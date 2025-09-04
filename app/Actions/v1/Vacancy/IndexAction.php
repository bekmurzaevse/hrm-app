<?php

namespace App\Actions\v1\Vacancy;

use App\Dto\v1\Vacancy\IndexDto;
use App\Http\Resources\v1\Vacancy\VacancyCollection;
use App\Models\Vacancy;
use App\Traits\ResponseTrait;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Cache;

class IndexAction
{
    use ResponseTrait;

    /**
     * Summary of __invoke
     * @return JsonResponse
     */
    public function __invoke(IndexDto $dto): JsonResponse
    {
        $key = 'vacancies:' . app()->getLocale() . ':' . md5(request()->fullUrl());

        $vacancy = Cache::remember($key, now()->addDay(), function () use ($dto) {
            $query = Vacancy::with([
                'client:id,name',
                'createdBy:id,first_name,last_name,patronymic',
                'district:id,title,region_id',
                'district.region:id,title',
            ]);

            if ($dto->search) {
                $query->where(function ($q) use ($dto) {
                    $q->where('title', 'like', '%' . $dto->search . '%');

                    $q->orWhereHas('client', function ($q2) use ($dto) {
                        $q2->where('name', 'like', '%' . $dto->search . '%');
                    });
                });
            }

            if ($dto->positionCount) {
                $query->where('position_count', $dto->positionCount);
            }

            if ($dto->salaryFrom) {
                $query->where('salary_from', '>=', $dto->salaryFrom);
            }

            if ($dto->salaryTo) {
                $query->where('salary_to', '<=', $dto->salaryTo);
            }

            if ($dto->regionId) {
                $query->whereHas('district', function ($q) use ($dto) {
                    $q->where('region_id', $dto->regionId);
                });
            }

            if ($dto->districtId) {
                $query->where('district_id', $dto->districtId);
            }

            if ($dto->userId) {
                $query->where('created_by', $dto->userId);
            }

            if ($dto->from) {
                $query->whereBetween('created_at', [$dto->from, $dto->to]);
            }

            if ($dto->status) {
                $query->where('status', $dto->status);
            }

            return $query->paginate($dto->perPage ?? 10);
        });

        return static::toResponse(
            message: 'Successfully Received',
            data: new VacancyCollection($vacancy)
        );
    }
}

<?php

namespace App\Actions\v1\Vacancy;

use App\Dto\v1\Vacancy\IndexDto;
use App\Http\Resources\v1\Vacancy\VacancyCollection;
use App\Models\Vacancy;
use App\Traits\ResponseTrait;
use Carbon\Carbon;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Cache;

class IndexAction
{
    use ResponseTrait;

    /**
     * Summary of __invoke
     * @param \App\Dto\v1\Vacancy\IndexDto $dto
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

            // Search
            if ($dto->search) {
                $query->where(function ($q) use ($dto) {
                    $q->where('title', 'like', '%' . $dto->search . '%');

                    $q->orWhereHas('client', function ($q2) use ($dto) {
                        $q2->where('name', 'like', '%' . $dto->search . '%');
                    });
                });
            }

            if ($dto->salaryFrom !== null) {
                $query->where('salary_to', '>=', $dto->salaryFrom);
            }

            if ($dto->salaryTo !== null) {
                $query->where('salary_from', '<=', $dto->salaryTo);
            }

            if ($dto->regionId !== null) {
                $query->whereHas('district', function ($q) use ($dto) {
                    $q->where('region_id', $dto->regionId);
                });
            }

            if ($dto->districtId !== null) {
                $query->where('district_id', $dto->districtId);
            }

            if ($dto->userId !== null) {
                $query->where('created_by', $dto->userId);
            }

            if ($dto->from !== null && $dto->to !== null) {
                $query->whereBetween('created_at', [
                    Carbon::parse($dto->from)->startOfDay(),
                    Carbon::parse($dto->to)->endOfDay(),
                ]);
            }

            if ($dto->status !== null) {
                $query->where('status', $dto->status);
            }

            // Sort
            $query->orderBy('created_at', 'desc');

            return $query->paginate(perPage: $dto->perPage, page: $dto->page);
        });

        return static::toResponse(
            message: 'Successfully Received',
            data: new VacancyCollection($vacancy)
        );
    }
}

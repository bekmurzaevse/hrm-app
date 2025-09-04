<?php

namespace App\Actions\v1\Candidate;

use App\Dto\v1\Candidate\IndexDto;
use App\Http\Resources\v1\Candidate\CandidateCollection;
use App\Models\Candidate;
use App\Traits\ResponseTrait;
use Carbon\Carbon;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Cache;

class IndexAction
{
    use ResponseTrait;

    /**
     * Summary of __invoke
     * @param \App\Dto\v1\Candidate\IndexDto $dto
     * @return JsonResponse
     */
    public function __invoke(IndexDto $dto): JsonResponse
    {

        $key = 'candidates:' . app()->getLocale() . ':' . md5(request()->fullUrl());
        $candidates = Cache::remember($key, now()->addDay(), function () use ($dto) {
            $query = Candidate::with(['district']);

            if ($dto->regionId) {
                $query->whereHas('district', function ($q) use ($dto) {
                    $q->where('region_id', $dto->regionId);
                });
            }

            if ($dto->districtId) {
                $query->where('district_id', $dto->districtId);
            }

            if ($dto->search) {
                $query->where('first_name', 'LIKE', "%{$dto->search}%")
                    ->orWhere('last_name', 'LIKE', "%{$dto->search}%")
                    ->orWhere('patronymic', 'LIKE', "%{$dto->search}%")
                    ->orWhere('address', 'LIKE', "%{$dto->search}%")
                    ->orWhere('workplace', 'LIKE', "%{$dto->search}%")
                    ->orWhere('position', 'LIKE', "%{$dto->search}%")
                    ->orWhere('citizenship', 'LIKE', "%{$dto->search}%")
                    ->orWhere('country_residence', 'LIKE', "%{$dto->search}%")
                    ->orWhere('source', 'LIKE', "%{$dto->search}%")
                    ->orWhereHas('contacts', function ($q) use ($dto) {
                        $q->where('value', 'LIKE', "%{$dto->search}%");
                    });
            }

            if ($dto->gender) {
                $query->where('gender', $dto->gender);
            }

            if ($dto->fromAge && $dto->toAge) {
                $from = (int) $dto->fromAge;
                $to   = (int) $dto->toAge;

                $fromDate = Carbon::now()->subYears($from)->endOfDay();
                $toDate   = Carbon::now()->subYears($to + 1)->addDay()->startOfDay();

                $query->whereBetween('birth_date', [$toDate, $fromDate]);
            } elseif ($dto->fromAge) {
                $from = (int) $dto->fromAge;
                $fromDate = Carbon::now()->subYears($from)->endOfDay();

                $query->where('birth_date', '<=', $fromDate);
            } elseif ($dto->toAge) {
                $to   = (int) $dto->toAge;

                $toDate   = Carbon::now()->subYears($to + 1)->addDay()->startOfDay();
                $query->where('birth_date', '>=', $toDate);
            }

            if ($dto->salaryFrom && $dto->salaryTo) {
                $query->whereBetween('desired_salary', [
                    $dto->salaryFrom,
                    $dto->salaryTo
                ]);
            } elseif ($dto->salaryFrom) {
                $query->where('desired_salary', '>=', $dto->salaryFrom);
            } elseif ($dto->salaryTo) {
                $query->where('desired_salary', '<=', $dto->salaryTo);
            }

            if ($dto->experienceFrom && $dto->experienceTo) {
                $query->whereBetween('experience', [
                    $dto->experienceFrom,
                    $dto->experienceTo
                ]);
            } elseif ($dto->experienceFrom) {
                $query->where('experience', '>=', $dto->experienceFrom);
            } elseif ($dto->experienceTo) {
                $query->where('experience', '<=', $dto->experienceTo);
            }

            if ($dto->status) {
                $query->where('status', $dto->status);
            }

            if ($dto->familyStatus) {
                $query->where('family_status', $dto->familyStatus);
            }

            return $query->paginate(10);
        });

        return static::toResponse(
            message: 'Successfully received',
            data: new CandidateCollection($candidates)
        );
    }
}

<?php

namespace App\Actions\v1\Candidate;

use App\Http\Requests\v1\Candidate\IndexRequest;
use App\Http\Resources\v1\Candidate\CandidateCollection;
use App\Models\Candidate;
use App\Traits\ResponseTrait;
use Carbon\Carbon;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;

class IndexAction
{
    use ResponseTrait;

    /**
     * Summary of __invoke
     * @return JsonResponse
     */
    public function __invoke(IndexRequest $request): JsonResponse
    {
        $key = 'candidates:' . app()->getLocale() . ':' . md5(request()->fullUrl());
        $candidates = Cache::remember($key, now()->addDay(), function () use ($request) {
            $query = Candidate::with(['district']);

            if ($request->region_id) {
                $query->whereHas('district', function ($q) use ($request) {
                    $q->where('region_id', $request->region_id);
                });
            }

            if ($request->district_id) {
                $query->where('district_id', $request->district_id);
            }

            if ($request->search) {
                $query->where('first_name', 'LIKE', "%{$request->search}%")
                    ->orWhere('last_name', 'LIKE', "%{$request->search}%")
                    ->orWhere('patronymic', 'LIKE', "%{$request->search}%")
                    ->orWhere('address', 'LIKE', "%{$request->search}%")
                    ->orWhere('workplace', 'LIKE', "%{$request->search}%")
                    ->orWhere('position', 'LIKE', "%{$request->search}%")
                    ->orWhere('citizenship', 'LIKE', "%{$request->search}%")
                    ->orWhere('country_residence', 'LIKE', "%{$request->search}%")
                    ->orWhere('source', 'LIKE', "%{$request->search}%");

            }

            // if ($request->search) {
            //     $query->whereHas('contacts', function ($q) use ($request) {
            //         $q->where('contacts.value', 'LIKE', "%{$request->search}%");
            //     });
            // }

            if ($request->gender) {
                $query->where('gender', $request->gender);
            }

            if ($request->from_age && $request->to_age) {
                $from = (int) $request->from_age;
                $to   = (int) $request->to_age;

                $fromDate = Carbon::now()->subYears($from)->endOfDay();
                $toDate   = Carbon::now()->subYears($to + 1)->addDay()->startOfDay();

                $query->whereBetween('birth_date', [$toDate, $fromDate]);

            } elseif ($request->from_age) {
                $from = (int) $request->from_age;
                $fromDate = Carbon::now()->subYears($from)->endOfDay();

                $query->where('birth_date', '<=', $fromDate);

            } elseif ($request->to_age) {
                $to   = (int) $request->to_age;

                $toDate   = Carbon::now()->subYears($to + 1)->addDay()->startOfDay();
                $query->where('birth_date', '>=', $toDate);
            }

            if ($request->salary_from && $request->salary_to) {
                $query->whereBetween('desired_salary', [
                    $request->salary_from,
                    $request->salary_to
                ]);
            } elseif ($request->salary_from) {
                $query->where('desired_salary', '>=', $request->salary_from);
            } elseif ($request->salary_to) {
                $query->where('desired_salary', '<=', $request->salary_to);
            }

            if ($request->experience_from && $request->experience_to) {
                $query->whereBetween('experience', [
                    $request->experience_from,
                    $request->experience_to
                ]);
            } elseif ($request->experience_from) {
                $query->where('experience', '>=', $request->experience_from);
            } elseif ($request->experience_to) {
                $query->where('experience', '<=', $request->experience_to);
            }

            if ($request->status) {
                $query->where('status', $request->status);
            }

            if ($request->family_status) {
                $query->where('family_status', $request->family_status);
            }

            return $query->paginate(10);
        });

        return static::toResponse(
            message: 'Successfully received',
            data: new CandidateCollection($candidates)
        );
    }
}

<?php

namespace App\Actions\v1\Candidate;

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
    public function __invoke(Request $request): JsonResponse
    {
        $key = 'candidates:' . app()->getLocale() . ':' . md5(request()->fullUrl());
        $candidates = Cache::remember($key, now()->addDay(), function () use ($request) {
            $query = Candidate::query();

            if ($request->gender) {
                $query->where('gender', $request->gender);
            }

            // if ($request->from) {
            //     $query->where('birth_date', '<', Carbon::now()->subYears($request->from));
            // }

            // if ($request->to) {
            //     $query->where('birth_date', '>=', Carbon::now()->subYears($request->to));
            // }

            if ($request->from_age && $request->to_age) {
                $from = (int) $request->from_age; // kichik yosh (24)
                $to   = (int) $request->to_age;   // katta yosh (29)

                $fromDate = Carbon::now()->subYears($from)->toDateString(); // 2001-08-18
                $toDate   = Carbon::now()->subYears($to)->toDateString();   // 1996-08-18

                $query->whereBetween('birth_date', [$toDate, $fromDate]);

            } elseif ($request->from_age) {
                $query->where('birth_date', '<=', Carbon::now()->subYears($request->from_age)->toDateString());

            } elseif ($request->to_age) {
                $query->where('birth_date', '>=', Carbon::now()->subYears($request->to_age)->toDateString());
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

            if ($request->status) {
                $query->where('status', $request->status);
            }

            if ($request->family_status) {
                $query->where('family_status', $request->family_status);
            }

            return $query->paginate(10);
            // return Candidate::paginate(10);
        });

        return static::toResponse(
            message: 'Successfully received',
            data: new CandidateCollection($candidates)
        );
    }
}

<?php

namespace App\Actions\v1\Vacancy;

use App\Exceptions\ApiResponseException;
use App\Models\Vacancy;
use App\Traits\ResponseTrait;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Storage;

class DeleteAction
{
    use ResponseTrait;

    /**
     * Summary of __invoke
     * @param int $id
     * @throws \App\Exceptions\ApiResponseException
     * @return JsonResponse
     */
    public function __invoke(int $id): JsonResponse
    {
        try {
            $vacancy = Vacancy::findOrFail($id);

            $vacancy->vacancyDetail()->delete();
            $vacancy->vacancySalary()->delete();
            $vacancy->skills()->delete();


            if (Storage::disk('public')->exists('vacancies/' . $vacancy->id)) {
                Storage::disk('public')->deleteDirectory("vacancies/" . $vacancy->id);
            }
            $vacancy->files()->delete();
            $vacancy->delete();

            return static::toResponse(
                message: "id-{$id} Vacancy Deleted",
            );
        } catch (ModelNotFoundException $ex) {
            throw new ApiResponseException('Vacancy Not Found', 404);
        }
    }
}


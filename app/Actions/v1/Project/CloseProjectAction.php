<?php

namespace App\Actions\v1\Project;

use App\Dto\v1\Project\CloseProjectDto;
use App\Enums\ProjectStatusEnum;
use App\Enums\Vacancy\VacancyStatusEnum;
use App\Exceptions\ApiResponseException;
use App\Models\Project;
use App\Traits\ResponseTrait;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Http\JsonResponse;

class CloseProjectAction
{
    use ResponseTrait;

    /**
     * Summary of __invoke
     * @param \App\Dto\v1\Project\UpdateDto $dto
     * @return JsonResponse
     */
    public function __invoke(int $id, CloseProjectDto $dto): JsonResponse
    {
        try {
            $project = Project::findOrFail($id);

            if ($project->status == ProjectStatusEnum::IN_PROGRESS) {
                $data = [
                    'comment' => $dto->comment,
                    'closed_by' => auth()->user()->id,
                    'closed_at' => now(),
                ];

                $project->closeProject()->create($data);

                // close vacancy
                $vacancy = $project->vacancy()->first();
                $vacancy->status = VacancyStatusEnum::CLOSED;
                $vacancy->save();

                // close project
                $project->status = ProjectStatusEnum::CANCELLED;
                $project->save();

                // Log user activity
                $title = 'Закрытие проекта с вакансией';
                $text = "Вакансия «{$vacancy->title}» проекта «{$project->title}» была закрыта";
                logActivity($title, $text);

                return static::toResponse(
                    message: "{$id}-Project closed"
                );
            } else {
                return static::toResponse(
                    message: 'Project already closed'
                );
            }
        } catch (ModelNotFoundException $e) {
            throw new ApiResponseException('Project Not Found', 404);
        }
    }
}

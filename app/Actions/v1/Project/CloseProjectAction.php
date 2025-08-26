<?php

namespace App\Actions\v1\Project;

use App\Dto\v1\Project\CloseProjectDto;
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

            if ($project->status == 'В работе') {
                $data = [
                    'comment' => $dto->comment,
                    'closed_by' => 1, // TODO: Replace with authenticated user ID
                    'closed_at' => now(),
                ];

                $project->closeProject()->create($data);

                $project->status = 'cancelled';
                $project->save();

                // Log user activity
                $title = 'Закрытие проекта';
                $text = "Проект «{$project->title}» был закрыт";
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

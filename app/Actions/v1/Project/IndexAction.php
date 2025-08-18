<?php

namespace App\Actions\v1\Project;

use App\Http\Resources\v1\Project\ProjectCollection;
use App\Models\Project;
use App\Traits\ResponseTrait;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Cache;

class IndexAction
{
    use ResponseTrait;

    /**
     * Summary of __invoke
     * @return \Illuminate\Http\JsonResponse
     */
    public function __invoke(): JsonResponse
    {
        $key = 'projects:' . app()->getLocale() . ':' . md5(request()->fullUrl());

        $projects = Cache::remember($key, now()->addDay(), function () {
            return Project::with([
                'client:id,name',
                'inProgressStage',
                'vacancy:id,title',
                'performers:id,first_name,last_name,patronymic',
                'stages:id,project_id,status',
            ])->paginate(10);
        });

        return static::toResponse(
            message: 'Successfully received',
            data: new ProjectCollection($projects)
        );
    }
}
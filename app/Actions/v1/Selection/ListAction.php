<?php

namespace App\Actions\v1\Selection;

use App\Models\Selection;
use App\Traits\ResponseTrait;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Cache;

class ListAction
{
    use ResponseTrait;

    /**
     * Summary of __invoke
     * @param \App\Dto\v1\Selection\IndexDto $dto
     * @return JsonResponse
     */
    public function __invoke(): JsonResponse
    {
        $key = 'selections:list:' . auth()->id() . ':' . app()->getLocale() . ':' . md5(request()->fullUrl());
        $selections = Cache::remember($key, now()->addDay(), function () {
            return Selection::where('created_by', auth()->id())
                ->get()
                ->map(function ($selection) {
                    return [
                        'id' => $selection->id,
                        'title' => $selection->title,
                    ];
                });
        });

        return static::toResponse(
            message: 'Successfully received',
            data: $selections->toArray()
        );
    }
}
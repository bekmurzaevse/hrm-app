<?php

namespace App\Actions\v1\Selection;

use App\Dto\v1\Selection\IndexDto;
use App\Http\Resources\v1\Selection\SelectionCollection;
use App\Models\Selection;
use App\Traits\ResponseTrait;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Cache;

class IndexAction
{
    use ResponseTrait;

    /**
     * Summary of __invoke
     * @param \App\Dto\v1\Selection\IndexDto $dto
     * @return JsonResponse
     */
    public function __invoke(IndexDto $dto): JsonResponse
    {
        $key = 'selections:' . app()->getLocale() . ':' . md5(request()->fullUrl());
        $selections = Cache::remember($key, now()->addDay(), function () use ($dto) {
            $query = Selection::with(['createdBy:id,first_name,last_name,patronymic'])
                ->where('created_by', auth()->id());

            if ($dto->search) {
                $query->where('title', 'like', '%' . $dto->search . '%');
            }

            $query->orderBy('created_at', 'desc');

            return $query->paginate(perPage: $dto->perPage, page: $dto->page);
        });

        return static::toResponse(
            message: 'Successfully received',
            data: new SelectionCollection($selections)
        );
    }
}
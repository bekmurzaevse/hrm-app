<?php

namespace App\Dto\v1\Project\File;

use App\Http\Requests\v1\Project\File\UploadRequest;
use Illuminate\Http\UploadedFile;

readonly class UploadDto
{
    public function __construct(
        public UploadedFile $file,
        public string $type,
    ) {
    }

    /**
     * Summary of from
     * @param \App\Http\Requests\v1\Project\File\UploadRequest $request
     * @return UploadDto
     */
    public static function from(UploadRequest $request): self
    {
        return new self(
            file: $request->file('file'),
            type: $request->type,
        );
    }
}

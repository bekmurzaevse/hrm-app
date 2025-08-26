<?php

namespace App\Dto\v1\Client\File;

use App\Http\Requests\v1\Client\File\UploadRequest;

readonly class UploadDto
{
    public function __construct(
        public array $files,
    ) {
    }

    /**
     * Summary of from
     * @param \App\Http\Requests\v1\Client\File\UploadRequest $request
     * @return UploadDto
     */
    public static function from(UploadRequest $request): self
    {
        return new self(
            files: $request->file('files'),
        );
    }
}

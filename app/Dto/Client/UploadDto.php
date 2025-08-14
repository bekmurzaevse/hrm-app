<?php

namespace App\Dto\Client;

use App\Http\Requests\v1\Client\UploadRequest;

readonly class UploadDto
{
    public function __construct(
        public array $files,
    ) {
    }

    /**
     * Summary of from
     * @param \App\Http\Requests\v1\Client\UploadRequest $request
     * @return UploadDto
     */
    public static function from(UploadRequest $request): self
    {
        return new self(
            files: $request->file('files'),
        );
    }
}

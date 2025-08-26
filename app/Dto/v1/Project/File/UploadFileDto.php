<?php

namespace App\Dto\v1\Project\File;

use App\Http\Requests\v1\Project\File\UploadFileRequest;
use Illuminate\Http\UploadedFile;

readonly class UploadFileDto
{
    public function __construct(
        public UploadedFile $file,
        public string $type,
    ) {
    }

    /**
     * Summary of from
     * @param \App\Http\Requests\v1\Project\File\UploadFileRequest $request
     * @return UploadFileDto
     */
    public static function from(UploadFileRequest $request): self
    {
        return new self(
            file: $request->file('file'),
            type: $request->type,
        );
    }
}

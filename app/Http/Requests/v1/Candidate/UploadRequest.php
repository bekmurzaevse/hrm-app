<?php

namespace App\Http\Requests\v1\Candidate;

use Illuminate\Foundation\Http\FormRequest;

class UploadRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    protected array $allowedMimes = [
        'application/pdf',
        'application/msword',
        'application/vnd.openxmlformats-officedocument.wordprocessingml.document',
        'application/vnd.ms-powerpoint',
        'application/vnd.openxmlformats-officedocument.presentationml.presentation',
        'application/vnd.ms-excel',
        'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet',
    ];

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'files' => 'required|array|max:5',
            'files.*' => 'required|file|max:4096|mimetypes:' . implode(',', $this->allowedMimes),
        ];
    }

    /**
     * Summary of messages
     * @return array{files.array: string, files.file: string, files.max: string, files.mimetypes: string, files.required: string}
     */
    public function messages(): array
    {
        return [
            'files.required' => "files ma'jbu'riy.",
            'files.array' => "files array boliw kerek.",
            'files.file' => "Tip file boliw kerek.",
            'files.max' => "file din' razmeri 4 Mb boliw kerek.",
            'files.mimetypes' => "file din' tipleri (" . implode(',', $this->allowedMimes) . ") boliw kerek.",
        ];
    }
}

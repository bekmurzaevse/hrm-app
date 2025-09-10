<?php

namespace App\Http\Requests\v1\Vacancy\File;

use App\Http\Requests\v1\Traits\FailedValidation;
use Illuminate\Foundation\Http\FormRequest;

class UploadFileRequest extends FormRequest
{
    use FailedValidation;

    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'file' => [
                'required',
                'file',
                'mimetypes:application/pdf,application/msword,application/vnd.openxmlformats-officedocument.wordprocessingml.document,application/vnd.ms-powerpoint,application/vnd.openxmlformats-officedocument.presentationml.presentation,application/vnd.ms-excel,application/vnd.openxmlformats-officedocument.spreadsheetml.sheet',
                'max:4096'
            ],
            'type' => 'required|string|max:255',
        ];
    }

    /**
     * Get the error messages for the defined validation rules.
     *
     * @return array
     */
    public function messages()
    {
        return [
            'file.mimetypes' => [
                'application/pdf' => 'The file must be a valid PDF.',
                'application/msword' => 'The file must be a valid Word document.',
                'application/vnd.openxmlformats-officedocument.wordprocessingml.document' => 'The file must be a valid Word document (.docx).',
                'application/vnd.ms-powerpoint' => 'The file must be a valid PowerPoint presentation.',
                'application/vnd.openxmlformats-officedocument.presentationml.presentation' => 'The file must be a valid PowerPoint presentation (.pptx).',
                'application/vnd.ms-excel' => 'The file must be a valid Excel spreadsheet.',
                'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet' => 'The file must be a valid Excel spreadsheet (.xlsx).',
            ],
        ];
    }
}

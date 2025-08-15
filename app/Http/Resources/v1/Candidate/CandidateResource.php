<?php

namespace App\Http\Resources\v1\Candidate;

use App\Http\Resources\v1\Contact\ContactResource;
use App\Http\Resources\v1\Education\EducationResource;
use App\Http\Resources\v1\File\FileResource;
use App\Http\Resources\v1\Interaction\InteractionResource;
use App\Http\Resources\v1\Language\LanguageResource;
use App\Http\Resources\v1\Photo\PhotoResource;
use App\Http\Resources\v1\WorkExperience\WorkExperienceResource;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class CandidateResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        // dd($this->photo);
        return [
            'main_info' => [
                'full_name' => $this->first_name . ' ' . $this->last_name . ' ' . $this->patronymic,
                'birth_date' => $this->birth_date->format('Y-m-d'),
                'age' => now()->year - $this->birth_date->year,
                'citizen' => $this->citizen,
                'gender' => $this->gender,
                'status' => $this->status,
            ],
            'contacts' => ContactResource::collection($this->contacts),
            // 'skills' => $this->skills,
            // 'languages' => LanguageResource::collection($this->languages),
            'info' => [
                'source' => $this->source,
                'created_by' => $this->user,
                'created_at' => $this->created_at->format('Y-m-d'),
                'updated_at' => $this->updated_at->format('Y-m-d'),
            ],
            'history' => InteractionResource::collection($this->interactions),
            'work_experience' => WorkExperienceResource::collection($this->workExperience),
            // 'salary' => $this->salary,
            'desired_salary' => $this->desired_salary,
            'esucations' => EducationResource::collection($this->educations),
            // 'files' => FileResource::collection($this->files),
            'photo' => new PhotoResource($this->photo),
            'description' => $this->description,
        ];
    }
}

<?php

namespace App\Http\Resources\v1\Candidate;

use App\Http\Resources\v1\Contact\ContactResource;
use App\Http\Resources\v1\Education\EducationResource;
use App\Http\Resources\v1\File\FileResource;
use App\Http\Resources\v1\Interaction\InteractionResource;
use App\Http\Resources\v1\Language\LanguageResource;
use App\Http\Resources\v1\Photo\PhotoResource;
use App\Http\Resources\v1\Skill\SkillResource;
use App\Http\Resources\v1\WorkExperience\WorkExperienceResource;
use Carbon\Carbon;
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
        return [
            'main_info' => [
                'full_name' => $this->first_name . ' ' . $this->last_name . ' ' . $this->patronymic,
                'birth_date' => $this->birth_date->format('Y-m-d'),
                'age' => Carbon::parse($this->birth_date)->age,
                'citizenship' => $this->citizenship,
                'country_residence' => $this->country_residence,
                'gender' => $this->gender,
                'status' => $this->status,
                'family_status' => $this->family_status,
                'family_info' => $this->family_info,
                'address' => $this->address,
                // 'district' => $this->district->title,
                'district' => [
                    'id' => $this->district->id,
                    'title' => $this->district->title,
                ],
                'region' => [
                    'id' => $this->district->region->id,
                    'title' => $this->district->region->title,
                ],
                'experience' => $this->total_work_experience,
            ],
            'about' => [
                'short_summary' => $this->short_summary,
                'achievments' => $this->achievments,
                'comment' => $this->comment,
            ],
            'contacts' => ContactResource::collection($this->contacts),
            'skills' => SkillResource::collection($this->skills),
            'languages' => LanguageResource::collection($this->languages),
            'info' => [
                'source' => $this->source,
                'created_by' => $this->user->first_name . ' ' . $this->user->last_name,
                'created_at' => $this->created_at->format('Y-m-d'),
                'updated_at' => $this->updated_at->format('Y-m-d'),
            ],
            'history' => InteractionResource::collection($this->interactions),
            'experience' => $this->experience,
            'work_experience' => WorkExperienceResource::collection($this->workExperience),
            'desired' => [
                'desired_salary' => $this->desired_salary,
                'workplace' => $this->workplace,
                'position' => $this->position,
            ],
            'educations' => EducationResource::collection($this->educations),
            'files' => FileResource::collection($this->files()->where('type', null)->get()),
            'photo' => new PhotoResource($this->photo),
            'description' => $this->description,
        ];
    }
}

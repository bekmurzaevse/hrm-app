<?php

namespace App\Http\Requests\v1\Candidate;

use App\Enums\Candidate\CandidateStatusEnum;
use App\Enums\Candidate\FamilyStatusEnum;
use App\Enums\GenderEnum;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class UpdateRequest extends FormRequest
{
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
            'first_name' => 'required|string|max:50',
            'last_name' => 'required|string|max:50',
            'patronymic' => 'required|string|max:50',
            'birth_date' => 'required|string',
            'gender' => ['required', Rule::enum(GenderEnum::class)],
            'citizenship' => 'required|string',
            'country_residence' => 'required|string',
            'family_status' => ['required', Rule::enum(FamilyStatusEnum::class)],
            'family_info' => 'nullable|string',
            'status' => ['required', Rule::enum(CandidateStatusEnum::class)],
            'workplace' => 'nullable|string',
            'position' => 'required|string',
            'district_id' => 'required|integer|exists:districts,id',
            'address' => 'required|string',
            'desired_salary' => 'required|numeric',
            'source' => 'nullable|string',
            'experience' => 'nullable|numeric',
            'description' => 'nullable|string',
            'photo' => 'nullable|image|mimes:png,jpg,png,jpeg',
        ];
    }

    /**
     * Summary of messages
     * @return array{address.required: string, address.string: string, citizenship.required: string, citizenship.string: string, country_residence.required: string, country_residence.string: string, desired_salary.numeric: string, desired_salary.required: string, distrcit_id.exist: string, distrcit_id.integer: string, distrcit_id.required: string, family_info.required: string, family_info.string: string, family_status.in: string, family_status.required: string, first_name.max: string, first_name.required: string, first_name.string: string, gender.in: string, gender.required: string, last_name.max: string, last_name.required: string, last_name.string: string, patronymic.max: string, patronymic.required: string, patronymic.string: string, photo.image: string, photo.mimes: string, position.required: string, position.string: string, status.in: string, status.required: string, user_id.exist: string, user_id.integer: string, user_id.required: string}
     */
    public function messages(): array
    {
        return [
            'first_name.required' => "First name ma'jbu'riy.",
            'first_name.string' => "First name string boliw kerek.",
            'first_name.max' => "First name 50 belgiden ko'p bolmawi kerek.",

            'last_name.required' => "Last name ma'jbu'riy.",
            'last_name.string' => "Last name string boliw kerek.",
            'last_name.max' => "Last name 50 belgiden ko'p bolmawi kerek.",

            'patronymic.required' => "Patronymic ma'jbu'riy.",
            'patronymic.string' => "Patronymic string boliw kerek.",
            'patronymic.max' => "Patronymic 50 belgiden ko'p bolmawi kerek.",

            'gender.required' => "Gender ma'jbu'riy.",
            'gender.in' => "Gender ma'nisleri (male yoki female) boliwi kerek.",

            'family_status.required' => "family_status ma'jbu'riy.",
            'family_status.in' => "family_status ma'nisleri (married, unmarried, divorced) boliwi kerek.",

            'family_info.required' => "family_info ma'jbu'riy.",
            'family_info.string' => "family_info string boliw kerek.",

            'citizenship.required' => "citizenship ma'jbu'riy.",
            'citizenship.string' => "citizenship string boliw kerek.",

            'country_residence.required' => "country_residence ma'jbu'riy.",
            'country_residence.string' => "country_residence string boliw kerek.",

            'distrcit_id.required' => "distrcit_id ma'jbu'riy.",
            'distrcit_id.integer' => "distrcit_id pu'tin san boliw kerek.",
            'distrcit_id.exist' => "distrcit_id bazada tabilmadi.",

            'status.required' => "status ma'jbu'riy.",
            'status.in' => "status ma'nisleri (active, in_search, employed) boliwi kerek.",

            'position.required' => "position ma'jbu'riy.",
            'position.string' => "position string boliw kerek.",

            'address.required' => "address ma'jbu'riy.",
            'address.string' => "address string boliw kerek.",

            'desired_salary.required' => "desired_salary ma'jbu'riy.",
            'desired_salary.numeric' => "desired_salary san boliw kerek.",

            'photo.image' => "photo image tipinde boliwiw kerek.",
            'photo.mimes' => "photo (png,jpg,png,jpeg) tiplerinin' biri boliwi kerek.",
        ];
    }
}

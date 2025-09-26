<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class createJobRequest extends FormRequest
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
            'title' => 'required|min:5|max:200',
            'category_id' => 'required',
            'job_type_id' => 'required',
            'vacancy' => 'required|integer',
            'salary' => 'required|integer',
            'location' => 'required|max:50',
            'description' => 'required',
            'benefits' => 'max:100',
            'responsibility' => 'max:100',
            'qualifications' => 'max:100',
            'experience' => 'required',
            'keywords' => 'max:200',
            'company_name' => 'required|min:3|max:50',
            'company_location' => 'required|max:50',
            'company_website' => 'required',
            'isFeatured' => 'boolean',
            'status' => 'required|in:0,1',
        ];
    }
}

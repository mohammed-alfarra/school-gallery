<?php

namespace App\Http\Requests\School;

use Illuminate\Foundation\Http\FormRequest;

class CreateSchoolRequest extends FormRequest
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
     * @return array<string, string>
     */
    public function rules(): array
    {
        return [
            'name' => ['required', 'string', 'min:2'],
        ];
    }
}

<?php

namespace App\Http\Requests\Image;

use App\Rules\MaxImages;
use Illuminate\Foundation\Http\FormRequest;

class UploadImagesRequest extends FormRequest
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
            'images.*' => ['required', 'image', 'mimes:jpeg,png', 'max:10000'],
            'images' => [new MaxImages],
        ];
    }
}

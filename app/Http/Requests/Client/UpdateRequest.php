<?php

namespace App\Http\Requests\Client;

use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;

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
     * @return array<string, ValidationRule|array|string>
     */
    public function rules(): array
    {
        return [
            'image' => 'image|max:1024',
            'brand_en' => 'required|min:2|max:30',
            'brand_ru' => 'required|min:2|max:30',
            'name_en' => 'required|min:2|max:30',
            'name_ru' => 'required|min:2|max:30',
            'description_en' => 'required|min:2|max:500',
            'description_ru' => 'required|min:2|max:500',
            'redirect_url' => 'required|min:2|max:500',
            'link' => 'required|url|min:2|max:500',
        ];
    }
}

<?php

namespace App\Http\Requests\Song;

use Illuminate\Foundation\Http\FormRequest;

class EditSongRequest extends FormRequest
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
            'genres' => [
                'nullable'
            ],
            'genres.*.genre_id' => [
                'required',
                'max:255',
                'required_with:genres.*',
            ],
            'genres_to_delete' => [
                'array',
                'nullable'
            ],
            'name' => [
                'max:255',
                'nullable'
            ],
            'description' => [
                'max:255',
                'nullable'
            ],
            'path' => [
                'nullable'
            ],
            'image' => [
                'nullable'
            ],
        ];
    }
}

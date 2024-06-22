<?php

namespace App\Http\Requests\Song;

use Illuminate\Foundation\Http\FormRequest;

class AddRequest extends FormRequest
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
            'user_id' => [
                'required',
                'numeric',
                'exists:users,id'
            ],
            'album_id' => [
                'numeric',
                'exists:albums,id'
            ],
            'genres' => [
                'required'
            ],
            'genres.*.genre_id' => [
                'required',
                'max:255',
                'required_with:genres.*',
            ],
            'name' => [
                'required',
                'max:255',
            ],
            'description' => [
                'required',
                'max:255',
            ],
            'path' => [
                
            ],
            'image' => [
                
            ],
        ];
    }
}

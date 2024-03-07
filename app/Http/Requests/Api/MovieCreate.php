<?php

namespace App\Http\Requests\Api;

use Illuminate\Foundation\Http\FormRequest;

class MovieCreate extends FormRequest
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
            'title' => 'required|string|max:255',
            'overview' => 'required|string',
            'release_date' => 'required|date',
            'popularity' => 'required|numeric',
            'vote_average' => 'required|numeric',
            'vote_count' => 'required|integer',
            'image'=> 'required|string',
        ];
    }
}

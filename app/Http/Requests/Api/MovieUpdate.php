<?php

namespace App\Http\Requests\Api;

use App\Http\Traits\ValidationTrait;
use Illuminate\Foundation\Http\FormRequest;

class MovieUpdate extends FormRequest
{
    use ValidationTrait; 
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
    public function rules() : array
    {
        return [
            'id' => 'required|exists:movies,id',
            'title' => 'sometimes|string|max:255',
            'overview' => 'sometimes|string',
            'release_date' => 'sometimes|date',
            'popularity' => 'sometimes|numeric',
            'vote_average' => 'sometimes|numeric',
            'vote_count' => 'sometimes|integer',
            'image'=> 'sometimes|string',
        ];
    }

    public function validationData()
    {
        return array_merge($this->all(), [
            'id' => $this->route('id'),
        ]);
    }
}

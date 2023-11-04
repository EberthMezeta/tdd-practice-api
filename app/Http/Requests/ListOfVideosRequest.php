<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ListOfVideosRequest extends FormRequest
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
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array|string>
     */
    public function rules(): array
    {
        return [
            'limit' => 'integer|max:50|min:1',
            'page' => 'integer'
        ];
    }

    public function getLimit(): int
    {

        return $this->get('limit', 30);
    }

    public function getPage(): int
    {
        return $this->get('page', 1);
    }
}

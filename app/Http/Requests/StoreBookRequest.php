<?php

namespace App\Http\Requests;

use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Exceptions\HttpResponseException;

class StoreBookRequest extends FormRequest
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
            'title' => 'required|string|min:3|max:255',
            'author' => 'required|string|min:3|max:255',
            'description' => 'required|string|min:10|max:255',
            'price' => 'required|numeric',
            'quantity' => 'required|integer',
            'year' => 'required|integer',
        ];
    }

    protected function failedValidation(Validator $validator)
    {
        if ($this->method() !== 'POST') {
            throw new HttpResponseException(response()->json([
                'success'   => false,
                'message'   => 'Method not allowed',
            ], 405));
        }

        if (!$this->isJson()) {
            throw new HttpResponseException(response()->json([
                'success'   => false,
                'message'   => 'Content-type must be application/json',
            ], 406));
        }

        throw new HttpResponseException(response()->json([
            'success'   => false,
            'message'   => 'Validation errors',
            'errors'     => $validator->errors(),
        ], 422));
    }
}

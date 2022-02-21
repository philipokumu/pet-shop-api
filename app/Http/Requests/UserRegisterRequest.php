<?php

namespace App\Http\Requests;

use App\Exceptions\ValidationErrorException;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Exceptions\HttpResponseException;

class UserRegisterRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'first_name' => 'required',
            'last_name' => 'required',
            'email' => 'required',
            'password' => 'required|confirmed',
            'password_confirmation' => 'required',
            'avatar' => '',
            'address' => 'required',
            'phone_number' => 'required',
            'is_marketing' => 'nullable|integer',
        ];
    }

    protected function failedValidation(Validator $validator)
    {
        $errors = $validator->errors();

        $response = response()->json([
            'success' => 0,
            'data' => [],
            'error' => 'User registration validation error',
            'errors' => [
                'meta' => $errors
            ],
            'trace' => []
        ], 422);

        throw new HttpResponseException($response);
    }
}

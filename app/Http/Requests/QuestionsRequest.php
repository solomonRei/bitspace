<?php

namespace App\Http\Requests;

use App\Rules\PhoneNumber;
use Illuminate\Foundation\Http\FormRequest;

class QuestionsRequest extends FormRequest
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
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'email' => 'required|email|max:255',
            'phone' => ['nullable', new PhoneNumber],
            'name' => 'required|min:2|max:255',
        ];
    }

    public function messages()
    {
        return [
            'email.email' => 'The email format is error.',
            'body.required' => 'A message is required',
        ];
    }
}

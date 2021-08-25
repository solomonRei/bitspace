<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use App\Rules\PhoneNumber;
use Illuminate\Support\Facades\Auth;

class EditSettingsRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return Auth::check();
    }

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
            'ava' => 'nullable|image|mimes:jpeg,jpg,png,gif,webp|max:2048',
            'is_hided' => 'nullable',
            'is_searched' => 'nullable',
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

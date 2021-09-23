<?php

namespace App\Http\Requests;

use App\Http\Requests\Request;
use Illuminate\Foundation\Http\FormRequest;

class UsersRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        // only allow updates if the user is logged in
        return backpack_auth()->check();
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'is_admin' => 'boolean',
            'is_hided' => 'boolean',
            'is_searched' => 'boolean',
            'is_promoted' => 'boolean',
            'banned' => 'boolean',
            'name' => 'required|string|max:255',
            'login' => 'required|string|max:255',
            'avatar.file_path' => '',
            'new_password' => 'string|min:6|nullable',
            'userStringsByLang' => 'array|nullable',
            'userStringsByLang.*' => 'array|nullable',
            'userStringsByLang.*.name' => 'string|min:2|max:255|nullable',
            'userStringsByLang.*.surname' => 'string|min:2|max:255|nullable',
            'userStringsByLang.*.age' => 'string|nullable',
            'userStringsByLang.*.education' => 'string|max:255|nullable',
            'userStringsByLang.*.about' => 'string|nullable',
            'userStringsByLang.*.experience' => 'string|nullable',
            'userStringsByLang.*.id' => 'integer|nullable',
            'userStringsByLang.*.lang_id' => 'required|integer|nullable',
        ];
    }

    /**
     * Get the validation attributes that apply to the request.
     *
     * @return array
     */
    public function attributes()
    {
        return [
            //
        ];
    }

    /**
     * Get the validation messages that apply to the request.
     *
     * @return array
     */
    public function messages()
    {
        return [
            //
        ];
    }
}

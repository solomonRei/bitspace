<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Auth;

class EditContactsRequest extends FormRequest
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
            'name' => 'required|array|min:1',
            'name.*' => 'required|string|max:100',

            'surname' => 'required|array|min:1',
            'surname.*' => 'required|string|max:100',

            'education' => 'required|array|min:1',
            'education.*' => 'required|string|max:100',
        ];
    }
}

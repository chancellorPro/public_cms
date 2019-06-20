<?php

namespace App\Http\Requests\Attribute;

use Illuminate\Foundation\Http\FormRequest;

/**
 * Class CreateUpdateAttribute
 */
class CreateUpdateAttribute extends FormRequest
{

    /**
     * Determine if the user is authorized to make this request.
     *
     * @return boolean
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
        $rules = [
            'name'  => 'required|string|max:100',
            'alias' => 'required|string|max:100',
        ];

        return $rules;
    }
}

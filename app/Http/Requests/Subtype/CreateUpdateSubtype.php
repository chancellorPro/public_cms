<?php

namespace App\Http\Requests\Subtype;

use Illuminate\Foundation\Http\FormRequest;

/**
 * Class CreateUpdateSubtype
 */
class CreateUpdateSubtype extends FormRequest
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
            'name' => 'required|string|max:100',
        ];

        return $rules;
    }
}

<?php

namespace App\Http\Requests\PageInfo;

use Illuminate\Foundation\Http\FormRequest;

/**
 * Action type create request
 */
class PageInfoRequest extends FormRequest
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
        return [
            'description' => 'required|string',
        ];
    }
}

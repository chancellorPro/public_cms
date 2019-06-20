<?php

namespace App\Http\Requests\Nla;

use Illuminate\Foundation\Http\FormRequest;

/**
 * Class NlaAssetRequest
 */
class NlaAssetRequest extends FormRequest
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
            'nla.*.name'        => 'required|unique:nla_assets,name',
            'nla.*.sort'        => 'required|unique:nla_assets,sort',
            'nla.*.category_id' => 'required|exists:nla_categories,id',
        ];
    }
}

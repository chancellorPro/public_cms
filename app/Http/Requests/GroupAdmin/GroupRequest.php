<?php

namespace App\Http\Requests\GroupAdmin;

use Illuminate\Foundation\Http\FormRequest;

/**
 * Class GroupRequest
 */
class GroupRequest extends FormRequest
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
            'uid' => 'required|unique:group_admins,receiver_id',
        ];
    }
}

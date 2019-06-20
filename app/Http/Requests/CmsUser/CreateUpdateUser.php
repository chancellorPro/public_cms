<?php

namespace App\Http\Requests\CmsUser;

use App\Http\Requests\FormRequest;
use App\Traits\Requests\Authorize;

/**
 * Class CreateUpdateUser
 */
class CreateUpdateUser extends FormRequest
{

    use Authorize;

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        $id = $this->route('cms_user');

        $rules = [
            'name'  => 'required|string|max:255',
            'login' => 'required|string|max:50|unique:cms_users,login' . ($id ? ",$id" : ""),
            'email' => 'string|email|max:50|unique:cms_users,email' . ($id ? ",$id" : ""),
            'roles' => 'required|array|exists:cms_roles,id',
        ];

        if (!$id || !empty($this->get('password'))) {
            $rules['password'] = 'required|string|min:5|confirmed';
        }

        return $rules;
    }
}

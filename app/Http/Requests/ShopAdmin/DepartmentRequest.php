<?php

namespace App\Http\Requests\ShopAdmin;

use App\Http\Requests\FormRequest;
use App\Traits\Requests\Authorize;

/**
 * DepartmentRequest
 */
class DepartmentRequest extends FormRequest
{

    use Authorize;

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'name'              => 'required|string|max:50',
            'description'       => 'nullable|string',
            'available'         => 'boolean',
            'preview_url'       => 'nullable|string|max:150',
            'preview_url_small' => 'nullable|string|max:150',
        ];
    }

    /**
     * Get all of the input and files for the request.
     *
     * @param array|mixed $keys Keys
     *
     * @return array
     */
    public function all($keys = null)
    {
        $data = parent::all($keys);

        $data['available'] = !empty($data['available']);

        return $data;
    }
}

<?php

namespace App\Http\Requests\ShopAdmin;

use App\Http\Requests\FormRequest;
use App\Traits\Requests\Authorize;

/**
 * Class ShopRequest
 */
class ShopRequest extends FormRequest
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
            'name'                 => 'required|string|max:50',
            'description'          => 'required|string',
            'available'            => 'boolean',
            'available_for_tester' => 'boolean',
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

        $data['available']            = !empty($data['available']);
        $data['available_for_tester'] = !empty($data['available_for_tester']);

        return $data;
    }
}

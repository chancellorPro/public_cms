<?php

namespace App\Http\Requests\ShopAdmin;

use App\Http\Requests\FormRequest;
use App\Traits\Requests\Authorize;

/**
 * DepartmentShopsRequest
 */
class DepartmentShopsRequest extends FormRequest
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
            'shop.*.shop_id'     => 'required|exists:shops,id',
            'shop.*.name'        => 'nullable|string|max:50',
            'shop.*.description' => 'nullable|string|max:250',
            'shop.*.new_items'   => 'boolean',
            'shop.*.default'     => 'boolean',
            'shop.*.enabled'     => 'boolean',
            'shop.*.position'    => 'nullable|integer',
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

        if (!empty($data['shop'])) {
            foreach ($data['shop'] as $key => &$item) {
                $item['new_items'] = (int) !empty($item['new_items']);
                $item['default']   = (int) !empty($item['default']);
                $item['enabled']   = (int) !empty($item['enabled']);
                $item['position']  = $key;
            }
        }

        return $data;
    }

    /**
     * Get shops
     *
     * @return array
     */
    public function shops():array
    {
        $shops = $this->all('shop');

        if (!empty($shops['shop'])) {
            return $shops['shop'];
        }

        return [];
    }
}

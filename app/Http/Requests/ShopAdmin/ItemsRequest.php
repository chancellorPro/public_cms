<?php

namespace App\Http\Requests\ShopAdmin;

use App\Http\Requests\FormRequest;
use App\Traits\Requests\Authorize;

/**
 * Class ItemsRequest
 */
class ItemsRequest extends FormRequest
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
            'items.*.asset_id' => 'required|exists:assets,id',
            'items.*.data'     => 'nullable',
            'items.*.sellable' => 'nullable|boolean',
        ];
    }

    /**
     * Get items
     *
     * @return array
     */
    public function getItems():array
    {
        return (array) $this->get('items', []);
    }
}

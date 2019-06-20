<?php

namespace App\Http\Requests\ShopAdmin;

use App\Http\Requests\FormRequest;
use App\Traits\Requests\Authorize;

/**
 * Class ShopDataRequest
 */
class ShopDataRequest extends FormRequest
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
            'data.size' => 'required|integer',
        ];
    }
}

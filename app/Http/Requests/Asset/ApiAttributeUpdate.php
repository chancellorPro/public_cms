<?php

namespace App\Http\Requests\Asset;

use App\Http\Requests\FormRequest;
use App\Traits\Requests\Authorize;

/**
 * Class ApiAttributeUpdate
 */
class ApiAttributeUpdate extends FormRequest
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
            'attribute_id' => 'required|exists:attributes,id',
            'value'        => 'required|numeric',
        ];
    }

    /**
     * Get attribute ID
     *
     * @return integer
     */
    public function getAttributeId():int
    {
        return (int) $this->get('attribute_id');
    }

    /**
     * Get attribute value
     *
     * @return mixed
     */
    public function getAttributeValue()
    {
        return $this->get('value');
    }
}

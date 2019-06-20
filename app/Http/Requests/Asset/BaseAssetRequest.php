<?php

namespace App\Http\Requests\Asset;

use App\Http\Requests\FormRequest;
use App\Models\Cms\Asset;
use App\Traits\Requests\Authorize;

/**
 * Class BaseAssetRequest
 */
abstract class BaseAssetRequest extends FormRequest
{

    use Authorize;

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        $rules = [
            'name'        => 'nullable|string|max:100',
            'cash_price'  => 'nullable|zeroWith:coins_price|integer',
            'coins_price' => 'nullable|zeroWith:cash_price|integer',
        ];

        $coinsPrice = (int) $this->get('coins_price');
        if (empty($coinsPrice)) {
            $rules['cash_price'] = 'required|zeroWith:coins_price|integer|min:1';
        }

        $type = $this->get('type');
        switch ($type) {
            case Asset::ASSET_TYPE_CLOTHES:
                $rules['collection_number'] = 'nullable|integer';
                break;
            case Asset::ASSET_TYPE_COLLECTION_ITEM:
                $rules['cash_price']  = 'required|integer';
                $rules['coins_price'] = 'required|integer';
                break;
            case Asset::ASSET_TYPE_BODY_PART:
                $rules['cash_price']  = 'nullable|integer';
                $rules['coins_price'] = 'nullable|integer';
                break;
        }

        return $rules;
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

        $type = $this->get('type');
        switch ($type) {
            case Asset::ASSET_TYPE_BODY_PART:
                $data['cash_price']  = 0;
                $data['coins_price'] = 0;
                break;
        }

        return $data;
    }

    /**
     * Get custom error messages
     *
     * @return array
     */
    public function messages():array
    {
        $messages = parent::messages();

        $messages['cash_price.min'] = __('Set price');

        return $messages;
    }
}

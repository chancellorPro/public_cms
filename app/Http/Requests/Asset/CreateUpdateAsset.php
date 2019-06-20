<?php

namespace App\Http\Requests\Asset;

use Illuminate\Validation\Rule;
use App\Models\Cms\Asset;

/**
 * Class CreateUpdateAsset
 */
class CreateUpdateAsset extends BaseAssetRequest
{

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        $rules = parent::rules();

        $rules += [
            'type'             => ['required', Rule::in(array_column(config('presets.asset_types'), 'id'))],
            'subtype'          => 'required_if:type,' . Asset::ASSET_TYPE_FURNITURE . '|exists:subtypes,id',
            'preview'          => 'required_without:uploaded_preview|image|max:2000',
            'uploaded_preview' => 'nullable',
            'action_type_id'   => 'nullable|integer',
        ];

        return $rules;
    }
}

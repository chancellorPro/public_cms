<?php

namespace App\Http\Requests\CmsUser;

use App\Http\Requests\FormRequest;
use App\Traits\Requests\Authorize;

/**
 * Class CertRequest
 */
class CertRequest extends FormRequest
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
            'cert_data.news_message' => 'required|string|max:145',
            'cert_data.name'         => 'required|string|max:25',
            'cert_data.event'        => 'required|string|max:25',
            'cert_data.group'        => 'required|string|max:25',
            'cert_data.date'         => 'required|string',
            'cert_data.asset_id'     => 'required|string',
        ];

        return $rules;
    }

    /**
     * Get custom error messages
     *
     * @return array
     */
    public function messages(): array
    {
        $messages = parent::messages();

        $messages['cert_data.news_message'] = __('Note is required');
        $messages['cert_data.name'] = __('Name is required');
        $messages['cert_data.event'] = __('Event name is required');
        $messages['cert_data.group'] = __('Group name is required');
        $messages['cert_data.date'] = __('Date is required');

        return $messages;
    }
}

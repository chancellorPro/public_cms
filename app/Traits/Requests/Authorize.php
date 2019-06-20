<?php

namespace App\Traits\Requests;

/**
 * Authorize
 */
trait Authorize
{

    /**
     * Determine if the user is authorized to make this request.
     *
     * @return boolean
     */
    public function authorize()
    {
        return true;
    }
}

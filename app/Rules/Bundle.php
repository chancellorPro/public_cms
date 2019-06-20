<?php

namespace App\Rules;

use Illuminate\Contracts\Validation\Rule;

/**
 * Bundle rule
 */
class Bundle implements Rule
{

    /**
     * Valid extension of a bundle
     */
    const EXTENSION = 'bundle';

    /**
     * Determine if the validation rule passes.
     *
     * @param string $attribute Attribute
     * @param mixed  $value     Value
     *
     * @return boolean
     */
    public function passes($attribute, $value) // phpcs:disable
    {
        return $value->getClientOriginalExtension() === self::EXTENSION;
    }

    /**
     * Get the validation error message.
     *
     * @return string
     */
    public function message()
    {
        return 'The field :attribute must be .bundle';
    }
}
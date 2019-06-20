<?php

namespace App\Exceptions\Placement;

use App\Exceptions\BaseException;

/**
 * Asset type not found
 */
class TypeNotFoundException extends BaseException
{

    /**
     * Message
     *
     * @var string
     */
    protected $message = 'Asset type not found';
}

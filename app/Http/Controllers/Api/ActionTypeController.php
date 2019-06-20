<?php

namespace App\Http\Controllers\Api;

use App\Configs\ActionTypeConfig;
use App\Http\Controllers\Api;

/**
 * Class ActionTypeController
 */
class ActionTypeController extends Api
{

    /**
     * Get action type config
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function all()
    {
        return $this->success((new ActionTypeConfig())->generate()->current());
    }
}

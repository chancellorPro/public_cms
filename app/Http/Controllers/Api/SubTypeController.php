<?php

namespace App\Http\Controllers\Api;

use App\Configs\SubTypeConfig;
use App\Http\Controllers\Api;

/**
 * Class SubTypeController
 */
class SubTypeController extends Api
{

    /**
     * Get sub type config
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function all()
    {
        return $this->success((new SubTypeConfig())->generate()->current());
    }
}

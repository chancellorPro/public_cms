<?php

namespace App\Http\Controllers;

use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;

/**
 * Class Api
 */
abstract class Api extends BaseController
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;

    const RESPONSE_SUCCESS = 1;
    const RESPONSE_ERROR   = 0;

    /**
     * Returns success
     *
     * @param mixed $data Data
     *
     * @return \Illuminate\Http\JsonResponse
     */
    protected function success($data = null)
    {
        $response = [];

        if (!empty($data)) {
            $response['d'] = $data;
        }

        $response['r'] = self::RESPONSE_SUCCESS;

        return response()->json($response);
    }

    /**
     * Returns error
     *
     * @return \Illuminate\Http\JsonResponse
     */
    protected function error()
    {
        return response()->json([
            'r' => self::RESPONSE_ERROR,
        ]);
    }
}

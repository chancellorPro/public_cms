<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Models\User\User;

/**
 * Class FcdController
 */
class FcdController extends Controller
{

    /**
     * Reset FCD
     *
     * @param integer $id User ID
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function reset(int $id)
    {
        User::resetFcd($id);

        return $this->success([
            'message' => __('FCD was reset'),
        ]);
    }
}

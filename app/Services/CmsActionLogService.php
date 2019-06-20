<?php

namespace App\Services;

use App\Models\Cms\CmsActionsHistory;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Carbon;

/**
 * Class CmsActionLogService
 */
class CmsActionLogService
{

    /**
     * Log action
     *
     * @param string $source Source name
     * @param string $action Action name
     * @param array  $data   Data
     *
     * @return void
     */
    public static function logAction(string $source, string $action, array $data)
    {
        if (Auth::user()) {
            $logData = [
                'cms_user_id' => Auth::user()->id,
                'source'      => $source,
                'action'      => $action,
                'data'        => $data,
                'created_at'  => Carbon::now(),
            ];
            CmsActionsHistory::create($logData);
        }
    }
}

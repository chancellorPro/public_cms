<?php

namespace App\Models\Stats;

use App\Models\StatsModel;

/**
 * RotationPoint
 */
class UsdSpent extends StatsModel
{

    /**
     * Table name
     *
     * @var string
     */
    protected $table = 'usd_spent';

    /**
     * Get total spent by user
     *
     * @param array $userIds User Ids
     *
     * @return array
     */
    public static function getTotalSpent(array $userIds)
    {
        $resp = [];
        if ($userIds) {
            $resp = self::groupBy('user_id')
                ->selectRaw('sum(usd_amount) as sum, user_id')
                ->where('verified', 1)
                ->whereIn('user_id', $userIds)
                ->pluck('sum', 'user_id');
        }
        return $resp;
    }
}

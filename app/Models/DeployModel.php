<?php

namespace App\Models;

use App\Models\CmsModel;
use App\Services\CmsActionLogService;
use App\Traits\Deploy\DeployFileModel;
use Doctrine\DBAL\Query\QueryException;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

/**
 * CmsModel
 */
abstract class DeployModel extends CmsModel
{
    use DeployFileModel;

    /**
     * Deploy order
     *
     * @var integer
     */
    public static $deployOrder = 0;

    /**
     * List order
     *
     * @var integer
     */
    public static $listOrder = 0;

    /**
     * Files for deploy
     *
     * @var array
     */
    public static $deployFiles = [];

    /**
     * Deploy category
     *
     * @var string
     */
    public static $deployCategory = 'unsorted';

    /**
     * Possible deploy directions
     *
     * @var array
     */
    public static $deployDirections = [
        'dev-stage',
        'stage-live',
        'stage-dev',
    ];

    /**
     * Check direction
     *
     * @param string $from From direction
     * @param string $to   To direction
     *
     * @return boolean
     */
    protected function checkDirection(string $from, string $to)
    {
        return in_array("$from-$to", self::$deployDirections);
    }

    /**
     * Deploy
     *
     * @param string $fromEnv From env
     * @param string $toEnv   To env
     *
     * @return boolean
     */
    public function deploy(string $fromEnv, string $toEnv)
    {
        $status = false;
        if ($this->checkDirection($fromEnv, $toEnv)) {
            $funName = "deploy" . ucfirst($fromEnv) . ucfirst($toEnv);
            if (method_exists($this, $funName)) {
                $status = $this->{$funName};
            } else {
                $status = $this->deployDefault($fromEnv, $toEnv);
            }
        }
        return $status;
    }

    /**
     * Deploy default
     *
     * @param string $fromEnv From env
     * @param string $toEnv   To env
     *
     * @return boolean
     */
    protected function deployDefault(string $fromEnv, string $toEnv)
    {
        $status = true;
        $now    = Carbon::now();

        $destinationDatabase = DB::connection("$toEnv.cms");
        $this->setConnection("$fromEnv.cms");

        $builder = $this->where(function ($query) {
            $query->whereRaw('deployed_at < updated_at')
                ->orWhereNull('deployed_at');
        });

        try {
            foreach ($builder->get() as $data) {
                $data->deployed_at = null;
                $data->updated_at  = $now;

                $insertData = $data->toArray();
                foreach ($insertData as &$field) {
                    if (is_array($field)) {
                        $field = json_encode($field);
                    }
                }

                if (!empty(static::$deployFiles)) {
                    foreach (static::$deployFiles as $deployFile) {
                        $this->deployFile($insertData[$deployFile], $fromEnv, $toEnv);
                    }
                }

                $destinationDatabase->table($this->getTable())->updateOrInsert(['id' => $data->id], $insertData);
            }
            /**
             * Turn off auto updated_at
             */
            $this->timestamps = false;
            $builder->update(['deployed_at' => $now]);
        } catch (\Illuminate\Database\QueryException $exception) {
            CmsActionLogService::logAction('deploy_configs', 'fail', ['message' => $exception->getMessage()]);
            $status = false;
        }
        return $status;
    }


    /**
     * Get number of rows for deploy
     *
     * @return integer
     */
    public function rowsForDeploy()
    {
        return $this->select(DB::raw('count(*) as total'))->where(function ($query) {
            $query->whereRaw('deployed_at < updated_at')
                ->orWhereNull('deployed_at');
        })->first()->total;
    }
}

<?php

namespace App\Observers;

use Illuminate\Database\Eloquent\Model;
use App\Services\CmsActionLogService;

/**
 * Class ModelChangeObserver
 */
class ModelChangeObserver
{

     /**
      * Handle the Model "created" event.
      *
      * @param Model $model Model
      *
      * @return void
      */
    public function created(Model $model)
    {
        $source = $model->getTable();
        $action = 'created';
        $data   = [
            'id' => $model->getKey(),
        ];
        CmsActionLogService::logAction($source, $action, $data);
    }

    /**
     * Handle the Model "updated" event.
     *
     * @param Model $model Model
     *
     * @return void
     */
    public function updated(Model $model)
    {
        $source = $model->getTable();
        $action = 'updated';
        if ($model->fromDeploy) {
            $action = 'deployed';
        }

        $data = [
            'id' => $model->getKey(),
        ];

        CmsActionLogService::logAction($source, $action, $data);
    }

    /**
     * Handle the Model "deleted" event.
     *
     * @param Model $model Model
     *
     * @return void
     */
    public function deleted(Model $model)
    {
        $source = $model->getTable();
        $action = 'deleted';
        $data   = [
            'id' => $model->getKey(),
        ];
        CmsActionLogService::logAction($source, $action, $data);
    }
}

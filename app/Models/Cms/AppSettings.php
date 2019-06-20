<?php

namespace App\Models\Cms;

use App\Services\CmsActionLogService;
use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;

/**
 * AppSettings
 *
 * @property string $key
 * @property mixed $value
 */
class AppSettings extends Model
{

    /**
     * Folder for images
     */
    const FILES_FOLDER = 'settings';

    /**
     * The primary key for the model.
     *
     * @var string
     */
    protected $primaryKey = 'key';

    /**
     * The "type" of the auto-incrementing ID.
     *
     * @var string
     */
    protected $keyType = 'string';

    /**
     * Indicates if the IDs are auto-incrementing.
     *
     * @var boolean
     */
    public $incrementing = false;

    /**
     * For detect deployment in ModelChangeObserver
     *
     * @var boolean
     */
    public $fromDeploy = false;

    /**
     * Fillable
     *
     * @var array
     */
    protected $fillable = [
        'key',
        'value',
    ];

    /**
     * Get settings converted to array
     *
     * @param string $name Name
     *
     * @return array
     */
    public static function getConfig(string $name)
    {
        $row    = self::find($name);
        $config = [];
        if ($row) {
            $config = json_decode($row->value, true);
        }
        return $config;
    }


    /**
     * Get configs for deploy
     *
     * @return mixed
     */
    public function configsForDeploy()
    {
        return $this->select('key')->where(function ($query) {
            $query->whereRaw('deployed_at < updated_at')
                ->orWhereNull('deployed_at');
        })->pluck('key');
    }

    /**
     * Deploy
     *
     * @param string $configName Сonfig
     * @param string $fromEnv    From env
     * @param string $toEnv      To env
     *
     * @return boolean
     */
    public function deploy(string $configName, string $fromEnv, string $toEnv)
    {
        $status = true;
        $now    = Carbon::now();

        $destinationDatabase = DB::connection("$toEnv.cms");
        $this->setConnection("$fromEnv.cms");

        $appSettingsConfigs = config('appsettings.' . $configName);

        $config = self::find($configName);

        if ($config) {
            try {
                $insertData = $config->toArray();
                unset($insertData['deployed_at']);
                $insertData['updated_at'] = $now;

                $destinationDatabase->table($this->getTable())->updateOrInsert(['key' => $config->key], $insertData);

                if (!empty($appSettingsConfigs['deploy_files'])) {
                    $this->deployFiles($configName, $insertData, $appSettingsConfigs['deploy_files'], $fromEnv, $toEnv);
                }

                /**
                 * Turn off auto updated_at
                 */
                $config->timestamps  = false;
                $config->deployed_at = $now;
                $config->fromDeploy  = true;

                $config->save();
            } catch (\Illuminate\Database\QueryException $exception) {
                CmsActionLogService::logAction('deploy_configs', 'fail', ['message' => $exception->getMessage()]);
                $status = false;
            }
        }

        return $status;
    }

    /**
     * Deploy files
     *
     * @param string $configName  Config name
     * @param array  $data        Data
     * @param array  $filesFields Files fields
     * @param string $fromEnv     From env
     * @param string $toEnv       To env
     *
     * @return void
     */
    public function deployFiles(string $configName, array $data, array $filesFields, string $fromEnv, string $toEnv)
    {
        $value = json_decode($data['value'], true);
        foreach ($value['rows'] ?? [] as $row) {
            foreach ($filesFields as $fileField) {
                $fileFieldPath = explode('.', $fileField);
                $fileName      = $row;
                foreach ($fileFieldPath as $fileFieldPathPart) {
                    $fileName = $fileName[$fileFieldPathPart] ?? [];
                }

                if ($fileName && is_string($fileName)) {
                    $file            = self::getUploadFolder($configName, $fromEnv)
                        . '/' . getSubFolder($fileName) . '/' . $fileName;
                    $destinationFile = self::getUploadFolder($configName, $toEnv)
                        . '/' . getSubFolder($fileName) . '/' . $fileName;

                    if (Storage::exists($file) && !Storage::exists($destinationFile)) {
                        Storage::copy($file, $destinationFile);
                    }
                }
            }
        }
    }

    /**
     * Create or update app settings
     *
     * @param string $name   Name
     * @param mixed  $config Config
     *
     * @return \Illuminate\Database\Eloquent\Model
     */
    public static function setConfig(string $name, $config)
    {
        return self::updateOrCreate(['key' => $name], ['value' => json_encode($config)]);
    }

    /**
     * Get upload folder
     *
     * @param string $name Name
     * @param string $env  Env
     *
     * @return string
     */
    public static function getUploadFolder(string $name, ?string $env = null): string
    {
        if (!$env) {
            $env = environment();
        }

        return $env . '/' . self::FILES_FOLDER . '/' . $name;
    }
}

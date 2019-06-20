<?php

namespace App\Traits;

use App\Models\Cms\AppSettings;
use App\Traits\PreviewUpload\UpdatePreviewImage;
use Validator;
use App\Exceptions\AppSettings\AppSettingsNotFound;
use App\Exceptions\AppSettings\AppSettingsValidate;

/**
 * Trait AppSettings
 */
trait AppSettingsTrait
{

    use UpdatePreviewImage;

    /**
     * Convert data types
     *
     * @param mixed $requestValue Request value
     * @param array $fieldData    Field data
     *
     * @return mixed
     *
     * @throws \Exception ValidatorException
     */
    private function convertDataTypes($requestValue, array $fieldData)
    {
        $type = isset($fieldData['config_type']) ? $fieldData['config_type'] : $fieldData['create_type'];

        switch ($type) {
            case 'select':
            case 'int':
                $value = (int) $requestValue;
                break;
            case 'float':
                $value = (float) $requestValue;
                break;
            case 'embed':
                $value = $this->fillEmbedData($fieldData['embed'], $requestValue);
                break;
            default:
                $value = $requestValue;
                break;
        }

        return $value;
    }

    /**
     * Fill data
     *
     * @param array   $fields      Fields
     * @param array   $requestData Request data
     * @param array   $configData  Config data
     * @param integer $id          ID
     *
     * @return void
     *
     * @throws AppSettingsValidate Validate
     */
    private function fillData(array $fields, array $requestData, array &$configData, int $id)
    {
        foreach ($fields as $field => $fieldData) {

            /**
             * Validation of the value
             */
            if (!empty($fieldData['validator'])) {
                $validator = Validator::make(
                    [$field => $requestData[$field]],
                    [$field => $fieldData['validator']]
                );
                if ($validator->invalid()) {
                    throw new AppSettingsValidate($validator->errors()->first($field));
                }
            }

            if (key_exists($field, $requestData)) {
                switch ($fieldData['create_type']) {
                    case 'dropzone':
                        self::updatePreviewImage($requestData[$field], $configData['rows'][$id][$field]);
                        break;
                }

                $value = $this->convertDataTypes($requestData[$field], $fieldData);

                $configData['rows'][$id][$field] = $value;
            } elseif ($fieldData['create_type'] == 'embed') {
                // for clear when all embed rows deleted
                unset($configData['rows'][$id][$field]);
            }
        }
    }

    /**
     * Fill embed data
     *
     * @param array $fields          Fields
     * @param array $requestDataRows Request data rows
     *
     * @return array
     *
     * @throws \Exception If value is not valid
     */
    private function fillEmbedData(array $fields, array $requestDataRows):array
    {
        $data = [];
        foreach ($requestDataRows as $requestData) {
            $row = [];
            foreach ($fields as $field => $fieldData) {
                /**
                 * Validation of the value
                 */
                if (!empty($fieldData['validator'])) {
                    $validator = Validator::make(
                        [$field => $requestData[$field]],
                        [$field => $fieldData['validator']]
                    );
                    if ($validator->invalid()) {
                        throw new \Exception($validator->errors()->first($field));
                    }
                }

                if (key_exists($field, $requestData)) {
                    $value       = $this->convertDataTypes($requestData[$field], $fieldData);
                    $row[$field] = $value;
                }
            }
            $data[] = $row;
        }
        return $data;
    }

    /**
     * Get fields list for config
     *
     * @param string $config Config name
     *
     * @return array
     * @throws AppSettingsNotFound NotFound
     */
    private function getFields(string $config):array
    {
        $appSettings = config('appsettings.' . $config);
        if (!$appSettings) {
            return [];
        }

        return $appSettings['fields'];
    }

    /**
     * Get form settings for config
     *
     * @param string $config Config name
     *
     * @return array
     * @throws AppSettingsNotFound NotFound
     */
    private function getFormSettings(string $config):array
    {
        $appSettings = config('appsettings.' . $config);
        if (!$appSettings) {
            return [];
        }

        $setings['name']              = $appSettings['name'] ?? ucfirst(str_replace('_', ' ', $config));
        $setings['add_mult_rows']     = $appSettings['add_mult_rows'] ?? false;
        $setings['fixed_rows']        = $appSettings['fixed_rows'] ?? false;
        $setings['default_structure'] = $appSettings['default_structure'] ?? false;
        $setings['with_award']        = $appSettings['with_award'] ?? false;

        return $setings;
    }

    /**
     * Get counter for config
     *
     * @param string  $config  Config name
     * @param integer $counter Counter
     *
     * @return void
     * @throws AppSettingsNotFound NotFound
     */
    private function setCounter(string $config, int $counter)
    {
        $appSettings = config('appsettings.' . $config);
        if (!$appSettings) {
            throw new AppSettingsNotFound($config);
        }

        AppSettings::setConfig($appSettings['counter'], $counter);
    }

    /**
     * Get counter for config
     *
     * @param string $config Config name
     *
     * @return integer
     * @throws AppSettingsNotFound NotFound
     */
    private function getCounter(string $config):int
    {
        $appSettings = config('appsettings.' . $config);
        if (!$appSettings) {
            throw new AppSettingsNotFound($config);
        }

        $counter = AppSettings::getConfig($appSettings['counter']);

        return empty($counter) ? 1 : (int) $counter;
    }

    /**
     * Get presets list for config
     *
     * @param string $config Config name
     *
     * @return array
     */
    private function getPresets(string $config):array
    {
        $presets     = config("appsettings.$config.presets") ?? [];
        $presetsData = [];
        foreach ($presets as $field => $presetName) {
            $list = config("presets.$presetName");

            if (!$list && strpos($presetName, '::') !== false) {
                $list = $presetName();
            }

            $presetsData[$field]['forView']   = arrayToKeyValue($list, 'id', 'name');
            $presetsData[$field]['forSelect'] = arrayToCollection($list);
        }
        return $presetsData;
    }

    /**
     * Get upload folder
     *
     * @return string
     */
    protected static function getUploadFolder(): string
    {
        $name = basename(request()->route()->parameters['config']);
        return AppSettings::getUploadFolder($name);
    }
}

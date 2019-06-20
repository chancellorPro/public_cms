<?php

namespace App\Configs;

use App\Configs\Base\Config;
use App\Models\Cms\AppSettings;
use Validator;

/**
 * Class AppSettingsConfig
 */
class AppSettingsConfig extends Config
{

    /**
     * App settings key
     *
     * @var null|string
     */
    private $appSettingsKey = null;

    /**
     * AppSettingsConfig constructor.
     *
     * @param string $appSettingsKey Set app settings key
     */
    public function __construct(string $appSettingsKey)
    {
        $this->appSettingsKey = $appSettingsKey;
    }

    /**
     * Generate
     *
     * @return \Generator
     *
     * @throws \Exception ValidatorException
     */
    public function generate():\Generator
    {
        $appSettings = config("appsettings.{$this->appSettingsKey}");

        $fields         = $appSettings['fields'];
        $configData     = AppSettings::getConfig($this->appSettingsKey);
        $configDataRows = $configData['rows'] ?? [];

        $result = $this->processAppsettingsFieldsValue($fields, $configDataRows);

        yield $result;
    }

    /**
     * Preparation process
     *
     * @param array $fields         Fields
     * @param array $configDataRows Data
     *
     * @return array
     *
     * @throws \Exception ValidatorException
     */
    private function processAppsettingsFieldsValue(array $fields, array $configDataRows)
    {
        $clientConfigData = [];

        foreach ((array) $configDataRows as $configDataRow) {
            $clientConfigDataRow = [];
            foreach ($fields as $field => $fieldData) {
                if (isset($configDataRow[$field])) {
                    $alias = $fieldData['alias'] ?? $field;

                    if ($fieldData['create_type'] == 'embed') {
                        $clientConfigDataRow[$alias] = $this->processAppsettingsFieldsValue(
                            $fieldData['embed'],
                            $configDataRow[$field]
                        );
                    } else {

                        /**
                         * Validation of the value
                         */
                        if (!empty($fieldData['validator'])) {
                            $validator = Validator::make(
                                [$field => $configDataRow[$field]],
                                [$field => $fieldData['validator']]
                            );
                            if ($validator->invalid()) {
                                throw new \Exception($validator->errors()->first($field));
                            }
                        }

                        $clientConfigDataRow[$alias] = cast($configDataRow[$field]);
                    }
                }
            }
            if (!empty($clientConfigDataRow)) {
                $clientConfigData[] = $clientConfigDataRow;
            }
        }

        return $clientConfigData;
    }
}

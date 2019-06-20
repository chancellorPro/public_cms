<?php

namespace App\Traits;

use Illuminate\Http\Request;

/**
 * Trait AppSettingsFilterTrait
 */
trait AppSettingsFilterTrait
{

    /**
     * Applied filters
     *
     * @var array
     */
    private $appliedFilter = [];

    /**
     * Config fields
     *
     * @var array
     */
    private $fields = [];

    /**
     * Apply filter
     *
     * @param array $configRows App Settings Config
     *
     * @return mixed
     */
    private function applyFilter(array $configRows)
    {
        $dataRows = collect($configRows);

        $filteredRows = collect([]);
        foreach ($dataRows as $key => $row) {
            $cond = true;
            foreach ($this->appliedFilter as $field => $value) {
                switch ($this->fields[$field]['filter_type']) {
                    case 'string':
                        $cond = strpos($row[$field], $value) !== false;
                        break;
                    default:
                        $cond = !empty($row[$field]) && $row[$field] == $value;
                        break;
                }

                if (!$cond) {
                    break;
                }
            }

            if ($cond) {
                $filteredRows[$key] = $row;
            }
        }

        return $filteredRows;
    }

    /**
     * Get filter
     *
     * @param array   $fields  Config fields
     * @param Request $request Request
     *
     * @return void
     */
    private function getFilter(array $fields, Request $request)
    {
        $filter       = [];
        $this->fields = $fields;
        foreach (array_keys($fields) as $field) {
            $requestFilter = $request->get($field);
            if ($requestFilter) {
                $filter[$field] = $requestFilter;
            }
        }

        $this->appliedFilter = $filter;
    }
}

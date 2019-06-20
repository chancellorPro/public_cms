<?php

namespace App\Configs\Base;

use App\Configs\Contract\Generator;
use Carbon\Carbon;

/**
 * Class Config
 */
abstract class Config implements Generator
{

    /**
     * Items per page
     *
     * @var integer
     */
    protected $perPage = 100;

    /**
     * Set items per page
     *
     * @param integer $perPage Items per page
     *
     * @return void
     */
    public function setPerPage(int $perPage)
    {
        $this->perPage = $perPage;
    }

    /**
     * Hidden fields
     *
     * Example:
     * 'created_at',
     * 'updated_at'
     *
     * @var array
     */
    protected $hiddenFields = [];

    /**
     * Allowed fields
     *
     * @var array
     */
    protected $allowedFields = [];

    /**
     * Filters
     *
     * Example:
     * {fields name} => {method name}
     * 'created_at'  => 'dateFilter'
     *
     * @var array
     */
    protected $filters = [];

    /**
     * Aliases
     *
     * Example:
     * 'id'      => 'i',
     * 'user_id' => 'uid',
     *
     * @var array
     */
    protected $aliases = [];

    /**
     * Date filter
     *
     * @param string $value Datetime 'Y-M-D H:i:s'
     *
     * @return integer
     */
    protected function dateFilter(string $value):int
    {
        return Carbon::parse($value)->timestamp;
    }

    /**
     * Get field name
     *
     * @param string $name Field name
     *
     * @return string
     */
    protected function getFieldName(string $name):string
    {
        return $this->aliases[$name] ?? $name;
    }

    /**
     * Fill data
     *
     * @param array  $data  Data
     * @param string $key   Key
     * @param mixed  $value Value
     * @param bool   $allowEmptyValue Allow Empty Value
     *
     * @return void
     */
    protected function fillData(array &$data, string $key, $value, bool $allowEmptyValue = false)
    {
        if (!empty($value) || $allowEmptyValue) {
            /**
             * Is the key allowed
             */
            if (!$this->allowed($key)) {
                return;
            }

            /**
             * If filter exists
             */
            if (!empty($this->filters[$key]) && method_exists($this, $this->filters[$key])) {
                $data[$this->getFieldName($key)] = $this->{$this->filters[$key]}($value);
                return;
            }

            $data[$this->getFieldName($key)] = $value;
        }
    }

    /**
     * Is fields allowed
     *
     * @param string $field Field name
     *
     * @return boolean
     */
    protected function allowed(string $field):bool
    {
        /**
         * If the key does not exist in allow fields - skip
         */
        if (!empty($this->allowedFields)) {
            return in_array($field, $this->allowedFields);
        }

        /**
         * If the key exists in hidden fields - skip
         */
        if (in_array($field, $this->hiddenFields)) {
            return false;
        }

        return true;
    }

    /**
     * Call
     *
     * @param string $name      Method name
     * @param mixed  $arguments Arguments
     *
     * @throws \Exception Some thing went wrong
     *
     * @return void
     */
    public function __call(string $name, $arguments)
    {
        switch (substr($name, 0, 3)) {

            /**
             * Set aliases, hidden fields and filters
             */
            case 'set':
                $propertyName = lcfirst(substr($name, 3));

                if (!property_exists($this, $propertyName)) {
                    throw new \Exception("Property not found: {$propertyName}");
                }

                if (empty($arguments[0])) {
                    $this->{$propertyName} = [];
                    return;
                } else {
                    if (!is_array($arguments[0])) {
                        throw new \Exception('Must be an array');
                    }
                }

                $this->{$propertyName} = $arguments[0];
                break;
        }
    }
}

<?php

use Illuminate\Support\Facades\Redis;

if (! function_exists('pushNotify')) {
    /**
     * Add notify to session.
     *
     * @param string $key   Key 'success'|'warning'|'danger'|'info'
     * @param string $value Value
     *
     * @return void
     */
    function pushNotify(string $key, string $value)
    {
        $types = ['info', 'success', 'warning', 'danger'];
        if (!empty($value) && in_array($key, $types)) {
            $values   = Session::get($key, []);
            $values[] = $value;
            Session::flash($key, $values);
        }
    }
}

if (! function_exists('getNotify')) {
    /**
     * Get notify from session.
     *
     * @return array
     */
    function getNotify():array
    {
        $notice = [];
        $types  = ['info', 'success', 'warning', 'danger'];
        foreach ($types as $type) {
            $notice[$type] = Session::get($type, []);
            Session::forget($type);
        }
        return $notice;
    }
}

if (! function_exists('arrayToCollection')) {
    /**
     * Convert array to object collection
     *
     * @param array $array Array
     *
     * @return \Illuminate\Support\Collection
     */
    function arrayToCollection(array $array = [])
    {
        return collect(json_decode(json_encode($array)));
    }
}

if (! function_exists('arrayToKeyValue')) {
    /**
     * Convert multidimensional array to simle key-value array
     *
     * @param array $array Array
     * @param mixed $key   Key
     * @param mixed $value Value
     *
     * @return array
     */
    function arrayToKeyValue(array $array, $key, $value):array
    {
        $res = [];
        foreach ($array as $row) {
            if (isset($row[$key]) && isset($row[$value])) {
                $res[$row[$key]] = $row[$value];
            }
        }
        return $res;
    }
}

if (! function_exists('parsePossibleValues')) {
    /**
     * Parse possible values from string to object collection
     *
     * @param null|string $string     Values
     * @param boolean     $assocArray Is the assoc
     *
     * @return array|\Illuminate\Support\Collection
     */
    function parsePossibleValues(?string $string, bool $assocArray = false)
    {
        $list = [];

        if (!empty($string)) {
            $values = explode(',', $string);
            foreach ($values as $row) {
                if (strpos($row, ':') !== false) {
                    list($name, $value) = explode(':', $row);
                    if ($assocArray) {
                        $list[trim($name)] = trim($value);
                    } else {
                        $list[] = ['id' => trim($name), 'value' => trim($value)];
                    }
                }
            }
        }

        return $assocArray ? $list : arrayToCollection($list);
    }
}

if (! function_exists('parameterizeArray')) {
    /**
     * Parse possible values from string to object collection
     *
     * @param array $array Array
     *
     * @return array
     */
    function parameterizeArray(array $array):array
    {
        $out = [];
        foreach ($array as $key => $value) {
            $out[] = "$key=$value";
        }
        return $out;
    }
}

if (! function_exists('assocArrayToCollection')) {
    /**
     * Convert key value array to collection
     *
     * @param array $array     Array
     * @param mixed $keyName   Key Name
     * @param mixed $valueName Value Name
     *
     * @return array|\Illuminate\Support\Collection
     */
    function assocArrayToCollection(array $array, $keyName = 'id', $valueName = 'value')
    {
        $list = [];
        foreach ($array as $key => $value) {
            $list[] = [
                $keyName   => $key,
                $valueName => $value,
            ];
        }
        
        return arrayToCollection($list);
    }
}

if (! function_exists('userCache')) {
    /**
     * Return connection to the user's data in the redis
     *
     * @return \Illuminate\Redis\Connections\Connection
     */
    function userCache() :\Illuminate\Redis\Connections\Connection
    {
        return Redis::connection('user');
    }
}

if (! function_exists('cast')) {
    /**
     * Casts the types
     *
     * @param mixed $data Data
     *
     * @return float|integer|mixed
     */
    function cast($data)
    {
        if (is_numeric($data)) {
            if (is_float($data)) {
                return (float) $data;
            } else {
                return (int) $data;
            }
        }

        return $data;
    }
}

if (! function_exists('getSubFolder')) {
    /**
     * Return sub path for the file by name
     *
     * Result of the function looks like: a1/b2/c3
     * Where md5 of the file = a1b2c3.........
     *
     * @param string $fileName File name
     *
     * @return string
     */
    function getSubFolder(string $fileName):string
    {
        $fileNameHash = substr(md5($fileName), 0, 6);
        $pathParts    = str_split($fileNameHash, 2);
        return join('/', $pathParts);
    }
}

if (! function_exists('modelConst')) {
    /**
     * Return constant from model
     *
     * @param string $modelName Model name
     * @param string $var       Const name
     *
     * @return mixed
     */
    function modelConst(string $modelName, string $var)
    {
        $const = ("App\Models\\$modelName::$var");
        return constant($const);
    }
}

if (! function_exists('environment')) {
    /**
     * Returns selected environment
     * It is using in choice connection to db
     *
     * @return string
     */
    function environment():string
    {
        $env = env('APP_ENV');

        if (request()->has('env')) {
            $env = request()->get('env');
            session()->put('environment', $env);
        }

        switch ($env) {
            case 'stage':
            case 'live':
                return $env;
            default:
                $env = session()->get('environment');
                if(!empty($env)) {
                    return $env;
                }
                return 'dev';
        }
    }
}

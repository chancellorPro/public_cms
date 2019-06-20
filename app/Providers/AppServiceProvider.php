<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Blade;
use Illuminate\Validation\ValidationException;
use Validator;

/**
 * Class AppServiceProvider
 */
class AppServiceProvider extends ServiceProvider
{

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        Blade::directive('formFieldLabel', function ($expression) {
            return '<?php $currentRouteActionName = explode(".", Route::currentRouteName());
                    $currentRouteName = empty($currentRouteActionName[0]) ? "" : $currentRouteActionName[0];
                    echo(__("forms.$currentRouteName' . "." . $expression . '")) ?>';
        });
        
        Validator::extend('zeroWith', function ($attribute, $value, $parameters, $validator) { // phpcs:ignore
            $relatedFieldValue = array_get($validator->getData(), $parameters[0]);
            return ($value != 0 && $relatedFieldValue != 0) ? false : true;
        });
        Validator::replacer('zeroWith', function ($message, $attribute, $rule, $parameters) { // phpcs:ignore
            return str_replace(':zeroWith', $parameters[0], $message);
        });
        
        /**
         * Extension validator
         */
        Validator::extend('extension', function ($attribute, $value, $parameters, $validator) { // phpcs:ignore
            $ext = $value->getClientOriginalExtension();
            return in_array($ext, $parameters);
        });
        Validator::replacer('extension', function ($message, $attribute, $rule, $parameters) { // phpcs:ignore
            return str_replace(':extension', $parameters[0], $message);
        });

        /**
         * Check list of ids
         *
         * 1,2,3,4
         */
        Validator::extend('exists_all', function ($attribute, $value, $parameters, $validator) { // phpcs:ignore
            $v = Validator::make([$attribute => $value], [$attribute => 'regex:/^[0-9]+(,[\s]?[0-9]+)*$/']);
            if ($v->fails()) {
                throw new ValidationException($v);
            }

            $ids = explode(',', $value);
            array_walk($ids, function (&$item) {
                $item = (int) $item;
            });

            $v = Validator::make(['id' => $ids], ['id' => "exists:{$parameters[0]},{$parameters[1]}"]);
            if ($v->fails()) {
                throw new ValidationException($v);
            }

            return true;
        });
    }
}

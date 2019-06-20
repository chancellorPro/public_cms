<?php

namespace App\Providers;

use Illuminate\Support\Facades\Gate;
use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;

use Illuminate\Support\Facades\Route;

/**
 * Class AuthServiceProvider
 */
class AuthServiceProvider extends ServiceProvider
{

    /**
     * The policy mappings for the application.
     *
     * @var array
     */
    protected $policies = [
        'App\Model' => 'App\Policies\ModelPolicy',
    ];

    /**
     * Register any authentication / authorization services.
     *
     * @return void
     */
    public function boot()
    {
        $this->registerPolicies();

        Gate::before(function ($user) {
            if ($user->isSuperAdmin()) {
                return true;
            }
        });
        
        $pagesGate = config('pagesgate');
        
        $routeCollection = Route::getRoutes();
        foreach ($routeCollection as $route) {
            if (in_array('roles', $route->middleware())) {
                $routeName      = $route->getName();
                $routeNameParts = explode('.', $routeName);
                $pageName       = $routeNameParts[0] ?? '';
                
                if (isset($pagesGate[$pageName]['pages'])) {
                    /**
                     * In case if one controller used for many pages (e.g. configs)
                     */
                    foreach ($pagesGate[$pageName]['pages'] as $page) {
                        $params        = implode('/', $page['params']);
                        $gateRouteName = $routeName . '/' . $params;
                        
                        Gate::define($gateRouteName, function ($user) use ($gateRouteName) {
                            return $user->hasPermission($gateRouteName);
                        });
                    }
                } else {
                    Gate::define($routeName, function ($user) use ($routeName) {
                        return $user->hasPermission($routeName);
                    });
                }
            }
        }
    }
}

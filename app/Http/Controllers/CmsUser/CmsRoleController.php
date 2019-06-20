<?php

namespace App\Http\Controllers\CmsUser;

use App\Http\Controllers\Controller;
use App\Models\Cms\CmsRole;
use App\Models\Cms\CmsRolePermission;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/**
 * Class CmsRoleController
 */
class CmsRoleController extends Controller
{

    /**
     * Display a listing of the resource.
     *
     * @param Request $request Request
     *
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function index(Request $request)
    {
        $activeDirection = $request->get('direction', environment());
        $keyword = $request->get('search');
        $perPage = 25;

        if (!empty($keyword)) {
            $cmsRoles = CmsRole::where('name', 'LIKE', "%$keyword%")
                ->orWhere('description', 'LIKE', "%$keyword%")
                ->latest()
                ->paginate($perPage);
        } else {
            $cmsRoles = CmsRole::latest()->paginate($perPage);
        }

        return view('cms-role.index', compact('cmsRoles', 'activeDirection'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\View\View
     */
    public function create()
    {
        $permissions = $this->getPermissions();

        return view('cms-role.create', compact('permissions'));
    }

    /**
     * Get all available actions for access
     *
     * @return array
     */
    private function getPermissions()
    {
        $permissions     = [];
        $routeCollection = Route::getRoutes();
        $pagesGate       = config('pagesgate');

        foreach ($routeCollection as $route) {
            if (in_array('roles', $route->middleware())) {
                $routeName      = $route->getName();
                $routeNameParts = explode('.', $routeName);
                $pageName       = $routeNameParts[0] ?? '';

                $actionName = $routeNameParts[1] ?? $routeName;
                if (isset($pagesGate[$pageName])) {
                    if (isset($pagesGate[$pageName]['pages'])) {
                        foreach ($pagesGate[$pageName]['pages'] as $page) {
                            $pageName = $page['name'];
                            $params   = implode('/', $page['params']);
                            
                            $permissions['configured'][__($pageName)][$actionName] = [
                                'id'   => $routeName . '/' . $params,
                                'name' => __($actionName),
                            ];
                        }
                    } else {
                        $pageName                                              = $pagesGate[$pageName]['name'];
                        $permissions['configured'][__($pageName)][$actionName] = [
                            'id'   => $routeName,
                            'name' => __($actionName),
                        ];
                    }
                } else {
                    $permissions['unconfigured'][__($pageName)][$actionName] = [
                        'id'   => $routeName,
                        'name' => __($actionName),
                    ];
                }
            }
        }
        return $permissions;
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param Request $request Request
     *
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     */
    public function store(Request $request)
    {
        $requestData = $request->all();

        $cmsRole = CmsRole::create($requestData);

        if (!empty($request->permissions)) {
            $rolePermissions = [];
            foreach ($request->permissions as $permission) {
                $rolePermissions[] = new CmsRolePermission(['permission' => $permission]);
            }
            $cmsRole->cmsRolePermissions()->saveMany($rolePermissions);
        }

        pushNotify('success', __('CmsRole') . ' ' . __('common.action.added'));
        return redirect('cms-roles');
    }

    /**
     * Display the specified resource.
     *
     * @param integer $id Id
     *
     * @return \Illuminate\View\View
     */
    public function show(int $id)
    {
        $cmsRole = CmsRole::findOrFail($id);

        return view('cms-role.show', compact('cmsRole'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param integer $id Id
     *
     * @return \Illuminate\View\View
     */
    public function edit(int $id)
    {
        $cmsRole = CmsRole::with('CmsRolePermissions')->findOrFail($id);

        $permissions = $this->getPermissions();

        return view('cms-role.edit', compact('cmsRole', 'permissions'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param Request $request Request
     * @param integer $id      Id
     *
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     */
    public function update(Request $request, int $id)
    {
        $requestData = $request->all();

        $cmsRole = CmsRole::with('CmsRolePermissions')->findOrFail($id);
        $cmsRole->update($requestData);

        $cmsRole->cmsRolePermissions()->delete();
        if (!empty($request->permissions)) {
            $rolePermissions = [];
            foreach ($request->permissions as $permission) {
                $rolePermissions[] = new CmsRolePermission(['permission' => $permission]);
            }
            $cmsRole->cmsRolePermissions()->saveMany($rolePermissions);
        }

        pushNotify('success', __('CmsRole') . ' ' . __('common.action.updated'));
        return redirect('cms-roles');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param integer $id Id
     *
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     */
    public function destroy(int $id)
    {
        CmsRole::destroy($id);

        pushNotify('success', __('CmsRole') . ' ' . __('common.action.deleted'));
        return redirect('cms-roles');
    }
}

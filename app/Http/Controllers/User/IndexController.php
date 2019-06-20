<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Http\Requests\User\UserDebug;
use App\Models\Cms\Subtype;
use App\Models\User\User;
use App\Models\User\UserAsset;
use App\Services\CmsActionLogService;
use App\Traits\FilterBuilder;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Input;

/**
 * Class UserController
 */
class IndexController extends Controller
{
    use FilterBuilder;
    const NEIGHBORS_PER_PAGE = 10;

    /**
     * Filter fields
     */
    const FILTER_FIELDS = [
        'id'      => 'numbers',
        'name'    => 'manual',
        'email'   => 'like',
        'country' => 'equal',
        'gender'  => 'equal',
        'xp'      => 'equal',
        'cash'    => 'equal',
        'coins'   => 'equal',
    ];

    /**
     * Display a listing of the resource.
     *
     * @param Request $request Request
     *
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function index(Request $request)
    {
        $usersBuilder = User::oldest('id');
        $users        = $this->applyFilter($request, $usersBuilder)->paginate(self::RECORDS_PER_PAGE);

        $viewVars['filter']     = $this->getFilter();
        $viewVars['usersSpent'] = UsdSpent::getTotalSpent($users->pluck('id')->toArray());
        $viewVars['users']      = $users;

        return view('user.index', $viewVars);
    }

    /**
     * Apply name filter
     *
     * @param Request $request Request
     * @param mixed   $builder Builder
     *
     * @return mixed
     */
    private function applyNameFilter(Request $request, $builder)
    {
        $name = $request->get('name');

        if ($name) {
            $nameParts = explode(' ', $name);
            $builder->where(function ($q) use ($nameParts) {
                foreach ($nameParts as $namePart) {
                    $q->orWhere('first_name', 'like', "%$namePart%")->orWhere('last_name', 'like', "%$namePart%");
                }
            });
        }
        return $builder;
    }

    /**
     * Display the specified resource.
     *
     * @param integer $id ID
     *
     * @return \Illuminate\View\View
     */
    public function show(int $id)
    {
        $user = User::findOrFail($id);

        return view('user.show', compact('user'));
    }

    /**
     * Clear User cache
     *
     * @param integer $id ID
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function clearCache(int $id)
    {
        $this->clearUserCache($id);

        return $this->success([
            'message' => __('Cache was removed'),
        ]);
    }


    /**
     * Clear User cache
     *
     * @param integer $id ID
     *
     * @return boolean
     */
    private function clearUserCache(int $id)
    {
        $keys = userCache()->keys("user:$id*");
        if ($keys) {
            userCache()->del($keys);
        }
        return true;
    }

    /**
     * Update the specified resource in storage.
     *
     * @param UserDebug $request Request
     * @param integer   $id      ID
     * @param mixed     $part    Part
     *
     * @return mixed
     */
    public function update(UserDebug $request, int $id, $part)
    {
        $method = 'update' . ucfirst($part);

        if (!method_exists($this, $method)) {
            abort(403, 'Unauthorized action.');
        }
        
        $this->clearUserCache($id);

        return $this->{$method}($request, $id);
    }

    /**
     * Get part
     *
     * @param UserDebug $request Request
     * @param integer   $id      ID
     * @param mixed     $part    Part
     *
     * @return mixed
     */
    public function getPart(UserDebug $request, int $id, $part)
    {
        $method = 'get' . ucfirst($part);
        if (!method_exists($this, $method)) {
            abort(403, 'Unauthorized action.');
        }

        return $this->{$method}($request, $id);
    }

    /**
     * Update common
     *
     * @param UserDebug $request Request
     * @param integer   $id      ID
     *
     * @return \Illuminate\Http\JsonResponse
     * @throws \Throwable Bad request
     */
    private function updateCommon(UserDebug $request, int $id)
    {
        $requestData = $request->all();
        $user        = User::findOrFail($id);
        $user->update($requestData);

        return response()->json([
            'type'      => 'success',
            'container' => 'common-block',
            'data'      => $this->getCommon($id)->render(),
        ]);
    }

    /**
     * Get common
     *
     * @param integer $id ID
     *
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function getCommon(int $id)
    {
        $user = User::findOrFail($id);
        return view('user.forms.common', compact('user'));
    }

    /**
     * Update currency from list
     *
     * @param UserDebug $request Request
     * @param integer   $id      ID
     *
     * @return \Illuminate\Http\JsonResponse
     * @throws \Throwable Bad request
     */
    private function updateCurrencyFromList(UserDebug $request, int $id)
    {
        $requestData = $request->all();
        $user        = User::findOrFail($id);
        $user->update($requestData);

        return response()->json([
            'type'      => 'success',
            'container' => 'list-currency-block',
            'data'      => $this->getCurrencyFromList($id)->render(),
        ]);
    }

    /**
     * Add currency from list
     *
     * @param UserDebug $request Request
     * @param integer   $id      ID
     *
     * @return \Illuminate\Http\JsonResponse
     * @throws \Throwable Bad request
     */
    private function updateAddCurrencyFromList(UserDebug $request, int $id)
    {
        $cash  = (int) $request->get('cash');
        $coins = (int) $request->get('coins');
        $user  = User::findOrFail($id);

        if ($cash) {
            $user->increment('cash', $cash);
            CmsActionLogService::logAction('user_debug', 'cash_added', ['user' => $id, 'amount' => $cash]);
        }
        if ($coins) {
            $user->increment('coins', $coins);
            CmsActionLogService::logAction('user_debug', 'coins_added', ['user' => $id, 'amount' => $coins]);
        }



        return response()->json([
            'type'      => 'success',
            'container' => 'list-currency-block',
            'data'      => $this->getCurrencyFromList($id)->render(),
        ]);
    }

    /**
     * Get currency from list
     *
     * @param integer $id ID
     *
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function getCurrencyFromList(int $id)
    {
        $user = User::findOrFail($id);
        return view('user.list-forms.currency', compact('user'));
    }

    /**
     * Get add asset
     *
     * @param integer $id ID
     *
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function getAddAsset(int $id)
    {
        Input::flash();
        $user       = User::findOrFail($id);
        $placements = $this->getUserPlacements($id);
        return view('user.forms.add-asset', compact('user', 'placements'));
    }

    /**
     * Update add placement
     *
     * @param UserDebug $request Request
     * @param integer   $id      ID
     *
     * @return \Illuminate\Http\JsonResponse
     * @throws \Throwable Bad request
     */
    private function updateAddPlacement(UserDebug $request, int $id)
    {
        $requestData = $request->all();
        $user        = User::findOrFail($id);

        $this->addPlacement($user->id, $requestData['placement_type'], $requestData['count']);

        return response()->json([
            'type'      => 'success',
            'container' => 'add-placements-block',
            'data'      => $this->getAddPlacement($id)->render(),
        ]);
    }

    /**
     * Get add placement
     *
     * @param integer $id ID
     *
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function getAddPlacement(int $id)
    {
        $user           = User::findOrFail($id);
        $placementTypes = $this->getPlacementTypes();

        return view('user.forms.add-placement', compact('user', 'placementTypes'));
    }

    /**
     * Get placement's assets
     *
     * @param UserDebug $request Request
     * @param integer   $id      ID
     *
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function getPlacementAssets(UserDebug $request, int $id)
    {
        $placementId = $request->get('placement');

        $assets   = UserAsset::with('asset')->where(['user_id' => $id, 'placement_id' => $placementId])->get();
        $subtypes = Subtype::all()->keyBy('id');

        return view('user.forms.placement-assets', compact('assets', 'placementId', 'subtypes'));
    }

    /**
     * Soft delete user
     *
     * @param integer $id ID
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function destroy(int $id)
    {
        /**
         * Delete user from users, user_neighbors and user_news tables
         */
        User::destroy($id);

        /**
         * Clear cache
         */
        $this->clearUserCache($id);

        pushNotify('success', __('User ') . $id . __('common.action.deleted'));

        return $this->success();
    }
    
    
    /**
     * Search User Assets
     *
     * @param UserDebug $request Request
     * @param integer   $id      ID
     *
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function getSearchAssets(UserDebug $request, int $id)
    {
        $assetIds = $request->get('asset_ids');
        $assets   = [];
        if ($assetIds) {
            $assets = UserAsset::with('asset', 'placement')
                ->where(['user_id' => $id])
                ->whereIn('asset_id', $assetIds)
                ->orderBy('asset_id', 'asc')->get();
        }
        
        $subtypes = Subtype::all()->keyBy('id');

        return view('user.forms.search-assets-list', compact('assets', 'subtypes'));
    }
}

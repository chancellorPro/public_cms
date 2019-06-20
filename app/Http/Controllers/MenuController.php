<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Cms\CmsUserBookmark;
use Illuminate\Support\Facades\Cache;

/**
 * Class MenuController
 */
class MenuController extends Controller
{

    /**
     * Show the application dashboard.
     *
     * @param Request $request Request
     *
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function index(Request $request)
    {
        $layout    = $request->ajax() ? 'layouts.lightbox' : 'layouts.app';
        $container = $request->ajax() ? 'lightbox_container' : 'main_container';
        $menu      = config('menu');

        return view('menu.index', compact('layout', 'container', 'menu'));
    }

    /**
     * Edit
     *
     * @param Request $request Request
     *
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function edit(Request $request)
    {
        $bookmarks = Auth::user()->bookmarks();
        $layout    = $request->ajax() ? 'layouts.lightbox' : 'layouts.app';
        $container = $request->ajax() ? 'lightbox_container' : 'main_container';
        $menu      = config('menu');

        return view('menu.edit', compact('layout', 'container', 'menu', 'bookmarks'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param Request $request Request
     *
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     */
    public function update(Request $request)
    {
        $requestData = $request->get('menu');

        $user = Auth::user();
        if ($user->cmsUserBookmarks === null) {
            $bookmarks = new CmsUserBookmark(['bookmarks' => json_encode($requestData)]);
            $user->cmsUserBookmarks()->save($bookmarks);
        } else {
            $user->cmsUserBookmarks->update(['bookmarks' => json_encode($requestData)]);
        }
        Cache::pull('cms_user_' . $user->id . '_bookmarks');
        
        pushNotify('success', __('Bookmarks') . ' ' . __('common.action.updated'));
        return redirect('/');
    }
}

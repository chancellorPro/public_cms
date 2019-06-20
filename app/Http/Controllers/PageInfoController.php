<?php

namespace App\Http\Controllers;

use App\Http\Requests\PageInfo\PageInfoRequest;
use App\Models\Cms\PageInfo;

/**
 * Class PageInfoController
 */
class PageInfoController extends Controller
{

    /**
     * Show the form for editing the specified resource.
     *
     * @param string $route Route of the page
     *
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function edit(string $route)
    {
        $model = PageInfo::firstOrNew(['id' => $route]);
        return view('page-info.edit', [
            'model' => $model,
        ]);
    }

    /**
     * Save the information about the page
     *
     * @param PageInfoRequest $request Request
     * @param string          $route   Route of the page
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function update(PageInfoRequest $request, string $route)
    {
        $pageInfo = PageInfo::firstOrNew(['id' => $route]);
        $pageInfo->fill($request->all());
        $pageInfo->save();

        return $this->success();
    }
}

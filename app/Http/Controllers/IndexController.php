<?php

namespace App\Http\Controllers;

/**
 * Class IndexController
 */
class IndexController extends Controller
{

    /**
     * Forbidden page
     *
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function forbidden()
    {
        return view('index.forbidden');
    }
}

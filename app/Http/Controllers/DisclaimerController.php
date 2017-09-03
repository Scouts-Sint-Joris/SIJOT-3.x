<?php

namespace Sijot\Http\Controllers;

use Illuminate\Http\Request;

/**
 * Class DisclaimerController
 *
 * @package Sijot\Http\Controllers
 */
class DisclaimerController extends Controller
{
    /**
     * Get the disclaimer page.
     *
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function index()
    {
        return view('disclaimer', ['title' => 'Disclaimer']);
    }
}

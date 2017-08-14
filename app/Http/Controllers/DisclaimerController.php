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
    // TODO Complete the class docblock. 
    
    /**
     * Get the disclaimer page.
     *
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function index()
    {
        $data['title'] = 'Disclaimer';
        return view('disclaimer', $data);
    }
}

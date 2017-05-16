<?php

namespace Sijot\Http\Controllers;

use Illuminate\Http\Request;

class DisclaimerController extends Controller
{
    public function __construct()
    {
        //
    }

    public function index()
    {
        $data['title'] = 'Disclaimer';
        return view('disclaimer', $data);
    }
}

<?php

namespace Sijot\Http\Controllers;

use Illuminate\Http\Request;

/**
 * Class MemberController
 *
 * @package Sijot\Http\Controllers
 */
class MemberController extends Controller
{
    /**
     * Get the information page for a new member.
     *
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function index()
    {
        $data['title'] = 'Lid worden';
        return view('members.index', $data);
    }
}

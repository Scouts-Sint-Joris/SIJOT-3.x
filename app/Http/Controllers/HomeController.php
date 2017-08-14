<?php

namespace Sijot\Http\Controllers;

use Sijot\Activity;
use Sijot\User;
use Sijot\Events;
use Sijot\News;
use Sijot\Lease;
use Illuminate\Http\Request;

/**
 * Class HomeController
 * @package Sijot\Http\Controllers
 */
class HomeController extends Controller
{
    /**
     * @var Events
     */
    private $eventDb;

    /**
     * @var News
     */
    private $newsDb;

    /**
     * Create a new controller instance.
     *
     * @param  Events $eventDb
     * @param  News   $newsDb
     * @return void
     */
    public function __construct(News $newsDb, Events $eventDb)
    {
        $this->middleware('auth')->only('backend');
        $this->middleware('forbid-banned-user')->only('backend');

        $this->eventDb = $eventDb;
        $this->newsDb  = $newsDb;
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $data['title']  = 'Index';
        $data['events'] = $this->eventDb->limit(6)->get();
        $data['news']   = $this->newsDb->where('publish', 'Y')->paginate(15);

        return view('frontend-home', $data);
    }

    /**
     * Get the backend index page.
     *
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function backend()
    {
        $data['title']          = 'Backend';
        $data['countLease']     = Lease::count();
        $data['countUsers']     = User::count();
        $data['countNews']      = News::count();
        $data['countActivity']  = Activity::count();

        return view('backend-home', $data);
    }
}

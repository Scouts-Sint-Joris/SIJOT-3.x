<?php

namespace Sijot\Http\Controllers;

use Illuminate\Http\Request;
use Sijot\Repositories\{
    ActivityRepository, LeaseRepository, NewsRepository, UsersRepository, EventsRepository
};


/**
 * Class HomeController
 *
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
     * @param  EventsRepository $eventDb    The events database repository.
     * @param  NewsRepository   $newsDb     The news database repository.
     * @return void
     */
    public function __construct(NewsRepository $newsDb, EventsRepository $eventDb)
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
        $data['events'] = $this->eventDb->indexEvents(6);
        $data['news']   = $this->newsDb->indexNews(15);

        return view('frontend-home', $data);
    }

    /**
     * Get the backend index page.
     *
     * @param LeaseRepository    $lease      The database instance for the leases.
     * @param UsersRepository    $users      The database instance for the users.
     * @param ActivityRepository $activities The database instance for the activities.
     *
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function backend(LeaseRepository $lease, UsersRepository $users, ActivityRepository $activities)
    {
        $data['title']          = 'Backend';
        $data['countLease']     = $lease->count();
        $data['countUsers']     = $users->count();
        $data['countNews']      = $this->newsDb->count();
        $data['countActivity']  = $activities->count();

        return view('backend-home', $data);
    }
}

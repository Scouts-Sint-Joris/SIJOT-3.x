<?php

namespace App\Http\Controllers;

use App\Events;
use App\News;
use Illuminate\Http\Request;

/**
 * Class HomeController
 * @package App\Http\Controllers
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
        $data['title'] = 'Backend';
        return view('backend-home', $data);
    }
}

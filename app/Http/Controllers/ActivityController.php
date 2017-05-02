<?php

namespace App\Http\Controllers;

use App\Activity;
use App\Groups;
use Illuminate\Http\Request;

/**
 * Class ActivityController
 *
 * @package App\Http\Controllers
 */
class ActivityController extends Controller
{
    /**
     * @var Activity
     */
    private $activity;

    /**
     * @var Groups
     */
    private $groups;

    /**
     * ActivityController constructor.
     *
     * @param   Activity $activity
     * @param   Groups $groups
     * @return  void
     */
    public function __construct(Activity $activity, Groups $groups)
    {
        $routes = ['backend'];

        $this->middleware('auth')->only($routes);
        $this->middleware('forbid-banned-user')->only($routes);

        $this->activity = $activity;
        $this->groups = $groups;
    }

    /**
     * Get the backend management view for the group activities.
     *
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function backend()
    {
        $data['title']      = 'Activiteiten';
        $data['activities'] = $this->activity->paginate(20);

        return view('activity.backend-index', $data);
    }
}

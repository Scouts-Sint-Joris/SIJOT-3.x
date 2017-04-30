<?php

namespace App\Http\Controllers;

use App\Activity;
use App\Groups;
use Illuminate\Http\Request;

/**
 * Class GroupController
 *
 * @package App\Http\Controllers
 */
class GroupController extends Controller
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
     * GroupController constructor.
     *
     * @param   Activity $activity
     * @param   Groups $groups
     * @return  void
     */
    public function __construct(Activity $activity, Groups $groups)
    {
        $this->activity = $activity;
        $this->groups   = $groups;
    }

    /**
     * Get the groups index page.
     *
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function index()
    {
        $data['title']      = 'Takken';
        $data['kapoenen']   = $this->groups->getGroup('kapoenen');
        $data['welpen']     = $this->groups->getGroup('welpen');
        $data['jongGivers'] = $this->groups->getGroup('jongGivers');
        $data['givers']     = $this->groups->getGroup('givers');
        $data['jins']       = $this->groups->getGroup('jins');
        $data['leiding']    = $this->groups->getGroup('leiding');

        return view('groups.index', $data);
    }

    /**
     * Get the backend view for the groups.
     *
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function backend()
    {
        $data['title']  = 'Groepen beheer';
        $data['groups'] = $this->groups->all();

        return view('groups.backend', $data);
    }
}

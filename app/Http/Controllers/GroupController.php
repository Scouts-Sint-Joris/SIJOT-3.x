<?php

namespace Sijot\Http\Controllers;

use Sijot\{
    Activity, Groups, Repositories\ActivityRepository, Repositories\GroupRepository
};
use Sijot\Http\Requests\GroupValidator;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

/**
 * Class GroupController
 *
 * @package Sijot\Http\Controllers
 */
class GroupController extends Controller
{
    /**
     * The variable for the activity model.
     * 
     * @var ActivityRepository
     */
    private $activity;

    /**
     * The variable for the groups model. 
     * 
     * @var GroupRepository
     */
    private $groups;

    /**
     * GroupController constructor.
     *
     * @param ActivityRepository $activity The activity model for the database.
     * @param GroupRepository    $groups   The groups model for the database.
     * 
     * @return void
     */
    public function __construct(ActivityRepository $activity, GroupRepository $groups)
    {
        $routes = ['backend', 'update'];

        $this->middleware('auth')->only($routes);
        $this->middleware('forbid-banned-user')->only($routes);

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

    /**
     * Edit a group in the backend.
     *
     * @param GroupValidator $input   The user input validator
     * @param Integer        $groupId The group id in the database.
     * 
     * @return \Illuminate\Http\RedirectResponse
     */
    public function update(GroupValidator $input, $groupId)
    {
        try { // Tru to find the record in the database.
            $group = $this->groups->findOrFail($groupId);

            if ($group->update($input->except(['_token']))) { // The record has been updated.
                flash(trans('group.flash-update'));
            }

            return back();
        } catch(ModelNotFoundException $modelNotFoundException) { // Record not found in the database.
            return app()->abort(404);
        }
    }

    /**
     * Show a specific group.
     *
     * @param string $selector The group selector in the database.
     * 
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View|void
     */
    public function show($selector)
    {
        try { // To find the record.
            $data['group']      = $this->groups->findGroup($selector);
            $data['title']      = $data['group']->title;
            $data['activities'] = $this->activity->getByGroup($data['group']->id, 7);

            return view('groups.show', $data);
        } catch (ModelNotFoundException $notFoundErr) { // Could not find the record.
            return app()->abort(404);
        }
    }
}

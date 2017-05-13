<?php

namespace Sijot\Http\Controllers;

use Sijot\Activity;
use Sijot\Groups;
use Sijot\Http\Requests\ActivityValidator;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Http\Request;

/**
 * Class ActivityController
 *
 * @package Sijot\Http\Controllers
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
        $routes = ['backend', 'destroy', 'status'];

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
        $data['title'] = 'Activiteiten';
        $data['activities'] = $this->activity->with(['group'])->orderBy('activiteit_datum', 'asc')->paginate(20);
        $data['groups'] = $this->groups->where('title', '!=', 'De Leiding')->get();

        return view('activity.backend-index', $data);
    }

    /**
     * Insert a new activity in the database.
     *
     * @param  ActivityValidator $input The given user input validator.
     * @return \Illuminate\Http\RedirectResponse
     */
    public function store(ActivityValidator $input)
    {
        if ($activity = $this->activity->create($input->except(['_token']))) { // Check if the activity can be stored.
            // Activity has been stored.
            session()->flash('class', 'alert alert-success');
            session()->flash('message', "De activiteit ({$activity->title}) is opgeslagen.");
        }

        return back(302); // HTTP STATUS: REDIRECT.
    }

    /**
     * Get a specific activity in the database. And return a json array from it.
     *
     * @param  integer $activityId  The activity id in the database.
     * @return mixed
     */
    public function getByid($activityId)
    {
        try { // Try to find and output the record.
            return(json_encode($this->activity->findOrFail($activityId)));
        } catch (ModelNotFoundException $notFoundException) { // The activity is not found.
            return app()->abort(404);
        }
    }

    /**
     * Update an activity status in the database.
     *
     * @param  integer $statusId    The status id for the activity. 0 = klad, 1 = public
     * @param  integer $activityId  The database id for the activity.
     * @return mixed
     */
    public function status($statusId, $activityId)
    {
        try { // To find the activity
            $activity = $this->activity->findOrFail($activityId);

            if ($activity->update(['status' => $statusId])) { // Try to update the activity.
                // The activity has been deleted.
                session()->flash('class', 'alert alert-success');

                if ((int) $statusId === 0) {
                    session()->flash('message', "De activiteit {$activity->title} is omgezet naar een klad versie.");
                } elseif ((int) $statusId === 1) {
                    session()->flash('message', "De activiteit {$activity->title} is omgezet naar een publicatie.");
                }
            }

            return back();
        } catch (ModelNotFoundException $modelNotFoundException) { // Could not find the activity.
            return app()->abort(404);
        }
    }

    /**
     * Delete an activity out off the database.
     *
     * @param  integer $activityId The activity id in the database.
     * @return mixed
     */
    public function destroy($activityId)
    {
        try { // To find the activity
            $activity = $this->activity->findOrFail($activityId);

            if ($activity->delete()) { // Try to delete the activity.
                // Activity has been deleted
                session()->flash('class', 'alert alert-success');
                session()->flash('message', "De activititeit ({$activity->title}) is verwijderd");
            }

            return back();
        } catch (ModelNotFoundException $modelNotFoundException) { // Could not find the activity
            return app()->abort(404);
        }
    }
}

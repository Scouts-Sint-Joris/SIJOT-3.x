<?php

namespace Sijot\Http\Controllers;

use Sijot\Activity;
use Sijot\Groups;
use Sijot\Http\Requests\ActivityValidator;
use GrahamCampbell\Markdown\Facades\Markdown;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Http\Request;

/**
 * Class ActivityController
 *
 * @category Sijot-Website
 * @package  Sijot\Http\Controllers
 * @author   Tim Joosten <topairy@gmail.com>
 * @license  MIT License
 * @link     http://www.st-joris-turnhout.be
 */
class ActivityController extends Controller
{
    /**
     * The activity database model. 
     * 
     * @var Activity
     */
    private $activity;

    /**
     * The groups model variable. 
     * 
     * @var Groups
     */
    private $groups;

    /**
     * ActivityController constructor.
     *
     * @param Activity $activity The activity database model.
     * @param Groups   $groups   The groups database model.
     * 
     * @return void
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
     * Generate a json feed for the modern news readers.
     *
     * @param integer $groepId The idvan de groep in de database.
     *
     * @return \Illuminate\Http\Response
     */
    public function jsonFeed($groepId) 
    {
        $data['group']  = $this->groups->find($groepId);
        $activities     = $this->activity->where('group_id', $data['group']->id)
            ->where('activiteit_datum', '>=', date('d-m-Y'))
            ->where('status', '=', 1)
            ->orderBy('activiteit_datum', 'asc')
            ->take(7)
            ->get();

        $feed = [
            'version'       => 'https://jsonfeed.org/version/1',
            'title'         => 'Scouts en Gidsen Sint-Joris Turnhout - Activiteiten feed.',
            'home_page_url' => 'https://laravel-news.com/',
            'feed_url'      => 'https://www.st-joris-turnhout.be/feed/json',
            'icon'          => 'https://www.st-joris-turn/apple-touch-icon.png',
            'favicon'       => 'https://www.st-joris-turnhout.be/apple-touch-icon.png',
            'items'         => [], // Empty array wil be filled up with the foreach below.
        ];

        foreach ($activities as $key => $activity) {
            $feed['items'][$key] = [
                'id'            => $activity->id,
                'title'         => $activity->title,
                'url'           => route('activity.show', $activity->id),
                'content_html'  => Markdown::convertToHtml($activity->description),
                'date_created'  => $activity->created_at->tz('UTC')->toRfc3339String(),
                'date_modified' => $activity->updated_at->tz('UTC')->toRfc3339String(),
                'author' => [
                    'name' => ''
                ],
            ];
        }

        return $feed;
    } 

    /**
     * Insert a new activity in the database.
     *
     * @param ActivityValidator $input The given user input validator.
     * 
     * @return \Illuminate\Http\RedirectResponse
     */
    public function store(ActivityValidator $input)
    {
        if ($activity = $this->activity->create($input->except(['_token']))) { // Check if the activity can be stored.
            // Activity has been stored.
            session()->flash('class', 'alert alert-success');
            session()->flash('message', trans('activity.flash-store-success', ['title' => $activity->title]));
        }

        return back(302); // HTTP STATUS: REDIRECT.
    }

    /**
     * Get a specific activity in the database. And return a json array from it.
     *
     * @param integer $activityId The activity id in the database.
     * 
     * @return mixed
     */
    public function getByid($activityId)
    {
        try { // Try to find and output the record.
            return(json_encode($this->activity->findOrFail($activityId)));
        } catch (ModelNotFoundException $notFoundException) {
            return app()->abort(404); // The activity is not found.
        }
    }

    /**
     * Update an activity status in the database.
     *
     * @param integer $statusId   The status id for the activity. 0 = klad, 1 = public
     * @param integer $activityId The database id for the activity.
     * 
     * @return mixed
     */
    public function status($statusId, $activityId)
    {
        try { // To find the activity
            $activity = $this->activity->findOrFail($activityId);

            if ($activity->update(['status' => $statusId])) { // Try to update the activity.
                // The activity has been deleted.
                session()->flash('class', 'alert alert-success');

                if ((int) $statusId === 0) { // Draft
                    session()->flash('message', trans('activity.flash-status-draft', ['title' => $activity->title]));
                } elseif ((int) $statusId === 1) { // Publish
                    session()->flash('message', trans('activity.flash-status-publish', ['title' => $activity->title]));
                }
            }

            return back(302);
        } catch (ModelNotFoundException $modelNotFoundException) { // Could not find the activity.
            return app()->abort(404);
        }
    }

    /**
     * Show an specific activity from the database. 
     *
     * @param integer $activityId The activity id in the database.
     * 
     * @return mixed
     */
    public function show($activityId)
    {
        try {
            $data['activity'] = $this->activity->findOrFail($activityId);
            $data['title']    = $data['activity']->title;

            return view('activity.show', $data);
        } catch (ModelNotFoundException $modelNotFoundException) {
            return app()->abort(404);
        }
    }

    /**
     * Delete an activity out off the database.
     *
     * @param integer $activityId The activity id in the database.
     * 
     * @return mixed
     */
    public function destroy($activityId)
    {
        try { // To find the activity
            $activity = $this->activity->findOrFail($activityId);

            if ($activity->delete()) { // Try to delete the activity.
                // Activity has been deleted
                session()->flash('class', 'alert alert-success');
                session()->flash('message', trans('activity.flash-delete-success', ['title' => $activity->title]));
            }

            return back(302);
        } catch (ModelNotFoundException $modelNotFoundException) { // Could not find the activity
            return app()->abort(404);
        }
    }
}

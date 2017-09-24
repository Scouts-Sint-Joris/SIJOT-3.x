<?php

namespace Sijot\Http\Controllers;

use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Http\Response as Status;
use Sijot\Http\Requests\EventValidator;
use Sijot\Repositories\EventsRepository;

/**
 * Class EventsController
 *
 * @category SIJOT-website
 * @package  Sijot\Http\Controllers
 * @author   Tim Joosten <topairy@gmail.com>
 * @license  MIT License
 * @link     http://www.st-joris-turnhout.be
 */
class EventsController extends Controller
{
    // TODO: Translate the event titles.

    /**
     * The events database model in the application. 
     * 
     * @var Events
     */
    private $events;

    /**
     * EventsController constructor.
     *
     * @param EventsRepository $events The events database model in the application.
     */
    public function __construct(EventsRepository $events)
    {
        $routes = ['index', 'delete', 'edit'];

        $this->middleware('auth')->only($routes);
        $this->middleware('forbid-banned-user')->only($routes);

        $this->events = $events;
    }

    /**
     * Store a new event in the database.
     *
     * @param  EventValidator $input The user validation.
     * @return \Illuminate\Http\RedirectResponse
     */
    public function store(EventValidator $input)
    {
        if ($this->events->createEvent($input->except(['_token']))) { // try to create the event.
            // The event has been created in the database.
            flash(trans('events.flash-event-create'));
        }

        return back(Status::HTTP_FOUND);
    }

    /**
     * Get the backend view for the events.
     *
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function index()
    {
        $data['title'] = 'Evenementen';
        $data['events'] = $this->events->getBackendEvents(['author'], 15);

        return view('events.index', $data);
    }

    /**
     * Display a specific event in the application.
     *
     * @param integer $eventId The event id in the database.
     * 
     * @return mixed
     */
    public function show($eventId)
    {
        try { // Try to find the event in the database.
            $data['event'] = $this->events->findEvent($eventId);
            $data['title'] = $data['event']->title;

            return view('events.show', $data);
        } catch (ModelNotFoundException $modelNotFoundException) {
            return app()->abort(Status::HTTP_NOT_FOUND); // Event not found in the db.
        }
    }

    /**
     * Change the status for the event.
     *
     * @param integer $statusId The id to indicate the status for the event.
     * @param integer $eventId  The id in the database for the event.
     * 
     * @return mixed
     */
    public function status($statusId, $eventId)
    {
        try { // To find the event in the database.
            $event = $this->events->findEvent($eventId);

            if ($event->update(['status' => $statusId])) { // Try to change the status.
                // The status has been updated.
                if ((int) $statusId === 0) { // Klad
                    flash(trans('events.flash-event-draft'));
                } elseif ((int) $statusId === 1) { // Publicate
                    flash(trans('events.flash-publish'));
                }
            }

            return back(Status::HTTP_FOUND);
        } catch (ModelNotFoundException $modelNotFoundException) { // Could not find the event in the database.
            return app()->abort(Status::HTTP_NOT_FOUND);
        }
    }

    /**
     * Delete an even in the database.
     *
     * @param integer $eventId The event id in the database.
     * 
     * @return mixed
     */
    public function delete($eventId)
    {
        try {
            $event = $this->events->findEvent($eventId);

            if ($event->delete()) { // Try to delete the event.
                // The event has been deleted.
                flash(trans('events.flash-event-delete'));
            }

            return back(302);
        } catch (ModelNotFoundException $modelNotFoundException) {
            return app()->abort(404);
        }
    }

    /**
     * Get a specific event and encode it with json.
     *
     * @param  integer $eventId The id from the event in the database.
     * @return mixed
     */
    public function getById($eventId)
    {
        // TODO: Register route.

        try { // TODO: Documentation.
            return json_encode($this->events->findEvent($eventId));
        } catch (ModelNotFoundException $modelNotFoundException) { // TODO: Documentation.
            return app()->abort(404);
        }
    }

    /**
     * Edit an event in the database.
     *
     * @param EventValidator $input   The user input validator.
     * @param integer        $eventId The event id in the database.
     * 
     * @return mixed
     */
    public function edit(EventValidator $input, $eventId)
    {
        // TODO: register route.

        try {
            $event = $this->events->findEvent($eventId);

            if ($event->update($input->except(['_token']))) { // Try to update an event.
                // Event has been updated
                flash('');
            }

            return back(302);
        } catch (ModelNotFoundException $modelNotFoundException) { // Could not find the event in the database.
            return app()->abort(404);
        }
    }
}

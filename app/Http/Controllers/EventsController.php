<?php

namespace Sijot\Http\Controllers;

use Sijot\Events;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Http\Request;

/**
 * Class EventsController
 *
 * @package Sijot\Http\Controllers
 */
class EventsController extends Controller
{
    /**
     * @var Events
     */
    private $events;

    public function __construct(Events $events)
    {
        $routes = [];

        $this->middleware('auth')->only($routes);
        $this->middleware('forbid-banned-user')->only($routes);

        $this->events = $events;
    }

    public function index()
    {
        // TODO: register route.
        $data['title'] = 'Evenementen';

        return view('events.index', $data);
    }

    /**
     * Delete an even in the database.
     *
     * @param  integer $eventId The event id in the database.
     * @return mixed
     */
    public function delete($eventId)
    {
        // TODO: register route.

        try {
            $event = $this->events->findOrFail($eventId);

            if ($event->delete()) { // Try to delete the event.
                // The event has been deleted.
                session()->flash('class', 'alert alert-success');
                session()->flash('message', 'Het evenement is verwijderd');
            }

            return back(302);
        } catch (ModelNotFoundException $modelNotFoundException) {
            return app()->abort(404);
        }
    }

    public function getById($eventId)
    {
        // TODO: Register route.

        try {
            return json_encode($this->events->findOrFail($eventId));
        } catch (ModelNotFoundException $modelNotFoundException) {
            //
        }
    }

    public function edit()
    {
        // TODO: register route

        try {
            //
        } catch (ModelNotFoundException $modelNotFoundException) {
            //
        }
    }
}

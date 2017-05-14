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
        //
    }

    public function delete()
    {
        try {
            //
        } catch (ModelNotFoundException $modelNotFoundException) {
            //
        }
    }

    public function getById()
    {
        try {
            //
        } catch (ModelNotFoundException $modelNotFoundException) {
            //
        }
    }

    public function edit()
    {
        try {
            //
        } catch (ModelNotFoundException $modelNotFoundException) {
            //
        }
    }
}

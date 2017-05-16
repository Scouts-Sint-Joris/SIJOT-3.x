<?php

namespace Sijot\Http\Controllers;

use Sijot\Http\Requests\BanValidator;
use Sijot\Http\Requests\Usersvalidator;
use Sijot\Notifications\BlockNotification;
use Sijot\User;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Notification;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

/**
 * Class UsersController
 * @package Sijot\Http\Controllers
 */
class UsersController extends Controller
{
    /**
     * @var User
     */
    private $userDB;

    /**
     * @var Permission
     */
    private $permissions;

    /**
     * @var Role
     */
    private $roles;

    /**
     * UsersController constructor.
     *
     * @param   User        $userDB
     * @param   Role        $roles
     * @param   Permission  $permissions
     * @return  void
     */
    public function __construct(Role $roles, Permission $permissions, User $userDB)
    {
        $this->middleware('auth');
        $this->middleware('forbid-banned-user');

        $this->userDB      = $userDB;
        $this->roles       = $roles;
        $this->permissions = $permissions;
    }

    /**
     * Get the usermanagement backend view.
     *
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function index()
    {
        $data['title']          = 'Gebruikers beheer';
        $data['users']          = $this->userDB->paginate(25);
        $data['roles']          = $this->roles->paginate(25);
        $data['permissions']    = $this->permissions->paginate(25);

        return view('users.index', $data);
    }

    /**
     * Get the user id and name and return it in json.
     *
     * @param  int $userId The id for the user in the database.
     * @return string|void
     */
    public function getById($userId)
    {
        try { // Try to find and output the record.
            return(json_encode($this->userDB->select(['id', 'name'])->findOrFail($userId)));
        } catch (ModelNotFoundException $notFoundException) { // The user is not found.
            return app()->abort(404);
        }
    }

    /**
     * Ban a user in the system.
     *
     * @param  BanValidator $input The user input validator.
     * @return mixed
     */
    public function block(BanValidator $input)
    {
        try { // To ban the user.
            $user = $this->userDB->findOrFail($input->id);
            $user->ban(['comment' => $input->reason, 'expired_at' => Carbon::parse($input->eind_datum)]);

            $notifyUsers = $this->userDB->role('Admin')->get();
            Notification::send($notifyUsers, new BlockNotification($notifyUsers));

            session()->flash('class', 'alert alert-success');
            session()->flash('message', $user->name . 'Is geblokkeerd tot' . $input->eind_datum);

            return back();
        } catch (ModelNotFoundException $modelNotFoundException) { // Could not ban the user.
            return app()->abort(404);
        }
    }

    /**
     * Create a new login in the database.
     *
     * @param  Usersvalidator   $input  The user input validation.
     * @return \Illuminate\Http\RedirectResponse
     */
    public function store(UsersValidator $input)
    {
        // TODO: Register route.

        if ($user = $this->userDB->create($input->except(['except']))) { // Try to create the user.
            session()->flash('class', 'alert alert-success');
            session()->flash('message', 'De login is aangemaakt.');
        }

        return back(302);
    }
}

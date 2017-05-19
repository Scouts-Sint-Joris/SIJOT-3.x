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
     * Variable for the user model. 
     * 
     * @var User
     */
    private $userDB;

    /**
     * Variable for the permissions model. 
     * 
     * @var Permission
     */
    private $permissions;

    /**
     * The variable for the roles model. 
     * 
     * @var Role
     */
    private $roles;

    /**
     * UsersController constructor.
     *
     * @param User       $userDB      The user model for the database.
     * @param Role       $roles       The Roles database model.
     * @param Permission $permissions The Permissions database model.
     * 
     * @return void
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
     * @param integer $userId The id for the user in the database.
     * 
     * @return string|void
     */
    public function getById($userId)
    {
        try { // Try to find and output the record.
            return json_encode($this->userDB->select(['id', 'name'])->findOrFail($userId));
        } catch (ModelNotFoundException $notFoundException) { // The user is not found.
            return app()->abort(404);
        }
    }

    /**
     * Ban a user in the system.
     *
     * @param BanValidator $input The user input validator.
     * 
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

            return back(302);
        } catch (ModelNotFoundException $modelNotFoundException) { // Could not ban the user.
            return app()->abort(404);
        }
    }

    /**
     * Unblock some user in the system
     *
     * @param integer $userId The id for the user in the database. 
     * 
     * @return mixed
     */
    public function unblock($userId) 
    {
        try { // To find the user in the database. 
            $user = $this->userDB->findOrFail($userId);

            if ($user->isBanned()) { // The user is banned.
                $user->unban(); // Unban the user in the system

                session()->flash('class', 'alert alert-success');
                session()->flash('message', 'De gebruiker is terug geactiveerd');
            } else { // The user is not banned
                session()->flash('class', 'alert alert-danger');
                session()->flash('message', 'Wij konden de gebruiker niet activeren.');
            }

            return back(302);
        } catch (ModelNotFoundException $modelNotFoundException) {
            return app()->abort(404); // Could not find the user in the database. 
        }
    }

    /**
     * Create a new login in the database.
     *
     * @param Usersvalidator $input The user input validation.
     * 
     * @return \Illuminate\Http\RedirectResponse
     */
    public function store(UsersValidator $input)
    {
        $data['name']     = $input->name; 
        $data['email']    = $input->email;
        $data['password'] = bcrypt($input->password);

        if ($user = $this->userDB->create($data)) { // Try to create the user.
            session()->flash('class', 'alert alert-success');
            session()->flash('message', 'De login is aangemaakt.');
        }

        return back(302);
    }

    /**
     * Delete a user in the database.
     *
     * @param integer $userId The id in the database for the user. 
     * 
     * @return mixed
     */
    public function delete($userId) 
    {
        try { // To find the user in the database. 
            $user = $this->userDB->findOrfail($userId); 

            if ($user->delete()) { // try to delete the user. 
                session()->flash('class', 'alert alert-success');
                session()->flash('message', "{$user->name} Is verwijderd uit het systeem.");
            }

            return back(302);
        } catch(ModelNotFoundException $modelNotFoundException) {
            return app()->abort(404); // The given user is not found.
        }  
    }
}

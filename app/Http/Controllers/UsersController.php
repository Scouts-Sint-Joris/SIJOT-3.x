<?php

namespace App\Http\Controllers;

use App\User;
use Illuminate\Http\Request;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

/**
 * Class UsersController
 * @package App\Http\Controllers
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
}

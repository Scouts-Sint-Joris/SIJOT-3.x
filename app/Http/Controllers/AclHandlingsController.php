<?php

namespace Sijot\Http\Controllers;

use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Http\Request;
use Sijot\Permission;
use Sijot\Role;

/**
 * Class AclHandlingsController
 *
 * @package Sijot\Http\Controllers
 */
class AclHandlingsController extends Controller
{
    private $permissions;   /** @var Permission $permissions The permissions database model variable. */
    private $roles;         /** @var Role       $roles       The role database model variable. */

    /**
     * AclHandlingsController constructor.
     *
     * @param Permission $permissions   The permisson DB instance.
     * @param Role       $roles         The role DB instance.
     *
     * @return void
     */
    public function __construct(Permission $permissions, Role $roles)
    {
        $this->middleware('auth');
        $this->middleware('forbid-banned-user');

        $this->permissions = $permissions;
        $this->roles       = $roles;
    }

    /**
     * Delete a ACL role in the system.
     *
     * @param  integer $roleId The role identifier in the database.
     * @return \Illuminate\Http\RedirectResponse
     */
    public function deleteRole($roleId)
    {
        // TODO: Write phpunit test.

        try {
            $role = $this->roles->findOrFail($roleId);

            if ($role->syncPermissions([]) && $role->delete()) {
                // The role has been deleted. And The permissions relation has been cleared.
                flash('acl-flash-success-delete-role', ['name' => $role->name])->success();
            }
        } catch (ModelNotFoundException $exception) {
            flash(trans('acl.flash-error-delete-role'))->role();
        }

        return redirect()->route('users.index');
    }

    /**
     * Delete a ACL Permission in the system.
     *
     * @param  integer $permissionId The permissdentifier in the database.
     * @return \Illuminate\Http\RedirectResponse
     */
    public function deletePermission($permissionId)
    {
        // TODO: Write phpunit test.

        try {
            $permission = $this->permissions->findOrFail($permissionId);

            if ($permission->roles()->sync([]) && $permission->delete()) {
                // The permission has been deleted. And the role relation has been cleared.
                flash(trans('acl.flash-success-delete-permission', ['name' => $permission->name]))->success();
            }
        } catch (ModelNotFoundException $exception) {
            flash(trans('acl.flash-error-delete-permission'))->error();
        }

        return redirect()->route('users.index');
    }
}

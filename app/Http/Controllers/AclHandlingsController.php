<?php

namespace Sijot\Http\Controllers;

use Sijot\{Permission, Role, User};
use Sijot\Http\Requests\{PermissionValidator, RoleValidator};
use Illuminate\Http\Request;
use Illuminate\Database\Eloquent\ModelNotFoundException;

/**
 * Class AclHandlingsController
 *
 * @package Sijot\Http\Controllers
 */
class AclHandlingsController extends Controller
{
    // TODO: Convert the testing factories.
    // TODO: Build up the translation files.
    // TODO: Build up unit tests.
    // TODO: Fill in the validators.
    // TODO: Implement validation errors to the form views.

    private $permissions;   /** @var Permission $permissions The permissions database model variable.   */
    private $roles;         /** @var Role       $roles       The role database model variable.          */
    private $users;         /** @var User       $users       The user database model variable.          */

    /**
     * AclHandlingsController constructor.
     *
     * @param Permission $permissions The permisson DB instance.
     * @param Role $roles The role DB instance.
     *
     * @return void
     */
    public function __construct(Permission $permissions, Role $roles, User $users)
    {
        $this->middleware('auth');
        $this->middleware('forbid-banned-user');

        $this->permissions  = $permissions;
        $this->roles        = $roles;
        $this->users        = $users;
    }

    /**
     * Store a new permission in the system.
     *
     * @param  PermissionValidator $input The user given input.
     * @return \Illuminate\Http\RedirectResponse
     */
    public function storePermission(PermissionValidator $input)
    {
        $input->merge(['author_id' => auth()->user()->id, 'system_permission' => 'Y']);

        if ($permission = $this->permissions->create($input->except(['_token', 'roles']))) { // The permission has been created.
            flash(trans('acl.flash-success-create-permission', ['name' => $input->name]))->success();

            if (! is_null($input->roles)) { // There are roles found for the permission. We need to attach it.
                foreach ($input->roles as $value => $roleId) { // Loop through the roles.
                    $this->roles->findOrFail($roleId)->givePermissionTo($permission->name);
                }
            }
        }

        return redirect()->route('users.index');
    }

    /**
     * Store a new role in the system.
     *
     * @param  RoleValidator $input The user given input.
     * @return \Illuminate\Http\RedirectResponse
     */
    public function storeRole(RoleValidator $input)
    {
        $input->merge(['author_id' => auth()->user()->id, 'system_role' => 'Y']);

        if ($role = $this->roles->create($input->except(['_token', 'users']))) { // The role is stored.
            flash(trans('acl.flash-success-create-role', ['name' => $input->name]))->success();

            if (! is_null($input->users)) { // There are users we need to attach to the group.
                foreach ($input->users as $value => $userId) { // Loop through the given users.
                    $this->users->findOrfail($userId)->assignRole($role->name);
                }
            }
        }

        return redirect()->route('users.index');
    }



    /**
     * Update view for some acl role/permission
     *
     * @param  string  $type    The type. Is it a role or permission.
     * @param  integer $id      The id for the role/permission in the database.
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function edit($type, $id)
    {
        if ((string) $type === 'role') {
            $data['acl']   = $this->roles->findOrFail($id);
            $data['group'] = $this->permissions->all();
        } elseif((string) $type === 'permissions') {
            $data['acl']   = $this->permissions->findOrFail($id);
            $data['group'] = $this->roles->all();
        } else {
            flash(trans('acl.flash-error-edit-acl'));
            return redirect()->route('users.index');
        }

        return view('acl.edit-view', $data);
    }

    /**
     * Delete a ACL role in the system.
     *
     * @param  integer $roleId The role identifier in the database.
     * @return \Illuminate\Http\RedirectResponse
     */
    public function deleteRole($roleId)
    {
        try {
            $role = $this->roles->findOrFail($roleId);

            if ($role->syncPermissions([]) && $role->delete()) {
                // The role has been deleted. And The permissions relation has been cleared.
                flash('acl.flash-success-delete-role', ['name' => $role->name])->success();
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

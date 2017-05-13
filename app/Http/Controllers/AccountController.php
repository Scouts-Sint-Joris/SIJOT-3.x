<?php

namespace Sijot\Http\Controllers;

use Sijot\User;
use Sijot\Themes;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Storage;
use Intervention\Image\Facades\Image;
use Sijot\Http\Requests\AccountInfoValidator;
use Sijot\Http\Requests\AccountSecurityValidator;

/**
 * Class AccountController
 *
 * @package Sijot\Http\Controllers
 */
class AccountController extends Controller
{
    /**
     * @var User
     */
    private $userDb;

    /**
     * @var Themes
     */
    private $themes; 

    /**
     * AccountController constructor.
     *
     * @param  User $userDb
     * @return void
     */
    public function __construct(Themes $themes, User $userDb)
    {
        $this->middleware('auth');
        $this->middleware('forbid-banned-user');

        $this->themes = $themes;
        $this->userDb = $userDb;
    }

    /**
     * Get the user profile page.
     *
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function index()
    {
        $data['user']   = auth()->user();
        $data['title']  = $data['user']->name;
        $data['themes'] = $this->themes->all();

        return view('account.index', $data);
    }

    /**
     * Update the account information in the system. 
     * 
     * @param  AccountInfoValidator $input
     * @return \Illuminate\Http\RedirectResponse
     */
    public function updateInfo(AccountInfoValidator $input)
    {
        // TODO: BUG - the user image is nog deleted when the user applies a new image.
        //       Check if this also happends on prodcution server.

        if ((int) $input->user_id === auth()->user()->id) { // The user and the form user are identical.
            $user = $this->userDb->find($input->user_id);

            if ($user->update($input->except(['_token']))) { // The user has been changed.
                if ($input->hasFile('avatar')) { // The user has given a new avatar.
                    $avatar = public_path(auth()->user()->avatar); 

                    if (file_exists($avatar)) { // If the previous avatar exists. Delete it.
                        Storage::delete($avatar);
                    }

                    $image      = $input->file('avatar');
                    $filename   = time() . '.' . $image->getClientOriginalExtension();
                    $path       = public_path('avatars/' . $filename);

                    Image::make($image->getRealPath())->resize(160, 160)->save($path);

                    // Save the avatar path to the database.
                    $user->avatar = 'avatars/' . $filename;
                    $user->save();
                }

                session()->flash('class', 'alert alert-success'); 
                session()->flash('message', 'Uw account wachtwoord is aangepast.');
            }

            return back();
        }

        return app()->abort(404);
    }

    /**
     * Update the user password in the system.
     * 
     * @param  AccountSecurityValidator $input
     * @return \Illuminate\Http\RedirectResponse
     */
    public function updateSecurity(AccountSecurityValidator $input) 
    {
        if ((int) $input->user_id === auth()->user()->id) { // The user and the form user are identical. 
            if ($this->userDb-find($input->user_id)->update($input->except(['_token', 'password_confirmation']))) { // The user has been changed. 
                session()->flash('class', 'alert alert-success'); 
                session()->flash('message', 'Uw account wachtwoord is aangepast.');
            }

            return back();
        } 

        return app()->abort(404);
    }
}

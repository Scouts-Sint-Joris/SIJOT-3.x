<?php

namespace Sijot\Http\Controllers;

use Sijot\{User, Themes};
use Illuminate\Http\{Response as Status};
use Illuminate\Support\Facades\{Storage};
use Intervention\Image\Facades\Image;
use Sijot\Http\Requests\{AccountInfoValidator, AccountSecurityValidator};

/**
 * Class AccountController
 *
 * @category AccountController
 * @package  Sijot\Http\Controllers
 * @author   Tim Joosten <topairy@gmail.com>
 * @link     http://www.st-joris-turnhout.be
 */
class AccountController extends Controller
{
    /**
     * The user database model. 
     * 
     * @var User
     */
    private $userDb;

    /**
     * The back-end theme database model. 
     * 
     * @var Themes
     */
    private $themes; 

    /**
     * AccountController constructor.
     *
     * @param Themes $themes The themes database model.
     * @param User   $userDb The user database model.
     * 
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
        $data['title']  = auth()->user()->name;
        $data['themes'] = $this->themes->all();

        return view('account.index', $data);
    }

    /**
     * Update the account information in the system. 
     * 
     * @param AccountInfoValidator $input The user validation
     * 
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

                flash(trans('account.flash-account-info'));
            }

            return back(302);
        }

        return app()->abort(Status::HTTP_NOT_FOUND);
    }

    /**
     * Update the user password in the system.
     * 
     * @param AccountSecurityValidator $input The user input validation
     * 
     * @return \Illuminate\Http\RedirectResponse
     */
    public function updateSecurity(AccountSecurityValidator $input) 
    {
        if ((int) $input->user_id === auth()->user()->id) { 
            // The user and the form user are identical. 
            if ($this->userDb->find($input->user_id)->update($input->except(['_token', 'password_confirmation']))) { // The user has been changed.
                flash(trans('account.flash-account-password'));
            }

            return back(302);
        } 

        return app()->abort(Status::HTTP_NOT_FOUND);
    }
}

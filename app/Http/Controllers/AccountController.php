<?php

namespace App\Http\Controllers;

use App\Http\Requests\AccountInfoValidator;
use App\Http\Requests\AccountSecurityValidator;
use App\User;
use Illuminate\Http\Request;

/**
 * Class AccountController
 *
 * @package App\Http\Controllers
 */
class AccountController extends Controller
{
    /**
     * @var User
     */
    private $userDb;

    /**
     * AccountController constructor.
     *
     * @param  User $userDb
     * @return void
     */
    public function __construct(User $userDb)
    {
        $this->userDb = $userDb;
    }

    /**
     * Get the user profile page.
     *
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function index()
    {
        $data['user']  = auth()->user();
        $data['title'] = $data['user']->name;

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
        if ((int) $input->user_id === auth()->user()->id) { // The user and the form user are identical. 
            if ($this->userDb-find($input->user_id)->update($input->except(['_token']))) { // The user has been changed. 
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

<?php

namespace Sijot\Http\Controllers;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Http\Request;
use Sijot\Http\Requests\LeaseValidator;
use Sijot\Http\Requests\LeaseAdminValidator;
use Sijot\Http\Requests\NotitionValidator;
use Sijot\Repositories\LeaseAdminRepository;
use Sijot\Repositories\LeaseRepository;
use Sijot\Repositories\NotitionRepository;
use Sijot\Repositories\UsersRepository;

/**
 * Class LeaseInfoController
 *
 * @package Sijot\Http\Controllers
 */
class LeaseInfoController extends Controller
{
    private $lease;         /** Lease       $lease      The model instance for the lease database table.        */
    private $notitions;     /** Notitions   $notitions  The model instance for the notitions database table.    */
    private $users;         /** User        $users      The model instance for the users database table.        */
    private $leaseAdmin;    /** LeaseAdmin  $leaseAdmin The model instance for the lease admin database table.  */

    /**
     * LeaseInfoController constructor.
     *
     * @param  LeaseRepository        $lease      The lease database instance.
     * @param  NotitionRepository     $notitions  The lease notition database instance.
     * @param  UsersRepository        $users      The user database instance.
     * @param  LeaseAdminRepository   $leaseAdmin The leaseAdmin database instance.
     * @return void
     */
    public function __construct(LeaseRepository $lease, NotitionRepository $notitions, UsersRepository $users, LeaseAdminRepository $leaseAdmin)
    {
        $this->middleware('auth');
        $this->middleware('forbid-banned-user');

        $this->lease        = $lease;
        $this->notitions    = $notitions;
        $this->users        = $users;
        $this->leaseAdmin   = $leaseAdmin;
    }

    /**
     * Show a specific domain lease.
     *
     * @param  integer $id The primary key for the lease record in the system.
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function show($id)
    {
        try { // To find the lease in the system.
            $data['lease']   = $this->lease->with(['notitions.author', 'opener', 'afsluiter'])->findOrFail($id);
            $data['persons'] = $this->users->role('verhuur')->get(); 
            
            return view('lease.info.show', $data);
        } catch (ModelNotFoundException $exception) {
            flash("Wij konden de verhuring niet vinden in het systeem.")->warning();
            return redirect()->back(302);
        }
    }

    /**
     * Update the lease information in the database.
     *
     * @param  LeaseValidator $input The user given input.
     * @param  integer        $id    The primary key from the lease in the database.
     * @return \Illuminate\Http\RedirectResponse
     */
    public function update(LeaseValidator $input, $id)
    {
        try {
            $lease = $this->lease->findOrFail($id);

            $data                = $input->all();
            $data['start_datum'] = (new Carbon($data['start_datum']))->format('Y-m-d H:i:s');   //! Convertor because MySQL errors on EU format.
            $data['eind_datum']  = (new Carbon($data['eind_datum']))->format('Y-m-d H:i:s');    //! Convertor because MySQL errors on EU format.

            if ($lease->update($data)) {
                flash('De informatie omtrent de verhuring is aangepast.')->success();
            }
            
            return redirect()->route('lease.info.show', ['id' => $id]);
        } catch (ModelNotFoundException $exception) {
            flash('Wij konden de informatie omtrent de verhuringen niet vinden.')->error();
            return redirect()->route('lease.backend');
        }
    }

    /**
     * Store a new lease admin in the system. 
     * 
     * @param  LeaseAdminValidator $input The user given input. 
     * @return \Illuminate\Http\RedirectResponse
     */
    public function addAdminPerson(LeaseAdminValidator $input) 
    {        
        if ($this->leaseAdmin->create($input->all())) {
            $user = $this->users->findOrfail($input->persons_id);

            if (! $user->hasRole('verhuur')) { //! The user don't have the needed role. So attach it.
                $user->assignRole('verhuur');  //! The role is now attached.
            }

            flash("{$user->name} Heeft nu de nodige bevoegdheid voor de verhuur.")->success();
        }

        return redirect()->route('lease.backend');
    }

    /**
     * Delete the lease admin in the system.
     *
     * @param  integer $recordId The primary key for the user in the database.
     * @return \Illuminate\Http\RedirectResponse
     */
    public function deleteAdminPerson($recordId) 
    {
        try { //? To find the record in the database. 
            $data['admin'] = $this->leaseAdmin->findOrFail($recordId);
            $data['user']  = $this->users->findOrFail($data['admin']->persons_id);

            if ($data['admin']->delete()) {                 //! The administrator record has been deleted. 
                if ($data['user']->hasRole('verhuur')) {    //! Check if user has the 'verhuur' role
                    $data['user']->removeRole('verhuur');   //! Remove the 'verhuur' role.
                }

                flash("{$data['user']->name} is verwijderd als verhurings administrator.");
            }

            return redirect()->route('lease.backend');
        } catch (ModelNotFoundException $exception) { //! Can't find the record in the database. 
            flash('Wij konden de verhuur administrator niet vinden in het systeem.')->error();
            return redirect()->route('lease.backend');
        }
    }

    /**
     * Delete a lease notition in the system.
     *
     * @param  integer $notitionId  The notition id in the database.
     * @param  integer $leaseId     The lease id in the database.
     * @return \Illuminate\Http\RedirectResponse
     */
    public function deleteNotition($notitionId, $leaseId)
    {
        try { // To find the notition in the database.
            $notition = $this->notitions->findOrFail($notitionId);

            if ($notition->delete()) {
                $notition->lease()->detach($leaseId); // Remove the data in the relation pivot table.
                flash('De notitie is verwijderd.');
            }

            return redirect()->route('lease.info.show', $leaseId);
        } catch (ModelNotFoundException $exception) { // Not found.
            flash('Wij konden de handeling niet uitvoeren')->warning();
            return redirect()->route('lease.backend');
        }
    }

    /**
     * Add notition to the given lease.
     *
     * @param  NotitionValidator $input The given user input.
     * @return \Illuminate\Http\RedirectResponse
     */
    public function addNotition(NotitionValidator $input)
    {
        $input->merge(['author_id' => auth()->user()->id]);

        if ($note = $this->notitions->create($input->all())) {
            flash('De notitie is opgeslagen')->success();

            //! This is palced below the flash messqage. Because it give an error on the test
            //! In a strange way. | TODO: Need to investigate this one.
            $this->lease->findOrFail($input->lease_id)->notitions()->attach($note->id);
        }

        return redirect()->route('lease.info.show', ['id' => $input->lease_id]);
    }
}

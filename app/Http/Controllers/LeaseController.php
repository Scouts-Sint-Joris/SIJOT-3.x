<?php

namespace App\Http\Controllers;

use App\Http\Requests\LeaseValidator;
use App\Lease;
use App\Mail\LeaseInfoRequester;
use App\Mail\LeaseInfoAdmin;
use App\User;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use Maatwebsite\Excel\Facades\Excel;

/**
 * Class LeaseController
 *
 * @package App\Http\Controllers
 */
class LeaseController extends Controller
{
    /**
     * @var Lease
     */
    private $leaseDB;

    /**
     * @var User
     */
    private $userDB;

    /**
     * LeaseController constructor
     *
     * @param  Lease $leaseDB
     * @param  User $userDB
     * @return void
     */
    public function __construct(Lease $leaseDB, User $userDB)
    {
        $routes = ['backend', 'status'];

        $this->middleware('auth')->only($routes);
        $this->middleware('forbid-banned-user')->only($routes);

        $this->leaseDB = $leaseDB;
        $this->userDB = $userDB;
    }

    /**
     * Get the index vor the domain lease.
     *
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function index()
    {
        $data['title'] = 'Verhuur';
        return view('lease.index', $data);
    }

    /**
     * Get the lease calendar view.
     *
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function calendar()
    {
        $data['title']  = 'Verhuur kalender.';
        $data['leases'] = $this->leaseDB->where('status_id', 3)->paginate(15);

        return view('lease.calendar', $data);
    }

    /**
     * Get the front-end view for a domain lease request. 
     *
     * @return  \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function leaseRequest()
    {
        $data['title'] = 'Verhuur aanvragen';
        return view('lease.request', $data);
    }

    /**
     * Store the lease request in the db.
     *
     * @param   LeaseValidator $input The user input validator.
     * @return  \Illuminate\Http\RedirectResponse
     */
    public function store(LeaseValidator $input)
    {
        if ($this->leaseDB->create($input->except('_token'))) { // The rental has been inserted.
            if (auth()->check()) { // Requester is logged in
                session()->flash('class', 'alert alert-success');
                session()->flash('message', 'De verhuring is toegevoegd.');
            } else { // Requester is not logged in.
                $when = Carbon::now()->addMinutes(15); // Needed to look your queued email.
                Mail::to($input->contact_email)->send(new LeaseInfoRequester($input->all()));

                // Start mailing to Admins and persons responsible for leases. 
                $adminUsers = $this->userDB->role('Admin')->get();
                $leaseUsers = $this->userDB->role('Verhuur')->get();

                foreach ($adminUsers as $admin) { // Send email notification to all the admins. 
                    Mail::to($admin->email)->send(new LeaseInfoAdmin($input->all()));
                }

                foreach ($leaseUsers as $lease) { // Set email to all persons responsibel for domain leases.
                    Mail::to($lease->email)->send(new LeaseInfoAdmin($input->all()));
                }

                // Set flash session output.
                session()->flash('class', 'alert alert-success');
                session()->flash('message', 'De verhuring is toegevoegd. We nemen spoedig contact met je op.');
            }
        }

        return back();
    }

    /**
     * Get the domain access page.
     *
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function domainAccess()
    {
        $data['title'] = 'Bereikbaarheid domein';
        return view('lease.access', $data);
    }

    /**
     * Change the lease status in the database.
     *
     * @param  string   $status     The new lease status.
     * @param  integer  $leaseId    The database id for the lease
     * @return \Illuminate\Http\RedirectResponse|void
     */
    public function status($status, $leaseId)
    {
        try { // Check if the record exists.
            $lease = $this->leaseDB->findOrFail($leaseId);

            switch ($status) {
                case 'nieuwe':      $status = 1; break;
                case 'optie':       $status = 2; break;
                case 'bevestigd':   $status = 3; break;
            }

            if ($lease->update(['status_id' => $status])) {
                session()->flash('class', 'alert alert-success');
                session()->flash('message', 'De verhuur is aangepast.');
            }

            return back();
        } catch (ModelNotFoundException $exception) { // The record doesn't exists
             return app()->abort(404);
        }
    }

    /**
     * Remove a leae in the database.
     *
     * @param  intger   $leaseId    The databaseid for the lease.
     * @return \Illuminate\Http\RedirectResponse|void
     */
    public function delete($leaseId)
    {
        try { // Check if the record exists
            if ($this->leaseDB->findOrFail($leaseId)->delete()) { // The lease has been deleted.
                session()->flash('class', 'alert alert-success');
                session()->flash('message', 'De verhuring is verwijderd.');
            }

            return back();
        } catch (ModelNotFoundException $exception) { // The record doesn't exists.
            return app()->abort(404);
        }
    }

    /**
     * Get the lease management view.
     *
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function backend()
    {
        $data['title']  = 'Verhuur beheer';
        $data['leases'] = $this->leaseDB->paginate(15);

        return view('lease.lease-backend', $data);
    }

    /**
     * Export the domain leases to a excel file.
     *
     * @return void
     */
    public function export()
    {
        Excel::create('Verhuringen', function ($excel) {
           $excel->sheet('Verhuringen', function ($sheet) {
               $all = $this->leaseDB->all();
               $sheet->loadView('lease.export', compact('all'));
           });
        })->export('xls');
    }
}

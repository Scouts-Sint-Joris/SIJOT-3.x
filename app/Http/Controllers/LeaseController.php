<?php

namespace App\Http\Controllers;

use App\Http\Requests\LeaseValidator;
use App\Lease;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Http\Request;
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
     * LeaseController constructor
     * .
     * @param  Lease $leaseDB
     * @return void
     */
    public function __construct(Lease $leaseDB)
    {
        $routes = ['backend', 'status'];

        $this->middleware('auth')->only($routes);
        $this->middleware('forbid-banned-user')->only($routes);

        $this->leaseDB = $leaseDB;
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
        // TODO: set notifiers

        if ($this->leaseDB->create($input->except('_token'))) { // The rental has been inserted.
            if (auth()->check()) { // Requester is logged in

            } else { // Requester is not logged in.

            }

            // Set flash session output.
            session()->flash('class', 'alert alert-success');
            session()->flash('message', 'De verhuring is toegevoegd. We nemen spoedig contact met je op.');
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

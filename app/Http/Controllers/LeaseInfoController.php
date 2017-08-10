<?php

namespace Sijot\Http\Controllers;

use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Http\Request;
use Sijot\Lease;

/**
 * Class LeaseInfoController
 *
 * @package Sijot\Http\Controllers
 */
class LeaseInfoController extends Controller
{
    private $lease; /** Lease $lease The model instance for the lease database table. */

    /**
     * LeaseInfoController constructor.
     *
     * @param  Lease $lease The lease database instance.
     * @return void
     */
    public function __construct(Lease $lease)
    {
        $this->middleware('auth');
        $this->middleware('forbid-banned-user');

        $this->lease = $lease;
    }

    /**
     * @param $id
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function show($id)
    {
       try { // To find the lease in the system.
           $data['lease'] = $this->lease->with(['notitions'])->findOrFail($id);
           return view('lease.info.show', $data);
       } catch (ModelNotFoundException $exception) {
            flash("Wij konden de verhuring niet vinden in het systeem.");
            return redirect()->back(302);
       }
    }
}

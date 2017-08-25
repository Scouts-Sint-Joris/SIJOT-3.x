<?php

namespace Sijot\Http\Controllers\ApiV1;

use Chrisbjr\ApiGuard\Http\Controllers\ApiGuardController;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Http\{Request, Response};
use Sijot\Http\Requests\LeaseValidator;
use Sijot\Http\Transformers\LeaseTransformer;
use Sijot\Repositories\LeaseRepository;

/**
 * Class LeaseController
 *
 * @package Sijot\Http\Controllers\ApiV1
 */
class LeaseController extends ApiGuardController
{
    /**
     * @var LeaseRepository
     */
    private $leaseRepository;

    /**
     * LeaseController constructor.
     *
     * @param LeaseRepository $leaseRepository
     */
    public function __construct(LeaseRepository $leaseRepository)
    {
        parent::__construct();
        $this->leaseRepository = $leaseRepository;
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Contracts\Routing\ResponseFactory
     */
    public function index()
    {
        return $this->response->withPaginator(
            $this->leaseRepository->paginate(25), new LeaseTransformer
        );
    }

    /**
     * Display the specified resource.
     *
     * @param  integer $leaseId The id for the wnated lease.
     * @return \Illuminate\Http\Response
     */
    public function show($leaseId)
    {
        try {
            $lease = $this->leaseRepository->findOrFail($leaseId);

            return $this->response->withItem($lease, new LeaseTransformer);
        } catch (ModelNotFoundException $exception) {
            return $this->response->errorNotFound();
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  integer $leaseId
     * @return \Illuminate\Contracts\Routing\ResponseFactory|mixed
     */
    public function destroy($leaseId)
    {
        try {
            $this->leaseRepository->findOrFail($leaseId)->delete();

            return $this->response->withArray([
                'error' => [
                    'code'      => 'GEN-NOT-FOUND',
                    'http_code' => Response::HTTP_NO_CONTENT,
                    'message'   => 'The resource has been successfully deleted.'
                ]
            ]);
        } catch (ModelNotFoundException $exception) {
            return $this->response->errorNotFound();
        }
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  Request|LeaseValidator $request
     * @return \Illuminate\Contracts\Routing\ResponseFactory
     */
    public function store(LeaseValidator $request)
    {
        $this->leaseRepository->create($request->all());

        return $this->response->withArray([

        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }
}

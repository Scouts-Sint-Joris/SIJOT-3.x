<?php

namespace Sijot\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Sijot\Http\Requests\ApiKeyValidator;
use Sijot\Repositories\ApiKeyRepository;

/**
 * Class ApiKeyController
 *
 * @package Sijot\Http\Controllers
 */
class ApiKeyController extends Controller
{
    /**
     * The apik ey eloquent database layer.
     *
     * @var ApiKeyRepository
     */
    private $apiKeyRepository;

    /**
     * ApiKeyController constructor.
     *
     * @param ApiKeyRepository $apiKeyRepository
     */
    public function __construct(ApiKeyRepository $apiKeyRepository)
    {
        $this->middleware('auth');
        $this->middleware('acl-role:admin');

        $this->apiKeyRepository = $apiKeyRepository;
    }

    /**
     * @todo Implement docblock.
     */
    public function index()
    {
        // TODO: Implement controller logic.
    }

    /**
     * Create a new api key in the system.
     *
     * @param  ApiKeyValidator $input
     * @return \Illuminate\Http\RedirectResponse
     */
    public function makeKey(ApiKeyValidator $input)
    {
        if ($apiKey = $this->apiKeyRepository->createKey($input->service)) {
            flash("De api sleutel: {$apiKey} is aangemaakt.")->success();
            session()->flash('tab-status', 'api-key');
        }

        return redirect()->route('account');
    }

    /**
     * Delete a api key in the system.
     *
     * @param  integer $keyId The primary key in the database from the key.
     * @return \Illuminate\Http\RedirectResponse
     */
    public function deleteKey($keyId)
    {
        if ($this->apiKeyRepository->canDeleteApiKey(auth()->user(), $keyId)) {  // 1) Permission check before delete
            if ($this->apiKeyRepository->keyExist($keyId) === 1) {               // 2) The api key is found.
                if ($this->apiKeyRepository->delete($keyId)) {                   // 3) API KEY === Deleted
                    flash("De API sleutel is verwijderd.")->success();
                    session()->flash('tab-status', 'api-key');
                }
            }

            return redirect()->route('account');
        }

        // The user hasn't the right permissions.
        return app()->abort(Response::HTTP_FORBIDDEN);
    }
}

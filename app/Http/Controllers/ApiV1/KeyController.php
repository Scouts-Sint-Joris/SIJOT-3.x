<?php

namespace Sijot\Http\Controllers\ApiV1;

use Chrisbjr\ApiGuard\Http\Controllers\ApiGuardController;
use Illuminate\Http\Request;
use Sijot\Http\Controllers\Controller;
use Sijot\Repositories\ApiKeyRepository;

class KeyController extends ApiGuardController
{
    private $apiKeyRepository;

    public function __construct(ApiKeyRepository $apiKeyRepository)
    {
        $this->apiKeyRepository = $apiKeyRepository;
    }

    public function store()
    {

    }

    public function destroy()
    {

    }
}

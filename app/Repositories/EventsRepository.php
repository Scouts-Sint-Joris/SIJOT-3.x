<?php 

namespace Sijot\Repositories;

use ActivismeBE\DatabaseLayering\Repositories\Contracts\RepositoryInterface;
use ActivismeBE\DatabaseLayering\Repositories\Eloquent\Repository;
use Sijot\Events;

/**
 * Class EventsRepository
 *
 * @package Sijot\Repositories
 */
class EventsRepository extends Repository
{

    /**
     * @return string
     */
    public function model()
    {
        return Events::class;
    }

    public function addRecord($data)
    {
        if ($this->create($data)) {
            return true;
        }

        return false;
    }
}
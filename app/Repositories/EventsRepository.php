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
     * Set the eloquent model class for the repository.
     *
     * @return Events|string
     */
    public function model()
    {
        return Events::class;
    }

    /**
     * Find an event in the database based on the primary key.
     *
     * @param  integer $eventId The auto increment (PK) record id form the database.
     * 
     * @return mixed
     */
    public function findEvent($eventId)
    {
        return $this->findOrFail($eventId);
    }

    /**
     * Create a new event in the database.
     * 
     * @param  array $input The given user input.
     * @return bool
     */
    public function createEvent(array $input) 
    {
        if ($this->create($input)) {
            return true; //* The event has been created.
        }

         return false; //! The event could not created. 
    }

    public function getBackendEvents($relations, $perPage)
    {
        return $this->with($relations)->paginate($perPage);
    }

    public function addRecord($data)
    {
        if ($this->create($data)) {
            return true;
        }

        return false;
    }
}
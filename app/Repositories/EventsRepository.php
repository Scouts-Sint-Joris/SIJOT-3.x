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
     * Paginate the events for the index page.
     *
     * @param  integer $limit The amount of events u want per page.
     * @return \Illuminate\Database\Eloquent\Collection|static[]
     */
    public function indexEvents($limit)
    {
        return $this->model->limit($limit)->get();
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

    /**
     * GYet all the events for the backend.
     *
     * @param  array   $relations The database relations u want to use.
     * @param  integer $perPage   The amount of events u want to display per page.
     * @return mixed
     */
    public function getBackendEvents($relations, $perPage)
    {
        return $this->with($relations)->paginate($perPage);
    }

    /**
     * Store a new event in the database.
     *
     * @param  string $data The input data for the new event.
     * @return bool
     */
    public function addRecord($data)
    {
        if ($this->create($data)) {
            return true;
        }

        return false;
    }
}
<?php 

namespace Sijot\Repositories;

use ActivismeBE\DatabaseLayering\Repositories\Contracts\RepositoryInterface;
use ActivismeBE\DatabaseLayering\Repositories\Eloquent\Repository;
use Sijot\Lease;

/**
 * Class LeaseRepository
 *
 * @package Sijot\Repositories
 */
class LeaseRepository extends Repository
{
    /**
     * Set the eloquent model class for the repository.
     *
     * @return string
     */
    public function model()
    {
        return Lease::class;
    }
}
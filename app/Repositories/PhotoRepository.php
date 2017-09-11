<?php 

namespace Sijot\Repositories;

use ActivismeBE\DatabaseLayering\Repositories\Contracts\RepositoryInterface;
use ActivismeBE\DatabaseLayering\Repositories\Eloquent\Repository;
use Sijot\Photos;

/**
 * Class PhotoRepository
 *
 * @package Sijot\Repositories
 */
class PhotoRepository extends Repository
{
    /**
     * Set the eloquent model class for the repository.
     *
     * @return string
     */
    public function model()
    {
        return Photos::class;
    }
}
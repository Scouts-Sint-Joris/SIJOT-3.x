<?php 

namespace Sijot\Repositories;

use ActivismeBE\DatabaseLayering\Repositories\Contracts\RepositoryInterface;
use ActivismeBE\DatabaseLayering\Repositories\Eloquent\Repository;
use Sijot\User;

/**
 * Class UsersRepository
 *
 * @package Sijot\Repositories
 */
class UsersRepository extends Repository
{
    /**
     * Set the eloquent model class for the repository.
     *
     * @return string
     */
    public function model()
    {
        return User::class;
    }

    /**
     * Cocunt all the users in the database.
     *
     * @return integer
     */
    public function count()
    {
        return $this->model->count();
    }

    /**
     * Find a user in the database based on their id.
     *
     * @param  integer $userId The id from the user in the database.
     * @return \Illuminate\Database\Eloquent\Collection|\Illuminate\Database\Eloquent\Model
     */
    public function findUser($userId)
    {
        return $this->model->select(['id', 'name'])->findOrFail($userId);
    }
}
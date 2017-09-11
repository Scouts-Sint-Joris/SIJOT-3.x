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

    public function count()
    {
        return $this->model->count();
    }

    public function findUser($userId)
    {
        return $this->model->select(['id', 'name'])->findOrFail($userId);
    }
}
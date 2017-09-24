<?php 

namespace Sijot\Repositories;

use ActivismeBE\DatabaseLayering\Repositories\Contracts\RepositoryInterface;
use ActivismeBE\DatabaseLayering\Repositories\Eloquent\Repository;
use Sijot\Groups;

/**
 * Class GroupRepository
 *
 * @package Sijot\Repositories
 */
class GroupRepository extends Repository
{
    /**
     * Set the eloquent model class for the repository.
     *
     * @return string
     */
    public function model()
    {
        return Groups::class;
    }

    /**
     * The scope used for getting groups.
     *
     * @param  string $selector The where criteria
     * @return mixed
     */
    public function getGroup($selector)
    {
        return $this->model->where('selector', $selector)->first();
    }

    /**
     * Find a group based on their selector.
     *
     * @param  string $selector The selector in the database where u want to look for.
     * @return \Illuminate\Database\Eloquent\Model|static
     */
    public function findGroup($selector)
    {
        return $this->model->where('selector', $selector)->firstOrFail();
    }
}
<?php 

namespace Sijot\Repositories;

use ActivismeBE\DatabaseLayering\Repositories\Contracts\RepositoryInterface;
use ActivismeBE\DatabaseLayering\Repositories\Eloquent\Repository;
use Sijot\Activity;

/**
 * Class ActivityRepository
 *
 * @package Sijot\Repositories
 */
class ActivityRepository extends Repository
{
    /**
     * Set the eloquent model class for the repository.
     *
     * @return string
     */
    public function model()
    {
        return Activity::class;
    }

    /**
     * Count all the activities in the database.
     *
     * @return integer
     */
    public function count()
    {
        return $this->model->count();
    }

    /**
     * Get all the activities spacified by the given group id.
     *
     * @param  integer $groupId The id for the group in the database.
     * @param  integer $limit   The limit of activities u want to display.
     * @return \Illuminate\Database\Eloquent\Collection|\Illuminate\Support\Collection|static[]
     */
    public function getByGroup($groupId, $limit)
    {
        return $this->model->where('group_id', $groupId)
            ->where('activiteit_datum', '>=', date('d-m-Y'))
            ->where('status', '=', 1)
            ->orderBy('activiteit_datum', 'asc')
            ->take($limit)
            ->get();
    }
}
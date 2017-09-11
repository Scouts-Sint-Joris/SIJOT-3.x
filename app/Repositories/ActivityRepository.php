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

    public function count()
    {
        return $this->model->count();
    }

    public function getByGroup($id, $limit)
    {
        return $this->model->where('group_id', $id)
            ->where('activiteit_datum', '>=', date('d-m-Y'))
            ->where('status', '=', 1)
            ->orderBy('activiteit_datum', 'asc')
            ->take($limit)
            ->get();
    }
}
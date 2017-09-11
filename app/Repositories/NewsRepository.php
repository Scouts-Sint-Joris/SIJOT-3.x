<?php 

namespace Sijot\Repositories;

use ActivismeBE\DatabaseLayering\Repositories\Contracts\RepositoryInterface;
use ActivismeBE\DatabaseLayering\Repositories\Eloquent\Repository;
use Sijot\News;

/**
 * Class NewsRepository
 *
 * @package Sijot\Repositories
 */
class NewsRepository extends Repository
{
    /**
     * @return string
     */
    public function model()
    {
        return News::class;
    }

    /**
     * Paginate the news for the index page.
     *
     * @param  integer $perPage The results u want per page.
     * @return \Illuminate\Contracts\Pagination\LengthAwarePaginator
     */
    public function indexNews($perPage)
    {
        return $this->model->where('publish', 'Y')->paginate($perPage);
    }

    public function count()
    {
        return $this->model->count();
    }
}
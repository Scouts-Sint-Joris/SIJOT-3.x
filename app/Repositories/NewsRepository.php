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
}
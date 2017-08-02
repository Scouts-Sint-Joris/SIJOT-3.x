<?php 

namespace Sijot\Repositories;

use Sijot\Categories;
use ActivismeBE\DatabaseLayering\Repositories\Eloquent\Repository as DatabaseMethods;
use ActivismeBE\DatabaseLayering\Repositories\Contracts\RepositoryInterface;

/**
 * Class CategoryRepository
 *
 * @package Sijot\Repositories
 */
class CategoryRepository extends DatabaseMethods
{
    /**
     * Initialize the database model.
     *
     * @return string
     */
    public function model()
    {
        return Categories::class;
    }

    /**
     * Store a new category in the database.
     *
     * @param  array $data The input data form the form.
     * @return bool
     */
    public function storeDb(array $data)
    {
        if ($this->create($data)) {
            return true; // The data bas been stored in the database.
        }

        return false; // Data hasn't stored in to the database.
    }

    /**
     * Find a specific record in the database table.
     *
     * @param  integer $categoryId  The database Primary Key for the data row.
     * @return mixed
     */
    public function findRecord($categoryId)
    {
        // NOTE: A database is used because there is not DatabaseMethod for find or fail.
        // SEE:  https://github.com/CPSB/ActivismeBE-database-layering/issues/29
        return Categories::findOrFail($categoryId);
    }

    /**
     * Delete some category out off the system.
     *
     * @param  integer $categoryId  The database Primary Key for the data row.
     * @return bool
     */
    public function deleteRecord($categoryId)
    {
        $category = $this->findRecord($categoryId);

        if ($this->delete($categoryId)) {
            $category->news()->sync([]); // Detach category form the news items.
            return true; // DELETE = OK
        }

        return false; // DELETE = NOK
    }
}
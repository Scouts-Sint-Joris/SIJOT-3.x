<?php

namespace Sijot\Http\Controllers;

use Illuminate\Database\Eloquent\ModelNotFoundException;
use Sijot\Categories;
use Sijot\Http\Requests\CategoryValidator;
use Illuminate\Http\Request;

/**
 * Class CategoryController
 *
 * @package Sijot\Http\Controllers
 */
class CategoryController extends Controller
{
    /**
     * @var Categories
     */
    private $categories;

    /**
     * CategoryController constructor.
     *
     * @param Categories $categories
     */
    public function __construct(Categories $categories)
    {
        $this->middleware('auth');
        $this->middleware('forbid-banned-user');

        $this->categories = $categories;
    }


    /**
     * Store a new category in the database.
     *
     * @param  CategoryValidator $input The user input validator.
     * @return \Illuminate\Http\RedirectResponse
     */
    public function insert(CategoryValidator $input)
    {
        if ($this->categories->create($input->all())) { // Try to insert a new category.
            // The category has been inserted.
            session()->flash('class', 'alert alert-success');
            session()->flash('message', 'De categorie is toegevoegd.');
        }

        return back(302);
    }

    /**
     * Get a category and encode it with json.
     *
     * @param  integer $categoryId
     * @return mixed
     */
    public function getById($categoryId)
    {
        // TODO: register route.

        try { // To find the category in the database.
            return(json_encode($this->categories->findOrFail($categoryId)));
        } catch (ModelNotFoundException $modelNotFoundException) { // Could not found the record in the database.
            return app()->abort(404);
        }
    }

    /**
     * Edit an category in the database.
     *
     * @param  CategoryValidator $input
     * @return mixed
     */
    public function edit(CategoryValidator $input)
    {
        // TODO register route

        try {
            $category = $this->categories->findOrfail($input->categoryId);

            if ($category->update($input->except(['_token']))) { // Try to edit the category.
                // The record has been updated.
                session()->flash('class', 'alert alert-succss');
                session()->flash('message', 'De category is aangepast');
            }

            return back(302);
        } catch (ModelNotFoundException $modelNotFoundException) { // Could not find the category in the database.
            return app()->abort(404);
        }
    }

    /**
     * Remove a category in the database.
     *
     * @param  integer $categoryId  The category id in the database.
     * @return mixed
     */
    public function destroy($categoryId)
    {
        try { // To find the category in the database
            $category = $this->categories->findOrFail($categoryId);

            if ($category->delete() && $category->news()->sync([])) { // Try to delete the category.
                // Category has been deleted.
                session()->flash('class', 'alert alert-success');
                session()->flash('message', 'De category is verwijderd');
            }

            return back();
        } catch (ModelNotFoundException $modelNotFoundException) { // Could not find the category in the database.
            return app()->abort(404);
        }
    }
}

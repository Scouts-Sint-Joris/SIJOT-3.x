<?php

namespace Sijot\Http\Controllers;

use Illuminate\Database\Eloquent\ModelNotFoundException;
use Sijot\Categories;
use Sijot\Http\Requests\CategoryValidator;
use Illuminate\Http\Request;

/**
 * Class CategoryController
 *
 * @category SIJOT-platform
 * @package  Sijot\Http\Controllers
 * @author   Tim Joosten <Topairy@gmail.com>
 * @license  MIT License
 * @link     http://www.st-joris-turnhout.be
 */
class CategoryController extends Controller
{
    /**
     * The categories model variable. 
     * 
     * @var Categories
     */
    private $categories;

    /**
     * CategoryController constructor.
     *
     * @param Categories $categories The categories model.
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
     * @param CategoryValidator $input The user input validator.
     * 
     * @return \Illuminate\Http\RedirectResponse
     */
    public function insert(CategoryValidator $input)
    {
        if ($this->categories->create($input->all())) { // Try to insert a new category.
            flash(trans('category.flash-insert'))->success();
        }

        return back(302);
    }

    /**
     * Get a category and encode it with json.
     *
     * @param integer $categoryId The category id in the database.
     * 
     * @return mixed
     */
    public function getById($categoryId)
    {
        try { // To find the category in the database.
            return(json_encode($this->categories->findOrFail($categoryId)));
        } catch (ModelNotFoundException $modelNotFoundException) { // Could not found the record in the database.
            return app()->abort(404);
        }
    }

    /**
     * Edit an category in the database.
     *
     * @param CategoryValidator $input The input validator data
     * 
     * @return mixed
     */
    public function edit(CategoryValidator $input)
    {
        try {
            $category = $this->categories->findOrfail($input->categoryId);

            if ($category->update($input->except(['_token']))) {             // Try to edit the category.
                flash(trans(trans('category.flash-edit')))->success();   // MSG the category has been updated.
            }

            return back(302);
        } catch (ModelNotFoundException $modelNotFoundException) { // Could not find the category in the database.
            return app()->abort(404);
        }
    }

    /**
     * Remove a category in the database.
     *
     * @param integer $categoryId The category id in the database.
     * 
     * @return mixed
     */
    public function destroy($categoryId)
    {
        try { // To find the category in the database
            $category = $this->categories->findOrFail($categoryId);

            if ($category->delete() && $category->news()->sync([])) { // Try to delete the category.
                flash(trans('category.flash-delete'))->success(); // Category has been deleted.
            }

            return back(302);
        } catch (ModelNotFoundException $modelNotFoundException) { // Could not find the category in the database.
            return app()->abort(404);
        }
    }
}

<?php

namespace Sijot\Http\Controllers;

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
}

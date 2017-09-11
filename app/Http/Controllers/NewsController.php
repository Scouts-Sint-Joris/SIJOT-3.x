<?php

namespace Sijot\Http\Controllers;

use Sijot\News;
use Sijot\Http\Requests\NewsValidator;
use Illuminate\Http\Request;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Sijot\Repositories\CategoryRepository;
use Sijot\Repositories\NewsRepository;

/**
 * Class NewsController
 *
 * @category SIJOT-Website
 * @package  Sijot\Http\Controllers
 * @author   Tim Joosten <topairy@gmail.com>
 * @license  MIT License
 * @link     http://www.st-joris-turnhout.be
 */
class NewsController extends Controller
{
    /**
     * The news database model.
     * 
     * @var News
     */
    private $_newsDb;

    /**
     * The categories database model.
     * 
     * @var mixed categoriesDb;
     */
    private $_categoriesDb;

    /**
     * NewsController constructor
     *
     * @param CategoryRepository  $_categoriesDb The categories database model.
     * @param NewsRepository      $_newsDb       The news database model.
     * 
     * @return void
     */
    public function __construct(CategoryRepository $_categoriesDb, NewsRepository $_newsDb)
    {
        $routes = ['store', 'update', 'delete', 'create', 'index', 'status', 'getById'];

        $this->middleware('auth')->only($routes);
        $this->middleware('forbid-banned-user')->only($routes);

        $this->_categoriesDb = $_categoriesDb;
        $this->_newsDb       = $_newsDb;
    }

    /**
     * Get the news management index.
     *
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function index()
    {
        $data['title']      = 'Nieuws management';
        $data['news']       = $this->_newsDb->with(['author'])->get();
        $data['categories'] = $this->_categoriesDb->all();

        return view('news.index', $data);
    }

    /**
     * The view for creating a new item.
     *
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function create()
    {
        $data['title']      = 'Nieuw Nieuwsbericht';
        $data['categories'] = $this->_categoriesDb->with(['author', 'news'])->get();

        return view('news.create', $data);
    }

    /**
     * Try to find a news message en encode it with json.
     *
     * @param integer $newsId The news id in the database.
     * 
     * @return mixed
     */
    public function getById($newsId)
    {
        try { // Try to find and output the record.
            //? Maybe we need convert this in some API form.
            return(json_encode($this->_newsDb->findOrFail($newsId)));
        } catch (ModelNotFoundException $notFoundException) { // The user is not found.
            return app()->abort(404);
        }
    }

    /**
     * Store a new news item in the database.
     *
     * @param NewsValidator $input The user input validator
     * 
     * @return \Illuminate\Http\RedirectResponse
     */
    public function store(NewsValidator $input)
    {
        $filter = ['_token', 'categories'];

        if ($item = $this->_newsDb->create($input->except($filter))) { // The news message has been stored.
            if (! is_null($input->categories)) { // There are categories find in the user input.
                $this->_newsDb->find($item->id)->categories()->attach($input->categories);
            }

            flash('Het nieuwsbericht is opgeslagen.');
        }

        return back();
    }

    /**
     * Show a specific news item in the application.
     *
     * @param integer $newsId The news id in the database.
     * 
     * @return mixed
     */
    public function show($newsId)
    {
        try { // Try to find the record
            $data['news']       = $this->_newsDb->with(['author'])->findOrFail($newsId);
            $data['categories'] = $this->_categoriesDb->all();
            $data['title']      = $data['news']->title;

            return view('news.show', $data);
        } catch (ModelNotFoundException $exception) { // Record not found.
            return app()->abort(404);
        }
    }

    /**
     * Update a news item in the database.
     *
     * @param NewsValidator $input  The user input validator
     * @param integer       $newsId The news id in the database.
     * 
     * @return mixed
     */
    public function update(NewsValidator $input, $newsId)
    {
        try { // Try to find the record.
            $newsItem = $this->_newsDb->findOrfail($newsId);

            if ($newsItem->update($input->except(['_token', 'categories']))) { // Record has been updated.
                $newsItem->categories()->sync($input->get('categories'));
                flash('Het nieuwsbericht is aangepast.');
            }

            return back();
        } catch (ModelNotFoundException $exception) { // Record is not found.
            return app()->abort(404);
        }
    }

    /**
     * Change the status for a news message.
     *
     * @param string  $status The status identifier for the news message.
     * @param integer $newsId The news message id in the database.
     * 
     * @return mixed
     */
    public function status($status, $newsId)
    {
        try { // Try to find the news item in the database.
            $newsItem = $this->_newsDb->findOrFail($newsId);

            if ($newsItem->update(['publish' => $status])) { // Try to update the record.
                // The record has been updated.
                if ((string) $status === 'Y') { // The status has been set to 'publish'
                    flash('Het nieuwsbericht is gepubliceerd.');
                } elseif ((string) $status === 'N') { // The status has been set to 'Klad'
                    flash('Het nieuws bericht is naar een klad versie gezet.');
                }
            }

            return back(302);
        } catch (ModelNotFoundException $modelNotFoundException) { // News item not found in de database.
            return app()->abort(404);
        }
    }

    /**
     * Delete a news item in the database.
     *
     * @param integer $newsId The news id in the database.
     * 
     * @return mixed
     */
    public function delete($newsId)
    {
        try { // Try to find the record.
            $news = $this->_newsDb->findOrFail($newsId);

            if ($news->delete()) { // Record has been deleted.
                flash('Het nieuwsbericht is verwijderd.');
            }

            return back(302);
        } catch (ModelNotFoundException $exception) { // Record not found.
            return app()->abort(404);
        }
    }
}

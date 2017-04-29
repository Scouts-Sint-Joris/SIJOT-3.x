<?php

namespace App\Http\Controllers;

use App\News;
use Illuminate\Http\Request;
use Illuminate\Database\Eloquent\ModelNotFoundException;

/**
 * Class NewsController
 *
 * @package App\Http\Controllers
 */
class NewsController extends Controller
{
    /**
     * @var News
     */
    private $newsDb;

    /**
     * @var categoriesDb;
     */
    private $categoriesDb;

    /**
     * NewsController constructor
     *
     * @param   News        $newsDb
     * @param   Categories  $categoriesDb
     * @return  void
     */
    public function __construct(Categories, $categoriesDb, News $newsDb)
    {
        $this->categoriesDb = $categoriesDb;
        $this->newsDb       = $newsDb;
    }

    /**
     * Get the news management index.
     *
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function index()
    {
        $data['title']      = 'Nieuws management';
        $data['news']       = $this->newsDb->all();
        $data['categories'] = $this->categoriesDb->all();

        return view('', $data);
    }

    /**
     * The view for creating a new item.
     *
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function create()
    {
        $data['title']      = 'Nieuw Nieuwsbericht';
        $data['categories'] = $this->categoriesDb->all();

        return view('news.create', $data);
    }

    /**
     * Store a new news item in the database.
     *
     * @param  NewsValidator $input The user input validator
     * @return \Illuminate\Http\RedirectResponse
     */
    public function store(NewsValidator $input)
    {
        if ($this->newsDb->create($input->except(['_token', 'categories']))) { // The news message has been stored.
            session()->flash('class', 'alert alert-success');
            session()->flash('message', 'Het nieuwsbericht is opgeslagen.');
        }

        return back();
    }

    /**
     * Show a specific news item in the application.
     *
     * @param  integer $newsId The news id in the database.
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View|void
     */
    public function show($newsId)
    {
        try { // Try to find the record
            $data['news']  = $this->newsDb->findOrFail($newsId);
            $data['title'] = $data['news']->title;

            return view('news.show', $data);
        } catch (ModelNotFoundException $exception) { // Record not found.
            return app()->abort(404);
        }
    }

    /**
     * Update a news item in the database.
     *
     * @param  NewsValidator $input The user input validator
     * @param  integer $newsId The news id in the database.
     * @return \Illuminate\Http\RedirectResponse|void
     */
    public function update(NewsValidator $input, $newsId)
    {
        try { // Try to find the record.
            $newsItem = $this->newsDb->findOrfail($newsId);

            if ($newsItem->update($input->except(['_token', 'categories']))) { // Record has been updated.
                $newsItem->categories()->sync($input->get('categories'));

                session()->flash('class', 'alert alert-success');
                session()->flash('message', 'Het nieuwsbericht is aangepast.');
            }

            return back();
        } catch (ModelNotFoundException $exception) { // Record is not found.
            return app()->abort(404);
        }
    }

    /**
     * Delete a news item in the database.
     *
     * @param  integer $newsId The news id in the database.
     * @return \Illuminate\Http\RedirectResponse|void
     */
    public function delete($newsId)
    {
        try { // Try to find the record.
            $news = $this->newsDb->findOrFail($newsId);

            if ($news->delete()) { // Record has been deleted.
                session()->flash('class', 'alert alert-success');
                session()->flash('message', 'Het nieuwsbericht is verwijderd.');
            }

            return back();
        } catch (ModelNotFoundException $exception) { // Record not found.
            return app()->abort(404);
        }
    }
}

<?php

namespace Sijot\Http\Controllers;

use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Http\Request;
use Sijot\Http\Requests\PhotoValidator;
use Sijot\Photos;
use Sijot\Groups;

/**
 * Class PhotoController
 *
 * @package Sijot\Http\Controllers
 */
class PhotoController extends Controller
{
    // TODO: Write translation file.
    // TODO: Repository Implementation.
    // TODO: Write tests.

    private $photos; /** @var mixed Photos The photos database instance. */
    private $groups; /** @var mixed Groups The groups database instance. */

    /**
     * PhotoController constructor.
     *
     * @param Photos $photos
     * @param Groups $groups 
     *  
     * @return void.
     */
    public function __construct(Photos $photos, Groups $groups)
    {
        $this->middleware('auth');
        // $this->middleware('lang'); // Throws bug when using. TODO: Trace this ons out

        $this->photos = $photos;
        $this->groups = $groups;
    }

    /**
     * The front-end index page for the photos.
     *
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function indexFront()
    {
        $data['title'] = trans('photos.title-frontend');
        return view('photos.index-front', $data);
    }

    /**
     * The backend index page for the photo's.
     *
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function indexBackend()
    {
        $data['title']  = trans('photos.title-backend.');
        $data['photos'] = $this->photos->paginate(25);
        $data['groups'] = $this->groups->select(['id', 'title'])->get();

        return view('photos.index-back', $data);
    }

    /**
     * Store a new photo in the system.
     *
     * @param  PhotoValidator $input The user given input.
     * @return \Illuminate\Http\RedirectResponse
     */
    public function store(PhotoValidator $input)
    {
        // TODO: Create intervention logic to store the image. And merge them to the input.

        $input->merge(['author_id' => auth()->user()->id, 'image' => '']);

        if ($photo = $this->photos->create($input->except(['_token', 'group']))) { // The photo has been inserted.
            $this->photos->findOrFail($photo->id)->group()->attach($input->group);

            session()->flash('class',  'alert alert-success');
            session()->flash('message', trans('photos.create-success-flash'));
        }

        return redirect()->route('photos.index.backend');
    }

    /**
     * Delete a photo out the system.
     *
     * @param  integer $photoId The primary key for the database row.
     * @return \Illuminate\Http\RedirectResponse
     */
    public function destroy($photoId)
    {
        try { // To find the photo in the system.
            $photo = $this->photos->findOrFail($photoId);

            if ($photo->delete()) { // The photo has been deleted.
                // TODO: Add operation to delete the file from the server.

                // Output handling.
                session()->flash('class',   'alert alert-success');
                session()->flash('message', trans('photos.delete-success-flash'));
            }

            return redirect()->route('photos.index.backend');
        } catch (ModelNotFoundException $exception) { // The error when the photo is not found.
            session()->flash('class',   'alert alert-success');
            session()->flash('message', trans('photos.delete-error-flash'));

            return redirect()->route('photos.index.backend');
        }
    }
}

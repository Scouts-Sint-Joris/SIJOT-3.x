<?php

namespace Sijot\Http\Controllers;

use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Http\Request;
use Sijot\Http\Requests\PhotoValidator;
use Intervention\Image\Facades\Image;
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
        $data['title']  = trans('photos.title-frontend');
        $data['photos'] = $this->photos->with('group')->paginate(24);
        $data['groups'] = $this->groups->get();

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
        $data['photos'] = $this->photos->with('group')->paginate(24);
        $data['groups'] = $this->groups->select(['id', 'title'])->get();

        return view('photos.index-back', $data);
    }

    /**
     * Display the photos based on the scouting group.
     *
     * @param  mixed $seleup selector in the database.
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\Http\RedirectResponse|\Illuminate\View\View
     */
    public function getByGroup($selector)
    {
        if ($this->groups->find($selector)->count() === 0) {
            session()->flash('class',   'alert alert-danger');
            session()->flash('message', trans('photos.error-flash-invalid-group'));

            return redirect()->route('photos.index.backend');
        }

        $data['photos'] = $this->photos->with(['group' => function($query) use ($selector) {
            $query->where('groups_id', $selector);
        }])->paginate(24);

        $data['title']  = trans('photos.title-group-photos');
        $data['groups'] = $this->groups->get();

        return view('photos.index-front', $data);
    }

    /**
     * Store a new photo in the system.
     *
     * @param  PhotoValidator $input The user given input.
     * @return \Illuminate\Http\RedirectResponse
     */
    public function store(PhotoValidator $input)
    {
        //! START image upload
        $image      = $input->file('image');
        $filename   = time() . '.' . $image->getClientOriginalExtension();
        $path       = public_path("img/photos/{$filename}");

        Image::make($image->getRealPath())->resize(400, 300)->save($path);
        //! END Image upload

        $input->merge(['author_id' => auth()->user()->id, 'image_path' => "img/photos/{$filename}"]);

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
                if (file_exists(public_path($photo->image_path))) {  //? Check if the image exist.
                    unlink(public_path($photo->image_path));         //? The image exists so delete them.
                } 

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

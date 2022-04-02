<?php

namespace App\Http\Controllers;

use App\Models\Photo;
use Auth;
use Illuminate\Http\Request;
use Storage;

class PhotoController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $photos = Photo::latest()->when($request->has('title'), function ($q) use ($request)
        {
            return $q->where('title', 'like', '%' . $request->get('title') . '%');
        })->paginate(5);

        return view('photos.index', [
            'photos' => $photos,
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('photos.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $request->validate([
            'title' => ['required', 'max:20'],
            'description' => ['required', 'max:255'],
            'image' => ['required', 'image'],
        ]);

        $photo = Photo::create([
            'user_id' => Auth::id(),
            'title' => $request->title,
            'description' => $request->description,
            'image' => $request->file('image')->store('photos', 'public'),
        ]);
        return redirect()->route('photos.show', $photo)->with([
            'status' => 'Successfully added!',
            'alert-class' => 'success',
        ]);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Photo  $photo
     * @return \Illuminate\Http\Response
     */
    public function show(Photo $photo)
    {
        return view('photos.show', [
            'photo' => $photo
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Photo  $photo
     * @return \Illuminate\Http\Response
     */
    public function edit(Photo $photo)
    {
        $this->authorize('update', $photo);

        return view('photos.edit', [
            'photo' => $photo
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Photo  $photo
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Photo $photo)
    {
        $this->authorize('update', $photo);

        $request->validate([
            'title' => ['required', 'max:20'],
            'description' => ['required', 'max:255'],
        ]);

        $photo->update([
            'title' => $request->title,
            'description' => $request->description,
        ]);
        return redirect()->route('photos.show', $photo)->with([
            'status' => 'Successfully updated!',
            'alert-class' => 'success',
        ]);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Photo  $photo
     * @return \Illuminate\Http\Response
     */
    public function destroy(Photo $photo)
    {
        $this->authorize('delete', $photo);

        Storage::disk('public')->delete($photo->image);

        $photo->delete();

        return redirect()->route('photos.index')->with([
            'status' => 'Photo deleted',
            'alert-class' => 'danger',
        ]);
    }

    public function __construct()
    {
        $this->middleware('auth')->except(['index', 'show']);
    }
}

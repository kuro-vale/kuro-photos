<?php

namespace App\Http\Controllers;

use App\Models\Photo;
use Auth;
use Illuminate\Http\Request;

use function Psy\debug;

class PhotoController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $photos = Photo::latest()->get();

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
            'title' => 'required',
            'description' => 'required',
            'image' => 'required',
        ]);

        $photo = Photo::create([
            'user_id' => Auth::id(),
            'title' => $request->title,
            'description' => $request->description,
            'image' => $request->file('image')->store('photos', 'public'),
        ]);
        return redirect()->route('photos.show', $photo);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Photos  $photos
     * @return \Illuminate\Http\Response
     */
    public function show(Photo $photos)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Photos  $photos
     * @return \Illuminate\Http\Response
     */
    public function edit(Photo $photos)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Photos  $photos
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Photo $photos)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Photos  $photos
     * @return \Illuminate\Http\Response
     */
    public function destroy(Photo $photos)
    {
        //
    }

    public function __construct()
    {
        $this->middleware('auth')->except(['index', 'show']);
    }
}

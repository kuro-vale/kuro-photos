<?php

namespace App\Http\Controllers;

use App\Models\Comment;
use App\Models\Photo;
use Auth;
use Illuminate\Http\Request;

class CommentController extends Controller
{
    /**
     * Store a newly created resource in storage.
     *
     * @param \App\Models\Photo $photo
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request, Photo $photo)
    {
        $request->validate([
            'body' => ['required', 'max:255']
        ]);

        Comment::create([
            'user_id' => Auth::id(),
            'photo_id' => $photo->id,
            'body' => $request->body,
        ]);
        return redirect()->route('photos.show', $photo)->with([
            'status' => 'Successfully added!',
            'alert-class' => 'success',
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param \App\Models\Photo $photo
     * @param  \App\Models\Comment  $comment
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Photo $photo, Comment $comment)
    {
        $this->authorize('update', $comment);

        $request->validate([
            'body' => ['required', 'max:255']
        ]);

        $comment->update([
            'body' => $request->body
        ]);
        return redirect()->route('photos.show', $photo)->with([
            'status' => 'Successfully updated!',
            'alert-class' => 'success',
        ]);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param \App\Models\Photo $photo
     * @param  \App\Models\Comment  $comment
     * @return \Illuminate\Http\Response
     */
    public function destroy(Photo $photo, Comment $comment)
    {
        $this->authorize('delete', $comment);

        $comment->delete();

        return redirect()->route('photos.show', $photo)->with([
            'status' => 'Comment deleted',
            'alert-class' => 'danger',
        ]);
    }
}

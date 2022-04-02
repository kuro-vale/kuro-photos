<?php

namespace App\Http\Controllers;

use App\Models\Photo;
use App\Models\User;
use Auth;
use Illuminate\Http\Request;
use Storage;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $users = User::oldest()->when($request->has('username'), function ($q) use ($request)
        {
            return $q->where('username', 'like', '%' . $request->get('username') . '%');
        })->paginate(12);

        return view('users.index', [
            'users' => $users
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function edit()
    {
        $user = Auth::user();

        return view('users.edit', [
            'user' => $user
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request)
    {
        $validatedata = [
            'name' => ['required', 'string', 'max:255'],
            'username' => ['required', 'string', 'min:2', 'max:25', 'unique:users', 'alpha_dash'],
            'avatar' => ['nullable', 'image']
        ];
        $user = Auth::user();
        if ($user->username == $request->username)
        {
            $validatedata['username'] = ['required', 'string', 'min:2', 'max:25', 'alpha_dash'];
        }
        $request->validate($validatedata);

        $user->update([
            'username' => $request->username,
            'name' => $request->name,
        ]);

        if ($request->file('avatar'))
        {
            if ($user->avatar != 'avatars/default-avatar.png')
            {
                Storage::disk('public')->delete($user->avatar);
            }
            $user->avatar = $request->file('avatar')->store('avatars', 'public');
            $user->save();
        }

        return redirect()->route('users.edit')->with([
            'status' => 'Settings updated!',
            'alert-class' => 'success',
        ]);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @return \Illuminate\Http\Response
     */
    public function destroy()
    {
        $user = Auth::user();
        Auth::logout($user);
        $user_photos = Photo::select('image')->where('user_id', '=', $user->id)->get()->toArray();
        if ($user->avatar != 'avatars/default-avatar.png')
        {
            Storage::disk('public')->delete($user->avatar);
        }
        foreach ($user_photos as $photo)
        {
            Storage::disk('public')->delete($photo);
        }
        $user->delete();
        return redirect()->route('users.index')->with([
            'status' => 'User deleted',
            'alert-class' => 'danger',
        ]);
    }

    /**
     * Display a listing of the resource by user.
     *
     * @param  \App\Models\User  $user
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function user_photos(Request $request, User $user)
    {
        $photos = Photo::latest()->where('user_id', '=', $user->id)->when($request->has('title'), function ($q) use ($request)
        {
            return $q->where('title', 'like', '%' . $request->get('title') . '%');
        })->paginate(5);;

        return view('users.photos', [
            'user' => $user,
            'photos' => $photos,
        ]);
    }

    /**
     * Display the dashboard of the user.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function dashboard(Request $request)
    {
        $user = Auth::user();
        $user_photos = Photo::latest()->where('user_id', '=', $user->id)->when($request->has('title'), function ($q) use ($request)
        {
            return $q->where('title', 'like', '%' . $request->get('title') . '%');
        })->get();

        return view('users.dashboard', [
            'user' => $user,
            'photos' => $user_photos,
        ]);
    }
}

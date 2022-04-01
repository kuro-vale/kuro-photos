<?php

namespace App\Http\Controllers;

use App\Models\User;
use Auth;
use Illuminate\Http\Request;
use Storage;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     *
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
     * @param  \App\Models\User  $user
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
     * @param  \App\Models\User  $user
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request)
    {
        $validatedata = [
            'name' => ['required', 'string', 'max:255'],
            'username' => ['required', 'string', 'min:2', 'max:25', 'unique:users'],
            'avatar' => ['nullable', 'image']
        ];
        $user = Auth::user();
        if ($user->username == $request->username)
        {
            $validatedata['username'] = ['required', 'string', 'min:2', 'max:25'];
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

        return redirect()->route('users.edit')->with('status', 'Settings successfully updated!');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\User  $user
     * @return \Illuminate\Http\Response
     */
    public function destroy()
    {
        $user = Auth::user();
        Auth::logout($user);
        if ($user->avatar != 'avatars/default-avatar.png')
        {
            Storage::disk('public')->delete($user->avatar);
        }
        $user->delete();
        return redirect()->route('users.index')->with('status', 'User deleted!!!');
    }
}

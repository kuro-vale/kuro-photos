<?php

namespace App\Policies;

use App\Models\Photo;
use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class PhotoPolicy
{
    use HandlesAuthorization;

    /**
     * Determine whether the user can update the model.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\Photo  $photo
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function update(User $user, Photo $photo)
    {
        return $user->id == $photo->user_id;
    }

    /**
     * Determine whether the user can delete the model.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\Photo  $photo
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function delete(User $user, Photo $photo)
    {
        return $user->id == $photo->user_id;
    }
}

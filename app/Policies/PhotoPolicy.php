<?php

namespace App\Policies;

use App\User;
use App\Photo;
use Illuminate\Auth\Access\HandlesAuthorization;

class PhotoPolicy
{
    use HandlesAuthorization;


    /*
     *  The controller methods are mapped to policy methods like so:
        show to view
        create to create
        store to create
        edit to update
        update to update
        save to update
        destroy to delete
        So calling ArticleController@show() would invoke ArticlePolicy@view() and so on.
     */

    /**
     * Determine whether the user can view the photo.
     *
     * @param  \App\User  $user
     * @param  \App\Photo  $photo
     * @return mixed
     */
    public function view(User $user, Photo $photo)
    {
        return $user->id === $photo->album->user_id; // nel modello photo abbiamo dichiarato la relazione tra le foto e l'labum
    }

    /**
     * Determine whether the user can create photos.
     *
     * @param  \App\User  $user
     * @return mixed
     */
    public function create(User $user)
    {
        return true;
    }

    /**
     * Determine whether the user can update the photo.
     *
     * @param  \App\User  $user
     * @param  \App\Photo  $photo
     * @return mixed
     */
    public function update(User $user, Photo $photo)
    {
        return $user->id === $photo->album->user_id; // nel modello photo abbiamo dichiarato la relazione tra le foto e l'labum
    }

    /**
     * Determine whether the user can delete the photo.
     *
     * @param  \App\User  $user
     * @param  \App\Photo  $photo
     * @return mixed
     */
    public function delete(User $user, Photo $photo)
    {
        return $user->id === $photo->album->user_id; // nel modello photo abbiamo dichiarato la relazione tra le foto e l'labum
    }
}

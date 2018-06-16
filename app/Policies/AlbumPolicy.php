<?php

namespace App\Policies;

use App\User;
use App\Album;
use Illuminate\Auth\Access\HandlesAuthorization;

class AlbumPolicy
{


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



    use HandlesAuthorization;

    /**
     * Determine whether the user can view the album.
     *
     * @param  \App\User  $user
     * @param  \App\Album  $album
     * @return mixed
     */

    public function view(User $user, Album $album)
    {
        //dd("1");
        return $user->id == $album->user_id;
    }

    // questo metodo viene invocato nel route web AlbumsController@show
    // come dimostrazione che posso invocare una policy anche dal route attraverso
    // un middleware
    public function test(User $user, Album $album)
    {
        dd("test");
        return $user->id == $album->user_id;
    }

    /**
     * Determine whether the user can create albums.
     *
     * @param  \App\User  $user
     * @return mixed
     */
    public function create(User $user)
    {
        //dd("2");
        return true;
    }

    /**
     * Determine whether the user can update the album.
     *
     * @param  \App\User  $user
     * @param  \App\Album  $album
     * @return mixed
     */
    public function update(User $user, Album $album)
    {
        //dd("3");
        return $user->id == $album->user_id;
    }

    /**
     * Determine whether the user can delete the album.
     *
     * @param  \App\User  $user
     * @param  \App\Album  $album
     * @return mixed
     */
    public function delete(User $user, Album $album)
    {
        //dd("4");
        return $user->id == $album->user_id;
    }
}

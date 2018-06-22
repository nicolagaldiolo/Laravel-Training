<?php

namespace App\Http\Controllers;

use App\Album;
use App\Photo;
use Illuminate\Http\Request;

class GalleryController extends Controller
{
    public function index(){

        $albums = Album::latest()->paginate();

        return view('gallery.albums')->with('albums', $albums);
    }

    public function showAlbumImages(Album $album){
        $photos = Photo::whereAlbumId($album->id)->latest()->paginate();

        return view('gallery.images')->with('photos', $photos);
    }

}

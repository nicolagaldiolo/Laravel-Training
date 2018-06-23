<?php

namespace App\Http\Controllers;

use App\Album;
use App\Category;
use App\Photo;
use Illuminate\Http\Request;

class GalleryController extends Controller
{
    public function index(){

        $albums = Album::latest()->with('categories')->paginate();

        return view('gallery.albums')->with('albums', $albums);
    }

    public function showAlbumImages(Album $album){
        $photos = Photo::whereAlbumId($album->id)->latest()->paginate();

        return view('gallery.images')->with('photos', $photos);
    }

    public function showAlbumsByCategory(Category $category)
    {
        //$albums = $category->load('album'); // mi torna anche le info della category
        $albums = $category->album()->paginate(); // mi torna gli album filtrati per category paginati

        //return $albums;

        return view('gallery.albums')->with('albums', $albums);
    }

}

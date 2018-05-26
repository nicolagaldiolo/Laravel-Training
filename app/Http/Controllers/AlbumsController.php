<?php

namespace App\Http\Controllers;

use App\Album;
use Illuminate\Http\Request;
use DB;

class AlbumsController extends Controller
{
    function index(Request $request){

      //Posso recuperare i dati in 2 modi, utilizzando il query builder
      //$album = Album::all();

      // oppure posso creare delle query grezze
      // utilizzo uno statement così da essere più sicuro ed evitare la sequel injection
      $sql = "SELECT * FROM albums WHERE 1=1";

      $where = [];

      if($request->has('id')){
        $where['id'] = $request->get('id');
        $sql .= " AND id = :id";
      }

      if($request->has('album_name')){
        $where['album_name'] = $request->get('album_name');
        $sql .= " AND album_name = :album_name";
      }

      $album = DB::select($sql, $where);

      //dd($album);

      return view('albums.albums', ['data' => $album]);
    }

    function show($id = ''){

      $sql = "SELECT * FROM albums WHERE id = :id";
      $album = DB::select($sql, ['id' => $id]);

      return view('albums.edit', ['data' => $album[0]]);

    }

    function update(Request $request){
      dd(request()->all());
    }

    function delete($id = ''){
      $response = '';
      if($id){
        $sql = "DELETE FROM albums WHERE id = :id";
        $response = DB::delete($sql, ['id' => $id]);
      }

      //return redirect('albums'); //ridirigo manualemente
      //return redirect()->back(); //ridirigo da dove sono venuto

      // dato che viene invocato via ajax torno $response
      return $response;

    }
}

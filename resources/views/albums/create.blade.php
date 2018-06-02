@extends('layouts.master')

@section('title', 'Pagina in BLADE')

@section('content')
    <form action="{{route('album.save')}}" method="POST" enctype="multipart/form-data"><!-- form encript multipart/form-data per permettere l'invio di file -->
        {{csrf_field()}} <!-- creo un campo nascosto con il token di sessione -->
        <div class="form-group">
            <label>Album name</label>
            <input type="text" class="form-control" placeholder="Album name" name="album_name">
        </div>

        <div class="form-group">
            <label>Album thumb</label>
            <input type="file" class="form-control" placeholder="Album thumb" name="album_thumb">
        </div>
        <div class="form-group">
            <label>Album Description</label>
            <textarea class="form-control" placeholder="Album description" name="description"></textarea>
        </div>
        <button type="submit" class="btn btn-primary">Submit</button>
    </form>
@stop
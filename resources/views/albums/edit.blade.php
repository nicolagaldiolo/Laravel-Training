@extends('layouts.master')

@section('title', 'Pagina in BLADE')

@section('content')
  <form method="POST" enctype="multipart/form-data"> <!-- form encript multipart/form-data per permettere l'invio di file -->
    {{csrf_field()}} <!-- creo un campo nascosto con il token di sessione -->
    <input type="hidden" name="_method" value="patch">
    <!-- per aggiornare il dato ho bisogni di una chiamata di tipo patch ma tramite un form posso utilizzare solo get o post
    quindi devo passare un campo nascosto dove istruisco laravel di simulare una chiamata di tipo patch -->
    <div class="form-group">
      <label>Album name</label>
      <input type="text" class="form-control" placeholder="Album name" name="album_name" value="{{$data->album_name}}">
    </div>
    <div class="form-group">
      <label>Album Description</label>
      <textarea class="form-control" placeholder="Album description" name="description">{{$data->description}}</textarea>
    </div>
    <div class="form-group">
      <label>Album thumb</label>
      <input type="file" class="form-control" placeholder="Album thumb" name="album_thumb">
      @if($data->album_thumb)
        <img width="300" src="{{asset($data->path)}}" alt="{{$data->album_name}}">
      @endif
    </div>
    <button type="submit" class="btn btn-primary">Submit</button>
  </form>
@stop
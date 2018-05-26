@extends('layouts.master')

@section('title', 'Pagina in BLADE')

@section('content')
  @if($data)
    <form method="POST">
      {{csrf_field()}}
      <input type="hidden" name="_method" value="patch">
      <div class="form-group">
        <label>Album name</label>
        <input type="text" class="form-control" placeholder="Album name" name="album_name" value="{{$data->album_name}}">
      </div>
      <div class="form-group">
        <label>Album Description</label>
        <textarea class="form-control" placeholder="Album name" name="description">{{$data->description}}</textarea>
      </div>
      <button type="submit" class="btn btn-primary">Submit</button>
    </form>
  @endif

@stop
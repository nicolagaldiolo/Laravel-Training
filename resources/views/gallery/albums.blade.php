@extends('layouts.master')
@section('content')

    <div class="card-columns">
        @foreach($albums as $album)
            <div class="card">
                <a href="{{route('gallery.albums.images', $album->id)}}">
                    <img class="card-img-top" src="{{asset($album->album_thumb)}}" alt="{{$album->album_name}}">
                </a>
                <div class="card-body">
                    <h5 class="card-title">{{$album->album_name}}</h5>
                    <p class="card-text">{{$album->description}}</p>
                    <p class="card-text"><small class="text-muted">{{$album->created_at->diffForHumans()}}</small></p>
                </div>
            </div>
        @endforeach
    </div>
@stop
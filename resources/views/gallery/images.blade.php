@extends('layouts.master')
@section('content')

    <div class="row justify-content-md-center">
        <div class="col-8">
            @foreach($photos as $photo)
                <a href="#">
                    <img class="img-fluid" src="{{asset($photo->img_path)}}" alt="{{$photo->name}}">
                </a>

            @endforeach
        </div>
    </div>

    <div>
        {{-- {{$images->links('vendor.pagination.bootstrap-4')}}
            || bootstrap-4 | default | semantic-ui | ecc
            posso specificare un determinato template per la paginazione, oppure usare quello standard
        --}} {{$photos->links()}}

    </div>

@stop
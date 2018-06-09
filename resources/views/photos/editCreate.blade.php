@extends('layouts.master')

@section('title', 'Pagina in BLADE')

@section('content')
    <!-- nella vista viene iniettata l'oggetto errors che con $errors->any() so se ci sono errori e
    con $errors->all() mi viene tornato l'array degli errori -->
    @if($errors->any())
        <div class="alert alert-danger alert-dismissible fade show" role="alert">
            <ul>
                @foreach($errors->all() as $error)
                    <li>{{$error}}</li>
                @endforeach
            </ul>
            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                <span aria-hidden="true">&times;</span>
            </button>
        </div>
    @endif

    @if($photo->id)
        <h1>Edit photo</h1>
        <form action="{{route('photos.update', $photo->id)}}" method="POST" enctype="multipart/form-data">
            <!-- form encript multipart/form-data per permettere l'invio di file -->

            <!-- per aggiornare il dato ho bisogni di una chiamata di tipo patch ma tramite un form posso utilizzare solo get o post
            quindi devo passare un campo nascosto dove istruisco laravel di simulare una chiamata di tipo patch -->
            {{method_field('PATCH')}} <!-- l'output di method_field è <input type="hidden" name="_method" value="patch">-->
    @else
        <h1>New photo</h1>
        <form action="{{route('photos.store')}}" method="POST" enctype="multipart/form-data">
            <!-- form encript multipart/form-data per permettere l'invio di file -->
    @endif

            {{csrf_field()}} <!-- creo un campo nascosto con il token di sessione -->

            <div class="form-group">
                <label>Name</label>
                <input type="text" class="form-control" placeholder="Photo name" name="name"
                       value="{{$photo->name}}">
            </div>

            @if(isset($albumList))
                <div class="form-group">
                    <select name="album_id">
                        <option>Seleziona album</option>
                        @foreach($albumList as $item)
                            <option {{$item->id == $album->id ? 'selected' : ''}} value="{{$item->id}}">{{$item->album_name}}</option>
                        @endforeach
                    </select>
                </div>
            @endif

            <div class="form-group">
                <label>Desciption</label>
                <textarea class="form-control" placeholder="photo description"
                          name="description">{{$photo->description}}</textarea>
            </div>
            @include('photos.partials.fileupload')

            <button type="submit" class="btn btn-primary">Submit</button>
        </form>
@stop
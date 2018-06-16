@extends('layouts.master')

@section('title', 'Pagina in BLADE')

@section('content')

    @include('partials.validatemessage')

    <form action="{{route('album.save')}}" method="POST" enctype="multipart/form-data"><!-- form encript multipart/form-data per permettere l'invio di file -->
        {{csrf_field()}} <!-- creo un campo nascosto con il token di sessione -->
        <div class="form-group">
            <label>Album name</label>
            <input type="text" class="form-control" placeholder="Album name" name="album_name" value="{{old('album_name')}}">
            <!-- con l'helper old() in caso di errori di validazione mi viene mantenuto il valore inserito nel campo input altrimenti lo perderei (dato che non è stato salvato), l'eventulae secondo parametro è il valore di default ossia il dato precedentemente salvato -->
        </div>

        <div class="form-group">
            <label>Album thumb</label>
            <input type="file" class="form-control" placeholder="Album thumb" name="album_thumb">
        </div>
        <div class="form-group">
            <label>Album Description</label>
            <textarea class="form-control" placeholder="Album description" name="description">{{old('description')}}</textarea>
            <!-- con l'helper old() in caso di errori di validazione mi viene mantenuto il valore inserito nel campo input altrimenti lo perderei (dato che non è stato salvato), l'eventulae secondo parametro è il valore di default ossia il dato precedentemente salvato -->
        </div>
        <button type="submit" class="btn btn-primary">Submit</button>
    </form>
@stop
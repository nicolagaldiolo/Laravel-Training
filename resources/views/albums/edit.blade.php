@extends('layouts.master')

@section('title', 'Pagina in BLADE')

@section('content')

  @include('partials.validatemessage')

  <form method="POST" enctype="multipart/form-data"> <!-- form encript multipart/form-data per permettere l'invio di file -->
    {{csrf_field()}} <!-- creo un campo nascosto con il token di sessione -->
    <input type="hidden" name="_method" value="patch">
    <!-- per aggiornare il dato ho bisogni di una chiamata di tipo patch ma tramite un form posso utilizzare solo get o post
    quindi devo passare un campo nascosto dove istruisco laravel di simulare una chiamata di tipo patch -->
    <div class="form-group">
      <label>Album name</label>
      <input type="text" class="form-control" placeholder="Album name" name="album_name" value="{{old('album_name', $album->album_name)}}">
      <!-- con l'helper old() in caso di errori di validazione mi viene mantenuto il valore inserito nel campo input altrimenti lo perderei (dato che non è stato salvato), l'eventulae secondo parametro è il valore di default ossia il dato precedentemente salvato -->
    </div>

      @if(isset($categories))
      <div class="form-group">
        <label>Category</label>
        <select class="js-example-basic-multiple form-control" name="categories[]" multiple="multiple">
          @foreach($categories as $category)
                <option value="{{$category->id}}" {{ in_array($category->id, $album->categories->pluck('id')->toArray()) ? 'selected' : ''}}>{{$category->name}}</option>
          @endforeach
        </select>
      </div>
    @endif

    <div class="form-group">
      <label>Album Description</label>
      <textarea class="form-control" placeholder="Album description" name="description">{{old('description', $album->description)}}</textarea>
      <!-- con l'helper old() in caso di errori di validazione mi viene mantenuto il valore inserito nel campo input altrimenti lo perderei (dato che non è stato salvato), l'eventulae secondo parametro è il valore di default ossia il dato precedentemente salvato -->
    </div>
    @include('albums.partials.fileupload')
    <button type="submit" class="btn btn-primary">Submit</button>
    <a href="{{route('albums')}}" class="btn btn-secondary">Annulla</a>
  </form>
@stop

@section('scripts')
  @parent
  <script>
      $(document).ready(function () {
          $('.js-example-basic-multiple').select2();
      });
  </script>
@stop
@extends('layouts.master')

@section('title', 'Pagina in BLADE')

@section('content')
  @if($data)
    <ul id="album_list" class="list-group">
      @foreach($data as $album)
        <li class="list-group-item flex-column">
          <div class="d-flex w-100 justify-content-between">
            <div>
              <h5 class="mb-1">{{$album->album_name}}</h5>
              <p class="mb-1">{{$album->description}}</p>
            </div>
            <small>
              <a href="/albums/{{$album->id}}"><i class="fas fa-pencil-alt fa-2x"></i></a>
              <a class="delete" href="/albums/{{$album->id}}"><i class="far fa-trash-alt fa-2x"></i></a>
            </small>
          </div>
        </li>
      @endforeach
    </ul>
  @endif

@stop

@section('scripts')
  @parent {{-- dico che in questo punto venga stampata la sezione scripts del parent, quella che sto estendendo. senza questa direttiva sovrascrivo la sezione scripts nel parent --}}
  <script>
    $('document').ready(function(){
      $('#album_list').on('click', '.delete', function(el){
        el.preventDefault();

        var li = el.target.parentNode.parentNode.parentNode.parentNode;
        var action = el.target.parentNode.href;

        // tutte le rotte del gruppo web sono protette dal gruppo di middleware "web" e tra i vari middleware utilizza anche
        // il VerifyCsrfToken che si preoccupa di verificare che tutte le richieste http siano accompagnate dal token di sessione
        // in modo da evitare che dall'esterno dell'applicazione posso effettuare alcune richieste tipo di aggiunta o cancellazione di dati. (esempio con postman).
        // infatti per tutte le richieste al di fuori della get devo passare il parametro _token che recupero con la relativa funzione: csrf_token().
        // all'interno di ogni middleware è possibile cmq specificare alcune eccezioni nella proprietà $except.
        $.ajax(action, {
          method: 'DELETE',
          data: {
            '_token' : "{{csrf_token()}}"
          },
          complete: function(resp){
            if(resp.responseText == 1){
              li.parentNode.removeChild(li);
            }else{
              console.log('Problemi con la chiamata');
            }
          }
        })
      });
    })
  </script>
@stop
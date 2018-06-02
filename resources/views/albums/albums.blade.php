@extends('layouts.master')

@section('title', 'Pagina in BLADE')

@section('content')

  @if(session()->has('message'))
    @component('components.alert') {{-- chiamo il componente e posso passare altre variabili con array aggiuntivo come secondo parametro (se non le passo si incazza), ciò che passo come content viene catturato dalla variabile {{$slot}} --}}
      {{session()->get('message')}}
    @endcomponent
  @endif

  @if($data)
    <ul id="album_list" class="list-group">
      @foreach($data as $album)
        <li class="list-group-item flex-column">
          <div class="d-flex w-100 justify-content-between">
            <div>
              @if($album->album_thumb)
                {{--
                  siccome sul db ho sia img reali caricate manualemte sia dati fake generati automaticamente devo fare un controlo
                  se il path del file è locale(=reale) o remoto(=fake) mi sono fatto un metodo getPathAttribute nel modello
                  Album che mi torna il path del file. $album->path mappa magicamente il metodo get|Path|Attribute
                --}}
                {{--<img width="120" src="{{asset('storage/'.$album->album_thumb)}}" alt="{{$album->album_name}}">--}}
                <img width="120" src="{{asset($album->path)}}" alt="{{$album->album_name}}">
              @endif
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

  <a class="btn btn-primary btn-lg btn-block" href="{{route('album.create')}}">Crate Album</a>

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
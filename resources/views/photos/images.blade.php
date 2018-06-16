@extends('layouts.master')

@section('title', 'Pagina in BLADE')

@section('content')

    @if(session()->has('message'))
        @component('components.alert') {{-- chiamo il componente e posso passare altre variabili con array aggiuntivo come secondo parametro (se non le passo si incazza), ciò che passo come content viene catturato dalla variabile {{$slot}} --}}
        {{session()->get('message')}}
        @endcomponent
    @endif

    <h1>Images for {{$album->album_name}} <a href="{{route('albums')}}" class="btn btn-link">Torna agli album</a></h1>

    <table class="table table-responsive table-striped">
        <tr>
            <th>Created At</th>
            <th>Title</th>
            <th>Album</th>
            <th>Thumbnail</th>
            <th></th>
        </tr>
        @forelse($images as $image)
            <tr>
                <td>{{$image->created_at->diffForHumans()}}</td>
                <td>{{$image->name}}</td>
                <td><a href="{{route('album.update', $album->id)}}">{{$album->album_name}}</a></td>
                <td><img width="100" src="{{asset($image->img_path)}}"></td>
                <td>
                    <a class="btn btn-primary" href="{{route('photos.edit', $image->id)}}"><i class="fas fa-pencil-alt"></i></a>
                    <a class="btn btn-danger delete" href="{{route('photos.destroy', $image->id)}}"><i class="far fa-trash-alt"></i></a>
                </td>
            </tr>
            @empty
            <tr>
                <td colspan="6">No images found</td>
            </tr>
        @endforelse
    </table>

    <div>
    {{-- {{$images->links('vendor.pagination.bootstrap-4')}}
        || bootstrap-4 | default | semantic-ui | ecc
        posso specificare un determinato template per la paginazione, oppure usare quello standard
    --}} {{$images->links()}}

    </div>

@stop

@section('scripts')
    @parent {{-- dico che in questo punto venga stampata la sezione scripts del parent, quella che sto estendendo. senza questa direttiva sovrascrivo la sezione scripts nel parent --}}
    <script>
        $('document').ready(function(){
            $('.table').on('click', '.delete', function(el){
                el.preventDefault();

                var tr = el.target.parentNode.parentNode.parentNode;
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
                            tr.parentNode.removeChild(tr);
                        }else{
                            console.log('Problemi con la chiamata');
                        }
                    }
                })
            });
        })
    </script>
@stop
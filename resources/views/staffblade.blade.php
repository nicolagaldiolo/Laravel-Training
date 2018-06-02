@extends('layouts/master')

@section('title', 'Pagina in BLADE')

@section('content')

  @include('partials.jumbotron', ['contenuto' => 'Contenuto del jumbotron'])

  @component('components.alert_demo', ['type' => 'success', 'other_var' => 'Altra variabile']) {{-- chiamo il componente e passo le mie variabili con array (se non le passo si incazza), ciò che passo come content viene catturato dalla variabile {{$slot}} --}}
    The content of the alert component
  @endcomponent

  @component('components.alert_demo', ['type' => 'warning', 'other_var' => 'Altra variabile']) {{-- posso anche evitare il content --}}
  @endcomponent

  @component('components.alert_demo') {{-- chiamo il componente e passo le mie variabili non come array ma con metodo slot (se non le passo si incazza), ciò che passo come content viene catturato dalla variabile {{$slot}} --}}
    @slot('type', 'info')
    @slot('other_var', 'Altra variabile')
    The content of the alert component
  @endcomponent

  @if($title)
    <h2>{{$title}}</h2>
  @endif

  @if($data)
    <h3>Ciclo con Foreach</h3>
    <ul>
      @foreach($data as $member)
        <li style="{{$loop->first ? 'color:red' : 'color:blue'}}">{{$loop->iteration}} di {{$loop->count}} - {{$member['name']}} {{$member['lastname']}} - {{$loop->remaining}}</li>
      @endforeach
    </ul>
  @endif

  <h3>Ciclo con Forelse</h3>
  <ul>
    @forelse($data as $member)
      <li>{{$member['name']}} {{$member['lastname']}}</li>
    @empty
      <li>La lista è vuota</li>
    @endforelse
  </ul>

  @if($data)
    <h3>Ciclo con For</h3>
    <ul>
      @for($i=0; $i<(count($data)); $i++)
        <li>{{$data[$i]['name']}} {{$data[$i]['lastname']}}</li>
      @endfor
    </ul>
  @endif

  @if($data)
    <h3>Ciclo con While</h3>
    <ul>
      @while($person = array_shift($data))
        <li>{{$person['name']}} {{$person['lastname']}}</li>
      @endwhile
    </ul>
  @endif

@stop

@section('scripts')
  @parent {{-- dico che in questo punto venga stampata la sezione scripts del parent, quella che sto estendendo.
  senza questa direttiva sovrascrivo la sezione scripts nel parent --}}
  <script>
    //alert("Sono nella pagina Staff")
  </script>
@stop

{{-- @endsection (vecchio modo di chiudere una section) --}}
{{-- @stop (nuovo modo di chiudere una section) --}}
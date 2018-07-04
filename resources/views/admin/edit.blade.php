@extends('layouts.admin')

@section('title', 'Pagina in BLADE')

@section('content')

    @if(session()->has('message'))
        @component('components.alert') {{-- chiamo il componente e posso passare altre variabili con array aggiuntivo come secondo parametro (se non le passo si incazza), ciò che passo come content viene catturato dalla variabile {{$slot}} --}}
        {{session()->get('message')}}
        @endcomponent
    @endif

    <h4>Editing user: {{$user->name}}</h4>
    <form action="{{route('users.update', $user)}}" method="POST" novalidate>
        @csrf
        @method('PATCH')
        @include('admin._form')
    </form>

@stop
@extends('layouts.master')

@section('title', 'Pagina in BLADE')

@section('content')
    <div class="jumbotron">
        <div class="container">
            <h3>{{ $exception->getMessage() }}</h3>
        </div>
    </div>
@stop
@extends('layouts.master')

@section('title', 'Pagina in BLADE')

@section('content')

    @if(session()->has('message'))
        @component('components.alert') {{-- chiamo il componente e posso passare altre variabili con array aggiuntivo come secondo parametro (se non le passo si incazza), ciò che passo come content viene catturato dalla variabile {{$slot}} --}}
        {{session()->get('message')}}
        @endcomponent
    @endif

    @include('partials.validatemessage')

    <div class="row">
        <div class="col-md-8">
            <table class="table table-striped">
                <tr>
                    <th>ID</th>
                    <th>Category Name</th>
                    <th>Created date</th>
                    <th>Update date</th>
                    <th>Number of albums</th>
                </tr>
                @forelse($categories as $category)
                    <tr>
                        <td>{{$category->id}}</td>
                        <td>{{$category->name}}</td>
                        <td>{{$category->created_at->diffForHumans()}}</td>
                        <td>{{$category->updated_at->diffForHumans()}}</td>
                        <td>{{$category->album_count}}</td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="5">No categories</td>
                    </tr>
                @endforelse
            </table>

            <div>
                {{-- {{$images->links('vendor.pagination.bootstrap-4')}}
                    || bootstrap-4 | default | semantic-ui | ecc
                    posso specificare un determinato template per la paginazione, oppure usare quello standard
                --}} {{$categories->links()}}

            </div>
        </div>
        <div class="col-md-4">
            <form action="{{route('categories.store')}}" method="post">
                @csrf
                <div class="form-group">
                    <label>Category name</label>
                    <input type="text" class="form-control" placeholder="Category name" name="name" value="{{old('name')}}">
                    <!-- con l'helper old() in caso di errori di validazione mi viene mantenuto il valore inserito nel campo input altrimenti lo perderei (dato che non è stato salvato), l'eventulae secondo parametro è il valore di default ossia il dato precedentemente salvato -->
                </div>
                <button type="submit" class="btn btn-primary">Submit</button>
            </form>
        </div>
    </div>

@stop
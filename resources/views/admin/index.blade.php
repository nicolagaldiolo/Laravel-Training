@extends('layouts.admin')

@section('title', 'Pagina in BLADE')

@section('content')

    @if(session()->has('message'))
        @component('components.alert') {{-- chiamo il componente e posso passare altre variabili con array aggiuntivo come secondo parametro (se non le passo si incazza), ciò che passo come content viene catturato dalla variabile {{$slot}} --}}
        {{session()->get('message')}}
        @endcomponent
    @endif

    <table id="userTable" class="table table-striped">
        <thead>
            <tr>
                <th>Name</th>
                <th>Email</th>
                <th>Created at</th>
                <th>Updated at</th>
                <th>Deleted at</th>
                <th></th>
            </tr>
        </thead>
        <tbody>
        </tbody>
    </table>

@stop

@section('scripts')
    @parent
    <script>
        $(document).ready( function () {
            var dataTable = $('#userTable').DataTable({
                processing: true,
                serverSide: true,
                ajax: '{{route('users.index')}}',
                columns: [
                    { data: "name" },
                    { data: "email" },
                    { data: "created_at" },
                    { data: "updated_at" },
                    { data: "deleted_at" },
                    { data: "action", name: 'action', orderable: false, searchable: false}
                ]
            });

            $('#userTable').on('click', '.ajax-action', function (el) {
                el.preventDefault();

                var action = this.href;
                var method = this.dataset.method.toUpperCase();
                var row = this.parentNode.parentNode;

                $.ajax(action, {
                    method: method,
                    data: {
                        '_token': laravel.csrfToken
                    },
                    complete: function (resp) {
                        resp = JSON.parse(resp.responseText);

                        if (resp.status) {
                            if(action.endsWith('forceDelete')){
                                row.parentNode.removeChild(row)
                            }
                            dataTable.ajax.reload();
                        } else {
                            alert(resp.message);
                        }
                    }
                })
            });

        });
    </script>
@stop
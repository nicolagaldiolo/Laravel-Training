@extends('layouts.master')

@section('title', 'Pagina in BLADE')

@section('content')


    <div class="category-list">
        @include('categories._list')
    </div>

@stop

@section('scripts')
    @parent {{-- dico che in questo punto venga stampata la sezione scripts del parent, quella che sto estendendo. senza questa direttiva sovrascrivo la sezione scripts nel parent --}}
    <script>
        $('document').ready(function () {

            $(document).on('click', '.update-category', function(el) {
                el.preventDefault();


                var link =          this.dataset.id;
                var table =         $('.table-striped tr');
                var tr =            $("#"+link);
                var formAction =    this.href;
                var catName =       $("#"+link+' .catName');
                var form =          $('#categoryForm');
                var formName =      form.find('input[name="name"]');
                var formButton =    form.find('button');

                table.css('border', '0');
                tr.css('border', '3px solid red');
                form.attr('action', formAction);
                formName.val(catName.text());
                form.append('<input type="hidden" name="_method" value="PATCH">');
                formButton.text("Update");
            });

            $(document).on('submit', '#categoryForm', function(el) {
                el.preventDefault();

                if (el.target.elements["name"].value == '') {
                    return;
                }

                $.ajax(el.target.action, {
                    method: 'POST',
                    data: $(this).serialize(), // faccio la serializzazione dei dati per inviare tutti i campi del form
                    complete: function (resp) {
                        resp = JSON.parse(resp.responseText);

                        if (resp.status) {
                            $('.category-list').html(resp.data);
                            validateMessage(resp.message);
                        } else {
                            alert(resp.message);
                        }
                    }
                })
            });

            $(document).on('click', '.delete-category', function(el) {
                el.preventDefault();

                var result = confirm('Are you sure?');

                if (result) {
                    var action = this.href;
                    var parent = document.getElementById(this.dataset.id);

                    $.ajax(action, {
                        method: 'DELETE',
                        data: {
                            '_token': window.laravel.csrfToken
                        },
                        complete: function (resp) {
                            resp = JSON.parse(resp.responseText);

                            if (resp.status) {
                                parent.parentNode.removeChild(parent);
                                validateMessage(resp.message);
                            } else {
                                alert(resp.message);
                            }
                        }
                    })
                }
            });

        })

        function validateMessage(response){
            var message = $('.responseMessage');
            message.html('<div class="alert alert-info alert-dismissible fade show" role="alert">'+
                            response +
                         '  <button type="button" class="close" data-dismiss="alert" aria-label="Close">'+
                         '    <span aria-hidden="true">&times;</span>'+
                         '  </button>'+
                         '</div>');
            setTimeout(function(){
                message.hide();
            }, 3000)
        }

    </script>
@stop
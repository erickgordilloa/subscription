@extends('guest.layout')

@section('css')
<style>
    body {
    font-family: "Kanit", sans-serif;
    background-color: #fff !important;
    margin: 0;
    margin-bottom: 10vh;
}
</style>

@section('js')
    <script>
        $(document).ready(function () {
            $.ajaxSetup({
                headers: {
                    "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr("content"),
                },
            });
        });

        function cancelar(id, name) {
            Swal.fire({
                title: "¡Cancelar suscripción!",
                text: "¿Desea cancelar la suscripción a " + name + "?",
                icon: "warning",
                showDenyButton: true,
                showCancelButton: true,
                confirmButtonText: "Confirmar",
                cancelButtonText: "Cancelar",
            }).then((result) => {
                /* Read more about isConfirmed, isDenied below */
                if (result.isConfirmed) {
                    $.ajax({
                        type: "DELETE",
                        url: "/suscripciones/"+id,
                        data: {
                            _token: $('meta[name="csrf-token"]').attr("content"),
                        },
                        beforeSend: function () {
                            Swal.fire({
                                title: "¡Espere, Por favor!",
                                html: "Cargando informacion...",
                                allowOutsideClick: false,
                                onBeforeOpen: () => {
                                    Swal.showLoading();
                                },
                            });
                        },
                        success: function (d) {
                            Swal.fire("¡Eliminado!","", "success");
                            setTimeout(() => {
                                location.reload();
                            }, 1500);
                        },
                        error: function (xhr) {
                            Swal.close();
                            toastr.error("Error: " + xhr.statusText + xhr.responseText);
                        },
                    });
                } else if (result.isDenied) {
                    Swal.fire("Changes are not saved", "", "info");
                }
            });
        }
    </script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@9"></script>
@stop

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-12">
            <div class="card border-primary">
                <div class="card-header"> Mis Suscripciones </div>
                <div class="card-body">
                    <div class="col-md-12">
                        <div class="row justify-content-center">
                            @forelse ($suscripciones as $rst)
                                <div class="col-md-4 mb-5 mt-3" >
                                    <div class="card border-primary">
                                        <div class="card" >
                                            <img src="{{$rst->subscription->imagen}}" class="card-img-top" alt="cafe">
                                            <div class="card-body">
                                            <h5 class="card-title">{{$rst->subscription->nombre}}</h5>
                                            <p class="card-text">{{$rst->subscription->detalle}}.</p>
                                            <p class="card-text">Tipo de suscripción: {{$rst->typeSubscription->name??''}}.</p>  
                                            <p class="card-text">Marca de Café: {{$rst->brand->name ?? ''}}.</p>  
                                            <p class="card-text">Tipo de Grano: {{$rst->type->name ?? ''}}.</p>  
                                            <button onclick="cancelar({{$rst->id}},'{{$rst->subscription->nombre}}')"  class="btn btn-danger mt-3">Cancelar suscripción</button>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            @empty
                                <p>Ningún dato disponible para mostrar =(</p>   
                            @endforelse
                        </div>
                        <div class="row justify-content-center p-4">
                            {!! $suscripciones->render() !!}
                        </div>
                    </div>
                </div>
            </div>
        </div>  
    </div>
</div>   
@stop
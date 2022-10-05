@extends('layouts.app')

@section('css')
    <link rel="stylesheet" href="../vendor/datatables/css/dataTables.bootstrap4.css">
@stop

@section('js')
    <script src="{{ asset('../js/personas.js') }}"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@9"></script>
    <script src="../../vendor/datatables/js/jquery.dataTables.js"></script>
    <script src="../../vendor/datatables/js/dataTables.bootstrap4.js"></script>
@stop

@section('title')
    <div class="page-title-heading">
        <div class="page-title-icon">
            <i class="pe-7s-users icon-gradient bg-strong-bliss">
            </i>
        </div>
        <div>Administración
            <div class="page-title-subheading">Listado de Suscriptores
            </div>

        </div>
    </div>
@endsection

@section('content')

    <div class="row">
        <div class="col-md-12">
            <div class="main-card mb-12 card">
                <div class="card-body">
                    <div id="div_table">

                    </div>
                </div>
            </div>
        </div>
    </div>

@stop

@section('modal')
<!-- Modal -->
<div class="modal fade modal-example" tabindex="-1" id="myModal" role="dialog" aria-labelledby="myLargeModalLabel" style="display: none;" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLongTitle">Datos de Contacto</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">×</span>
                </button>
            </div>
            <form id="formulario" class="form-horizontal">
                {{ csrf_field() }}
                <div class="modal-body">
                    <div class="row">
                        <div class="col">
                            <div class="form-group">
                                <label for="nombre" class="col-form-label">Nombre</label>
                                <input type="hidden" name="id" id="id">
                                <input type="text" id="nombre" name="nombre" class="form-control">
                                <label tipo="error" id="nombre-error"></label>
                            </div>
                        </div>
                        <div class="col">
                            <div class="form-group">
                                <label for="apellido" class="col-form-label">Apellido</label>
                                <input type="text" id="apellido" name="apellido" class="form-control">
                                <label tipo="error" id="apellido-error"></label>
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col">
                             <div class="form-group">
                                <label for="tipo" class="col-form-label">Tipo de Documento</label>
                                <input type="text" id="tipo" name="tipo" class="form-control">
                                <label tipo="error" id="tipo-error"></label>
                            </div>
                        </div>
                        <div class="col">
                            <div class="form-group">
                                <label for="identidad" class="col-form-label">N° Documento</label>
                                <input type="text" id="identidad" name="identidad" class="form-control">
                                <label tipo="error" id="identidad-error"></label>
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col">
                              <div class="form-group">
                                <label for="correo" class="col-form-label">Correo</label>
                                <input type="correo" id="correo" name="correo" class="form-control">
                                <label tipo="error" id="correo-error"></label>                      
                              </div>
                        </div>
                        <div class="col">
                              <div class="form-group">
                                <label for="direccion" class="col-form-label">Dirección</label>
                                <input type="direccion" id="direccion" name="direccion" class="form-control">
                                <label tipo="error" id="direccion-error"></label>                      
                              </div>
                        </div>
                    </div>  
                    <div class="row">
                        <div class="col">
                              <div class="form-group">
                                <label for="celular" class="col-form-label">Celular</label>
                                <input type="celular" id="celular" name="celular" class="form-control">
                                <label tipo="error" id="celular-error"></label>                      
                              </div>
                        </div>
                        <div class="col">
                             
                        </div>
                    </div>                    
                        
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal" onclick="limpiar()">Cerrar</button>
                    <button type="button" class="btn btn-primary"  data-dismiss="modal" id="btn_guardar">Guardar</button>
                </div>
            </form>
        </div>
    </div>
</div>
@stop








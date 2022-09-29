@extends('layouts.app')

@section('css')
    <link rel="stylesheet" href="../vendor/datatables/css/dataTables.bootstrap4.css">
    <style type="text/css">
    .ck-editor__editable {
   
        min-height: 150px;
    }
    .ck-rounded-corners .ck.ck-balloon-panel, .ck.ck-balloon-panel.ck-rounded-corners {
        z-index: 10055 !important;
    }
        
    </style>
@stop

@section('js')
    <script src="{{ asset('../js/subscriptions.js') }}"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@9"></script>
    <script src="../../vendor/datatables/js/jquery.dataTables.js"></script>
    <script src="../../vendor/datatables/js/dataTables.bootstrap4.js"></script>
    <script src="https://cdn.ckeditor.com/ckeditor5/22.0.0/classic/ckeditor.js"></script>
@stop

@section('title')
    <div class="page-title-heading">
        <div class="page-title-icon">
            <i class="pe-7s-ticket icon-gradient bg-strong-bliss">
            </i>
        </div>
        <div>Administración
            <div class="page-title-subheading">Listado de tipos de suscripción
            </div>

        </div>
    </div>
    <div class="page-title-actions">
        <button title="Guardar" data-placement="bottom" data-toggle="modal" data-target=".modal-example" id="agregar"
                class="btn-shadow mr-3 btn btn-success " onclick="limpiar()">
            <i class="fa fa-plus"></i> Agregar Tipo
        </button>
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
<div class="modal fade modal-example"  id="myModal" role="dialog" aria-labelledby="myLargeModalLabel" style="display: none;" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLongTitle">Tipo de subscription</h5>
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
                                <label for="detalle" class="col-form-label">Detalle</label>
                                <input type="text" id="detalle" name="detalle" class="form-control">
                                <label tipo="error" id="detalle-error"></label>
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col">
                              <div class="form-group">
                                <label for="monto" class="col-form-label">Monto</label>
                                <input type="monto" id="monto" name="monto" class="form-control">
                                <label tipo="error" id="monto-error"></label>                      
                              </div>
                        </div>
                        <div class="col">
                            <div class="row">
                                <div class="col">
                                    <div class="form-group">
                                        <label for="estado" class="col-form-label">Monto Editable</label> <br>
                                        <div class="custom-control custom-radio custom-control-inline">
                                          <input type="radio" id="si" name="es_editable" value="S" class="custom-control-input">
                                          <label class="custom-control-label" for="si">SI</label>
                                        </div>
                                        <div class="custom-control custom-radio custom-control-inline">
                                          <input type="radio" id="no" name="es_editable" value="N" class="custom-control-input" checked>
                                          <label class="custom-control-label" for="no">NO</label>
                                        </div>
                                        <label tipo="error" id="es_editable-error"></label>                     
                                      </div>
                                </div>
                                <div class="col">
                                    <div class="form-group">
                                        <label for="estado" class="col-form-label">Estado</label> <br>
                                        <div class="custom-control custom-radio custom-control-inline">
                                          <input type="radio" id="activo" name="estado" value="A" class="custom-control-input">
                                          <label class="custom-control-label" for="activo">Activo</label>
                                        </div>
                                        <div class="custom-control custom-radio custom-control-inline">
                                          <input type="radio" id="inactivo" name="estado" value="I" class="custom-control-input">
                                          <label class="custom-control-label" for="inactivo">Inactivo</label>
                                        </div>
                                        <label tipo="error" id="estado-error"></label>
                                    </div>
                                </div>
                            </div>
                            
                        </div>
                    </div>

                    <div class="row">
                        <div class="col">
                            <div class="form-group">
                              <label for="texto" class="col-form-label">Texto Adjunto</label>
                              <textarea id="texto" name="texto" rows="7"></textarea>
                            </div>
                        </div>
                    </div>

                    {{--<div class="row">
                                                                <div class="col">
                                                                    <div class="form-group row">
                                                                      <label for="texto" class="col-form-label col-lg-5">¿Cuantos archivos adjuntos deseas incluir?</label>
                                                                      <input type="text" name="cantidad" id="cantidad" class="form-control col-lg-2">
                                                                    </div>
                                                                </div>
                                                            </div>--}}
                    <div id="cantidades">
                        
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


<div class="modal fade modal-archivo" tabindex="-1" id="myModalfile" role="dialog" aria-labelledby="myLargeModalLabel" style="display: none;" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLongTitle">Archivos</h5>
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
                                <label for="file_name" class="col-form-label">Nombre</label>
                                <input type="hidden" name="subscription_id" id="subscription_id">
                                <input type="text" id="file_name" name="file_name" class="form-control">
                                <label tipo="error" id="file_name-error"></label>
                            </div>
                        </div>
                    </div>

                   
                    <div class="row">
                        <div class="col">
                            <div class="form-group">
                                <label for="archivo" class="col-form-label">Archivo</label>
                                <input type="file" id="archivo" name="archivo" class="form-control">
                                <label tipo="error" id="archivo-error"></label>
                            </div>
                        </div>
                    </div>

                                      
                        
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal" onclick="limpiar()">Cerrar</button>
                    <button type="button" class="btn btn-primary"  data-dismiss="modal" id="btn_guardar_archivo">Guardar</button>
                </div>
            </form>
        </div>
    </div>
</div>
@stop






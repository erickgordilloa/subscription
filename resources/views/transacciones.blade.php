@extends('layouts.app')

@section('css')
    <link rel="stylesheet" href="../vendor/datatables/css/dataTables.bootstrap4.css">
@stop

@section('js')
    <script src="{{ asset('../js/transacciones.js') }}"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@9"></script>
    <script src="../../vendor/datatables/js/jquery.dataTables.js"></script>
    <script src="../../vendor/datatables/js/dataTables.bootstrap4.js"></script>
@stop

@section('title')
    <div class="page-title-heading">
        <div class="page-title-icon">
            <i class="pe-7s-id icon-gradient bg-strong-bliss">
            </i>
        </div>
        <div>Administración
            <div class="page-title-subheading">Listado de Transacciones
            </div>

        </div>
    </div>
    <div class="page-title-actions">
        <form id="export-form" action="{{ route('export') }}" method="POST" style="display: none;">
            {{ csrf_field() }}
            <input type="hidden" name="fecha_inicio" id="fecha_inicio">
            <input type="hidden" name="final" id="final">
            <input type="hidden" name="estado_export" id="estado_export">
        </form>
        {{-- <button title="Guardar" data-placement="bottom" 
                class="btn-shadow mr-3 btn btn-primary "  onclick="event.preventDefault(); document.getElementById('export-form').submit();">
            <i class="fa fa-file-excel-o"></i> Exportar 
        </button> --}}
    </div>
@endsection

@section('content')
    <div class="row">
        <div class="col-md-12">
            <div class="main-card mb-12 card">
                <div class="card-body">
                    <div>
                        <form class="needs-validation" novalidate id="form_search">
                            {{ csrf_field() }}
                          <div class="form-row">
                            <div class="col-md-5 mb-3">
                              <label for="validationCustom01">Fecha</label>
                              <div id="reportrange" style="background: #fff; cursor: pointer; padding: 5px 10px; border: 1px solid #ccc; width: 100%">
                                    <i class="fa fa-calendar"></i>&nbsp;
                                    <span></span> <i class="fa fa-caret-down"></i>
                                </div>
                            </div>
                            <div class="col-md-4 mb-3">
                              <label for="validationCustom02">Estado</label>
                                <select class="form-control" id="estado" name="estado">
                                    <option value="-1" selected disabled>Seleccione</option>
                                    <option value="">Todos</option>
                                    @foreach($estados as $estado)
                                    <option value="{{ $estado->status }}">{{ $estado->status }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="col-md-3 mb-3">
                              <button style="margin-top: 30px;" type="button" class="btn btn-success" id="busqueda" onclick="view_table()">Buscar</button>
                            </div>
                          </div>
                        </form>
                    </div>
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
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLongTitle">Reembolso</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">×</span>
                </button>
            </div>
            <form id="formulario" class="form-horizontal">
                {{ csrf_field() }}
                <div class="modal-body">
                  <div class="form-group">
                    <label for="detalle" class="col-form-label">Detalle del reembolso</label>
                    
                        <input type="hidden" name="id_response" id="id_response">
                        <textarea id="detalle" name="detalle" class="form-control" maxlength="250" rows="6"></textarea>
                        <label tipo="error" id="detalle-error"></label>
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

<!-- Modal -->
<div class="modal fade modal-reference" tabindex="-1" id="myModalreference" role="dialog" aria-labelledby="myLargeModalLabel" style="display: none;" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLongTitle">Cambiar tipo de subscription</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">×</span>
                </button>
            </div>
            <form id="formularioreference" class="form-horizontal">
                {{ csrf_field() }}
                <div class="modal-body">
                  <div class="form-group">
                    <label for="detalle" class="col-form-label">Tipo de subscription</label>
                        <input type="hidden" name="transaccion_id" id="transaccion_id">
                        <select class="form-control" id="reference" name="reference">
                        @foreach ($subscriptions as $element)
                            <option value="{{ $element->id }}">{{ $element->nombre }}</option>
                        @endforeach
                        </select>
                    </div>
                  </div>                       
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal" >Cerrar</button>
                    <button type="button" class="btn btn-primary"  data-dismiss="modal" id="btn_guardar_reference">Guardar</button>
                </div>
            </form>
        </div>
    </div>
</div>
@stop







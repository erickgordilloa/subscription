@extends('guest.layout')


@section('js')
    <script src="{{ asset('../js/perfil.js') }}"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@9"></script>
    <script src="../../vendor/datatables/js/jquery.dataTables.js"></script>
    <script src="../../vendor/datatables/js/dataTables.bootstrap4.js"></script>
    <script src="https://cdn.ckeditor.com/ckeditor5/22.0.0/classic/ckeditor.js"></script>
   

   
@stop
@section('content')
<div class="container">
    <ul class="body-tabs body-tabs-layout tabs-animated body-tabs-animated nav">
            <li class="nav-item">
            <a role="tab" class="nav-link active" id="tab-0" data-toggle="tab" href="#tab-content-0" aria-selected="true">
            <span>Datos Personales</span>
            </a>
        </li>
        <li class="nav-item">
            <a role="tab" class="nav-link" id="tab-1" data-toggle="tab" href="#tab-content-1" aria-selected="false">
            <span>Dirección</span>
            </a>
        </li>
        <li class="nav-item">
            <a role="tab" class="nav-link" id="tab-1" data-toggle="tab" href="#tab-content-2" aria-selected="false">
            <span>Facturación</span>
            </a>
        </li>
    </ul>

        <div class="tab-content mt-3">
            <div class="tab-pane tabs-animation fade active show" id="tab-content-0" role="tabpanel">
                <div class="row justify-content-center">
                    <div class="col-md-12">
                        <div class="card border-primary">
                            
                            <div class="card-body">
                                <form>
                                    <div class="form-group">
                                      <label for="name">Nombre</label>
                                      <input type="text" class="form-control" id="name" value="{{Auth::user()->name}}">
                                    </div>
                                    <div class="form-group">
                                      <label for="email">Correo electronico</label>
                                      <input type="email" class="form-control" id="email" value="{{Auth::user()->email}}" disabled style="background-color: #e9ecef !important">
                                    </div>
                                    <div class="form-group">
                                      <label for="password">Contraseña</label>
                                      <input type="password" class="form-control" id="password">
                                    </div>
                                    <div class="form-group">
                                      <label for="confirm_password">Confirmar contraseña</label>
                                      <input type="password" class="form-control" id="confirm_password">
                                    </div>
                                    <button type="submit" class="btn btn-primary">Guardar</button>
                                </form>
                            </div>
                        </div>
                    </div>  
                </div>
            </div>

            <div class="tab-pane tabs-animation fade" id="tab-content-1" role="tabpanel">
                <div class="row justify-content-center">
                    <div class="col-md-8">
                        <div class="card">
                            <div class="card-header"> Agregar tarjeta </div>
            
                            <div class="card-body">
                            <form id="add-card-form">
                                <div class="payment-form" id="my-card" data-capture-name="true"></div>
                                <button class="btn btn-primary btn-block">Guardar</button>
                                <br/>
                                <div id="messages"></div>
                            </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            
            <div class="tab-pane tabs-animation fade" id="tab-content-2" role="tabpanel">
                <div class="row justify-content-center">
                    <div class="col-md-8">
                        <div class="card">
                            <div class="card-header"> Agregar tarjeta </div>
            
                            <div class="card-body">
                            <form id="add-card-form">
                                <div class="payment-form" id="my-card" data-capture-name="true"></div>
                                <button class="btn btn-primary btn-block">Guardar</button>
                                <br/>
                                <div id="messages"></div>
                            </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

        </div>
    
</div>
@stop


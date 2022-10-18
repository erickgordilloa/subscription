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
    @if(Session::has('message'))
    <p class="alert alert-info">{{ Session::get('message') }}</p>
    @endif
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
                                <form method="POST" action="{{ route('perfil.data') }}">
                                    {{ csrf_field() }}
                                    <div class="form-group">
                                      <label for="name">Nombre</label>
                                      <input type="text" class="form-control @error('name') is-invalid @enderror" id="name" name="name" value="{{Auth::user()->name}}">
                                        @error('name')
                                        <span class="invalid-feedback" role="alert">
                                          <strong>{{ $message }}</strong>
                                        </span>
                                        @enderror
                                    </div>
                                    <div class="form-group">
                                      <label for="email">Correo electronico</label>
                                      <input type="email" class="form-control" id="email" value="{{Auth::user()->email}}" disabled style="background-color: #e9ecef !important">
                                    </div>
                                    <div class="form-group">
                                      <label for="password">Contraseña</label>
                                      <input type="password" class="form-control @error('password') is-invalid @enderror" id="password" name="password">
                                      @error('password')
                                        <span class="invalid-feedback" role="alert">
                                          <strong>{{ $message }}</strong>
                                        </span>
                                        @enderror
                                    </div>
                                    <div class="form-group">
                                      <label for="password_confirmation">Confirmar contraseña</label>
                                      <input type="password" class="form-control  @error('password_confirmation') is-invalid @enderror" id="password_confirmation" name="password_confirmation">
                                      @error('password_confirmation')
                                        <span class="invalid-feedback" role="alert">
                                          <strong>{{ $message }}</strong>
                                        </span>
                                        @enderror
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
                    <div class="col-md-12">
                        <div class="card border-primary">
                            
                            <div class="card-body">
                                <form method="POST" action="{{ route('perfil.direccion') }}">
                                    {{ csrf_field() }}
                                    <div class="form-group">
                                        <label for="provincia">Provincia</label>
                                        <select name="provincia" id="provincia" class="form-control  @error('provincia') is-invalid @enderror">  
                                            <option value="Azuay" @if(Auth::user()->provincia == "Azuay") selected @endif >Azuay</option>  
                                            <option value="Cañar"  @if(Auth::user()->provincia == "Cañar") selected @endif>Cañar</option>  
                                            <option value="Loja"  @if(Auth::user()->provincia == "Loja") selected @endif>Loja</option>  
                                            <option value="Carchi"  @if(Auth::user()->provincia == "Carchi") selected @endif>Carchi</option>  
                                            <option value="Imbabura"  @if(Auth::user()->provincia == "Imbabura") selected @endif>Imbabura</option>  
                                            <option value="Pichincha"  @if(Auth::user()->provincia == "Pichincha") selected @endif>Pichincha</option>  
                                            <option value="Cotopaxi"  @if(Auth::user()->provincia == "Cotopaxi") selected @endif>Cotopaxi</option>  
                                            <option value="Tungurahua"  @if(Auth::user()->provincia == "Tungurahua") selected @endif>Tungurahua</option>  
                                            <option value="Bolívar"  @if(Auth::user()->provincia == "Bolívar") selected @endif>Bolívar</option>  
                                            <option value="Chimborazo"  @if(Auth::user()->provincia == "Chimborazo") selected @endif>Chimborazo</option>  
                                            <option value="Sto. Domingo de los Tsachilas"  @if(Auth::user()->provincia == "Sto. Domingo de los Tsachilas") selected @endif>Sto. Domingo de los Tsachilas</option>  
                                            <option value="Esmeraldas"  @if(Auth::user()->provincia == "Esmeraldas") selected @endif>Esmeraldas</option>  
                                            <option value="Manabí"  @if(Auth::user()->provincia == "Manabí") selected @endif>Manabí</option>  
                                            <option value="Guayas"  @if(Auth::user()->provincia == "Guayas") selected @endif>Guayas</option>  
                                            <option value="Los Ríos"  @if(Auth::user()->provincia == "Los Ríos") selected @endif>Los Ríos</option>  
                                            <option value="El Oro"  @if(Auth::user()->provincia == "El Oro") selected @endif>El Oro</option>  
                                            <option value="Santa Elena"  @if(Auth::user()->provincia == "Santa Elena") selected @endif>Santa Elena</option>  
                                            <option value="Sucumbíos"  @if(Auth::user()->provincia == "Sucumbíos") selected @endif>Sucumbíos</option>  
                                            <option value="Napo"  @if(Auth::user()->provincia == "Napo") selected @endif>Napo</option>  
                                            <option value="Pastaza"  @if(Auth::user()->provincia == "Pastaza") selected @endif>Pastaza</option>  
                                            <option value="Orellana"  @if(Auth::user()->provincia == "Orellana") selected @endif>Orellana</option>  
                                            <option value="Morona Santiago"  @if(Auth::user()->provincia == "Morona Santiago") selected @endif>Morona Santiago</option>  
                                            <option value="Zamora Chinchipe"  @if(Auth::user()->provincia == "Zamora Chinchipe") selected @endif>Zamora Chinchipe</option>  
                                            <option value="Galápagos"  @if(Auth::user()->provincia == "Galápagos") selected @endif>Galápagos</option>  
                                        </select> 
                                        @error('provincia')
                                        <span class="invalid-feedback" role="alert">
                                          <strong>{{ $message }}</strong>
                                        </span>
                                        @enderror 
                                    </div>
                                    <div class="form-group">
                                      <label for="ciudad">Ciudad</label>
                                      <input type="text" class="form-control  @error('ciudad') is-invalid @enderror"  id="ciudad" name="ciudad" value="{{Auth::user()->ciudad}}">
                                      @error('ciudad')
                                        <span class="invalid-feedback" role="alert">
                                          <strong>{{ $message }}</strong>
                                        </span>
                                        @enderror 
                                    </div>
                                    <div class="form-group">
                                      <label for="telefono">Telefono</label>
                                      <input type="text" class="form-control  @error('telefono') is-invalid @enderror"  id="telefono" name="telefono" value="{{Auth::user()->telefono}}">
                                      @error('telefono')
                                        <span class="invalid-feedback" role="alert">
                                          <strong>{{ $message }}</strong>
                                        </span>
                                        @enderror 
                                    </div>
                                    <div class="form-group">
                                      <label for="direccion">Dirección de la calle</label>
                                      <input type="text" class="form-control  @error('direccion') is-invalid @enderror"  id="direccion" name="direccion" value="{{Auth::user()->direccion}}">
                                      @error('direccion')
                                        <span class="invalid-feedback" role="alert">
                                          <strong>{{ $message }}</strong>
                                        </span>
                                        @enderror 
                                    </div>
                                    <div class="form-group">
                                      <label for="referencia">Referencia</label>
                                      <input type="text" class="form-control  @error('password_confirmation') is-invalid @enderror"  id="referencia" name="referencia" value="{{Auth::user()->Referencia}}">
                                      @error('referencia')
                                        <span class="invalid-feedback" role="alert">
                                          <strong>{{ $message }}</strong>
                                        </span>
                                        @enderror 
                                    </div>
                                    <button type="submit" class="btn btn-primary">Guardar Dirección</button>
                                </form>
                            </div>

                        </div>
                    </div>  
                </div>
            </div>
            
            <div class="tab-pane tabs-animation fade" id="tab-content-2" role="tabpanel">
                <div class="row justify-content-center">
                    <div class="col-md-12">
                        <div class="card border-primary">   
                            <div class="card-body">
                                <form method="POST" action="{{ route('perfil.factura') }}">
                                    {{ csrf_field() }}
                                    <div class="form-group">
                                      <label for="provincia_fac">Provincia</label>
                                      <select id="provincia_fac" name="provincia_fac" class="form-control  @error('provincia_fac') is-invalid @enderror"> 
                                            <option value="Azuay" @if(Auth::user()->provincia_fac == "Azuay") selected @endif >Azuay</option>  
                                            <option value="Cañar"  @if(Auth::user()->provincia_fac == "Cañar") selected @endif>Cañar</option>  
                                            <option value="Loja"  @if(Auth::user()->provincia_fac == "Loja") selected @endif>Loja</option>  
                                            <option value="Carchi"  @if(Auth::user()->provincia_fac == "Carchi") selected @endif>Carchi</option>  
                                            <option value="Imbabura"  @if(Auth::user()->provincia_fac == "Imbabura") selected @endif>Imbabura</option>  
                                            <option value="Pichincha"  @if(Auth::user()->provincia_fac == "Pichincha") selected @endif>Pichincha</option>  
                                            <option value="Cotopaxi"  @if(Auth::user()->provincia_fac == "Cotopaxi") selected @endif>Cotopaxi</option>  
                                            <option value="Tungurahua"  @if(Auth::user()->provincia_fac == "Tungurahua") selected @endif>Tungurahua</option>  
                                            <option value="Bolívar"  @if(Auth::user()->provincia_fac == "Bolívar") selected @endif>Bolívar</option>  
                                            <option value="Chimborazo"  @if(Auth::user()->provincia_fac == "Chimborazo") selected @endif>Chimborazo</option>  
                                            <option value="Sto. Domingo de los Tsachilas"  @if(Auth::user()->provincia_fac == "Sto. Domingo de los Tsachilas") selected @endif>Sto. Domingo de los Tsachilas</option>  
                                            <option value="Esmeraldas"  @if(Auth::user()->provincia_fac == "Esmeraldas") selected @endif>Esmeraldas</option>  
                                            <option value="Manabí"  @if(Auth::user()->provincia_fac == "Manabí") selected @endif>Manabí</option>  
                                            <option value="Guayas"  @if(Auth::user()->provincia_fac == "Guayas") selected @endif>Guayas</option>  
                                            <option value="Los Ríos"  @if(Auth::user()->provincia_fac == "Los Ríos") selected @endif>Los Ríos</option>  
                                            <option value="El Oro"  @if(Auth::user()->provincia_fac == "El Oro") selected @endif>El Oro</option>  
                                            <option value="Santa Elena"  @if(Auth::user()->provincia_fac == "Santa Elena") selected @endif>Santa Elena</option>  
                                            <option value="Sucumbíos"  @if(Auth::user()->provincia_fac == "Sucumbíos") selected @endif>Sucumbíos</option>  
                                            <option value="Napo"  @if(Auth::user()->provincia_fac == "Napo") selected @endif>Napo</option>  
                                            <option value="Pastaza"  @if(Auth::user()->provincia_fac == "Pastaza") selected @endif>Pastaza</option>  
                                            <option value="Orellana"  @if(Auth::user()->provincia_fac == "Orellana") selected @endif>Orellana</option>  
                                            <option value="Morona Santiago"  @if(Auth::user()->provincia_fac == "Morona Santiago") selected @endif>Morona Santiago</option>  
                                            <option value="Zamora Chinchipe"  @if(Auth::user()->provincia_fac == "Zamora Chinchipe") selected @endif>Zamora Chinchipe</option>  
                                            <option value="Galápagos"  @if(Auth::user()->provincia_fac == "Galápagos") selected @endif>Galápagos</option>  
                                    
                                    </select> 
                                    @error('provincia_fac')
                                    <span class="invalid-feedback" role="alert">
                                      <strong>{{ $message }}</strong>
                                    </span>
                                    @enderror 
                                    </div>
                                    <div class="form-group">
                                      <label for="ciudad_fac">Ciudad</label>
                                      <input type="text" class="form-control  @error('ciudad_fac') is-invalid @enderror"  id="ciudad_fac" name="ciudad_fac" value="{{Auth::user()->ciudad_fac}}" >
                                      @error('ciudad_fac')
                                        <span class="invalid-feedback" role="alert">
                                          <strong>{{ $message }}</strong>
                                        </span>
                                        @enderror 
                                    </div>
                                    <div class="form-group">
                                      <label for="direccion_fac">Dirección</label>
                                      <input type="text" class="form-control  @error('direccion_fac') is-invalid @enderror"  id="direccion_fac" name="direccion_fac" value="{{Auth::user()->direccion_fac}}">
                                      @error('direccion_fac')
                                      <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                      </span>
                                      @enderror 
                                    </div>
                                    <div class="form-group">
                                      <label for="documento_identidad">Documento de indentidad</label>
                                      <input type="text" class="form-control  @error('documento_identidad') is-invalid @enderror"  id="documento_identidad" name="documento_identidad" value="{{Auth::user()->documento_identidad}}">
                                      @error('documento_identidad')
                                      <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                      </span>
                                      @enderror 
                                    </div>
                                    <button type="submit" class="btn btn-primary">Guardar</button>
                                </form>
                            </div>
                        </div>
                    </div>  
                </div>
            </div>

        </div>
</div>
@stop


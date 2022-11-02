@extends('guest.layout')

@section('js')
    <script src="{{ asset('../js/guest.js') }}"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@9"></script>
    <script src="../../vendor/datatables/js/jquery.dataTables.js"></script>
    <script src="../../vendor/datatables/js/dataTables.bootstrap4.js"></script>
    <script src="https://cdn.ckeditor.com/ckeditor5/22.0.0/classic/ckeditor.js"></script>
@stop


@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-12">
            <div class="row justify-content-center">
                @forelse ($suscripciones as $rst)
                    <div class="col-md-4 mb-5 mt-3" >
                        <div class="card border-primary">
                            <div class="card" >
                                <img src="{{$rst->imagen}}" class="card-img-top" alt="cafe">
                                <div class="card-body">
                                    <h5 class="card-title">{{$rst->nombre}}</h5>
                                    <p class="card-text">{{$rst->detalle}}.</p>
                                    <div class="form-group row">
                                        <label for="brand{{$rst->id}}" class="col-sm-5 col-form-label">Marca de Café</label>
                                        <div class="col-sm-7">
                                            <select name="brand" id="brand_{{$rst->id}}" class="form-control">
                                                @foreach ($brands as $brand)
                                                    <option value="{{$brand->id}}">{{$brand->name}}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                      </div>

                                   
                                      <div class="form-group row">
                                        <label for="type_{{$rst->id}}" class="col-sm-5 col-form-label">Tipo de Grano</label>
                                        <div class="col-sm-7">
                                            <select name="type" id="type_{{$rst->id}}" class="form-control">
                                                @foreach ($types as $type)
                                                    <option value="{{$type->id}}">{{$type->name}}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                      </div>

                                      <div class="form-group row">
                                        <label for="month_{{$rst->id}}" class="col-sm-5 col-form-label">Suscripción</label>
                                        <div class="col-sm-7">
                                            <select name="month" id="month_{{$rst->id}}" class="form-control">
                                                @foreach ($typeSubscriptions as $typeSubscription)
                                                    <option value="{{$typeSubscription->id}}">{{$typeSubscription->name}}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                      </div>

                                    @guest
                                    <a class="btn btn-primary mt-3 btn-block" href="{{ route('register') }}">suscribirse ${{$rst->monto ? number_format($rst->monto, 2, '.', ',') : '0.00'}}</a>
                                    @else
                                    @if (Auth::user()->role->name == 'Suscriptor')
                                        <button onclick="subscribirse({{$rst->id}},'{{$rst->nombre}}')" class="btn btn-primary mt-3 btn-block">suscribirse ${{$rst->monto ? number_format($rst->monto, 2, '.', ',') : '0.00'}}</button>    
                                    @endif
                                    @endguest
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
@endsection
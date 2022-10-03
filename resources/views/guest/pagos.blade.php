@extends('guest.layout')


@section('js')
    <script src="{{ asset('../js/pagos.js') }}"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@9"></script>
    <script src="../../vendor/datatables/js/jquery.dataTables.js"></script>
    <script src="../../vendor/datatables/js/dataTables.bootstrap4.js"></script>
    <script src="https://cdn.ckeditor.com/ckeditor5/22.0.0/classic/ckeditor.js"></script>
   

@stop

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-12">
            <div class="card border-primary">
                <div class="card-header"> 
                    Listado de pagos
                </div>
                <div class="card-body">
                    <div id="div_table">
    
                    </div>
                </div>
            </div>
        </div>  
    </div>
</div>
@stop


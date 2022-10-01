@extends('guest.layout')




@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-12">
            <div class="row justify-content-center">
                @for($i=0;$i<20;$i++)
                    <div class="col-md-4 mb-5 mt-3" >
                        <div class="card border-primary">
                            <div class="card" >
                                <img src="https://paqucafe.com/wp-content/uploads/2021/08/CAJA-DOBLE.jpg" class="card-img-top" alt="cafe">
                                <div class="card-body">
                                <h5 class="card-title">Card title</h5>
                                <p class="card-text">Some quick example text to build on the card title and make up the bulk of the card's content.</p>
                                <a href="#" class="btn btn-primary">Seleccionar</a>
                                </div>
                            </div>
                        </div>
                    </div>
                @endfor
            </div>
            {{-- <div class="row justify-content-center p-4">
                {!! $ofertas->render() !!}
            </div> --}}
        </div>
    </div>
</div>
@endsection
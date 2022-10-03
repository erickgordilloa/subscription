@extends('guest.layout')


@section('js')
    <script src="{{ asset('../js/cards.js') }}"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@9"></script>
    <script src="../../vendor/datatables/js/jquery.dataTables.js"></script>
    <script src="../../vendor/datatables/js/dataTables.bootstrap4.js"></script>
    <script src="https://cdn.ckeditor.com/ckeditor5/22.0.0/classic/ckeditor.js"></script>
   
    <script src="https://cdn.paymentez.com/ccapi/sdk/payment_stable.min.js" charset="UTF-8"></script>

    <script>
        $(function () {
      
          
          Payment.init('stg', 'TPP3-EC-CLIENT', 'ZfapAKOk4QFXheRNvndVib9XU3szzg');
      
          let form = $("#add-card-form");
          let submitButton = form.find("button");
          let submitInitialText = submitButton.text();
      
          $("#add-card-form").submit(function (e) {
            let myCard = $('#my-card');
            $('#messages').text("");
            let cardToSave = myCard.PaymentForm('card');
            if (cardToSave == null) {
              $('#messages').text("Invalid Card Data");
            } else {
              submitButton.attr("disabled", "disabled").text("Card Processing...");      
              let uid = "{{ Auth::user()->id }}";
              let email = "{{ Auth::user()->email }}";
              Payment.addCard(uid, email, cardToSave, successHandler, errorHandler);
            }
            e.preventDefault();
          });
      
      
          let successHandler = function (cardResponse) {
            console.log(cardResponse.card);
            if (cardResponse.card.status === 'valid') {
                saveCard(cardResponse,'valid');
            } else if (cardResponse.card.status === 'review') {
                saveCard(cardResponse,'review');
            } else {

              Swal.fire({
                icon: 'error',
                title: 'Oops...',
                text: cardResponse.card.message
                });
              
            }
            submitButton.removeAttr("disabled");
            submitButton.text(submitInitialText);
          };
      
          let errorHandler = function (err) {
            console.log(err.error);
            Swal.fire({
                icon: 'error',
                title: 'Oops...',
                text: err.error.type
                });
            submitButton.removeAttr("disabled");
            submitButton.text(submitInitialText);
          };
        });

        function saveCard(response,status){
            $.ajax({
                type: "POST",
                url: "/tarjetas",
                data: {
                    _token: $('meta[name="csrf-token"]').attr("content"),
                    response:response
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
                    Swal.close();
                    if (d["msg"] == "success") {
                        view_table();
                        if(status == 'review'){
                            Swal.fire("Éxito", "Tarjeta en revisión", "warning");
                        }else{
                            Swal.fire("Éxito", d["data"], "success");
                        }
                    } else {
                        Swal.fire("¡Oops!", d["data"], "error");
                    }
                },
                error: function (xhr) {
                    Swal.close();
                    toastr.error("Error: " + xhr.statusText + xhr.responseText);
                },
            });
        }
      </script>
@stop

@section('css')
<link href="https://cdn.paymentez.com/ccapi/sdk/payment_stable.min.css" rel="stylesheet" type="text/css"/>
<style>
    .panel {
      margin: 0 auto;
      background-color: #F5F5F7;
      border: 1px solid #ddd;
      padding: 20px;
      display: block;
      width: 80%;
      border-radius: 6px;
      box-shadow: 0 2px 4px rgba(0, 0, 0, .1);
    }
    .btn:hover {
      cursor: pointer;
    }
  
    .payment-form .icon {
      position: absolute;
      display: block;
      width: 24px;
      height: 17px;
      left: 8px;
      top: 5px;
      pointer-events: none;
  }
  </style>
@stop
@section('content')
<div class="container">
    <ul class="body-tabs body-tabs-layout tabs-animated body-tabs-animated nav">
        <li class="nav-item">
        <a role="tab" class="nav-link active" id="tab-0" data-toggle="tab" href="#tab-content-0" aria-selected="true">
        <span>Listado</span>
        </a>
        </li>
        <li class="nav-item">
        <a role="tab" class="nav-link" id="tab-1" data-toggle="tab" href="#tab-content-1" aria-selected="false">
        <span>Agregar tarjeta</span>
        </a>
        </li>
        </ul>

        <div class="tab-content mt-3">
            <div class="tab-pane tabs-animation fade active show" id="tab-content-0" role="tabpanel">
                <div class="row justify-content-center">
                    <div class="col-md-12">
                        <div class="card border-primary">
                            <div class="card-header"> 
                                Listado de tarjetas
                            </div>
                            <div class="card-body">
                                <div id="div_table">
                
                                </div>
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
        </div>
    
</div>
@stop


<!DOCTYPE html>
<html>
@include('web.head')
<body>
		<nav class="secundario p-4" >
			<div class="container">
				<div class="row">
					<div class="col-md-4  col-xs-12">
						<img src="/images/logo.png">
					</div>
					<div class="col-md-8  col-xs-12">
						<h3 class="notice bottom">¡Tu aporte nos ayuda a soñar y crecer!</h3>
					</div>
				</div>
			</div>
		</nav>

		<section class="section">
			<div class="container p-5">
				<div class="row justify-content-md-center">
					<div class="col-md-10 col-xs-12">
						<div class="border-form">
							<h2 class="title p-4 text-center">{{ config('app.name', 'Suscripción') }}</h2>

							<!-- Nav tabs -->
								<ul class="nav nav-tabs nav-justified">
								  <li class="nav-item">
								    <a class="nav-link active" data-toggle="tab" href="#form"><b>Debito / Crédito</b></a>
								  </li>
								  <li class="nav-item">
								    <a class="nav-link" data-toggle="tab" href="#debit"><b>Transferencias y depósitos</b></a>
								  </li>
								  <li class="nav-item">
								    <a class="nav-link" data-toggle="tab" href="#ayuda"><b>Ayuda Social</b></a>
								  </li>
								</ul>

								<!-- Tab panes -->
								<div class="tab-content">
								  <div class="tab-pane container active" id="form">
								  	<form class="p-4" name="formulario" id="formulario" method="POST">
								  		@csrf
						                <div class="row">
						                  <div class="col-md-6 col-xs-12">
						                    <div class="form-group">
						                    <label for="nombre">Nombres</label>
						                    <input type="text" class="form-control" id="nombre" name="nombre" placeholder="">
						                    <label tipo="error" id="nombre-error"></label>
						                    <input type="hidden" class="form-control" id="id_user" name="id_user">
						                  </div>
						                  </div>
						                  <div class="col-md-6 col-xs-12">
						                    <div class="form-group">
						                    <label for="apellido">Apellidos</label>
						                    <input type="text" class="form-control" id="apellido" name="apellido" placeholder="">
						                    <label tipo="error" id="apellido-error"></label>
						                  </div>
						                  </div>
						                </div>
						                <div class="row">
						                <div class="col-md-6 col-xs-12">
						                    <div class="form-group">
						                    <label for="tipo_identidad">Tipo de Documento de Identidad</label>
						                    <select name="tipo_identidad" id="tipo_identidad" class="form-control">
						                    	<option value="" selected disabled>Seleccione</option>
						                    	<option value="1">Cédula</option>
						                    	<option value="2">Ruc</option>
						                    	<option value="3">Pasaporte</option>
						                    </select>
						                    <label tipo="error" id="tipo_identidad-error"></label>
						                  </div>


						                </div>
						                   <div class="col-md-6 col-xs-12">
						                    <div class="form-group">
						                    <label for="cedula">Documento de Identidad</label>
						                    <input type="text" class="form-control" id="cedula" name="cedula" placeholder="">
						                    <label tipo="error" id="cedula-error"></label>
						                  </div>
						                  </div>
						              </div>
						                <div class="row">
						                  <div class="col-md-6 col-xs-12">
						                    <div class="form-group">
						                    <label for="correo">Correo Electrónico</label>
						                    <input type="text" class="form-control" id="correo" name="correo" placeholder="">
						                    <label tipo="error" id="correo-error"></label>
						                  </div>
						                  </div>
						                  <div class="col-md-6 col-xs-12">
						                    <div class="form-group">
						                    <label for="direccion">Dirección</label>
						                    <input type="text" id="direccion" name="direccion" class="form-control">
						                    <label tipo="error" id="direccion-error"></label>
						                  </div>
						                  </div>

						                </div>

						                 <div class="row">
						                 

						                  <div class="col-md-6 col-xs-12">
						                    <div class="form-group">
						                    <label for="tipo">Tipo de suscripción</label>
						                    <select name="tipo" id="tipo" class="form-control">
						                      <option value="" selected disabled>Seleccione</option>
						                      @foreach($subscriptions as $subscription)
						                      	<option data-aumont="{{$subscriptions->monto}}" data-editable="{{$subscriptions->es_editable}}" value="{{$subscriptions->id}}">{{$subscriptions->nombre}}</option>
						                      @endforeach
						                    </select>
						                    <label tipo="error" id="tipo-error"></label>
						                  </div>
						                  </div>


						                  <div class="col-md-6 col-xs-12">
						                    <div class="form-group">
						                    <label for="monto">Ingrese o seleccione el valor de su donanción</label>
						                    <input type="text" class="form-control monto" id="monto" name="monto"  placeholder="">
						                    <label tipo="error" id="monto-error"></label>
						                  </div>
						                  </div>



						                </div>




						                <div class="row">


						                  

						                   <div class="col-md-6 col-xs-12">
						                    <div class="form-group">
						                    <label for="comentario">Comentarios</label>
						                    <textarea id="comentario" name="comentario" class="form-control" maxlength="300" rows="5"></textarea>
						                    <label tipo="error" id="comentario-error"></label>
						                  </div>
						                  </div>

						                  <div class="col-md-6 col-xs-12">
						                    <div class="form-group">
						                    <label for="celular">Celular</label>
						                    <input type="text" class="form-control" id="celular" name="celular" placeholder="">
						                    <label tipo="error" id="celular-error"></label>
						                  </div>
						                  </div>

						                </div>


						                <div class="row" id="valores">
						                	<div class="col margen">
						                		<a onclick="setValue(5)" class="btn btn-default" id="5">$5</a>
						                	</div>
						                	<div class="col margen">
						                		<a onclick="setValue(10)" class="btn btn-default" id="10">$10</a>
						                	</div>
						                	<div class="col margen">
						                		<a onclick="setValue(25)" class="btn btn-default" id="25">$25</a>
						                	</div>
						                	<div class="col margen">
						                		<a onclick="setValue(50)" class="btn btn-default" id="50">$50</a>
						                	</div>
						                	<div class="col margen">
						                		<a onclick="setValue(100)" class="btn btn-default" id="100">$100</a>
						                	</div>

						                </div>


						          		<div class="row margen">
						                	<div class="col-md-12">
						                		 <div class="form-check">
												    <input type="checkbox" class="form-check-input" value="1" id="terminos" name="terminos">
												    <label class="form-check-label" for="terminos"><a target="_blank" href="{{ route('terminos') }}">Acepto Términos y Condiciones</a></label>
												  </div>
												    <label tipo="error" id="terminos-error"></label>
						                	</div>
						                </div>

						                <div class="row separador">
							                <div class="col-md-6 col-xs-12">
							                  <button class="btn btn-primary" type="submit" id="btnRealizar"> Realizar Donación</button>
							                  <button class="btn btn-back"  id="regresar"> Regresar</button>
							                </div>
						                </div>
						              </form>
								  </div>
								  <div class="tab-pane container fade" id="debit">
								  	<div class="p-4">
								  		<!--<p>Para depósitos o tranferencias:</p>
								  		<p class="line">Disponemos de una cuenta en el Banco Pichincha</p>
								  		<p class="line"><b>Nombre: </b>Iglesia Alianza Samborondón</p>
								  		<p class="line"><b>Cuenta Corriente: </b>3264328904</p>
								  		<p class="line"><b>Ruc: </b>0991263217001</p>-->
								  		
								  	</div>
								  </div>
								  <div class="tab-pane container fade" id="ayuda">
								  	<div class="p-4">
								  		<!--<p>Comunícate con nosotros para más información</p>
								  		<p class="line">Jhon Alvarez – celular 099-787-4402 </p>-->
								  		
								  	</div>
								  </div>
								</div>



						</div>

					</div>
				</div>

			</div>

<input type="hidden" name="max_donacion" id="max_donacion" value="1">
<footer class="principal">


	<div class="container">
			<div class="row p-4">
				<div class="col-xs-6 text-center">
					<p class="text">Todos los derechos reservados | Desarrollado por Alianza Samborondón | <a class="text" href="{{ route('terminos') }}" target="_blank">Términos & condiciones</a></p>
				</div>
				<div class="col-xs-6 text-center">
					<ul class="nav-principal">
					<li><a class="text" href="https://www.facebook.com/iglesia.samborondon/" target="_blank"><i class="fa fa-facebook-official" aria-hidden="true"></i></a></li>
					<li><a class="text" href="https://www.instagram.com/alianzasamborondon_ias/"  target="_blank"><i class="fa fa-instagram" aria-hidden="true"></i></a></li>
					<li><a class="text" href="https://twitter.com/AlianzaSamboron"  target="_blank"><i class="fa fa-twitter" aria-hidden="true"></i></a></li>
					<li><a class="text" href="https://www.youtube.com/user/AlianzaSamborondon1"  target="_blank"><i class="fa fa-youtube-play" aria-hidden="true"></i></a></li>
				</ul>
				</div>
			</div>
		</div>

</footer>


		</section>




<script>
  let paymentCheckout = new PaymentCheckout.modal({
    client_app_code: '{{ env('CLIENT_APP_CODE') }}',//'TPP3-EC-CLIENT', // Client Credentials
    client_app_key: '{{ env('CLIENT_APP_KEY') }}', // Client Credentials
    locale: 'es', // User's preferred language (es, en, pt). English will be used by default.
    env_mode: '{{ env('ENV_MODE_PAYMENTEZ') }}',//'prod', // `prod`, `stg`, `local` to change environment. Default is `stg`
    onOpen: function () {
      console.log('modal open');
    },
    onClose: function () {
      console.log('modal closed');
    },
    onResponse: function (response) { // The callback to invoke when the Checkout process is completed

      /*
        In Case of an error, this will be the response.
        response = {
          "error": {
            "type": "Server Error",
            "help": "Try Again Later",
            "description": "Sorry, there was a problem loading Checkout."
          }
        }

        When the User completes all the Flow in the Checkout, this will be the response.
        response = {
          "transaction":{
              "status": "success", // success or failure
              "id": "CB-81011", // transaction_id
              "status_detail": 3 // for the status detail please refer to: https://paymentez.github.io/api-doc/#status-details
          }
        }
      */
      console.log('modal response');
      //document.getElementById('response').innerHTML = JSON.stringify(response);
      //aqui guardar en base de datos la transaccion
      console.log(response)

        $.ajax({
            type: 'POST',
            url: '/donacion',
             data: {
                "_token": $('meta[name="csrf-token"]').attr('content'),
                //"id_customer":$("#id_user").val(),
                "amount": response.transaction.amount,
                "authorization_code": response.transaction.authorization_code,
                "carrier_code": response.transaction.carrier_code,
                "dev_reference": response.transaction.dev_reference,
                "id_response": response.transaction.id,
                "message": response.transaction.message,
                "payment_date": response.transaction.payment_date,
                "transaction_reference": response.card.transaction_reference,
                "status": response.transaction.status,
                "status_detail": response.transaction.status_detail,
                "correo": $("#correo").val()
            },
            beforeSend: function () {
                Swal.fire({
	                title: '¡Espere, Por favor!',
	                html: 'Cargando informacion...',
	                allowOutsideClick: false,
	                onBeforeOpen: () => {
	                    Swal.showLoading()
	                },
	            });
            },
            success: function (data) {
                console.log(data)
                setTimeout(function(){

                	if(data.status=='success'){
                		$("#formulario")[0].reset()
	                	Swal.fire(
					      '¡Gracias!',
					      'Tu aporte nos ayuda a soñar y crecer.',
					      'success'
					    )
					    /*setTimeout(function(){
		                	history.back()
		                }, 5000);*/
	                }else if(data.status=="pending"){
	                	$("#formulario")[0].reset()
	                	Swal.fire(
						 	'¡Gracias!',
					      	'Tu aporte nos ayuda a soñar y crecer, en breves minutos le enviaremos un correo sobre el detalle de la transacción',
					      	'success'
						)
						/*setTimeout(function(){
		                	history.back()
		                }, 5000);*/
	                }else{
	                	Swal.fire({
						  icon: 'error',
						  title: 'Oops...',
						  text: '!Ocurrió un error al realizar la transacción!'
						})
	                }

                }, 1500);


            },
            error: function (xhr) { // if error occured
                console.log('Error: ' + xhr.statusText + xhr.responseText);
                setTimeout(function(){
                	Swal.fire({
						  icon: 'error',
						  title: 'Oops...',
						  text: '!Ocurrió un error al realizar la transacción!'
						})
                }, 1500);
            }, complete:function(){
            	swal.close()
            }
        });
    }
  });



  window.addEventListener('popstate', function () {
    paymentCheckout.close();
  });
</script>

<script src="https://code.jquery.com/jquery-3.5.1.min.js" integrity="sha256-9/aliU8dGd2tb6OSsuzixeV4y/faTqgFtohetphbbj0=" crossorigin="anonymous"></script>
<script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.1/dist/umd/popper.min.js" integrity="sha384-9/reFTGAW83EW2RDu2S0VKaIzap3H66lZH81PoYlFhbGU+6BZp6G7niu735Sk7lN" crossorigin="anonymous"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.1/js/bootstrap.min.js" integrity="sha384-XEerZL0cuoUbHE4nZReLT7nx9gQrQreJekYhJD9WNWhH8nEW+0c5qq7aIo2Wl30J" crossorigin="anonymous"></script>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@9"></script>

<script src="{{ asset('../js/jquery.validate.min.js') }}"></script>
<script src="{{ asset('../js/jquery.inputmask.js')  }}"></script>
<script src="{{ asset('../js/main.js')  }}"></script>


</body>

</html>
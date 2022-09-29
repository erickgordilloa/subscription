function init(){
	
	$("#formulario").on("submit",function(e)
	{
		realizar(e);	
	});

	$.ajaxSetup({
	    headers: {
	        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
	    }
	});
}

//Función para guardar o editar
$.validator.addMethod('monto_minimo', function(value, element, param) {
	var max=parseFloat(param);
	var val=parseFloat(value);
	if(val>=max){
		return true;
	}else{
		return false;
	}
}, "El valor debe ser igual o mayor a $"+1);

$.validator.addMethod('monto_maximo', function(value, element, param) {
	//var max=parseFloat(param);
	var max=parseFloat($("#max_donacion").val());
	var val=parseFloat(value);
	if(val<=max){
		return true;
	}else{
		return false;
	}
}, "El valor debe ser menor o igual a $"+$("#max_donacion").val());

 $.validator.addMethod('required_monto', function(value, element, param) {
 	if( $("#terminos").is(':checked') ){
	        // Hacer algo si el checkbox ha sido seleccionado
	        return true;
	    } else {
	        // Hacer algo si el checkbox ha sido deseleccionado
	        return false;
	    }
    }, "Debe aceptar los términos y condicones");

    $.validator.addMethod('isMail', function(value, element, param) {
 	if( /^([A-Za-z0-9_\-\.])+\@([A-Za-z0-9_\-\.])+\.([A-Za-z]{2,4})$/.test(value) ){
	        // Hacer algo si el checkbox ha sido seleccionado
	        return true;
	    } else {
	        // Hacer algo si el checkbox ha sido deseleccionado
	        return false;
	    }
    }, "Por favor, introduce una dirección de correo electrónico válida");

	$.validator.addMethod('identificacion', function(value, element, param) {
	 	if ($("#tipo_identidad").val()==3) {
	 		if(/^[0-9a-zA-Z]+$/.test(value)){
	 			return true;
	 		}else{
	 			return false;
	 		}
	 	}else{
			if(/^[0-9]+$/.test(value)){
	 			return true;
	 		}else{
	 			return false;
	 		}
	 	}
    }, "Ingrese un número de documento valido");

 $.validator.addMethod('dollarsscents', function(value, element) {
    return this.optional(element) || /^\d{0,4}(\.\d{0,2})?$/i.test(value);
}, "El valor debe incluir dos decimales");



$("#formulario").validate({ 
		ignore: [],
	    rules: {
	      'nombre'         	: {required: true},
	      'apellido'         	: {required: true},
	      'comentario'         	: {maxlength:300},
	      'cedula'         	: {required: true,identificacion:true },
	      'correo'         	: {required: true,isMail:true},
	      'tipo'         	: {required: true},
	      'direccion'         	: {required: true},
	      'tipo_identidad'         	: {required: true},
	      'celular'         	: {required: true,number:true,minlength:10},
	      'terminos'         	: {required: true,required_monto:true},

	      //'titular'         	: {required: true},
	      //'numero'         	: {required: true,number:true},
	      //'titular'         	: {required: true},
	      //'mes'         	: {required: true,maxlength:7},
	      //'cvc'         	: {required: true,number:true,minlength:3},
	      'monto'       : {required: true,number:true,monto_minimo:1,monto_maximo:$("#max_donacion").val(),dollarsscents:true},
	    },
	    messages:{
	      'cedula':{
	        minlength: "Por favor, ingresa {0} caracteres",
	        maxlength: "Por favor, ingresa {0} caracteres",
	      }
	    },
	      errorPlacement: function (error, element) {
	        var er=error[0].innerHTML;
	        var nombre = element[0].id;
	        if(element[0].type=="select-one"){
	        	$("#" + nombre).parent().find(".select2-container").addClass("error");
	        }else{
	        	$("#" + nombre).addClass("is-invalid");
	        }
	        $("#" + nombre + "-error").html(er);
	        $("#" + nombre + "-error").show();
	      }, unhighlight: function (element) {
	        var nombre = element.id;
	        if(element.type=="select-one"){
	        	$("#" + nombre).parent().find(".select2-container").removeClass("error");
	        }else{
	        	$("#" + nombre).removeClass("is-invalid");
	        }
	        $("#" + nombre + "-error").hide();
	        $("#"+nombre).removeClass("error");
	      }
	  });


function realizar(e)
{
	e.preventDefault(); //No se activará la acción predeterminada del evento
	//debugger;
	if (!$("#formulario").valid()) {
		return false;
	}
	//$("#purchase").trigger('click')
	//$("#btnRealizar").prop("disabled",true);

		var data = $('#formulario').serialize();
        $.ajax({
            type: 'POST',
            url: '/crear',
            data: data,
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
            success: function (datos) {
                console.log(datos)
                if (datos.status=='success') {
                	$("#id_user").val(datos.data.id_customer);
                	//$("#purchase").trigger('click');
                	//console.log(paymentCheckout)

				    paymentCheckout.open({
				      user_id: $("#id_user").val(),//new Date().getTime().toString(),
				      user_email: $("#correo").val(), //optional
				      user_phone: $("#celular").val(), //optional
				      order_description: $("#nombre").val()+ ' ' +$("#apellido").val()+ ': '+ $( "#tipo option:selected" ).text(),
				      order_amount: parseFloat($("#monto").val()),
				      order_vat: 0,
				      order_reference: datos.data.id.toString(),// id transcation
				      //order_installments_type: 2, // optional: The installments type are only available for Equador. The valid values are: https://paymentez.github.io/api-doc/#installments-type
				      order_taxable_amount: 0, // optional: Only available for Datafast (Equador). The taxable amount, if it is zero, it is calculated on the total. Format: Decimal with two fraction digits.
				      order_tax_percentage: 0 // optional: Only available for Datafast (Equador). The tax percentage to be applied to this order.
				    });
                }else{
                	setTimeout(function(){
	                	Swal.fire({
							  icon: 'error',
							  title: 'Oops...',
							  text: datos.message
							})
	                }, 1000);
                }
            },
            error: function (xhr) { // if error occured
                console.log('Error: ' + xhr.statusText + xhr.responseText);
                setTimeout(function(){
                	Swal.fire({
						  icon: 'error',
						  title: 'Oops...',
						  text: '!Ocurrió un error al realizar la transacción! ' + xhr.message
						})
                }, 1500);
            }, complete:function(){
            	swal.close()
            }
        });



}

$("#tipo").change(function(){
	var valor = $(this).find(':selected').data('aumont');
	var editable = $(this).find(':selected').data('editable');

	if (editable=='N') {
		$("#monto").val(valor);
		$("#monto").prop("readonly",true);
		$("#valores").hide(1000);
	}else if(editable=='S'){
		$("#monto").val(valor);
		$("#monto").prop("readonly",false);
		$("#monto").focus();
		$("#valores").show(1000);
	}
});

$("#regresar").click(function(e){
	e.preventDefault(); //No se activará la acción predeterminada del evento
	history.back()

})

$("#monto").keyup(function(){
	$("#5").css('background-color','#fff');
	$("#10").css('background-color','#fff');
	$("#25").css('background-color','#fff');
	$("#50").css('background-color','#fff');
	$("#100").css('background-color','#fff');
})
function setValue(value){
	$("#monto").val(value);
	$("#5").css('background-color','#fff');
	$("#10").css('background-color','#fff');
	$("#25").css('background-color','#fff');
	$("#50").css('background-color','#fff');
	$("#100").css('background-color','#fff');

	$("#"+value).css('background-color','#e9e9e9');

}

 function formatString(e) {
  var inputChar = String.fromCharCode(event.keyCode);
  var code = event.keyCode;
  var allowedKeys = [8];
  if (allowedKeys.indexOf(code) !== -1) {
    return;
  }

  event.target.value = event.target.value.replace(
    /^([1-9]\/|[2-9])$/g, '0$1/' // 3 > 03/
  ).replace(
    /^(0[1-9]|1[0-2])$/g, '$1/' // 11 > 11/
  ).replace(
    /^1([3-9])$/g, '01/$1' // 13 > 01/3 //UPDATED by NAVNEET
  // ).replace(
  //   /^(0?[1-9]|1[0-2])([0-9]{2})$/g, '$1/$2' // 141 > 01/41
  ).replace(
    /^0\/|0+$/g, '0' // 0/ > 0 and 00 > 0 //UPDATED by NAVNEET
  ).replace(
    /[^\d|^\/]*/g, '' // To allow only digits and `/` //UPDATED by NAVNEET
  ).replace(
    /\/\//g, '/' // Prevent entering more than 1 `/`
  );
}


init();
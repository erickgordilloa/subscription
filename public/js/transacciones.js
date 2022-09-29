$(document).ready(function () {
    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });

    var start = moment();
    var end = moment();

    $("#fecha_inicio").val(start.format('YYYY-MM-DD'));
    $("#final").val(end.format('YYYY-MM-DD'));

    function cb(start, end) {
        $('#reportrange span').html(start.format('MMMM D, YYYY') + ' - ' + end.format('MMMM D, YYYY'));
        $("#fecha_inicio").val(start.format('YYYY-MM-DD'));
        $("#final").val(end.format('YYYY-MM-DD'));
    }

    $("#estado").change(function(){
        //console.log($(this).val())
        $("#estado_export").val($(this).val())
    })
    $('#reportrange').daterangepicker({
        startDate: start,
        endDate: end,
        ranges: {
            'Hoy': [moment(), moment()],
            'Ayer': [moment().subtract(1, 'days'), moment().subtract(1, 'days')],
            'Últimos 7 días': [moment().subtract(6, 'days'), moment()],
            'Últimos 30 días': [moment().subtract(29, 'days'), moment()],
            'Este mes': [moment().startOf('month'), moment().endOf('month')],
            'Anterior Mes': [moment().subtract(1, 'month').startOf('month'), moment().subtract(1, 'month').endOf('month')]
        }
    }, cb);

    cb(start, end);

    view_table();

    $("#btn_guardar_reference").click(function () {
        var data = new $('#formularioreference').serialize();
        $('#myModalreference').modal('toggle');
        $.ajax({
            type: 'POST',
            url: '/reference/transaccion',
            data: data,
            beforeSend: function () {
                Swal.fire({
                    title: '¡Espere, Por favor!',
                    html: 'Cargando informacion...',
                    allowOutsideClick: false,
                    onBeforeOpen: () => {
                        Swal.showLoading()
                    }
                }); 
            },
            success: function (d) {
                console.log(d)
              //  $('#formregisterdiv').html(data);
              //debugger;
                //var d = JSON.parse(data);
                //$('#div_mensajes').removeClass('d-none text-center')
                if (d['msg'] == 'success') {
                    toastr.success(d['data']);
                    view_table();
                    limpiar();
                } else {
                    toastr.error(d['data']);
                }
            },
            error: function (xhr) { // if error occured
                toastr.error('Error: '+xhr.statusText + xhr.responseText);
            },
            complete: function () {
               swal.close();
            }
        });
    });

    $("#btn_guardar").click(function () {
        if (!$("#formulario").valid()) {
            return false;
        }
        var data = new $('#formulario').serialize();
        $('#myModal').modal('toggle');
        $.ajax({
            type: 'POST',
            url: '/refund/transaction',
            data: data,
            beforeSend: function () {
                Swal.fire({
                    title: '¡Espere, Por favor!',
                    html: 'Cargando informacion...',
                    allowOutsideClick: false,
                    onBeforeOpen: () => {
                        Swal.showLoading()
                    }
                }); 
            },
            success: function (d) {
                console.log(d)
              //  $('#formregisterdiv').html(data);
              //debugger;
                //var d = JSON.parse(data);
                //$('#div_mensajes').removeClass('d-none text-center')
                if (d['status'] == 'success') {
                    toastr.success(d['detail']);
                    view_table();
                    limpiar();
                } else {
                    toastr.error(d['detail']);
                }
            },
            error: function (xhr) { // if error occured
                toastr.error('Error: '+xhr.statusText + xhr.responseText);
            },
            complete: function () {
               swal.close();
            }
        });
    });

      $("#formulario").validate({ 
        ignore: [],
        rules: {
          'detalle'         : {required: true,maxlength:250},
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

});
function limpiar(){
    $("#formulario")[0].reset();
}

function refund(id,name){
    limpiar();
    $('#myModal').modal('toggle');
    $("#id_response").val(id);
}

function reference(id,referenc){
    $("#reference").val(referenc);
    $("#transaccion_id").val(id);
}
function resend(id,name){
       $.confirm({
                title: '¡Reenviar Correo!',
                content: '¿Desea reenviar el correo de confirmación de pago a '+name+'?',
                buttons: {
                    confirm: function () {
                        $.ajax({
                            type: 'POST',
                            url: '/resend/transaccion',
                            data: {
                                "_token": $('meta[name="csrf-token"]').attr('content'),
                                "id": id,
                            },
                            beforeSend: function () {
                                Swal.fire({
                                    title: '¡Espere, Por favor!',
                                    html: 'Cargando informacion...',
                                    allowOutsideClick: false,
                                    onBeforeOpen: () => {
                                        Swal.showLoading()
                                    }
                                });
                            },
                            success: function (d) {
                                if (d['msg'] == 'error') {
                                    toastr.error(d['data']);
                                } else {
                                    toastr.success(d['data']);
                                }
                            },
                            error: function (xhr) {
                                toastr.error('Error: '+xhr.statusText + xhr.responseText);
                            },
                            complete: function () {
                                swal.close();
                            },
                        });
                    },
                    cancel: function () {
                        $.alert('Se ha cancelado la acción!');
                    }
                }
            });
}

function view_table() {
    var drp = $('#reportrange').data('daterangepicker');
    //debugger;
    var fecha_ini = drp.startDate.format('YYYY-MM-DD');
    var fecha_fin = drp.endDate.format('YYYY-MM-DD');

    $.ajax({
        type: 'POST',
        url: '/data/transacciones',
        data: {
            "_token": $('meta[name="csrf-token"]').attr('content'),
            fecha_ini: fecha_ini,
            fecha_fin: fecha_fin,
            estado: $('#estado').val()
        },
        beforeSend: function () {
             Swal.fire({
	                title: '¡Espere, Por favor!',
	                html: 'Cargando informacion...',
	                allowOutsideClick: false,
	                onBeforeOpen: () => {
	                    Swal.showLoading()
	                }
	            });  
        },
        success: function (data) {
            $('#div_table').html(data);
            $('#tbl_transacciones').DataTable({
                "language": {
                    "sProcessing": "Procesando...",
                    "sLengthMenu": "Mostrar _MENU_ registros",
                    "sZeroRecords": "No se encontraron resultados",
                    "sEmptyTable": "Ningún dato disponible en esta tabla =(",
                    "sInfo": "Mostrando registros del _START_ al _END_ de un total de _TOTAL_ registros",
                    "sInfoEmpty": "Mostrando registros del 0 al 0 de un total de 0 registros",
                    "sInfoFiltered": "(filtrado de un total de _MAX_ registros)",
                    "sInfoPostFix": "",
                    "sSearch": "Buscar:",
                    "sUrl": "",
                    "sInfoThousands": ",",
                    "sLoadingRecords": "Cargando...",
                    "oPaginate": {
                        "sFirst": "Primero",
                        "sLast": "Último",
                        "sNext": "Siguiente",
                        "sPrevious": "Anterior"
                    },
                    "oAria": {
                        "sSortAscending": ": Activar para ordenar la columna de manera ascendente",
                        "sSortDescending": ": Activar para ordenar la columna de manera descendente"
                    },
                    "buttons": {
                        "copy": "Copiar",
                        "colvis": "Visibilidad"
                    }
                },
                "paging": true,
                "lengthChange": true,
                "ordering": true,
                "info": true,
                "autoWidth": false,
               // "order": [[0, "desc"]]
            });
            // acciones();
        },
        error: function (xhr) { // if error occured
            toastr.error('Error: ' + xhr.statusText + xhr.responseText);
        },
        complete: function () {
             	swal.close()
        },
        dataType: 'html'
    });
}



$(function () {



    /*$('#busqueda').click(function (e) {

        e.preventDefault();
        var drp = $('#reportrange').data('daterangepicker');
        //debugger;
        var fecha_ini = drp.startDate.format('YYYY-MM-DD');
        var fecha_fin = drp.endDate.format('YYYY-MM-DD');

        $.ajax({
            type: 'POST',
            url: '/view_data_citas',
            data: {
                fecha_ini: fecha_ini,
                fecha_fin: fecha_fin,
                estado: $('#estado').val(),
                cita: $('#cita').val(),
                "_token": $('meta[name="csrf-token"]').attr('content')
            },
            beforeSend: function () {
                 Swal.fire({
                    title: '¡Espere, Por favor!',
                    html: 'Cargando informacion...',
                    allowOutsideClick: false,
                    onBeforeOpen: () => {
                        Swal.showLoading()
                    }
                });  
            },
            success: function (data) {
                $('#tbl_transacciones').html(data);
                $('#tbl_citas').DataTable({
                    "language": {
                        "sProcessing": "Procesando...",
                        "sLengthMenu": "Mostrar _MENU_ registros",
                        "sZeroRecords": "No se encontraron resultados",
                        "sEmptyTable": "Ningún dato disponible en esta tabla =(",
                        "sInfo": "Mostrando registros del _START_ al _END_ de un total de _TOTAL_ registros",
                        "sInfoEmpty": "Mostrando registros del 0 al 0 de un total de 0 registros",
                        "sInfoFiltered": "(filtrado de un total de _MAX_ registros)",
                        "sInfoPostFix": "",
                        "sSearch": "Buscar:",
                        "sUrl": "",
                        "sInfoThousands": ",",
                        "sLoadingRecords": "Cargando...",
                        "oPaginate": {
                            "sFirst": "Primero",
                            "sLast": "Último",
                            "sNext": "Siguiente",
                            "sPrevious": "Anterior"
                        },
                        "oAria": {
                            "sSortAscending": ": Activar para ordenar la columna de manera ascendente",
                            "sSortDescending": ": Activar para ordenar la columna de manera descendente"
                        },
                        "buttons": {
                            "copy": "Copiar",
                            "colvis": "Visibilidad"
                        }
                    },
                    "paging": true,
                    "lengthChange": true,
                    "ordering": true,
                    "info": true,
                    "autoWidth": false,
                    "order": [[0, "desc"]]
                });
                // acciones();
            },
            error: function (xhr) { // if error occured
                toastr.error('Error: ' + xhr.statusText + xhr.responseText);
            },
            complete: function () {
                    swal.close()
            },
            dataType: 'html'
        });
    });*/

});





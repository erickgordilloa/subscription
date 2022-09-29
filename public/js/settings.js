var ck_transferencia;
var ck_ayuda_social;
$(document).ready(function () {
    $.ajaxSetup({
        headers: {
            "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr("content"),
        },
    });

    ClassicEditor.create(document.querySelector("#transferencia"))
        .then((editor) => {
            console.log(editor);
            ck_transferencia = editor;
        })
        .catch((error) => {
            console.error(error);
        });

    ClassicEditor.create(document.querySelector("#ayuda_social"))
        .then((editor) => {
            console.log(editor);
            ck_ayuda_social = editor;
        })
        .catch((error) => {
            console.error(error);
        });

    view_table();

    $("#btn_guardar").click(function () {
        /*if (!$("#formulario").valid()) {
            return false;
        }*/
        var data = new $("#formulario").serialize();
        $("#myModal").modal("toggle");
        $.ajax({
            type: "POST",
            url: "/settings",
            data: {
                _token: $('meta[name="csrf-token"]').attr("content"),
                monto_maximo: $("#monto_maximo").val(),
                transferencia: ck_transferencia.getData(),
                ayuda_social: ck_ayuda_social.getData(),
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
                //  $('#formregisterdiv').html(data);
                //debugger;
                //var d = JSON.parse(data);
                //$('#div_mensajes').removeClass('d-none text-center')
                if (d["msg"] == "error") {
                    toastr.error(d["data"]);
                } else {
                    toastr.success(d["data"]);
                    view_table();
                    limpiar();
                }
            },
            error: function (xhr) {
                // if error occured
                toastr.error("Error: " + xhr.statusText + xhr.responseText);
            },
            complete: function () {
                swal.close();
            },
        });
    });

    //Función para guardar o editar
    $.validator.addMethod(
        "monto_minimo",
        function (value, element, param) {
            var max = parseFloat(param);
            var val = parseFloat(value);
            if (val >= max) {
                return true;
            } else {
                return false;
            }
        },
        "El valor debe ser igual o mayor a $0"
    );

    $.validator.addMethod(
        "monto_maximo",
        function (value, element, param) {
            var max = parseFloat(param);
            var val = parseFloat(value);
            if (val <= max) {
                return true;
            } else {
                return false;
            }
        },
        "El valor debe ser menor o igual a $2000"
    );

    /*$("#formulario").validate({ 
        ignore: [],
        rules: {
          'monto_maximo'          : {required: true},
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
      });*/
});

function limpiar() {
    $("#formulario")[0].reset();
}

function editar(id, transferencia, ayuda, monto) {
    $("#myModal").modal("toggle");
    $("#id").val(id);
    $("#monto_maximo").val(monto);
    ck_ayuda_social.setData(ayuda);
    ck_transferencia.setData(transferencia);
}

function view_table() {
    $.ajax({
        type: "POST",
        url: "/data/configuracion",
        data: {
            _token: $('meta[name="csrf-token"]').attr("content"),
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
        success: function (data) {
            $("#div_table").html(data);
            $("#tbl_subscriptions").DataTable({
                language: {
                    sProcessing: "Procesando...",
                    sLengthMenu: "Mostrar _MENU_ registros",
                    sZeroRecords: "No se encontraron resultados",
                    sEmptyTable: "Ningún dato disponible en esta tabla =(",
                    sInfo: "Mostrando registros del _START_ al _END_ de un total de _TOTAL_ registros",
                    sInfoEmpty:
                        "Mostrando registros del 0 al 0 de un total de 0 registros",
                    sInfoFiltered: "(filtrado de un total de _MAX_ registros)",
                    sInfoPostFix: "",
                    sSearch: "Buscar:",
                    sUrl: "",
                    sInfoThousands: ",",
                    sLoadingRecords: "Cargando...",
                    oPaginate: {
                        sFirst: "Primero",
                        sLast: "Último",
                        sNext: "Siguiente",
                        sPrevious: "Anterior",
                    },
                    oAria: {
                        sSortAscending:
                            ": Activar para ordenar la columna de manera ascendente",
                        sSortDescending:
                            ": Activar para ordenar la columna de manera descendente",
                    },
                    buttons: {
                        copy: "Copiar",
                        colvis: "Visibilidad",
                    },
                },
                paging: true,
                lengthChange: true,
                ordering: true,
                info: true,
                autoWidth: false,
                order: [[0, "desc"]],
            });
            // acciones();
        },
        error: function (xhr) {
            // if error occured
            toastr.error("Error: " + xhr.statusText + xhr.responseText);
        },
        complete: function () {
            swal.close();
        },
        dataType: "html",
    });
}

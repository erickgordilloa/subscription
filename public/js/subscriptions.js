var ck_texto;
$(document).ready(function () {
    $.ajaxSetup({
        headers: {
            "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr("content"),
        },
    });

    $('[data-toggle="popover"]').popover();

    ClassicEditor.create(document.querySelector("#texto"))
        .then((editor) => {
            console.log(editor);
            ck_texto = editor;
        })
        .catch((error) => {
            console.error(error);
        });

    view_table();

    $("#cantidad").keyup(function () {
        var cantidad = $(this).val();
        var opcion = "";

        $("#cantidades").html("");
        $("#cantidades").show();
        var j = 0;
        for (var i = 0; i < cantidad; i++) {
            j = j + 1;
            // console.log(j)
            opcion +=
                '<div class="row">' +
                '<div class="col">' +
                '<div class="form-group">' +
                '<input type="file" name="archivo_' +
                j +
                '" id="archivo_' +
                j +
                '" class="form-control">' +
                "</div>" +
                "</div>" +
                "</div>";
        }
        $("#cantidades").append(opcion);
    });

    $("#btn_guardar_archivo").click(function () {
        var data = new FormData();
        data.append("subscription_id", $("#subscription_id").val());
        data.append("nombre", $("#file_name").val());
        data.append("archivo", $("#archivo")[0].files[0]);
        data.append("_token", $('meta[name="csrf-token"]').attr("content"));

        $("#myModalfile").modal("toggle");
        $.ajax({
            type: "POST",
            url: "/post/archivos",
            data: data,
            contentType: false,
            processData: false,
            cache: false,
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
                console.log(d);
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

    $("#btn_guardar").click(function () {
        if (!$("#formulario").valid()) {
            return false;
        }
        var editable = "N";
        var estado = "A";
        if ($("#si").prop("checked") === true) {
            editable = "S";
        }

        if ($("#inactivo").prop("checked") === true) {
            estado = "I";
        }

        //var data = new $('#formulario').serialize();
        //var archivos = document.getElementById("archivos");
        // var archivo = archivos.files;
        var data = new FormData();
        /*var files = [];
        var j = 0;
        for(i=0; i < $("#cantidad").val(); i++){
            //debugger;
            j = j + 1;
            data.append('archivo_'+j,$('#archivo_'+j)[0].files[0]);
        }*/
        //debugger;
        // data.append('archivo',files); //Añadimos cada archivo a el arreglo con un indice direfente
        data.append("id", $("#id").val());
        // data.append('cantidad',$("#cantidad").val());
        data.append("nombre", $("#nombre").val());
        data.append("detalle", $("#detalle").val());
        data.append("monto", $("#monto").val());
        data.append("es_editable", editable);
        data.append("estado", estado);
        data.append("texto", ck_texto.getData());
        data.append("_token", $('meta[name="csrf-token"]').attr("content"));

        $("#myModal").modal("toggle");
        $.ajax({
            type: "POST",
            url: "/subscriptions",
            data: data,
            contentType: false,
            processData: false,
            cache: false,
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
                console.log(d);
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

    $("#formulario1").validate({
        ignore: ["texto"],
        rules: {
            nombre: { required: true },
            detalle: { required: true },
            monto: {
                required: true,
                number: true,
                monto_minimo: 0,
                monto_maximo: 2000,
            },
            estado: { required: true },
        },
        messages: {
            cedula: {
                minlength: "Por favor, ingresa {0} caracteres",
                maxlength: "Por favor, ingresa {0} caracteres",
            },
        },
        errorPlacement: function (error, element) {
            var er = error[0].innerHTML;
            var nombre = element[0].id;
            if (element[0].type == "select-one") {
                $("#" + nombre)
                    .parent()
                    .find(".select2-container")
                    .addClass("error");
            } else {
                $("#" + nombre).addClass("is-invalid");
            }
            $("#" + nombre + "-error").html(er);
            $("#" + nombre + "-error").show();
        },
        unhighlight: function (element) {
            var nombre = element.id;
            if (element.type == "select-one") {
                $("#" + nombre)
                    .parent()
                    .find(".select2-container")
                    .removeClass("error");
            } else {
                $("#" + nombre).removeClass("is-invalid");
            }
            $("#" + nombre + "-error").hide();
            $("#" + nombre).removeClass("error");
        },
    });
});

function eliminar(id, name) {
    $.confirm({
        title: "¡Eliminar Archivo Adjunto!",
        content: "¿Desea eliminar el archivo adjunto " + name + "?",
        buttons: {
            confirm: {
                text: "Eliminar",
                btnClass: "btn-red",
                action: function () {
                    $.ajax({
                        type: "POST",
                        url: "/delete/archivos",
                        data: {
                            _token: $('meta[name="csrf-token"]').attr(
                                "content"
                            ),
                            id: id,
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
                            if (d["msg"] == "error") {
                                toastr.error(d["data"]);
                            } else {
                                toastr.success(d["data"]);
                            }
                        },
                        error: function (xhr) {
                            toastr.error(
                                "Error: " + xhr.statusText + xhr.responseText
                            );
                        },
                        complete: function () {
                            swal.close();
                        },
                    });
                },
            },
            cancel: {
                action: function () {
                    $.alert("Se ha cancelado la acción!");
                },
                text: "Cerrar",
            },
        },
    });
}

function limpiar() {
    $("#formulario")[0].reset();
}

function abrir(botonimg, id) {
    //debugger;
    //let botonimg = opt.toElement;
    let row = $(botonimg).parents("tr")[0];
    var tbl = $("#tbl_subscriptions").dataTable();
    if (tbl.fnIsOpen(row)) {
        tbl.fnClose(row);
        botonimg.src = "/images/details_open.png";
    } else {
        $.ajax({
            type: "POST",
            url: "/subscriptions/archivos",
            data: {
                _token: $('meta[name="csrf-token"]').attr("content"),
                id: id,
            },
            beforeSend: function () {
                $("#div_mensajes").removeClass("d-none");
                $("#div_mensajes").addClass("text-center");
                $("#mensajes").html(
                    '<img src="../images/load.gif" width="5%" height="5%" />'
                );
            },
            success: function (d) {
                console.log(d);
                var table =
                    "<table class='table table-bordered' with='100%'><thead class='thead-light'><tr>" +
                    "<th>Nombre del archivo</th>" +
                    "<th>Opciones</th>" +
                    "</tr></thead><tbody>";

                for (var i = 0; i < d.length; i++) {
                    table += "<tr>";
                    if (d[i].archivo != null) {
                        table += "<td>" + d[i].archivo + "</td>";
                        table +=
                            '<td><a target="_blank" href="/storage/adjuntos/' +
                            d[i].subscription_id +
                            "/" +
                            d[i].archivo +
                            '" title="Descargar" type="button" class="btn btn-primary  btn-sm">' +
                            '<i class="fas fa-download"></i></i> Descargar</a> ' +
                            '<button onclick="eliminar(' +
                            d[i].id +
                            ",'" +
                            d[i].archivo +
                            '\')"  title="Eliminar" type="button" class="btn btn-danger  btn-sm">' +
                            '<i class="fas fa-trash"></i></i> Eliminar</button>' +
                            "</td>";
                    } else {
                        table += "<td></td>";
                        table += "<td></td>";
                    }
                    table += "</tr>";
                }
                table += "</tbody></table>";
                console.log(table);
                // var table = "hola mundo" + id;
                tbl.fnOpen(row, table, "details");
                botonimg.src = "/images/details_close.png";
            },
            error: function (xhr) {
                toastr.error("Error: " + xhr.statusText + xhr.responseText);
            },
            complete: function () {
                $("#div_mensajes").addClass("d-none");
            },
        });
    }
}

function editar(id, nombre, detalle, monto, estado, es_editable) {
    $("#myModal").modal("toggle");
    $("#id").val(id);
    $("#nombre").val(nombre);
    $("#detalle").val(detalle);
    $("#monto").val(monto);
    var texto = $("#texto_editable_" + id).val();
    ck_texto.setData(texto);
    if (estado == "A") {
        $("#activo").prop("checked", true);
    } else {
        $("#inactivo").prop("checked", true);
    }
    if (es_editable == "S") {
        $("#si").prop("checked", true);
    } else {
        $("#no").prop("checked", true);
    }
}

function view_table() {
    $.ajax({
        type: "POST",
        url: "/data/subscriptions",
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

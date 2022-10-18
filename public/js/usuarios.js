$(document).ready(function () {
    $.ajaxSetup({
        headers: {
            "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr("content"),
        },
    });

    view_table();

    $("#btn_guardar").click(function () {
        if (!$("#formulario").valid()) {
            return false;
        }
        var data = new $("#formulario").serialize();
        $("#myModal").modal("toggle");
        $.ajax({
            type: "POST",
            url: "/usuarios",
            data: data,
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
                //  $('#formregisterdiv').html(data);
                var d = JSON.parse(data);
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
            dataType: "html",
        });
    });

    $("#btn_actualizar").click(function () {
        var data = new $("#form").serialize();
        $("#EditModal").modal("toggle");
        $.ajax({
            type: "POST",
            url: "/register",
            data: data,
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
                //  $('#formregisterdiv').html(data);
                var d = JSON.parse(data);
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
            dataType: "html",
        });
    });

    $("#formulario").validate({
        ignore: [],
        rules: {
            name: { required: true },
            confirm: { required: true, equalTo: "#password" },
            password: { required: true, minlength: 8 },
            email: { required: true, email: true },
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

function limpiar() {
    $("#formulario")[0].reset();
}

function editar(id, name, email) {
    $("#EditModal").modal("toggle");
    $("#id").val(id);
    $("#name_edit").val(name);
    $("#email_edit").val(email);
}

function eliminar(data, name) {
    $.confirm({
        title: "Eliminar usuario!",
        content: "¿Desea eliminar el usuario usuario " + name + "?",
        buttons: {
            confirm: function () {
                $.ajax({
                    type: "POST",
                    url: "/delete/usuarios",
                    data: {
                        _token: $('meta[name="csrf-token"]').attr("content"),
                        id: data,
                    },
                    beforeSend: function () {
                        $("#div_mensajes").removeClass("d-none");
                        $("#div_mensajes").addClass("text-center");
                        $("#mensajes").html(
                            '<img src="../images/load.gif" width="5%" height="5%" />'
                        );
                    },
                    success: function (d) {
                        if (d["msg"] == "error") {
                            toastr.error(d["data"]);
                        } else {
                            toastr.success(d["data"]);
                            view_table();
                            limpiar();
                        }
                    },
                    error: function (xhr) {
                        toastr.error(
                            "Error: " + xhr.statusText + xhr.responseText
                        );
                    },
                    complete: function () {
                        $("#div_mensajes").addClass("d-none");
                    },
                });
            },
            cancel: function () {
                $.alert("Se ha cancelado la eliminación!");
            },
        },
    });
}

function view_table() {
    $.ajax({
        type: "POST",
        url: "/data/usuarios",
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
            $("#tbl_usuarios").DataTable({
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

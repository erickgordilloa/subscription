$(document).ready(function () {
    $.ajaxSetup({
        headers: {
            "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr("content"),
        },
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
            url: "/post/personas",
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
                swal.close();
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
});

function limpiar() {
    $("#formulario")[0].reset();
}
function editar(
    id,
    tipo,
    identidad,
    nombre,
    apellido,
    correo,
    direccion,
    telefono
) {
    $("#id").val(id);
    $("#tipo").val(tipo);
    $("#identidad").val(identidad);
    $("#nombre").val(nombre);
    $("#apellido").val(apellido);
    $("#correo").val(correo);
    $("#direccion").val(direccion);
    $("#celular").val(telefono);
    $("#myModal").modal("toggle");
}

function view_table() {
    $.ajax({
        type: "POST",
        url: "/data/personas",
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
            $("#tbl_personas").DataTable({
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
function cobrar(id, name) {
    Swal.fire({
        title: "¡Cobrar!",
        text: "¿Desea Cobrar la suscripción al usuario a " + name + "?",
        icon: "info",
        showDenyButton: true,
        showCancelButton: true,
        confirmButtonText: "Confirmar",
        cancelButtonText: "Cancelar",
    }).then((result) => {
        /* Read more about isConfirmed, isDenied below */
        if (result.isConfirmed) {
            $.ajax({
                type: "POST",
                url: "/cobrar",
                data: {
                    _token: $('meta[name="csrf-token"]').attr("content"),
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
                    //Swal.close();
                    if (d["msg"] == "success") {
                        Swal.fire("¡Cobrar!", d["data"], "success");
                        setTimeout(() => {
                            view_table();
                        }, 2000);
                    } else {
                        Swal.fire("¡Oops!", d["data"], "error");
                    }
                },
                error: function (xhr) {
                    Swal.close();
                    toastr.error("Error: " + xhr.statusText + xhr.responseText);
                },
            });
        } else if (result.isDenied) {
            Swal.fire("Changes are not saved", "", "info");
        }
    });
}

$(function () {
    $("#busqueda").click(function (e) {
        e.preventDefault();
        var drp = $("#reportrange").data("daterangepicker");
        //debugger;
        var fecha_ini = drp.startDate.format("YYYY-MM-DD");
        var fecha_fin = drp.endDate.format("YYYY-MM-DD");

        $.ajax({
            type: "POST",
            url: "/view_data_citas",
            data: {
                fecha_ini: fecha_ini,
                fecha_fin: fecha_fin,
                estado: $("#estado").val(),
                cita: $("#cita").val(),
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
                $("#tbl_personas").html(data);
                $("#tbl_citas").DataTable({
                    language: {
                        sProcessing: "Procesando...",
                        sLengthMenu: "Mostrar _MENU_ registros",
                        sZeroRecords: "No se encontraron resultados",
                        sEmptyTable: "Ningún dato disponible en esta tabla =(",
                        sInfo: "Mostrando registros del _START_ al _END_ de un total de _TOTAL_ registros",
                        sInfoEmpty:
                            "Mostrando registros del 0 al 0 de un total de 0 registros",
                        sInfoFiltered:
                            "(filtrado de un total de _MAX_ registros)",
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
    });
});

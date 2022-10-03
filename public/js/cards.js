$(document).ready(function () {
    $.ajaxSetup({
        headers: {
            "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr("content"),
        },
    });

    view_table();

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
});

function eliminar(id, name) {
    Swal.fire({
        title: "¡Eliminar tarjeta!",
        text: "¿Desea cancelar la tarjeta a " + name + "?",
        icon: "warning",
        showDenyButton: true,
        showCancelButton: true,
        confirmButtonColor: "#d33",
        confirmButtonText: "Eliminar",
        cancelButtonText: "Cancelar",
    }).then((result) => {
        /* Read more about isConfirmed, isDenied below */
        if (result.isConfirmed) {
            $.ajax({
                type: "DELETE",
                url: "/tarejtas/" + id,
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
                success: function (d) {
                    Swal.fire("¡Eliminado!", "", "success");
                    view_table();
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

function view_table() {
    $.ajax({
        type: "POST",
        url: "/tarjetas/data",
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
            $("#tbl_cards").DataTable({
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

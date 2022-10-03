$(document).ready(function () {
    $.ajaxSetup({
        headers: {
            "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr("content"),
        },
    });

    view_table();
});

function view_table() {
    $.ajax({
        type: "POST",
        url: "/pagos/data",
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
            $("#tbl_pagos").DataTable({
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

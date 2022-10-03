$(document).ready(function () {
    $.ajaxSetup({
        headers: {
            "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr("content"),
        },
    });

    view_table();
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

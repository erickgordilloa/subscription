$(document).ready(function () {
    $.ajaxSetup({
        headers: {
            "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr("content"),
        },
    });
});

function subscribirse(id, name) {
    let meses = $("#month_" + id).val();
    let meses_text = $("#month_" + id + " option:selected").text();
    let brand_id = $("#brand_" + id + " option:selected").val();
    let type_id = $("#type_" + id + " option:selected").val();
    Swal.fire({
        title: "¡Suscribirse!",
        text: "¿Desea suscribirse a " + name + " por " + meses_text + "?",
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
                url: "/suscribir",
                data: {
                    _token: $('meta[name="csrf-token"]').attr("content"),
                    subscription_id: id,
                    type_subscription_id: meses,
                    brand_id: brand_id,
                    type_id: type_id,
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
                    Swal.close();
                    if (d["msg"] == "success") {
                        Swal.fire("¡Suscribirse!", d["data"], "success");
                    } else {
                        //Swal.fire("¡Oops!", d["data"], "error");
                        Swal.fire({
                            title: "¡Oops!",
                            icon: "error",
                            html: d["data"],
                            confirmButtonText: "Añadir tarjeta",
                        }).then((result) => {
                            /* Read more about isConfirmed, isDenied below */
                            if (result.isConfirmed) {
                                window.location = "/tarjetas";
                            }
                        });
                    }
                },
                error: function (xhr) {
                    toastr.error("Error: " + xhr.statusText + xhr.responseText);
                },
            });
        } else if (result.isDenied) {
            Swal.fire("Changes are not saved", "", "info");
        }
    });
}

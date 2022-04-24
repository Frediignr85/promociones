$(document).ready(function() {
    generar2();
    $('.select').select2();
    $("#hora_inicio").timepicki();
    $("#hora_fin").timepicki();
    $('#formulario').validate({
        rules: {
            nombre: {
                required: true,
            },
            codigo: {
                required: true,
            },
            descripcion: {
                required: true,
            },
            fecha_inicio: {
                required: true,
            },
            hora_inicio: {
                required: true,
            },
            fecha_fin: {
                required: true,
            },
            hora_fin: {
                required: true,
            },
            id_tipo_promocion: {
                required: true,
            },
            id_establecimiento: {
                required: true,
            },
            id_sucursal: {
                required: true,
            },
        },
        messages: {
            nombre: "Por favor ingrese el Nombre de la Promocion!.",
            codigo: "Por favor ingrese el Codigo de la Promocion!.",
            descripcion: "Por favor ingrese la Descripcion de la Promocion!.",
            fecha_inicio: "Por favor seleccione la Fecha de Inicio de la Promocion!.",
            hora_inicio: "Por favor seleccione la Hora de Inicio de la Promocion!.",
            fecha_fin: "Por favor seleccione la Fecha de Finalizacion de la Promocion!.",
            hora_fin: "Por favor seleccione la Hora de Finalizacion de la Promocion!.",
            id_tipo_promocion: "Por favor seleccione el Tipo de Promocion!.",
            id_establecimiento: "Por favor seleccione el Establecimiento de la Promocion!.",
            id_sucursal: "Por favor seleccione la Sucursal de la Promocion!.",
        },
        submitHandler: function(form) {
            senddata();
        }
    });

});

function mayus(e) {
    var v = e.value;
    var nombre = v.toUpperCase();
    $("#nombre").val(nombre);
}


function senddata() {
    var base_url = $("#base_url").val();
    var nombre = $("#nombre").val();
    var codigo = $("#codigo").val();
    var descripcion = $("#descripcion").val();
    var fecha_inicio = $("#fecha_inicio").val();
    var hora_inicio = $("#hora_inicio").val();
    var fecha_fin = $("#fecha_fin").val();
    var hora_fin = $("#hora_fin").val();
    var id_tipo_promocion = $("#id_tipo_promocion").val();
    var id_establecimiento = $("#id_establecimiento").val();
    var id_sucursal = $("#id_sucursal").val();
    let error = false;
    let msg = "";

    if ((fecha_inicio > fecha_fin) || (fecha_inicio == fecha_fin && hora_inicio >= hora_fin)) {
        error = true;
        msg = "Comprobar que las fechas y las horas tengan concordancia!";
    }
    if (!error) {
        var process = $('#process').val();
        if (process == 'insertar') {
            var id_promocion = 0;
            var url = base_url + '/promociones/insertar_promocion';
        }
        if (process == 'editar') {
            var id_promocion = $('#id_promocion').val();
            var url = base_url + '/promociones/modificar_promocion';
        }
        var datas_string = "nombre=" + nombre;
        datas_string += "&codigo=" + codigo;
        datas_string += "&descripcion=" + descripcion;
        datas_string += "&fecha_inicio=" + fecha_inicio;
        datas_string += "&hora_inicio=" + hora_inicio;
        datas_string += "&fecha_fin=" + fecha_fin;
        datas_string += "&hora_fin=" + hora_fin;
        datas_string += "&id_tipo_promocion=" + id_tipo_promocion;
        datas_string += "&id_establecimiento=" + id_establecimiento;
        datas_string += "&id_sucursal=" + id_sucursal;
        datas_string += "&id_promocion=" + id_promocion;
        $.ajax({
            type: 'POST',
            url: url,
            data: datas_string,
            dataType: 'json',
            success: function(datax) {
                display_notify(datax.typeinfo, datax.msg);
                if (datax.typeinfo == "Success") {
                    setInterval("reload1();", 1500);
                }
            }
        });
    } else {
        display_notify("Warning", msg);
    }
}

function reload1() {
    let base_url = $("#base_url").val();
    location.href = base_url + '/promociones/';
}

function deleted(id) {
    var base_url = $("#base_url").val();
    swal({
            title: "¿Esta seguro que desea eliminar esta promocion?",
            text: "Usted no podra deshacer este cambio!!",
            type: "warning",
            showCancelButton: true,
            confirmButtonColor: "#DD6B55",
            confirmButtonText: "Si, Eliminar",
            cancelButtonText: "No, Cerrar",
            closeOnConfirm: true
        },
        function() {
            $.ajax({
                type: "POST",
                url: base_url + "/promociones/eliminar_promocion/" + id,
                dataType: "JSON",
                success: function(datax) {
                    if (datax.typeinfo == "success" || datax.typeinfo == "Success") {
                        setInterval("reload1();", 1500);
                    }
                    display_notify(datax.typeinfo, datax.msg);
                }
            });
        });
}

function desactivar(id) {
    var base_url = $("#base_url").val();
    swal({
            title: "¿Esta seguro que desea desactivar esta promocion?",
            text: "Hagalo unicamente si esta seguro!",
            type: "warning",
            showCancelButton: true,
            confirmButtonColor: "#DD6B55",
            confirmButtonText: "Si, Desactivar",
            cancelButtonText: "No, Cerrar",
            closeOnConfirm: true
        },
        function() {
            $.ajax({
                type: "POST",
                url: base_url + "/promociones/desactivar_promocion/" + id,
                dataType: "JSON",
                success: function(datax) {
                    if (datax.typeinfo == "success" || datax.typeinfo == "Success") {
                        setInterval("reload1();", 1500);
                    }
                    display_notify(datax.typeinfo, datax.msg);
                }
            });
        });
}

function activar(id) {
    var base_url = $("#base_url").val();
    swal({
            title: "¿Esta seguro que desea activar esta promocion?",
            text: "Hagalo unicamente si esta seguro!",
            type: "warning",
            showCancelButton: true,
            confirmButtonColor: "#DD6B55",
            confirmButtonText: "Si, Activar",
            cancelButtonText: "No, Cerrar",
            closeOnConfirm: true
        },
        function() {
            $.ajax({
                type: "POST",
                url: base_url + "/promociones/activar_promocion/" + id,
                dataType: "JSON",
                success: function(datax) {
                    if (datax.typeinfo == "success" || datax.typeinfo == "Success") {
                        setInterval("reload1();", 1500);
                    }
                    display_notify(datax.typeinfo, datax.msg);
                }
            });
        });
}



$(document).on("click", ".desactivar", function() {
    desactivar($(this).attr("id_promocion"));
});
$(document).on("click", ".activar", function() {
    activar($(this).attr("id_promocion"));
});
$(document).on("click", ".elim", function() {
    deleted($(this).attr("id_promocion"));
});
$(function() {
    /*binding event click for button in modal form
	$(document).on("click", "#btnDelete", function(event) {
	deleted();
});*/
    // Clean the modal form
    $(document).on('hidden.bs.modal', function(e) {
        var target = $(e.target);
        target.removeData('bs.modal').find(".modal-content").html('');
    });
});

/* FUNCION PARA PODER LLENAR EL DATATABLE */
function generar2() {
    let base_url = $("#base_url").val();
    $('#editable2').DataTable({
        'processing': true,
        'serverSide': true,
        'serverMethod': 'post',
        "autoWidth": false,
        "order": [0, 'desc'],
        'ajax': {
            'url': base_url + "/promociones/getPromociones",
            'data': function(data) {
                return {
                    data: data,
                };
            },
        },
        'columns': [
            { data: 'id_promocion' },
            { data: 'nombre' },
            { data: 'codigo' },
            { data: 'fecha_inicio' },
            { data: 'fecha_fin' },
            { data: 'nombre_establecimiento' },
            { data: 'nombre_sucursal' },
            { data: 'nombre_tipo_promocion' },
            { data: 'activo' },
            { data: 'boton' },
        ]
    });
}

$("#id_establecimiento").change(function() {
    let id_establecimiento = $(this).val();
    let base_url = $("#base_url").val();
    $("#id_sucursal *").remove();
    $("#select2-id_sucursal-container").text("");
    var ajaxdata = { "id_establecimiento": id_establecimiento };
    $.ajax({
        url: base_url + "/promociones/cambiar_establecimiento",
        type: "POST",
        data: ajaxdata,
        success: function(opciones) {
            $("#select2-id_sucursal-container").text("Seleccione");
            $("#id_sucursal").html(opciones);
            $("#id_sucursal").val("");
        }
    })
});
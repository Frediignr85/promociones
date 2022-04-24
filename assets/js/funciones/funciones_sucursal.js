$(document).ready(function() {
    generar2();
    $('.select').select2();
    $('#formulario').validate({
        rules: {
            nombre: {
                required: true,
            },
            telefono: {
                required: true,
            },
            direccion: {
                required: true,
            },
            id_departamento: {
                required: true,
            },
            id_municipio: {
                required: true,
            },
            id_usuario: {
                required: true,
            },
            url: {
                required: true,
            },
            id_establecimiento: {
                required: true,
            },
        },
        messages: {
            nombre: "Por favor ingrese el Nombre de la Sucursal!.",
            telefono: "Por favor ingrese el Telefono de la Sucursal!.",
            direccion: "Por favor ingrese la Direccion de la Sucursal!.",
            id_departamento: "Por favor seleccione el Departamento de la Sucursal!.",
            id_municipio: "Por favor seleccione el Municipio de la Sucursal!.",
            id_usuario: "Por favor seleccione el Usuario Encargado de la Sucursal!.",
            url: "Por favor seleccione la URL de Google Maps de la Sucursal!.",
            id_establecimiento: "Por favor seleccione el Establecimiento de la Sucursal!.",
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
    var telefono = $("#telefono").val();
    var direccion = $("#direccion").val();
    var id_departamento = $("#id_departamento").val();
    var id_municipio = $("#id_municipio").val();
    var id_usuario = $("#id_usuario").val();
    var url_x = $("#url").val();
    var id_establecimiento = $("#id_establecimiento").val();
    var process = $('#process').val();
    if (process == 'insertar') {
        var id_sucursal = 0;
        var url = base_url + '/sucursales/insertar_sucursal';
    }
    if (process == 'editar') {
        var id_sucursal = $('#id_sucursal').val();
        var url = base_url + '/sucursales/modificar_sucursal';
    }
    var datas_string = "nombre=" + nombre;
    datas_string += "&telefono=" + telefono;
    datas_string += "&direccion=" + direccion;
    datas_string += "&id_departamento=" + id_departamento;
    datas_string += "&id_municipio=" + id_municipio;
    datas_string += "&id_usuario=" + id_usuario;
    datas_string += "&id_establecimiento=" + id_establecimiento;
    datas_string += "&url=" + url_x;
    datas_string += "&id_sucursal=" + id_sucursal;
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
}
$('.tel').on('keydown', function(event) {
    if (event.keyCode == 8 || event.keyCode == 9 || event.keyCode == 13 || event.keyCode == 37 || event.keyCode == 39) {} else {
        inputval = $(this).val();
        var string = inputval.replace(/[^0-9]/g, "");
        var bloc1 = string.substring(0, 4);
        var bloc2 = string.substring(4, 7);
        var string = (bloc1 + "-" + bloc2);
        $(this).val(string);
    }
});

function reload1() {
    let base_url = $("#base_url").val();
    location.href = base_url + '/sucursales/';
}

function deleted(id) {
    var base_url = $("#base_url").val();
    swal({
            title: "¿Esta seguro que desea eliminar esta sucursal?",
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
                url: base_url + "/sucursales/eliminar_sucursal/" + id,
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
            title: "¿Esta seguro que desea desactivar esta sucursal?",
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
                url: base_url + "/sucursales/desactivar_sucursal/" + id,
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
            title: "¿Esta seguro que desea activar esta sucursal?",
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
                url: base_url + "/sucursales/activar_sucursal/" + id,
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
    desactivar($(this).attr("id_sucursal"));
});
$(document).on("click", ".activar", function() {
    activar($(this).attr("id_sucursal"));
});
$(document).on("click", ".elim", function() {
    deleted($(this).attr("id_sucursal"));
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
            'url': base_url + "/sucursales/getSucursales",
            'data': function(data) {
                return {
                    data: data,
                };
            },
        },
        'columns': [
            { data: 'id_sucursal' },
            { data: 'nombre' },
            { data: 'nombre_establecimiento' },
            { data: 'telefono' },
            { data: 'direccion' },
            { data: 'nombre_departamento' },
            { data: 'nombre_municipio' },
            { data: 'nombre_usuario' },
            { data: 'activo' },
            { data: 'boton' },
        ]
    });
}

$("#id_departamento").change(function() {
    let id_departamento = $(this).val();
    let base_url = $("#base_url").val();
    $("#id_municipio *").remove();
    $("#select2-id_municipio-container").text("");
    var ajaxdata = { "id_departamento": id_departamento };
    $.ajax({
        url: base_url + "/sucursales/cambiar_departamento",
        type: "POST",
        data: ajaxdata,
        success: function(opciones) {
            $("#select2-id_municipio-container").text("Seleccione");
            $("#id_municipio").html(opciones);
            $("#id_municipio").val("");
        }
    })
});
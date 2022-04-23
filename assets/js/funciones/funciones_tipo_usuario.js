$(document).ready(function() {
    generar2();
    $('#formulario').validate({
        rules: {
            nombre: {
                required: true,
            },
            descripcion: {
                required: true,
            },
        },
        messages: {
            nombre: "Por favor ingrese el nombre del Tipo de Usuario!.",
            descripcion: "Por favor ingrese la descripcion del Tipo de Usuario!.",
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

function mayus2(e) {
    var v = e.value;
    var descripcion = v.toUpperCase();
    $("#descripcion").val(descripcion);
}


function senddata() {
    var base_url = $("#base_url").val();
    var nombre = $("#nombre").val();
    var descripcion = $("#descripcion").val();
    var process = $('#process').val();
    if (process == 'insertar') {
        var id_tipo_usuario = 0;
        var url = base_url + '/catalogos/insertar_tipo_usuario';
    }
    if (process == 'editar') {
        var id_tipo_usuario = $('#id_tipo_usuario').val();
        var url = base_url + '/catalogos/modificar_tipo_usuario';
    }
    var datas_string = "nombre=" + nombre;
    datas_string += "&descripcion=" + descripcion;
    datas_string += "&id_tipo_usuario=" + id_tipo_usuario;
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

function reload1() {
    let base_url = $("#base_url").val();
    location.href = base_url + '/catalogos/admin_tipo_usuarios';
}

function deleted(id) {
    var base_url = $("#base_url").val();
    swal({
            title: "¿Esta seguro que desea eliminar este tipo de usuario?",
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
                url: base_url + "/catalogos/eliminar_tipo_usuario/" + id,
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
            title: "¿Esta seguro que desea desactivar este tipo de usuario?",
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
                url: base_url + "/catalogos/desactivar_tipo_usuario/" + id,
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
            title: "¿Esta seguro que desea activar este tipo de usuario?",
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
                url: base_url + "/catalogos/activar_tipo_usuario/" + id,
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

function permiso() {
    var base_url = $("#base_url").val();
    var id_tipo_usuario = $('#id_tipo_usuario').val();
    var myCheckboxes = new Array();
    var cuantos = 0;
    var chequeado = false;
    $("input[name='myCheckboxes']:checked").each(function(index) {
        var est = $('#myCheckboxes').eq(index).attr('checked');
        chequeado = true;
        myCheckboxes.push($(this).val());
        cuantos = cuantos + 1;
    });
    var dataString = 'myCheckboxes=' + myCheckboxes + '&qty=' + cuantos;
    $.ajax({
        type: 'POST',
        url: base_url + "/catalogos/asignar_permiso_tipo_usuario/" + id_tipo_usuario,
        data: dataString,
        dataType: 'json',
        success: function(datax) {
            display_notify(datax.typeinfo, datax.msg);
            if (datax.typeinfo == "Success") {
                setInterval("reload1();", 1500);
            }
        }
    });
}

$(document).on("click", "#btnPermiso", function(e) {
    permiso();
    e.preventDefault();
});

$(document).on("click", ".desactivar", function() {
    desactivar($(this).attr("id_tipo_usuario"));
});
$(document).on("click", ".activar", function() {
    activar($(this).attr("id_tipo_usuario"));
});
$(document).on("click", ".elim", function() {
    deleted($(this).attr("id_tipo_usuario"));
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
            'url': base_url + "/catalogos/getTipoUsuarios",
            'data': function(data) {
                return {
                    data: data,
                };
            },
        },
        'columns': [
            { data: 'id_tipo_usuario' },
            { data: 'nombre' },
            { data: 'descripcion' },
            { data: 'activo' },
            { data: 'boton' },
        ]
    });
}
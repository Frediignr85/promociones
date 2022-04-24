$(document).ready(function() {
    generar2();
    $('.select').select2();
    $('#formulario').validate({
        rules: {
            nombre: {
                required: true,
            },
            username: {
                required: true,
            },
            correo: {
                required: true,
            },
            password: {
                required: true,
            },
            repetir_password: {
                required: true,
            },
            id_tipo_usuario: {
                required: true,
            },
        },
        messages: {
            nombre: "Por favor ingrese el Nombre del Usuario!.",
            username: "Por favor ingrese el Username del Usuario!.",
            correo: "Por favor ingrese el Correo del Usuario!.",
            password: "Por favor ingrese el Password del Usuario!.",
            repetir_password: "Por favor repita el Password!.",
            id_tipo_usuario: "Por favor Seleccione el Tipo de Empleado!.",
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
    var username = $("#username").val();
    var password = $("#password").val();
    var correo = $("#correo").val();
    var repetir_password = $("#repetir_password").val();
    var id_tipo_usuario = $("#id_tipo_usuario").val();
    var administrador = 0;
    $("input[name='myCheckboxes1']:checked").each(function(index) {
        administrador = 1;
    });
    if (password == repetir_password) {
        var process = $('#process').val();
        if (process == 'insertar') {
            var id_usuario = 0;
            var url = base_url + '/usuarios/insertar_usuario';
        }
        if (process == 'editar') {
            var id_usuario = $('#id_usuario').val();
            var url = base_url + '/usuarios/modificar_usuario';
        }
        var datas_string = "nombre=" + nombre;
        datas_string += "&username=" + username;
        datas_string += "&password=" + password;
        datas_string += "&correo=" + correo;
        datas_string += "&id_tipo_usuario=" + id_tipo_usuario;
        datas_string += "&administrador=" + administrador;
        datas_string += "&id_usuario=" + id_usuario;
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
        display_notify("Error", "Los Password No Coinciden!!");
    }
}

function reload1() {
    let base_url = $("#base_url").val();
    location.href = base_url + '/usuarios/';
}

function deleted(id) {
    var base_url = $("#base_url").val();
    swal({
            title: "¿Esta seguro que desea eliminar este usuario?",
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
                url: base_url + "/usuarios/eliminar_usuario/" + id,
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
            title: "¿Esta seguro que desea desactivar este usuario?",
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
                url: base_url + "/usuarios/desactivar_usuario/" + id,
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
            title: "¿Esta seguro que desea activar este usuario?",
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
                url: base_url + "/usuarios/activar_usuario/" + id,
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
    var id_usuario = $('#id_usuario').val();
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
        url: base_url + "/usuarios/asignar_permiso_usuario/" + id_usuario,
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
    desactivar($(this).attr("id_usuario"));
});
$(document).on("click", ".activar", function() {
    activar($(this).attr("id_usuario"));
});
$(document).on("click", ".elim", function() {
    deleted($(this).attr("id_usuario"));
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
            'url': base_url + "/usuarios/getUsuarios",
            'data': function(data) {
                return {
                    data: data,
                };
            },
        },
        'columns': [
            { data: 'id_usuario' },
            { data: 'usuario' },
            { data: 'nombre' },
            { data: 'correo' },
            { data: 'label_admin' },
            { data: 'tipo_usuario' },
            { data: 'activo' },
            { data: 'boton' },
        ]
    });
}
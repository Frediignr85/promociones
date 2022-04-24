$(document).ready(function() {
    generar2();
    $('.select').select2();
    $('#formulario').validate({
        rules: {
            nombre: {
                required: true,
            },
            descripcion: {
                required: true,
            },
            id_tipo_aviso: {
                required: true,
            },
        },
        messages: {
            nombre: "Por favor ingrese el Nombre del Aviso!.",
            descripcion: "Por favor ingrese la Descripcion del Aviso!.",
            id_tipo_aviso: "Por favor seleccione el Tipo de Aviso!.",
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
    var descripcion = $("#descripcion").val();
    var id_tipo_aviso = $("#id_tipo_aviso").val();
    var process = $('#process').val();
    if (process == 'insertar') {
        var id_aviso = 0;
        var url = base_url + '/avisos/insertar_aviso';
    }
    if (process == 'editar') {
        var id_aviso = $('#id_aviso').val();
        var url = base_url + '/avisos/modificar_aviso';
    }
    var datas_string = "nombre=" + nombre;
    datas_string += "&descripcion=" + descripcion;
    datas_string += "&id_tipo_aviso=" + id_tipo_aviso;
    datas_string += "&id_aviso=" + id_aviso;
    $.ajax({
        type: 'POST',
        url: url,
        data: datas_string,
        dataType: 'json',
        success: function(datax) {
            display_notify(datax.typeinfo, datax.msg);
            if (datax.typeinfo == "Success") {
                $("#id_imagen_perfil").val(datax.id_tipo_aviso);
                $("#send_form_perfil").click();
            }
        }
    });
}

function reload1() {
    let base_url = $("#base_url").val();
    location.href = base_url + '/avisos/';
}

function deleted(id) {
    var base_url = $("#base_url").val();
    swal({
            title: "¿Esta seguro que desea eliminar este aviso?",
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
                url: base_url + "/avisos/eliminar_aviso/" + id,
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
            title: "¿Esta seguro que desea desactivar este aviso?",
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
                url: base_url + "/avisos/desactivar_aviso/" + id,
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
            title: "¿Esta seguro que desea activar este aviso?",
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
                url: base_url + "/avisos/activar_aviso/" + id,
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
    desactivar($(this).attr("id_aviso"));
});
$(document).on("click", ".activar", function() {
    activar($(this).attr("id_aviso"));
});
$(document).on("click", ".elim", function() {
    deleted($(this).attr("id_aviso"));
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
            'url': base_url + "/avisos/getAvisos",
            'data': function(data) {
                return {
                    data: data,
                };
            },
        },
        'columns': [
            { data: 'id_aviso' },
            { data: 'nombre' },
            { data: 'descripcion' },
            { data: 'nombre_tipo_aviso' },
            { data: 'activo' },
            { data: 'boton' },
        ]
    });
}
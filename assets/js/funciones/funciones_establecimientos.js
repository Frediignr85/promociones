$(document).ready(function() {
    generar2();
    $('.select').select2();
    $('#formulario').validate({
        rules: {
            nombre: {
                required: true,
            },
            id_usuario: {
                required: true,
            },
            id_categoria: {
                required: true,
            },
        },
        messages: {
            nombre: "Por favor ingrese el Nombre del Establecimiento!.",
            id_usuario: "Por favor seleccione el Usuario Encargado del Establecimiento!.",
            id_categoria: "Por favor seleccione la Categoria del Establecimiento!.",
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
    var id_usuario = $("#id_usuario").val();
    var urlx = $("#url").val();
    var id_categoria = $("#id_categoria").val();
    var process = $('#process').val();
    if (process == 'insertar') {
        var id_establecimiento = 0;
        var url = base_url + '/establecimientos/insertar_establecimiento';
    }
    if (process == 'editar') {
        var id_establecimiento = $('#id_establecimiento').val();
        var url = base_url + '/establecimientos/modificar_establecimiento';
    }
    var datas_string = "nombre=" + nombre;
    datas_string += "&id_usuario=" + id_usuario;
    datas_string += "&url=" + urlx;
    datas_string += "&id_categoria=" + id_categoria;
    datas_string += "&id_establecimiento=" + id_establecimiento;
    $.ajax({
        type: 'POST',
        url: url,
        data: datas_string,
        dataType: 'json',
        success: function(datax) {
            display_notify(datax.typeinfo, datax.msg);
            if (datax.typeinfo == "Success") {
                $("#id_imagen_perfil").val(datax.id_categoria);
                $("#id_imagen_banner").val(datax.id_categoria);
                $("#send_form_perfil").click();
            }
        }
    });
}

function reload1() {
    let base_url = $("#base_url").val();
    location.href = base_url + '/establecimientos/';
}

function deleted(id) {
    var base_url = $("#base_url").val();
    swal({
            title: "¿Esta seguro que desea eliminar este establecimiento?",
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
                url: base_url + "/establecimientos/eliminar_establecimiento/" + id,
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
            title: "¿Esta seguro que desea desactivar este establecimiento?",
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
                url: base_url + "/establecimientos/desactivar_establecimiento/" + id,
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
            title: "¿Esta seguro que desea activar este establecimiento?",
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
                url: base_url + "/establecimientos/activar_establecimiento/" + id,
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
    desactivar($(this).attr("id_establecimiento"));
});
$(document).on("click", ".activar", function() {
    activar($(this).attr("id_establecimiento"));
});
$(document).on("click", ".elim", function() {
    deleted($(this).attr("id_establecimiento"));
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
            'url': base_url + "/establecimientos/getEstablecimientos",
            'data': function(data) {
                return {
                    data: data,
                };
            },
        },
        'columns': [
            { data: 'id_establecimiento' },
            { data: 'nombre' },
            { data: 'nombre_usuario' },
            { data: 'nombre_categoria' },
            { data: 'activo' },
            { data: 'boton' },
        ],
        columnDefs: [
            { orderable: false, targets: 5 }
        ],
    });
}
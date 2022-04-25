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
            color: {
                required: true,
            },
        },
        messages: {
            nombre: "Por favor ingrese el nombre del tipo de promocion!.",
            descripcion: "Por favor ingrese la descripcion del tipo de promocion!.",
            color: "Por favor ingrese el color representativo del tipo de promocion!.",
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
    var color = $("#color").val();
    var process = $('#process').val();
    if (process == 'insertar') {
        var id_tipo_promocion = 0;
        var url = base_url + '/catalogos/insertar_tipo_promocion';
    }
    if (process == 'editar') {
        var id_tipo_promocion = $('#id_tipo_promocion').val();
        var url = base_url + '/catalogos/modificar_tipo_promocion';
    }
    var datas_string = "nombre=" + nombre;
    datas_string += "&descripcion=" + descripcion;
    datas_string += "&color=" + color;
    datas_string += "&id_tipo_promocion=" + id_tipo_promocion;
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
    location.href = base_url + '/catalogos/admin_tipo_promociones';
}

function deleted(id) {
    var base_url = $("#base_url").val();
    swal({
            title: "¿Esta seguro que desea eliminar este tipo de promocion?",
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
                url: base_url + "/catalogos/eliminar_tipo_promocion/" + id,
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
            title: "¿Esta seguro que desea desactivar este tipo de promocion?",
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
                url: base_url + "/catalogos/desactivar_tipo_promocion/" + id,
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
            title: "¿Esta seguro que desea activar este tipo de promocion?",
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
                url: base_url + "/catalogos/activar_tipo_promocion/" + id,
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
    desactivar($(this).attr("id_tipo_promocion"));
});
$(document).on("click", ".activar", function() {
    activar($(this).attr("id_tipo_promocion"));
});
$(document).on("click", ".elim", function() {
    deleted($(this).attr("id_tipo_promocion"));
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
            'url': base_url + "/catalogos/getTipoPromocion",
            'data': function(data) {
                return {
                    data: data,
                };
            },
        },
        'columns': [
            { data: 'id_tipo_promocion' },
            { data: 'nombre' },
            { data: 'descripcion' },
            { data: 'color' },
            { data: 'activo' },
            { data: 'boton' },
        ],
        columnDefs: [
            { orderable: false, targets: 5 }
        ],
    });
}
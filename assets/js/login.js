$(document).ready(function() {
    toastr.options = {
        "closeButton": true,
        "newestOnTop": false,
        "progressBar": true,
        "positionClass": "toast-bottom-center",
        "preventDuplicates": false,
        "onclick": null,
        "showDuration": "300",
        "hideDuration": "1000",
        "timeOut": "5000",
        "extendedTimeOut": "1000",
        "showEasing": "swing",
        "hideEasing": "linear",
        "showMethod": "fadeIn",
        "hideMethod": "fadeOut"
    }
    $("#fecha_nacimiento").val("");
});
$("#btn_recuperar_cuenta").click(function() {
    let email = $("#email").val();
    let msg = "";
    let error = false;
    if (email == "") {
        error = true;
        msg = "Hace Falta Introducir el Email!";
    }
    if (error) {
        swal({
            title: "Error!",
            text: msg,
            icon: "error",
            button: "Ok!",
        });
    } else {
        if (/^(([^<>()[\]\.,;:\s@\"]+(\.[^<>()[\]\.,;:\s@\"]+)*)|(\".+\"))@(([^<>()[\]\.,;:\s@\"]+\.)+[^<>()[\]\.,;:\s@\"]{2,})$/i.test(email)) {
            let base_url = $("#base_url").val();
            $.ajax({
                type: 'POST',
                url: base_url + "/recuperar/enviar",
                data: {
                    email: email,
                },
                dataType: 'json',
                async: false,
                success: function(datax) {
                    if (datax.typeinfo == "Success") {
                        swal({
                            title: "Exito!",
                            text: datax.msg,
                            icon: "success",
                            button: "Ok!",
                        });
                        setInterval("reload1();", 1500);
                    } else {
                        swal({
                            title: "Error!",
                            text: datax.msg,
                            icon: "error",
                            button: "Ok!",
                        });
                    }
                }
            });
        } else {
            swal({
                title: "Error!",
                text: "El formato de email no es correcto!",
                icon: "error",
                button: "Ok!",
            });
        }
    }
});

$("#btn_login_ingresar").click(function() {
    let username = $("#username").val();
    let password = $("#password").val();
    let msg = "";
    let error = false;
    if (username == "") {
        error = true;
        msg = "Hace Falta Introducir el Username!";
    } else if (password == "") {
        error = true;
        msg = "Hace Falta Introducir el Password!";
    }
    if (error) {
        swal({
            title: "Error!",
            text: msg,
            icon: "error",
            button: "Ok!",
        });
    } else {
        let base_url = $("#base_url").val();
        $.ajax({
            type: 'POST',
            url: base_url + "/login/login",
            data: {
                password: password,
                username: username,
            },
            dataType: 'json',
            async: false,
            success: function(datax) {
                if (datax.typeinfo == "Success") {
                    swal({
                        title: "Exito!",
                        text: datax.msg,
                        icon: "success",
                        button: "Ok!",
                    });
                    setInterval("reload2();", 1500);
                } else {
                    swal({
                        title: "Error!",
                        text: datax.msg,
                        icon: "error",
                        button: "Ok!",
                    });
                }
            }
        });
    }
});
$("#btn_cambiar_contra").click(function() {
    let password = $("#password").val();
    let repetir_password = $("#repetir_password").val();
    let id_cuenta_recuperar = $("#id_cuenta_recuperar").val();
    let msg = "";
    let error = false;
    if (password == "") {
        error = true;
        msg = "Hace Falta Introducir la Contraseña!";
    } else if (repetir_password == "") {
        error = true;
        msg = "Hace Falta Introducir la Confirmacion de la Contraseña!";
    }
    if (error) {
        swal({
            title: "Error!",
            text: msg,
            icon: "error",
            button: "Ok!",
        });
    } else {
        if (password == repetir_password) {
            let base_url = $("#base_url").val();
            $.ajax({
                type: 'POST',
                url: base_url + "/recuperar/cambiar",
                data: {
                    password: password,
                    id_cuenta_recuperar: id_cuenta_recuperar,
                },
                dataType: 'json',
                async: false,
                success: function(datax) {
                    if (datax.typeinfo == "Success") {
                        swal({
                            title: "Exito!",
                            text: datax.msg,
                            icon: "success",
                            button: "Ok!",
                        });
                        setInterval("reload1();", 1500);
                    } else {
                        swal({
                            title: "Error!",
                            text: datax.msg,
                            icon: "error",
                            button: "Ok!",
                        });
                    }
                }
            });
        } else {
            swal({
                title: "Error!",
                text: "Las Contraseñas no Coinciden!",
                icon: "error",
                button: "Ok!",
            });
        }
    }
});




function reload1() {
    let base_url = $("#base_url").val();
    location.href = base_url + '/login';
}

function reload2() {
    let base_url = $("#base_url").val();
    location.href = base_url + '/dashboard';
}
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





function reload1() {
    let base_url = $("#base_url").val();
    location.href = base_url + '/login';
}

function reload2() {
    let base_url = $("#base_url").val();
    location.href = base_url + '/dashboard';
}
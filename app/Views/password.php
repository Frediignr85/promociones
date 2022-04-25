<div class="modal-header">
    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
    <h4 class="modal-title">Cambiar Password</h4>
</div>
<div class="modal-body">
    <div class="wrapper wrapper-content  animated fadeInRight">
        <div class="row" id="row1">
            <div class="col-lg-12">
                <div class="form-group">
                    <label class="control-label">Contraseña actual</label>
                    <input type="password" name="oldpass" id="oldpass" class="form-control col-lg-10" value="">
                </div>
                <div class="form-group">
                    <br>
                </div>
                <div class="form-group">
                    <label class="control-label">Contraseña nueva</label>
                    <input type="password" name="newpass" id="newpass" class="form-control col-lg-10" value="">
                </div>
            </div>
        </div>
    </div>
</div>
<script>
    $(function() {
        $(document).on('hidden.bs.modal', function(e) {
            var target = $(e.target);
            target.removeData('bs.modal').find(".modal-content").html('');
        });
        $(document).on("click", "#btnCambiar", function() {
            let oldpass = $("#oldpass").val();
            let newpass = $("#newpass").val();
            cambiar_pass(oldpass, newpass);
        });


});

function cambiar_pass(oldpass, newpass) {
    let base_url = $("#base_url").val();
    $.ajax({
        type: 'POST',
        url: base_url + "/password/cambiar_password",
        data: {
            oldpass: oldpass,
            newpass: newpass,
        },
        dataType: 'json',
        async: false,
        success: function(datax) {
            if (datax.typeinfo == "Success") {
                $("#btnCerrar").click();
                swal({
                    title: "Exito!",
                    text: datax.msg,
                    icon: "success",
                    button: "Ok!",
                });
                setInterval("location.reload()", 1500);

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
</script>
<div class="modal-footer">
    <button type="button" class="btn btn-primary" id="btnCambiar">Cambiar</button>
    <button type="button" class="btn btn-default" id="btnCerrar" data-dismiss="modal">Cerrar</button>
</div>
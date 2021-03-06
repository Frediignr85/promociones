<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <script src="https://kit.fontawesome.com/64d58efce2.js" crossorigin="anonymous"></script>
    <link rel="stylesheet" href="<?php echo base_url("/assets/css/style_login.css") ?>" />
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
	<link rel='stylesheet' href='https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.css'>

    <title>Login y Registro</title>
</head>

<body>
    <div class="container-login">
        <div class="forms-container-login">
            <div class="signin-signup">
                <form action="#" class="sign-in-form">
                    <h1 class="title">Recuperar Contraseña</h1>
                    <p>
                        Se le enviara un correo al email ingresado con los pasos a seguir.
                    </p>
                    <div class="input-field">
                        <i class="fas fa-envelope"></i>
                        <input type="email" id="email" name="email" placeholder="Correo" />
                    </div>
                    <?php
                        if(isset($_GET['id_request'])){
                            if($_GET['id_request'] == 0){
                                echo "<p class=\"text-danger\">No se pudo activar la cuenta!!</p>";
                            }
                            elseif($_GET['id_request'] == 1){
                                echo "<p class=\"text-success\">Cuenta Activada con Exito!!</p>";
                            }
                        }
                    ?>
                    <input type="button" id="btn_recuperar_cuenta" name="btn_recuperar_cuenta" value="Recuperar" class="btn-login solid" />
                </form>
            </div>
        </div>
        <br><br><br><br><br>
        <div class="panels-container">
            <div class="panel left-panel">
                <div class="content">
                    <h3>¿Deseas Iniciar Sesion?</h3>
                    <p>
                        Da click al boton volver.
                    </p>
                    <a href="login"  class="btn btn-secondary" >Volver</a>
                </div>
                <img src="<?php echo base_url("/assets/images/log.svg") ?>" class="image" alt="" />
            </div>
        </div>
    </div>
	<input type="hidden" name="base_url" id="base_url" value="<?php echo base_url(); ?>">
	<script src="https://cpwebassets.codepen.io/assets/common/stopExecutionOnTimeout-1b93190375e9ccc259df3a57c1abc0e64599724ae30d7ea4c6877eb615f89387.js"></script>
	<script src="https://code.jquery.com/jquery-3.6.0.js" integrity="sha256-H+K7U5CnXl1h5ywQfKtSj8PCmoN9aaq30gDh27Xc0jk=" crossorigin="anonymous"></script>
	<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous"></script>
    <script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script>
	<script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.js"></script>
	<?php
		$a = rand(1,9999);
		$src = base_url("/assets/js/login.js?t".$a."=".$a);
		echo "<script src=\"$src\"></script>";
	?>
	
</body>

</html>
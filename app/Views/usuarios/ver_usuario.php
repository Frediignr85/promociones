<div class="modal-header">
	<button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
	<h4 class="modal-title">Datos de Tipo de Empleado</h4>
</div>
<div class="modal-body">
	<div class="wrapper wrapper-content  animated fadeInRight">
        <div class="row">
            <div class="col-lg-6 col-sm-6 col-md-6 col-xl-6 col-6">
                <div class="form-group has-info single-line rounded-top" >
                    <label class="control-label"><span style="color:red;">* </span> Nombre: </label>
                    <input type="text" class="form-control" name="nombre" id="nombre" onkeyup="mayus(this)" placeholder="Ingrese el Nombre Corto del Usuario" value="<?php echo $array_usuario[0]['nombre']; ?>" disabled>
                </div>
            </div>
            <div class="col-lg-6 col-sm-6 col-md-6 col-xl-6 col-6">
                <div class="form-group has-info single-line rounded-top" >
                    <label class="control-label"><span style="color:red;">* </span> Username: </label>
                    <input type="text" class="form-control" name="username" id="username" placeholder="Ingrese el Username del Usuario" value="<?php echo $array_usuario[0]['usuario']; ?>" disabled>
                </div>
            </div>
            <div class="col-lg-6 col-sm-6 col-md-6 col-xl-6 col-6">
                <div class="form-group has-info single-line rounded-top" >
                    <label class="control-label"><span style="color:red;">* </span> Correo: </label>
                    <input type="text" class="form-control" name="correo" id="correo" placeholder="Ingrese el Correo del Usuario" value="<?php echo $array_usuario[0]['correo']; ?>" disabled>
                </div>
            </div>
            <div class="col-lg-6 col-sm-6 col-md-6 col-xl-6 col-6">
                <div class="form-group has-info single-line rounded-top" >
                    <label class="control-label"><span style="color:red;">* </span> Empleado: </label>
                    <select class="form-control select" name="empleado" id="empleado" style="width:100%;" disabled>
                        <option value="">Seleccione el Empleado</option>
                        <?php
                            foreach ($array_tipo_usuario as $key => $value) {
                                echo "<option value='".$value["id_tipo_usuario"]."'";
                                if($array_usuario[0]['id_tipo_usuario'] == $value['id_tipo_usuario']){
                                    echo " selected ";
                                }
                                echo ">".$value["nombre"]."</option>";
                            }
                        ?>
                    </select>
                </div>
            </div>
            <div class="col-lg-6 col-sm-6 col-md-6 col-xl-6 col-6">
                <div class="form-group has-info single-line rounded-top" >
                    <p>
                    <?php
                        if($array_usuario[0]['admin']){
                    ?>
                        <div class='checkbox i-checks'><label> <input id='myCheckboxes1' name='myCheckboxes1' type='checkbox' checked  disabled> <i></i>Administrador</label></div>
                    <?php
                        }
                        else{
                    ?>
                        <div class='checkbox i-checks'><label> <input id='myCheckboxes1' name='myCheckboxes1' type='checkbox'  disabled> <i></i>Administrador</label></div>
                    <?php
                        }
                    ?>
                    </p>
                </div>
            </div>
        </div>
	</div>
    <div class="modal-footer">
        <button type='button' class='btn btn-default' data-dismiss='modal'>Cerrar</button>
    </div>

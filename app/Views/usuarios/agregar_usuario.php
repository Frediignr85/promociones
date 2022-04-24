<div class="row">
    <div class="col-lg-12" style="margin-top: 1%;">
        <div class="panel panel-default">
            <div class="panel-heading text-center">
                <h3 class='text-primary'><i class="fa fa-user"></i> Registro de Usuario</h3> (Los campos marcados con <span style="color:red;">*</span> son requeridos)
            </div>
            <div class="panel-body">
                <form id="formulario" autocomplete="off">
                    <div class="row">
                        <div class="col-lg-6 col-sm-6 col-md-6 col-xl-6 col-6">
                            <div class="form-group has-info single-line rounded-top" >
                                <label class="control-label"><span style="color:red;">* </span> Nombre: </label>
								<input type="text" class="form-control" name="nombre" id="nombre" onkeyup="mayus(this)" placeholder="Ingrese el Nombre Corto del Usuario">
                            </div>
                        </div>
                        <div class="col-lg-6 col-sm-6 col-md-6 col-xl-6 col-6">
                            <div class="form-group has-info single-line rounded-top" >
                                <label class="control-label"><span style="color:red;">* </span> Correo: </label>
								<input type="text" class="form-control" name="correo" id="correo" placeholder="Ingrese el Correo del Usuario">
                            </div>
                        </div>
                        <div class="col-lg-4 col-sm-4 col-md-4 col-xl-4 col-4">
                            <div class="form-group has-info single-line rounded-top" >
                                <label class="control-label"><span style="color:red;">* </span> Username: </label>
								<input type="text" class="form-control" name="username" id="username" placeholder="Ingrese el Username del Usuario">
                            </div>
                        </div>
                        <div class="col-lg-4 col-sm-4 col-md-4 col-xl-4 col-4">
                            <div class="form-group has-info single-line rounded-top" >
                                <label class="control-label"><span style="color:red;">* </span> Password: </label>
								<input type="password" class="form-control" name="password" id="password" placeholder="Ingrese el Password del Usuario">
                            </div>
                        </div>
                        <div class="col-lg-4 col-sm-4 col-md-4 col-xl-4 col-4">
                            <div class="form-group has-info single-line rounded-top" >
                                <label class="control-label"><span style="color:red;">* </span> Repetir Password: </label>
								<input type="password" class="form-control" name="repetir_password" id="repetir_password" placeholder="Repita el Password">
                            </div>
                        </div>
                        <div class="col-lg-6 col-sm-6 col-md-6 col-xl-6 col-6">
                            <div class="form-group has-info single-line rounded-top" >
                                <label class="control-label"><span style="color:red;">* </span> Tipo de Usuario: </label>
                                <select class="form-control select" name="id_tipo_usuario" id="id_tipo_usuario" style="width:100%;">
                                    <option value="">Seleccione el Empleado</option>
                                    <?php
                                        foreach ($array_tipo_usuario as $key => $value) {
                                            echo "<option value='".$value["id_tipo_usuario"]."'>".$value["nombre"]."</option>";
                                        }
                                    ?>
                                </select>
                            </div>
                        </div>
                        <div class="col-lg-6 col-sm-6 col-md-6 col-xl-6 col-6">
                            <div class="form-group has-info single-line rounded-top" >
                                <p>
                                    <div class='checkbox i-checks'><label> <input id='myCheckboxes1' name='myCheckboxes1' type='checkbox'> <i></i>Administrador</label></div>
                                </p>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-lg-5 col-sm-5 col-md-5 col-xl-5 col-5 text-center">
                            <hr>
                        </div>
                        <div class="col-lg-2 text-center">
                            <hr>
                        </div>
                        <div class="col-lg-5 col-sm-5 col-md-5 col-xl-5 col-5 text-center">
                            <hr>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-lg-12 col-sm-12 col-md-12 col-xl-12 col-12 text-right">
                            <input type="hidden" name="process" id="process" value="insertar">
                            <input type="submit" value="Guardar" class="btn btn-primary">
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
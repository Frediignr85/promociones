<div class="row">
    <div class="col-lg-12" style="margin-top: 1%;">
        <div class="panel panel-default">
            <div class="panel-heading text-center">
                <h3 class='text-primary'><i class="fa fa-user"></i> Registro de Sucursal</h3> (Los campos marcados con <span style="color:red;">*</span> son requeridos)
            </div>
            <div class="panel-body">
                <div class="row">                    
                    <div class="col-lg-12">
                        <form id="formulario" autocomplete="off">
                            <div class="row">
                                <div class="col-lg-12 col-sm-12 col-md-12 col-xl-12 col-12">
                                    <div class="form-group has-info single-line rounded-top" >
                                        <label class="control-label"><span style="color:red;">* </span> Nombre: </label>
                                        <input type="text" class="form-control" name="nombre" id="nombre" onkeyup="mayus(this)" placeholder="Ingrese el Nombre Corto de la Sucursal">
                                    </div>
                                </div>
                                <div class="col-lg-12 col-sm-12 col-md-12 col-xl-12 col-12">
                                    <div class="form-group has-info single-line rounded-top" >
                                        <label class="control-label"><span style="color:red;">* </span> Direccion: </label>
                                        <input type="text" class="form-control" name="direccion" id="direccion"  placeholder="Ingrese la Direccion de la Sucursal">
                                    </div>
                                </div>
                                <div class="col-lg-6 col-sm-6 col-md-6 col-xl-6 col-6">
                                    <div class="form-group has-info single-line rounded-top" >
                                        <label class="control-label"><span style="color:red;">* </span> Departamento: </label>
                                        <select class="form-control select" name="id_departamento" id="id_departamento" style="width:100%;">
                                            <option value="">Seleccione el Departamento</option>
                                            <?php
                                                foreach ($array_departamentos as $key => $value) {
                                                    echo "<option value='".$value["id_departamento"]."'>".$value["nombre"]."</option>";
                                                }
                                            ?>
                                        </select>
                                    </div>
                                </div>
                                <div class="col-lg-6 col-sm-6 col-md-6 col-xl-6 col-6">
                                    <div class="form-group has-info single-line rounded-top" >
                                        <label class="control-label"><span style="color:red;">* </span> Municipio: </label>
                                        <select class="form-control select" name="id_municipio" id="id_municipio" style="width:100%;">
                                            <option value="">Primero Seleccione un Departamento...</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="col-lg-6 col-sm-6 col-md-6 col-xl-6 col-6">
                                    <div class="form-group has-info single-line rounded-top" >
                                        <label class="control-label"><span style="color:red;">* </span> Telefono: </label>
                                        <input type="text" class="form-control tel" name="telefono" id="telefono"  placeholder="Ingrese la Telefono de la Sucursal">
                                    </div>
                                </div>
                                <div class="col-lg-6 col-sm-6 col-md-6 col-xl-6 col-6">
                                    <div class="form-group has-info single-line rounded-top" >
                                        <label class="control-label"> URL de Ubicacion Maps: </label>
                                        <input type="text" class="form-control" name="url" id="url" placeholder="Ingrese la URL de la Ubicacion de la Sucursal">
                                    </div>
                                </div>
                                <div class="col-lg-6 col-sm-6 col-md-6 col-xl-6 col-6">
                                    <div class="form-group has-info single-line rounded-top" >
                                        <label class="control-label"><span style="color:red;">* </span> Encargado: </label>
                                        <select class="form-control select" name="id_usuario" id="id_usuario" style="width:100%;">
                                            <option value="">Seleccione el Encargado</option>
                                            <?php
                                                foreach ($array_usuarios as $key => $value) {
                                                    echo "<option value='".$value["id_usuario"]."'>".$value["nombre"]."</option>";
                                                }
                                            ?>
                                        </select>
                                    </div>
                                </div>
                                <div class="col-lg-6 col-sm-6 col-md-6 col-xl-6 col-6">
                                    <div class="form-group has-info single-line rounded-top" >
                                        <label class="control-label"><span style="color:red;">* </span> Establecimiento: </label>
                                        <select class="form-control select" name="id_establecimiento" id="id_establecimiento" style="width:100%;">
                                            <option value="">Seleccione el Establecimiento de la Sucursal</option>
                                            <?php
                                                foreach ($array_establecimientos as $key => $value) {
                                                    echo "<option value='".$value["id_establecimiento"]."'>".$value["nombre"]."</option>";
                                                }
                                            ?>
                                        </select>
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
    </div>
</div>
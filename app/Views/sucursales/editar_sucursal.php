<div class="row">
    <div class="col-lg-12" style="margin-top: 1%;">
        <div class="panel panel-default">
            <div class="panel-heading text-center">
                <h3 class='text-primary'><i class="fa fa-user"></i> Edicion de Sucursal</h3> (Los campos marcados con <span style="color:red;">*</span> son requeridos)
            </div>
            <div class="panel-body">
                <div class="row">                    
                    <div class="col-lg-12">
                        <form id="formulario" autocomplete="off">
                            <div class="row">
                                <div class="col-lg-12 col-sm-12 col-md-12 col-xl-12 col-12">
                                    <div class="form-group has-info single-line rounded-top" >
                                        <label class="control-label"><span style="color:red;">* </span> Nombre: </label>
                                        <input type="text" class="form-control" name="nombre" id="nombre" onkeyup="mayus(this)" placeholder="Ingrese el Nombre Corto de la Sucursal" value="<?php echo $array_sucursal[0]['nombre'];?>">
                                    </div>
                                </div>
                                <div class="col-lg-12 col-sm-12 col-md-12 col-xl-12 col-12">
                                    <div class="form-group has-info single-line rounded-top" >
                                        <label class="control-label"><span style="color:red;">* </span> Direccion: </label>
                                        <input type="text" class="form-control" name="direccion" id="direccion"  placeholder="Ingrese la Direccion de la Sucursal"  value="<?php echo $array_sucursal[0]['direccion'];?>">
                                    </div>
                                </div>
                                <div class="col-lg-6 col-sm-6 col-md-6 col-xl-6 col-6">
                                    <div class="form-group has-info single-line rounded-top" >
                                        <label class="control-label"><span style="color:red;">* </span> Departamento: </label>
                                        <select class="form-control select" name="id_departamento" id="id_departamento" style="width:100%;">
                                            <option value="">Seleccione el Departamento</option>
                                            <?php
                                                foreach ($array_departamentos as $key => $value) {
                                                    echo "<option value='".$value["id_departamento"]."'";
                                                    if($array_sucursal[0]['id_departamento'] == $value['id_departamento']){
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
                                        <label class="control-label"><span style="color:red;">* </span> Municipio: </label>
                                        <select class="form-control select" name="id_municipio" id="id_municipio" style="width:100%;">
                                            <option value="">Seleccione el Municipio</option>
                                            <?php
                                                foreach ($array_municipios as $key => $value) {
                                                    echo "<option value='".$value["id_municipio"]."'";
                                                    if($array_sucursal[0]['id_municipio'] == $value['id_municipio']){
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
                                        <label class="control-label"><span style="color:red;">* </span> Telefono: </label>
                                        <input type="text" class="form-control tel" name="telefono" id="telefono"  placeholder="Ingrese la Telefono de la Sucursal"  value="<?php echo $array_sucursal[0]['telefono'];?>">
                                    </div>
                                </div>
                                <div class="col-lg-6 col-sm-6 col-md-6 col-xl-6 col-6">
                                    <div class="form-group has-info single-line rounded-top" >
                                        <label class="control-label"> URL de Ubicacion Maps: </label>
                                        <input type="text" class="form-control" name="url" id="url" placeholder="Ingrese la URL de la Ubicacion de la Sucursal" value="<?php echo $array_sucursal[0]['url'];?>">
                                    </div>
                                </div>
                                <div class="col-lg-6 col-sm-6 col-md-6 col-xl-6 col-6">
                                    <div class="form-group has-info single-line rounded-top" >
                                        <label class="control-label"><span style="color:red;">* </span> Encargado: </label>
                                        <select class="form-control select" name="id_usuario" id="id_usuario" style="width:100%;">
                                            <option value="">Seleccione el Encargado</option>
                                            <?php
                                                foreach ($array_usuarios as $key => $value) {
                                                    echo "<option value='".$value["id_usuario"]."'";
                                                    if($array_sucursal[0]['id_usuario'] == $value['id_usuario']){
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
                                        <label class="control-label"><span style="color:red;">* </span> Establecimiento: </label>
                                        <select class="form-control select" name="id_establecimiento" id="id_establecimiento" style="width:100%;" disabled>
                                            <option value="">Seleccione el Establecimiento de la Sucursal</option>
                                            <?php
                                                foreach ($array_establecimientos as $key => $value) {
                                                    echo "<option value='".$value["id_establecimiento"]."'";
                                                    if($array_sucursal[0]['id_establecimiento'] == $value['id_establecimiento']){
                                                        echo " selected ";
                                                    }
                                                    echo">".$value["nombre"]."</option>";
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
                                    <input type="hidden" name="process" id="process" value="editar">
                                    <input type="hidden" name="id_sucursal" id="id_sucursal" value="<?php echo $array_sucursal[0]['id_sucursal']; ?>">
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
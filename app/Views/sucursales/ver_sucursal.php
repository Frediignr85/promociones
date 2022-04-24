<div class="modal-header">
	<button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
	<h4 class="modal-title">Datos de la Sucursal</h4>
</div>
<div class="modal-body">
	<div class="wrapper wrapper-content  animated fadeInRight">
        <div class="row">
            <div class="col-lg-12 col-sm-12 col-md-12 col-xl-12 col-12">
                <div class="form-group has-info single-line rounded-top" >
                    <label class="control-label"><span style="color:red;">* </span> Nombre: </label>
                    <input type="text" class="form-control" name="nombre" id="nombre" onkeyup="mayus(this)" placeholder="Ingrese el Nombre Corto de la Sucursal" value="<?php echo $array_sucursal[0]['nombre'];?>" disabled>
                </div>
            </div>
            <div class="col-lg-12 col-sm-12 col-md-12 col-xl-12 col-12">
                <div class="form-group has-info single-line rounded-top" >
                    <label class="control-label"><span style="color:red;">* </span> Direccion: </label>
                    <input type="text" class="form-control" name="direccion" id="direccion"  placeholder="Ingrese la Direccion de la Sucursal"  value="<?php echo $array_sucursal[0]['direccion'];?>" disabled>
                </div>
            </div>
            <div class="col-lg-12 col-sm-12 col-md-12 col-xl-12 col-12">
                <div class="form-group has-info single-line rounded-top" >
                    <label class="control-label"> URL de Ubicacion Maps: </label>
                    <input type="text" class="form-control" name="url" id="url" placeholder="Ingrese la URL de la Ubicacion de la Sucursal" value="<?php echo $array_sucursal[0]['url'];?>"  disabled>
                </div>
            </div>
            <div class="col-lg-6 col-sm-6 col-md-6 col-xl-6 col-6">
                <div class="form-group has-info single-line rounded-top" >
                    <label class="control-label"><span style="color:red;">* </span> Departamento: </label>
                    <select class="form-control select" name="id_departamento" id="id_departamento" style="width:100%;"  disabled>
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
                    <select class="form-control select" name="id_municipio" id="id_municipio" style="width:100%;"  disabled>
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
                    <input type="text" class="form-control tel" name="telefono" id="telefono"  placeholder="Ingrese la Telefono de la Sucursal"  value="<?php echo $array_sucursal[0]['telefono'];?>"  disabled>
                </div>
            </div>
            <div class="col-lg-6 col-sm-6 col-md-6 col-xl-6 col-6">
                <div class="form-group has-info single-line rounded-top" >
                    <label class="control-label"><span style="color:red;">* </span> Encargado: </label>
                    <select class="form-control select" name="id_usuario" id="id_usuario" style="width:100%;"  disabled>
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
            <div class="col-lg-12 col-sm-12 col-md-12 col-xl-12 col-12" ><br>
                <div class=" text-center">
                    <h3>Contactos</h3>
                </div>
            </div>
        </div>
        <div class="row">
            <!--- SEPARADOR DIV --->
            <div class="col-lg-12 col-sm-12 col-md-12 col-xl-12 col-12">
                <table class="table table-hover table-striped table-bordered">
                    <thead>
                        <tr>
                            <th>NOMBRE</th>
                            <th>DEPARTAMENTO</th>
                            <th>MUNICIPIO</th>
                            <th>DIRECCION</th>
                            <th>TIPO DE CONTACTO</th>
                            <th>INFO TIPO CONTACTO</th>
                        </tr>
                    </thead>
                    <tbody id="contactos_table">
                    <?php
                        foreach ($array_contactos as $key => $value) {
                            $nombre_contacto = $value['nombre'];
                            $direccion = $value['direccion'];
                            $info_tipo_contacto = $value['info_tipo_contacto'];
                            $id_departamento = $value['id_departamento'];
                            $nombre_departamento = $value['nombre_departamento'];
                            $id_municipio = $value['id_municipio'];
                            $nombre_municipio = $value['nombre_municipio'];
                            $id_tipo_contacto = $value['id_tipo_contacto'];
                            $nombre_tipo_contacto = $value['nombre_tipo_contacto'];

                    ?>
                        <tr class='campo'>
                            <td class='nombre_contacto'><?php echo $nombre_contacto; ?></td>
                            <td class='id_departamento_contacto' hidden><?php echo $id_departamento; ?></td>
                            <td><?php echo $nombre_departamento; ?></td>
                            <td class='id_municipio_contacto' hidden><?php echo $id_municipio; ?></td>
                            <td><?php echo $nombre_municipio; ?></td>
                            <td class='direccion_contacto'><?php echo $direccion; ?></td>
                            <td class='id_tipo_contacto' hidden><?php echo $id_tipo_contacto; ?></td>
                            <td><?php echo $nombre_tipo_contacto; ?></td>
                            <td class='informacion_tipo_contacto'><?php echo $nombre_tipo_contacto; ?></td>
                        </tr>
                    <?php
                        }

                    ?>
                    </tbody>
                </table>
            </div>
            <!--- SEPARADOR DIV --->
        </div>
	</div>
    <div class="modal-footer">
        <button type='button' class='btn btn-default' data-dismiss='modal'>Cerrar</button>
    </div>

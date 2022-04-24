<div class="modal-header">
	<button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
	<h4 class="modal-title">Datos del Establecimiento</h4>
</div>
<div class="modal-body">
	<div class="wrapper wrapper-content  animated fadeInRight">
        <div class="row">
            <div class="col-lg-12">
                <label class="control-label"> Foto de Perfil: </label>
                <?php if ($array_establecimiento[0]['imagen_logo']!="") { ?>
                <!--Widgwt imagen-->
                <div class="col-lg-12 center-block">
                    <div class="widget style1 gray-bg text-center">
                    <div class="m-b-md" id='imagen'>
                        <img alt="image" class="img-rounded" src=<?php echo base_url("")."/assets/".$array_establecimiento[0]['imagen_logo']; ?> width="250px" height="150px" border='1'>
                    </div>
                    </div>
                </div>
                <!--Fin Widgwt imagen-->
                <?php }
                else{
                $descripcion="No tine imagen de logo asignada";
                echo "<div class='span12 text-center'><strong>$descripcion</strong></div>";
                }
                ?>
            </div>
            <div class="col-lg-12">
                <label class="control-label"> Foto de Banner: </label>
                <?php if ($array_establecimiento[0]['imagen_banner']!="") { ?>
                <!--Widgwt imagen-->
                <div class="col-lg-12 center-block">
                    <div class="widget style1 gray-bg text-center">
                    <div class="m-b-md" id='imagen'>
                        <img alt="image" class="img-rounded" src=<?php echo base_url("")."/assets/".$array_establecimiento[0]['imagen_banner']; ?> width="250px" height="150px" border='1'>
                    </div>
                    </div>
                </div>
                <!--Fin Widgwt imagen-->
                <?php }
                else{
                $descripcion="No tine de banner imagen asignada";
                echo "<div class='span12 text-center'><strong>$descripcion</strong></div>";
                }
                ?>
            </div>
            <div class="col-lg-12 col-sm-12 col-md-12 col-xl-12 col-12">
                <div class="form-group has-info single-line rounded-top" >
                    <label class="control-label"><span style="color:red;">* </span> Nombre: </label>
                    <input type="text" class="form-control" name="nombre" id="nombre" onkeyup="mayus(this)" placeholder="Ingrese el Nombre Corto del Usuario" value="<?php echo $array_establecimiento[0]['nombre']; ?>" disabled>
                </div>
            </div>
            <div class="col-lg-12 col-sm-12 col-md-12 col-xl-12 col-12">
                <div class="form-group has-info single-line rounded-top" >
                    <label class="control-label"> URL pagina Web: </label>
                    <input type="text" class="form-control" name="url" id="url" placeholder="Ingrese la URL de la Pagina Web del Establecimiento" value="<?php echo $array_establecimiento[0]['url']; ?>" disabled>
                </div>
            </div>                        
            <div class="col-lg-6 col-sm-6 col-md-6 col-xl-6 col-6">
                <div class="form-group has-info single-line rounded-top" >
                    <label class="control-label"><span style="color:red;">* </span> Encargado: </label>
                    <select class="form-control select" name="id_usuario" id="id_usuario" style="width:100%;" disabled>
                    <option value="">Seleccione el Encargado</option>
                        <?php
                            foreach ($array_usuarios as $key => $value) {
                                echo "<option value='".$value["id_usuario"]."'";
                                if($array_establecimiento[0]['id_usuario'] == $value['id_usuario']){
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
                    <label class="control-label"><span style="color:red;">* </span> Categoria: </label>
                    <select class="form-control select" name="id_categoria" id="id_categoria" style="width:100%;" disabled>
                        <option value="">Seleccione la Categoria del Establecimiento</option>
                        <?php
                            foreach ($array_categorias as $key => $value) {
                                echo "<option value='".$value["id_categoria"]."'";
                                if($array_establecimiento[0]['id_categoria'] == $value['id_categoria']){
                                    echo " selected ";
                                }
                                echo ">".$value["nombre"]."</option>";
                            }
                        ?>
                    </select>
                </div>
            </div>
        </div>
	</div>
    <div class="modal-footer">
        <button type='button' class='btn btn-default' data-dismiss='modal'>Cerrar</button>
    </div>

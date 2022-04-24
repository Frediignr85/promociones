<div class="modal-header">
	<button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
	<h4 class="modal-title">Datos de la Categoria</h4>
</div>
<div class="modal-body">
	<div class="wrapper wrapper-content  animated fadeInRight">
        <div class="row">
            <div class="col-lg-12">
                <label class="control-label"> Foto de Perfil: </label>
                <?php if ($array_categoria[0]['imagen_logo']!="") { ?>
                <!--Widgwt imagen-->
                <div class="col-lg-12 center-block">
                    <div class="widget style1 gray-bg text-center">
                    <div class="m-b-md" id='imagen'>
                        <img alt="image" class="img-rounded" src=<?php echo base_url("")."/assets/".$array_categoria[0]['imagen_logo']; ?> width="250px" height="150px" border='1'>
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
                <?php if ($array_categoria[0]['imagen_banner']!="") { ?>
                <!--Widgwt imagen-->
                <div class="col-lg-12 center-block">
                    <div class="widget style1 gray-bg text-center">
                    <div class="m-b-md" id='imagen'>
                        <img alt="image" class="img-rounded" src=<?php echo base_url("")."/assets/".$array_categoria[0]['imagen_banner']; ?> width="250px" height="150px" border='1'>
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
                    <input type="text" class="form-control" name="nombre" id="nombre" onkeyup="mayus(this)" placeholder="Ingrese el Nombre de la Categoria" value="<?php echo $array_categoria[0]["nombre"]; ?>" disabled>
                </div>
            </div>
            <div class="col-lg-12 col-sm-12 col-md-12 col-xl-12 col-12">
                <div class="form-group has-info single-line rounded-top" >
                    <label class="control-label"><span style="color:red;">* </span> Descripcion: </label>
                    <input type="text" class="form-control" name="descripcion" id="descripcion" onkeyup="mayus2(this)" placeholder="Ingrese la Descripcion de la Categoria" value="<?php echo $array_categoria[0]["descripcion"]; ?>" disabled>
                </div>
            </div>
        </div>
	</div>
    <div class="modal-footer">
        <button type='button' class='btn btn-default' data-dismiss='modal'>Cerrar</button>
    </div>

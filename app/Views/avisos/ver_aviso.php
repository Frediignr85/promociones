<div class="modal-header">
	<button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
	<h4 class="modal-title">Datos del Establecimiento</h4>
</div>
<div class="modal-body">
	<div class="wrapper wrapper-content  animated fadeInRight">
        <div class="row">
            <div class="col-lg-12">
                <label class="control-label"> Foto del Aviso: </label>
                <?php if ($array_aviso[0]['imagen_aviso']!="") { ?>
                <!--Widgwt imagen-->
                <div class="col-lg-12 center-block">
                    <div class="widget style1 gray-bg text-center">
                    <div class="m-b-md" id='imagen'>
                        <img alt="image" class="img-rounded" src=<?php echo base_url("")."/assets/".$array_aviso[0]['imagen_aviso']; ?> width="250px" height="150px" border='1'>
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
            
            <div class="col-lg-12 col-sm-12 col-md-12 col-xl-12 col-12">
                <div class="form-group has-info single-line rounded-top" >
                    <label class="control-label"><span style="color:red;">* </span> Nombre: </label>
                    <input type="text" class="form-control" name="nombre" id="nombre" onkeyup="mayus(this)" placeholder="Ingrese el Nombre del Aviso" value="<?php echo $array_aviso[0]['nombre']; ?>" disabled>
                </div>
            </div>
            <div class="col-lg-12 col-sm-12 col-md-12 col-xl-12 col-12">
                <div class="form-group has-info single-line rounded-top" >
                    <label class="control-label"><span style="color:red;">* </span> Tipo de Aviso: </label>
                    <select class="form-control select" name="id_tipo_aviso" id="id_tipo_aviso" style="width:100%;" disabled>
                        <option value="">Seleccione el Tipo de Aviso</option>
                        <?php
                            foreach ($array_tipo_avisos as $key => $value) {
                                echo "<option value='".$value["id_tipo_aviso"]."'";
                                if($array_aviso[0]['id_tipo_aviso'] == $value['id_tipo_aviso']){
                                    echo " selected ";
                                }
                                echo ">".$value["nombre"]."</option>";
                            }
                        ?>
                    </select>
                </div>
            </div>
            <div class="col-lg-12 col-sm-12 col-md-12 col-xl-12 col-12">
                <div class="form-group has-info single-line rounded-top" >
                    <label class="control-label"><span style="color:red;">* </span> Descripcion: </label>
                    <textarea name="descripcion" id="descripcion" cols="30" rows="10" style="width: 100%;" disabled><?php echo $array_aviso[0]['descripcion']; ?></textarea>
                </div>
            </div>
        </div>
	</div>
    <div class="modal-footer">
        <button type='button' class='btn btn-default' data-dismiss='modal'>Cerrar</button>
    </div>

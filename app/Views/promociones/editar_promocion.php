<div class="row">
    <div class="col-lg-12" style="margin-top: 1%;">
        <div class="panel panel-default">
            <div class="panel-heading text-center">
                <h3 class='text-primary'><i class="fa fa-user"></i> Edicion de Promocion</h3> (Los campos marcados con <span style="color:red;">*</span> son requeridos)
            </div>
            <div class="panel-body">
                <div class="row">                    
                    <div class="col-lg-12">
                        <form id="formulario" autocomplete="off">
                            <div class="row">
                                <div class="col-lg-4 col-sm-4 col-md-4 col-xl-4 col-4">
                                    <div class="form-group has-info single-line rounded-top" >
                                        <label class="control-label"><span style="color:red;">* </span> Establecimiento: </label>
                                        <select class="form-control select" name="id_establecimiento" id="id_establecimiento" style="width:100%;" disabled>
                                            <option value="">Seleccione el Establecimiento</option>
                                            <?php
                                                foreach ($array_establecimientos as $key => $value) {
                                                    echo "<option value='".$value["id_establecimiento"]."'";
                                                    if($array_promocion[0]['id_establecimiento'] == $value['id_establecimiento']){
                                                        echo " selected ";
                                                    }
                                                    echo">".$value["nombre"]."</option>";
                                                }
                                            ?>
                                        </select>
                                    </div>
                                </div>
                                <div class="col-lg-4 col-sm-4 col-md-4 col-xl-4 col-4">
                                    <div class="form-group has-info single-line rounded-top" >
                                        <label class="control-label"><span style="color:red;">* </span> Sucursal: </label>
                                        <select class="form-control select" name="id_sucursal" id="id_sucursal" style="width:100%;" disabled>
                                            <option value="">Seleccione la Sucursal</option>
                                            <?php
                                                foreach ($array_sucursales as $key => $value) {
                                                    echo "<option value='".$value["id_sucursal"]."'";
                                                    if($array_promocion[0]['id_sucursal'] == $value['id_sucursal']){
                                                        echo " selected ";
                                                    }
                                                    echo">".$value["nombre"]."</option>";
                                                }
                                            ?>
                                        </select>
                                    </div>
                                </div>
                                <div class="col-lg-4 col-sm-4 col-md-4 col-xl-4 col-4">
                                    <div class="form-group has-info single-line rounded-top" >
                                        <label class="control-label"><span style="color:red;">* </span> Tipo de Promocion: </label>
                                        <select class="form-control select" name="id_tipo_promocion" id="id_tipo_promocion" style="width:100%;">
                                            <option value="">Seleccione el Tipo de Promocion</option>
                                            <?php
                                                foreach ($array_tipo_promociones as $key => $value) {
                                                    echo "<option value='".$value["id_tipo_promocion"]."'";
                                                    if($array_promocion[0]['id_tipo_promocion'] == $value['id_tipo_promocion']){
                                                        echo " selected ";
                                                    }
                                                    echo ">".$value["nombre"]."</option>";
                                                }
                                            ?>
                                        </select>
                                    </div>
                                </div>
                                <div class="col-lg-3 col-sm-3 col-md-3 col-xl-3 col-3">
                                    <div class="form-group has-info single-line rounded-top" >
                                        <label><span style="color:red;">* </span> Fecha Inicio:</label>
                                        <input type="text" placeholder="Ingrese la fecha de inicio" class="form-control datepicker" id="fecha_inicio" name="fecha_inicio" required  value="<?php echo ED($array_promocion[0]['fecha_inicio']); ?>">
                                    </div>
                                </div>
                                <div class="col-lg-3 col-sm-3 col-md-3 col-xl-3 col-3">
                                    <div class="form-group has-info single-line rounded-top" >
                                        <label><span style="color:red;">* </span> Fecha Inicio:</label>
                                        <input type="text" placeholder="Ingrese la hora de inicio" class="form-control" id="hora_inicio" name="hora_inicio" value="<?php echo _hora_media_decode($array_promocion[0]['hora_inicio']); ?>">
                                    </div>
                                </div>
                                <div class="col-lg-3 col-sm-3 col-md-3 col-xl-3 col-3">
                                    <div class="form-group has-info single-line rounded-top" >
                                        <label><span style="color:red;">* </span> Fecha Fin:</label>
                                        <input type="text" placeholder="Ingrese la fecha de finalizacion" class="form-control datepicker" id="fecha_fin" name="fecha_fin" required value="<?php echo ED($array_promocion[0]['fecha_fin']); ?>">
                                    </div>                                    
                                </div>
                                <div class="col-lg-3 col-sm-3 col-md-3 col-xl-3 col-3">
                                    <div class="form-group has-info single-line rounded-top" >
                                        <label><span style="color:red;">* </span> Fecha Fin:</label>
                                        <input type="text" placeholder="Ingrese la hora de finalizacion" class="form-control" id="hora_fin" name="hora_fin" value="<?php echo _hora_media_decode($array_promocion[0]['hora_fin']); ?>">
                                    </div>
                                </div>

                                <div class="col-lg-6 col-sm-6 col-md-6 col-xl-6 col-6">
                                    <div class="form-group has-info single-line rounded-top" >
                                        <label class="control-label"><span style="color:red;">* </span> Nombre: </label>
                                        <input type="text" class="form-control" name="nombre" id="nombre" onkeyup="mayus(this)" placeholder="Ingrese el Nombre de la Promocion" value="<?php echo $array_promocion[0]['nombre']; ?>">
                                    </div>
                                </div>
                                <div class="col-lg-6 col-sm-6 col-md-6 col-xl-6 col-6">
                                    <div class="form-group has-info single-line rounded-top" >
                                        <label class="control-label"><span style="color:red;">* </span> Codigo: </label>
                                        <input type="text" class="form-control" name="codigo" id="codigo" placeholder="Ingrese el Codigo de la Promocion" value="<?php echo $array_promocion[0]['codigo']; ?>">
                                    </div>
                                </div>
                                <div class="col-lg-12 col-sm-12 col-md-12 col-xl-12 col-12">
                                    <div class="form-group has-info single-line rounded-top" >
                                        <label class="control-label"><span style="color:red;">* </span> Descripcion: </label>
                                        <textarea name="descripcion" id="descripcion" cols="30" rows="10" style="width: 100%;"><?php echo $array_promocion[0]['descripcion']; ?></textarea>
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
                                    <input type="hidden" name="id_promocion" id="id_promocion" value="<?php echo $array_promocion[0]['id_promocion']; ?>">
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
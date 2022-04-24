<div class="row">
    <div class="col-lg-12" style="margin-top: 1%;">
        <div class="panel panel-default">
            <div class="panel-heading text-center">
                <h3 class='text-primary'><i class="fa fa-user"></i> Edicion de Permisos del Usuario</h3> (Los campos marcados con <span style="color:red;">*</span> son requeridos)
            </div>
            <div class="panel-body">
                <form id="formulario" autocomplete="off">
                    <div class="row">
                        <div class="col-lg-12 col-sm-12 col-md-12 col-xl-12 col-12 form-group">
                            <div class="row">
                                <hr>
                                <?php
                                    $contador = 1;
                                    foreach ($array_permisos as $key => $value) {
                                        if($contador > 4){
                                            echo "</div>";
                                            echo"<div class='row'>";
                                            echo "<hr>";
                                            $contador = 1;
                                        }
                                        $id_menu = $value['id_menu'];
                                        $nombre_menu = $value['nombre_menu'];
                                        $icono = $value['icono'];
                                        $modulos = $value['modulos'];
                                ?>
                                <div class="col-lg-3 col-sm-3 col-md-3 col-xl-3 col-3 form-group">
                                    <div class="panel panel-info">
                                        <div class="panel-heading">
                                            <i class='<?php echo $icono ?> icon-large'></i> <?php echo $nombre_menu; ?>
                                        </div>
                                        <div class="panel-body">
                                            <?php
                                                foreach ($modulos as $key => $value2) {
                                                    $id_modulo = $value2['id_modulo'];
                                                    $nombre_modulo = $value2['nombre_modulo'];
                                                    $permiso = $value2['permiso'];
                                                    if($permiso){
                                            ?>
                                            <p>
                                                <div class='checkbox i-checks'><label> <input id='myCheckboxes' name='myCheckboxes' type='checkbox' value='<?php echo $id_modulo; ?>' checked> <i></i><?php echo ucfirst($nombre_modulo); ?></label></div>
                                            </p>
                                            <?php
                                                    }
                                                    else{
                                            ?>
                                            <p>
                                                <div class='checkbox i-checks'><label> <input id='myCheckboxes' name='myCheckboxes' type='checkbox' value='<?php echo $id_modulo; ?>'> <i></i><?php echo ucfirst($nombre_modulo); ?></label></div>
                                            </p>    
                                            <?php
                                                    }
                                                }
                                            ?>
                                        </div>
                                    </div>
                                </div>    
                                <?php
                                
                                   $contador++;
                                    }
                                ?>
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
                            <input type="hidden" name="process" id="process" value="permiso">
                            <input type="hidden" name="id_usuario" id="id_usuario" value="<?php echo $id_usuario; ?>">
                            <input type="submit" value="Guardar" id="btnPermiso" class="btn btn-primary">
                        </div>
                    </div>
                    <br>
                </form>
            </div>
        </div>
    </div>
</div>
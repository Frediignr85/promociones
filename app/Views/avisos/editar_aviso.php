<div class="row">
    <div class="col-lg-12" style="margin-top: 1%;">
        <div class="panel panel-default">
            <div class="panel-heading text-center">
                <h3 class='text-primary'><i class="fa fa-user"></i> Edicacion de Aviso</h3> (Los campos marcados con <span style="color:red;">*</span> son requeridos)
            </div>
            <div class="panel-body">
                <div class="row">
                    <div class="col-lg-12">
                        <form style="justify-content:right;" action="<?php echo base_url('/avisos/store_perfil');?>" name="ajax_form"
                            id="ajax_form" method="post" accept-charset="utf-8" enctype="multipart/form-data">
                            <div class="row">
                                <div class="row">
                                    <div class="form-group col-md-3">
                                        <img id="blah"
                                            src="<?php echo base_url("")."/assets/".$array_aviso[0]['imagen_aviso']; ?>"
                                            class="" width="100" height="100" style="float: right;" />
                                    </div>
                                    <div class="form-group col-md-9">
                                        <label for="formGroupExampleInput">Seleccione la foto de perfil</label>
                                        <input type="file" name="file" class="form-control" id="file"
                                            onchange="readURL(this);" accept=".png, .jpg, .jpeg" />
                                            <input type="hidden" name="id_imagen_perfil" id="id_imagen_perfil"  value="<?php $array_aviso[0]['id_aviso'] ?>"> 
                                    </div>
                                </div>                                
                                
                                <div class="form-group">
                                    <button type="submit" id="send_form_perfil" class="btn btn-success" style="display: none;">Submit</button>
                                </div>
                            </div>
                        </form>
                    </div>
                    <div class="col-lg-12">
                        <form id="formulario" autocomplete="off">
                            <div class="row">
                                <div class="col-lg-12 col-sm-12 col-md-12 col-xl-12 col-12">
                                    <div class="form-group has-info single-line rounded-top" >
                                        <label class="control-label"><span style="color:red;">* </span> Nombre: </label>
                                        <input type="text" class="form-control" name="nombre" id="nombre" onkeyup="mayus(this)" placeholder="Ingrese el Nombre del Aviso" value="<?php echo $array_aviso[0]['nombre']; ?>">
                                    </div>
                                </div>
                                <div class="col-lg-12 col-sm-12 col-md-12 col-xl-12 col-12">
                                    <div class="form-group has-info single-line rounded-top" >
                                        <label class="control-label"><span style="color:red;">* </span> Tipo de Aviso: </label>
                                        <select class="form-control select" name="id_tipo_aviso" id="id_tipo_aviso" style="width:100%;">
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
                                        <textarea name="descripcion" id="descripcion" cols="30" rows="10" style="width: 100%;"><?php echo $array_aviso[0]['descripcion']; ?></textarea>
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
                                    <input type="hidden" name="id_aviso" id="id_aviso" value="<?php echo $array_aviso[0]['id_aviso']; ?>">
                                    <input type="submit" value="Guardar" class="btn btn-primary">
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
                <script>
                    function readURL(input, id) {
                        id = id || '#blah';
                        if (input.files && input.files[0]) {
                            var reader = new FileReader();

                            reader.onload = function(e) {
                                $(id)
                                    .attr('src', e.target.result)
                                    .width(200)
                                    .height(150);
                            };

                            reader.readAsDataURL(input.files[0]);
                        }
                    }
                </script>
            </div>
        </div>
    </div>
</div>
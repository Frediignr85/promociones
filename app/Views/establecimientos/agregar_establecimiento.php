<div class="row">
    <div class="col-lg-12" style="margin-top: 1%;">
        <div class="panel panel-default">
            <div class="panel-heading text-center">
                <h3 class='text-primary'><i class="fa fa-user"></i> Registro de Establecimiento</h3> (Los campos marcados con <span style="color:red;">*</span> son requeridos)
            </div>
            <div class="panel-body">
                <div class="row">
                    <div class="col-lg-12">
                        <form style="justify-content:right;" action="<?php echo base_url('/establecimientos/store_perfil');?>" name="ajax_form"
                            id="ajax_form" method="post" accept-charset="utf-8" enctype="multipart/form-data">
                            <div class="row">
                                <div class="row">
                                    <div class="form-group col-md-3">
                                        <img id="blah"
                                            src="<?php echo base_url("")."/assets/img/fondo.jpg"; ?>"
                                            class="" width="100" height="100" style="float: right;" />
                                    </div>
                                    <div class="form-group col-md-9">
                                        <label for="formGroupExampleInput">Seleccione la foto de perfil</label>
                                        <input type="file" name="file" class="form-control" id="file"
                                            onchange="readURL(this);" accept=".png, .jpg, .jpeg" />
                                            <input type="hidden" name="id_imagen_perfil" id="id_imagen_perfil" value=""> 
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="form-group col-md-3">
                                        <img id="blah2"
                                            src="<?php echo base_url("")."/assets/img/12123.png"; ?>"
                                            class="" width="100" height="100" style="float: right;" />
                                    </div>
                                    <div class="form-group col-md-9">
                                        <label for="formGroupExampleInput">Seleccione la foto de banner</label>
                                        <input type="file" name="file2" class="form-control" id="file2"
                                            onchange="readURL2(this);" accept=".png, .jpg, .jpeg" />
                                            <input type="hidden" name="id_imagen_banner" id="id_imagen_banner" value=""> 
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
                                        <input type="text" class="form-control" name="nombre" id="nombre" onkeyup="mayus(this)" placeholder="Ingrese el Nombre Corto del Establecimiento">
                                    </div>
                                </div>
                                <div class="col-lg-12 col-sm-12 col-md-12 col-xl-12 col-12">
                                    <div class="form-group has-info single-line rounded-top" >
                                        <label class="control-label"> URL pagina Web: </label>
                                        <input type="text" class="form-control" name="url" id="url" placeholder="Ingrese la URL de la Pagina Web del Establecimiento">
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
                                        <label class="control-label"><span style="color:red;">* </span> Categoria: </label>
                                        <select class="form-control select" name="id_categoria" id="id_categoria" style="width:100%;">
                                            <option value="">Seleccione la Categoria del Establecimiento</option>
                                            <?php
                                                foreach ($array_categorias as $key => $value) {
                                                    echo "<option value='".$value["id_categoria"]."'>".$value["nombre"]."</option>";
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
                    function readURL2(input, id) {
                        id = id || '#blah2';
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
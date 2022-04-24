<div class="row">
    <div class="col-lg-12" style="margin-top: 1%;">
        <div class="panel panel-default">
            <div class="panel-heading text-center">
                <h3 class='text-primary'><i class="fa fa-user"></i> Edicion de Categoria</h3> (Los campos marcados con <span style="color:red;">*</span> son requeridos)
            </div>
            <div class="panel-body">
                <div class="row">
                    <div class="col-lg-12 col-sm-12 col-md-12 col-xl-12 col-12">
                        <form style="justify-content:right;" action="<?php echo base_url('/catalogos/store_perfil');?>" name="ajax_form"
                            id="ajax_form" method="post" accept-charset="utf-8" enctype="multipart/form-data">
                            <div class="row">
                                <div class="row">
                                    <div class="form-group col-md-3">
                                        <img id="blah"
                                            src="<?php echo base_url("")."/assets/".$array_categoria[0]["imagen_logo"]; ?>"
                                            class="" width="100" height="100" style="float: right;" />
                                    </div>
                                    <div class="form-group col-md-9">
                                        <label for="formGroupExampleInput">Seleccione la foto de perfil</label>
                                        <input type="file" name="file" class="form-control" id="file"
                                            onchange="readURL(this);" accept=".png, .jpg, .jpeg" />
                                            <input type="hidden" name="id_imagen_perfil" id="id_imagen_perfil" value="<?php echo $array_categoria[0]["id_categoria"]; ?>"> 
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="form-group col-md-3">
                                        <img id="blah2"
                                            src="<?php echo base_url("")."/assets/".$array_categoria[0]["imagen_banner"]; ?>"
                                            class="" width="100" height="100" style="float: right;" />
                                    </div>
                                    <div class="form-group col-md-9">
                                        <label for="formGroupExampleInput">Seleccione la foto de banner</label>
                                        <input type="file" name="file2" class="form-control" id="file2"
                                            onchange="readURL2(this);" accept=".png, .jpg, .jpeg" />
                                            <input type="hidden" name="id_imagen_banner" id="id_imagen_banner" value="<?php echo $array_categoria[0]["id_categoria"]; ?>"> 
                                    </div>
                                </div>
                                
                                
                                <div class="form-group">
                                    <button type="submit" id="send_form_perfil" class="btn btn-success" style="display: none;">Submit</button>
                                </div>
                        </form>
                    </div>
                    <div class="col-lg-12 col-sm-12 col-md-12 col-xl-12 col-12">
                        <form id="formulario" autocomplete="off">
                            <div class="row">
                                <div class="row">
                                
                                    <div class="col-lg-12 col-sm-12 col-md-12 col-xl-12 col-12">
                                        <div class="col-lg-6 col-sm-6 col-md-6 col-xl-6 col-6">
                                                <div class="form-group has-info single-line rounded-top" >
                                                    <label class="control-label"><span style="color:red;">* </span> Nombre: </label>
                                                    <input type="text" class="form-control" name="nombre" id="nombre" onkeyup="mayus(this)" placeholder="Ingrese el Nombre de la Categoria" value="<?php echo $array_categoria[0]["nombre"]; ?>">
                                                </div>
                                            </div>
                                            <div class="col-lg-6 col-sm-6 col-md-6 col-xl-6 col-6">
                                                <div class="form-group has-info single-line rounded-top" >
                                                    <label class="control-label"><span style="color:red;">* </span> Descripcion: </label>
                                                    <input type="text" class="form-control" name="descripcion" id="descripcion" onkeyup="mayus2(this)" placeholder="Ingrese la Descripcion de la Categoria" value="<?php echo $array_categoria[0]["descripcion"]; ?>">
                                                </div>
                                            </div>
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
                                    <input type="hidden" name="id_categoria" id="id_categoria" value="<?php echo $id_categoria; ?>">
                                    <input type="submit" value="Guardar" class="btn btn-primary">
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
                
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
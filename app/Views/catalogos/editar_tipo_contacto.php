<div class="row">
    <div class="col-lg-12" style="margin-top: 1%;">
        <div class="panel panel-default">
            <div class="panel-heading text-center">
                <h3 class='text-primary'><i class="fa fa-user"></i> Edicion de Tipo de Contacto</h3> (Los campos marcados con <span style="color:red;">*</span> son requeridos)
            </div>
            <div class="panel-body">
                <form id="formulario" autocomplete="off">
                    <div class="row">
                        <div class="col-lg-12 col-sm-12 col-md-12 col-xl-12 col-12">
                            <div class="form-group has-info single-line rounded-top" >
                                <label class="control-label"><span style="color:red;">* </span> Nombre: </label>
								<input type="text" class="form-control" name="nombre" id="nombre" onkeyup="mayus(this)" placeholder="Ingrese el Nombre del Tipo de Contacto" value="<?php echo $array_tipo_contacto[0]["nombre"]; ?>">
                            </div>
                        </div>
                        <div class="col-lg-12 col-sm-12 col-md-12 col-xl-12 col-12">
                            <div class="form-group has-info single-line rounded-top" >
                                <label class="control-label"><span style="color:red;">* </span> Descripcion: </label>
								<input type="text" class="form-control" name="descripcion" id="descripcion" onkeyup="mayus2(this)" placeholder="Ingrese la Descripcion del Tipo de Contacto" value="<?php echo $array_tipo_contacto[0]["descripcion"]; ?>">
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
                            <input type="hidden" name="id_tipo_contacto" id="id_tipo_contacto" value="<?php echo $id_tipo_contacto; ?>">
                            <input type="submit" value="Guardar" class="btn btn-primary">
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
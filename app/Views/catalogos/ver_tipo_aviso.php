<div class="modal-header">
	<button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
	<h4 class="modal-title">Datos del Tipo de Aviso</h4>
</div>
<div class="modal-body">
	<div class="wrapper wrapper-content  animated fadeInRight">
        <div class="row">
            <div class="col-lg-12 col-sm-12 col-md-12 col-xl-12 col-12">
                <div class="form-group has-info single-line rounded-top" >
                    <label class="control-label"><span style="color:red;">* </span> Nombre: </label>
                    <input type="text" class="form-control" name="nombre" id="nombre" onkeyup="mayus(this)" placeholder="Ingrese el Nombre del Tipo de Aviso" value="<?php echo $array_tipo_aviso[0]["nombre"]; ?>" disabled>
                </div>
            </div>
            <div class="col-lg-12 col-sm-12 col-md-12 col-xl-12 col-12">
                <div class="form-group has-info single-line rounded-top" >
                    <label class="control-label"><span style="color:red;">* </span> Descripcion: </label>
                    <input type="text" class="form-control" name="descripcion" id="descripcion" onkeyup="mayus2(this)" placeholder="Ingrese la Descripcion del Tipo de Aviso" value="<?php echo $array_tipo_aviso[0]["descripcion"]; ?>" disabled>
                </div>
            </div>
            <div class="col-lg-12 col-sm-12 col-md-12 col-xl-12 col-12">
                <div class="form-group has-info single-line rounded-top" >
                    <label class="control-label">Color Reconocimiento: </label>
                    <input type="color" class="form-control" name="color" id="color" placeholder="Ingrese el Color de Reconocimiento del Tipo de Aviso" value="<?php echo $array_tipo_aviso[0]["color"]; ?>" disabled>
                </div>
            </div>
        </div>
	</div>
    <div class="modal-footer">
        <button type='button' class='btn btn-default' data-dismiss='modal'>Cerrar</button>
    </div>

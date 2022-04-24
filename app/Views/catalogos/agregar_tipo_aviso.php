<div class="row">
    <div class="col-lg-12" style="margin-top: 1%;">
        <div class="panel panel-default">
            <div class="panel-heading text-center">
                <h3 class='text-primary'><i class="fa fa-user"></i> Registro de Tipo de Aviso</h3> (Los campos marcados con <span style="color:red;">*</span> son requeridos)
            </div>
            <div class="panel-body">
                <form id="formulario" autocomplete="off">
                    <div class="row">
                        <div class="col-lg-6 col-sm-6 col-md-6 col-xl-6 col-6">
                            <div class="form-group has-info single-line rounded-top" >
                                <label class="control-label"><span style="color:red;">* </span> Nombre: </label>
								<input type="text" class="form-control" name="nombre" id="nombre" onkeyup="mayus(this)" placeholder="Ingrese el Nombre del Tipo de Aviso">
                            </div>
                        </div>
                        <div class="col-lg-6 col-sm-6 col-md-6 col-xl-6 col-6">
                            <div class="form-group has-info single-line rounded-top" >
                                <label class="control-label"><span style="color:red;">* </span> Descripcion: </label>
								<input type="text" class="form-control" name="descripcion" id="descripcion" onkeyup="mayus2(this)" placeholder="Ingrese la Descripcion del Tipo de Aviso">
                            </div>
                        </div>
                        <div class="col-lg-6 col-sm-6 col-md-6 col-xl-6 col-6">
                            <div class="form-group has-info single-line rounded-top" >
                                <label class="control-label">Color Reconocimiento: </label>
								<input type="color" class="form-control" name="color" id="color" placeholder="Ingrese el Color de Reconocimiento del Tipo de Aviso">
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
    </div>
</div>
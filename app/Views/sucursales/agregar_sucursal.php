<div class="row">
    <div class="col-lg-12" style="margin-top: 1%;">
        <div class="panel panel-default">
            <div class="panel-heading text-center">
                <h3 class='text-primary'><i class="fa fa-user"></i> Registro de Sucursal</h3> (Los campos marcados con <span style="color:red;">*</span> son requeridos)
            </div>
            <div class="panel-body">
                <div class="row">                    
                    <div class="col-lg-12">
                        <form id="formulario" autocomplete="off">
                            <div class="row">
                                <div class="col-lg-12 col-sm-12 col-md-12 col-xl-12 col-12">
                                    <div class="form-group has-info single-line rounded-top" >
                                        <label class="control-label"><span style="color:red;">* </span> Nombre: </label>
                                        <input type="text" class="form-control" name="nombre" id="nombre" onkeyup="mayus(this)" placeholder="Ingrese el Nombre Corto de la Sucursal">
                                    </div>
                                </div>
                                <div class="col-lg-12 col-sm-12 col-md-12 col-xl-12 col-12">
                                    <div class="form-group has-info single-line rounded-top" >
                                        <label class="control-label"><span style="color:red;">* </span> Direccion: </label>
                                        <input type="text" class="form-control" name="direccion" id="direccion"  placeholder="Ingrese la Direccion de la Sucursal">
                                    </div>
                                </div>
                                <div class="col-lg-6 col-sm-6 col-md-6 col-xl-6 col-6">
                                    <div class="form-group has-info single-line rounded-top" >
                                        <label class="control-label"><span style="color:red;">* </span> Departamento: </label>
                                        <select class="form-control select" name="id_departamento" id="id_departamento" style="width:100%;">
                                            <option value="">Seleccione el Departamento</option>
                                            <?php
                                                foreach ($array_departamentos as $key => $value) {
                                                    echo "<option value='".$value["id_departamento"]."'>".$value["nombre"]."</option>";
                                                }
                                            ?>
                                        </select>
                                    </div>
                                </div>
                                <div class="col-lg-6 col-sm-6 col-md-6 col-xl-6 col-6">
                                    <div class="form-group has-info single-line rounded-top" >
                                        <label class="control-label"><span style="color:red;">* </span> Municipio: </label>
                                        <select class="form-control select" name="id_municipio" id="id_municipio" style="width:100%;">
                                            <option value="">Primero Seleccione un Departamento...</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="col-lg-6 col-sm-6 col-md-6 col-xl-6 col-6">
                                    <div class="form-group has-info single-line rounded-top" >
                                        <label class="control-label"><span style="color:red;">* </span> Telefono: </label>
                                        <input type="text" class="form-control tel" name="telefono" id="telefono"  placeholder="Ingrese la Telefono de la Sucursal">
                                    </div>
                                </div>
                                <div class="col-lg-6 col-sm-6 col-md-6 col-xl-6 col-6">
                                    <div class="form-group has-info single-line rounded-top" >
                                        <label class="control-label"> URL de Ubicacion Maps: </label>
                                        <input type="text" class="form-control" name="url" id="url" placeholder="Ingrese la URL de la Ubicacion de la Sucursal">
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
                                        <label class="control-label"><span style="color:red;">* </span> Establecimiento: </label>
                                        <select class="form-control select" name="id_establecimiento" id="id_establecimiento" style="width:100%;">
                                            <option value="">Seleccione el Establecimiento de la Sucursal</option>
                                            <?php
                                                foreach ($array_establecimientos as $key => $value) {
                                                    echo "<option value='".$value["id_establecimiento"]."'>".$value["nombre"]."</option>";
                                                }
                                            ?>
                                        </select>
                                    </div>
                                </div>
                                
                            </div>
                            <div class="row">
                                <div class="col-lg-10 col-sm-10 col-md-10 col-xl-10 col-10" ><br>
                                    <div class=" text-center">
                                        <h3 style="margin-left: 20%;">Contactos</h3>
                                    </div>
                                </div>
                                <div class="col-lg-2 col-sm-2 col-md-2 col-xl-2 col-2" >
                                    <br>
                                    <br>
                                    <button type="button" id="btn_add_contacto" style="justify-content:right; margin-bottom:20px;" class="btn btn-info">Agregar</button>
                                    <br>
                                </div>
                            </div>
                            <div class="row">                                
                                <div class="col-lg-2 col-sm-2 col-md-2 col-xl-2 col-2">
                                    <div class="form-group has-info single-line rounded-top" >
                                        <label class="control-label"><span style="color:red;">* </span> Nombre Contacto: </label>
                                        <input type="text" class="form-control clear" name="nombre_contacto" id="nombre_contacto" placeholder="Ingrese la Descripcion de la Presentacion">
                                    </div>
                                </div>
                                <div class="col-lg-2 col-sm-2 col-md-2 col-xl-2 col-2">
                                    <div class="form-group has-info single-line rounded-top" >
                                        <label class="control-label"><span style="color:red;">* </span> Departamento: </label>
                                        <select class="form-control select" name="id_departamento_contacto" id="id_departamento_contacto" style="width:100%;">
                                            <option value="">Seleccione el Departamento</option>
                                            <?php
                                                foreach ($array_departamentos as $key => $value) {
                                                    echo "<option value='".$value["id_departamento"]."'>".$value["nombre"]."</option>";
                                                }
                                            ?>
                                        </select>
                                    </div>
                                </div>
                                <div class="col-lg-2 col-sm-2 col-md-2 col-xl-2 col-2">
                                    <div class="form-group has-info single-line rounded-top" >
                                        <label class="control-label"><span style="color:red;">* </span> Municipio: </label>
                                        <select class="form-control select" name="id_municipio_contacto" id="id_municipio_contacto" style="width:100%;">
                                            <option value="">Primero Seleccione un Departamento...</option>
                                        </select>
                                    </div>
                                </div>                                 
                                <div class="col-lg-2 col-sm-2 col-md-2 col-xl-2 col-2">
                                    <div class="form-group has-info single-line rounded-top" >
                                        <label class="control-label"><span style="color:red;">* </span> Direccion Contacto: </label>
                                        <input type="text" class="form-control clear" name="direccion_contacto" id="direccion_contacto" placeholder="Ingrese la Direccion del Contacto">
                                    </div>
                                </div>    
                                <div class="col-lg-2 col-sm-2 col-md-2 col-xl-2 col-2">
                                    <div class="form-group has-info single-line rounded-top" >
                                        <label class="control-label"><span style="color:red;">* </span> Tipo de Contacto: </label>
                                        <select class="form-control select" name="id_tipo_contacto" id="id_tipo_contacto" style="width:100%;">
                                            <option value="">Seleccione el Tipo de Contacto</option>
                                            <?php
                                                foreach ($array_tipo_contactos as $key => $value) {
                                                    echo "<option value='".$value["id_tipo_contacto"]."'>".$value["nombre"]."</option>";
                                                }
                                            ?>
                                        </select>
                                    </div>
                                </div>                                 
                                <div class="col-lg-2 col-sm-2 col-md-2 col-xl-2 col-2">
                                    <div class="form-group has-info single-line rounded-top" >
                                        <label class="control-label"><span style="color:red;">* </span> Info Tipo Contacto: </label>
                                        <input type="text" class="form-control clear" name="informacion_tipo_contacto" id="informacion_tipo_contacto" placeholder="Ingrese la Informacion">
                                    </div>
                                </div>      

                            </div>
                            <div class="row">
                                <!--- SEPARADOR DIV --->
                                <div class="col-lg-12 col-sm-12 col-md-12 col-xl-12 col-12">
                                    <table class="table table-hover table-striped table-bordered">
                                        <thead>
                                            <tr>
                                                <th>NOMBRE</th>
                                                <th>DEPARTAMENTO</th>
                                                <th>MUNICIPIO</th>
                                                <th>DIRECCION</th>
                                                <th>TIPO DE CONTACTO</th>
                                                <th>INFO TIPO CONTACTO</th>
                                                <th>ACCIÓN</th>
                                            </tr>
                                        </thead>
                                        <tbody id="contactos_table">

                                        </tbody>
                                    </table>
                                </div>
                                <!--- SEPARADOR DIV --->
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
    </div>
</div>
<?php namespace App\Controllers;

use App\Controllers\BaseController;
use App\Models\ModeloCategorias;
use App\Models\ModeloPrincipal;
use App\Models\ModeloTipoUsuarioModulo;
use App\Models\ModeloTipoUsuarios;

class Catalogos extends BaseController{
    protected $modelName = 'App\Models\ModeloEmpleados';
    protected $format = 'json';
    public function __construct()
    {
        /*ACA MANDO A LLAMAR EL OBJETO DEL MODELO PRINCIPAL */
        $this->modelo_principal = new ModeloPrincipal();
        $this->modelo_categoria = new ModeloCategorias();
        $this->modelo_tipo_usuario = new ModeloTipoUsuarios();
        $this->modelo_tipo_usuario_modulo = new ModeloTipoUsuarioModulo();
        /* ACA INICIALIZO LA INSTANCIA PARA USAR LAS SESIONES */
        $this->session = session(); 
        /* ACA LLAMO LAS VARIABLES DE SESION */
        $this->id_usuario = $this->session->get('id_usuario');
        $this->admin = $this->session->get('admin');
        $this->id_sucursal_session = $this->session->get('id_sucursal');
        helper('utilidades'); 
    }
    

    /* FUNCION PARA LISTAR TODAS LAS CATEGORIAS */
    public function admin_categorias(){
        /* MODELO PRINCIPAL EN DONDE SE RECUPERAN DATOS GENERALES DEL SISTEMA */
        $modelo_principal = $this->modelo_principal;
        /* ESTA FUNCION SIRVE PARA TRAER LOS DATOS PRINCIPALES DEL SISTEMA */
        $id_usuario = 1;
        $admin = 1;
        /* ACA MANDO A LLAMAR EL MENU */
        $menu = $modelo_principal->menu($this->id_usuario,$this->admin);
        $datos['menu'] = $menu;

        $filename = "catalogos/agregar_categoria";
        $permiso = $this->modelo_principal->comprobar_permiso($filename,$this->id_usuario,$this->admin);
        if($permiso){
            $boton_agregar =    "<div class='ibox-title'>";
            $boton_agregar.=    "<a href='agregar_categoria' class='btn btn-primary' role='button'><i class='fa fa-plus icon-large'></i> Agregar Categoria</a>";
            $boton_agregar.=    "</div>";
        }
        $datos_admin['btn_add'] = $boton_agregar;
        echo view('template/header');
        echo view('template/main_menu',$datos);
        echo view('catalogos/admin_categorias',$datos_admin); 
        $datos3['url'] = '<script src="'.base_url("").'/assets/js/funciones/funciones_categorias.js" ></script>';
        echo view('template/footer',$datos3);
    }

    /* FUNCION PARA LLAMAR A LA VISTA PARA PODER AGREGAR UNA NUEVA CATEGORIA */
    public function agregar_categoria(){
        /* MODELO PRINCIPAL EN DONDE SE RECUPERAN DATOS GENERALES DEL SISTEMA */
        $modelo_principal = $this->modelo_principal;
        /* ESTA FUNCION SIRVE PARA TRAER LOS DATOS PRINCIPALES DEL SISTEMA */
        /* ACA MANDO A LLAMAR EL MENU */
        $menu = $modelo_principal->menu($this->id_usuario,$this->admin);
        $datos['menu'] = $menu;
        /*ACA IMPRIMO LAS VISTAS */
        echo view('template/header');
        echo view('template/main_menu',$datos);
        echo view('catalogos/agregar_categoria'); 
        $datos3['url'] = '<script src="'.base_url("").'/assets/js/funciones/funciones_categorias.js" ></script>';
        echo view('template/footer',$datos3);
    }
    
    /* FUNCION PARA INSERTAR UNA NUEVA CATEGORIA */
    public function insertar_categoria(){
        $nombres = addslashes($this->request->getPost('nombre'));
        $descripcion = addslashes($this->request->getPost('descripcion'));
        $id = $this->modelo_categoria->insert([
            'nombre' => $nombres,
            'descripcion' => $descripcion,
            'activo' =>'1',
        ]);
        if($this->modelo_categoria->get($id) != null){
            $xdatos['typeinfo'] = "Success";
            $xdatos['msg'] = "Categoria Registrada con Exito!.";
        }
        else{
            $xdatos['typeinfo'] = "Error";
            $xdatos['msg'] = "No se pudo registrar la Categoria, intente mas tarde!.";
        }
        echo json_encode($xdatos);
    }
    
    /* FUNCION PARA LLAMAR A LA VISTA PARA PODER EDITAR UNA CATEGORIA */
    public function editar_categoria($id_categoria){
        /* MODELO PRINCIPAL EN DONDE SE RECUPERAN DATOS GENERALES DEL SISTEMA */
        $modelo_principal = $this->modelo_principal;
        /* ACA MANDO A LLAMAR EL MENU */
        $menu = $modelo_principal->menu($this->id_usuario,$this->admin);
        $datos['menu'] = $menu;
        
        $array_categoria = $this->modelo_categoria->get($id_categoria);
        $datos2['array_categoria'] = $array_categoria;
        $datos2['id_categoria'] = $id_categoria;
        /*ACA IMPRIMO LAS VISTAS */
        echo view('template/header');
        echo view('template/main_menu',$datos);
        echo view('catalogos/editar_categoria',$datos2); 
        $datos3['url'] = '<script src="'.base_url("").'/assets/js/funciones/funciones_categorias.js" ></script>';
        echo view('template/footer',$datos3);
    }
    
    /* FUNCION PARA MODIFICAR UNA CATEGORIA */
    public function modificar_categoria(){
        $nombre = addslashes($this->request->getPost('nombre'));
        $descripcion = addslashes($this->request->getPost('descripcion'));
        $id_categoria = addslashes($this->request->getPost('id_categoria'));

        $this->modelo_categoria->update($id_categoria,[
            'nombre' => $nombre,
            'descripcion' => $descripcion,
        ]);
        if($this->modelo_categoria->get($id_categoria) != null){
            $xdatos['typeinfo'] = "Success";
            $xdatos['msg'] = "Categoria Editada con Exito!.";
        }
        else{
            $xdatos['typeinfo'] = "Error";
            $xdatos['msg'] = "No se pudo editar la Categoria, intente mas tarde!.";
        }
        echo json_encode($xdatos);
    }

    /* FUNCION PARA LLAMAR A LA VISTA PARA PODER VER LA INFORMACION DE UNA CATEGORIA */
    public function ver_categoria($id_categoria){
        $array_categoria = $this->modelo_categoria->get($id_categoria);
        $datos2['array_categoria'] = $array_categoria;
        echo view('catalogos/ver_categoria',$datos2); 
    }

    /* FUNCION PARA ELIMINAR UNA CATEGORIA */
    public function eliminar_categoria($id_categoria){
        $eliminar = $this->modelo_categoria->delete($id_categoria);
        if($eliminar){
            $xdatos['typeinfo'] = "Success";
            $xdatos['msg'] = "Categoria eliminada con exito!";
        }
        else{
            $xdatos['typeinfo'] = "Error";
            $xdatos['msg'] = "No se puede eliminar la Categoria, intentar mas tarde!";
        }
        echo json_encode($xdatos);
    }
    /* FUNCION PARA ACTIVAR UNA CATEGORIA */
    public function activar_categoria($id_categoria){
        $this->modelo_categoria->update($id_categoria,[
            'activo' =>'1',
        ]);
        if($this->modelo_categoria->get($id_categoria) != null){
            $xdatos['typeinfo'] = "Success";
            $xdatos['msg'] = "Categoria Activada con Exito!.";
        }
        else{
            $xdatos['typeinfo'] = "Error";
            $xdatos['msg'] = "No se pudo activar la Categoria, intente mas tarde!.";
        }
        echo json_encode($xdatos);
    }
    /* FUNCION PARA DESACTIVAR UNA CATEGORIA */
    public function desactivar_categoria($id_categoria){
        $this->modelo_categoria->update($id_categoria,[
            'activo' =>'0',
        ]);
        if($this->modelo_categoria->get($id_categoria) != null){
            $xdatos['typeinfo'] = "Success";
            $xdatos['msg'] = "Categoria Desactivado con Exito!.";
        }
        else{
            $xdatos['typeinfo'] = "Error";
            $xdatos['msg'] = "No se pudo desactivar la Categoria, intente mas tarde!.";
        }
        echo json_encode($xdatos);
    }

    /* FUNCION PARA TRAER LOS TIPOS DE USUARIOS AL DATATABLE */
    public function getCategorias(){
        $request = service('request');
        $postData = $request->getPost();
        $dtpostData = $postData['data'];
        $response = array();
        ## Read value
        $draw = $dtpostData['draw'];
        $start = $dtpostData['start'];
        $rowperpage = $dtpostData['length']; // Rows display per page
        $columnIndex = $dtpostData['order'][0]['column']; // Column index
        $columnName = $dtpostData['columns'][$columnIndex]['data']; // Column name
        $columnSortOrder = $dtpostData['order'][0]['dir']; // asc or desc
        $searchValue = $dtpostData['search']['value']; // Search value
        ## Total number of records without filtering
        $tipo_empleados = $this->modelo_categoria;
        $totalRecords = $tipo_empleados
                ->select('id_categoria')
                ->where('deleted_at',null)
                ->countAllResults();
        ## Total number of records with filtering
        $totalRecordwithFilter = $tipo_empleados->select("*")
                ->groupStart()
                    ->orLike('tblcategoria.nombre', $searchValue)
                    ->orLike('tblcategoria.descripcion', $searchValue)
                ->groupEnd()
                ->groupStart()
                ->where('tblcategoria.deleted_at',null)
                ->groupEnd()
                ->countAllResults();
        ## Fetch records
        $records = $tipo_empleados->select("*")
                ->groupStart()
                    ->orLike('tblcategoria.nombre', $searchValue)
                    ->orLike('tblcategoria.descripcion', $searchValue)
                ->groupEnd()
                ->groupStart()
                ->where('tblcategoria.deleted_at',null)
                ->groupEnd()
                ->orderBy($columnName,$columnSortOrder)
                ->findAll($rowperpage, $start);
        $data = array();
        foreach($records as $record ){
            $id_categoria = $record['id_categoria'];
            $nombre = $record['nombre'];
            $descripcion = $record['descripcion'];
            $activo = $record['activo'];
            $label_activo = "";
            $menudrop = "";
            $menudrop.="
            <div class='btn-group'>
            <button class='btn btn-primary dropdown-toggle' data-toggle='dropdown'>
            <i class=\"fa	fa-gears (alias)\"></i> Accion
            <span class='caret'></span>
            </button>
            <ul class='dropdown-menu'>";
            if ($record["activo"]==1) {
                $filename = "catalogos/editar_categoria";
                $permiso = $this->modelo_principal->comprobar_permiso($filename,$this->id_usuario,$this->admin);
                if($permiso)
                {
                    $menudrop.="<li><a href=\"editar_categoria/".$id_categoria."\"><i class='fa fa-edit (alias)'></i> Editar</a></li>";
                }
                $filename = "catalogos/borrar_categoria";
                $permiso = $this->modelo_principal->comprobar_permiso($filename,$this->id_usuario,$this->admin);
                if($permiso)
                {
                    $menudrop.="<li><a id_categoria='".$id_categoria."' class='elim'><i class='fa fa-trash (alias)'></i> Eliminar</a></li>";
                }
                $filename = "catalogos/ver_categoria";
                $permiso = $this->modelo_principal->comprobar_permiso($filename,$this->id_usuario,$this->admin);
                if($permiso)
                {
                    $menudrop.="<li><a data-toggle='modal' href='ver_categoria/".$id_categoria."' data-target='#viewModal' data-refresh='true'><i class=\"fa fa-search\"></i> Ver Detalle</a></li>";
                }
            }
            $filename = "catalogos/estado_categoria";
            $permiso = $this->modelo_principal->comprobar_permiso($filename,$this->id_usuario,$this->admin);
            if($permiso)
            {
                if ($record["activo"]==1) {
                    $menudrop.="<li><a id_categoria='".$id_categoria."' class='desactivar'><i class='fa fa-eye-slash'></i> Desactivar</a></li>";
                    $label_activo = "<span class=\"label label-info\">Activo</span>";
                }else {
                    $menudrop.="<li><a id_categoria='".$id_categoria."' class='activar'><i class='fa fa-eye'></i> Activar</a></li>";
                    $label_activo = "<span class=\"label label-danger\">Inactivo</span>";
                }
            }
            $menudrop.="</ul>
            </div>";
            $data[] = array( 
                "id_categoria"=>$record['id_categoria'],
                "nombre"=>$nombre,
                "descripcion"=>$descripcion,
                "activo"=>$label_activo,
                "boton" => $menudrop
            ); 
        }
        ## Response
        $response = array(
            "draw" => intval($draw),
            "iTotalRecords" => $totalRecords,
            "iTotalDisplayRecords" => $totalRecordwithFilter,
            "aaData" => $data,
        );
        return $this->response->setJSON($response);
    }

    
    /* FUNCION PARA LISTAR TODOS TIPOS DE USUARIOS */
    public function admin_tipo_usuarios(){
        /* MODELO PRINCIPAL EN DONDE SE RECUPERAN DATOS GENERALES DEL SISTEMA */
        $modelo_principal = $this->modelo_principal;
        /* ESTA FUNCION SIRVE PARA TRAER LOS DATOS PRINCIPALES DEL SISTEMA */
        $query = $modelo_principal->datos_empresa(1);
        $datos['result'] = $query->getResultArray();
        $id_usuario = 1;
        $admin = 1;
        /* ACA MANDO A LLAMAR EL MENU */
        $menu = $modelo_principal->menu($this->id_usuario,$this->admin);
        $datos['menu'] = $menu;

        $filename = "catalogos/agregar_tipo_usuario";
        $permiso = $this->modelo_principal->comprobar_permiso($filename,$this->id_usuario,$this->admin);
        if($permiso){
            $boton_agregar =    "<div class='ibox-title'>";
            $boton_agregar.=    "<a href='agregar_tipo_usuario' class='btn btn-primary' role='button'><i class='fa fa-plus icon-large'></i> Agregar Tipo de Usuario</a>";
            $boton_agregar.=    "</div>";
        }
        $datos_admin['btn_add'] = $boton_agregar;
        echo view('template/header');
        echo view('template/main_menu',$datos);
        echo view('catalogos/admin_tipo_usuarios',$datos_admin); 
        $datos3['url'] = '<script src="'.base_url("").'/assets/js/funciones/funciones_tipo_usuario.js" ></script>';
        echo view('template/footer',$datos3);
    }

    /* FUNCION PARA LLAMAR A LA VISTA PARA PODER AGREGAR UN NUEVO TIPO DE USUARIO */
    public function agregar_tipo_usuario(){
        /* MODELO PRINCIPAL EN DONDE SE RECUPERAN DATOS GENERALES DEL SISTEMA */
        $modelo_principal = $this->modelo_principal;
        /* ESTA FUNCION SIRVE PARA TRAER LOS DATOS PRINCIPALES DEL SISTEMA */
        $query = $modelo_principal->datos_empresa(1);
        $datos['result'] = $query->getResultArray();
        $id_usuario = 1;
        $admin = 1;
        /* ACA MANDO A LLAMAR EL MENU */
        $menu = $modelo_principal->menu($this->id_usuario,$this->admin);
        $datos['menu'] = $menu;
        /*ACA IMPRIMO LAS VISTAS */
        echo view('template/header');
        echo view('template/main_menu',$datos);
        echo view('catalogos/agregar_tipo_usuario'); 
        $datos3['url'] = '<script src="'.base_url("").'/assets/js/funciones/funciones_tipo_usuario.js" ></script>';
        echo view('template/footer',$datos3);
    }

    /* FUNCION PARA INSERTAR UN NUEVO TIPO DE USUARIO */
    public function insertar_tipo_usuario(){
        $nombres = addslashes($this->request->getPost('nombre'));
        $descripcion = addslashes($this->request->getPost('descripcion'));
        $id = $this->modelo_tipo_usuario->insert([
            'nombre' => $nombres,
            'descripcion' => $descripcion,
            'activo' =>'1',
        ]);
        if($this->modelo_tipo_usuario->get($id) != null){
            $xdatos['typeinfo'] = "Success";
            $xdatos['msg'] = "Tipo de Usuario Registrado con Exito!.";
        }
        else{
            $xdatos['typeinfo'] = "Error";
            $xdatos['msg'] = "No se pudo registrar el Tipo de Usuario, intente mas tarde!.";
        }
        echo json_encode($xdatos);
    }

    /* FUNCION PARA LLAMAR A LA VISTA PARA PODER EDITAR UN TIPO DE USUARIO */
    public function editar_tipo_usuario($id_tipo_usuario){
        /* MODELO PRINCIPAL EN DONDE SE RECUPERAN DATOS GENERALES DEL SISTEMA */
        $modelo_principal = $this->modelo_principal;
        /* ESTA FUNCION SIRVE PARA TRAER LOS DATOS PRINCIPALES DEL SISTEMA */
        $query = $modelo_principal->datos_empresa(1);
        $datos['result'] = $query->getResultArray();
        /* ACA MANDO A LLAMAR EL MENU */
        $menu = $modelo_principal->menu($this->id_usuario,$this->admin);
        $datos['menu'] = $menu;
        
        $array_tipo_usuario = $this->modelo_tipo_usuario->get($id_tipo_usuario);
        $datos2['array_tipo_usuario'] = $array_tipo_usuario;
        $datos2['id_tipo_usuario'] = $id_tipo_usuario;
        /*ACA IMPRIMO LAS VISTAS */
        echo view('template/header');
        echo view('template/main_menu',$datos);
        echo view('catalogos/editar_tipo_usuario',$datos2); 
        $datos3['url'] = '<script src="'.base_url("").'/assets/js/funciones/funciones_tipo_usuario.js" ></script>';
        echo view('template/footer',$datos3);
    }

    /* FUNCION PARA MODIFICAR UN TIPO DE USUARIO */
    public function modificar_tipo_usuario(){
        $nombre = addslashes($this->request->getPost('nombre'));
        $descripcion = addslashes($this->request->getPost('descripcion'));
        $id_tipo_usuario = addslashes($this->request->getPost('id_tipo_usuario'));

        $this->modelo_tipo_usuario->update($id_tipo_usuario,[
            'nombre' => $nombre,
            'descripcion' => $descripcion,
        ]);
        if($this->modelo_tipo_usuario->get($id_tipo_usuario) != null){
            $xdatos['typeinfo'] = "Success";
            $xdatos['msg'] = "Tipo de Usuario Editado con Exito!.";
        }
        else{
            $xdatos['typeinfo'] = "Error";
            $xdatos['msg'] = "No se pudo editar el Tipo de Usuario, intente mas tarde!.";
        }
        echo json_encode($xdatos);
    }

    /* FUNCION PARA LLAMAR A LA VISTA PARA PODER VER LA INFORMACION DE UN USUARIO */
    public function ver_tipo_usuario($id_tipo_usuario){
        $array_tipo_usuario = $this->modelo_tipo_usuario->get($id_tipo_usuario);
        $datos2['array_tipo_usuario'] = $array_tipo_usuario;
        echo view('catalogos/ver_tipo_usuario',$datos2); 
    }

    /* FUNCION PARA ELIMINAR UN TIPO DE USUARIO */
    public function eliminar_tipo_usuario($id_tipo_usuario){
        $eliminar = $this->modelo_tipo_usuario->delete($id_tipo_usuario);
        if($eliminar){
            $xdatos['typeinfo'] = "Success";
            $xdatos['msg'] = "Tipo de Usuario eliminado con exito!";
        }
        else{
            $xdatos['typeinfo'] = "Error";
            $xdatos['msg'] = "No se puede eliminar el Tipo de Usuario, intentar mas tarde!";
        }
        echo json_encode($xdatos);
    }
    /* FUNCION PARA ACTIVAR UN TIPO DE USUARIO */
    public function activar_tipo_usuario($id_tipo_usuario){
        $this->modelo_tipo_usuario->update($id_tipo_usuario,[
            'activo' =>'1',
        ]);
        if($this->modelo_tipo_usuario->get($id_tipo_usuario) != null){
            $xdatos['typeinfo'] = "Success";
            $xdatos['msg'] = "Tipo de Usuario Activado con Exito!.";
        }
        else{
            $xdatos['typeinfo'] = "Error";
            $xdatos['msg'] = "No se pudo activar el Tipo de Usuario, intente mas tarde!.";
        }
        echo json_encode($xdatos);
    }
    /* FUNCION PARA DESACTIVAR UN TIPO DE USUARIO */
    public function desactivar_tipo_usuario($id_tipo_usuario){
        $this->modelo_tipo_usuario->update($id_tipo_usuario,[
            'activo' =>'0',
        ]);
        if($this->modelo_tipo_usuario->get($id_tipo_usuario) != null){
            $xdatos['typeinfo'] = "Success";
            $xdatos['msg'] = "Tipo de Usuario Desactivado con Exito!.";
        }
        else{
            $xdatos['typeinfo'] = "Error";
            $xdatos['msg'] = "No se pudo desactivar el Tipo de Usuario, intente mas tarde!.";
        }
        echo json_encode($xdatos);
    }

    /* FUNCION PARA PODER MOSTRAR LA VISTA DE LOS PERMISOS QUE TENDRA EL TIPO DE USUARIO EN ESPECIFICO */
    public function permiso_tipo_usuario($id_tipo_usuario){
        /* MODELO PRINCIPAL EN DONDE SE RECUPERAN DATOS GENERALES DEL SISTEMA */
        $modelo_principal = $this->modelo_principal;
        /* ESTA FUNCION SIRVE PARA TRAER LOS DATOS PRINCIPALES DEL SISTEMA */
        $query = $modelo_principal->datos_empresa(1);
        $datos['result'] = $query->getResultArray();
        /* ACA MANDO A LLAMAR EL MENU */
        $menu = $modelo_principal->menu($this->id_usuario,$this->admin);
        $datos['menu'] = $menu;
        
        $array_permisos = $this->modelo_principal->traer_permisos($id_tipo_usuario);
        $datos2['array_permisos'] = $array_permisos;
        $datos2['id_tipo_usuario'] = $id_tipo_usuario;
        /*ACA IMPRIMO LAS VISTAS */
        echo view('template/header');
        echo view('template/main_menu',$datos);
        echo view('catalogos/permiso_tipo_usuario',$datos2); 
        $datos3['url'] = '<script src="'.base_url("").'/assets/js/funciones/funciones_tipo_usuario.js" ></script>';
        echo view('template/footer',$datos3);
    }
    /* ESTA FUNCION SIRVE PARA ASIGNAR PERMISOS A UN TIPO DE USUARIO EN ESPECIFICO */
    function asignar_permiso_tipo_usuario($id_tipo_usuario){
        $mod = addslashes($this->request->getPost('myCheckboxes'));
        $cuantos = addslashes($this->request->getPost('qty'));
        $listadatos=explode(',',$mod);
        $this->modelo_tipo_usuario_modulo->eliminar_permiso_tipo_empleado($id_tipo_usuario);
        $error = false;
        for ($i=0;$i<$cuantos ;$i++)
        {
            $id_modulo=$listadatos[$i];
            $id = $this->modelo_tipo_usuario_modulo->insert([
                'id_modulo' => $id_modulo,
                'id_tipo_usuario' => $id_tipo_usuario
            ]);
            if($this->modelo_tipo_usuario_modulo->get($id) == null){
                $error = true;
            }
        }    
        if($error){
            $xdatos['typeinfo'] = "Error";
            $xdatos['msg'] = "No se pudieron asignar los permisos, intente mas tarde";
        }
        else{
            $xdatos['typeinfo'] = "Success";
            $xdatos['msg'] ="Permisos agregados correctamente!";
        }
        echo json_encode($xdatos);
    }
    /* FUNCION PARA TRAER LOS TIPOS DE USUARIOS AL DATATABLE */
    public function getTipoUsuarios(){
        $request = service('request');
        $postData = $request->getPost();
        $dtpostData = $postData['data'];
        $response = array();
        ## Read value
        $draw = $dtpostData['draw'];
        $start = $dtpostData['start'];
        $rowperpage = $dtpostData['length']; // Rows display per page
        $columnIndex = $dtpostData['order'][0]['column']; // Column index
        $columnName = $dtpostData['columns'][$columnIndex]['data']; // Column name
        $columnSortOrder = $dtpostData['order'][0]['dir']; // asc or desc
        $searchValue = $dtpostData['search']['value']; // Search value
        ## Total number of records without filtering
        $tipo_empleados = $this->modelo_tipo_usuario;
        $totalRecords = $tipo_empleados
                ->select('id_tipo_usuario')
                ->where('deleted_at',null)
                ->countAllResults();
        ## Total number of records with filtering
        $totalRecordwithFilter = $tipo_empleados->select("*")
                ->groupStart()
                    ->orLike('tbltipo_usuario.nombre', $searchValue)
                    ->orLike('tbltipo_usuario.descripcion', $searchValue)
                ->groupEnd()
                ->groupStart()
                ->where('tbltipo_usuario.deleted_at',null)
                ->groupEnd()
                ->countAllResults();
        ## Fetch records
        $records = $tipo_empleados->select("*")
                ->groupStart()
                    ->orLike('tbltipo_usuario.nombre', $searchValue)
                    ->orLike('tbltipo_usuario.descripcion', $searchValue)
                ->groupEnd()
                ->groupStart()
                ->where('tbltipo_usuario.deleted_at',null)
                ->groupEnd()
                ->orderBy($columnName,$columnSortOrder)
                ->findAll($rowperpage, $start);
        $data = array();
        foreach($records as $record ){
            $id_tipo_usuario = $record['id_tipo_usuario'];
            $nombre = $record['nombre'];
            $descripcion = $record['descripcion'];
            $activo = $record['activo'];
            $label_activo = "";
            $menudrop = "";
            $menudrop.="
            <div class='btn-group'>
            <button class='btn btn-primary dropdown-toggle' data-toggle='dropdown'>
            <i class=\"fa	fa-gears (alias)\"></i> Accion
            <span class='caret'></span>
            </button>
            <ul class='dropdown-menu'>";
            if ($record["activo"]==1) {
                $filename = "catalogos/permiso_tipo_usuario";
                $permiso = $this->modelo_principal->comprobar_permiso($filename,$this->id_usuario,$this->admin);
                if($permiso)
                {
                    $menudrop.="<li><a href=\"permiso_tipo_usuario/".$id_tipo_usuario."\"><i class='fa fa-lock (alias)'></i> Permiso</a></li>";
                }
                $filename = "catalogos/editar_tipo_usuario";
                $permiso = $this->modelo_principal->comprobar_permiso($filename,$this->id_usuario,$this->admin);
                if($permiso)
                {
                    $menudrop.="<li><a href=\"editar_tipo_usuario/".$id_tipo_usuario."\"><i class='fa fa-edit (alias)'></i> Editar</a></li>";
                }
                $filename = "catalogos/borrar_tipo_usuario";
                $permiso = $this->modelo_principal->comprobar_permiso($filename,$this->id_usuario,$this->admin);
                if($permiso)
                {
                    $menudrop.="<li><a id_tipo_usuario='".$id_tipo_usuario."' class='elim'><i class='fa fa-trash (alias)'></i> Eliminar</a></li>";
                }
                $filename = "catalogos/ver_tipo_usuario";
                $permiso = $this->modelo_principal->comprobar_permiso($filename,$this->id_usuario,$this->admin);
                if($permiso)
                {
                    $menudrop.="<li><a data-toggle='modal' href='ver_tipo_usuario/".$id_tipo_usuario."' data-target='#viewModal' data-refresh='true'><i class=\"fa fa-search\"></i> Ver Detalle</a></li>";
                }
            }
            $filename = "catalogos/estado_tipo_usuario";
            $permiso = $this->modelo_principal->comprobar_permiso($filename,$this->id_usuario,$this->admin);
            if($permiso)
            {
                if ($record["activo"]==1) {
                    $menudrop.="<li><a id_tipo_usuario='".$id_tipo_usuario."' class='desactivar'><i class='fa fa-eye-slash'></i> Desactivar</a></li>";
                    $label_activo = "<span class=\"label label-info\">Activo</span>";
                }else {
                    $menudrop.="<li><a id_tipo_usuario='".$id_tipo_usuario."' class='activar'><i class='fa fa-eye'></i> Activar</a></li>";
                    $label_activo = "<span class=\"label label-danger\">Inactivo</span>";
                }
            }
            $menudrop.="</ul>
            </div>";
            $data[] = array( 
                "id_tipo_usuario"=>$record['id_tipo_usuario'],
                "nombre"=>$nombre,
                "descripcion"=>$descripcion,
                "activo"=>$label_activo,
                "boton" => $menudrop
            ); 
        }
        ## Response
        $response = array(
            "draw" => intval($draw),
            "iTotalRecords" => $totalRecords,
            "iTotalDisplayRecords" => $totalRecordwithFilter,
            "aaData" => $data,
        );
        return $this->response->setJSON($response);
    }





}
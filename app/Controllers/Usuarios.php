<?php namespace App\Controllers;

use App\Controllers\BaseController;
use App\Models\ModeloModulo;
use App\Models\ModeloPrincipal;
use App\Models\ModeloTipoUsuarioModulo;
use App\Models\ModeloTipoUsuarios;
use App\Models\ModeloUsuarios;
use App\Models\ModeloUsuarioModulo;
header('Access-Control-Allow-Origin: *');

class Usuarios extends BaseController{
    protected $modelName = 'App\Models\ModeloUsuarios';
    protected $format = 'json';
    public function __construct()
    {
        /*ACA MANDO A LLAMAR EL OBJETO DEL MODELO PRINCIPAL */
        $this->modelo_principal = new ModeloPrincipal();
        $this->modelo_usuario = new ModeloUsuarios();
        $this->modelo_usuario_modulo = new ModeloUsuarioModulo();
        $this->modelo_tipo_usuario_modulo = new ModeloTipoUsuarioModulo();
        $this->modelo_modulo = new ModeloModulo();
        $this->modelo_tipo_usuario = new ModeloTipoUsuarios();
        /* ACA INICIALIZO LA INSTANCIA PARA USAR LAS SESIONES */
        $this->session = session(); 
        /* ACA LLAMO LAS VARIABLES DE SESION */
        $this->id_usuario = $this->session->get('id_usuario');
        $this->admin = $this->session->get('admin');
        $this->id_sucursal_session = $this->session->get('id_sucursal');
        helper('utilidades'); 
        helper('url');
    }


    /* FUNCION PARA LISTAR TODOS LOS USUARIOS */
    public function index(){
        /* MODELO PRINCIPAL EN DONDE SE RECUPERAN DATOS GENERALES DEL SISTEMA */
        $modelo_principal = $this->modelo_principal;
        /* ACA MANDO A LLAMAR EL MENU */
        $menu = $modelo_principal->menu($this->id_usuario,$this->admin);
        $datos['menu'] = $menu;

        $filename = "usuarios/agregar_usuario";
        $permiso = $this->modelo_principal->comprobar_permiso($filename,$this->id_usuario,$this->admin);
        if($permiso){
            $boton_agregar =    "<div class='ibox-title'>";
            $boton_agregar.=    "<a href='$filename' class='btn btn-primary' role='button'><i class='fa fa-plus icon-large'></i> Agregar Usuario</a>";
            $boton_agregar.=    "</div>";
        }
        $datos_admin['btn_add'] = $boton_agregar;
        echo view('template/header');
        echo view('template/main_menu',$datos);
        echo view('usuarios/admin_usuarios',$datos_admin); 
        $datos3['url'] = '<script src="'.base_url("").'/assets/js/funciones/funciones_usuario.js" ></script>';
        echo view('template/footer',$datos3);
    }

    /* FUNCION PARA LLAMAR A LA VISTA PARA PODER AGREGAR UN NUEVO USUARIO*/
    public function agregar_usuario(){
        /* MODELO PRINCIPAL EN DONDE SE RECUPERAN DATOS GENERALES DEL SISTEMA */
        $modelo_principal = $this->modelo_principal;
        /* ACA MANDO A TRAER TODOS LOS DATOS DE OTRAS TABLAS QUE OCUPARE PARA LLENAR LOS SELECT AL MOMENTO DE AGREGAR UN USUARIO */
        $array_tipo_usuario = $this->modelo_tipo_usuario->get();
        $datos2['array_tipo_usuario'] = $array_tipo_usuario;
        /* ACA MANDO A LLAMAR EL MENU */
        $menu = $modelo_principal->menu($this->id_usuario,$this->admin);
        $datos['menu'] = $menu;
        /*ACA IMPRIMO LAS VISTAS */
        echo view('template/header');
        echo view('template/main_menu',$datos);
        echo view('usuarios/agregar_usuario',$datos2); 
        $datos3['url'] = '<script src="'.base_url("").'/assets/js/funciones/funciones_usuario.js" ></script>';
        echo view('template/footer',$datos3);
    }
    
    /* FUNCION PARA INSERTAR UN NUEVO USUARIO */
    public function insertar_usuario(){
        $nombre = addslashes($this->request->getPost('nombre'));
        $username = addslashes($this->request->getPost('username'));
        $password = addslashes($this->request->getPost('password'));
        $id_tipo_usuario = addslashes($this->request->getPost('id_tipo_usuario'));
        $administrador = addslashes($this->request->getPost('administrador'));
        $correo = addslashes($this->request->getPost('correo'));
        $id = $this->modelo_usuario->insert([
            'usuario' => $username,
            'nombre' => $nombre,
            'correo' => $correo,
            'password' => md5($password),
            'password_no_encrypt' => $password,
            'admin' => $administrador,
            'id_tipo_usuario' => $id_tipo_usuario,
            'activo' =>'1',
            'id_sucursal' => $this->id_sucursal_session
        ]);
        if($this->modelo_usuario->get($id) != null){  
            $error = false;
            if($administrador){
                $array_permisos = $this->modelo_modulo->get();
                if($array_permisos != null){
                    foreach ($array_permisos as $key => $value) {
                        $id_modulo_permiso = $value['id_modulo'];
                        $id_usuario_modulo = $this->modelo_usuario_modulo->insert([
                            'id_usuario' => $id,
                            'id_modulo' => $id_modulo_permiso
                        ]);
                        if(!$id_usuario_modulo){
                            $error = true;
                        }
                    }
                }
            }   
            else{
                $array_tipo_usuario = $this->modelo_tipo_usuario->get($id_tipo_usuario);
                $id_tipo_usuario = $array_tipo_usuario[0]["id_tipo_usuario"];
                $array_permisos = $this->modelo_tipo_usuario_modulo->traer_permisos_tipo_empleado($id_tipo_usuario);
                if($array_permisos != null){
                    foreach ($array_permisos as $key => $value) {
                        $id_modulo_permiso = $value['id_modulo'];
                        $id_usuario_modulo = $this->modelo_usuario_modulo->insert([
                            'id_usuario' => $id,
                            'id_modulo' => $id_modulo_permiso
                        ]);
                        if(!$id_usuario_modulo){
                            $error = true;
                        }
                    }
                }
               
            }      
            if(!$error){
                $xdatos['typeinfo'] = "Success";
                $xdatos['msg'] = "Usuario Registrado con Exito!.";
            }
            else{
                $xdatos['typeinfo'] = "Error";
                $xdatos['msg'] = "No se pudo registrar el Usuario, intente mas tarde!.";
            }  
        }
        else{
            $xdatos['typeinfo'] = "Error";
            $xdatos['msg'] = "No se pudo registrar el Usuario, intente mas tarde!.";
        }
        echo json_encode($xdatos);
    }
    
    /* FUNCION PARA LLAMAR A LA VISTA PARA PODER EDITAR UN USUARIO */
    public function editar_usuario($id_usuario){
        /* MODELO PRINCIPAL EN DONDE SE RECUPERAN DATOS GENERALES DEL SISTEMA */
        $modelo_principal = $this->modelo_principal;
        /* ESTA FUNCION SIRVE PARA TRAER LOS DATOS PRINCIPALES DEL SISTEMA */
        $query = $modelo_principal->datos_empresa(1);
        $datos['result'] = $query->getResultArray();
        /* ACA MANDO A LLAMAR EL MENU */
        $menu = $modelo_principal->menu($this->id_usuario,$this->admin);
        $datos['menu'] = $menu;
        
        /* ACA MANDO A TRAER TODOS LOS DATOS DE OTRAS TABLAS QUE OCUPARE PARA LLENAR LOS SELECT AL MOMENTO DE AGREGAR UN USUARIO */
        $array_tipo_usuario = $this->modelo_tipo_usuario->get();
        $datos2['array_tipo_usuario'] = $array_tipo_usuario;
        $array_usuario = $this->modelo_usuario->get($id_usuario);
        $datos2['array_usuario'] = $array_usuario;
        $datos2['id_usuario'] = $id_usuario;
        /*ACA IMPRIMO LAS VISTAS */
        echo view('template/header');
        echo view('template/main_menu',$datos);
        echo view('usuarios/editar_usuario',$datos2); 
        $datos3['url'] = '<script src="'.base_url("").'/assets/js/funciones/funciones_usuario.js" ></script>';
        echo view('template/footer',$datos3);
    }
    
    /* FUNCION PARA MODIFICAR UN USUARIO */
    public function modificar_usuario(){
        $nombre = addslashes($this->request->getPost('nombre'));
        $username = addslashes($this->request->getPost('username'));
        $password = addslashes($this->request->getPost('password'));
        $correo = addslashes($this->request->getPost('correo'));
        $id_tipo_usuario = addslashes($this->request->getPost('id_tipo_usuario'));
        $administrador = addslashes($this->request->getPost('administrador'));
        $id_usuario = addslashes($this->request->getPost('id_usuario'));
        $datos = $this->modelo_usuario->get($id_usuario);
        $admin_antes = $datos[0]['admin'];
        $this->modelo_usuario->update($id_usuario,[
            'usuario' => $username,
            'nombre' => $nombre,
            'correo' => $correo,
            'password' => md5($password),
            'password_no_encrypt' => $password,
            'admin' => $administrador,
            'activo' =>'1',
            'id_sucursal' => $this->id_sucursal_session
        ]);
        if($this->modelo_usuario->get($id_usuario) != null){
            if($admin_antes != $administrador){
                $this->modelo_usuario_modulo->eliminar_permisos_usuario($id_usuario);
                $error = false;
                if($administrador){
                    $array_permisos = $this->modelo_modulo->get();
                    if($array_permisos != null){
                        foreach ($array_permisos as $key => $value) {
                            $id_modulo_permiso = $value['id_modulo'];
                            $id_usuario_modulo = $this->modelo_usuario_modulo->insert([
                                'id_usuario' => $id_usuario,
                                'id_modulo' => $id_modulo_permiso
                            ]);
                            if(!$id_usuario_modulo){
                                $error = true;
                            }
                        }
                    }
                }
                else{
                    $array_tipo_usuario = $this->modelo_tipo_usuario->get($id_tipo_usuario);
                    $id_tipo_usuario = $array_tipo_usuario[0]["id_tipo_usuario"];
                    $array_permisos = $this->modelo_tipo_usuario_modulo->traer_permisos_tipo_empleado($id_tipo_usuario);
                    if($array_permisos != null){
                        foreach ($array_permisos as $key => $value) {
                            $id_modulo_permiso = $value['id_modulo'];
                            $id_usuario_modulo = $this->modelo_usuario_modulo->insert([
                                'id_usuario' => $id_usuario,
                                'id_modulo' => $id_modulo_permiso
                            ]);
                            if(!$id_usuario_modulo){
                                $error = true;
                            }
                        }
                    }
                }
                if(!$error){
                    $xdatos['typeinfo'] = "Success";
                    $xdatos['msg'] = "Usuario Registrado con Exito!.";
                }
                else{
                    $xdatos['typeinfo'] = "Error";
                    $xdatos['msg'] = "No se pudo registrar el Usuario, intente mas tarde!.";
                }  
            }
            else{
                $xdatos['typeinfo'] = "Success";
                $xdatos['msg'] = "Tipo de Empleado Editado con Exito!.";
            }
        }
        else{
            $xdatos['typeinfo'] = "Error";
            $xdatos['msg'] = "No se pudo editar el Tipo de Empleado, intente mas tarde!.";
        }
        echo json_encode($xdatos);
    }

    /* FUNCION PARA LLAMAR A LA VISTA PARA PODER VER UN USUARIO */
    public function ver_usuario($id_usuario){
        /* ACA MANDO A TRAER TODOS LOS DATOS DE OTRAS TABLAS QUE OCUPARE PARA LLENAR LOS SELECT AL MOMENTO DE AGREGAR UN USUARIO */
        $array_tipo_usuario = $this->modelo_tipo_usuario->get();
        $datos2['array_tipo_usuario'] = $array_tipo_usuario;
        $array_usuario = $this->modelo_usuario->get($id_usuario);
        $datos2['array_usuario'] = $array_usuario;
        echo view('usuarios/ver_usuario',$datos2); 
    }

    /* FUNCION PARA ELIMINAR UN USUARIO */
    public function eliminar_usuario($id_usuario){
        $eliminar = $this->modelo_usuario->delete($id_usuario);
        if($eliminar){
            $xdatos['typeinfo'] = "Success";
            $xdatos['msg'] = "Usuario eliminado con exito!";
        }
        else{
            $xdatos['typeinfo'] = "Error";
            $xdatos['msg'] = "No se puede eliminar el Usuario, intentar mas tarde!";
        }
        echo json_encode($xdatos);
    }
    /* FUNCION PARA ACTIVAR UN USUARIO*/
    public function activar_usuario($id_usuario){
        $this->modelo_usuario->update($id_usuario,[
            'activo' =>'1',
        ]);
        if($this->modelo_usuario->get($id_usuario) != null){
            $xdatos['typeinfo'] = "Success";
            $xdatos['msg'] = "Usuario Activado con Exito!.";
        }
        else{
            $xdatos['typeinfo'] = "Error";
            $xdatos['msg'] = "No se pudo activar el Usuario, intente mas tarde!.";
        }
        echo json_encode($xdatos);
    }
    /* FUNCION PARA DESACTIVAR UN USUARIO */
    public function desactivar_usuario($id_usuario){
        $this->modelo_usuario->update($id_usuario,[
            'activo' =>'0',
        ]);
        if($this->modelo_usuario->get($id_usuario) != null){
            $xdatos['typeinfo'] = "Success";
            $xdatos['msg'] = "Usuario Desactivado con Exito!.";
        }
        else{
            $xdatos['typeinfo'] = "Error";
            $xdatos['msg'] = "No se pudo desactivar el Usuario, intente mas tarde!.";
        }
        echo json_encode($xdatos);
    }

    /* FUNCION PARA PODER MOSTRAR LA VISTA DE LOS PERMISOS QUE TENDRA EL USUARIO EN ESPECIFICO */
    public function permiso_usuario($id_usuario){
        /* MODELO PRINCIPAL EN DONDE SE RECUPERAN DATOS GENERALES DEL SISTEMA */
        $modelo_principal = $this->modelo_principal;
        /* ESTA FUNCION SIRVE PARA TRAER LOS DATOS PRINCIPALES DEL SISTEMA */
        $query = $modelo_principal->datos_empresa(1);
        $datos['result'] = $query->getResultArray();
        /* ACA MANDO A LLAMAR EL MENU */
        $menu = $modelo_principal->menu($this->id_usuario,$this->admin);
        $datos['menu'] = $menu;
        
        $array_permisos = $this->modelo_principal->traer_permisos_usuario($id_usuario);
        $datos2['array_permisos'] = $array_permisos;
        $datos2['id_usuario'] = $id_usuario;
        /*ACA IMPRIMO LAS VISTAS */
        echo view('template/header');
        echo view('template/main_menu',$datos);
        echo view('usuarios/permiso_usuario',$datos2); 
        $datos3['url'] = '<script src="'.base_url("").'/assets/js/funciones/funciones_usuario.js" ></script>';
        echo view('template/footer',$datos3);
    }
    /* ESTA FUNCION SIRVE PARA ASIGNAR PERMISOS A UN TIPO DE EMPLEADO EN ESPECIFICO */
    function asignar_permiso_usuario($id_usuario){
        $mod = addslashes($this->request->getPost('myCheckboxes'));
        $cuantos = addslashes($this->request->getPost('qty'));
        $listadatos=explode(',',$mod);
        $this->modelo_usuario_modulo->eliminar_permisos_usuario($id_usuario);
        $error = false;
        for ($i=0;$i<$cuantos ;$i++)
        {
            $id_modulo=$listadatos[$i];
            $id = $this->modelo_usuario_modulo->insert([
                'id_modulo' => $id_modulo,
                'id_usuario' => $id_usuario
            ]);
            if($this->modelo_usuario_modulo->get($id) == null){
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
    /* FUNCION PARA TRAER LOS USUARIOS AL DATATABLE */
    public function getUsuarios(){
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
        $usuarios = $this->modelo_usuario;
        $totalRecords = $usuarios
                ->select('id_usuario')
                ->where('deleted_at',null)
                ->countAllResults();
        ## Total number of records with filtering
        $totalRecordwithFilter = $usuarios->select("tblusuario.id_usuario,tblusuario.correo, tblusuario.usuario, tblusuario.nombre, tblusuario.admin, tblusuario.activo, tbltipo_usuario.nombre as tipo_usuario")      
                ->join('tbltipo_usuario','tbltipo_usuario.id_tipo_usuario = tblusuario.id_tipo_usuario')
                ->groupStart()
                    ->orLike('tblusuario.usuario', $searchValue)
                    ->orLike('tblusuario.nombre', $searchValue)
                    ->orLike('tblusuario.correo', $searchValue)
                    ->orLike('tbltipo_usuario.nombre', $searchValue)
                ->groupEnd()
                ->groupStart()
                ->where('tblusuario.deleted_at',null)
                ->groupEnd()
                ->countAllResults();
        ## Fetch records
        $records = $usuarios->select("tblusuario.id_usuario, tblusuario.usuario, tblusuario.nombre,tblusuario.correo, tblusuario.admin, tblusuario.activo, tbltipo_usuario.nombre as tipo_usuario")      
                ->join('tbltipo_usuario','tbltipo_usuario.id_tipo_usuario = tblusuario.id_tipo_usuario')
                ->groupStart()
                    ->orLike('tblusuario.usuario', $searchValue)
                    ->orLike('tblusuario.correo', $searchValue)
                    ->orLike('tblusuario.nombre', $searchValue)
                    ->orLike('tbltipo_usuario.nombre', $searchValue)
                ->groupEnd()
                ->groupStart()
                ->where('tblusuario.deleted_at',null)
                ->groupEnd()
                ->orderBy($columnName,$columnSortOrder)
                ->findAll($rowperpage, $start);
        $data = array();
        foreach($records as $record ){
            $id_usuario = $record['id_usuario'];
            $usuario = $record['usuario'];
            $correo = $record['correo'];
            $nombre = $record['nombre'];
            $administrador = $record['admin'];
            $activo = $record['activo'];
            $tipo_usuario = $record['tipo_usuario'];
            $label_admin = "";
            $label_activo = "";
            $menudrop = "";
            $menudrop.="
            <div class='btn-group'>
            <button class='btn btn-primary dropdown-toggle' data-toggle='dropdown'>
            <i class=\"fa	fa-gears (alias)\"></i> Accion
            <span class='caret'></span>
            </button>
            <ul class='dropdown-menu'>";
            if ($activo) {
                $filename = "usuarios/permiso_usuario";
                $permiso = $this->modelo_principal->comprobar_permiso($filename,$this->id_usuario,$this->admin);
                if($permiso)
                {
                    $menudrop.="<li><a href=\"$filename/".$id_usuario."\"><i class='fa fa-lock (alias)'></i> Permiso</a></li>";
                }
                $filename = "usuarios/editar_usuario";
                $permiso = $this->modelo_principal->comprobar_permiso($filename,$this->id_usuario,$this->admin);
                if($permiso)
                {
                    $menudrop.="<li><a href=\"$filename/".$id_usuario."\"><i class='fa fa-edit (alias)'></i> Editar</a></li>";
                }
                $filename = "usuarios/borrar_usuario";
                $permiso = $this->modelo_principal->comprobar_permiso($filename,$this->id_usuario,$this->admin);
                if($permiso)
                {
                    $menudrop.="<li><a id_usuario='".$id_usuario."' class='elim'><i class='fa fa-trash (alias)'></i> Eliminar</a></li>";
                }
                $filename = "usuarios/ver_usuario";
                $permiso = $this->modelo_principal->comprobar_permiso($filename,$this->id_usuario,$this->admin);
                if($permiso)
                {
                    $menudrop.="<li><a data-toggle='modal' href='$filename/".$id_usuario."' data-target='#viewModal' data-refresh='true'><i class=\"fa fa-search\"></i> Ver Detalle</a></li>";
                }
            }
            $filename = "usuarios/estado_usuario";
            $permiso = $this->modelo_principal->comprobar_permiso($filename,$this->id_usuario,$this->admin);
            if($permiso)
            {
                if ($activo) {
                    $menudrop.="<li><a id_usuario='".$id_usuario."' class='desactivar'><i class='fa fa-eye-slash'></i> Desactivar</a></li>";
                    $label_activo = "<span class=\"label label-info\">Activo</span>";
                }else {
                    $menudrop.="<li><a id_usuario='".$id_usuario."' class='activar'><i class='fa fa-eye'></i> Activar</a></li>";
                    $label_activo = "<span class=\"label label-danger\">Inactivo</span>";
                }
            }
            if($administrador){
                $label_admin = "<span class=\"label label-info\">Si</span>";
            }
            else{
                $label_admin = "<span class=\"label label-danger\">No</span>";
            }

            $menudrop.="</ul>
            </div>";
            $data[] = array( 
                "id_usuario"=>$id_usuario,
                "usuario"=>$usuario,
                "nombre"=>$nombre,
                "correo"=>$correo,
                "label_admin"=>$label_admin,
                "tipo_usuario"=>$tipo_usuario,
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
<?php namespace App\Controllers;

use App\Controllers\BaseController;
use App\Models\ModeloCategorias;
use App\Models\ModeloEstablecimientos;
use App\Models\ModeloPrincipal;
use App\Models\ModeloUsuarios;
header('Access-Control-Allow-Origin: *');

class Establecimientos extends BaseController{
    protected $modelName = 'App\Models\ModeloUsuarios';
    protected $format = 'json';
    public function __construct()
    {
        /*ACA MANDO A LLAMAR EL OBJETO DEL MODELO PRINCIPAL */
        $this->modelo_principal = new ModeloPrincipal();
        $this->modelo_usuario = new ModeloUsuarios();
        $this->modelo_establecimiento = new ModeloEstablecimientos();
        $this->modelo_categoria = new ModeloCategorias();
        /* ACA INICIALIZO LA INSTANCIA PARA USAR LAS SESIONES */
        $this->session = session(); 
        /* ACA LLAMO LAS VARIABLES DE SESION */
        $this->id_usuario = $this->session->get('id_usuario');
        $this->admin = $this->session->get('admin');
        $this->id_sucursal_session = $this->session->get('id_sucursal');
        helper('utilidades'); 
        helper('url');
    }


    /* FUNCION PARA LISTAR TODOS LOS ESTABLECIMIENTOS */
    public function index(){
        /* MODELO PRINCIPAL EN DONDE SE RECUPERAN DATOS GENERALES DEL SISTEMA */
        $modelo_principal = $this->modelo_principal;
        /* ACA MANDO A LLAMAR EL MENU */
        $menu = $modelo_principal->menu($this->id_usuario,$this->admin);
        $datos['menu'] = $menu;

        $filename = "establecimientos/agregar_establecimiento";
        $permiso = $this->modelo_principal->comprobar_permiso($filename,$this->id_usuario,$this->admin);
        if($permiso){
            $boton_agregar =    "<div class='ibox-title'>";
            $boton_agregar.=    "<a href='$filename' class='btn btn-primary' role='button'><i class='fa fa-plus icon-large'></i> Agregar Establecimiento</a>";
            $boton_agregar.=    "</div>";
        }
        $datos_admin['btn_add'] = $boton_agregar;
        echo view('template/header');
        echo view('template/main_menu',$datos);
        echo view('establecimientos/admin_establecimientos',$datos_admin); 
        $datos3['url'] = '<script src="'.base_url("").'/assets/js/funciones/funciones_establecimientos.js" ></script>';
        echo view('template/footer',$datos3);
    }

    /* FUNCION PARA LLAMAR A LA VISTA PARA PODER AGREGAR UN NUEVO ESTABLECIMIENTO*/
    public function agregar_establecimiento(){
        /* MODELO PRINCIPAL EN DONDE SE RECUPERAN DATOS GENERALES DEL SISTEMA */
        $modelo_principal = $this->modelo_principal;
        /* ACA MANDO A TRAER TODOS LOS DATOS DE OTRAS TABLAS QUE OCUPARE PARA LLENAR LOS SELECT AL MOMENTO DE AGREGAR UN ESTABLECIMIENTO */
        $array_usuarios = $this->modelo_usuario->get();
        $datos2['array_usuarios'] = $array_usuarios;
        $array_categorias = $this->modelo_categoria->get();
        $datos2['array_categorias'] = $array_categorias;
        /* ACA MANDO A LLAMAR EL MENU */
        $menu = $modelo_principal->menu($this->id_usuario,$this->admin);
        $datos['menu'] = $menu;
        /*ACA IMPRIMO LAS VISTAS */
        echo view('template/header');
        echo view('template/main_menu',$datos);
        echo view('establecimientos/agregar_establecimiento',$datos2); 
        $datos3['url'] = '<script src="'.base_url("").'/assets/js/funciones/funciones_establecimientos.js" ></script>';
        echo view('template/footer',$datos3);
    }
    
    /* FUNCION PARA INSERTAR UN NUEVO ESTABLECIMIENTO */
    public function insertar_establecimiento(){
        $nombre = addslashes($this->request->getPost('nombre'));
        $url = addslashes($this->request->getPost('url'));
        $id_usuario = addslashes($this->request->getPost('id_usuario'));
        $id_categoria = addslashes($this->request->getPost('id_categoria'));
        $id = $this->modelo_establecimiento->insert([
            'url' => $url,
            'nombre' => $nombre,
            'imagen_logo' => '',
            'imagen_banner' => '',
            'id_usuario' => $id_usuario,
            'id_categoria' => $id_categoria,
            'activo' =>'1',
        ]);
        if($this->modelo_establecimiento->get($id) != null){  
            $xdatos['typeinfo'] = "Success";
            $xdatos['msg'] = "Establecimiento Registrado con Exito!."; 
            $xdatos['id_establecimiento']=$id;
            $this->session->set("id_establecimiento",$id);
        }
        else{
            $xdatos['typeinfo'] = "Error";
            $xdatos['msg'] = "No se pudo registrar el Establecimiento, intente mas tarde!.";
        }
        echo json_encode($xdatos);
    }
    
    /* FUNCION PARA LLAMAR A LA VISTA PARA PODER EDITAR UN ESTABLECIMIENTO */
    public function editar_establecimiento($id_establecimiento){
        /* MODELO PRINCIPAL EN DONDE SE RECUPERAN DATOS GENERALES DEL SISTEMA */
        $modelo_principal = $this->modelo_principal;
        /* ESTA FUNCION SIRVE PARA TRAER LOS DATOS PRINCIPALES DEL SISTEMA */
        $query = $modelo_principal->datos_empresa(1);
        $datos['result'] = $query->getResultArray();
        /* ACA MANDO A LLAMAR EL MENU */
        $menu = $modelo_principal->menu($this->id_usuario,$this->admin);
        $datos['menu'] = $menu;
        
        /* ACA MANDO A TRAER TODOS LOS DATOS DE OTRAS TABLAS QUE OCUPARE PARA LLENAR LOS SELECT AL MOMENTO DE AGREGAR UN ESTABLECIMIENTO */
        $array_usuarios = $this->modelo_usuario->get();
        $datos2['array_usuarios'] = $array_usuarios;
        $array_categorias = $this->modelo_categoria->get();
        $datos2['array_categorias'] = $array_categorias;
        $array_establecimiento = $this->modelo_establecimiento->get($id_establecimiento);
        $datos2['array_establecimiento'] = $array_establecimiento;
        $datos2['id_establecimiento'] = $id_establecimiento;
        /*ACA IMPRIMO LAS VISTAS */
        echo view('template/header');
        echo view('template/main_menu',$datos);
        echo view('establecimientos/editar_establecimiento',$datos2); 
        $datos3['url'] = '<script src="'.base_url("").'/assets/js/funciones/funciones_establecimientos.js" ></script>';
        echo view('template/footer',$datos3);
    }
    
    /* FUNCION PARA MODIFICAR UN ESTABLECIMIENTO */
    public function modificar_establecimiento(){
        $nombre = addslashes($this->request->getPost('nombre'));
        $url = addslashes($this->request->getPost('url'));
        $id_usuario = addslashes($this->request->getPost('id_usuario'));
        $id_categoria = addslashes($this->request->getPost('id_categoria'));
        $id_establecimiento = addslashes($this->request->getPost('id_establecimiento'));
        $this->modelo_establecimiento->update($id_usuario,[
            'url' => $url,
            'nombre' => $nombre,
            'id_categoria' => $id_categoria,
        ]);
        if($this->modelo_establecimiento->get($id_establecimiento) != null){
            $xdatos['typeinfo'] = "Success";
            $xdatos['msg'] = "Establecimiento Editado con Exito!.";
            $xdatos['id_establecimiento']=$id_establecimiento;
            $this->session->set("id_establecimiento",$id_establecimiento);
        }
        else{
            $xdatos['typeinfo'] = "Error";
            $xdatos['msg'] = "No se pudo editar el Establecimiento, intente mas tarde!.";
        }
        echo json_encode($xdatos);
    }

    /* FUNCION PARA LLAMAR A LA VISTA PARA PODER VER UN ESTABLECIMIENTO */
    public function ver_establecimiento($id_establecimiento){
        /* ACA MANDO A TRAER TODOS LOS DATOS DE OTRAS TABLAS QUE OCUPARE PARA LLENAR LOS SELECT AL MOMENTO DE AGREGAR UN ESTABLECIMIENTO */
        $array_usuarios = $this->modelo_usuario->get();
        $datos2['array_usuarios'] = $array_usuarios;
        $array_categorias = $this->modelo_categoria->get();
        $datos2['array_categorias'] = $array_categorias;
        $array_establecimiento = $this->modelo_establecimiento->get($id_establecimiento);
        $datos2['array_establecimiento'] = $array_establecimiento;
        echo view('establecimientos/ver_establecimiento',$datos2); 
    }

    /* FUNCION PARA ELIMINAR UN ESTABLECIMIENTO */
    public function eliminar_establecimiento($id_establecimiento){
        $eliminar = $this->modelo_establecimiento->delete($id_establecimiento);
        if($eliminar){
            $xdatos['typeinfo'] = "Success";
            $xdatos['msg'] = "Establecimiento eliminado con exito!";
        }
        else{
            $xdatos['typeinfo'] = "Error";
            $xdatos['msg'] = "No se puede eliminar el Establecimiento, intentar mas tarde!";
        }
        echo json_encode($xdatos);
    }
    /* FUNCION PARA ACTIVAR UN ESTABLECIMIENTO*/
    public function activar_establecimiento($id_establecimiento){
        $this->modelo_establecimiento->update($id_establecimiento,[
            'activo' =>'1',
        ]);
        if($this->modelo_establecimiento->get($id_establecimiento) != null){
            $xdatos['typeinfo'] = "Success";
            $xdatos['msg'] = "Establecimiento Activado con Exito!.";
        }
        else{
            $xdatos['typeinfo'] = "Error";
            $xdatos['msg'] = "No se pudo activar el Establecimiento, intente mas tarde!.";
        }
        echo json_encode($xdatos);
    }
    /* FUNCION PARA DESACTIVAR UN ESTABLECIMIENTO */
    public function desactivar_establecimiento($id_establecimiento){
        $this->modelo_establecimiento->update($id_establecimiento,[
            'activo' =>'0',
        ]);
        if($this->modelo_establecimiento->get($id_establecimiento) != null){
            $xdatos['typeinfo'] = "Success";
            $xdatos['msg'] = "Establecimiento Desactivado con Exito!.";
        }
        else{
            $xdatos['typeinfo'] = "Error";
            $xdatos['msg'] = "No se pudo desactivar el Establecimiento, intente mas tarde!.";
        }
        echo json_encode($xdatos);
    }

    /* FUNCION PARA TRAER LOS ESTABLECIMIENTOS AL DATATABLE */
    public function getEstablecimientos(){
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
        $establecimientos = $this->modelo_establecimiento;
        $totalRecords = $establecimientos
                ->select('id_establecimiento')
                ->where('deleted_at',null)
                ->countAllResults();
        ## Total number of records with filtering
        $totalRecordwithFilter = $establecimientos->select("tblestablecimiento.id_establecimiento, tblestablecimiento.nombre, tblestablecimiento.url, tblusuario.nombre as nombre_usuario, tblcategoria.nombre as nombre_categoria, tblestablecimiento.activo ")      
                ->join('tblusuario','tblusuario.id_usuario = tblestablecimiento.id_usuario')
                ->join('tblcategoria','tblcategoria.id_categoria = tblestablecimiento.id_categoria')
                ->groupStart()
                    ->orLike('tblestablecimiento.nombre', $searchValue)
                    ->orLike('tblusuario.nombre', $searchValue)
                    ->orLike('tblcategoria.nombre', $searchValue)
                ->groupEnd()
                ->groupStart()
                ->where('tblestablecimiento.deleted_at',null)
                ->groupEnd()
                ->countAllResults();
        ## Fetch records
        $records =  $establecimientos->select("tblestablecimiento.id_establecimiento, tblestablecimiento.nombre, tblestablecimiento.url, tblusuario.nombre as nombre_usuario, tblcategoria.nombre as nombre_categoria, tblestablecimiento.activo ")      
                ->join('tblusuario','tblusuario.id_usuario = tblestablecimiento.id_usuario')
                ->join('tblcategoria','tblcategoria.id_categoria = tblestablecimiento.id_categoria')
                ->groupStart()
                    ->orLike('tblestablecimiento.nombre', $searchValue)
                    ->orLike('tblusuario.nombre', $searchValue)
                    ->orLike('tblcategoria.nombre', $searchValue)
                ->groupEnd()
                ->groupStart()
                ->where('tblestablecimiento.deleted_at',null)
                ->groupEnd()
                ->orderBy($columnName,$columnSortOrder)
                ->findAll($rowperpage, $start);
        $data = array();
        foreach($records as $record ){
            $id_establecimiento = $record['id_establecimiento'];
            $nombre = $record['nombre'];
            $nombre_usuario = $record['nombre_usuario'];
            $nombre_categoria = $record['nombre_categoria'];
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
            if ($activo) {
                $filename = "establecimientos/editar_establecimiento";
                $permiso = $this->modelo_principal->comprobar_permiso($filename,$this->id_usuario,$this->admin);
                if($permiso)
                {
                    $menudrop.="<li><a href=\"$filename/".$id_establecimiento."\"><i class='fa fa-edit (alias)'></i> Editar</a></li>";
                }
                $filename = "establecimientos/borrar_establecimiento";
                $permiso = $this->modelo_principal->comprobar_permiso($filename,$this->id_usuario,$this->admin);
                if($permiso)
                {
                    $menudrop.="<li><a id_establecimiento='".$id_establecimiento."' class='elim'><i class='fa fa-trash (alias)'></i> Eliminar</a></li>";
                }
                $filename = "establecimientos/ver_establecimiento";
                $permiso = $this->modelo_principal->comprobar_permiso($filename,$this->id_usuario,$this->admin);
                if($permiso)
                {
                    $menudrop.="<li><a data-toggle='modal' href='$filename/".$id_establecimiento."' data-target='#viewModal' data-refresh='true'><i class=\"fa fa-search\"></i> Ver Detalle</a></li>";
                }
            }
            $filename = "establecimientos/estado_establecimiento";
            $permiso = $this->modelo_principal->comprobar_permiso($filename,$this->id_usuario,$this->admin);
            if($permiso)
            {
                if ($activo) {
                    $menudrop.="<li><a id_establecimiento='".$id_establecimiento."' class='desactivar'><i class='fa fa-eye-slash'></i> Desactivar</a></li>";
                    $label_activo = "<span class=\"label label-info\">Activo</span>";
                }else {
                    $menudrop.="<li><a id_establecimiento='".$id_establecimiento."' class='activar'><i class='fa fa-eye'></i> Activar</a></li>";
                    $label_activo = "<span class=\"label label-danger\">Inactivo</span>";
                }
            }

            $menudrop.="</ul>
            </div>";
            $data[] = array( 
                "id_establecimiento"=>$id_establecimiento,
                "nombre"=>$nombre,
                "nombre_usuario"=>$nombre_usuario,
                "nombre_categoria"=>$nombre_categoria,
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

    public function store_perfil()
    {
        helper(['form', 'url']);
        $db = \Config\Database::connect();
        $validated2 = $this->validate([
            'file' => [
                'uploaded[file]',
                'mime_in[file,image/jpg,image/jpeg,image/gif,image/png]',
                'max_size[file,4096]',
            ],
        ]);
        if ($validated2) {
            $avatar2 = $this->request->getFile('file2');
            $avatar2->move('./assets/img/banner');
            if(file_exists("./assets/img/banner/".$avatar2->getClientName())){
                $antiguo_nombre2 = "./assets/img/banner/".$avatar2->getClientName();
                $id_unico2 = uniqid();
                $nuevo_nombre2 = "./assets/img/banner/".$id_unico2.$avatar2->getClientName();
                $url2 = "img/banner/".$id_unico2.$avatar2->getClientName();
                rename($antiguo_nombre2, $nuevo_nombre2);
            }
            $query3 = $db->query('UPDATE tblestablecimiento SET imagen_banner = \''.$url2.'\' WHERE tblestablecimiento.id_establecimiento = \''.$this->session->get('id_establecimiento').'\'');
        }
        $validated = $this->validate([
            'file' => [
                'uploaded[file]',
                'mime_in[file,image/jpg,image/jpeg,image/gif,image/png]',
                'max_size[file,4096]',
            ],
        ]);
        if ($validated) {
            $avatar = $this->request->getFile('file');
            $avatar->move('./assets/img/perfil');
            if(file_exists("./assets/img/perfil/".$avatar->getClientName())){
                $antiguo_nombre = "./assets/img/perfil/".$avatar->getClientName();
                $id_unico = uniqid();
                $nuevo_nombre = "./assets/img/perfil/".$id_unico.$avatar->getClientName();
                $url = "img/perfil/".$id_unico.$avatar->getClientName();
                rename($antiguo_nombre, $nuevo_nombre);
            }
            $query2 = $db->query('UPDATE tblestablecimiento SET imagen_logo = \''.$url.'\' WHERE tblestablecimiento.id_establecimiento = \''.$this->session->get('id_establecimiento').'\'');
        }
       
        sleep(3);
        return redirect()->to('establecimientos/');
    }
}
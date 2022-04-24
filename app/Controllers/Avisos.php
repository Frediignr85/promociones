<?php namespace App\Controllers;

use App\Controllers\BaseController;
use App\Models\ModeloAvisos;
use App\Models\ModeloPrincipal;
use App\Models\ModeloTipoAviso;
header('Access-Control-Allow-Origin: *');

class Avisos extends BaseController{
    protected $modelName = 'App\Models\ModeloUsuarios';
    protected $format = 'json';
    public function __construct()
    {
        /*ACA MANDO A LLAMAR EL OBJETO DEL MODELO PRINCIPAL */
        $this->modelo_principal = new ModeloPrincipal();
        $this->modelo_tipo_aviso = new ModeloTipoAviso();
        $this->modelo_aviso = new ModeloAvisos();
        /* ACA INICIALIZO LA INSTANCIA PARA USAR LAS SESIONES */
        $this->session = session(); 
        /* ACA LLAMO LAS VARIABLES DE SESION */
        $this->id_usuario = $this->session->get('id_usuario');
        $this->admin = $this->session->get('admin');
        $this->id_sucursal_session = $this->session->get('id_sucursal');
        helper('utilidades'); 
        helper('url');
    }


    /* FUNCION PARA LISTAR TODOS LOS AVISOS */
    public function index(){
        /* MODELO PRINCIPAL EN DONDE SE RECUPERAN DATOS GENERALES DEL SISTEMA */
        $modelo_principal = $this->modelo_principal;
        /* ACA MANDO A LLAMAR EL MENU */
        $menu = $modelo_principal->menu($this->id_usuario,$this->admin);
        $datos['menu'] = $menu;

        $filename = "avisos/agregar_aviso";
        $permiso = $this->modelo_principal->comprobar_permiso($filename,$this->id_usuario,$this->admin);
        if($permiso){
            $boton_agregar =    "<div class='ibox-title'>";
            $boton_agregar.=    "<a href='$filename' class='btn btn-primary' role='button'><i class='fa fa-plus icon-large'></i> Agregar Aviso</a>";
            $boton_agregar.=    "</div>";
        }
        $datos_admin['btn_add'] = $boton_agregar;
        echo view('template/header');
        echo view('template/main_menu',$datos);
        echo view('avisos/admin_avisos',$datos_admin); 
        $datos3['url'] = '<script src="'.base_url("").'/assets/js/funciones/funciones_avisos.js" ></script>';
        echo view('template/footer',$datos3);
    }

    /* FUNCION PARA LLAMAR A LA VISTA PARA PODER AGREGAR UN NUEVO AVISO*/
    public function agregar_aviso(){
        /* MODELO PRINCIPAL EN DONDE SE RECUPERAN DATOS GENERALES DEL SISTEMA */
        $modelo_principal = $this->modelo_principal;
        /* ACA MANDO A TRAER TODOS LOS DATOS DE OTRAS TABLAS QUE OCUPARE PARA LLENAR LOS SELECT AL MOMENTO DE AGREGAR UN AVISO */
        $array_tipo_avisos = $this->modelo_tipo_aviso->get();
        $datos2['array_tipo_avisos'] = $array_tipo_avisos;
        /* ACA MANDO A LLAMAR EL MENU */
        $menu = $modelo_principal->menu($this->id_usuario,$this->admin);
        $datos['menu'] = $menu;
        /*ACA IMPRIMO LAS VISTAS */
        echo view('template/header');
        echo view('template/main_menu',$datos);
        echo view('avisos/agregar_aviso',$datos2); 
        $datos3['url'] = '<script src="'.base_url("").'/assets/js/funciones/funciones_avisos.js" ></script>';
        echo view('template/footer',$datos3);
    }
    
    /* FUNCION PARA INSERTAR UN NUEVO AVISO */
    public function insertar_aviso(){
        $nombre = addslashes($this->request->getPost('nombre'));
        $descripcion = addslashes($this->request->getPost('descripcion'));
        $id_tipo_aviso = addslashes($this->request->getPost('id_tipo_aviso'));
        $id = $this->modelo_aviso->insert([
            'nombre' => $nombre,
            'descripcion' => $descripcion,
            'imagen_aviso' => '',
            'id_tipo_aviso' => $id_tipo_aviso,
            'activo' =>'1',
        ]);
        if($this->modelo_aviso->get($id) != null){  
            $xdatos['typeinfo'] = "Success";
            $xdatos['msg'] = "Aviso Registrado con Exito!."; 
            $xdatos['id_aviso']=$id;
            $this->session->set("id_aviso",$id);
        }
        else{
            $xdatos['typeinfo'] = "Error";
            $xdatos['msg'] = "No se pudo registrar el Aviso, intente mas tarde!.";
        }
        echo json_encode($xdatos);
    }
    
    /* FUNCION PARA LLAMAR A LA VISTA PARA PODER EDITAR UN AVISO */
    public function editar_aviso($id_aviso){
        /* MODELO PRINCIPAL EN DONDE SE RECUPERAN DATOS GENERALES DEL SISTEMA */
        $modelo_principal = $this->modelo_principal;
        /* ACA MANDO A LLAMAR EL MENU */
        $menu = $modelo_principal->menu($this->id_usuario,$this->admin);
        $datos['menu'] = $menu;
        
        /* ACA MANDO A TRAER TODOS LOS DATOS DE OTRAS TABLAS QUE OCUPARE PARA LLENAR LOS SELECT AL MOMENTO DE AGREGAR UN AVISO */
        $array_tipo_avisos = $this->modelo_tipo_aviso->get();
        $datos2['array_tipo_avisos'] = $array_tipo_avisos;
        $array_aviso = $this->modelo_aviso->get($id_aviso);
        $datos2['array_aviso'] = $array_aviso;
        $datos2['id_aviso'] = $id_aviso;
        /*ACA IMPRIMO LAS VISTAS */
        echo view('template/header');
        echo view('template/main_menu',$datos);
        echo view('avisos/editar_aviso',$datos2); 
        $datos3['url'] = '<script src="'.base_url("").'/assets/js/funciones/funciones_avisos.js" ></script>';
        echo view('template/footer',$datos3);
    }
    
    /* FUNCION PARA MODIFICAR UN AVISO */
    public function modificar_aviso(){
        $nombre = addslashes($this->request->getPost('nombre'));
        $descripcion = addslashes($this->request->getPost('descripcion'));
        $id_tipo_aviso = addslashes($this->request->getPost('id_tipo_aviso'));
        $id_aviso = addslashes($this->request->getPost('id_aviso'));
        $this->modelo_aviso->update($id_aviso,[
            'nombre' => $nombre,
            'descripcion' => $descripcion,
            'id_tipo_aviso' => $id_tipo_aviso,
        ]);
        if($this->modelo_aviso->get($id_aviso) != null){
            $xdatos['typeinfo'] = "Success";
            $xdatos['msg'] = "Aviso Editado con Exito!.";
            $xdatos['id_aviso']=$id_aviso;
            $this->session->set("id_aviso",$id_aviso);
        }
        else{
            $xdatos['typeinfo'] = "Error";
            $xdatos['msg'] = "No se pudo editar el Aviso, intente mas tarde!.";
        }
        echo json_encode($xdatos);
    }

    /* FUNCION PARA LLAMAR A LA VISTA PARA PODER VER UN AVISO */
    public function ver_aviso($id_aviso){
        /* ACA MANDO A TRAER TODOS LOS DATOS DE OTRAS TABLAS QUE OCUPARE PARA LLENAR LOS SELECT AL MOMENTO DE AGREGAR UN AVISO */
        $array_tipo_avisos = $this->modelo_tipo_aviso->get();
        $datos2['array_tipo_avisos'] = $array_tipo_avisos;
        $array_aviso = $this->modelo_aviso->get($id_aviso);
        $datos2['array_aviso'] = $array_aviso;
        echo view('avisos/ver_aviso',$datos2); 
    }

    /* FUNCION PARA ELIMINAR UN AVISO */
    public function eliminar_aviso($id_aviso){
        $eliminar = $this->modelo_aviso->delete($id_aviso);
        if($eliminar){
            $xdatos['typeinfo'] = "Success";
            $xdatos['msg'] = "Aviso eliminado con exito!";
        }
        else{
            $xdatos['typeinfo'] = "Error";
            $xdatos['msg'] = "No se puede eliminar el Aviso, intentar mas tarde!";
        }
        echo json_encode($xdatos);
    }
    /* FUNCION PARA ACTIVAR UN AVISO*/
    public function activar_aviso($id_aviso){
        $this->modelo_aviso->update($id_aviso,[
            'activo' =>'1',
        ]);
        if($this->modelo_aviso->get($id_aviso) != null){
            $xdatos['typeinfo'] = "Success";
            $xdatos['msg'] = "Aviso Activado con Exito!.";
        }
        else{
            $xdatos['typeinfo'] = "Error";
            $xdatos['msg'] = "No se pudo activar el Aviso, intente mas tarde!.";
        }
        echo json_encode($xdatos);
    }
    /* FUNCION PARA DESACTIVAR UN AVISO */
    public function desactivar_aviso($id_aviso){
        $this->modelo_aviso->update($id_aviso,[
            'activo' =>'0',
        ]);
        if($this->modelo_aviso->get($id_aviso) != null){
            $xdatos['typeinfo'] = "Success";
            $xdatos['msg'] = "Aviso Desactivado con Exito!.";
        }
        else{
            $xdatos['typeinfo'] = "Error";
            $xdatos['msg'] = "No se pudo desactivar el Aviso, intente mas tarde!.";
        }
        echo json_encode($xdatos);
    }

    /* FUNCION PARA TRAER LOS AVISOS AL DATATABLE */
    public function getAvisos(){
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
        $avisos = $this->modelo_aviso;
        $totalRecords = $avisos
                ->select('id_aviso')
                ->where('deleted_at',null)
                ->countAllResults();
        ## Total number of records with filtering
        $totalRecordwithFilter = $avisos->select("tblaviso.id_aviso, tblaviso.nombre, tblaviso.descripcion, tblaviso.activo, tbltipo_aviso.nombre as nombre_tipo_aviso")      
                ->join('tbltipo_aviso','tbltipo_aviso.id_tipo_aviso = tblaviso.id_tipo_aviso')
                ->groupStart()
                    ->orLike('tblaviso.nombre', $searchValue)
                    ->orLike('tblaviso.descripcion', $searchValue)
                    ->orLike('tbltipo_aviso.nombre', $searchValue)
                ->groupEnd()
                ->groupStart()
                ->where('tblaviso.deleted_at',null)
                ->groupEnd()
                ->countAllResults();
        ## Fetch records
        $records = $avisos->select("tblaviso.id_aviso, tblaviso.nombre, tblaviso.descripcion, tblaviso.activo, tbltipo_aviso.nombre as nombre_tipo_aviso")      
                ->join('tbltipo_aviso','tbltipo_aviso.id_tipo_aviso = tblaviso.id_tipo_aviso')
                ->groupStart()
                    ->orLike('tblaviso.nombre', $searchValue)
                    ->orLike('tblaviso.descripcion', $searchValue)
                    ->orLike('tbltipo_aviso.nombre', $searchValue)
                ->groupEnd()
                ->groupStart()
                ->where('tblaviso.deleted_at',null)
                ->groupEnd()
                ->orderBy($columnName,$columnSortOrder)
                ->findAll($rowperpage, $start);
        $data = array();
        foreach($records as $record ){
            $id_aviso = $record['id_aviso'];
            $nombre = $record['nombre'];
            $nombre_tipo_aviso = $record['nombre_tipo_aviso'];
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
            if ($activo) {
                $filename = "avisos/editar_aviso";
                $permiso = $this->modelo_principal->comprobar_permiso($filename,$this->id_usuario,$this->admin);
                if($permiso)
                {
                    $menudrop.="<li><a href=\"$filename/".$id_aviso."\"><i class='fa fa-edit (alias)'></i> Editar</a></li>";
                }
                $filename = "avisos/borrar_aviso";
                $permiso = $this->modelo_principal->comprobar_permiso($filename,$this->id_usuario,$this->admin);
                if($permiso)
                {
                    $menudrop.="<li><a id_aviso='".$id_aviso."' class='elim'><i class='fa fa-trash (alias)'></i> Eliminar</a></li>";
                }
                $filename = "avisos/ver_aviso";
                $permiso = $this->modelo_principal->comprobar_permiso($filename,$this->id_usuario,$this->admin);
                if($permiso)
                {
                    $menudrop.="<li><a data-toggle='modal' href='$filename/".$id_aviso."' data-target='#viewModal' data-refresh='true'><i class=\"fa fa-search\"></i> Ver Detalle</a></li>";
                }
            }
            $filename = "avisos/estado_aviso";
            $permiso = $this->modelo_principal->comprobar_permiso($filename,$this->id_usuario,$this->admin);
            if($permiso)
            {
                if ($activo) {
                    $menudrop.="<li><a id_aviso='".$id_aviso."' class='desactivar'><i class='fa fa-eye-slash'></i> Desactivar</a></li>";
                    $label_activo = "<span class=\"label label-info\">Activo</span>";
                }else {
                    $menudrop.="<li><a id_aviso='".$id_aviso."' class='activar'><i class='fa fa-eye'></i> Activar</a></li>";
                    $label_activo = "<span class=\"label label-danger\">Inactivo</span>";
                }
            }

            $menudrop.="</ul>
            </div>";
            $data[] = array( 
                "id_aviso"=>$id_aviso,
                "nombre"=>$nombre,
                "nombre_tipo_aviso"=>$nombre_tipo_aviso,
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
            $avatar2 = $this->request->getFile('file');
            $avatar2->move('./assets/img/avisos');
            if(file_exists("./assets/img/avisos/".$avatar2->getClientName())){
                $antiguo_nombre2 = "./assets/img/avisos/".$avatar2->getClientName();
                $id_unico2 = uniqid();
                $nuevo_nombre2 = "./assets/img/avisos/".$id_unico2.$avatar2->getClientName();
                $url2 = "img/avisos/".$id_unico2.$avatar2->getClientName();
                rename($antiguo_nombre2, $nuevo_nombre2);
            }
            $query3 = $db->query('UPDATE tblaviso SET imagen_aviso = \''.$url2.'\' WHERE tblaviso.id_aviso = \''.$this->session->get('id_aviso').'\'');
        }
        return redirect()->to('avisos/');
    }
}
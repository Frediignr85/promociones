<?php namespace App\Controllers;

use App\Controllers\BaseController;
use App\Models\ModeloCategorias;
use App\Models\ModeloContactoSucursal;
use App\Models\ModeloDepartamento;
use App\Models\ModeloEstablecimientos;
use App\Models\ModeloMunicipio;
use App\Models\ModeloPrincipal;
use App\Models\ModeloSucursales;
use App\Models\ModeloTipoContacto;
use App\Models\ModeloUsuarios;
header('Access-Control-Allow-Origin: *');

class Sucursales extends BaseController{
    protected $modelName = 'App\Models\ModeloUsuarios';
    protected $format = 'json';
    public function __construct()
    {
        /*ACA MANDO A LLAMAR EL OBJETO DEL MODELO PRINCIPAL */
        $this->modelo_principal = new ModeloPrincipal();
        $this->modelo_usuario = new ModeloUsuarios();
        $this->modelo_establecimiento = new ModeloEstablecimientos();
        $this->modelo_departamento = new ModeloDepartamento();
        $this->modelo_municipio = new ModeloMunicipio();
        $this->modelo_sucursal = new ModeloSucursales();
        $this->modelo_tipo_contacto = new ModeloTipoContacto();
        $this->modelo_contacto_sucursal = new ModeloContactoSucursal();
        /* ACA INICIALIZO LA INSTANCIA PARA USAR LAS SESIONES */
        $this->session = session(); 
        /* ACA LLAMO LAS VARIABLES DE SESION */
        $this->id_usuario = $this->session->get('id_usuario');
        $this->admin = $this->session->get('admin');
        $this->id_sucursal_session = $this->session->get('id_sucursal');
        helper('utilidades'); 
        helper('url');
    }


    /* FUNCION PARA LISTAR TODOS LAS SUCURSALES */
    public function index(){
        /* MODELO PRINCIPAL EN DONDE SE RECUPERAN DATOS GENERALES DEL SISTEMA */
        $modelo_principal = $this->modelo_principal;
        /* ACA MANDO A LLAMAR EL MENU */
        $menu = $modelo_principal->menu($this->id_usuario,$this->admin);
        $datos['menu'] = $menu;

        $filename = "sucursales/agregar_sucursal";
        $permiso = $this->modelo_principal->comprobar_permiso($filename,$this->id_usuario,$this->admin);
        if($permiso){
            $boton_agregar =    "<div class='ibox-title'>";
            $boton_agregar.=    "<a href='$filename' class='btn btn-primary' role='button'><i class='fa fa-plus icon-large'></i> Agregar Sucursal</a>";
            $boton_agregar.=    "</div>";
        }
        $datos_admin['btn_add'] = $boton_agregar;
        echo view('template/header');
        echo view('template/main_menu',$datos);
        echo view('sucursales/admin_sucursales',$datos_admin); 
        $datos3['url'] = '<script src="'.base_url("").'/assets/js/funciones/funciones_sucursal.js" ></script>';
        echo view('template/footer',$datos3);
    }

    /* FUNCION PARA LLAMAR A LA VISTA PARA PODER AGREGAR UNA NUEVA SUCURSAL*/
    public function agregar_sucursal(){
        /* MODELO PRINCIPAL EN DONDE SE RECUPERAN DATOS GENERALES DEL SISTEMA */
        $modelo_principal = $this->modelo_principal;
        /* ACA MANDO A TRAER TODOS LOS DATOS DE OTRAS TABLAS QUE OCUPARE PARA LLENAR LOS SELECT AL MOMENTO DE AGREGAR UNA SUCURSAL */
        $array_usuarios = $this->modelo_usuario->get();
        $datos2['array_usuarios'] = $array_usuarios;
        $array_establecimientos = $this->modelo_establecimiento->get();
        $datos2['array_establecimientos'] = $array_establecimientos;
        $array_departamentos = $this->modelo_departamento->get();
        $datos2['array_departamentos'] = $array_departamentos;
        $array_tipo_contactos = $this->modelo_tipo_contacto->get();
        $datos2['array_tipo_contactos'] = $array_tipo_contactos;
        /* ACA MANDO A LLAMAR EL MENU */
        $menu = $modelo_principal->menu($this->id_usuario,$this->admin);
        $datos['menu'] = $menu;
        /*ACA IMPRIMO LAS VISTAS */
        echo view('template/header');
        echo view('template/main_menu',$datos);
        echo view('sucursales/agregar_sucursal',$datos2); 
        $datos3['url'] = '<script src="'.base_url("").'/assets/js/funciones/funciones_sucursal.js" ></script>';
        echo view('template/footer',$datos3);
    }
    
    /* FUNCION PARA INSERTAR UNA NUEVA SUCURSAL */
    public function insertar_sucursal(){
        $nombre = addslashes($this->request->getPost('nombre'));
        $url = addslashes($this->request->getPost('url'));
        $telefono = addslashes($this->request->getPost('telefono'));
        $direccion = addslashes($this->request->getPost('direccion'));
        $id_usuario = addslashes($this->request->getPost('id_usuario'));
        $id_establecimiento = addslashes($this->request->getPost('id_establecimiento'));
        $id_departamento = addslashes($this->request->getPost('id_departamento'));
        $id_municipio = addslashes($this->request->getPost('id_municipio'));
        $lista = addslashes($this->request->getPost('lista'));
        $id = $this->modelo_sucursal->insert([
            'nombre' => $nombre,
            'url' => $url,
            'telefono' => $telefono,
            'direccion' => $direccion,
            'id_usuario' => $id_usuario,
            'id_establecimiento' => $id_establecimiento,
            'id_departamento' => $id_departamento,
            'id_municipio' => $id_municipio,
            'activo' =>'1',
        ]);
        if($this->modelo_sucursal->get($id) != null){  
            $this->modelo_contacto_sucursal->eliminar_contactos_sucursal($id);
            $explora = explode("|", $lista);
			$c = count($explora);
            $error = false;
            for ($i=0; $i < $c-1 ; $i++){
				$ex = explode("~~", $explora[$i]);
				$nombre_contacto = $ex[0];
				$id_departamento_contacto = $ex[1];
				$id_municipio_contacto = $ex[2];
				$direccion_contacto = $ex[3];
				$id_tipo_contacto = $ex[4];
				$informacion_tipo_contacto = $ex[5];
				$id_contacto_sucursal = $this->modelo_contacto_sucursal->insert([
                    'nombre' => $nombre_contacto,
                    'direccion' => $direccion_contacto,
                    'info_tipo_contacto' => $informacion_tipo_contacto,
                    'id_departamento' => $id_departamento_contacto,
                    'id_municipio' => $id_municipio_contacto,
                    'id_tipo_contacto' => $id_tipo_contacto,
                    'id_sucursal' => $id
                ]);
				if($this->modelo_contacto_sucursal->get($id_contacto_sucursal) == null){
                    $error = true;
                }
			}
			if(!$error){
				$xdatos['typeinfo'] = "Success";
                $xdatos['msg'] = "Sucursal Registrada con Exito!."; 
			}	
			else{
				$xdatos['typeinfo'] = "Error";
                $xdatos['msg'] = "No se pudo registrar la Sucursal, intente mas tarde!.";
			}	
        }
        else{
            $xdatos['typeinfo'] = "Error";
            $xdatos['msg'] = "No se pudo registrar la Sucursal, intente mas tarde!.";
        }
        echo json_encode($xdatos);
    }
    
    /* FUNCION PARA LLAMAR A LA VISTA PARA PODER EDITAR UNA SUCURSAL */
    public function editar_sucursal($id_sucursal){
        /* MODELO PRINCIPAL EN DONDE SE RECUPERAN DATOS GENERALES DEL SISTEMA */
        $modelo_principal = $this->modelo_principal;
        /* ACA MANDO A LLAMAR EL MENU */
        $menu = $modelo_principal->menu($this->id_usuario,$this->admin);
        $datos['menu'] = $menu;
        
        /* ACA MANDO A TRAER TODOS LOS DATOS DE OTRAS TABLAS QUE OCUPARE PARA LLENAR LOS SELECT AL MOMENTO DE AGREGAR UNA SUCURSAL */
        $array_usuarios = $this->modelo_usuario->get();
        $datos2['array_usuarios'] = $array_usuarios;
        $array_establecimientos = $this->modelo_establecimiento->get();
        $datos2['array_establecimientos'] = $array_establecimientos;
        $array_sucursal = $this->modelo_sucursal->get($id_sucursal);
        $array_departamentos = $this->modelo_departamento->get();
        $datos2['array_departamentos'] = $array_departamentos;
        $array_municipios = $this->modelo_municipio->get_municipios_departamento($array_sucursal[0]['id_departamento']);
        $datos2['array_municipios'] = $array_municipios;
        $datos2['array_departamentos'] = $array_departamentos;
        $datos2['array_sucursal'] = $array_sucursal;
        $datos2['id_sucursal'] = $id_sucursal; 
        $array_tipo_contactos = $this->modelo_tipo_contacto->get();
        $datos2['array_tipo_contactos'] = $array_tipo_contactos;       
        $array_contactos = $this->modelo_contacto_sucursal->traer_contactos_sucursal($id_sucursal);
        $datos2['array_contactos'] = $array_contactos;
        /*ACA IMPRIMO LAS VISTAS */
        echo view('template/header');
        echo view('template/main_menu',$datos);
        echo view('sucursales/editar_sucursal',$datos2); 
        $datos3['url'] = '<script src="'.base_url("").'/assets/js/funciones/funciones_sucursal.js" ></script>';
        echo view('template/footer',$datos3);
    }
    
    /* FUNCION PARA MODIFICAR UNA SUCURSAL */
    public function modificar_sucursal(){
        $nombre = addslashes($this->request->getPost('nombre'));
        $url = addslashes($this->request->getPost('url'));
        $telefono = addslashes($this->request->getPost('telefono'));
        $direccion = addslashes($this->request->getPost('direccion'));
        $id_usuario = addslashes($this->request->getPost('id_usuario'));
        $id_departamento = addslashes($this->request->getPost('id_departamento'));
        $id_municipio = addslashes($this->request->getPost('id_municipio'));
        $id_sucursal = addslashes($this->request->getPost('id_sucursal'));
        $lista = addslashes($this->request->getPost('lista'));
        $this->modelo_sucursal->update($id_sucursal,[
            'nombre' => $nombre,
            'url' => $url,
            'telefono' => $telefono,
            'direccion' => $direccion,
            'id_usuario' => $id_usuario,
            'id_departamento' => $id_departamento,
            'id_municipio' => $id_municipio,
        ]);
        if($this->modelo_sucursal->get($id_sucursal) != null){
            $this->modelo_contacto_sucursal->eliminar_contactos_sucursal($id_sucursal);
            $explora = explode("|", $lista);
			$c = count($explora);
            $error = false;
            for ($i=0; $i < $c-1 ; $i++){
				$ex = explode("~~", $explora[$i]);
				$nombre_contacto = $ex[0];
				$id_departamento_contacto = $ex[1];
				$id_municipio_contacto = $ex[2];
				$direccion_contacto = $ex[3];
				$id_tipo_contacto = $ex[4];
				$informacion_tipo_contacto = $ex[5];
				$id_contacto_sucursal = $this->modelo_contacto_sucursal->insert([
                    'nombre' => $nombre_contacto,
                    'direccion' => $direccion_contacto,
                    'info_tipo_contacto' => $informacion_tipo_contacto,
                    'id_departamento' => $id_departamento_contacto,
                    'id_municipio' => $id_municipio_contacto,
                    'id_tipo_contacto' => $id_tipo_contacto,
                    'id_sucursal' => $id_sucursal
                ]);
				if($this->modelo_contacto_sucursal->get($id_contacto_sucursal) == null){
                    $error = true;
                }
			}
			if(!$error){
				$xdatos['typeinfo'] = "Success";
                $xdatos['msg'] = "Sucursal Editada con Exito!."; 
			}	
			else{
				$xdatos['typeinfo'] = "Error";
                $xdatos['msg'] = "No se pudo editar la Sucursal, intente mas tarde!.";
			}	
        }
        else{
            $xdatos['typeinfo'] = "Error";
            $xdatos['msg'] = "No se pudo editar la Sucursal, intente mas tarde!.";
        }
        echo json_encode($xdatos);
    }

    /* FUNCION PARA LLAMAR A LA VISTA PARA PODER VER UNA SUCURSAL */
    public function ver_sucursal($id_sucursal){
        /* ACA MANDO A TRAER TODOS LOS DATOS DE OTRAS TABLAS QUE OCUPARE PARA LLENAR LOS SELECT AL MOMENTO DE AGREGAR UNA SUCURSAL */
        $array_usuarios = $this->modelo_usuario->get();
        $datos2['array_usuarios'] = $array_usuarios;
        $array_establecimientos = $this->modelo_establecimiento->get();
        $datos2['array_establecimientos'] = $array_establecimientos;
        $array_sucursal = $this->modelo_sucursal->get($id_sucursal);
        $array_departamentos = $this->modelo_departamento->get();
        $datos2['array_departamentos'] = $array_departamentos;
        $array_municipios = $this->modelo_municipio->get_municipios_departamento($array_sucursal[0]['id_departamento']);
        $datos2['array_municipios'] = $array_municipios;
        $datos2['array_departamentos'] = $array_departamentos;
        $datos2['array_sucursal'] = $array_sucursal;
        $datos2['id_sucursal'] = $id_sucursal; 
        $array_tipo_contactos = $this->modelo_tipo_contacto->get();
        $datos2['array_tipo_contactos'] = $array_tipo_contactos;       
        $array_contactos = $this->modelo_contacto_sucursal->traer_contactos_sucursal($id_sucursal);
        $datos2['array_contactos'] = $array_contactos;
        echo view('sucursales/ver_sucursal',$datos2); 
    }

    /* FUNCION PARA ELIMINAR UNA SUCURSAL */
    public function eliminar_sucursal($id_sucursal){
        $eliminar = $this->modelo_sucursal->delete($id_sucursal);
        if($eliminar){
            $xdatos['typeinfo'] = "Success";
            $xdatos['msg'] = "Sucursal eliminada con exito!";
        }
        else{
            $xdatos['typeinfo'] = "Error";
            $xdatos['msg'] = "No se puede eliminar la Sucursal, intentar mas tarde!";
        }
        echo json_encode($xdatos);
    }
    /* FUNCION PARA ACTIVAR UNA SUCURSAL*/
    public function activar_sucursal($id_sucursal){
        $this->modelo_sucursal->update($id_sucursal,[
            'activo' =>'1',
        ]);
        if($this->modelo_sucursal->get($id_sucursal) != null){
            $xdatos['typeinfo'] = "Success";
            $xdatos['msg'] = "Sucursal Activada con Exito!.";
        }
        else{
            $xdatos['typeinfo'] = "Error";
            $xdatos['msg'] = "No se pudo activar la Sucursal, intente mas tarde!.";
        }
        echo json_encode($xdatos);
    }
    /* FUNCION PARA DESACTIVAR UNA SUCURSAL */
    public function desactivar_sucursal($modelo_sucursal){
        $this->modelo_sucursal->update($modelo_sucursal,[
            'activo' =>'0',
        ]);
        if($this->modelo_sucursal->get($modelo_sucursal) != null){
            $xdatos['typeinfo'] = "Success";
            $xdatos['msg'] = "Sucursal Desactivada con Exito!.";
        }
        else{
            $xdatos['typeinfo'] = "Error";
            $xdatos['msg'] = "No se pudo desactivar la Sucursal, intente mas tarde!.";
        }
        echo json_encode($xdatos);
    }

    /* FUNCION PARA TRAER LAS SUCURSALES AL DATATABLE */
    public function getSucursales(){
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
        $sucursales = $this->modelo_sucursal;
        $totalRecords = $sucursales
                ->select('id_establecimiento')
                ->where('deleted_at',null)
                ->countAllResults();
        ## Total number of records with filtering
        $totalRecordwithFilter = $sucursales->select("tblsucursal.id_sucursal, tblsucursal.nombre, tblsucursal.telefono, tblsucursal.direccion,
                tbldepartamento.nombre as nombre_departamento, tblmunicipio.nombre as nombre_municipio, tblsucursal.activo,
                tblestablecimiento.nombre as nombre_establecimiento, tblusuario.nombre as nombre_usuario")      
                ->join('tblestablecimiento','tblestablecimiento.id_establecimiento = tblsucursal.id_establecimiento')
                ->join('tbldepartamento','tbldepartamento.id_departamento = tblsucursal.id_departamento')
                ->join('tblmunicipio',' tblmunicipio.id_municipio = tblsucursal.id_municipio')
                ->join('tblusuario','tblusuario.id_usuario = tblsucursal.id_usuario')
                ->groupStart()
                    ->orLike('tblsucursal.nombre', $searchValue)
                    ->orLike('tblsucursal.telefono', $searchValue)
                    ->orLike('tblsucursal.direccion', $searchValue)
                    ->orLike('tbldepartamento.nombre', $searchValue)
                    ->orLike('tblmunicipio.nombre', $searchValue)
                    ->orLike('tblestablecimiento.nombre', $searchValue)
                    ->orLike('tblusuario.nombre', $searchValue)
                ->groupEnd()
                ->groupStart()
                    ->where('tblsucursal.deleted_at',null)
                ->groupEnd()
                ->countAllResults();
        ## Fetch records
        $records = $sucursales->select("tblsucursal.id_sucursal, tblsucursal.nombre, tblsucursal.telefono, tblsucursal.direccion,
                tbldepartamento.nombre as nombre_departamento, tblmunicipio.nombre as nombre_municipio, tblsucursal.activo,
                tblestablecimiento.nombre as nombre_establecimiento, tblusuario.nombre as nombre_usuario")      
                ->join('tblestablecimiento','tblestablecimiento.id_establecimiento = tblsucursal.id_establecimiento')
                ->join('tbldepartamento','tbldepartamento.id_departamento = tblsucursal.id_departamento')
                ->join('tblmunicipio',' tblmunicipio.id_municipio = tblsucursal.id_municipio')
                ->join('tblusuario','tblusuario.id_usuario = tblsucursal.id_usuario')
                ->groupStart()
                    ->orLike('tblsucursal.nombre', $searchValue)
                    ->orLike('tblsucursal.telefono', $searchValue)
                    ->orLike('tblsucursal.direccion', $searchValue)
                    ->orLike('tbldepartamento.nombre', $searchValue)
                    ->orLike('tblmunicipio.nombre', $searchValue)
                    ->orLike('tblestablecimiento.nombre', $searchValue)
                    ->orLike('tblusuario.nombre', $searchValue)
                ->groupEnd()
                ->groupStart()
                    ->where('tblsucursal.deleted_at',null)
                ->groupEnd()
                ->orderBy($columnName,$columnSortOrder)
                ->findAll($rowperpage, $start);
        $data = array();
        foreach($records as $record ){
            $id_sucursal = $record['id_sucursal'];
            $nombre = $record['nombre'];
            $telefono = $record['telefono'];
            $direccion = $record['direccion'];
            $nombre_departamento = $record['nombre_departamento'];
            $nombre_municipio = $record['nombre_municipio'];
            $nombre_establecimiento = $record['nombre_establecimiento'];
            $nombre_usuario = $record['nombre_usuario'];
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
                $filename = "sucursales/editar_sucursal";
                $permiso = $this->modelo_principal->comprobar_permiso($filename,$this->id_usuario,$this->admin);
                if($permiso)
                {
                    $menudrop.="<li><a href=\"$filename/".$id_sucursal."\"><i class='fa fa-edit (alias)'></i> Editar</a></li>";
                }
                $filename = "sucursales/borrar_sucursal";
                $permiso = $this->modelo_principal->comprobar_permiso($filename,$this->id_usuario,$this->admin);
                if($permiso)
                {
                    $menudrop.="<li><a id_sucursal='".$id_sucursal."' class='elim'><i class='fa fa-trash (alias)'></i> Eliminar</a></li>";
                }
                $filename = "sucursales/ver_sucursal";
                $permiso = $this->modelo_principal->comprobar_permiso($filename,$this->id_usuario,$this->admin);
                if($permiso)
                {
                    $menudrop.="<li><a data-toggle='modal' href='$filename/".$id_sucursal."' data-target='#viewModal' data-refresh='true'><i class=\"fa fa-search\"></i> Ver Detalle</a></li>";
                }
            }
            $filename = "sucursales/estado_sucursal";
            $permiso = $this->modelo_principal->comprobar_permiso($filename,$this->id_usuario,$this->admin);
            if($permiso)
            {
                if ($activo) {
                    $menudrop.="<li><a id_sucursal='".$id_sucursal."' class='desactivar'><i class='fa fa-eye-slash'></i> Desactivar</a></li>";
                    $label_activo = "<span class=\"label label-info\">Activo</span>";
                }else {
                    $menudrop.="<li><a id_sucursal='".$id_sucursal."' class='activar'><i class='fa fa-eye'></i> Activar</a></li>";
                    $label_activo = "<span class=\"label label-danger\">Inactivo</span>";
                }
            }

            $menudrop.="</ul>
            </div>";
            $data[] = array( 
                "id_sucursal"=>$id_sucursal,
                "nombre"=>$nombre,
                "nombre_establecimiento"=>$nombre_establecimiento,
                "telefono"=>$telefono,
                "direccion"=>$direccion,
                "nombre_departamento"=>$nombre_departamento,
                "nombre_municipio"=>$nombre_municipio,
                "nombre_usuario"=>$nombre_usuario,
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
    /* ESTA ES LA FUNCION PARA CAMBIAR EL SELECT DE MUNICIPIOS SEGUN EL DEPARTAMENTO QUE SE SELECCIONE */
    public function cambiar_departamento(){
        $id_departamento = addslashes($this->request->getPost('id_departamento'));
        $array_municipio = $this->modelo_municipio->get_municipios_departamento($id_departamento);
        $option = "";
        $option .= "<option value=''>Seleccione el Municipio</option>";
        foreach ($array_municipio as $key => $value) {
            $option .= "<option value='".$value["id_municipio"]."'>".$value["nombre"]."</option>";
        }
        echo $option;
    }
}
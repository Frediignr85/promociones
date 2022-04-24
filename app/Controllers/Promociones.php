<?php namespace App\Controllers;

use App\Controllers\BaseController;
use App\Models\ModeloEstablecimientos;
use App\Models\ModeloPrincipal;
use App\Models\ModeloPromociones;
use App\Models\ModeloSucursales;
use App\Models\ModeloTipoPromociones;

header('Access-Control-Allow-Origin: *');

class Promociones extends BaseController{
    protected $modelName = 'App\Models\ModeloUsuarios';
    protected $format = 'json';
    public function __construct()
    {
        /*ACA MANDO A LLAMAR EL OBJETO DEL MODELO PRINCIPAL */
        $this->modelo_principal = new ModeloPrincipal();
        $this->modelo_establecimiento = new ModeloEstablecimientos();
        $this->modelo_sucursal = new ModeloSucursales();
        $this->modelo_tipo_promocion = new ModeloTipoPromociones();
        $this->modelo_promocion = new ModeloPromociones();
        /* ACA INICIALIZO LA INSTANCIA PARA USAR LAS SESIONES */
        $this->session = session(); 
        /* ACA LLAMO LAS VARIABLES DE SESION */
        $this->id_usuario = $this->session->get('id_usuario');
        $this->admin = $this->session->get('admin');
        $this->id_sucursal_session = $this->session->get('id_sucursal');
        helper('utilidades'); 
        helper('url');
    }


    /* FUNCION PARA LISTAR TODOS LAS PROMOCIONES */
    public function index(){
        /* MODELO PRINCIPAL EN DONDE SE RECUPERAN DATOS GENERALES DEL SISTEMA */
        $modelo_principal = $this->modelo_principal;
        /* ACA MANDO A LLAMAR EL MENU */
        $menu = $modelo_principal->menu($this->id_usuario,$this->admin);
        $datos['menu'] = $menu;

        $filename = "promociones/agregar_promocion";
        $permiso = $this->modelo_principal->comprobar_permiso($filename,$this->id_usuario,$this->admin);
        if($permiso){
            $boton_agregar =    "<div class='ibox-title'>";
            $boton_agregar.=    "<a href='$filename' class='btn btn-primary' role='button'><i class='fa fa-plus icon-large'></i> Agregar Promocion</a>";
            $boton_agregar.=    "</div>";
        }
        $datos_admin['btn_add'] = $boton_agregar;
        echo view('template/header');
        echo view('template/main_menu',$datos);
        echo view('promociones/admin_promociones',$datos_admin); 
        $datos3['url'] = '<script src="'.base_url("").'/assets/js/funciones/funciones_promociones.js" ></script>';
        echo view('template/footer',$datos3);
    }

    /* FUNCION PARA LLAMAR A LA VISTA PARA PODER AGREGAR UNA NUEVA PROMOCION*/
    public function agregar_promocion(){
        /* MODELO PRINCIPAL EN DONDE SE RECUPERAN DATOS GENERALES DEL SISTEMA */
        $modelo_principal = $this->modelo_principal;
        /* ACA MANDO A TRAER TODOS LOS DATOS DE OTRAS TABLAS QUE OCUPARE PARA LLENAR LOS SELECT AL MOMENTO DE AGREGAR UNA PROMOCION */
        $array_establecimientos = $this->modelo_establecimiento->get();
        $datos2['array_establecimientos'] = $array_establecimientos;
        $array_tipo_promociones = $this->modelo_tipo_promocion->get();
        $datos2['array_tipo_promociones'] = $array_tipo_promociones;
        /* ACA MANDO A LLAMAR EL MENU */
        $menu = $modelo_principal->menu($this->id_usuario,$this->admin);
        $datos['menu'] = $menu;
        /*ACA IMPRIMO LAS VISTAS */
        echo view('template/header');
        echo view('template/main_menu',$datos);
        echo view('promociones/agregar_promocion',$datos2); 
        $datos3['url'] = '<script src="'.base_url("").'/assets/js/funciones/funciones_promociones.js" ></script>';
        echo view('template/footer',$datos3);
    }
    
    /* FUNCION PARA INSERTAR UNA NUEVA PROMOCION */
    public function insertar_promocion(){
        $nombre = addslashes($this->request->getPost('nombre'));
        $descripcion = addslashes($this->request->getPost('descripcion'));
        $codigo = addslashes($this->request->getPost('codigo'));
        $fecha_inicio = MD(addslashes($this->request->getPost('fecha_inicio')));
        $hora_inicio = _hora_media_encode(addslashes($this->request->getPost('hora_inicio')));
        $fecha_fin = MD(addslashes($this->request->getPost('fecha_fin')));
        $hora_fin = _hora_media_encode(addslashes($this->request->getPost('hora_fin')));
        $id_tipo_promocion = addslashes($this->request->getPost('id_tipo_promocion'));
        $id_sucursal = addslashes($this->request->getPost('id_sucursal'));
        $id_establecimiento = addslashes($this->request->getPost('id_establecimiento'));
        $id = $this->modelo_promocion->insert([
            'nombre' => $nombre,
            'descripcion' => $descripcion,
            'codigo' => $codigo,
            'fecha_inicio' => $fecha_inicio,
            'hora_inicio' => $hora_inicio,
            'fecha_fin' => $fecha_fin,
            'hora_fin' => $hora_fin,
            'id_tipo_promocion' => $id_tipo_promocion,
            'id_sucursal' => $id_sucursal,
            'id_establecimiento' => $id_establecimiento,
            'activo' =>'1',
        ]);
        if($this->modelo_promocion->get($id) != null){  
            $xdatos['typeinfo'] = "Success";
            $xdatos['msg'] = "Promocion Registrada con Exito!."; 
        }
        else{
            $xdatos['typeinfo'] = "Error";
            $xdatos['msg'] = "No se pudo registrar la Promocion, intente mas tarde!.";
        }
        echo json_encode($xdatos);
    }
    
    /* FUNCION PARA LLAMAR A LA VISTA PARA PODER EDITAR UNA PROMOCION */
    public function editar_promocion($id_promocion){
        /* MODELO PRINCIPAL EN DONDE SE RECUPERAN DATOS GENERALES DEL SISTEMA */
        $modelo_principal = $this->modelo_principal;
        /* ACA MANDO A LLAMAR EL MENU */
        $menu = $modelo_principal->menu($this->id_usuario,$this->admin);
        $datos['menu'] = $menu;
        
        /* ACA MANDO A TRAER TODOS LOS DATOS DE OTRAS TABLAS QUE OCUPARE PARA LLENAR LOS SELECT AL MOMENTO DE AGREGAR UNA PROMOCION */
        $array_establecimientos = $this->modelo_establecimiento->get();
        $datos2['array_establecimientos'] = $array_establecimientos;
        $array_tipo_promociones = $this->modelo_tipo_promocion->get();
        $datos2['array_tipo_promociones'] = $array_tipo_promociones;
        $array_promocion = $this->modelo_promocion->get($id_promocion);
        $datos2['array_promocion'] = $array_promocion;
        $datos2['id_promocion'] = $id_promocion;
        $array_sucursales = $this->modelo_sucursal->get_sucursales_establecimiento($array_promocion[0]['id_establecimiento']);
        $datos2['array_sucursales'] = $array_sucursales;
        /*ACA IMPRIMO LAS VISTAS */
        echo view('template/header');
        echo view('template/main_menu',$datos);
        echo view('promociones/editar_promocion',$datos2); 
        $datos3['url'] = '<script src="'.base_url("").'/assets/js/funciones/funciones_promociones.js" ></script>';
        echo view('template/footer',$datos3);
    }
    
    /* FUNCION PARA MODIFICAR UNA PROMOCION */
    public function modificar_promocion(){
        $nombre = addslashes($this->request->getPost('nombre'));
        $descripcion = addslashes($this->request->getPost('descripcion'));
        $codigo = addslashes($this->request->getPost('codigo'));
        $fecha_inicio = MD(addslashes($this->request->getPost('fecha_inicio')));
        $hora_inicio = _hora_media_encode(addslashes($this->request->getPost('hora_inicio')));
        $fecha_fin = MD(addslashes($this->request->getPost('fecha_fin')));
        $hora_fin = _hora_media_encode(addslashes($this->request->getPost('hora_fin')));
        $id_tipo_promocion = addslashes($this->request->getPost('id_tipo_promocion'));
        $id_promocion = addslashes($this->request->getPost('id_promocion'));
        $this->modelo_promocion->update($id_promocion,[
            'nombre' => $nombre,
            'descripcion' => $descripcion,
            'codigo' => $codigo,
            'fecha_inicio' => $fecha_inicio,
            'hora_inicio' => $hora_inicio,
            'fecha_fin' => $fecha_fin,
            'hora_fin' => $hora_fin,
            'id_tipo_promocion' => $id_tipo_promocion,
        ]);
        if($this->modelo_promocion->get($id_promocion) != null){
            $xdatos['typeinfo'] = "Success";
            $xdatos['msg'] = "Promocion Editada con Exito!.";
        }
        else{
            $xdatos['typeinfo'] = "Error";
            $xdatos['msg'] = "No se pudo editar la Promocion, intente mas tarde!.";
        }
        echo json_encode($xdatos);
    }

    /* FUNCION PARA LLAMAR A LA VISTA PARA PODER VER UNA PROMOCION */
    public function ver_promocion($id_promocion){
        /* ACA MANDO A TRAER TODOS LOS DATOS DE OTRAS TABLAS QUE OCUPARE PARA LLENAR LOS SELECT AL MOMENTO DE AGREGAR UNA PROMOCION */
        $array_establecimientos = $this->modelo_establecimiento->get();
        $datos2['array_establecimientos'] = $array_establecimientos;
        $array_tipo_promociones = $this->modelo_tipo_promocion->get();
        $datos2['array_tipo_promociones'] = $array_tipo_promociones;
        $array_promocion = $this->modelo_promocion->get($id_promocion);
        $datos2['array_promocion'] = $array_promocion;
        $datos2['id_promocion'] = $id_promocion;
        $array_sucursales = $this->modelo_sucursal->get_sucursales_establecimiento($array_promocion[0]['id_establecimiento']);
        $datos2['array_sucursales'] = $array_sucursales;
        echo view('promociones/ver_promocion',$datos2); 
    }

    /* FUNCION PARA ELIMINAR UNA PROMOCION */
    public function eliminar_promocion($id_promocion){
        $eliminar = $this->modelo_promocion->delete($id_promocion);
        if($eliminar){
            $xdatos['typeinfo'] = "Success";
            $xdatos['msg'] = "Promocion eliminada con exito!";
        }
        else{
            $xdatos['typeinfo'] = "Error";
            $xdatos['msg'] = "No se puede eliminar la Promocion, intentar mas tarde!";
        }
        echo json_encode($xdatos);
    }
    /* FUNCION PARA ACTIVAR UNA PROMOCION*/
    public function activar_promocion($id_promocion){
        $this->modelo_promocion->update($id_promocion,[
            'activo' =>'1',
        ]);
        if($this->modelo_promocion->get($id_promocion) != null){
            $xdatos['typeinfo'] = "Success";
            $xdatos['msg'] = "Promocion Activada con Exito!.";
        }
        else{
            $xdatos['typeinfo'] = "Error";
            $xdatos['msg'] = "No se pudo activar la Promocion, intente mas tarde!.";
        }
        echo json_encode($xdatos);
    }
    /* FUNCION PARA DESACTIVAR UNA PROMOCION */
    public function desactivar_promocion($id_promocion){
        $this->modelo_promocion->update($id_promocion,[
            'activo' =>'0',
        ]);
        if($this->modelo_promocion->get($id_promocion) != null){
            $xdatos['typeinfo'] = "Success";
            $xdatos['msg'] = "Promocion Desactivada con Exito!.";
        }
        else{
            $xdatos['typeinfo'] = "Error";
            $xdatos['msg'] = "No se pudo desactivar la Promocion, intente mas tarde!.";
        }
        echo json_encode($xdatos);
    }

    /* FUNCION PARA TRAER LAS PROMOCIONES AL DATATABLE */
    public function getPromociones(){
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
        $promociones = $this->modelo_promocion;
        $totalRecords = $promociones
                ->select('id_establecimiento')
                ->where('deleted_at',null)
                ->countAllResults();
        ## Total number of records with filtering
        $totalRecordwithFilter = $promociones->select("tblpromocion.id_promocion, tblpromocion.nombre, tblpromocion.codigo,
                tblpromocion.fecha_inicio, tblpromocion.hora_inicio, tblpromocion.fecha_fin, tblpromocion.hora_fin,
                tblestablecimiento.nombre as nombre_establecimiento, tblsucursal.nombre as nombre_sucursal,
                tbltipo_promocion.nombre as nombre_tipo_promocion, tblpromocion.activo ")      
                ->join('tblestablecimiento','tblestablecimiento.id_establecimiento = tblpromocion.id_establecimiento')
                ->join('tblsucursal','tblsucursal.id_sucursal = tblpromocion.id_sucursal')
                ->join('tbltipo_promocion','tbltipo_promocion.id_tipo_promocion = tblpromocion.id_tipo_promocion')
                ->groupStart()
                    ->orLike('tblpromocion.nombre', $searchValue)
                    ->orLike('tblpromocion.codigo', $searchValue)
                    ->orLike('tblestablecimiento.nombre', $searchValue)
                    ->orLike('tblsucursal.nombre', $searchValue)
                    ->orLike('tbltipo_promocion.nombre', $searchValue)
                ->groupEnd()
                ->groupStart()
                    ->where('tblpromocion.deleted_at',null)
                ->groupEnd()
                ->countAllResults();
        ## Fetch records
        $records =  $promociones->select("tblpromocion.id_promocion, tblpromocion.nombre, tblpromocion.codigo,
                tblpromocion.fecha_inicio, tblpromocion.hora_inicio, tblpromocion.fecha_fin, tblpromocion.hora_fin,
                tblestablecimiento.nombre as nombre_establecimiento, tblsucursal.nombre as nombre_sucursal,
                tbltipo_promocion.nombre as nombre_tipo_promocion, tblpromocion.activo ")      
                ->join('tblestablecimiento','tblestablecimiento.id_establecimiento = tblpromocion.id_establecimiento')
                ->join('tblsucursal','tblsucursal.id_sucursal = tblpromocion.id_sucursal')
                ->join('tbltipo_promocion','tbltipo_promocion.id_tipo_promocion = tblpromocion.id_tipo_promocion')
                ->groupStart()
                    ->orLike('tblpromocion.nombre', $searchValue)
                    ->orLike('tblpromocion.codigo', $searchValue)
                    ->orLike('tblestablecimiento.nombre', $searchValue)
                    ->orLike('tblsucursal.nombre', $searchValue)
                    ->orLike('tbltipo_promocion.nombre', $searchValue)
                ->groupEnd()
                ->groupStart()
                    ->where('tblpromocion.deleted_at',null)
                ->groupEnd()
                ->orderBy($columnName,$columnSortOrder)
                ->findAll($rowperpage, $start);
        $data = array();
        foreach($records as $record ){
            $id_promocion = $record['id_promocion'];
            $nombre = $record['nombre'];
            $codigo = $record['codigo'];
            $fecha_inicio = ED($record['fecha_inicio']);
            $hora_inicio = _hora_media_decode($record['hora_inicio']);
            $fecha_inicio_general = $fecha_inicio." ".$hora_inicio; 
            $fecha_fin = ED($record['fecha_fin']);
            $hora_fin =  _hora_media_decode($record['hora_fin']);
            $fecha_fin_general = $fecha_fin." ".$hora_fin;
            $nombre_establecimiento = $record['nombre_establecimiento'];
            $nombre_sucursal = $record['nombre_sucursal'];
            $nombre_tipo_promocion = $record['nombre_tipo_promocion'];
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
                $filename = "promociones/editar_promocion";
                $permiso = $this->modelo_principal->comprobar_permiso($filename,$this->id_usuario,$this->admin);
                if($permiso)
                {
                    $menudrop.="<li><a href=\"$filename/".$id_promocion."\"><i class='fa fa-edit (alias)'></i> Editar</a></li>";
                }
                $filename = "promociones/borrar_sucursal";
                $permiso = $this->modelo_principal->comprobar_permiso($filename,$this->id_usuario,$this->admin);
                if($permiso)
                {
                    $menudrop.="<li><a id_promocion='".$id_promocion."' class='elim'><i class='fa fa-trash (alias)'></i> Eliminar</a></li>";
                }
                $filename = "promociones/ver_promocion";
                $permiso = $this->modelo_principal->comprobar_permiso($filename,$this->id_usuario,$this->admin);
                if($permiso)
                {
                    $menudrop.="<li><a data-toggle='modal' href='$filename/".$id_promocion."' data-target='#viewModal' data-refresh='true'><i class=\"fa fa-search\"></i> Ver Detalle</a></li>";
                }
            }
            $filename = "promociones/estado_sucursal";
            $permiso = $this->modelo_principal->comprobar_permiso($filename,$this->id_usuario,$this->admin);
            if($permiso)
            {
                if ($activo) {
                    $menudrop.="<li><a id_promocion='".$id_promocion."' class='desactivar'><i class='fa fa-eye-slash'></i> Desactivar</a></li>";
                    $label_activo = "<span class=\"label label-info\">Activo</span>";
                }else {
                    $menudrop.="<li><a id_promocion='".$id_promocion."' class='activar'><i class='fa fa-eye'></i> Activar</a></li>";
                    $label_activo = "<span class=\"label label-danger\">Inactivo</span>";
                }
            }

            $menudrop.="</ul>
            </div>";
            $data[] = array( 
                "id_promocion"=>$id_promocion,
                "nombre"=>$nombre,
                "codigo"=>$codigo,
                "fecha_inicio"=>$fecha_inicio_general,
                "fecha_fin"=>$fecha_fin_general,
                "nombre_establecimiento"=>$nombre_establecimiento,
                "nombre_sucursal"=>$nombre_sucursal,
                "nombre_tipo_promocion"=>$nombre_tipo_promocion,
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
    /* ESTA ES LA FUNCION PARA CAMBIAR EL SELECT DE SUCURSALES SEGUN EL ESTABLECIMIENTOS QUE SE SELECCIONE */
    public function cambiar_establecimiento(){
        $id_establecimiento = addslashes($this->request->getPost('id_establecimiento'));
        $array_sucursal = $this->modelo_sucursal->get_sucursales_establecimiento($id_establecimiento);
        $option = "";
        $option .= "<option value=''>Selecciona la Sucursal</option>";
        foreach ($array_sucursal as $key => $value) {
            $option .= "<option value='".$value["id_sucursal"]."'>".$value["nombre"]."</option>";
        }
        echo $option;
    }
}
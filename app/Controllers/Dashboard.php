<?php
namespace App\Controllers;

use App\Models\ModeloPrincipal;

class Dashboard extends BaseController{

    public function __construct()
    {
        /*ACA MANDO A LLAMAR EL OBJETO DEL MODELO PRINCIPAL */
        $this->modelo_principal = new ModeloPrincipal();
        /* ACA INICIALIZO LA INSTANCIA PARA USAR LAS SESIONES */
        $this->session = session(); 
    }

    public function index(){
        /* MODELO PRINCIPAL EN DONDE SE RECUPERAN DATOS GENERALES DEL SISTEMA */
        $modelo_principal = $this->modelo_principal;
        /* ACA LLAMO LAS VARIABLES DE SESION */
        $id_usuario = $this->session->get('id_usuario');
        $admin = $this->session->get('admin');
        /* ACA MANDO A LLAMAR EL MENU */
        $menu = $modelo_principal->menu($id_usuario,$admin);
        $datos['menu'] = $menu;
        echo view('template/header');
        echo view('template/main_menu',$datos);
        echo view('dashboard');
        $datos3['url'] = '<script src="'.base_url("").'/assets/js/funciones/funciones_dashboard.js" ></script>';
        echo view('template/footer',$datos3);
    }
    function grafica1(){
        $db = \Config\Database::connect();
        $data = array();
        $sql = "SELECT tblsucursal.id_sucursal, tblsucursal.nombre, COUNT(tblpromocion.id_promocion) as total
        from tblsucursal
        inner join tblpromocion on tblpromocion.id_sucursal = tblsucursal.id_sucursal 
        where tblsucursal.deleted_at is null
        group by tblsucursal.id_sucursal, tblsucursal.nombre 
        order by total desc
        limit 6";
        $datax = $db->query($sql);
        $array_data = $datax->getResultArray();
        $data = array();
        foreach ($array_data as $key => $value) {
            $nombre = $value['nombre'];
            $total = $value['total'];
            $data[] = array(
                "total" => $total,  
                "producto" => $nombre, 
            );
        }
        echo json_encode($data);
    }
    function grafica2(){
        $db = \Config\Database::connect();
        $data = array();
        $sql = "SELECT tblestablecimiento.id_establecimiento, tblestablecimiento.nombre, COUNT(tblpromocion.id_promocion) as total
        from tblestablecimiento
        inner join tblpromocion on tblpromocion.id_establecimiento = tblestablecimiento.id_establecimiento 
        where tblestablecimiento.deleted_at is null
        group by tblestablecimiento.id_establecimiento, tblestablecimiento.nombre 
        order by total desc
        limit 6";
        $datax = $db->query($sql);
        $array_data = $datax->getResultArray();
        $data = array();
        foreach ($array_data as $key => $value) {
            $nombre = $value['nombre'];
            $total = $value['total'];
            $data[] = array(
                "total" => $total,  
                "producto" => $nombre, 
            );
        }
        echo json_encode($data);
    }


}




?>
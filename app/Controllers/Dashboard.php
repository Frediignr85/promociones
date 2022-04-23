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



}




?>
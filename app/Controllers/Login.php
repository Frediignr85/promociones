<?php

namespace App\Controllers;
use App\Models\ModeloLogin;
use App\Models\ModeloDashboard;
use App\Models\ModeloPrincipal;

header('Access-Control-Allow-Origin: *');
class Login extends BaseController
{
    function __construct()
    {
        $this->ElModelo = new ModeloLogin();
         /*ACA MANDO A LLAMAR EL OBJETO DEL MODELO PRINCIPAL */
        $this->modelo_principal = new ModeloPrincipal();
        /* ACA INICIALIZO LA INSTANCIA PARA USAR LAS SESIONES */
        $this->session = session(); 
    }

    public function index()
    {
        $session = session();     
        if($session->get('id_usuario') == ""){           
            echo view('login');
        }
        else{
           /* MODELO PRINCIPAL EN DONDE SE RECUPERAN DATOS GENERALES DEL SISTEMA */
            $modelo_principal = $this->modelo_principal;
            /* ESTA FUNCION SIRVE PARA TRAER LOS DATOS PRINCIPALES DEL SISTEMA */
            $query = $modelo_principal->datos_empresa(1);
            $datos['result'] = $query->getResultArray();
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
    public function login(){
        $username = $this->request->getPost('username');
        $clave = $this->request->getPost('password');
        $modelo = $this->ElModelo;
        $query = $modelo->verificar_username($username);
        if(count($query) > 0){
            $query2 = $modelo->verificar_credenciales($username,$clave);
            if(count($query2->getResultArray()) > 0){
                $datos = $query2->getResultArray();
                foreach ($datos as $key => $value) {
                    $id_usuario = $value['id_usuario'];
                    $nombre = $value['nombre'];
                    $usuario = $value['usuario'];
                    $activo = $value['activo'];
                    $admin = $value['admin'];
                    $id_sucursal = 0;
                    if(isset($value['id_sucursal'])){
                        $id_sucursal =$value['id_sucursal'];
                    }
                }
                $user_session = [
                    'id_usuario' => $id_usuario,
                    'nombre' => $nombre,
                    'usuario' => $usuario,
                    'admin' => $admin,
                    'id_sucursal' => $id_sucursal,
                ];
                $session = session();
                $session->set($user_session);
                
                $xdatos['typeinfo'] ="Success";
                $xdatos['msg'] = "Bienvenido $nombre!";
            }
            else{
                $xdatos['typeinfo'] ="Error";
                $xdatos['msg'] = "Las credenciales no son las correctas o el usuario esta inactivo!";
            }
        }   
        else{
            $xdatos['typeinfo'] ="Error";
            $xdatos['msg'] = "No existe ese usuario!";
        }
        echo json_encode($xdatos);
    }
    
}

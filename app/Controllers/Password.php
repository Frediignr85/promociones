<?php

namespace App\Controllers;
use App\Models\ModeloPassword;
header('Access-Control-Allow-Origin: *');
class Password extends BaseController
{
    function __construct()
    {
        $this->ElModelo = new ModeloPassword();
        helper('url');
    }
    public function index()
    {
        echo view('password');
    }
    function cambiar_password(){
        $modelo = $this->ElModelo;
        $session = session(); 
        $id_usuario = $session->get('id_usuario');
        $oldpass = $this->request->getPost('oldpass');
        $newpass = $this->request->getPost('newpass');
        $query = $modelo->verificar_password($oldpass,$id_usuario);
        if($query){
            $query2 = $modelo->cambiar_password($newpass,$id_usuario);
            if($query2){
                $xdatos['typeinfo'] = "Success";
                $xdatos['msg'] = "Contraseña cambiada con exito.";
            }
            else{
                $xdatos['typeinfo'] = "Error";
                $xdatos['msg'] = "No se pudo cambiar La contraseña intente mas tarde.";
            }
        }   
        else{
            $xdatos['typeinfo'] = "Error";
            $xdatos['msg'] = "La contraseña vieja no coincide.";
        }
        echo json_encode($xdatos);
    }

}

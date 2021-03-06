<?php
namespace App\Models;
use CodeIgniter\Database\ConnectionInterface;
use CodeIgniter\Model;

class ModeloRecuperar extends Model
{
    function verificar_username($username){
        $data = $this->db->query("SELECT * FROM tblusuario WHERE correo = '$username' AND activo = 1 AND deleted_at is NULL");
        return $data;
    }
    function verificar_credenciales($username,$password){
        $data = $this->db->query("SELECT * FROM tblusuario WHERE password = '".MD5($password)."' AND usuario = '$username' AND id_tipo_usuario = '4' AND activo = 1");
        return $data;
    }
    function verificar_correo($email){
        $data = $this->db->query("SELECT * FROM tblcliente WHERE correo = '$email' AND deleted_at is NULL");
        return $data;
    }
    function verificar_id($id){
        $db = \Config\Database::connect();
        $data = $this->db->query("SELECT * FROM tblusuario WHERE activo = 1 ORDER BY id_usuario DESC ");
        $data = $data->getResultArray();
        $id_usuario_x = 0;
        foreach ($data as $key => $value) {
            if($id == md5($value['id_usuario'])){
                $id_usuario_x = $value['id_usuario'];
            }
        }
        return $id_usuario_x;
    }
    function cambiar_password($password,$id_usuario){
        $db = \Config\Database::connect();
        $password1 = md5($password);
        $builder = $db->table('tblusuario');
        $data = [
            'password' => $password1,
            'password_no_encrypt'  => $password,
        ];
        $builder->where('id_usuario', $id_usuario);
        $builder->update($data);
        return $builder;
    }
}

?>
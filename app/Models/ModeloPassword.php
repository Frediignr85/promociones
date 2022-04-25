<?php
namespace App\Models;
use CodeIgniter\Database\ConnectionInterface;
use CodeIgniter\Model;

class ModeloPassword extends Model
{

    function verificar_password($oldpass, $id_usuario){
        $oldpass = md5($oldpass);
        $data = $this->db->query("SELECT * FROM tblusuario WHERE password = '$oldpass' AND id_usuario = '$id_usuario'");
        $data = $data->getResultArray();
        $contador = 0;
        foreach ($data as $key => $value) {
            $contador++;
        }
        if($contador == 0){
            return 0;
        }
        else{
            return 1;
        }
    }
    function cambiar_password($newpass, $id_usuario){
        $db = \Config\Database::connect();
        $builder = $db->table('tblusuario');
        $data = [
            'password' => md5($newpass),
            'password_no_encrypt' => $newpass
        ];
        $builder->where('id_usuario', $id_usuario);
        $builder->update($data);
        return $builder;
    }
}

?>
<?php
    namespace App\Models;

    use CodeIgniter\Model;


    class ModeloUsuarios extends Model
    {
        protected $table = 'tblusuario';
        protected $primaryKey = 'id_usuario';
        protected $allowedFields = ['usuario',
                                    'correo',
                                    'password',
                                    'password_no_encrypt',
                                    'admin',
                                    'id_tipo_usuario',
                                    'nombre',
                                    'activo'];
        protected $useSoftDeletes = true;
        protected $useTimestamps = false;
        protected $createdField  = 'created_at';
        protected $updatedField  = 'updated_at';
        protected $deletedField  = 'deleted_at';

        public function get($id_usuario = null){
            if($id_usuario == null){
                return $this->findAll();
            }
            return $this->asArray()
                ->where('tblusuario.id_usuario',$id_usuario)->findAll();
        }
    }


?>
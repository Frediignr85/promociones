<?php
    namespace App\Models;

    use CodeIgniter\Model;


    class ModeloTipoUsuarios extends Model
    {
        protected $table = 'tbltipo_usuario';
        protected $primaryKey = 'id_tipo_usuario';
        protected $allowedFields = ['nombre','descripcion','activo'];
        protected $useSoftDeletes = true;
        protected $useTimestamps = false;
        protected $createdField  = 'created_at';
        protected $updatedField  = 'updated_at';
        protected $deletedField  = 'deleted_at';

        public function get($id_tipo_usuario = null){
            if($id_tipo_usuario == null){
                return $this->findAll();
            }
            return $this->asArray()
                ->where('tbltipo_usuario.id_tipo_usuario',$id_tipo_usuario)->findAll();
        }
    }


?>
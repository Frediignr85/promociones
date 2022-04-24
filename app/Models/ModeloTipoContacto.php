<?php
    namespace App\Models;

    use CodeIgniter\Model;


    class ModeloTipoContacto extends Model
    {
        protected $table = 'tbltipo_contacto';
        protected $primaryKey = 'id_tipo_contacto';
        protected $allowedFields = ['nombre','descripcion','activo'];
        protected $useSoftDeletes = true;
        protected $useTimestamps = false;
        protected $createdField  = 'created_at';
        protected $updatedField  = 'updated_at';
        protected $deletedField  = 'deleted_at';

        public function get($id_tipo_contacto = null){
            if($id_tipo_contacto == null){
                return $this->findAll();
            }
            return $this->asArray()
                ->where('tbltipo_contacto.id_tipo_contacto',$id_tipo_contacto)->findAll();
        }
    }


?>
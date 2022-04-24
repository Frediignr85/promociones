<?php
    namespace App\Models;

    use CodeIgniter\Model;


    class ModeloTipoPromociones extends Model
    {
        protected $table = 'tbltipo_promocion';
        protected $primaryKey = 'id_tipo_promocion';
        protected $allowedFields = ['nombre','descripcion','color','activo'];
        protected $useSoftDeletes = true;
        protected $useTimestamps = false;
        protected $createdField  = 'created_at';
        protected $updatedField  = 'updated_at';
        protected $deletedField  = 'deleted_at';

        public function get($id_tipo_promocion = null){
            if($id_tipo_promocion == null){
                return $this->findAll();
            }
            return $this->asArray()
                ->where('tbltipo_promocion.id_tipo_promocion',$id_tipo_promocion)->findAll();
        }
    }


?>
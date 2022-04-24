<?php
    namespace App\Models;

    use CodeIgniter\Model;


    class ModeloTipoAviso extends Model
    {
        protected $table = 'tbltipo_aviso';
        protected $primaryKey = 'id_tipo_aviso';
        protected $allowedFields = ['nombre','descripcion','color','activo'];
        protected $useSoftDeletes = true;
        protected $useTimestamps = false;
        protected $createdField  = 'created_at';
        protected $updatedField  = 'updated_at';
        protected $deletedField  = 'deleted_at';

        public function get($id_tipo_aviso = null){
            if($id_tipo_aviso == null){
                return $this->findAll();
            }
            return $this->asArray()
                ->where('tbltipo_aviso.id_tipo_aviso',$id_tipo_aviso)->findAll();
        }
    }


?>
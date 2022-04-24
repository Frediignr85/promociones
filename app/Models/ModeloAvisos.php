<?php
    namespace App\Models;

    use CodeIgniter\Model;


    class ModeloAvisos extends Model
    {
        protected $table = 'tblaviso';
        protected $primaryKey = 'id_aviso';
        protected $allowedFields = ['nombre','descripcion','imagen_aviso','activo','id_tipo_aviso'];
        protected $useSoftDeletes = true;
        protected $useTimestamps = false;
        protected $createdField  = 'created_at';
        protected $updatedField  = 'updated_at';
        protected $deletedField  = 'deleted_at';

        public function get($id_aviso = null){
            if($id_aviso == null){
                return $this->findAll();
            }
            return $this->asArray()
                ->where('tblaviso.id_aviso',$id_aviso)->findAll();
        }
    }


?>
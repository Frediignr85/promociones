<?php
    namespace App\Models;

    use CodeIgniter\Model;


    class ModeloEstablecimientos extends Model
    {
        protected $table = 'tblestablecimiento';
        protected $primaryKey = 'id_establecimiento';
        protected $allowedFields = ['nombre','url','imagen_logo','imagen_banner','id_usuario','activo','id_categoria'];
        protected $useSoftDeletes = true;
        protected $useTimestamps = false;
        protected $createdField  = 'created_at';
        protected $updatedField  = 'updated_at';
        protected $deletedField  = 'deleted_at';

        public function get($id_establecimiento = null){
            if($id_establecimiento == null){
                return $this->findAll();
            }
            return $this->asArray()
                ->where('tblestablecimiento.id_establecimiento',$id_establecimiento)->findAll();
        }
    }


?>
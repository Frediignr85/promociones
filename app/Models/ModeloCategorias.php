<?php
    namespace App\Models;

    use CodeIgniter\Model;


    class ModeloCategorias extends Model
    {
        protected $table = 'tblcategoria';
        protected $primaryKey = 'id_categoria';
        protected $allowedFields = ['nombre','descripcion','activo','imagen_logo','imagen_banner'];
        protected $useSoftDeletes = true;
        protected $useTimestamps = false;
        protected $createdField  = 'created_at';
        protected $updatedField  = 'updated_at';
        protected $deletedField  = 'deleted_at';

        public function get($id_categoria = null){
            if($id_categoria == null){
                return $this->findAll();
            }
            return $this->asArray()
                ->where('tblcategoria.id_categoria',$id_categoria)->findAll();
        }
    }


?>
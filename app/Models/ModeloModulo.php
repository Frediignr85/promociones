<?php
    namespace App\Models;

    use CodeIgniter\Model;


    class ModeloModulo extends Model
    {
        protected $table = 'tblmodulo';
        protected $primaryKey = 'id_modulo';
        protected $allowedFields = ['nombre','descripcion','filename','visible','prioridad','id_menu'];
        protected $useSoftDeletes = true;
        protected $useTimestamps = false;
        protected $createdField  = 'created_at';
        protected $updatedField  = 'updated_at';
        protected $deletedField  = 'deleted_at';

        public function get($id_modulo = null){
            if($id_modulo == null){
                return $this->findAll();
            }
            return $this->asArray()
                ->where('tblmodulo.id_modulo',$id_modulo)->findAll();
        }
    }


?>
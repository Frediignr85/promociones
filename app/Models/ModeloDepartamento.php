<?php
    namespace App\Models;

    use CodeIgniter\Model;


    class ModeloDepartamento extends Model
    {
        protected $table = 'tbldepartamento';
        protected $primaryKey = 'id_departamento';
        protected $allowedFields = ['nombre'];
        protected $useSoftDeletes = true;
        protected $useTimestamps = false;
        protected $createdField  = 'created_at';
        protected $updatedField  = 'updated_at';
        protected $deletedField  = 'deleted_at';

        public function get($id_departamento = null){
            if($id_departamento == null){
                return $this->findAll();
            }
            return $this->asArray()
                ->where('tbldepartamento.id_departamento',$id_departamento)->findAll();
        }
    }


?>
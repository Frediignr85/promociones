<?php
    namespace App\Models;

    use CodeIgniter\Model;


    class ModeloMunicipio extends Model
    {
        protected $table = 'tblmunicipio';
        protected $primaryKey = 'id_municipio';
        protected $allowedFields = ['nombre','id_departamento'];
        protected $useSoftDeletes = true;
        protected $useTimestamps = false;
        protected $createdField  = 'created_at';
        protected $updatedField  = 'updated_at';
        protected $deletedField  = 'deleted_at';

        public function get($id_municipio = null){
            if($id_municipio == null){
                return $this->findAll();
            }
            return $this->asArray()
                ->where('tblmunicipio.id_municipio',$id_municipio)->findAll();
        }
        public function get_municipios_departamento($id_departamento){
            return $this->asArray()
                    ->where("tblmunicipio.id_departamento",$id_departamento)
                    ->findAll();
        }
    }


?>
<?php
    namespace App\Models;

    use CodeIgniter\Model;


    class ModeloSucursales extends Model
    {
        protected $table = 'tblsucursal';
        protected $primaryKey = 'id_sucursal';
        protected $allowedFields = ['nombre',
                                    'url',
                                    'telefono',
                                    'direccion',
                                    'id_departamento',
                                    'id_municipio',
                                    'id_usuario',
                                    'activo',
                                    'id_establecimiento'];
        protected $useSoftDeletes = true;
        protected $useTimestamps = false;
        protected $createdField  = 'created_at';
        protected $updatedField  = 'updated_at';
        protected $deletedField  = 'deleted_at';

        public function get($id_sucursal = null){
            if($id_sucursal == null){
                return $this->findAll();
            }
            return $this->asArray()
                ->where('tblsucursal.id_sucursal',$id_sucursal)->findAll();
        }
        public function get_sucursales_establecimiento($id_establecimiento){
            return $this->asArray()
                    ->where("tblsucursal.id_establecimiento",$id_establecimiento)
                    ->findAll();
        }
    }


?>
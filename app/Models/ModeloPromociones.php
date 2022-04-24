<?php
    namespace App\Models;

    use CodeIgniter\Model;


    class ModeloPromociones extends Model
    {
        protected $table = 'tblpromocion';
        protected $primaryKey = 'id_promocion';
        protected $allowedFields = ['fecha_inicio',
                                    'hora_inicio',
                                    'fecha_fin',
                                    'hora_fin',
                                    'codigo',
                                    'nombre',
                                    'descripcion',
                                    'id_tipo_promocion',
                                    'id_sucursal',
                                    'id_establecimiento',
                                    'activo'];
        protected $useSoftDeletes = true;
        protected $useTimestamps = false;
        protected $createdField  = 'created_at';
        protected $updatedField  = 'updated_at';
        protected $deletedField  = 'deleted_at';

        public function get($id_promocion = null){
            if($id_promocion == null){
                return $this->findAll();
            }
            return $this->asArray()
                ->where('tblpromocion.id_promocion',$id_promocion)->findAll();
        }
    }


?>
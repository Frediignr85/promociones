<?php
    namespace App\Models;

    use CodeIgniter\Model;


    class ModeloUsuarioModulo extends Model
    {
        protected $table = 'tblusuario_modulo';
        protected $primaryKey = 'id_usuario_modulo';
        protected $allowedFields = ['id_modulo','id_usuario'];
        protected $useSoftDeletes = false;
        protected $useTimestamps = false;
        protected $createdField  = 'created_at';
        protected $updatedField  = 'updated_at';
        protected $deletedField  = 'deleted_at';

        public function get($id_usuario_modulo = null){
            if($id_usuario_modulo == null){
                return $this->findAll();
            }
            return $this->asArray()
                ->where('tblusuario_modulo.id_usuario_modulo',$id_usuario_modulo)->findAll();
        }
        public function eliminar_permisos_usuario($id_usuario){
            $sql = "DELETE FROM tblusuario_modulo WHERE id_usuario = '$id_usuario'";
            $data2 = $this->db->query($sql);
            return $data2;
        }
        public function traer_permisos_tipo_empleado($id_usuario){
            return $this->asArray()
                ->where("tblusuario_modulo.id_usuario = '$id_usuario'")->findAll();
        }
    }


?>
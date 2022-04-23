<?php
    namespace App\Models;

    use CodeIgniter\Model;


    class ModeloTipoUsuarioModulo extends Model
    {
        protected $table = 'tbltipo_usuario_modulo';
        protected $primaryKey = 'id_tipo_usuario_modulo';
        protected $allowedFields = ['id_modulo','id_tipo_usuario'];
        protected $useSoftDeletes = false;
        protected $useTimestamps = false;
        protected $createdField  = 'created_at';
        protected $updatedField  = 'updated_at';
        protected $deletedField  = 'deleted_at';

        public function get($id_tipo_usuario_modulo = null){
            if($id_tipo_usuario_modulo == null){
                return $this->findAll();
            }
            return $this->asArray()
                ->where('tbltipo_usuario_modulo.id_tipo_usuario_modulo',$id_tipo_usuario_modulo)->findAll();
        }
        public function eliminar_permiso_tipo_empleado($id_tipo_usuario){
            $sql = "DELETE FROM tbltipo_usuario_modulo WHERE id_tipo_usuario = '$id_tipo_usuario'";
            $data2 = $this->db->query($sql);
            return $data2;
        }
        public function traer_permisos_tipo_empleado($id_tipo_usuario){
            return $this->asArray()
                ->where("tbltipo_usuario_modulo.id_tipo_usuario = '$id_tipo_usuario'")->findAll();
        }
    }


?>
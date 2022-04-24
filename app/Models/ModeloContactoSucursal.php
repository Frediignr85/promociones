<?php
    namespace App\Models;

    use CodeIgniter\Model;


    class ModeloContactoSucursal extends Model
    {
        protected $table = 'tblcontacto_sucursal';
        protected $primaryKey = 'id_contacto_sucursal';
        protected $allowedFields = ['nombre','direccion','info_tipo_contacto','id_departamento','id_municipio','id_tipo_contacto','id_sucursal'];
        protected $useSoftDeletes = false;
        protected $useTimestamps = false;
        protected $createdField  = 'created_at';
        protected $updatedField  = 'updated_at';
        protected $deletedField  = 'deleted_at';

        public function get($id_contacto_sucursal = null){
            if($id_contacto_sucursal == null){
                return $this->findAll();
            }
            return $this->asArray()
                ->where('tblcontacto_sucursal.id_contacto_sucursal',$id_contacto_sucursal)->findAll();
        }
        public function eliminar_contactos_sucursal($id_sucursal){
            $sql = "DELETE FROM tblcontacto_sucursal WHERE id_sucursal = '$id_sucursal'";
            $data2 = $this->db->query($sql);
            return $data2;
        }
        public function traer_contactos_sucursal($id_sucursal){
            $sql = "SELECT tblcontacto_sucursal.nombre, tblcontacto_sucursal.direccion, tblcontacto_sucursal.info_tipo_contacto, 
            tblcontacto_sucursal.id_departamento, tbldepartamento.nombre as nombre_departamento,
            tblcontacto_sucursal.id_municipio, tblmunicipio.nombre as nombre_municipio,
            tblcontacto_sucursal.id_tipo_contacto, tbltipo_contacto.nombre as nombre_tipo_contacto
            from tblcontacto_sucursal 
            inner join tbldepartamento on tbldepartamento.id_departamento = tblcontacto_sucursal.id_departamento 
            inner join tblmunicipio on tblmunicipio.id_municipio = tblcontacto_sucursal.id_municipio 
            inner join tbltipo_contacto on tbltipo_contacto.id_tipo_contacto = tblcontacto_sucursal.id_tipo_contacto 
            WHERE tblcontacto_sucursal.id_sucursal = '$id_sucursal'";
            $data2 = $this->db->query($sql);
            $data2 = $data2->getResultArray();
            return $data2;
        }
        public function traer_permisos_tipo_empleado($id_sucursal){
            return $this->asArray()
                ->where("tblcontacto_sucursal.id_sucursal = '$id_sucursal'")->findAll();
        }
    }


?>
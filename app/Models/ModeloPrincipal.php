<?php
    namespace App\Models;
    use CodeIgniter\Model;

    class ModeloPrincipal extends Model{
        /* FUNCION PARA TRAER TODOS LOS DATOS DE LA EMPRESA */
        public function datos_empresa($id_sucursal){
            $data = $this->db->query("SELECT * FROM tblsucursal WHERE id_sucursal = '$id_sucursal'");
            return $data;
        }
        /* FUNCION PARA TRAER EL MENU DEL USUARIO SEGUN LOS PERMISOS QUE ESTE TENGA */
        public function menu($id_usuario, $admin){
           
            $retorno = "";
            $icono='fa fa-star-o';
            $sql_menus="SELECT id_menu, nombre, prioridad,icono FROM tblmenu WHERE visible='1' AND deleted_at is NULL order by prioridad";
            //echo $sql_menus;
            $data = $this->db->query($sql_menus);
            $main_lnk='dashboard.php';
            if($admin=='1')
            {
                $retorno.="<li class='active'>";
                $retorno.="<a href='".base_url("/dashboard")."'><i class='".$icono."'></i> <span class='nav-label'>Inicio</span></a>";
                $retorno.="</li>";
            }
            else
            {
                $retorno.="<li class='active'>";
                $retorno.="<a href='".base_url("/dashboard")."'><i class='".$icono."'></i> <span class='nav-label'>Inicio</span></a>";
                $retorno.="</li>";
            }
            if(count($data->getResult()) > 0){
                foreach ($data->getResult('array') as $value) {
                    $menuname=$value['nombre'];
                    $id_menu=$value['id_menu'];
                    $icono=$value['icono'];
                    if($admin=='1')
                    {
                        $sql_links="SELECT distinct tblmodulo.prioridad,tblmenu.id_menu, tblmenu.nombre as nombremenu, tblmenu.prioridad,
                        tblmodulo.id_modulo, tblmodulo.nombre as nombremodulo, tblmodulo.descripcion, tblmodulo.filename, tblusuario.admin
                        FROM tblmenu, tblmodulo, tblusuario
                        WHERE tblusuario.id_usuario='$id_usuario'
                        AND tblusuario.admin='1'
                        AND tblmenu.id_menu='$id_menu'
                        AND tblmenu.id_menu=tblmodulo.id_menu
                        AND tblmodulo.visible='1'
                        order by tblmodulo.prioridad";
                    }
                    else
                    {
                        $sql_links="SELECT tblmodulo.prioridad,tblmenu.id_menu, tblmenu.nombre as nombremenu, tblmenu.prioridad,
                        tblmodulo.id_modulo,  tblmodulo.nombre as nombremodulo, tblmodulo.descripcion, tblmodulo.filename,
                        tblusuario_modulo.id_usuario,tblusuario.admin
                        FROM tblmenu, tblmodulo, tblusuario_modulo, tblusuario
                        WHERE tblusuario.id_usuario='$id_usuario'
                        AND tblmenu.id_menu='$id_menu'
                        AND tblusuario.id_usuario=tblusuario_modulo.id_usuario
                        AND tblusuario_modulo.id_modulo=tblmodulo.id_modulo
                        AND tblmenu.id_menu=tblmodulo.id_menu
                        AND tblmodulo.visible='1'
                        AND tblusuario_modulo.deleted_at is NULL
                        order by tblmodulo.prioridad";
                    }
                    //$retorno.=$sql_links;
                    //echo $sql_links;
                    $data2 = $this->db->query($sql_links);
                    $data2 = $data2->getResultArray();
                    if(count($data2) > 0){
                        $retorno.="<li><a href='".$main_lnk."' class='".strtolower(($menuname))."'><i class='".$icono."'></i><span class='nav-label'>".$menuname."</span> <span class='fa arrow'></span></a>";
                        $retorno.=" <ul class='nav nav-second-level'>";
                        foreach ($data2 as $value){
                            $lnk=($value['filename']);
                            if($lnk == "<hoja_membretada>")
                            {
                                $extra = "target='_blank'";
                            }
                            else
                            {
                                $lnk = $lnk;
                                $extra = "";
                            }
                            $modulo=$value['nombremodulo'];
                            $id_modulo=$value['id_modulo'];
                            $retorno.="<li><a href='".base_url()."/".$lnk."' $extra>".ucfirst($modulo)."</a></li>";
                        }
                        $retorno.="</ul>";
                        $retorno.=" </li>";
                    }
                }
            }
            return $retorno;
        }

        public function comprobar_permiso($ruta,$id_usuario,$admin){
            if($admin){
                return 1;
            }
            else{
                $sql = "SELECT tblmodulo.filename FROM tblmodulo INNER JOIN tblusuario_modulo on tblusuario_modulo.id_modulo = tblmodulo.id_modulo INNER JOIN tblusuario on tblusuario.id_usuario = tblusuario_modulo.id_usuario WHERE tblusuario.id_usuario = '$id_usuario' AND tblmodulo.filename = '$ruta'";
                $data = $this->db->query($sql);
                $query = $data->getResultArray();
                if($query == null){
                    return 0;
                }
                else{
                    return 1;
                }
            }
        }
        public function traer_permisos($id_tipo_usuario){
            $data = $this->db->query("SELECT * FROM tblmenu WHERE tblmenu.deleted_at is NULL AND visible = 1 ORDER BY tblmenu.prioridad ASC");
            $data = $data->getResultArray();
            $array_devolver = array();
            foreach ($data as $key => $value) {
                $id_menu = $value['id_menu'];
                $nombre_menu = $value['nombre'];
                $icono = $value['icono'];
                $sql2 = "SELECT tblmodulo.id_modulo, tblmodulo.nombre FROM tblmodulo WHERE tblmodulo.id_menu = '$id_menu' AND tblmodulo.deleted_at is NULL ORDER BY tblmodulo.prioridad ASC";
                $data2 = $this->db->query($sql2);
                $data2 = $data2->getResultArray();
                $array_interno = array();
                foreach ($data2 as $key => $value2) {
                    $id_modulo = $value2['id_modulo'];
                    $nombre_modulo = $value2['nombre'];
                    $sql3 = "SELECT * FROM tbltipo_usuario_modulo WHERE tbltipo_usuario_modulo.id_modulo = '$id_modulo' AND tbltipo_usuario_modulo.id_tipo_usuario = '$id_tipo_usuario' AND deleted_at is NULL";
                    $data3 = $this->db->query($sql3);
                    $tiene_permiso = 0;
                    $data3 = $data3->getResultArray();
                    if($data3 != null){
                        $tiene_permiso = 1;
                    }
                    $array_interno[] = array(
                        'id_modulo' => $id_modulo,
                        'nombre_modulo' => $nombre_modulo,
                        'permiso' =>$tiene_permiso
                    );
                }
                $array_devolver[] = array(
                    'id_menu' => $id_menu,
                    'nombre_menu' => $nombre_menu,
                    'icono' => $icono,
                    'modulos' => $array_interno
                );
            }
            return $array_devolver;
        }

        public function traer_permisos_usuario($id_usuario){
            $data = $this->db->query("SELECT * FROM tblmenu WHERE visible = 1 ORDER BY tblmenu.prioridad ASC");
            $data = $data->getResultArray();
            $array_devolver = array();
            foreach ($data as $key => $value) {
                $id_menu = $value['id_menu'];
                $nombre_menu = $value['nombre'];
                $icono = $value['icono'];
                $sql2 = "SELECT tblmodulo.id_modulo, tblmodulo.nombre FROM tblmodulo WHERE tblmodulo.id_menu = '$id_menu' AND tblmodulo.deleted_at is NULL ORDER BY tblmodulo.prioridad ASC";
                $data2 = $this->db->query($sql2);
                $data2 = $data2->getResultArray();
                $array_interno = array();
                foreach ($data2 as $key => $value2) {
                    $id_modulo = $value2['id_modulo'];
                    $nombre_modulo = $value2['nombre'];
                    $sql3 = "SELECT * FROM tblusuario_modulo WHERE tblusuario_modulo.id_modulo = '$id_modulo' AND tblusuario_modulo.id_usuario = '$id_usuario' AND deleted_at is NULL";
                    $data3 = $this->db->query($sql3);
                    $tiene_permiso = 0;
                    $data3 = $data3->getResultArray();
                    if($data3 != null){
                        $tiene_permiso = 1;
                    }
                    $array_interno[] = array(
                        'id_modulo' => $id_modulo,
                        'nombre_modulo' => $nombre_modulo,
                        'permiso' =>$tiene_permiso
                    );
                }
                $array_devolver[] = array(
                    'id_menu' => $id_menu,
                    'nombre_menu' => $nombre_menu,
                    'icono' => $icono,
                    'modulos' => $array_interno
                );
            }
            return $array_devolver;
        }

        /* FUNCION PARA INICIAR TRANSACCION */
        public function begin(){
            $this->db->transStart();
        }
        /* FUNCION PARA COMPROBAR ERRORES DE UNA TRANSACCION */
        public function verificar_transaccion(){
            if ($this->db->transStatus() === false) {
                return 0;
            }
            else{
                return 1;
            }
        }
        /* FUNCION PARA HACER UN ROLLBACK DE LA TRANSACCION */
        public function rollback(){
            $this->db->transRollback();
        }
        /* FUNCION PARA HACER UN COMMIT DE LA TRANSACCION */
        public function commit(){
            $this->db->transCommit();
        }

    }

    

?>
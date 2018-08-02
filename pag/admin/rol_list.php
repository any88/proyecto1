<?php
include '../../funct/con_tacnamh_db.php';
include '../../funct/functions.php';
include '../../modelo/consultas_genericas.php';
include "../session_header.php";
include './header.php';

###datos generales
$entity_name="roles del sistema";
$link_edit="rol_edit.php";
$link_listar="rol_list.php";
$link_add="rol_add.php";
$location="rol_list.php";
$link_perfil="rol_edit.php";
###validar si el usuario logueado tiene acceso a ejevutar las acciones editar y eliminar, por defecto falso
$permisos_de_action=1;


$listado_select= array();
$bd_table="rol";
$id_table="id_rol";
$elemento_distintivo="nombre";

##campos para el delete
$delete_campo="id_rol";
$delete_table="rol";



###campos a mostrar en la tabla
$a=0;
$campos_tabla[$a]["nombre_mostrar"]="No.";
$campos_tabla[$a]["nombre_bd"]="id_rol";

$a++;
$campos_tabla[$a]["nombre_mostrar"]="Nombre";
$campos_tabla[$a]["nombre_bd"]="nombre";
$a++;
$campos_tabla[$a]["nombre_mostrar"]="Descripci&oacute;n";
$campos_tabla[$a]["nombre_bd"]="descripcion";
$a++;

include './plantilla_crud.php';

echo "<br><br>";

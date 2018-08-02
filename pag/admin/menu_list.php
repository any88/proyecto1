<?php
include './session_header.php';
include '../../funct/con_cautivadb.php';
include '../../funct/functions.php';

include '../../modelo/consultas_genericas.php';

###datos generales
$entity_name="menu";
$link_edit="menu_edit.php";
$link_listar="menu_list.php";
$link_add="menu_add.php";
$location="menu_list.php";
$link_perfil="menu_edit.php";

###validar si el usuario logueado tiene acceso a ejevutar las acciones editar y eliminar, por defecto falso
$permisos_de_action=0;
if($h_id_tipo_usuario==1){$permisos_de_action=1;}

$listado_select= array();
$bd_table="menu";
$id_table="id_menu";
$elemento_distintivo="nombre";

##campos para el delete
$delete_campo="id_menu";
$delete_table="menu";



###campos a mostrar en la tabla
$a=0;
$campos_tabla[$a]["nombre_mostrar"]="No.";
$campos_tabla[$a]["nombre_bd"]="id_menu";

$a++;
$campos_tabla[$a]["nombre_mostrar"]="Nombre";
$campos_tabla[$a]["nombre_bd"]="nombre";
$a++;

include './plantilla_crud.php';

echo "<br><br>";

?>



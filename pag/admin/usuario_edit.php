<?php
include '../../funct/con_tacnamh_db.php';
include '../../funct/functions.php';
include '../../modelo/consultas_genericas.php';
include "../session_header.php";
include './header.php';

###datos generales
$location="index_admin.php";
$entity_name="Usuarios";
$entity_campo_id="id_usuario";
$msg="";
$tipo_msg="";
$edit_table="usuario";

###validar si el usuario logueado tiene acceso a ejevutar las acciones editar y eliminar, por defecto falso
$permisos_de_action=1;


#valor a comparar para ver si existe
$elemento_distintivo="usuario";

$link_cancelar="index_admin.php";
##listado de campos
$campos_add=array();
$cont_c=0;
$campos_add[$cont_c]['campobd']="usuario";
$campos_add[$cont_c]['nombre']="Usuario";
$campos_add[$cont_c]['tipo']="text";
$campos_add[$cont_c]['select']="";
$campos_add[$cont_c]['valor']="";
$campos_add[$cont_c]['validate']="lnc";
$cont_c++;
$campos_add[$cont_c]['campobd']="nombre";
$campos_add[$cont_c]['nombre']="Nombre";
$campos_add[$cont_c]['tipo']="text";
$campos_add[$cont_c]['select']="";
$campos_add[$cont_c]['valor']="";
$campos_add[$cont_c]['validate']="lnc";
$cont_c++;
$campos_add[$cont_c]['campobd']="password";
$campos_add[$cont_c]['nombre']="Contrase&ntilde;a";
$campos_add[$cont_c]['tipo']="pass";
$campos_add[$cont_c]['select']="";
$campos_add[$cont_c]['valor']="";
$campos_add[$cont_c]['validate']="";
$cont_c++;
##cargar los distintos tipos de cargos
$cg=new ConsultasG();
$lista=$cg->Distint("rol", "nombre", "id_rol");

$campos_add[$cont_c]['campobd']="id_rol";
$campos_add[$cont_c]['nombre']="Rol";
$campos_add[$cont_c]['tipo']="select";
$campos_add[$cont_c]['select']=$lista;
$campos_add[$cont_c]['valor']="";
$campos_add[$cont_c]['list_name']="nombre";
$campos_add[$cont_c]['list_value']="id_rol";
$cont_c++;


include './plantilla_edit.php';
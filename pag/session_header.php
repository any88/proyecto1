<?php

session_start();
if(!$_SESSION["loggin"]){
    header("location:errors_404.html");
}
###################################
$h_user=$_SESSION["loggin"];
$h_id_usuario=$_SESSION["id_user"];
$h_nombre=$_SESSION["nombre"];
$h_id_rol=$_SESSION["rol"];

###################################

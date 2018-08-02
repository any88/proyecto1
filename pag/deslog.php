<?php

include"../functions/functions.php";
include"../functions/con_conduces.php";

session_start();
$data=session_encode( );

$_SESSION['loggin']=null;
// Finalmente, destruir la sesión.
session_destroy();

Header("location:../index.php");

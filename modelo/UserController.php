<?php
require 'Usuario.php';
class UserController {

public function UserControLLer(){}

public function LoginObject($user,$pass)
{
    $result=array();
    $bd= new con_mysqli("", "", "", "");
    ##validar iny sql
    $user=$bd->ValidarCadena($user);
    $pass=$bd->ValidarCadena($pass);

    $md5_pass= md5($pass);
    
    $consulta="SELECT * FROM `usuario` WHERE `user` = '$user' AND `pass` = '$md5_pass' && `estado`='activo'";
    
    $r=$bd->consulta($consulta);
    if($r)
    {
        $a=0;
        while ($fila=$bd->fetch_assoc($r))
        {
            $bd_id=$fila['id_usuario'];
            $id_tipo_usuario=$fila['id_tipo_usuario'];
            $id_cargo_usuario=$fila['id_cargo_usuario'];
            $id_empresa=$fila['id_empresa'];
            $nombre=$fila['nombre'];
            $user=$fila['user'];
            $pass=$fila['pass'];
            $dni=$fila['dni'];
            $email=$fila['email'];
            $telefono=$fila['telefono'];
            $estado=$fila['estado'];

            $obj_user=new Usuario($bd_id,$id_tipo_usuario,$id_cargo_usuario,$nombre,$user,$pass,$id_empresa,$dni,$email,$telefono,$estado);
            $result[$a]=$obj_user;

        }
    }

    return $result;
    
}

}

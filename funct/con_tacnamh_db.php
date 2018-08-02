<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of con_mysqli
 *
 * @author MARGOTH TAPIA
 */
class con_mysqli extends mysqli

{
    private $conexion;
    
    public function __construct($host=null, $usuario=null, $contraseña=null, $bd=null)
    {
        
    $host="localhost";
    $usuario="root";
    $contraseña="";
    $bd="tacnamhapp_db";
    
        parent::__construct($host, $usuario, $contraseña, $bd);

        if (mysqli_connect_error()) {
            die('Error de Conexión (' . mysqli_connect_errno() . ') '
                . mysqli_connect_error());
        }
        else {
            $this->conexion=mysqli_connect($host, $usuario,$contraseña,$bd);
            $this->conexion->set_charset("utf8");
        }
    }
    
    public function consulta($consulta)
    {
         
        
        $resultado=mysqli_query($this->conexion, $consulta);
        
        return $resultado;
    }
    
    public function fetch_assoc($result)
    {
        return mysqli_fetch_assoc($result);
    }
    
    public function num_row($result)
    {
        return mysqli_num_rows($result);
    }
    
    public function affected_row()
    {
        return mysqli_affected_rows($this->conexion);
    
    }
    public function fetch_array($consulta)
    {
        return mysqli_fetch_array($consulta);
    }
    public function Close()
    {
        mysqli_close($this->conexion);
    }
    
    public function real_scape_string($cadena)
    {
        return mysqli_real_escape_string($this->conexion, $cadena);
    }
     public function ValidarCadena($cadena)
    {
        // escaping, additionally removing everything that could be (html/javascript-) code
        return mysqli_real_escape_string($this->conexion,(strip_tags($cadena,ENT_QUOTES)));
    }
}

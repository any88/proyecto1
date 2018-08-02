<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of CargoController
 *
 * @author MARGOTH TAPIA
 */

include '../Modelo/Cargo.php';

class CargoController {
    
    public function CargoController(){}
    
public function CrearCargo($p_nombre)
{
    $affected=0;
    $bd=new con_mysqli("", "", "", "");
    
    ##Validar Iny Sql
        $p_nombre=$bd->real_scape_string($p_nombre);
                
        $consulta="INSERT INTO `cargo` (`nombrecargo`) VALUES ('$p_nombre')";
        
        $r=$bd->consulta($consulta);
        if($r)
        {
            $affected=$bd->affected_row();
        }
        $bd->Close();
        return $affected;
        
}

public function ModificarCargo($p_id,$p_nombre)
    {
        $affected=0;
        $bd=new con_mysqli("", "", "", "");
        
        ##Validar Iny Sql
        $p_id=$bd->real_scape_string($p_id);
        $p_nombre=$bd->real_scape_string($p_nombre);
                
        $consulta="UPDATE `cargo` SET `nombrecargo`='$p_nombre' WHERE (`idcargo`='$p_id')";
        
        $r=$bd->consulta($consulta);
        if($r)
        {
            $affected=$bd->affected_row();
            if($affected==0){$affected=1;}
        }
        $bd->Close();
        return $affected;
    }
    
    public function EliminarCargo($p_id)
    {
        $affected=0;
        $bd=new con_mysqli("", "", "", "");
        
        ##Validar Iny Sql
        $p_id=$bd->real_scape_string($p_id);
        
        $consulta="DELETE FROM `cargo` WHERE (`idcargo`='$p_id')";
        
        $r=$bd->consulta($consulta);
        if($r)
        {
            $affected=$bd->affected_row();
        }
        $bd->Close();
        return $affected;
        
    }
    
    public function MostrarCargo()
    {
        $result=array();
        $bd= new con_mysqli("", "", "", "");
        $consulta="SELECT * FROM `cargo` order by `nombrecargo` ASC";
        $r=$bd->consulta($consulta);
        if($r)
        {
            $a=0;
            while ($fila=$bd->fetch_assoc($r))
            {
               
                $p_id=$fila["idcargo"];
                $p_nombre=$fila["nombrecargo"];
                                                
                $objCargo=new Cargo($p_id, $p_nombre);
                $result[$a]=$objCargo;
                $a++;
            }
        }
        $bd->Close();
        return $result;
    }
    
    public function BuscarLike($p_nombre)
    {
        $result=array();
        $bd= new con_mysqli("", "", "", "");
        $consulta="SELECT * FROM `cargo` WHERE `nombrecargo`LIKE '%$p_nombre%'";
        $r=$bd->consulta($consulta);
        if($r)
        {
            $a=0;
            while ($fila=$bd->fetch_assoc($r))
            {
                 
                $p_id=$fila["idcargo"];
                $p_nombre=$fila["nombrecargo"];
                                                
                $objCargo=new Cargo($p_id, $p_nombre);
                $result[$a]=$objCargo;
                $a++;
            }
        }
        $bd->Close();
        return $result;
    }

    public function BuscarCargo($p_id, $p_nombre)
    {
        $result=array();
        $bd= new con_mysqli("", "", "", "");
        $consulta="SELECT * FROM `cargo` ";
        
        if($p_id!="")
        {
            $consulta=$consulta."WHERE `idcargo`='$p_id'";
        }
        if($p_nombre!="")
        {
            if($p_id=="")
            {
                $consulta=$consulta."WHERE `nombrecargo`='$p_nombre'";
            }
            else 
            {
                $consulta=$consulta." and `nombrecargo`='$p_nombre'";
            }
        }       
        
        $consulta=$consulta." order by `nombrecargo` ASC";
        $r=$bd->consulta($consulta);
        if($r)
        {
            $a=0;
            while ($fila=$bd->fetch_assoc($r))
            {
                 
                $p_id=$fila["idcargo"];
                $p_nombre=$fila["nombrecargo"];
                                                
                $objCargo=new Cargo($p_id, $p_nombre);
                $result[$a]=$objCargo;
                $a++;
            }
        }
        $bd->Close();
        return $result;
        
    }
    
    public function CargarCargo($search)
    {
        $result=array();
        $bd= new con_mysqli("", "", "", "");
        
        ##Validar parametros
        $search=$bd->real_scape_string($search);
        
        $consulta="SELECT * FROM `cargo` WHERE `nombrecargo` LIKE '%$search%'";
        $r=$bd->consulta($consulta);
        if($r)
        {
            $a=0;
            while ($fila=$bd->fetch_assoc($r))
            {
                $bd_nombre=$fila["nombrecargo"];
                $result[$a]=$bd_nombre;
                $a++;
            }
        }
        $bd->Close();
        
        return $result;
    }
    
}

<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of NombreCirugiaController
 *
 * @author MARGOTH TAPIA
 */

include '../modelo/NombreCirugia.php';

class NombreCirugiaController {
    
    public function NombreCirugiaController(){}
    
public function CrearNombreCirugia($p_nombrecirugia, $p_idespecialidad)
{
    $affected=0;
    $bd=new con_mysqli("", "", "", "");
    
    ##Validar Iny Sql
        $p_nombrecirugia=$bd->real_scape_string($p_nombrecirugia);
        $p_idespecialidad=$bd->real_scape_string($p_idespecialidad);
                
        $consulta="INSERT INTO `nombrecirugia` (`nombrecirugia`, `idespecialidad`) VALUES ('$p_nombrecirugia', '$p_idespecialidad')";
        
        $r=$bd->consulta($consulta);
        if($r)
        {
            $affected=$bd->affected_row();
        }
        $bd->Close();
        return $affected;
        
}

public function ModificarNombreCirugia($p_id, $p_nombrecirugia, $p_idespecialidad)
    {
        $affected=0;
        $bd=new con_mysqli("", "", "", "");
        
        ##Validar Iny Sql
        $p_id=$bd->real_scape_string($p_id);
        $p_nombrecirugia=$bd->real_scape_string($p_nombrecirugia);
        $p_idespecialidad=$bd->real_scape_string($p_idespecialidad);
                
        $consulta="UPDATE `nombrecirugia` SET `nombrecirugia`='$p_nombrecirugia', `idespecialidad`='$p_idespecialidad' WHERE (`idnombrecirugia`='$p_id')";
        
        $r=$bd->consulta($consulta);
        if($r)
        {
            $affected=$bd->affected_row();
        }
        $bd->Close();
        return $affected;
    }
    
    public function EliminarNombreCirugia($p_id)
    {
        $affected=0;
        $bd=new con_mysqli("", "", "", "");
        
        ##Validar Iny Sql
        $p_id=$bd->real_scape_string($p_id);
        
        $consulta="DELETE FROM `nombrecirugia` WHERE (`idnombrecirugia`='$p_id')";
        
        $r=$bd->consulta($consulta);
        if($r)
        {
            $affected=$bd->affected_row();
        }
        $bd->Close();
        return $affected;
        
    }
    
    public function MostrarNombreCirugia()
    {
        $result=array();
        $bd= new con_mysqli("", "", "", "");
        $consulta="SELECT * FROM `nombrecirugia` order by `nombrecirugia` ASC";
        $r=$bd->consulta($consulta);
        if($r)
        {
            $a=0;
            while ($fila=$bd->fetch_assoc($r))
            {
               
                $p_id=$fila["idnombrecirugia"];
                $p_nombrecirugia=$fila["nombrecirugia"];
                $p_idespecialidad=$fila["idespecialidad"];
                                                
                $objNombreCirugia=new NombreCirugia($p_id, $p_nombrecirugia, $p_idespecialidad);
                $result[$a]=$objNombreCirugia;
                $a++;
            }
        }
        $bd->Close();
        return $result;
    }
    
    public function BuscarNombreCirugia($p_id, $p_nombrecirugia, $p_idespecialidad)
    {
        $result=array();
        $bd= new con_mysqli("", "", "", "");
        $consulta="SELECT * FROM `nombrecirugia` ";
        
        if($p_id!="")
        {
            $consulta=$consulta."WHERE `idnombrecirugia`='$p_id'";
        }
        if($p_nombrecirugia!="")
        {
            if($p_id=="")
            {
                $consulta=$consulta."WHERE `nombrecirugia`='$p_nombrecirugia'";
            }
            else 
            {
                $consulta=$consulta." and `nombrecirugia`='$p_nombrecirugia'";
            }
        }      
        if($p_idespecialidad!="")
        {
            if($p_id=="" && $p_nombrecirugia=="")
            {
                $consulta=$consulta."WHERE `idespecialidad`='$p_idespecialidad'";
            }
            else 
            {
                $consulta=$consulta." and `idespecialidad`='$p_idespecialidad'";
            }
        }      
        
        $consulta=$consulta." order by `idnombrecirugia` ASC";
        $r=$bd->consulta($consulta);
        if($r)
        {
            $a=0;
            while ($fila=$bd->fetch_assoc($r))
            {
                 
                $p_id=$fila["idnombrecirugia"];
                $p_nombrecirugia=$fila["nombrecirugia"];
                $p_idespecialidad=$fila["idespecialidad"];
                                                
                $objNombreCirugia=new NombreCirugia($p_id, $p_nombrecirugia, $p_idespecialidad);
                $result[$a]=$objNombreCirugia;
                $a++;
            }
        }
        $bd->Close();
        return $result;
        
    }
    
    public function CargarNombreCirugiaID($search)
    {
        $result=array();
        $bd= new con_mysqli("", "", "", "");
        
        ##Validar parametros
        $search=$bd->real_scape_string($search);
        
        $consulta="SELECT * FROM `nombrecirugia` WHERE `idnombrecirugia` LIKE '%$search%'";
        $r=$bd->consulta($consulta);
        if($r)
        {
            $a=0;
            while ($fila=$bd->fetch_assoc($r))
            {
                $bd_idcirugia=$fila["idnombrecirugia"];
                $result[$a]=$bd_idcirugia;
                $a++;
            }
        }
        $bd->Close();
        
        return $result;
    }
    public function CargarNombreCirugia($search)
    {
        $result=array();
        $bd= new con_mysqli("", "", "", "");
        
        ##Validar parametros
        $search=$bd->real_scape_string($search);
    
        $consulta="SELECT * FROM `nombrecirugia` WHERE `idnombrecirugia` LIKE '%$search%'";
        $r=$bd->consulta($consulta);
        if($r)
        {
            $a=0;
            while ($fila=$bd->fetch_assoc($r))
            {
                $bd_idnombrecirugia=$fila["idnombrecirugia"];
                $bd_nombrecirugia=$fila["nombrecirugia"];
                $result[$a]="($bd_idnombrecirugia) ".$bd_nombrecirugia;
                $a++;
            }
        }
        $bd->Close();
    
        return $result;
    }
}

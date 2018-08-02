<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of EspecialidadController
 *
 * @author MARGOTH TAPIA
 */

include '../Modelo/Especialidad.php';

class EspecialidadController {
    
    public function EspecialidadController(){}
    
public function CrearEspecialidad($p_nombre, $p_esquirurgica)
{
    $affected=0;
    $bd=new con_mysqli("", "", "", "");
    
    ##Validar Iny Sql
        $p_nombre=$bd->real_scape_string($p_nombre);
        $p_esquirurgica=$bd->real_scape_string($p_esquirurgica);
                
        $consulta="INSERT INTO `especialidad` (`nombreespecialidad`, `esquirurgica`) VALUES ('$p_nombre', '$p_esquirurgica')";
        
        $r=$bd->consulta($consulta);
        if($r)
        {
            $affected=$bd->affected_row();
        }
        $bd->Close();
        return $affected;
        
}

public function ModificarEspecialidad($p_id,$p_nombre,$p_esquirurgica)
    {
        $affected=0;
        $bd=new con_mysqli("", "", "", "");
        
        ##Validar Iny Sql
        $p_id=$bd->real_scape_string($p_id);
        $p_nombre=$bd->real_scape_string($p_nombre);
        $p_esquirurgica=$bd->real_scape_string($p_esquirurgica);
                
        $consulta="UPDATE `especialidad` SET `nombreespecialidad`='$p_nombre', `esquirurgica`='$p_esquirurgica' WHERE (`idespecialidad`='$p_id')";
        
        $r=$bd->consulta($consulta);
        if($r)
        {
            $affected=$bd->affected_row();
            if($affected==0){$affected=1;}
        }
        $bd->Close();
        return $affected;
    }
    
    public function EliminarEspecialidad($p_id)
    {
        $affected=0;
        $bd=new con_mysqli("", "", "", "");
        
        ##Validar Iny Sql
        $p_id=$bd->real_scape_string($p_id);
        
        $consulta="DELETE FROM `especialidad` WHERE (`idespecialidad`='$p_id')";
        
        $r=$bd->consulta($consulta);
        if($r)
        {
            $affected=$bd->affected_row();
        }
        $bd->Close();
        return $affected;
        
    }
    
    public function MostrarEspecialidad()
    {
        $result=array();
        $bd= new con_mysqli("", "", "", "");
        $consulta="SELECT * FROM `especialidad` order by `nombreespecialidad` ASC";
        $r=$bd->consulta($consulta);
        if($r)
        {
            $a=0;
            while ($fila=$bd->fetch_assoc($r))
            {
               
                $p_id=$fila["idespecialidad"];
                $p_nombre=$fila["nombreespecialidad"];
                $p_esquirurgica=$fila["esquirurgica"];
                                                
                $objEspecialidad=new Especialidad($p_id, $p_nombre, $p_esquirurgica);
                $result[$a]=$objEspecialidad;
                $a++;
            }
        }
        $bd->Close();
        return $result;
    }
    
    public function BuscarEspecialidad($p_id, $p_nombre, $p_esquirurgica)
    {
        $result=array();
        $bd= new con_mysqli("", "", "", "");
        $consulta="SELECT * FROM `especialidad` ";
        
        if($p_id!="")
        {
            $consulta=$consulta."WHERE `idespecialidad`='$p_id'";
        }
        if($p_nombre!="")
        {
            if($p_id=="")
            {
                $consulta=$consulta."WHERE `nombreespecialidad`='$p_nombre'";
            }
            else 
            {
                $consulta=$consulta." and `nombreespecialidad`='$p_nombre'";
            }
        }   
        if($p_esquirurgica!="")
        {
            if($p_id=="" && $p_nombre=="")
            {
                $consulta=$consulta."WHERE `esquirurgica`='$p_esquirurgica'";
            }
            else 
            {
                $consulta=$consulta." and `esquirurgica`='$p_esquirurgica'";
            }
        }  
        
        $consulta=$consulta." order by `nombreespecialidad` ASC";
        $r=$bd->consulta($consulta);
        if($r)
        {
            $a=0;
            while ($fila=$bd->fetch_assoc($r))
            {
                 
                $p_id=$fila["idespecialidad"];
                $p_nombre=$fila["nombreespecialidad"];
                $p_esquirurgica=$fila["esquirurgica"];
                                                
                $objEspecialidad=new Especialidad($p_id, $p_nombre, $p_esquirurgica);
                $result[$a]=$objEspecialidad;
                $a++;
            }
        }
        $bd->Close();
        return $result;
        
    }
    
    public function CargarEspecialidad($search)
    {
        $result=array();
        $bd= new con_mysqli("", "", "", "");
        
        ##Validar parametros
        $search=$bd->real_scape_string($search);
        
        $consulta="SELECT * FROM `especialidad` WHERE `nombreespecialidad` LIKE '%$search%'";
        $r=$bd->consulta($consulta);
        if($r)
        {
            $a=0;
            while ($fila=$bd->fetch_assoc($r))
            {
                $bd_nombre=$fila["nombreespecialidad"];
                $result[$a]=$bd_nombre;
                $a++;
            }
        }
        $bd->Close();
        
        return $result;
    }
       
}

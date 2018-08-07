<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of ServicioController
 *
 * @author MARGOTH TAPIA
 */

include '../Modelo/Servicio.php';

class ServicioController {
    
    public function ServicioController(){}
    
public function CrearServicio($p_idtiposervicio, $p_precio)
{
    $affected=0;
    $bd=new con_mysqli("", "", "", "");
    
    ##Validar Iny Sql
        $p_idtiposervicio=$bd->real_scape_string($p_idtiposervicio);
        $p_precio=$bd->real_scape_string($p_precio);
        
        $consulta="INSERT INTO `servicio` (`idtiposervicio`, `precio`) VALUES ('$p_idtiposervicio', '$p_precio')";
        
        $r=$bd->consulta($consulta);
        if($r)
        {
            $affected=$bd->affected_row();
            if($affected==1)
            {
                $consulta="SELECT LAST_INSERT_ID()";
                $r=$bd->consulta($consulta);
                if($r)
                {
                    $fila=$bd->fetch_array($r);
                    $affected=$fila[0];
                }
                
            }
        }
        $bd->Close();
        return $affected;
        
}

public function ModificarServicio($p_id,$p_idtiposervicio,$p_precio)
    {
        $affected=0;
        $bd=new con_mysqli("", "", "", "");
        
        ##Validar Iny Sql
        $p_id=$bd->real_scape_string($p_id);
        $p_idtiposervicio=$bd->real_scape_string($p_idtiposervicio);
        $p_precio=$bd->real_scape_string($p_precio);
        
        $consulta="UPDATE `servicio` SET `idtiposervicio`='$p_idtiposervicio', `precio`='$p_precio' WHERE (`idservicio`='$p_id')";
        
        $r=$bd->consulta($consulta);
        if($r)
        {
            $affected=$bd->affected_row();
        }
        $bd->Close();
        return $affected;
    }
    
    public function EliminarServicio($p_id)
    {
        $affected=0;
        $bd=new con_mysqli("", "", "", "");
        
        ##Validar Iny Sql
        $p_id=$bd->real_scape_string($p_id);
        
        $consulta="DELETE FROM `servicio` WHERE (`idservicio`='$p_id')";
        
        $r=$bd->consulta($consulta);
        if($r)
        {
            $affected=$bd->affected_row();
        }
        $bd->Close();
        return $affected;
        
    }
    
    public function MostrarServicio()
    {
        $result=array();
        $bd= new con_mysqli("", "", "", "");
        $consulta="SELECT * FROM `servicio` order by `idtiposervicio` ASC";
        $r=$bd->consulta($consulta);
        if($r)
        {
            $a=0;
            while ($fila=$bd->fetch_assoc($r))
            {
               
                $p_id=$fila["idservicio"];
                $p_idtiposervicio=$fila["idtiposervicio"];
                $p_precio=$fila["precio"];
                                
                $objServicio=new Servicio($p_id, $p_idtiposervicio, $p_precio);
                $result[$a]=$objServicio;
                $a++;
            }
        }
        $bd->Close();
        return $result;
    }
    
    public function BuscarServicio($p_id, $p_idtiposervicio, $p_precio)
    {
        $result=array();
        $bd= new con_mysqli("", "", "", "");
        $consulta="SELECT * FROM `servicio` ";
        
        if($p_id!="")
        {
            $consulta=$consulta."WHERE `idservicio`='$p_id'";
        }
        if($p_idtiposervicio!="")
        {
            if($p_id=="")
            {
                $consulta=$consulta."WHERE `idtiposervicio`='$p_idtiposervicio'";
            }
            else 
            {
                $consulta=$consulta." and `idtiposervicio`='$p_idtiposervicio'";
            }
        }
        if($p_precio!="")
        {
            if($p_id=="" && $p_idtiposervicio=="" )
            {
                $consulta=$consulta."WHERE `precio`='$p_precio'";
            }
            else 
            {
                $consulta=$consulta." and `precio`='$p_precio'";
            }
         }
         
         
        
        $consulta=$consulta." order by `idservicio` ASC";
      
        $r=$bd->consulta($consulta);
        if($r)
        {
            $a=0;
            while ($fila=$bd->fetch_assoc($r))
            {
                 
                $p_id=$fila["idservicio"];
                $p_idtiposervicio=$fila["idtiposervicio"];
                $p_precio=$fila["precio"];
                              
               
                $objServicio=new Servicio($p_id, $p_idtiposervicio, $p_precio);

                $result[$a]=$objServicio;
                $a++;
            }
        }
        $bd->Close();
        return $result;
        
    }
    
    public function CargarServicio($search)
    {
        $result=array();
        $bd= new con_mysqli("", "", "", "");
        
        ##Validar parametros
        $search=$bd->real_scape_string($search);
        
        $consulta="SELECT * FROM `servicio` WHERE `idservicio` LIKE '%$search%'";
        $r=$bd->consulta($consulta);
        if($r)
        {
            $a=0;
            while ($fila=$bd->fetch_assoc($r))
            {
                $bd_idservicio=$fila["idservicio"];
                $result[$a]=$bd_idservicio;
                $a++;
            }
        }
        $bd->Close();
        
        return $result;
    }
    public function CargarServicioID($search)
    {
        $result=array();
        $bd= new con_mysqli("", "", "", "");
        
        ##Validar parametros
        $search=$bd->real_scape_string($search);
    
        $consulta="SELECT * FROM `servicio` WHERE `idservicio` LIKE '%$search%'";
        $r=$bd->consulta($consulta);
        if($r)
        {
            $a=0;
            while ($fila=$bd->fetch_assoc($r))
            {
                $bd_idservicio=$fila["idservicio"];
                $bd_precio=$fila["precio"];
                $result[$a]="($bd_idservicio) ".$bd_precio;
                $a++;
            }
        }
        $bd->Close();
    
        return $result;
    }
    
    
}

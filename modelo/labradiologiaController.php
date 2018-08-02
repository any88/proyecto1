<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of labradiologiaController
 *
 * @author MARGOTH TAPIA
 */

include '../modelo/labradiologia.php';

class labradiologiaController {
    
    public function labradiologiaController(){}
    
public function CrearLabRadiologia($p_nombre, $p_ruc)
{
    $affected=0;
    $bd=new con_mysqli("", "", "", "");
    
    ##Validar Iny Sql
        $p_nombre=$bd->real_scape_string($p_nombre);
        $p_ruc=$bd->real_scape_string($p_ruc);
        
        $consulta="INSERT INTO `labradiologia` (`nombrelabradiologia`, `ruc`) VALUES ('$p_nombre', '$p_ruc')";
        
        $r=$bd->consulta($consulta);
        if($r)
        {
            $affected=$bd->affected_row();
        }
        $bd->Close();
        return $affected;
        
}

public function ModificarLabRadiologia($p_id,$p_nombre,$p_ruc)
    {
        $affected=0;
        $bd=new con_mysqli("", "", "", "");
        
        ##Validar Iny Sql
        $p_id=$bd->real_scape_string($p_id);
        $p_nombre=$bd->real_scape_string($p_nombre);
        $p_ruc=$bd->real_scape_string($p_ruc);
        
        $consulta="UPDATE `labradiologia` SET `nombrelabradiologia`='$p_nombre', `ruc`='$p_ruc' WHERE (`idlabradiologia`='$p_id')";
        
        $r=$bd->consulta($consulta);
        if($r)
        {
            $affected=$bd->affected_row();
            if($affected==0){$affected=1;}
        }
        $bd->Close();
        return $affected;
    }
    
    public function EliminarLabRadiologia($p_id)
    {
        $affected=0;
        $bd=new con_mysqli("", "", "", "");
        
        ##Validar Iny Sql
        $p_id=$bd->real_scape_string($p_id);
        
        $consulta="DELETE FROM `labradiologia` WHERE (`idlabradiologia`='$p_id')";
        
        $r=$bd->consulta($consulta);
        if($r)
        {
            $affected=$bd->affected_row();
        }
        $bd->Close();
        return $affected;
        
    }
    
    public function MostrarLabRadiologia()
    {
        $result=array();
        $bd= new con_mysqli("", "", "", "");
        $consulta="SELECT * FROM `labradiologia` order by `nombrelabradiologia` ASC";
        $r=$bd->consulta($consulta);
        if($r)
        {
            $a=0;
            while ($fila=$bd->fetch_assoc($r))
            {
               
                $p_id=$fila["idlabradiologia"];
                $p_nombre=$fila["nombrelabradiologia"];
                $p_ruc=$fila["ruc"];
                                
                $objLabRadiologia=new labradiologia($p_id, $p_nombre, $p_ruc);
                $result[$a]=$objLabRadiologia;
                $a++;
            }
        }
        $bd->Close();
        return $result;
    }
    
    public function BuscarLabRadiologia($p_id, $p_nombre, $p_ruc)
    {
        $result=array();
        $bd= new con_mysqli("", "", "", "");
        $consulta="SELECT * FROM `labradiologia` ";
        
        if($p_id!="")
        {
            $consulta=$consulta."WHERE `idlabradiologia`='$p_id'";
        }
        if($p_nombre!="")
        {
            if($p_id=="")
            {
                $consulta=$consulta."WHERE `nombrelabradiologia`='$p_nombre'";
            }
            else 
            {
                $consulta=$consulta." and `nombrelabradiologia`='$p_nombre'";
            }
        }
        if($p_ruc!="")
        {
            if($p_id=="" && $p_nombre=="" )
            {
                $consulta=$consulta."WHERE `ruc`='$p_ruc'";
            }
            else 
            {
                $consulta=$consulta." and `ruc`='$p_ruc'";
            }
         }
         
        
        $consulta=$consulta." order by `nombrelabradiologia` ASC";
        $r=$bd->consulta($consulta);
        if($r)
        {
            $a=0;
            while ($fila=$bd->fetch_assoc($r))
            {
                 
                $p_id=$fila["idlabradiologia"];
                $p_nombre=$fila["nombrelabradiologia"];
                $p_ruc=$fila["ruc"];
                                
                $objLabRadiologia=new labradiologia($p_id, $p_nombre, $p_ruc);
                $result[$a]=$objLabRadiologia;
                $a++;
            }
        }
        $bd->Close();
        return $result;
        
    }
    
    public function CargarLabRadiologia($search)
    {
        $result=array();
        $bd= new con_mysqli("", "", "", "");
        
        ##Validar parametros
        $search=$bd->real_scape_string($search);
        
        $consulta="SELECT * FROM `labradiologia` WHERE `nombrelabradiologia` LIKE '%$search%'";
        $r=$bd->consulta($consulta);
        if($r)
        {
            $a=0;
            while ($fila=$bd->fetch_assoc($r))
            {
                $bd_nombre=$fila["nombrelabradiologia"];
                $result[$a]=$bd_nombre;
                $a++;
            }
        }
        $bd->Close();
        
        return $result;
    }
    public function CargarLabRadiologiaRUC($search)
    {
        $result=array();
        $bd= new con_mysqli("", "", "", "");
        
        ##Validar parametros
        $search=$bd->real_scape_string($search);
    
        $consulta="SELECT * FROM `labradiologia` WHERE `ruc` LIKE '%$search%'";
        $r=$bd->consulta($consulta);
        if($r)
        {
            $a=0;
            while ($fila=$bd->fetch_assoc($r))
            {
                $bd_nombre=$fila["nombrelabradiologia"];
                $bd_ruc=$fila["ruc"];
                $result[$a]="($bd_nombre) ".$bd_ruc;
                $a++;
            }
        }
        $bd->Close();
    
        return $result;
    }
}

<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of NombreRadiologiaController
 *
 * @author MARGOTH TAPIA
 */

include '../modelo/NombreRadiologia.php';

class NombreRadiologiaController {
    
    public function NombreRadiologiaController(){}
    
public function CrearNombreRadiologia($p_nombre, $p_tipo)
{
    $affected=0;
    $bd=new con_mysqli("", "", "", "");
    
    ##Validar Iny Sql
        $p_nombre=$bd->real_scape_string($p_nombre);
        $p_tipo=$bd->real_scape_string($p_tipo);
        
        $consulta="INSERT INTO `nombreradiologia` (`nombreradiologia`, `idtiporadiologia`) VALUES ('$p_nombre', '$p_tipo')";
        
        $r=$bd->consulta($consulta);
        if($r)
        {
            $affected=$bd->affected_row();
        }
        $bd->Close();
        return $affected;
        
}

public function ModificarNombreRadiologia($p_id, $p_nombre, $p_tipo)
    {
        $affected=0;
        $bd=new con_mysqli("", "", "", "");
        
        ##Validar Iny Sql
        $p_id=$bd->real_scape_string($p_id);
        $p_nombre=$bd->real_scape_string($p_nombre);
        $p_tipo=$bd->real_scape_string($p_tipo);
        
        $consulta="UPDATE `nombreradiologia` SET `nombreradiologia`='$p_nombre', `idtiporadiologia`='$p_tipo' WHERE (`idnombreradiologia`='$p_id')";
        
        $r=$bd->consulta($consulta);
        if($r)
        {
            $affected=$bd->affected_row();
            if($affected==0){$affected=1;}
        }
        $bd->Close();
        return $affected;
    }
    
    public function EliminarNombreRadiologia($p_id)
    {
        $affected=0;
        $bd=new con_mysqli("", "", "", "");
        
        ##Validar Iny Sql
        $p_id=$bd->real_scape_string($p_id);
        
        $consulta="DELETE FROM `nombreradiologia` WHERE (`idnombreradiologia`='$p_id')";
        
        $r=$bd->consulta($consulta);
        if($r)
        {
            $affected=$bd->affected_row();
        }
        $bd->Close();
        return $affected;
        
    }
    
    public function MostrarNombreRadiologia()
    {
        $result=array();
        $bd= new con_mysqli("", "", "", "");
        $consulta="SELECT * FROM `nombreradiologia` order by `nombreradiologia` ASC";
        $r=$bd->consulta($consulta);
        if($r)
        {
            $a=0;
            while ($fila=$bd->fetch_assoc($r))
            {
               
                $p_id=$fila["idnombreradiologia"];
                $p_nombre=$fila["nombreradiologia"];
                $p_tipo=$fila["idtiporadiologia"];
                                
                $objNombreRadiologia=new NombreRadiologia($p_id, $p_nombre, $p_tipo);
                $result[$a]=$objNombreRadiologia;
                $a++;
            }
        }
        $bd->Close();
        return $result;
    }
    
    public function BuscarNombreRadiologia($p_id, $p_nombre, $p_tipo)
    {
        $result=array();
        $bd= new con_mysqli("", "", "", "");
        $consulta="SELECT * FROM `nombreradiologia` ";
        
        if($p_id!="")
        {
            $consulta=$consulta."WHERE `idnombreradiologia`='$p_id'";
        }
        if($p_nombre!="")
        {
            if($p_id=="")
            {
                $consulta=$consulta."WHERE `nombreradiologia`='$p_nombre'";
            }
            else 
            {
                $consulta=$consulta." and `nombreradiologia`='$p_nombre'";
            }
        }
        if($p_tipo!="")
        {
            if($p_id=="" && $p_nombre=="" )
            {
                $consulta=$consulta."WHERE `idtiporadiologia`='$p_tipo'";
            }
            else 
            {
                $consulta=$consulta." and `idtiporadiologia`='$p_tipo'";
            }
         }
         
        
        $consulta=$consulta." order by `nombreradiologia` ASC";
        $r=$bd->consulta($consulta);
        if($r)
        {
            $a=0;
            while ($fila=$bd->fetch_assoc($r))
            {
                 
                $p_id=$fila["idnombreradiologia"];
                $p_nombre=$fila["nombreradiologia"];
                $p_tipo=$fila["idtiporadiologia"];
                                
                $objNombreRadiologia=new NombreRadiologia($p_id, $p_nombre, $p_tipo);
                $result[$a]=$objNombreRadiologia;
                $a++;
            }
        }
        $bd->Close();
        return $result;
        
    }
    
    public function CargarNombreRadiologia($search)
    {
        $result=array();
        $bd= new con_mysqli("", "", "", "");
        
        ##Validar parametros
        $search=$bd->real_scape_string($search);
        
        $consulta="SELECT * FROM `nombreradiologia` WHERE `nombreradiologia` LIKE '%$search%'";
        $r=$bd->consulta($consulta);
        if($r)
        {
            $a=0;
            while ($fila=$bd->fetch_assoc($r))
            {
                $bd_nombre=$fila["nombreradiologia"];
                $result[$a]=$bd_nombre;
                $a++;
            }
        }
        $bd->Close();
        
        return $result;
    }
    public function CargarNombreRadiologiaID($search)
    {
        $result=array();
        $bd= new con_mysqli("", "", "", "");
        
        ##Validar parametros
        $search=$bd->real_scape_string($search);
    
        $consulta="SELECT * FROM `nombreradiologia` WHERE `idnombreradiologia` LIKE '%$search%'";
        $r=$bd->consulta($consulta);
        if($r)
        {
            $a=0;
            while ($fila=$bd->fetch_assoc($r))
            {
                $bd_nombre=$fila["nombreradiologia"];
                $bd_idnombreradiologia=$fila["idnombreradiologia"];
                $result[$a]="($bd_nombre) ".$bd_idnombreradiologia;
                $a++;
            }
        }
        $bd->Close();
    
        return $result;
    }
}

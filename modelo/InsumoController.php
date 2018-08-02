<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of InsumoController
 *
 * @author MARGOTH TAPIA
 */

include '../Modelo/Insumos.php';

class InsumoController {
    
        public function InsumoController(){}
    
public function CrearInsumo($p_nombre, $p_preciounitario)
{
    $affected=0;
    $bd=new con_mysqli("", "", "", "");
    
    ##Validar Iny Sql
        $p_nombre=$bd->real_scape_string($p_nombre);
        $p_preciounitario=$bd->real_scape_string($p_preciounitario);
        
        $consulta="INSERT INTO `insumo` (`nombre`, `preciounitario`) VALUES ('$p_nombre', '$p_preciounitario')";
        
        $r=$bd->consulta($consulta);
        if($r)
        {
            $affected=$bd->affected_row();
        }
        $bd->Close();
        return $affected;
        
}

public function ModificarInsumo($p_id, $p_nombre, $p_preciounitario)
    {
        $affected=0;
        $bd=new con_mysqli("", "", "", "");
        
        ##Validar Iny Sql
        $p_id=$bd->real_scape_string($p_id);
        $p_nombre=$bd->real_scape_string($p_nombre);
        $p_preciounitario=$bd->real_scape_string($p_preciounitario);
        
        $consulta="UPDATE `insumo` SET `nombre`='$p_nombre', `preciounitario`='$p_preciounitario' WHERE (`idinsumo`='$p_id')";
        
        $r=$bd->consulta($consulta);
        if($r)
        {
            $affected=$bd->affected_row();
            if($affected==0){$affected=1;}
        }
        $bd->Close();
        return $affected;
    }
    
    public function EliminarInsumo($p_id)
    {
        $affected=0;
        $bd=new con_mysqli("", "", "", "");
        
        ##Validar Iny Sql
        $p_id=$bd->real_scape_string($p_id);
        
        $consulta="DELETE FROM `insumo` WHERE (`idinsumo`='$p_id')";
        
        $r=$bd->consulta($consulta);
        if($r)
        {
            $affected=$bd->affected_row();
        }
        $bd->Close();
        return $affected;
        
    }
    
    public function MostrarInsumo()
    {
        $result=array();
        $bd= new con_mysqli("", "", "", "");
        $consulta="SELECT * FROM `insumo` order by `nombre` ASC";
        $r=$bd->consulta($consulta);
        if($r)
        {
            $a=0;
            while ($fila=$bd->fetch_assoc($r))
            {
               
                $p_id=$fila["idinsumo"];
                $p_nombre=$fila["nombre"];
                $p_preciounitario=$fila["preciounitario"];
                                
                $objInsumo=new Insumos($p_id, $p_nombre, $p_preciounitario);
                $result[$a]=$objInsumo;
                $a++;
            }
        }
        $bd->Close();
        return $result;
    }
    
    public function BuscarInsumo($p_id, $p_nombre, $p_preciounitario)
    {
        $result=array();
        $bd= new con_mysqli("", "", "", "");
        $consulta="SELECT * FROM `insumo` ";
        
        if($p_id!="")
        {
            $consulta=$consulta."WHERE `idinsumo`='$p_id'";
        }
        if($p_nombre!="")
        {
            if($p_id=="")
            {
                $consulta=$consulta."WHERE `nombre`='$p_nombre'";
            }
            else 
            {
                $consulta=$consulta." and `nombre`='$p_nombre'";
            }
        }
        if($p_preciounitario!="")
        {
            if($p_id=="" && $p_nombre=="" )
            {
                $consulta=$consulta."WHERE `preciounitario`='$p_preciounitario'";
            }
            else 
            {
                $consulta=$consulta." and `preciounitario`='$p_preciounitario'";
            }
         }
         
        
        $consulta=$consulta." order by `nombre` ASC";
        $r=$bd->consulta($consulta);
        if($r)
        {
            $a=0;
            while ($fila=$bd->fetch_assoc($r))
            {
                 
                $p_id=$fila["idinsumo"];
                $p_nombre=$fila["nombre"];
                $p_preciounitario=$fila["preciounitario"];
                                
                $objInsumo=new Insumos($p_id, $p_nombre, $p_preciounitario);
                $result[$a]=$objInsumo;
                $a++;
            }
        }
        $bd->Close();
        return $result;
        
    }
    
    public function CargarInsumo($search)
    {
        $result=array();
        $bd= new con_mysqli("", "", "", "");
        
        ##Validar parametros
        $search=$bd->real_scape_string($search);
        
        $consulta="SELECT * FROM `insumo` WHERE `nombre` LIKE '%$search%'";
        $r=$bd->consulta($consulta);
        if($r)
        {
            $a=0;
            while ($fila=$bd->fetch_assoc($r))
            {
                $bd_nombre=$fila["nombre"];
                $result[$a]=$bd_nombre;
                $a++;
            }
        }
        $bd->Close();
        
        return $result;
    }
    public function CargarInsumoID($search)
    {
        $result=array();
        $bd= new con_mysqli("", "", "", "");
        
        ##Validar parametros
        $search=$bd->real_scape_string($search);
    
        $consulta="SELECT * FROM `insumo` WHERE `idinsumo` LIKE '%$search%'";
        $r=$bd->consulta($consulta);
        if($r)
        {
            $a=0;
            while ($fila=$bd->fetch_assoc($r))
            {
                $bd_nombre=$fila["nombre"];
                $bd_idinsumo=$fila["idinsumo"];
                $result[$a]="($bd_nombre) ".$bd_idinsumo;
                $a++;
            }
        }
        $bd->Close();
    
        return $result;
    }
}

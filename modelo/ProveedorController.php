<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of ProveedorController
 *
 * @author MARGOTH TAPIA
 */

include '../Modelo/Proveedor.php';

class ProveedorController {
    
    public function ProveedorController(){}
    
public function CrearProveedor($p_nombre, $p_ruc)
{
    $affected=0;
    $bd=new con_mysqli("", "", "", "");
    
    ##Validar Iny Sql
        $p_nombre=$bd->real_scape_string($p_nombre);
        $p_ruc=$bd->real_scape_string($p_ruc);
        
        $consulta="INSERT INTO `proveedor` (`nombre`, `ruc`) VALUES ('$p_nombre', '$p_ruc')";
        
        $r=$bd->consulta($consulta);
        if($r)
        {
            $affected=$bd->affected_row();
        }
        $bd->Close();
        return $affected;
        
}

public function ModificarProveedor($p_id,$p_nombre,$p_ruc)
    {
        $affected=0;
        $bd=new con_mysqli("", "", "", "");
        
        ##Validar Iny Sql
        $p_id=$bd->real_scape_string($p_id);
        $p_nombre=$bd->real_scape_string($p_nombre);
        $p_ruc=$bd->real_scape_string($p_ruc);
        
        $consulta="UPDATE `proveedor` SET `nombre`='$p_nombre', `ruc`='$p_ruc' WHERE (`idproveedor`='$p_id')";
        
        $r=$bd->consulta($consulta);
        if($r)
        {
            $affected=$bd->affected_row();
            if($affected==0){$affected=1;}
        }
        $bd->Close();
        return $affected;
    }
    
    public function EliminarProveedor($p_id)
    {
        $affected=0;
        $bd=new con_mysqli("", "", "", "");
        
        ##Validar Iny Sql
        $p_id=$bd->real_scape_string($p_id);
        
        $consulta="DELETE FROM `proveedor` WHERE (`idproveedor`='$p_id')";
        
        $r=$bd->consulta($consulta);
        if($r)
        {
            $affected=$bd->affected_row();
        }
        $bd->Close();
        return $affected;
        
    }
    
    public function MostrarProveedor()
    {
        $result=array();
        $bd= new con_mysqli("", "", "", "");
        $consulta="SELECT * FROM `proveedor` order by `nombre` ASC";
        $r=$bd->consulta($consulta);
        if($r)
        {
            $a=0;
            while ($fila=$bd->fetch_assoc($r))
            {
               
                $p_id=$fila["idproveedor"];
                $p_nombre=$fila["nombre"];
                $p_ruc=$fila["ruc"];
                                
                $objProveedor=new Proveedor($p_id, $p_nombre, $p_ruc);
                $result[$a]=$objProveedor;
                $a++;
            }
        }
        $bd->Close();
        return $result;
    }
    
    public function BuscarProveedor($p_id, $p_nombre, $p_ruc)
    {
        $result=array();
        $bd= new con_mysqli("", "", "", "");
        $consulta="SELECT * FROM `proveedor` ";
        
        if($p_id!="")
        {
            $consulta=$consulta."WHERE `idproveedor`='$p_id'";
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
         
        
        $consulta=$consulta." order by `nombre` ASC";
        $r=$bd->consulta($consulta);
        if($r)
        {
            $a=0;
            while ($fila=$bd->fetch_assoc($r))
            {
                 
                $p_id=$fila["idproveedor"];
                $p_nombre=$fila["nombre"];
                $p_ruc=$fila["ruc"];
                                
                $objProveedor=new Proveedor($p_id, $p_nombre, $p_ruc);
                $result[$a]=$objProveedor;
                $a++;
            }
        }
        $bd->Close();
        return $result;
        
    }
    
    public function CargarProveedor($search)
    {
        $result=array();
        $bd= new con_mysqli("", "", "", "");
        
        ##Validar parametros
        $search=$bd->real_scape_string($search);
        
        $consulta="SELECT * FROM `proveedor` WHERE `nombre` LIKE '%$search%'";
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
    public function CargarProveedorRUC($search)
    {
        $result=array();
        $bd= new con_mysqli("", "", "", "");
        
        ##Validar parametros
        $search=$bd->real_scape_string($search);
    
        $consulta="SELECT * FROM `proveedor` WHERE `ruc` LIKE '%$search%'";
        $r=$bd->consulta($consulta);
        if($r)
        {
            $a=0;
            while ($fila=$bd->fetch_assoc($r))
            {
                $bd_nombre=$fila["nombre"];
                $bd_ruc=$fila["ruc"];
                $result[$a]="($bd_nombre) ".$bd_ruc;
                $a++;
            }
        }
        $bd->Close();
    
        return $result;
    }
}

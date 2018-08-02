<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of InsumoProveedorController
 *
 * @author MARGOTH TAPIA
 */

include '../modelo/InsumoProveedor.php';

class InsumoProveedorController {
    
    public function InsumoProveedorController(){}
    
public function CrearInsumoProveedor($p_idinsumo, $p_idproveedor, $p_cantidad, $p_fechacompra)
{
    $affected=0;
    $bd=new con_mysqli("", "", "", "");
    
    ##Validar Iny Sql
        $p_idinsumo=$bd->real_scape_string($p_idinsumo);
        $p_idproveedor=$bd->real_scape_string($p_idproveedor);
        $p_cantidad=$bd->real_scape_string($p_cantidad);
        $p_fechacompra=$bd->real_scape_string($p_fechacompra);
                
        $consulta="INSERT INTO `insumo_proveedor` (`idinsumo`, `idproveedor`, `cantidadinsumo`, `fechacompra`) VALUES ('$p_idinsumo', '$p_idproveedor', '$p_cantidad', '$p_fechacompra')";
        
        $r=$bd->consulta($consulta);
        if($r)
        {
            $affected=$bd->affected_row();
        }
        $bd->Close();
        return $affected;
        
}

public function ModificarInsumoProveedor($p_id,$p_idinsumo,$p_idproveedor, $p_cantidadinsumo, $p_fechacompra)
    {
        $affected=0;
        $bd=new con_mysqli("", "", "", "");
        
        ##Validar Iny Sql
        $p_id=$bd->real_scape_string($p_id);
        $p_idinsumo=$bd->real_scape_string($p_idinsumo);
        $p_idproveedor=$bd->real_scape_string($p_idproveedor);
        $p_cantidadinsumo=$bd->real_scape_string($p_cantidadinsumo);
        $p_fechacompra=$bd->real_scape_string($p_fechacompra);
                
        $consulta="UPDATE `insumo_proveedor` SET `idinsumo`='$p_idinsumo', `idproveedor`='$p_idproveedor', `cantidadinsumo`='$p_cantidadinsumo', `fechacompra`='$p_fechacompra' WHERE (`idip`='$p_id')";
        
        $r=$bd->consulta($consulta);
        if($r)
        {
            $affected=$bd->affected_row();
            if($affected==0){$affected=1;}
        }
        $bd->Close();
        return $affected;
    }
    
    public function EliminarInsumoProveedor($p_id)
    {
        $affected=0;
        $bd=new con_mysqli("", "", "", "");
        
        ##Validar Iny Sql
        $p_id=$bd->real_scape_string($p_id);
        
        $consulta="DELETE FROM `insumo_proveedor` WHERE (`idip`='$p_id')";
        
        $r=$bd->consulta($consulta);
        if($r)
        {
            $affected=$bd->affected_row();
        }
        $bd->Close();
        return $affected;
        
    }
    
    public function MostrarInsumoProveedor()
    {
        $result=array();
        $bd= new con_mysqli("", "", "", "");
        $consulta="SELECT * FROM `insumo_proveedor` order by `idip` ASC";
        $r=$bd->consulta($consulta);
        if($r)
        {
            $a=0;
            while ($fila=$bd->fetch_assoc($r))
            {
               
                $p_id=$fila["idip"];
                $p_idinsumo=$fila["idinsumo"];
                $p_idproveedor=$fila["idproveedor"];
                $p_cantidadinsumo=$fila["cantidadinsumo"];
                $p_fechacompra=$fila["fechacompra"];
                                                
                $objInsumoProveedor=new InsumoProveedor($p_id, $p_idinsumo, $p_idproveedor, $p_cantidadinsumo, $p_fechacompra);
                $result[$a]=$objInsumoProveedor;
                $a++;
            }
        }
        $bd->Close();
        return $result;
    }
    
    public function BuscarInsumoProveedor($p_id, $p_idinsumo, $p_idproveedor)
    {
        $result=array();
        $bd= new con_mysqli("", "", "", "");
        $consulta="SELECT * FROM `insumo_proveedor` ";
        
        if($p_id!="")
        {
            $consulta=$consulta."WHERE `idip`='$p_id'";
        }
        if($p_idinsumo!="")
        {
            if($p_id=="")
            {
                $consulta=$consulta."WHERE `idinsumo`='$p_idinsumo'";
            }
            else 
            {
                $consulta=$consulta." and `idinsumo`='$p_idinsumo'";
            }
        }   
        if($p_idproveedor!="")
        {
            if($p_id=="" && $p_idinsumo=="")
            {
                $consulta=$consulta."WHERE `idproveedor`='$p_idproveedor'";
            }
            else 
            {
                $consulta=$consulta." and `idproveedor`='$p_idproveedor'";
            }
        }  
        
        $consulta=$consulta." order by `idip` ASC";
        $r=$bd->consulta($consulta);
        if($r)
        {
            $a=0;
            while ($fila=$bd->fetch_assoc($r))
            {
                 
                $p_id=$fila["idip"];
                $p_idinsumo=$fila["idinsumo"];
                $p_idproveedor=$fila["idproveedor"];
                $p_cantidadinsumo=$fila["cantidadinsumo"];
                $p_fechacompra=$fila["fechacompra"];
                                                
                $objInsumoProveedor=new InsumoProveedor($p_id, $p_idinsumo, $p_idproveedor, $p_cantidadinsumo, $p_fechacompra);
                $result[$a]=$objInsumoProveedor;
                $a++;
            }
        }
        $bd->Close();
        return $result;
        
    }
    
    public function CargarInsumoProveedor($search)
    {
        $result=array();
        $bd= new con_mysqli("", "", "", "");
        
        ##Validar parametros
        $search=$bd->real_scape_string($search);
        
        $consulta="SELECT * FROM `insumo_proveedor` WHERE `idip` LIKE '%$search%'";
        $r=$bd->consulta($consulta);
        if($r)
        {
            $a=0;
            while ($fila=$bd->fetch_assoc($r))
            {
                $bd_id=$fila["idip"];
                $result[$a]=$bd_id;
                $a++;
            }
        }
        $bd->Close();
        
        return $result;
    }
}

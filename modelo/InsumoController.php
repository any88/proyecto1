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
    
public function CrearInsumo($p_nombre, $cant_min_almacen,$p_id_cat_almacen)
{
    $affected=0;
    $bd=new con_mysqli("", "", "", "");
    
    ##Validar Iny Sql
        $p_nombre=$bd->real_scape_string($p_nombre);
        $cant_min_almacen=$bd->real_scape_string($cant_min_almacen);
        $p_id_cat_almacen=$bd->real_scape_string($p_id_cat_almacen);
        
        $consulta="INSERT INTO `insumo` (`nombre`, `cant_min_almacen`,`id_categoria_almacen`) VALUES ('$p_nombre', '$cant_min_almacen','$p_id_cat_almacen')";
        
        $r=$bd->consulta($consulta);
        if($r)
        {
            $affected=$bd->affected_row();
        }
        $bd->Close();
        return $affected;
        
}

public function ModificarInsumo($p_id, $p_nombre, $cant_min_almacen,$p_id_cat_almacen)
    {
        $affected=0;
        $bd=new con_mysqli("", "", "", "");
        
        ##Validar Iny Sql
        $p_id=$bd->real_scape_string($p_id);
        $p_nombre=$bd->real_scape_string($p_nombre);
        $cant_min_almacen=$bd->real_scape_string($cant_min_almacen);
        $p_id_cat_almacen=$bd->real_scape_string($p_id_cat_almacen);
        
        $consulta="UPDATE `insumo` SET `nombre`='$p_nombre', `cant_min_almacen`='$cant_min_almacen', `id_categoria_almacen`='$p_id_cat_almacen' WHERE (`idinsumo`='$p_id')";
        
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
                $cant_min_almacen=$fila["cant_min_almacen"];
                $id_categoria_almacen=$fila["id_categoria_almacen"];
                                
                $objInsumo=new Insumos($p_id, $p_nombre, $cant_min_almacen,$id_categoria_almacen);
                $result[$a]=$objInsumo;
                $a++;
            }
        }
        $bd->Close();
        return $result;
    }
    
    public function BuscarInsumo($p_id, $p_nombre, $cant_min_almacen,$id_categoria_almacen=null)
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
        if($cant_min_almacen!="")
        {
            if($p_id=="" && $p_nombre=="" )
            {
                $consulta=$consulta."WHERE `cant_min_almacen`='$cant_min_almacen'";
            }
            else 
            {
                $consulta=$consulta." and `cant_min_almacen`='$cant_min_almacen'";
            }
         }
         if($id_categoria_almacen!="")
        {
            if($p_id=="" && $p_nombre=="" && $cant_min_almacen=="" )
            {
                $consulta=$consulta."WHERE `id_categoria_almacen`='$id_categoria_almacen'";
            }
            else 
            {
                $consulta=$consulta." and `id_categoria_almacen`='$id_categoria_almacen'";
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
                $cant_min_almacen=$fila["cant_min_almacen"];
                $id_cat_almacen=$fila["id_categoria_almacen"];
                                
                $objInsumo=new Insumos($p_id, $p_nombre, $cant_min_almacen,$id_cat_almacen);
                $result[$a]=$objInsumo;
                $a++;
            }
        }
        $bd->Close();
        return $result;
        
    }
    
    
}

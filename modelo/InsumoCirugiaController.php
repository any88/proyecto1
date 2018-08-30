<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of InsumoCirugiaController
 *
 * @author MARGOTH TAPIA
 */

include '../modelo/InsumoCirugia.php';

class InsumoCirugiaController {
    
    public function InsumoCirugiaController(){}
    
public function CrearInsumoCirugia($p_idinsumo, $p_idcirugia, $p_cantidad)
{
    $affected=0;
    $bd=new con_mysqli("", "", "", "");
    
    ##Validar Iny Sql
        $p_idinsumo=$bd->real_scape_string($p_idinsumo);
        $p_idcirugia=$bd->real_scape_string($p_idcirugia);
        $p_cantidad=$bd->real_scape_string($p_cantidad);
                
        $consulta="INSERT INTO `insumo_cirugia` (`idinsumo`, `idcirugia`, `cantidadinsumo`) VALUES ('$p_idinsumo', '$p_idcirugia', '$p_cantidad')";
        
        $r=$bd->consulta($consulta);
        if($r)
        {
            $affected=$bd->affected_row();
        }
        $bd->Close();
        return $affected;
        
}

public function ModificarInsumoCirugia($p_id,$p_idinsumo,$p_idcirugia, $p_cantidadinsumo)
    {
        $affected=0;
        $bd=new con_mysqli("", "", "", "");
        
        ##Validar Iny Sql
        $p_id=$bd->real_scape_string($p_id);
        $p_idinsumo=$bd->real_scape_string($p_idinsumo);
        $p_idcirugia=$bd->real_scape_string($p_idcirugia);
        $p_cantidadinsumo=$bd->real_scape_string($p_cantidadinsumo);
                
        $consulta="UPDATE `insumo_cirugia` SET `idinsumo`='$p_idinsumo', `idcirugia`='$p_idcirugia', `cantidadinsumo`='$p_cantidadinsumo' WHERE (`idic`='$p_id')";
        
        $r=$bd->consulta($consulta);
        if($r)
        {
            $affected=$bd->affected_row();
            if($affected==0){$affected=1;}
        }
        $bd->Close();
        return $affected;
    }
    
    public function EliminarInsumoCirugia($p_id)
    {
        $affected=0;
        $bd=new con_mysqli("", "", "", "");
        
        ##Validar Iny Sql
        $p_id=$bd->real_scape_string($p_id);
        
        $consulta="DELETE FROM `insumo_cirugia` WHERE (`idic`='$p_id')";
        
        $r=$bd->consulta($consulta);
        if($r)
        {
            $affected=$bd->affected_row();
        }
        $bd->Close();
        return $affected;
        
    }
    
    public function MostrarInsumoCirugia()
    {
        $result=array();
        $bd= new con_mysqli("", "", "", "");
        $consulta="SELECT * FROM `insumo_cirugia` order by `id_ins_cirugia` ASC";
        $r=$bd->consulta($consulta);
        if($r)
        {
            $a=0;
            while ($fila=$bd->fetch_assoc($r))
            {
               
                $p_id=$fila["idic"];
                $p_idinsumo=$fila["idinsumo"];
                $p_idcirugia=$fila["idcirugia"];
                $p_cantidadinsumo=$fila["cantidadinsumo"];
                                                
                $objInsumoCirugia=new InsumoCirugia($p_id, $p_idinsumo, $p_idcirugia, $p_cantidadinsumo);
                $result[$a]=$objInsumoCirugia;
                $a++;
            }
        }
        $bd->Close();
        return $result;
    }
    
    public function BuscarInsumoCirugia($p_id, $p_idinsumo, $p_idcirugia)
    {
        $result=array();
        $bd= new con_mysqli("", "", "", "");
        $consulta="SELECT * FROM `insumo_cirugia` ";
        
        if($p_id!="")
        {
            $consulta=$consulta."WHERE `idic`='$p_id'";
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
        if($p_idcirugia!="")
        {
            if($p_id=="" && $p_idinsumo=="")
            {
                $consulta=$consulta."WHERE `idcirugia`='$p_idcirugia'";
            }
            else 
            {
                $consulta=$consulta." and `idcirugia`='$p_idcirugia'";
            }
        }  
        
        $consulta=$consulta." order by `idic` ASC";
        
        $r=$bd->consulta($consulta);
        if($r)
        {
            $a=0;
            while ($fila=$bd->fetch_assoc($r))
            {
                 
                $p_id=$fila["idic"];
                $p_idinsumo=$fila["idinsumo"];
                $p_idcirugia=$fila["idcirugia"];
                $p_cantidadinsumo=$fila["cantidadinsumo"];
                                                
                $objInsumoCirugia=new InsumoCirugia($p_id, $p_idinsumo, $p_idcirugia, $p_cantidadinsumo);
                $result[$a]=$objInsumoCirugia;
                $a++;
            }
        }
        $bd->Close();
        return $result;
        
    }
    
    public function CargarInsumoCirugia($search)
    {
        $result=array();
        $bd= new con_mysqli("", "", "", "");
        
        ##Validar parametros
        $search=$bd->real_scape_string($search);
        
        $consulta="SELECT * FROM `insumo_cirugia` WHERE `id_ins_cirugia` LIKE '%$search%'";
        $r=$bd->consulta($consulta);
        if($r)
        {
            $a=0;
            while ($fila=$bd->fetch_assoc($r))
            {
                $bd_id=$fila["idic"];
                $result[$a]=$bd_id;
                $a++;
            }
        }
        $bd->Close();
        
        return $result;
    }
}

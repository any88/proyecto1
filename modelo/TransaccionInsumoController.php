<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of TransaccionInsumoController
 *
 * @author MARGOTH TAPIA
 */

include '../modelo/TransaccionInsumo.php';

class TransaccionInsumoController {
    
    public function TransaccionInsumoController(){}
    
public function CrearTransaccionInsumo($p_idtransaccion, $p_idinsumo, $p_fecha)
{
    $affected=0;
    $bd=new con_mysqli("", "", "", "");
    
    ##Validar Iny Sql
        $p_idtransaccion=$bd->real_scape_string($p_idtransaccion);
        $p_idinsumo=$bd->real_scape_string($p_idinsumo);
        $p_fecha=$bd->real_scape_string($p_fecha);
                                
        $consulta="INSERT INTO `transaccion_insumo` (`idtransaccion`, `idinsumo`, `fecha`) VALUES ('$p_idtransaccion', '$p_idinsumo', '$p_fecha')";
        
        $r=$bd->consulta($consulta);
        if($r)
        {
            $affected=$bd->affected_row();
        }
        $bd->Close();
        return $affected;
        
}

public function ModificarTransaccionInsumo($p_id,$p_idtransaccion,$p_idinsumo,$p_fecha)
    {
        $affected=0;
        $bd=new con_mysqli("", "", "", "");
        
        ##Validar Iny Sql
        $p_id=$bd->real_scape_string($p_id);
        $p_fecha=$bd->real_scape_string($p_fecha);
        $p_idtransaccion=$bd->real_scape_string($p_idtransaccion);
        $p_idinsumo=$bd->real_scape_string($p_idinsumo);
                       
        $consulta="UPDATE `transaccion_insumo` SET `fecha`='$p_fecha', `idtransaccion`='$p_idtransaccion', `idinsumo`='$p_idinsumo' WHERE (`idti`='$p_id')";
        
        $r=$bd->consulta($consulta);
        if($r)
        {
            $affected=$bd->affected_row();
        }
        $bd->Close();
        return $affected;
    }
    
    public function EliminarTransaccionInsumo($p_id)
    {
        $affected=0;
        $bd=new con_mysqli("", "", "", "");
        
        ##Validar Iny Sql
        $p_id=$bd->real_scape_string($p_id);
        
        $consulta="DELETE FROM `transaccion_insumo` WHERE (`idti`='$p_id')";
        
        $r=$bd->consulta($consulta);
        if($r)
        {
            $affected=$bd->affected_row();
        }
        $bd->Close();
        return $affected;
        
    }
    
    public function MostrarTransaccionInsumo()
    {
        $result=array();
        $bd= new con_mysqli("", "", "", "");
        $consulta="SELECT * FROM `transaccion_insumo` order by `fecha` ASC";
        $r=$bd->consulta($consulta);
        if($r)
        {
            $a=0;
            while ($fila=$bd->fetch_assoc($r))
            {
               
                $p_id=$fila["idti"];
                $p_idtransaccion=$fila["idtransaccion"];
                $p_fecha=$fila["fecha"];
                $p_idinsumo=$fila["idinsumo"];
                                                                                
                $objTransaccionInsumo=new TransaccionInsumo($p_id, $p_idtransaccion, $p_idinsumo, $p_fecha);
                $result[$a]=$objTransaccionInsumo;
                $a++;
            }
        }
        $bd->Close();
        return $result;
    }
    
    public function BuscarTransaccionInsumo($p_idti, $p_idtransaccion, $p_idinsumo)
    {
        $result=array();
        $bd= new con_mysqli("", "", "", "");
        $consulta="SELECT * FROM `transaccion_insumo` ";
        
        if($p_idti!="")
        {
            $consulta=$consulta."WHERE `idti`='$p_idti'";
        }
        if($p_idtransaccion!="")
        {
            if($p_idti=="")
            {
                $consulta=$consulta."WHERE `idtransaccion`='$p_idtransaccion'";
            }
            else 
            {
                $consulta=$consulta." and `idtransaccion`='$p_idtransaccion'";
            }
        }
        if($p_idinsumo!="")
        {
            if($p_idti=="" && $p_idtransaccion=="")
            {
                $consulta=$consulta."WHERE `idinsumo`='$p_idinsumo'";
            }
            else 
            {
                $consulta=$consulta." and `idinsumo`='$p_idinsumo'";
            }
         }
         
        
        $consulta=$consulta." order by `idti` ASC";
        $r=$bd->consulta($consulta);
        if($r)
        {
            $a=0;
            while ($fila=$bd->fetch_assoc($r))
            {
                 
                $p_id=$fila["idti"];
                $p_idtransaccion=$fila["idtransaccion"];
                $p_idinsumo=$fila["idinsumo"];
                $p_fecha=$fila["fecha"];
                                                                                
                $objTransaccionInsumo=new TransaccionInsumo($p_id, $p_idtransaccion, $p_idinsumo, $p_fecha);
                $result[$a]=$objTransaccionInsumo;
                $a++;
            }
        }
        $bd->Close();
        return $result;
        
    }
    
    public function CargarTransaccionInsumoID($search)
    {
        $result=array();
        $bd= new con_mysqli("", "", "", "");
        
        ##Validar parametros
        $search=$bd->real_scape_string($search);
        
        $consulta="SELECT * FROM `transaccion_insumo` WHERE `idti` LIKE '%$search%'";
        $r=$bd->consulta($consulta);
        if($r)
        {
            $a=0;
            while ($fila=$bd->fetch_assoc($r))
            {
                $bd_id=$fila["idti"];
                $result[$a]=$bd_id;
                $a++;
            }
        }
        $bd->Close();
        
        return $result;
    }
    public function CargarTransaccionInsumo($search)
    {
        $result=array();
        $bd= new con_mysqli("", "", "", "");
        
        ##Validar parametros
        $search=$bd->real_scape_string($search);
    
        $consulta="SELECT * FROM `transaccion_insumo` WHERE `idti` LIKE '%$search%'";
        $r=$bd->consulta($consulta);
        if($r)
        {
            $a=0;
            while ($fila=$bd->fetch_assoc($r))
            {
                $bd_id=$fila["idti"];
                $bd_idtransaccion=$fila["idtransaccion"];
                $bd_idinsumo=$fila["idinsumo"];
                $result[$a]="($bd_id) ".$bd_idtransaccion." ".$bd_idinsumo;
                $a++;
            }
        }
        $bd->Close();
    
        return $result;
    }
}

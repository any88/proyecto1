<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of TransaccionTrabajadorController
 *
 * @author MARGOTH TAPIA
 */

include '../modelo/TransaccionTrabajador.php';

class TransaccionTrabajadorController {
    
    public function TransaccionTrabajadorController(){}
    
public function CrearTransaccionTrabajador($p_idtransaccion, $p_idtrabajador, $p_observaciones)
{
    $affected=0;
    $bd=new con_mysqli("", "", "", "");
    
    ##Validar Iny Sql
        $p_idtransaccion=$bd->real_scape_string($p_idtransaccion);
        $p_idtrabajador=$bd->real_scape_string($p_idtrabajador);
        $p_observaciones=$bd->real_scape_string($p_observaciones);
                                
        $consulta="INSERT INTO `transaccion_trabajador` (`idtransaccion`, `idtrabajador`, `observaciones`) VALUES ('$p_idtransaccion', '$p_idtrabajador', '$p_observaciones')";
        
        $r=$bd->consulta($consulta);
        if($r)
        {
            $affected=$bd->affected_row();
        }
        $bd->Close();
        return $affected;
        
}

public function ModificarTransaccionTrabajador($p_id,$p_idtransaccion,$p_idtrabajador,$p_observaciones)
    {
        $affected=0;
        $bd=new con_mysqli("", "", "", "");
        
        ##Validar Iny Sql
        $p_id=$bd->real_scape_string($p_id);
        $p_observaciones=$bd->real_scape_string($p_observaciones);
        $p_idtransaccion=$bd->real_scape_string($p_idtransaccion);
        $p_idtrabajador=$bd->real_scape_string($p_idtrabajador);
                       
        $consulta="UPDATE `transaccion_trabajador` SET `observaciones`='$p_observaciones', `idtransaccion`='$p_idtransaccion', `idtrabajador`='$p_idtrabajador' WHERE (`idtt`='$p_id')";
        
        $r=$bd->consulta($consulta);
        if($r)
        {
            $affected=$bd->affected_row();
        }
        $bd->Close();
        return $affected;
    }
    
    public function EliminarTransaccionTrabajador($p_id)
    {
        $affected=0;
        $bd=new con_mysqli("", "", "", "");
        
        ##Validar Iny Sql
        $p_id=$bd->real_scape_string($p_id);
        
        $consulta="DELETE FROM `transaccion_trabajador` WHERE (`idtt`='$p_id')";
        
        $r=$bd->consulta($consulta);
        if($r)
        {
            $affected=$bd->affected_row();
        }
        $bd->Close();
        return $affected;
        
    }
    
    public function MostrarTransaccionTrabajador()
    {
        $result=array();
        $bd= new con_mysqli("", "", "", "");
        $consulta="SELECT * FROM `transaccion_trabajador` order by `idtt` ASC";
        $r=$bd->consulta($consulta);
        if($r)
        {
            $a=0;
            while ($fila=$bd->fetch_assoc($r))
            {
               
                $p_id=$fila["idtt"];
                $p_idtransaccion=$fila["idtransaccion"];
                $p_observaciones=$fila["observaciones"];
                $p_idtrabajador=$fila["idtrabajador"];
                                                                                
                $objTransaccionTrabajador=new TransaccionTrabajador($p_id, $p_idtransaccion, $p_idtrabajador, $p_observaciones);
                $result[$a]=$objTransaccionTrabajador;
                $a++;
            }
        }
        $bd->Close();
        return $result;
    }
    
    public function BuscarTransaccionTrabajador($p_idtt, $p_idtransaccion, $p_idtrabajador)
    {
        $result=array();
        $bd= new con_mysqli("", "", "", "");
        $consulta="SELECT * FROM `transaccion_trabajador` ";
        
        if($p_idtt!="")
        {
            $consulta=$consulta."WHERE `idtt`='$p_idtt'";
        }
        if($p_idtransaccion!="")
        {
            if($p_idtt=="")
            {
                $consulta=$consulta."WHERE `idtransaccion`='$p_idtransaccion'";
            }
            else 
            {
                $consulta=$consulta." and `idtransaccion`='$p_idtransaccion'";
            }
        }
        if($p_idtrabajador!="")
        {
            if($p_idtt=="" && $p_idtransaccion=="")
            {
                $consulta=$consulta."WHERE `idtrabajador`='$p_idtrabajador'";
            }
            else 
            {
                $consulta=$consulta." and `idtrabajador`='$p_idtrabajador'";
            }
         }
         
        
        $consulta=$consulta." order by `idtt` ASC";
        $r=$bd->consulta($consulta);
        if($r)
        {
            $a=0;
            while ($fila=$bd->fetch_assoc($r))
            {
                 
                $p_id=$fila["idtt"];
                $p_idtransaccion=$fila["idtransaccion"];
                $p_idtrabajador=$fila["idtrabajador"];
                $p_observaciones=$fila["observaciones"];
                                                                                
                $objTransaccionTrabajador=new TransaccionTrabajador($p_id, $p_idtransaccion, $p_idtrabajador, $p_observaciones);
                $result[$a]=$objTransaccionTrabajador;
                $a++;
            }
        }
        $bd->Close();
        return $result;
        
    }
    
    public function CargarTransaccionTrabajadorID($search)
    {
        $result=array();
        $bd= new con_mysqli("", "", "", "");
        
        ##Validar parametros
        $search=$bd->real_scape_string($search);
        
        $consulta="SELECT * FROM `transaccion_trabajador` WHERE `idtt` LIKE '%$search%'";
        $r=$bd->consulta($consulta);
        if($r)
        {
            $a=0;
            while ($fila=$bd->fetch_assoc($r))
            {
                $bd_id=$fila["idtt"];
                $result[$a]=$bd_id;
                $a++;
            }
        }
        $bd->Close();
        
        return $result;
    }
    public function CargarTransaccionTrabajador($search)
    {
        $result=array();
        $bd= new con_mysqli("", "", "", "");
        
        ##Validar parametros
        $search=$bd->real_scape_string($search);
    
        $consulta="SELECT * FROM `transaccion_trabajador` WHERE `idtt` LIKE '%$search%'";
        $r=$bd->consulta($consulta);
        if($r)
        {
            $a=0;
            while ($fila=$bd->fetch_assoc($r))
            {
                $bd_id=$fila["idtt"];
                $bd_idtransaccion=$fila["idtransaccion"];
                $bd_idtrabajador=$fila["idtrabajador"];
                $result[$a]="($bd_id) ".$bd_idtransaccion." ".$bd_idtrabajador;
                $a++;
            }
        }
        $bd->Close();
    
        return $result;
    }
}

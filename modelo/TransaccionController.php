<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of TransaccionController
 *
 * @author MARGOTH TAPIA
 */

include '../Modelo/Transaccion.php';

class TransaccionController {
    
    public function TransaccionController(){}
    
public function CrearTransaccion($p_tipo, $p_fecha, $p_monto, $p_motivo,$f_pago)
{
    $affected=0;
    $bd=new con_mysqli("", "", "", "");
    
    ##Validar Iny Sql
        $p_tipo=$bd->real_scape_string($p_tipo);
        $p_fecha=$bd->real_scape_string($p_fecha);
        $p_monto=$bd->real_scape_string($p_monto);
        $p_motivo=$bd->real_scape_string($p_motivo);
        $f_pago=$bd->real_scape_string($f_pago);
                        
        $consulta="INSERT INTO `transaccion` (`tipotransaccion`, `fecha`, `monto`, `motivo`,`forma_pago`) VALUES ('$p_tipo', '$p_fecha', '$p_monto', '$p_motivo','$f_pago')";
        
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

public function ModificarTransaccion($p_id,$p_tipo,$p_fecha,$p_monto,$p_motivo,$fpago)
    {
        $affected=0;
        $bd=new con_mysqli("", "", "", "");
        
        ##Validar Iny Sql
        $p_tipo=$bd->real_scape_string($p_tipo);
        $p_fecha=$bd->real_scape_string($p_fecha);
        $p_monto=$bd->real_scape_string($p_monto);
        $p_motivo=$bd->real_scape_string($p_motivo);
        $fpago=$bd->real_scape_string($fpago);
               
        $consulta="UPDATE `transaccion` SET `tipotransaccion`='$p_tipo', `fecha`='$p_fecha', `monto`='$p_monto', `motivo`='$p_motivo' ,`forma_pago`='$fpago' WHERE (`idtransaccion`='$p_id')";
        
        $r=$bd->consulta($consulta);
        if($r)
        {
            $affected=$bd->affected_row();
        }
        $bd->Close();
        return $affected;
    }
    
    public function EliminarTransaccion($p_id)
    {
        $affected=0;
        $bd=new con_mysqli("", "", "", "");
        
        ##Validar Iny Sql
        $p_id=$bd->real_scape_string($p_id);
        
        $consulta="DELETE FROM `transaccion` WHERE (`idtransaccion`='$p_id')";
        
        $r=$bd->consulta($consulta);
        if($r)
        {
            $affected=$bd->affected_row();
        }
        $bd->Close();
        return $affected;
        
    }
    
    public function MostrarTransaccion()
    {
        $result=array();
        $bd= new con_mysqli("", "", "", "");
        $consulta="SELECT * FROM `transaccion` order by `fecha` ASC";
        $r=$bd->consulta($consulta);
        if($r)
        {
            $a=0;
            while ($fila=$bd->fetch_assoc($r))
            {
               
                $p_id=$fila["idtransaccion"];
                $p_tipo=$fila["tipotransaccion"];
                $p_fecha=$fila["fecha"];
                $p_monto=$fila["monto"];
                $p_motivo=$fila["motivo"];
                $forma_pago=$fila["forma_pago"];
                                                                
                $objTransaccion=new Transaccion($p_id, $p_tipo, $p_fecha, $p_monto, $p_motivo,$forma_pago);
                $result[$a]=$objTransaccion;
                $a++;
            }
        }
        $bd->Close();
        return $result;
    }
    
    public function BuscarTransaccionPorId($id_transaccion)
    {
        $result=array();
        $bd= new con_mysqli("", "", "", "");
        $consulta="SELECT * FROM `transaccion` WHERE `idtransaccion`='$id_transaccion'";
        $r=$bd->consulta($consulta);
        if($r)
        {
            $a=0;
            while ($fila=$bd->fetch_assoc($r))
            {
                 
                $p_id=$fila["idtransaccion"];
                $p_tipotransaccion=$fila["tipotransaccion"];
                $p_fecha=$fila["fecha"];
                $p_monto=$fila["monto"];
                $p_motivo=$fila["motivo"];
                $forma_pago=$fila["forma_pago"];
                                                                
                $objTransaccion=new Transaccion($p_id, $p_tipotransaccion, $p_fecha, $p_monto, $p_motivo,$forma_pago);
                $result[$a]=$objTransaccion;
                $a++;
            }
        }
        $bd->Close();
        return $result;
        
    }

    public function BuscarTransaccion($p_idtransaccion, $p_fecha, $p_monto)
    {
        $result=array();
        $bd= new con_mysqli("", "", "", "");
        $consulta="SELECT * FROM `transaccion` ";
        
        if($p_idtransaccion!="")
        {
            $consulta=$consulta."WHERE `idtransaccion`='$p_idtransaccion'";
        }
        if($p_fecha!="")
        {
            if($p_idtransaccion=="")
            {
                $consulta=$consulta."WHERE `fecha`='$p_fecha'";
            }
            else 
            {
                $consulta=$consulta." and `fecha`='$p_fecha'";
            }
        }
        if($p_monto!="")
        {
            if($p_idtransaccion=="" && $p_fecha=="")
            {
                $consulta=$consulta."WHERE `monto`='$p_monto'";
            }
            else 
            {
                $consulta=$consulta." and `monto`='$p_monto'";
            }
         }
         
        
        $consulta=$consulta." order by `fecha` ASC";
       
        $r=$bd->consulta($consulta);
        if($r)
        {
            $a=0;
            while ($fila=$bd->fetch_assoc($r))
            {
                 
                $p_id=$fila["idtransaccion"];
                $p_tipotransaccion=$fila["tipotransaccion"];
                $p_fecha=$fila["fecha"];
                $p_monto=$fila["monto"];
                $p_motivo=$fila["motivo"];
                $forma_pago=$fila["forma_pago"];
                                                                
                $objTransaccion=new Transaccion($p_id, $p_tipotransaccion, $p_fecha, $p_monto, $p_motivo,$forma_pago);
                $result[$a]=$objTransaccion;
                $a++;
            }
        }
        $bd->Close();
        return $result;
        
    }
    
    public function CargarTransaccionID($search)
    {
        $result=array();
        $bd= new con_mysqli("", "", "", "");
        
        ##Validar parametros
        $search=$bd->real_scape_string($search);
        
        $consulta="SELECT * FROM `transaccion` WHERE `idtransaccion` LIKE '%$search%'";
        $r=$bd->consulta($consulta);
        if($r)
        {
            $a=0;
            while ($fila=$bd->fetch_assoc($r))
            {
                $bd_transaccion=$fila["idtransaccion"];
                $result[$a]=$bd_transaccion;
                $a++;
            }
        }
        $bd->Close();
        
        return $result;
    }
    public function CargarTransaccion($search)
    {
        $result=array();
        $bd= new con_mysqli("", "", "", "");
        
        ##Validar parametros
        $search=$bd->real_scape_string($search);
    
        $consulta="SELECT * FROM `transaccion` WHERE `idtransaccion` LIKE '%$search%'";
        $r=$bd->consulta($consulta);
        if($r)
        {
            $a=0;
            while ($fila=$bd->fetch_assoc($r))
            {
                $bd_idtransaccion=$fila["idtransaccion"];
                $bd_tipo=$fila["tipotransaccion"];
                $bd_monto=$fila["monto"];
                $result[$a]="($bd_nombre) ".$bd_tipo." ".$bd_monto;
                $a++;
            }
        }
        $bd->Close();
    
        return $result;
    }
}

<?php

include 'LogCaja.php';
class LogCajaController
{
    public function LogCajaController(){}
    ##$accion="1" para Ingreso o $accion="0" para Extraccion
    public function NuevoLogcaja($accion, $motivo, $cantidad, $fecha, $id_usuario,$nombre_entrega)
   {
     $affected=0;
     $bd=new con_mysqli("", "", "", "");
     $accion=$bd->real_scape_string($accion);
     $cantidad=$bd->real_scape_string($cantidad);
     $fecha=$bd->real_scape_string($fecha);
     $id_usuario=$bd->real_scape_string($id_usuario);
     $motivo=$bd->real_scape_string($motivo);
     $nombre_entrega=$bd->real_scape_string($nombre_entrega);
     
     $consulta="INSERT INTO `log_caja` (`id_usuario`, `accion`, `motivo`, `cantidad`, `fecha`,`nombre_entrega`) "
             . "VALUES ('$id_usuario', '$accion', '$motivo', '$cantidad', '$fecha','$nombre_entrega')";
     $r=$bd->consulta($consulta);
        if($r)
        {
            $affected=$bd->affected_row();
            $consulta="SELECT LAST_INSERT_ID()";
                $r=$bd->consulta($consulta);
                if($r)
                {
                    $fila=$bd->fetch_array($r);
                    $affected=$fila[0];
                }
            
        }
        $bd->Close();
        return $affected;
        
   }
   public function ModificarLogCaja($accion, $motivo, $cantidad, $fecha, $id_usuario,$id_log_caja,$nombre_entrega)
    {
        $affected=0;
        $bd=new con_mysqli("", "", "", "");
        
        ##Validar Iny Sql
        $accion=$bd->real_scape_string($accion);
        $cantidad=$bd->real_scape_string($cantidad);
        $fecha=$bd->real_scape_string($fecha);
        $id_usuario=$bd->real_scape_string($id_usuario);
        $motivo=$bd->real_scape_string($motivo);
        $id_log_caja=$bd->real_scape_string($id_log_caja);
        $nombre_entrega=$bd->real_scape_string($nombre_entrega);
                       
        $consulta="UPDATE `log_caja` SET `id_usuario`='$id_usuario', `accion`='$accion', `motivo`='$motivo', `cantidad`='$cantidad', `fecha`='$fecha',`nombre_entrega`='$nombre_entrega' WHERE (`id_log_caja`='$id_log_caja')";
        //Mostrar($consulta);
        $r=$bd->consulta($consulta);
        if($r)
        {
            $affected=$bd->affected_row();
        }
        $bd->Close();
        return $affected;
    }
    
    public function EliminarConsulta($p_id)
    {
        $affected=0;
        $bd=new con_mysqli("", "", "", "");
        
        ##Validar Iny Sql
        $p_id=$bd->real_scape_string($p_id);
        
        $consulta="DELETE FROM `log_caja` WHERE (`id_log_caja`='$p_id')";
        
        $r=$bd->consulta($consulta);
        if($r)
        {
            $affected=$bd->affected_row();
        }
        $bd->Close();
        return $affected;
        
    }
    public function MostrarConsulta()
    {
        $result=array();
        $bd= new con_mysqli("", "", "", "");
        $consulta="SELECT * FROM `log_caja` order by `fecha` ASC";
        $r=$bd->consulta($consulta);
        if($r)
        {
            $a=0;
            while ($fila=$bd->fetch_assoc($r))
            {
               
                $accion=$fila["accion"];
                $cantidad=$fila["cantidad"];
                $fecha=$fila["fecha"];
                $id_usuario=$fila["id_usuario"];
                $motivo=$fila["motivo"];
                $id_log_caja=$fila["id_log_caja"];
                $nombre_entrega=$fila['nombre_entrega'];
                $objLogCaja=new LogCaja($id_log_caja, $accion, $motivo, $cantidad, $fecha, $id_usuario,$nombre_entrega);
                $result[$a]=$objLogCaja;
                $a++;
            }
        }
        $bd->Close();
        return $result;
    }
    public function BuscarLogCaja($accion,$fecha, $id_usuario,$id_log_caja)
    {
        $result=array();
        $bd= new con_mysqli("", "", "", "");
        $consulta="SELECT * FROM `log_caja` ";
        
        if($id_log_caja!="")
        {
            $consulta=$consulta."WHERE `id_log_caja`='$id_log_caja'";
        }
        if($accion!="")
        {
            if($id_log_caja=="")
            {
                $consulta=$consulta."WHERE `accion`='$accion'";
            }
            else 
            {
                $consulta=$consulta." and `accion`='$accion'";
            }
        }       
        if($fecha!="")
        {
            if($id_log_caja=="" && $accion=="")
            {
                $consulta=$consulta."WHERE `fecha`='$fecha'";
            }
            else 
            {
                $consulta=$consulta." and `fecha`='$fecha'";
            }
        }
        if($id_usuario!="")
        {
            if($id_log_caja=="" && $accion=="" && $fecha=="")
            {
                $consulta=$consulta."WHERE `id_usuario`='$id_usuario'";
            }
            else 
            {
                $consulta=$consulta." and `id_usuario`='$id_usuario'";
            }
        }
        $consulta=$consulta." order by `fecha` ASC";
        //Mostrar($consulta);
        $r=$bd->consulta($consulta);
        if($r)
        {
            $a=0;
            while ($fila=$bd->fetch_assoc($r))
            {
                $accion=$fila["accion"];
                $cantidad=$fila["cantidad"];
                $fecha=$fila["fecha"];
                $id_usuario=$fila["id_usuario"];
                $motivo=$fila["motivo"];
                $id_log_caja=$fila["id_log_caja"];
                $nombre_entrega=$fila['nombre_entrega'];
                $objLogCaja=new LogCaja($id_log_caja, $accion, $motivo, $cantidad, $fecha, $id_usuario,$nombre_entrega);
                $result[$a]=$objLogCaja;
                $a++;
            }
        }
        $bd->Close();
        return $result;
        
    }
}


<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of PacienteServicioController
 *
 * @author MARGOTH TAPIA
 */

include '../modelo/PacienteServicio.php';

class PacienteServicioController {
    
    public function PacienteServicioController(){}
    
public function CrearPacienteServicio($p_idpaciente, $p_idservicio, $p_fecha, $p_idtransaccion,$p_hora=null)
{
    $affected=0;
    $bd=new con_mysqli("", "", "", "");
    
    ##Validar Iny Sql
        $p_idpaciente=$bd->real_scape_string($p_idpaciente);
        $p_idservicio=$bd->real_scape_string($p_idservicio);
        $p_fecha=$bd->real_scape_string($p_fecha);
        $p_idtransaccion=$bd->real_scape_string($p_idtransaccion);
        $p_hora=$bd->real_scape_string($p_hora);
                        
        $consulta="INSERT INTO `paciente_servicio` (`idpaciente`, `idservicio`, `fecha`, `idtransaccion`,`hora`) VALUES ('$p_idpaciente', '$p_idservicio', '$p_fecha', '$p_idtransaccion','$p_hora')";
        
        $r=$bd->consulta($consulta);
        if($r)
        {
            $affected=$bd->affected_row();
        }
        $bd->Close();
        return $affected;
        
}

public function ModificarPacienteServicio($p_id,$p_idpaciente,$p_idservicio,$p_fecha,$p_idtransaccion,$p_hora=null)
    {
        $affected=0;
        $bd=new con_mysqli("", "", "", "");
        
        ##Validar Iny Sql
        $p_id=$bd->real_scape_string($p_id);
        $p_fecha=$bd->real_scape_string($p_fecha);
        $p_idpaciente=$bd->real_scape_string($p_idpaciente);
        $p_idservicio=$bd->real_scape_string($p_idservicio);
        $p_idtransaccion=$bd->real_scape_string($p_idtransaccion);
        $p_hora=$bd->real_scape_string($p_hora);
        
        $consulta="UPDATE `paciente_servicio` SET `fecha`='$p_fecha', `idpaciente`='$p_idpaciente', `idservicio`='$p_idservicio', `idtransaccion`='$p_idtransaccion',`hora`='$p_hora' WHERE (`id_ps`='$p_id')";
        
        $r=$bd->consulta($consulta);
        if($r)
        {
            $affected=$bd->affected_row();
        }
        $bd->Close();
        return $affected;
    }
    public function EfectuarPago($id_ps,$id_transaccion)
    {
        $affected=0;
        $bd=new con_mysqli("", "", "", "");
        
        ##Validar Iny Sql
        $id_ps=$bd->real_scape_string($id_ps);
        $id_transaccion=$bd->real_scape_string($id_transaccion);
       
               
        $consulta="UPDATE `paciente_servicio` SET `idtransaccion`='$id_transaccion' WHERE (`id_ps`='$id_ps')";
        
        $r=$bd->consulta($consulta);
        if($r)
        {
            $affected=$bd->affected_row();
        }
        $bd->Close();
        return $affected;
    }

    public function ModificarFechaporIdServicio($p_idservicio,$p_fecha)
    {
        $affected=0;
        $bd=new con_mysqli("", "", "", "");
        
        ##Validar Iny Sql
        $p_fecha=$bd->real_scape_string($p_fecha);
        $p_idservicio=$bd->real_scape_string($p_idservicio);
       
               
        $consulta="UPDATE `paciente_servicio` SET `fecha`='$p_fecha' WHERE (`idservicio`='$p_idservicio')";
        
        $r=$bd->consulta($consulta);
        if($r)
        {
            $affected=$bd->affected_row();
        }
        $bd->Close();
        return $affected;
    }
    
    public function EliminarPacienteServicio($p_id)
    {
        $affected=0;
        $bd=new con_mysqli("", "", "", "");
        
        ##Validar Iny Sql
        $p_id=$bd->real_scape_string($p_id);
        
        $consulta="DELETE FROM `paciente_servicio` WHERE (`id_ps`='$p_id')";
        
        $r=$bd->consulta($consulta);
        if($r)
        {
            $affected=$bd->affected_row();
        }
        $bd->Close();
        return $affected;
        
    }
    
    public function MostrarPacienteServicio()
    {
        $result=array();
        $bd= new con_mysqli("", "", "", "");
        $consulta="SELECT * FROM `paciente_servicio` order by `fecha` ASC";
        $r=$bd->consulta($consulta);
        if($r)
        {
            $a=0;
            while ($fila=$bd->fetch_assoc($r))
            {
               
                $p_id=$fila["id_ps"];
                $p_idpaciente=$fila["idpaciente"];
                $p_fecha=$fila["fecha"];
                $p_idservicio=$fila["idservicio"];
                $p_idtransaccion=$fila["idtransaccion"];
                $p_hora=$fila["hora"];                                                
                $objPacienteServicio=new PacienteServicio($p_id, $p_idpaciente, $p_idservicio, $p_fecha, $p_idtransaccion,$p_hora);
                $result[$a]=$objPacienteServicio;
                $a++;
            }
        }
        $bd->Close();
        return $result;
    }
    
    public function BuscarPacienteServicio($p_id_ps, $p_idpaciente, $p_idservicio,$p_fecha=null)
    {
        $result=array();
        $bd= new con_mysqli("", "", "", "");
        $consulta="SELECT * FROM `paciente_servicio` ";
        
        if($p_id_ps!="")
        {
            $consulta=$consulta."WHERE `id_ps`='$p_id_ps'";
        }
        if($p_idpaciente!="")
        {
            if($p_id_ps=="")
            {
                $consulta=$consulta."WHERE `idpaciente`='$p_idpaciente'";
            }
            else 
            {
                $consulta=$consulta." and `idpaciente`='$p_idpaciente'";
            }
        }
        if($p_idservicio!="")
        {
            if($p_id_ps=="" && $p_idpaciente=="")
            {
                $consulta=$consulta."WHERE `idservicio`='$p_idservicio'";
            }
            else 
            {
                $consulta=$consulta." and `idservicio`='$p_idservicio'";
            }
         }
         if($p_fecha!="")
        {
            if($p_id_ps=="" && $p_idpaciente=="" && $p_idservicio=="")
            {
                $consulta=$consulta."WHERE `fecha`='$p_fecha'";
            }
            else 
            {
                $consulta=$consulta." and `fecha`='$p_fecha'";
            }
         }
        
        $consulta=$consulta." order by `id_ps` ASC";
        
        $r=$bd->consulta($consulta);
        if($r)
        {
            $a=0;
            while ($fila=$bd->fetch_assoc($r))
            {
                 
                $p_id=$fila["id_ps"];
                $p_idpaciente=$fila["idpaciente"];
                $p_idservicio=$fila["idservicio"];
                $p_fecha=$fila["fecha"];
                $p_idtransaccion=$fila["idtransaccion"];
                $p_hora=$fila["hora"];                                                
                $objPacienteServicio=new PacienteServicio($p_id, $p_idpaciente, $p_idservicio, $p_fecha, $p_idtransaccion,$p_hora);
                $result[$a]=$objPacienteServicio;
                $a++;
            }
        }
        $bd->Close();
        return $result;
        
    }
    
    public function CargarPacienteServicioID($search)
    {
        $result=array();
        $bd= new con_mysqli("", "", "", "");
        
        ##Validar parametros
        $search=$bd->real_scape_string($search);
        
        $consulta="SELECT * FROM `paciente_servicio` WHERE `id_ps` LIKE '%$search%'";
        $r=$bd->consulta($consulta);
        if($r)
        {
            $a=0;
            while ($fila=$bd->fetch_assoc($r))
            {
                $bd_id=$fila["id_ps"];
                $result[$a]=$bd_id;
                $a++;
            }
        }
        $bd->Close();
        
        return $result;
    }
    public function CargarPacienteServicio($search)
    {
        $result=array();
        $bd= new con_mysqli("", "", "", "");
        
        ##Validar parametros
        $search=$bd->real_scape_string($search);
    
        $consulta="SELECT * FROM `paciente_servicio` WHERE `id_ps` LIKE '%$search%'";
        $r=$bd->consulta($consulta);
        if($r)
        {
            $a=0;
            while ($fila=$bd->fetch_assoc($r))
            {
                $bd_id=$fila["id_ps"];
                $bd_idpaciente=$fila["idpaciente"];
                $bd_idservicio=$fila["idservicio"];
                $result[$a]="($bd_id) ".$bd_idpaciente." ".$bd_idservicio;
                $a++;
            }
        }
        $bd->Close();
    
        return $result;
    }
    
    public function ServiciosDelDia()
    {
       $bd= new con_mysqli("", "", "", "");
       $fecha= FechaYMA();
       
       $consulta="SELECT * FROM `paciente_servicio` WHERE `fecha` = '$fecha' order by `fecha`";
      
       $result=array();
       $a=0;
       $r=$bd->consulta($consulta);
       if($r)
        {
            $a=0;
            while ($fila=$bd->fetch_assoc($r))
            {
                 
                $p_id=$fila["id_ps"];
                $p_idpaciente=$fila["idpaciente"];
                $p_idservicio=$fila["idservicio"];
                $p_fecha=$fila["fecha"];
                $p_idtransaccion=$fila["idtransaccion"];
                $p_hora=$fila["hora"];                                                
                $objPacienteServicio=new PacienteServicio($p_id, $p_idpaciente, $p_idservicio, $p_fecha, $p_idtransaccion,$p_hora);
                $result[$a]=$objPacienteServicio;
                $a++;
            }
        }
        $bd->Close();
        return $result;
        
    }
    public function AgendaClinica($fecha)
    {
       $bd= new con_mysqli("", "", "", "");
       $fecha=$bd->real_scape_string($fecha);
       $consulta="SELECT * FROM `paciente_servicio` WHERE `fecha` LIKE '$fecha%' order by `hora`";
       
       $result=array();
       $a=0;
       $r=$bd->consulta($consulta);
       if($r)
        {
            $a=0;
            while ($fila=$bd->fetch_assoc($r))
            {
                 
                $p_id=$fila["id_ps"];
                $p_idpaciente=$fila["idpaciente"];
                $p_idservicio=$fila["idservicio"];
                $p_fecha=$fila["fecha"];
                $p_idtransaccion=$fila["idtransaccion"];
                $p_hora=$fila["hora"];                                                
                $objPacienteServicio=new PacienteServicio($p_id, $p_idpaciente, $p_idservicio, $p_fecha, $p_idtransaccion,$p_hora);                                                
                
                $result[$a]=$objPacienteServicio;
                $a++;
            }
        }
        $bd->Close();
        return $result;
        
    }
    
    public function CobrosPendientes()
    {
        $bd= new con_mysqli("", "", "", "");
        $consulta="SELECT * FROM `paciente_servicio` WHERE `idtransaccion`='' or  `idtransaccion` IS NULL";
        $result=array();
       $a=0;
       $r=$bd->consulta($consulta);
       if($r)
        {
            $a=0;
            while ($fila=$bd->fetch_assoc($r))
            {
                 
                $p_id=$fila["id_ps"];
                $p_idpaciente=$fila["idpaciente"];
                $p_idservicio=$fila["idservicio"];
                $p_fecha=$fila["fecha"];
                $p_idtransaccion=$fila["idtransaccion"];
                $p_hora=$fila["hora"];                                                
                $objPacienteServicio=new PacienteServicio($p_id, $p_idpaciente, $p_idservicio, $p_fecha, $p_idtransaccion,$p_hora);                                                
                $result[$a]=$objPacienteServicio;
                $a++;
            }
        }
        $bd->Close();
        return $result;
    }
    
  
            
}

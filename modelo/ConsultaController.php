<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of ConsultaController
 *
 * @author MARGOTH TAPIA
 */

include '../Modelo/Consulta.php';

class ConsultaController {
    
    public function ConsultaController(){}
    
public function CrearConsulta($p_idservicio, $p_especialidad, $p_indicaciones, $p_resultados)
{
    $affected=0;
    $bd=new con_mysqli("", "", "", "");
    
    ##Validar Iny Sql
        $p_idservicio=$bd->real_scape_string($p_idservicio);
        $p_especialidad=$bd->real_scape_string($p_especialidad);
        $p_indicaciones=$bd->real_scape_string($p_indicaciones);
        $p_resultados=$bd->real_scape_string($p_resultados);
                                
        $consulta="INSERT INTO `consulta` (`idservicio`, `idespecialidad`, `indicaciones`, `resultados`) VALUES ('$p_idservicio', '$p_especialidad', '$p_indicaciones', '$p_resultados')";
        
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

public function ModificarConsulta($p_id,$p_especialidad,$p_indicaciones,$p_resultados)
    {
        $affected=0;
        $bd=new con_mysqli("", "", "", "");
        
        ##Validar Iny Sql
        $p_especialidad=$bd->real_scape_string($p_especialidad);
        $p_indicaciones=$bd->real_scape_string($p_indicaciones);
        $p_resultados=$bd->real_scape_string($p_resultados);
                       
        $consulta="UPDATE `consulta` SET `idespecialidad`='$p_especialidad', `indicaciones`='$p_indicaciones', `resultados`='$p_resultados' WHERE (`idconsulta`='$p_id')";
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
        
        $consulta="DELETE FROM `consulta` WHERE (`idconsulta`='$p_id')";
        
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
        $consulta="SELECT * FROM `consulta` order by `idconsulta` ASC";
        $r=$bd->consulta($consulta);
        if($r)
        {
            $a=0;
            while ($fila=$bd->fetch_assoc($r))
            {
               
                $p_idconsulta=$fila["idconsulta"];
                $p_especialidad=$fila["especialidad"];
                $p_indicaciones=$fila["indicaciones"];
                $p_resultados=$fila["resultados"];
                                                                                
                $objConsulta=new Consulta($p_idconsulta, $p_especialidad, $p_indicaciones, $p_resultados);
                $result[$a]=$objConsulta;
                $a++;
            }
        }
        $bd->Close();
        return $result;
    }
    
    public function BuscarConsulta($p_idconsulta, $p_especialidad, $p_idservicio=null, $p_indicaciones=null, $p_resultados=null)
    {
        $result=array();
        $bd= new con_mysqli("", "", "", "");
        $consulta="SELECT * FROM `consulta` ";
        
        if($p_idconsulta!="")
        {
            $consulta=$consulta."WHERE `idconsulta`='$p_idconsulta'";
        }
        if($p_especialidad!="")
        {
            if($p_idconsulta=="")
            {
                $consulta=$consulta."WHERE `idespecialidad`='$p_especialidad'";
            }
            else 
            {
                $consulta=$consulta." and `idespecialidad`='$p_especialidad'";
            }
        }       
        if($p_idservicio!="")
        {
            if($p_idconsulta=="" && $p_especialidad=="")
            {
                $consulta=$consulta."WHERE `idservicio`='$p_idservicio'";
            }
            else 
            {
                $consulta=$consulta." and `idservicio`='$p_idservicio'";
            }
        }
        if($p_indicaciones!="")
        {
            if($p_idconsulta=="" && $p_especialidad=="" && $p_idservicio=="")
            {
                $consulta=$consulta."WHERE `indicaciones`='$p_indicaciones'";
            }
            else 
            {
                $consulta=$consulta." and `indicaciones`='$p_indicaciones'";
            }
        }
        if($p_resultados!="")
        {
            if($p_idconsulta=="" && $p_especialidad=="" && $p_idservicio=="" && $p_indicaciones=="")
            {
                $consulta=$consulta."WHERE `resultados`='$p_resultados'";
            }
            else 
            {
                $consulta=$consulta." and `resultados`='$p_resultados'";
            }
        }
        
        $consulta=$consulta." order by `idconsulta` ASC";
        //Mostrar($consulta);
        $r=$bd->consulta($consulta);
        if($r)
        {
            $a=0;
            while ($fila=$bd->fetch_assoc($r))
            {
                 
                $p_idconsulta=$fila["idconsulta"];
                $p_idservicio=$fila["idservicio"];
                $p_especialidad=$fila["idespecialidad"];
                $p_indicaciones=$fila["indicaciones"];
                $p_resultados=$fila["resultados"];
                                                                                
                $objConsulta=new Consulta($p_idservicio, $p_idconsulta, $p_especialidad, $p_indicaciones, $p_resultados);
                $result[$a]=$objConsulta;
                $a++;
            }
        }
        $bd->Close();
        return $result;
        
    }
    
    public function CargarConsultaID($search)
    {
        $result=array();
        $bd= new con_mysqli("", "", "", "");
        
        ##Validar parametros
        $search=$bd->real_scape_string($search);
        
        $consulta="SELECT * FROM `consulta` WHERE `idconsulta` LIKE '%$search%'";
        $r=$bd->consulta($consulta);
        if($r)
        {
            $a=0;
            while ($fila=$bd->fetch_assoc($r))
            {
                $bd_consulta=$fila["idconsulta"];
                $result[$a]=$bd_consulta;
                $a++;
            }
        }
        $bd->Close();
        
        return $result;
    }
    public function CargarConsulta($search)
    {
        $result=array();
        $bd= new con_mysqli("", "", "", "");
        
        ##Validar parametros
        $search=$bd->real_scape_string($search);
    
        $consulta="SELECT * FROM `consulta` WHERE `idconsulta` LIKE '%$search%'";
        $r=$bd->consulta($consulta);
        if($r)
        {
            $a=0;
            while ($fila=$bd->fetch_assoc($r))
            {
                $bd_idconsulta=$fila["idconsulta"];
                $bd_especialidad=$fila["especialidad"];
                $result[$a]="($bd_idconsulta) ".$bd_especialidad;
                $a++;
            }
        }
        $bd->Close();
    
        return $result;
    }
}

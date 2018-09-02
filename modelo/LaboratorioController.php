<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of LaboratorioController
 *
 * @author MARGOTH TAPIA
 */

include '../Modelo/Laboratorio.php';

class LaboratorioController {
    
    public function LaboratorioController(){}
    
public function CrearLaboratorio($p_idservicio, $p_idtipoanalisislab, $p_nombre, $p_resultados)
{
    $affected=0;
    $bd=new con_mysqli("", "", "", "");
    
    ##Validar Iny Sql
        $p_idservicio=$bd->real_scape_string($p_idservicio);
        $p_idtipoanalisislab=$bd->real_scape_string($p_idtipoanalisislab);
        $p_nombre=$bd->real_scape_string($p_nombre);
        $p_resultados=$bd->real_scape_string($p_resultados);
                        
        $laboratorio="INSERT INTO `laboratorio` (`idservicio`, `idtipoanalisislaboratorio`, `idnombreanalisis`, `resultados`) VALUES ('$p_idservicio', '$p_idtipoanalisislab', '$p_nombre', '$p_resultados')";
        
        $r=$bd->consulta($laboratorio);
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

public function ModificarLaboratorio($p_id,$p_idtipoanalisislab,$p_nombre,$p_resultados)
    {
        $affected=0;
        $bd=new con_mysqli("", "", "", "");
        
        ##Validar Iny Sql
        $p_idtipoanalisislab=$bd->real_scape_string($p_idtipoanalisislab);
        $p_nombre=$bd->real_scape_string($p_nombre);
        $p_resultados=$bd->real_scape_string($p_resultados);
               
        $consulta="UPDATE `laboratorio` SET `idtipoanalisislaboratorio`='$p_idtipoanalisislab', `idnombreanalisis`='$p_nombre', `resultados`='$p_resultados' WHERE (`idlaboratorio`='$p_id')";
        
        $r=$bd->consulta($consulta);
        if($r)
        {
            $affected=$bd->affected_row();
        }
        $bd->Close();
        return $affected;
    }
    
    public function EliminarLaboratorio($p_id)
    {
        $affected=0;
        $bd=new con_mysqli("", "", "", "");
        
        ##Validar Iny Sql
        $p_id=$bd->real_scape_string($p_id);
        
        $laboratorio="DELETE FROM `laboratorio` WHERE (`idlaboratorio`='$p_id')";
        
        $r=$bd->laboratorio($laboratorio);
        if($r)
        {
            $affected=$bd->affected_row();
        }
        $bd->Close();
        return $affected;
        
    }
    
    public function MostrarLaboratorio()
    {
        $result=array();
        $bd= new con_mysqli("", "", "", "");
        $laboratorio="SELECT * FROM `laboratorio` order by `idlaboratorio` ASC";
        $r=$bd->consulta($laboratorio);
        if($r)
        {
            $a=0;
            while ($fila=$bd->fetch_assoc($r))
            {
               
                $p_idlaboratorio=$fila["idlaboratorio"];
                $p_idtipoanalisislab=$fila["idtipoanalisislaboratorio"];
                $p_nombre=$fila["idnombreanalisis"];
                $p_resultados=$fila["resultados"];
                                                                
                $objLaboratorio=new Laboratorio($p_idlaboratorio, $p_idtipoanalisislab, $p_nombre, $p_resultados);
                $result[$a]=$objLaboratorio;
                $a++;
            }
        }
        $bd->Close();
        return $result;
    }
    
    public function BuscarLaboratorio($p_idlaboratorio, $p_idtipoanalisislab, $p_nombre, $p_idservicio=null, $p_resultados=null)
    {
        $result=array();
        $bd= new con_mysqli("", "", "", "");
        $consulta="SELECT * FROM `laboratorio` ";
        
        if($p_idlaboratorio!="")
        {
            $consulta=$consulta."WHERE `idlaboratorio`='$p_idlaboratorio'";
        }
        if($p_idtipoanalisislab!="")
        {
            if($p_idlaboratorio=="")
            {
                $consulta=$consulta."WHERE `idtipoanalisislaboratorio`='$p_idtipoanalisislab'";
            }
            else 
            {
                $consulta=$consulta." and `idtipoanalisislaboratorio`='$p_idtipoanalisislab'";
            }
        }
        if($p_nombre!="")
        {
            if($p_idlaboratorio=="" && $p_idtipoanalisislab=="")
            {
                $consulta=$consulta."WHERE `idnombreanalisis`='$p_nombre'";
            }
            else 
            {
                $consulta=$consulta." and `idnombreanalisis`='$p_nombre'";
            }
         }
         if ($p_idservicio != "") {
            if ($p_idlaboratorio == "" && $p_idtipoanalisislab == "" && $p_nombre == "") {
                $consulta = $consulta . "WHERE `idservicio`='$p_idservicio'";
            } else {
                $consulta = $consulta . " and `idservicio`='$p_idservicio'";
            }
        }
        if ($p_resultados != "") {
            if ($p_idlaboratorio == "" && $p_idtipoanalisislab == "" && $p_nombre == "" && $p_idservicio=="") {
                $consulta = $consulta . "WHERE `resultados`='$p_resultados'";
            } else {
                $consulta = $consulta . " and `resultados`='$p_resultados'";
            }
        }         
        
        $consulta=$consulta." order by `idlaboratorio` ASC";
        $r=$bd->consulta($consulta);
        if($r)
        {
            $a=0;
            while ($fila=$bd->fetch_assoc($r))
            {
                 
                $p_idservicio=$fila["idservicio"];
                $p_idlaboratorio=$fila["idlaboratorio"];
                $p_idtipoanalisislab=$fila["idtipoanalisislaboratorio"];
                $p_nombre=$fila["idnombreanalisis"];
                $p_resultados=$fila["resultados"];
                                                                
                $objLaboratorio=new Laboratorio($p_idservicio, $p_idlaboratorio, $p_idtipoanalisislab, $p_nombre, $p_resultados);
                $result[$a]=$objLaboratorio;
                $a++;
            }
        }
        $bd->Close();
        return $result;
        
    }
    
    public function CargarLaboratorioID($search)
    {
        $result=array();
        $bd= new con_mysqli("", "", "", "");
        
        ##Validar parametros
        $search=$bd->real_scape_string($search);
        
        $laboratorio="SELECT * FROM `laboratorio` WHERE `idlaboratorio` LIKE '%$search%'";
        $r=$bd->laboratorio($laboratorio);
        if($r)
        {
            $a=0;
            while ($fila=$bd->fetch_assoc($r))
            {
                $bd_laboratorio=$fila["idlaboratorio"];
                $result[$a]=$bd_laboratorio;
                $a++;
            }
        }
        $bd->Close();
        
        return $result;
    }
    public function CargarLaboratorio($search)
    {
        $result=array();
        $bd= new con_mysqli("", "", "", "");
        
        ##Validar parametros
        $search=$bd->real_scape_string($search);
    
        $laboratorio="SELECT * FROM `laboratorio` WHERE `idlaboratorio` LIKE '%$search%'";
        $r=$bd->laboratorio($laboratorio);
        if($r)
        {
            $a=0;
            while ($fila=$bd->fetch_assoc($r))
            {
                $bd_idlaboratorio=$fila["idlaboratorio"];
                $bd_nombre=$fila["idnombreanalisis"];
                $result[$a]="($bd_idlaboratorio) ".$bd_nombre;
                $a++;
            }
        }
        $bd->Close();
    
        return $result;
    }
}


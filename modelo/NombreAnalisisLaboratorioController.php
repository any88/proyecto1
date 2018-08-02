<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of NombreAnalisisLaboratorioController
 *
 * @author MARGOTH TAPIA
 */

include '../modelo/NombreAnalisisLaboratorio.php';

class NombreAnalisisLaboratorioController {
    
    public function NombreAnalisisLaboratorioController(){}
    
public function CrearNombreAnalisis($p_nombre, $p_tipo)
{
    $affected=0;
    $bd=new con_mysqli("", "", "", "");
    
    ##Validar Iny Sql
        $p_nombre=$bd->real_scape_string($p_nombre);
        $p_tipo=$bd->real_scape_string($p_tipo);
        
        $consulta="INSERT INTO `nombreanalisislaboratorio` (`nombreanalisis`, `idtipoanalisis`) VALUES ('$p_nombre', '$p_tipo')";
        
        $r=$bd->consulta($consulta);
        if($r)
        {
            $affected=$bd->affected_row();
        }
        $bd->Close();
        return $affected;
        
}

public function ModificarNombreAnalisis($p_id, $p_nombre, $p_tipo)
    {
        $affected=0;
        $bd=new con_mysqli("", "", "", "");
        
        ##Validar Iny Sql
        $p_id=$bd->real_scape_string($p_id);
        $p_nombre=$bd->real_scape_string($p_nombre);
        $p_tipo=$bd->real_scape_string($p_tipo);
        
        $consulta="UPDATE `nombreanalisislaboratorio` SET `nombreanalisis`='$p_nombre', `idtipoanalisis`='$p_tipo' WHERE (`idnombreanalisis`='$p_id')";
        
        $r=$bd->consulta($consulta);
        if($r)
        {
            $affected=$bd->affected_row();
            if($affected==0){$affected=1;}
        }
        $bd->Close();
        return $affected;
    }
    
    public function EliminarNombreAnalisis($p_id)
    {
        $affected=0;
        $bd=new con_mysqli("", "", "", "");
        
        ##Validar Iny Sql
        $p_id=$bd->real_scape_string($p_id);
        
        $consulta="DELETE FROM `nombreanalisislaboratorio` WHERE (`idnombreanalisis`='$p_id')";
        
        $r=$bd->consulta($consulta);
        if($r)
        {
            $affected=$bd->affected_row();
        }
        $bd->Close();
        return $affected;
        
    }
    
    public function MostrarNombreAnalisis()
    {
        $result=array();
        $bd= new con_mysqli("", "", "", "");
        $consulta="SELECT * FROM `nombreanalisislaboratorio` order by `nombreanalisis` ASC";
        $r=$bd->consulta($consulta);
        if($r)
        {
            $a=0;
            while ($fila=$bd->fetch_assoc($r))
            {
               
                $p_id=$fila["idnombreanalisis"];
                $p_nombre=$fila["nombreanalisis"];
                $p_tipo=$fila["idtipoanalisis"];
                                
                $objNombreAnalisis=new NombreAnalisisLaboratorio($p_id, $p_nombre, $p_tipo);
                $result[$a]=$objNombreAnalisis;
                $a++;
            }
        }
        $bd->Close();
        return $result;
    }
    
    public function BuscarNombreAnalisis($p_id, $p_nombre, $p_tipo)
    {
        $result=array();
        $bd= new con_mysqli("", "", "", "");
        $consulta="SELECT * FROM `nombreanalisislaboratorio` ";
        
        if($p_id!="")
        {
            $consulta=$consulta."WHERE `idnombreanalisis`='$p_id'";
        }
        if($p_nombre!="")
        {
            if($p_id=="")
            {
                $consulta=$consulta."WHERE `nombreanalisis`='$p_nombre'";
            }
            else 
            {
                $consulta=$consulta." and `nombreanalisis`='$p_nombre'";
            }
        }
        if($p_tipo!="")
        {
            if($p_id=="" && $p_nombre=="" )
            {
                $consulta=$consulta."WHERE `idtipoanalisis`='$p_tipo'";
            }
            else 
            {
                $consulta=$consulta." and `idtipoanalisis`='$p_tipo'";
            }
         }
         
        
        $consulta=$consulta." order by `nombreanalisis` ASC";
        $r=$bd->consulta($consulta);
        if($r)
        {
            $a=0;
            while ($fila=$bd->fetch_assoc($r))
            {
                 
                $p_id=$fila["idnombreanalisis"];
                $p_nombre=$fila["nombreanalisis"];
                $p_tipo=$fila["idtipoanalisis"];
                                
                $objNombreAnalisis=new NombreAnalisisLaboratorio($p_id, $p_nombre, $p_tipo);
                $result[$a]=$objNombreAnalisis;
                $a++;
            }
        }
        $bd->Close();
        return $result;
        
    }
    
    public function CargarNombreAnalisis($search)
    {
        $result=array();
        $bd= new con_mysqli("", "", "", "");
        
        ##Validar parametros
        $search=$bd->real_scape_string($search);
        
        $consulta="SELECT * FROM `nombreanalisislaboratorio` WHERE `nombreanalisis` LIKE '%$search%'";
        $r=$bd->consulta($consulta);
        if($r)
        {
            $a=0;
            while ($fila=$bd->fetch_assoc($r))
            {
                $bd_nombre=$fila["nombreanalisis"];
                $result[$a]=$bd_nombre;
                $a++;
            }
        }
        $bd->Close();
        
        return $result;
    }
    public function CargarNombreAnalisisID($search)
    {
        $result=array();
        $bd= new con_mysqli("", "", "", "");
        
        ##Validar parametros
        $search=$bd->real_scape_string($search);
    
        $consulta="SELECT * FROM `nombreanalisislaboratorio` WHERE `idnombreanalisis` LIKE '%$search%'";
        $r=$bd->consulta($consulta);
        if($r)
        {
            $a=0;
            while ($fila=$bd->fetch_assoc($r))
            {
                $bd_nombre=$fila["nombreanalisis"];
                $bd_idnombreanalisis=$fila["idnombreanalisis"];
                $result[$a]="($bd_nombre) ".$bd_idnombreanalisis;
                $a++;
            }
        }
        $bd->Close();
    
        return $result;
    }
}

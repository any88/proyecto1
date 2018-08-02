<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of LaboratorioClinicoController
 *
 * @author MARGOTH TAPIA
 */

include '../modelo/LaboratorioClinico.php';

class LaboratorioClinicoController {
     
    public function LaboratorioClinicoController(){}
    
public function CrearLaboratorioClinico($p_nombre, $p_ruc)
{
    $affected=0;
    $bd=new con_mysqli("", "", "", "");
    
    ##Validar Iny Sql
        $p_nombre=$bd->real_scape_string($p_nombre);
        $p_ruc=$bd->real_scape_string($p_ruc);
        
        $consulta="INSERT INTO `labclinico` (`nombrelabclinico`, `ruc`) VALUES ('$p_nombre', '$p_ruc')";
        
        $r=$bd->consulta($consulta);
        if($r)
        {
            $affected=$bd->affected_row();
        }
        $bd->Close();
        return $affected;
        
}

public function ModificarLaboratorioClinico($p_id,$p_nombre,$p_ruc)
    {
        $affected=0;
        $bd=new con_mysqli("", "", "", "");
        
        ##Validar Iny Sql
        $p_id=$bd->real_scape_string($p_id);
        $p_nombre=$bd->real_scape_string($p_nombre);
        $p_ruc=$bd->real_scape_string($p_ruc);
        
        $consulta="UPDATE `labclinico` SET `nombrelabclinico`='$p_nombre', `ruc`='$p_ruc' WHERE (`idlabclinico`='$p_id')";
        
        $r=$bd->consulta($consulta);
        if($r)
        {
            $affected=$bd->affected_row();
            if($affected==0){$affected=1;}
        }
        $bd->Close();
        return $affected;
    }
    
    public function EliminarLaboratorioClinico($p_id)
    {
        $affected=0;
        $bd=new con_mysqli("", "", "", "");
        
        ##Validar Iny Sql
        $p_id=$bd->real_scape_string($p_id);
        
        $consulta="DELETE FROM `labclinico` WHERE (`idlabclinico`='$p_id')";
        
        $r=$bd->consulta($consulta);
        if($r)
        {
            $affected=$bd->affected_row();
        }
        $bd->Close();
        return $affected;
        
    }
    
    public function MostrarLaboratorioClinico()
    {
        $result=array();
        $bd= new con_mysqli("", "", "", "");
        $consulta="SELECT * FROM `labclinico` order by `nombrelabclinico` ASC";
        $r=$bd->consulta($consulta);
        if($r)
        {
            $a=0;
            while ($fila=$bd->fetch_assoc($r))
            {
               
                $p_id=$fila["idlabclinico"];
                $p_nombre=$fila["nombrelabclinico"];
                $p_ruc=$fila["ruc"];
                                
                $objLaboratorioClinico=new LaboratorioClinico($p_id, $p_nombre, $p_ruc);
                $result[$a]=$objLaboratorioClinico;
                $a++;
            }
        }
        $bd->Close();
        return $result;
    }
    
    public function BuscarLaboratorioClinico($p_id, $p_nombre, $p_ruc)
    {
        $result=array();
        $bd= new con_mysqli("", "", "", "");
        $consulta="SELECT * FROM `labclinico` ";
        
        if($p_id!="")
        {
            $consulta=$consulta."WHERE `idlabclinico`='$p_id'";
        }
        if($p_nombre!="")
        {
            if($p_id=="")
            {
                $consulta=$consulta."WHERE `nombrelabclinico`='$p_nombre'";
            }
            else 
            {
                $consulta=$consulta." and `nombrelabclinico`='$p_nombre'";
            }
        }
        if($p_ruc!="")
        {
            if($p_id=="" && $p_nombre=="" )
            {
                $consulta=$consulta."WHERE `ruc`='$p_ruc'";
            }
            else 
            {
                $consulta=$consulta." and `ruc`='$p_ruc'";
            }
         }
         
        
        $consulta=$consulta." order by `nombrelabclinico` ASC";
        $r=$bd->consulta($consulta);
        if($r)
        {
            $a=0;
            while ($fila=$bd->fetch_assoc($r))
            {
                 
                $p_id=$fila["idlabclinico"];
                $p_nombre=$fila["nombrelabclinico"];
                $p_ruc=$fila["ruc"];
                                
                $objLaboratorioClinico=new LaboratorioClinico($p_id, $p_nombre, $p_ruc);
                $result[$a]=$objLaboratorioClinico;
                $a++;
            }
        }
        $bd->Close();
        return $result;
        
    }
    
    public function CargarLaboratorioClinico($search)
    {
        $result=array();
        $bd= new con_mysqli("", "", "", "");
        
        ##Validar parametros
        $search=$bd->real_scape_string($search);
        
        $consulta="SELECT * FROM `labclinico` WHERE `nombrelabclinico` LIKE '%$search%'";
        $r=$bd->consulta($consulta);
        if($r)
        {
            $a=0;
            while ($fila=$bd->fetch_assoc($r))
            {
                $bd_nombre=$fila["nombrelabclinico"];
                $result[$a]=$bd_nombre;
                $a++;
            }
        }
        $bd->Close();
        
        return $result;
    }
    public function CargarLaboratorioClinicoRUC($search)
    {
        $result=array();
        $bd= new con_mysqli("", "", "", "");
        
        ##Validar parametros
        $search=$bd->real_scape_string($search);
    
        $consulta="SELECT * FROM `labclinico` WHERE `ruc` LIKE '%$search%'";
        $r=$bd->consulta($consulta);
        if($r)
        {
            $a=0;
            while ($fila=$bd->fetch_assoc($r))
            {
                $bd_nombre=$fila["nombrelabclinico"];
                $bd_ruc=$fila["ruc"];
                $result[$a]="($bd_nombre) ".$bd_ruc;
                $a++;
            }
        }
        $bd->Close();
    
        return $result;
    }
}

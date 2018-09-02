<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of LaboratorioClinico_AnalisisController
 *
 * @author MARGOTH TAPIA
 */

include '../modelo/LaboratorioClinico_Analisis.php';

class LaboratorioClinico_AnalisisController {
    
    public function LaboratorioClinico_AnalisisController(){}
    
public function CrearLaboratorioClinico_Analisis($p_idlabclin, $p_idlab, $p_fecha, $p_idtransaccion)
{
    $affected=0;
    $bd=new con_mysqli("", "", "", "");
    
    ##Validar Iny Sql
        $p_idlabclin=$bd->real_scape_string($p_idlabclin);
        $p_idlab=$bd->real_scape_string($p_idlab);
        $p_fecha=$bd->real_scape_string($p_fecha);
        $p_idtransaccion=$bd->real_scape_string($p_idtransaccion);
                        
        $consulta="INSERT INTO `labclin_analab` (`idlabclinico`, `idlaboratorio`, `fecha`, `idtransaccion`) VALUES ('$p_idlabclin', '$p_idlab', '$p_fecha', '$p_idtransaccion')";
        
        $r=$bd->consulta($consulta);
        if($r)
        {
            $affected=$bd->affected_row();
        }
        $bd->Close();
        return $affected;
        
}

public function ModificarLaboratorioClinico_Analisis($p_id,$p_idlabclin,$p_idlab,$p_fecha,$p_idtransaccion)
    {
        $affected=0;
        $bd=new con_mysqli("", "", "", "");
        
        ##Validar Iny Sql
        $p_id=$bd->real_scape_string($p_id);
        $p_fecha=$bd->real_scape_string($p_fecha);
        $p_idlabclin=$bd->real_scape_string($p_idlabclin);
        $p_idlab=$bd->real_scape_string($p_idlab);
        $p_idtransaccion=$bd->real_scape_string($p_idtransaccion);
               
        $consulta="UPDATE `labclin_analab` SET `fecha`='$p_fecha', `idlabclinico`='$p_idlabclin', `idlaboratorio`='$p_idlab', `idtransaccion`='$p_idtransaccion' WHERE (`id_labclinanalab`='$p_id')";
        
        $r=$bd->consulta($consulta);
        if($r)
        {
            $affected=$bd->affected_row();
        }
        $bd->Close();
        return $affected;
    }
    
    public function ModificarIdlabClinporIdAnalisisLab($p_idlaboratorio,$p_idlabclin)
    {
        $affected=0;
        $bd=new con_mysqli("", "", "", "");
        
        ##Validar Iny Sql
        $p_idlaboratorio=$bd->real_scape_string($p_idlaboratorio);
        $p_idlabclin=$bd->real_scape_string($p_idlabclin);
       
               
        $consulta="UPDATE `labclin_analab` SET `idlabclinico`='$p_idlabclin' WHERE (`idlaboratorio`='$p_idlaboratorio')";
        
        $r=$bd->consulta($consulta);
        if($r)
        {
            $affected=$bd->affected_row();
        }
        $bd->Close();
        return $affected;
    }
    
    public function EliminarLaboratorioClinico_Analisis($p_id)
    {
        $affected=0;
        $bd=new con_mysqli("", "", "", "");
        
        ##Validar Iny Sql
        $p_id=$bd->real_scape_string($p_id);
        
        $consulta="DELETE FROM `labclin_analab` WHERE (`id_labclinanalab`='$p_id')";
        
        $r=$bd->consulta($consulta);
        if($r)
        {
            $affected=$bd->affected_row();
        }
        $bd->Close();
        return $affected;
        
    }
    
    public function MostrarLaboratorioClinico_Analisis()
    {
        $result=array();
        $bd= new con_mysqli("", "", "", "");
        $consulta="SELECT * FROM `labclin_analab` order by `fecha` ASC";
        $r=$bd->consulta($consulta);
        if($r)
        {
            $a=0;
            while ($fila=$bd->fetch_assoc($r))
            {
               
                $p_id=$fila["id_labclinanalab"];
                $p_idlabclin=$fila["idlabclinico"];
                $p_fecha=$fila["fecha"];
                $p_idlab=$fila["idlaboratorio"];
                $p_idtransaccion=$fila["idtransaccion"];
                                                                
                $objLaboratorioClinico_Analisis=new LaboratorioClinico_Analisis($p_id, $p_idlabclin, $p_idlab, $p_fecha, $p_idtransaccion);
                $result[$a]=$objLaboratorioClinico_Analisis;
                $a++;
            }
        }
        $bd->Close();
        return $result;
    }
    
    public function BuscarLaboratorioClinico_Analisis($p_idlabclinanalab, $p_idlabclin, $p_idlab)
    {
        $result=array();
        $bd= new con_mysqli("", "", "", "");
        $consulta="SELECT * FROM `labclin_analab` ";
        
        if($p_idlabclinanalab!="")
        {
            $consulta=$consulta."WHERE `id_labclinanalab`='$p_idlabclinanalab'";
        }
        if($p_idlabclin!="")
        {
            if($p_idlabclinanalab=="")
            {
                $consulta=$consulta."WHERE `idlabclinico`='$p_idlabclin'";
            }
            else 
            {
                $consulta=$consulta." and `idlabclinico`='$p_idlabclin'";
            }
        }
        if($p_idlab!="")
        {
            if($p_idlabclinanalab=="" && $p_idlabclin=="")
            {
                $consulta=$consulta."WHERE `idlaboratorio`='$p_idlab'";
            }
            else 
            {
                $consulta=$consulta." and `idlaboratorio`='$p_idlab'";
            }
         }
         
        
        $consulta=$consulta." order by `id_labclinanalab` ASC";
        $r=$bd->consulta($consulta);
        if($r)
        {
            $a=0;
            while ($fila=$bd->fetch_assoc($r))
            {
                 
                $p_id=$fila["id_labclinanalab"];
                $p_idlabclin=$fila["idlabclinico"];
                $p_idlab=$fila["idlaboratorio"];
                $p_fecha=$fila["fecha"];
                $p_idtransaccion=$fila["idtransaccion"];
                                                                
                $objLaboratorioClinico_Analisis=new LaboratorioClinico_Analisis($p_id, $p_idlabclin, $p_idlab, $p_fecha, $p_idtransaccion);
                $result[$a]=$objLaboratorioClinico_Analisis;
                $a++;
            }
        }
        $bd->Close();
        return $result;
        
    }
    
    public function CargarLaboratorioClinico_AnalisisID($search)
    {
        $result=array();
        $bd= new con_mysqli("", "", "", "");
        
        ##Validar parametros
        $search=$bd->real_scape_string($search);
        
        $consulta="SELECT * FROM `labclin_analab` WHERE `id_labclinanalab` LIKE '%$search%'";
        $r=$bd->consulta($consulta);
        if($r)
        {
            $a=0;
            while ($fila=$bd->fetch_assoc($r))
            {
                $bd_id=$fila["id_labclinanalab"];
                $result[$a]=$bd_id;
                $a++;
            }
        }
        $bd->Close();
        
        return $result;
    }
    public function CargarLaboratorioClinico_Analisis($search)
    {
        $result=array();
        $bd= new con_mysqli("", "", "", "");
        
        ##Validar parametros
        $search=$bd->real_scape_string($search);
    
        $consulta="SELECT * FROM `labclin_analab` WHERE `id_labclinanalab` LIKE '%$search%'";
        $r=$bd->consulta($consulta);
        if($r)
        {
            $a=0;
            while ($fila=$bd->fetch_assoc($r))
            {
                $bd_id=$fila["id_labclinanalab"];
                $bd_idlabclin=$fila["idlabclinico"];
                $bd_idlab=$fila["idlaboratorio"];
                $result[$a]="($bd_id) ".$bd_idlabclin." ".$bd_idlab;
                $a++;
            }
        }
        $bd->Close();
    
        return $result;
    }
}

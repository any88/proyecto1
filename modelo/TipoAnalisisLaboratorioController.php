<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of TipoAnalisisLaboratorioController
 *
 * @author MARGOTH TAPIA
 */

include '../Modelo/TipoAnalisisLaboratorio.php';

class TipoAnalisisLaboratorioController {
    
    public function TipoAnalisisLaboratorioController(){}
    
public function CrearTipoAnalisisLaboratorio($p_tipoanalisis)
{
    $affected=0;
    $bd=new con_mysqli("", "", "", "");
    
    ##Validar Iny Sql
        $p_tipoanalisis=$bd->real_scape_string($p_tipoanalisis);
                
        $consulta="INSERT INTO `tipoanalisislaboratorio` (`tipoanalisis`) VALUES ('$p_tipoanalisis')";
        
        $r=$bd->consulta($consulta);
        if($r)
        {
            $affected=$bd->affected_row();
        }
        $bd->Close();
        return $affected;
        
}

public function ModificarTipoAnalisisLaboratorio($p_id, $p_tipoanalisis)
    {
        $affected=0;
        $bd=new con_mysqli("", "", "", "");
        
        ##Validar Iny Sql
        $p_id=$bd->real_scape_string($p_id);
        $p_tipoanalisis=$bd->real_scape_string($p_tipoanalisis);
                
        $consulta="UPDATE `tipoanalisislaboratorio` SET `tipoanalisis`='$p_tipoanalisis' WHERE (`idtipoanalisislaboratorio`='$p_id')";
        
        $r=$bd->consulta($consulta);
        if($r)
        {
            $affected=$bd->affected_row();
        }
        $bd->Close();
        return $affected;
    }
    
    public function EliminarTipoAnalisisLaboratorio($p_id)
    {
        $affected=0;
        $bd=new con_mysqli("", "", "", "");
        
        ##Validar Iny Sql
        $p_id=$bd->real_scape_string($p_id);
        
        $consulta="DELETE FROM `tipoanalisislaboratorio` WHERE (`idtipoanalisislaboratorio`='$p_id')";
        
        $r=$bd->consulta($consulta);
        if($r)
        {
            $affected=$bd->affected_row();
        }
        $bd->Close();
        return $affected;
        
    }
    
    public function MostrarTipoAnalisisLaboratorio()
    {
        $result=array();
        $bd= new con_mysqli("", "", "", "");
        $consulta="SELECT * FROM `tipoanalisislaboratorio` order by `tipoanalisis` ASC";
        $r=$bd->consulta($consulta);
        if($r)
        {
            $a=0;
            while ($fila=$bd->fetch_assoc($r))
            {
               
                $p_id=$fila["idtipoanalisislaboratorio"];
                $p_tipoanalisis=$fila["tipoanalisis"];
                                                
                $objTipoAnalisisLaboratorio=new TipoAnalisisLaboratorio($p_id, $p_tipoanalisis);
                $result[$a]=$objTipoAnalisisLaboratorio;
                $a++;
            }
        }
        $bd->Close();
        return $result;
    }
    
    public function BuscarTipoAnalisisLaboratorio($p_id, $p_tipoanalisis)
    {
        $result=array();
        $bd= new con_mysqli("", "", "", "");
        $consulta="SELECT * FROM `tipoanalisislaboratorio` ";
        
        if($p_id!="")
        {
            $consulta=$consulta."WHERE `idtipoanalisislaboratorio`='$p_id'";
        }
        if($p_tipoanalisis!="")
        {
            if($p_id=="")
            {
                $consulta=$consulta."WHERE `tipoanalisis`='$p_tipoanalisis'";
            }
            else 
            {
                $consulta=$consulta." and `tipoanalisis`='$p_tipoanalisis'";
            }
        }      
        
        $consulta=$consulta." order by `idtipoanalisislaboratorio` ASC";
        $r=$bd->consulta($consulta);
        if($r)
        {
            $a=0;
            while ($fila=$bd->fetch_assoc($r))
            {
                 
                $p_id=$fila["idtipoanalisislaboratorio"];
                $p_tipoanalisis=$fila["tipoanalisis"];
                                                
                $objTipoAnalisisLaboratorio=new TipoAnalisisLaboratorio($p_id, $p_tipoanalisis);
                $result[$a]=$objTipoAnalisisLaboratorio;
                $a++;
            }
        }
        $bd->Close();
        return $result;
        
    }
    
    public function CargarTipoAnalisisLaboratorio($search)
    {
        $result=array();
        $bd= new con_mysqli("", "", "", "");
        
        ##Validar parametros
        $search=$bd->real_scape_string($search);
        
        $consulta="SELECT * FROM `tipoanalisislaboratorio` WHERE `idtipoanalisislaboratorio` LIKE '%$search%'";
        $r=$bd->consulta($consulta);
        if($r)
        {
            $a=0;
            while ($fila=$bd->fetch_assoc($r))
            {
                $bd_idanalisis=$fila["idtipoanalisislaboratorio"];
                $result[$a]=$bd_idanalisis;
                $a++;
            }
        }
        $bd->Close();
        
        return $result;
    }
    public function CargarTipoAnalisisLabID($search)
    {
        $result=array();
        $bd= new con_mysqli("", "", "", "");
        
        ##Validar parametros
        $search=$bd->real_scape_string($search);
    
        $consulta="SELECT * FROM `tipoanalisislaboratorio` WHERE `idtipoanalisislaboratorio` LIKE '%$search%'";
        $r=$bd->consulta($consulta);
        if($r)
        {
            $a=0;
            while ($fila=$bd->fetch_assoc($r))
            {
                $bd_idtipoanalisislaboratorio=$fila["idtipoanalisislaboratorio"];
                $bd_tipoanalisis=$fila["tipoanalisis"];
                $result[$a]="($bd_idtipoanalisislaboratorio) ".$bd_tipoanalisis;
                $a++;
            }
        }
        $bd->Close();
    
        return $result;
    }
}

<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of TipoRadiologiaController
 *
 * @author MARGOTH TAPIA
 */

include '../modelo/TipoRadiologia.php';

class TipoRadiologiaController {
    
    public function TipoRadiologiaController(){}
    
public function CrearTipoRadiologia($p_tiporadiologia)
{
    $affected=0;
    $bd=new con_mysqli("", "", "", "");
    
    ##Validar Iny Sql
        $p_tiporadiologia=$bd->real_scape_string($p_tiporadiologia);
                
        $consulta="INSERT INTO `tiporadiologia` (`tiporadiologia`) VALUES ('$p_tiporadiologia')";
        
        $r=$bd->consulta($consulta);
        if($r)
        {
            $affected=$bd->affected_row();
        }
        $bd->Close();
        return $affected;
        
}

public function ModificarTipoRadiologia($p_id, $p_tiporadiologia)
    {
        $affected=0;
        $bd=new con_mysqli("", "", "", "");
        
        ##Validar Iny Sql
        $p_id=$bd->real_scape_string($p_id);
        $p_tiporadiologia=$bd->real_scape_string($p_tiporadiologia);
                
        $consulta="UPDATE `tiporadiologia` SET `tiporadiologia`='$p_tiporadiologia' WHERE (`idtiporadiologia`='$p_id')";
        
        $r=$bd->consulta($consulta);
        if($r)
        {
            $affected=$bd->affected_row();
        }
        $bd->Close();
        return $affected;
    }
    
    public function EliminarTipoRadiologia($p_id)
    {
        $affected=0;
        $bd=new con_mysqli("", "", "", "");
        
        ##Validar Iny Sql
        $p_id=$bd->real_scape_string($p_id);
        
        $consulta="DELETE FROM `tiporadiologia` WHERE (`idtiporadiologia`='$p_id')";
        
        $r=$bd->consulta($consulta);
        if($r)
        {
            $affected=$bd->affected_row();
        }
        $bd->Close();
        return $affected;
        
    }
    
    public function MostrarTipoRadiologia()
    {
        $result=array();
        $bd= new con_mysqli("", "", "", "");
        $consulta="SELECT * FROM `tiporadiologia` order by `tiporadiologia` ASC";
        $r=$bd->consulta($consulta);
        if($r)
        {
            $a=0;
            while ($fila=$bd->fetch_assoc($r))
            {
               
                $p_id=$fila["idtiporadiologia"];
                $p_tiporadiologia=$fila["tiporadiologia"];
                                                
                $objTipoRadiologia=new TipoRadiologia($p_id, $p_tiporadiologia);
                $result[$a]=$objTipoRadiologia;
                $a++;
            }
        }
        $bd->Close();
        return $result;
    }
    
    public function BuscarTipoRadiologia($p_id, $p_tiporadiologia)
    {
        $result=array();
        $bd= new con_mysqli("", "", "", "");
        $consulta="SELECT * FROM `tiporadiologia` ";
        
        if($p_id!="")
        {
            $consulta=$consulta."WHERE `idtiporadiologia`='$p_id'";
        }
        if($p_tiporadiologia!="")
        {
            if($p_id=="")
            {
                $consulta=$consulta."WHERE `tiporadiologia`='$p_tiporadiologia'";
            }
            else 
            {
                $consulta=$consulta." and `tiporadiologia`='$p_tiporadiologia'";
            }
        }      
        
        $consulta=$consulta." order by `idtiporadiologia` ASC";
        $r=$bd->consulta($consulta);
        if($r)
        {
            $a=0;
            while ($fila=$bd->fetch_assoc($r))
            {
                 
                $p_id=$fila["idtiporadiologia"];
                $p_tiporadiologia=$fila["tiporadiologia"];
                                                
                $objTipoRadiologia=new TipoRadiologia($p_id, $p_tiporadiologia);
                $result[$a]=$objTipoRadiologia;
                $a++;
            }
        }
        $bd->Close();
        return $result;
        
    }
    
    public function CargarTipoRadiologia($search)
    {
        $result=array();
        $bd= new con_mysqli("", "", "", "");
        
        ##Validar parametros
        $search=$bd->real_scape_string($search);
        
        $consulta="SELECT * FROM `tiporadiologia` WHERE `idtiporadiologia` LIKE '%$search%'";
        $r=$bd->consulta($consulta);
        if($r)
        {
            $a=0;
            while ($fila=$bd->fetch_assoc($r))
            {
                $bd_idradiologia=$fila["idtiporadiologia"];
                $result[$a]=$bd_idradiologia;
                $a++;
            }
        }
        $bd->Close();
        
        return $result;
    }
    public function CargarTipoRadiologiaID($search)
    {
        $result=array();
        $bd= new con_mysqli("", "", "", "");
        
        ##Validar parametros
        $search=$bd->real_scape_string($search);
    
        $consulta="SELECT * FROM `tiporadiologia` WHERE `idtiporadiologia` LIKE '%$search%'";
        $r=$bd->consulta($consulta);
        if($r)
        {
            $a=0;
            while ($fila=$bd->fetch_assoc($r))
            {
                $bd_idtiporadiologia=$fila["idtiporadiologia"];
                $bd_tiporadiologia=$fila["tiporadiologia"];
                $result[$a]="($bd_idtiporadiologia) ".$bd_tiporadiologia;
                $a++;
            }
        }
        $bd->Close();
    
        return $result;
    }
}

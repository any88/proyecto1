<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of LaboratorioRadiologia_PruebaRadController
 *
 * @author MARGOTH TAPIA
 */

include '../modelo/LaboratorioRadiologia_PruebaRad.php';

class LaboratorioRadiologia_PruebaRadController {
    
    public function LaboratorioRadiologia_PruebaRadController(){}
    
public function CrearLaboratorioRadiologia_PruebaRad($p_idlabrad, $p_idrad, $p_fecha, $p_idtransaccion)
{
    $affected=0;
    $bd=new con_mysqli("", "", "", "");
    
    ##Validar Iny Sql
        $p_idlabrad=$bd->real_scape_string($p_idlabrad);
        $p_idrad=$bd->real_scape_string($p_idrad);
        $p_fecha=$bd->real_scape_string($p_fecha);
        $p_idtransaccion=$bd->real_scape_string($p_idtransaccion);
                        
        $consulta="INSERT INTO `labrad_pruebarad` (`idlabradiologia`, `idradiologia`, `fecha`, `idtransaccion`) VALUES ('$p_idlabrad', '$p_idrad', '$p_fecha', '$p_idtransaccion')";
        
        $r=$bd->consulta($consulta);
        if($r)
        {
            $affected=$bd->affected_row();
        }
        $bd->Close();
        return $affected;
        
}

public function ModificarLaboratorioRadiologia_PruebaRad($p_id,$p_idlabrad,$p_idrad,$p_fecha,$p_idtransaccion)
    {
        $affected=0;
        $bd=new con_mysqli("", "", "", "");
        
        ##Validar Iny Sql
        $p_id=$bd->real_scape_string($p_id);
        $p_fecha=$bd->real_scape_string($p_fecha);
        $p_idlabrad=$bd->real_scape_string($p_idlabrad);
        $p_idrad=$bd->real_scape_string($p_idrad);
        $p_idtransaccion=$bd->real_scape_string($p_idtransaccion);
               
        $consulta="UPDATE `labrad_pruebarad` SET `fecha`='$p_fecha', `idlabradiologia`='$p_idlabrad', `idradiologia`='$p_idrad', `idtransaccion`='$p_idtransaccion' WHERE (`id_labradprbrad`='$p_id')";
        
        $r=$bd->consulta($consulta);
        if($r)
        {
            $affected=$bd->affected_row();
        }
        $bd->Close();
        return $affected;
    }
    
    public function ModificarIdlabRadporIdAnalisisLab($p_idlaboratorio,$p_idlabrad)
    {
        $affected=0;
        $bd=new con_mysqli("", "", "", "");
        
        ##Validar Iny Sql
        $p_idlaboratorio=$bd->real_scape_string($p_idlaboratorio);
        $p_idlabrad=$bd->real_scape_string($p_idlabrad);
       
               
        $consulta="UPDATE `labrad_pruebarad` SET `idlabradiologia`='$p_idlabrad' WHERE (`idradiologia`='$p_idlaboratorio')";
        
        $r=$bd->consulta($consulta);
        if($r)
        {
            $affected=$bd->affected_row();
        }
        $bd->Close();
        return $affected;
    }
    
    public function EliminarLaboratorioRadiologia_PruebaRad($p_id)
    {
        $affected=0;
        $bd=new con_mysqli("", "", "", "");
        
        ##Validar Iny Sql
        $p_id=$bd->real_scape_string($p_id);
        
        $consulta="DELETE FROM `labrad_pruebarad` WHERE (`id_labradprbrad`='$p_id')";
        
        $r=$bd->consulta($consulta);
        if($r)
        {
            $affected=$bd->affected_row();
        }
        $bd->Close();
        return $affected;
        
    }
    
    public function MostrarLaboratorioRadiologia_PruebaRad()
    {
        $result=array();
        $bd= new con_mysqli("", "", "", "");
        $consulta="SELECT * FROM `labrad_pruebarad` order by `fecha` ASC";
        $r=$bd->consulta($consulta);
        if($r)
        {
            $a=0;
            while ($fila=$bd->fetch_assoc($r))
            {
               
                $p_id=$fila["id_labradprbrad"];
                $p_idlabrad=$fila["idlabradiologia"];
                $p_fecha=$fila["fecha"];
                $p_idrad=$fila["idradiologia"];
                $p_idtransaccion=$fila["idtransaccion"];
                                                                
                $objLaboratorioRadiologia_PruebaRad=new LaboratorioRadiologia_PruebaRad($p_id, $p_idlabrad, $p_idrad, $p_fecha, $p_idtransaccion);
                $result[$a]=$objLaboratorioRadiologia_PruebaRad;
                $a++;
            }
        }
        $bd->Close();
        return $result;
    }
    
    public function BuscarLaboratorioRadiologia_PruebaRad($id_labradprbrad, $p_idlabrad, $p_idrad)
    {
        $result=array();
        $bd= new con_mysqli("", "", "", "");
        $consulta="SELECT * FROM `labrad_pruebarad` ";
        
        if($id_labradprbrad!="")
        {
            $consulta=$consulta."WHERE `id_labradprbrad`='$id_labradprbrad'";
        }
        if($p_idlabrad!="")
        {
            if($id_labradprbrad=="")
            {
                $consulta=$consulta."WHERE `idlabradiologia`='$p_idlabrad'";
            }
            else 
            {
                $consulta=$consulta." and `idlabradiologia`='$p_idlabrad'";
            }
        }
        if($p_idrad!="")
        {
            if($id_labradprbrad=="" && $p_idlabrad=="")
            {
                $consulta=$consulta."WHERE `idradiologia`='$p_idrad'";
            }
            else 
            {
                $consulta=$consulta." and `idradiologia`='$p_idrad'";
            }
         }
         
        
        $consulta=$consulta." order by `id_labradprbrad` ASC";
        $r=$bd->consulta($consulta);
        if($r)
        {
            $a=0;
            while ($fila=$bd->fetch_assoc($r))
            {
                 
                $p_id=$fila["id_labradprbrad"];
                $p_idlabrad=$fila["idlabradiologia"];
                $p_idrad=$fila["idradiologia"];
                $p_fecha=$fila["fecha"];
                $p_idtransaccion=$fila["idtransaccion"];
                                                                
                $objLaboratorioRadiologia_PruebaRad=new LaboratorioRadiologia_PruebaRad($p_id, $p_idlabrad, $p_idrad, $p_fecha, $p_idtransaccion);
                $result[$a]=$objLaboratorioRadiologia_PruebaRad;
                $a++;
            }
        }
        $bd->Close();
        return $result;
        
    }
    
    public function CargarLaboratorioRadiologia_PruebaRadID($search)
    {
        $result=array();
        $bd= new con_mysqli("", "", "", "");
        
        ##Validar parametros
        $search=$bd->real_scape_string($search);
        
        $consulta="SELECT * FROM `labrad_pruebarad` WHERE `id_labradprbrad` LIKE '%$search%'";
        $r=$bd->consulta($consulta);
        if($r)
        {
            $a=0;
            while ($fila=$bd->fetch_assoc($r))
            {
                $bd_id=$fila["id_labradprbrad"];
                $result[$a]=$bd_id;
                $a++;
            }
        }
        $bd->Close();
        
        return $result;
    }
    public function CargarLaboratorioRadiologia_PruebaRad($search)
    {
        $result=array();
        $bd= new con_mysqli("", "", "", "");
        
        ##Validar parametros
        $search=$bd->real_scape_string($search);
    
        $consulta="SELECT * FROM `labrad_pruebarad` WHERE `id_labradprbrad` LIKE '%$search%'";
        $r=$bd->consulta($consulta);
        if($r)
        {
            $a=0;
            while ($fila=$bd->fetch_assoc($r))
            {
                $bd_id=$fila["id_labradprbrad"];
                $bd_idlabrad=$fila["idlabradiologia"];
                $bd_idrad=$fila["idradiologia"];
                $result[$a]="($bd_id) ".$bd_idlabrad." ".$bd_idrad;
                $a++;
            }
        }
        $bd->Close();
    
        return $result;
    }
}

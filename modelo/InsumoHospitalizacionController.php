<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of InsumoHospitalizacionController
 *
 * @author MARGOTH TAPIA
 */

include '../modelo/InsumoHospitalizacion.php';

class InsumoHospitalizacionController {
    
    public function InsumoHospitalizacionController(){}
    
public function CrearInsumoHospitalizacion($p_idinsumo, $p_idhospitalizacion, $p_cantidad, $p_fecha)
{
    $affected=0;
    $bd=new con_mysqli("", "", "", "");
    
    ##Validar Iny Sql
        $p_idinsumo=$bd->real_scape_string($p_idinsumo);
        $p_idhospitalizacion=$bd->real_scape_string($p_idhospitalizacion);
        $p_cantidad=$bd->real_scape_string($p_cantidad);
        $p_fecha=$bd->real_scape_string($p_fecha);
                
        $consulta="INSERT INTO `insumo_hospitalizacion` (`idinsumo`, `idhospitalizacion`, `cantidadinsumo`, `fecha`) VALUES ('$p_idinsumo', '$p_idhospitalizacion', '$p_cantidad', '$p_fecha')";
        
        $r=$bd->consulta($consulta);
        if($r)
        {
            $affected=$bd->affected_row();
        }
        $bd->Close();
        return $affected;
        
}

public function ModificarInsumoHospitalizacion($p_id,$p_idinsumo,$p_idhospitalizacion, $p_cantidadinsumo, $p_fecha)
    {
        $affected=0;
        $bd=new con_mysqli("", "", "", "");
        
        ##Validar Iny Sql
        $p_id=$bd->real_scape_string($p_id);
        $p_idinsumo=$bd->real_scape_string($p_idinsumo);
        $p_idhospitalizacion=$bd->real_scape_string($p_idhospitalizacion);
        $p_cantidadinsumo=$bd->real_scape_string($p_cantidadinsumo);
        $p_fecha=$bd->real_scape_string($p_fecha);
                
        $consulta="UPDATE `insumo_hospitalizacion` SET `idinsumo`='$p_idinsumo', `idhospitalizacion`='$p_idhospitalizacion', `cantidadinsumo`='$p_cantidadinsumo', `fecha`='$p_fecha' WHERE (`idih`='$p_id')";
        
        $r=$bd->consulta($consulta);
        if($r)
        {
            $affected=$bd->affected_row();
            if($affected==0){$affected=1;}
        }
        $bd->Close();
        return $affected;
    }
      
    public function EliminarInsumoHospitalizacion($p_id)
    {
        $affected=0;
        $bd=new con_mysqli("", "", "", "");
        
        ##Validar Iny Sql
        $p_id=$bd->real_scape_string($p_id);
        
        $consulta="DELETE FROM `insumo_hospitalizacion` WHERE (`idih`='$p_id')";
        
        $r=$bd->consulta($consulta);
        if($r)
        {
            $affected=$bd->affected_row();
        }
        $bd->Close();
        return $affected;
        
    }
    
    public function MostrarInsumoHospitalizacion()
    {
        $result=array();
        $bd= new con_mysqli("", "", "", "");
        $consulta="SELECT * FROM `insumo_hospitalizacion` order by `idih` ASC";
        $r=$bd->consulta($consulta);
        if($r)
        {
            $a=0;
            while ($fila=$bd->fetch_assoc($r))
            {
               
                $p_id=$fila["idih"];
                $p_idinsumo=$fila["idinsumo"];
                $p_idhospitalizacion=$fila["idhospitalizacion"];
                $p_cantidadinsumo=$fila["cantidadinsumo"];
                $p_fecha=$fila["fecha"];
                                                
                $objInsumoHospitalizacion=new InsumoHospitalizacion($p_id, $p_idinsumo, $p_idhospitalizacion, $p_fecha, $p_cantidadinsumo);
                $result[$a]=$objInsumoHospitalizacion;
                $a++;
            }
        }
        $bd->Close();
        return $result;
    }
    
    public function BuscarInsumoHospitalizacion($p_id, $p_idinsumo, $p_idhospitalizacion)
    {
        $result=array();
        $bd= new con_mysqli("", "", "", "");
        $consulta="SELECT * FROM `insumo_hospitalizacion` ";
        
        if($p_id!="")
        {
            $consulta=$consulta."WHERE `idih`='$p_id'";
        }
        if($p_idinsumo!="")
        {
            if($p_id=="")
            {
                $consulta=$consulta."WHERE `idinsumo`='$p_idinsumo'";
            }
            else 
            {
                $consulta=$consulta." and `idinsumo`='$p_idinsumo'";
            }
        }   
        if($p_idhospitalizacion!="")
        {
            if($p_id=="" && $p_idinsumo=="")
            {
                $consulta=$consulta."WHERE `idhospitalizacion`='$p_idhospitalizacion'";
            }
            else 
            {
                $consulta=$consulta." and `idhospitalizacion`='$p_idhospitalizacion'";
            }
        }  
        
        $consulta=$consulta." order by `idih` ASC";
       
        $r=$bd->consulta($consulta);
        if($r)
        {
            $a=0;
            while ($fila=$bd->fetch_assoc($r))
            {
                 
                $p_id=$fila["idih"];
                $p_idinsumo=$fila["idinsumo"];
                $p_idhospitalizacion=$fila["idhospitalizacion"];
                $p_cantidadinsumo=$fila["cantidadinsumo"];
                $p_fecha=$fila["fecha"];
                                                
                $objInsumoHospitalizacion=new InsumoHospitalizacion($p_id, $p_idinsumo, $p_idhospitalizacion, $p_fecha, $p_cantidadinsumo);
                $result[$a]=$objInsumoHospitalizacion;
                $a++;
            }
        }
        $bd->Close();
        return $result;
        
    }
    
    public function CargarInsumoHospitalizacion($search)
    {
        $result=array();
        $bd= new con_mysqli("", "", "", "");
        
        ##Validar parametros
        $search=$bd->real_scape_string($search);
        
        $consulta="SELECT * FROM `insumo_hospitalizacion` WHERE `idih` LIKE '%$search%'";
        $r=$bd->consulta($consulta);
        if($r)
        {
            $a=0;
            while ($fila=$bd->fetch_assoc($r))
            {
                $bd_id=$fila["idih"];
                $result[$a]=$bd_id;
                $a++;
            }
        }
        $bd->Close();
        
        return $result;
    }
    
     
   
    public function CantidadPorInsumos($id_insumo)
   {
        $result=array();
        $bd= new con_mysqli("", "", "", "");
        $consulta="SELECT SUM(cantidadinsumo) from insumo_hospitalizacion WHERE idinsumo='$id_insumo'";
        
        $r=$bd->consulta($consulta);
        if($r)
        {
            $a=0;
            while ($fila=$bd->fetch_array($r))
            {
                 
                $sum=$fila[0];
                $result[$a]=$sum;
                $a++;
            }
        }
        $bd->Close();
        
        return $result;
   }
}

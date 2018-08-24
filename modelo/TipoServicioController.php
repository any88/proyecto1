<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of TipoServicioController
 *
 * @author MARGOTH TAPIA
 */

include '../Modelo/TipoServicio.php';

class TipoServicioController {
    
    public function TipoServicioController(){}
    
public function CrearTipoServicio($p_tiposervicio,$precio_base)
{
    $affected=0;
    $bd=new con_mysqli("", "", "", "");
    
    ##Validar Iny Sql
        $p_tiposervicio=$bd->real_scape_string($p_tiposervicio);
        $precio_base=$bd->real_scape_string($precio_base);
        
        $consulta="INSERT INTO `tiposervicio` (`tiposervicio`,`precio_base`) VALUES ('$p_tiposervicio','$precio_base')";
        
        $r=$bd->consulta($consulta);
        if($r)
        {
            $affected=$bd->affected_row();
        }
        $bd->Close();
        return $affected;
        
}

public function ModificarTipoServicio($p_id, $p_tiposervicio,$precio_base)
    {
        $affected=0;
        $bd=new con_mysqli("", "", "", "");
        
        ##Validar Iny Sql
        $p_id=$bd->real_scape_string($p_id);
        $p_tiposervicio=$bd->real_scape_string($p_tiposervicio);
        $precio_base=$bd->real_scape_string($precio_base);
        
        $consulta="UPDATE `tiposervicio` SET `tiposervicio`='$p_tiposervicio',`precio_base`='$precio_base' WHERE (`idtiposervicio`='$p_id')";
        
        $r=$bd->consulta($consulta);
        if($r)
        {
            $affected=$bd->affected_row();
            if($affected==0){$affected=1;}
        }
        $bd->Close();
        return $affected;
    }
    
    public function EliminarTipoServicio($p_id)
    {
        $affected=0;
        $bd=new con_mysqli("", "", "", "");
        
        ##Validar Iny Sql
        $p_id=$bd->real_scape_string($p_id);
        
        $consulta="DELETE FROM `tiposervicio` WHERE (`idtiposervicio`='$p_id')";
        
        $r=$bd->consulta($consulta);
        if($r)
        {
            $affected=$bd->affected_row();
        }
        $bd->Close();
        return $affected;
        
    }
    
    public function MostrarTipoServicio()
    {
        $result=array();
        $bd= new con_mysqli("", "", "", "");
        $consulta="SELECT * FROM `tiposervicio` order by `tiposervicio` ASC";
        $r=$bd->consulta($consulta);
        if($r)
        {
            $a=0;
            while ($fila=$bd->fetch_assoc($r))
            {
               
                $p_id=$fila["idtiposervicio"];
                $p_tiposervicio=$fila["tiposervicio"];
                $p_preciob=$fila['precio_base']; 
                $objTipoServicio=new TipoServicio($p_id, $p_tiposervicio,$p_preciob);
                $result[$a]=$objTipoServicio;
                $a++;
            }
        }
        $bd->Close();
        return $result;
    }
    
    public function BuscarTipoServicio($p_id, $p_tiposervicio)
    {
        $result=array();
        $bd= new con_mysqli("", "", "", "");
        $consulta="SELECT * FROM `tiposervicio` ";
        
        if($p_id!="")
        {
            $consulta=$consulta."WHERE `idtiposervicio`='$p_id'";
        }
        if($p_tiposervicio!="")
        {
            if($p_id=="")
            {
                $consulta=$consulta."WHERE `tiposervicio`='$p_tiposervicio'";
            }
            else 
            {
                $consulta=$consulta." and `tiposervicio`='$p_tiposervicio'";
            }
        }      
        
        $consulta=$consulta." order by `idtiposervicio` ASC";
        $r=$bd->consulta($consulta);
        if($r)
        {
            $a=0;
            while ($fila=$bd->fetch_assoc($r))
            {
                 
                $p_id=$fila["idtiposervicio"];
                $p_tiposervicio=$fila["tiposervicio"];
                $p_preciob=$fila['precio_base']; 
                $objTipoServicio=new TipoServicio($p_id, $p_tiposervicio,$p_preciob);
                $result[$a]=$objTipoServicio;
                $a++;
            }
        }
        $bd->Close();
        return $result;
        
    }
    
    public function CargarTipoServicio($search)
    {
        $result=array();
        $bd= new con_mysqli("", "", "", "");
        
        ##Validar parametros
        $search=$bd->real_scape_string($search);
        
        $consulta="SELECT * FROM `tiposervicio` WHERE `idtiposervicio` LIKE '%$search%'";
        $r=$bd->consulta($consulta);
        if($r)
        {
            $a=0;
            while ($fila=$bd->fetch_assoc($r))
            {
                $bd_idservicio=$fila["idtiposervicio"];
                $result[$a]=$bd_idservicio;
                $a++;
            }
        }
        $bd->Close();
        
        return $result;
    }
    public function CargarTipoServicioID($search)
    {
        $result=array();
        $bd= new con_mysqli("", "", "", "");
        
        ##Validar parametros
        $search=$bd->real_scape_string($search);
    
        $consulta="SELECT * FROM `tiposervicio` WHERE `idtiposervicio` LIKE '%$search%'";
        $r=$bd->consulta($consulta);
        if($r)
        {
            $a=0;
            while ($fila=$bd->fetch_assoc($r))
            {
                $bd_idtiposervicio=$fila["idtiposervicio"];
                $bd_tiposervicio=$fila["tiposervicio"];
                $result[$a]="($bd_idtiposervicio) ".$bd_tiposervicio;
                $a++;
            }
        }
        $bd->Close();
    
        return $result;
    }
}

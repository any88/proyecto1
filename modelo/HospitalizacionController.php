<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of HospitalizacionController
 *
 * @author MARGOTH TAPIA
 */

include '../Modelo/Hospitalizacion.php';

class HospitalizacionController {
    
    public function HospitalizacionController(){}
    
public function CrearHospitalizacion($p_idservicio, $p_fechaingreso, $p_fechaalta, $p_duracion, $p_tipohabitacion, $p_nrocama, $p_nombrefamiliar, $p_parentescofamiliar, $p_estadopaciente, $p_condicionatencion, $p_pa, $p_pulso, $p_temp, $p_peso, $p_examenfisico)
{
    $affected=0;
    $bd=new con_mysqli("", "", "", "");
    
    ##Validar Iny Sql
        $p_fechaingreso=$bd->real_scape_string($p_fechaingreso);
        $p_fechaalta=$bd->real_scape_string($p_fechaalta);
        $p_duracion=$bd->real_scape_string($p_duracion);
        $p_tipohabitacion=$bd->real_scape_string($p_tipohabitacion);
        $p_nrocama=$bd->real_scape_string($p_nrocama);
        $p_nombrefamiliar=$bd->real_scape_string($p_nombrefamiliar);
        $p_parentescofamiliar=$bd->real_scape_string($p_parentescofamiliar);
        $p_estadopaciente=$bd->real_scape_string($p_estadopaciente);
        $p_condicionatencion=$bd->real_scape_string($p_condicionatencion);
        $p_pa=$bd->real_scape_string($p_pa);
        $p_pulso=$bd->real_scape_string($p_pulso);
        $p_temp=$bd->real_scape_string($p_temp);
        $p_peso=$bd->real_scape_string($p_peso);
        $p_examenfisico=$bd->real_scape_string($p_examenfisico);
                
        $consulta="INSERT INTO `hospitalizacion` (`idservicio`, `fechaingreso`, `fechaalta`, `duracion`, `tipohabitacion`, `nrocama`, `nombrefamiliar`, `parentescofamiliar`, `estadodelpaciente`, `condiciondeatencion`, `pa`, `pulso`, `temp`, `peso`, `examenfisico`) VALUES ('$p_idservicio', '$p_fechaingreso', '$p_fechaalta', '$p_duracion', '$p_tipohabitacion', '$p_nrocama', '$p_nombrefamiliar', '$p_parentescofamiliar', '$p_estadopaciente', '$p_condicionatencion', '$p_pa', '$p_pulso', '$p_temp', '$p_peso', '$p_examenfisico')";
        
        $r=$bd->consulta($consulta);
        if($r)
        {
            $affected=$bd->affected_row();
            if($affected==1)
            {
                $consulta="SELECT LAST_INSERT_ID()";
                $r=$bd->consulta($consulta);
                if($r)
                {
                    $fila=$bd->fetch_array($r);
                    $affected=$fila[0];
                }
                
            }
        }
        $bd->Close();
        return $affected;
        
}

public function ModificarHospitalizacion($p_id, $p_fechaingreso, $p_fechaalta, $p_duracion, $p_tipohabitacion, $p_nrocama, $p_nombrefamiliar, $p_parentescofamiliar, $p_estadopaciente, $p_condicionatencion, $p_pa, $p_pulso, $p_temp, $p_peso, $p_examenfisico)
    {
        $affected=0;
        $bd=new con_mysqli("", "", "", "");
        
        ##Validar Iny Sql
        $p_id=$bd->real_scape_string($p_id);
        $p_fechaingreso=$bd->real_scape_string($p_fechaingreso);
        $p_fechaalta=$bd->real_scape_string($p_fechaalta);
        $p_duracion=$bd->real_scape_string($p_duracion);
        $p_tipohabitacion=$bd->real_scape_string($p_tipohabitacion);
        $p_nrocama=$bd->real_scape_string($p_nrocama);
        $p_nombrefamiliar=$bd->real_scape_string($p_nombrefamiliar);
        $p_parentescofamiliar=$bd->real_scape_string($p_parentescofamiliar);
        $p_estadopaciente=$bd->real_scape_string($p_estadopaciente);
        $p_condicionatencion=$bd->real_scape_string($p_condicionatencion);
        $p_pa=$bd->real_scape_string($p_pa);
        $p_pulso=$bd->real_scape_string($p_pulso);
        $p_temp=$bd->real_scape_string($p_temp);
        $p_peso=$bd->real_scape_string($p_peso);
        $p_examenfisico=$bd->real_scape_string($p_examenfisico);
                
        $consulta="UPDATE `hospitalizacion` SET `fechaingreso`='$p_fechaingreso', `fechaalta`='$p_fechaalta', `duracion`='$p_duracion', `tipohabitacion`='$p_tipohabitacion', `nrocama`='$p_nrocama', `nombrefamiliar`='$p_nombrefamiliar', `parentescofamiliar`='$p_parentescofamiliar', `estadodelpaciente`='$p_estadopaciente', `condiciondeatencion`='$p_condicionatencion', `pa`='$p_pa', `pulso`='$p_pulso', `temp`='$p_temp', `peso`='$p_peso', `examenfisico`='$p_examenfisico' WHERE (`idhospitalizacion`='$p_id')";
        
        $r=$bd->consulta($consulta);
        if($r)
        {
            $affected=$bd->affected_row();
        }
        $bd->Close();
        return $affected;
    }
    
    public function EliminarHospitalizacion($p_id)
    {
        $affected=0;
        $bd=new con_mysqli("", "", "", "");
        
        ##Validar Iny Sql
        $p_id=$bd->real_scape_string($p_id);
        
        $consulta="DELETE FROM `hospitalizacion` WHERE (`idhospitalizacion`='$p_id')";
        
        $r=$bd->consulta($consulta);
        if($r)
        {
            $affected=$bd->affected_row();
        }
        $bd->Close();
        return $affected;
        
    }
    
    public function MostrarHospitalizacion()
    {
        $result=array();
        $bd= new con_mysqli("", "", "", "");
        $consulta="SELECT * FROM `hospitalizacion` order by `idhospitalizacion` ASC";
        $r=$bd->consulta($consulta);
        if($r)
        {
            $a=0;
            while ($fila=$bd->fetch_assoc($r))
            {
               
                $p_id=$fila["idhospitalizacion"];
                $p_fechaingreso=$fila["fechaingreso"];
                $p_fechaalta=$fila["fechaalta"];
                $p_duracion=$fila["duracion"];
                $p_tipohabitacion=$fila["tipohabitacion"];
                $p_nrocama=$fila["nrocama"];
                $p_nombrefamiliar=$fila["nombrefamiliar"];
                $p_parentescofamiliar=$fila["parentescofamiliar"];
                $p_estadopaciente=$fila["estadodelpaciente"];
                $p_condicionatencion=$fila["condiciondeatencion"];
                $p_pa=$fila["pa"];
                $p_pulso=$fila["pulso"];
                $p_temp=$fila["temp"];
                $p_peso=$fila["peso"];
                $p_examenfisico=$fila["examenfisico"];
                                                             
                $objHospitalizacion=new Hospitalizacion($p_id, $p_fechaingreso, $p_fechaalta, $p_duracion, $p_tipohabitacion, $p_nrocama, $p_nombrefamiliar, $p_parentescofamiliar, $p_estadopaciente, $p_condicionatencion, $p_pa, $p_pulso, $p_temp, $p_peso, $p_examenfisico);
                $result[$a]=$objHospitalizacion;
                $a++;
            }
        }
        $bd->Close();
        return $result;
    }
    public function AltaPaciente($id_hosp,$fecha)
    {
        $affected=0;
        $bd=new con_mysqli("", "", "", "");
        $fecha=$bd->real_scape_string($fecha);
        $id_hosp=$bd->real_scape_string($id_hosp);
        
        $consulta="UPDATE `hospitalizacion` SET `fechaalta`='$fecha' WHERE (`idhospitalizacion`='$id_hosp')";
        
        $r=$bd->consulta($consulta);
        if($r)
        {
            $affected=$bd->affected_row();
        }
        $bd->Close();
        return $affected;
    }

    public function BuscarHospitalizacion($p_id, $p_fechaingreso, $p_idservicio=null)
    {
        $result=array();
        $bd= new con_mysqli("", "", "", "");
        $consulta="SELECT * FROM `hospitalizacion` ";
        
        if($p_id!="")
        {
            $consulta=$consulta."WHERE `idhospitalizacion`='$p_id'";
        }
        if($p_fechaingreso!="")
        {
            if($p_id=="")
            {
                $consulta=$consulta."WHERE `fechaingreso`='$p_fechaingreso'";
            }
            else 
            {
                $consulta=$consulta." and `fechaingreso`='$p_fechaingreso'";
            }
        }
        if($p_idservicio!="")
        {
            if($p_id=="" && $p_fechaingreso=="")
            {
                $consulta=$consulta."WHERE `idservicio`='$p_idservicio'";
            }
            else 
            {
                $consulta=$consulta." and `idservicio`='$p_idservicio'";
            }
        }
        
        $consulta=$consulta." order by `idhospitalizacion` ASC";
       
        $r=$bd->consulta($consulta);
        if($r)
        {
            $a=0;
            while ($fila=$bd->fetch_assoc($r))
            {
                 
                $p_serv=$fila["idservicio"];
                $p_id=$fila["idhospitalizacion"];
                $p_fechaingreso=$fila["fechaingreso"];
                $p_fechaalta=$fila["fechaalta"];
                $p_duracion=$fila["duracion"];
                $p_tipohabitacion=$fila["tipohabitacion"];
                $p_nrocama=$fila["nrocama"];
                $p_nombrefamiliar=$fila["nombrefamiliar"];
                $p_parentescofamiliar=$fila["parentescofamiliar"];
                $p_estadopaciente=$fila["estadodelpaciente"];
                $p_condicionatencion=$fila["condiciondeatencion"];
                $p_pa=$fila["pa"];
                $p_pulso=$fila["pulso"];
                $p_temp=$fila["temp"];
                $p_peso=$fila["peso"];
                $p_examenfisico=$fila["examenfisico"];
                                                
                $objHospitalizacion=new Hospitalizacion($p_serv, $p_id, $p_fechaingreso, $p_fechaalta, $p_duracion, $p_tipohabitacion, $p_nrocama, $p_nombrefamiliar, $p_parentescofamiliar, $p_estadopaciente, $p_condicionatencion, $p_pa, $p_pulso, $p_temp, $p_peso, $p_examenfisico);
                $result[$a]=$objHospitalizacion;
                $a++;
            }
        }
        $bd->Close();
        return $result;
        
    }
    
    public function CargarHospitalizacion($search)
    {
        $result=array();
        $bd= new con_mysqli("", "", "", "");
        
        ##Validar parametros
        $search=$bd->real_scape_string($search);
        
        $consulta="SELECT * FROM `hospitalizacion` WHERE `idhospitalizacion` LIKE '%$search%'";
        $r=$bd->consulta($consulta);
        if($r)
        {
            $a=0;
            while ($fila=$bd->fetch_assoc($r))
            {
                $bd_id=$fila["idhospitalizacion"];
                $result[$a]=$bd_id;
                $a++;
            }
        }
        $bd->Close();
        
        return $result;
    }
    public function CargarHospitalizacionID($search)
    {
        $result=array();
        $bd= new con_mysqli("", "", "", "");
        
        ##Validar parametros
        $search=$bd->real_scape_string($search);
    
        $consulta="SELECT * FROM `hospitalizacion` WHERE `idhospitalizacion` LIKE '%$search%'";
        $r=$bd->consulta($consulta);
        if($r)
        {
            $a=0;
            while ($fila=$bd->fetch_assoc($r))
            {
                $bd_id=$fila["idhospitalizacion"];
                $result[$a]="($bd_id)";
                $a++;
            }
        }
        $bd->Close();
    
        return $result;
    }
}

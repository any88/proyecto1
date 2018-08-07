<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of CirugiaController
 *
 * @author MARGOTH TAPIA
 */

include '../Modelo/Cirugia.php';

class CirugiaController {
        
    public function CirugiaController(){}
    
public function CrearCirugia($p_idservicio, $p_idespecialidad, $p_idnombrec, $p_duracion)
{
    $affected=0;
    $bd=new con_mysqli("", "", "", "");
    
    ##Validar Iny Sql
        $p_idservicio=$bd->real_scape_string($p_idservicio);
        $p_idespecialidad=$bd->real_scape_string($p_idespecialidad);
        $p_idnombrec=$bd->real_scape_string($p_idnombrec);
        $p_duracion=$bd->real_scape_string($p_duracion);
                                
        $consulta="INSERT INTO `cirugia` (`idservicio`, `idespecialidad`, `idnombrec`, `duracion`) VALUES ('$p_idservicio', '$p_idespecialidad', '$p_idnombrec', '$p_duracion')";
        
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

public function ModificarCirugia($p_id,$p_idespecialidad,$p_idnombrec,$p_duracion)
    {
        $affected=0;
        $bd=new con_mysqli("", "", "", "");
        
        ##Validar Iny Sql
        $p_idespecialidad=$bd->real_scape_string($p_idespecialidad);
        $p_idnombrec=$bd->real_scape_string($p_idnombrec);
        $p_duracion=$bd->real_scape_string($p_duracion);
                       
        $consulta="UPDATE `cirugia` SET `idespecialidad`='$p_idespecialidad', `idnombrec`='$p_idnombrec', `duracion`='$p_duracion' WHERE (`idcirugia`='$p_id')";
        
        $r=$bd->consulta($consulta);
        if($r)
        {
            $affected=$bd->affected_row();
        }
        $bd->Close();
        return $affected;
    }
    
    public function EliminarCirugia($p_id)
    {
        $affected=0;
        $bd=new con_mysqli("", "", "", "");
        
        ##Validar Iny Sql
        $p_id=$bd->real_scape_string($p_id);
        
        $consulta="DELETE FROM `cirugia` WHERE (`idcirugia`='$p_id')";
        
        $r=$bd->consulta($consulta);
        if($r)
        {
            $affected=$bd->affected_row();
        }
        $bd->Close();
        return $affected;
        
    }
    
    public function MostrarCirugia()
    {
        $result=array();
        $bd= new con_mysqli("", "", "", "");
        $consulta="SELECT * FROM `cirugia` order by `idcirugia` ASC";
        $r=$bd->consulta($consulta);
        if($r)
        {
            $a=0;
            while ($fila=$bd->fetch_assoc($r))
            {
               
                $p_idcirugia=$fila["idcirugia"];
                $p_idnombrec=$fila["idnombrec"];
                $p_duracion=$fila["duracion"];
                $p_idservicio=$fila["idservicio"];
                $p_idespecialidad=$fila["idespecialidad"];
               
                $objCirugia=new Cirugia($p_idservicio, $p_idcirugia, $p_idespecialidad, $p_idnombrec, $p_duracion);
                $result[$a]=$objCirugia;
                $a++;
            }
        }
        $bd->Close();
        return $result;
    }
    
    public function BuscarCirugia($p_idcirugia, $p_idespecialidad, $p_idnombrec,$id_servicio=null,$id_rol_cirugia=null)
    {
        $result=array();
        $bd= new con_mysqli("", "", "", "");
        $consulta="SELECT * FROM `cirugia` ";
        
        if($p_idcirugia!="")
        {
            $consulta=$consulta."WHERE `idcirugia`='$p_idcirugia'";
        }
        if($p_idespecialidad!="")
        {
            if($p_idcirugia=="")
            {
                $consulta=$consulta."WHERE `idespecialidad`='$p_idespecialidad'";
            }
            else 
            {
                $consulta=$consulta." and `idespecialidad`='$p_idespecialidad'";
            }
        }
        if($p_idnombrec!="")
        {
            if($p_idcirugia=="" && $p_idespecialidad=="")
            {
                $consulta=$consulta."WHERE `idnombrec`='$p_idnombrec'";
            }
            else 
            {
                $consulta=$consulta." and `idnombrec`='$p_idnombrec'";
            }
         }
         if($id_servicio!="")
        {
            if($p_idcirugia=="" && $p_idespecialidad=="" && $p_idnombrec=="")
            {
                $consulta=$consulta."WHERE `idservicio`='$id_servicio'";
            }
            else 
            {
                $consulta=$consulta." and `idservicio`='$id_servicio'";
            }
         }
          if($id_rol_cirugia!="")
        {
            if($p_idcirugia=="" && $p_idespecialidad=="" && $p_idnombrec=="" && $id_servicio=="")
            {
                $consulta=$consulta."WHERE `id_rol_cirugia`='$id_rol_cirugia'";
            }
            else 
            {
                $consulta=$consulta." and `id_rol_cirugia`='$id_rol_cirugia'";
            }
         }
        
        $consulta=$consulta." order by `idcirugia` ASC";
        //Mostrar($consulta);
        $r=$bd->consulta($consulta);
        if($r)
        {
            $a=0;
            while ($fila=$bd->fetch_assoc($r))
            {
                 
                $p_idcirugia=$fila["idcirugia"];
                $p_idnombrec=$fila["idnombrec"];
                $p_duracion=$fila["duracion"];
                $p_idservicio=$fila["idservicio"];
                $p_idespecialidad=$fila["idespecialidad"];
               
                $objCirugia=new Cirugia($p_idservicio, $p_idcirugia, $p_idespecialidad, $p_idnombrec, $p_duracion);
                
                $result[$a]=$objCirugia;
                $a++;
            }
        }
        $bd->Close();
        return $result;
        
    }
    
    public function CargarCirugiaID($search)
    {
        $result=array();
        $bd= new con_mysqli("", "", "", "");
        
        ##Validar parametros
        $search=$bd->real_scape_string($search);
        
        $consulta="SELECT * FROM `cirugia` WHERE `idcirugia` LIKE '%$search%'";
        $r=$bd->consulta($consulta);
        if($r)
        {
            $a=0;
            while ($fila=$bd->fetch_assoc($r))
            {
                $bd_cirugia=$fila["idcirugia"];
                $result[$a]=$bd_cirugia;
                $a++;
            }
        }
        $bd->Close();
        
        return $result;
    }
    public function CargarCirugia($search)
    {
        $result=array();
        $bd= new con_mysqli("", "", "", "");
        
        ##Validar parametros
        $search=$bd->real_scape_string($search);
    
        $consulta="SELECT * FROM `cirugia` WHERE `idcirugia` LIKE '%$search%'";
        $r=$bd->consulta($consulta);
        if($r)
        {
            $a=0;
            while ($fila=$bd->fetch_assoc($r))
            {
                $bd_idcirugia=$fila["idcirugia"];
                $bd_idnombrec=$fila["idnombrec"];
                $result[$a]="($bd_idcirugia) ".$bd_idnombrec;
                $a++;
            }
        }
        $bd->Close();
    
        return $result;
    }
}

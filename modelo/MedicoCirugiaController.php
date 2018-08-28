<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of MedicoCirugiaController
 *
 * @author MARGOTH TAPIA
 */

include '../modelo/MedicoCirugia.php';

class MedicoCirugiaController {
    
    public function MedicoCirugiaController(){}
    
public function CrearMedicoCirugia($p_idmedico, $p_idcirugia, $p_fecha, $p_idtransaccion,$prol,$p_idTrabajador)
{
    $affected=0;
    $bd=new con_mysqli("", "", "", "");
    
    ##Validar Iny Sql
        $p_idmedico=$bd->real_scape_string($p_idmedico);
        $p_idcirugia=$bd->real_scape_string($p_idcirugia);
        $p_fecha=$bd->real_scape_string($p_fecha);
        $p_idtransaccion=$bd->real_scape_string($p_idtransaccion);
        $prol=$bd->real_scape_string($prol);
        $p_idTrabajador=$bd->real_scape_string($p_idTrabajador);
        if($p_idmedico!="")
        {
            $consulta="INSERT INTO `medico_cirugia` (`idmedico`, `idcirugia`, `fecha`,`id_rol_cirugia`) VALUES ('$p_idmedico', '$p_idcirugia', '$p_fecha', '$prol')";
        }
        if($p_idTrabajador!="")
        {
            $consulta="INSERT INTO `medico_cirugia` (`idcirugia`, `fecha`,`id_rol_cirugia`,`id_trabajador`) VALUES ('$p_idcirugia', '$p_fecha', '$prol','$p_idTrabajador')";
        }
        
        $r=$bd->consulta($consulta);
        //Mostrar($consulta);
        if($r)
        {
            $affected=$bd->affected_row();
        }
        $bd->Close();
        return $affected;
        
}

public function ModificarMedicoCirugia($p_id,$p_idmedico,$p_idcirugia,$p_fecha,$p_idtransaccion,$id_trabajador)
    {
        $affected=0;
        $bd=new con_mysqli("", "", "", "");
        
        ##Validar Iny Sql
        $p_id=$bd->real_scape_string($p_id);
        $p_fecha=$bd->real_scape_string($p_fecha);
        $p_idmedico=$bd->real_scape_string($p_idmedico);
        $p_idcirugia=$bd->real_scape_string($p_idcirugia);
        $p_idtransaccion=$bd->real_scape_string($p_idtransaccion);
        $id_trabajador=$bd->real_scape_string($id_trabajador);
               
        $consulta="UPDATE `medico_cirugia` SET `fecha`='$p_fecha', `idmedico`='$p_idmedico', `idcirugia`='$p_idcirugia', `idtransaccion`='$p_idtransaccion',`id_trabajador`='$id_trabajador' WHERE (`id_med_cirugia`='$p_id')";
        
        $r=$bd->consulta($consulta);
        if($r)
        {
            $affected=$bd->affected_row();
        }
        $bd->Close();
        return $affected;
    }
    public function ModificarCirujanoPrincipal($p_idmedico,$p_idcirugia)
    {
        $affected=0;
        $bd=new con_mysqli("", "", "", "");
        
        ##Validar Iny Sql
        $p_idmedico=$bd->real_scape_string($p_idmedico);
        $p_idcirugia=$bd->real_scape_string($p_idcirugia);
         
        $consulta="UPDATE `medico_cirugia` SET  `idmedico`='$p_idmedico'  WHERE (`idcirugia`='$p_idcirugia' and `id_rol_cirugia`='1')";
        
        $r=$bd->consulta($consulta);
        if($r)
        {
            $affected=$bd->affected_row();
        }
        $bd->Close();
        return $affected;
    }
    public function EliminarMedicoCirugia($p_id)
    {
        $affected=0;
        $bd=new con_mysqli("", "", "", "");
        
        ##Validar Iny Sql
        $p_id=$bd->real_scape_string($p_id);
        
        $consulta="DELETE FROM `medico_cirugia` WHERE (`id_med_cirugia`='$p_id')";
        
        $r=$bd->consulta($consulta);
        if($r)
        {
            $affected=$bd->affected_row();
        }
        $bd->Close();
        return $affected;
        
    }
    public function EliminarPordCirugia($p_id_cirugia)
    {
        $affected=0;
        $bd=new con_mysqli("", "", "", "");
        
        ##Validar Iny Sql
        $p_id_cirugia=$bd->real_scape_string($p_id_cirugia);
        
        $consulta="DELETE FROM `medico_cirugia` WHERE (`idcirugia`='$p_id_cirugia' and `id_rol_cirugia`!='1')";
        
        
        $r=$bd->consulta($consulta);
        if($r)
        {
            $affected=$bd->affected_row();
            if($affected==0){$affected=1;}
        }
        $bd->Close();
        return $affected;
        
    }
    
    public function MostrarMedicoCirugia()
    {
        $result=array();
        $bd= new con_mysqli("", "", "", "");
        $consulta="SELECT * FROM `medico_cirugia` order by `id_med_cirugia` ASC";
        $r=$bd->consulta($consulta);
        if($r)
        {
            $a=0;
            while ($fila=$bd->fetch_assoc($r))
            {
               
                $p_id=$fila["id_med_cirugia"];
                $p_idmedico=$fila["idmedico"];
                $p_fecha=$fila["fecha"];
                $p_idcirugia=$fila["idcirugia"];
                $p_idtransaccion=$fila["idtransaccion"];
                $prol=$fila["id_rol_cirugia"];
                $p_id_trabajador=$fila['id_trabajador'];                                         
                $objMedicoCirugia=new MedicoCirugia($p_id, $p_idmedico, $p_idcirugia, $p_fecha, $p_idtransaccion,$prol,$p_id_trabajador);
                $result[$a]=$objMedicoCirugia;
                $a++;
            }
        }
        $bd->Close();
        return $result;
    }
    
    public function BuscarMedicoCirugia($p_idmc, $p_idmedico, $p_idcirugia,$rol=null,$id_trabajador=null)
    {
        $result=array();
        $bd= new con_mysqli("", "", "", "");
        $consulta="SELECT * FROM `medico_cirugia` ";
        
        if($p_idmc!="")
        {
            $consulta=$consulta."WHERE `id_med_cirugia`='$p_idmc'";
        }
        if($p_idmedico!="")
        {
            if($p_idmc=="")
            {
                $consulta=$consulta."WHERE `idmedico`='$p_idmedico'";
            }
            else 
            {
                $consulta=$consulta." and `idmedico`='$p_idmedico'";
            }
        }
        if($p_idcirugia!="")
        {
            if($p_idmc=="" && $p_idmedico=="")
            {
                $consulta=$consulta."WHERE `idcirugia`='$p_idcirugia'";
            }
            else 
            {
                $consulta=$consulta." and `idcirugia`='$p_idcirugia'";
            }
         }
         if($rol!="")
        {
            if($p_idmc=="" && $p_idmedico=="" && $p_idcirugia=="")
            {
                $consulta=$consulta."WHERE `id_rol_cirugia`='$rol'";
            }
            else 
            {
                $consulta=$consulta." and `id_rol_cirugia`='$rol'";
            }
         }
         if($id_trabajador!="")
        {
            if($p_idmc=="" && $p_idmedico=="" && $p_idcirugia=="" && $rol=="")
            {
                $consulta=$consulta."WHERE `id_trabajador`='$id_trabajador'";
            }
            else 
            {
                $consulta=$consulta." and `id_trabajador`='$id_trabajador'";
            }
         }
         
        
        $consulta=$consulta." order by `idmc` ASC";
       
        $r=$bd->consulta($consulta);
        if($r)
        {
            $a=0;
            while ($fila=$bd->fetch_assoc($r))
            {
                 
                $p_id=$fila["idmc"];
                $p_idmedico=$fila["idmedico"];
                $p_idcirugia=$fila["idcirugia"];
                $p_fecha=$fila["fecha"];
                $p_idtransaccion=$fila["idtransaccion"];
                $prol=$fila["id_rol_cirugia"];
                $p_id_trabajador=$fila['id_trabajador'];                                         
                $objMedicoCirugia=new MedicoCirugia($p_id, $p_idmedico, $p_idcirugia, $p_fecha, $p_idtransaccion,$prol,$p_id_trabajador);
                $result[$a]=$objMedicoCirugia;
                $a++;
            }
        }
        
        $bd->Close();
        return $result;
        
    }
    
    public function CargarMedicoCirugiaID($search)
    {
        $result=array();
        $bd= new con_mysqli("", "", "", "");
        
        ##Validar parametros
        $search=$bd->real_scape_string($search);
        
        $consulta="SELECT * FROM `medico_cirugia` WHERE `id_med_cirugia` LIKE '%$search%'";
        $r=$bd->consulta($consulta);
        if($r)
        {
            $a=0;
            while ($fila=$bd->fetch_assoc($r))
            {
                $bd_id=$fila["id_med_cirugia"];
                $result[$a]=$bd_id;
                $a++;
            }
        }
        $bd->Close();
        
        return $result;
    }
    public function CargarMedicoCirugia($search)
    {
        $result=array();
        $bd= new con_mysqli("", "", "", "");
        
        ##Validar parametros
        $search=$bd->real_scape_string($search);
    
        $consulta="SELECT * FROM `medico_cirugia` WHERE `id_med_cirugia` LIKE '%$search%'";
        $r=$bd->consulta($consulta);
        if($r)
        {
            $a=0;
            while ($fila=$bd->fetch_assoc($r))
            {
                $bd_id=$fila["id_med_cirugia"];
                $bd_idmedico=$fila["idmedico"];
                $bd_idcirugia=$fila["idcirugia"];
                $result[$a]="($bd_id) ".$bd_idmedico." ".$bd_idcirugia;
                $a++;
            }
        }
        $bd->Close();
    
        return $result;
    }
}

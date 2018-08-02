<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of MedicoController
 *
 * @author MARGOTH TAPIA
 */

include '../Modelo/Medico.php';

class MedicoController {
    
    public function MedicoController(){}
    
public function CrearMedico($p_nrocolegiomedico, $p_nombre, $p_docID, $p_fechaNac, $p_sexo, $p_telef, $p_email, $p_direccion, $p_especialidad)
{
    $affected=0;
    $bd=new con_mysqli("", "", "", "");
    
    ##Validar Iny Sql
        $p_nrocolegiomedico=$bd->real_scape_string($p_nrocolegiomedico);    
        $p_nombre=$bd->real_scape_string($p_nombre);
        $p_docID=$bd->real_scape_string($p_docID);
        $p_fechaNac=$bd->real_scape_string($p_fechaNac);
        $p_sexo=$bd->real_scape_string($p_sexo);
        $p_telef=$bd->real_scape_string($p_telef);
        $p_email=$bd->real_scape_string($p_email);
        $p_direccion=$bd->real_scape_string($p_direccion);
        $p_especialidad=$bd->real_scape_string($p_especialidad);
                
        $consulta="INSERT INTO `medico` (`nrocolegiomedico`, `nombre`, `docid`, `fechanac`, `sexo`, `telef`, `email`, `direccion`, `idespecialidad`) VALUES ('$p_nrocolegiomedico', '$p_nombre', '$p_docID', '$p_fechaNac', '$p_sexo', '$p_telef', '$p_email', '$p_direccion', '$p_especialidad')";
        
        $r=$bd->consulta($consulta);
        if($r)
        {
            $affected=$bd->affected_row();
        }
        $bd->Close();
        return $affected;
        
}

public function ModificarMedico($p_id,$p_nrocolegiomedico,$p_nombre,$p_docID,$p_fechaNac,$p_sexo,$p_telef,$p_email,$p_direccion,$p_especialidad)
    {
        $affected=0;
        $bd=new con_mysqli("", "", "", "");
        
        ##Validar Iny Sql
        $p_nrocolegiomedico=$bd->real_scape_string($p_nrocolegiomedico);    
        $p_nombre=$bd->real_scape_string($p_nombre);
        $p_docID=$bd->real_scape_string($p_docID);
        $p_fechaNac=$bd->real_scape_string($p_fechaNac);
        $p_sexo=$bd->real_scape_string($p_sexo);
        $p_telef=$bd->real_scape_string($p_telef);
        $p_email=$bd->real_scape_string($p_email);
        $p_direccion=$bd->real_scape_string($p_direccion);
        $p_especialidad=$bd->real_scape_string($p_especialidad);
        
        $consulta="UPDATE `medico` SET `nrocolegiomedico`='$p_nrocolegiomedico', `nombre`='$p_nombre', `docid`='$p_docID', `fechanac`='$p_fechaNac', `sexo`='$p_sexo', `telef`='$p_telef', `email`='$p_email', `direccion`='$p_direccion', `idespecialidad`='$p_especialidad' WHERE (`idmedico`='$p_id')";
        
        $r=$bd->consulta($consulta);
        if($r)
        {
            $affected=$bd->affected_row();
            if($affected==0){$affected=1;}
        }
        $bd->Close();
        return $affected;
    }
    
    public function EliminarMedico($p_id)
    {
        $affected=0;
        $bd=new con_mysqli("", "", "", "");
        
        ##Validar Iny Sql
        $p_id=$bd->real_scape_string($p_id);
        
        $consulta="DELETE FROM `medico` WHERE (`idmedico`='$p_id')";
        
        $r=$bd->consulta($consulta);
        if($r)
        {
            $affected=$bd->affected_row();
        }
        $bd->Close();
        return $affected;
        
    }
    
    public function MostrarMedico()
    {
        $result=array();
        $bd= new con_mysqli("", "", "", "");
        $consulta="SELECT * FROM `medico` order by `nombre` ASC";
        $r=$bd->consulta($consulta);
        if($r)
        {
            $a=0;
            while ($fila=$bd->fetch_assoc($r))
            {
               
                $p_id=$fila["idmedico"];
                $p_nrocolegiomedico=$fila["nrocolegiomedico"];
                $p_nombre=$fila["nombre"];
                $p_docid=$fila["docid"];
                $p_fechanac=$fila["fechanac"];
                $p_sexo=$fila["sexo"];
                $p_telef=$fila["telef"];
                $p_email=$fila["email"];
                $p_direccion=$fila["direccion"];
                $p_especialidad=$fila["idespecialidad"];
                                                
                $objMedico=new Medico($p_id, $p_nrocolegiomedico, $p_nombre, $p_docid, $p_fechanac, $p_sexo, $p_telef, $p_email, $p_direccion, $p_especialidad);
                $result[$a]=$objMedico;
                $a++;
            }
        }
        $bd->Close();
        return $result;
    }
    
    public function BuscarMedico($p_id, $p_nombre, $p_docid,$p_id_especialidad=null)
    {
        $result=array();
        $bd= new con_mysqli("", "", "", "");
        $consulta="SELECT * FROM `medico` ";
        
        if($p_id!="")
        {
            $consulta=$consulta."WHERE `idmedico`='$p_id'";
        }
        if($p_nombre!="")
        {
            if($p_id=="")
            {
                $consulta=$consulta."WHERE `nombre`='$p_nombre'";
            }
            else 
            {
                $consulta=$consulta." and `nombre`='$p_nombre'";
            }
        }
        if($p_docid!="")
        {
            if($p_id=="" && $p_nombre=="")
            {
                $consulta=$consulta."WHERE `docid`='$p_docid'";
            }
            else 
            {
                $consulta=$consulta." and `docid`='$p_docid'";
            }
         }
         if($p_id_especialidad!="")
        {
            if($p_id=="" && $p_nombre=="" && $p_docid=="")
            {
                $consulta=$consulta."WHERE `idespecialidad`='$p_id_especialidad'";
            }
            else 
            {
                $consulta=$consulta." and `idespecialidad`='$p_id_especialidad'";
            }
         }
         
         
        $consulta=$consulta." order by `nombre` ASC";
        $r=$bd->consulta($consulta);
        if($r)
        {
            $a=0;
            while ($fila=$bd->fetch_assoc($r))
            {
                 
                $p_id=$fila["idmedico"];
                $p_nrocolegiomedico=$fila["nrocolegiomedico"];
                $p_nombre=$fila["nombre"];
                $p_docid=$fila["docid"];
                $p_fechanac=$fila["fechanac"];
                $p_sexo=$fila["sexo"];
                $p_telef=$fila["telef"];
                $p_email=$fila["email"];
                $p_direccion=$fila["direccion"];
                $p_especialidad=$fila["idespecialidad"];
                                                
                $objMedico=new Medico($p_id, $p_nrocolegiomedico, $p_nombre, $p_docid, $p_fechanac, $p_sexo, $p_telef, $p_email, $p_direccion, $p_especialidad);
                $result[$a]=$objMedico;
                $a++;
            }
        }
        $bd->Close();
        return $result;
        
    }
    
    public function CargarMedico($search)
    {
        $result=array();
        $bd= new con_mysqli("", "", "", "");
        
        ##Validar parametros
        $search=$bd->real_scape_string($search);
        
        $consulta="SELECT * FROM `medico` WHERE `nombre` LIKE '%$search%'";
        $r=$bd->consulta($consulta);
        if($r)
        {
            $a=0;
            while ($fila=$bd->fetch_assoc($r))
            {
                $bd_nombre=$fila["nombre"];
                $result[$a]=$bd_nombre;
                $a++;
            }
        }
        $bd->Close();
        
        return $result;
    }
    public function CargarMedicoNroColegio($search)
    {
        $result=array();
        $bd= new con_mysqli("", "", "", "");
        
        ##Validar parametros
        $search=$bd->real_scape_string($search);
    
        $consulta="SELECT * FROM `medico` WHERE `nrocolegiomedico` LIKE '%$search%'";
        $r=$bd->consulta($consulta);
        if($r)
        {
            $a=0;
            while ($fila=$bd->fetch_assoc($r))
            {
                $bd_nombre=$fila["nombre"];
                $bd_nrocolegiomedico=$fila["nrocolegiomedico"];
                $result[$a]="($bd_nombre) ".$bd_nrocolegiomedico;
                $a++;
            }
        }
        $bd->Close();
    
        return $result;
    }
}

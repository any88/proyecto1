<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of PacienteController
 *
 * @author MARGOTH TAPIA
 */

include '../Modelo/Paciente.php';

class PacienteController {
    
    public function PacienteController(){}
    
public function CrearPaciente($p_nombre, $p_numeroHC, $p_docID, $p_fechaNac, $p_sexo, $p_telef, $p_ocupacion, $p_direccion, $p_anamnesis, $p_tiempoDeEnfermedad, $p_idAseguradora, $p_email, $p_idClienteAseguradora, $p_grupoSanguineo, $p_alergiaMed)
{
    $affected=0;
    $bd=new con_mysqli("", "", "", "");
    
    ##Validar Iny Sql
        $p_nombre=$bd->real_scape_string($p_nombre);
        $p_numeroHC=$bd->real_scape_string($p_numeroHC);
        $p_docID=$bd->real_scape_string($p_docID);
        $p_fechaNac=$bd->real_scape_string($p_fechaNac);
        $p_sexo=$bd->real_scape_string($p_sexo);
        $p_telef=$bd->real_scape_string($p_telef);
        $p_ocupacion=$bd->real_scape_string($p_ocupacion);
        $p_direccion=$bd->real_scape_string($p_direccion);
        $p_anamnesis=$bd->real_scape_string($p_anamnesis);
        $p_tiempoDeEnfermedad=$bd->real_scape_string($p_tiempoDeEnfermedad);
        $pid_Aseguradora=$bd->real_scape_string($p_idAseguradora);
        $p_email=$bd->real_scape_string($p_email);
        $p_idClienteAseguradora=$bd->real_scape_string($p_idClienteAseguradora);
        $p_grupoSanguineo=$bd->real_scape_string($p_grupoSanguineo);
        $p_alergiaMed=$bd->real_scape_string($p_alergiaMed);
        
        
        $consulta="INSERT INTO `paciente` (`nombre`, `numerohc`, `docid`, `fechanac`, `sexo`, `telef`, `ocupacion`, `direccion`, `anamnesis`, `tiempodeenfermedad`, `idaseguradora`, `email`, `idclienteaseguradora`, `gruposanguineo`, `alergiamed`) VALUES ('$p_nombre', '$p_numeroHC', '$p_docID', '$p_fechaNac', '$p_sexo', '$p_telef', '$p_ocupacion', '$p_direccion', '$p_anamnesis', '$p_tiempoDeEnfermedad', '$p_idAseguradora', '$p_email', '$p_idClienteAseguradora', '$p_grupoSanguineo', '$p_alergiaMed')";
        
        
        $r=$bd->consulta($consulta);
        if($r)
        {
            $affected=$bd->affected_row();
        }
        $bd->Close();
        return $affected;
        
}

public function ModificarPaciente($p_id,$p_nombre,$p_numeroHC,$p_docID,$p_fechaNac,$p_sexo,$p_telef,$p_ocupacion,$p_direccion,$p_anamnesis,$p_tiempoDeEnfermedad,$p_idAseguradora,$p_email, $p_idClienteAseguradora, $p_grupoSanguineo, $p_alergiaMed)
    {
        $affected=0;
        $bd=new con_mysqli("", "", "", "");
        
        ##Validar Iny Sql
        $p_nombre=$bd->real_scape_string($p_nombre);
        $p_numeroHC=$bd->real_scape_string($p_numeroHC);
        $p_docID=$bd->real_scape_string($p_docID);
        $p_fechaNac=$bd->real_scape_string($p_fechaNac);
        $p_sexo=$bd->real_scape_string($p_sexo);
        $p_telef=$bd->real_scape_string($p_telef);
        $p_ocupacion=$bd->real_scape_string($p_ocupacion);
        $p_direccion=$bd->real_scape_string($p_direccion);
        $p_anamnesis=$bd->real_scape_string($p_anamnesis);
        $p_tiempoDeEnfermedad=$bd->real_scape_string($p_tiempoDeEnfermedad);
        $p_idAseguradora=$bd->real_scape_string($p_idAseguradora);
        $p_email=$bd->real_scape_string($p_email);
        $p_idClienteAseguradora=$bd->real_scape_string($p_idClienteAseguradora);
        $p_grupoSanguineo=$bd->real_scape_string($p_grupoSanguineo);
        $p_alergiaMed=$bd->real_scape_string($p_alergiaMed);
        
        $consulta="UPDATE `paciente` SET `nombre`='$p_nombre', `numerohc`='$p_numeroHC', `docid`='$p_docID', `fechanac`='$p_fechaNac', `sexo`='$p_sexo', `telef`='$p_telef', `ocupacion`='$p_ocupacion', `direccion`='$p_direccion', `anamnesis`='$p_anamnesis', `tiempodeenfermedad`='$p_tiempoDeEnfermedad', `idaseguradora`='$p_idAseguradora', `email`='$p_email', `idclienteaseguradora`='$p_idClienteAseguradora', `gruposanguineo`='$p_grupoSanguineo', `alergiamed`='$p_alergiaMed' WHERE (`idpaciente`='$p_id')";
       
        
        
        $r=$bd->consulta($consulta);
        if($r)
        {
            $affected=$bd->affected_row();
            if($affected==0){$affected=1;}
        }
        $bd->Close();
        return $affected;
    }
    
    public function EliminarPaciente($p_id)
    {
        $affected=0;
        $bd=new con_mysqli("", "", "", "");
        
        ##Validar Iny Sql
        $p_id=$bd->real_scape_string($p_id);
        
        $consulta="DELETE FROM `paciente` WHERE (`idpaciente`='$p_id')";
        
        $r=$bd->consulta($consulta);
        if($r)
        {
            $affected=$bd->affected_row();
        }
        $bd->Close();
        return $affected;
        
    }
    
    public function MostrarPaciente()
    {
        $result=array();
        $bd= new con_mysqli("", "", "", "");
        $consulta="SELECT * FROM `paciente` order by `nombre` ASC";
        $r=$bd->consulta($consulta);
        if($r)
        {
            $a=0;
            while ($fila=$bd->fetch_assoc($r))
            {
               
                $p_id=$fila["idpaciente"];
                $p_nombre=$fila["nombre"];
                $p_numerohc=$fila["numerohc"];
                $p_docid=$fila["docid"];
                $p_fechanac=$fila["fechanac"];
                $p_sexo=$fila["sexo"];
                $p_telef=$fila["telef"];
                $p_ocupacion=$fila["ocupacion"];
                $p_direccion=$fila["direccion"];
                $p_anamnesis=$fila["anamnesis"];
                $p_tiempodeenfermedad=$fila["tiempodeenfermedad"];
                $p_idaseguradora=$fila["idaseguradora"];
                $p_email=$fila["email"];
                $p_idClienteAseguradora=$fila["idclienteaseguradora"];
                $p_grupoSanguineo=$fila["gruposanguineo"];
                $p_alergiaMed=$fila["alergiamed"];
                                
                $objPaciente=new Paciente($p_id, $p_nombre, $p_numerohc, $p_docid, $p_fechanac, $p_sexo, $p_telef, $p_ocupacion, $p_direccion, $p_anamnesis, $p_tiempodeenfermedad, $p_idaseguradora, $p_email, $p_idClienteAseguradora, $p_grupoSanguineo, $p_alergiaMed);
                $result[$a]=$objPaciente;
                $a++;
            }
        }
        $bd->Close();
        return $result;
    }
    
    public function BuscarPaciente($p_numerohc, $p_nombre, $p_docid,$p_id)
    {
        $result=array();
        $bd= new con_mysqli("", "", "", "");
        $consulta="SELECT * FROM `paciente` ";
        
        $p_nombre=$bd->real_scape_string($p_nombre);
        $p_numerohc=$bd->real_scape_string($p_numerohc);
        $p_docid=$bd->real_scape_string($p_docid);
        $p_id=$bd->real_scape_string($p_id);
        
        if($p_numerohc!="")
        {
            $consulta=$consulta."WHERE `numerohc`='$p_numerohc'";
        }
        if($p_nombre!="")
        {
            if($p_numerohc=="")
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
            if($p_numerohc=="" && $p_nombre=="")
            {
                $consulta=$consulta."WHERE `docid`='$p_docid'";
            }
            else 
            {
                $consulta=$consulta." and `docid`='$p_docid'";
            }
         }
         if($p_id!="")
            {
                if($p_numerohc=="" && $p_nombre=="" && $p_docid=="")
               {
                   $consulta=$consulta."WHERE `idpaciente`='$p_id'";
               }
               else 
               {
                   $consulta=$consulta." and `idpaciente`='$p_id'";
               }
            }
         
        $consulta=$consulta." order by `nombre` ASC";    
        $r=$bd->consulta($consulta);
        if($r)
        {
            $a=0;
            while ($fila=$bd->fetch_assoc($r))
            {
                 
                $p_id=$fila["idpaciente"];
                $p_nombre=$fila["nombre"];
                $p_numerohc=$fila["numerohc"];
                $p_docid=$fila["docid"];
                $p_fechanac=$fila["fechanac"];
                $p_sexo=$fila["sexo"];
                $p_telef=$fila["telef"];
                $p_ocupacion=$fila["ocupacion"];
                $p_direccion=$fila["direccion"];
                $p_anamnesis=$fila["anamnesis"];
                $p_tiempodeenfermedad=$fila["tiempodeenfermedad"];
                $p_idaseguradora=$fila["idaseguradora"];
                $p_email=$fila["email"];
                $p_idClienteAseguradora=$fila["idclienteaseguradora"];
                $p_grupoSanguineo=$fila["gruposanguineo"];
                $p_alergiaMed=$fila["alergiamed"];
                                
                $objPaciente=new Paciente($p_id, $p_nombre, $p_numerohc, $p_docid, $p_fechanac, $p_sexo, $p_telef, $p_ocupacion, $p_direccion, $p_anamnesis, $p_tiempodeenfermedad, $p_idaseguradora, $p_email, $p_idClienteAseguradora, $p_grupoSanguineo, $p_alergiaMed);
                $result[$a]=$objPaciente;
                $a++;
            }
        }
        $bd->Close();
        return $result;
        
    }
    public function BuscarPacienteLike($p_numerohc, $p_nombre, $p_docid,$p_id)
    {
        $result=array();
        $bd= new con_mysqli("", "", "", "");
        $consulta="SELECT * FROM `paciente` ";
        
        $p_nombre=$bd->real_scape_string($p_nombre);
        $p_numerohc=$bd->real_scape_string($p_numerohc);
        $p_docid=$bd->real_scape_string($p_docid);
        $p_id=$bd->real_scape_string($p_id);
        
        if($p_numerohc!="")
        {
            $consulta=$consulta."WHERE `numerohc`='$p_numerohc'";
        }
        if($p_nombre!="")
        {
            if($p_numerohc=="")
            {
                $consulta=$consulta."WHERE `nombre` LIKE '%$p_nombre%'";
            }
            else 
            {
                $consulta=$consulta." and `nombre` LIKE '%$p_nombre%'";
            }
        }
        if($p_docid!="")
        {
            if($p_numerohc=="" && $p_nombre=="")
            {
                $consulta=$consulta."WHERE `docid`='$p_docid'";
            }
            else 
            {
                $consulta=$consulta." and `docid`='$p_docid'";
            }
         }
         if($p_id!="")
            {
                if($p_numerohc=="" && $p_nombre=="" && $p_docid=="")
               {
                   $consulta=$consulta."WHERE `idpaciente`='$p_id'";
               }
               else 
               {
                   $consulta=$consulta." and `idpaciente`='$p_id'";
               }
            }
         
        $consulta=$consulta." order by `nombre` ASC";  
       
        $r=$bd->consulta($consulta);
        if($r)
        {
            $a=0;
            while ($fila=$bd->fetch_assoc($r))
            {
                 
                $p_id=$fila["idpaciente"];
                $p_nombre=$fila["nombre"];
                $p_numerohc=$fila["numerohc"];
                $p_docid=$fila["docid"];
                $p_fechanac=$fila["fechanac"];
                $p_sexo=$fila["sexo"];
                $p_telef=$fila["telef"];
                $p_ocupacion=$fila["ocupacion"];
                $p_direccion=$fila["direccion"];
                $p_anamnesis=$fila["anamnesis"];
                $p_tiempodeenfermedad=$fila["tiempodeenfermedad"];
                $p_idaseguradora=$fila["idaseguradora"];
                $p_email=$fila["email"];
                $p_idClienteAseguradora=$fila["idclienteaseguradora"];
                $p_grupoSanguineo=$fila["gruposanguineo"];
                $p_alergiaMed=$fila["alergiamed"];
                                
                $objPaciente=new Paciente($p_id, $p_nombre, $p_numerohc, $p_docid, $p_fechanac, $p_sexo, $p_telef, $p_ocupacion, $p_direccion, $p_anamnesis, $p_tiempodeenfermedad, $p_idaseguradora, $p_email, $p_idClienteAseguradora, $p_grupoSanguineo, $p_alergiaMed);
                $result[$a]=$objPaciente;
                $a++;
            }
        }
        $bd->Close();
        return $result;
        
    }
    
    public function CargarPaciente($search)
    {
        $result=array();
        $bd= new con_mysqli("", "", "", "");
        
        ##Validar parametros
        $search=$bd->real_scape_string($search);
        
        $consulta="SELECT * FROM `paciente` WHERE `nombre` LIKE '%$search%'";
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
    public function CargarPacienteHC($search)
    {
        $result=array();
        $bd= new con_mysqli("", "", "", "");
        
        ##Validar parametros
        $search=$bd->real_scape_string($search);
    
        $consulta="SELECT * FROM `paciente` WHERE `numerohc` LIKE '%$search%'";
        $r=$bd->consulta($consulta);
        if($r)
        {
            $a=0;
            while ($fila=$bd->fetch_assoc($r))
            {
                $bd_nombre=$fila["nombre"];
                $bd_numerohc=$fila["numerohc"];
                $result[$a]="($bd_nombre) ".$bd_numerohc;
                $a++;
            }
        }
        $bd->Close();
    
        return $result;
    }
}

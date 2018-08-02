<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of TrabajadorController
 *
 * @author MARGOTH TAPIA
 */

include '../Modelo/Trabajador.php';

class TrabajadorController {
    
    public function TrabajadorController(){}
    
public function CrearTrabajador($p_docID, $p_nombre, $p_fechaNac, $p_sexo, $p_telef, $p_email, $p_direccion, $p_cargo, $p_salario)
{
    $affected=0;
    $bd=new con_mysqli("", "", "", "");
    
    ##Validar Iny Sql
        $p_docID=$bd->real_scape_string($p_docID);
        $p_nombre=$bd->real_scape_string($p_nombre);
        $p_fechaNac=$bd->real_scape_string($p_fechaNac);
        $p_sexo=$bd->real_scape_string($p_sexo);
        $p_telef=$bd->real_scape_string($p_telef);
        $p_email=$bd->real_scape_string($p_email);
        $p_direccion=$bd->real_scape_string($p_direccion);
        $p_cargo=$bd->real_scape_string($p_cargo);
        $p_salario=$bd->real_scape_string($p_salario);
                
        $consulta="INSERT INTO `trabajador` (`docid`, `nombre`, `fechanac`, `sexo`, `telef`, `email`, `direccion`, `cargo`, `salario`) VALUES ('$p_docID', '$p_nombre', '$p_fechaNac', '$p_sexo', '$p_telef', '$p_email', '$p_direccion', '$p_cargo', '$p_salario')";
        
        $r=$bd->consulta($consulta);
        if($r)
        {
            $affected=$bd->affected_row();
        }
        $bd->Close();
        return $affected;
        
}

public function ModificarTrabajador($p_id,$p_docID,$p_nombre,$p_fechaNac,$p_sexo,$p_telef,$p_email,$p_direccion,$p_cargo, $p_salario)
    {
        $affected=0;
        $bd=new con_mysqli("", "", "", "");
        
        ##Validar Iny Sql
        $p_docID=$bd->real_scape_string($p_docID);
        $p_nombre=$bd->real_scape_string($p_nombre);
        $p_fechaNac=$bd->real_scape_string($p_fechaNac);
        $p_sexo=$bd->real_scape_string($p_sexo);
        $p_telef=$bd->real_scape_string($p_telef);
        $p_email=$bd->real_scape_string($p_email);
        $p_direccion=$bd->real_scape_string($p_direccion);
        $p_cargo=$bd->real_scape_string($p_cargo);
        $p_salario=$bd->real_scape_string($p_salario);
        
        $consulta="UPDATE `trabajador` SET `docid`='$p_docID', `nombre`='$p_nombre', `fechanac`='$p_fechaNac', `sexo`='$p_sexo', `telef`='$p_telef', `email`='$p_email', `direccion`='$p_direccion', `cargo`='$p_cargo', `salario`='$p_salario' WHERE (`idtrabajador`='$p_id')";
        //Mostrar($consulta);
        $r=$bd->consulta($consulta);
        if($r)
        {
            $affected=$bd->affected_row();
            if($affected==0){$affected=1;}
        }
        $bd->Close();
        return $affected;
    }
    
    public function EliminarTrabajador($p_id)
    {
        $affected=0;
        $bd=new con_mysqli("", "", "", "");
        
        ##Validar Iny Sql
        $p_id=$bd->real_scape_string($p_id);
        
        $consulta="DELETE FROM `trabajador` WHERE (`idtrabajador`='$p_id')";
        
        $r=$bd->consulta($consulta);
        if($r)
        {
            $affected=$bd->affected_row();
        }
        $bd->Close();
        return $affected;
        
    }
    
    public function MostrarTrabajador()
    {
        $result=array();
        $bd= new con_mysqli("", "", "", "");
        $consulta="SELECT * FROM `trabajador` order by `nombre` ASC";
        $r=$bd->consulta($consulta);
        if($r)
        {
            $a=0;
            while ($fila=$bd->fetch_assoc($r))
            {
               
                $p_id=$fila["idtrabajador"];
                $p_docid=$fila["docid"];
                $p_nombre=$fila["nombre"];
                $p_fechanac=$fila["fechanac"];
                $p_sexo=$fila["sexo"];
                $p_telef=$fila["telef"];
                $p_email=$fila["email"];
                $p_direccion=$fila["direccion"];
                $p_cargo=$fila["cargo"];
                $p_salario=$fila["salario"];
                                                
                $objTrabajador=new Trabajador($p_id, $p_docid, $p_nombre, $p_fechanac, $p_sexo, $p_telef, $p_email, $p_direccion, $p_cargo, $p_salario);
                $result[$a]=$objTrabajador;
                $a++;
            }
        }
        $bd->Close();
        return $result;
    }
    
    public function BuscarTrabajador($p_idtrabajador, $p_nombre, $p_docid,$p_cargo=null)
    {
        $result=array();
        $bd= new con_mysqli("", "", "", "");
        $consulta="SELECT * FROM `trabajador` ";
        
        if($p_idtrabajador!="")
        {
            $consulta=$consulta."WHERE `idtrabajador`='$p_idtrabajador'";
        }
        if($p_nombre!="")
        {
            if($p_idtrabajador=="")
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
            if($p_idtrabajador=="" && $p_nombre=="")
            {
                $consulta=$consulta."WHERE `docid`='$p_docid'";
            }
            else 
            {
                $consulta=$consulta." and `docid`='$p_docid'";
            }
         }
         if($p_cargo!="")
        {
            if($p_idtrabajador=="" && $p_nombre=="" && $p_docid=="")
            {
                $consulta=$consulta."WHERE `cargo`='$p_cargo'";
            }
            else 
            {
                $consulta=$consulta." and `cargo`='$p_cargo'";
            }
         }
         
        
        $consulta=$consulta." order by `nombre` ASC";
        $r=$bd->consulta($consulta);
        if($r)
        {
            $a=0;
            while ($fila=$bd->fetch_assoc($r))
            {
                 
                $p_id=$fila["idtrabajador"];
                $p_docid=$fila["docid"];
                $p_nombre=$fila["nombre"];
                $p_fechanac=$fila["fechanac"];
                $p_sexo=$fila["sexo"];
                $p_telef=$fila["telef"];
                $p_email=$fila["email"];
                $p_direccion=$fila["direccion"];
                $p_cargo=$fila["cargo"];
                $p_salario=$fila["salario"];
                                                
                $objTrabajador=new Trabajador($p_id, $p_docid, $p_nombre, $p_fechanac, $p_sexo, $p_telef, $p_email, $p_direccion, $p_cargo, $p_salario);
                $result[$a]=$objTrabajador;
                $a++;
            }
        }
        $bd->Close();
        return $result;
        
    }
    
    public function CargarTrabajador($search)
    {
        $result=array();
        $bd= new con_mysqli("", "", "", "");
        
        ##Validar parametros
        $search=$bd->real_scape_string($search);
        
        $consulta="SELECT * FROM `trabajador` WHERE `nombre` LIKE '%$search%'";
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
    public function CargarTrabajadorDocID($search)
    {
        $result=array();
        $bd= new con_mysqli("", "", "", "");
        
        ##Validar parametros
        $search=$bd->real_scape_string($search);
    
        $consulta="SELECT * FROM `trabajador` WHERE `docid` LIKE '%$search%'";
        $r=$bd->consulta($consulta);
        if($r)
        {
            $a=0;
            while ($fila=$bd->fetch_assoc($r))
            {
                $bd_nombre=$fila["nombre"];
                $bd_docid=$fila["docid"];
                $result[$a]="($bd_nombre) ".$bd_docid;
                $a++;
            }
        }
        $bd->Close();
    
        return $result;
    }
}

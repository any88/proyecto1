<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of MedicoConsultaController
 *
 * @author MARGOTH TAPIA
 */

include '../modelo/MedicoConsulta.php';

class MedicoConsultaController {
    
    public function MedicoConsultaController(){}
    
public function CrearMedicoConsulta($p_idmedico, $p_idconsulta, $p_fecha, $p_idtransaccion)
{
    $affected=0;
    $bd=new con_mysqli("", "", "", "");
    
    ##Validar Iny Sql
        $p_idmedico=$bd->real_scape_string($p_idmedico);
        $p_idconsulta=$bd->real_scape_string($p_idconsulta);
        $p_fecha=$bd->real_scape_string($p_fecha);
        $p_idtransaccion=$bd->real_scape_string($p_idtransaccion);
        
        
        if($p_idmedico!="")
        {
            $consulta="INSERT INTO `medico_consulta` (`idmedico`, `idconsulta`, `fecha`,`idtransaccion`) VALUES ('$p_idmedico', '$p_idconsulta', '$p_fecha', '$p_idtransaccion')";
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

public function ModificarMedicoConsulta($p_id,$p_idmedico,$p_idconsulta,$p_fecha,$p_idtransaccion)
    {
        $affected=0;
        $bd=new con_mysqli("", "", "", "");
        
        ##Validar Iny Sql
        $p_id=$bd->real_scape_string($p_id);
        $p_idmedico=$bd->real_scape_string($p_idmedico);
        $p_idconsulta=$bd->real_scape_string($p_idconsulta);
        $p_fecha=$bd->real_scape_string($p_fecha);
        $p_idtransaccion=$bd->real_scape_string($p_idtransaccion);
        
               
        $consulta="UPDATE `medico_consulta` SET `fecha`='$p_fecha', `idmedico`='$p_idmedico', `idconsulta`='$p_idconsulta', `idtransaccion`='$p_idtransaccion' WHERE (`idmc`='$p_id')";
        
        $r=$bd->consulta($consulta);
        if($r)
        {
            $affected=$bd->affected_row();
        }
        $bd->Close();
        return $affected;
    }
    
    public function EliminarMedicoConsulta($p_id)
    {
        $affected=0;
        $bd=new con_mysqli("", "", "", "");
        
        ##Validar Iny Sql
        $p_id=$bd->real_scape_string($p_id);
        
        $consulta="DELETE FROM `medico_consulta` WHERE (`idmc`='$p_id')";
        
        $r=$bd->consulta($consulta);
        if($r)
        {
            $affected=$bd->affected_row();
        }
        $bd->Close();
        return $affected;
        
    }
        
    public function MostrarMedicoConsulta()
    {
        $result=array();
        $bd= new con_mysqli("", "", "", "");
        $consulta="SELECT * FROM `medico_consulta` order by `idmc` ASC";
        $r=$bd->consulta($consulta);
        if($r)
        {
            $a=0;
            while ($fila=$bd->fetch_assoc($r))
            {
               
                $p_id=$fila["idmc"];
                $p_idmedico=$fila["idmedico"];
                $p_fecha=$fila["fecha"];
                $p_idconsulta=$fila["idconsulta"];
                $p_idtransaccion=$fila["idtransaccion"];
                
                $objMedicoConsulta=new MedicoConsulta($p_id, $p_idmedico, $p_idconsulta, $p_fecha, $p_idtransaccion);
                $result[$a]=$objMedicoConsulta;
                $a++;
            }
        }
        $bd->Close();
        return $result;
    }
    
    public function BuscarMedicoConsulta($p_idmc, $p_idmedico, $p_idconsulta)
    {
        $result=array();
        $bd= new con_mysqli("", "", "", "");
        $consulta="SELECT * FROM `medico_consulta` ";
        
        if($p_idmc!="")
        {
            $consulta=$consulta."WHERE `idmc`='$p_idmc'";
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
        if($p_idconsulta!="")
        {
            if($p_idmc=="" && $p_idmedico=="")
            {
                $consulta=$consulta."WHERE `idconsulta`='$p_idconsulta'";
            }
            else 
            {
                $consulta=$consulta." and `idconsulta`='$p_idconsulta'";
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
                $p_idconsulta=$fila["idconsulta"];
                $p_fecha=$fila["fecha"];
                $p_idtransaccion=$fila["idtransaccion"];
                
                $objMedicoConsulta=new MedicoConsulta($p_id, $p_idmedico, $p_idconsulta, $p_fecha, $p_idtransaccion);
                $result[$a]=$objMedicoConsulta;
                $a++;
            }
        }
        $bd->Close();
        return $result;
        
    }
    
    public function CargarMedicoConsultaID($search)
    {
        $result=array();
        $bd= new con_mysqli("", "", "", "");
        
        ##Validar parametros
        $search=$bd->real_scape_string($search);
        
        $consulta="SELECT * FROM `medico_consulta` WHERE `idmc` LIKE '%$search%'";
        $r=$bd->consulta($consulta);
        if($r)
        {
            $a=0;
            while ($fila=$bd->fetch_assoc($r))
            {
                $bd_id=$fila["idmc"];
                $result[$a]=$bd_id;
                $a++;
            }
        }
        $bd->Close();
        
        return $result;
    }
    public function CargarMedicoConsulta($search)
    {
        $result=array();
        $bd= new con_mysqli("", "", "", "");
        
        ##Validar parametros
        $search=$bd->real_scape_string($search);
    
        $consulta="SELECT * FROM `medico_consulta` WHERE `idmc` LIKE '%$search%'";
        $r=$bd->consulta($consulta);
        if($r)
        {
            $a=0;
            while ($fila=$bd->fetch_assoc($r))
            {
                $bd_id=$fila["idmc"];
                $bd_idmedico=$fila["idmedico"];
                $bd_idconsulta=$fila["idconsulta"];
                $result[$a]="($bd_id) ".$bd_idmedico." ".$bd_idconsulta;
                $a++;
            }
        }
        $bd->Close();
    
        return $result;
    }
}

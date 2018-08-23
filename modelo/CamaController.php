<?php
include 'Cama.php';
class CamaController
{
    function __construct() {       
    }

    public function AgregarCama($p_num_cama,$estado)
    {
        $affected=0;
        $bd=new con_mysqli("", "", "", "");
        $p_num_cama=$bd->real_scape_string($p_num_cama);
        $estado=$bd->real_scape_string($estado);
        
        $consulta="INSERT INTO `camas_hospitalizacion` (`num_cama`, `estado`) VALUES ('$p_num_cama', '$estado')";
        
        $r=$bd->consulta($consulta);
        if($r)
        {
            $affected=$bd->affected_row();
        }
        $bd->Close();
        return $affected;
    }
     public function ModificarNumeroCama($id_cama,$p_num_cama)
    {
        $affected=0;
        $bd=new con_mysqli("", "", "", "");
        $id_cama=$bd->real_scape_string($id_cama);
        $p_num_cama=$bd->real_scape_string($p_num_cama);
       
        
        $consulta="UPDATE `camas_hospitalizacion` SET `num_cama`='$p_num_cama' WHERE (`id_cama`='$id_cama')";
        $r=$bd->consulta($consulta);
        if($r)
        {
            $affected=$bd->affected_row();
        }
        $bd->Close();
        return $affected;
    }
    
    public function ModificarEstadoCama($id_cama,$estado)
    {
        $affected=0;
        $bd=new con_mysqli("", "", "", "");
        $id_cama=$bd->real_scape_string($id_cama);
        $p_num_cama=$bd->real_scape_string($p_num_cama);
       
        
        $consulta="UPDATE `camas_hospitalizacion` SET `estado`='$estado' WHERE (`id_cama`='$id_cama')";
        $r=$bd->consulta($consulta);
        if($r)
        {
            $affected=$bd->affected_row();
        }
        $bd->Close();
        return $affected;
    }
    public function MostrarCamas()
    {
        $result=array();
        $bd= new con_mysqli("", "", "", "");
        $consulta="SELECT * FROM `camas_hospitalizacion` order by `num_cama` ASC";
        $r=$bd->consulta($consulta);
        if($r)
        {
            $a=0;
            while ($fila=$bd->fetch_assoc($r))
            {
                $bd_idcama=$fila['id_cama'];
                $bd_num_cama=$fila['num_cama'];
                $bd_estado=$fila['estado'];
                $objCama=new Cama($bd_idcama, $bd_num_cama, $bd_estado);
                $result[$a]=$objCama;
                $a++;
            }
        }
        
        return $result;
    }
    public function MostrarCamasDisponibles()
    {
        $result=array();
        $bd= new con_mysqli("", "", "", "");
        $consulta="SELECT * FROM `camas_hospitalizacion` WHERE `estado` = '0' order by `num_cama` ASC";
        $r=$bd->consulta($consulta);
        if($r)
        {
            $a=0;
            while ($fila=$bd->fetch_assoc($r))
            {
                $bd_idcama=$fila['id_cama'];
                $bd_num_cama=$fila['num_cama'];
                $bd_estado=$fila['estado'];
                $objCama=new Cama($bd_idcama, $bd_num_cama, $bd_estado);
                $result[$a]=$objCama;
                $a++;
            }
        }
        
        return $result;
    }
    public function BuscarCama($id_cama, $p_nro_camma, $p_estado)
    {
        $result=array();
        $bd= new con_mysqli("", "", "", "");
        $consulta="SELECT * FROM `camas_hospitalizacion` ";
        
        $id_cama=$bd->real_scape_string($id_cama);
        $p_nro_camma=$bd->real_scape_string($p_nro_camma);
        $p_estado=$bd->real_scape_string($p_estado);
       
        if($id_cama!="")
        {
            $consulta=$consulta."WHERE `id_cama`='$id_cama'";
        }
        if($p_nro_camma!="")
        {
            if($id_cama=="")
            {
                $consulta=$consulta."WHERE `num_cama`='$p_nro_camma'";
            }
            else 
            {
                $consulta=$consulta." and `num_cama`='$p_nro_camma'";
            }
        }
        if($p_estado!="")
        {
            if($id_cama=="" && $p_nro_camma=="")
            {
                $consulta=$consulta."WHERE `estado`='$p_estado'";
            }
            else 
            {
                $consulta=$consulta." and `estado`='$p_estado'";
            }
         }
         
         
        $consulta=$consulta." order by `num_cama` ASC";    
        $r=$bd->consulta($consulta);
        if($r)
        {
            $a=0;
            while ($fila=$bd->fetch_assoc($r))
            {
                $bd_idcama=$fila['id_cama'];
                $bd_num_cama=$fila['num_cama'];
                $bd_estado=$fila['estado'];
                $objCama=new Cama($bd_idcama, $bd_num_cama, $bd_estado);
                $result[$a]=$objCama;
                $a++;
            }
        }
        $bd->Close();
        return $result;
        
    }
    public function EliminarCama($id_cama)
    {
        $affected=0;
        $bd=new con_mysqli("", "", "", "");
        $id_cama=$bd->real_scape_string($id_cama);
        
        $consulta="DELETE FROM `camas_hospitalizacion` WHERE (`id_cama`='$id_cama')";
        $r=$bd->consulta($consulta);
        if($r)
        {
            $affected=$bd->affected_row();
        }
        $bd->Close();
        return $affected;
    }
     public function GenerarNroCama()
    {
        $nro=1;
        $bd=new con_mysqli("", "", "", "");
        
        $consulta="SELECT MAX(num_cama)  from camas_hospitalizacion";
        $r=$bd->consulta($consulta);
        if($r)
        {
            $nro=$bd->fetch_array($r)[0];
            
        }
        $res=1;
        $nro++;
        for ($i = 1; $i <=$nro; $i++) 
        {
            $consulta="SELECT * FROM `camas_hospitalizacion` WHERE `num_cama` = '$i' ";
            $r=$bd->consulta($consulta);
            if($r)
            {
                $nr=$bd->num_row($r);
                if($nr==0){$res=$i;
                break;}
            }
        }
        $bd->Close();
        return $res;
    }
    
    
}

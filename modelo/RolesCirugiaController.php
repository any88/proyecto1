<?php

include '../modelo/RolesCirugia.php';

class RolesCirugiaController
{
    public function RolesCirugiaController(){}

    public function CrearRolesCirugia($p_nombre, $p_especializacion)
{
    $affected=0;
    $bd=new con_mysqli("", "", "", "");
    
    ##Validar Iny Sql
        $p_nombre=$bd->real_scape_string($p_nombre);
        $p_especializacion=$bd->real_scape_string($p_especializacion);
                
        $consulta="INSERT INTO `roles_cirugia` (`nombre`, `especializacion`) VALUES ('$p_nombre', '$p_especializacion')";
        
        $r=$bd->consulta($consulta);
        if($r)
        {
            $affected=$bd->affected_row();
        }
        $bd->Close();
        return $affected;
        
}

public function ModificarRolesCirugia($p_id,$p_nombre)
    {
        $affected=0;
        $bd=new con_mysqli("", "", "", "");
        
        ##Validar Iny Sql
        $p_id=$bd->real_scape_string($p_id);
        $p_nombre=$bd->real_scape_string($p_nombre);
                
        $consulta="UPDATE `roles_cirugia` SET `nombre`='$p_nombre' WHERE (`id_rol`='$p_id')";
        
        $r=$bd->consulta($consulta);
        if($r)
        {
            $affected=$bd->affected_row();
            if($affected==0){$affected=1;}
        }
        $bd->Close();
        return $affected;
    }
    
    public function EliminarRolesCirugia($p_id)
    {
        $affected=0;
        $bd=new con_mysqli("", "", "", "");
        
        ##Validar Iny Sql
        $p_id=$bd->real_scape_string($p_id);
        
        $consulta="DELETE FROM `roles_cirugia` WHERE (`id_rol`='$p_id')";
        
        $r=$bd->consulta($consulta);
        if($r)
        {
            $affected=$bd->affected_row();
        }
        $bd->Close();
        return $affected;
        
    }
    
    public function MostrarRolesCirugia()
    {
        $result=array();
        $bd= new con_mysqli("", "", "", "");
        $consulta="SELECT * FROM `roles_cirugia` order by `nombre` ASC";
        $r=$bd->consulta($consulta);
        if($r)
        {
            $a=0;
            while ($fila=$bd->fetch_assoc($r))
            {
               
                $p_id=$fila["id_rol"];
                $p_nombre=$fila["nombre"];
                $p_especializacion=$fila["especializacion"];
                                                
                $objRolesCirugia=new RolesCirugia($p_id, $p_nombre, $p_especializacion);
                $result[$a]=$objRolesCirugia;
                $a++;
            }
        }
        $bd->Close();
        return $result;
    }
    
    public function BuscarLike($p_nombre)
    {
        $result=array();
        $bd= new con_mysqli("", "", "", "");
        $consulta="SELECT * FROM `roles_cirugia` WHERE `nombre` LIKE '%$p_nombre%'";
        $r=$bd->consulta($consulta);
        if($r)
        {
            $a=0;
            while ($fila=$bd->fetch_assoc($r))
            {
                 
                $p_id=$fila["id_rol"];
                $p_nombre=$fila["nombre"];
                $p_especializacion=$fila["especializacion"];
                                                
                $objRolesCirugia=new RolesCirugia($p_id, $p_nombre, $p_especializacion);
                $result[$a]=$objRolesCirugia;
                $a++;
            }
        }
        $bd->Close();
        return $result;
    }

    public function BuscarRolesCirugia($p_id, $p_nombre)
    {
        $result=array();
        $bd= new con_mysqli("", "", "", "");
        $consulta="SELECT * FROM `roles_cirugia` ";
        
        if($p_id!="")
        {
            $consulta=$consulta."WHERE `id_rol`='$p_id'";
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
        
        $consulta=$consulta." order by `nombre` ASC";
        $r=$bd->consulta($consulta);
        if($r)
        {
            $a=0;
            while ($fila=$bd->fetch_assoc($r))
            {
                 
                $p_id=$fila["id_rol"];
                $p_nombre=$fila["nombre"];
                $p_especializacion=$fila["especializacion"];
                                                
                $objRolesCirugia=new RolesCirugia($p_id, $p_nombre, $p_especializacion);
                $result[$a]=$objRolesCirugia;
                $a++;
            }
        }
        $bd->Close();
        return $result;
        
    }
    
    public function CargarRolesCirugia($search)
    {
        $result=array();
        $bd= new con_mysqli("", "", "", "");
        
        ##Validar parametros
        $search=$bd->real_scape_string($search);
        
        $consulta="SELECT * FROM `roles_cirugia` WHERE `nombre` LIKE '%$search%'";
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
}

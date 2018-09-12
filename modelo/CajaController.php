<?php
include 'caja.php';
class CajaController
{
    public function CajaController(){}

    public function AgregarCantidadEnCaja($cantidad)
    {
        $affected=0;
        $bd=new con_mysqli("", "", "", "");
        ##Validar Iny Sql
        $cantidad=$bd->real_scape_string($cantidad);
                        
        $consulta="INSERT INTO `caja` (`cantidad`) VALUES ('$cantidad')";
        $r=$bd->consulta($consulta);
        if($r)
        {
            $affected=$bd->affected_row();
            
        }
        $bd->Close();
        return $affected;
    }
    
    public function VaciarCaja()
    {
        $affected=0;
        $bd=new con_mysqli("", "", "", "");
        $consulta="UPDATE `caja` SET `cantidad`='0' WHERE (`id_caja`='1')";
        $r=$bd->consulta($consulta);
        if($r)
        {
            $affected=$bd->affected_row();
        }
        $bd->Close();
        return $affected;
    }
    public function MostrarCaja()
    {
        $result=array();
        $bd=new con_mysqli("", "", "", "");
        $consulta="SELECT * FROM `caja`";
        $r=$bd->consulta($consulta);
        if($r)
        {
            $a=0;
            while ($fila=$bd->fetch_assoc($r))
            {
                $id=$fila['id_caja'];
                $cantidad=$fila['cantidad'];
                $objCaja=new Caja($id, $cantidad);
                $result[$a]=$objCaja;
                $a++;
            }
        }
        $bd->Close();
        return $result;
        
    }

    public function ModificarCantidad($nueva_cantidad)
    {
        $affected=0;
        $bd=new con_mysqli("", "", "", "");
        $nc=0;
        $consulta="SELECT * FROM `caja`";
        $r=$bd->consulta($consulta);
        if($r)
        {
            
            while ($fila=$bd->fetch_assoc($r))
            {
                $nc=$nc+$fila['cantidad'];
            }
        }
        $nueva_cantidad=$nc+$nueva_cantidad;
        ##Validar Iny Sql
        $nueva_cantidad=$bd->real_scape_string($nueva_cantidad);
        $consulta="UPDATE `caja` SET `cantidad`='$nueva_cantidad' WHERE (`id_caja`='1')";
        
        $r=$bd->consulta($consulta);
        if($r)
        {
            $affected=$bd->affected_row();
        }
        $bd->Close();
        return $affected;
    }
}


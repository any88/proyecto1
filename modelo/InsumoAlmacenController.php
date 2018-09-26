<?php

include 'InsumoAlmacen.php';
class InsumoAlmacenController
{
    function __construct() {
        
    }
    
    public function AgregarInsumoAlmacen( $id_insumo, $cantidad, $precio_compra, $fecha_compra, $precio_venta, $lote, $fecha_vencimiento, $id_proveedor)
   {
        $affected=0;
        $bd=new con_mysqli("", "", "", "");

        ##Validar Iny Sql
            $id_insumo=$bd->real_scape_string($id_insumo);
            $cantidad=$bd->real_scape_string($cantidad);
            $precio_compra=$bd->real_scape_string($precio_compra);
            $fecha_compra=$bd->real_scape_string($fecha_compra);
            $precio_venta=$bd->real_scape_string($precio_venta);
            $lote=$bd->real_scape_string($lote);
            $fecha_vencimiento=$bd->real_scape_string($fecha_vencimiento);
            $id_proveedor=$bd->real_scape_string($id_proveedor);

            $consulta="INSERT INTO `insumo_almacen` (`id_insumo`, `cantidad`, `precio_compra`, `fecha_compra`, `precio_venta`, `lote`, `fecha_vencimiento`, `id_proveedor`) "
                    . "VALUES ('$id_insumo', '$cantidad', '$precio_compra', '$fecha_compra', '$precio_venta', '$lote', '$fecha_vencimiento', '$id_proveedor')";
            
            $r=$bd->consulta($consulta);
            if($r)
            {
                $affected=$bd->affected_row();
            }
            $bd->Close();
            return $affected;
   }
   public function ModificarInsumoAlmacen($id_insumo_almacen, $id_insumo, $cantidad, $precio_compra, $fecha_compra, $precio_venta, $lote, $fecha_vencimiento, $id_proveedor)
    {
        $affected=0;
        $bd=new con_mysqli("", "", "", "");
        
        ##Validar Iny Sql
        $id_insumo_almacen=$bd->real_scape_string($id_insumo_almacen);
        $id_insumo=$bd->real_scape_string($id_insumo);
        $cantidad=$bd->real_scape_string($cantidad);
        $precio_compra=$bd->real_scape_string($precio_compra);
        $fecha_compra=$bd->real_scape_string($fecha_compra);
        $precio_venta=$bd->real_scape_string($precio_venta);
        $lote=$bd->real_scape_string($lote);
        $fecha_vencimiento=$bd->real_scape_string($fecha_vencimiento);
        $id_proveedor=$bd->real_scape_string($id_proveedor);
                
        $consulta="UPDATE `insumo_almacen` SET `id_insumo`='$id_insumo', `cantidad`='$cantidad', `precio_compra`='$precio_compra', `fecha_compra`='$fecha_compra', `precio_venta`='$precio_venta', "
                . "`lote`='$lote', `fecha_vencimiento`='$fecha_vencimiento', `id_proveedor`='$id_proveedor' WHERE (`id_insumo_almacen`='$id_insumo_almacen')";
        
        $r=$bd->consulta($consulta);
        if($r)
        {
            $affected=$bd->affected_row();
            if($affected==0){$affected=1;}
        }
        $bd->Close();
        return $affected;
    }
    
    public function EliminarInsumoAlmacen($id_insumo_almacen)
    {
        $affected=0;
        $bd=new con_mysqli("", "", "", "");
        
        ##Validar Iny Sql
        $id_insumo_almacen=$bd->real_scape_string($id_insumo_almacen);
        
        $consulta="DELETE FROM `insumo_almacen` WHERE (`id_insumo_almacen`='$id_insumo_almacen')";
        
        $r=$bd->consulta($consulta);
        if($r)
        {
            $affected=$bd->affected_row();
        }
        $bd->Close();
        return $affected;
        
    }
    
    public function MostrarInsumoAlmacen()
    {
        $result=array();
        $bd= new con_mysqli("", "", "", "");
        $consulta="SELECT * FROM `insumo_almacen` order by `id_insumo` ASC";
        $r=$bd->consulta($consulta);
        if($r)
        {
            $a=0;
            while ($fila=$bd->fetch_assoc($r))
            {
               
                $id_insumo_almacen=$fila["id_insumo_almacen"];
                $id_insumo=$fila["id_insumo"];
                $cantidad=$fila["cantidad"];
                $precio_compra=$fila["precio_compra"];
                $fecha_compra=$fila["fecha_compra"];
                $precio_venta=$fila["precio_venta"];
                $lote=$fila["lote"];
                $fecha_vencimiento=$fila["fecha_vencimiento"];
                $id_proveedor=$fila["id_proveedor"];
                                                
                $objInsumoAlmacen=new InsumoAlmacen($id_insumo_almacen, $id_insumo, $cantidad, $precio_compra, $fecha_compra, $precio_venta, $lote, $fecha_vencimiento, $id_proveedor);
                $result[$a]=$objInsumoAlmacen;
                $a++;
            }
        }
        $bd->Close();
        return $result;
    }
    
    public function CargarInsumoAlmacenAgrupadoPrecio()
    {
        $result=array();
        $bd= new con_mysqli("", "", "", "");
        $consulta="SELECT * FROM `insumo_almacen` order by `id_insumo` ASC";
        $r=$bd->consulta($consulta);
        if($r)
        {
            $a=0;
            while ($fila=$bd->fetch_assoc($r))
            {
               
                $id_insumo_almacen=$fila["id_insumo_almacen"];
                $id_insumo=$fila["id_insumo"];
                $cantidad=$fila["cantidad"];
                $precio_compra=$fila["precio_compra"];
                $fecha_compra=$fila["fecha_compra"];
                $precio_venta=$fila["precio_venta"];
                $lote=$fila["lote"];
                $fecha_vencimiento=$fila["fecha_vencimiento"];
                $id_proveedor=$fila["id_proveedor"];
                                                
                if($a==0)
                {
                    $result['id_insumo'][$a]=$id_insumo;
                    $result['precio_venta'][$a]=$precio_venta;
                    $result['cantidad'][$a]=$cantidad;
                    $a++;
                }
                else
                {
                    ##buscar insumo al mismo precio
                    $sum=0;
                    for ($i = 0; $i < count($result); $i++) 
                    {
                        if($result['id_insumo'][$i]==$id_insumo)
                        {
                            if($result['precio_venta'][$i]==$precio_venta)
                            {
                                $result['cantidad'][$i]=$result['cantidad'][$i]+$cantidad;
                                $sum++;
                            }
                        }
                    }
                    if($sum==0)
                    {
                        $result['id_insumo'][$a]=$id_insumo;
                        $result['precio_venta'][$a]=$precio_venta;
                        $result['cantidad'][$a]=$cantidad;
                        $a++; 
                    }
                }
                
            }
        }
        $bd->Close();
        return $result;
    }

    public function BuscarInsumoAlmacen($id_insumo_almacen, $id_insumo, $cantidad, $precio_compra, $fecha_compra, $precio_venta, $lote, $fecha_vencimiento, $id_proveedor)
    {
        $result=array();
        $bd= new con_mysqli("", "", "", "");
        $consulta="SELECT * FROM `insumo_almacen` ";
        
        ##Validar Iny Sql
        $id_insumo_almacen=$bd->real_scape_string($id_insumo_almacen);
        $id_insumo=$bd->real_scape_string($id_insumo);
        $cantidad=$bd->real_scape_string($cantidad);
        $precio_compra=$bd->real_scape_string($precio_compra);
        $fecha_compra=$bd->real_scape_string($fecha_compra);
        $precio_venta=$bd->real_scape_string($precio_venta);
        $lote=$bd->real_scape_string($lote);
        $fecha_vencimiento=$bd->real_scape_string($fecha_vencimiento);
        $id_proveedor=$bd->real_scape_string($id_proveedor);
        
        if($id_insumo_almacen!="")
        {
            $consulta=$consulta."WHERE `id_insumo_almacen`='$id_insumo_almacen'";
        }
        if($id_insumo!="")
        {
            if($id_insumo_almacen=="")
            {
                $consulta=$consulta."WHERE `id_insumo`='$id_insumo'";
            }
            else 
            {
                $consulta=$consulta." and `id_insumo`='$id_insumo'";
            }
        }  
        if($cantidad!="")
        {
            if($id_insumo_almacen=="" && $id_insumo=="")
            {
                $consulta=$consulta."WHERE `cantidad`='$cantidad'";
            }
            else 
            {
                $consulta=$consulta." and `cantidad`='$cantidad'";
            }
        }  
        if($precio_compra!="")
        {
            if($id_insumo_almacen=="" && $id_insumo=="" && $cantidad=="")
            {
                $consulta=$consulta."WHERE `precio_compra`='$precio_compra'";
            }
            else 
            {
                $consulta=$consulta." and `precio_compra`='$precio_compra'";
            }
        } 
         if($fecha_compra!="")
        {
            if($id_insumo_almacen=="" && $id_insumo=="" && $cantidad=="" && $precio_compra=="")
            {
                $consulta=$consulta."WHERE `fecha_compra`='$fecha_compra'";
            }
            else 
            {
                $consulta=$consulta." and `fecha_compra`='$fecha_compra'";
            }
        }
        if($precio_venta!="")
        {
            if($id_insumo_almacen=="" && $id_insumo=="" && $cantidad=="" && $precio_compra=="" && $fecha_compra=="")
            {
                $consulta=$consulta."WHERE `precio_venta`='$precio_venta'";
            }
            else 
            {
                $consulta=$consulta." and `precio_venta`='$precio_venta'";
            }
        }
        if($lote!="")
        {
            if($id_insumo_almacen=="" && $id_insumo=="" && $cantidad=="" && $precio_compra=="" && $fecha_compra=="" && $precio_venta=="")
            {
                $consulta=$consulta."WHERE `lote`='$lote'";
            }
            else 
            {
                $consulta=$consulta." and `lote`='$lote'";
            }
        }
        if($fecha_vencimiento!="")
        {
            if($id_insumo_almacen=="" && $id_insumo=="" && $cantidad=="" && $precio_compra=="" && $fecha_compra=="" && $precio_venta=="" && $lote=="")
            {
                $consulta=$consulta."WHERE `fecha_vencimiento`='$fecha_vencimiento'";
            }
            else 
            {
                $consulta=$consulta." and `fecha_vencimiento`='$fecha_vencimiento'";
            }
        }
        if($id_proveedor!="")
        {
            if($id_insumo_almacen=="" && $id_insumo=="" && $cantidad=="" && $precio_compra=="" && $fecha_compra=="" && $precio_venta=="" && $lote=="" && $fecha_vencimiento=="")
            {
                $consulta=$consulta."WHERE `id_proveedor`='$id_proveedor'";
            }
            else 
            {
                $consulta=$consulta." and `id_proveedor`='$id_proveedor'";
            }
        }
        
        $consulta=$consulta." order by `id_insumo` ASC";
        $r=$bd->consulta($consulta);
        if($r)
        {
            $a=0;
            while ($fila=$bd->fetch_assoc($r))
            {
                 
                $id_insumo_almacen=$fila["id_insumo_almacen"];
                $id_insumo=$fila["id_insumo"];
                $cantidad=$fila["cantidad"];
                $precio_compra=$fila["precio_compra"];
                $fecha_compra=$fila["fecha_compra"];
                $precio_venta=$fila["precio_venta"];
                $lote=$fila["lote"];
                $fecha_vencimiento=$fila["fecha_vencimiento"];
                $id_proveedor=$fila["id_proveedor"];
                                                
                $objInsumoAlmacen=new InsumoAlmacen($id_insumo_almacen, $id_insumo, $cantidad, $precio_compra, $fecha_compra, $precio_venta, $lote, $fecha_vencimiento, $id_proveedor);
                $result[$a]=$objInsumoAlmacen;
                $a++;
            }
        }
        $bd->Close();
        return $result;
        
    }

}


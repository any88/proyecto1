<?php

include 'categorias_almacen.php';
class CategoriaAlmacenController
{
    public function CrearCategoriaAlmacen($nombre_categoria)
   {
        $affected=0;
        $bd=new con_mysqli("", "", "", "");
    
    ##Validar Iny Sql
        $nombre_categoria=$bd->real_scape_string($nombre_categoria);
                
        $consulta="INSERT INTO `categorias_almacen` (`nombre_categoria`) VALUES ('$nombre_categoria')";
        
        $r=$bd->consulta($consulta);
        if($r)
        {
            $affected=$bd->affected_row();
        }
        $bd->Close();
        return $affected;
   }
   public function ModificarCategoria($p_id,$nombre_categoria)
    {
        $affected=0;
        $bd=new con_mysqli("", "", "", "");
        
        ##Validar Iny Sql
        $p_id=$bd->real_scape_string($p_id);
        $nombre_categoria=$bd->real_scape_string($nombre_categoria);
                       
        $consulta="UPDATE `categorias_almacen` SET `nombre_categoria`='$nombre_categoria' WHERE (`id_categoria_almacen`='$p_id')";
        //Mostrar($consulta);
        $r=$bd->consulta($consulta);
        if($r)
        {
            $affected=$bd->affected_row();
        }
        $bd->Close();
        return $affected;
    }
    public function EliminarConsulta($p_id)
    {
        $affected=0;
        $bd=new con_mysqli("", "", "", "");
        
        ##Validar Iny Sql
        $p_id=$bd->real_scape_string($p_id);
        
        $consulta="DELETE FROM `categorias_almacen` WHERE (`id_categoria_almacen`='$p_id')";
        
        $r=$bd->consulta($consulta);
        if($r)
        {
            $affected=$bd->affected_row();
        }
        $bd->Close();
        return $affected;
        
    }
     public function MostrarCategoria()
    {
        $result=array();
        $bd= new con_mysqli("", "", "", "");
        $consulta="SELECT * FROM `categorias_almacen` order by `nombre_categoria` ASC";
        $r=$bd->consulta($consulta);
        if($r)
        {
            $a=0;
            while ($fila=$bd->fetch_assoc($r))
            {
               
                $id_categoria_almacen=$fila["id_categoria_almacen"];
                $nombre_categoria=$fila["nombre_categoria"];
                
                                                                                
                $objCategoria=new CategoriasAlmacen($id_categoria_almacen, $nombre_categoria);
                $result[$a]=$objCategoria;
                $a++;
            }
        }
        $bd->Close();
        return $result;
    }
    public function BuscarCategoria($id_categoria_almacen, $nombre_categoria)
    {
        $result=array();
        $bd= new con_mysqli("", "", "", "");
        $consulta="SELECT * FROM `categorias_almacen` ";
        
        if($id_categoria_almacen!="")
        {
            $consulta=$consulta."WHERE `id_categoria_almacen`='$id_categoria_almacen'";
        }
        if($nombre_categoria!="")
        {
            if($id_categoria_almacen=="")
            {
                $consulta=$consulta."WHERE `nombre_categoria`='$nombre_categoria'";
            }
            else 
            {
                $consulta=$consulta." and `nombre_categoria`='$nombre_categoria'";
            }
        }  
        
        $consulta=$consulta." order by `nombre_categoria` ASC";
       
        $r=$bd->consulta($consulta);
        if($r)
        {
            $a=0;
            while ($fila=$bd->fetch_assoc($r))
            {
                 
               $id_categoria_almacen=$fila["id_categoria_almacen"];
                $nombre_categoria=$fila["nombre_categoria"];
                
                                                                                
                $objCategoria=new CategoriasAlmacen($id_categoria_almacen, $nombre_categoria);
                $result[$a]=$objCategoria;
                $a++;
            }
        }
        $bd->Close();
        return $result;
        
    }
}


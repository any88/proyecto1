<?php
session_start();
include '../funct/con_tacnamh_db.php';
include '../funct/functions.php';
include './header.php';

include '../modelo/InsumoAlmacenController.php';
include '../modelo/InsumoController.php';
include '../modelo/ProveedorController.php';

$objInsumoAlmacenC=new InsumoAlmacenController();
$objInsumoC=new InsumoController();
$objProveedor=new ProveedorController();
$msg="";
$id_insumo_almacen="";
$nombre_insumo="";
$datos_insumo=array();

if($_GET)
{
    if(isset($_GET['nik'])){$id_insumo=$_GET['nik'];}
    if(eliminarblancos($id_insumo)!="")
    {
        $datos_insumo=$objInsumoAlmacenC->BuscarInsumoAlmacen($id_insumo_almacen, "", "", "", "", "", "", "", "");
        
    }
    else
    {
        echo "<script>";
            echo "window.location = 'almacen_gestion.php';";
        echo "</script>";

    }
    
}
include './menu_almacen.php';
?>
<br><br>
<section class="about-text">
    <div class="ingres_costo ">
        <div class="col-md-12">
          <?php 
          if($msg!=""){echo $msg;}
          ?>
          <div class="panel panel-default">
              <div class="panel-heading">
                  <b class="text-left"><i class="fa fa-medkit text-info"> Datos del insumo</i></b>
                  <div class="pull-right" style="margin-top: -5px;">
                      <a href="#" class="btn btn-success btn-xs"><i class="fa fa-pencil"> Editar</i></a>
                  </div>
              </div>
              <div class="panel-body">
                  <?php 
                  if(count($datos_insumo)>0)
                {
                      $id_insumo_bd=$datos_insumo[0]->getId_insumo();
                      $nombre_insumo="";
                      $arr_insumos=$objInsumoC->BuscarInsumo($id_insumo_bd, "", "");
                      if(count($arr_insumos)>0){$nombre_insumo=$arr_insumos[0]->getNombre();}
                      $fecha_compra_bd=$datos_insumo[0]->getFecha_compra();
                      $fecha_venc_bd=$datos_insumo[0]->getFecha_vencimiento();
                      $precio_compra=$datos_insumo[0]->getPrecio_compra();
                      $precio_venta=$datos_insumo[0]->getPrecio_venta();
                      $lote_bd=$datos_insumo[0]->getLote();
                      ##proveedor
                      $id_proveedor_bd=$datos_insumo[0]->getId_proveedor();
                      $nombre_proveedor_bd="";
                      $arrProveedores=$objProveedor->BuscarProveedor($id_proveedor_bd, "", "");
                      if(count($arrProveedores)>0){$nombre_proveedor_bd=$arrProveedores[0]->getNombre();}
                      
                      $cantidad_bd=$datos_insumo[0]->getCantidad();
                      $ganancia=$precio_venta-$precio_compra;
                      echo "<table class='table  table-bordered table-responsive'>";
                      echo "<tr>";
                      echo "<th>Nombre del Insumo</th>";
                      echo "<td>$nombre_insumo</td>";
                      echo "<th>Fecha Compra</th>";
                      echo "<td>$fecha_compra_bd</td>";
                      echo "<th>Fecha Vencimiento</th>";
                      echo "<td>$fecha_venc_bd</td>";
                      echo "<tr>";
                      echo "<tr>";
                      echo "<th>Precio Compra</th>";
                      echo "<td>s/. $precio_compra</td>";
                      echo "<th>Precio Venta</th>";
                      echo "<td>s/. $precio_venta</td>";
                      echo "<th>Lote</th>";
                      echo "<td>$lote_bd</td>";
                      echo "<tr>";
                      echo "<tr>";
                      echo "<th>Proveedor</th>";
                      echo "<td>$nombre_proveedor_bd</td>";
                      echo "<th>Cantidad</th>";
                      echo "<td>$cantidad_bd</td>";
                      echo "<th>Ganancia</th>";
                      echo "<td>s/. $ganancia</td>";
                      echo "<tr>";
                      echo '</table>';
                }
                else
                {
                    $msg="<div class='alert alert-danger alert-dismissable'>"
                    . "<button type='button' class='close' data-dismiss='alert' aria-hidden='true'>&times;</button>"
                    . "Error! No se han encontrado los datos del insumo seleccionado en el almacen.</div>";
                    $_SESSION['msg']=$msg;
                    echo "<script>";
                        echo "window.location = 'almacen_gestion.php';";
                   echo "</script>";

                }
                  
                  ?>
              
                    <div class="pull-right">
                        <a href="almacen_gestion.php" class="btn btn-danger"> Volver</a>
                    </div>
              </div>
          </div>
        </div>
    </div>
</section>


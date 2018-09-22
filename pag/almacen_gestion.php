<?php
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
$id_ins_delete="";
$nombre_insumo="";
if($_POST)
{
    if(isset($_POST['id_insumo_delete'])){$id_ins_delete=$_POST['id_insumo_delete'];}
    if(isset($_POST['nombre_insumo'])){$nombre_insumo=$_POST['nombre_insumo'];}
    if(eliminarblancos($id_ins_delete)!="")
    {
        $affected=$objInsumoAlmacenC->EliminarInsumoAlmacen($id_ins_delete);
        if($affected==1)
        {
            $msg="<div class='alert alert-success alert-dismissable'>"
            . "<button type='button' class='close' data-dismiss='alert' aria-hidden='true'>&times;</button>"
            . "OK! El Insumo $nombre_insumo ha sido eliminado Correctamente.</div>";
        }
        else
        {
            $msg="<div class='alert alert-danger alert-dismissable'>"
            . "<button type='button' class='close' data-dismiss='alert' aria-hidden='true'>&times;</button>"
            . "Error! El insumo $nombre_insumo no pudo ser eliminado.</div>";
        }
    }
}
$lista_almacen=$objInsumoAlmacenC->MostrarInsumoAlmacen();
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
                  <b class="text-left"><i class="fa fa-certificate text-info"> GESTION DE ALMACEN</i></b>
                  <div class="pull-right" style="margin-top: -5px;">
                      <a href="nuevo_insumo_almacen.php" class="btn btn-success btn-xs"><i class="fa fa-plus"> Registrar Insumos</i></a>
                  </div>
              </div>
              <div class="panel-body">
                  
                  <table class="table table-responsive table-hover" id="dataTables-example">
                      <thead>
                          <tr>
                              <th>Nro.</th>
                              <th>Insumo</th>
                              <th>Cantidad</th>
                              <th>Fecha Compra</th>
                              <th>Precio Compra</th>
                              <th>Precio Venta</th>
                              <th>Fecha vencimiento</th>
                              <th>Proveedor</th>
                              <th>Acci&oacute;n</th>
                          </tr>
                      </thead>
                      <tbody>
                          <?php 
                          for ($i = 0; $i < count($lista_almacen); $i++) 
                          {
                              $nro=$i+1;
                              $id_insumoAlmacen=$lista_almacen[$i]->getId_insumo_almacen();
                              $id_insumo=$lista_almacen[$i]->getId_insumo();
                              $id_proveedor=$lista_almacen[$i]->getId_proveedor();
                              $fecha_compra=$lista_almacen[$i]->getFecha_compra();
                              $fecha_vencimiento=$lista_almacen[$i]->getFecha_vencimiento();
                              $precio_compra=$lista_almacen[$i]->getPrecio_compra();
                              $precio_venta=$lista_almacen[$i]->getPrecio_venta();
                              $cantidad=$lista_almacen[$i]->getCantidad();
                              $lote=$lista_almacen[$i]->getLote();
                              $nombre_insumo="";
                              $tr_class="";
                              $ArrInsumos=$objInsumoC->BuscarInsumo($id_insumo, "", "");
                              if(count($ArrInsumos)>0)
                              {
                                  $nombre_insumo=$ArrInsumos[0]->getNombre();
                                  if($ArrInsumos[0]->getCant_min_almacen() == $cantidad){$tr_class="alert alert-danger";}
                              }
                              $nombre_proveedor="-";
                              $arrProveedor=$objProveedor->BuscarProveedor($id_proveedor, "", "");
                              if(count($arrProveedor)>0){$nombre_proveedor=$arrProveedor[0]->getNombre();}
                              
                              echo "<tr>";
                              echo "<td>$nro</td>";
                              echo "<td>$nombre_insumo</td>";
                              echo "<td>$cantidad</td>";
                              echo "<td>$fecha_compra</td>";
                              echo "<td>$precio_compra</td>";
                              echo "<td>$precio_venta</td>";
                              echo "<td>$fecha_vencimiento</td>";
                             
                              echo "<td>$nombre_proveedor</td>";
                              echo "<td>";
                             
                              echo "<form method='post' action='almacen_gestion.php' id='form$i'>";
                               echo "<a href='editar_insumoAlmacen.php?nik=$id_insumoAlmacen' class='btn btn-warning btn-xs'><i class='fa fa-edit'></i></a>";
                               echo "<a href='mostrar_insumoAlmacen.php?nik=$id_insumoAlmacen' class='btn btn-primary btn-xs'><i class='fa fa-eye'></i></a>";
                              echo "<input type='hidden' name='id_insumo_delete' value='$id_insumoAlmacen'>";
                              echo "<input type='hidden' name='nombre_insumo' value='$nombre_insumo'>";
                              echo "<button type='button' class='btn btn-danger btn-xs' title='ELiminar' onclick='EliminarInumoAlmacen(this.id,this.value);'  value='$i' id='$nombre_insumo'> <i class='fa fa-trash'></i></button></form> ";
                              echo "</td>";
                              echo "</tr>";
                          }
                          
                          ?>
                      </tbody>
                  </table>
              </div>
          </div>
        </div>
    </div>
</section>




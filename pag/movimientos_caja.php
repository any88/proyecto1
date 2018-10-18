<?php
include '../funct/con_tacnamh_db.php';
include '../funct/functions.php';
include '../modelo/consultas_genericas.php';
include './header.php';
include '../modelo/TransaccionController.php';
include '../modelo/LogCajaController.php';
include '../modelo/PacienteServicioController.php';
include '../modelo/TipoServicioController.php';
include '../modelo/ServicioController.php';

$objTransaccion=new TransaccionController();
$objLogCajaC=new LogCajaController();
$objPacienteServC=new PacienteServicioController();
$objTipoServicio=new TipoServicioController();
$objServ=new ServicioController();

$total_ingreso_caja=0;
$total_extraccion_caja=0;
$total_pago_servicios=0;

$fecha= FechaYMA();
if($_POST)
{
    if(isset($_POST['fecha_balance'])){$fecha=$_POST['fecha_balance'];}
}
$arrLogCaja=$objLogCajaC->BuscarLogCaja("", $fecha, "", "");

$arrTransacciones=$objTransaccion->BuscarTransaccion("", $fecha, "","PL");
for ($i = 0; $i < count($arrLogCaja); $i++) 
{
    if($arrLogCaja[$i]->getAccion()==1)
    {
        $total_ingreso_caja=$total_ingreso_caja+$arrLogCaja[$i]->getCantidad();
    }
    else
    {
        $total_extraccion_caja=$total_extraccion_caja+$arrLogCaja[$i]->getCantidad();
    }
}
for ($i = 0; $i < count($arrTransacciones); $i++) 
{
    if($arrTransacciones[$i]->getFpago()=="PL")
    {
        $total_pago_servicios=$total_pago_servicios+$arrTransacciones[$i]->getMonto();
    }
}

include './menu_caja.php';
?>

<br><br>
<section class="about-text">
    <div class="ingres_costo ">
        <div class="col-md-12">
          <h3 class="text-left"><i class="fa fa-usd text-info"> Balance de Caja para la fecha <?php echo $fecha;?></i></h3>
          <div class="form-horizontal">
              <form method="post" action="movimientos_caja.php" name="fbc">
                  <div class="col-lg-2"><input type="date" name="fecha_balance" class="form-control" value="<?php echo $fecha;?>"></div>
                  <button type="submit" class="btn btn-success">Buscar</button>
              </form>
          </div>
           <div class="pull-right" style="margin-top: -90px; width: 200px; border-style:solid; border-width: 1px; border-radius: 5px;">
              <?php 
              $heigth1='20px';
              $heigth2='20px';
              $heigth3='20px';
              if($total_ingreso_caja >$total_extraccion_caja && $total_ingreso_caja >$total_pago_servicios)
              {
                  $heigth1='60px';
                  if($total_extraccion_caja > $total_pago_servicios){$heigth3='40px';$heigth2='20px';}
                  else {$heigth2='40px';$heigth3='20px';}
              
              }
              if($total_pago_servicios > $total_ingreso_caja && $total_pago_servicios > $total_extraccion_caja)
              {
                  $heigth2='60px';
                  if($total_extraccion_caja > $total_ingreso_caja){$heigth3='40px';$heigth1='20px';}
                  else {$heigth1='40px';$heigth3='20px';}
              }
              if($total_extraccion_caja > $total_ingreso_caja && $total_extraccion_caja > $total_pago_servicios)
              {
                  $heigth3='60px';
                  if($total_pago_servicios > $total_ingreso_caja){$heigth2='40px';$heigth1='20px';}
                  else {$heigth1='40px';$heigth2='20px';}
              }
              
              ?>
              <div style=" margin-left: 15px;">
                  <h4 >Estadisticas Caja</h4>
                      <div style="padding-left: 3px;padding-right: 3px;float: left; margin-bottom:2px;  height: 90px; bottom: 0;"> <div style="width: 40px;height: <?php echo $heigth1;?>; background-color: #469D46; float: bottom;" title="INGRESO A CAJA"></div><p style="text-align: right;"><?php echo $total_ingreso_caja;?></p></div>
                      <div style=" padding-left: 3px;padding-right: 3px;float: left; margin-bottom:2px;  height: 90px; bottom: 0;">  <div style="width: 40px;height: <?php echo $heigth2;?>; background-color: #3A87B9; float: bottom;" title="PAGO DE SERVICIOS"></div> <p style="text-align: right;"><?php echo $total_pago_servicios;?></p></div>
                      <div style=" padding-left: 3px;padding-right: 3px;float: left; margin-bottom:2px;  height: 90px; bottom: 0;"> <div style="width: 40px;height: <?php echo $heigth3;?>; background-color: #B94A48; float: bottom;" title="EXTRACCION DE EFECTIVO"></div> <p style="text-align: right;"><?php echo $total_extraccion_caja;?></p></div>
                 
                  
                  
              </div>
              
          </div>
          <div class="panel panel-default">
              <div class="panel-heading">
                  <b class="text-left"><i class="fa fa-search text-info"> BUSCADOR DE INSUMOS DE ALMACEN</i></b>
              </div>
              <div class="panel-body">
          <table class="table table-responsive table-hover">
              <thead>
                  <tr>
                      <th>Nro</th>
                      <th>Tipo de Movimiento</th>
                      <th>Fecha</th>
                      
                      <th>Cantidad</th>
                  </tr>
              </thead>
              <tbody>
                  <?php 
                  $class_tr='';
                  for ($i = 0; $i < count($arrLogCaja); $i++) 
                  {
                      $nro=$i+1;
                      $fechabd=$arrLogCaja[$i]->getFecha();
                      $cantbd=$arrLogCaja[$i]->getCantidad();
                      $tm=$arrLogCaja[$i]->getAccion();
                      $tipo_movimiento="-";
                      if($tm==1){$tipo_movimiento="INGRESO A CAJA";$class_tr='text-success';}
                      if($tm==0){$tipo_movimiento="EXTRACCION DE EFECTIVO EN CAJA";$class_tr='text-danger';}
                      
                      echo "<tr class='$class_tr'>";
                      echo "<td>$nro</td>";
                      echo "<td>$tipo_movimiento</td>";
                      echo "<td>$fecha</td>";
                      
                      echo "<td>s/. $cantbd</td>";
                      echo "</tr>";
                  }
                  $class_tr='text-info';
                  for ($i= 0; $i < count($arrTransacciones); $i++) 
                  {
                      $nro=$i+1;
                      $fechabd=$arrTransacciones[$i]->getFpago();
                      $cantbd=$arrTransacciones[$i]->getMonto();
                      $id_transaccion=$arrTransacciones[$i]->getIdTransaccion();
                      $tipo_movimiento="PAGO SERVICIO";
                      $nombre_servicio="";
                      $arrPacServC=$objPacienteServC->BuscarPacienteServicio("", "", "","",$id_transaccion);
                      if(count($arrPacServC)>0)
                      {
                          $id_servicio=$arrPacServC[0]->getIdservicio();
                          $arrServicios=$objServ->BuscarServicio($id_servicio, "", "");
                          if(count($arrServicios)>0)
                          {
                              $id_tipoS=$arrServicios[0]->getIdTipoServicio();
                              $arrTipoServicio=$objTipoServicio->BuscarTipoServicio($id_tipoS, "");
                              if(count($arrTipoServicio)>0)
                              {
                                  $nombre_servicio=$arrTipoServicio[0]->getTipoServicio();
                              }
                          
                          }
                      }
                      echo "<tr class='$class_tr'>";
                      echo "<td>$nro</td>";
                      echo "<td>$tipo_movimiento $nombre_servicio</td>";
                      echo "<td>$fecha</td>";
                      
                      echo "<td>s/. $cantbd</td>";
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

<?php
include '../funct/con_tacnamh_db.php';
include '../funct/functions.php';
include '../modelo/consultas_genericas.php';
include './header.php';

include '../modelo/PacienteServicioController.php';
include '../modelo/PacienteController.php';
include '../modelo/ServicioController.php';
include '../modelo/MedicoController.php';
include '../modelo/TipoServicioController.php';
include '../modelo/TransaccionController.php';
include '../modelo/CajaController.php';

$objPacienteServC=new PacienteServicioController();
$objPaciente=new PacienteController();
$objMedicoC=new MedicoController();
$objServicioC=new ServicioController();
$objTipoServicio=new TipoServicioController();
$objTransaccion=new TransaccionController();
$objCaja=new CajaController();


$fecha= FechaYMA();
if($_POST)
{
    if(isset($_POST['fecha_balance'])){$fecha=$_POST['fecha_balance'];}
}

$total_ingreso=0;
$aporte_a_caja=0;
$pago_aseguradora=0;
$pago_efectivo=0;
$extraccion_caja=0;
$total_gestion_caja=0;
$total_ingreso=$objTransaccion->TotalIngresoPorFecha($fecha);
$lista_transacciones=$objTransaccion->BuscarTransaccion("", $fecha, "");
if(count($lista_transacciones)>0)
{
    for ($i = 0; $i < count($lista_transacciones); $i++) 
    {
        $forma_pago=$lista_transacciones[$i]->getFpago();
        $monto=$lista_transacciones[$i]->getMonto();
        
        if($forma_pago=="PA"){$pago_aseguradora=$pago_aseguradora+$monto;}
        if($forma_pago=="PL"){$pago_efectivo=$pago_efectivo+$monto;}
    }
}
$total_gestion_caja=$aporte_a_caja-$extraccion_caja;

$arr_caja=$objCaja->MostrarCaja();
$total_caja=0;
if(count($arr_caja)>0){$total_caja=$arr_caja[0]->getCantidad();}

##el total en caja debe de ser el total en efectivo + el total en caja
$total_caja=$total_caja+$pago_efectivo;


include './menu_caja.php';
?>

<br><br>
<section class="about-text">
    <div class="ingres_costo ">
      
        <div class="">
          <h3 class="text-left"><i class="fa fa-usd text-info"> Balance de Caja para la fecha <?php echo $fecha;?></i></h3>
          <div class="form-horizontal">
              <form method="post" action="balance_caja.php" name="fbc">
                  <div class="col-lg-2"><input type="date" name="fecha_balance" class="form-control" value="<?php echo $fecha;?>"></div>
                  <button type="submit" class="btn btn-success">Buscar</button>
              </form>
              <div class="pull-right">
                  <form name="imp" method="post" action="imprimir_cierre.php">
                      <input type="hidden" name="fecha_balance" value="<?php echo $fecha;?>">
                      <button type='submit' class="btn btn-primary" target="_blank"><i class="fa fa-print"> </i> Imprimir Cierre</button>
                  </form>
                 
              </div>
              <hr>
              <div class="col-md-12" style="background-color: #d6cfcf;border-radius: 5px;color: black;margin-top: 5px;padding-top: 10px;">
                  <h4>Gesti&oacute;n de Caja</h4>
                  <table class="table table-responsive">
                      <tr>
                          <td>Aporte a Caja</td> <td class="pull-right">s/.<?php echo $aporte_a_caja;?></td>
                      </tr>
                      <tr>
                          <td>Extracci&oacute;n de Caja</td><td class="pull-right">s/.<?php echo $extraccion_caja;?></td>
                      </tr>
                      <tr>
                          <th>Total</th><td class="pull-right">s/.<?php echo $total_gestion_caja;?></td>
                      </tr>
                  </table>
                 
              </div>
              <div class="col-md-12" style="background-color: #d6cfcf;border-radius: 5px;color: black;margin-top: 5px;padding-top: 10px;">
                  <h4>Cobros de Servicio</h4>
                  <table class="table table-responsive">
                      <tr>
                          <td>Por Aseguradora</td> <td class="pull-right">s/.<?php echo $pago_aseguradora;?></td>
                      </tr>
                      <tr>
                          <td>Pago en Efectivo</td><td class="pull-right">s/.<?php echo $pago_efectivo;?></td>
                      </tr>
                      <tr>
                          <th>Total</th><td class="pull-right">s/.<?php echo $pago_aseguradora+$pago_efectivo;?></td>
                      </tr>
                  </table>
                  
              </div>
              <div class="col-md-12" style="background-color: #d6cfcf;border-radius: 5px;color: black;margin-top: 5px;padding-top: 10px;">
                  <h4>Efectivo en Caja</h4>
                  <p>Fecha: <?php echo FechaActual();?></p>
                  <p>Usuario: <?php echo "Jorge Ernesto Fernandez de la Torre";?></p>
                  <table class="table table-responsive">
                      <tr>
                          <th>Total</th><td class="pull-right">s/.<?php echo $total_caja;?></td>
                      </tr>
                  </table>
                  
              </div>
              
          </div>
        </div>
    </div>
</section>

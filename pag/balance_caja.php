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

$objPacienteServC=new PacienteServicioController();
$objPaciente=new PacienteController();
$objMedicoC=new MedicoController();
$objServicioC=new ServicioController();
$objTipoServicio=new TipoServicioController();
$objTransaccion=new TransaccionController();

include './menu_caja.php';
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

?>

<br><br>
<section class="about-text">
    <div class="ingres_costo ">
      
        <div class="">
          <h3 class="text-left"><i class="fa fa-user text-info"> Balance de Caja para la fecha <?php echo $fecha;?></i></h3>
          <div class="form-horizontal">
              <form method="post" action="balance_caja.php" name="fbc">
                  <div class="col-lg-2"><input type="date" name="fecha_balance" class="form-control" value="<?php echo $fecha;?>"></div>
                  <button type="submit" class="btn btn-success">Buscar</button>
              </form>
              
              <hr>
              <div class="col-md-10" style="background-color: #d6cfcf;border-radius: 5px;color: black;margin-top: 5px;padding-top: 10px;">
                  <h4>Gesti&oacute;n de Caja</h4>
                 Aporte a Caja  <p class="pull-right">s/.<?php echo $aporte_a_caja;?></p><br>
                 Extracci&oacute;n de Caja <p class="pull-right" style="margin-right: -20px;">s/.<?php echo $extraccion_caja;?></p><br>
                 Total <p class="pull-right" style="margin-right: -20px;">s/.<?php echo $total_gestion_caja;?></p>
              </div>
              <div class="col-md-10" style="background-color: #d6cfcf;border-radius: 5px;color: black;margin-top: 5px;padding-top: 10px;">
                  <h4>Cobros de Servicio</h4>
                  Por Aseguradora <p class="pull-right">s/.<?php echo $pago_aseguradora;?></p><br>
                  Pago en Efectivo<p class="pull-right" style="margin-right: -30px;">s/.<?php echo $pago_efectivo;?></p><br>
                  Total <p class="pull-right" style="margin-right: -30px;">s/.<?php echo $pago_aseguradora+$pago_efectivo;?></p>
              </div>
              
          </div>
        </div>
    </div>
</section>

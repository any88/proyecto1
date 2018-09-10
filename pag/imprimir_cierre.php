<?php
include '../funct/con_tacnamh_db.php';
include '../funct/functions.php';
include '../modelo/consultas_genericas.php';

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

//Imprimir
 require_once  ('../includes/pdf/html2pdf.class.php');
 include  ('balance_cierre_imprimir_plantilla.php');
    // get the HTML
    ob_start();
     error_reporting(E_ALL & ~E_NOTICE);
  ini_set('display_errors', 0);
  ini_set('log_errors', 1); 
    
   ob_end_clean();
  $content = ob_get_clean();  
    try
    {
        // init HTML2PDF
        $html2pdf = new HTML2PDF('P', 'LETTER', 'es', true, 'UTF-8', array(0, 0, 0, 0));
        // display the full page
        $html2pdf->pdf->SetDisplayMode('fullpage');
        $html2pdf->writeHTML($content, isset($_GET['vuehtml']));
        
        // send the PDF
        
        $html2pdf->Output("BalanceCaja.pdf");
     
          
   }
    catch(HTML2PDF_exception $e) {
    echo $e;
    exit;
    }
?>
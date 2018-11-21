<?php
include '../funct/con_tacnamh_db.php';
include '../funct/functions.php';
include '../modelo/consultas_genericas.php';

include '../modelo/PacienteServicioController.php';
include '../modelo/PacienteController.php';
include '../modelo/ServicioController.php';
include '../modelo/MedicoController.php';
include '../modelo/TipoServicioController.php';

$objPacienteServC=new PacienteServicioController();
$objPaciente=new PacienteController();
$objMedicoC=new MedicoController();
$objServicioC=new ServicioController();
$objTipoServicio=new TipoServicioController();




//Imprimir
 require_once  ('../includes/pdf/html2pdf.class.php');
 include  ('historia_clinica_plantilla.php');
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
        
        $html2pdf->Output("HistoriaClinicaPacienteTMH.pdf");
     
          
   }
    catch(HTML2PDF_exception $e) {
    echo $e;
    exit;
    }
?>


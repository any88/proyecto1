<?php
session_start();
include '../funct/functions.php';
include '../funct/con_tacnamh_db.php';
include '../modelo/LogCajaController.php';
$objLogCajaC=new LogCajaController();

$usuario_recibe="";
$nombre_persona_entrega="";
$cantidad=0;
$fecha="";
$motivo="---";
$id_logCaja="";
$accion="";
if($_GET)
{
    if(isset($_GET))
    {
        $id_logCaja=$_GET['nik'];
        if(eliminarblancos($id_logCaja!=""))
        {
            $arrCaja=$objLogCajaC->BuscarLogCaja("", "", "", $id_logCaja);
            if(count($arrCaja)>0)
            {
                $fecha=$arrCaja[0]->getFecha();
                $cantidad=$arrCaja[0]->getCantidad();
                $accion=$arrCaja[0]->getAccion();
                $motivo=$arrCaja[0]->getMotivo();
                $nombre_persona_entrega=$arrCaja[0]->getNombre_entrega();
                $id_usuario=$arrCaja[0]->getId_usuario();
                ##caso temporal hasta añadir inicio por sesiones
                if($id_usuario==1){$usuario_recibe="Jorge Ernesto Fernandez de la Torre";}
            }
            else 
            {
                $msg="<div class='alert alert-danger alert-dismissable'>"
                . "<button type='button' class='close' data-dismiss='alert' aria-hidden='true'>&times;</button>"
                . "Error! No se puede inprimir el recibo pues no se encuentra el registro en la base de datos.</div>";
                 $_SESSION['msg_imp']=$msg;

                echo "<script>";
                    echo "window.location = 'caja_declarar_ingreso.php';";
               echo "</script>";
            }
            
        }
        else 
        {
            $msg="<div class='alert alert-danger alert-dismissable'>"
            . "<button type='button' class='close' data-dismiss='alert' aria-hidden='true'>&times;</button>"
            . "Error! No se puede inprimir el recibo pues no se encuentra el registro en la base de datos.</div>";
             $_SESSION['msg_imp']=$msg;
             
            echo "<script>";
                echo "window.location = 'extraccion_efectivo.php';";
           echo "</script>";

        }
        
    }
    
    
    ##imprimir
    require_once  ('../includes/pdf/html2pdf.class.php');
    include  ('./caja_declarar_extraccion_plantilla.php');
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
}
else
{
    echo "<script>";
                echo "window.location = 'caja_declarar_ingreso.php';";
           echo "</script>";
}

?>

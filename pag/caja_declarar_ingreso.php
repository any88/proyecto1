<?php
session_start();
include '../funct/con_tacnamh_db.php';
include '../funct/functions.php';
include '../modelo/consultas_genericas.php';
include './header.php';


include '../modelo/LogCajaController.php';

$objLogCajaC=new LogCajaController();

$fecha= FechaActual();
$nomb_p="";
$observaciones="";
$cantidad=0;
$msg="";
$id_usuario="";
if(isset($_SESSION['msg_imp'])){$msg=$_SESSION['msg_imp'];unset($_SESSION['msg_imp']);}

if($_POST)
{
    if(isset($_POST['nombre_p'])){$nomb_p= eliminarblancos($_POST['nombre_p']);}
    if(isset($_POST['cantidad'])){$cantidad=eliminarblancos($_POST['cantidad']);}
    if(isset($_POST['motivo'])){$motivo=eliminarblancos($_POST['motivo']);}

    if($nomb_p!="" && $cantidad!="")
    {
        if(isNaN($cantidad))
        {
            $msg="<div class='alert alert-danger alert-dismissable'>"
            . "<button type='button' class='close' data-dismiss='alert' aria-hidden='true'>&times;</button>"
            . "Error! La cantidad entrada debe de ser un n&uacute;mero.</div>";
        }
        else
        {
            if($cantidad<=0)
            {
                $msg="<div class='alert alert-danger alert-dismissable'>"
                . "<button type='button' class='close' data-dismiss='alert' aria-hidden='true'>&times;</button>"
                . "Error! La cantidad entrada debe de ser mayor que 0.</div>";
            }
            else
            {
                $id_ultimo_insert_logCaja=$objLogCajaC->NuevoLogcaja(1, $observaciones, $cantidad, $fecha, 1,$nomb_p);
                
                if($id_ultimo_insert_logCaja!=0)
                {
                     $msg="<div class='alert alert-success alert-dismissable'>"
                    . "<button type='button' class='close' data-dismiss='alert' aria-hidden='true'>&times;</button>"
                    . "Se ha registrado el ingreso de efectivo en caja correctamente, Si desea imprimir un comprobante del ingreso acceder"
                    . " aqui <a href='imprimir_declarar_caja_ingresos.php?nik=$id_ultimo_insert_logCaja' target='_blank' class='btn btn-primary'><i class='fa fa-print'></i>Imprimir</a>.</div>";
                     $_SESSION['msg_imp']=$msg;
                     echo "<script>";
                        echo "window.location = 'caja_declarar_ingreso.php';";
                     echo "</script>";

                }
                else
                {
                     $msg="<div class='alert alert-danger alert-dismissable'>"
                    . "<button type='button' class='close' data-dismiss='alert' aria-hidden='true'>&times;</button>"
                    . "Error! No se pudo registrar el ingreso en caja.</div>";
                }
            }
        }
    }
 else 
    {
        $msg="<div class='alert alert-danger alert-dismissable'>"
        . "<button type='button' class='close' data-dismiss='alert' aria-hidden='true'>&times;</button>"
        . "Error! Los campos nombre y cantidad no pueden estar vac&iacute;os.</div>";
    }
    
}
include './menu_caja.php';
?>
<br><br>
<section class="about-text">
    <div class="ingres_costo ">
      
        <div class="">
          <h3 class="text-left"><i class="fa fa-usd text-info"> Declaraci&oacute;n de Ingresos en Caja</i></h3>
          <div class="alert alert-warning alert-dismissable">
              <button type='button' class='close' data-dismiss='alert' aria-hidden='true'>&times;</button>
              <i class="fa fa-exclamation-circle"> Se recomienda al cajero llevar un registro fiel de los ingresos y extracciones
              de caja para un mayor control sobre el efectivo que circula en la clinica.</i>
          </div>
          <br>
          <?php if($msg!=""){echo $msg;}?>
              <div class="panel panel-default">
                  <div class="panel-heading"> <b> Declaraci&oacute;n de ingreso de Efectivo, fecha (<?php echo $fecha;?>)</b></div>
                  <div class="panel-body">
                      <form name="dIng" method="post" action="caja_declarar_ingreso.php">
                          <table class="table table-responsive">
                          <tr>
                              <td class="col-md-4">Nombre persona que ingresa el efectivo</td>
                              <td><input type="text" class="form-control" name="nombre_p"></td>
                          </tr>
                          <tr>
                              <td class="col-md-4">Cantidad Ingresada</td>
                              <td><input type="text" class="form-control" name="cantidad"></td>
                          </tr>
                          <tr>
                              <td class="col-md-4">Observaciones</td>
                              <td><textarea class="form-control" name="motivo"></textarea></td>
                          </tr>
                          <tr>
                              
                              <td colspan="2">
                                  <div class="pull-right"><button class="btn btn-success" type="submit">Guardar</button></div>
                              </td>
                          </tr>
                  
                        </table>
                      </form>
                      
                  </div>
                  
              </div>
              
         
        </div>
    </div>
</section>


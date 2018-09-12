<?php
session_start();
include '../funct/con_tacnamh_db.php';
include '../funct/functions.php';
include '../modelo/consultas_genericas.php';
include './header.php';


include '../modelo/LogCajaController.php';
include '../modelo/CajaController.php';

$objLogCajaC=new LogCajaController();
$objCajaC=new CajaController();

$fecha= FechaActual();
$nomb_p="";
$observaciones="";
$cantidad=0;
$msg="";
$id_usuario="";
$total_caja=0;
$arrCaja=$objCajaC->MostrarCaja();
if(count($arrCaja)>0)
{
    $total_caja=$arrCaja[0]->getCantidad();
}
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
                ##si la cantidad que se desea sustraer es mayor que la cantidad de dinero en caja
                if($total_caja<$cantidad)
                {
                    $msg="<div class='alert alert-danger alert-dismissable'>"
                   . "<button type='button' class='close' data-dismiss='alert' aria-hidden='true'>&times;</button>"
                   . "La cantidad que desea sustraer es mayor que la cantidad de dinero disponible en caja. (disponible en caja $total_caja soles)</div>";
                        
                }
                else
                {
                    $id_ultimo_insert_logCaja=$objLogCajaC->NuevoLogcaja('0', $observaciones, $cantidad, $fecha, 1,$nomb_p);
                
                    if($id_ultimo_insert_logCaja!=0)
                     {
                        ##sumarle la nueva cantidad a lo que hay en efectivo en caja
                        $aff=$objCajaC->ExtraerCantidad($cantidad);
                        if($aff==1)
                        {
                             $msg="<div class='alert alert-success alert-dismissable'>"
                        . "<button type='button' class='close' data-dismiss='alert' aria-hidden='true'>&times;</button>"
                        . "Se ha registrado la extracci&oacute;n de efectivo en caja correctamente, Si desea imprimir un comprobante,acceder"
                        . " aqui <a href='imprimir_declarar_caja_extraccion.php?nik=$id_ultimo_insert_logCaja' target='_blank' class='btn btn-primary'><i class='fa fa-print'></i>Imprimir</a>.</div>";
                        }
                        else
                        {
                             $msg="<div class='alert alert-warning alert-dismissable'>"
                        . "<button type='button' class='close' data-dismiss='alert' aria-hidden='true'>&times;</button>"
                        . "Error!!! no se pudo actualizar la cantidad de efectivo en caja.</div>";
                         $aff=$objLogCajaC->EliminarLogCaja($id_ultimo_insert_logCaja);

                        }
                         $_SESSION['msg_imp']=$msg;
                         echo "<script>";
                            echo "window.location = 'caja_declarar_ingreso.php';";
                         echo "</script>";

                    }
                    else
                    {
                         $msg="<div class='alert alert-danger alert-dismissable'>"
                        . "<button type='button' class='close' data-dismiss='alert' aria-hidden='true'>&times;</button>"
                        . "Error! No se pudo registrar la extracci&oacute;n de efectivo en caja.</div>";
                    }
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
          <h3 class="text-left"><i class="fa fa-usd text-info"> Declaraci&oacute;n de Extracci&oacute;n de efectivo en Caja</i></h3>
          <div class="alert alert-warning alert-dismissable">
              <button type='button' class='close' data-dismiss='alert' aria-hidden='true'>&times;</button>
              <i class="fa fa-exclamation-circle"> Se recomienda al cajero llevar un registro fiel de los ingresos y extracciones
              de caja para un mayor control sobre el efectivo que circula en la clinica.</i>
          </div>
          <br>
          <?php if($msg!=""){echo $msg;}?>
              <div class="panel panel-default">
                  <div class="panel-heading"> <b> Declaraci&oacute;n de Extracci&oacute; de Efectivo, fecha (<?php echo $fecha;?>)</b></div>
                  <div class="panel-body">
                      <form name="dIng" method="post" action="extraccion_efectivo.php">
                          <table class="table table-responsive">
                          <tr>
                              <td class="col-md-4">Nombre persona que sustrae el efectivo</td>
                              <td><input type="text" class="form-control" name="nombre_p"></td>
                          </tr>
                          <tr>
                              <td class="col-md-4">Cantidad </td>
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


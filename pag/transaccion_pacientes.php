<?php
include '../funct/con_tacnamh_db.php';
include '../funct/functions.php';
include './header.php';

include '../modelo/AseguradoraController.php';
include '../modelo/PacienteController.php';
include '../modelo/consultas_genericas.php';
include '../modelo/PacienteServicioController.php';
include '../modelo/ServicioController.php';
include '../modelo/TipoServicioController.php';
include '../modelo/TransaccionController.php';

$objPS=new PacienteServicioController();
$objP= new PacienteController();
$objServicioC=new ServicioController();
$objTipoServicio=new TipoServicioController();
$objTransaccion=new TransaccionController();
$objA=new AseguradoraController();


#id_paciente_servicio
##tipo Transaccion en este caso es 1 de ingreso
##motivo es 1 de cobro de pacientes

$id_pacienteS="";
$id_paciente="";
$id_servicio="";
$nombre_paciente="";
$nombre_servicio="";
$id_aseguradora="";
$precio=0;
$monto=0;
$f_pago="";
$nombre_aseguradora="";
$msg="";
$error=0;
$estado="PENDIENTE";
if($_POST)
{    Mostrar($_POST);
    if(isset($_POST['idt']))
    {
        $id_pacienteS=$_POST['idt'];
        $arrPS=$objPS->BuscarPacienteServicio($id_pacienteS, "", "");
        if(count($arrPS)>0)
        {
            $id_paciente=$arrPS[0]->getIdpaciente();
            $id_servicio=$arrPS[0]->getIdservicio();
            $id_trans=$arrPS[0]->getIdtransaccion();
            if($id_trans!=""){$estado="PAGO";}
            $arrPaciente=$objP->BuscarPaciente("", "", "", $id_paciente);
            if(count($arrPaciente)>0)
            {
                $nombre_paciente=$arrPaciente[0]->getNombre();
                $id_aseguradora=$arrPaciente[0]->getIdAseguradora();
                $arrAseguradora=$objA->BuscarAseguradora($id_aseguradora, "", "");
                if(count($arrAseguradora)>0){$nombre_aseguradora=$arrAseguradora[0]->getNombre();}
            }
            
            $arr_servicio=$objServicioC->BuscarServicio($id_servicio, "", "");
            if(count($arr_servicio)>0)
            {
               $id_ts=$arr_servicio[0]->getIdTipoServicio();
               $precio=$arr_servicio[0]->getPrecio();
               $monto=$precio;
               $arrTipoServicios=$objTipoServicio->BuscarTipoServicio($id_ts, "");
               if(count($arrTipoServicios)>0)
               {$nombre_servicio=$arrTipoServicios[0]->getTipoServicio();}
            }
        }

    }
    ##por la misma pagina
    if(isset($_POST['id_paciente_servicio'])){$id_pacienteS=$_POST['id_paciente_servicio'];
    
    if(isset($_POST['id_paciente_servicio'])){$id_pacienteS=$_POST['id_paciente_servicio'];}
    if(isset($_POST['id_aseguradora'])){$id_aseguradora=$_POST['id_aseguradora'];}
    if(isset($_POST['id_paciente'])){$id_paciente=$_POST['id_paciente'];}
    if(isset($_POST['id_servicio'])){$id_servicio=$_POST['id_servicio'];}
    if(isset($_POST['f_pago'])){$f_pago=$_POST['f_pago'];}
    if(isset($_POST['precio_base'])){$precio=$_POST['precio_base'];}
    if(isset($_POST['monto'])){$monto=$_POST['monto'];}
    
        if(eliminarblancos($monto)=="" ||eliminarblancos($monto)<=0 )
        {
            $msg="<div class='alert alert-danger alert-dismissable'>"
            . "<button type='button' class='close' data-dismiss='alert' aria-hidden='true'>&times;</button>"
            . "Error! Usted debe de especificar la cantidad a pagar.</div>";
        }
        else 
        {
            if(isNaN($monto))
            {
                $msg="<div class='alert alert-danger alert-dismissable'>"
                . "<button type='button' class='close' data-dismiss='alert' aria-hidden='true'>&times;</button>"
                . "Error! El monto a pagar debe de ser un n&uacute;mero</div>";
            }
            else
            {
                $fecha= FechaYMA();
                ##validar que el servicio no tenga asignada una transaccion
                $arrPS=$objPS->BuscarPacienteServicio($id_pacienteS, "", $id_servicio);
                if(count($arrPS)>0)
                {
                    $id_transaccion_creada=$arrPS[0]->getIdtransaccion();
                    if($id_transaccion_creada=="")
                    {
                        $id_transaccion_creada=$objTransaccion->CrearTransaccion(1, $fecha, $monto, 1,$f_pago);
                        if($id_transaccion_creada==0)
                        {
                            $msg="<div class='alert alert-danger alert-dismissable'>"
                            . "<button type='button' class='close' data-dismiss='alert' aria-hidden='true'>&times;</button>"
                            . "Error! No se pudo efectuar el pago.</div>";
                        }
                        else
                        {
                            ##modificar el idtransaccion en paciente servicio
                            $affected=$objPS->EfectuarPago($id_pacienteS, $id_transaccion_creada);
                            if($affected==0)
                            {
                                $msg="<div class='alert alert-danger alert-dismissable'>"
                                . "<button type='button' class='close' data-dismiss='alert' aria-hidden='true'>&times;</button>"
                                . "Error! No se pudo efectuar el pago en paciente servicio.</div>";
                                ##eliminar la transacion
                                $aff=$objTransaccion->EliminarTransaccion($id_transaccion_creada);
                            }
                            else 
                            {
                                $msg="<div class='alert alert-success alert-dismissable'>"
                                . "<button type='button' class='close' data-dismiss='alert' aria-hidden='true'>&times;</button>"
                                . "OK! Pago efectuado correctamente.</div>";
                                echo "<script>";
                                    echo "window.location = 'mostrarpaciente.php?nik=$id_paciente';";
                               echo "</script>";

                            }
                        }
                    }
                    else
                    {
                        $affected=$objTransaccion->ModificarTransaccion($id_transaccion_creada, 1, $fecha, $monto, 1, $f_pago);
                        if($affected==0)
                            {
                                $msg="<div class='alert alert-danger alert-dismissable'>"
                                . "<button type='button' class='close' data-dismiss='alert' aria-hidden='true'>&times;</button>"
                                . "Error! No se pudo efectuar el pago en paciente servicio.</div>";
                                
                                ##eliminar la transacion
                                $aff=$objTransaccion->EliminarTransaccion($id_transaccion_creada);
                            }
                            else 
                            {
                                $msg="<div class='alert alert-success alert-dismissable'>"
                                . "<button type='button' class='close' data-dismiss='alert' aria-hidden='true'>&times;</button>"
                                . "OK! Pago efectuado correctamente.</div>";
                                 echo "<script>";
                                    echo "window.location = 'mostrarpaciente.php?nik=$id_paciente';";
                               echo "</script>";
                            }
                    }
                }
                
                
            }
        }
        
    
    }
    
}
 else {
    echo "<script>";
     echo "window.location = 'listar_pacientes.php';";
echo "</script>";

}
?>
<br>
<br>
<section class="about-text">
    <div class="container ">
        <?php if($msg!=""){echo $msg;}?>
        <div class="col-md-2"></div>
        <div class="col-md-8 form-group">
            <div class="panel panel-default">
                <div class="panel-heading">
                    <h3 class="text-left"><i class="fa fa-user text-info"> Cobro de Servicios</i></h3>
                    <div class="pull-right" style="margin-top: -30px;"> Estado (<?php echo $estado;?>)</div>
                </div>
                <div class="panel-body">
                    <form name="ft" method="post" action="transaccion_pacientes.php" >
                        <input type="hidden" name='id_paciente_servicio' value="<?php echo $id_pacienteS;?>">
                        <input type="hidden" name='id_aseguradora' value="<?php echo $id_aseguradora;?>">
                        <input type="hidden" name='id_paciente' value="<?php echo $id_paciente;?>">
                        <input type="hidden" name='id_servicio' value="<?php echo $id_servicio;?>">
                        <input type="hidden" name='precio_base' value="<?php echo $precio;?>">
                        <table class="table table-responsive">
                          <tr>
                              <th>Nombre Paciente:</th>
                              <td><?php echo $nombre_paciente;?></td>
                          </tr>
                          <tr>
                              <th>Nombre Servicio:</th>
                              <td><?php echo $nombre_servicio;?></td>
                          </tr>
                          <tr>
                              <th>Forma de pago:</th>
                              <td>
                                  <?php 
                                      $chekedA="";
                                      $chekedL="";
                                          if($id_aseguradora!="" && $p_forma_pago="PA")
                                          {
                                              $chekedA="checked='checked'";
                                          }
                                           if($id_aseguradora=="" && $p_forma_pago="PL")
                                          {
                                               $chekedL="checked='checked'";
                                          }
                                    ?>
                                  <div class="form-horizontal">

                                      <b>Pago Libre: </b> <input type="radio" name='f_pago' <?php echo $chekedL;?> value='PL' class="radio radio-inline">
                                      &nbsp;&nbsp;
                                      <b>Pago por Aseguradora (<?php echo $nombre_aseguradora;?>):  </b><input type="radio" name='f_pago' <?php echo $chekedA;?> value="PA" class="radio radio-inline">
                                  </div>

                              </td>
                          </tr> 
                          <tr>
                              <th>Precio Acordado:</th>
                              <td>s/. <?php echo $precio;?></td>
                          </tr> 
                          <tr>
                              <th>Monto a Pagar:</th>
                              <td><input type="text" name='monto' value='<?php echo $monto;?>' required class="form-control"></td>
                          </tr>
                          <tr>
                              <td colspan="2">
                                  <div class="pull-right">
                                      <button type="submit" class="btn btn-success"><i class="fa fa-dollar"> Efectuar Pago</i></button>
                                      <a href="mostrarpaciente.php?nik=<?php echo $id_paciente;?>" class="btn btn-danger"> Cancelar</a>
                                  </div>
                              </td>
                          </tr>

                        </table>



                        </form>
                </div>
            </div>
          
          
        </div>
        <div class="col-md-2"></div>
    </div>
</section>



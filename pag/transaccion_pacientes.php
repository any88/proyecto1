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
include '../modelo/ConsultaController.php';
include '../modelo/EspecialidadController.php';
include '../modelo/InsumoCirugiaController.php';
include '../modelo/HospitalizacionController.php';
include '../modelo/CirugiaController.php';
include '../modelo/InsumoController.php';
include '../modelo/InsumoHospitalizacionController.php';
include '../modelo/CajaController.php';
$objCajaC=new CajaController();

$saldo_caja=0;
$arrCaja=$objCajaC->MostrarCaja();
if(count($arrCaja)>0)
{
    $saldo_caja=$arrCaja[0]->getCantidad();
}

$objPS=new PacienteServicioController();
$objP= new PacienteController();
$objServicioC=new ServicioController();
$objTipoServicio=new TipoServicioController();
$objTransaccion=new TransaccionController();
$objA=new AseguradoraController();
$objConsultaC=new ConsultaController();
$objEspecialidad= new EspecialidadController();
$objInsumoCirugia=new InsumoCirugiaController();
$objInsumoHosp=new InsumoHospitalizacionController();
$objCirugiaC=new CirugiaController();
$objInsumoController=new InsumoController();


#id_paciente_servicio
##tipo Transaccion en este caso es 1 de ingreso
##motivo es 1 de cobro de pacientes

$id_pacienteS="";
$id_paciente="";
$id_servicio="";
$nombre_paciente="";
$nombre_servicio="";
$id_aseguradora="";
$especialidad="";
$dni="";
$direccion="";
$id_ts="";
$precio=0;
$monto=0;
$saldo=0;
$f_pago="";
$nombre_aseguradora="";
$msg="";
$error=0;
$estado="PENDIENTE";
if($_POST)
{   
    
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
                $dni=$arrPaciente[0]->getDocID();
                $direccion=$arrPaciente[0]->getDireccion();
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
                                if($f_pago=="PL")
                                {
                                    $aff=$objCajaC->ModificarCantidad($monto);
                                    if($aff==1)
                                    {
                                        $msg="<div class='alert alert-success alert-dismissable'>"
                                        . "<button type='button' class='close' data-dismiss='alert' aria-hidden='true'>&times;</button>"
                                        . "OK! Pago efectuado correctamente.</div>";
                                        echo "<script>";
                                            echo "window.location = 'listar_servicios.php';";
                                       echo "</script>";
                                    }
                                    else
                                    {
                                        $msg="<div class='alert alert-danger alert-dismissable'>"
                                        . "<button type='button' class='close' data-dismiss='alert' aria-hidden='true'>&times;</button>"
                                        . "Error! No se pudo modificar la cantidad de efectivo en caja.</div>";
                                        ##eliminar la transacion
                                        $aff=$objTransaccion->EliminarTransaccion($id_transaccion_creada);
                                    }
                                }
                                else
                                {
                                    $msg="<div class='alert alert-success alert-dismissable'>"
                                        . "<button type='button' class='close' data-dismiss='alert' aria-hidden='true'>&times;</button>"
                                        . "OK! Pago efectuado correctamente.</div>";
                                        echo "<script>";
                                            echo "window.location = 'listar_servicios.php';";
                                       echo "</script>";
                                }

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
       
        <div class="col-md-8 form-group">
            <div class="panel panel-default">
                <div class="panel-heading">
                    <h3 class="text-left"><i class="fa fa-user text-info"> Cobro de Servicios</i></h3>
                    <div class="pull-right" style="margin-top: -30px;"> 
                        <span class="text text-success"><b>s/. <?php echo $saldo_caja;?></b> en caja</span>
                        
                    </div>
                </div>
                <div class="panel-body">
                    <form name="ft" method="post" action="transaccion_pacientes.php" >
                        <input type="hidden" name='id_paciente_servicio' value="<?php echo $id_pacienteS;?>">
                        <input type="hidden" name='id_aseguradora' value="<?php echo $id_aseguradora;?>">
                        <input type="hidden" name='id_paciente' value="<?php echo $id_paciente;?>">
                        <input type="hidden" name='id_servicio' value="<?php echo $id_servicio;?>">
                        <input type="hidden" name='precio_base' value="<?php echo $precio;?>">
                        <input type="hidden" name="idt" value="<?php echo $id_pacienteS;?>">
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

                                      <b>Pago Libre: </b> <input type="radio" name='f_pago' <?php echo $chekedL;?> value='PL' class="radio radio-inline" id='radio_libre' onclick="TrVisibles();">
                                      &nbsp;&nbsp;
                                      <b>Pago por Aseguradora (<?php echo $nombre_aseguradora;?>):  </b><input type="radio" name='f_pago' <?php echo $chekedA;?> value="PA" class="radio radio-inline" id='radio_aseguradora' onclick="TrOcultos();">
                                  </div>

                              </td>
                          </tr> 
                          
                          <tr>
                              <th>Monto a Pagar:</th>
                              <td><input type="text" name='monto' value='<?php echo $monto;?>' required class="form-control" id='monto' onkeyup="Vuelto();"></td>
                          </tr>
                          <tr class="hidden" id="trabondo_hidden">
                              <th>Abonado por el cliente</th>
                              <td><input type="text" name='saldo' value='<?php echo $saldo;?>' class="form-control" id='abonado' onkeyup="Vuelto();"></td>
                          </tr>
                          <tr class="hidden" id="trvuelto_hidden">
                              <th>Vuelto a entregar</th>
                             
                              <td><input type="text" name='saldo' value='s/. 0' class="form-control"  readonly="true" id='vueltos'></td>
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
        
        <div class="col-md-4 about-container">
            <div class="panel panel-default">
                <div class="panel-heading">
                    <i class="fa fa-dollar text-info"> Resumen del Servicio Prestado</i>
                </div>
                <div class="panel-body">
                    <div class="form-horizontal">
                        <label>Cliente: </label> <?php echo $nombre_paciente;?><br>
                        <label>Documento Identidad: </label> <?php echo $dni;?><br>
                        <label>Direcci&oacute;n: </label> <?php echo $direccion;?><br>
                        <label>Servicio Prestado: </label> <?php echo $nombre_servicio;?><br>
                        <?php 
                        $arrCons=$objConsultaC->BuscarConsulta("", "",$id_servicio);
                        if(count($arrCons)>0)
                        {
                           $id_especialidad=$arrCons[0]->getEspecialidad();
                           $arrEspecialidad=$objEspecialidad->BuscarEspecialidad($id_especialidad, "", "");
                           if(count($arrEspecialidad)>0){$especialidad=$arrEspecialidad[0]->getNombreespecialidad();}
                        }
                            if($id_ts==1)
                            {
                                ##consulta
                                echo "<label>Especialidad: </label> $especialidad <br>";
                            }
                            if($id_ts==2)
                            {
                                ##cirugia
                                $total_por_insumos=0;
                                $listaInsumosCirugia=array();
                                $arrCir=$objCirugiaC->BuscarCirugia("", "", "",$id_servicio);
                                $id_cirugia="";
                                if(count($arrCir)>0)
                                   {
                                    $id_cirugia=$arrCir[0]->getIdCirugia();
                                    $id_especialidad=$arrCir[0]->getIdEspecialidad();
                                    $arrEspecialidad=$objEspecialidad->BuscarEspecialidad($id_especialidad, "", "");
                                    if(count($arrEspecialidad)>0)
                                    {
                                        $especialidad=$arrEspecialidad[0]->getNombreespecialidad();
                                    }
                                   }
                                echo "<label>Especialidad: </label> $especialidad <br>";
                                echo "<label>Desgloce por Insumos: </label> <br>";
                                echo "<table class='table table-responsive'>";
                                echo "<tr>";
                                    echo "<th>Insumo</th>";
                                    echo "<th>Cantidad</th>";
                                    echo "<th>Precio Unitario</th>";
                                    echo "<th>Sub. Total</th>";
                                echo "</tr>";
                                
                                if($id_cirugia!="")
                                {
                                    $listaInsumosCirugia=$objInsumoCirugia->BuscarInsumoCirugia("", "", $id_cirugia);
                                    if(count($listaInsumosCirugia)>0)
                                    {
                                        for ($k = 0; $k < count($listaInsumosCirugia); $k++) 
                                        {
                                            $subT=0;
                                            $id_insumo=$listaInsumosCirugia[$k]->getIdinsumo();
                                            $cant_insumos=$listaInsumosCirugia[$k]->getCantidadinsumo();
                                            $nombre_insumo="-";
                                            $precio_insumo=0;
                                            $arrInsumos=$objInsumoController->BuscarInsumo($id_insumo, "", "");
                                            if(count($arrInsumos)>0)
                                            {
                                                $nombre_insumo=$arrInsumos[0]->getNombre();
                                                $precio_insumo=$arrInsumos[0]->getPrecioUnitario();
                                                echo "<tr>";
                                                echo "<td>$nombre_insumo</td>";
                                                echo "<td>$cant_insumos</td>";
                                                echo "<td>$precio_insumo</td>";
                                                $subT=$cant_insumos*$precio_insumo;
                                                echo "<td>s/.$subT</td>";
                                                $total_por_insumos=$total_por_insumos+$subT;
                                                echo "</tr>";
                                            }
                                        }
                                        echo "<tr>";
                                        echo "<td colspan='3'><b>Precio Total</b></td>";
                                        echo "<td><b> s/.$total_por_insumos</b></td>";
                                        echo "</tr>";
                                    }
                                }
                                
                                echo "</table>";
                            }
                            if($id_ts==3)
                            {
                                ##hospitalizacion
                                echo "<label>Cantidad dias Hospitalizados: </label> 3 <br>";
                                
                            }
                        ?>
                        <label>Monto a Pagar: </label> s/.<?php echo $precio;?>
                    </div>
                </div>
                
            </div>
        </div>
    </div>
</section>
<?php include './footer.html'; ?>


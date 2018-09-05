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
include '../modelo/MedicoCirugiaController.php';
include '../modelo/MedicoConsultaController.php';
include '../modelo/ConsultaController.php';
include '../modelo/CirugiaController.php';


$objPacienteServC=new PacienteServicioController();
$objPaciente=new PacienteController();
$objMedicoC=new MedicoController();
$objServicioC=new ServicioController();
$objTipoServicio=new TipoServicioController();
$objTransaccion=new TransaccionController();
$objMedConsulta=new MedicoConsultaController();
$objMedicoCirugia=new MedicoCirugiaController();
$objConsultaC=new ConsultaController();
$objCirugia=new CirugiaController();
include './menu_caja.php';

$p_fecha= FechaYMA();
$lista_transacciones=$objTransaccion->BuscarTransaccion("", $p_fecha, "");
$total_ingreso=$objTransaccion->TotalIngresoPorFecha($p_fecha);
?>

<br><br>
<section class="about-text">
    <div class="ingres_costo">
      
        <div class="">
          <h3 class="text-left"><i class="fa fa-user text-info">Ingresos del Dia (s/. <?php echo $total_ingreso;?>)</i></h3>
          
          <?php 
          if(count($lista_transacciones)>0)
          {
              echo "<table class='table table-responsive' id='dataTables-example'>";
              echo "<thead>";
              echo "<tr>";
              echo "<th>Nro</th>";
                echo "<th>Servicio</th>";
                echo "<th>Medico</th>";
                echo "<th>Ingreso</th>";
                echo "<th>Motivo</th>";
                echo "<th>Tipo de Pago</th>";
              echo "</tr>";
              echo "</thead>";
              echo "<tbody>";
              for ($i = 0; $i < count($lista_transacciones); $i++) 
              {
                  $nro=$i+1;
                  $id_transaccion=$lista_transacciones[$i]->getIdTransaccion();
                  $monto=$lista_transacciones[$i]->getMonto();
                  $motivo=$lista_transacciones[$i]->getMotivo();
                  $forma_pago=$lista_transacciones[$i]->getFpago();
                  $nombre_motivo="";
                  if($motivo==1){$nombre_motivo="COBRO DE SERVICIOS";}
                  $nomb_fp="-";
                  if($forma_pago=="PA"){$nomb_fp="PAGO ASEGURADORA";}
                  if($forma_pago=="PL"){$nomb_fp="PAGO en EFECTIVO";}
                  $nombre_servicio="";
                  $nombre_medico="-";
                  
                  $arrPacServ=$objPacienteServC->BuscarPorIdTransaccion($id_transaccion);
                  if(count($arrPacServ)>0)
                  {
                     $id_servicio=$arrPacServ[0]->getIdservicio();
                     $arrServ=$objServicioC->BuscarServicio($id_servicio, "", "");
                     if(count($arrServ)>0)
                     {
                         $id_tipo_servicio=$arrServ[0]->getIdTipoServicio();
                         $arrTipoServicio=$objTipoServicio->BuscarTipoServicio($id_tipo_servicio, "");
                         if(count($arrTipoServicio)>0)
                         {
                             $nombre_servicio=$arrTipoServicio[0]->getTipoServicio();
                         }
                         
                         if($id_tipo_servicio==1)
                         {
                             ##buscar nombre dl medico en medico consulta
                             $arrConsultas=$objConsultaC->BuscarConsulta("", "", $id_servicio);
                             if(count($arrConsultas)>0)
                             {
                                 $id_consultabd=$arrConsultas[0]->getIdConsulta();
                                 $arrMedConsultas=$objMedConsulta->BuscarMedicoConsulta("", "", $id_consultabd);
                                 if(count($arrMedConsultas)>0)
                                 {
                                     $id_medico=$arrMedConsultas[0]->getIdmedico();
                                     $arrMedico=$objMedicoC->BuscarMedico($id_medico, "", "");
                                     if(count($arrMedico)>0)
                                     {
                                         $nombre_medico=$arrMedico[0]->getNombre();
                                     }
                                 }
                             }
                            
                         }
                         
                         if($id_tipo_servicio==2)
                         {
                             ##buscar nombre del medico en medico cirugia
                             $arrCirugia=$objCirugia->BuscarCirugia("", "", "", $id_servicio);
                             if(count($arrCirugia)>0)
                             {
                                 $id_cirugia=$arrCirugia[0]->getIdCirugia();
                                 $arrMedCirugias=$objMedicoCirugia->BuscarMedicoCirugia("", "", $id_cirugia);
                                 if(count($arrMedCirugias)>0)
                                 {
                                     $id_medico=$arrMedCirugias[0]->getIdmedico();
                                     $arrMedico=$objMedicoC->BuscarMedico($id_medico, "", "");
                                     if(count($arrMedico)>0)
                                     {
                                         $nombre_medico=$arrMedico[0]->getNombre();
                                     }
                                 }
                             }
                         }
                     }
                  }
                  echo "<tr>";
                  echo "<td>$nro</td>";
                  echo "<td>$nombre_servicio</td>";
                  echo "<td>$nombre_medico</td>";
                  echo "<td>s/. <b>$monto</b></td>";
                  echo "<td>$nombre_motivo</td>";
                  echo "<td>$nomb_fp</td>";
                  echo "</tr>";
              }
              echo "</tbody>";
              echo '</table>';
          }
          else 
          {
              echo "<div class='alert alert-info alert-dismissable'>"
                . "<button type='button' class='close' data-dismiss='alert' aria-hidden='true'>&times;</button>"
                . "No se han registrados pagos en el dia de hoy $p_fecha.</div>";
          }
          
          ?>
        </div>
    </div>
</section>
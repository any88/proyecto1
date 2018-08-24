<?php

include '../funct/con_tacnamh_db.php';
include '../funct/functions.php';
include './header.php';

include '../modelo/consultas_genericas.php';
include '../modelo/ServicioController.php';
include '../modelo/PacienteController.php';
include '../modelo/InsumoController.php';
include '../modelo/HospitalizacionController.php';
include '../modelo/InsumoHospitalizacionController.php';

$objHospitalizacion= new HospitalizacionController();
$objPacienteC= new PacienteController();
$objInsumo= new InsumoController();
$objInsumoHosp= new InsumoHospitalizacionController();
$objServicioC=new ServicioController();

$datoshosp=array();
$datosInsumoHosp=array();

$idhosp="";

if($_GET)
    {
        if(isset($_GET["nik"]))
        {
            $idhosp= $_GET["nik"];
            $datoshosp=$objHospitalizacion->BuscarHospitalizacion($idhosp, "", "");
        }
    }
?>
<br><br>
<section class="about-text">
    <div class="container">
      
        <div class="col-md-12">
          <h3 class="text-left"><i class="fa fa-eye text-info"> Datos del Ingreso</i></h3>
          <?php 
          if(count($datoshosp)>0)
          {
                 $idservicio=$datoshosp[0]->getIdServicio();
                 $fechaingreso=$datoshosp[0]->getFechaIngreso();
                 $fechaalta=$datoshosp[0]->getFechaAlta();
                 $tipohab=$datoshosp[0]->getTipoHabitacion();
                 $nrocama=$datoshosp[0]->getNroCama();
                 $nombrefamiliar=$datoshosp[0]->getNombreFamiliar();
                 $parentescofam=$datoshosp[0]->getParentescoFamiliar();
                 $estadopaciente=$datoshosp[0]->getEstadoDelPaciente();
                 $condicatencion=$datoshosp[0]->getCondicionDeAtencion();
                 $pa=$datoshosp[0]->getPA();
                 $pulso=$datoshosp[0]->getPulso();
                 $temp=$datoshosp[0]->getTemp();
                 $peso=$datoshosp[0]->getPeso();
                 $examfis=$datoshosp[0]->getExamenFisico();
                 //$precio=$datoshosp[0]->getPrecio();  //deberia venir de servicio
                 
                 if($tipohab=="f"){$tipohab="Full";}
                 if($tipohab=="c"){$tipohab="Compartida";}    
                 
                 ##datos del paciente por paciente servicio
                 $cg=new ConsultasG();
                 $p=array();
                 $p['campo'][0]='idservicio';
                 $p['valor'][0]=$idservicio;
                 $r=$cg->GenericSelect('paciente_servicio', $p);
                 $dat_pacientesS=$cg->ArregloAsociativoSelect($r, 'paciente_servicio');
                 if(count($dat_pacientesS)>0)
                 {
                     $id_pacienteS=$dat_pacientesS[0]['idpaciente'];
                                         
                     $datos_paciente=$objPacienteC->BuscarPaciente("", "", "", $id_pacienteS);
                     if(count($datos_paciente)>0)
                      {
                         $nombre_paciente=$datos_paciente[0]->getNombre();
                      }
                     
                 }
                 $arrS=$objServicioC->BuscarServicio($idservicio, "", "");
                 if(count($arrS)>0){$precio=$arrS[0]->getPrecio();}
                 
                 ##datos de los insumos x insumo_hospitalizacion
                 $datosInsumoHosp = $objInsumoHosp->BuscarInsumoHospitalizacion("", "", $idhosp);
                 
                ####datos
                echo '<table class="table table-responsive table-bordered">';
                echo "<h4>Detalles de Hospitalización</h4>";
                echo '<tr class="text text-info">';
                echo '<th>Paciente</th>';
                echo '<th>Fecha de Ingreso</th>';
                echo '<th>Fecha de Alta</th>';
                echo '<th>Tipo de Habitación</th>';
                echo '</tr>';
                echo '<tr>';
                echo "<td>$nombre_paciente</td>";
                echo "<td>$fechaingreso</td>";
                echo "<td>$fechaalta</td>";
                echo "<td>$tipohab</td>";
                echo '</tr>';
                echo '<tr class="text text-info">';
                echo '<th>Num. Cama</th>';
                echo '<th>Nombre del Familiar</th>';
                echo '<th>Parentesco del Familiar</th>';
                echo '<th>Estado del Paciente</th>';
                echo '</tr>';
                echo '<tr>';
                echo "<td>$nrocama</td>";
                echo "<td>$nombrefamiliar</td>";
                echo "<td>$parentescofam</td>";
                echo "<td>$estadopaciente</td>";
                echo '</tr>';
                echo '<tr class="text text-info">';
                echo '<th>Condición de Atención</th>';
                echo '<th>PA</th>';
                echo '<th>Pulso</th>';
                echo '<th>Temperatura</th>';
                echo '</tr>';
                echo '<tr>';
                echo "<td>$condicatencion</td>";
                echo "<td>$pa</td>";
                echo "<td>$pulso</td>";
                echo "<td>$temp</td>";
                echo '</tr>';
                echo '<tr class="text text-info">';
                echo '<th>Peso</th>';
                echo '<th>Exámen Físico</th>';
                echo '<th>Costo</th>';
                echo '<th></th>';
                echo '</tr>';
                echo '<tr>';
                echo "<td>$peso</td>";
                echo "<td>$examfis</td>";
                echo "<td>$precio</td>";
                echo "<td></td>";
                echo '</tr>';
                echo '</table>';
                
                echo '<table class="table table-responsive table-bordered">';
                echo "<h4>Insumos Utilizados</h4>";
                echo '<tr class="text text-info">';
                echo '<th>Insumo</th>';
                echo '<th>Cantidad</th>';
                echo '<th>Fecha/Hora de Administración</th>';
                echo '</tr>';
                echo '<tr>';
                
                for ($i=0; $i < count($datosInsumoHosp); $i++)
                    {
                    if($datosInsumoHosp[$i]->getIdhospitalizacion()==$idhosp)
                        {
                         $idinsumo= $datosInsumoHosp[$i]->getIdinsumo();
                         $cantidadinsumo= $datosInsumoHosp[$i]->getCantidadinsumo();
                         $fechaHora= $datosInsumoHosp[$i]->getFecha();
                         $nombreinsumo= $objInsumo->BuscarInsumo($idinsumo, "", "")[0]->getNombre();
                         echo "<td>$nombreinsumo</td>";
                         echo "<td>$cantidadinsumo</td>";
                         echo "<td>$fechaHora</td>";
                        }
                    }
                
                echo '</tr>';
                echo '</table>';
                
                echo "<a href='#' class='btn btn-primary'>Imprimir</a> ";
                echo "<a href='editarhospitalizacionrl.php?nik=$idhosp' class='btn btn-success'>Editar</a> ";
                echo "<a href='mostrarpaciente.php?nik=$id_pacienteS' class='btn btn-danger'>Volver</a>";
                echo "<br><br>";
          }
          else 
            {
                  echo "<div class='alert alert-danger'> No hay datos que mostrar</div>";
            }
          ?>
        </div>
    </div>
</section>

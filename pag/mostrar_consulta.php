<?php

include '../funct/con_tacnamh_db.php';
include '../funct/functions.php';
include './header.php';

include '../modelo/consultas_genericas.php';
include '../modelo/ServicioController.php';
include '../modelo/ConsultaController.php';
include '../modelo/MedicoController.php';
include '../modelo/PacienteController.php';
include '../modelo/EspecialidadController.php';

$objConsultaController=new ConsultaController();
$objMedicoC=new MedicoController();
$objPacienteC=new PacienteController();
$objEspecialidad=new EspecialidadController();
$objServicio=new ServicioController();
$datosConsulta=array();

$idconsulta="";
if($_GET)
    {
        if(isset($_GET["nik"]))
        {
            $idconsulta= $_GET["nik"];
            $datosConsulta=$objConsultaController->BuscarConsulta($idconsulta, "", "");
        }
    }
?>
<br><br>
<section class="about-text">
    <div class="container">
      
        <div class="col-md-12">
          <h3 class="text-left"><i class="fa fa-eye text-info"> Datos de la Consulta</i></h3>
          <?php 
          if(count($datosConsulta)>0)
          {
              $i=0;
                 $id_servicio=$datosConsulta[$i]->getIdServicio();
                 $indicaciones=$datosConsulta[$i]->getIndicaciones();
                 $especialidad=$datosConsulta[$i]->getEspecialidad();
                 $resultados=$datosConsulta[$i]->getResultados();
                 
                 
                 ##datos especialidad
                 $dat_especialidad=$objEspecialidad->BuscarEspecialidad($especialidad, "", "");
                 if(count($dat_especialidad)>0)
                {
                     $nombre_especialidad=$dat_especialidad[0]->getNombreespecialidad();
                }
                 ##datos del paciente por paciente servicio
                 $cg=new ConsultasG();
                 $p=array();
                 $p['campo'][0]='idservicio';
                 $p['valor'][0]=$id_servicio;
                 $r=$cg->GenericSelect('paciente_servicio', $p);
                 $dat_pacientesS=$cg->ArregloAsociativoSelect($r, 'paciente_servicio');
                 if(count($dat_pacientesS)>0)
                 {
                     $id_pacienteS=$dat_pacientesS[0]['idpaciente'];
                     $fecha=$dat_pacientesS[0]['fecha'];
                    
                     
                     $datos_paciente=$objPacienteC->BuscarPaciente("", "", "", $id_pacienteS);
                     if(count($datos_paciente)>0)
                      {
                         $nombre_paciente=$datos_paciente[0]->getNombre();
                      }
                      $datos_servicio=$objServicio->BuscarServicio($id_servicio, "", "");
                      if(count($datos_servicio)>0)
                      {
                          $precio=$datos_servicio[0]->getPrecio();
                      }
                     
                 }
                 
                 ##datos del medico por medico consulta
                 $p=array();
                $p['campo'][0]='idconsulta';
                $p['valor'][0]=$idconsulta;
                $r=$cg->GenericSelect('medico_consulta', $p);
                if($r)
                {
                    $dat_med_consulta=$cg->ArregloAsociativoSelect($r, 'medico_consulta');
                    if(count($dat_med_consulta)>0)
                    {
                        $id_medico=$dat_med_consulta[0]['idmedico'];
                        $datos_medico=$objMedicoC->BuscarMedico($id_medico, "", "", "");
                        if(count($datos_medico)>0)
                        {
                            $nombre_medico=$datos_medico[0]->getNombre();
                        }
                    }
                }
                ####datos
                
                echo '<table class="table table-responsive table-bordered">';
                echo "<h4>Consulta de $nombre_especialidad</h4>";
                echo '<tr class="text text-info">';
                echo '<th>Doctor</th>';
                echo '<th>Fecha</th>';
                
                echo '<th>Paciente</th>';
                echo '</tr>';
                echo '<tr>';
                echo "<td>$nombre_medico</td>";
                echo "<td>$fecha</td>";
               
                echo "<td>$nombre_paciente</td>";
                echo '</tr>';
                echo '<tr class="text text-info">';
                echo '<th>Indicaciones</th>';
                echo '<th>Resultado</th>';
                echo '<th>Precio</th>';
                echo '</tr>';
                echo '<tr>';
                echo "<td>$indicaciones</td>";
                echo "<td>$resultados</td>";
                echo "<td>$precio</td>";
                echo '</tr>';
                echo '</table>';
                
                echo "<a href='#' class='btn btn-primary'>Imprimir</a> ";
                echo "<a href='editar_consulta.php?nik=$idconsulta' class='btn btn-success'>Editar</a> ";
                echo "<a href='mostrarpaciente.php?nik=$id_pacienteS' class='btn btn-danger'>Volver</a>";
          }
          else 
            {
                  echo "<div class='alert alert-danger'> No hay datos que mostrar</div>";
            }
          ?>
        </div>
    </div>
</section>



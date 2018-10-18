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
                         $idpaciente=$datos_paciente[0]->getIdPaciente();
                         $edadPaciente=$datos_paciente[0]->GetEdadPaciente();
                         $sexoPaciente=$datos_paciente[0]->getSexo();
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
                $img='../img/paciente_masculino.png';
                if($sexoPaciente=="F"){$img="../img/paciente_femenino.png";}
                echo "<div class='panel panel-default'>";
                        echo "<div class='panel-heading'>";
                            echo "<b>Datos del Servicio Cirugia </b>";
                        echo "</div>";
                        echo "<div class='panel-body'>";
                            echo "<ul class='nav nav-tabs'>";
                                echo "<li class='active'><a href='#home' data-toggle='tab'>Datos generales Paciente</a>";
                                echo "</li>";
                                echo "<li><a href='#profile' data-toggle='tab'>Datos de la Cosulta</a>";
                               echo "</li>";
                            echo "</ul>";
                            
                            echo "<div class='tab-content'>";
                                echo "<div class='tab-pane fade in active' id='home'>";
                                echo "<h4>Datos generales del paciente</h4>";
                                echo"<div class=' text-right'><a href='editarpaciente.php?nik=$idpaciente'><i class=' fa fa-pencil' style='color:#666666;'> Editar</i></a></div>";
                                    echo '<table class="table table-responsive">';
                                    echo '<tr>';
                                    echo "<td rowspan='3' style='width:200px;'><img src='$img' title='Paciete' style='width:150px;'></td>";echo "<td style='heigth:10px !important;'><b>Nombre del Paciente:</b> $nombre_paciente</td>";
                                    echo '</tr>';
                                    echo '<tr>';
                                    echo "<td><b>Edad:</b> $edadPaciente </td>";
                                    echo '</tr>';
                                    echo '<tr>';
                                    echo "<td><b>Sexo:</b> $sexoPaciente </td>";
                                    echo '</tr>';
                                    echo"</table>";
                                echo "</div>";
                                
                                ##datos consulta
                                echo "<div class='tab-pane fade' id='profile'>";
                                    echo "<h4>Datos de la Consulta</h4>";
                                    echo"<div class=' text-right'><a href='editar_consulta.php?nik=$idconsulta'><i class=' fa fa-pencil' style='color:#666666;'> Editar</i></a></div>";
                                        echo '<table class="table table-responsive table-bordered">';
                                        //echo "<h4>Consulta de $nombre_especialidad</h4>";
                                        echo '<tr>';
                                        echo "<th>Especialidad</th><td>$nombre_especialidad</td></tr>";
                                        echo "<tr><th>Doctor</th><td>$nombre_medico</td></tr>";
                                        echo "<tr><th>Fecha</th><td>$fecha</td></tr>";
                                        
                                        echo '<tr>';
                                        echo "<th>Motivo</th><td>$indicaciones</td></tr>";     //El campo al que hace referencia es "indicaciones"
                                        echo "<tr><th>Resultado</th> <td>$resultados</td></tr>";
                                        echo "<tr><th>Precio</th><td>$precio</td></tr>";
                                        
                                        echo '</table>';
                                    
                                    echo "</div>";
                        echo "</div>";
                         echo "<br>";
                
                        echo "<div class='pull-right'>";
                        echo "<a href='#' class='btn btn-primary'>Imprimir</a> ";
                        echo "<a href='editar_consulta.php?nik=$idconsulta' class='btn btn-success'>Editar</a> ";
                        echo "<a href='mostrarpaciente.php?nik=$id_pacienteS' class='btn btn-danger'>Volver</a>";
                        echo "</div>";
                echo "</div>";
               
          }
          else 
            {
                  echo "<div class='alert alert-danger'> No hay datos que mostrar</div>";
            }
          ?>
        </div>
    </div>
</section>
<script>

// Select all tabs
$('.nav-tabs a').click(function(){
    $(this).tab('show');
})

// Select tab by name
$('.nav-tabs a[href="#home"]').tab('show')

// Select first tab
$('.nav-tabs a:first').tab('show')

// Select last tab
$('.nav-tabs a:last').tab('show')

// Select fourth tab (zero-based)
$('.nav-tabs li:eq(3) a').tab('show')
</script>
<?php include './footer.html'; ?>

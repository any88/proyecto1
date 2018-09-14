<?php

include '../funct/con_tacnamh_db.php';
include '../funct/functions.php';
include './header.php';

include '../modelo/consultas_genericas.php';
include '../modelo/PacienteController.php';
include '../modelo/ServicioController.php';
include '../modelo/LaboratorioController.php';
include '../modelo/LaboratorioClinicoController.php';
include '../modelo/PacienteServicioController.php';
include '../modelo/LaboratorioClinico_AnalisisController.php';
include '../modelo/TipoAnalisisLaboratorioController.php';
include '../modelo/NombreAnalisisLaboratorioController.php';

$objPaciente=new PacienteController();
$objServicio= new ServicioController();
$objLaboratorio=new LaboratorioController();
$objLaboratorioClinico= new LaboratorioClinicoController();
$objTipoAnalisisLab= new TipoAnalisisLaboratorioController();
$objNombreAnalisis= new NombreAnalisisLaboratorioController();
$objPacienteServ= new PacienteServicioController();
$objLabClinAnalab= new LaboratorioClinico_AnalisisController();

$datosLaboratorio=array();
$datosServicio=array();
$datosPcteServ=array();
$datosLabClin=array();

$idlaboratorio="";
if($_GET)
    {
        if(isset($_GET["nik"]))
        {
            $idlaboratorio=$_GET["nik"];
            $datosLaboratorio=$objLaboratorio->BuscarLaboratorio($idlaboratorio, "", "");
        }
    }
?>
<br><br>
<section class="about-text">
    <div class="container">
      
        <div class="col-md-12">
          <h3 class="text-left"><i class="fa fa-eye text-info"> Datos del Análisis</i></h3>
          <?php 
          if(count($datosLaboratorio)>0)
          {
                 $idservicio=$datosLaboratorio[0]->getIdServicio();
                 $idtipoanalisis=$datosLaboratorio[0]->getIdTipoAnalisisLaboratorio();
                 $idnombreanalisis=$datosLaboratorio[0]->getNombre();
                 $resultados=$datosLaboratorio[0]->getResultados();
                 
                 $tipoanalisis= $objTipoAnalisisLab->BuscarTipoAnalisisLaboratorio($idtipoanalisis, "")[0]->getTipoAnalisis();
                 $nombreanalisis= $objNombreAnalisis->BuscarNombreAnalisis($idnombreanalisis,"", "")[0]->getNombreanalisis();
                                  
                 ##datos servicio
                 $datosServicio=$objServicio->BuscarServicio($idservicio, "", "");
                 if(count($datosServicio)>0)
                {
                     $precio=$datosServicio[0]->getPrecio();
                }
                
                 ##datos del paciente por paciente servicio
                $datosPcteServ=$objPacienteServ->BuscarPacienteServicio("", "", $idservicio);
                if(count($datosPcteServ)>0)
                {
                     $fecha=$datosPcteServ[0]->getFecha();
                     $idpaciente=$datosPcteServ[0]->getIdpaciente();
                     $datos_paciente=$objPaciente->BuscarPaciente("", "", "", $idpaciente);
                     if(count($datos_paciente)>0)
                      {
                         $nombrepaciente=$datos_paciente[0]->getNombre();
                         
                         $edadPaciente=$datos_paciente[0]->GetEdadPaciente();
                         $sexoPaciente=$datos_paciente[0]->getSexo();
                      }
                     
                }
                 
                 ##datos del laboratorio clinico por labclin_analab
                $datosLabClin=$objLabClinAnalab->BuscarLaboratorioClinico_Analisis("", "", $idlaboratorio);
                if(count($datosLabClin)>0)
                {
                     $idlabclin=$datosLabClin[0]->getIdlabclinico();
                     $nombrelabclin=$objLaboratorioClinico->BuscarLaboratorioClinico($idlabclin, "", "")[0]->getNombrelabclin();
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
                                echo "<li><a href='#profile' data-toggle='tab'>Datos del Laboratorio</a>";
                               echo "</li>";
                            echo "</ul>";
                            
                            echo "<div class='tab-content'>";
                                echo "<div class='tab-pane fade in active' id='home'>";
                                echo "<h4>Datos generales del paciente</h4>";
                                echo"<div class=' text-right'><a href='editarpaciente.php?nik=$idpaciente'><i class=' fa fa-pencil' style='color:#666666;'> Editar</i></a></div>";
                                    echo '<table class="table table-responsive">';
                                    echo '<tr>';
                                    echo "<td rowspan='3' style='width:200px;'><img src='$img' title='Paciete' style='width:150px;'></td>";echo "<td style='heigth:10px !important;'><b>Nombre del Paciente:</b> $nombrepaciente</td>";
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
                                  
                                    echo"<div class=' text-right'><a href='editar_laboratorio.php?nik=$idlaboratorio'><i class=' fa fa-pencil' style='color:#666666;'> Editar</i></a></div>";
                                       
                                    echo '<table class="table table-responsive table-bordered">';
                                    echo "<h4>Análisis de Laboratorio</h4>";
                                    
                                    echo "<tr><th>Paciente</th><td>$nombrepaciente</td></tr>";
                                    echo "<tr><th>Tipo de Análisis</th><td>$tipoanalisis</td></tr>";
                                    echo "<tr><th>Nombre de Análisis</th><td>$nombreanalisis</td></tr>";
                                    echo "<tr><th>Fecha</th><td>$fecha</td></tr>";
                                    echo "<tr><th>Laboratorio Clínico</th><td>$nombrelabclin</td></tr>";
                                    echo "<tr><th>Resultados</th><td>$resultados</td></tr>";
                                    echo "<tr><th>Precio</th><td> s/. $precio</td></tr>";
                                    
                                    echo '</table>';
                               echo "</div>";
                               echo "<br>";
                               echo "<div class='pull-right'>";
                                echo "<a href='#' class='btn btn-primary'>Imprimir</a> ";
                                echo "<a href='mostrarpaciente.php?nik=$idpaciente' class='btn btn-danger'>Volver</a>";
                               echo "</div>";
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
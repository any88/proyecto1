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
                     $nombrepaciente=$objPaciente->BuscarPaciente("", "", "", $idpaciente)[0]->getNombre();
                }
                 
                 ##datos del laboratorio clinico por labclin_analab
                $datosLabClin=$objLabClinAnalab->BuscarLaboratorioClinico_Analisis("", "", $idlaboratorio);
                if(count($datosLabClin)>0)
                {
                     $idlabclin=$datosLabClin[0]->getIdlabclinico();
                     $nombrelabclin=$objLaboratorioClinico->BuscarLaboratorioClinico($idlabclin, "", "")[0]->getNombrelabclin();
                }
                
                ####datos
                
                echo '<table class="table table-responsive table-bordered">';
                echo "<h4>Análisis de Laboratorio</h4>";
                echo '<tr class="text text-info">';
                echo '<th>Paciente</th>';
                echo '<th>Tipo de Análisis</th>';
                echo '<th>Nombre de Análisis</th>';
                echo '<th>Fecha</th>';
                echo '</tr>';
                echo '<tr>';
                echo "<td>$nombrepaciente</td>";
                echo "<td>$tipoanalisis</td>";
                echo "<td>$nombreanalisis</td>";
                echo "<td>$fecha</td>";
                echo '</tr>';
                echo '<tr class="text text-info">';
                echo '<th>Laboratorio Clínico</th>';
                echo '<th>Resultados</th>';
                echo '<th>Precio</th>';
                echo "<td></td>";
                echo '</tr>';
                echo '<tr>';
                echo "<td>$nombrelabclin</td>";
                echo "<td>$resultados</td>";
                echo "<td>$precio</td>";
                echo "<td></td>";
                echo '</tr>';
                echo '</table>';
                
                echo "<a href='#' class='btn btn-primary'>Imprimir</a> ";
                echo "<a href='#' class='btn btn-success'>Editar</a> ";
                echo "<a href='mostrarpaciente.php?nik=$idpaciente' class='btn btn-danger'>Volver</a>";
          }
          else 
            {
                  echo "<div class='alert alert-danger'> No hay datos que mostrar</div>";
            }
          ?>
        </div>
    </div>
</section>

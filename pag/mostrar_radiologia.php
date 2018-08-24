<?php

include '../funct/con_tacnamh_db.php';
include '../funct/functions.php';
include './header.php';

include '../modelo/consultas_genericas.php';
include '../modelo/PacienteController.php';
include '../modelo/ServicioController.php';
include '../modelo/RadiologiaController.php';
include '../modelo/LaboratorioRadiologiaController.php';
include '../modelo/PacienteServicioController.php';
include '../modelo/LaboratorioRadiologia_PruebaRadController.php';
include '../modelo/TipoRadiologiaController.php';
include '../modelo/NombreRadiologiaController.php';

$objPaciente=new PacienteController();
$objServicio= new ServicioController();
$objRadiologia=new RadiologiaController();
$objLaboratorioRadiologia= new LaboratorioRadiologiaController();
$objTipoRadiologia= new TipoRadiologiaController();
$objNombreRadiologia= new NombreRadiologiaController();
$objPacienteServ= new PacienteServicioController();
$objLabRadPruebaRad= new LaboratorioRadiologia_PruebaRadController();

$datosRadiologia=array();
$datosServicio=array();
$datosPcteServ=array();
$datosLabRad=array();

$idradiologia="";
if($_GET)
    {
        if(isset($_GET["nik"]))
        {
            $idradiologia=$_GET["nik"];
            $datosRadiologia=$objRadiologia->BuscarRadiologia($idradiologia, "", "");
        }
    }
?>
<br><br>
<section class="about-text">
    <div class="container">
      
        <div class="col-md-12">
          <h3 class="text-left"><i class="fa fa-eye text-info"> Datos del Examen</i></h3>
          <?php 
          if(count($datosRadiologia)>0)
          {
                 $idservicio=$datosRadiologia[0]->getIdServicio();
                 $idtiporadiologia=$datosRadiologia[0]->getIdTipoRadiologia();
                 $idnombreradiologia=$datosRadiologia[0]->getNombre();
                 $resultados=$datosRadiologia[0]->getResultados();
                 
                 $dat_tiporad=$objTipoRadiologia->BuscarTipoRadiologia($idtiporadiologia, "");
                 
                 if(count($dat_tiporad)>0)
                     {
                        $tiporadiologia=$dat_tiporad[0]->getTipoRadiologia();
                     }
                 
                 $dat_nombrerad= $objNombreRadiologia->BuscarNombreRadiologia($idnombreradiologia,"", "");
                 if(count($dat_nombrerad)>0)
                     {
                        $nombreradiologia=$dat_nombrerad[0]->getNombreradiologia();
                     }
                                                   
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
                 
                 ##datos del laboratorio rad por labrad_prbrad
                $datosLabRad=$objLabRadPruebaRad->BuscarLaboratorioRadiologia_PruebaRad("", "", $idradiologia);
                if(count($datosLabRad)>0)
                {
                     $idlabrad=$datosLabRad[0]->getIdlabradiologia();
                     $nombrelabrad=$objLaboratorioRadiologia->BuscarLaboratorioRadiologia($idlabrad, "", "")[0]->getNombrelabrad();
                }
                
                ####datos
                
                echo '<table class="table table-responsive table-bordered">';
                echo "<h4>Prueba Radiológica</h4>";
                echo '<tr class="text text-info">';
                echo '<th>Paciente</th>';
                echo '<th>Tipo de Prueba Radiológica</th>';
                echo '<th>Nombre de la Prueba</th>';
                echo '<th>Fecha</th>';
                echo '</tr>';
                echo '<tr>';
                echo "<td>$nombrepaciente</td>";
                echo "<td>$tiporadiologia</td>";
                echo "<td>$nombreradiologia</td>";
                echo "<td>$fecha</td>";
                echo '</tr>';
                echo '<tr class="text text-info">';
                echo '<th>Laboratorio Radiológico</th>';
                echo '<th>Resultados</th>';
                echo '<th>Precio</th>';
                echo "<td></td>";
                echo '</tr>';
                echo '<tr>';
                echo "<td>$nombrelabrad</td>";
                echo "<td>$resultados</td>";
                echo "<td>$precio</td>";
                echo "<td></td>";
                echo '</tr>';
                echo '</table>';
                
                echo "<a href='#' class='btn btn-primary'>Imprimir</a> ";
                echo "<a href='editar_radiologia.php?nik=$idradiologia' class='btn btn-success'>Editar</a> ";
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


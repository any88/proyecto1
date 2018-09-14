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
                     
                     $arrPaciente=$objPaciente->BuscarPaciente("", "", "", $idpaciente);
                     if(count($arrPaciente)>0)
                     {
                         $nombrepaciente=$arrPaciente[0]->getNombre();
                         $edadPaciente=$arrPaciente[0]->GetEdadPaciente();
                         $sexoPaciente=$arrPaciente[0]->getSexo();
                     }
                     
                }
                 
                 ##datos del laboratorio rad por labrad_prbrad
                $datosLabRad=$objLabRadPruebaRad->BuscarLaboratorioRadiologia_PruebaRad("", "", $idradiologia);
                if(count($datosLabRad)>0)
                {
                     $idlabrad=$datosLabRad[0]->getIdlabradiologia();
                     $nombrelabrad=$objLaboratorioRadiologia->BuscarLaboratorioRadiologia($idlabrad, "", "")[0]->getNombrelabrad();
                }
                
                ####datos
                 $img='../img/paciente_masculino.png';
                if($sexoPaciente=="F"){$img="../img/paciente_femenino.png";}
                echo "<div class='panel panel-default'>";
                        echo "<div class='panel-heading'>";
                            echo "<b>Datos del Servicio Radiolog&iacute;A </b>";
                        echo "</div>";
                        echo "<div class='panel-body'>";
                            echo "<ul class='nav nav-tabs'>";
                                echo "<li class='active'><a href='#home' data-toggle='tab'>Datos generales Paciente</a>";
                                echo "</li>";
                                echo "<li><a href='#profile' data-toggle='tab'>Datos de la radiolog&iacute;a</a>";
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
                                echo "<div class='tab-pane fade' id='profile'>";
                                    
                                    echo"<div class=' text-right'><a href='editar_radiologia.php?nik=$idradiologia'><i class=' fa fa-pencil' style='color:#666666;'> Editar</i></a></div>";
                                    
                                    echo '<table class="table table-responsive table-bordered">';
                                    echo "<h4>Prueba Radiológica</h4>";
                                    echo "<tr><th>Tipo de Prueba Radiológica</th><td>$tiporadiologia</td></tr>";
                                    echo "<tr><th>Nombre de la Prueba</th><td>$nombreradiologia</td></tr>";
                                    echo "<tr><th>Fecha</th><td>$fecha</td></tr>";
                                    echo "<tr><th>Laboratorio Radiológico</th><td>$nombrelabrad</td></tr>";
                                    echo "<tr><th>Resultados</th><td>$resultados</td></tr>";
                                    echo "<tr><th>Precio</th><td>s/. $precio</td></tr>";
                                    
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
<?php

include '../funct/con_tacnamh_db.php';
include '../funct/functions.php';
include './header.php';

include '../modelo/consultas_genericas.php';
include '../modelo/PacienteController.php';
include '../modelo/MedicoController.php';
include '../modelo/TrabajadorController.php';
include '../modelo/ServicioController.php';
include '../modelo/CirugiaController.php';
include '../modelo/InsumoController.php';
include '../modelo/PacienteServicioController.php';
include '../modelo/EspecialidadController.php';
include '../modelo/NombreCirugiaController.php';
include '../modelo/MedicoCirugiaController.php';
include '../modelo/InsumoCirugiaController.php';

$objPaciente=new PacienteController();
$objMedico= new MedicoController();
$objTrabajador= new TrabajadorController();
$objServicio= new ServicioController();
$objCirugia=new CirugiaController();
$objInsumo=new InsumoController();
$objPacienteServ= new PacienteServicioController();
$objEspecialidad= new EspecialidadController();
$objNombreCirugia= new NombreCirugiaController();
$objMedicoCirugia= new MedicoCirugiaController();
$objInsumoCirugia= new InsumoCirugiaController();

$datosCirugia=array();
$datosServicio=array();
$datosPcteServ=array();
$datosMedicoCirugia=array();
$datosInsumoCirugia=array();

$lista_especialidades = $objEspecialidad->MostrarEspecialidad();

$idcirugia="";
if($_GET)
    {
        if(isset($_GET["nik"]))
        {
            $idcirugia=$_GET["nik"];
            $datosCirugia=$objCirugia->BuscarCirugia($idcirugia, "", "");
            
        }
    }
?>
<br><br>
<section class="about-text">
    <div class="container">
      
        <div class="col-md-12">
          <h3 class="text-left"><i class="fa fa-eye text-info"> Datos de la Cirugía</i></h3>
          <?php 
          if(count($datosCirugia)>0)
          {
                 $idservicio=$datosCirugia[0]->getIdServicio();
                 $idespecialidad=$datosCirugia[0]->getIdEspecialidad();
                 $idnombrecirugia=$datosCirugia[0]->getIdNombreC();
                 $duracion=$datosCirugia[0]->getDuracion();
                 
                 $especialidad= $objEspecialidad->BuscarEspecialidad($idespecialidad, "", "")[0]->getNombreespecialidad();
                 $nombrecirugia= $objNombreCirugia->BuscarNombreCirugia($idnombrecirugia,"", "")[0]->getNombreCirugia();
                                  
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
                     ##datos del paciente
                    $datosPaciente=array();
                    $datosPaciente=$objPaciente->BuscarPaciente("", "", "", $idpaciente);
                    if(count($datosPaciente)>0)
                    {
                         $nombrepaciente=$datosPaciente[0]->getNombre();
                         $sexoPaciente=$datosPaciente[0]->getSexo();
                         $edadPaciente=$datosPaciente[0]->GetEdadPaciente();
                    }
                     
                   
                     
                }
                
                 
                 ##datos del equipo medico x medico_cirugia
                $datosMedicoCirugia=$objMedicoCirugia->BuscarMedicoCirugia("", "", $idcirugia);
                                
                ##datos de los insumos utilizados x insumo_cirugia
                $datosInsumoCirugia=$objInsumoCirugia->BuscarInsumoCirugia("", "", $idcirugia);
                                
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
                                echo "<li><a href='#profile' data-toggle='tab'>Datos de la Cirugia</a>";
                                echo "<li><a href='#equipo' data-toggle='tab'>Equipo</a>";
                                echo "<li><a href='#insumos' data-toggle='tab'>Insumos</a>";
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
                                
                                ##datos cirugia
                                echo "<div class='tab-pane fade' id='profile'>";
                                    echo "<h4>Datos de la Cirugía</h4>";
                                    echo"<div class=' text-right'><a href='editar_datoscirugia.php?nik=$idcirugia&serv=$idservicio'><i class=' fa fa-pencil' style='color:#666666;'> Editar</i></a></div>";
                                    echo '<table class="table table-responsive table-bordered">';
                                    echo '<tr >';
                                    echo "<th style='width:200px;' class='text text-info'>Especialidad Quirúrgica</th>"; echo "<td>$especialidad</td>";
                                    echo '</tr>';
                                    echo '<tr>';
                                    echo '<th class="text text-info">Cirugía Practicada</th>'; echo "<td>$nombrecirugia</td>";               
                                    echo '</tr>';
                                    echo '<tr >';
                                    echo '<th class="text text-info">Fecha</th>';echo "<td>$fecha</td>";
                                    echo '</tr>';
                                    echo '<tr >';
                                    echo '<th class="text text-info">Duración</th>';echo "<td>$duracion</td>";
                                    echo '</tr>';
                                    echo '</tr>';
                                    echo '<th class="text text-info">Precio</th>';echo "<td> s/. $precio</td>";
                                    echo '</tr>';
                                    echo '</table>';
                                echo "</div>";
                                
                                ##equipo
                                echo "<div class='tab-pane fade' id='equipo'>";
                                    echo "<h4>Equipo Médico</h4>";
                                    echo"<div class=' text-right'><a href='edita_equipo_cirugia.php?nik=$idcirugia'><i class=' fa fa-pencil' style='color:#666666;'> Editar</i></a></div>";
                                    echo '<table class="table table-responsive table-bordered">';

                                    echo '<tr class="text text-info">';
                                    echo '<th>Nombre</th>';
                                    
                                    echo '<th>Rol Desempeñado</th>';
                                    echo '</tr>';

                                    for ($i=0; $i < count($datosMedicoCirugia); $i++)
                                        {

                                             $idmedico= $datosMedicoCirugia[$i]->getIdmedico();
                                             $id_rol_cirugia=$datosMedicoCirugia[$i]->getRol();

                                             $nombremedico= $objMedico->BuscarMedico($idmedico, "", "", "")[0]->getNombre();
                                             
                                             //ver de donde capturar los datos para el rol de cada gente
                                             $p=array();
                                             $cg=new ConsultasG();
                                             $rol=""; 
                                             $p["campo"][0]="id_rol";
                                             $p["valor"][0]=$id_rol_cirugia;
                                             $r=$cg->GenericSelect('roles_cirugia', $p);
                                             if($r)
                                            {
                                                 $arr_rol=$cg->ArregloAsociativoSelect($r, 'roles_cirugia'); 
                                                 if(count($arr_rol)>0){$rol=$arr_rol[0]['nombre'];}
                                            }

                                            echo '<tr>';
                                            echo "<td>$nombremedico</td>";
                                            
                                            echo "<td>$rol</td>";
                                            echo '</tr>';
                                        }


                                    echo '</table>';
                                echo "</div>";
                                ##insumos
                                echo "<div class='tab-pane fade' id='insumos'>";
                                    echo "<h4>Insumos Utilizados</h4>";
                                    echo"<div class=' text-right'><a href='editar_cirugia.php'><i class=' fa fa-pencil' style='color:#666666;'> Editar</i></a></div>";
                                    echo '<table class="table table-responsive table-bordered">';

                                    echo '<tr class="text text-info">';
                                    echo '<th>Insumo</th>';
                                    echo '<th>Cantidad</th>';
                                    echo '</tr>';


                                    for ($i=0; $i < count($datosInsumoCirugia); $i++)
                                        {
                                        if($datosInsumoCirugia[$i]->getIdcirugia()==$idcirugia)
                                            {
                                             $idinsumo= $datosInsumoCirugia[$i]->getIdinsumo();
                                             $cantidadinsumo= $datosInsumoCirugia[$i]->getCantidadinsumo();
                                             $nombreinsumo= $objInsumo->BuscarInsumo($idinsumo, "", "")[0]->getNombre();
                                              echo '<tr>';
                                                echo "<td>$nombreinsumo</td>";
                                                echo "<td>$cantidadinsumo</td>";
                                              echo '</tr>';
                                            }
                                        }


                                    echo '</table>';
                                echo "</div>";
                            echo "</div>";
                        echo "</div>";
                        
                echo "</div>";
               
                
               
                
                echo "<div class='col-md-12'>";
                
                echo "</div>";
                
                echo"<div class='col-md-12 text-right'>";
                #echo "<a href='#' class='btn btn-primary'>Imprimir</a> ";
                #echo "<a href='#' class='btn btn-success'>Editar</a> ";
                echo "<a href='mostrarpaciente.php?nik=$idpaciente' class='btn btn-danger'>Volver</a>";
                echo "</div>";
                
                echo "<br>";echo "<br>";
                
                
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
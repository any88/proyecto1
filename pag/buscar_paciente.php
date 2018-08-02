<?php

include '../funct/con_tacnamh_db.php';
include '../funct/functions.php';
include './header.php';

include '../modelo/PacienteController.php';
include '../modelo/ServicioController.php';
include '../modelo/consultas_genericas.php';
include '../modelo/PacienteServicioController.php';
$objPaciente=new PacienteController();
$objPSC=new PacienteServicioController();

$datos_paciente=array();
$nombre_paciente="";
$nhc="";
$docId="";
$link_edit="editarpaciente.php";
$link_listar="listar_pacientes.php";
$link_mostrar="mostrarpaciente.php";
$link_servicio="addservicios.php";
if($_POST)
{
    if(isset($_POST['nombre_paciente'])){$nombre_paciente=$_POST['nombre_paciente'];}
    if(isset($_POST['nhc'])){$nhc=$_POST['nhc'];}
    if(isset($_POST['docid'])){$docId=$_POST['docid'];}
    
    if(eliminarblancos($nombre_paciente)!="" || eliminarblancos($nhc)!="" || eliminarblancos($docId)!="")
    {
        $datos_paciente=$objPaciente->BuscarPaciente($nhc, $nombre_paciente, $docId, "");
    }
}
 else 
{
  echo "<script>";
     echo "window.location = 'index.php';";
  echo "</script>";  
}

?>
<br><br>
<section class="about-text">
    <div class="container ">
      
        <div class="col-md-12">
          <h3 class="text-left"><i class="fa fa-search-plus text-info"> </i> Datos del Paciente</h3>
          <a href="crearpaciente.php" class="btn btn-success"><i class="fa fa-plus"></i> Nuevo Paciente</a>
          <?php 
          if(count($datos_paciente)>0)
          {
              
              echo "<div class='panel panel-default'>";
              echo "<div class='panel-heading'>";
                    echo "Se han encontrado ".count($datos_paciente). "resultados para su busqueda";
              echo "</div>";
              echo "<div class='panel panel-body'>";
              echo "<table class='table table-responsive' id='dataTables-example'>";
                echo "<thead>";
                echo "<tr>";
                    echo "<th>Nro.</th>";
                    echo "<th>Nombre</th>";
                    echo "<th>Doc ID</th>";
                    echo "<th>Historia Clinica</th>";
                    echo "<th>Acciones</th>";
                echo "</tr>";
                echo "</thead>";
                echo "<tbody>";
                
                for ($i = 0; $i < count($datos_paciente); $i++) 
                {
                    $nro=$i+1;
                    $id_pacientebd=$datos_paciente[$i]->getIdPaciente();
                    $nombre_pac_bd=$datos_paciente[$i]->getNombre();
                    $numeroHCbd=$datos_paciente[$i]->getNumeroHC();
                    $numeroDocIDbd=$datos_paciente[$i]->getDocID();
                    echo "<tr>";
                    echo "<td>$nro</td>";
                    echo "<td>$nombre_pac_bd</td>";
                    echo "<td>$numeroDocIDbd</td>";
                    echo "<td>$numeroHCbd</td>";
                    echo '
                    <td>
                             <a href="'.$link_edit.'?nik='.$id_pacientebd.'" title="Editar datos" class="btn btn-primary btn-sm"><span class="glyphicon glyphicon-edit" aria-hidden="true"></span></a>

                             <a href="'.$link_listar.'?action=delete&nik='.$id_pacientebd.'&v='.$nombre_pac_bd .'" title="Eliminar" onclick="return confirm(\'Está seguro de borrar los datos  de el paciente '.$nombre_pac_bd.' ?\')" class="btn btn-danger btn-sm"><span class="glyphicon glyphicon-trash" aria-hidden="true"></span></a>
                                 
                             <a href="'.$link_mostrar.'?nik='.$id_pacientebd.'" title="Mostrar datos" class="btn btn-success btn-sm"><span class="glyphicon glyphicon-eye-open" aria-hidden="true"></span></a>

                             <a href="'.$link_servicio.'?nik='.$id_pacientebd.'" title="Nuevo Servicio" class="btn btn-warning btn-sm"><span class="glyphicon glyphicon-plus" aria-hidden="true"></span></a>                     '
                    . '</td>';
                    echo "</tr>";
                }
                echo "</tbody>";
                
              echo "</table>";
              echo "</div>";
              echo "</div>";
          }
          else
          {
              echo "<div class='alert alert-warning alert-dismissable'>"
            . "<button type='button' class='close' data-dismiss='alert' aria-hidden='true'>&times;</button>"
            . "Lo sentimos no se han encontrado resultados de paciente para su busqueda</div>";
              
             
          }
          
          ?>
          
        </div>
    </div>
</section>

<?php
include '../funct/con_tacnamh_db.php';
include '../funct/functions.php';
include './header.php';

include '../modelo/AseguradoraController.php';
include '../modelo/PacienteController.php';

$objPaciente=new PacienteController();
$list_pacientes=$objPaciente->MostrarPaciente();
$msg="";

if(isset($_SESSION['msg'])){$msg=$_SESSION['msg'];unset($_SESSION['msg']);}
if($_GET)
{
    
    if(isset($_GET["nik"]))
    {
        $id_eliminar=$_GET["nik"];
        
        $arr_existe=array();
        $arr_existe=$objPaciente->BuscarPaciente("", "", "", $id_eliminar);
        if(count($arr_existe)>0)
        {
            $affected=$objPaciente->EliminarPaciente($id_eliminar);
            if($affected==0){$msg="No se encontro el paciente";}
            else {$msg="Se eliminaron los datos correctamente";}
        }
        else 
        {
            $msg="EL paciente que desea eliminar no existe";
        }
        echo "<script>window.location = 'listar_pacientes.php';</script>";
    }
}

?>
<br><br>
<section class="about-text">
    <div class="container ">
      
        <div class="col-md-12">
          <h3 class="text-left"><i class="fa fa-user text-info"> Listado de Pacientes</i></h3>
          <div class="text-left">
              <a href='crearpaciente.php' class="btn btn-success" type="submit">Nuevo Paciente</a>
         </div>
          <?php  echo $msg;?>
          <br>
          <table id="dataTables-example" class="table table-striped table-bordered table-hover table-responsive" style="right: 10px;">
              <thead>
                  <tr>
                      <th>Nro</th>
                      <th>Nombre</th>
                      <th>Doc. Id</th>
                      <th>Num. HC</th>
                      <th>Acci&oacute;n</th>
                  </tr>
              </thead>
              <tbody>
                 <?php 
                 $link_edit="editarpaciente.php";
                 $link_listar="";
                 $link_servicio="addservicios.php";
                 $link_mostrar="mostrarpaciente.php";
                 for ($i = 0; $i < count($list_pacientes); $i++) 
                 {
                     $nro=$i+1;
                    echo "<tr>";
                    echo "<td>".$nro."</td>";
                    echo "<td>".$list_pacientes[$i]->getNombre()."</td>";
                    echo "<td>".$list_pacientes[$i]->getDocID()."</td>";
                    echo "<td>".$list_pacientes[$i]->getNumeroHC()."</td>";
                    echo '
                    <td>
                             <a href="'.$link_edit.'?nik='.$list_pacientes[$i]->getIdPaciente().'" title="Editar datos" class="btn btn-primary btn-sm"><span class="glyphicon glyphicon-edit" aria-hidden="true"></span></a>

                             <a href="'.$link_listar.'?action=delete&nik='.$list_pacientes[$i]->getIdPaciente().'&v='.$list_pacientes[$i]->getNombre() .'" title="Eliminar" onclick="return confirm(\'Está seguro de borrar los datos  de el paciente '.$list_pacientes[$i]->getNombre().' ?\')" class="btn btn-danger btn-sm"><span class="glyphicon glyphicon-trash" aria-hidden="true"></span></a>
                                 
                             <a href="'.$link_mostrar.'?nik='.$list_pacientes[$i]->getIdPaciente().'" title="Mostrar datos" class="btn btn-success btn-sm"><span class="glyphicon glyphicon-eye-open" aria-hidden="true"></span></a>

                             <a href="'.$link_servicio.'?nik='.$list_pacientes[$i]->getIdPaciente().'" title="Nuevo Servicio" class="btn btn-warning btn-sm"><span class="glyphicon glyphicon-plus" aria-hidden="true"></span></a>                     '
                 . '</td>';
                   echo "</tr>";
                 }
                 ?>
              </tbody>
          </table>
          
        </div>
    </div>
</section>
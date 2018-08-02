<?php
include '../funct/con_tacnamh_db.php';
include '../funct/functions.php';
include './header.php';

include '../modelo/EspecialidadController.php';

$objEspecialidad=new EspecialidadController;
$list_especialidades=$objEspecialidad->MostrarEspecialidad();
$msg="";

if($_GET)
{
    
    if(isset($_GET["nik"]))
    {
        $id_eliminar=$_GET["nik"];
        
        $arr_existe=array();
        $arr_existe=$objEspecialidad->BuscarEspecialidad($id_eliminar,"", "");
        if(count($arr_existe)>0)
        {
            $affected=$objEspecialidad->EliminarEspecialidad($id_eliminar);
            if($affected==0){$msg="No se encontro la especialidad";}
            else {$msg="Se eliminaron los datos correctamente";}
        }
        else 
        {
            $msg="La especialidad que desea eliminar no existe";
        }
        echo "<script>window.location = 'listar_especialidades.php';</script>";
    }
}

?>
<br><br>
<section class="about-text">
    <div class="container ">
      
        <div class="col-md-12">
          <h3 class="text-left"><i class="fa fa-star text-info"> Listado de Especialidades</i></h3>
          <div class="text-left">
              <a href='crearespecialidad.php' class="btn btn-success" type="submit">Nueva Especialidad</a>
         </div>
          <br>
          <table id="dataTables-example" class="table table-striped table-hover display table-responsive " style="right: 10px;">
              <thead>
                  <tr>
                      <th>Nro</th>
                      <th>Nombre</th>
                      <th>Procedimientos Quirúrgicos</th>
                                                                  
                      <th>Acci&oacute;n</th>
                  </tr>
              </thead>
              <tbody>
                 <?php 
                 $link_edit="editarespecialidad.php";
                 $link_listar="";
                 for ($i = 0; $i < count($list_especialidades); $i++) 
                 {
                    $nro=$i+1;
                    echo "<tr>";
                    echo "<td>".$nro."</td>";
                    echo "<td>".$list_especialidades[$i]->getNombreespecialidad()."</td>";
                    if($list_especialidades[$i]->getEsquirurgica()=="s")
                        {
                            echo "<td>Sí</td>";
                        }
                    else{
                        if($list_especialidades[$i]->getEsquirurgica()=="n")
                            {
                            echo "<td>No</td>";
                            }
                        }
                    echo '<td>
                             <a href="'.$link_edit.'?nik='.$list_especialidades[$i]->getIdEspecialidad().'" title="Editar datos" class="btn btn-primary btn-sm"><span class="glyphicon glyphicon-edit" aria-hidden="true"></span></a>

                             <a href="'.$link_listar.'?action=delete&nik='.$list_especialidades[$i]->getIdEspecialidad().'&v='.$list_especialidades[$i]->getNombreespecialidad().'" title="Eliminar" onclick="return confirm(\'Está seguro de borrar los datos '.$list_especialidades[$i]->getNombreespecialidad().' ?\')" class="btn btn-danger btn-sm"><span class="glyphicon glyphicon-trash" aria-hidden="true"></span></a>
                     </td>';
                    echo "</tr>";
                 }
                 ?>
              </tbody>
          </table>
        </div>
    </div>
</section


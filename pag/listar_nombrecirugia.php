<?php
include '../funct/con_tacnamh_db.php';
include '../funct/functions.php';
include './header.php';

include '../modelo/NombreCirugiaController.php';
include '../modelo/EspecialidadController.php';

$objNombreCirugia=new NombreCirugiaController();
$list_nombrecirugia=$objNombreCirugia->MostrarNombreCirugia();
$objEspecialidad= new EspecialidadController();
$list_especialidades= $objEspecialidad->MostrarEspecialidad();
$msg="";

if($_GET)
{
    if(isset($_GET["nik"]))
    {
        $id_eliminar=$_GET["nik"];      
        $arr_existe=array();
        $arr_existe=$objNombreCirugia->BuscarNombreCirugia($id_eliminar,"", "");
        if(count($arr_existe)>0)
        {
            $affected=$objNombreCirugia->EliminarNombreCirugia($id_eliminar);
            if($affected==0){$msg="No se encontro la cirugía";}
            else {$msg="Se eliminaron los datos correctamente";}
        }
        else 
        {
            $msg="La cirugía que desea eliminar no existe";
        }
        echo "<script>window.location = 'listar_nombrecirugia.php';</script>";
    }
}

?>
<br><br>
<section class="about-text">
    <div class="container ">
      
        <div class="col-md-12">
          <h3 class="text-left"><i class="fa fa-hand-scissors-o"> Listado de Cirugías</i></h3>
          <div class="text-left">
              <a href='crearnombrecirugia.php' class="btn btn-success" type="submit">Nueva Cirugía</a>
         </div>
          <br>
          <table id="example" class="table table-striped table-hover display table-responsive " style="right: 10px;">
              <thead>
                  <tr>
                      <th>Nro</th>
                      <th>Nombre</th>
                      <th>Especialidad Quirúrgica</th>
                                            
                      <th>Acci&oacute;n</th>
                  </tr>
              </thead>
              <tbody>
                 <?php 
                 $link_edit="editarnombrecirugia.php";
                 $link_listar="";
                 for ($i = 0; $i < count($list_nombrecirugia); $i++) 
                 {
                     $nro=$i+1;
                    echo "<tr>";
                    echo "<td>".$nro."</td>";
                    echo "<td>".$list_nombrecirugia[$i]->getNombreCirugia()."</td>";
                    for ($j=0; $j < count ($list_especialidades); $j++)
                    {
                        if($list_nombrecirugia[$i]->getIdEspecialidad()==$list_especialidades[$j]->getIdEspecialidad())
                        {
                        echo "<td>".$list_especialidades[$j]->getNombreespecialidad()."</td>";
                        }
                    }
                    
                    echo '<td>
                             <a href="'.$link_edit.'?nik='.$list_nombrecirugia[$i]->getIdNombreCirugia().'" title="Editar datos" class="btn btn-primary btn-sm"><span class="glyphicon glyphicon-edit" aria-hidden="true"></span></a>

                             <a href="'.$link_listar.'?action=delete&nik='.$list_nombrecirugia[$i]->getIdNombreCirugia().'&v='.$list_nombrecirugia[$i]->getNombreCirugia().'" title="Eliminar" onclick="return confirm(\'Está seguro de borrar los datos '.$list_nombrecirugia[$i]->getNombreCirugia().' ?\')" class="btn btn-danger btn-sm"><span class="glyphicon glyphicon-trash" aria-hidden="true"></span></a>
                     </td>';
                    echo "</tr>";
                 }
                 ?>
              </tbody>
          </table>
        </div>
    </div>
</section>


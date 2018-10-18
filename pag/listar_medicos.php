<?php
include '../funct/con_tacnamh_db.php';
include '../funct/functions.php';
include './header.php';

include '../modelo/EspecialidadController.php';
include '../modelo/MedicoController.php';

$objMedico=new MedicoController();
$list_medicos=$objMedico->MostrarMedico();
$objEspecialidad=new EspecialidadController();

if($_GET)
{
    
    if(isset($_GET["nik"]))
    {
        $id_eliminar=$_GET["nik"];
        
        $arr_existe=array();
        $arr_existe=$objMedico->BuscarMedico($id_eliminar, "", "");
        if(count($arr_existe)>0)
        {
            $affected=$objMedico->EliminarMedico($id_eliminar);
            if($affected==0){$msg="No se encontro el medico";}
            else {$msg="Se eliminaron los datos correctamente";}
        }
        else 
        {
            $msg="EL medico que desea eliminar no existe";
        }
        echo "<script>window.location = 'listar_medicos.php';</script>";
    }   
}

?>
<br><br>
<section class="about-text">
    <div class="container ">
      
        <div class="col-md-12">
        
          
          <div class="panel panel-default">
              <div class="panel-heading">
                  <b class="text-left"><i class="fa fa-user-md text-info"> LISTADO DE MEDICOS</i></b>
                  <div class="pull-right" style="margin-top: -5px;">
                      <a href='crearmedico.php' class="btn btn-primary btn-xs" type="submit"><i class="fa fa-plus"></i> Nuevo Médico</a>
                  </div>
              </div>
              <div class="panel-body">
                  <table id="dataTables-example" class="table table-striped table-hover display table-responsive " style="right: 10px;">
                    <thead>
                        <tr>
                            <th>Nro</th>
                            <th>Nombre</th>
                            <th>Doc.Id</th>
                            <th>Num. Colegiatura</th>
                            <th>Especialidad</th>

                            <th>Acci&oacute;n</th>
                        </tr>
                    </thead>
                    <tbody>
                       <?php 
                       $link_edit="editarmedico.php";
                       $link_listar="";
                       $link_mostrar="mostrarmedico.php";
                       for ($i = 0; $i < count($list_medicos); $i++) 
                       {
                           $nro=$i+1;
                          echo "<tr>";
                          echo "<td>".$nro."</td>";
                          echo "<td>".$list_medicos[$i]->getNombre()."</td>";
                          echo "<td>".$list_medicos[$i]->getDocID()."</td>";
                          echo "<td>".$list_medicos[$i]->getNroColegioMed()."</td>";
                          echo "<td>".$objEspecialidad->BuscarEspecialidad($list_medicos[$i]->getEspecialidad(), "", "")[0]->getNombreespecialidad()."</td>";
                         echo '
                          <td>
                                   <a href="'.$link_edit.'?nik='.$list_medicos[$i]->getIdMedico().'" title="Editar datos" class="btn btn-primary btn-xs"><span class="glyphicon glyphicon-edit" aria-hidden="true"></span></a>

                                   <a href="'.$link_listar.'?action=delete&nik='.$list_medicos[$i]->getIdMedico().'&v='.$list_medicos[$i]->getNombre() .'" title="Eliminar" onclick="return confirm(\'Está seguro de borrar los datos '.$list_medicos[$i]->getNombre().' ?\')" class="btn btn-primary btn-xs"><span class="glyphicon glyphicon-trash" aria-hidden="true"></span></a>

                                   <a href="'.$link_mostrar.'?nik='.$list_medicos[$i]->getIdMedico().'" title="Mostrar datos" class="btn btn-primary btn-xs"><span class="glyphicon glyphicon-eye-open" aria-hidden="true"></span></a>
                           </td>';
                          echo "</tr>";
                       }
                       ?>
                    </tbody>
                </table>
              </div>
          </div>
          
        </div>
    </div>
</section>
<?php 
                 include './footer.html';

?>
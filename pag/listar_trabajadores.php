<?php
include '../funct/con_tacnamh_db.php';
include '../funct/functions.php';
include './header.php';

include '../modelo/CargoController.php';
include '../modelo/TrabajadorController.php';

$objCargo=new CargoController();
$objTrabajador=new TrabajadorController();
$list_trabajadores=$objTrabajador->MostrarTrabajador();
$msg="";

if($_GET)
{
    
    if(isset($_GET["nik"]))
    {
        $id_eliminar=$_GET["nik"];
        
        $arr_existe=array();
        $arr_existe=$objTrabajador->BuscarTrabajador($id_eliminar, "", "");
        if(count($arr_existe)>0)
        {
            $affected=$objTrabajador->EliminarTrabajador($id_eliminar);
            if($affected==0){$msg="No se encontro el medico";}
            else {$msg="Se eliminaron los datos correctamente";}
        }
        else 
        {
            $msg="EL medico que desea eliminar no existe";
        }
        echo "<script>window.location = 'listar_trabajadores.php';</script>";
    }
}

?>
<br><br>
<section class="about-text">
    <div class="container ">
      
        <div class="col-md-12">
          <h3 class="text-left"><i class="fa fa-user text-info"> Listado de Trabajadores</i></h3>
          <div class="text-left">
              <a href='creartrabajador.php' class="btn btn-success" type="submit">Nuevo Trabajador</a>
         </div>
          <br>
          <?php 
          if($msg!=""){echo $msg;}
          ?>
          <table id="dataTables-example" class="table table-striped table-hover display table-responsive " style="right: 10px;">
              <thead>
                  <tr>
                      <th>Nro</th>
                      <th>Nombre</th>
                      <th>Doc. Id</th>
                      <th>Cargo</th>
                      
                      <th>Acci&oacute;n</th>
                  </tr>
              </thead>
              <tbody>
                 <?php 
                 $link_edit="editartrabajador.php";
                 $link_listar="";
                 $link_mostrar="mostrartrabajador.php";
                 for ($i = 0; $i < count($list_trabajadores); $i++) 
                 {
                     $nro=$i+1;
                    echo "<tr>";
                    echo "<td>".$nro."</td>";
                    echo "<td>".$list_trabajadores[$i]->getNombre()."</td>";
                    echo "<td>".$list_trabajadores[$i]->getDocID()."</td>";
                    echo "<td>".$objCargo->BuscarCargo($list_trabajadores[$i]->getCargo(), "")[0]->getNombreCargo()."</td>";
                    echo '
                    <td>
                             <a href="'.$link_edit.'?nik='.$list_trabajadores[$i]->getIdTrabajador().'" title="Editar datos" class="btn btn-primary btn-sm"><span class="glyphicon glyphicon-edit" aria-hidden="true"></span></a>

                             <a href="'.$link_listar.'?action=delete&nik='.$list_trabajadores[$i]->getIdTrabajador().'&v='.$list_trabajadores[$i]->getNombre().'" title="Eliminar" onclick="return confirm(\'Está seguro de borrar los datos '.$list_trabajadores[$i]->getNombre().' ?\')" class="btn btn-danger btn-sm"><span class="glyphicon glyphicon-trash" aria-hidden="true"></span></a>
                                 
                             <a href="'.$link_mostrar.'?nik='.$list_trabajadores[$i]->getIdTrabajador().'" title="Mostrar datos" class="btn btn-success btn-sm"><span class="glyphicon glyphicon-eye-open" aria-hidden="true"></span></a>
                     </td>';
                    echo "</tr>";
                 }
                 ?>
              </tbody>
          </table>
        </div>
    </div>
</section>


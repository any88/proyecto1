<?php
include '../funct/con_tacnamh_db.php';
include '../funct/functions.php';
include './header.php';

include '../modelo/CargoController.php';

$objCargo=new CargoController();
$list_cargos=$objCargo->MostrarCargo();
$msg="";

if($_GET)
{
    
    if(isset($_GET["nik"]))
    {
        $id_eliminar=$_GET["nik"];
        
        $arr_existe=array();
        $arr_existe=$objCargo->BuscarCargo($id_eliminar,"");
        if(count($arr_existe)>0)
        {
            $affected=$objCargo->EliminarCargo($id_eliminar);
            if($affected==0){$msg="No se encontro el cargo";}
            else {$msg="Se eliminaron los datos correctamente";}
        }
        else 
        {
            $msg="El cargo que desea eliminar no existe";
        }
        echo "<script>window.location = 'listar_cargos.php';</script>";
    }
}

?>
<br><br>
<section class="about-text">
    <div class="container ">
      
        <div class="col-md-12">
          <h3 class="text-left"><i class="fa fa-angle-double-up"> Listado de Cargos</i></h3>
          <div class="text-left">
              <a href='crearcargo.php' class="btn btn-success" type="submit">Nuevo Cargo</a>
         </div>
          <br>
          <table id="example" class="table table-striped table-hover display table-responsive " style="right: 10px;">
              <thead>
                  <tr>
                      <th>Nro</th>
                      <th>Nombre</th>
                                                                  
                      <th>Acci&oacute;n</th>
                  </tr>
              </thead>
              <tbody>
                 <?php 
                 $link_edit="editarcargo.php";
                 $link_listar="";
                 for ($i = 0; $i < count($list_cargos); $i++) 
                 {
                    $nro=$i+1;
                    echo "<tr>";
                    echo "<td>".$nro."</td>";
                    echo "<td>".$list_cargos[$i]->getNombreCargo()."</td>";
                    echo '<td>
                             <a href="'.$link_edit.'?nik='.$list_cargos[$i]->getIdCargo().'" title="Editar datos" class="btn btn-primary btn-sm"><span class="glyphicon glyphicon-edit" aria-hidden="true"></span></a>

                             <a href="'.$link_listar.'?action=delete&nik='.$list_cargos[$i]->getIdCargo().'&v='.$list_cargos[$i]->getNombreCargo().'" title="Eliminar" onclick="return confirm(\'Está seguro de borrar los datos '.$list_cargos[$i]->getNombreCargo().' ?\')" class="btn btn-danger btn-sm"><span class="glyphicon glyphicon-trash" aria-hidden="true"></span></a>
                     </td>';
                    echo "</tr>";
                 }
                 ?>
              </tbody>
          </table>
        </div>
    </div>
</section

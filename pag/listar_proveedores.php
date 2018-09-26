<?php
include '../funct/con_tacnamh_db.php';
include '../funct/functions.php';
include './header.php';

include '../modelo/ProveedorController.php';

$objProveedor=new ProveedorController();
$list_proveedores=$objProveedor->MostrarProveedor();
$msg="";

if($_GET)
{
    if(isset($_GET["nik"]))
    {
        $id_eliminar=$_GET["nik"];
        
        $arr_existe=array();
        $arr_existe=$objProveedor->BuscarProveedor($id_eliminar,"", "");
        if(count($arr_existe)>0)
        {
            $affected=$objProveedor->EliminarProveedor($id_eliminar);
            if($affected==0){$msg="No se encontro el proveedor";}
            else {$msg="Se eliminaron los datos correctamente";}
        }
        else 
        {
            $msg="El proveedor que desea eliminar no existe";
        }
        echo "<script>window.location = 'listar_proveedores.php';</script>";
    }
}

include './menu_almacen.php';
?>
<br><br>
<section class="about-text">
    <div class="ingres_costo ">
        <div class="col-md-12">
          <h3 class="text-left"><i class="fa fa-truck"> Listado de Proveedores</i></h3>
          <div class="text-left">
              <a href='crearproveedor.php' class="btn btn-success" type="submit">Nuevo Proveedor</a>
         </div>
          <br>
          <table id="example" class="table table-striped table-hover display table-responsive " style="right: 10px;">
              <thead>
                  <tr>
                      <th>Nro</th>
                      <th>Nombre</th>
                      <th>RUC</th>
                                            
                      <th>Acci&oacute;n</th>
                  </tr>
              </thead>
              <tbody>
                 <?php 
                 $link_edit="editarproveedor.php";
                 $link_listar="";
                 for ($i = 0; $i < count($list_proveedores); $i++) 
                 {
                     $nro=$i+1;
                    echo "<tr>";
                    echo "<td>".$nro."</td>";
                    echo "<td>".$list_proveedores[$i]->getNombre()."</td>";
                    echo "<td>".$list_proveedores[$i]->getRUC()."</td>";
                    echo '<td>
                             <a href="'.$link_edit.'?nik='.$list_proveedores[$i]->getIdProveedor().'" title="Editar datos" class="btn btn-primary btn-sm"><span class="glyphicon glyphicon-edit" aria-hidden="true"></span></a>

                             <a href="'.$link_listar.'?action=delete&nik='.$list_proveedores[$i]->getIdProveedor().'&v='.$list_proveedores[$i]->getNombre().'" title="Eliminar" onclick="return confirm(\'Está seguro de borrar los datos '.$list_proveedores[$i]->getNombre().' ?\')" class="btn btn-danger btn-sm"><span class="glyphicon glyphicon-trash" aria-hidden="true"></span></a>
                     </td>';
                    echo "</tr>";
                 }
                 ?>
              </tbody>
          </table>
        </div>
    </div>
</section


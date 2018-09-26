<?php
include '../funct/con_tacnamh_db.php';
include '../funct/functions.php';
include './header.php';

include '../modelo/InsumoController.php';
include '../modelo/CategoriaAlmacenController.php';

$objInsumo=new InsumoController();
$list_insumos=$objInsumo->MostrarInsumo();
$objCategAlmacC=new CategoriaAlmacenController();
$msg="";

if($_GET)
{
    if(isset($_GET["nik"]))
    {
        $id_eliminar=$_GET["nik"];      
        $arr_existe=array();
        $arr_existe=$objInsumo->BuscarInsumo($id_eliminar,"", "","");
        if(count($arr_existe)>0)
        {
            $affected=$objInsumo->EliminarInsumo($id_eliminar);
            if($affected==0){$msg="No se encontro el insumo";}
            else {$msg="Se eliminaron los datos correctamente";}
        }
        else 
        {
            $msg="El insumo que desea eliminar no existe";
        }
        echo "<script>window.location = 'listar_insumos.php';</script>";
    }
}

include './menu_almacen.php';
?>
<br><br>
<section class="about-text">
    <div class="ingres_costo ">
        <div class="col-md-12">
          <h3 class="text-left"><i class="fa fa-medkit"> Listado de Insumos</i></h3>
          <div class="text-left">
              <a href='crearinsumo.php' class="btn btn-success" type="submit">Nuevo Insumo</a>
         </div>
          <br>
          <table id="example" class="table table-striped table-hover display table-responsive " style="right: 10px;">
              <thead>
                  <tr>
                      <th>Nro</th>
                      <th>Nombre</th>
                      <th>Cantidad Min. Almac&eacute;n</th>
                      <th>Categor&iacute;a</th>                      
                      <th>Acci&oacute;n</th>
                  </tr>
              </thead>
              <tbody>
                 <?php 
                 $link_edit="editarinsumo.php";
                 $link_listar="";
                 for ($i = 0; $i < count($list_insumos); $i++) 
                 {
                     $nro=$i+1;
                     $id_categoria=$list_insumos[$i]->getId_categoria_almacen();
                     $nombre_categoriaAlm="";
                     if($id_categoria!="")
                     {
                         $arrCatAlm=$objCategAlmacC->BuscarCategoria($id_categoria, "");
                        if(count($arrCatAlm)>0){$nombre_categoriaAlm=$arrCatAlm[0]->getNombre_categoria();}
                     }
                     
                    echo "<tr>";
                    echo "<td>".$nro."</td>";
                    echo "<td>".$list_insumos[$i]->getNombre()."</td>";
                    echo "<td>".$list_insumos[$i]->getCant_min_almacen()."</td>";
                    echo "<td>".$nombre_categoriaAlm."</td>";
                    echo '<td>
                             <a href="'.$link_edit.'?nik='.$list_insumos[$i]->getIdInsumo().'" title="Editar datos" class="btn btn-primary btn-sm"><span class="glyphicon glyphicon-edit" aria-hidden="true"></span></a>

                             <a href="'.$link_listar.'?action=delete&nik='.$list_insumos[$i]->getIdInsumo().'&v='.$list_insumos[$i]->getNombre().'" title="Eliminar" onclick="return confirm(\'Está seguro de borrar los datos '.$list_insumos[$i]->getNombre().' ?\')" class="btn btn-danger btn-sm"><span class="glyphicon glyphicon-trash" aria-hidden="true"></span></a>
                     </td>';
                    echo "</tr>";
                 }
                 ?>
              </tbody>
          </table>
        </div>
    </div>
</section>



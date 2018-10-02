<?php
session_start();
include '../funct/con_tacnamh_db.php';
include '../funct/functions.php';
include './header.php';

include '../modelo/CategoriaAlmacenController.php';
$objCategAlmacC=new CategoriaAlmacenController();
include '../modelo/InsumoAlmacenController.php';
$objInsumoAlmacenC=new InsumoAlmacenController();
include '../modelo/InsumoController.php';
$objInsumoC=new InsumoController();

$listadoNecesidad=$objInsumoC->Necesidad();
$msg="";


include './menu_almacen.php';
?>
<br><br>
<section class="about-text">
    <div class="ingres_costo ">
        <div class="col-md-12">
            <div class='alert alert-info alert-dismissable'>"
                <button type='button' class='close' data-dismiss='alert' aria-hidden='true'>&times;</button>
                La necesidad de un producto está dada por la cantidad m&iacute;nima de ese producto que se declara en el nomenclador que 
                debe estar en stock para considerar la necesidad de compra de ese producto...
            </div>
          <?php 
          if($msg!=""){echo $msg;}
          ?>
          <div class="panel panel-default">
              <div class="panel-heading">
                  <b class="text-left"><i class="fa fa-truck text-danger"> NECESIDADES DE PRODUCTOS</i></b>
                  
              </div>
              <div class="panel-body">
                  <table class="table table-responsive table-hover" id="dataTables-example">
                      <thead>
                          <tr>
                              <th>Nro.</th>
                              <th>Categor&iacute;a</th>
                              <th>Insumo</th>
                              <th>Cantidad en Almac&eacute;n</th>
                          </tr>
                      </thead>
                      <tbody>
                          <?php 
                            if(count($listadoNecesidad)>0)
                            {
                                for ($i = 0; $i < count($listadoNecesidad); $i++) 
                                {
                                    $nro=$i+1;
                                    $cat_bd="";
                                    $nomb_insumo_bd="";
                                    $cantidad_bd=$listadoNecesidad[$i]->getCant_min_almacen();
                                    $id_insumo=$listadoNecesidad[$i]->getIdInsumo();
                                    $arrInsumos=$objInsumoC->BuscarInsumo($id_insumo, "", "");
                                    if(count($arrInsumos)>0)
                                    {
                                        $nomb_insumo_bd=$arrInsumos[0]->getNombre();
                                        $id_categoria_alm=$arrInsumos[0]->getId_categoria_almacen();
                                        $arrCategoriasAlm=$objCategAlmacC->BuscarCategoria($id_categoria_alm, "");
                                        if(count($arrCategoriasAlm)>0)
                                        {
                                            $cat_bd=$arrCategoriasAlm[0]->getNombre_categoria();
                                        }
                                    }
                                    echo "<tr>";
                                    echo "<td>$nro</td>";
                                    echo "<td>$nomb_insumo_bd</td>";
                                    echo "<td>$cat_bd</td>";
                                    echo "<td>$cantidad_bd</td>";
                                    echo "</tr>";
                                }
                            }
                            
                          ?>
                      </tbody>
                      
                  </table>
              </div>
          </div>
        </div>
    </div>
</section>


<?php
include '../funct/con_tacnamh_db.php';
include '../funct/functions.php';
include './header.php';

include '../modelo/InsumoAlmacenController.php';
include '../modelo/InsumoController.php';
include '../modelo/ProveedorController.php';

$objInsumoAlmacenC=new InsumoAlmacenController();
$objInsumoC=new InsumoController();
$objProveedor=new ProveedorController();
$msg="";

$lista_insumos=$objInsumoC->MostrarInsumo();
$p_id_insumo="";
$p_nombre_insumo="";
include './menu_almacen.php';
?>
<br><br>
<section class="about-text">
    <div class="ingres_costo ">
        <div class="col-md-12">
          <?php 
          if($msg!=""){echo $msg;}
          ?>
            <form method="post" action="nuevo_insumo_almacen.php">
            <div class="panel panel-default">
                <div class="panel-heading">
                    <b class="text-left"><i class="fa fa-certificate text-info"> GESTION DE ALMACEN</i></b>

                </div>
                <div class="panel-body">
                    <div class="col-md-3">
                        <img class="pic" src="../img/medicamento.jpg">
                    </div>
                    <div class="col-md-9">
                        <select name="insumo" class='form-control selectpicker' data-live-search='true'>
                            <option value="">--SELECCIONE EL INSUMO--</option>
                            <?php 
                                for ($i = 0; $i < count($lista_insumos); $i++) 
                                {
                                    $id_insumo=$lista_insumos[$i]->getIdInsumo();
                                    $nombre_insumo=$lista_insumos[$i]->getNombre();
                                    $selected="";
                                    if($id_insumo==$p_id_insumo){$selected="selected='selected'";}
                                    echo "<option value='$id_insumo' $selected>$nombre_insumo</option>";
                                }
                            ?>
                        </select>
                       
                    </div>
                </div>

            </div>
            <div class="pull-right">
                <a href="almacen_gestion.php" class="btn btn-danger"> Volver</a>
                <button type="submit" class="btn btn-success"> Guardar</button>
            </div>
           </form>
        </div>
    </div>
</section>


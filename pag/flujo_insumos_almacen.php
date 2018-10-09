<?php
session_start();
include '../funct/con_tacnamh_db.php';
include '../funct/functions.php';
include './header.php';

include '../modelo/InsumoCirugiaController.php';
include '../modelo/InsumoHospitalizacionController.php';
include '../modelo/InsumoController.php';
include '../modelo/CategoriaAlmacenController.php';

$objInsumo=new InsumoController();
$objInsumoCirugia=new InsumoCirugiaController();
$objInsumoHosp=new InsumoHospitalizacionController();
$objCategAlmacC=new CategoriaAlmacenController();

$result=array();
$listInsumos=$objInsumo->MostrarInsumo();

if(count($listInsumos)>0)
{
    $a=0;
    for ($i = 0; $i < count($listInsumos); $i++) 
    {
        $id_insumo=$listInsumos[$i]->getIdInsumo();
        $nombre_insumo=$listInsumos[$i]->getNombre();
        $id_categoria=$listInsumos[$i]->getId_categoria_almacen();
        $arrInsCir=$objInsumoCirugia->CantidadPorInsumos($id_insumo);
        $arrInsHosp=$objInsumoHosp->CantidadPorInsumos($id_insumo);
        $nombre_categoriaAlm="";
        if($id_categoria!="")
        {
            $arrCateg= $objCategAlmacC->BuscarCategoria($id_categoria, "");
            if(count($arrCateg)>0)
            {
                $nombre_categoriaAlm=$arrCateg[0]->getNombre_categoria();
            }
        }
        
        if(count($arrInsCir)>0)
        {
            $cant_ins_cir=$arrInsCir[0];
        }
        else{$cant_ins_cir=0;}
        if(count($arrInsCir)>0)
        {
            $cant_ins_hosp=$arrInsHosp[0];
        }
        {$cant_ins_hosp=0;}
        
        $result[$a]['id_insumo']=$id_insumo;
        $result[$a]['nomb_insumo']=$nombre_insumo;
        $result[$a]['cantidad']=$cant_ins_cir+$cant_ins_hosp;
        $result[$a]['categoria']=$nombre_categoriaAlm;
        $a++;
    }
}
$msg="";

for ($k = 0; $k < count($result); $k++) 
{
    $id_mayor=$result[$k]['id_insumo'];
    $cant_mayor=$result[$k]['cantidad'];
    $nomb_mayor=$result[$k]['nomb_insumo'];
    $nomb_categoria=$result[$k]['categoria'];
    
    for ($i = 0; $i < count($result); $i++) 
    {
        $id=$result[$i]['id_insumo'];
        $cant=$result[$i]['cantidad'];
        $nomb=$result[$i]['nomb_insumo'];
        $categoria=$result[$i]['categoria'];
        
        if($cant<$cant_mayor)
        {
            $result[$k]['id_insumo']=$id;
            $result[$k]['nomb_insumo']=$nomb;
            $result[$k]['cantidad']=$cant;
            $result[$k]['categoria']=$categoria;
            
            $result[$i]['id_insumo']=$id_mayor;
            $result[$i]['nomb_insumo']=$nomb_mayor;
            $result[$i]['cantidad']=$cant_mayor;
            $result[$i]['categoria']=$nomb_categoria;
            
            $id_mayor=$id;
            $cant_mayor=$cant;
            $nomb_mayor=$nomb;
            $nomb_categoria=$categoria;
        }
    }
}

include './menu_almacen.php';
?>
<br><br>
<section class="about-text">
    <div class="ingres_costo ">
        <div class="col-md-12">
          <?php 
          if($msg!=""){echo $msg;}
          ?>
           <div class='alert alert-info alert-dismissable'>
          <button type='button' class='close' data-dismiss='alert' aria-hidden='true'>&times;</button>
          <i class="fa fa-exclamation-circle"></i> Listado de Insumos del almac&eacute;n ordenados de mayor a menor consumo.</div> 
          <div class="panel panel-default">
              <div class="panel-heading">
                  <b class="text-left"><i class="fa fa-tasks text-info"> FLUJO DE INSUMOS DE ALMACEN</i></b>
                 
              </div>
              <div class="panel-body">
                  
                  <table class="table table-responsive" id="dataTables-example">
                      <thead>
                          <tr>
                              <th>Nro.</th>
                              <th>Nombre</th>
                              <th>Categor&iacute;a de Almac&eacute;n</th>
                              <th>Cantidad</th>
                          </tr>
                      </thead>
                      <tbody>
                          <?php 
                            for ($i = 0; $i < count($result); $i++) 
                            {
                                $nro=$i+1;
                                $nombre=$result[$i]['nomb_insumo'];
                                $cantidad=$result[$i]['cantidad'];
                                $categoriaAlm=$result[$i]['categoria'];
                                echo "<tr>";
                                echo "<td>$nro</td>";
                                echo "<td>$nombre</td>";
                                echo "<td>$categoriaAlm</td>";
                                echo "<td>$cantidad</td>";
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


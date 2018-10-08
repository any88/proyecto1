<?php
session_start();
include '../funct/con_tacnamh_db.php';
include '../funct/functions.php';
include './header.php';

include '../modelo/InsumoCirugiaController.php';
include '../modelo/InsumoHospitalizacionController.php';
include '../modelo/InsumoController.php';

$objInsumo=new InsumoController();
$objInsumoCirugia=new InsumoCirugiaController();
$objInsumoHosp=new InsumoHospitalizacionController();


$result=array();
$listInsumos=$objInsumo->MostrarInsumo();

if(count($listInsumos)>0)
{
    $a=0;
    for ($i = 0; $i < count($listInsumos); $i++) 
    {
        $id_insumo=$listInsumos[$i]->getIdInsumo();
        $nombre_insumo=$listInsumos[$i]->getNombre();
        
        $arrInsCir=$objInsumoCirugia->CantidadPorInsumos($id_insumo);
        $arrInsHosp=$objInsumoHosp->CantidadPorInsumos($id_insumo);
        
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
        $a++;
    }
}
$msg="";

for ($k = 0; $k < count($result); $k++) 
{
    $id_mayor=$result[$k]['id_insumo'];
    $cant_mayor=$result[$k]['cantidad'];
    $nomb_mayor=$result[$k]['nomb_insumo'];
    
    for ($i = 0; $i < count($result); $i++) 
    {
        $id=$result[$i]['id_insumo'];
        $cant=$result[$i]['cantidad'];
        $nomb=$result[$i]['nomb_insumo'];
        
        if($cant<$cant_mayor)
        {
            $result[$k]['id_insumo']=$id;
            $result[$k]['nomb_insumo']=$nomb;
            $result[$k]['cantidad']=$cant;
            
            $result[$i]['id_insumo']=$id_mayor;
            $result[$i]['nomb_insumo']=$nomb_mayor;
            $result[$i]['cantidad']=$cant_mayor;
            
            $id_mayor=$id;
            $cant_mayor=$cant;
            $nomb_mayor=$nomb;
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
                                echo "<tr>";
                                echo "<td>$nro</td>";
                                echo "<td>$nombre</td>";
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


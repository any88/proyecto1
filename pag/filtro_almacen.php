<?php
session_start();
include '../funct/con_tacnamh_db.php';
include '../funct/functions.php';
include './header.php';

include '../modelo/InsumoCirugiaController.php';
include '../modelo/InsumoHospitalizacionController.php';
include '../modelo/InsumoController.php';
include '../modelo/CategoriaAlmacenController.php';
include '../modelo/InsumoAlmacenController.php';
include '../modelo/ProveedorController.php';

$objInsumo=new InsumoController();
$objInsumoCirugia=new InsumoCirugiaController();
$objInsumoHosp=new InsumoHospitalizacionController();
$objCategAlmacC=new CategoriaAlmacenController();
$objProveedor=new ProveedorController();
$objInsAlmacenC=new InsumoAlmacenController();

$msg="";
$listaCategorias=$objCategAlmacC->MostrarCategoria();
$listaProvedores=$objProveedor->MostrarProveedor();
$listaInsumos=$objInsumo->MostrarInsumo();

$p_id_categoria="";
$p_id_proveedor="";
$p_id_insumo="";

$result_filtro=array();
$cont_f=0;
$p=0;
if($_POST)
{
    if(isset($_POST['insumos'])){$p_id_insumo=$_POST['insumos'];}
    if(isset($_POST['categoria'])){$p_id_categoria=$_POST['categoria'];}
    if(isset($_POST['provedores'])){$p_id_proveedor=$_POST['provedores'];}
    
    $result=array();
    if($p_id_insumo!="" || $p_id_proveedor!="")
    {
       
         $result=$objInsAlmacenC->BuscarInsumoAlmacen("", $p_id_insumo, "", "", "", "", "", "", $p_id_proveedor);
        
         if($p_id_categoria!="")
        {
             for ($i = 0; $i < count($result); $i++) 
             {
                $id_insumo_bd=$result[$i]->getId_insumo();
                
                $ArrInsumos=$objInsumo->BuscarInsumo($id_insumo_bd, "", "");
                if(count($ArrInsumos)>0)
                {
                    if($p_id_categoria==$ArrInsumos[0]->getId_categoria_almacen())
                    {
                        $result_filtro[$cont_f]=$result[$i];
                        $cont_f++;
                    }
                }
                
             }
        }
        else
        {
            for ($j = 0; $j < count($result); $j++) 
                {
                    $result_filtro[$cont_f]=$result[$j];
                    $cont_f++;
                }
        }
    }
    else
    {
        if($p_id_categoria!="")
        {
            $ArrInsumos=$objInsumo->BuscarInsumo("", "", "", $p_id_categoria);
            if(count($ArrInsumos)>0)
            {
                for ($j = 0; $j < count($ArrInsumos); $j++) 
                {
                    $result_filtro[$cont_f]=$ArrInsumos[$j];
                    $cont_f++;
                }
            }
        }
    }
   
 $p=1;
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
          <i class="fa fa-exclamation-circle"></i> Usted puede filtrar los insumos por 1 o varios de los parametros que aparecen a continuaci&oacute;n.</div> 
          
          <div class="panel panel-default">
              <div class="panel-heading">
                  <b class="text-left"><i class="fa fa-search text-info"> BUSCADOR DE INSUMOS DE ALMACEN</i></b>
              </div>
              <div class="panel-body">
                  <form name="filtro" method="post" action="filtro_almacen.php">
                      <table class="table table-responsive">
                      <tr>
                          <th>Nombre</th>
                          <td> 
                               <select name="insumos" class='form-control selectpicker' data-live-search='true'>
                                  <option value='' >--SELECCIONE EL INSUMO--</option>
                                  <?php 
                                    for ($i = 0; $i < count($listaInsumos); $i++) 
                                    {
                                        $id_insumo=$listaInsumos[$i]->getIdInsumo();
                                        $nomb_cinsumo=$listaInsumos[$i]->getNombre();
                                        $selected="";
                                        if($id_insumo==$p_id_insumo){$selected="selected='selected'";}
                                        echo "<option value='$id_insumo' $selected>$nomb_cinsumo</option>";
                                    }
                                  ?>   
                                      
                              </select>
                          </td>
                      </tr>
                       <tr>
                           <th>Categor&iacute;a</th>
                          <td> 
                              <select name="categoria" class='form-control selectpicker' data-live-search='true'>
                                  <option value='' >--SELECCIONE LA CATEGORIA--</option>
                                  <?php 
                                    for ($i = 0; $i < count($listaCategorias); $i++) 
                                    {
                                        $id_categoria=$listaCategorias[$i]->getId_categoria_almacen();
                                        $nomb_categoria=$listaCategorias[$i]->getNombre_categoria();
                                        $selected="";
                                        if($id_categoria==$p_id_categoria){$selected="selected='selected'";}
                                        echo "<option value='$id_categoria' $selected>$nomb_categoria</option>";
                                    }
                                  ?>   
                                      
                              </select>
                          </td>
                      </tr>
                      <tr>
                           <th>Proveedor</th>
                          <td> 
                              <select name="provedores" class='form-control selectpicker' data-live-search='true'>
                                  <option value='' >--SELECCIONE EL PROVEEDOR--</option>
                                  <?php 
                                    for ($i = 0; $i < count($listaProvedores); $i++) 
                                    {
                                        $id_proveedor=$listaProvedores[$i]->getIdProveedor();
                                        $nomb_proveedor=$listaProvedores[$i]->getNombre();
                                        $selected="";
                                        if($id_proveedor==$p_id_proveedor){$selected="selected='selected'";}
                                        echo "<option value='$id_proveedor' $selected>$nomb_proveedor</option>";
                                    }
                                  ?>   
                                      
                              </select>
                          </td>
                      </tr>
                      <tr>
                          <td colspan="2">
                              <div class="pull-right">
                                  <button type="submit" class="btn btn-success"> BUSCAR </button>
                              </div>
                              
                          </td>
                      </tr>
                      
                  </table>
                  </form>
                  
              </div>
          </div>
            
            
            <?php 
            if($p==1)
            {
                $total_resultados= count($result_filtro);
                echo "<hr>";
                echo "<div class='panel panel-default'>";
                    echo "<div class='panel-heading'>";
                        echo "<b class='text-left'><i class='fa fa-search text-info'> ($total_resultados) RESULTADO(S) DE LA BUSQUEDA</i></b>";
                    echo "</div>";
                      echo "<div class='panel-body'>";
                        if(count($result_filtro)>0)
                        {
                            echo "<table class='table table-responsive' id='dataTables-example'>";
                            echo "<thead>";
                            echo "<tr>";
                                echo "<th>Nombre</th>";
                                echo "<th>Cantidad</th>";
                                echo "<th>Fecha Compra</th>";
                                echo "<th>Precio Compra</th>";
                                echo "<th>Precio venta</th>";
                                echo "<th>Fecha Vencimiento</th>";
                                echo "<th>Categor&iacute;a</th>";
                                echo "<th>Proveedor</th>";
                            echo "</tr>";
                            echo "<thead>";
                            echo "<tbody>";
                            for ($i = 0; $i < count($result_filtro); $i++) 
                            {
                                $id_insumo=$result_filtro[$i]->getId_insumo();
                                $cantidad=$result_filtro[$i]->getCantidad();
                                $fecha_compra=$result_filtro[$i]->getFecha_compra();
                                $precio_compra=$result_filtro[$i]->getPrecio_compra();
                                $precio_venta=$result_filtro[$i]->getPrecio_venta();
                                $fecha_v=$result_filtro[$i]->getFecha_vencimiento();
                                $id_proveedor=$result_filtro[$i]->getId_proveedor();
                                
                                $categoria="";
                                $nomb_prov="";
                                $nombre_insumo="";
                                $dat_insumo=$objInsumo->BuscarInsumo($id_insumo, "", "");
                                if(count($dat_insumo)>0)
                                {
                                    $nombre_insumo=$dat_insumo[0]->getNombre();
                                    $id_categoria=$dat_insumo[0]->getId_categoria_almacen();
                                    if($id_categoria!="")
                                    {
                                        $dat_categoria=$objCategAlmacC->BuscarCategoria($id_categoria, "");
                                        if(count($dat_categoria)>0)
                                        {
                                            $categoria=$dat_categoria[0]->getNombre_categoria();
                                        }
                                    }
                                }
                                $dat_proveedor=$objProveedor->BuscarProveedor($id_proveedor, "", "");
                                if(count($dat_proveedor)>0){$nomb_prov=$dat_proveedor[0]->getNombre();}
                                echo "<tr>";
                                echo "<td>$nombre_insumo</td>";
                                echo "<td>$cantidad</td>";
                                echo "<td>$fecha_compra</td>";
                                echo "<td>$precio_compra</td>";
                                echo "<td>$precio_venta</td>";
                                echo "<td>$fecha_v</td>";
                                echo "<td>$categoria</td>";
                                echo "<td>$nomb_prov</td>";
                                echo "</tr>";
                            }
                            echo "</tbody>";
                            echo "</table>";
                            
                        }
                        else
                        {
                            echo "<p> No se han encontrado resultados para su criterio de b&uacute;squeda</p>";
                        }
                      echo "</div>";
                  echo "</div>";
                
            }
            
            
            ?>
           
        </div>
    </div>
</section>
            


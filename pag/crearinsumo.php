<?php

include '../funct/con_tacnamh_db.php';
include '../funct/functions.php';
include './header.php';

include '../modelo/InsumoController.php';
include '../modelo/CategoriaAlmacenController.php';

$objCatAlmC=new CategoriaAlmacenController();
$objInsumo=new InsumoController();
$msg="";

##variables
$nombreinsumo="";
$preciounitario="";
$id_categoria="";
$nomb_categoria="";
$listaCategorias=array();
$listaCategorias=$objCatAlmC->MostrarCategoria();

if($_POST)
{
    //Mostrar($_POST);
    if(isset($_POST['nombreinsumo'])){$nombreinsumo= eliminarblancos($_POST['nombreinsumo']);}
    if(isset($_POST['preciounitario'])){$preciounitario=eliminarblancos($_POST['preciounitario']);}
    if(isset($_POST['id_categoria'])){$id_categoria= eliminarblancos($_POST['id_categoria']);}
    
    $error=0;
    ##validar
     if($nombreinsumo=="" || $preciounitario=="" || $id_categoria=="")
    {
        $msg="<div class='alert alert-danger alert-dismissable'>"
                . "<button type='button' class='close' data-dismiss='alert' aria-hidden='true'>&times;</button>"
                . "Error! No puede dejar campos vacíos</div>";
        $error++;
    }
    else
    {      
        ##validar que el insumo no exista en la base de datos
        
        $list_p=$objInsumo->BuscarInsumo('', $nombreinsumo, '','');
        if(count($list_p)>0)
        {
            $msg="<div class='alert alert-danger alert-dismissable'>"
                . "<button type='button' class='close' data-dismiss='alert' aria-hidden='true'>&times;</button>"
                . "Error! Ya existe un insumo registrado con ese nombre: $nombreinsumo</div>"; 
            $error++;
            
        }
        
        if($error==0)
        {
            $affected=$objInsumo->CrearInsumo($nombreinsumo, $preciounitario,$id_categoria);
            if($affected==1)
            {
                
                 $msg="<div class='alert alert-success alert-dismissable'>"
                . "<button type='button' class='close' data-dismiss='alert' aria-hidden='true'>&times;</button>"
                . "Insumo registrado satisfactoriamente</div>"; 
                 echo "<script>";
                echo "window.location = 'listar_insumos.php';";
                echo "</script>";
            }
            else
            {
                $msg="<div class='alert alert-danger alert-dismissable'>"
                . "<button type='button' class='close' data-dismiss='alert' aria-hidden='true'>&times;</button>"
                . "Error! No se pudo Insertar el Insumo</div>"; 
            }
        }
        
    }
    
}
include './menu_almacen.php';
?>

<br>
<section class="about-text">
    <div class="ingres_costo ">
        <div class="col-md-12">
          <h3 class="text-left"><i class="fa fa-medkit"> Nuevo Insumo</i></h3>
          <?php 
             echo $msg;
          ?>
          <form name="nuevo_insumo" method="post" action="crearinsumo.php">
              <table class="table table-responsive table-bordered">
                  <tr class="text text-info">
                      <th> Nombre</th>
                      <th> Cantidad Minima Almac&eacute;n</th>
                       <th> Categor&iacute;a</th>
                  </tr>
                  <tr >
                      <td><input type="text" name="nombreinsumo" class="form-control" required="" value="<?php echo $nombreinsumo;?>"></td>
                      <td><input type="number" name="preciounitario" class="form-control" required="" value="<?php echo $preciounitario;?>" min="0" max="10000"></td> 
                      <td>
                          
                          <select name="id_categoria" class='form-control selectpicker' data-live-search='true' required="">
                              <option value="">--SELECCIONE LA CATEGORIA --</option>
                              <?php 
                                for ($j = 0; $j < count($listaCategorias); $j++) 
                                {
                                    $id_categoria_bd=$listaCategorias[$j]->getId_categoria_almacen();
                                    $nombre_categoriaAlm_bd=$listaCategorias[$j]->getNombre_categoria();
                                    $selected="";
                                    if($id_categoria==$id_categoria_bd)
                                    {$selected="selected='selected'";}
                                    echo "<option value='$id_categoria_bd' $selected>$nombre_categoriaAlm_bd</option>";
                                }
                              
                              ?>
                          </select>
                      </td>
                  </tr>
                                    
              </table>
              <div class="text-right">
                  <button class="btn btn-success" type="submit">Registrar</button>
                  <a href='listar_insumos.php' class="btn btn-danger" type="submit">Cancelar</a>
              </div>
              
          </form>
        </div>
    </div>
</section>

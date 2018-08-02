<?php

include '../funct/con_tacnamh_db.php';
include '../funct/functions.php';
include './header.php';

include '../modelo/InsumoController.php';

$objInsumo=new InsumoController();
$insmod=array();
$id_insmod="";
$msg="";

##variables
$nombreinsumo="";
$preciounitario="";

if(isset($_GET['nik']))
{
$id_insmod=$_GET['nik'];
$insmod=$objInsumo->BuscarInsumo($id_insmod, "", "");

    if(count($insmod)>0)
    {
        $nombreinsumo=$insmod[0]->getNombre();
        $preciounitario=$insmod[0]->getPrecioUnitario();
    }
}
if($_POST)
{
    //Mostrar($_POST);
    if(isset($_POST['id_insmod'])){$id_insmod= eliminarblancos($_POST['id_insmod']);}
    if(isset($_POST['nombreinsumo'])){$nombreinsumo= eliminarblancos($_POST['nombreinsumo']);}
    if(isset($_POST['preciounitario'])){$preciounitario= eliminarblancos($_POST['preciounitario']);}
            
    $error=0;
    ##validar
    
    if($nombreinsumo=="" || $preciounitario=="")
    {
        $msg="<div class='alert alert-danger alert-dismissable'>"
                . "<button type='button' class='close' data-dismiss='alert' aria-hidden='true'>&times;</button>"
                . "Error! No puede dejar campos vacíos</div>";
        $error++;
    }
    else
    {           
        if($error==0)
        {
            $affected=$objInsumo->ModificarInsumo($id_insmod, $nombreinsumo, $preciounitario);
            if($affected==1)
            {
                $msg="<div class='alert alert-success alert-dismissable'>"
                . "<button type='button' class='close' data-dismiss='alert' aria-hidden='true'>&times;</button>"
                . "Datos actualizados satisfactoriamente</div>"; 
                echo "<script>";
                echo "window.location = 'listar_insumos.php';";
                echo "</script>";
            }
            else
            {
                $msg="<div class='alert alert-danger alert-dismissable'>"
                . "<button type='button' class='close' data-dismiss='alert' aria-hidden='true'>&times;</button>"
                . "Error! Actualizacion de datos fallida</div>"; 
            }
        }
        
    }
  
}

?>

<br>
<section class="about-text">
    <div class="container ">
      
        <div class="col-md-12">
          <h3 class="text-left"><i class="fa fa-medkit"> Editar Insumo</i></h3>
          <?php 
             echo $msg;
          ?>
          <form name="editar_insumo" method="post" action="editarinsumo.php">
              <table class="table table-responsive table-bordered">
                  <tr class="text text-info">
                      <th> Nombre</th>
                      <th> Precio Unitario</th>
                  </tr>
                  <tr >
                      <input type="hidden" name="id_insmod" value="<?php echo $id_insmod; ?>">
                      <td><input type="text" name="nombreinsumo" class="form-control" required="" value="<?php echo $nombreinsumo;?>"></td>
                      <td><input type="text" name="preciounitario" class="form-control" required="" value="<?php echo $preciounitario;?>"></td> 
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



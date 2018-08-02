<?php

include '../funct/con_tacnamh_db.php';
include '../funct/functions.php';
include './header.php';

include '../modelo/InsumoController.php';

$objInsumo=new InsumoController();
$msg="";

##variables
$nombreinsumo="";
$preciounitario="";

if($_POST)
{
    //Mostrar($_POST);
    if(isset($_POST['nombreinsumo'])){$nombreinsumo= eliminarblancos($_POST['nombreinsumo']);}
    if(isset($_POST['preciounitario'])){$preciounitario=eliminarblancos($_POST['preciounitario']);}
    
    
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
        ##validar que el insumo no exista en la base de datos
        
        $list_p=$objInsumo->BuscarInsumo('', $nombreinsumo, '');
        if(count($list_p)>0)
        {
            $msg="<div class='alert alert-danger alert-dismissable'>"
                . "<button type='button' class='close' data-dismiss='alert' aria-hidden='true'>&times;</button>"
                . "Error! Ya existe un insumo registrado con ese nombre: $nombreinsumo</div>"; 
            $error++;
            
        }
        
        if($error==0)
        {
            $affected=$objInsumo->CrearInsumo($nombreinsumo, $preciounitario);
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
?>

<br>
<section class="about-text">
    <div class="container ">
      
        <div class="col-md-12">
          <h3 class="text-left"><i class="fa fa-medkit"> Nuevo Insumo</i></h3>
          <?php 
             echo $msg;
          ?>
          <form name="nuevo_insumo" method="post" action="crearinsumo.php">
              <table class="table table-responsive table-bordered">
                  <tr class="text text-info">
                      <th> Nombre</th>
                      <th> Precio Unitario</th>
                  </tr>
                  <tr >
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

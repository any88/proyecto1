<?php

include '../funct/con_tacnamh_db.php';
include '../funct/functions.php';
include './header.php';

include '../modelo/ProveedorController.php';

$objProveedor=new ProveedorController();
$msg="";

##variables
$nombreproveedor="";
$ruc="";

if($_POST)
{
    //Mostrar($_POST);
    if(isset($_POST['nombreproveedor'])){$nombreproveedor= eliminarblancos($_POST['nombreproveedor']);}
    if(isset($_POST['ruc'])){$ruc=eliminarblancos($_POST['ruc']);}
    
    
    $error=0;
    ##validar
    if($nombreproveedor=="" || $ruc=="")
    {
        $msg="<div class='alert alert-danger alert-dismissable'>"
                . "<button type='button' class='close' data-dismiss='alert' aria-hidden='true'>&times;</button>"
                . "Error! No puede dejar campos vacíos</div>";
        $error++;
    }
    else
    {      
        ##validar que el ruc no exista en la base de datos
        
        $list_p=$objProveedor->BuscarProveedor('', '', $ruc);
        if(count($list_p)>0)
        {
            $msg="<div class='alert alert-danger alert-dismissable'>"
                . "<button type='button' class='close' data-dismiss='alert' aria-hidden='true'>&times;</button>"
                . "Error! Ya existe un proveedor registrado con ese RUC: $ruc</div>"; 
            $error++;
            
        }
        
        if($error==0)
        {
            $affected=$objProveedor->CrearProveedor($nombreproveedor, $ruc);
            if($affected==1)
            {
                
                 $msg="<div class='alert alert-success alert-dismissable'>"
                . "<button type='button' class='close' data-dismiss='alert' aria-hidden='true'>&times;</button>"
                . "Proveedor registrado satisfactoriamente</div>"; 
                 echo "<script>";
                echo "window.location = 'listar_proveedores.php';";
                echo "</script>";
            }
            else
            {
                $msg="<div class='alert alert-danger alert-dismissable'>"
                . "<button type='button' class='close' data-dismiss='alert' aria-hidden='true'>&times;</button>"
                . "Error! No se pudo Insertar el Proveedor</div>"; 
            }
        }
        
    }
    
}
?>

<br>
<section class="about-text">
    <div class="container ">
      
        <div class="col-md-12">
          <h3 class="text-left"><i class="fa fa-truck"> Nuevo Proveedor</i></h3>
          <?php 
             echo $msg;
          ?>
          <form name="nuevo_proveedor" method="post" action="crearproveedor.php">
              <table class="table table-responsive table-bordered">
                  <tr class="text text-info">
                      <th> Nombre</th>
                      <th> RUC</th>
                  </tr>
                  <tr >
                      <td><input type="text" name="nombreproveedor" class="form-control" required="" value="<?php echo $nombreproveedor;?>"></td>
                      <td><input type="text" name="ruc" class="form-control" required="" value="<?php echo $ruc;?>"></td> 
                  </tr>
                                    
              </table>
              <div class="text-right">
                  <button class="btn btn-success" type="submit">Registrar</button>
                  <a href='listar_proveedores.php' class="btn btn-danger" type="submit">Cancelar</a>
              </div>
              
          </form>
        </div>
    </div>
</section>


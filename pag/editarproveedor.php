<?php

include '../funct/con_tacnamh_db.php';
include '../funct/functions.php';
include './header.php';

include '../modelo/ProveedorController.php';

$objProveedor=new ProveedorController();
$promod=array();
$id_promod="";
$msg="";

##variables
$nombreproveedor="";
$ruc="";

if(isset($_GET['nik']))
{
$id_promod=$_GET['nik'];
$promod=$objProveedor->BuscarProveedor($id_promod, "", "");

    if(count($promod)>0)
    {
        $nombreproveedor=$promod[0]->getNombre();
        $ruc=$promod[0]->getRUC();
    }
}
if($_POST)
{
    //Mostrar($_POST);
    if(isset($_POST['id_promod'])){$id_promod= eliminarblancos($_POST['id_promod']);}
    if(isset($_POST['nombreproveedor'])){$nombreproveedor= eliminarblancos($_POST['nombreproveedor']);}
    if(isset($_POST['ruc'])){$ruc= eliminarblancos($_POST['ruc']);}
            
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
        if($error==0)
        {
            $affected=$objProveedor->ModificarProveedor($id_promod, $nombreproveedor, $ruc);
            if($affected==1)
            {
                $msg="<div class='alert alert-success alert-dismissable'>"
                . "<button type='button' class='close' data-dismiss='alert' aria-hidden='true'>&times;</button>"
                . "Datos actualizados satisfactoriamente</div>"; 
                echo "<script>";
                echo "window.location = 'listar_proveedores.php';";
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
          <h3 class="text-left"><i class="fa fa-truck"> Editar Proveedor</i></h3>
          <?php 
             echo $msg;
          ?>
          <form name="editar_proveedor" method="post" action="editarproveedor.php">
              <table class="table table-responsive table-bordered">
                  <tr class="text text-info">
                      <th> Nombre</th>
                      <th> RUC</th>
                  </tr>
                  <tr >
                      <input type="hidden" name="id_promod" value="<?php echo $id_promod; ?>">
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


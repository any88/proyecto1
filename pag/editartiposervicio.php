<?php

include '../funct/con_tacnamh_db.php';
include '../funct/functions.php';
include './header.php';

include '../modelo/TipoServicioController.php';

$objTipoServicio=new TipoServicioController();
$tiposmod=array();
$id_tiposmod="";
$msg="";

##variables
$tiposervicio="";
$preciob="";
if(isset($_GET['nik']))
{
    $id_tiposmod=$_GET['nik'];
    $tiposmod=$objTipoServicio->BuscarTipoServicio($id_tiposmod, "");

    if(count($tiposmod)>0)
    {
        $tiposervicio=$tiposmod[0]->getTipoServicio();
        $preciob=$tiposmod[0]->getPrecio_base();
    }
}
if($_POST)
{
    //Mostrar($_POST);
    if(isset($_POST['id_tiposmod'])){$id_tiposmod= eliminarblancos($_POST['id_tiposmod']);}
    if(isset($_POST['tiposervicio'])){$tiposervicio= eliminarblancos($_POST['tiposervicio']);}
    if(isset($_POST['preciob'])){$preciob= eliminarblancos($_POST['preciob']);}
    
    $error=0;
    ##validar
    
    if($tiposervicio=="" || $preciob=="")
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
            $affected=$objTipoServicio->ModificarTipoServicio($id_tiposmod, $tiposervicio,$preciob);
            if($affected==1)
            {
                $msg="<div class='alert alert-success alert-dismissable'>"
                . "<button type='button' class='close' data-dismiss='alert' aria-hidden='true'>&times;</button>"
                . "Datos actualizados satisfactoriamente</div>"; 
                echo "<script>";
                echo "window.location = 'listar_tiposervicio.php';";
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
          <h3 class="text-left"><i class="fa fa-hospital-o"> Editar Tipo de Servicio</i></h3>
          <?php 
             echo $msg;
          ?>
          <form name="editar_tiposervicio" method="post" action="editartiposervicio.php">
              <table class="table table-responsive table-bordered">
                  <tr class="text text-info">
                      <th> Tipo de Servicio</th>
                      <th> Precio Base</th>
                  </tr>
                  <tr>
                      <input type="hidden" name="id_tiposmod" value="<?php echo $id_tiposmod; ?>">
                      <td><input type="text" name="tiposervicio" class="form-control" required="" value="<?php echo $tiposervicio;?>"></td>
                      <td><input type="text" name="preciob" class="form-control" required="" value="<?php echo $preciob;?>"></td>
                  </tr>
                                    
              </table>
              <div class="text-right">
                  <button class="btn btn-success" type="submit">Registrar</button>
                  <a href='listar_tiposervicio.php' class="btn btn-danger" type="submit">Cancelar</a>
              </div>
              
          </form>
        </div>
    </div>
</section>

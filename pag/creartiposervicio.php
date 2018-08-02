<?php

include '../funct/con_tacnamh_db.php';
include '../funct/functions.php';
include './header.php';

include '../modelo/TipoServicioController.php';

$objTipoServicio=new TipoServicioController();
$msg="";

##variables
$tiposervicio="";

if($_POST)
{
    //Mostrar($_POST);
    if(isset($_POST['tiposervicio'])){$tiposervicio= eliminarblancos($_POST['tiposervicio']);}
    
    $error=0;
    ##validar
    if($tiposervicio=="")
    {
        $msg="<div class='alert alert-danger alert-dismissable'>"
                . "<button type='button' class='close' data-dismiss='alert' aria-hidden='true'>&times;</button>"
                . "Error! No puede dejar campos vacíos</div>";
        $error++;
    }
    else
    {      
        ##validar que el ruc no exista en la base de datos
        
        $list_p=$objTipoServicio->BuscarTipoServicio('',$tiposervicio);
        if(count($list_p)>0)
        {
            $msg="<div class='alert alert-danger alert-dismissable'>"
                . "<button type='button' class='close' data-dismiss='alert' aria-hidden='true'>&times;</button>"
                . "Error! Ya existe un tipo de servicio registrado con ese nombre: $tiposervicio</div>"; 
            $error++;
            
        }
        
        if($error==0)
        {
            $affected=$objTipoServicio->CrearTipoServicio($tiposervicio);
            if($affected==1)
            {
                
                 $msg="<div class='alert alert-success alert-dismissable'>"
                . "<button type='button' class='close' data-dismiss='alert' aria-hidden='true'>&times;</button>"
                . "Tipo de Servicio registrado satisfactoriamente</div>"; 
                 echo "<script>";
                echo "window.location = 'listar_tiposervicio.php';";
                echo "</script>";
            }
            else
            {
                $msg="<div class='alert alert-danger alert-dismissable'>"
                . "<button type='button' class='close' data-dismiss='alert' aria-hidden='true'>&times;</button>"
                . "Error! No se pudo Insertar el Tipo de Servicio</div>"; 
            }
        }
        
    }
    
}
?>

<br>
<section class="about-text">
    <div class="container ">
      
        <div class="col-md-12">
          <h3 class="text-left"><i class="fa fa-hospital-o"> Nuevo Tipo de Servicio</i></h3>
          <?php 
             echo $msg;
          ?>
          <form name="nuevo_tiposervicio" method="post" action="creartiposervicio.php">
              <table class="table table-responsive table-bordered">
                  <tr class="text text-info">
                      <th> Tipo de Servicio</th>
                  </tr>
                  <tr>
                      <td><input type="text" name="tiposervicio" class="form-control" required="" value="<?php echo $tiposervicio;?>"></td>
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


<?php

include '../funct/con_tacnamh_db.php';
include '../funct/functions.php';
include './header.php';

include '../modelo/TipoRadiologiaController.php';

$objTipoRadiologia=new TipoRadiologiaController();
$msg="";

##variables
$tiporadiologia="";

if($_POST)
{
    //Mostrar($_POST);
    if(isset($_POST['tiporadiologia'])){$tiporadiologia= eliminarblancos($_POST['tiporadiologia']);}
    
    $error=0;
    ##validar
    if($tiporadiologia=="")
    {
        $msg="<div class='alert alert-danger alert-dismissable'>"
                . "<button type='button' class='close' data-dismiss='alert' aria-hidden='true'>&times;</button>"
                . "Error! No puede dejar campos vacíos</div>";
        $error++;
    }
    else
    {      
        ##validar que el ruc no exista en la base de datos
        
        $list_p=$objTipoRadiologia->BuscarTipoRadiologia('',$tiporadiologia);
        if(count($list_p)>0)
        {
            $msg="<div class='alert alert-danger alert-dismissable'>"
                . "<button type='button' class='close' data-dismiss='alert' aria-hidden='true'>&times;</button>"
                . "Error! Ya existe un tipo de prueba radiológica registrado con ese nombre: $tiporadiologia</div>"; 
            $error++;
            
        }
        
        if($error==0)
        {
            $affected=$objTipoRadiologia->CrearTipoRadiologia($tiporadiologia);
            if($affected==1)
            {
                
                 $msg="<div class='alert alert-success alert-dismissable'>"
                . "<button type='button' class='close' data-dismiss='alert' aria-hidden='true'>&times;</button>"
                . "Tipo de Prueba Radiológica registrado satisfactoriamente</div>"; 
                 echo "<script>";
                echo "window.location = 'listar_tiporadiologia.php';";
                echo "</script>";
            }
            else
            {
                $msg="<div class='alert alert-danger alert-dismissable'>"
                . "<button type='button' class='close' data-dismiss='alert' aria-hidden='true'>&times;</button>"
                . "Error! No se pudo Insertar el Tipo de Prueba Radiológica</div>"; 
            }
        }
        
    }
    
}
?>

<br>
<section class="about-text">
    <div class="container ">
      
        <div class="col-md-12">
          <h3 class="text-left"><i class="fa fa-area-chart"> Nuevo Grupo de Prueba Radiológica</i></h3>
          <?php 
             echo $msg;
          ?>
          <form name="nuevo_tiporadiologia" method="post" action="creartiporadiologia.php">
              <table class="table table-responsive table-bordered">
                  <tr class="text text-info">
                      <th> Grupo de Prueba Radiológica</th>
                  </tr>
                  <tr>
                      <td><input type="text" name="tiporadiologia" class="form-control" required="" value="<?php echo $tiporadiologia;?>"></td>
                  </tr>
                                    
              </table>
              <div class="text-right">
                  <button class="btn btn-success" type="submit">Registrar</button>
                  <a href='listar_tiporadiologia.php' class="btn btn-danger" type="submit">Cancelar</a>
              </div>
              
          </form>
        </div>
    </div>
</section>


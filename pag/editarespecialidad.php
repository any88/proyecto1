<?php

include '../funct/con_tacnamh_db.php';
include '../funct/functions.php';
include './header.php';

include '../modelo/EspecialidadController.php';

$objEspecialidad=new EspecialidadController();
$espmod=array();
$id_espmod="";
$msg="";

##variables
$nombreespecialidad="";
$esquirurgica="";

if(isset($_GET['nik']))
{
$id_espmod=$_GET['nik'];
$espmod=$objEspecialidad->BuscarEspecialidad($id_espmod, "", "");

    if(count($espmod)>0)
    {
        $nombreespecialidad=$espmod[0]->getNombreespecialidad();
        $esquirurgica=$espmod[0]->getEsquirurgica();
    }
}
if($_POST)
{
    //Mostrar($_POST);
    if(isset($_POST['id_espmod'])){$id_espmod= eliminarblancos($_POST['id_espmod']);}
    if(isset($_POST['nombreespecialidad'])){$nombreespecialidad= eliminarblancos($_POST['nombreespecialidad']);}
    if(isset($_POST['esquirurgica'])){$esquirurgica= eliminarblancos($_POST['esquirurgica']);}

    $error=0;
    ##validar
    
    if($nombreespecialidad=="" || $esquirurgica=="")
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
            $affected=$objEspecialidad->ModificarEspecialidad($id_espmod, $nombreespecialidad, $esquirurgica);
            if($affected==1)
            {
                $msg="<div class='alert alert-success alert-dismissable'>"
                . "<button type='button' class='close' data-dismiss='alert' aria-hidden='true'>&times;</button>"
                . "Datos actualizados satisfactoriamente</div>"; 
                echo "<script>";
                echo "window.location = 'listar_especialidades.php';";
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
          <h3 class="text-left"><i class="glyphicon glyphicon-star"> Editar Especialidad</i></h3>
          <?php 
             echo $msg;
          ?>
          <form name="editar_especialidad" method="post" action="editarespecialidad.php">
              <table class="table table-responsive table-bordered">
                  <tr class="text text-info">
                      <th> Nombre</th>
                      <th> Procedimientos Quirúrgicos</th>
                  </tr>
                  <tr >
                      <input type="hidden" name="id_espmod" value="<?php echo $id_espmod; ?>">
                      <td><input type="text" name="nombreespecialidad" class="form-control" required="" value="<?php echo $nombreespecialidad;?>"></td>
                      <td>
                          <select name="esquirurgica" class="form-control">
                              <?php 
                              $selecteds="";
                              $selectedn="";
                              
                                    if($esquirurgica=="s"){$selecteds="selected='selected'";}
                                    else {$selectedn="selected='selected'";}
                              ?>
                              <option value='s' <?php echo $selecteds;?> >Sí</option>
                              <option value='n' <?php echo $selectedn;?> >No</option>
                          </select>
                      </td>
                  </tr>
                                    
              </table>
              <div class="text-right">
                  <button class="btn btn-success" type="submit">Registrar</button>
                  <a href='listar_especialidades.php' class="btn btn-danger" type="submit">Cancelar</a>
              </div>
              
          </form>
        </div>
    </div>
</section>

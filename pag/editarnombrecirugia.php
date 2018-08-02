<?php

include '../funct/con_tacnamh_db.php';
include '../funct/functions.php';
include './header.php';

include '../modelo/NombreCirugiaController.php';
include '../modelo/EspecialidadController.php';

$objNombreCirugia= new NombreCirugiaController();
$objEspecialidad= new EspecialidadController();
$lista_especialidades = $objEspecialidad->MostrarEspecialidad();
$cirmod=array();
$id_cirmod="";
$msg="";

##variables
$nombrecirugia="";
$idespecialidad="";

if(isset($_GET['nik']))
{
$id_cirmod=$_GET['nik'];
$cirmod=$objNombreCirugia->BuscarNombreCirugia($id_cirmod, "", "");

    if(count($cirmod)>0)
    {
        $nombrecirugia=$cirmod[0]->getNombreCirugia();
        $idespecialidad=$cirmod[0]->getIdEspecialidad();
    }
}
if($_POST)
{
    //Mostrar($_POST);
    if(isset($_POST['id_cirmod'])){$id_cirmod= eliminarblancos($_POST['id_cirmod']);}
    if(isset($_POST['nombrecirugia'])){$nombrecirugia= eliminarblancos($_POST['nombrecirugia']);}
    if(isset($_POST['idespecialidad'])){$idespecialidad= eliminarblancos($_POST['idespecialidad']);}

    $error=0;
    ##validar
    
    if($nombrecirugia=="" || $idespecialidad=="")
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
            $affected=$objNombreCirugia->ModificarNombreCirugia($id_cirmod, $nombrecirugia, $idespecialidad);
            if($affected==1)
            {
                $msg="<div class='alert alert-success alert-dismissable'>"
                . "<button type='button' class='close' data-dismiss='alert' aria-hidden='true'>&times;</button>"
                . "Datos actualizados satisfactoriamente</div>"; 
                echo "<script>";
                echo "window.location = 'listar_nombrecirugia.php';";
                echo "</script>";
            }
            else
            {
                $msg="<div class='alert alert-danger alert-dismissable'>"
                . "<button type='button' class='close' data-dismiss='alert' aria-hidden='true'>&times;</button>"
                . "Error! Actualización de datos fallida</div>"; 
            }
        }
        
    }
  
}

?>

<br>
<section class="about-text">
    <div class="container ">
      
        <div class="col-md-12">
          <h3 class="text-left"><i class="fa fa-hand-scissors-o"> Editar Cirugía</i></h3>
          <?php 
             echo $msg;
          ?>
          <form name="editar_nombrecirugia" method="post" action="editarnombrecirugia.php">
              <table class="table table-responsive table-bordered">
                  <tr class="text text-info">
                      <th> Nombre</th>
                      <th> Especialidad</th>
                  </tr>
                  <tr>
                      <input type="hidden" name="id_cirmod" value="<?php echo $id_cirmod; ?>">
                      <td><input type="text" name="nombrecirugia" class="form-control" required="" value="<?php echo $nombrecirugia;?>"></td>
                      <td>
                          <select name="idespecialidad" class="form-control">
                              <option value=''>--SELECCIONE--</option>
                              <?php 
                            for ($i = 0; $i < count($lista_especialidades); $i++) 
                            {
                               $id_especialidad=$lista_especialidades[$i]->getIdEspecialidad();
                               $nombreespecialidad=$lista_especialidades[$i]->getNombreespecialidad();
                               $marcar="";
                               if($id_especialidad==$idespecialidad){$marcar="selected='selected'";}
                               echo "<option value='$id_especialidad' $marcar>$nombreespecialidad</option>";
                            }
                              ?>
                          </select>
                      </td>
                  </tr>
                                    
              </table>
              <div class="text-right">
                  <button class="btn btn-success" type="submit">Registrar</button>
                  <a href='listar_nombrecirugia.php' class="btn btn-danger" type="submit">Cancelar</a>
              </div>
              
          </form>
        </div>
    </div>
</section>


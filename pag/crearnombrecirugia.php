<?php

include '../funct/con_tacnamh_db.php';
include '../funct/functions.php';
include './header.php';

include '../modelo/NombreCirugiaController.php';
include '../modelo/EspecialidadController.php';

$objNombreCirugia= new NombreCirugiaController();
$objEspecialidad=new EspecialidadController();
$list_especialidades=$objEspecialidad->MostrarEspecialidad();
$msg="";

##variables
$nombrecirugia="";
$idespecialidad="";

if($_POST)
{
    //Mostrar($_POST);
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
        ##validar que la especialidad no exista en la base de datos
        
        $list_p=$objNombreCirugia->BuscarNombreCirugia('', $nombrecirugia, '');
        if(count($list_p)>0)
        {
            $msg="<div class='alert alert-danger alert-dismissable'>"
                . "<button type='button' class='close' data-dismiss='alert' aria-hidden='true'>&times;</button>"
                . "Error! Ya existe una cirugía registrada con ese nombre: $nombrecirugia</div>"; 
            $error++;
            
        }
        
        if($error==0)
        {
            $affected=$objNombreCirugia->CrearNombreCirugia($nombrecirugia, $idespecialidad);
            if($affected==1)
            {
                
                 $msg="<div class='alert alert-success alert-dismissable'>"
                . "<button type='button' class='close' data-dismiss='alert' aria-hidden='true'>&times;</button>"
                . "Especialidad registrada satisfactoriamente</div>"; 
                 echo "<script>";
                echo "window.location = 'listar_nombrecirugia.php';";
                echo "</script>";
            }
            else
            {
                $msg="<div class='alert alert-danger alert-dismissable'>"
                . "<button type='button' class='close' data-dismiss='alert' aria-hidden='true'>&times;</button>"
                . "Error! No se pudo Insertar la Cirugía</div>"; 
            }
        }
        
    }
    
}
?>

<br>
<section class="about-text">
    <div class="container ">
      
        <div class="col-md-12">
          <h3 class="text-left"><i class="fa fa-hand-scissors-o"> Nueva Cirugía</i></h3>
          <?php 
             echo $msg;
          ?>
          <form name="nueva_cirugia" method="post" action="crearnombrecirugia.php">
              <table class="table table-responsive table-bordered">
                  <tr class="text text-info">
                      <th> Nombre</th>
                      <th> Especialidad</th>
                  </tr>
                  <tr >
                      <td><input type="text" name="nombrecirugia" class="form-control" required="" value="<?php echo $nombrecirugia;?>"></td>
                      <td>
                          <select name="idespecialidad" class="form-control">
                              <option value=''>--SELECCIONE--</option>
                              <?php
                            for ($i = 0; $i < count($list_especialidades); $i++) 
                            {
                               $id_especialidad=$list_especialidades[$i]->getIdEspecialidad();
                               $nombre=$list_especialidades[$i]->getNombreespecialidad();
                               $marcar="";
                               if($id_especialidad==$idespecialidad){$marcar="selected='selected'";}
                               echo "<option value='$id_especialidad' $marcar>$nombre</option>";
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


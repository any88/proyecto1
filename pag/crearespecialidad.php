<?php

include '../funct/con_tacnamh_db.php';
include '../funct/functions.php';
include './header.php';

include '../modelo/EspecialidadController.php';

$objEspecialidad=new EspecialidadController();
$msg="";

##variables
$nombreespecialidad="";
$esquirurgica="";

if($_POST)
{
    //Mostrar($_POST);
    if(isset($_POST['nombreespecialidad'])){$nombreespecialidad= eliminarblancos($_POST['nombreespecialidad']);}  
    if(isset($_POST['esquirurgica'])){$esquirurgica= eliminarblancos($_POST['esquirurgica']);}  
    
    $error=0;
    ##validar
    if($nombreespecialidad=="" || $esquirurgica="")
    {
        $msg="<div class='alert alert-danger alert-dismissable'>"
                . "<button type='button' class='close' data-dismiss='alert' aria-hidden='true'>&times;</button>"
                . "Error! No puede dejar campos vacíos</div>";
        $error++;
    }
    else
    {      
        ##validar que la especialidad no exista en la base de datos
        
        $list_p=$objEspecialidad->BuscarEspecialidad('', $nombreespecialidad, '');
        if(count($list_p)>0)
        {
            $msg="<div class='alert alert-danger alert-dismissable'>"
                . "<button type='button' class='close' data-dismiss='alert' aria-hidden='true'>&times;</button>"
                . "Error! Ya existe una especialidad registrada con ese nombre: $nombreespecialidad</div>"; 
            $error++;
            
        }
        
        if($error==0)
        {
            $affected=$objEspecialidad->CrearEspecialidad($nombreespecialidad, $esquirurgica);
            if($affected==1)
            {
                
                 $msg="<div class='alert alert-success alert-dismissable'>"
                . "<button type='button' class='close' data-dismiss='alert' aria-hidden='true'>&times;</button>"
                . "Especialidad registrada satisfactoriamente</div>"; 
                 echo "<script>";
                echo "window.location = 'listar_especialidades.php';";
                echo "</script>";
            }
            else
            {
                $msg="<div class='alert alert-danger alert-dismissable'>"
                . "<button type='button' class='close' data-dismiss='alert' aria-hidden='true'>&times;</button>"
                . "Error! No se pudo Insertar la Especialidad</div>"; 
            }
        }
        
    }
    
}
?>

<br>
<section class="about-text">
    <div class="container ">
      
        <div class="col-md-12">
          <h3 class="text-left"><i class="glyphicon glyphicon-star"> Nueva Especialidad</i></h3>
          <?php 
             echo $msg;
          ?>
          <form name="nueva_especialidad" method="post" action="crearespecialidad.php">
              <table class="table table-responsive table-bordered">
                  <tr class="text text-info">
                      <th> Nombre</th>
                      <th> Procedimientos Quirúrgicos</th>
                  </tr>
                  <tr >
                      <td><input type="text" name="nombreespecialidad" class="form-control" required="" value="<?php echo $nombreespecialidad;?>"></td>
                      <td>
                          <select name="esquirurgica" class="form-control">
                              <option value=''>--SELECCIONE--</option>
                              <option value='s'> Sí</option>
                              <option value='n'> No</option>
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


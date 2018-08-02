<?php

include '../funct/con_tacnamh_db.php';
include '../funct/functions.php';
include './header.php';

include '../modelo/CargoController.php';
include '../modelo/TrabajadorController.php';

$objCargo=new CargoController();
$lista_cargos=$objCargo->MostrarCargo();
$msg="";
$objTrabajador=new TrabajadorController();

##variables
$nombre="";
$docID="";
$fecha_nac="";
$sexo="";
$telefono="";
$email="";
$direccion="";
$cargo="";
$salario="";
if($_POST)
{
    //Mostrar($_POST);
    if(isset($_POST['nombre'])){$nombre= eliminarblancos($_POST['nombre']);}
    if(isset($_POST['docID'])){$docID=eliminarblancos($_POST['docID']);}
    if(isset($_POST['fecha_nac'])){$fecha_nac=eliminarblancos($_POST['fecha_nac']);}
    if(isset($_POST['sexo'])){$sexo=eliminarblancos($_POST['sexo']);}
    if(isset($_POST['telefono'])){$telefono=eliminarblancos($_POST['telefono']);}
    if(isset($_POST['email'])){$email=eliminarblancos($_POST['email']);}
    if(isset($_POST['direccion'])){$direccion=eliminarblancos($_POST['direccion']);}
    if(isset($_POST['cargo'])){$cargo=eliminarblancos($_POST['cargo']);}
    if(isset($_POST['salario'])){$salario=eliminarblancos($_POST['salario']);}
    
    $error=0;
    ##validar
    if($nombre=="" || $docID=="" || $telefono=="" || $fecha_nac=="" || $cargo=="" || $direccion=="")
    {
        $msg="<div class='alert alert-danger alert-dismissable'>"
                . "<button type='button' class='close' data-dismiss='alert' aria-hidden='true'>&times;</button>"
                . "Error! No puede dejar campos vacíos</div>";
        $error++;
    }
    else
    {
        if(isNaN($telefono))
        {
           $msg="<div class='alert alert-danger alert-dismissable'>"
                . "<button type='button' class='close' data-dismiss='alert' aria-hidden='true'>&times;</button>"
                . "Error! El campo tel&eacute;fono solo admite n&uacute;meros</div>"; 
           $error++;
        }
        
        ##validar que el trabajador no exista en la base de datos
        
        $list_p=$objTrabajador->BuscarTrabajador('', '', $docID);
        if(count($list_p)>0)
        {
            $msg="<div class='alert alert-danger alert-dismissable'>"
                . "<button type='button' class='close' data-dismiss='alert' aria-hidden='true'>&times;</button>"
                . "Error! Ya existe un trabajador registrado con documento de identidad igual: $docID</div>"; 
            $error++;
            
        }
        
        
        if($error==0)
        {
            $affected=$objTrabajador->CrearTrabajador($docID, $nombre, $fecha_nac, $sexo, $telefono, $email, $direccion, $cargo, $salario);
            if($affected==1)
            {
                
                 $msg="<div class='alert alert-success alert-dismissable'>"
                . "<button type='button' class='close' data-dismiss='alert' aria-hidden='true'>&times;</button>"
                . "Trabajador registrado satisfactoriamente</div>"; 
                 echo "<script>";
                echo "window.location = 'listar_trabajadores.php';";
                echo "</script>";
            }
            else
            {
                $msg="<div class='alert alert-danger alert-dismissable'>"
                . "<button type='button' class='close' data-dismiss='alert' aria-hidden='true'>&times;</button>"
                . "Error! No se pudo Insertar el Trabajador</div>"; 
            }
        }
        
    }
    
}
?>

<br>
<section class="about-text">
    <div class="container ">
      
        <div class="col-md-12">
          <h3 class="text-left"><i class="fa fa-user text-info"> Nuevo Trabajador</i></h3>
          <?php 
             echo $msg;
          ?>
          <form name="nuevo_trabajador" method="post" action="creartrabajador.php">
              <table class="table table-responsive table-bordered">
                  <tr class="text text-info">
                      <th> Nombre</th>
                      <th> Doc.Identidad</th>
                      <th> Fecha Nac.</th>
                  </tr>
                  <tr >
                      <td><input type="text" name="nombre" placeholder="Nombre(s) Apellido1 Apellido2" class="form-control" required="" value="<?php echo $nombre;?>"></td>
                      <td><input type="text" name="docID" class="form-control" required="" value="<?php echo $docID;?>"></td>
                      <td><input type="date" name="fecha_nac" class="form-control" value="<?php echo $fecha_nac;?>"></td>
                  </tr>
                  <tr class="text text-info">
                      <th>Sexo</th>
                      <th>Teléfono</th>
                      <th >Email</th>
                  </tr>
                  <tr>
                      <td>
                          <select name="sexo" class="form-control">
                              <?php 
                              $selectedf="";
                              $selectedm="";
                              
                                    if($sexo=="F"){$selectedf="selected='selected'";}
                                    else {$selectedm="selected='selected'";}
                              ?>
                              <option value='F' <?php echo $selectedf;?> >F</option>
                              <option value='M' <?php echo $selectedf;?>>M</option>
                          </select>
                      </td>
                      <td><input type="text" name='telefono' class="form-control" value='<?php echo $telefono;?>'></td>
                      <td><input type="email" name="email" class="form-control" value='<?php echo $email;?>'></td>
                  </tr>
                  <tr class="text text-info">
                      <th>Direcci&oacute;n</th>
                      <th>Cargo</th>
                      <th>Salario</th>
                  </tr>
                  <tr>
                      <td >
                          <textarea class="form-control" name="direccion"><?php echo $direccion;?></textarea>
                      </td>
                      <td>
                          <select name="cargo" class="form-control">
                              <option value=''>--SELECCIONE--</option>
                              <?php 
                            for ($i = 0; $i < count($lista_cargos); $i++) 
                            {
                               $id_cargo=$lista_cargos[$i]->getIdCargo();
                               $nombrecargo=$lista_cargos[$i]->getNombreCargo();
                               $marcar="";
                               if($id_cargo==$cargo){$marcar="selected='selected'";}
                               echo "<option value='$id_cargo' $marcar>$nombrecargo</option>";
                            }
                              ?>
                          </select>
                      </td>
                      <td><input type="text" name="salario" class="form-control" value='<?php echo $salario;?>'></td>
                      
                  </tr>
                                    
              </table>
              <div class="text-right">
                  <button class="btn btn-success" type="submit">Registrar</button>
                  <a href='listar_trabajadores.php' class="btn btn-danger" type="submit">Cancelar</a>
              </div>
              
          </form>
        </div>
    </div>
</section>

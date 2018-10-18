<?php

include '../funct/con_tacnamh_db.php';
include '../funct/functions.php';
include './header.php';

include '../modelo/CargoController.php';
include '../modelo/TrabajadorController.php';

$msg="";
$objCargo=new CargoController();
$lista_cargos=$objCargo->MostrarCargo();
$objTrabajador=new TrabajadorController();

if(isset($_REQUEST['nik']))
    {
    $id_trabmod=$_REQUEST['nik'];
    $trabmod=$objTrabajador->BuscarTrabajador($id_trabmod, "", "");
    }
    
##variables
$nombre="";
$docID="";
$fecha_nac="";
if(isset($trabmod))
{
    $sexo=$trabmod[0]->getSexo();
    $cargo=$trabmod[0]->getCargo();
}
else
{
    $sexo="";
    $cargo="";
}
$telefono="";
$email="";
$direccion="";
$salario="";

?>

<br>
<section class="about-text">
    <div class="container ">
      
        <div class="col-md-12">
          <h3 class="text-left"><i class="fa fa-user text-info"> Mostrar Trabajador</i></h3>
          <?php 
             echo $msg;
          ?>
          <form name="mostrar_trabajador">
              <table class="table table-responsive table-bordered">
                  <tr class="text text-info">
                      <th> Nombre</th>
                      <th> Doc.Identidad</th>
                      <th> Fecha Nac.</th>
                  </tr>
                  <tr> 
                      <input type="hidden" name="id_trabmod" value="<?php echo $id_trabmod; ?>">
                      <td><?php echo $trabmod[0]->getNombre();?></td>
                      <td><?php echo $trabmod[0]->getDocID();?></td>
                      <td><?php echo $trabmod[0]->getFechaNac();?></td>
                  </tr>
                  <tr class="text text-info">
                      <th>Sexo</th>
                      <th>Teléfono</th>
                      <th >Email</th>
                  </tr>
                  <tr>
                      <td><?php echo $trabmod[0]->getSexo(); ?></td>
                      <td><?php echo $trabmod[0]->getTelef();?></td>
                      <td><?php echo $trabmod[0]->getEmail();?></td>
                  </tr>
                  <tr class="text text-info">
                      <th>Direcci&oacute;n</th>
                      <th>Cargo</th>
                      <th>Salario</th>
                  </tr>
                  <tr>
                      <td ><?php echo $trabmod[0]->getDireccion();?></td>
                      <td>
                          <?php 
                            $id_cargo=$trabmod[0]->getCargo();
                            for ($i = 0; $i < count($lista_cargos); $i++) 
                            {
                               if($id_cargo==$lista_cargos[$i]->getIdCargo())
                               echo $lista_cargos[$i]->getNombreCargo();
                            }
                              ?>    
                      </td>
                      <td><?php echo $trabmod[0]->getSalario();?></td>
                  </tr>             
              </table>
              <div class="text-right">
                  <?php $link_edit="editartrabajador.php";?>
                  <a href=# class="btn btn-primary" type="submit">Imprimir</a>
                  <?php echo '<a href='.$link_edit.'?nik='.$id_trabmod.' class="btn btn-success" type="submit">Editar</a>'?>
                  <a href='listar_medicos.php' class="btn btn-danger" type="submit">Volver</a>
              </div>
              
          </form>
        </div>
    </div>
</section>
<?php include './footer.html'; ?>

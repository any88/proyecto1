<?php

include '../funct/con_tacnamh_db.php';
include '../funct/functions.php';
include './header.php';

include '../modelo/MedicoController.php';
include '../modelo/EspecialidadController.php';

$msg="";
$objMedico=new MedicoController();
$objEspecialidad= new EspecialidadController();
$lista_especialidades=$objEspecialidad->MostrarEspecialidad();

if(isset($_REQUEST['nik']))
    {
    $id_medmod=$_REQUEST['nik'];
    $medmod=$objMedico->BuscarMedico($id_medmod, "", "");
    }

##variables
$nombre_medico="";
$docID="";
$nrocolegiomedico="";
$fecha_nac="";
if(isset($medmod))
{
    $sexo=$medmod[0]->getSexo();
    $idespecialidad=$medmod[0]->getEspecialidad();
}
else
{
    $sexo="";
    $idespecialidad="";
}
$telefono="";
$email="";
$direccion="";

?>

<br>
<section class="about-text">
    <div class="container ">
      
        <div class="col-md-12">
          
          <div class="panel panel-default">
              <div class="panel-heading">
                  <b class="text-left"><i class="fa fa-user-md text-info"> MOSTRAR MEDICO</i></b>
                  
              </div>
              <div class="panel-body">
                  
                  <form name="mostrar_medico">
                    <table class="table table-responsive table-bordered">
                        <tr class="text text-info">
                            <th> Nombre</th>
                            <th> Doc.Identidad</th>
                            <th> Num. Colegio Médico</th>
                        </tr>
                        <tr >
                            <input type="hidden" name="id_medmod" value="<?php echo $id_medmod; ?>">
                            <td><?php echo $medmod[0]->getNombre();?></td>
                            <td><?php echo $medmod[0]->getDocID();?></td>
                            <td><?php echo $medmod[0]->getNroColegioMed();?></td>
                        </tr>
                        <tr class="text text-info">
                            <th >Fecha Nac.</th>
                            <th>Sexo</th>
                            <th>Teléfono</th>
                        </tr>
                        <tr>
                            <td><?php echo $medmod[0]->getFechaNac();?></td>
                            <td><?php echo $medmod[0]->getSexo();?></td>
                            <td><?php echo $medmod[0]->getTelef();?></td>
                        </tr>
                        <tr class="text text-info">
                            <th>Email</th>
                            <th >Direcci&oacute;n</th>
                            <th>Especialidad</th>
                        </tr>
                        <tr>
                            <td><?php echo $medmod[0]->getEmail();?></td>
                            <td ><?php echo $medmod[0]->getDireccion();?></td>
                            <td>
                                     <?php 
                                  $id_especialidad=$medmod[0]->getEspecialidad();
                                  for ($i = 0; $i < count($lista_especialidades); $i++) 
                                  {
                                     if($id_especialidad==$lista_especialidades[$i]->getIdEspecialidad())
                                     echo $lista_especialidades[$i]->getNombreespecialidad();
                                  }
                                    ?>
                            </td>
                        </tr>

                    </table>
                    <div class="text-right">
                        <?php $link_edit="editarmedico.php";?>
                        
                        <?php echo "<a href='$link_edit?nik=$id_medmod' class='btn btn-primary' type='submit'> <i class='fa fa-edit'></i> Editar</a>"?>
                        <a href='listar_medicos.php' class="btn btn-primary" type="submit"> <i class="fa fa-close"></i> Volver</a>
                    </div>

                </form>
              </div>
          </div>
          
        </div>
    </div>
</section>


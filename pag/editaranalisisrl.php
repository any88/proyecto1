<?php

// EN DESARROLLO!!! VER COMENTARIOS PARA MAS INFO..

include '../funct/con_tacnamh_db.php';
include '../funct/functions.php';
include './header.php';

include '../modelo/LaboratorioController.php';
include '../modelo/TipoAnalisisLaboratorioController.php';
include '../modelo/NombreAnalisisLaboratorioController.php';

$msg="";
$objLaboratorio=new LaboratorioController();
$objTipoAnalisisLab= new TipoAnalisisLaboratorioController();
$objNombreAnalisis= new NombreAnalisisLaboratorioController();
$lista_laboratorio= $objLaboratorio->MostrarLaboratorio();
$lista_tipoanalisislab=$objTipoAnalisisLab->MostrarTipoAnalisisLaboratorio();
$lista_nombreanalisis=$objNombreAnalisis->MostrarNombreAnalisis();

if(isset($_REQUEST['nik']))
    {
    $id_labmod=$_REQUEST['nik'];
    $labmod=$objLaboratorio->BuscarLaboratorio($id_labmod, "", "");
    }
if(isset($_POST['id_labmod']))
    {
    $id_labmod=$_POST['id_labmod'];
    } 

##variables
$idtipo="";
$idnombre="";
$fecha="";
$precio="";
$resultados="";

if(isset($labmod))
{
    $idtipo=$labmod[0]->getIdTipoAnalisisLaboratorio();
    $idnombre=$labmod[0]->getNombre();
    //capturar bien la fecha
    $fecha="";
    $resultados= $labmod[0]->getResultados();
    $precio= $labmod[0]->getPrecio();
}

if($_POST)
{
    //Mostrar($_POST);
    if(isset($_POST['id_labmod'])){$id_labmod= eliminarblancos($_POST['id_labmod']);}
    if(isset($_POST['idtipo'])){$idtipo=eliminarblancos($_POST['idtipo']);}
    if(isset($_POST['idnombre'])){$idnombre= eliminarblancos($_POST['idnombre']);}
    if(isset($_POST['fecha'])){$fecha=eliminarblancos($_POST['fecha']);}
    if(isset($_POST['resultados'])){$resultados=eliminarblancos($_POST['resultados']);}
    if(isset($_POST['precio'])){$precio=eliminarblancos($_POST['precio']);}
            
    $error=0;
    ##validar
    
    if($idtipo=="" || $idnombre=="" || $fecha=="" || $precio=="")
    {
        $msg="<div class='alert alert-danger alert-dismissable'>"
                . "<button type='button' class='close' data-dismiss='alert' aria-hidden='true'>&times;</button>"
                . "Error! No puede dejar campos vacíos</div>";
        $error++;
    }
               
    if($error==0)
        {
            $affected=$objLaboratorio->ModificarLaboratorio($id_labmod, $idtipo, $idnombre, $precio, $resultados);
            // $affected2 es para comprobar la fecha, se necesita crear clase de referencia
            $affected2="";
            if($affected==1 && $affected2==1)
            {
                
                 $msg="<div class='alert alert-success alert-dismissable'>"
                . "<button type='button' class='close' data-dismiss='alert' aria-hidden='true'>&times;</button>"
                . "Datos actualizados satisfactoriamente</div>"; 
                echo "<script>";
                // aqui se debe construir con variables el enlace de retorno (la pag con los servs del paciente
                // seleccionado)
                echo "window.location = 'listar_pacientes.php';";
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
    

?>

<br>
<section class="about-text">
    <div class="container ">
      
        <div class="col-md-12">
          <h3 class="text-left"><i class="fa fa-flask"> Editar Análisis</i></h3>
          <?php 
             echo $msg;
          ?>
          <form name="editar_analisis" method="post" action="editaranalisisrl.php">
              <table class="table table-responsive table-bordered">
                  <tr class="text text-info">
                      <th> Tipo de Análisis</th>
                      <th> Nombre del Análisis</th>
                      <th> Fecha</th>
                  </tr>
                  <tr >
                      <input type="hidden" name="id_labmod" value="<?php echo $id_labmod; ?>">
                      <td>
                          <select name="idtipo" class="form-control">
                              <option value=''>--SELECCIONE--</option>
                              <?php 
                            for ($i = 0; $i < count($lista_tipoanalisislab); $i++) 
                            {
                               $id_tipo=$lista_tipoanalisislab[$i]->getIdTipoAnalisisLaboratorio();
                               $nombre=$lista_tipoanalisislab[$i]->getTipoAnalisis();
                               $marcar="";
                               if($id_tipo==$idtipo){$marcar="selected='selected'";}
                               echo "<option value='$id_tipo' $marcar>$nombre</option>";
                            }
                              ?>
                          </select>
                      </td>
                      <td>
                          <select name="idnombre" class="form-control">
                              <option value=''>--SELECCIONE--</option>
                              <?php 
                            for ($i = 0; $i < count($lista_nombreanalisis); $i++) 
                            {
                               $id_nombreanalisis=$lista_nombreanalisis[$i]->getIdnombreanalisis();
                               $nombre=$lista_nombreanalisis[$i]->getNombreanalisis();
                               $marcar="";
                               if($id_nombreanalisis==$idnombre){$marcar="selected='selected'";}
                               echo "<option value='$id_nombreanalisis' $marcar>$nombre</option>";
                            }
                              ?>
                          </select>
                      </td>
                      <td><input type="date" name="fecha" class="form-control" value="<?php echo $fecha;?>"></td>
                  </tr>
                  <tr class="text text-info">
                      <th> Resultados</th>
                      <th> Precio</th>
                  </tr>
                  <tr>                    
                      <!-- Recordar que "resultados" guarda imagenes, realizar los ajustes para el caso-->
                      <td><input type="text" name="resultados" class="form-control" value="<?php echo $resultados;?>"></td>
                      <td><input type="text" name='precio' class="form-control" value="<?php echo $precio;?>"></td>
                  </tr>                                                     
              </table>
              <div class="text-right">
                  <button class="btn btn-success" type="submit">Actualizar</button>
                  <!-- aqui se debe construir con variables el enlace de retorno (la pag con los servs del 
                  paciente seleccionado) -->
                  <a href='listar_pacientes.php' class="btn btn-danger" type="submit">Cancelar</a>
              </div>
              
          </form>
        </div>
    </div>
</section>


<?php

// EN DESARROLLO!!! VER COMENTARIOS PARA MAS INFO..

include '../funct/con_tacnamh_db.php';
include '../funct/functions.php';
include './header.php';

include '../modelo/RadiologiaController.php';
include '../modelo/TipoRadiologiaController.php';
include '../modelo/NombreRadiologiaController.php';

$msg="";
$objRadiologia=new RadiologiaController();
$objTipoRadiologia= new TipoRadiologiaController();
$objNombreRadiologia= new NombreRadiologiaController();
$lista_radiologia= $objRadiologia->MostrarRadiologia();
$lista_tiporadiologia=$objTipoRadiologia->MostrarTipoRadiologia();
$lista_nombreradiologia=$objNombreRadiologia->MostrarNombreRadiologia();

if(isset($_REQUEST['nik']))
    {
    $id_radmod=$_REQUEST['nik'];
    $radmod=$objRadiologia->BuscarRadiologia($id_radmod, "", "");
    }
if(isset($_POST['id_radmod']))
    {
    $id_radmod=$_POST['id_radmod'];
    } 

##variables
$idtipo="";
$idnombre="";
$fecha="";
$precio="";
$resultados="";

if(isset($radmod))
{
    $idtipo=$radmod[0]->getIdTipoRadiologia();
    $idnombre=$radmod[0]->getNombre();
    //capturar bien la fecha
    $fecha="";
    $resultados= $radmod[0]->getResultados();
    $precio= $radmod[0]->getPrecio();
}

if($_POST)
{
    //Mostrar($_POST);
    if(isset($_POST['id_radmod'])){$id_radmod= eliminarblancos($_POST['id_radmod']);}
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
            $affected=$objRadiologia->ModificarRadiologia($id_radmod, $idtipo, $idnombre, $resultados, $precio);
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
          <h3 class="text-left"><i class="fa fa-area-chart"> Editar Prueba Radiológica</i></h3>
          <?php 
             echo $msg;
          ?>
          <form name="editar_radiologia" method="post" action="editarradiologiarl.php">
              <table class="table table-responsive table-bordered">
                  <tr class="text text-info">
                      <th> Tipo de Prueba</th>
                      <th> Nombre de la Prueba</th>
                      <th> Fecha</th>
                  </tr>
                  <tr >
                      <input type="hidden" name="id_radmod" value="<?php echo $id_radmod; ?>">
                      <td>
                          <select name="idtipo" class="form-control">
                              <option value=''>--SELECCIONE--</option>
                              <?php 
                            for ($i = 0; $i < count($lista_tiporadiologia); $i++) 
                            {
                               $id_tipo=$lista_tiporadiologia[$i]->getIdTipoRadiologia();
                               $nombre=$lista_tiporadiologia[$i]->getTipoRadiologia();
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
                            for ($i = 0; $i < count($lista_nombreradiologia); $i++) 
                            {
                               $id_nombreradiologia=$lista_nombreradiologia[$i]->getIdnombreradiologia();
                               $nombre=$lista_nombreradiologia[$i]->getNombreradiologia();
                               $marcar="";
                               if($id_nombreradiologia==$idnombre){$marcar="selected='selected'";}
                               echo "<option value='$id_nombreradiologia' $marcar>$nombre</option>";
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

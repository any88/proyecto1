<?php

include '../funct/con_tacnamh_db.php';
include '../funct/functions.php';
include './header.php';

include '../modelo/NombreAnalisisLaboratorioController.php';
include '../modelo/TipoAnalisisLaboratorioController.php';


$objNombreAnalisis=new NombreAnalisisLaboratorioController();
$objTipoAnalisisLab= new TipoAnalisisLaboratorioController();
$lista_tipoanalisislab= $objTipoAnalisisLab->MostrarTipoAnalisisLaboratorio();
$msg="";

##variables
$nombreanalisis="";
$idtipo="";

if($_POST)
{
    Mostrar($_POST);
    if(isset($_POST['nombreanalisis'])){$nombreanalisis= eliminarblancos($_POST['nombreanalisis']);}
    if(isset($_POST['idtipo'])){$idtipo=eliminarblancos($_POST['idtipo']);}
    
    
    $error=0;
    ##validar
    if($nombreanalisis=="" || $idtipo=="")
    {
        $msg="<div class='alert alert-danger alert-dismissable'>"
                . "<button type='button' class='close' data-dismiss='alert' aria-hidden='true'>&times;</button>"
                . "Error! No puede dejar campos vacíos</div>";
        $error++;
    }
    else
    {      
        ##validar que el insumo no exista en la base de datos
        
        $list_p=$objNombreAnalisis->BuscarNombreAnalisis('', $nombreanalisis, '');
        if(count($list_p)>0)
        {
            $msg="<div class='alert alert-danger alert-dismissable'>"
                . "<button type='button' class='close' data-dismiss='alert' aria-hidden='true'>&times;</button>"
                . "Error! Ya existe un analisis registrado con ese nombre: $nombreanalisis</div>"; 
            $error++;
            
        }
        
        if($error==0)
        {
            $affected=$objNombreAnalisis->CrearNombreAnalisis($nombreanalisis, $idtipo);
            if($affected==1)
            {
                
                 $msg="<div class='alert alert-success alert-dismissable'>"
                . "<button type='button' class='close' data-dismiss='alert' aria-hidden='true'>&times;</button>"
                . "Análisis registrado satisfactoriamente</div>"; 
                 echo "<script>";
                echo "window.location = 'listar_analisislaboratorio.php';";
                echo "</script>";
            }
            else
            {
                $msg="<div class='alert alert-danger alert-dismissable'>"
                . "<button type='button' class='close' data-dismiss='alert' aria-hidden='true'>&times;</button>"
                . "Error! No se pudo Insertar el Análisis</div>"; 
            }
        }
        
    }
    
}
?>

<br>
<section class="about-text">
    <div class="container ">
      
        <div class="col-md-12">
          <h3 class="text-left"><i class="fa fa-flask"> Nuevo Análisis de Laboratorio</i></h3>
          <?php 
             echo $msg;
          ?>
          <form name="nuevo_analisis" method="post" action="crearanalisislaboratorio.php">
              <table class="table table-responsive table-bordered">
                  <tr class="text text-info">
                      <th> Nombre</th>
                      <th> Tipo de Análisis</th>
                  </tr>
                  <tr >
                      <td><input type="text" name="nombreanalisis" class="form-control" required="" value="<?php echo $nombreanalisis;?>"></td>
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
                  </tr>
                                    
              </table>
              <div class="text-right">
                  <button class="btn btn-success" type="submit">Registrar</button>
                  <a href='listar_analisislaboratorio.php' class="btn btn-danger" type="submit">Cancelar</a>
              </div>
              
          </form>
        </div>
    </div>
</section>
<?php include './footer.html';?>

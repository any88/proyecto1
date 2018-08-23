<?php
include '../funct/con_tacnamh_db.php';
include '../funct/functions.php';
include './header.php';

include '../modelo/CamaController.php';
$objCamaC=new CamaController();
$p_nro_cama="";
$p_estado=0;
$error=0;
$msg="";
##el nro de cama debe de ser un numero en un rango
$p_nro_cama=$objCamaC->GenerarNroCama();
if($_POST)
{   
    if(isset($_POST['nrocama'])){$p_nro_cama=$_POST['nrocama'];}
    if(isset($_POST['estado'])){$estado=$_POST['estado'];}
    if(eliminarblancos($p_nro_cama)=="")
    {
        $error++;
        $msg="<div class='alert alert-danger alert-dismissable'>"
       . "<button type='button' class='close' data-dismiss='alert' aria-hidden='true'>&times;</button>"
       . "Usted debe de introducir un n&uacute;mero de cama.</div>";
    }
    
    if(isNaN($p_nro_cama))
    {
        $error++;
        $msg="<div class='alert alert-danger alert-dismissable'>"
       . "<button type='button' class='close' data-dismiss='alert' aria-hidden='true'>&times;</button>"
       . "El n&uacute;mero no est&aacute; en el formato correcto.</div>";
    }
    #buscar que no exits otra cama con ese numero
    $listC=$objCamaC->BuscarCama("", $p_nro_cama, "");
    if(count($listC)>0)
    {
        $error++;
        $msg="<div class='alert alert-danger alert-dismissable'>"
       . "<button type='button' class='close' data-dismiss='alert' aria-hidden='true'>&times;</button>"
       . "El n&uacute;mero de cama $p_nro_cama ya est&aacute; asignado.</div>";
    }
    
    if($error==0)
    {
        $aff=$objCamaC->AgregarCama($p_nro_cama, $p_estado);
        if($aff==0)
        {
            $msg="<div class='alert alert-danger alert-dismissable'>"
            . "<button type='button' class='close' data-dismiss='alert' aria-hidden='true'>&times;</button>"
            . "No se pudo a&ntilde;adir la cama...Contacte a su administrador.</div>";
        }
        else
        {
            echo "<script>";
                echo "window.location = 'listar_camas.php';";
           echo "</script>";

        }
    }
}
?>
<br><br>
<section class="about-text">
    <div class="container ">
        <div class="col-md-12">
          <h3 class="text-left"><i class="fa fa-bed text-info"> Nueva Cama para Hospitalizaci&oacute;n</i></h3>
          <?php 
          if($msg!=""){echo $msg;}
          ?>
          <form name='f' method="post" action="nueva_cama.php">
              <table class="table table-responsive">
              <thead>
                  <tr>
                      <th>Nro. de Cama</th>
                      <th>Estado</th>
                  </tr>
              </thead>
              <tbody>
                  <tr>
                      <td>
                          <input type="number" name="nrocama" min="1" max="1000" value='<?php echo $p_nro_cama;?>' class="form-control">
                      </td>
                      <td>
                          <select class="form-control" name='estado'>
                              <?PHP 
                                if($p_estado==0){ echo "<option value='0' selected='selected'> DISPONIBLE</option>";}
                                else {echo "<option value='0'> DISPONIBLE</option>";}
                                if($p_estado==1){ echo "<option value='1' selected='selected'> OCUPADO</option>";}
                                else {echo "<option value='1'> OCUPADO</option>";}
                              ?>
                          </select>
                      </td>
                      
                  </tr>
              </tbody>
          </table>
              <div class="pull-right">
               <button type="submit" class="btn btn-success">Agregar Cama</button>
               <a href="listar_camas.php" class="btn btn-danger">Cancelar</a>
            </div>
          </form>
          
        </div>
    </div>
</section>



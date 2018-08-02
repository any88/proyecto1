<?php
include '../../funct/con_tacnamh_db.php';
include '../../funct/functions.php';
include '../../modelo/consultas_genericas.php';
include "../session_header.php";
include './header.php';

$cg=new ConsultasG();
$p_nombre_user="";
$p_user="";
$p_pass="";
$p_id_rol="";
$msg="";
$error=0;
if($_POST)
{
    
    if(isset($_POST['nombre_user'])){$p_nombre_user=$_POST['nombre_user'];}
    if(isset($_POST['user_u'])){$p_user=$_POST['user_u'];}
    if(isset($_POST['pass'])){$p_pass=$_POST['pass'];}
    if(isset($_POST['rol'])){$p_id_rol=$_POST['rol'];}
    
    ##validar datos vacios
    if(eliminarblancos($p_nombre_user)==""  || eliminarblancos($p_user)=="" || eliminarblancos($p_pass)=="" || eliminarblancos($p_id_rol)=="")
    {
       $msg="<div class='alert alert-danger alert-dismissable'><button type='button' class='close' data-dismiss='alert' aria-hidden='true'>&times;</button>Error! No puede dejar campos vacíos</div>";
       $error++;
    }
    
    ##validar que el usuario sea unico
    $p=array();
    $p["campo"][0]='usuario';
    $p["valor"][0]=$p_user;
    $r=$cg->GenericSelect('usuario', $p);
    if($r)
    {
        $lista_user=$cg->ArregloAsociativoSelect($r, 'usuario');
        if(count($lista_user)>0)
        {
            $error++;
            $msg="<div class='alert alert-danger alert-dismissable'><button type='button' class='close' data-dismiss='alert' aria-hidden='true'>&times;</button>Error! El usuario $p_user ya existe en la base de datos</div>";
        }
    }
    if($error==0)
    {
        ##insertar el usuario
        $p=array();
        $a=0;
        $p["campo"][$a]='nombre';
        $p["valor"][$a]=$p_nombre_user;
        $a++;
        $p["campo"][$a]='usuario';
        $p["valor"][$a]=$p_user;
        $a++;
        $md5_pass= md5($p_pass);
        $p["campo"][$a]='password';
        $p["valor"][$a]=$md5_pass;
        $a++;
        $p["campo"][$a]='id_rol';
        $p["valor"][$a]=$p_id_rol;
        
        $affected=$cg->GenericInsert('usuario', $p);
        if($affected==1)
            {
                $msg="<div class='alert alert-success alert-dismissable'><button type='button' class='close' data-dismiss='alert' aria-hidden='true'>&times;</button>OK! El usuario $p_user ha sido insertado correctamente en la base de datos</div>";
                $_SESSION['msg_user']=$msg;
                echo "<script>";
                echo "window.location = 'index_admin.php';";
                echo "</script>";
            }
        else 
            {
             $msg="<div class='alert alert-danger alert-dismissable'><button type='button' class='close' data-dismiss='alert' aria-hidden='true'>&times;</button>Error! No se pudieron insertar los datos en la base de datos.</div>";
            }
        
    }
}

$lista_roles=$cg->Distint('rol', 'nombre', 'id_rol');

?>
<br><br>
<section class="about-text">
    <div class="container ">
      
        <div class="col-md-12">
          <h3 class="text-left">Nuevo Usuario</h3>
          <?php 
            if($msg!=""){echo $msg;}
          ?>
          <div class="col-md-8">
              <form name="new_user" method="post" action="usuarios_add.php">
              <table class="table table-responsive">
                  <tr>
                      <th rowspan="4"><img src="img/user_icons_medic.jpg" title="usuarios"></th>
                      <th>Nombre <input type="text" placeholder="Nombre" name="nombre_user" class="form-control"></th>
                      
                  </tr>
                  <tr>
                      <th>Usuario <input type="text" placeholder="Usuario" name="user_u" class="form-control"></th>
                      
                  </tr>
                  <tr><th>Contrase&ntilde;a <input type="password" name="pass" class="form-control"></th></tr>
                  <tr><th>Rol
                          <select name="rol" class="form-control">
                              <option value="">--SELECCIONE--</option>
                              <?php 
                              for ($i = 0; $i < count($lista_roles); $i++) 
                              {
                                 $id_rol=$lista_roles[$i]['id_rol'];
                                 $nombre_rol=$lista_roles[$i]['nombre'];
                                 if($nombre_rol!=""){}$nombre_rol= strtoupper($nombre_rol);
                                 $selected="";
                                 
                                 if($id_rol==$p_id_rol){$selected="selected='selected'";}
                                 echo " <option value='$id_rol' $selected>$nombre_rol</option>";
                              }
                              ?>
                          </select>
                      
                      </th></tr>
                  <tr>
                      <td colspan="2">
                        <div class="text-right">
                            <a href="" class="btn btn-danger">Cancelar</a> 
                            <button type="submit" class="btn btn-success">Crear Usuario</button>
                        </div>
                      </td>
                  </tr>
                  
              </table>
          </form>
          </div>
          <div class="col-md-3 alert alert-info" style=" width: 350px;">
              <p> <i class="fa fa-warning" align='justify'></i>  Cada usuario debe de tener asignado un rol, el cual definir&aacute; los permisos que va a terner dentro de la
                      aplicaci&oacute;n. Es recomendable revisar los roles antes de asignarlos y crear o modificar los existentes para que se adapten mejor a los requisitos de
                      seguridad de su sistema...</p>
          </div>
          
        </div>
    </div>
</section>



<?php

include '../../funct/con_tacnamh_db.php';
include '../../funct/functions.php';
include '../../modelo/consultas_genericas.php';
include "../session_header.php";
include './header.php';

$lista_usuarios=array();
$nombre_rol="";
$cg=new ConsultasG();

$p=array();
$p['campo'][0]="";
$p['valor'][0]="";
$r=$cg->GenericSelect('usuario', $p);
if($r)
{
    $lista_usuarios=$cg->ArregloAsociativoSelect($r, 'usuario');
}

$msg="";
if(isset($_SESSION['msg_user'])){$msg=$_SESSION['msg_user']; unset($_SESSION['msg_user']);}

?>
<br><br>
<section class="about-text">
    <div class="container ">
      
        <div class="col-md-12">
            <h3 class="text-left"><i class="fa fa-secure text-info"> Bienvenido al m&oacute;dulo de administraci&oacute;n general.</i></h3>
          <div class="panel panel-default">
                        <div class="panel-heading">
                            Usuarios del Sistema
                             
                            <div class="pull-right">
                                <a href="usuarios_add.php" class=" btn btn-success btn-xs" title="Nuevo Usuario"><i class="fa fa-plus"> Nuevo usuario</i></a>
                            </div>
                        </div>
              
              <div class="panel-body">
                  <?php 
                                if($msg!=""){echo $msg;}
                            ?>
                  <table id="example" class="table table-striped table-hover display table-responsive " style="right: 10px;">
                      <thead>
                          <tr>
                              <th>Nro.</th>
                              <th>Usuario</th>
                              <th>Nombre</th>
                              <th>Rol</th>
                              <th>Acci&oacute;n</th>
                          </tr>
                      </thead>
                      <tbody>
                          <?php 
                          if(count($lista_usuarios)>0)
                            { 
                              for ($i = 0; $i < count($lista_usuarios); $i++) 
                              {
                                  $id_usuariobd=$lista_usuarios[$i]['id_usuario'];
                                  $usuariobd=$lista_usuarios[$i]['usuario'];
                                  $nombreusbd=$lista_usuarios[$i]['nombre'];
                                  $id_rol=$lista_usuarios[$i]['id_rol'];
                                  
                                  $p=array();
                                  $p['campo'][0]='id_rol';
                                  $p['valor'][0]=$id_rol;
                                  $r=$cg->GenericSelect('rol', $p);
                                  if($r)
                                    {
                                      $arr_roles=$cg->ArregloAsociativoSelect($r, 'rol');
                                      if(count($arr_roles)>0)
                                        {
                                          $nombre_rol=$arr_roles[0]['nombre'];
                                        }
                                    }                                  
                                  
                                  echo "<tr>";
                                    echo "<td>$id_usuariobd</td>";
                                    echo "<td>$usuariobd</td>";
                                    echo "<td>$nombreusbd</td>";
                                    echo "<td>$nombre_rol</td>";
                                    echo '
                                        <td>
                                         <a href="usuario_edit.php?nik='.$id_usuariobd.'" title="Editar datos" class="btn btn-primary btn-sm"><span class="glyphicon glyphicon-edit" aria-hidden="true"></span></a>

                                         <a href="index_admin.php?action=delete&nik='.$id_usuariobd.'&v='.$usuariobd .'" title="Eliminar" onclick="return confirm(\'Esta seguro de borrar los datos '.$usuariobd.' ?\')" class="btn btn-danger btn-sm"><span class="glyphicon glyphicon-trash" aria-hidden="true"></span></a>
                                        </td>';
                                    
                                  echo "</tr>";
                              }
                            }
                          ?>
                      </tbody>
                  </table>
              </div>
          </div>
        </div>
    </div>
</section>
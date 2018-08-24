<?php
include '../../funct/con_tacnamh_db.php';
include '../../funct/functions.php';
include '../../modelo/consultas_genericas.php';
include "../session_header.php";
include './header.php';

$cg=new ConsultasG();
$parametros=array();
$parametros["campo"][0]="";
$parametros["valor"][0]="";
$lista_menus=array();
$r=$cg->GenericSelect('menu', $parametros);
if($r)
{
    $lista_menus=$cg->ArregloAsociativoSelect($r, 'menu');
}

$error=0;
$msg="";
$p_nombre_rol="";
$p_desc="";
$arr_checked=array();
$ch=0;
$p_id_rol="";
if($_POST)
{
    ##Mostrar($_POST);
    if(isset($_POST['nombre_rol'])){$p_nombre_rol=$_POST['nombre_rol'];}
    if(isset($_POST['desc'])){$p_desc=$_POST['desc'];}
    
    ##validar vacios
    if(eliminarblancos($p_nombre_rol)=="")
    {
        $msg="<div class='alert alert-danger alert-dismissable'><button type='button' class='close' data-dismiss='alert' aria-hidden='true'>&times;</button>Error! Usted debe de nombrar el rol a crear</div>";
        $error++;
    }
 else {
        ##buscar que el rol no exista
        $p=array();
        $p["campo"][0]="nombre";
        $p["valor"][0]=$p_nombre_rol;
        $r=$cg->GenericSelect('rol', $p);
        if($r)
        {
            $arr_rol=$cg->ArregloAsociativoSelect($r, 'rol');
            
            if(count($arr_rol)==1)
            {
                $msg="<div class='alert alert-danger alert-dismissable'><button type='button' class='close' data-dismiss='alert' aria-hidden='true'>&times;</button>Error! El rol $p_nombre_rol ya existe.</div>";
                $error++;
            }
        }
    }
    
    if($error==0)
    {
        ##insertar el nuevo rol y tomar el id
        $p=array();
        $a=0;
        $p["campo"][$a]="nombre";
        $p["valor"][$a]=$p_nombre_rol;
        $a++;
        $p["campo"][$a]="descripcion";
        $p["valor"][$a]=$p_desc;
        $a++;
        $affected=$cg->GenericInsert('rol', $p);
        if($affected==1)
        {
            ##buscar el id del rol que se inserto por el nombre ya que el nombre del rol es unico
            $p=array();
            $p["campo"][0]="nombre";
            $p["valor"][0]=$p_nombre_rol;
            ##insertar los permisos para el nuevo rol
            $r=$cg->GenericSelect('rol', $p);
            if($r)
            {
                $arr_rolesBd=$cg->ArregloAsociativoSelect($r, 'rol');
                if(count($arr_rolesBd)>0)
                {
                    $p_id_rol=$arr_rolesBd[0]['id_rol'];
                }
            }
             if(count($lista_menus)>0)
            {
                for ($j = 0; $j < count($lista_menus); $j++) 
                {
                    $id_menu=$lista_menus[$j]['id_menu'];
                    $var="nombre_menu$id_menu";
                    if(isset($_POST["$var"]))
                    {
                        $listar=0;
                        $editar=0;
                        $nuevo=0;
                        $imp=0;
                        $eliminar=0;
                        
                        $var_list="listar$id_menu";
                        $var_nuevo="nuevo$id_menu";
                        $var_editar="editar$id_menu";
                        $var_eliminar="eliminar$id_menu";
                        $var_imp="imp$id_menu";
                        $var_todos="todos$id_menu";
                       
                        if(isset($_POST[$var_todos]))
                        {
                            $arr_checked[$ch]=$var_todos;
                            $ch++;
                        }
                        if(isset($_POST[$var_list]))
                        {   
                            $listar=1;
                            $arr_checked[$ch]=$var_list;
                            $ch++;
                        }
                        if(isset($_POST[$var_editar]))
                        {   
                            $editar=1;
                            $arr_checked[$ch]=$var_editar;
                            $ch++;
                        }
                        if(isset($_POST[$var_eliminar]))
                        {   
                            $eliminar=1;
                            $arr_checked[$ch]=$var_eliminar;
                            $ch++;
                        }
                        if(isset($_POST[$var_nuevo]))
                        {   
                            $nuevo=1;
                            $arr_checked[$ch]=$var_nuevo;
                            $ch++;
                        }
                        if(isset($_POST[$var_imp]))
                        {   
                            $imp=1;
                            $arr_checked[$ch]=$var_imp;
                            $ch++;
                        }
                        ##insertar el nuevo usuario _menu con el id_rol recien insertado, el id del menu y 0 o 1 en los listar,eliminar, edital,etc.. segun venga
                       
                        if($listar!=0 || $eliminar!=0 || $editar!=0 || $imp!=0 || $nuevo!=0)
                        {
                            $p=array();
                            $k=0;
                            $p["campo"][$k]="id_rol";
                            $p["valor"][$k]=$p_id_rol;
                            $k++;
                            $p["campo"][$k]="id_menu";
                            $p["valor"][$k]=$id_menu;
                            $k++;
                            $p["campo"][$k]="listar";
                            $p["valor"][$k]=$listar;
                            $k++;
                            $p["campo"][$k]="crear";
                            $p["valor"][$k]=$nuevo;
                            $k++;
                            $p["campo"][$k]="editar";
                            $p["valor"][$k]=$editar;
                            $k++;
                            $p["campo"][$k]="eliminar";
                            $p["valor"][$k]=$eliminar;
                            $k++;
                            $p["campo"][$k]="imp";
                            $p["valor"][$k]=$imp;
                            $k++;

                            $affected=$cg->GenericInsert('usuarios_menu', $p);
                            if($affected==1)
                            {
                               ##mensaje de success y redireccionar la pagina
                                $msg="<div class='alert alert-success alert-dismissable'><button type='button' class='close' data-dismiss='alert' aria-hidden='true'>&times;</button>Ok! EL rol $p_nombre_rol ha sido creado con &eacute;xito.</div>";

                                $_SESSION['msg']=$msg;
                                echo "<script>";
                                echo "window.location = 'rol_list.php';";
                                echo "</script>";
                            }
                            else
                            {
                                $aff=$cg->GenericDeltePorID('rol', 'id_rol', $p_id_rol);
                                if($aff==1)
                                {
                                    $msg="<div class='alert alert-danger alert-dismissable'><button type='button' class='close' data-dismiss='alert' aria-hidden='true'>&times;</button>Error! No se pudieron asignar los permisos correctamente.</div>";
                                }
                                else 
                                {
                                   $msg="<div class='alert alert-danger alert-dismissable'><button type='button' class='close' data-dismiss='alert' aria-hidden='true'>&times;</button>Error! No se pudo eliminar el rol para arreglar los permisos.</div>"; 
                                }

                            }
                        }
                        else 
                        {
                            $msg="<div class='alert alert-danger alert-dismissable'><button type='button' class='close' data-dismiss='alert' aria-hidden='true'>&times;</button>Error! Usted debe de seleccionar al menos 1 permiso para el rol.</div>";
                        }
                        
                    }
                }
            }
            
        }
        else 
        {
            
           $msg="<div class='alert alert-success alert-dismissable'><button type='button' class='close' data-dismiss='alert' aria-hidden='true'>&times;</button>Error! No se pudieron guradar los datos.</div>";
        }
       
    }
    
}

?>

<br><br>
<section class="about-text">
    <div class="container ">
      
        <div class="col-md-12">
          <h3 class="text-left"><i class="fa fa-user text-info"> Nuevo Rol</i></h3>
          <?php 
          if($msg!=""){echo $msg;}
          ?>
         
              <form name="new_rol" method="post" action="rol_add.php">
                  <table class="table table-responsive">
                      <tr>
                          <th rowspan="2"><img src="img/roles.jpg" title="roles"  class="img-responsive"></th>
                          <th colspan="6">Nombre <input type="text" name="nombre_rol" placeholder="Nombre del Rol" class="form-control" value='<?php echo $p_nombre_rol;?>'></th>
                      </tr>
                      <tr>
                          <th colspan="6">Descripci&oacute;n<textarea placeholder="Descripci&oacute;n del Rol" class="form-control" name="desc" ><?php echo $p_desc;?></textarea></th>
                      </tr>
                  </table>
                 
                      <h3>Seleccione los permisos del nuevo Rol</h3>
                  <table class="table  table-responsive" >
                      <thead>
                          <tr>
                          <th>Menu</th>
                          <th>Todos</th>
                          <th>Nuevo</th>
                          <th>Editar</th>
                          <th>Eliminar</th>
                          <th>Listar</th>
                          <th>Imprimir</th>
                      </tr>
                      </thead>
                      <tbody>
                      
                      <?php 
                      if(count($lista_menus)>0)
                        {
                          
                          for ($i = 0; $i < count($lista_menus); $i++) 
                          {
                            $id_menu=$lista_menus[$i]['id_menu'];
                            $nombre=$lista_menus[$i]['nombre'];
                            $nombre_menu_general=$lista_menus[$i]['nomb_menu_general'];
                           
                           
                            $var="onClick=\"Chequear('".$id_menu."')\"";
                            echo "<tr>";
                            
                            echo "<td>$nombre <input type='hidden' name='nombre_menu$id_menu' value='$nombre' ></td>";
                            if(BuscarElementoEnArray('todos'.$id_menu, $arr_checked)){$cheked="checked=true";}else{$cheked="";}
                            echo "<td><input type='checkbox' name='todos$id_menu' onclick='MarcarTodos(this.id);'  id='$id_menu' $cheked></td>";
                            
                            if(BuscarElementoEnArray('nuevo'.$id_menu, $arr_checked)){$cheked="checked=true";}else{$cheked="";}
                            echo "<td><input type='checkbox' name='nuevo$id_menu' $var  $cheked id='nuevo$id_menu'></td>";
                            
                            if(BuscarElementoEnArray('editar'.$id_menu, $arr_checked)){$cheked="checked=true";}else{$cheked="";}
                            echo "<td><input type='checkbox' name='editar$id_menu' $var  id='editar$id_menu' $cheked></td>";
                            
                            if(BuscarElementoEnArray('eliminar'.$id_menu, $arr_checked)){$cheked="checked=true";}else{$cheked="";}
                            echo "<td><input type='checkbox' name='eliminar$id_menu' $var  id='eliminar$id_menu' $cheked></td>";
                            
                            if(BuscarElementoEnArray('listar'.$id_menu, $arr_checked)){$cheked="checked=true";}else{$cheked="";}
                            echo "<td><input type='checkbox' name='listar$id_menu' $var id='listar$id_menu' $cheked></td>";
                            
                            if(BuscarElementoEnArray('imp'.$id_menu, $arr_checked)){$cheked="checked=true";}else{$cheked="";}
                            echo "<td><input type='checkbox' name='imp$id_menu' $var  id='imp$id_menu' $cheked></td>";
                            
                            echo "</tr>";
                            
                          }
                        }
                      
                      ?>
                      </tbody>
                  </table>
                      
                      
                  
                   <br>
                    <br> <br>
                  <div class="text-center">
                          <a href="index_admin.php" class="btn btn-danger">Cancelar</a>
                          <button type="submit" class="btn btn-success"> Crear Rol</button>
                      </div>
                      <br> <br> <br>
              </form>
              
          
        </div>
    </div>
</section>

<?php

$primera_vez=0;
$id_buscar="";
$nombre="";
$pass="";
if(isset($_GET['nik']) && $primera_vez==0)
{
   
   $msg="";
   $_SESSION['msg']=$msg;
    $id_buscar=$_GET['nik'];
 
    $primera_vez++;
    $tipo_msg++;
    ##cargar todos los datos de la Bd oara el id:buscar
    $cg=new ConsultasG();
    $p['campo'][0]=$entity_campo_id;
    $p['valor'][0]=$id_buscar;
    $r=$cg->GenericSelect($edit_table, $p);
    $n=$cg->NumeroResultados($r);
    
    if($cg->NumeroResultados($r)!=0)
    {
        $datos=$cg->ArregloAsociativoSelect($r, $edit_table);
   
        for ($i = 0; $i < count($campos_add); $i++) {
            $camp=$campos_add[$i]['campobd'];
          
            $valor=$datos[0][$camp];
            
            $campos_add[$i]['valor']=$valor;
        }
        
        $nombre=$datos[0][$elemento_distintivo];
    }
 else 
     {
        ##no se encontró nada con ese id para modificar, en ese caso se deberia redireccionar a la pagina listar y mostrar un msg
     $_SESSION['msg']="<div class='alert alert-danger alert-dismissable'><button type='button' class='close' data-dismiss='alert' aria-hidden='true'>&times;</button>No se encontraron los datos!!</div>";
     echo "<script>";
     echo "window.location = '$link_cancelar';";
     echo "</script>";
}
    }

 else 
{
    echo "<script>";
    echo "window.location = '$link_cancelar';";
    echo "</script>";
}

if(isset($_POST))
{
 ##limpiar la variable get
    unset($_GET);
    
    $add=array();
    $add["campo"][0]="";
    $add["valor"][0]="";
    $a=0;
    $validar_vacios=0;
    ##tomar los campos CDA UNO DE LOS CAMPOS DE LA BASE DE DATOS SiN CONTAR EL ID
   
    
    for ($i = 0; $i < count($campos_add); $i++) 
    { 
            if(isset($campos_add[$i]['campobd']))
            {
                @$name=$campos_add[$i]['campobd'];
            }
            else
            {
                @$name=$campos_add[$i]['nombre'];
            }
         
        if(isset($_POST[$name]))
        {
            $add["campo"][$a]=$name;
            $p_valor=$_POST[$name];
            if($name==$elemento_distintivo)
            {
                $p_valor=$p_valor;
            }
            if($name=='password'){$pass=$p_valor;}
            $add["valor"][$a]=$p_valor;
            $campos_add[$i]["valor"]=$add["valor"][$a];
            
            if(eliminarblancos($add["valor"][$a])=="")
            {
                $msg="<div class='alert alert-danger alert-dismissable'><button type='button' class='close' data-dismiss='alert' aria-hidden='true'>&times;</button>Error! No puede dejar campos vacíos</div>";
                $campos_add[$i]["result_validar"]="**El campo $name no puede estar vacío...";
                $validar_vacios++;
            }
            ##realizar validaciones especificasas
            $nameValidar=$name.'__validate';
            
            if(isset($_POST[$nameValidar]))
            {
                $tipo_validacion=$_POST[$nameValidar];
                ##verificar tipo
              
                if($tipo_validacion=="sn")##solo numeros
                {
                    if(!solonumeros($p_valor))
                    {
                        $validar_vacios++;
                        $msg="<div class='alert alert-danger alert-dismissable'><button type='button' class='close' data-dismiss='alert' aria-hidden='true'>&times;</button>El campo $name solo admite numeros</div>";
                        $campos_add[$i]["result_validar"]="**El campo $name solo admite numeros...";
                    }
                }
              
                 if($tipo_validacion=="sl")##solo numeros
                {
                    if(!SoloTexto($p_valor))
                    {
                        $validar_vacios++;
                        $msg="<div class='alert alert-danger alert-dismissable'><button type='button' class='close' data-dismiss='alert' aria-hidden='true'>&times;</button>El campo $name solo admite Letras</div>";
                        $campos_add[$i]["result_validar"]="**El campo $name solo admite letras...";
                    }
                }
                 if($tipo_validacion=="lnc")##solo letra numeros y algnos caracteres
                {
                     
                    if(!SoloTextoNumerosYAlgC($p_valor))
                    {
                        $validar_vacios++;
                        $msg="<div class='alert alert-danger alert-dismissable'><button type='button' class='close' data-dismiss='alert' aria-hidden='true'>&times;</button>El campo $name no admite caracteres extraños</div>";
                        $campos_add[$i]["result_validar"]="**El campo $name presenta caracteres no permitidos ($&=*')";
                    }
                      
                }
                
                if($tipo_validacion=="email")##email
                {
                    if(!ValidarEmail($p_valor))
                    {
                        $validar_vacios++;
                        $msg="<div class='alert alert-danger alert-dismissable'><button type='button' class='close' data-dismiss='alert' aria-hidden='true'>&times;</button>El campo $name no esta en el formato correcto</div>";
                        $campos_add[$i]["result_validar"]="**El campo $name no esta en el formato correcto ej: usuario@dominio.com";
                    }
                      
                }
            }
             $_SESSION['msg']=$msg;
            $a++;
        }
    }
    
  if($validar_vacios==0)
{
      
  ##validar que el elemento a editar no se repita en bd $elemto_distintivo

 $valor_comparar="";
  for ($k = 0;$k < count($add["campo"]); $k++) {
      $v=$add['campo'][$k];
      if($v==$elemento_distintivo)
        {
          $valor_comparar=$add["valor"][$k];
          break;
        }
  }

  #Mostrar($valor_comparar);
  if($valor_comparar!="")
      {
      
        $cg=new ConsultasG();
        $par['campo'][0]=$elemento_distintivo;
        $par['valor'][0]=$valor_comparar;
        
       
        $r=$cg->GenericSelect($edit_table, $par);
        $datos=$cg->ArregloAsociativoSelect($r, $edit_table);
      
        $repite=0;
        for ($i = 0; $i < count($datos); $i++) 
        {
            if($datos[$i][$entity_campo_id]==$id_buscar)
            {
                $repite++;
                ##solo para las contraseñas
                if(isset($datos[$i]['password']))
                {
                    if($datos[$i]['password']!=$pass)
                        {                       
                           
                            for ($l = 0; $l < count($add['campo']); $l++) 
                            {                               
                                if($add['campo'][$l]=='password'){$add['valor'][$l]=md5($pass);}
                               
                            } 
                        
                        }
                   
                }
            }
            
            
            
        }
      
        if(count($datos)==0 || (count($datos)==1 && $repite==1))
        {
            ##validar si tiene los permisos
            ##si la variable no se ha creado, la creo con valor positivo, solo para el casi de q se me olvidara ponerle la condicion
            if(!isset($permisos_de_action)){$permisos_de_action=0;}
            if($permisos_de_action==1)
            {
                ##modifico los datos los datos
                $affected=$cg->GenericUpdate($edit_table, $add,$entity_campo_id,$id_buscar);
                
                if($affected==1)
                {
                     $msg="<div class='alert alert-success alert-dismissable'><button type='button' class='close' data-dismiss='alert' aria-hidden='true'>&times;</button>Los datos han sido guardados con &eacute;xito.</div>";
                    $tipo_msg=0;
                       $_SESSION['msg']=$msg;
                       $mensaje = strip_tags($msg);
                        echo "<script>";
                        echo "alert('Los datos han sido guardados con éxito.');";  
                        echo "window.location = '$location';";
                        echo "</script>";  
                }
                else 
                {

                     $msg="<div class='alert alert-danger alert-dismissable'><button type='button' class='close' data-dismiss='alert' aria-hidden='true'>&times;</button>Error! No se guardaron los datos</div>";
                     $tipo_msg=1;
                      $_SESSION['msg']=$msg;
                }
            }
            else
            {
                $msg= '<div class="alert alert-danger alert-dismissable text-center"><button type="button" class="close" data-dismiss="alert" aria-hidden="true"></button> Lo sentimos!!! Su nivel de acceso no le permite ejecutar esta acción</div>';
                 $tipo_msg=1;
                 $_SESSION['msg']=$msg;
            }
        }
        else 
        {
            ##MUESTRO MSG ERROR NO SE PUEDE AÑADIR PQ EXISTE
            $msg= "<div class='alert alert-danger alert-dismissable'><button type='button' class='close' data-dismiss='alert' aria-hidden='true'>&times;</button>Error. El <b>$elemento_distintivo </b> con valor <b>$valor_comparar </b> ya existe!</div>";
            $tipo_msg=1;
            $_SESSION['msg']=$msg;
        }
      } 
}
 
}
?>
<br><br>
<section class="about-text">
    <div class="container ">
      
        <div class="col-md-12">
          <h3 class="text-left"><i class="fa fa-institution text-info"><?php echo $entity_name.' '.$nombre;?></i></h3>
      <?php echo $msg;?>
    <form class="form-horizontal" action="" method="post">
        <?php 

        for ($i = 0; $i < count($campos_add); $i++) {
            
            if(isset($campos_add[$i]['campobd']))
            {
                $camp_add_nombre=$campos_add[$i]['campobd'];
            }
            else
            {
                $camp_add_nombre=$campos_add[$i]['nombre'];
            }
            
            $camp_add_tipo=$campos_add[$i]['tipo'];
            $camp_add_listSelect=$campos_add[$i]['select'];
            $camp_add_valor=$campos_add[$i]['valor'];
            $camp_add_result_v="";
            $camp_add_validate="";
             if(isset($campos_add[$i]["validate"]))
            {
                $camp_add_validate=$campos_add[$i]["validate"];
            }
            if(isset($campos_add[$i]["result_validar"]))
            {
                $camp_add_result_v=$campos_add[$i]["result_validar"];
            }
            
            if($tipo_msg==0){$camp_add_valor="";}
           
            echo "<div class='form-group'>";
                echo "<label class='col-sm-3 control-label'>$camp_add_nombre</label>";
                echo "<div class='col-sm-7'>";
                if($camp_add_tipo=="text")
                {
                    echo "<div class='form-group'>";
                     echo "<input type='text' name='$camp_add_nombre' class='form-control' placeholder='$camp_add_nombre' value='$camp_add_valor' required>";
                      if($camp_add_result_v!=""){echo "<span class='text-danger'>$camp_add_result_v</span>";}
                      echo "<input type='hidden' name='$camp_add_nombre._validate' value='$camp_add_validate'>";                     
                    echo "</div>";
                }
                if($camp_add_tipo=="number")
                {
                     echo "<div class='form-group'>";
                     echo "<input type='number' name='$camp_add_nombre' class='form-control' value='$camp_add_valor' required min='1'>";
                     if($camp_add_result_v!=""){echo "<span class='text-danger'>$camp_add_result_v</span>";}
                     echo "<input type='hidden' name='$camp_add_nombre._validate' value='$camp_add_validate'>";
                     echo "</div>";
                }
                if($camp_add_tipo=="date")
                {
                     echo "<div class='form-group'>";
                    //echo "<input type='text' name='$camp_add_nombre' class='input-group date form-control'  id='fecha'  placeholder='00-00-0000' value='$camp_add_valor' readonly required>";
                      echo "<input type='date' name='$camp_add_nombre' value='$camp_add_valor' class='form-control' required>";
                    echo "</div>";
                }
                if($camp_add_tipo=="textarea")
                {echo "<div class='form-group'>";
                    echo "<textarea name='$camp_add_nombre' class='form-control' required col='3' rows='5'>$camp_add_valor</textarea>";
                    if($camp_add_result_v!=""){echo "<span class='text-danger'>$camp_add_result_v</span>";}
                    echo "<input type='hidden' name='$camp_add_nombre._validate' value='$camp_add_validate'>";
                echo "</div>";
                }
                if($camp_add_tipo=="email")
                {
                    echo "<div class='form-group'>";
                     echo "<input type='email' name='$camp_add_nombre' class='input-group form-control' placeholder='usuario@correo.com' value='$camp_add_valor' required>";
                    echo "</div>";
                }
                  if($camp_add_tipo=="pass")
                {
                    echo "<div class='form-group'>";
                     echo "<input type='password' name='$camp_add_nombre' class='input-group form-control' value='$camp_add_valor' required>";
                    echo "</div>";
                }
                if($camp_add_tipo=="select")
                {
                    $list_name=$campos_add[$i]['list_name'];
                    $list_value=$campos_add[$i]['list_value'];
                    echo "<div class='form-group'>";
                    echo "<select name='$camp_add_nombre' class='form-control selectpicker data-live-search='true'>";
                    echo "<option value=''> --SELECCIONE-- </option>";
                    for ($j = 0;$j < count($camp_add_listSelect); $j++)
                    {
                        $selected="";
                        $lista_select_name=$camp_add_listSelect[$j][$list_name];
                        $lista_select_value=$camp_add_listSelect[$j][$list_value];
                                                
                        if($lista_select_value == $camp_add_valor){$selected="selected";}
                        
                        echo "<option value='$lista_select_value' $selected >$lista_select_name</option>";

                    }
                     
                echo "</select>";
                echo "</div>";
                }
               
                echo "</div>";
            echo "</div>";
            
        }
        ?>

        <div class="form-group">
                <label class="col-sm-3 control-label">&nbsp;</label>
                <div class="col-sm-6">
                        <input type="submit" name="add" class="btn btn-sm btn-primary " value="Guardar">
                        <a href="<?php echo $link_cancelar;?>" class="btn btn-sm btn-danger">Cancelar</a>
                </div>
        </div>
    </form>
    </div>
    
</section>
<br><br>
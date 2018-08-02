<?php
if(isset($_POST))
{
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
                $p_valor=  strtoupper($p_valor);
            }
           
            if($campos_add[$i]["tipo"]=="pass"){$p_valor=  md5($p_valor);}
            $add["valor"][$a]=$p_valor;
            
            $campos_add[$i]["valor"]=$add["valor"][$a];
          
            if(eliminarblancos($add["valor"][$a])=="" && $campos_add[$i]['tipo']!='hidden')
            {
                $msg="<div class='alert alert-danger alert-dismissable'><button type='button' class='close' data-dismiss='alert' aria-hidden='true'>&times;</button>Error! No puede dejar campos vacíos</div>";
                $validar_vacios++;
                $campos_add[$i]["result_validar"]="**El campo $name no puede estar vacío...";
            }
            
            ##realizar validaciones especificasas
            $nameValidar=$name.'__validate';
            
            if(isset($_POST[$nameValidar]))
            {
                $tipo_validacion=$_POST[$nameValidar];
                ##verificar tipo
                
                if($tipo_validacion=="sn")##solo numeros
                {
                    if(isNaN($p_valor))
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
                        $msg="<div class='alert alert-danger alert-dismissable'><button type='button' class='close' data-dismiss='alert' aria-hidden='true'>&times;</button>El campo $name no admite caracteres extraños</div>";
                        $campos_add[$i]["result_validar"]="**El campo $name no esta en el formato correcto ej: usuario@dominio.com";
                    }
                      
                }
            }
            $a++;
        }
    }
   
  if($validar_vacios==0)
{
 
  ##validar nuevo elemento ya no exista en bd $elemto_distintivo
     
 $valor_comparar="";
 $valor_comparar2="";
 $valor_comparar3="";
 if($elemento_distintivo!="-1")
 {
    for ($k = 0;$k < count($add["campo"]); $k++) {
        $v=$add['campo'][$k];
        if($v==$elemento_distintivo)
          {
            $valor_comparar=$add["valor"][$k];
            
          }
        if(isset($elemento_distintivo2))
        {
           if($v==$elemento_distintivo2)
          {
            $valor_comparar2=$add["valor"][$k];
            
          }
        }
        if(isset($elemento_distintivo3))
        {
           if($v==$elemento_distintivo3)
          {
            $valor_comparar3=$add["valor"][$k];
           
          }
        }
    }
 }else{$valor_comparar="-1";}


  if($valor_comparar!="")
      {
        $cg=new ConsultasG();
        $num_resultados=0;
        if($elemento_distintivo!="-1")
        {
            $parametros['campo'][0]=$elemento_distintivo;
            $parametros['valor'][0]=$valor_comparar;
            if($valor_comparar2!="")
            {
                $parametros['campo'][1]=$elemento_distintivo2;
                $parametros['valor'][1]=$valor_comparar2;
            }
            if($valor_comparar3!="")
            {
                $parametros['campo'][2]=$elemento_distintivo3;
                $parametros['valor'][2]=$valor_comparar3;
            }

            $r=$cg->GenericSelect($tabla, $parametros);
            $num_resultados=$cg->NumeroResultados($r);
        }
        
        if($num_resultados==0)
        {
            
            ##validar si tiene los permisos
            ##si la variable no se ha creado, la creo con valor positivo, solo para el casi de q se me olvidara ponerle la condicion
            if(!isset($permisos_de_action)){$permisos_de_action=0;}
            if($permisos_de_action==1)
            {
                ##inserto los datos
                $affected=$cg->GenericInsert($tabla, $add);
                
                if($affected==1)
                {
                     $msg="<div class='alert alert-success alert-dismissable'><button type='button' class='close' data-dismiss='alert' aria-hidden='true'>&times;</button>Bien hecho! Los datos han sido guardados con &eacute;xito.</div>";
                    $tipo_msg=0;
                    $_SESSION['msg']=$msg;
                    echo "<script>";
                    echo "window.location = '$link_cancelar';";
                    echo "</script>";
                }
                else 
                {
                     $msg="<div class='alert alert-danger alert-dismissable'><button type='button' class='close' data-dismiss='alert' aria-hidden='true'>&times;</button>Error! No se guardaron los datos</div>";
                     $tipo_msg=1;
                }
            }
            else
            {
                $msg= '<div class="alert alert-danger alert-dismissable text-center"><button type="button" class="close" data-dismiss="alert" aria-hidden="true"></button> Lo sentimos!!! Su nivel de acceso no le permite ejecutar esta acción</div>';
                            
            }
           
        }
        else 
        {
            ##MUESTRO MSG ERROR NO SE PUEDE AÑADIR PQ EXISTE
            $show="El <b>$elemento_distintivo </b> con valor <b>$valor_comparar </b> ya existe!";
            if(isset($campanna)){if($campanna==1){$show="Ya se ha creado una campa&ntilde;a para este proyecto en el mes en curso";}}
            $msg= "<div class='alert alert-danger alert-dismissable'><button type='button' class='close' data-dismiss='alert' aria-hidden='true'>&times;</button>Error. $show</div>";
            $tipo_msg=1;
        }
      } 
}
 else {
$tipo_msg=1;    
}
 
 
}

?>
<br><br>
<section class="about-text">
    <div class="container ">
      
        <div class="col-md-12">
          <h3 class="text-left"><i class="fa fa-institution text-info"><?php echo $entity_name;?></i></h3>
      <?php if($msg!=""){echo $msg;}?>
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
            $camp_mostrar_titulo=$campos_add[$i]['nombre'];
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
            if($tipo_msg==0&& $camp_add_tipo!='hidden'){$camp_add_valor="";}
           
            echo "<div class='form-group'>";
                echo "<label class='col-sm-3 control-label'>$camp_mostrar_titulo</label>";
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
                    echo "<input type='date' name='$camp_add_nombre' value='$camp_add_valor' class='form-control' >";
                    echo "</div>";
                }
                if($camp_add_tipo=="textarea")
                {
                    echo "<div class='form-group'>";
                    echo "<textarea name='$camp_add_nombre' class='form-control' >$camp_add_valor</textarea>";
                    echo "<input type='hidden' name='$camp_add_nombre._validate' value='$camp_add_validate'>";
                    echo "</div>";
                }
                 if($camp_add_tipo=="email")
                {
                    echo "<div class='form-group'>";
                     echo "<input type='email' name='$camp_add_nombre' class='input-group form-control' placeholder='usuario@correo.com' value='$camp_add_valor' >";
                    echo "</div>";
                }
                 if($camp_add_tipo=="hidden")
                {
                    echo "<div class='form-group'>";
                     echo "<input type='text' name='$camp_add_nombre' class='input-group form-control'  value='$camp_add_valor' readonly>";
                    echo "</div>";
                }
                  if($camp_add_tipo=="pass")
                {
                    echo "<div class='form-group'>";
                     echo "<input type='password' name='$camp_add_nombre' class='input-group form-control'  value='$camp_add_valor' required>";
                    echo "</div>";
                }
                if($camp_add_tipo=="select")
                {
                    $list_name=$campos_add[$i]['list_name'];
                    $list_value=$campos_add[$i]['list_value'];
                   echo "<div class='form-group'>";
                    echo "<select name='$camp_add_nombre' class='form-control selectpicker' data-live-search='true'>";
                    //
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
                if($camp_add_tipo=="checkbox")
                {
                    
                }
               
                echo "</div>";
            echo "</div>";
            
        }
        ?>

        <div class="form-group">
                <label class="col-sm-3 control-label">&nbsp;</label>
                <div class="col-sm-6">
                        <input type="submit" name="add" class="btn btn-sm btn-primary" value="Guardar">
                        <a href="<?php echo $link_cancelar;?>" class="btn btn-sm btn-danger">Cancelar</a>
                </div>
        </div>
    </form>
    </div>
    
</section
<br><br>
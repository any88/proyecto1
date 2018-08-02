<?php
##cargar todos los datos
$primera_vez=0;
$id_buscar="";
$msg="";
$row=array();
if(isset($_SESSION['msg']))
{
    $msg=$_SESSION['msg'];
    unset($_SESSION['msg']);
}

if(isset($_GET['nik']))
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
        $row=$cg->ArregloAsociativoSelect($r, $edit_table);
        
        for ($i = 0; $i < count($campos_add); $i++) {
            $camp=$campos_add[$i]['campobd'];
          
            $valor=$row[0][$camp];
            
            $campos_add[$i]['valor']=$valor;
        }
        
    }
    else 
     {
        ##no se encontró nada con ese id para mostrar, en ese caso se deberia redireccionar a la pagina listar y mostrar un msg
        $_SESSION['msg']="<div class='alert alert-danger alert-dismissable'><button type='button' class='close' data-dismiss='alert' aria-hidden='true'>&times;</button>No se encontraron los datos!!</div>";
        echo "<script>";
        echo "window.location = '$link_cancelar';";
        echo "</script>";
    }   
}
 else {
    /*echo "<script>";
        echo "window.location = '$link_cancelar';";
        echo "</script>";*/
}
?>
<br><br>
<section class="about-text">
    <div class="container ">
      
        <div class="col-md-12">
          <h3 class="text-left"><i class="fa fa-institution text-info"><?php echo "Perfil de ".$entity_name;?></i></h3>
          
        <?php echo $msg;?>
        <table id='example2' class='table display' width="100%">
        <?php 
        echo "<thead>";
            #echo "<tr><th colspan='2'>Listado de $entity_name</th><input type='hidden' id='title_perfil' value='$entity_name'></tr>";
            echo "<tr><th >Campo</th><th>Valor</th></tr>";
        echo "</thead>";
        echo "<tbody>";
        
        for ($i = 0; $i < count($campos_add); $i++) 
        {
                        
            $camp_add_nombre=$campos_add[$i]['nombre'];
            $camp_add_valor=$campos_add[$i]['valor'];
             if(isset($campos_tabla[$i]["join"]))
                {
                    $tabla1=$campos_tabla[$i]["tabla1"];
                    $tabla2=$campos_tabla[$i]["tabla2"];
                    $camp_seleccionar_t1=$campos_tabla[$i]["camp_seleccionar_t1"];
                    $camp_seleccionar_t2=$campos_tabla[$i]["camp_seleccionar_t2"];
                    $camp_filtrar_t1=$campos_tabla[$i]["camp_filtrar_t1"];
                    $camp_filtrar_t2=$campos_tabla[$i]["camp_filtrar_t"];
                   
                    $idt=$row[0][$camp_filtrar_t2];
                    $camp_add_valor=$cg->GenericJoinV1($tabla1, $tabla2, $camp_seleccionar_t1, $camp_filtrar_t1, $camp_filtrar_t2, $idt, $camp_seleccionar_t2);

                }
                    
            echo "<tr>";
             echo "<div class='form-group'>";
                 echo "<th class='alert-info' style='width:50%;'><label class='col-sm-3 control-label '>$camp_add_nombre</label></th>";
                 echo "<td><div class='col-sm-7'>$camp_add_valor</div></td>";
             echo '</div>';
            echo "</tr>";
        }
       echo "</tbody>";
        ?>
        </table>

    </div>
    
</section>
<br><br>


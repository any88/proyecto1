<?php
$cg=new ConsultasG();
$msg="";
$get_view=0;
$filter="";

if(isset($_SESSION['msg']))
{
    
    $msg=$_SESSION['msg'];
    unset($_SESSION['msg']);
}
if(isset($_SESSION['cd']))
    {
       
        $campo_depende=$_SESSION['cd'];
        unset($_SESSION['cd']);
    
    }
if($_GET)
    {
   
            $get_view++;
            if(isset($_GET['action']) == 'delete'){
                // escaping, additionally removing everything that could be (html/javascript-) code
                $nik = $_GET["nik"];
                ##buscar si existe
                if(isset($_GET['v']))
                {
                    $vm=":".$_GET['v'];
                }
                else
                {
                    $vm="";
                }
                
                $paramt['campo'][0]="$id_table";
                $paramt['valor'][0]=$nik;
                $result=0;
                $result=$cg->GenericSelect($bd_table, $paramt);

                if($cg->NumeroResultados($result) == 0){
                        $msg= '<div class="alert alert-warning alert-dismissable text-center"><button type="button" class="close" data-dismiss="alert" aria-hidden="true"></button> No se encontraron datos.</div>';
                }else{
                    
                    ##VALIDAR DEPENDENCIAS
                    $depende=0;
                    
                    if(isset($_GET['depende']))
                    {
                        $depende=$_GET["depende"];
                      
                    }
                    if($depende==0)
                    {
                       $msg_depende="";
                    }
                    ##si la variable no se ha creado, la creo con valor positivo, solo para el casi de q se me olvidara ponerle la condicion
                    if(!isset($permisos_de_action)){$permisos_de_action=0;}
                    if($permisos_de_action==1)
                    {
                        ###eliminar el dato seleccionado
                        $delete = $cg->GenericDeltePorID($delete_table, $delete_campo, $nik);
                        if($delete!=0){
                                $msg= '<div class="alert alert-success alert-dismissable text-center"><button type="button" class="close" data-dismiss="alert" aria-hidden="true"></button> Campo: '. $vm .', eliminado correctamente.</div>';
                                
                                
                        }else{
                                $msg= '<div class="alert alert-danger alert-dismissable text-center"><button type="button" class="close" data-dismiss="alert" aria-hidden="true"></button> Los datos de '.$entity_name.' no pudireon ser eliminados '.$msg_depende." $vm tiene dependencias con $campo_depende</div>";
                                unset($_SESSION['cd']);
                        }
                        
                    }
                    else 
                        {
                            $msg= '<div class="alert alert-danger alert-dismissable text-center"><button type="button" class="close" data-dismiss="alert" aria-hidden="true"></button> Lo sentimos!!! Su nivel de acceso no le permite ejecutar esta acción</div>';
                            
                        }
                    
                        $_SESSION['msg']=$msg;
                       
                }
                 $mensaje = strip_tags($msg);
                    echo "<script>";
                    echo "alert('$mensaje');";  
                    echo "window.location = '$link_listar';";
                    echo "</script>";  

            }

        
   
    
    }
    
 ?>
<br><br>
<section class="about-text">
    <?php if(isset($tipo_nom))
    {
        if($tipo_nom=='gastos')
        {
            echo "<div class='ingres_costo'>";
        }
        else
        {
             echo " <div class='container'>";
        }
    }
 else {
        echo " <div class='container'>";
    }
     ?>
  
      <div class="row">
        
          <h3 class="text-left"><i class="fa fa-institution text-info">Lista de <?php echo $entity_name;?></i></h3>
           
      </div>
      <div class="form-group table-responsive">
            <div class="panel panel-default">
            <div class="panel-heading">
            <?php echo strtoupper($entity_name);?>

                <div class="pull-right">
                     <?php 
                if(isset($permisos_de_action)&& $permisos_de_action==1)
                {
                    echo "<a href='$link_add' class='btn btn-success btn-xs'><i class='fa fa-plus'> Nuevo</i></a>";
                }
               ?>
                </div>
            </div>
        <div class="panel-body">
         <?php 

          echo $msg;

         ?>

        <br>

        <table id="example" class="table table-striped table-hover display table-responsive " style="right: 10px;">
        <thead>
        <?php 
            $colspan=  count($campos_tabla)+1;
            echo "<tr>";
            echo "<th colspan='$colspan'>Listado de $entity_name</th>";
            echo "</tr>";
        ?>
            <tr>
                <?php 
                If($get_view!=1)
                {
                    if($filter){
                        $parametros["campo"][0]=$id_table;
                        $parametros["valor"][0]=$filter;
                        $sql = $cg->GenericSelect($bd_table, $parametros);
                    }else{
                        $parametros["campo"][0]="";
                        $parametros["valor"][0]="";
                        $sql = $cg->GenericSelect($bd_table, $parametros);
                    }
                    if($cg->NumeroResultados($sql) == 0){
                            echo "<tr><td colspan='3'> <h3 class='text-center'>No hay datos para Mostrar!!!</h3></td></tr>";
                    }
                    else
                    {
                        ###cargar encabezados dinamicos
                        for ($i = 0; $i < count($campos_tabla); $i++) {


                            $ct=$campos_tabla[$i]["nombre_mostrar"];

                            echo "<th>$ct</th>";

                        }
                    }

                    ?>
            </tr>
            </thead>
            <tbody>
            <?php

                $no = 1;
                $row=$cg->ArregloAsociativoSelect($sql, $bd_table);
                $depende=0;
                $campo_depende="";
                for ($i = 0; $i < count($row); $i++)
                {
                    $n=$i+1;
                    $valor_row=$row[$i][$id_table];

                    if(isset($campos_tabla[$i]["dependencia"]))
                    {
                       $list_dep=$campos_tabla[$i]["dependencia"];

                       for ($dp = 0; $dp < count($list_dep); $dp++) 
                       {
                           ##referencia por el id de la tabla, 
                           $tabla_dependencia=$list_dep[$dp]["tabla_dep"];
                           $campo_dependencia=$list_dep[$dp]["campo_dep"];

                           $parametros_d["campo"][0]=$campo_dependencia;
                           $parametros_d["valor"][0]=$valor_row;

                           $cg= new ConsultasG();
                           $r=$cg->GenericSelect($tabla_dependencia, $parametros_d);
                           if($cg->NumeroResultados($r)>0)
                          {

                               $depende++;
                               $campo_depende=$campo_depende.','.$tabla_dependencia;


                          }
                       }


                    }
                    $html="<tr> <td>$n</td><td><a href=$link_perfil?nik=$valor_row>";
                    for ($j = 1; $j < count($campos_tabla)-1; $j++) 
                    {

                        $n_bd=$campos_tabla[$j]["nombre_bd"];
                        if(isset($campos_tabla[$j]["join"]))
                            {
                            if($campos_tabla[$j]["join"]==3)
                                {
                                    /*$tabla1=$campos_tabla[$j]["tabla1"];
                                    $tabla2=$campos_tabla[$j]["tabla2"];
                                    $tabla3=$campos_tabla[$j]["tabla3"];
                                    $camp_seleccionar_t1=$campos_tabla[$j]["camp_seleccionar_t1"];
                                    $camp_seleccionar_t2=$campos_tabla[$j]["camp_seleccionar_t2"];
                                    $camp_seleccionar_t3=$campos_tabla[$j]["camp_seleccionar_t3"];
                                    $camp_filtrar_t2=$campos_tabla[$j]["camp_filtrar_t2"];
                                    //$camp_filtrar_t3=$campos_tabla[$j]["camp_filtrar_t3"];*/
                                    $tabla1=$campos_tabla[$j]["tabla1"];
                                    $tabla2=$campos_tabla[$j]["tabla2"];
                                    $camp_seleccionar_t1=$campos_tabla[$j]["camp_seleccionar_t1"];
                                    $camp_seleccionar_t2=$campos_tabla[$j]["camp_seleccionar_t2"];
                                    $camp_filtrar_t1=$campos_tabla[$j]["camp_filtrar_t1"];
                                    $camp_filtrar_t2=$campos_tabla[$j]["camp_filtrar_t"];

                                    $idt=$row[$i][$camp_filtrar_t2];
                                    //$valor_rowBD=$cg->GenericJoinV2($tabla1, $tabla2, $tabla3, $camp_seleccionar_t1, $camp_seleccionar_t2, $camp_seleccionar_t3,$camp_filtrar_t3, $idt);
                                    $valor_rowBD=$cg->GenericJoinV2($tabla1, $tabla2, $camp_seleccionar_t1, $camp_filtrar_t1, $camp_filtrar_t2, $idt, $camp_seleccionar_t2);
                                    $valor_row=$valor_rowBD;

                                }
                                else
                                {
                                    $tabla1=$campos_tabla[$j]["tabla1"];
                                    $tabla2=$campos_tabla[$j]["tabla2"];
                                    $camp_seleccionar_t1=$campos_tabla[$j]["camp_seleccionar_t1"];
                                    $camp_seleccionar_t2=$campos_tabla[$j]["camp_seleccionar_t2"];
                                    $camp_filtrar_t1=$campos_tabla[$j]["camp_filtrar_t1"];
                                    $camp_filtrar_t2=$campos_tabla[$j]["camp_filtrar_t"];

                                    $idt=$row[$i][$camp_filtrar_t2];
                                    $valor_row=$cg->GenericJoinV1($tabla1, $tabla2, $camp_seleccionar_t1, $camp_filtrar_t1, $camp_filtrar_t2, $idt, $camp_seleccionar_t2);

                                }

                            }
                        else
                            {
                                $valor_row=$row[$i][$n_bd];

                            }




                        if($j==1)
                        {
                             $html=$html."$valor_row</a></td>";
                        }
                        else
                        {
                            if(isset($campos_tabla[$j]["icon_star"]))
                    {
                        ###pintar el icono n veces
                         ##si el numero de estrellas tiene un pintar media estrella
                            $arr_estrellas=  preg_split('[/.]', $valor_row);
                            $num_estrella_entero=$arr_estrellas[0];
                            $estrella_pintada="";

                            if($num_estrella_entero >5){$num_estrella_entero=5;}

                            for ($s = 0; $s< $num_estrella_entero; $s++) 
                            {
                                $estrella_pintada=$estrella_pintada."<i class='fa fa-star text-warning'></i>";
                            }
                            if(count($arr_estrellas)>1 && $num_estrella_entero!=5)
                            {
                                $estrella_pintada=$estrella_pintada."<i class='fa fa-star-half-o'></i>";
                            }
                            $valor_row=$estrella_pintada.' ('.$valor_row.')';
                    }
                            $html=$html. "<td> $valor_row </td>";
                        }
                    } 



                    echo $html;   


                    if(isset($permisos_de_action) && $permisos_de_action==1)
                    {
                        if($elemento_distintivo=="")
                    {
                         echo '
                        <td>
                                 <a href="'.$link_edit.'?nik='.$row[$i][$id_table].'" title="Editar datos" class="btn btn-primary btn-sm"><span class="glyphicon glyphicon-edit" aria-hidden="true"></span></a>

                                 <a href="'.$link_listar.'?action=delete&nik='.$row[$i][$id_table].'&depende='.$depende.'&v='.$entity_name.'" title="Eliminar" onclick="return confirm(\'Esta seguro de borrar los datos  ?\')" class="btn btn-danger btn-sm"><span class="glyphicon glyphicon-trash" aria-hidden="true"></span></a>
                         </td>
                        </tr>
                        ';    
                    }
                    else
                    {
                        echo '
                        <td>
                                 <a href="'.$link_edit.'?nik='.$row[$i][$id_table].'" title="Editar datos" class="btn btn-primary btn-sm"><span class="glyphicon glyphicon-edit" aria-hidden="true"></span></a>

                                 <a href="'.$link_listar.'?action=delete&nik='.$row[$i][$id_table].'&depende='.$depende.'&v='.$row[$i][$elemento_distintivo] .'" title="Eliminar" onclick="return confirm(\'Esta seguro de borrar los datos '.$row[$i][$elemento_distintivo].' ?\')" class="btn btn-danger btn-sm"><span class="glyphicon glyphicon-trash" aria-hidden="true"></span></a>
                         </td>
                        </tr>
                        ';
                    }

                    }
                    else 
                    {
                        echo "<td>---</td>";
                    }
                    $no++;
                }

                $_SESSION['cd']=$campo_depende;
            }


    ?>
        </tbody>
        </table>

    </div>
    </div>
    </div>
</div>

    
    
</section>

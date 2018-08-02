<?php

class ConsultasG
    {
    private $parametros;
    private $tabla;

    public function ConsultasG()
    {     
        $this->parametros=array();
        $this->parametros['campo'][0]="";
        $this->parametros['valor'][0]="";
       
    }
    
    public function GenericSelect($tabla,$parametros)
    {
        $bd= new con_mysqli();
        
            $consulta="Select * from $tabla";
            ###validar si hay campos para comparar
            for ($i = 0; $i < count($parametros['campo']); $i++) 
            {
                
                $campo=$parametros['campo'][$i];
                $valor=$parametros['valor'][$i];
                
                ##validar datos
                $campo=$bd->ValidarCadena($campo);
                $valor=$bd->ValidarCadena($valor);
               
                if(eliminarblancos($campo)!="")
                {
                    if($i==0)
                    {
                        $consulta=$consulta.' '."Where `$campo`='$valor'";
                    }
                    else 
                    {
                         $consulta=$consulta.' '."and `$campo`='$valor'";
                    }
                }
            }
            
            $r=$bd->consulta($consulta);
            
            $bd->Close();
            return $r;

        
    }
    public function GenericSelect2($tabla,$parametros)
    {
        $bd= new con_mysqli();
        
            $consulta="Select * from $tabla";
            ###validar si hay campos para comparar
            for ($i = 0; $i < count($parametros['campo']); $i++) 
            {
                
                $campo=$parametros['campo'][$i];
                $valor=$parametros['valor'][$i];
                
                ##validar datos
                $campo=$bd->ValidarCadena($campo);
                $valor=$bd->ValidarCadena($valor);
               
                if(eliminarblancos($campo)!="")
                {
                    if($i==0)
                    {
                        $consulta=$consulta.' '."Where `$campo`='$valor'";
                    }
                    else 
                    {
                         $consulta=$consulta.' '."and `$campo`='$valor'";
                    }
                }
            }
            Mostrar($consulta);
            $r=$bd->consulta($consulta);
            
            $bd->Close();
            return $r;

        
    }
    
    public function Buscar($tabla,$parametros)
    {
        $bd= new con_mysqli();
        
            $consulta="Select * from $tabla";
            ###validar si hay campos para comparar
            for ($i = 0; $i < count($parametros['campo']); $i++) 
            {
                
                $campo=$parametros['campo'][$i];
                $valor=$parametros['valor'][$i];
                
                ##validar datos
                $campo=$bd->ValidarCadena($campo);
                $valor=$bd->ValidarCadena($valor);
               
                if(eliminarblancos($campo)!="")
                {
                    if($i==0)
                    {
                        $consulta=$consulta.' '."Where `$campo`='$valor'";
                    }
                    else 
                    {
                         $consulta=$consulta.' '."and `$campo`='$valor'";
                    }
                }
            }
            return $consulta;
            $r=$bd->consulta($consulta);
            
            $bd->Close();
            return $r;
    }

    public function NumeroResultados($r)
    {
       $bd= new con_mysqli();
       if($r)
        {
           $bd->Close();
           return $bd->num_row($r);
        }
        $bd->Close();
        return 0;
    }
    
    public function MostrarCamposTabla($tabla)
    {
        $bd= new con_mysqli();
        $consulta="SHOW COLUMNS from $tabla";
        
        $campos=array();
        $a=0;
        $r=$bd->consulta($consulta);
        if($r)
        {
            while ($fila=$bd->fetch_assoc($r))
            {
                $campos[$a]=$fila['Field']; $a++;
            }
        }
         $bd->Close();
         
         return $campos;
    }

    public function ArregloAsociativoSelect($r,$tabla)
    {
       $datos=array();
       $campos=array();
       $a=0;
       $bd= new con_mysqli();
       if($r)
        {
           $campos=$this->MostrarCamposTabla($tabla);
           while ($fila=$bd->fetch_assoc($r))
            {
              for ($i=0;$i<count($campos);$i++)
               {
                   $nomb_campo=$campos[$i];
                   $datos[$a][$nomb_campo]=$fila[$nomb_campo];
               }
                 $a++;
            }
           
        }
        $bd->Close();
        #Mostrar($datos);
        return $datos;
    }
    
    public function GenericDeltePorID($tabla,$nombre_campo,$valor)
    {
        
        $affected=0;
        $bd= new con_mysqli();
        ##validar datos
        $tabla=$bd->ValidarCadena($tabla);
        $nombre_campo=$bd->ValidarCadena($nombre_campo);
        $valor=$bd->ValidarCadena($valor);
        if(eliminarblancos($tabla)!="" && eliminarblancos($nombre_campo)!="")
        {
            $consulta="DELETE FROM `$tabla` WHERE (`$nombre_campo`='$valor')";
            
            $r=$bd->consulta($consulta);
            if($r)
            {
                $affected=$bd->affected_row();
            }
        }
        $bd->Close();
        return $affected;
    }
    
    public function GenericInsert($tabla,$parametros)
    {
        $affected=0;
        $bd= new con_mysqli();
        ##validar datos
        $tabla=$bd->ValidarCadena($tabla);
        $consulta="INSERT INTO `$tabla` ";
        
        $consulta_campos="(";
        $consulta_valores="VALUES (";
        
        if(eliminarblancos($tabla)!="")
        {
            if($parametros["campo"][0]!="")
            {
                for ($i = 0; $i < count($parametros["campo"]); $i++) {
                    
                    
                    $campo=$parametros["campo"][$i];
                    $valor=$parametros["valor"][$i];
                    ##validar campo y valor
                    $campo=$bd->ValidarCadena($campo);
                    $valor=$bd->ValidarCadena($valor);
                    
                    
                    if($i>0){$consulta_campos=$consulta_campos.',';$consulta_valores=$consulta_valores.",";}
                    $consulta_campos=$consulta_campos.'`'.$campo.'`';
                    $consulta_valores=$consulta_valores."'".$valor."'";
                }
                
                ##si se escribió algo cerrar las etiquetas
                if($consulta_campos!="(")
                {
                    $consulta_campos=$consulta_campos.")";
                    $consulta_valores=$consulta_valores.")";
                }
                ##completar la consulta
                $consulta=$consulta.' '.$consulta_campos. ' '. $consulta_valores;
                //Mostrar($consulta);
                $r=$bd->consulta($consulta);
                {
                    $affected=$bd->affected_row();
                }
                $bd->Close();
                return $affected;
            }
        }
         $bd->Close();
        return $affected;
    }
     public function GenericInsert2($tabla,$parametros)
    {
        $affected=0;
        $bd= new con_mysqli();
        ##validar datos
        $tabla=$bd->ValidarCadena($tabla);
        $consulta="INSERT INTO `$tabla` ";
        
        $consulta_campos="(";
        $consulta_valores="VALUES (";
        
        if(eliminarblancos($tabla)!="")
        {
            if($parametros["campo"][0]!="")
            {
                for ($i = 0; $i < count($parametros["campo"]); $i++) {
                    
                    
                    $campo=$parametros["campo"][$i];
                    $valor=$parametros["valor"][$i];
                    ##validar campo y valor
                    $campo=$bd->ValidarCadena($campo);
                    $valor=$bd->ValidarCadena($valor);
                    
                    
                    if($i>0){$consulta_campos=$consulta_campos.',';$consulta_valores=$consulta_valores.",";}
                    $consulta_campos=$consulta_campos.'`'.$campo.'`';
                    $consulta_valores=$consulta_valores."'".$valor."'";
                }
                
                ##si se escribió algo cerrar las etiquetas
                if($consulta_campos!="(")
                {
                    $consulta_campos=$consulta_campos.")";
                    $consulta_valores=$consulta_valores.")";
                }
                ##completar la consulta
                $consulta=$consulta.' '.$consulta_campos. ' '. $consulta_valores;
                Mostrar($consulta);
                $r=$bd->consulta($consulta);
                {
                    $affected=$bd->affected_row();
                }
                $bd->Close();
                return $affected;
            }
        }
         $bd->Close();
        return $affected;
    }
    public function GenericUpdate($tabla,$parametros,$id_nombre,$id_valor)
    {
        
        $affected=0;
        $bd= new con_mysqli();
        ##validar datos
        $tabla=$bd->ValidarCadena($tabla);
        $consulta="UPDATE `$tabla` SET ";
       
        
        if(eliminarblancos($tabla)!="")
        {
            if($parametros["campo"][0]!="")
            {
                for ($i = 0; $i < count($parametros["campo"]); $i++) {
                    
                    $campo=$parametros["campo"][$i];
                    $valor=$parametros["valor"][$i];
                    ##validar campo y valor
                    $campo=$bd->ValidarCadena($campo);
                    $valor=$bd->ValidarCadena($valor);
                    
                    
                    
                    if($i>0){$consulta=$consulta.',';}
                    $consulta=$consulta.'`'.$campo.'`='."'".$valor."'" ; 
                }
                $consulta=$consulta." Where `$id_nombre`='$id_valor'";
                //Mostrar($consulta);
                $r=$bd->consulta($consulta);
                {
                    $affected=$bd->affected_row();
                    if($affected==0){$affected=1;}
                }
                 
                $bd->Close();
                return $affected;
            }
        }
         $bd->Close();
        return $affected;
    }

    public function DistintTrabajador()
    {
        ##devuelve el nombre y el id del usuario que es trabajador y esta activo
        $datos=array();
        $bd= new con_mysqli();
        $a=0;
            $consulta="select DISTINCT usuario.nombre, id_usuario FROM usuario WHERE  usuario.id_tipo_usuario='1' or usuario.id_tipo_usuario='3' or usuario.id_tipo_usuario='5' or usuario.id_tipo_usuario='6' and usuario.estado='activo'";
           # Mostrar($consulta);
            $r=$bd->consulta($consulta);
            if($r)
            {
                ###creo arreglo asociativo con los nombres de los campos de la tabla
                 while ($fila=$bd->fetch_assoc($r))
                 {
                    $datos[$a]['nombre']=$fila['nombre'];
                    $datos[$a]['id_trabajador']=$fila['id_usuario'];
                     $a++;
                 }
            }
       
        
        return $datos;
    }

    public function Distint($tabla,$campo,$id_campo)
    {
        $datos=array();
        $bd= new con_mysqli();
        $a=0;
        ###validar inysql
        $campo=$bd->ValidarCadena($campo);
        $tabla=$bd->ValidarCadena($tabla);
        $id_campo=$bd->ValidarCadena($id_campo);
        
        if(eliminarblancos($campo)!="" && eliminarblancos($tabla)!="")
        {
            $consulta="Select DISTINCT $campo,$id_campo FROM $tabla";
           # Mostrar($consulta);
            $r=$bd->consulta($consulta);
            if($r)
            {
                ###creo arreglo asociativo con los nombres de los campos de la tabla
                 while ($fila=$bd->fetch_assoc($r))
                 {
                    $datos[$a][$campo]=$fila[$campo];
                    $datos[$a][$id_campo]=$fila[$id_campo];
                     $a++;
                 }
            }
        }
        
        return $datos;
    
    }
    public function GenericJoinV1($tabla1,$tabla2,$campo_seleccionar_t1,$campo_filtrar_t1,$campo_filtrar_t2,$valor_filtrar_t2,$campo_seleccionar_t2)
    {
        $valor="";
        $bd= new con_mysqli();
        $a=0;
        ###validar inysql
        $tabla1=  eliminarblancos($bd->ValidarCadena($tabla1));
        $tabla2=eliminarblancos($bd->ValidarCadena($tabla2));
        $campo_seleccionar_t1=eliminarblancos($bd->ValidarCadena($campo_seleccionar_t1));
        $campo_seleccionar_t2=eliminarblancos($bd->ValidarCadena($campo_seleccionar_t2));
        $campo_filtrar_t1=eliminarblancos($bd->ValidarCadena($campo_filtrar_t1));
        $campo_filtrar_t2=eliminarblancos($bd->ValidarCadena($campo_filtrar_t2));
        $valor_filtrar_t2=eliminarblancos($bd->ValidarCadena($valor_filtrar_t2));
        
        $consulta="SELECT $campo_seleccionar_t1 from $tabla1 WHERE $campo_filtrar_t1  in (SELECT $campo_seleccionar_t2 from $tabla2 where $campo_filtrar_t2='$valor_filtrar_t2')";
        //Mostrar($consulta);
        $r=$bd->consulta($consulta);
        if($r)
        {
            if($campo_seleccionar_t1!='*')
            {
                $fila=$bd->fetch_array($r);
                $valor=$fila[0];
            }
            else 
            {
                $valor=array();
                $valor= $this->ArregloAsociativoSelect($r, $tabla1);
            }
            
        }
        return $valor;
    }
     public function GenericJoinV2($tabla1,$tabla2,$campo_seleccionar_t1,$campo_filtrar_t1,$campo_filtrar_t2,$valor_filtrar_t2,$campo_seleccionar_t2)
    {
        $valor="";
        $bd= new con_mysqli();
        $a=0;
        ###validar inysql
        $tabla1=  eliminarblancos($bd->ValidarCadena($tabla1));
        $tabla2=eliminarblancos($bd->ValidarCadena($tabla2));
        $campo_seleccionar_t1=eliminarblancos($bd->ValidarCadena($campo_seleccionar_t1));
        $campo_seleccionar_t2=eliminarblancos($bd->ValidarCadena($campo_seleccionar_t2));
        $campo_filtrar_t1=eliminarblancos($bd->ValidarCadena($campo_filtrar_t1));
        $campo_filtrar_t2=eliminarblancos($bd->ValidarCadena($campo_filtrar_t2));
        $valor_filtrar_t2=eliminarblancos($bd->ValidarCadena($valor_filtrar_t2));
        
        $consulta="SELECT $campo_seleccionar_t1 from $tabla1 WHERE $campo_filtrar_t1  = (SELECT $campo_seleccionar_t2 from $tabla2 where $campo_filtrar_t2='$valor_filtrar_t2')";
        //Mostrar($consulta);
        $r=$bd->consulta($consulta);
        if($r)
        {
           //$datos= $this->ArregloAsociativoSelect($r, $tabla1);
            $fila=$bd->fetch_array($r);
            $valor=$fila[0];
        }
        return $valor;
    }
    public function GenericJoinV3($tabla1,$tabla2,$tabla3,$tabla1_campo,$tabla2_campo,$tabla3_campo,$campo_filtrart3,$valor_filtrar_t3)
    {
        $datos=array();
        $bd= new con_mysqli("", "", "", "");
        $a=0;
        ###validar inysql
        $tabla1=  eliminarblancos($bd->ValidarCadena($tabla1));
        $tabla2=eliminarblancos($bd->ValidarCadena($tabla2));
        $tabla3=eliminarblancos($bd->ValidarCadena($tabla3));
        $tabla1_campo=eliminarblancos($bd->ValidarCadena($tabla1_campo));
        $tabla2_campo=eliminarblancos($bd->ValidarCadena($tabla2_campo));
        $tabla3_campo=eliminarblancos($bd->ValidarCadena($tabla3_campo));
        $valor_filtrar_t3=eliminarblancos($bd->ValidarCadena($valor_filtrar_t3));
        $campo_filtrart3= eliminarblancos($campo_filtrart3);
        
        
        #$consulta="SELECT usuario.nombre,trabajador.id_usuario from usuario join trabajador WHERE trabajador.id_trabajador in (SELECT proyecto.id_trabajador FROM proyecto WHERE proyecto.id_trabajador='1')";
        $consulta="SELECT *  from $tabla1 join $tabla2 WHERE $tabla2.$tabla2_campo in (SELECT $tabla3_campo FROM $tabla3 WHERE $campo_filtrart3='$valor_filtrar_t3')";
        #$consulta="SELECT $campo_seleccionar_t1 from $tabla1 WHERE $campo_filtrar_t1  in (SELECT $campo_seleccionar_t2 from $tabla2 where $campo_filtrar_t2='$valor_filtrar_t2')";
       //Mostrar($consulta);
        $r=$bd->consulta($consulta);
        if($r)
        {
           $datos= $this->ArregloAsociativoSelect($r, $tabla1);
        }
        
        return $datos;
    }
    
    function Login($user,$pass)
    {
      
        $bd= new con_mysqli();
        ##validar iny sql
        $user=$bd->ValidarCadena($user);
        $pass=$bd->ValidarCadena($pass);
        
        $md5_pass=  md5($pass);
        
        $consulta="SELECT * FROM `usuario` WHERE `user` = '$user' AND `pass` = '$pass'";
        $r=$bd->consulta($consulta);
        if($r)
        {
            $cant=$this->NumeroResultados($r);
            if($cant!=0){ return true;}
        }
        
        return false;

    }
    
    public function documentacio($id_proyecto)
    {
        ##cargar arreglo de datos de la doc
        $d=0;
        $documentacion[$d]["nombre_doc"]="Diagnostico de la empresa";
        $documentacion[$d]["nomb_entidad"]="diagnostico_empresa";
        $documentacion[$d]['campo_q_une']="id_proyecto";
        $documentacion[$d]['id_tabla']="";##solo si lo encuentra
        $documentacion[$d]['id']="id_diagnostico_emp";
        $documentacion[$d]['representa']=10;
        $documentacion[$d]['url']="diagnostico_perfil.php";
        $d++;
        $documentacion[$d]["nombre_doc"]="Ficha de la empresa";
        $documentacion[$d]["nomb_entidad"]="ficha_empresa_cliente";
        $documentacion[$d]['campo_q_une']="id_proyecto";
         $documentacion[$d]['id_tabla']="";##solo si lo encuentra
        $documentacion[$d]['representa']=10;
         $documentacion[$d]['id']="id_ficha";
         $documentacion[$d]['url']="ficha_perfil.php";
        $d++;
        $documentacion[$d]["nombre_doc"]="Analisis de la competiencia";
        $documentacion[$d]["nomb_entidad"]="analisis_comp";
        $documentacion[$d]['campo_q_une']="id_proyecto";
         $documentacion[$d]['id_tabla']="";##solo si lo encuentra
        $documentacion[$d]['representa']=10;
          $documentacion[$d]['id']="id_analisis";
          $documentacion[$d]['url']="analisis_perfil.php";
        $d++;
       
        $documentacion[$d]["nombre_doc"]="Prototipo de cliente";
        $documentacion[$d]["nomb_entidad"]="analisis_comp";
        $documentacion[$d]['campo_q_une']="id_proyecto";
         $documentacion[$d]['id_tabla']="";##solo si lo encuentra
        $documentacion[$d]['representa']=10;
         $documentacion[$d]['id']="id_prototipo";
         $documentacion[$d]['url']="#";
        $d++;
        $documentacion[$d]["nombre_doc"]="Segmentacion";
        $documentacion[$d]["nomb_entidad"]="segmentacion";
        $documentacion[$d]['campo_q_une']="id_proyecto";
         $documentacion[$d]['id_tabla']="";##solo si lo encuentra
        $documentacion[$d]['representa']=10;
         $documentacion[$d]['id']="id_segmentacion";
         $documentacion[$d]['url']="#";
        $d++;
        $documentacion[$d]["nombre_doc"]="Matriz Foda";
        $documentacion[$d]["nomb_entidad"]="matrizf";
        $documentacion[$d]['campo_q_une']="id_proyecto";
         $documentacion[$d]['id_tabla']="";##solo si lo encuentra
        $documentacion[$d]['representa']=10;
         $documentacion[$d]['id']="id_matriz";
         $documentacion[$d]['url']="#";
        $d++;
         $documentacion[$d]["nombre_doc"]="Plan de Marketing";
        $documentacion[$d]["nomb_entidad"]="planm";
        $documentacion[$d]['campo_q_une']="id_proyecto";
         $documentacion[$d]['id_tabla']="";##solo si lo encuentra
        $documentacion[$d]['representa']=10;
        $documentacion[$d]['id']="id_plan";
        $documentacion[$d]['url']="#";
        $d++;
         $documentacion[$d]["nombre_doc"]="Referencia de Estilos";
        $documentacion[$d]["nomb_entidad"]="referenciaEstilos";
        $documentacion[$d]['campo_q_une']="id_proyecto";
         $documentacion[$d]['id_tabla']="";##solo si lo encuentra
        $documentacion[$d]['representa']=10;
        $documentacion[$d]['id']="id_referencia";
        $documentacion[$d]['url']="#";
        $d++;
         $documentacion[$d]["nombre_doc"]="Objetivos 4P";
        $documentacion[$d]["nomb_entidad"]="objetivos4p";
        $documentacion[$d]['campo_q_une']="id_proyecto";
         $documentacion[$d]['id_tabla']="";##solo si lo encuentra
        $documentacion[$d]['representa']=10;
         $documentacion[$d]['id']="id_objetivo";
         $documentacion[$d]['url']="#";
        $d++;
        $documentacion[$d]["nombre_doc"]="Planes de Campa&ntilde;a";
        $documentacion[$d]["nomb_entidad"]="planesC";
        $documentacion[$d]['campo_q_une']="id_proyecto";
         $documentacion[$d]['id_tabla']="";##solo si lo encuentra
        $documentacion[$d]['representa']=10;
         $documentacion[$d]['id']="id_planes";
         $documentacion[$d]['url']="#";
        $d++;
        $documentacion[$d]["nombre_doc"]="Acciones de Campa&ntilde;a";
        $documentacion[$d]["nomb_entidad"]="accionesC";
        $documentacion[$d]['campo_q_une']="id_proyecto";
         $documentacion[$d]['id_tabla']="";##solo si lo encuentra
        $documentacion[$d]['representa']=10;
         $documentacion[$d]['id']="id_acciones";
         $documentacion[$d]['url']="#";
       
        
        ###validar si existe el id de proyecto en alguna de estas tablas
        
        $cg=new ConsultasG();
        for ($i = 0; $i < count($documentacion); $i++) {
            
            $tabla=$documentacion[$i]['nomb_entidad'];
            $campoUne= $documentacion[$i]['campo_q_une'];
            $p['campo'][0]=$campoUne;
            $p['valor'][0]=$id_proyecto;
            $r=$cg->GenericSelect($tabla, $p);
            $arr_res=$cg->ArregloAsociativoSelect($r, $tabla);
            $nombre_id_enTabla=$documentacion[$i]['id'];
            if(count($arr_res)>0)
            {
                 @$documentacion[$i]['id_tabla']=$arr_res[0][$nombre_id_enTabla];
            }
            
        }
        
        return $documentacion;
        
        
    }
    ###funciones para Modulo agenda
    function BuscarTareas($fecha,$id_campanna)
    {
        $datos=array();
        $bd= new con_mysqli();
        ##validar iny sql
        $fecha=$bd->ValidarCadena($fecha);
        $id_campanna=$bd->ValidarCadena($id_campanna);
        ###ordenado por hora
        $consulta="SELECT * from acciones_campanna where fecha='$fecha' and id_campana='$id_campanna' ORDER BY hora ASC";
        #Mostrar($consulta);
        $r=$bd->consulta($consulta);
        if($r)
        {
            $datos=  $this->ArregloAsociativoSelect($r, 'acciones_campanna');
        }
        
        return $datos;
    }
    function BuscarTareasFecha($id_campanna)
    {
        $datos=array();
        $bd= new con_mysqli();
        ##validar iny sql
        $id_campanna=$bd->ValidarCadena($id_campanna);
        ###ordenado por hora
        $consulta="SELECT * from acciones_campanna where id_campana='$id_campanna' ORDER BY fecha ASC";
        #Mostrar($consulta);
        $r=$bd->consulta($consulta);
        if($r)
        {
            $datos=  $this->ArregloAsociativoSelect($r, 'acciones_campanna');
        }
        
        return $datos;
    }
    
    function EstadosTareasCampanna($id_campanna)
    {
        $tareas=array();
        $tareas['creadas']=0;
        $tareas['publicadas']=0;
        $tareas['aprobadas']=0;
        $tareas['pendientes']=0;
        $tareas['expiradas']=0;
        
        $bd=new con_mysqli();
        $id_campanna=$bd->ValidarCadena($id_campanna);
        ##estado=CREADO
        $consulta="SELECT COUNT(acciones_campanna.id_acc) FROM acciones_campanna WHERE acciones_campanna.id_campana='$id_campanna' and acciones_campanna.estado='CREADO'";
        $r=$bd->consulta($consulta);
        if($r){$fila=$bd->fetch_array($r); $tareas['creadas']=$fila;}
        ##estado=PUBLICADO
        $consulta="SELECT COUNT(acciones_campanna.id_acc) FROM acciones_campanna WHERE acciones_campanna.id_campana='$id_campanna' and acciones_campanna.estado='PUBLICADO'";
        $r=$bd->consulta($consulta);
        if($r){$fila=$bd->fetch_array($r); $tareas['publicadas']=$fila;}
        ##estado=APROBADO
        $consulta="SELECT COUNT(acciones_campanna.id_acc) FROM acciones_campanna WHERE acciones_campanna.id_campana='$id_campanna' and acciones_campanna.estado='APROBADO'";
        $r=$bd->consulta($consulta);
        if($r){$fila=$bd->fetch_array($r); $tareas['aprobadas']=$fila;}
        ##estado=PENDIENTE
        $consulta="SELECT COUNT(acciones_campanna.id_acc) FROM acciones_campanna WHERE acciones_campanna.id_campana='$id_campanna' and acciones_campanna.estado='PENDIENTE'";
        $r=$bd->consulta($consulta);
        if($r){$fila=$bd->fetch_array($r); $tareas['pendientes']=$fila;}
        ##estado=EXPIRADO
        $consulta="SELECT COUNT(acciones_campanna.id_acc) FROM acciones_campanna WHERE acciones_campanna.id_campana='$id_campanna' and acciones_campanna.estado='EXPIRADO'";
        $r=$bd->consulta($consulta);
        if($r){$fila=$bd->fetch_array($r); $tareas['expiradas']=$fila;}
        
        $bd->Close();
        return $tareas;
    }
    
    function UsuariosPermitidos($id_tarea,$id_user_logueado)
    {
        $bd=new con_mysqli();
        $id_tarea=$bd->ValidarCadena($id_tarea);
        
        $id_usuario="";
        ##devuelve el id del usuario responsable de la tarea por parametros
        $consulta="SELECT trabajador.id_usuario from trabajador where trabajador.id_usuario 
                    in (SELECT id_trabajador from proyecto where proyecto.id_proyecto in 
                    (SELECT id_proyecto from campana WHERE id_campana in (SELECT id_campana
                    from acciones_campanna WHERE acciones_campanna.id_acc='$id_tarea')))";
        
        $r=$bd->consulta($consulta);
        if($r)
        {
            $fila=$bd->fetch_array($r);
            $id_usuario=$fila[0];
        }
        $bd->Close();
        if($id_user_logueado==$id_usuario){return true;}
        return false;
        
    }
    
    function NotificarTareasSemanas($id_usuario,$id_tipo_usuario)
    {
        $fecha_actual= FechaYMA();
        $f='';
        $datos_urgente=array();
        $datos_medio=array();
        $datos_casi=array();
        $bd= new con_mysqli();
        ##validar datos
        $id_tipo_usuario=$bd->ValidarCadena($id_tipo_usuario);
        $id_usuario=$bd->ValidarCadena($id_usuario);
        $fecha_actual=$bd->ValidarCadena($fecha_actual);
        $mes="";
        $anno="";
        $dia="";
        $arr_fecha= preg_split("/[-]/", $fecha_actual);
        $fecha_urgente="";# desde el inicio del mes a casi 2 dias
        $fecha_medio="";# de 3 a 4 dias
        $fecha_casi="";# de 4 a 7 dias
        $not=array();
        $not['urgente']=$datos_urgente;
        $not['medio']=$datos_medio;
        $not["casi"]=$datos_casi;
        if(count($arr_fecha)==3)
        {
            $fecha_inicio_mes=$anno."-".$mes."-01";
            $f=$arr_fecha[0].'-'.$arr_fecha[1];
            $anno=$arr_fecha[0];
            $mes=$arr_fecha[1];
            $dia=$arr_fecha[2];
            
            ##eliminar el 0 delante del numero
            //$dia= preg_replace("/[0]/",'',$dia);
            if($dia<10){if($dia=='0'.$dia){$dia= preg_replace("/[0]/",'',$dia);}}
            
            $cant_dias_mes= cantidadDiasMes($mes, $anno);
            $d_urgente=$dia+2;
            if($d_urgente>$cant_dias_mes){$d_urgente=$cant_dias_mes;}
            if($d_urgente<10){$d_urgente='0'.$d_urgente;}
            $fecha_urgente=$anno.'-'.$mes.'-'.$d_urgente;
            
            $d_medio=$dia+4;
            if($d_medio>$cant_dias_mes){$d_medio=$cant_dias_mes;}
            if($d_medio<10){$d_medio='0'.$d_medio;}
            $fecha_medio=$anno.'-'.$mes.'-'.$d_medio;
            
            $d_casi=$dia+7;
            if($d_casi>$cant_dias_mes){$d_casi=$cant_dias_mes;}
            if($d_casi<10){$d_casi='0'.$d_casi;}
            $fecha_casi=$anno.'-'.$mes.'-'.$d_casi;
        }
        
        ##selecciona todas las tareas que sean del año y mes actual
        $consulta="SELECT * FROM `acciones_campanna` WHERE estado!='PUBLICADO' and fecha BETWEEN '$fecha_inicio_mes' and '$fecha_urgente' order by fecha";
        $r=$bd->consulta($consulta);
        if($r)
        {
            $datos_urgente= $this->ArregloAsociativoSelect($r, 'acciones_campanna');
        }
        $consulta="SELECT * FROM `acciones_campanna` WHERE estado!='PUBLICADO' and fecha BETWEEN '$fecha_urgente' and '$fecha_medio' order by fecha";
        $r=$bd->consulta($consulta);
        if($r)
        {
            $datos_medio= $this->ArregloAsociativoSelect($r, 'acciones_campanna');
        }
        $consulta="SELECT * FROM `acciones_campanna` WHERE estado!='PUBLICADO' and fecha BETWEEN '$fecha_medio' and '$fecha_casi' order by fecha";
        $r=$bd->consulta($consulta);
        if($r)
        {
            $datos_casi= $this->ArregloAsociativoSelect($r, 'acciones_campanna');
        }
        
      
        ##si el usuario es admin mostrar todas las tareas sin importar las campanna
        if($id_tipo_usuario==1 ||$id_tipo_usuario==5 || $id_tipo_usuario==6)
        { 
            $not['urgente']=$datos_urgente;
            $not['medio']=$datos_medio;
            $not["casi"]=$datos_casi;
        }
        if($id_tipo_usuario==3)
        {
            $u=0;
            for ($i = 0; $i < count($datos_urgente); $i++) 
            {
                $id_tarea=$datos_urgente[$i]['id_acc'];
                $permitido= $this->UsuariosPermitidos($id_tarea, $id_usuario);
                
                if($permitido)
                {
                    $not['urgente'][$u]=$datos_urgente[$i];$u++;
                }
            }
            $m=0;
            for ($i = 0; $i < count($datos_medio); $i++) 
            {
                $id_tarea=$datos_medio[$i]['id_acc'];
                $permitido= $this->UsuariosPermitidos($id_tarea, $id_usuario);
                if($permitido)
                {
                    $not['medio'][$m]=$datos_medio[$i];$m++;
                }
            }
            $c=0;
            for ($i = 0; $i < count($datos_casi); $i++) 
            {
                $id_tarea=$datos_casi[$i]['id_acc'];
                $permitido= $this->UsuariosPermitidos($id_tarea, $id_usuario);
                if($permitido)
                {
                    $not['casi'][$c]=$datos_casi[$i];$c++;
                }
            }
        }
        
            $bd->Close();
            return $not;
        
    }
    
    function ComentariosTarea($id_tarea)
    {
        ##devuelve solo los comentarios de una tarea
        $datos=array();
        $comentarios=array();
        $bd=new con_mysqli();
        $id_tarea=$bd->ValidarCadena($id_tarea);
        
        $consulta="SELECT * from logs_tareas WHERE id_tarea='$id_tarea' ORDER BY fecha_accion ASC";
        $r=$bd->consulta($consulta);
        if($r)
        {
            $a=0;
            $comentarios= $this->ArregloAsociativoSelect($r, 'logs_tareas');
            if(count($comentarios)>0)
            {
                for ($i = 0; $i < count($comentarios); $i++) 
                {
                  $c=$comentarios[$i]['comentario'];  
                  if($c!="" || $c!=NULL)
                  {
                      $datos[$a]=$c;
                      $a++;
                  }
                }
            }
        }
        $bd->Close();
        return $datos;
    }
    
    function Aprobar($id_tarea)
    {
        $affected=0;
        ##solo modifica el estado a aprobado
        $bd= new con_mysqli();
        $id_tarea=$bd->ValidarCadena($id_tarea);
        $consulta="UPDATE `acciones_campanna` SET `estado`='APROBADO' WHERE (`id_acc`='$id_tarea')";
        
        $r=$bd->consulta($consulta);
        if($r)
        {
            $affected=$bd->affected_row();
        }
        $bd->Close();
        return $affected;
    }
    
    function SalarioTrabajadores($mes,$anno,$id_usuario)
    {
        $datos=array();
        $bd= new con_mysqli();
        $mes=$bd->ValidarCadena($mes);
        $anno=$bd->ValidarCadena($anno);
        $id_usuario=$bd->ValidarCadena($id_usuario);
        if($mes<10){$mes='0'.$mes;}
        $consulta="SELECT * FROM egreso_salario WHERE  id_usuario='$id_usuario' and mes='$mes' and anno='$anno'";
        
        $r=$bd->consulta($consulta);
        if($r)
        {
            $datos=$this->ArregloAsociativoSelect($r, 'egreso_salario');
            
        }
        $bd->Close();
      
        return $datos;
    }
    
    
    ##todos los usuarios que sean trabajador y no esten inactivos en la fecha actual
    function ListaTrabajadoresSalario($fecha_inicio,$fech_fin)
    {
        $datos=array();
        $bd= new con_mysqli();
        $fech_fin=$bd->ValidarCadena($fech_fin);
        $fecha_inicio=$bd->ValidarCadena($fecha_inicio);
        $consulta="SELECT * from usuario WHERE usuario.id_usuario in (SELECT trabajador.id_usuario from trabajador where  fecha_baja is NULL or trabajador.fecha_baja BETWEEN '$fecha_inicio' and '$fech_fin')";
        #Mostrar($consulta);
        $r=$bd->consulta($consulta);
        if($r)
        {
            $datos= $this->ArregloAsociativoSelect($r, 'usuario');
        }
        $bd->Close();
        return $datos;
    }
    
    function ValidarfechaPago($mes,$anno,$id_usuario)
    {
        ##Para saber si ya se le pago o no a un usuario en el mes seleccionado
        ##si se le pago devuelve falso
        ##si no se encontro nada devuelve true
        $bd= new con_mysqli();
        $mes=$bd->ValidarCadena($mes);
        $anno=$bd->ValidarCadena($anno);
        $id_usuario=$bd->ValidarCadena($id_usuario);
        $consulta="SELECT * FROM `egreso_salario` WHERE `mes` ='$mes' and `anno`='anno' and id_usuario='$id_usuario'";
       //Mostrar($consulta);
        $r=$bd->consulta($consulta);
        if($r)
        {
            $n= $this->NumeroResultados($r);
            if($n>0){return false;}
        }
        
        return true;
    }
    
    function PublicidadEgresos($fecha_like)
    {
        $datos=array();
        $bd= new con_mysqli();
        $fecha_like=$bd->ValidarCadena($fecha_like);
      
        $consulta="SELECT * FROM `proyecto` WHERE `estado_proyecto` = 'activo' AND (`fecha_fin` IS NULL OR `fecha_fin` LIKE '$fecha_like')";
        //Mostrar($consulta);
        $r=$bd->consulta($consulta);
        if($r)
        {
            $datos= $this->ArregloAsociativoSelect($r, 'proyecto');
        }
        $bd->Close();
        return $datos;
    }
    function ValidarfechaPagoPublicitarios($mes,$anno,$id_proyecto)
    {
        ##Para saber si ya se le pago o no a un usuario en el mes seleccionado
        ##si se le pago devuelve falso
        ##si no se encontro nada devuelve true
        $bd= new con_mysqli();
        $mes=$bd->ValidarCadena($mes);
        $anno=$bd->ValidarCadena($anno);
        $id_proyecto=$bd->ValidarCadena($id_proyecto);
        if($mes<10){$mes='0'.$mes;}
        $consulta="SELECT * FROM `egreso_publicitario` WHERE `mes`='$mes' and `anno`='$anno' and `id_proyecto`='$id_proyecto'";
       // Mostrar($consulta);
        $r=$bd->consulta($consulta);
        if($r)
        {
            $n= $this->NumeroResultados($r);
            if($n>0){return false;}
        }
        
        return true;
    }
    function EgresoPublicitario($mes,$anno,$id_proyecto)
    {
        ##devuelve los datos de un egreso publicitario para un proyecto en una fecha x
        $datos=array();
        $bd= new con_mysqli();
        $anno=$bd->ValidarCadena($anno);
        $mes=$bd->ValidarCadena($mes);
        $id_proyecto=$bd->ValidarCadena($id_proyecto);
        if($mes<10){$mes='0'.$mes;}
        $consulta="SELECT * FROM egreso_publicitario WHERE  id_proyecto='$id_proyecto' and `mes`='$mes' and `anno`='$anno'";
        //Mostrar($consulta);
        $r=$bd->consulta($consulta);
        if($r)
        {
            $datos=$this->ArregloAsociativoSelect($r, 'egreso_publicitario');
            
        }
        $bd->Close();
      
        return $datos;
    }
    
    public function ListaGastosPorCategoria($id_categoria_gasto,$mes,$anno)
    {
        $datos=array();
        $bd= new con_mysqli();
        $anno=$bd->ValidarCadena($anno);
        $mes=$bd->ValidarCadena($mes);
        $id_categoria_gasto=$bd->ValidarCadena($id_categoria_gasto);
        $consulta="SELECT * from gastos WHERE id_item =(SELECT id_item from item WHERE item.id_categoria_costo='$id_categoria_gasto' and mes='$mes' and anno='$anno')";
        //Mostrar($consulta);
        $r=$bd->consulta($consulta);
        if($r)
        {
            $datos=$this->ArregloAsociativoSelect($r, 'egreso_publicitario');
            
        }
        $bd->Close();
      
        return $datos;
    }
    function ValidarfechaPagoGastos($mes,$anno,$id_item)
    {
        ##Para saber si ya se registro o no un gasto en el mes seleccionado
        ##si se le pago devuelve falso
        ##si no se encontro nada devuelve true
        $bd= new con_mysqli();
        $mes=$bd->ValidarCadena($mes);
        $anno=$bd->ValidarCadena($anno);
        $id_item=$bd->ValidarCadena($id_item);
        $consulta="SELECT * FROM `gastos` WHERE `mes` ='$mes' and `anno`='anno' and id_item='$id_item'";
       //Mostrar($consulta);
        $r=$bd->consulta($consulta);
        if($r)
        {
            $n= $this->NumeroResultados($r);
            if($n>0){return false;}
        }
        
        return true;
    }
    function Ingresos($mes,$anno,$id_proyecto)
    {
        ##devuelve los datos de un egreso publicitario para un proyecto en una fecha x
        $datos=array();
        $bd= new con_mysqli();
        $anno=$bd->ValidarCadena($anno);
        $mes=$bd->ValidarCadena($mes);
        $id_proyecto=$bd->ValidarCadena($id_proyecto);
        if($mes<10){$mes='0'.$mes;}
        $consulta="SELECT * FROM ingresos WHERE  id_proyecto='$id_proyecto' and `mes`='$mes' and `anno`='$anno'";
        //Mostrar($consulta);
        $r=$bd->consulta($consulta);
        if($r)
        {
            $datos=$this->ArregloAsociativoSelect($r, 'ingresos');
            
        }
        $bd->Close();
      
        return $datos;
    }
    
    function ValidarfechaIngresos($mes,$anno,$id_proyecto)
    {
        ##Para saber si ya se le pago o no a un usuario en el mes seleccionado
        ##si se le pago devuelve falso
        ##si no se encontro nada devuelve true
        $bd= new con_mysqli();
        $mes=$bd->ValidarCadena($mes);
        $anno=$bd->ValidarCadena($anno);
        $id_proyecto=$bd->ValidarCadena($id_proyecto);
       // if($mes<10){$mes='0'.$mes;}
        $consulta="SELECT * FROM `ingresos` WHERE `mes`='$mes' and `anno`='$anno' and `id_proyecto`='$id_proyecto'";
        //Mostrar($consulta);
        $r=$bd->consulta($consulta);
        if($r)
        {
            $n= $this->NumeroResultados($r);
            if($n>0){$bd->Close();return false;}
        }
        $bd->Close();
        return true;
    }
    
    function ListaTotalIngresosMesAnno($mes,$anno)
    {
        $total=0;
        $bd= new con_mysqli();
        $mes=$bd->ValidarCadena($mes);
        $anno=$bd->ValidarCadena($anno);
        
        if($mes!='0'.$mes && $mes<10){$mes='0'.$mes;}
        $consulta="SELECT SUM(ingresos.pago) as total from ingresos WHERE mes='$mes' and anno='$anno'";
        //Mostrar($consulta);
        $r=$bd->consulta($consulta);
        if($r)
        {
            $fila=$bd->fetch_array($r);
            $total=$fila[0];
        }
        
        $bd->Close();
        return $total;
    }
    function ListaTotalIngresosRango($mes1,$mes2,$anno1,$anno2)
    {
        $total=0;
        $bd= new con_mysqli();
        $mes1=$bd->ValidarCadena($mes1);
        $mes2=$bd->ValidarCadena($mes2);
        $anno1=$bd->ValidarCadena($anno1);
        $anno2=$bd->ValidarCadena($anno2);
        
         if($mes1!='0'.$mes1 && $mes1<10){$mes1='0'.$mes1;}
        if($mes2!='0'.$mes2 && $mes2<10){$mes2='0'.$mes2;}
        $consulta="SELECT SUM(ingresos.pago) as total from ingresos WHERE mes>='$mes1' and mes<='$mes2' and anno>='$anno1'and anno<='$anno2'";
        $r=$bd->consulta($consulta);
        if($r)
        {
            $fila=$bd->fetch_array($r);
            $total=$fila[0];
        }
        
        $bd->Close();
        return $total;
    }
    function TotalgastoPorIdCategoriamesAnno($mes,$anno,$id_categoria)
    {
        $datos=array();
        $bd= new con_mysqli();
        $mes=$bd->ValidarCadena($mes);
        $anno=$bd->ValidarCadena($anno);
        $id_categoria=$bd->ValidarCadena($id_categoria);
        if($mes!='0'.$mes && $mes<10){$mes='0'.$mes;}

        $consulta="SELECT SUM(pago) from gastos WHERE mes='$mes' and anno='$anno' and id_item in (SELECT id_item FROM item WHERE item.id_categoria_costo='$id_categoria')";
        //Mostrar($consulta);
        $r=$bd->consulta($consulta);
        if($r)
        {
            $fila=$bd->fetch_array($r);
            $total=$fila[0];
        }
        $bd->Close();
        return $total;
        
    }
    
    function TotalesGastosPorCategorias($mes,$anno)
    {
        $datos=array();
        $bd= new con_mysqli();
        $mes=$bd->ValidarCadena($mes);
        $anno=$bd->ValidarCadena($anno);
        
        if($mes!='0'.$mes && $mes<10){$mes='0'.$mes;}
        $consulta="SELECT * FROM `categoria_costos` '";
        $r=$bd->consulta($consulta);
        if($r)
        {
            $a=0;
            while ($fila=$bd->fetch_assoc($r))
            {
                $id_categoria=$fila['id_categoria_costo'];
                $nombre=$fila['nombre'];
                $total=0;
                $consulta="SELECT SUM(pago) from gastos WHERE mes='$mes' and anno='$anno' and id_item in (SELECT id_item FROM item WHERE item.id_categoria_costo='$id_categoria')";
                $r=$bd->consulta($consulta);
                if($r)
                {
                    $fila=$bd->fetch_array($r);
                    $total=$fila[0];
                }
                $datos[$a]['id_categoria']=$id_categoria;
                $datos[$a]['nombre']=$nombre;
                $datos[$a]['total']=$total;
                $a++;
            }
        }
        
        $bd->Close();
        return $datos;
    }
    function TotalesGastosPorCategoriasRango($mes1,$mes2,$anno1,$anno2)
    {
        $datos=array();
        $bd= new con_mysqli();
        $mes1=$bd->ValidarCadena($mes1);
        $mes2=$bd->ValidarCadena($mes2);
        $anno1=$bd->ValidarCadena($anno1);
        $anno2=$bd->ValidarCadena($anno2);
        
        if($mes1!='0'.$mes1 && $mes1<10){$mes1='0'.$mes1;}
        if($mes2!='0'.$mes2 && $mes2<10){$mes2='0'.$mes2;}
        $consulta="SELECT * FROM `categoria_costos` '";
        $r=$bd->consulta($consulta);
        if($r)
        {
            $a=0;
            while ($fila=$bd->fetch_assoc($r))
            {
                $id_categoria=$fila['id_categoria_costo'];
                $nombre=$fila['nombre'];
                $total=0;
                $consulta="SELECT SUM(pago) from gastos WHERE mes>='$mes1' and  mes<='$mes2' and anno>='$anno1'anno<='$anno2' and id_item in (SELECT id_item FROM item WHERE item.id_categoria_costo='$id_categoria')";
                $r=$bd->consulta($consulta);
                if($r)
                {
                    $fila=$bd->fetch_array($r);
                    $total=$fila[0];
                }
                $datos[$a]['id_categoria']=$id_categoria;
                $datos[$a]['nombre']=$nombre;
                $datos[$a]['total']=$total;
                $a++;
            }
        }
        
        $bd->Close();
        return $datos;
    }
    
    function TotalGastosSalariosMesAnno($mes,$anno)
    {
        $total=0;
        $bd= new con_mysqli();
        $mes=$bd->ValidarCadena($mes);
        $anno=$bd->ValidarCadena($anno);
        
        if($mes!='0'.$mes && $mes<10){$mes='0'.$mes;}
        $consulta="SELECT SUM(pago) as total from egreso_salario WHERE mes='$mes' and anno='$anno'";
        $r=$bd->consulta($consulta);
        if($r)
        {
            $fila=$bd->fetch_array($r);
            $total=$fila[0];
        }
        
        $bd->Close();
        return $total;
    }
    function TotalGastosSalariosRango($mes1,$mes2,$anno1,$anno2)
    {
        $total=0;
        $bd= new con_mysqli();
        $mes1=$bd->ValidarCadena($mes1);
        $mes2=$bd->ValidarCadena($mes2);
        $anno1=$bd->ValidarCadena($anno1);
        $anno2=$bd->ValidarCadena($anno2);
        
        if($mes1!='0'.$mes1 && $mes1<10){$mes1='0'.$mes1;}
        if($mes2!='0'.$mes2 && $mes2<10){$mes2='0'.$mes2;}
        $consulta="SELECT SUM(pago) as total from egreso_salario WHERE mes>='$mes1' and mes<='$mes2' and anno>='$anno1' and anno<='$anno2'";
        $r=$bd->consulta($consulta);
        if($r)
        {
            $fila=$bd->fetch_array($r);
            $total=$fila[0];
        }
        
        $bd->Close();
        return $total;
    }
     function TotalGastosPublicitariosMesAnno($mes,$anno)
    {
        $total=0;
        $bd= new con_mysqli();
        $mes=$bd->ValidarCadena($mes);
        $anno=$bd->ValidarCadena($anno);
        
        if($mes!='0'.$mes && $mes<10){$mes='0'.$mes;}
        $consulta="SELECT SUM(pago) as total from egreso_publicitario WHERE mes='$mes' and anno='$anno'";
        $r=$bd->consulta($consulta);
        if($r)
        {
            $fila=$bd->fetch_array($r);
            $total=$fila[0];
        }
        
        $bd->Close();
        return $total;
    }
    function TotalGastosPublicitariosRango($mes1,$mes2,$anno1,$anno2)
    {
        $total=0;
        $bd= new con_mysqli();
        $mes1=$bd->ValidarCadena($mes1);
        $mes2=$bd->ValidarCadena($mes2);
        $anno1=$bd->ValidarCadena($anno1);
        $anno2=$bd->ValidarCadena($anno2);
        
        if($mes1!='0'.$mes1 && $mes1<10){$mes1='0'.$mes1;}
        if($mes2!='0'.$mes2 && $mes2<10){$mes2='0'.$mes2;}
        $consulta="SELECT SUM(pago) as total from egreso_publicitario WHERE mes>='$mes1' and mes<='$mes2' and anno>='$anno1' and anno<='$anno2'";
        $r=$bd->consulta($consulta);
        if($r)
        {
            $fila=$bd->fetch_array($r);
            $total=$fila[0];
        }
        
        $bd->Close();
        return $total;
    }
    function TotalGastosMaterialesDirectosMesAnno($mes,$anno)
    {
        $total=0;
        $bd= new con_mysqli();
        $mes=$bd->ValidarCadena($mes);
        $anno=$bd->ValidarCadena($anno);
        
        if($mes!='0'.$mes && $mes<10){$mes='0'.$mes;}
        $consulta="SELECT SUM(pago) as total from egreso_publicitario WHERE mes='$mes' and anno='$anno'";
        $r=$bd->consulta($consulta);
        if($r)
        {
            $fila=$bd->fetch_array($r);
            $total=$fila[0];
        }
        
        $bd->Close();
        return $total;
    }
    
    function EmpresasSinPagarmesActual()
    {
        $datos=array();
        $mes_actual= MesActual();
        $anno_actual= AnnoActual();
        $fecha_like= FechaYMA();
        if($mes_actual<10){$mes_actual='0'.$mes_actual;}
        $bd= new con_mysqli();
        $a=0;
        $lista_proyectos_activos=array();
        
            $lista_proyectos_activos= $this->PublicidadEgresos($fecha_like);
            if(count($lista_proyectos_activos)>0)
            {
                for ($i = 0; $i < count($lista_proyectos_activos); $i++) 
                {
                     $id_proyecto=$lista_proyectos_activos[$i]['id_proyecto'];
                     
                     $consulta="SELECT * FROM `ingresos` WHERE  `id_proyecto` = '$id_proyecto' AND `mes`='$mes_actual' AND `anno`=$anno_actual";
                     $r=$bd->consulta($consulta);
                     $c=0;
                     if($r)
                    {
                         
                         while ($fila=$bd->fetch_assoc($r))
                        {
                             if($fila['pago']!=0)
                             {
                                 $c++;
                             }
                            else {$c=0; break;}
                             
                             
                        }
                    }
                    
                    if($c==0)
                    {
                        ##no se encontro ningun pago para el mes actual, tomar los datos de la empresa
                        $consulta="select empresa.nombre from empresa WHERE id_empresa in (SELECT id_empresa_cliente from proyecto where proyecto.id_proyecto='$id_proyecto')";
                        
                        $r=$bd->consulta($consulta);
                        if($r)
                        {
                            while ($fila=$bd->fetch_assoc($r))
                            {
                                $nomb_empresa=$fila['nombre'];
                                $datos[$a]=$nomb_empresa;$a++;
                                //$datos[$a]=$consulta;$a++;
                            }
                        }
                    }
                }
               
            }
        
        
        if($r)
        {}
        
        $bd->Close();
        return $datos;
    }
    
}

?>
        

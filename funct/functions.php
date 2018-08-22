<?php
## funciones utiles

function  Mostrar($arreglo)
{
    echo '<pre>'; print_r($arreglo);echo '</pre>';exit();
}

function limpiarString($texto)#solo texto de la a a la z
{
    $cadena_limpia="";
    $text="";
    #elimino todo lo que no sea texto , espacio o n�mero y lo rempl por ''

    $textoLimpio = preg_replace('([^a-zA-Z0-9\s])', '', $texto);
    $t=eliminarblancos($textoLimpio);
    return $t;
}

function picarFechas($fecha)
{
    $arreglo=array();
    if($fecha!="")
    {
        $arr=preg_split('/[**]/', $fecha);
        if(count($arr)==3)
        {
             $arreglo[0]=$arr[0];
             $arreglo[1]=$arr[2];
        }
        else 
        {
            $arreglo[0]=$fecha;
            $arreglo[1]="00:00:00";
        }
    }
    return $arreglo;
}
function CortarNumModelo($p_num_modelo)
{
    $arr=preg_split("/[-]/", $p_num_modelo);
    ##el num del modelo tiene el siguiente formato ejemplo: 2017-1
    if(count($arr)>1)
    {
        if(count($arr)==3)
        {
            
            $num= $arr[2];
        }
        else 
        {
            $num= $arr[1];
        }
        
        if($num < 10){$num="0".$num;}
        return $num;
    }
    else {return $p_num_modelo;}
}

function eliminarblancos($cadena)
{
    $cadena = trim($cadena);#elimina espacios al principio y final de la cadena
    $cadena = preg_replace('/\s(?=\s)/', '', $cadena);#elimina espacios dobles
    $cadena = preg_replace('/[\n\r\t]/', ' ', $cadena);#elimina tabulaciones
    return $cadena;
}

function MesActual()
{
    $fech_act=FechaYMA();
    $f_arr=preg_split("/[-]/", $fech_act);
    $mes=$f_arr[1];
    if($mes<10)
    {$mes=preg_replace("/[0]/", '', $mes);}
    return $mes;
}
function Meses()
{
    $meses=array();
    $i=1;
    $meses[$i]="Enero";$i++;
    $meses[$i]="Febrero";$i++;
    $meses[$i]="Marzo";$i++;
    $meses[$i]="Abril";$i++;
    $meses[$i]="Mayo";$i++;
    $meses[$i]="Junio";$i++;
    $meses[$i]="Julio";$i++;
    $meses[$i]="Agosto";$i++;
    $meses[$i]="Septiembre";$i++;
    $meses[$i]="Octubre";$i++;
    $meses[$i]="Noviembre";$i++;
    $meses[$i]="Diciembre";$i++;
    
    return $meses;
}
function MesesList()
{
    $meses=array();
    $i=1;
    $meses[$i]['nombre']="Enero";
    $meses[$i]['id']=$i;
    $i++;
    $meses[$i]['nombre']="Febrero";
    $meses[$i]['id']=$i;
    $i++;
    $meses[$i]['nombre']="Marzo";
    $meses[$i]['id']=$i;
    $i++;
    $meses[$i]['nombre']="Abril";
    $meses[$i]['id']=$i;
    $i++;
    $meses[$i]['nombre']="Mayo";
    $meses[$i]['id']=$i;
    $i++;
    $meses[$i]['nombre']="Junio";
    $meses[$i]['id']=$i;
    $i++;
    $meses[$i]['nombre']="Julio";
    $meses[$i]['id']=$i;
    $i++;
    $meses[$i]['nombre']="Agosto";
    $meses[$i]['id']=$i;
    $i++;
    $meses[$i]['nombre']="Septiembre";
    $meses[$i]['id']=$i;
    $i++;
    $meses[$i]['nombre']="Octubre";
    $meses[$i]['id']=$i;
    $i++;
    $meses[$i]['nombre']="Noviembre";
    $meses[$i]['id']=$i;
    $i++;
    $meses[$i]['nombre']="Diciembre";
    $meses[$i]['id']=$i;
    $i++;
    
    return $meses;
}

function Anios()
{
    ## a parir del 2017 hasta 20 anios
    $a=2017;
    $anios=array();
    for ($i =0; $i < 20; $i++) 
    {
        $a=2017+$i;
        $anios[$a]=$a;
    }
    return $anios;
}

function CambiarFormatoFecha($p_fecha)
{
    ##elimina blancos al inicio y final de la cadena
    $p_fecha=eliminarblancos($p_fecha);
    
    $fecha='0000-00-00';
    $arr_f=preg_split("[/]",$p_fecha);
    
    if(count($arr_f)==3)
    {
        $fecha=$arr_f[2].'-'.$arr_f[0].'-'.$arr_f[1];
    }
    return $fecha;
    
}
function FechaActual()
{
    date_default_timezone_set("Cuba");
    return $fecha=date("Y-m-d H:i:s");
}

function Hora()
{
    
    $hora=date("H:i:A");
    //return localtime();
    return $hora;
}
function FechaYMA()
{
    date_default_timezone_set("Cuba");
    return $fecha=date("Y-m-d");
}
function FechaYMA2()
{
    date_default_timezone_set("Cuba");
    return $fecha=date("d/m/Y");
}
function AnnoActual()
{
    return  date('Y');
}
FUNCTION ip()
{
    $D="";
    // IP Acceso
    $D=$_SERVER['REMOTE_ADDR'];
    return $D;
}

function ValidarN($campo)
{
    #que no est� en blaco
    if ($campo=="")
    {
        return false;
    }
    #solo numero
    if(!preg_match("/^[0-9.]+$/", $campo))
    {
        return false;
    }

    return true;
}

function ValidarCI($ci)
{
    if(ValidarN($ci))
    {
        if(strlen($ci)==11)###cadena de 11 digitos
        {
            return true;
        }
    }
    return false;
}

function ValidarCaracteresHtml($cadena)
{
    
    return strip_tags($cadena);
}


function isNaN($var){
    return !preg_match('/^[-]?[0-9]+([\.][0-9]+)?$/', $var);
}

function escapeNumero($cad){
    if(isNaN($cad)){
        return "";
    } else {
        return $cad;
    }
}

function SoloTexto($texto)#solo texto de la a a la z
{
    # todo lo que no sea texto , espacio 
   $texto=utf8_decode($texto);
   #return preg_match('([a-zA-ZüÜáéíóúàèìòùÀÈÌÒÙñÁÉÍÓÚÑ\s])', $texto);
   if(!preg_match('/[$=&\'\*\d]/', $texto)){
                  return true;}
                  else{return false;}
   
   
    
}

function solonumeros($texto)
{
    /***
    ^\d+$:  Campo obligatorio.  Admite uno o más dígitos.
    ^\d*$:  Campo opcional.  Admite cero o más dígitos.     */
     return preg_match("(^\d*$)", $texto);
    #return preg_match("/^[0-9]+\.?[0-9]*/", $texto);
}
function SoloTextoYNumeros($texto)#solo texto de la a a la z con tildes y numeros
{
    # todo lo que no sea texto , espacio
    #\W 	Cualquier carácter no alfanumérico 	[^a-zA-Z0-9_]

    return !preg_match('/\W\s/', $texto);

}
function SoloTextoNumerosYAlgC($texto)#solo texto de la a a la z
{
    
    # todo lo que no sea texto , espacio

     #return preg_match("([^a-zA-ZüÜáéíóúàèìòùÀÈÌÒÙñÁÉÍÓÚÑ0-9%.,\s]['\'])", $texto);
     if(!preg_match('/[$=&\'\*]/', $texto)){
                  return true;}
                  else{return false;}

}
function ValidarEmail($email) 
{
  if(preg_match("/^([a-zA-Z0-9])+([a-zA-Z0-9\._-])*@([a-zA-Z0-9_-])+([a-zA-Z0-9\._-]+)+$/",$email))
  {
    return true;
  }
  return false;
}

####################################################################

function BuscarElementoEnArray($elemento,$array)
{
    ##si lo encuentra devuelve true sino false
    for ($i = 0; $i < count($array); $i++) 
    {
        if($elemento==$array[$i])
        {
            return true;
        }
    }
    
    return false;
}

function NombrePC()
{
    $ip=ip();
    $nombre_host = gethostbyaddr($ip);
    return $nombre_host;
}
 
 function  ValidarIP($ip)
 {
     ### separar el ip por . (ptos) debe de tener al menos 4
     $arr_ip=preg_split("/[.]/", $ip);
     
     if(count($arr_ip)>=4)
     {
         ## validar que cada numero sea de al menos 3 caracteres
         for ($i = 0; $i < count($arr_ip); $i++) 
         {
             $validarN=$arr_ip[$i];
             $validarN=eliminarblancos($validarN);
             if($validarN==""){return false;}
            
         }
         
         return true;
     }
     else 
     {
         return false;
     }
 }
 
 function cantidadDiasMes($mes,$anno)
{

$first_of_month = mktime (0,0,0, $mes, 1, $anno);
$maxdays = date('t', $first_of_month); 

return $maxdays;
}

function DiaSemana($mes,$anno,$dia)
{
    $dia=date('w',strtotime($anno.'-'.$mes.'-'.$dia));
    return $dia;
}

function CantidadSemanas($mes,$anno)
{
    $cant_dias_mes=  cantidadDiasMes($mes, $anno);
    $Num_semana=($cant_dias_mes/7)+1;
    
    ##si el primer dia del mes cae domingo
    if(DiaSemana($mes, $anno, '1')==0){$Num_semana++;}
    return $Num_semana;
}

function GetSemanaActual()
{
    
    ##devuelve una rango de 7 dias a partir del dia actual y la fecha de inicio que se muestra es la de inicio de mes para
    #casos de tareas que no estan en el rango de las semana pero que necesitan mostrarse como urgente en index asesoria
    $fecha_actual= FechaYMA();
    
    $semana[1]="-";
    $arr_fecha= preg_split('/[-]/', $fecha_actual);
    if(count($arr_fecha)==3)
    {
        $dia=$arr_fecha[2];
        $mes=$arr_fecha[1];
        $anno=$arr_fecha[0];
        $cant_dias_mes= cantidadDiasMes($mes, $anno);
        if($dia+7>$cant_dias_mes){$d_fin_semana=$cant_dias_mes;}
        else{$d_fin_semana=$dia+7;}
        
        $semana[0]=$anno.'-'.$mes.'-01';
        $semana[1]=$anno.'-'.$mes.'-'.$d_fin_semana;
    }
    return $semana;
}

function Dias()
{
    $a=0;
    $d[$a]="Domingo";$a++;
   $d[$a]="Lunes";$a++;
   $d[$a]="Martes";$a++;
   $d[$a]="Miercoles";$a++;
   $d[$a]="Jueves";$a++;
   $d[$a]="Viernes";$a++;
   $d[$a]="Sabado";$a++;
return $d;
}
function  CompararFechas($f1,$f2)
{
   
   $fecha_actual = strtotime("$f1 00:00:00");
   $fecha_entrada = strtotime("$f2 00:00:00");
    
if($fecha_actual > $fecha_entrada){
    return 0;##la fehca ya paso
}else{
    return 1;
}
    
}
function  CompararMesesFecha($f1,$f2)
{
    ##f1=fecha campanna
    ##f2= fecha tarea
    $arr_f1= preg_split("/[-]/", $f1);
    $arr_f2= preg_split("/[-]/", $f2);
    
    ##si tiene 3 campos es una fecha en formato correcto
    ## si la campaña es de abril la fecha de la tarea debe de ser de abril
    if(count($arr_f1)==3 && count($arr_f2)==3)
    {
        
        $mes_f1=$arr_f1[1];
        $mes_f2=$arr_f2[1];
       
        if($mes_f2!=$mes_f1){return 0;}
        else {    return 1;}
    }
    else { return 0;  }

    
}
function ValidarImg($files)
{
    // Comprobamos si ha ocurrido un error.
if (!isset($files["imagen"]) || $files["imagen"]["error"] > 0)
{
    echo "Ha ocurrido un error.";
}
else
{
    // Verificamos si el tipo de archivo es un tipo de imagen permitido.
    // y que el tamaño del archivo no exceda los 16MB
    $permitidos = array("image/jpg", "image/jpeg", "image/gif", "image/png");
    $limite_kb = 16384;

    if (in_array($files['imagen']['type'], $permitidos) && $files['imagen']['size'] <= $limite_kb * 1024)
    {

        // Archivo temporal
        $imagen_temporal = $files['imagen']['tmp_name'];

        // Tipo de archivo
        $tipo = $files['imagen']['type'];

        // Leemos el contenido del archivo temporal en binario.
        $fp = fopen($imagen_temporal, 'r+b');
        $data = fread($fp, filesize($imagen_temporal));
        fclose($fp);
        
        //Podríamos utilizar también la siguiente instrucción en lugar de las 3 anteriores.
        // $data=file_get_contents($imagen_temporal);


        if ($resultado)
        {
            echo "El archivo ha sido copiado exitosamente.";
        }
        else
        {
            echo "Ocurrió algun error al copiar el archivo.";
        }
    }
    else
    {
        echo "Formato de archivo no permitido o excede el tamaño límite de $limite_kb Kbytes.";
    }
}
}
##validar si es una url
function isURL($url){
    $pattern='|^http(s)?://[a-z0-9-]+(.[a-z0-9-]+)*(:[0-9]+)?(/.*)?$|i';
    if(preg_match($pattern, $url) > 0) return true;
    else return false;
}

##validar si existe
function ValidarUrlImg($url) {

 #$src = 'http://www.mydomain.com/images/'.$filename; if (@getimagesize($src))
}

function BorrarFichero($url_Fichero)
{
    ##si no es una iurl http: comprueba
    if(@getimagesize($url_Fichero)==false)
    {
        ##si existe una imagen la elimino
        if(file_exists($url_Fichero))
        {
            if($url_Fichero!="../../img/campannas" || $url_Fichero!="../../img/campannas")
            {
                 if (unlink($url_Fichero))
                {
                //si puede ser
                  return true;
                }
            }
           
        }
        else 
        {
            ##si la imagen no existe es q no hay nada a eliminar y retorno true
            return true;
        }
    }
    return false;
    
}

function MotivosTransaccion()
{
    $motivos=array();
    $c=1;
    #motivo 1 COBRO PACIENTES
    $motivos[$c]="COBRO PACIENTE";$c++;
    #motivo 2
    $motivos[$c]="PAGO MEDICO CIRUGIA";$c++;
    #motivo 3
    $motivos[$c]="PAGO MEDICO CONSULTA";$c++;
    #motivo 4
    $motivos[$c]="PAGO LABORATORIO ANALISIS";$c++;
    #motivo 5
    $motivos[$c]="PAGO LABORATORIO RADIOLOGIA";$c++;
    #motivo 6
    $motivos[$c]="PAGO INSUMOS";$c++;
    #motivo 7
    $motivos[$c]="PAGO SALARIOS";$c++;
    
    return $motivos;
}

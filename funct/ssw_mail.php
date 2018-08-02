<?php




function BaseMail()
{

    $phpmailer= new PHPMailer();
    //Con PluginDir le indicamos a la clase phpmailer donde se
    //encuentra la clase smtp que como he comentado al principio de
    //este ejemplo va a estar en el subdirectorio includes
    $phpmailer->PluginDir = "../includes/phpmailer/";
    //Con la propiedad Mailer le indicamos que vamos a usar un
    //servidor smtp
    $phpmailer->Mailer = "smtp";
    
    //Asignamos a Host el nombre de nuestro servidor smtp
    $phpmailer->Host = "correo.emprequin.co.cu";
    
    //Le indicamos que el servidor smtp requiere autenticación
    $phpmailer->SMTPAuth = true;
    
    //Le decimos cual es nuestro nombre de usuario y password
    $phpmailer->Username = "aniuvys@emprequin.cu";
    $phpmailer->Password = "anyany123*--";
    
    //Indicamos cual es nuestra dirección de correo y el nombre que
    //queremos que vea el usuario que lee nuestro correo
    $phpmailer->From = "aniuvys@emprequin.cu";
    $phpmailer->FromName = "Dpto Informática";
    
    //el valor por defecto 10 de Timeout es un poco escaso dado que voy a usar
    //una cuenta gratuita, por tanto lo pongo a 30
    $phpmailer->Timeout=30;
    
    return $phpmailer;
}
    
    function AddRemitentes($listaRemitentes,$phpmailer)
    {
        
        if(count($listaRemitentes)==0)
        {
            return false;
        }
        else 
        {
            for ($i = 0; $i < count($listaRemitentes); $i++) 
            {
                $direccion_c=$listaRemitentes[$i]['mail'];
                $nombre=$listaRemitentes[$i]['name'];
               
                $phpmailer->AddAddress($direccion_c, $nombre);
            }
        }
        return true;
    }
    
     function AddCopia($listaRemitentes,$phpmailer)
    {
        $direccion_c=$listaRemitentes[0]['mail'];
        $nombre=$listaRemitentes[0]['name'];
        $phpmailer->AddCC($direccion_c,$nombre);
    }
     function AddAsunto($asunto,$phpmailer)
    {
        //Añado un asunto al mensaje
        $phpmailer->Subject = $asunto;
    }
    
     function AddBody($body,$phpmailer)
    {
        //inserto el texto del mensaje en formato HTML
        $phpmailer->MsgHTML($body);
    }
    
     function AddAdjunto($ruta,$phpmailer)
    {
        #asigno un archivo adjunto al mensaje
         //$this->phpmailer->AddAttachment("ruta/archivo_adjunto.gif");
    }
    
     function EnviarCorreo($phpmailer)
    {
        if(!$phpmailer->Send()) {
            return true;
        } 
        else
        {
            return false;
        }
    }

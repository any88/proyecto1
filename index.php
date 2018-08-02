<?php
include 'header.html';
include 'funct/functions.php';


$user="";
$pass="";

$tipo_m="";
$msg="";

if($_POST) 
{
    if(isset($_POST["user"])){$user=$_POST['user'];}
    if(isset($_POST["passwd"])){$pass=$_POST['passwd'];}
    
    if(eliminarblancos($user)!="" && eliminarblancos($pass)!="")
        {
            ##validar que el usuario y la contraseña sean los mismos que en la base de datos

            /*$cg=new ConsultasG();
            $result=$uc->LoginObject($cautiva_u,$cautiva_p);
            if(count($result)>0)
            {

                session_start();
                $_SESSION["loggin"]="$cautiva_u";
                $_SESSION["id_user"]=$result[0]->getIdUsuario();
                $_SESSION["nombre"]=$result[0]->getNombre();
                $_SESSION["id_cargo"]=$result[0]->getIdCargoUsuario();
                $_SESSION["nombre_cargo"]="$nomb_cargo";
                $_SESSION["tipo_usuario_id"]=$result[0]->getIdTipoUsuario();
                $_SESSION["dni"]=$result[0]->getDni();
                $_SESSION["estado"]=$result[0]->getEstado();
                $_SESSION["email"]=$result[0]->getEmail();
                $_SESSION["telefono"]=$result[0]->getTelefono();
             
                if($result[0]->getIdTipoUsuario()==1)
                {
                     header("location:pag/index_asesoria.php");
                }
                else 
                {
                    header("location:pag/index_user.php");
                }
           }
            else {
                $tipo_m="alert-danger";
                $msg="<b>Usuario o Contrase&ntilde;a Incorrectos!!!</b>";
            }
            */
            if($user=="jorge" && $pass=='ndmm')
            {
                 header("location:pag/index.php");
            }
            else {
               
                if($user=="admin" && $pass=="admintmh**--")
                {
                    session_start();
                    $_SESSION["loggin"]="admin";
                    $_SESSION["id_user"]="0";
                    $_SESSION["nombre"]="Administrador Principal del Sistema";
                    $_SESSION["rol"]="0";
                    header("location:pag/admin/index_admin.php");
                }
                else 
                {
                    $tipo_m="alert-danger";
                    $msg="<b>Usuario o Contrase&ntilde;a Incorrectos!!!</b>";
                }
                
            }
        }
    else {

        $tipo_m="alert-warning";
        $msg="<b>Usted neesita llenar los campos usuario y contrase&ntilde;a para poder entrar en el sistema.</b>";
   }
}

?>

<body>
  <!--==========================
  Hero Section
  ============================-->
  <div id="preloader"></div>
  <section id="hero">
    <div class="hero-container">
   
      <div class="wow fadeIn">
        <div class="hero-logo">
            <img class="" src="img/clinica_logo.png" alt="Clinica">
        </div>
 </div>
        
<!------ Include the above in your HEAD tag ---------->

<div class="container">
  <noscript>

      <div class='alert alert-danger text-center'>
            <b>Para utilizar las funcionalidades completas de este sitio es necesario tener
            JavaScript habilitado. </b><p>Aquí están las <a href="https://www.enable-javascript.com/es/"
            target="_blank"> instrucciones para habilitar JavaScript en tu navegador web</a>.</p>
      </div>
   </noscript>
     <?php 
            if($tipo_m!="")
                {
                 echo "<div class='alert $tipo_m'>";
                 echo $msg;
                 echo "</div>";
                }
            ?> 
   
    <div class="row">
        <div class="col-sm-6 col-md-4 col-md-offset-4">
            <h5 class="text-center login-title"> Usted debe de estar registrado para entrar </h5>
          
             <div class='account-wall'>
                <form name='flogin' method="post" action="index.php" class="form-signin">
                <input name= "user" type="text" class="form-control" placeholder="Usuario" required autofocus>
				<br>
                <input name="passwd" type="password" class="form-control" placeholder="Contrase&nacute;a" required>
				<br>
                <button class="btn btn-lg btn-success btn-block" type="submit">
                   Entrar</button>
               
                </form>
            </div>
			<br>
            Para m&aacute;s informaci&oacute;n <a href="https://tacnamedhope.com/" class="text-center new-account">Visita Nuestra WEB</a>
        </div>
    </div>
</div>
     
    </div>
  </section>

  
      

  

  <a href="#" class="back-to-top"><i class="fa fa-chevron-up"></i></a>

  <!-- Required JavaScript Libraries -->
  <script src="lib/jquery/jquery.min.js"></script>
  <script src="lib/bootstrap/js/bootstrap.min.js"></script>
  <script src="lib/superfish/hoverIntent.js"></script>
  <script src="lib/superfish/superfish.min.js"></script>
  <script src="lib/morphext/morphext.min.js"></script>
  <script src="lib/wow/wow.min.js"></script>
  <script src="lib/stickyjs/sticky.js"></script>
  <script src="lib/easing/easing.js"></script>

  <!-- Template Specisifc Custom Javascript File -->
  <script src="js/custom.js"></script>

  <script src="contactform/contactform.js"></script>


</body>

<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="utf-8">
  <title>ClinicApp</title>
  <meta content="width=device-width, initial-scale=1.0" name="viewport">
  <meta content="" name="keywords">
  <meta content="" name="description">

  <!-- Place your favicon.ico and apple-touch-icon.png in the template root directory -->
  <link href="../img/clinica_logo.png" rel="shortcut icon">

 <!-- GLOBAL STYLES -->
    
  <!--<link rel="stylesheet" href="../css/bts/main.css" />
  <link rel="stylesheet" href="../css/bts/theme.css" />
  <link rel="stylesheet" href="../css/bts/MoneAdmin.css" />-->
 <!-- Main Stylesheet File -->
  <link href="../css/style.css" rel="stylesheet">
   
  <!-- Bootstrap CSS File -->
  <link href="../lib/bootstrap/css/bootstrap.min.css" rel="stylesheet">
  <link href="../lib/bootstrap/css/bootstrap.css"  rel="stylesheet"/>
  <link href="../lib/bootstrap/css/bootstrap-theme.css"  rel="stylesheet"/>
    
  <!-- Libraries CSS Files -->
  <link href="../lib/font-awesome/css/font-awesome.min.css" rel="stylesheet">
  <link href="../lib/animate-css/animate.min.css" rel="stylesheet">
  
  <!-- Select picker -->
 <link rel="stylesheet" href="../lib/select_picker/bootstrap-select.min.css" />

 <!-- data table css -->
 <link href="../lib/dataTables/dataTables.bootstrap.css" rel="stylesheet" />
 

<!-- Daterange picker -->
  <link rel="stylesheet" href="../lib/daterangepicker/daterangepicker.css">

</head>

<body>
    
   <!--<div id="preloader"></div>-->
  <noscript>

      <div class='alert alert-danger text-center'>
            <b>Para utilizar las funcionalidades completas de este sitio es necesario tener
            JavaScript habilitado. </b><p>Aquí están las <a href="https://www.enable-javascript.com/es/"
            target="_blank"> instrucciones para habilitar JavaScript en tu navegador web</a>.</p>
      </div>
   </noscript>
  

  <!--==========================
  Header Section
  ============================-->
  <header id="header">
    <div class="container">

      <div id="logo" class="pull-left">
          <a href="index.php"><img src="../img/clinica_logo.png" alt="" title="" /></a>
        <!-- Uncomment below if you prefer to use a text image -->
        <!--<h1><a href="#hero">Header 1</a></h1>-->
      </div>

      <nav id="nav-menu-container">
        <ul class="nav-menu">
          
          <li class="menu-has-children" ><a href="#">Pacientes</a>
          <ul>
              <li><a href="crearpaciente.php">Nuevo Paciente</a></li>
              <li><a href="listar_pacientes.php">Listar Pacientes</a></li>
              <li><a href="pacientes_hospitalizados.php">Hospitalizados</a></li>
           </ul>
          </li>
          <li class="menu-has-children" ><a href="#">Servicios</a>
          <ul>
              <li><a href="buscar_servicio.php">Buscar Servicio</a></li>
              <li><a href="listar_servicios.php" >Listar Servicios</a></li>
           </ul>
          </li>
          <li class="menu-has-children" ><a href="#">Caja</a>
          <ul>
              <li><a href="cobros_pendientes.php" >Cobros Pendientes</a></li>
              <li><a href="pagos_pendientes.php" >Pagos Pendientes</a></li>
              <li><a href="cobros_realizados.php" >Cobros Realizados</a></li>
              <li><a href="#" onclick="Msg();">Pagos Realizados</a></li>
              <li><a href="#" onclick="Msg();">Balance de Caja</a></li>
          </ul>
          </li>
         <li class="menu-has-children" ><a href="#" onclick="Msg();">Farmacia</a></li>
         <li><a href="#" onclick="Msg();">Reportes</a></li>
         <li class="menu-has-children" ><a href="nomencladores.php">Administraci&oacute;n</a></li>
          <li class="menu-has-children"><a href="#">Bienvenido, @usuario</a>
            <ul>
                <li><a href="#">Editar perfil</a></li>
                <li><a href="../index.php">Salir</a></li>
            </ul>
          </li>
          
        </ul>
      </nav>
      <!-- #nav-menu-container -->
    </div>
  </header>
  <!-- #header -->

  <a href="#" class="back-to-top"><i class="fa fa-chevron-up"></i></a>

  <!-- Required JavaScript Libraries -->
  <script src="../lib/jquery/jquery.min.js"></script>
  <script src="../lib/superfish/hoverIntent.js"></script>
  <script src="../lib/superfish/superfish.min.js"></script>
  <script src="../lib/morphext/morphext.min.js"></script>
  <script src="../lib/wow/wow.min.js"></script>
  <script src="../lib/stickyjs/sticky.js"></script>
  <script src="../lib/easing/easing.js"></script>

  <!-- Template Specisifc Custom Javascript File -->
   <script src="../js/custom.js"></script>
   <script src="../js/cautivapp.js"></script>
   <script src="../js/adminlte.min.js"></script>
   
   

  <script src="../contactform/contactform.js"></script>

  <!-- select picker scripts -->
 
 <script src="../lib/select_picker/bootstrap-select.min.js"></script>
  <!--end select pickers -->
<!-- tab panel -->
   <script src="../lib/jquery-2.0.3.min.js"></script>
   <script src="../lib/modernizr-2.6.2-respond-1.1.0.min.js"></script>
<!-- Data table js-->
    <script src="../lib/bootstrap/js/bootstrap.min.js"></script>
    <script src="../lib/dataTables/jquery.dataTables.js"></script>
    <script src="../lib/dataTables/dataTables.bootstrap.js"></script>
     <script>
         $(document).ready(function () {
             $('#dataTables-example').dataTable();
         });
         
    </script>
     <!-- END Data table js -->
<!--date picker-->

<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.5.0/css/bootstrap-datepicker.min.css" />
<script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.5.0/js/bootstrap-datepicker.min.js"></script>
<!-- graficas -->
<!-- MDB core JavaScript -->
<script type="text/javascript" src="../lib/MDB/js/mdb.min.js"></script>
<!-- date-range-picker -->
<script src="../lib/daterangepicker/moment.min.js"></script>
<script src="../lib/daterangepicker/daterangepicker.js"></script>
<script>
        $( document ).ready(function() {
            $('#fecha').datepicker();
            //Date range picker
    $('#reservation').daterangepicker();
    //Date range picker with time picker
    $('#reservationtime').daterangepicker({timePicker: true, timePickerIncrement: 30, format: 'MM/DD/YYYY h:mm A'});
    //Date range as a button
    $('#daterange-btn').daterangepicker(
        {
          ranges: {
            'Today': [moment(), moment()],
            'Yesterday': [moment().subtract(1, 'days'), moment().subtract(1, 'days')],
            'Last 7 Days': [moment().subtract(6, 'days'), moment()],
            'Last 30 Days': [moment().subtract(29, 'days'), moment()],
            'This Month': [moment().startOf('month'), moment().endOf('month')],
            'Last Month': [moment().subtract(1, 'month').startOf('month'), moment().subtract(1, 'month').endOf('month')]
          },
          startDate: moment().subtract(29, 'days'),
          endDate: moment()
        },
        function (start, end) {
          $('#daterange-btn span').html(start.format('MMMM D, YYYY') + ' - ' + end.format('MMMM D, YYYY'));
        }
    );
        });
        
        
    </script>
<script>
$(document).ready(function(){
    $('[data-toggle="tooltip"]').tooltip();
});

</script>
<script type="text/javascript">
    jQuery(document).ready(function ($) {
        $(".tabs").tabs();
    });
</script>


</body>

</html>

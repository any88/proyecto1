<!doctype html>
<html>
<head>
<meta charset="utf-8">
<title>Documento sin título</title>
<link href="css/style.css" rel="stylesheet" type="text/css">
	<style>
	
		.gris
		{
			margin-left: 30px;
			margin-right: 30px;
			background-color: #D6CFCF;
		}
		.table
		{
			width: 100% !important;
			border: 1px;
                        border-color: transparent;
		}
                .tdBC
                {
                    width: 585px;
                }
		.firma_bottom
		{
			width: 250px;
			height: 50px;
			margin-left: 30px;
			margin-right: 30px;
			margin-bottom: 5px;
			margin-left: 250px;;
			margin-top: 75px;
			text-align: center;
		}
               
               
	</style>
</head>

<body>
<blockquote>
	<img src="../img/clinica_logo.jpg" width="48" height="55" alt="tmh" style='margin-top:5px;'/>
  <p style='margin-left: 55px; margin-top: -35px;'>Clinica Tacna Medica Hope <br><b>Balance de caja</b></p>
</blockquote>
    <div style="margin-left: 30px;margin-top: 50px; margin-bottom: 10px;">Fecha: <?php echo FechaActual();?></div>
	<div class="gris">
		<b style="margin-top: 20px;">Gesti&oacute;n de Caja</b>
		<br><br>
	  <table class="table">
		  <tr>
                      <td class="tdBC">Aporte a Caja</td> <td class="pull-right">s/.<?php echo $aporte_a_caja;?></td>
		  </tr>
		  <tr>
			  <td>Extracci&oacute;n de Caja</td><td class="pull-right">s/.<?php echo $extraccion_caja;?></td>
		  </tr>
		  <tr>
			  <td><b>Total</b></td><td class="pull-right">s/.<?php echo $total_gestion_caja;?></td>
		  </tr>
	  </table>
	</div>
	<br><br>
	<div class="gris">
		<b style="margin-top: 20px;">Cobros de Servicio</b>
		<br><br>
	  <table class="table">
	  <tr>
              <td class="tdBC">Por Aseguradora</td> <td class="pull-right">s/.<?php echo $pago_aseguradora;?></td>
	  </tr>
	  <tr>
		  <td>Pago en Efectivo</td><td class="pull-right">s/.<?php echo $pago_efectivo;?></td>
	  </tr>
	  <tr>
		  <td><b>Total</b></td><td class="pull-right">s/.<?php echo $pago_aseguradora+$pago_efectivo;?></td>
	  </tr>
	  </table>
	</div>
	<br><br>
	<div class="gris">
		<b style="margin-top: 20px;">Efectivo en Caja</b>
		<br><br>
	 
	  <table class="table">
		  <tr>
                      <td class="tdBC"><b>Total</b></td><td class="pull-right">s/.<?php echo $total_caja;?></td>
		  </tr>
	  </table>
	</div>
	<div class="firma_bottom">
            <p>______________________<br><br>
                E. Vanessa Huacani Rondon<br>
                Gerente General<br>
                Servisalud CLINITACNA EIRL
                
		</p>
	
	</div>
	
</body>
</html>
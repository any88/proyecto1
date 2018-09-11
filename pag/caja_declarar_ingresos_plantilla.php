<!doctype html>
<html>
<head>
<meta charset="utf-8">
<title>Documento sin título</title>
<link href="css/style.css" rel="stylesheet" type="text/css">
	<style>
	
		.normal
		{
			margin-left: 30px;
			margin-right: 30px;
                        margin-top: 70px;
		}
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
  <p style='margin-left: 55px; margin-top: -35px;'>Clinica Tacna Medica Hope <br><b>Recibo de Ingreso a Caja</b></p>
</blockquote>

	<div class="normal">
		<p style="margin-top: 20px;"> Por medio de la presente se deja constancia que en el dia <?php ?> se ha realizado una gesti&oacute;n de caja en la Cl&iacute;nica Tacna Medical Hope con los siguientes datos:</p>
		<br><br>
	  <table class="table">
		  <tr>
			  <td>Fecha:</td>
			  <td><?php echo $fecha;?></td>
		  </tr>
		  <tr>
			  <td>Cantidad Abonada:</td>
			  <td><?php echo $cantidad;?> soles</td>
		  </tr>
		  <tr>
			  <td>Observaciones:</td>
			  <td><?php echo $motivo;?></td>
		  </tr>
		  <tr>
			  <td>Persona que entrega:</td>
			  <td><?php echo $nombre_persona_entrega;?></td>
		  </tr>
		  <tr>
			  <td>Persona que recibe:</td>
			  <td><?php echo $usuario_recibe;?></td>
		  </tr>
		  
	  </table>
	<br><br>
	<p>Para que asi conste firman la Presente:</p>
		<table class="table">
                
		<tr>
                    <td style="border-bottom-color: black; border-bottom: 1px;"> </td>
                    <td></td>
                    <td style="border-bottom-color: black; border-bottom: 1px;"> </td>
		</tr>
			<tr>
                            <td style="width: 250px;">Quien Entrega:<br> <?php echo $nombre_persona_entrega;?></td>
                            <td></td>
			<td>Quien Entrega: <br><?php echo $usuario_recibe;?></td>
		</tr>
		</table>
	</div>
	
	
	
</body>
</html>
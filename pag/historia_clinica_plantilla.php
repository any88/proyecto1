<!doctype html>
<html>
<head>
<meta charset="utf-8">
<title>Historia Clinica</title>
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
		th{text-align: left;}
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
  <p style='margin-left: 55px; margin-top: -35px;'>Clinica Tacna Medical Hope <br><b>Historia Cl&iacute;nica # <?php echo "TMH125";?></b></p>
</blockquote>

	<div class="normal">
		
	  <table class="table">
		  <tr>
			  <th>Nombre Paciente:</th>
			  <td><?php ?></td>
		  </tr>
		  <tr>
			  <th>Documento de identidad:</th>
			  <td><?php ?></td>
		  </tr>
		  <tr>
			  <th>Edad:</th>
			  <td><?php ?></td>
		  </tr>
		  <tr>
			  <th>Sexo:</th>
			  <td><?php ?></td>
		  </tr>
		  <tr>
			  <th>Ocupaci&oacute;n:</th>
			  <td><?php ?></td>
		  </tr>
		  <tr>
			  <th>Aseguradora:</th>
			  <td><?php ?></td>
		  </tr>
		  <tr>
			  <th>ID de Cliente de Aseguradora:</th>
			  <td><?php ?></td>
		  </tr>
		  <tr>
			  <th>Direcci&oacute;n:</th>
			  <td><?php ?></td>
		  </tr>
		  <tr>
			  <th>Tel&eacute;fono:</th>
			  <td><?php ?></td>
		  </tr>
	  </table>
		<table class="table">
			<tr>
			  <th>Tipo Sangu&iacute;neo:</th>
			  <td><?php ?></td>
		   </tr>
			<tr>
			  <th>Alergias Medicamentosas:</th>
			</tr>
			<tr>
			  <td><?php ?></td>
		  </tr>
		</table>
	<br><br>
		<h3>Listado de Servicios Recibidos en la Cl&iacute;nica</h3>
        <table class="table">
			<tr>
				<th>Fecha</th>
				<th>Tipo de Servicio</th>
				<th>Especialidad</th>
				<th>Doctor</th>
			</tr>
		</table>
	</div>
	
	
	
</body>
</html>
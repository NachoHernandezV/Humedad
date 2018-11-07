<!DOCTYPE html>
<html>
<?php
session_start();
?>
<head>
	    <link rel="stylesheet" type="text/css" href="seleccion.css">
			    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script><!--Para que funcione el .load que carga el contenido JQUERY-->

<script type="text/javascript">

	function objetoAjax(){
		var xmlhttp = false;
		try {
			xmlhttp = new ActiveXObject("Msxml2.XMLHTTP");
		} catch (e) {

			try {
				xmlhttp = new ActiveXObject("Microsoft.XMLHTTP");
			} catch (E) {
				xmlhttp = false; }
		}

		if (!xmlhttp && typeof XMLHttpRequest!='undefined') {
		  xmlhttp = new XMLHttpRequest();
		}
		return xmlhttp;
	}
  function enviarDatos()
	{
	        //Recogemos los valores introducimos en los campos de texto
			/*equipo = document.formulario.equipo.value;
			dorsal = document.formulario.dorsal.value;*/

			fecha = document.formulario.fecha.value;//inicio
			zona = document.formulario.zona.value;
			etapas = document.formulario.etapas.value;
			horas = document.formulario.horas.value;//fin

	         //Aquí será donde se mostrará el resultado
			humedad = document.getElementById('humedad');//inicio

			//instanciamos el objetoAjax
			ajax = objetoAjax();

			//Abrimos una conexión AJAX pasando como parámetros el método de envío, y el archivo que realizará las operaciones deseadas
			ajax.open("POST", "consulta.php", true);

			//cuando el objeto XMLHttpRequest cambia de estado, la función se inicia
			ajax.onreadystatechange = function() {

	             //Cuando se completa la petición, mostrará los resultados
				if (ajax.readyState == 4){

					//El método responseText() contiene el texto de nuestro 'consultar.php'. Por ejemplo, cualquier texto que mostremos por un 'echo'
					//var cadena=(ajax.responseText) //OBTENER LOS RESULTADOS EN CADENA DE TEXTO
					//var resultados = cadena.split("-");  //PARTIR LOS RESULTADOS EN VARIAS PARTES SEGUN LA CONSULTA

					humedad.value = ajax.responseText  //OBTENER LA PARTE 1
					  //OBTENER LA PARTE 2
					//jugador.value = (ajax.responseText)// ESTE PONE TODA LA CADENA DE TEXTO QUE MANDA LA CONSULTA
				}
			}

			//Llamamos al método setRequestHeader indicando que los datos a enviarse están codificados como un formulario.
			ajax.setRequestHeader("Content-Type","application/x-www-form-urlencoded");

			//enviamos las variables a 'consulta.php'
			//"&equipo="+equipo+"&dorsal="+dorsal+
			ajax.send("&fecha="+fecha+"&zona="+zona+"&etapas="+etapas+"&horas="+horas)
}

</script>
<script type="text/javascript">
		/*<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js">*//*SE REQUIERE PARA CARGAR EL CONTENIDO LA FUNCION .load*/
		$("document").ready(function()
		{
					$("#etapas").load("../archivos_para_load/arranque_etapas.php");
		})

		$("document").ready(function()
		{
					$("#horas").load("../archivos_para_load/arranque_horas.php");
		})

		$("document").ready(function()
		{
						/*PARA QUE ARRANQUEN LOS DATOS DE ZONA*/
					 $("#zona").load("../archivos_para_load/arranque_zona.php");

				//ESTA LINEA SE EJECUTA CUANDO SE SELECCIONA EL SELECT
					$("#zona").change(function()
						{

										//OBTENEMOS LA VARIABLE QUE VAMOS A MANDAR EN ESTE CASO SERIA
										//IDZONA
										var id= $("#zona").val();

										//CAMBIAMOS la ETAPA CUANDO CAMBIEMOS LA ZONA
										$.get("../archivos_para_load/cambio_etapas.php",{param2_id:id})
										.done(function(data)
										{
											$("#etapas").html(data);
										})

										//CAMBIAMOS la hora CUANDO CAMBIEMOS LA ZONA
										$.get("../archivos_para_load/cambio_horas.php",{param2_id:id})
										.done(function(data)
										{
											$("#horas").html(data);
										})
					 })
	})
</script>
	<script>

	function habilitar(value)
	{
			var zona=document.getElementById("zona").value;
			var HabilidarCenizas=0;

		if(zona == "1" && value=="Limpia")
			HabilidarCenizas=0;
			if(zona == "1" && value=="Cambio")
				HabilidarCenizas=0;
				if(zona == "1" && value=="Molienda")
					HabilidarCenizas=0;
					if(zona == "1" && value=="Envio")
						HabilidarCenizas=1;

		if(zona == "2" && value=="Limpia")
				HabilidarCenizas=0;
				if(zona == "2" && value=="Caída del Banco")
						HabilidarCenizas=0;
						if(zona == "2" && value=="Molienda")
								HabilidarCenizas=1;

		if(zona == "3")
				HabilidarCenizas=1;

		if(HabilidarCenizas==1)
		{
			document.getElementById("cenizas").disabled=false;
		}
		else{
			document.getElementById("cenizas").disabled=true;
			document.getElementById("cenizas").value="";
		}
	}

	//PARA HABILITAR O deshabilitar LOS CAMPOS DE CENIZAS Y HUMEDAD , SI YA PARO
	function habilitarInactividad(value)
	{
		var zona=document.getElementById("zona").value;
		var HabilidarCenizas=0;

	if(zona == "1" && value=="Limpia")
		HabilidarCenizas=0;
		if(zona == "1" && value=="Cambio")
			HabilidarCenizas=0;
			if(zona == "1" && value=="Molienda")
				HabilidarCenizas=0;
				if(zona == "1" && value=="Envio")
					HabilidarCenizas=1;

	if(zona == "2" && value=="Limpia")
			HabilidarCenizas=0;
			if(zona == "2" && value=="Caída del Banco")
					HabilidarCenizas=0;
					if(zona == "2" && value=="Molienda")
							HabilidarCenizas=1;

	if(zona == "3")
			HabilidarCenizas=1;

		if(document.getElementById('hayparo').checked)
			{
						document.getElementById("humedad").disabled=true;
						document.getElementById("humedad").value="";

						document.getElementById("cenizas").disabled=true;
						document.getElementById("cenizas").value="";

			}
			else
			{

					document.getElementById("humedad").disabled=false;
					if(HabilidarCenizas==1)
					{
					document.getElementById("cenizas").disabled=false;
					}
			}
	}//FIN DE LA FUNCION
</script>

</head>

<body>
	<?php
	date_default_timezone_set('America/Monterrey');
   ?>


			<div id="contenedor-flex">
							<div id="formulario">
								<form name="formulario" action="" onSubmit="enviarDatos(); return false" >
										<!--<input type="text" name="equipo" id="equipo"/>-->

										<h3>Seleccione los datos para buscar</h3>

										<label for="fname">Fecha</label><!-- INICIO  -->
										<input type="date" id="fecha" name="fecha" value="<?php echo date("Y-m-d");?>">

										<label for="zona">Zona</label>
										<select id="zona" name="zona" id="zona" onchange="habilitar(this.value);">
										</select>

										<label for="etapas">Etapas</label>
										<select id="etapas" name="etapas" id="etapas" onchange="habilitar(this.value);">
										</select>

										<label for="horas">Hora</label>
										<select id="horas" name="horas" id="horas">
										</select>

										<input type="submit" value="Buscar"  class="botoninsertar"/>



								</form>
							</div>
			</div>


			<div id="contenedor-flex">
							<div id="formulario">
								<form name="formulario2" ACTION="editar.php" METHOD=post>

									<!-- required pattern="^\d{0,3}(\.\d{0,4})?$"    acepta solo un numero de 3 cifras, despues el punto, y otro numero de 4 cifras-->
									<label for="fname">Humedad</label>
									<input type="text" id="humedad" name="humedad" placeholder="Ingrese el valor de humedad .." required pattern="^\d{0,3}(\.\d{0,4})?$">

									<input type="checkbox" name="hayparo" id="hayparo" onclick="habilitarInactividad();" value="si">Hay Inactividad<br><!-- FIN  -->

										<input type="submit" value="Editar" id="Editar" name="Editar" class="botoninsertar"/>

								</form>
							</div>
			</div>
<script>

</script>
<?php
	$link=mysqli_connect("localhost", "root", "pirineos", "humedad");

	$humedad=$_POST["humedad"];
	$cenizas=$_POST["cenizas"];
	$hayparo=$_POST["hayparo"];
	$Editar=$_POST["Editar"];

	$fecha=$_SESSION['fecha_S'];//ESTA VARIABLES SON PARA EL ARCHIVO EDITAR
	$zona=$_SESSION['zona_S'];
	$etapas=$_SESSION['etapas_S'];
	$horas=$_SESSION['horas_S']; //PARA PODER EDITAR
	$iduser=$_SESSION['iduser'];
	$fechamovim=date("Y-m-d H:i:s");


if(	$Editar == "Editar") //CUANDO SE PRESIONE EL BOTON DE EDITAR
{
		if($zona == "1" and $etapas=="Limpia") //ZONA  MOLINO 1 Y LIMPIA
		{
				if($hayparo=='si')
				{
					$sql="UPDATE molino1_limpia SET humedadMol='100' WHERE fecha='".$fecha."' and hora='".$horas."'";
				}
				else
				{
						$sql="UPDATE molino1_limpia SET humedadMol='".$humedad."' WHERE fecha='".$fecha."' and hora='".$horas."'";
				}
				 $resultad=mysqli_query($link,$sql);
				 $sql2="INSERT INTO editar (iduser,Hora,fecha,fechamovim,Tabla) VALUES ('$iduser','$horas','$fecha','$fechamovim','Molino molino1_limpia')";
				 $resultad=mysqli_query($link,$sql2);
		}

		if($zona == "1" and $etapas=="Cambio") //ZONA  MOLINO 1 Y LIMPIA
		{
				if($hayparo=='si')
				{
					$sql="UPDATE molino1_cambio SET humedadMol='100' WHERE fecha='".$fecha."' and hora='".$horas."'";
				}
				else
				{
						$sql="UPDATE molino1_cambio SET humedadMol='".$humedad."' WHERE fecha='".$fecha."' and hora='".$horas."'";
				}
				 $resultad=mysqli_query($link,$sql);
				 $sql2="INSERT INTO editar (iduser,Hora,fecha,fechamovim,Tabla) VALUES ('$iduser','$horas','$fecha','$fechamovim','Molino molino1_cambio')";
				 $resultad=mysqli_query($link,$sql2);
		}

		if($zona == "1" and $etapas=="Molienda") //ZONA  MOLINO 1 Y LIMPIA
		{
				if($hayparo=='si')
				{
					$sql="UPDATE molino1_molienda SET humedadMol='100' WHERE fecha='".$fecha."' and hora='".$horas."'";
				}
				else
				{
						$sql="UPDATE molino1_molienda SET humedadMol='".$humedad."' WHERE fecha='".$fecha."' and hora='".$horas."'";
				}
				 $resultad=mysqli_query($link,$sql);
				 $sql2="INSERT INTO editar (iduser,Hora,fecha,fechamovim,Tabla) VALUES ('$iduser','$horas','$fecha','$fechamovim','Molino molino1_molienda')";
				 $resultad=mysqli_query($link,$sql2);
		}
		if($zona == "1" and $etapas=="Envio") //ZONA  MOLINO 1 Y LIMPIA
		{
				if($hayparo=='si')
				{
					$sql="UPDATE molino1_envio SET humedadMol='100' WHERE fecha='".$fecha."' and hora='".$horas."'";
				}
				else
				{
						$sql="UPDATE molino1_envio SET humedadMol='".$humedad."' WHERE fecha='".$fecha."' and hora='".$horas."'";
				}
				 $resultad=mysqli_query($link,$sql);
				 $sql2="INSERT INTO editar (iduser,Hora,fecha,fechamovim,Tabla) VALUES ('$iduser','$horas','$fecha','$fechamovim','Molino molino1_envio')";
				 $resultad=mysqli_query($link,$sql2);
		}


		//PARA LA SEGUNDA Zona

		if($zona == "2" and $etapas=="Limpia") //ZONA  MOLINO 1 Y LIMPIA
		{
				if($hayparo=='si')
				{
					$sql="UPDATE molino2_limpia SET humedadMol='100' WHERE fecha='".$fecha."' and hora='".$horas."'";
				}
				else
				{
						$sql="UPDATE molino2_limpia SET humedadMol='".$humedad."' WHERE fecha='".$fecha."' and hora='".$horas."'";
				}
				 $resultad=mysqli_query($link,$sql);
				 $sql2="INSERT INTO editar (iduser,Hora,fecha,fechamovim,Tabla) VALUES ('$iduser','$horas','$fecha','$fechamovim','Molino molino2_limpia')";
				 $resultad=mysqli_query($link,$sql2);
		}

		if($zona == "2" and $etapas=="Caída del Banco") //ZONA  MOLINO 1 Y LIMPIA
		{
				if($hayparo=='si')
				{
					$sql="UPDATE molino2_caidablanco SET humedadMol='100' WHERE fecha='".$fecha."' and hora='".$horas."'";
				}
				else
				{
						$sql="UPDATE molino2_caidablanco SET humedadMol='".$humedad."' WHERE fecha='".$fecha."' and hora='".$horas."'";
				}
				 $resultad=mysqli_query($link,$sql);
				 $sql2="INSERT INTO editar (iduser,Hora,fecha,fechamovim,Tabla) VALUES ('$iduser','$horas','$fecha','$fechamovim','Molino molino2_caidablanco')";
				 $resultad=mysqli_query($link,$sql2);
		}

		if($zona == "2" and $etapas=="Molienda") //ZONA  MOLINO 1 Y LIMPIA
		{
				if($hayparo=='si')
				{
					$sql="UPDATE molino2_molienda SET humedadMol='100' WHERE fecha='".$fecha."' and hora='".$horas."'";
				}
				else
				{
						$sql="UPDATE molino2_molienda SET humedadMol='".$humedad."' WHERE fecha='".$fecha."' and hora='".$horas."'";
				}
				 $resultad=mysqli_query($link,$sql);
				 $sql2="INSERT INTO editar (iduser,Hora,fecha,fechamovim,Tabla) VALUES ('$iduser','$horas','$fecha','$fechamovim','Molino molino2_molienda')";
				$resultad=mysqli_query($link,$sql2);
		}


		//PARA LAS TERCER ZONA
		if($zona == "3" and $etapas=="Mezclas Continuas") //ZONA  MOLINO 1 Y LIMPIA
		{
				if($hayparo=='si')
				{
					$sql="UPDATE mezclas_continuas SET humedadMol='100' WHERE fecha='".$fecha."' and hora='".$horas."'";
				}
				else
				{
						$sql="UPDATE mezclas_continuas SET humedadMol='".$humedad."' WHERE fecha='".$fecha."' and hora='".$horas."'";
				}
				 $resultad=mysqli_query($link,$sql);
				 $sql2="INSERT INTO editar (iduser,Hora,fecha,fechamovim,Tabla) VALUES ('$iduser','$horas','$fecha','$fechamovim','Molino mezclas_continuas')";
				$resultad=mysqli_query($link,$sql2);
		}

		if($zona == "3" and $etapas=="Empaque") //ZONA  MOLINO 1 Y LIMPIA
		{
				if($hayparo=='si')
				{
					$sql="UPDATE mezclas_empaque SET humedadMol='100' WHERE fecha='".$fecha."' and hora='".$horas."'";
				}
				else
				{
						$sql="UPDATE mezclas_empaque SET humedadMol='".$humedad."' WHERE fecha='".$fecha."' and hora='".$horas."'";
				}
				 $resultad=mysqli_query($link,$sql);
				 $sql2="INSERT INTO editar (iduser,Hora,fecha,fechamovim,Tabla) VALUES ('$iduser','$horas','$fecha','$fechamovim','Molino mezclas_empaque')";
			 $resultad=mysqli_query($link,$sql2);
		}

		if($zona == "3" and $etapas=="Envasado") //ZONA  MOLINO 1 Y LIMPIA
		{
				if($hayparo=='si')
				{
					$sql="UPDATE mezclas_envasado SET humedadMol='100' WHERE fecha='".$fecha."' and hora='".$horas."'";
				}
				else
				{
						$sql="UPDATE mezclas_envasado SET humedadMol='".$humedad."' WHERE fecha='".$fecha."' and hora='".$horas."'";
				}
				 $resultad=mysqli_query($link,$sql);
				 $sql2="INSERT INTO editar (iduser,Hora,fecha,fechamovim,Tabla) VALUES ('$iduser','$horas','$fecha','$fechamovim','Molino mezclas_envasado')";
			 	$resultad=mysqli_query($link,$sql2);

		}

}
?>

</body>
</html>

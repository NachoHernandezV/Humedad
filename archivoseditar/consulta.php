<?php
session_start();
?>
<?php

	//Configuracion de la conexion a base de datos
	$bd_host = "localhost";
	$bd_usuario = "root";
	$bd_password = "pirineos";
	$bd_base = "humedad";

	$conexion = mysql_connect ($bd_host, $bd_usuario, $bd_password);
	mysql_select_db ($bd_base, $conexion);

	//Variables recibidas por POST de nuestra conexión AJAX
	$equipo = $_POST['equipo'];
	$dorsal = $_POST['dorsal'];

	$fecha= $_POST['fecha'];//2018-04-20
	$zona= $_POST['zona'];  //son NUMEROS 1
	$etapas= $_POST['etapas'];//limpia,Cambio,Molienda, Envio
	$horas=$_POST['horas'];  //07:00:00

	$_SESSION['fecha_S']=$fecha;//ESTA VARIABLES SON PARA EL ARCHIVO EDITAR
	$_SESSION['zona_S']=$zona;
	$_SESSION['etapas_S']=$etapas;
	$_SESSION['horas_S']=$horas; //PARA PODER EDITAR

	//Variable donde recogemos el resultado de la consulta
	$nombre_jugador = null;

	//Seleccionar la tabla
	$tabla="";
	if($zona == 1)
	{
		if($etapas=="Limpia")
		$tabla="molino1_limpia";

		if($etapas=="Cambio")
		$tabla="molino1_cambio";

		if($etapas=="Molienda")
		$tabla="molino1_molienda";

		if($etapas=="Envio")
		$tabla="molino1_envio";
	}

	if($zona == 2)
	{
		if($etapas=="Limpia")
		$tabla="molino2_limpia";

		if($etapas=="Caída del Banco")
		$tabla="molino2_caidablanco";

		if($etapas=="Molienda")
		$tabla="molino2_molienda";
	}


		if($zona == 3)
		{
			if($etapas=="Mezclas Continuas")
			$tabla="mezclas_continuas";

			if($etapas=="Empaque")
			$tabla="mezclas_empaque";

			if($etapas=="Envasado")
			$tabla="mezclas_envasado";
		}



	//Realizamos la consulta a la base de datos
	$query = "SELECT * FROM ".$tabla." WHERE fecha='".$fecha."' AND hora='".$horas."'";
	$select = mysql_query($query, $conexion) or die('Error'.mysql_error());

	while ($valor = mysql_fetch_assoc($select)){
		$nombre_jugador = $valor['humedadLab']."-".$valor['cenizas'];
	}

	//Mostramos el resultado. Este 'echo' será el que recibirá la conexión AJAX
	echo $nombre_jugador;

?>

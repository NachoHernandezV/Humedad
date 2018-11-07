<?php
	/*archivo para Arrancar los datos de ETAPAS al inicio, solo se ejecuta al abrir o actualizar*/
			date_default_timezone_set('America/Monterrey');
			$idzona = $_GET['param2_id'];
			$user="root";
			$pass="pirineos";
			$server="localhost";
			$bd="humedad";
			$con=mysqli_connect($server,$user,$pass,$bd);


			$sql5="SELECT * FROM horas where idzona='".$idzona."'";
			$resultad=mysqli_query($con,$sql5);

			while($row2 = mysqli_fetch_array($resultad))
			{
				echo '<option value="'.$row2['Hora'].'">'.$row2['Hora'].'</option>';
			}
?>

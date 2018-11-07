 <?php
session_start();
?>
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <link rel="stylesheet" type="text/css" href="css/index.css">
<title>INGRESAR</title>
</head>

<body>
<div align="center" id="contenedor">
<img src="imagenes/logo1.png" alt="Este es el ejemplo de un texto alternativo" width="350" height="320">
<br>
<br>
<table>
	<form action="index.php" method="POST">
		<tr>
			<td ALIGN=CENTER><font size=2 face="verdana" style="color:#44822F">Usuario</font></td>
			<td><input  style="color: #000; background-color: #E6FCDF" type="text" size="13" name="usuario" id="usuario"></td>
		</tr>
		<tr>
			<td ALIGN=CENTER><font size=2 face="verdana" style="color:#44822F">Contraseña</font></td>
			<td><input  style="color: #000; background-color: #E6FCDF" type="password" size="13" name="pass" id="pass"></td>
		</tr>
		<tr>
			<td ALIGN=CENTER></td>
			<td ALIGN=RIGHT>
				<input type="submit" value="Ingresar" name="Ingresar" id="Ingresar" class="boton2">
			</td>
		</tr>
	</form>
</table>
</div>
<?php
//<input style="color: #449035; background-color: #FDC35E" src="ingresar.jpg" type="image" width="80" height="25" value="Ingresar" name="Ingresar" id="Ingresar">

//recibir los datos
$Ingresar = $_POST["Ingresar"];
$usuario = $_POST["usuario"];
$pass = $_POST["pass"];



if($Ingresar == "Ingresar")
{

//coneccion con la base
$link = new mysqli("localhost", "root", "pirineos", "humedad");
/* comprobar la conexión */
if ($link->connect_errno)
{
    printf("Conexión fallida: %s\n", $mysqli->connect_error);
    exit();
}
//


//PARA MOLINO
$sqla="Select * from usuarios_lab where nombre='".$usuario."' and password='".$pass."'";
$querya=mysqli_query($link,$sqla);

//PARA LABORATORIO
$sqlb="Select * from usuarios_mol where nombre='".$usuario."' and password='".$pass."'";
$queryb=mysqli_query($link,$sqlb);



if($existe = mysqli_fetch_object($querya)) //MOLINO
{
      	mysqli_data_seek($querya,0);
      	$consultacompleta = mysqli_fetch_row($querya);

      	if($consultacompleta[5] == "H")
      	$_SESSION['foto']='imagenes/userH.png';
      	else
      	$_SESSION['foto']='imagenes/userM.png';

      	$_SESSION['open']='si';
      	$_SESSION['idusuarioLab']=$consultacompleta[0];
        $_SESSION['iduser']=$consultacompleta[0];
      	$_SESSION['usuario']=$consultacompleta[1]." ".$consultacompleta[2];
        $_SESSION['labgeneral']="si";
      	echo '<script>window.location="laboratorio.php"</script>';
}
elseif($existe = mysqli_fetch_object($queryb)) //LABORATORIOS
{
      	mysqli_data_seek($queryb,0);
      	$consultacompleta = mysqli_fetch_row($queryb);
      	//
      	if($consultacompleta[5] == "H")
      	$_SESSION['foto']='imagenes/userH.png';
      	else
      	$_SESSION['foto']='imagenes/userM.png';

      	$_SESSION['open']='si';
      	$_SESSION['idusuarioMol']=$consultacompleta[0];
        $_SESSION['iduser']=$consultacompleta[0];
      	$_SESSION['usuario']=$consultacompleta[1]." ".$consultacompleta[2];
        $_SESSION['molgeneral']="si";
      	echo '<script>window.location="molino.php"</script>';
}
elseif($usuario == "" or $pass == "" ) //detectar VACIO
{
	echo "No se puede ingresar usuario o contraseña vacio";
}
else
{
	echo "usuario incorrecto o no registrado";
}




}//fin del if de ingresar





?>

</body>
</html>

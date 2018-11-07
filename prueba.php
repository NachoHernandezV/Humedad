<?php
date_default_timezone_set('America/Monterrey');
//generar la cadena de FECHAS PARA LA PARTE IZQUIERDA DEL REPORTE
$FechaInicio='2018-05-22';
$FechaFin='2018-05-23';


$user="root";
$pass="pirineos";
$server="localhost";
$bd="humedad";
$con=mysqli_connect($server,$user,$pass,$bd);


$Seriedefechas[]=array();
		if(	$FechaInicio > $FechaFin)
		{
			echo "ERROR NO SE PUEDE CALCULAR";
		}
		elseif($FechaInicio == $FechaFin)
		{
					$Seriedefechas[0]=$FechaInicio;
		}

		else
		{
					$var=0;
					$FechaTemp=$FechaInicio;
					while ($FechaTemp <= $FechaFin)
					{
						$Seriedefechas[$var]=$FechaTemp;
						$FechaTemp = strtotime ( '+1 day' , strtotime ( $FechaTemp ) ) ;
						$FechaTemp = date ( 'Y-m-j' , $FechaTemp );
						$var=	$var+1;
					}
		}
//fin de la cadena de REPORTES


$numerodelinea=6; //INICIO
$numerodelineaaux=6;
$var=0;
$varaux=0;
$Seriedehoras[]=array();
$numerodefechas=count($Seriedefechas);

for($i=0;$i<count($Seriedefechas);$i++)
{

	//bloque de LAS HORAS
		$resultadHoras=mysqli_query($con,"SELECT Hora FROM `horas` WHERE idzona='1'");
		while($HoraRecibida = mysqli_fetch_array($resultadHoras))
		{
			$Seriedehoras[$varaux]=$HoraRecibida['Hora'];
			$varaux=$varaux+1;
			$numerodelineaaux=$numerodelineaaux+1;
		}

			$numerodelineaaux=$numerodelinea;
}




///////////////////LIMPIA

$numerodelinea=6;
$SumaMolino=0;
$SumaLaboratorio=0;
$SumaDiferencia=0;
$varaux=0;
$varaux2=1;
$Activarpromedio=0;
$paracambiodefecha=$FechaInicio;
$Activarfin=0;
$diferencia=0;
$Activarpromedioespecial=0;
$numerodecambiodefechas=1;

$sql="SELECT * FROM molino1_molienda WHERE fecha>= '".$FechaInicio."' and fecha<='".$FechaFin."' ORDER BY fecha,hora asc";
$sql2="SELECT count(*) as numeroconsultas FROM molino1_molienda WHERE fecha>= '".$FechaInicio."' and fecha<='".$FechaFin."' ORDER BY fecha asc";
$resultado=mysqli_query($con,$sql);
$resultado2=mysqli_query($con,$sql2);
$numeroderegistros = mysqli_fetch_array($resultado2);
echo $sql."</br>";
echo $sql2."</br>";

while($DatosMolino1Limpia = mysqli_fetch_array($resultado))
{

if($DatosMolino1Limpia['fecha'] > $paracambiodefecha) //ES PARA VER EL CAMBIO DE DIA, Y PONER EL PROMEDIO
{
	$Activarfin=1; //ACTIVAR CASO ESPECIAL, FIN DE FECHA Y FIN DE LA CADENA
	$partesFecha1=explode("-",$DatosMolino1Limpia['fecha']);
	$partesFecha2=explode("-",$paracambiodefecha);
	$dia1=$partesFecha1[2];
	$dia2=$partesFecha2[2];
	$numerodecambiodefechas=$dia1 -	$dia2;
	echo "ACTIVAR FIN SE EJECUTO== SI ".$Activarfin."</br>";
}

if($DatosMolino1Limpia['fecha'] > $paracambiodefecha and $numeroderegistros['numeroconsultas'] == $varaux2)
{
$Activarpromedioespecial=1;//PARA ACTIVAR LA IMPRESION DEL ULTIMO PROMEDIO, CASO ESPECIAL CUANDO SOLO HAY UNA FECHA DIFERENTE AL FINAL
echo "ACTIVAR PROMEDIOespecial== SI ".$Activarpromedioespecial."</br>";
}

if($DatosMolino1Limpia['fecha'] > $paracambiodefecha or $numeroderegistros['numeroconsultas'] == $varaux2) //ES PARA VER EL CAMBIO DE DIA, Y PONER EL PROMEDIO
{
$paracambiodefecha=$DatosMolino1Limpia['fecha']; //METEMOS LA NUEVA FECHA MAYOR
$numerodelinea=	$numerodelinea+14*$numerodecambiodefechas;  //PASAR AL SIGUIENTE FECHA
$Activarpromedio=1; //ESTA VARIABLE ACTIVA EL PROMEDIO
echo "se activo el promedio=".$Activarpromedio."</br>";
}


for($i=0;$i<=12;$i++)
{
					if($Seriedehoras[$i] == $DatosMolino1Limpia['hora'])
					{
						if ($numeroderegistros['numeroconsultas'] == $varaux2 and $Activarfin==0) $numerodelinea=$numerodelinea-14*$numerodecambiodefechas;  //Regresar el valor al anterior para no afectar el ultimo registro


						if($DatosMolino1Limpia['hora']== '07:00:00') 	$lugarhora=0;
						if($DatosMolino1Limpia['hora']== '09:00:00') 	$lugarhora=1;
						if($DatosMolino1Limpia['hora']== '11:00:00') 	$lugarhora=2;
						if($DatosMolino1Limpia['hora']== '13:00:00') 	$lugarhora=3;
						if($DatosMolino1Limpia['hora']== '15:00:00') 	$lugarhora=4;
						if($DatosMolino1Limpia['hora']== '16:00:00') 	$lugarhora=5;
						if($DatosMolino1Limpia['hora']== '17:00:00') 	$lugarhora=6;
						if($DatosMolino1Limpia['hora']== '19:00:00') 	$lugarhora=7;
						if($DatosMolino1Limpia['hora']== '21:00:00') 	$lugarhora=8;
						if($DatosMolino1Limpia['hora']== '23:00:00') 	$lugarhora=9;
						if($DatosMolino1Limpia['hora']== '01:00:00') 	$lugarhora=10;
						if($DatosMolino1Limpia['hora']== '03:00:00') 	$lugarhora=11;
						if($DatosMolino1Limpia['hora']== '05:00:00') 	$lugarhora=12;


							$posicion=$numerodelinea+$lugarhora;

							if($DatosMolino1Limpia['humedadMol'] == '100' or $DatosMolino1Limpia['humedadLab'] == '100' )  //SI HAY PARO SOLO PONE EL DATO , NO LO CUENTA NI SUMMA
							{
								echo "PARO EN D  PARO </BR>";
									echo "PARO EN E  PARO </BR>";
										echo "PARO EN F  PARO </BR></BR>";
											echo "SumaMolino=".$SumaMolino."   SumaLaboratorio=".$SumaLaboratorio."  SumaDiferencia=".$SumaDiferencia."  varaux=".$varaux."</br>";
							}
							else
							{


											$diferencia=$DatosMolino1Limpia['humedadMol'] - $DatosMolino1Limpia['humedadLab'];
											echo "D".$posicion." ".$DatosMolino1Limpia['humedadMol'].'%'."</BR>";
												echo "E".$posicion." ".$DatosMolino1Limpia['humedadLab'].'%'."</BR>";
													echo "F".$posicion." ".$diferencia.'%'."</BR>";

												if($Activarfin==1)
												{

												}
												else {
												$SumaMolino=$DatosMolino1Limpia['humedadMol'] + $SumaMolino;
												$SumaLaboratorio=$DatosMolino1Limpia['humedadLab'] + $SumaLaboratorio;
												$SumaDiferencia=$SumaDiferencia + $diferencia;
												$varaux=$varaux + 1;//PARA CONTAR TODOS LOS REGISTROS Y SACAR EL PROMEDIO
												echo "SumaMolino=".$SumaMolino."   SumaLaboratorio=".$SumaLaboratorio."  SumaDiferencia=".$SumaDiferencia."  varaux=".$varaux."</br>";
											}
							}
							if ($numeroderegistros['numeroconsultas'] == $varaux2 and $Activarfin==0) $numerodelinea=	$numerodelinea+14*$numerodecambiodefechas;//Regresar el valor al Siguiente para no afectar el promedio y continue el flujo
					}
}
$varaux2=$varaux2 + 1;//ES PARA FIJAR EL ULTIMO PROMEDIO
$Activarfin=0;

if($Activarpromedio==1)
{
	echo "</br></br>SE ACTIVO EL PROMEDIO";
				if($varaux==0)
				{
					echo "</br>LA VARIABLE VARAUX VALE CERO";
				}
				else
				{
								$promedioMolino= bcdiv($SumaMolino/$varaux, '1', 2);  ////VARIABLES PARA CALCULAR LOS PROMEDIOS
								$promedioLab= bcdiv($SumaLaboratorio/$varaux, '1', 2); ////VARIABLES PARA CALCULAR LOS PROMEDIOS
								$promedio= bcdiv($SumaDiferencia/$varaux, '1', 2); ////VARIABLES PARA CALCULAR LOS PROMEDIOS
								$ajustedeposicion=14*($numerodecambiodefechas-1);
								$posicionPromedio=$numerodelinea-$ajustedeposicion-1;
								//$posicionPromedio=$numerodelinea-1; ////VARIABLES PARA CALCULAR LOS PROMEDIOS

									echo "RESULTADOS FINALES </BR>";
									echo "D".$posicionPromedio." ".$promedioMolino.'%'."</br>";
									echo "E".$posicionPromedio." ".$promedioLab.'%'."</br>";
									echo "F".$posicionPromedio." ".$promedio.'%'."</br>";
				}


								if($DatosMolino1Limpia['humedadLab']=='100' or $DatosMolino1Limpia['humedadMol']=='100')
								{
									$SumaMolino=0;//RESETEAR LAS VARIABLES PARA EL SIGUIENTE PROMEDIO
									$SumaLaboratorio=0;//RESETEAR LAS VARIABLES PARA EL SIGUIENTE PROMEDIO
									$SumaDiferencia=0;//RESETEAR LAS VARIABLES PARA EL SIGUIENTE PROMEDIO
								}
								else {
								$SumaMolino=$DatosMolino1Limpia['humedadMol'];//RESETEAR LAS VARIABLES PARA EL SIGUIENTE PROMEDIO
								$SumaLaboratorio=$DatosMolino1Limpia['humedadLab'];//RESETEAR LAS VARIABLES PARA EL SIGUIENTE PROMEDIO
								$SumaDiferencia=$diferencia;//RESETEAR LAS VARIABLES PARA EL SIGUIENTE PROMEDIO
								$varaux=1;//RESETEAR LAS VARIABLES PARA EL SIGUIENTE PROMEDIO
							}

								$Activarpromedio=0;
								echo "devolvemos las variables para que se inicie nuevamente suma molino".$SumaMolino."</br>";
								echo "devolvemos las variables para que se inicie nuevamente suma laboratorio".$SumaMolino."</br>";
								echo "LA DIFERENCIA PARA REINICIAR ES".$SumaDiferencia."</br>"."</br>"."</br>";
}

if($Activarpromedioespecial==1)
{
			$diferencia=$DatosMolino1Limpia['humedadMol'] - $DatosMolino1Limpia['humedadLab'];
			$posicionPromedio=$numerodelinea+13; ////VARIABLES PARA CALCULAR LOS PROMEDIOS
			echo "D".$posicionPromedio." ".$DatosMolino1Limpia['humedadMol'].'%'."</br>";
			echo "E".$posicionPromedio." ".$DatosMolino1Limpia['humedadLab'].'%'."</br>";
			echo "F".$posicionPromedio,$diferencia.'%'."</br>";

}
$Activarpromedioespecial=0;
ECHO "FIN DEL BLOQUE    --------------------------------------------------------------------->>>>>>>>>>>>>>>>>>>>>>>>>></BR></BR>";

}
////////FIN DE LIMPIA
?>

<?php
session_start();
?>
<?php
//zona horaria php
date_default_timezone_set('America/Monterrey');
////////////////////////////////////////////////////////////////////////

		$Departamento=$_SESSION['DepartamentoSend'];
		$Indicador=$_SESSION['IndicadorSend'];

		$user="root";
		$pass="pirineos";
		$server="localhost";
		$bd="humedad";
		$con=mysqli_connect($server,$user,$pass,$bd);

		$FechaInicio = $_POST["fecha_inicio"];
		$FechaFin = $_POST["fecha_fin"];


if(strtotime($FechaInicio) > strtotime($FechaFin)) //si la fecha inicial es mayor mandara un mensaje pues no es logico
{
	echo "<script>
							alert('<---- La fecha Inicial es Menor a la Final, Regresa y corrige la fecha de inicio para la generación de tu reporte');
	</script>";
}
else
{ //aplicable cuando la fecha incial es menos o igual a la FINAL ESO ES LO LOGICO
			require_once 'Classes/PHPExcel.php';
			$excel = new PHPExcel();
			header('Content-Type: application/vnd.ms-excel');
			header('Content-Disposition: attachment;filename="Reporte.xls"');
			header('Cache-Control: max-age=0');
		//PASO 1
		//generar la cadena de FECHAS PARA LA PARTE IZQUIERDA DEL REPORTE

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
								$FechaTemp = date ( 'Y-m-d' , $FechaTemp );
								$var=	$var+1;
							}
				}
		//fin de la cadena de REPORTES

				//$objPHPExcel->createSheet(0); //crear hoja
				$excel->setActiveSheetIndex(0); //seleccionar hora
				$excel->getActiveSheet()->setTitle("Molino 1"); //establecer titulo de hoja

				//orientacion hoja
				$excel->getActiveSheet()->getPageSetup()->setOrientation(PHPExcel_Worksheet_PageSetup::ORIENTATION_LANDSCAPE);
				$excel->getDefaultStyle()->getFont()->setName('Times new Roman');
				$excel->getDefaultStyle()->getFont()->setSize(12);

				//$excel->getActiveSheet()->getRowDimension('1')->setRowHeight(20);
				$excel->getActiveSheet()->getRowDimension(1)->setRowHeight(-1);
				$excel->getActiveSheet()->getColumnDimension('A')->setWidth(12);
				$excel->getActiveSheet()->getColumnDimension('B')->setWidth(20);
				$excel->getActiveSheet()->getColumnDimension('C')->setWidth(16);//bien
				$excel->getActiveSheet()->getColumnDimension('D')->setWidth(10);
				$excel->getActiveSheet()->getColumnDimension('E')->setWidth(10);
				$excel->getActiveSheet()->getColumnDimension('F')->setWidth(10);//bien
				$excel->getActiveSheet()->getColumnDimension('G')->setWidth(10);//bien
				$excel->getActiveSheet()->getColumnDimension('H')->setWidth(10);
				$excel->getActiveSheet()->getColumnDimension('I')->setWidth(10);
				$excel->getActiveSheet()->getColumnDimension('J')->setWidth(10);//bien
				$excel->getActiveSheet()->getColumnDimension('K')->setWidth(10);//bien
				$excel->getActiveSheet()->getColumnDimension('L')->setWidth(10);
				$excel->getActiveSheet()->getColumnDimension('M')->setWidth(10);

			// Do your stuff here
			$y=2;
			$excel->setActiveSheetIndex(0)
				->setCellValue("B".(string)(3),'Molino 1')
				->setCellValue("B".(string)(4),'Fechas')
				->setCellValue("C".(string)(4),'Muestras (Horario)')
				->setCellValue("D".(string)(4),'Limpia')
				->setCellValue("G".(string)(4),'Cambio')
				->setCellValue("J".(string)(4),'Molienda')
				->setCellValue("M".(string)(4),'Envio')
				->setCellValue("D".(string)(5),'Molino')
				->setCellValue("E".(string)(5),'lab')
				->setCellValue("F".(string)(5),'Diferencia')
				->setCellValue("G".(string)(5),'Molino')
				->setCellValue("H".(string)(5),'lab')
				->setCellValue("I".(string)(5),'Diferencia')
				->setCellValue("J".(string)(5),'Molino')
				->setCellValue("K".(string)(5),'lab')
				->setCellValue("L".(string)(5),'Diferencia')
				->setCellValue("M".(string)(5),'Molino')
				->setCellValue("N".(string)(5),'lab')
				->setCellValue("O".(string)(5),'Diferencia')
				->setCellValue("P".(string)(5),'Cenizas')
				;

			//fECHA
			$excel->setActiveSheetIndex(0)->mergeCells('B3:P3');
			$excel->getActiveSheet()->getStyle('B3')->getAlignment()->setVertical(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
			$excel->getActiveSheet()->getStyle('B3')->getAlignment()->setVertical(PHPExcel_Style_Alignment::VERTICAL_CENTER);
			//fECHA
			$excel->setActiveSheetIndex(0)->mergeCells('B4:B5');
			$excel->getActiveSheet()->getStyle('B4')->getAlignment()->setVertical(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
			$excel->getActiveSheet()->getStyle('B4')->getAlignment()->setVertical(PHPExcel_Style_Alignment::VERTICAL_CENTER);
			//Horario
			$excel->setActiveSheetIndex(0)->mergeCells('C4:C5');
			$excel->getActiveSheet()->getStyle('C4')->getAlignment()->setVertical(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
			$excel->getActiveSheet()->getStyle('C4')->getAlignment()->setVertical(PHPExcel_Style_Alignment::VERTICAL_CENTER);
			//lIMPIA
			$excel->setActiveSheetIndex(0)->mergeCells('D4:F4');
			$excel->getActiveSheet()->getStyle('D4')->getAlignment()->setVertical(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
			$excel->getActiveSheet()->getStyle('D4')->getAlignment()->setVertical(PHPExcel_Style_Alignment::VERTICAL_CENTER);
			//CAMBIO
			$excel->setActiveSheetIndex(0)->mergeCells('G4:I4');
			$excel->getActiveSheet()->getStyle('G4')->getAlignment()->setVertical(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
			$excel->getActiveSheet()->getStyle('G4')->getAlignment()->setVertical(PHPExcel_Style_Alignment::VERTICAL_CENTER);
			//MOLIENDA
			$excel->setActiveSheetIndex(0)->mergeCells('J4:L4');
			$excel->getActiveSheet()->getStyle('J4')->getAlignment()->setVertical(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
			$excel->getActiveSheet()->getStyle('J4')->getAlignment()->setVertical(PHPExcel_Style_Alignment::VERTICAL_CENTER);
			//ENVIO
			$excel->setActiveSheetIndex(0)->mergeCells('M4:P4');
			$excel->getActiveSheet()->getStyle('M4')->getAlignment()->setVertical(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
			$excel->getActiveSheet()->getStyle('M4')->getAlignment()->setVertical(PHPExcel_Style_Alignment::VERTICAL_CENTER);


			$borders = array
			(
					'borders' =>array(
					'allborders' => array(
					'style' => PHPExcel_Style_Border::BORDER_THIN,
					'color' => array('argb'),
					)
					),
				'alignment' =>  array(
		        'horizontal'=> PHPExcel_Style_Alignment::HORIZONTAL_CENTER,
		        'vertical'  => PHPExcel_Style_Alignment::VERTICAL_CENTER,
		        'wrap'      => TRUE
		    )
			);
			$excel->getActiveSheet()->getStyle('B3:P5')->getFill()
					->applyFromArray(array('type' => PHPExcel_Style_Fill::FILL_SOLID,
					'startcolor' => array('rgb' => 'ABD7AC')
					));
		//FINNNNNNNNNNNNNNNNNNN

		//fechas LATEAL IZQUIERDA
		$numerodelinea=6; //INICIO
		$numerodelineaaux=6;
		$var=0;
		$varaux=0;
		$Seriedehoras[]=array();
		$numerodefechas=count($Seriedefechas);

		for($i=0;$i<count($Seriedefechas);$i++)
		{

			$excel->setActiveSheetIndex(0)
			->setCellValue("B".$numerodelinea,$Seriedefechas[$var]); //y = 3

				$temp=$numerodelinea+13;
				$cadena="B".$numerodelinea.":B".$temp;
				$excel->setActiveSheetIndex(0)->mergeCells($cadena);
				$excel->getActiveSheet()->getStyle('B'.$numerodelinea)->getAlignment()->setVertical(PHPExcel_Style_Alignment::VERTICAL_CENTER);
				$excel->getActiveSheet()->getStyle('B'.$numerodelinea)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);


					$excel->getActiveSheet()->getStyle($cadena)->getFill()
							->applyFromArray(array('type' => PHPExcel_Style_Fill::FILL_SOLID,
							'startcolor' => array('rgb' => 'ABD7AC')
							));
				$numerodelinea=$numerodelinea+14;
				$var=$var+1;

					//bloque de LAS HORAS
						$resultadHoras=mysqli_query($con,"SELECT Hora FROM `horas` WHERE idzona='1'");
						while($HoraRecibida = mysqli_fetch_array($resultadHoras))
						{
							$Seriedehoras[$varaux]=$HoraRecibida['Hora'];
							$varaux=$varaux+1;
							$excel->setActiveSheetIndex(0)
							->setCellValue("C".$numerodelineaaux,$HoraRecibida['Hora']); //

								$excel->getActiveSheet()->getStyle("C".$numerodelineaaux)->getFill()
										->applyFromArray(array('type' => PHPExcel_Style_Fill::FILL_SOLID,
										'startcolor' => array('rgb' => 'ABD7AC')
										));

									$excel->getActiveSheet()->getStyle('C'.$numerodelineaaux)->getAlignment()->setVertical(PHPExcel_Style_Alignment::VERTICAL_CENTER);
									$excel->getActiveSheet()->getStyle('C'.$numerodelineaaux)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
							$numerodelineaaux=$numerodelineaaux+1;
						}

						$excel->setActiveSheetIndex(0)
						->setCellValue("C".$numerodelineaaux,"Promedio"); //

							$numerodelineaaux=$numerodelinea;
		}

		//APLICAR BORDERS A TODO EL DOCUMENTO Y EL CENTRADO
		$numerodelinea=$numerodelinea-1;
		$rango="B3:P".$numerodelinea;
		$excel->getActiveSheet()
					->getStyle($rango) // A D
					->applyFromArray($borders);

		$excel->getActiveSheet()->getStyle($rango)->getAlignment()->setVertical(PHPExcel_Style_Alignment::VERTICAL_CENTER);
		$excel->getActiveSheet()->getStyle($rango)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
		//



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

		$resultado=mysqli_query($con,"SELECT * FROM molino1_limpia WHERE fecha>= '".$FechaInicio."' and fecha<='".$FechaFin."' ORDER BY fecha,hora asc");
		$resultado2=mysqli_query($con,"SELECT count(*) as numeroconsultas FROM molino1_limpia WHERE fecha>= '".$FechaInicio."' and fecha<='".$FechaFin."' ORDER BY fecha asc");
		$numeroderegistros = mysqli_fetch_array($resultado2);

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
								}

								if($DatosMolino1Limpia['fecha'] > $paracambiodefecha and $numeroderegistros['numeroconsultas'] == $varaux2)
								{
										$Activarpromedioespecial=1;//PARA ACTIVAR LA IMPRESION DEL ULTIMO PROMEDIO, CASO ESPECIAL CUANDO SOLO HAY UNA FECHA DIFERENTE AL FINAL
								}

								if($DatosMolino1Limpia['fecha'] > $paracambiodefecha or $numeroderegistros['numeroconsultas'] == $varaux2) //ES PARA VER EL CAMBIO DE DIA, Y PONER EL PROMEDIO
								{
								$paracambiodefecha=$DatosMolino1Limpia['fecha']; //METEMOS LA NUEVA FECHA MAYOR
								$numerodelinea=	$numerodelinea+14*$numerodecambiodefechas;  //PASAR AL SIGUIENTE FECHA
								$Activarpromedio=1; //ESTA VARIABLE ACTIVA EL PROMEDIO
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

													if($DatosMolino1Limpia['humedadMol'] == '100' or $DatosMolino1Limpia['humedadLab'] == '100')  //SI HAY PARO SOLO PONE EL DATO , NO LO CUENTA NI SUMMA
													{
														$excel->setActiveSheetIndex(0)
														->setCellValue("D".$posicion,'Paro')
														->setCellValue("E".$posicion,'Paro')
														->setCellValue("F".$posicion,'Paro');

														$SumaMolino=0 + $SumaMolino;
														$SumaLaboratorio=0 + $SumaLaboratorio;
														$SumaDiferencia=$SumaDiferencia + 0;
													}
													else
													{
																$diferencia=$DatosMolino1Limpia['humedadMol'] - $DatosMolino1Limpia['humedadLab'];
																$excel->setActiveSheetIndex(0)
																->setCellValue("D".$posicion,$DatosMolino1Limpia['humedadMol'].'%')
																->setCellValue("E".$posicion,$DatosMolino1Limpia['humedadLab'].'%')
																->setCellValue("F".$posicion,$diferencia.'%');

																if($Activarfin==1)
																{

																}
																else
																{
																					$SumaMolino=$DatosMolino1Limpia['humedadMol'] + $SumaMolino;
																					$SumaLaboratorio=$DatosMolino1Limpia['humedadLab'] + $SumaLaboratorio;
																					$SumaDiferencia=$SumaDiferencia + $diferencia;
																					$varaux=$varaux + 1;//PARA CONTAR TODOS LOS REGISTROS Y SACAR EL PROMEDIO
																}
													}
													if ($numeroderegistros['numeroconsultas'] == $varaux2 and $Activarfin==0) $numerodelinea=	$numerodelinea+14*$numerodecambiodefechas;//Regresar el valor al Siguiente para no afectar el promedio y continue el flujo
											}
								}
											$varaux2=$varaux2 + 1;//ES PARA FIJAR EL ULTIMO PROMEDIO
											$Activarfin=0;

											if($Activarpromedio==1)
											{
												if($varaux==0)
												{
												}
												else {
															//para cuando solo hay paro
																$promedioMolino= bcdiv($SumaMolino/$varaux, '1', 2); ////VARIABLES PARA CALCULAR LOS PROMEDIOS
																$promedioLab= bcdiv($SumaLaboratorio/$varaux, '1', 2); ////VARIABLES PARA CALCULAR LOS PROMEDIOS
																$promedio= bcdiv($SumaDiferencia/$varaux, '1', 2); ////VARIABLES PARA CALCULAR LOS PROMEDIOS
																$ajustedeposicion=14*($numerodecambiodefechas-1);
																$posicionPromedio=$numerodelinea-$ajustedeposicion-1;
																//$posicionPromedio=$numerodelinea-1; ////VARIABLES PARA CALCULAR LOS PROMEDIOS

																$excel->setActiveSheetIndex(0)//PONER LOS VALORES CALCULADOS
																->setCellValue("D".$posicionPromedio,$promedioMolino.'%')
																->setCellValue("E".$posicionPromedio,$promedioLab.'%')
																->setCellValue("F".$posicionPromedio,$promedio.'%');
														}

														if($DatosMolino1Limpia['humedadLab']=='100' or $DatosMolino1Limpia['humedadMol']=='100')
														{
															$SumaMolino=0;//RESETEAR LAS VARIABLES PARA EL SIGUIENTE PROMEDIO
															$SumaLaboratorio=0;//RESETEAR LAS VARIABLES PARA EL SIGUIENTE PROMEDIO
															$SumaDiferencia=0;//RESETEAR LAS VARIABLES PARA EL SIGUIENTE PROMEDIO
														}
														else
														{
															$SumaMolino=$DatosMolino1Limpia['humedadMol'];//RESETEAR LAS VARIABLES PARA EL SIGUIENTE PROMEDIO
															$SumaLaboratorio=$DatosMolino1Limpia['humedadLab'];//RESETEAR LAS VARIABLES PARA EL SIGUIENTE PROMEDIO
															$SumaDiferencia=$diferencia;//RESETEAR LAS VARIABLES PARA EL SIGUIENTE PROMEDIO
															$varaux=1;//RESETEAR LAS VARIABLES PARA EL SIGUIENTE PROMEDIO
														}
																$Activarpromedio=0;



											}
											if($Activarpromedioespecial==1)
											{
												if($DatosMolino1Limpia['humedadLab']=='100' or $DatosMolino1Limpia['humedadMol']=='100')
												{
												}
												else {
															$diferencia=$DatosMolino1Limpia['humedadMol'] - $DatosMolino1Limpia['humedadLab'];
															$posicionPromedio=$numerodelinea+13; ////VARIABLES PARA CALCULAR LOS PROMEDIOS
															$excel->setActiveSheetIndex(0)//PONER LOS VALORES CALCULADOS
															->setCellValue("D".$posicionPromedio,$DatosMolino1Limpia['humedadMol'].'%')
															->setCellValue("E".$posicionPromedio,$DatosMolino1Limpia['humedadLab'].'%')
															->setCellValue("F".$posicionPromedio,$diferencia.'%');
														}
											}
											$Activarpromedioespecial=0;

		}
		////////FIN DE LIMPIA





			$writer = PHPExcel_IOFactory::createWriter($excel, 'Excel5');
			// This line will force the file to download
			$writer->save('php://output');
}// ES LA LLAVE QUE CIERRA EL ELSE DE LA LINEA 30  aplicable cuando la fecha incial es menos o igual a la FINAL ESO ES LO LOGICO
?>

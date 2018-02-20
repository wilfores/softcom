	<?php
	include("inicio.php");
	?>
	<?php
	include("../conecta.php");
	include("script/functions.inc");
	include("script/cifrar.php");
	include("../funcion.inc");
	?>
		<link rel="stylesheet" type="text/css" href="css/estilos.css" />
	
	<script language="JavaScript">
	function Abre_ventana (pagina)
	{
		 ventana=window.open(pagina,"Asignar","toolbar=no,location=0,directories=no,status=no,menubar=no,scrollbars=yes,resizable=yes,width=420,height=200");
	}
	
	function Retornar()
	{
	  document.enviar.action="recepcion_lista.php";
	  document.enviar.submit();
	}
	</script>
	        <script type="text/javascript" src="jquery/jquery.js"></script>
       		<script type="text/javascript" src="jquery/highcharts.js"></script>
			<link rel="stylesheet" type="text/css" href="css/estilos.css" />
		<?
			$dpto = $_GET["dpto"];
			//$maestro = $_GET["maestro"];
			//$conn = mysql_connect("localhost","root","12345");
			$camb_gest=$_SESSION["camb_gest"];
			//$conn = Conectarse();
			if($camb_gest==2013)
			{
				$conn = Conectarse();
			}
			if($camb_gest==2014)
			{
				$conn = Conectarse2();
			}
			if($camb_gest==2015)
			{
				$conn = Conectarse3();
			}
			//$db= mysql_select_db("bd_softcom2");
			if($_GET["maestro"]){
				$maestro = $_GET["maestro"];
			}
			else{
				$maestro = $_GET["dpto"];
			}
			//-->obtenemos el nombre del departamento
			$consulta = "	select  departamento_descripcion_dep as nombre
					from `departamento` where departamento_cod_departamento ='$dpto'";
			$res = mysql_query($consulta, $conn);
			$filaux=mysql_fetch_array($res);
			$nomdep = $filaux['nombre'];
			echo "<center><br><p>".$nomdep."</p></center>";
			//-->fin de la extraccion del nombre
			//procedemos a crear la tabla con las estadisticas generalizadas... debemos crear la primera fila fuera del while
			//para garantizar la visibilidad end epartamentos de unidad unica (q no tiene dependencias)
			//ultima referencia y consulta data 6
			?>
		
            <table width="90%" border="1" cellpadding="1" align="center">
                <tr style="font-size: 8pt; color:#FFFFFF" bgcolor="#3E6BA3">
                    <td class=mitd>Unidad Dependiente</td>
                    <td class=mitd>Correspondencia Atendida</td>
                    <td class=mitd>Correspondencia Pendiente</td>
                    <td class=mitd>Total de Correspondencia</td>
                    <td class=mitd>Porcentaje de Atencion</td>
                    <td class=mitd>Porcentaje de Pendiente</td>
                    <td class=mitd>Total de Porcentaje</td>
                </tr>
            <? 	
			$consulta2 = "	select  cargos_id, cargos_cargo
					from `cargos` where cargos_cod_depto ='$dpto'";
			$res = mysql_query($consulta2, $conn);
			$contdoc1 = 0;
			$contder = 0;
			$contadoc1 = 0;
			$contader = 0;
			//contador general de la tabla
			$globalatendidos=0;
			$globalpendientes=0;
			
			//array que almacenara los datos de los dependientes
			$matdep;
			$fil=0;
			//$col=0;
			while ($fila=mysql_fetch_array($res)){
				//---------tabla registrodoc1 calculod e pendientes
				//echo "--".$fila["cargos_id"]."--".$fila["cargos_cargo"]."<br>";
				
				$consulta2 = "	select COUNT(*) as total from `registrodoc1`
						where registrodoc1_estado='R' and registrodoc1_cc='E' and
							registrodoc1_situacion = 'P' and
							registrodoc1_hoja_ruta != '0' and
							registrodoc1_para = '$fila[cargos_id]'";
				
				/*echo $consulta2;*/
				$res2 = mysql_query($consulta2, $conn);
				$filaux2=mysql_fetch_array($res2);
				//echo "-r-".$filaux2['total']."--<br>";
				$contdoc1 = $contdoc1+$filaux2['total'];
				//--------tabla derivadoc calculo de pendientes
				//echo "--".$fila["cargos_id"]."--".$fila["cargos_cargo"]."<br>";
				//se retirada de la consulta, al parecer 
				
		
				$consulta3 = "	select COUNT(*) as total from `derivardoc`
						where 	derivardoc_situacion='R' and derivardoc_estado = 'P' and
							    derivardoc_realizado = 'H' and
							    derivardoc_para  = '$fila[cargos_id]'";
				
				/*echo $consulta2;*/
				$res3 = mysql_query($consulta3, $conn);
				$filaux3=mysql_fetch_array($res3);
				//echo "-d-".$filaux3['total']."--<br>";
				$contder = $contder+$filaux3['total'];
				
				//---------tabla registrodoc1 calculo de atendidos
				//			registrodoc1_estado = 'R' and
				//echo "--".$fila["cargos_id"]."--".$fila["cargos_cargo"]."<br>";
				$consulta4 = "	select COUNT(*) as total from `registrodoc1`
						where 	registrodoc1_cc='E' and
							registrodoc1_estado = 'SR' and
							registrodoc1_situacion = 'P' and
							registrodoc1_hoja_ruta != '0' and
							registrodoc1_de = '$fila[cargos_id]'";
				//echo $consulta2;
				$res4 = mysql_query($consulta4, $conn);
				$filaux4=mysql_fetch_array($res4);
				//echo "-r-".$filaux4['total']."--<br>";				
				$contadoc1 = $contadoc1+$filaux4['total'];
				
				//--------tabla derivadoc calculo de atendidos
				//		where 	derivardoc_situacion  = 'R' and
				//echo "--".$fila["cargos_id"]."--".$fila["cargos_cargo"]."<br>";
				$consulta5 = "	select COUNT(*) as total from `derivardoc`
								where 	derivardoc_situacion  = 'SR' and
								derivardoc_estado = 'P' and
							    derivardoc_hoja_ruta != '0' and
							    derivardoc_de  = '$fila[cargos_id]'";
				//echo $consulta2;
				$res5 = mysql_query($consulta5, $conn);
				$filaux5=mysql_fetch_array($res5);
				//echo "-d-".$filaux5['total']."--<br>";
				$contader = $contader+$filaux5['total'];
				//--------tabla usuarios obtencion del nombre
				//echo "--".$fila["cargos_id"]."--".$fila["cargos_cargo"]."<br>";
				$consulta6 = "	select usuario_nombre as nombre
								from usuario
						where 	usuario_ocupacion  = '$fila[cargos_id]'";
				/*echo $consulta2;*/
				$res6 = mysql_query($consulta6, $conn);
				$filaux6=mysql_fetch_array($res6);

				
				//->almacenamiento en el array los datos de los dependientes(subordinados)
				$matdep[$fil][0]=$fila["cargos_id"];
				$matdep[$fil][1]=$fila["cargos_cargo"];
				$matdep[$fil][2]=$filaux2['total']+$filaux3['total'];
				$matdep[$fil][3]=$filaux4['total']+$filaux5['total'];
				$matdep[$fil][4]=$filaux6['nombre'];
				$fil++;
			}
			$total_atendidos=$contadoc1+$contader;
			$total_pendientes=$contdoc1+$contder;
			$sum=$total_atendidos+$total_pendientes;
			$t_p4=($total_atendidos*100)/$sum;
			$t_p5=($total_pendientes*100)/$sum;
			$t_p6=($total_atendidos+$total_pendientes)*100/$sum;
			//calculando los porcentages
			$t_p4=round($t_p4*100)/100;
			$t_p5=round($t_p5*100)/100;
			$t_p6=round($t_p6*100)/100;
			
			$globalatendidos = $globalatendidos+$total_atendidos;
			$globalpendientes = $globalpendientes+$total_pendientes;
			?>
			<tr style="font-size:11px" class=mitr>
				<td class=mitd><? echo "<font color=#0000FF>".$nomdep; ?>
				</td>
				
				<td class=mitd><?  
					echo $contadoc1+$contader;
				?></td>
				<td class=mitd><?  
					echo $contdoc1+$contder;
				?></td>
				<td class=mitd><?  
				echo $sum;?></td>
				<td class=mitd><?  
				echo $t_p4." %";?>	</td>
				<td class=mitd><?  
				echo $t_p5." %";?></td>
				<td class=mitd><?  
				echo $t_p6." %";?></td>
				
			</tr> 
			<?
			//--->consulta para verificar la existencia de departamentos dependientes
			$sql1="select count(departamento_cod_departamento) as total
			from `departamento` where departamento_dependencia_dep = '$dpto'";
			$rs2 = mysql_query($sql1, $conn);
			$rw2 = mysql_fetch_array($rs2);

			//fin de la elaboracion de la primera fila del reporte
			if ($rw2["total"]>0){
				echo "<br><br><br><br><br><br>";
				//tiene departamentos dependientes cargar un select con dichos departamentos
				$sql3="select departamento_cod_departamento as codigo, departamento_descripcion_dep as nomdep
				from `departamento` where departamento_dependencia_dep = '$dpto'";
				$rs3 = mysql_query($sql3, $conn);
				?>
                <div name=miselect id=miselect>
                <form name="depform" action="muestra_depto.php" method="get">
	                <center><p>Elija un departamento : <br><br><select name="dpto" style="width:150px;" >
    	            <?
                    echo "<option  value=".$dpto.">-- SELECCIONE --</option>";
					while ($filad = mysql_fetch_array($rs3)){
						echo "<option  value=".$filad['codigo'].">".$filad["nomdep"]."</option>";
					}
					?>
                    </select> 
                    <input type=submit value="ver estadisticas">
                    </p></center>
                    <?
                    	echo "<input type=hidden value=".$maestro." name='maestro' >";
					?>
                </form>
                </div>
                <?
				$sql3="select departamento_cod_departamento as codigo, departamento_descripcion_dep as nomdep
				from `departamento` where departamento_dependencia_dep = '$dpto' and departamento_cod_departamento!= '$dpto'";
				//echo $sql3;
				$rs3 = mysql_query($sql3, $conn);
				while ($filadpto = mysql_fetch_array($rs3)){
					//echo $filadpto["codigo"]."--".$filadpto["nomdep"]."<br>";
					$consulta7 = "	select  cargos_id, cargos_cargo
					from `cargos` where cargos_cod_depto ='$filadpto[codigo]'";
					$res = mysql_query($consulta7, $conn);
					$contdoc1d = 0;
					$contderd = 0;
					$contadoc1d = 0;
					$contaderd = 0;
					//array que almacenara los datos de los dependientes
					//$col=0;
					while ($filad=mysql_fetch_array($res)){
							//echo "--".$filax["cargos_id"]."--".$filax["cargos_cargo"]."<br>";
							
							//---------tabla registrodoc1 calculod e pendientes
							//echo "--".$fila["cargos_id"]."--".$fila["cargos_cargo"]."<br>";
							$consulta8 = "	select COUNT(*) as total from `registrodoc1`
										where registrodoc1_estado='R' and 	
										registrodoc1_cc='E' and
										registrodoc1_situacion = 'P' and
										registrodoc1_hoja_ruta != '0' and
										registrodoc1_para = '$filad[cargos_id]'";
							$res8 = mysql_query($consulta8, $conn);
							$filaux8=mysql_fetch_array($res8);
							//echo "-r-".$filaux2['total']."--<br>";
							$contdoc1d = $contdoc1d+$filaux8['total'];
							//--------tabla derivadoc calculo de pendientes
							//echo "--".$fila["cargos_id"]."--".$fila["cargos_cargo"]."<br>";
							$consulta9 = "	select COUNT(*) as total from `derivardoc`
									where derivardoc_situacion  = 'R' and 	
									derivardoc_estado = 'P' and
											derivardoc_hoja_ruta != '0' and
											derivardoc_para  = '$filad[cargos_id]'";
							$res9 = mysql_query($consulta9, $conn);
							$filaux9=mysql_fetch_array($res9);
							//echo "-d-".$filaux3['total']."--<br>";
							$contderd = $contderd+$filaux9['total'];
							
							//---------tabla registrodoc1 calculo de atendidos
							//echo "--".$fila["cargos_id"]."--".$fila["cargos_cargo"]."<br>";
							//registrodoc1_estado = 'R' and
							$consulta10 = "	select COUNT(*) as total from `registrodoc1`
									where 	registrodoc1_cc='E' and
										registrodoc1_estado = 'SR' and
										registrodoc1_situacion = 'P' and
										registrodoc1_hoja_ruta != '0' and
										registrodoc1_de = '$filad[cargos_id]'";
							$res10 = mysql_query($consulta10, $conn);
							$filaux10=mysql_fetch_array($res10);
							//echo "-r-".$filaux4['total']."--<br>";
							$contadoc1d = $contadoc1d+$filaux10['total'];
							//--------tabla derivadoc calculo de atendidos
							//echo "--".$fila["cargos_id"]."--".$fila["cargos_cargo"]."<br>";
							//derivardoc_situacion  = 'R' and
							
							$consulta11 = "	select COUNT(*) as total from `derivardoc`
								where 	derivardoc_situacion  = 'SR' and
								derivardoc_estado = 'P' and
							    derivardoc_hoja_ruta != '0' and
							    derivardoc_de  = '$filad[cargos_id]'";
							$res11 = mysql_query($consulta11, $conn);
							$filaux11=mysql_fetch_array($res11);
							//echo "-d-".$filaux5['total']."--<br>";
							$contaderd = $contaderd+$filaux11['total'];
							
					}
						
						$total_atendidosd=$contadoc1d+$contaderd;
						$total_pendientesd=$contdoc1d+$contderd;
						$sumd=$total_atendidosd+$total_pendientesd;
						$t_p4d=($total_atendidosd*100)/$sumd;
						$t_p5d=($total_pendientesd*100)/$sumd;
						$t_p6d=($total_atendidosd+$total_pendientesd)*100/$sumd;
						//calculando los porcentages
						$t_p4d=round($t_p4d*100)/100;
						$t_p5d=round($t_p5d*100)/100;
						$t_p6d=round($t_p6d*100)/100;
						
						$globalatendidos = $globalatendidos+$total_atendidosd;
						$globalpendientes = $globalpendientes+$total_pendientesd;

						?>
						<tr style="font-size:11px" class=mitr>
							<td class=mitd><? echo "<font color=#0000FF>".$filadpto["nomdep"]; ?>
							</td>
							
							<td class=mitd><?  
								echo $total_atendidosd;
							?></td>
							<td class=mitd><?  
								echo $total_pendientesd;
							?></td>
							<td class=mitd><?  
							echo $sumd;?></td>
							<td class=mitd><?  
							echo $t_p4d." %";?>	</td>
							<td class=mitd><?  
							echo $t_p5d." %";?></td>
							<td class=mitd><?  
							echo $t_p6d." %";?></td>
							
						</tr> 
					<?
						
				}
			}
		
			
			
			if($dpto!=$maestro){
			?>  <center>
				<form name="depform2" action="muestra_depto.php" method="get">
	                    <?
	                    	echo "<input type=hidden value=".$maestro." name='dpto' >";
						?>
	                    <center><input type=submit value="volver al inicio"></center>
	                </form>
                 </center>
            <?
			}
			$sum = $globalatendidos+$globalpendientes;
			$t_p4=($globalatendidos*100)/$sum;
			$t_p5=($globalpendientes*100)/$sum;
			$t_p6=($globalatendidos+$globalpendientes)*100/$sum;
			//calculando los porcentages
			$t_p4=round($t_p4*100)/100;
			$t_p5=round($t_p5*100)/100;
			$t_p6=round($t_p6*100)/100;

			?>
  
            <tr style="font-size: 8pt; color:#FFFFFF" bgcolor="#3E6BA3" class=mitr>
                <td class=mitd></td>
                <td class=mitd>TOTAL = <?php echo $globalatendidos;?></td>
                <td class=mitd>TOTAL = <?php echo $globalpendientes;?></td>
                <td class=mitd>TOTAL = <?php echo $globalatendidos+$globalpendientes;?></td>
                <td class=mitd>TOTAL = <?php echo $t_p4." %";?></td>
                <td class=mitd>TOTAL = <?php echo $t_p5." %";?></td>
                <td class=mitd>TOTAL = <?php echo $t_p6." %";?></td>
            </tr>
</table>
<center>
        <div id="container" style="width: 800px; height: 400px; margin: 0 auto"></div>
	<script type="text/javascript">
 
            var chart;
		var ate = parseFloat("<? echo $globalatendidos; ?>");
		var pen = parseFloat("<? echo $globalpendientes; ?>");
		var tot = parseFloat("<? echo $globalatendidos+$globalpendientes; ?>");
		ate = Math.round((ate*100/tot)*100)/100;
		pen = Math.round((pen*100/tot)*100)/100;
		

		//alert("<? echo $sum; ?>");
            $(document).ready(function() {
                chart = new Highcharts.Chart({
                    chart: {
                        renderTo: 'container',
                        plotBackgroundColor: null,
                        plotBorderWidth: null,
                        plotShadow: false
                    },
                    title: {
                        text: 'CORRESPONDENCIA TOTAL'
                    },
                    tooltip: {
                        formatter: function() {
                            return '<b>'+ this.point.name +'</b>: '+ this.y +' %';
                        }
                    },
                    plotOptions: {
                        pie: {
                            allowPointSelect: true,
                            cursor: 'pointer',
                            dataLabels: {
                                enabled: false
                            },
                            showInLegend: true
                        }
                    },
                    series: [{
                        type: 'pie',
                        name: 'Browser share',
                        data: [
                            ['Atendidos',  ate ],
                            //['Atendidos',   36.3],
                            ['Pendientes',  pen],
                            {
                                name: 'Total',
                                //y: tot,
                                y: 100,
                                sliced: true,
                                selected: true
                            }
                        ]
                    }]
                });
				
			//barra de graficos
			chart3 = new Highcharts.Chart({
            chart: {
                renderTo: 'container3',
                type: 'bar'
            },
            title: {
                text: 'Correspondencia del departamento'
            },
            subtitle: {
                text: 'Ministerio de Salud'
            },
            xAxis: {
                categories: [<? for($i=0;$i<$fil;$i++){
								 echo "'".$matdep[$i][1]."<br>".$matdep[$i][4]."'" ;
								 if ($i < $fil-1)
								 	echo ", ";
								 }
								?>
							],
                title: {
                    text: null
                }
            },
            yAxis: {
                min: 0,
                title: {
                    text: <? echo "'".$nomdep."'";?>,
                    align: 'high'
                },
                labels: {
                    overflow: 'justify'
                }
            },
            tooltip: {
                formatter: function() {
                    return ''+
                        this.series.name +': '+ this.y +' correos';
                }
            },
            plotOptions: {
                bar: {
                    dataLabels: {
                        enabled: true
                    }
                }
            },
            legend: {
                layout: 'vertical',
                align: 'right',
                verticalAlign: 'top',
                x: -100,
                y: 100,
                floating: true,
                borderWidth: 1,
                backgroundColor: '#FFFFFF',
                shadow: true
            },
            credits: {
                enabled: false
            },
            series: [{
                name: 'Atendida',
                data: [<? for($j=0;$j<$fil;$j++){
								 echo "".$matdep[$j][3]."";
								 if ($j < $fil-1)
								 	echo ", ";
								 }
					   ?>]
            }
            , {
                name: 'Pendiente',
                data: [<? for($k=0;$k<$fil;$k++){
								 echo "".$matdep[$k][2]."";
								 if ($k < $fil-1)
								 	echo ", ";
								 }
					   ?>]
            }
            , {
                name: 'Total Correspondencia',
                data: [<? for($l=0;$l<$fil;$l++){
								 echo "".$matdep[$l][2]+$matdep[$l][3]."";
								 if ($l < $fil-1)
								 	echo ", ";
								 }
								?>]
            }]
        });
				
            });
			
        </script>
		<?

			//ahora averiguamos si nuestro dep tiene departamentos dependientes
			/*$sql2="select count(departamento_cod_departamento) as total
				from `departamento` where departamento_dependencia_dep = '$dpto'";
			$rs2 = mysql_query($sql2, $conn);
			$rw2 = mysql_fetch_array($rs2);
			*/
			//echo "<br> el total de departamentos dependientes es: ".$rw2["total"];
			echo "<center>";
			/*
			if ($rw2["total"]>0){
				echo "<form name=formdep action='listadodepdep.php'>";
				echo "<input type=hidden value=".$maestro." name='maestro' >";
				echo "<input type=hidden value=".$dpto." name='dpto' >";
				echo "<input type=submit value='VER DETALLES DEPARTAMENTOS DEPENDIENTES'>";
				echo "</form>";
			}	
			
				echo "<form name=formdep1 action='listadodepdep.php'>";
				echo "<input type=hidden value=".$maestro." name='dpto' >";
				echo "<input type=hidden value=".$maestro." name='maestro' >";
				echo "<input type=submit value='VOLVER AL INICIO'>";
				echo "</form>";
				echo "</center>";
				
				for($i=0;$i<$fil;$i++){
				echo $matdep[$i][0]."--".$matdep[$i][1]."--".$matdep[$i][2]."--".$matdep[$i][3]."<br>";
				}
				//echo $fil;
				*/

		?>
        <br><br><br>
        <div id="container3" style="width: 800px; height:<? 
			switch ($fil) {
				case $fil<5:
					echo 300; 
					break;
				case $fil<10:
					echo 600; 
					break;
				case $fil<15:
					echo 900; 
					break;
				case $fil<20:
					echo 1200; 
					break;
				case $fil<25:
					echo 1500; 
					break;
				case $fil<30:
					echo 1800; 
					break;
				case $fil<35:
					echo 2100; 
					break;
				case $fil<40:
					echo 2400; 
					break;
				case $fil<45:
					echo 2700; 
					break;
				case $fil<50:
					echo 3000; 
					break;	
				case $fil<55:
					echo 3500; 
					break;	
				case $fil<60:
					echo 4000; 
					break;	
				case $fil<65:
					echo 4500; 
					break;	
				case $fil<70:
					echo 5000; 
					break;	
			}
		
		?>; margin: 0 auto"></div>
<?php
include("final.php");
?>
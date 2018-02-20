		<?php
		include("../filtro.php");
		?>

		<?php
		include("inicio.php");
		?>
		<?php
		include("../conecta.php");
		include("script/functions.inc");
		include("script/cifrar.php");
		include("../funcion.inc");
		?>
	
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
			$usr_cod = $_GET["usuario"];
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
			if($dpto!=$maestro){
			?>
				<form name="depform2" action="muestra_depto.php" method="get">
	                    <?
	                    	echo "<input type=hidden value=".$maestro." name='dpto' >";
						?>
	                    <input type=submit value="volver">
	                </form>
            <?
			}
			
			//-->obtenemos el nombre del departamento
			$consulta = "	select  departamento_descripcion_dep as nombre
					from `departamento` where departamento_cod_departamento ='$dpto'";
			$res = mysql_query($consulta, $conn);
			$filaux=mysql_fetch_array($res);
			$nomdep = $filaux['nombre'];
			echo "<center><br><p>".$nomdep."</p></center>";
			//-->fin de la extraccion del nombre

			//-->reformando
			$consulta1 = "	select  usuario_nombre from usuario 
							where usuario_ocupacion = '$usr_cod' ";
			$res = mysql_query($consulta1, $conn);
			$fila=mysql_fetch_array($res);
			$contdoc1 = 0;
			$contder = 0;
			$contadoc1 = 0;
			$contader = 0;
			//array que almacenara los datos de los dependientes
			$matdep;
			$fil=0;
			//---------tabla registrodoc1 calculod e pendientes
				//echo "--".$fila["cargos_id"]."--".$fila["cargos_cargo"]."<br>";
				$consulta2 = "	select COUNT(*) as total from `registrodoc1`
						where registrodoc1_estado='R' and registrodoc1_cc='E' and
							registrodoc1_situacion = 'P' and
							registrodoc1_hoja_ruta != '0' and
							registrodoc1_para = '$usr_cod'";
				/*echo $consulta2;*/
				$res2 = mysql_query($consulta2, $conn);
				$filaux2=mysql_fetch_array($res2);
				//echo "-r-".$filaux2['total']."--<br>";
				$contdoc1 = $contdoc1+$filaux2['total'];
				//--------tabla derivadoc calculo de pendientes
				//************derivardoc_situacion = 'R' and
				//echo "--".$fila["cargos_id"]."--".$fila["cargos_cargo"]."<br>";
				$consulta3 = "	select COUNT(*) as total from `derivardoc`
						where derivardoc_situacion='R' and derivardoc_estado = 'P' and
							    derivardoc_hoja_ruta != '0' and
							    derivardoc_para  = '$usr_cod'";
				/*echo $consulta2;*/
				$res3 = mysql_query($consulta3, $conn);
				$filaux3=mysql_fetch_array($res3);
				//echo "-d-".$filaux3['total']."--<br>";
				$contder = $contder+$filaux3['total'];
				
				//---------tabla registrodoc1 calculo de atendidos
				//echo "--".$fila["cargos_id"]."--".$fila["cargos_cargo"]."<br>";
				$consulta4 = "	select COUNT(*) as total from `registrodoc1`
						where 	registrodoc1_cc='E' and
							registrodoc1_estado = 'SR' and
							registrodoc1_situacion = 'P' and
							registrodoc1_hoja_ruta != '0' and
							registrodoc1_de = '$usr_cod'";
				/*echo $consulta2;*/
				$res4 = mysql_query($consulta4, $conn);
				$filaux4=mysql_fetch_array($res4);
				//echo "-r-".$filaux4['total']."--<br>";
				$contadoc1 = $contadoc1+$filaux4['total'];
				//--------tabla derivadoc calculo de atendidos
				//echo "--".$fila["cargos_id"]."--".$fila["cargos_cargo"]."<br>";
				$consulta5 = "	select COUNT(*) as total from `derivardoc`
								where 	derivardoc_situacion  = 'SR' and
								derivardoc_estado = 'P' and
							    derivardoc_hoja_ruta != '0' and
							    derivardoc_de  = '$usr_cod'";
				/*echo $consulta2;*/
				$res5 = mysql_query($consulta5, $conn);
				$filaux5=mysql_fetch_array($res5);
				//echo "-d-".$filaux5['total']."--<br>";
				$contader = $contader+$filaux5['total'];
				//->almacenamiento en el array los datos de los dependientes(subordinados)
				$matdep[$fil][0]=$fila["usuario_ocupacion"];
				$matdep[$fil][1]=$fila["usuario_nombre"];
				$matdep[$fil][2]=$filaux2['total']+$filaux3['total'];
				$matdep[$fil][3]=$filaux4['total']+$filaux5['total'];
				
				/*
				 for($j=0;$j<4;$j++){
					echo "".$matdep[0][$j].", ";
			 	}
				*/

		?>
		
		<table width="90%" border="1" cellpadding="1" align="center">
			<tr style="font-size: 8pt; color:#FFFFFF" bgcolor="#3E6BA3" class=mitr>
				<td class=mitd>Unidad Dependiente</td>
				<td class=mitd>Correspondencia Atendida</td>
				<td class=mitd>Correspondencia Pendiente</td>
				<td class=mitd>Total de Correspondencia</td>
				<td class=mitd>Porcentaje de Atencion</td>
				<td class=mitd>Porcentaje de Pendiente</td>
				<td class=mitd>Total de Porcentaje</td>
			</tr>
		<? 	
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
		?>
			<tr style="font-size:11px" class=mitr>
				<td class=mitd><? echo "<font color=#0000FF>".$fila["usuario_nombre"] ?>
				</td>
				
				<td class=mitd><?  
					echo $total_atendidos;
				?></td>
				<td class=mitd><?  
					echo $total_pendientes;
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
  
  	<tr style="font-size: 8pt; color:#FFFFFF" bgcolor="#3E6BA3" class=mitr>
		<td class=mitd></td>
		<td class=mitd>TOTAL: =<?php echo $total_atendidos;?></td>
		<td class=mitd>TOTAL: =<?php echo $total_pendientes;?></td>
		<td class=mitd>TOTAL: =<?php echo $sum;?></td>
		<td class=mitd>TOTAL: =<?php echo $t_p4." %";?></td>
		<td class=mitd>TOTAL: =<?php echo $t_p5." %";?></td>
		<td class=mitd>TOTAL: =<?php echo $t_p6." %";?></td>
	</tr>
</table>
<center>
        <div id="container" style="width: 800px; height: 400px; margin: 0 auto"></div>
	<script type="text/javascript">
 
            var chart;
		var ate = parseFloat("<? echo $total_atendidos; ?>");
		var pen = parseFloat("<? echo $total_pendientes; ?>");
		var tot = parseFloat("<? echo $total_atendidos+$total_pendientes; ?>");
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
                        text: 'CORRESPONDENCIA DEL USUARIO'
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
			//graficos en bara
			chart3 = new Highcharts.Chart({
            chart: {
                renderTo: 'container3',
                type: 'bar'
            },
            title: {
                text: 'Estadisticas de la Correspondencia'
            },
            subtitle: {
                text: 'Ministerio de Salud y Deportes'
            },
            xAxis: {
                categories: [<? 
								 echo "'".$matdep[0][1]."'" ;
  							 ?>
							],
                title: {
                    text: null
                }
            },
            yAxis: {
                min: 0,
                title: {
                    text: 'Estadisticas de Correspondencia',
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
                data: [<? 
							 echo "".$matdep[0][3]."";
					   ?>]
            }, {
                name: 'Pendiente',
                data: [<? 
							 echo "".$matdep[0][2]."";
				   ?>]
            }, {
                name: 'Total Correspondencia',
                data: [<? 
							 echo "".$matdep[0][2]+$matdep[0][3]."";
  					   ?>]
            }]
        });
				
            });
			
        </script>

	
		<?/*
			echo "<form name=formdusr action='listadodepusr.php'>";
			echo "<input type=hidden value=".$dpto." name='dpto' >";
			echo "<input type=hidden value=".$maestro." name='maestro' >";
			echo "<input type=submit value='VOLVER'>";
			echo "</form>";
            */
		?>
        <br>
        <div id="container3" style="width: 800px; height: 250px; margin: 0 auto"></div>
       	<br><br><br>
	</center>
<?php
include("final.php");
?>

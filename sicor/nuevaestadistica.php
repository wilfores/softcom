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

	$dpto=$_SESSION["departamento"];			//$maestro = $_GET["maestro"];
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
	$consulta = "	select  departamento_descripcion_dep as nombre
				from `departamento` where departamento_cod_departamento ='$dpto'";
	$res = mysql_query($consulta, $conn);
	$filaux=mysql_fetch_array($res);
	$nomdep = $filaux['nombre'];
	echo "<br><center><h2>".$nomdep."</h2></center>";
	?>
    <div id="mibody">
	<h2><center> ESTADISTICAS DEL DEPARTAMENTO </center></h2>
	<table align="center">
      <tr>
        <td>
            <table width="20%" border="1" cellpadding="1" >
                <tr style="font-size: 8pt; color:#FFFFFF" bgcolor="#3E6BA3" >
                    <td class="truno">Documentos</td>
                    <td class="truno">Cantidad</td>
                </tr>
            <? 	
//			$consulta1 = "	select registrodoc1_doc from registrodoc1 
//		$consulta1 = "	select registrodoc1_doc from reg1 
			$consulta1 = "	select registrodoc1_doc from registrodoc1  
							where registrodoc1_depto = '$dpto' group by registrodoc1_doc";
			$res1 = mysql_query($consulta1, $conn);
			$candoc = 0;
//			$contder = 0;
//			$contadoc1 = 0;
//			$contader = 0;
			$matdep;
			$fil=0;
			$totaldoc=0;
			while ($fila=mysql_fetch_array($res1)){
				echo "<tr>";
				$consulta2 = "	select documentos_descripcion from documentos
								where documentos_sigla = '$fila[registrodoc1_doc]'";
				$res2 = mysql_query($consulta2, $conn);
				$filaaux2 = mysql_fetch_array($res2);
				$matdep[$fil][0] = $filaaux2["documentos_descripcion"];
				echo "<td class='trdos'>".$filaaux2["documentos_descripcion"]."</td>";

//				$consulta3 = "	select COUNT(*) as total from reg1
				$consulta3 = "	select COUNT(*) as total from registrodoc1 
								where registrodoc1_depto = '$dpto' 
								and registrodoc1_doc = '$fila[registrodoc1_doc]'";
				$res3 = mysql_query($consulta3, $conn);
				$filaux3 = mysql_fetch_array($res3);
				//echo "-d-".$filaux3['total']."--<br>";
				$matdep[$fil][1] = $filaux3['total'];
				echo "<td class='trdos'>".$filaux3['total']."</td></tr>";
				$fil++;
				$totaldoc += $filaux3['total'];
			}
			?>
				<tr> <td class='truno'> TOTAL </td><td class='trdos'><? echo $totaldoc; ?> </td>
            </table>			
		  </td>
          <td>
			<div id="container" style="width: 650px; height: 350px; margin: 0 auto"></div><br>
          </td>
        <tr>
          <td>

			<table width="30%" border="1" cellpadding="1">
                <tr style="font-size: 8pt; color:#FFFFFF" bgcolor="#3E6BA3" >
                    <td class='truno'>Tiempo</td>  
                    <td class='truno'>Documentos</td>
                    <td class='truno'>Porcentaje</td>
                </tr>
            <? 	
			/*
			$consulta4 = "	select SUM(TIMESTAMPDIFF(DAY,  DATE(registrodoc1_fecha_elaboracion),CURDATE() )) as total
							from registrodoc1 where registrodoc1_depto_para = '$dpto'
							and registrodoc1_situacion = 'P' ";
			$res4 = mysql_query($consulta4, $conn);
			$aux4 = mysql_fetch_array($res4);
			$totpen = $aux4["total"];*/
			$matpen;
			$filp=0;
//							from registrodoc1 where registrodoc1_depto_para = '$dpto'
			$consulta5 = "	select TIMESTAMPDIFF(DAY,  DATE(registrodoc1_fecha_elaboracion),CURDATE() ) as dias
							from registrodoc1 where registrodoc1_depto_para = '$dpto'
							and registrodoc1_situacion = 'P' ";
			$res5 = mysql_query($consulta5, $conn);
			$sem1 = 0;
			$sem2 = 0;
			$sem3 = 0;
			$sem4 = 0;
			while ($filap=mysql_fetch_array($res5)){
				if ($filap["dias"]>0 && $filap["dias"]<8){
						$sem1++;
				}
				if ($filap["dias"]>7 && $filap["dias"]<15){
						$sem2++;
				}
				if ($filap["dias"]>14 && $filap["dias"]<22){
						$sem3++;
				}
				if ($filap["dias"]>21 ){
						$sem4++;
				}
			}
			$totpen = $sem1+$sem2+$sem3+$sem4;
			echo "<tr> <td class='trdos'> 1 Semana </td><td class='trdos'>".$sem1."</td><td class='trdos'>&nbsp;".round(($sem1*100)/$totpen)."%</td></tr>";
			echo "<tr> <td class='trdos'> 2 Semanas </td><td class='trdos'>".$sem2."</td><td class='trdos'>&nbsp;".round(($sem2*100)/$totpen)."%</td></tr>";
			echo "<tr> <td class='trdos'> 3 Semanas </td><td class='trdos'>".$sem3."</td><td class='trdos'>&nbsp;".round(($sem3*100)/$totpen)."%</td></tr>";
			echo "<tr> <td class='trdos'> Mas de 4 semanas </td><td class='trdos'>".$sem4."</td class='trdos'><td class='trdos'>&nbsp;".round(($sem4*100)/$totpen)."%</td></tr>";
			?>
				<tr> <td class='truno'> TOTAL </td><td class='trdos'><? echo $sem1+$sem2+$sem3+$sem4; ?> </td><td class='trdos'>100%</td></tr>
            </table>
          </td>
			<?
			$matpen[0][0]="1 Semana ";
			$matpen[0][1]=$sem1;
			$matpen[0][2]=round(($sem1*100)/$totpen);
			$matpen[1][0]="2 Semanas ";
			$matpen[1][1]=$sem2;
			$matpen[1][2]=round(($sem2*100)/$totpen);
			$matpen[2][0]="3 Semanas ";
			$matpen[2][1]=$sem3;
			$matpen[2][2]=round(($sem3*100)/$totpen);
			$matpen[3][0]="Mas de 4 semanas ";
			$matpen[3][1]=$sem4;
			$matpen[3][2]=round(($sem4*100)/$totpen);
			?>
		  <td>
			<div id="container2" style="width: 650px; height: 250px; margin: 0 auto"></div><br>
          </td>
        <tr>
          <td>
        <div id="dcontainer3">
			<table width="30%" border="1" cellpadding="1">
                <tr style="font-size: 8pt; color:#FFFFFF" bgcolor="#3E6BA3" >
                    <td class='truno'>Estado</td>
                    <td class='truno'>Cantidad</td>
                    <td class='truno'>Porcentaje</td>
                </tr>
			<?
			$mattip;
			$canp = 0;
			$cand = 0;
			$cana = 0;
//			$consulta6 = "select count(*) as total from registrodoc1 
			$consulta6 = "select count(*) as total from registrodoc1 
							where registrodoc1_depto_para = '$dpto'
							and registrodoc1_situacion = 'P' ";
			$res6 = mysql_query($consulta6, $conn);
			$aux6 = mysql_fetch_array($res6);
			$canp = $aux6["total"];
//			$consulta7 = "select count(*) as total from registrodoc1 
			$consulta7 = "select count(*) as total from registrodoc1 
							where registrodoc1_depto_para = '$dpto'
							and registrodoc1_situacion = 'D' ";
			$res7 = mysql_query($consulta7, $conn);
			$aux7 = mysql_fetch_array($res7);
			$cand = $aux7["total"];
//			$consulta8 = "select count(*) as total from registrodoc1 
			$consulta8 = "select count(*) as total from registrodoc1
							where registrodoc1_depto_para = '$dpto'
							and registrodoc1_situacion = 'A' ";
			$res8 = mysql_query($consulta8, $conn);
			$aux8 = mysql_fetch_array($res8);
			$cana = $aux8["total"];
			
			$totcor = $canp+$cand+$cana;
			echo "<tr> <td class='trdos'> Pendiente </td><td class='trdos'>".$canp."</td><td class='trdos'>&nbsp;".round(($canp*100)/$totcor)."%</td></tr>";
			echo "<tr> <td class='trdos'> Derivados </td><td class='trdos'>".$cand."</td><td class='trdos'>&nbsp;".round(($cand*100)/$totcor)."%</td></tr>";
			echo "<tr> <td class='trdos'> Archivados </td><td class='trdos'>".$cana."</td><td class='trdos'>&nbsp;".round(($cana*100)/$totcor)."%</td></tr>";
			?>
				<tr> <td class='truno'> TOTAL </td><td class='trdos'><? echo $canp+$cand+$cana; ?> </td><td class='trdos'>100%</td></tr>
            </table>
       </td>
       <td>
       	<div id="container3" style="width: 650px; height: 250px; margin: 0 auto"></div><br>
       </td>
      </tr>
   </table>
			<?
			$mattip[0][0]="Pendiente ";
			$mattip[0][1]=$canp;
			$mattip[0][2]=round(($canp*100)/$totcor);
			$mattip[1][0]="Derivados ";
			$mattip[1][1]=$cand;
			$mattip[1][2]=round(($cand*100)/$totcor);
			$mattip[2][0]="Archivados ";
			$mattip[2][1]=$cana;
			$mattip[2][2]=round(($cana*100)/$totcor);
		?>
    <script type="text/javascript" src="jquery/jquery.js"></script>
	<script type="text/javascript" src="jquery/highcharts.js"></script>
	<script type="text/javascript" src="jquery/exporting.js"></script>
    

	<script type="text/javascript">
			var chart;
			var chart2;
			var chart3;
            $(document).ready(function() {
                chart = new Highcharts.Chart({
					chart: {
						renderTo: 'container',
						type: 'column'
					},
                    title: {
                        text: 'DOCUMENTOS GENERADOS'
                    },
					subtitle: {
						text: 'Ministerio de Salud y Deportes'
					},
					xAxis: {
						categories: [ 'Total documentos'
								<? /*for($i=0;$i<$fil;$i++){
								 echo "'".$matdep[$i][0]."'" ;
								 if ($i < $fil-1)
								 	echo " , ";
								 }*/
								?>
						]
					},
					yAxis: {
						min: 0,
						title: {
							text: 'Cantidad'
						}
					},
					legend: {
						layout: 'vertical',
						backgroundColor: '#FFFFFF',
						align: 'left',
						verticalAlign: 'top',
						x: 270,
						y: 50,
						floating: true,
						shadow: true
					},					
					tooltip: {
						formatter: function() {
							return ''+
								this.x +': '+ this.y +' ';
						}
					},
					plotOptions: {
						column: {
							pointPadding: 0.2,
							borderWidth: 0
						}
					},
                    series: [
					<? for($j=0;$j<$fil;$j++){
								 echo "{ name : '".$matdep[$j][0]."' ," ;
								 echo "  data : [".$matdep[$j][1]."] }" ;
								 if ($j < $fil-1)
								 	echo ", ";
						}
					?>
					]
                });
				chart2 = new Highcharts.Chart({
					chart: {
						renderTo: 'container2',
						type: 'column'
					},
                    title: {
                        text: 'DOCUMENTOS PENDIENTES'
                    },
					subtitle: {
						text: 'Ministerio de Salud y Deportes'
					},
					xAxis: {
						categories: [ 'Pendientes'
								<? /*for($i=0;$i<$fil;$i++){
								 echo "'".$matdep[$i][0]."'" ;
								 if ($i < $fil-1)
								 	echo " , ";
								 }*/
								?>
						]
					},
					yAxis: {
						min: 0,
						title: {
							text: 'Pendientes'
						}
					},
					legend: {
						layout: 'vertical',
						backgroundColor: '#FFFFFF',
						align: 'left',
						verticalAlign: 'top',
						x: 270,
						y: 50,
						floating: true,
						shadow: true
					},					
					tooltip: {
						formatter: function() {
							return ''+
								this.x +': '+ this.y +' ';
						}
					},
					plotOptions: {
						column: {
							pointPadding: 0.2,
							borderWidth: 0
						}
					},
                    series: [
					<? for($j=0;$j<4;$j++){
								 echo "{ name : '".$matpen[$j][0]."' ," ;
								 echo "  data : [".$matpen[$j][1]."] }" ;
								 if ($j < 3)
								 	echo ", ";
						}
					?>
					]
                });
				chart3 = new Highcharts.Chart({
					chart: {
						renderTo: 'container3',
						type: 'column'
					},
                    title: {
                        text: 'DOCUMENTOS PROCESADOS'
                    },
					subtitle: {
						text: 'Ministerio de Salud y Deportes'
					},
					xAxis: {
						categories: [ 'Total'
								<? /*for($i=0;$i<$fil;$i++){
								 echo "'".$matdep[$i][0]."'" ;
								 if ($i < $fil-1)
								 	echo " , ";
								 }*/
								?>
						]
					},
					yAxis: {
						min: 0,
						title: {
							text: 'Procesados'
						}
					},
					legend: {
						layout: 'vertical',
						backgroundColor: '#FFFFFF',
						align: 'left',
						verticalAlign: 'top',
						x: 270,
						y: 50,
						floating: true,
						shadow: true
					},					
					tooltip: {
						formatter: function() {
							return ''+
								this.x +': '+ this.y +' ';
						}
					},
					plotOptions: {
						column: {
							pointPadding: 0.2,
							borderWidth: 0
						}
					},
                    series: [
					<? for($j=0;$j<3;$j++){
								 echo "{ name : '".$mattip[$j][0]."' ," ;
								 echo "  data : [".$mattip[$j][1]."] }" ;
								 if ($j < 2)
								 	echo ", ";
						}
					?>
					]
                });
			});
	</script>
	
	
	
  </div>
	<style>
	.truno {
		margin: 4px;
		border: 0px solid #cccccc;
		/*background-color: #e3e9ef; */
		background-color:#BCC9E0; 
		padding: 10px;
		font-size: 11px;
		color: #254D78;
	}
	.trdos {
	margin: 4px;
	border: 0px solid #cccccc;
	background-color: #ffffff;
	padding: 10px;
	font-size: 11px;
	color: #254D78;
	}
	</style>
<?php
include("final.php");
?>

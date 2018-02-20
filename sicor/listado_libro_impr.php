<?php
include("../filtro.php");
?>
<?php
include("inicio.php");
?>
<?php
include("script/functions.inc");
include("script/cifrar.php");
include("../conecta.php");
$cod_institucion=$_SESSION["institucion"];
$codigo_usuario=$_SESSION["codigo"];
$cargo_unico=$_SESSION["cargo_asignado"];
unset($_SESSION["codigo_libro_reg"]);
$fecha_hoy = date("Y-m-d");

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

echo "$codigo_usuario<br>";
echo "$cargo_unico<br>";

$s_dep_s="select cargos_dependencia from cargos where cargos_id='$cargo_unico'";
$r_dep_s = mysql_query($s_dep_s, $conn);
$row_dep=mysql_fetch_array($r_dep_s);
$cod_dep=$row_dep[0];
	
/*
	while ($row_ent2 = mysql_fetch_array($rs_ent2)) 
	{  
		$doc_arch=cifrar($row_ent2['registrodoc1_hoja_ruta']);
		
		$sql_usu2="SELECT * FROM usuario WHERE usuario_ocupacion='$row_ent2[registrodoc1_de]'";
		$rs_usu2= mysql_query($sql_usu2, $conn);
		$nom_usu2=mysql_fetch_array($rs_usu2);
		
	}
*/
//codigo de paginacion
if (!isset($pg))
$pg = 0; // $pg es la pagina actual
$cantidad=15; // cantidad de resultados por página
$inicial = $pg * $cantidad;

//-------------

if ($_SESSION["cargo"] == "Ventanilla")
{
  $sql_ent2 = "SELECT * FROM registrodoc1 WHERE registrodoc1_estado='R' and registrodoc1_situacion='P' and registrodoc1_cc='E' GROUP BY registrodoc1_cite ORDER BY registrodoc1_fecha_recepcion DESC";
 }
 else
 {/*consulta para la secretaria*/
 $sql_ent2 = "SELECT * FROM registrodoc1 WHERE '$cod_dep'=registrodoc1_para and registrodoc1_estado='R' and registrodoc1_situacion='P' and registrodoc1_cc='E' GROUP BY registrodoc1_cite ORDER BY registrodoc1_fecha_recepcion DESC";
 }
$rs_ent2 = mysql_query($sql_ent2, $conn);

/* ORDER BY registrodoc1_hoja_ruta DESC LIMIT $inicial,$cantidad*/

$total_records = mysql_num_rows($rs_ent2);
$pages = intval($total_records / $cantidad);
 
/*if (isset($_POST['imprimir']))
 {  
 	$var=$_POST['lista_hr'];
	$elementos = count($var);
	for($i=0; $i < $elementos; $i++)
	{
		echo "$var[$i]<br>";
	}
	?>
		<script language="JavaScript">
			//window.self.location="listado_libro_impr_list.php?hojasruta[]=<?=$var;?>";	
		</script>
	<?php 
  }*/
?>
<script language="JavaScript">
function Retornar(){
	document.ingreso.action="menu2.php";
	document.ingreso.submit();
 }
</script>
<br>
<p class="fuente_titulo">
<center><b style=" font-size:18px">LIBRO DE REGISTRO</b></center></p></center>

<table width="90%" cellspacing="1" cellpadding="1" border="0" align="center">
<tr style="font-size: 8pt; color:#FFFFFF" bgcolor="#3E6BA3">
	<td width="1%" align="center">&nbsp;<b></b></td>
	<td width="8%" align="center"><span >Hoja Ruta</td>
	<td width="10%" align="center"><span >Fecha Recepcion</td>
	<td width="17%" align="center"><span >Referencia</td>
	<td width="6%" align="center"><span >Tipo</td>
	<td width="10%" align="center"><span >Tipo Doc</td>
	<td width="13%" align="center"><span >Remitente</td>
	<td width="13%" align="center"><span >Destinatario</td>
	<!--<td width="11%" align="center"><span ></td>-->
</tr>
<!--<DIV class=tableContainer id=tableContainer>
<div style="overflow:auto; width:100%; height:210px; align:left;">
<center>

<form action="listado_libro_impr_list.php" name="ingreso" method="POST" target="_blank">-->
<form action="pruebacodigo20122.php" name="ingreso" method="POST" target="_blank">
<?php
if (!empty($rs_ent2)) 
{
 $resaltador=0;
 
 while ($row= mysql_fetch_array($rs_ent2))
	 {
		
		 if ($resaltador==0)
		  {
		   echo "<tr class=truno>";
		   $resaltador=1;
		  }
		  else
		  {
		   echo "<tr class=trdos>";
		   $resaltador=0;
		  }
	 
	?>
	
	<td align="center" width="4%">
	<input name="lista_hr[]" type="checkbox" value="<?php echo $row["registrodoc1_hoja_ruta"];?>" />
	</td>	
	<td align="center" width="8%"><?php echo $row["registrodoc1_hoja_ruta"];?>
	</td>
	
	<td align="center" width="10%"><?php echo $row["registrodoc1_fecha_recepcion"];?>
	</td>
	
	<td align="center" width="12%"><?php echo $row["registrodoc1_referencia"];?>
	</td>	
	
	<td align="center" width="12%"><?php
	$tipo = $row["registrodoc1_tipo"];
	if ($tipo=="INTERNO") 
	{
	   $rdocsig=mysql_query("SELECT * from documentos 
							where documentos_sigla='$row[registrodoc1_doc]'",$conn);
	   $rpdoc=mysql_fetch_array($rdocsig);
	   echo "$rpdoc[documentos_descripcion]";
	
	} 
	else 
	{ 
		
	   $rdocsig=mysql_query("SELECT * from clasecorrespondencia 
							where clasecorrespondencia_codigo_clase_corresp='$row[registrodoc1_doc]'",$conn);
	   $rpdoc=mysql_fetch_array($rdocsig);
	   echo "$rpdoc[clasecorrespondencia_descripcion_clase_corresp]";
	}	
	 
	 ?>
	</td>	
	
	<?php 

	?>	
	<td align="center" width="6%"><?php echo $tipo_hr;
	if ($tipo=="INTERNO") {
	  echo "INTERNO";
	} else 
	{ echo "EXTERNO"; }
	?>
	</td>
	
	<td align="center" width="15%">
	<?php
	if ($tipo=='INTERNO')
	{
	  	$valor_clave=$row["registrodoc1_de"];
		$conexion = mysql_query("SELECT * FROM cargos WHERE '$valor_clave'=cargos_id",$conn);
		if($fila_clave=mysql_fetch_array($conexion))
		{
			$valor_cargo=$fila_clave["cargos_id"];
			$conexion2 = mysql_query("SELECT * FROM usuario WHERE '$valor_cargo'=usuario_ocupacion",$conn);
			if($fila_cargo=mysql_fetch_array($conexion2))
			{
			echo $fila_cargo["usuario_nombre"];
			}
		}
	 
	}
	 else 
	{ 
		$valor_clave=$row["registrodoc1_de"];
		$conexion = mysql_query("SELECT * FROM usuarioexterno WHERE '$valor_clave'=usuarioexterno_codigo",$conn);
		if($fila_clave=mysql_fetch_array($conexion))
		{
			echo "$fila_clave[usuarioexterno_nombre]";
			/*
			$valor_cargo=$fila_clave["cargos_id"];
			$conexion2 = mysql_query("SELECT * FROM usuario WHERE '$valor_cargo'=usuario_ocupacion",$conn);
			if($fila_cargo=mysql_fetch_array($conexion2))
			{
			echo $fila_cargo["usuario_nombre"];
			}*/
		}
	
		
	}
	?>
	</td>
	
	<td align="center" width="15%">
	<?php
	$valor_clave=$row["registrodoc1_para"];
	$conexion = mysql_query("SELECT * FROM cargos WHERE '$valor_clave'=cargos_id",$conn);
	if($fila_clave=mysql_fetch_array($conexion))
	{
		$valor_cargo=$fila_clave["cargos_id"];
		$conexion2 = mysql_query("SELECT * FROM usuario WHERE '$valor_cargo'=usuario_ocupacion",$conn);
		if($fila_cargo=mysql_fetch_array($conexion2))
		{
		echo $fila_cargo["usuario_nombre"];
		}
	}
	
	$hrc=cifrar($row["registrodoc1_hoja_ruta"]);
	?>
	</td>
	<!--
	<td align="center" width="11%">	
		<a href="hoja_ruta_doc.php?hr1=<?php echo $hrc;?>" onmouseover="window.status='Guia de sitio';return true" onmouseout="window.status='';return true" target="_blank">
		<img src="images/imp_h_r.png" onmouseover="this.src='images/imp_h_r1.png'" onmouseout="this.src='images/imp_h_r.png'">
		</a>                         
	 </td>-->
	</tr>
	<?php
  }//fin de while 
  /*
	echo "<p class=fonty>";
	if ($pg != 0) {
	$url = $pg - 1;
	echo "<a href='$PHP_SELF?pg=".$url."'>&laquo; Anterior</a>&nbsp;";
	} else {
	echo " ";
	}
	for ($i = 0; $i <= $pages; $i++) {
	if ($i == $pg) {
	if ($i == "0") {
	echo "<b> 1 </b>";
	} else {
	$i = $i+1;
	echo "<b> ".$i." </b>";
	}
	} else {
	if ($i == "0") {
	echo "<a href=$PHP_SELF?pg=".$i.">1</a> ";
	} else {
	echo "<a href='$PHP_SELF?pg=".$i."'>";
	$i = $i+1;
	echo $i."</a>&nbsp;";
	}
	}
	}
	if ($pg < $pages) {
	$url = $pg + 1;
	echo "<a href='$PHP_SELF?pg=".$url."'>Siguiente &raquo;</a>";
	} else {
	echo " ";
	}
	echo "</p>";
  */
}
?>
</table>
</center>
</div>
<br>
<center>
<table width="70%" cellspacing="2" cellpadding="2" border="0">
<tr class="border_tr">
<td width="95%" align="center">
<input type="submit" name="imprimir" value="Imprimir" class="boton"/>
<input type="reset" name="cancelar" value="Cancelar" onClick="Retornar();" class="boton" />
</td>
</tr>
</table>
</form>
</center>
<?php
include("final.php");
?>
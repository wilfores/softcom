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
$codigo=$_SESSION["cargo_asignado"];
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
//echo "$codigo <br>";
//echo "$codigo_usuario <br>";

//codigo de paginacion
if (!isset($pg))
$pg = 0; // $pg es la pagina actual
$cantidad=10; // cantidad de resultados por página
$inicial = $pg * $cantidad;

//-------------
$ssql="SELECT * FROM libroregistro WHERE '$cargo_unico'=libroregistro_cod_usr ORDER BY libroregistro_cod_registro DESC LIMIT $inicial,$cantidad";
$rss=mysql_query($ssql,$conn);
//-----
$contar = "SELECT 
registrodoc1_hoja_ruta, registrodoc1_fecha_elaboracion, usuario_nombre, registrodoc1_referencia, documentos_descripcion, registrodoc1_estado, registrodoc1_asociar, registrodoc1_asociar_h_r
FROM `registrodoc1`, `documentos`, `usuario`
where registrodoc1_de = '$codigo' 
and registrodoc1_para=usuario_ocupacion
and registrodoc1_doc=documentos_sigla
GROUP BY registrodoc1_hoja_ruta DESC LIMIT $inicial,$cantidad";

$contarok=mysql_query($contar,$conn);
$total_records = mysql_num_rows($contarok);
$pages = intval($total_records / $cantidad);
?>
<script language="JavaScript">
function CopiaValor(objeto) {
	document.ingreso.sel_ingreso.value = objeto.value;
}

function Retornar(){
	document.ingreso.action="menu2.php";
	document.ingreso.submit();
}

function libro_usuario()
{
	if (document.lista.sel_usuario.value!="")
	{
		document.lista.action="listado_de_mi.php";
		document.lista.submit();
	}
}

</script>
<script language="JavaScript">
function Abre_ventana (pagina)
{
     ventana=window.open(pagina,"Asignar","toolbar=no,location=0,directories=no,status=no,menubar=no,scrollbars=yes,resizable=yes,width=420,height=200");
}
function Retornar(){
	document.ingreso.action="menu2.php";
	document.ingreso.submit();
}
</script>

<p class="fuente_titulo">
<center><b>LIBRO DE REGISTRO</b></center></p></center>
<form name="ingreso" action="for_nuevo_doc2.php" method="POST">
<center>
<input type="reset" name="cancelar" value="Cancelar" onClick="Retornar();" style="font-size:9px; color:blue;" class="boton"/>
<input type="submit" name="imprimir" value="Nuevo Documento" style="font-size:9px; color:blue;" class="boton"/>
</center>
<table width="90%" cellspacing="1" cellpadding="1" border="0" align="center">
<tr style="font-size: 8pt; color:#FFFFFF" bgcolor="#3E6BA3">
	<td width="7%" align="center"><span >Hoja Ruta</td>
	<td width="8%" align="center"><span >Fecha Elaboracion</td>
	<td width="15%" align="center"><span >Destinatario</td>
	<td width="20%" align="center"><span >Referencia</td>
	<td width="14%" align="center"><span >Tipo Doc</td>
	<td width="8%" align="center"><span >Estado</td>	
	<td width="15%" align="center"></td>
	
</tr>

<?php
$slista="SELECT 
registrodoc1_hoja_ruta, registrodoc1_fecha_elaboracion, usuario_nombre, registrodoc1_referencia, documentos_descripcion, registrodoc1_estado, registrodoc1_asociar, registrodoc1_asociar_h_r
FROM `registrodoc1`, `documentos`, `usuario`
where registrodoc1_de = '$codigo' 
and registrodoc1_para=usuario_ocupacion
and registrodoc1_doc=documentos_sigla
GROUP BY registrodoc1_hoja_ruta";
$rslista=mysql_query($slista,$conn);
if (!empty($rslista)) 
{
 $resaltador=0;
 while($rwlista=mysql_fetch_array($rslista))
 {
	 //$valor_vect=$row["libroregistro_cod_registro"];
	
	 $doc_arch=cifrar($rwlista["registrodoc1_hoja_ruta"]);
 
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
<td align="center"><?php 
if($rwlista[registrodoc1_asociar]=='si'){echo "<font color=#CC0000>Doc. Asociado $rwlista[registrodoc1_asociar_h_r]";}
else {echo $rwlista[registrodoc1_hoja_ruta];}?>
</td>

<td align="center"><?php echo $rwlista[registrodoc1_fecha_elaboracion];?>
</td>

<td align="left"><?php echo $rwlista[usuario_nombre];?>
</td>

<td align="left"><?php echo $rwlista[registrodoc1_referencia]; ?>
</td>

<td align="left"><?php echo $rwlista[documentos_descripcion];?></td>

<?php
if($rwlista['registrodoc1_estado']=='SR') 
{$rep='No Recepcionado';?><td align="center" style="color:#990000; font-size:10px"><?php echo "$rep";?></td>
<?php }
else {$rep='Recepcionado';?>
<td align="center" style="font-size:10px"><?php echo "$rep";?></td>
 <?php }?>
</td>

<td align="center">
<a href="impresion_doc.php?hr1=<?php echo $doc_arch;?>" onmouseover="window.status='Guia de sitio';return true" onmouseout="window.status='';return true">
<img src="images/elaborar.png" onmouseover="this.src='images/elaborar1.png'" onmouseout="this.src='images/elaborar.png'"></a>

<a href="javascript:Abre_ventana('subir_arch_elab.php?hr1=<? echo $doc_arch;?>')" onmouseover="window.status='Guia de sitio';return true" onmouseout="window.status='';return true">
<img src="images/subir.png" onmouseover="this.src='images/subir1.png'" onmouseout="this.src='images/subir.png'"></a>
</td>
</tr>
<?php
} 
	
		/*echo "<p class=fonty>";
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
<br>
</form>
</center>
<?php
include("final.php");
?>
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
$cantidad=20; // cantidad de resultados por página
$inicial = $pg * $cantidad;

//-------------
$ssql="SELECT * FROM libroregistro WHERE '$cargo_unico'=libroregistro_cod_usr ORDER BY libroregistro_cod_registro DESC LIMIT $inicial,$cantidad";
$rss=mysql_query($ssql,$conn);
//-----
$contar = "SELECT * FROM libroregistro WHERE '$cargo_unico'=libroregistro_cod_usr ORDER BY libroregistro_cod_registro";
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

<p class="fuente_titulo">
<center><b>LISTADO DE CORRESPONDENCIA ARCHIVADA</b></center></p></center>

<table width="" cellspacing="5" cellpadding="5" border="0" height="" align="center">
<tr style="font-size: 8pt; color:#FFFFFF;" bgcolor="#3E6BA3">
	<td width="" align="center"><span >Hoja Ruta</td>
	<td width="" align="center"><span >Fecha Archivada</td>
	<td width="" align="center"><span >Referencia</td>
	<td width="" align="center"><span >Remitente</td>
	<td width="" align="center" bgcolor="#FFFFFF"><span ></td>
	<!--<td width="" align="center" bgcolor="#FFFFFF"><span ></td>-->
</tr>
<form name="ingreso" action="" method="POST">
<?php
$slista="SELECT * FROM archivados WHERE '$codigo'=archivados_quien";
$rslista=mysql_query($slista,$conn);
if (!empty($rslista)) 
{
 $resaltador=0;
 while($rwlista=mysql_fetch_array($rslista))
 {
 //****
 $hoja_ruta = $rwlista["archivados_hoja_ruta"];
 $hr1 = cifrar($hoja_ruta);
 //****
 $valor_vect=$row["libroregistro_cod_registro"];
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
<td align="center"><?php echo $rwlista[1];?>
</td>

<td align="center"><?php echo $rwlista[2];?>
</td>

<td align="center"><?php echo $rwlista[3]; ?>
</td>

<td align="center"><?php echo $rwlista[4];?>
</td>
<!--
<td align="center" ><a href="ver_doc_adjuntos.php?hr1=<? echo $hr1;?>" class="botonte" target="_top">Ver</a>
</td>-->
<td align="center" ><a href="desarchivar.php?hr1=<?php echo $hr1;?>" class="botonte" target="_top">Desarchivar</a>
</td>

</tr>
<?php
} 
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
		//echo "<b> 1 </b>";
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
  
}
?>
</table>

<br>
<center>
<table width="" cellspacing="2" cellpadding="2" border="0">
<tr class="border_tr">
<td width="" align="center">
<!--
<input type="hidden" name="sel_ingreso">
<input type="hidden" name="cod_institucion" value="<?php echo $cod_institucion;?>">
<input type="submit" name="imprimir" value="Nuevo Documento" style="font-size:9px; color:blue;"/>
<input type="reset" name="cancelar" value="Cancelar" onClick="Retornar();" style="font-size:9px; color:blue;" />
-->
</td>
</tr>
</table>
</form>
</center>
<?php
include("final.php");
?>
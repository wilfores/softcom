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
//unset($_SESSION["codigo_libro_reg"]);
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

$t=10;
if(!isset($_GET['pagina'])) {
$pagina=1;
$inicio=0;
}
else {
$pagina=$_GET['pagina'];
$inicio=($pagina-1)*$t;
}

?>
<script language="JavaScript">

function Abre_ventana (pagina)
{
     ventana=window.open(pagina,"Asignar","toolbar=no,location=0,directories=no,status=no,menubar=no,scrollbars=yes,resizable=yes,width=420,height=200");
	 function checkfocus()
	 {
		if(!ventana.focus())
			ventana.focus();
	 }
	 setInterval('checkfocus()',1000);
}

function Retornar(){
	document.ingreso.action="menu2.php";
	document.ingreso.submit();
}
</script>

<br>
<p class="fuente_titulo">
<center><b style=" font-size:18px">LISTADO DE AFILIADOS REGISTRADOS</b></center></p></center>
<form name="ingreso" action="afiliacion.php" method="POST">
<center>
<!--<input type="reset" name="cancelar" value="Cancelar" onClick="Retornar();" class="boton"/>-->
<? if($camb_gest==2014)
{ ?>
<input type="submit" name="imprimir" value="Nuevo Documento" style="font-size:10px; color:blue;"/>
<? } ?>
<!--  style="font-size:9px; color:blue;"-->
</center>

<table width="95%" cellspacing="1" cellpadding="1" border="0" align="center">
<tr style="font-size: 8pt; color:#FFFFFF" bgcolor="#3E6BA3">
	<td width="7%" align="center"><span >AP PATERNO</td>
	<td width="7%" align="center"><span >AP MATERNO</td>
	<td width="8%" align="center"><span >NOMBRE</td>
	<td width="7%" align="center"></td>
	
</tr>
<!--<meta content="5;URL=listado_de_mi2.php" http-equiv="REFRESH">-->
<?php
$slista="SELECT 
afiliacionreg_id, afiliacionreg_pat, afiliacionreg_mat, afiliacionreg_nom
FROM `afiliacionreg`
ORDER BY afiliacionreg_id desc LIMIT 0, 2000";
$rslista=mysql_query($slista,$conn);
$lim_inferior=1;
$lim_superior=1;
$total_paginas = ceil(mysql_num_rows($rslista) / $t);

if (!empty($rslista)) 
{
 $resaltador=0;
 while($rwlista=mysql_fetch_array($rslista))
 {
	 //$valor_vect=$row["libroregistro_cod_registro"];
	if ($lim_inferior>$inicio && $lim_superior<=$t)
	{
	 $doc_arch=cifrar($rwlista["afiliacionreg_id"]);
	 //$doc_aso=$rwlista["registrodoc1_asociar"];
 
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
<td align="center"><?php echo $rwlista[afiliacionreg_pat];?>
</td>

<td align="center"><?php echo $rwlista[afiliacionreg_mat];?>
</td>

<td align="center"><?php echo $rwlista[afiliacionreg_nom];?>
</td>
<td align="center">
<a href="impresion_afi2.php?hr1=<?php echo  $doc_arch;?>" onMouseOver="window.status='Guia de sitio';return true" onMouseOut="window.status='';return true" target="_blank">
<img src="images/elaborar.png" onMouseOver="this.src='images/elaborar1.png'" onMouseOut="this.src='images/elaborar.png'"></a>
</td>

</tr>
<?php
	$lim_superior++;
	}//FIN DE IF
$lim_inferior++;
}// FIN DE WHILE 

}
?>
</table>
</center>
</meta>
<center>
<?php
for ($i=1;$i<=$total_paginas;$i++) 
{
	if ($i!=$pagina) 
	{	$suiguiente=$i;
	echo "<a href=$PHP_SELF?pagina=$i><font color=#FF6600>$i</font></a> ";
	}
	else {
	echo " | ".$i." | ";
	}
}

?>
<br>
</form>
</center>

<?php
include("final.php");
?>
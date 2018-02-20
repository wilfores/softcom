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
<center><b style=" font-size:18px">LISTADO DE ARCHIVOS GENERADOS</b></center></p></center>
<form name="ingreso" action="for_nuevo_doc2.php" method="POST">
<center>
<!--<input type="reset" name="cancelar" value="Cancelar" onClick="Retornar();" class="boton"/>-->
<? if($camb_gest==2015)
{ ?>
<input type="submit" name="imprimir" value="Nuevo Documento" style="font-size:10px; color:blue;"/>
<? } ?>
<!--  style="font-size:9px; color:blue;"-->
</center>

<table width="95%" cellspacing="1" cellpadding="1" border="0" align="center">
<tr style="font-size: 8pt; color:#FFFFFF" bgcolor="#3E6BA3">
	<td width="7%" align="center"><span >Hoja Ruta</td>
	<td width="7%" align="center"><span >No Cite</td>
	<td width="8%" align="center"><span >Fecha Elaboracion</td>
	<td width="15%" align="center"><span >Destinatario</td>
	<td width="20%" align="center"><span >Referencia</td>
	<td width="10%" align="center"><span >Tipo Doc</td>
	<td width="8%" align="center"></td>	
	<td width="16%" align="center"></td>
	
</tr>
<!--<meta content="5;URL=listado_de_mi2.php" http-equiv="REFRESH">-->
<?php
$slista="SELECT 
registrodoc1_id, registrodoc1_hoja_ruta, registrodoc1_fecha_elaboracion, usuario_nombre, registrodoc1_referencia, documentos_descripcion, registrodoc1_estado, registrodoc1_asociar, registrodoc1_asociar_h_r, registrodoc1_cc, registrodoc1_cite, usuario_ocupacion, registrodoc1_asociar, documentos_id, registrodoc1_situacion
FROM `registrodoc1`, `documentos`, `usuario`
where registrodoc1_de = '$codigo' 
and registrodoc1_para=usuario_ocupacion
and registrodoc1_doc=documentos_sigla ORDER BY registrodoc1_fecha_elaboracion desc LIMIT 0, 2000";
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
	 $doc_arch=cifrar($rwlista["registrodoc1_hoja_ruta"]);
	 $doc_arch2=cifrar($rwlista["registrodoc1_cite"]);
	 $doc_arch3=cifrar($rwlista["registrodoc1_id"]);
	 $doc_aso=$rwlista["registrodoc1_asociar"];
 
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

<td align="center"><?php echo $rwlista[registrodoc1_cite];?>
</td>

<td align="center"><?php echo $rwlista[registrodoc1_fecha_elaboracion];?>
</td>

<td align="left"><?php echo $rwlista[usuario_nombre];?>
</td>

<td align="left"><?php echo $rwlista[registrodoc1_referencia]; ?>
</td>

<td align="left"><?php echo $rwlista[documentos_descripcion];?></td>

<?php
if($rwlista['registrodoc1_estado']=='SR' and $rwlista['documentos_id']==13 and $rwlista['registrodoc1_asociar']<>'si' and $rwlista['registrodoc1_situacion']=='P') 
{$rep='No Recepcionado';?><td align="center" style="color:#990000; font-size:10px">

<a href="mod_destinatario.php?hrid1=<? echo $doc_arch3;?>&nrohjrt=<? echo $doc_arch;?>" onMouseOver="window.status='Guia de sitio';return true" onMouseOut="window.status='';return true">
<img src="images/cam_dest.png" onMouseOver="this.src='images/cam_dest2.png'" onMouseOut="this.src='images/cam_dest.png'"></a>

</td>
<?php }
else {$rep='Recepcionado';?>
<td align="center" style="font-size:10px"></td>
 <?php }?>
</td>
<?php 
if($rwlista['registrodoc1_cc']=='NE' )
{
	if($rwlista['registrodoc1_situacion']!='E')
	{
?>
<td align="center">
<a href="impresion_doc.php?hr1=<?php echo  $doc_arch2;?>&as=<?php echo  $doc_aso;?>" onMouseOver="window.status='Guia de sitio';return true" onMouseOut="window.status='';return true">
<img src="images/elaborar.png" onMouseOver="this.src='images/elaborar1.png'" onMouseOut="this.src='images/elaborar.png'"></a>

<a href="javascript:Abre_ventana('subir_arch_elab.php?hr1=<? echo $doc_arch2;?>')" onMouseOver="window.status='Guia de sitio';return true" onMouseOut="window.status='';return true">
<img src="images/subir.png" onMouseOver="this.src='images/subir1.png'" onMouseOut="this.src='images/subir.png'"></a>

<a href="eliminadoc.php?hr1=<? echo $doc_arch2;?>" onMouseOver="window.status='Guia de sitio';return true" onMouseOut="window.status='';return true">
<img src="images/eliminacite.png" onMouseOver="this.src='images/eliminacite1.png'" onMouseOut="this.src='images/eliminacite.png'"></a>
</td>
<? 
	}
	else
	{
?>
<td align="center" style="color:#CC0000">
<strong><em>CITE ANULADO</em></strong>
</td>
<? 	
	}
	
}
else
{
	if($rwlista['registrodoc1_asociar']<>'si')
	{ 
		if($rwlista['documentos_id']==13)
		{
	?>
	<td align="center">
		<a href="hoja_ruta_doc.php?hr1=<?php echo $doc_arch;?>" onmouseover="window.status='Guia de sitio';return true" onmouseout="window.status='';return true" target="_blank">
		<img src="images/imp_h_r.png" onmouseover="this.src='images/imp_h_r1.png'" onmouseout="this.src='images/imp_h_r.png'">
		</a>	
	</td>
	<?
		}
		else
		{
		?>
		<td align="center">
		</td>
		<?
		}
	}
	else
	{
	?>
	<td align="center">
	</td>
	<?
	}
}
?>
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
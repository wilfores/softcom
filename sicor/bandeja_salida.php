<link rel="stylesheet" type="text/css" href="script/ventanita.css">
<?php
include("../filtro.php");
include("script/functions.inc");
include("../conecta.php");
include("script/cifrar.php");

$cod_institucion=$_SESSION["institucion"];
$cargo_unico=$_SESSION["cargo_asignado"];
//echo "$cargo_unico";
$sw=0;

$gestion=$_SESSION["gestion"];
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
	if (!isset($_GET['orden']))
	{
            $orden = "seguimiento_fecha_deriva";
	}
	else
	{
            $orden=$_GET['orden'];
	}
        
$ssql="SELECT * FROM seguimiento
       WHERE '$cargo_unico'= seguimiento_destinatario
       AND (seguimiento_tipo='A' OR seguimiento_tipo='R')
       AND seguimiento_estado='P' ORDER BY ".$orden." DESC";
$rss=mysql_query($ssql,$conn);
?>

<STYLE type="text/css"> 
    A:link {text-decoration:none;color:#FFFFFF;} 
    A:visited {text-decoration:none;color:#CEDCEA;} 
    A:active {text-decoration:none;color:#FFFFFF;} 
    A:hover {text-decoration:underline;color:#DDE5EE;} 
	
	/*.botonte {
	BORDER-RIGHT: #4E85C2 2px solid; 
	BORDER-TOP: #4E85C2 2px solid; 
	BORDER-BOTTOM: #4E85C2 2px solid; 
	BORDER-LEFT: #4E85C2 2px solid; 
	BACKGROUND: #328FC0; 
	HEIGHT: 12px; 
	FONT-FAMILY: Arial; 
	FONT-SIZE: 8pt; */
}
</STYLE>

<script language="JavaScript">
function CopiaValor(objeto) {
	document.recepcion.sel_derivar.value = objeto.value;
}

function Retornar()
{
	document.recepcion.action="principal.php";
	document.recepcion.submit();
}
</script>

<center>
<!--
<table width="90%" border="0">
     <tr bgcolor="#666666">
        <td style="font-size: 11px; color:#FFFFFF"><strong>BANDEJA DE SALIDA&nbsp;&nbsp;&nbsp; HR :</strong> 
		<input type="text" id="entrada" size="12" />
        <a href="#" id="limp_ent" class="botonvent" style="background-color: black;">Limpiar filtro</a>
		</td>
	</tr>
</table>-->
<table cellspacing="1" cellpadding="1" border="1" style="font-size: 8pt;" width="90%" bordercolor="#FFFFFF">
	<tr style="font-size: 8pt; color:#FFFFFF;" bgcolor="#3E6BA3">		
		<td align="center">Hoja de Ruta</a></td>
		<td align="center">Fecha de Envio</td>
		<td align="center">Referencia</td>
		<td align="center">Dirigido a</a></td>		
		<td align="center">Situacion</td>		
		
	</tr>
<?php	
	$sql_der = "SELECT * FROM derivardoc WHERE '$cargo_unico'=derivardoc_de and derivardoc_situacion='SR' order by derivardoc_fec_derivacion desc";
	$rs_der = mysql_query($sql_der, $conn);
	while ($row_der = mysql_fetch_array($rs_der)) 
	{  
		//$hr2=$row_ent['registrodoc_hoja_ruta']; 
		$doc_arch1=cifrar($row_der['derivardoc_hoja_ruta']);
		$doc_hr_cod=cifrar($row_der['derivardoc_cod']);
		$sw_cont=$row_der['derivardoc_n_derivacion'];
		
		$sql_usu2="SELECT * FROM usuario WHERE usuario_ocupacion='$row_der[derivardoc_para]'";
		$rs_usu2= mysql_query($sql_usu2, $conn);
		$nom_usu2=mysql_fetch_array($rs_usu2);
	?>	
	<tr style="font-size: 8pt;" class="trdos">
		<td align="center"><?php echo $row_der['derivardoc_hoja_ruta'];?></td>	
		<td align="center"><?php echo $row_der['derivardoc_fec_derivacion'];?></td>
		<td align="center"><?php echo $row_der['derivardoc_proveido'];?></td>
		<td align="center"><?php echo $nom_usu2[2];?></td>
		<?php
		if($sw_cont < 999)
		{
		?>
		<td align="center">
		Pendiente
		<!--<a href="quitar_deri.php?hr1=<?php echo $doc_arch1;?>&hrcod=<?php echo $doc_hr_cod;?>" class="botonte" target="_top">Quitar Der</a>	-->	
		</td>
		<?php 
		}
		else
		{
		?>
		<td align="center"><?php if($row_der['derivardoc_estado']=='P') echo'Pendiente';
								 if($row_der['derivardoc_estado']=='A') echo'Archivado';
								 if($row_der['derivardoc_estado']=='D') echo'Derivado';	
		?></td>
		<?php 
		}
		?>

		
		<!--
		<td align="center"><?php if($row_der['derivardoc_estado']=='P') echo'Pendiente';
								 if($row_der['derivardoc_estado']=='A') echo'Archivado';
								 if($row_der['derivardoc_estado']=='D') echo'Derivado';	
		?></td>
	
		<td align="center" >
		<a href="seguimiento_doc.php?hr1=<?php echo $doc_arch1;?>" class="botonte" target="_top">Ver</a>		
		</td>-->		
		
	</tr>

	<?php 
	}
	
	//$dir="adjunto";
	$sql_ent = "SELECT * FROM registrodoc1 WHERE '$cargo_unico'=registrodoc1_de and registrodoc1_estado='SR' and registrodoc1_cc<>'NE' and registrodoc1_asociar<>'si' and registrodoc1_hoja_ruta<>'0' order by registrodoc1_fecha_elaboracion desc";
	$rs_ent = mysql_query($sql_ent, $conn);
	while ($row_ent = mysql_fetch_array($rs_ent)) 
	{  
		//$hr2=$row_ent['registrodoc_hoja_ruta']; 
		$doc_arch=cifrar($row_ent['registrodoc1_hoja_ruta']);
		
		$sql_usu="SELECT * FROM usuario WHERE usuario_ocupacion='$row_ent[registrodoc1_para]'";
		$rs_usu= mysql_query($sql_usu, $conn);
		$nom_usu=mysql_fetch_array($rs_usu);
	?>	
	<tr style="font-size: 8pt;" class="">
		<td align="center"><?php echo $row_ent['registrodoc1_hoja_ruta'];?></td>
		<td align="center"><?php echo $row_ent['registrodoc1_fecha_elaboracion'];?></td>	
		<td align="center"><?php echo $row_ent['registrodoc1_referencia'];?></td>
		<td align="center"><?php echo $nom_usu[2];?></td>
		<td align="center"><?php if($row_ent['registrodoc1_situacion']=='P') echo'Pendiente';
								 if($row_ent['registrodoc1_situacion']=='A') echo'Archivado';
								 if($row_ent['registrodoc1_situacion']=='D') echo'Derivado';	
		?></td>
		<!--
		<td align="center" >
		<a href="seguimiento_doc.php?hr1=<?php echo $doc_arch;?>" class="botonte" target="_top">Ver</a>		
		</td>	-->	
		
	</tr>

	<?php 
	}
	?>
	

</table>

</center>

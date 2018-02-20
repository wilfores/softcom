<?php
include("../filtro.php");
?>
<?php
include("inicio.php");
?>
<?php
include("../conecta.php");
include("cifrar.php");
include("script/functions.inc");
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

$cod_institucion=$_SESSION["institucion"];
$cargo_unico=$_SESSION["cargo_asignado"];
$depto=$_SESSION["departamento"];
$hruta=descifrar($_GET['hr1']);

	$s_hr="select * from registrodoc1 where registrodoc1_hoja_ruta='$hruta'";
	$r_hr = mysql_query($s_hr, $conn);
	$row_dep=mysql_fetch_array($r_hr);
	$cod_dep=$row_dep['registrodoc1_de'];
	$cod_para=$row_dep['registrodoc1_para'];
	$estado=$row_dep['registrodoc1_estado'];
	$cite=$row_dep['registrodoc1_cite'];
	$prioridad=$row_dep['registrodoc1_prioridad'];
	$fech_ela=$row_dep["registrodoc1_fecha_elaboracion"];
	$gest=$row_dep["registrodoc1_gestion"];
	$ref=strtoupper($row_dep["registrodoc1_referencia"]);
	$tipo = $row_dep["registrodoc1_tipo"];
	
	if ($tipo=='INTERNO')
	{
	$r_rm = mysql_query("select usuario_nombre, cargos_cargo, usuario_titulo from usuario, cargos where usuario_ocupacion='$cod_dep' and usuario_ocupacion=cargos_id", $conn);
	$row_rm=mysql_fetch_array($r_rm);
	$tit_rm=$row_rm['usuario_titulo'];
	$nom_rm=$row_rm['usuario_nombre'];
	$cargo_rm=$row_rm['cargos_cargo'];
	
	$tit_nom_rm=$tit_rm.' '.$nom_rm;
	 
	}
	 else 
	{ 
		$valor_clave=$row_dep["registrodoc1_de"];
		$conexion = mysql_query("SELECT * FROM usuarioexterno WHERE '$valor_clave'=usuarioexterno_codigo",$conn);
		$row_rm2=mysql_fetch_array($conexion);
		$tit_nom_rm=$row_rm2[2];
		$cargo_rm=$row_rm2[3];
		
	}
	
	/*
	$r_des = mysql_query("select usuario_nombre, cargos_cargo, usuario_titulo from usuario, cargos where usuario_ocupacion='$cod_para' and usuario_ocupacion=cargos_id", $conn);
	$row_des=mysql_fetch_array($r_des);
	$tit_des=$row_des['usuario_titulo'];
	$nom_des=$row_des['usuario_nombre'];
	$cargo_des=$row_des['cargos_cargo'];
$contarok=mysql_query($contar,$conn);
*/
?>
<center>
<br>
<?php echo "DETALLE DE LA HOJA DE RUTA ";?>
<table width="500" border="0" cellpadding="1">
  <tr class="border_tr3">
    <td width="200"><span class="fuente_normal"><strong>H.R: </strong></span></td>
    <td width="300"><span class="fuente_normal"><?php echo "$hruta";?></span></td>
    </tr>
  <tr class="border_tr3">
	<td width="200"><span class="fuente_normal"><strong>Fecha de Elaboracion:</strong> </span></td>
    <td width="300"><span class="fuente_normal"><? echo "$fech_ela";?> </span></td>
    </tr>
  <tr class="border_tr3">
    <td width="200"><span class="fuente_normal"><strong>Gestion:</strong></span></td>
    <td width="300">MSyD-<?php echo"$gest";?></td>
    </tr>
  <tr class="border_tr3">
    <td colspan="2" width="700"><span class="fuente_normal"><strong>Referencia: <?php echo"$ref";?></strong></span></td>
    </tr>
	<br>
  <tr class="border_tr3">
    <td colspan="2" width="350"><span class="fuente_normal"><strong><br>Remitente: <br><br><?php echo"$tit_nom_rm";?><br><?php echo"$cargo_rm";?></strong></span></td>
    
	<!--<td width="350"><span class="fuente_normal"><strong>Destinatario: <br><br><?php echo"$tit_des. $nom_des";?><br><?php echo"$cargo_des";?></strong></span></td>-->
    </tr>
</table>
<BR>

<?php echo "DOCUMENTACION ASOCIADA";
$adj_doc="select * from arch_adj where arch_adj_h_r='$cite'";
$r_adj = mysql_query($adj_doc, $conn);
if($r_adj>0)
{
 ?>
<table width="600" border="0" cellpadding="1"> 
  <tr style="font-size: 8pt; color:#FFFFFF" bgcolor="#3E6BA3">
    <td width="350" align="center">Adjuntado por</td>
	<td valign="100" align="center">Fecha</td>
	<td width="150" align="center">Nombre del Documento</td>
  </tr>
<?
	$dir="adjunto";
	$resaltador=0;
	while($rwadj=mysql_fetch_array($r_adj))
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
	  	$usuadj=$rwadj['arch_adj_usuario'];
		$r_des = mysql_query("select usuario_nombre, cargos_cargo, usuario_titulo from usuario, cargos where usuario_ocupacion='$usuadj' and usuario_ocupacion=cargos_id", $conn);
	$row_des=mysql_fetch_array($r_des);
	$tit_des=$row_des['usuario_titulo'];
	$nom_des=$row_des['usuario_nombre'];
	$cargo_des=$row_des['cargos_cargo'];
?>
    <td align="left"><? echo"$tit_des $nom_des<br>"; echo"$cargo_des";
		 ?>
	</td>
	<td align="center"><? echo"$rwadj[arch_adj_fecha]";?></td>
	<td align="center">
	<a href="<?=$dir?>/<?=$rwadj[2]?>" onMouseOver="window.status='Guia de sitio';return true" onMouseOut="window.status='';return true" target="_blank">
<img src="images/ver.png" onMouseOver="this.src='images/ver1.png'" onMouseOut="this.src='images/ver.png'"></a>
	
	</td>
  </tr>
<?
}
?>  
</table>
<?
}
else
{
?>
<table width="700" border="0" cellpadding="1">
  <tr class="border_tr3">
    <td >NO SE TIENE DOCUMNETOS ADJUNTOS A ESTE DOCUMENTO;</td>
  </tr>
</table>
<?
}
?>
</center>
<?php
include("final.php");
?>
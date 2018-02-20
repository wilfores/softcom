<?php
include("../filtro.php");
?>
<?php
include("inicio.php");
include("script/functions.inc");
include("script/cifrar.php");
?>
<?php
include("../conecta.php");
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

$deptofuncionario=$_SESSION["departamento"];

//echo "$deptofuncionario";

?>
<center>
<br>
<table width="0" border="0" cellpadding="0">
<?
$resp1=mysql_query("select usuario_ocupacion, usuario_nombre, cargos_cargo 
from `usuario`, cargos
where usuario_cod_departamento='$deptofuncionario'
and usuario_ocupacion=cargos_id",$conn);
$resaltador=0;
while ($r_w=mysql_fetch_array($resp1))
	{ 
?>

  <tr style="font-size: 8pt; color:#FFFFFF;" bgcolor="#999999">
    <td colspan="3"><?php echo "$r_w[usuario_nombre]";?></td>
  </tr>
  <tr style="font-size: 8pt; color:#FFFFFF;" bgcolor="#999999">
    <td colspan="3"><?php echo "$r_w[cargos_cargo]";?></td>
  </tr>
    
  <tr style="font-size: 8pt; color:#FFFFFF;" bgcolor="#3E6BA3">
    <td width="168">HOJA DE RUTA</td>
    <td width="249">REFERENCIA</td>
    <td width="281">TIEMPO DE TENENCIA</td>
  </tr>
  <?
  	$sql_ent = "SELECT * FROM registrodoc1 WHERE '$r_w[usuario_ocupacion]'=registrodoc1_para and registrodoc1_estado='R' and registrodoc1_situacion='P' and registrodoc1_cc='E' and registrodoc1_hoja_ruta<>'0'";
	$rs_ent = mysql_query($sql_ent, $conn);
	$resaltador=0;
	while ($row_ent = mysql_fetch_array($rs_ent)) 
	{  
		if ($resaltador==0)
		  {
		  ?>
		  <tr style="color:#254D78; margin:4px; font-size:11px; background-color:#BCC9E0; padding:10px" bordercolor="#FFFFFF">
		   <?php
		   //<tr style=margin: 4px; border: 0px solid #cccccc; background-color:#BCC9E0; padding: 10px; font-size: 11px; color: #254D78; >
		   $resaltador=1;
		  }
		  else
		  {
		  ?>
		  <tr style="color:#254D78; margin:4px; font-size:11px; background-color:#ffffff; padding:10px" bordercolor="#FFFFFF">
		   <?php
		   //echo "<tr class=trdos2>";
		   $resaltador=0;
		  }
	      ?>	
			<td><?php echo "$row_ent[registrodoc1_hoja_ruta]";?></td>
			<td><?php echo "$row_ent[registrodoc1_referencia]";?></td>
			<td><?php echo "$row_ent[registrodoc1_fecha_recepcion]";?></td>

	   <?
	   } 
	   ?> 
	 	  </tr>
  <?
	$sql_derv1 = "SELECT * FROM derivardoc WHERE '$r_w[usuario_ocupacion]'=derivardoc_para and derivardoc_situacion='R' and derivardoc_estado='P'";
	
	$rs_derv1 = mysql_query($sql_derv1, $conn);
	$resaltador=0;
	while ($row_derv1 = mysql_fetch_array($rs_derv1)) 
	{  
		if ($resaltador==0)
		  {
		  ?>
		  <tr style="color:#254D78; margin:4px; font-size:11px; background-color:#BCC9E0; padding:10px" bordercolor="#FFFFFF">
		   <?php
		   //<tr style=margin: 4px; border: 0px solid #cccccc; background-color:#BCC9E0; padding: 10px; font-size: 11px; color: #254D78; >
		   $resaltador=1;
		  }
		  else
		  {
		  ?>
		  <tr style="color:#254D78; margin:4px; font-size:11px; background-color:#ffffff; padding:10px" bordercolor="#FFFFFF">
		   <?php
		   //echo "<tr class=trdos2>";
		   $resaltador=0;
		  }
	      ?>	
			<td><?php echo "$row_derv1[derivardoc_hoja_ruta]";?></td>
			<td><?php echo "$row_derv1[derivardoc_proveido]";?></td>
			<td><?php echo "$row_derv1[derivardoc_fec_recibida]";?></td>
		  
	   <?
	   } 
	   ?>  
		  </tr>
  
<?
} 
 ?> 
  

</table>
</center>
<?php
include("final.php");
?>

<?php
include("../filtro.php");
?>
<?php
include("inicio.php");
include("script/functions.inc");
include("script/cifrar.php");
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

$codigo=$_SESSION["cargo_asignado"];
$depto=$_SESSION["departamento"];
//echo "$codigo";

?>
<link rel="stylesheet" href="jquery.mobile-1.0.min.css" />
<script src="jquery-1.7.1.min.js"></script>
<script src="jquery.mobile-1.0.min.js"></script>

<script language="JavaScript">
function Retornar(){
	document.ingreso.action="menu2.php";
	document.ingreso.submit();
}
</script>
<br />
<form action="genera_cite.php" method="post" name="crear">
<table width="693" height="290" border="0" align="center" cellspacing="3" cellpadding="3" class="border_tr3">
  <tr class="border_tr3">
    <td colspan="3" align="center" bgcolor="#3E6BA3"><strong style="color:#FFFFFF">Selecione el Tipo de Documento </strong></td>
  </tr>
  <tr class="border_tr3">
    <td colspan="3" ><strong>1) Tipo de Correspondencia</strong></td>
  </tr>
  <tr class="border_tr3">
    <td width="102"></td>
    <td width="160"><strong>Tipo de Documento: </strong></td>
    <td width="409" style="font-size:10; color:#333333">
	  <select name="tipo_doc" style="font-size:9px" >
		<option value="">Selecione el Tipo de Documento</option>
		<?php
		$respss=mysql_query("select documentocargo_doc, documentos_descripcion, documentos_sigla 
								from documentocargo, documentos 
								where documentocargo_cargo='$codigo'
								and documentocargo_doc=documentos_id",$conn);
		while($rowass=mysql_fetch_array($respss))
		{
			?>
			<option value=<?php echo $rowass["documentocargo_doc"];?> selected><?php echo $rowass["documentos_descripcion"];?></option>
			<?php
		}

			?>
	 </select>
	</td>
  </tr>
  <tr class="border_tr3">
    <td colspan="3"><strong>2) Destinatario</strong></td>
  </tr>
  <tr class="border_tr3">
    <td>&nbsp;</td>
    <td><strong>Cargo y Nombre del Funcionario:</strong> </td>
    <td>	
	<select name="doc_para" style="font-size:9px">
		<option value="">Dirigido a:</option>
		<?php
		$rpara=mysql_query("select a.`asignar_su_codigo`, u.`usuario_nombre`, c.`cargos_cargo`
							from `asignar` a , `cargos` c , `usuario` u
							where
							a.`asignar_mi_codigo`='$codigo'
							and
							a.`asignar_su_codigo`=c.`cargos_id`
							and
							c.`cargos_id`=u.`usuario_ocupacion`",$conn);
		while($rp=mysql_fetch_array($rpara))
		{
			?>			
			<option value=<?php echo $rp["0"];?> selected><?php echo $rp["1"]; echo ".....("; echo $rp["2"]; echo ")";?></option>
			<?php
		}

			?>
	 </select>
	<?php echo $rp["0"];?>
	</td>
  </tr>
  <tr class="border_tr3">
    <td colspan="3"><strong>3) Detalle</strong></td>
  </tr>
  <tr class="border_tr3">
    <td height="84">&nbsp;</td>
    <td ><strong>Referencia:</strong></td>
    <td><textarea name="tema" rows="3" cols="50"></textarea></td>
  </tr>
  <tr>
	<td colspan="3" align="center" >

	<input style="font-size:9px; color:blue;" type="submit" value="Crear Cite" name="crear"/>
	</td>
  </tr>
</form>
  
    <tr>
	<td colspan="3" align="center" >
		<A href="impresion_cm_ne.php?nota=<?php echo $codigo; ?>">
	    <img src='images/word2007.gif' border='0'><span style="font-weight: bold">&nbsp;&nbsp;IMPRIMIR</span>
		</a>
	</td>
  </tr>
				  
</table>

	
<br />
<br />
<?php
include("final.php");
?>

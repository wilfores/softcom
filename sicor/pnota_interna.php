<?php
include("../filtro.php");
include("inicio.php");
include("script/functions.inc");
include("../conecta.php");
$institucion = $_SESSION["institucion"];
$cod_usr=$_SESSION["codigo"];
$cod_depar=$_SESSION["departamento"];
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
?>
  <script>
  function Abre_ventana (pagina) 
{
  ventana=window.open(pagina,"Asignar","toolbar=no,location=0,directories=no,status=no,menubar=no,scrollbars=yes,resizable=yes,width=300,height=250");
}
function Retornar(){
 document.enviar.action="pinforme.php";
 document.enviar.submit();
}

  </script>
<?php
$ssql = "SELECT usuario_ocupacion,usuario_nombre,departamento_descripcion_dep FROM usuario, departamento WHERE usuario.usuario_cod_departamento=departamento.departamento_cod_departamento AND usuario.usuario_cod_usr='$cod_usr'";
$rss = mysql_query($ssql,$conn);
$row = mysql_fetch_array($rss);

if (isset($_POST['verimprimir'])) 
{ 
  if(empty($_POST['tema']))
  {
    $error = TRUE;
	$alert_tem = 1;
  }  
 
  $verifica = count($_POST['tarde']); 
  if($verifica == 0)
  {
    $error = TRUE;
	$fun_para = 1;
  }
    
if (!$error) 
    {
	  $int = "INSERT INTO registroarchivo(registroarchivo_hoja_interna,registroarchivo_usuario_inicia, registroarchivo_referencia, registroarchivo_fecha,registroarchivo_fecha_recepcion, registroarchivo_hora_recepcion, registroarchivo_tipo) 
				VALUES ('$_POST[numcite]','$cod_usr','$_POST[tema]','$_POST[fecha]','$_POST[fecha_recepcion]','$_POST[hora_recepcion]','NOTA INTERNA')";
	   mysql_query($int,$conn);
    
	   $numActual = mysql_query("SELECT * FROM usuario WHERE '$cod_usr'=usuario_cod_usr",$conn);
	   $temp = mysql_fetch_array($numActual);
	   $temporal=$temp["usuario_ninterna"];
	   $temporal = $temporal + 1;

	   mysql_query("UPDATE usuario SET usuario_ninterna='$temporal' WHERE '$cod_usr'=usuario_cod_usr",$conn);
   
	   $numActualz = mysql_query("SELECT * FROM departamento WHERE '$cod_depar'=departamento_cod_departamento",$conn);

	   $tempz = mysql_fetch_array($numActualz);
	   $temporalz=$tempz["departamento_ninterna"];
	   $temporalz = $temporalz + 1;
	   mysql_query("UPDATE departamento SET departamento_ninterna='$temporalz' 
					WHERE '$cod_depar'=departamento_cod_departamento",$conn);

		/*****************************************************************************
								GUARDA LA INFORMACION DE PARA
		 *****************************************************************************/

		$elementos = count($_POST['tarde']);
		$cont = 0;
		   
		foreach($_POST['tarde'] as $value)
			{
				$busca = mysql_query("SELECT * FROM usuario WHERE usuario_nombre='$value'",$conn);
				$rca = mysql_fetch_array($busca);
				$ocupa=$rca["usuario_cod_usr"];
				$int_rca = "INSERT INTO derivaciones(derivaciones_hoja_interna,derivaciones_cod_usr,derivaciones_estado,derivaciones_estadoinicial) VALUES ('$_POST[numcite]','$_POST[ocupa]','P','P')";
				mysql_query($int_rca,$conn);  
				$cont++;
		     }

		
		/*****************************************************************************
								GUARDA LA INFORMACION DE VIA
		 *****************************************************************************/


		$elementos1 = count($_POST['tarde1']);
		$cont1 = 0;

		if($elementos1 > 0)   
		 {
				foreach($_POST['tarde1'] as $value1)
					{
						$busca1 = mysql_query("SELECT * FROM usuario 
											   WHERE usuario_nombre='$value1'",$conn);
						$rca1 = mysql_fetch_array($busca1);
						$ocupa1=$rca1["usuario_cod_usr"];
						$int_rca1 = "INSERT INTO derivaciones(derivaciones_hoja_interna,derivaciones_cod_usr,derivaciones_estado,derivaciones_estadoinicial) VALUES ('$_POST[numcite]','ocupa1','V','V')";
						mysql_query($int_rca1,$conn);  
						$cont1++;
					}
		 }


		
		/*****************************************************************************
								GUARDA LA INFORMACION DE DE
		 *****************************************************************************/

		$elementos2 = count($_POST['tarde2']);
		$cont2 = 0;

		mysql_query("INSERT INTO derivaciones SET 
					 derivaciones_hoja_interna='$_POST[numcite]',
					 derivaciones_cod_usr='$cod_usr',
					 derivaciones_estadoinicial='D',
					 derivaciones_estado='D'",$conn) or  die("Error la ingresar a Datos");
   

		foreach($_POST['tarde2'] as $value2)
		{
				$busca2 = mysql_query("SELECT * FROM usuario WHERE usuario_nombre='$value2'",$conn);
				$rca2 = mysql_fetch_array($busca2);
				$ocupa2=$rca2["usuario_cod_usr"];
				$int_rca2 = "INSERT INTO derivaciones(derivaciones_hoja_interna,derivaciones_cod_usr,derivaciones_estado,derivaciones_estadoinicial) VALUES ('$_POST[numcite]','$ocupa2','D','D')";
				mysql_query($int_rca2,$conn);  
			    $cont2++;
		}
		
	?>
    <script language="JavaScript">
    window.self.location="encuentra2.php";
    </script>
	<?php
  
	}
 }  

$ssql = "SELECT usuario_ocupacion,usuario_nombre,departamento_descripcion_dep FROM usuario, departamento WHERE usuario.usuario_cod_departamento=departamento.departamento_cod_departamento AND usuario.usuario_cod_usr='$cod_usr'";
$rss = mysql_query($ssql,$conn);
$row = mysql_fetch_array($rss);
?>
<script language="JavaScript">
function Retornar(){
  document.envio.action="ingreso_nota.php";
  document.envio.submit();
}
</script>
<br>
<b class="fuente_titulo"><span class="fuente_normal">
<center>NOTA INTERNA</center></b>
<center>
<table border="0" cellpadding="0" cellspacing="2" align="center" width="60%">
<form name="envio" method="POST">
<tr><td align="center" colspan="2">
<span class="fuente_normal">
<b>CITE : 
<?php

$consul=mysql_query("select * from departamento where departamento_cod_departamento='$cod_depar'",$conn);
if ($rcon=mysql_fetch_array($consul))
{
$consulaux=mysql_query("select * from instituciones where instituciones_cod_institucion='$institucion'",$conn);
if ($rconaux=mysql_fetch_array($consulaux))
{
$numD=cite($tipop,$planilla,$conn,$institucion,$cod_depar,$cod_usr);
$correlativo=$rcon["departamento_ninterna"]+1;
$numcite=strtoupper($rcon["departamento_sigla_dep"])."/NI"."/".$correlativo.$numD;

echo $numcite;
}
?>
	<input type="hidden" name="numcite" value="<?php echo $numcite; ?>" />
<?php
}
?></b>
</td></tr>

<tr class="border_tr3">
<td align="right"  valign="top">
Para: &nbsp;&nbsp;
</td>
<td>
<!--multiples -->
<TABLE width="95%" BORDER="0" CELLSPACING="2" CELLPADDING="0" class="fuente_normal">
<tr bgcolor="#CCCCCC">
<td width="200"><b>Funcionario</b>
</td>
<td width="300"><b>Cargo</b>

</tr>
</table>
<div style="overflow:auto; width:98%; height:100px; align:left;">
<TABLE width="95%" BORDER="0" CELLSPACING="2" CELLPADDING="0" class="fuente_normal">
<?php
$rss2=mysql_query("SELECT * FROM usuario where usuario_cod_nivel='' and usuario_active='1' and '$cod_usr'<> usuario_cod_usr",$conn);
if (!empty($rss2)) {
while($row2 = mysql_fetch_array($rss2)) 
{
?>
    <TR>
    <td bgcolor="#EFEBE3" width="200">
	<input type="checkbox" value="<?php echo $row2["usuario_nombre"];?>" name="tarde[]">
    <?php Alert($fun_para);?> 
	<?php
	echo "<span class=fuente_normal>".$row2["usuario_nombre"]."</span>";
	?>
	</td>
	<td width="300">
		<?php
	echo "<span class=fuente_normal>".strtoupper($row2["usuario_ocupacion"])."</span>";
	?>
	</td>
	
<?php
}
}
?>
</table><br>
</div>
<!--fin multiples -->   
   
</td>
</tr>
<tr class="border_tr3">
<td align="right" valign="top">
Via: &nbsp;&nbsp;
</td>
<td>
<!--multiples -->
<TABLE width="95%" BORDER="0" CELLSPACING="2" CELLPADDING="0" class="fuente_normal">
<tr bgcolor="#CCCCCC">
<td width="200"><b>Funcionario</b>
</td>
<td width="300"><b>Cargo</b>

</tr>
</table>
<div style="overflow:auto; width:98%; height:100px; align:left;">
<TABLE width="95%" BORDER="0" CELLSPACING="2" CELLPADDING="0" class="fuente_normal">
<?php
$rss2=mysql_query("SELECT * FROM usuario where usuario_cod_nivel='' and usuario_active='1' and '$cod_usr'<> usuario_cod_usr",$conn);
if (!empty($rss2)) {
while($row2 = mysql_fetch_array($rss2)) 
{
?>
    <TR>
    <td bgcolor="#EFEBE3" width="200">
	<input type="checkbox" value="<?php echo $row2["usuario_nombre"];?>" name="tarde1[]">
	<?php
	echo "<span class=fuente_normal>".$row2["usuario_nombre"]."</span>";
	?>
	</td>
	<td width="300">
		<?php
	echo "<span class=fuente_normal>".strtoupper($row2["usuario_ocupacion"])."</span>";
	?>
	</td>
	
<?php
}
}
?>
</table><br>
</div>
<!--fin multiples --> 
</td>
</tr>

<tr class="border_tr3">
<td align="right"  valign="top" >
De: &nbsp;&nbsp;
</td>
<td>
<!--multiples -->
<TABLE width="95%" BORDER="0" CELLSPACING="2" CELLPADDING="0" class="fuente_normal">
<tr bgcolor="#CCCCCC">
<td width="200"><b>Funcionario</b>
</td>
<td width="300"><b>Cargo</b>

</tr>
</table>
<div style="overflow:auto; width:98%; height:100px; align:left;">
<TABLE width="95%" BORDER="0" CELLSPACING="2" CELLPADDING="0" class="fuente_normal">
<?php
$rss2=mysql_query("SELECT * FROM usuario where usuario_cod_nivel='' and usuario_active='1' AND '$cod_depar'=usuario_cod_departamento",$conn);
if (!empty($rss2)) {
while($row2 = mysql_fetch_array($rss2)) 
{
?>
    <tr>
    <td bgcolor="#EFEBE3" width="200">
	<?php
	if($row2["usuario_cod_usr"]==$cod_usr)
	{
	?>
	<input type="checkbox" value="<?php echo $row2["usuario_nombre"];?>" name="tarde2[]" checked disabled>
	<?php
	}
	else
	{
	?>
	<input type="checkbox" value="<?php echo $row2["usuario_nombre"];?>" name="tarde2[]">
	<?php
	}
	?>
    <?php Alert($fun_de);?> 
	<?php
	echo "<span class=fuente_normal>".$row2["usuario_nombre"]."</span>";
	?>
	</td>
	<td width="300">
		<?php
	echo "<span class=fuente_normal>".strtoupper($row2["usuario_ocupacion"])."</span>";
	?>
	</td>
	
<?php
}
}
?>
</table><br>
</div>
<!--fin multiples --> 
</td>
</tr>
<tr class="border_tr3">
<td align="right"  valign="top" size="30">
REF.: &nbsp;&nbsp;
</td>
<td>
&nbsp;&nbsp;&nbsp;
<?php
if (isset($tema)) {
?><input type="text" name="tema" size="50" value="<?php echo $tema; ?>" ><?php
}else{
   echo "<input type=\"text\" name=\"tema\" size=\"50\"/>";    
}
 Alert($alert_tem); ?>
</td>
</tr>

<tr class="border_tr3">
<td align="right">
Fecha: &nbsp;&nbsp;
</td>
<td align="left">
&nbsp;&nbsp;&nbsp;
<input type="text" name="fecha" value="<?php echo "La Paz, ".MesLiteral(date("Y-m-d"));?>" size="27" maxlength="60" />

</td>
</tr>

<tr class="border_tr3">
<td align="right" valign="top">
 &nbsp;&nbsp;
</td>
<td>
&nbsp;&nbsp;&nbsp;
<input type="hidden" name="fecha_recepcion" align="center"  size="10" maxlength="10"  value="<?php echo date("Y-m-d");?>" >
&nbsp;&nbsp;&nbsp;
<input type="hidden" name="hora_recepcion" align="center"  size="8" maxlength="8"  value="<?php echo date("H:i:s");?>">          

</td>
</tr>

</table>
</center>

<center>
<table border="0" cellpadding="0" cellspacing="2" align="center" width="80%">
<tr>
<td align="center" colspan="2">
<input type="hidden" name="tipop" value="<?php echo $tipop;?>"/>
<input type="hidden" name="planilla" value="<?php echo $planilla;?>"/>
<input type="submit" name="verimprimir" value="Aceptar" class="boton"/>
<input type="reset" name="cancelar" value="Cancelar" class="boton" onClick="Retornar();" />
</td>
</form>
</tr>
</table>
</center>

<?php
include("final.php");
?>

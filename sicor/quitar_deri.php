<?php
include("../filtro.php");
?>
<?php
include("inicio.php");
?>
<?php
include("../conecta.php");
include("script/functions.inc");
include("script/cifrar.php");
include("../funcion.inc");
?>

<?
	$dpto=$_SESSION["departamento"];
	$codigo_usuario=$_SESSION["codigo"];
	$camb_gest=$_SESSION["camb_gest"];
	$fechqd=date("Y-m-d H:i:s");
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
	$hru = descifrar($_GET['hr1']);
	$hr_cod = descifrar($_GET['hrcod']);


$error=0;
$val_nder=0;
	
if (isset($_POST['cancelar']))
	{
	?>
		  <script language="JavaScript">
			window.self.location="menu3.php";
		  </script>
	<?php
	}

if (isset($_POST['quitarder']))
{	
	$buscacodd = mysql_query("select * from derivardoc where derivardoc_hoja_ruta = '$hru' and derivardoc_de='$codigo_usuario' and derivardoc_situacion='SR' and derivardoc_estado='P' and derivardoc_copia_de=''", $conn);
	$reccod = mysql_fetch_array($buscacodd);
	
	$qd_para=$reccod['derivardoc_para'];
	$qd_fechd=$reccod['derivardoc_fec_derivacion'];
	$val_hr=$reccod['derivardoc_cod'];	
	$val_nder=$reccod['derivardoc_n_derivacion'];	
	$val_provder=$reccod['derivardoc_proveido'];
	$descqd=$_POST['seleqder'];
	
	
	//echo "$val_nder<br>";
	//echo "$qd_para<br>";
	//echo "$qd_fechd<br>";
	//echo "$fechqd<br>";
	//echo "$codigo_usuario<br>";
	//echo "$camb_gest<br>";
	//echo "$hru<br>";
	//echo "$hr_cod<br>";
	echo "<BR><BR><center><h2> LA HOJA DE RUTA <strong style=color:#CC4512;> ".$hru." </strong>VOLVIO A SUS PENDIENTES </h2></center><br>";
	//echo "$val_hr<br>";
	//echo "$descqd<br>";	
		
	$val_nder=$val_nder-1;

	//echo "$val_nder<br>";
	
	$insertar="call insert_qderv($hr_cod,'$hru',$codigo_usuario,$qd_para,$camb_gest,'$qd_fechd','$fechqd','$descqd','$val_provder','RT')";		 
	mysql_query($insertar, $conn);
		
mysql_query("delete from derivardoc where derivardoc_hoja_ruta = '$hru' and derivardoc_de='$codigo_usuario' and derivardoc_situacion='SR' and derivardoc_estado='P' and derivardoc_copia_de=''", $conn);

    $bushabder = mysql_query("select * from derivardoc where derivardoc_hoja_ruta = '$hru' and derivardoc_para='$codigo_usuario' and derivardoc_situacion='R' and derivardoc_estado='D' and derivardoc_n_derivacion='$val_nder' and derivardoc_copia_de=''", $conn);
	
	$recbusder = mysql_fetch_array($bushabder);
	if ($recbusder['derivardoc_cod'] != '')
	{
		mysql_query("update derivardoc set derivardoc_estado = 'P' where derivardoc_hoja_ruta = '$hru' and derivardoc_para='$codigo_usuario' and derivardoc_situacion='R' and derivardoc_estado='D' and derivardoc_n_derivacion='$val_nder' and derivardoc_copia_de=''", $conn);
		//echo"se encontro el archivo $recbusder[derivardoc_hoja_ruta]<br>";
		
	}
	else
	{
	
	//echo"NO se encontro el archivo <br>";
	
		mysql_query("update registrodoc1 set registrodoc1_situacion = 'P' where registrodoc1_hoja_ruta = '$hru' and registrodoc1_para='$codigo_usuario' and registrodoc1_estado='R' and registrodoc1_situacion='D' and registrodoc1_cc='E' and registrodoc1_asociar!='si' and registrodoc1_hoja_ruta!='0'", $conn);
							
	}
	
	?>
	
	<script language='javascript' type='text/javascript'>
		function redirecciona (){
		document.location.replace('menu3.php');
		}
	setTimeout(redirecciona,1500);
	</script>

	<?php
}
else{
?>

<br>
<br>
<form  method="POST" name="qdr" enctype="multipart/form-data">
<table width="0" border="0" cellpadding="0" align="center" class="border_tr3" bordercolor="">
  <tr class="border_tr3">
    <td colspan="2" align="center" bgcolor="#3E6BA3">
	<strong style="color:#FFFFFF; font-size:15px">QUITAR DERIVACION DE <?php echo"<strong style=color:#FFCC66;>".$hru."</strong>";?></strong></td>
  </tr>
  <tr>
    <td>Motivo.....</td>
    <td>
		<select name="seleqder">
		<option value="DE" selected>Destinatario Equivocado</option> 	
		<option value="ET" selected>Error de Taipeo</option>
		</select>
	</td>
  </tr>
    <tr>
    <td colspan="2" align="center">
	<input type="submit" value="Quitar Derivacion" name="quitarder">
	<input type="submit" value="Cancelar" name="cancelar">
	</td>
  </tr>
</table>
</form>
<br />
<br />
<?php
}
include("final.php");
?>
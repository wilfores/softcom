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
$cod_depar=$_SESSION["departamento"];
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
?>
<?PHP
if (isset($_POST['registro']))
{
?>
	 <script language="JavaScript">
            window.self.location="pexterno.php";
     </script>
<?php
}

if(isset($_POST['cancelar']))
{
	?>
	 <script language="JavaScript">
            window.self.location="menu.php";
     </script>
	 <?php 
}
?>

<?php
$ssql="select * from hojaexterna where hojaexterna_depto=$_SESSION[departamento] ORDER BY hojaexterna_id DESC";	 	   
$respi=mysql_query($ssql,$conn);
?>

<br>
<p class="fuente_titulo"><span class="fuente_normal">
<center><b>CORRESPONDENCIA SALIENTE</b>
</center>
<div align="right">
<form method="POST" name="ingreso">
<input type="submit" name="registro" value="Nuevo Documento" class="boton"/>
</form>
</div>
</p>


<table width="100%" cellspacing="1" cellpadding="1" border="0">
<tr class="border_tr2">
<td width="15%" align="center"><span class="fuente_normal">Hoja Externa</td>
<td width="10%" align="center"><span class="fuente_normal">Fecha Elaboracion</td>
<td width="20%" align="center"><span class="fuente_normal">Destinatario/Cargo</td>
<td width="35%" align="center"><span class="fuente_normal">Referencia</td>
<td width="10%" align="center"><span class="fuente_normal">Anexos</td>
<td width="10%" align="center"><span class="fuente_normal">Archivo</td>
</tr>
</table>


<center>
<div id="tableContainer" style="overflow:auto; width:100%; height:210px; align:left; ">

<table width="100%" cellspacing="0" cellpadding="0" border="0" style="font-size:10px">
<?php 
  $resaltador=0;
 while($row=mysql_fetch_array($respi))
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
?>
<td align="left" width="15%"><b><?php echo $row["hojaexterna_hoja"];?></b></td>
<td align="left" width="10%">
<?php echo $row["hojaexterna_fecha"]." ".$row["hojaexterna_hora"];?>
</td>
<td align="left" width="20%">
<?php echo $row["hojaexterna_destinatario"];
      echo "<br>";
	  echo "<b>".$row["hojaexterna_cargo"]."</b>"; 
?>
</td>
<td align="left" width="35%">
<?php echo $row["hojaexterna_referencia"];?>
</td>

<td align="center" width="10%" style="font-size:8px" >
	<?php echo $row["hojaexterna_hojas"];
 
	if ($row["hojaexterna_adjunto"]=='')
	{
	}
	else
	{ 
	echo "<br>";
	echo $row["hojaexterna_adjunto"];
	}
	
	 ?>
</td>
<td width="10%" align="center">
	<?php 
	if ($row["hojaexterna_archivo"]=='')
	{
	$llevar=$row["hojaexterna_id"];
	?>
	<a href="adjuntar_externa.php?valor=<?php echo $llevar;?>" class="boton">Adjuntar Archivo</a>
    <A href="images_ext.php?valor_enviado=<?php echo $row["hojaexterna_id"];?>"><img src='images/word2007.gif' border='0'></a>
	<?php
	}
	else
	{
	?>
	<a href="<?php echo $row["hojaexterna_archivo"];?>" target="_blank"><img src="images/adjunto.jpg" align="absmiddle" border="0">
	</a>
	<?php
    }
	?>
	
</td>
</tr>
<?php
}   
mysql_close($conn);
?>
</table>
</center>
</div>
<br>
<center>
<table width="70%" cellspacing="2" cellpadding="2" border="0">
<tr class="border_tr">
<td width="95%" align="center">
<form method="POST" name="ingreso">
<input type="submit" name="registro" value="Nuevo Documento" class="boton"/>
<input type="submit" name="cancelar" value="Cancelar" class="boton" />
</form></td>
</tr>
</table>
<?php
include("../final.php");
?>
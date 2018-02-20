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
$ssql="select * from registroarchivo where registroarchivo_depto='$_SESSION[departamento]' ORDER BY registroarchivo_tipo";	   

$respi=mysql_query($ssql,$conn);
?>
<link href="script/estilos2.css" rel="stylesheet" type="text/css" />

<br />
<p class="fuente_titulo"><span class="fuente_normal">
    <center>
        <b>LISTADO GENERAL DE  DOCUMENTOS GENERADOS POR DEPARTAMENTOS</b>
    </center>
    </span>
</p>


<table width="100%" cellspacing="1" cellpadding="1" border="0">
<tr class="border_tr2">
<td width="15%" align="center"><span class="fuente_normal">Hoja Interna</span></td>
<td width="10%" align="center"><span class="fuente_normal">Tipo</span></td>
<td width="45%" align="center"><span class="fuente_normal">Referencia</span></td>
<td width="10%" align="center"><span class="fuente_normal">Fecha Ingreso</span></td>
<td width="10%" align="center"><span class="fuente_normal">Realizado Por</span></td>



</tr>
</table>
<DIV class=tableContainer id=tableContainer>
<div style="overflow:auto; width:100%; height:210px; align:left;">
<center>
<table width="100%" cellspacing="1" cellpadding="1" border="0" style="font-size:10px">
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
<td align="left" width="15%">&nbsp;&nbsp;&nbsp;&nbsp;<b><?php echo $row["registroarchivo_hoja_interna"];?></b></td>
<td align="left" width="10%">
&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
<b>
<?php
        $valor_cargo=$row["registroarchivo_tipo"]; 
		$conexion2 = mysql_query("SELECT * FROM documentos WHERE '$valor_cargo'=documentos_id",$conn);
		if($fila_cargo=mysql_fetch_array($conexion2))
		{
		echo $fila_cargo["documentos_descripcion"];
		}
?>
</b>
</td>

<td align="left" width="45%"><?php echo $row["registroarchivo_referencia"];?>
</td>

<td align="left" width="10%">
<?php echo $row["registroarchivo_fecha_recepcion"]." ";echo $row["registroarchivo_hora_recepcion"];?>
</td>

<td width="10%" align="left">
<?php

$valor_clave=$row["registroarchivo_usuario_inicia"];
		$conexion = mysql_query("SELECT * FROM cargos WHERE '$valor_clave'=cargos_id",$conn);
		if($fila_clave=mysql_fetch_array($conexion))
		{
			$valor_cargo=$fila_clave["cargos_id"];
			$conexion2 = mysql_query("SELECT * FROM usuario WHERE '$valor_cargo'=usuario_ocupacion",$conn);
			if($fila_cargo=mysql_fetch_array($conexion2))
			{
			echo $fila_cargo["usuario_nombre"];
			}
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
<br />
<center>
<table width="70%" cellspacing="2" cellpadding="2" border="0">
<tr class="border_tr">
<td width="95%" align="center">
<form method="POST" name="ingreso">
<input type="submit" name="cancelar" value="Cancelar" class="boton" />
</form></td>
</tr>
</table>
<?php
include("../final.php");
?>
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
$nom_usuario=$_SESSION["nombre"];
$codigo_usuario=$_SESSION["cargo_asignado"];

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
<STYLE type="text/css"> 
    A:link {text-decoration:none;color:#FFFFFF;} 
    A:visited {text-decoration:none;color:#CEDCEA;} 
    A:active {text-decoration:none;color:#FFFFFF;} 
    A:hover {text-decoration:underline;color:#DDE5EE;} 
</STYLE>
<script language="JavaScript">
function Adicionar(){
	document.ingreso.action="ingreso_nota.php";
	document.ingreso.submit();
}
function Retornar()
{
	document.ingreso.action="notas_derivadas.php";
	document.ingreso.submit();
}
</script>
<?php

$ssql="select * from registroarchivo
	   where registroarchivo_codigo='$_GET[datos]' 
	   AND registroarchivo_adj_documento <>''";
$respi=mysql_query($ssql,$conn);

if($row=mysql_fetch_array($respi))
{
?>
<br>
<p class="fuente_titulo"><span class="fuente_normal">
<center><b>CORRESPONDENCIA TERMINADA</b></center></p></center>

<table width="50%" cellspacing="1" cellpadding="1" align="center" border="0">
<tr class="border_tr3">
<td width="8%" align="left" class="border_tr2"><span class="fuente_normal">Hoja Interna</td>
<td width="8%" align="left"><span class="fuente_normal"><b><?php echo $row["registroarchivo_hoja_interna"];?></b></td>
</tr>

<tr class="border_tr3">
<td width="8%" align="left" class="border_tr2"><span class="fuente_normal">Fecha de Recepcion</td>
<td width="8%" align="left"><span class="fuente_normal"><?php echo $row["registroarchivo_fecha_recepcion"];?></td>
</tr>

<tr class="border_tr3">
<td width="8%" align="left" class="border_tr2"><span class="fuente_normal">De</td>
<td width="8%"  align="left">
<?php 
$de="select * from derivaciones where derivaciones_hoja_interna='$_GET[datos]'";
$valores=mysql_query($de,$conn);
while($reglon=mysql_fetch_array($valores))
{  if ($reglon["derivaciones_estadoinicial"] == 'D')
   {
	$datos123=$reglon["derivaciones_cod_usr"];
	$consulta="select * from usuario where usuario_ocupacion='$datos123'";
	$nombre=mysql_query($consulta,$conn);
	if($filon=mysql_fetch_array($nombre))
	{ $var1=$filon["usuario_nombre"];
	 
	$valor_clave=$filon["usuario_ocupacion"];
	$conexion = mysql_query("SELECT * FROM cargos WHERE '$valor_clave'=cargos_id",$conn);
	if($fila_clave=mysql_fetch_array($conexion))
	{
	$var2=$fila_clave["cargos_cargo"];
	} 
	  
	}   
   
?>   
<span class="fuente_normal"><?php echo $var1."<br><b>".$var2."</b></br></br>";?>
<?php
   }
}
?>

</tr>

<tr class="border_tr3">
<td width="8%" align="left" class="border_tr2"><span class="fuente_normal">Via</td>
<td width="8%"  align="left">
<?php 
$de="select * from derivaciones where derivaciones_hoja_interna='$_GET[datos]'";
$valores=mysql_query($de,$conn);
while($reglon=mysql_fetch_array($valores))
{  if ($reglon["derivaciones_estadoinicial"] == 'V')
   {
	$datos123=$reglon["derivaciones_cod_usr"];
	$consulta="select * from usuario where usuario_ocupacion='$datos123'";
	$nombre=mysql_query($consulta,$conn);
	if($filon=mysql_fetch_array($nombre))
	{ $var1=$filon["usuario_nombre"];
	
	$valor_clave=$filon["usuario_ocupacion"];
	$conexion = mysql_query("SELECT * FROM cargos WHERE '$valor_clave'=cargos_id",$conn);
	if($fila_clave=mysql_fetch_array($conexion))
	{
	$var2=$fila_clave["cargos_cargo"];
	}   
	  
	} 
?>	  
<span class="fuente_normal"><?php echo $var1."<br><b>".$var2."</b></br></br>";?>
<?php
   }
}
?>
</td>
</tr>

<tr class="border_tr3">
<td width="8%" align="left" class="border_tr2"><span class="fuente_normal">Para</td>
<td width="8%" align="left">
<?php 
$de="select * from derivaciones where derivaciones_hoja_interna='$_GET[datos]'";
$valores=mysql_query($de,$conn);
while($reglon=mysql_fetch_array($valores))
{  if ($reglon["derivaciones_estadoinicial"] == 'P')
   {
	$datos123=$reglon["derivaciones_cod_usr"];
	$consulta="select * from usuario where usuario_ocupacion='$datos123'";
	$nombre=mysql_query($consulta,$conn);
	if($filon=mysql_fetch_array($nombre))
	{ $var1=$filon["usuario_nombre"];
	 
	
	$valor_clave=$filon["usuario_ocupacion"];
	$conexion = mysql_query("SELECT * FROM cargos WHERE '$valor_clave'=cargos_id",$conn);
	if($fila_clave=mysql_fetch_array($conexion))
	{
	$var2=$fila_clave["cargos_cargo"];
	}  
	}   
   
?>   
<span class="fuente_normal"><?php echo $var1."<br><b>".$var2."</b></br></br>";?>
<?php
   }
}
?>
</td>
</tr>


<tr class="border_tr3">
<td width="8%" align="left" class="border_tr2"><span class="fuente_normal">Tipo de Documento</td>
<td width="8%" align="left"><span class="fuente_normal">
<b>
<?php
        $valor_cargo=$row["registroarchivo_tipo"]; 
		$conexion2 = mysql_query("SELECT * FROM documentos WHERE '$valor_cargo'=documentos_id",$conn);
		if($fila_cargo=mysql_fetch_array($conexion2))
		{
		echo $fila_cargo["documentos_descripcion"];
		}
?>
</b></td>
</tr>
<?php
$consulta_final="select * from terminados where terminados_indicador='$_GET[datos1]'";
$final=mysql_query($consulta_final,$conn);
if ($finalizar=mysql_fetch_array($final))
{
?>
    <tr class="border_tr3">
    <td width="8%" align="left" class="border_tr2"><span class="fuente_normal">Descripcion Final</td>
    <td width="8%" align="left"><span class="fuente_normal"><?php echo $finalizar["terminados_descripcion_final"];?></td>
    </tr>
    
    <tr class="border_tr3">
    <td width="8%" align="left" class="border_tr2"><span class="fuente_normal">Archivado</td>
    <td width="8%" align="left"><span class="fuente_normal"><?php echo $finalizar["terminados_archivado"];?></td>
    </tr>
<?php
}
?>
<tr class="border_tr3">
<td width="8%" align="left" class="border_tr2"><span class="fuente_normal">Referencia</td>
<td width="8%" align="left"><span class="fuente_normal"><?php echo $row["registroarchivo_referencia"];?></td>
</tr>

<tr class="border_tr3">
<td width="8%" align="left" class="border_tr2"><span class="fuente_normal">Documento Adjunto</td>
<td width="8%" align="left">
<a href="adjuntar_nota1.php?valor=<?php echo $_GET['datos'];?>"><img src="images/documentos.png" border="0">
</a>
</td>
</tr>
</table>
<center>
<br><br>
<?php
}   
mysql_close($conn);
?>
</table>
</center>
<br>
<center>
<table width="70%" cellspacing="2" cellpadding="2" border="0">
<tr class="border_tr">
<td width="95%" align="center">
<form method="POST" name="ingreso">
<input type="hidden" name="busqueda" value="<?php echo $busqueda;?>" >
<input type="hidden" name="clase" value="<?php echo $clase; ?>" >
<input type="hidden" name="imp" value="<?php echo $imp; ?>" >
</form>
</td>
</tr>
</table>
<a href="historia_nota.php?datos=<?php echo $_GET['datos'];?>" class="botonde" >Volver</a>
<?php
include("../final.php");
?>
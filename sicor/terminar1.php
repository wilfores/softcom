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

$sel_derivar=descifrar($_GET['datos']);

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

$gestion = strftime("%Y");
$aux = 0;
$cod_institucion = $_SESSION["institucion"];


if (isset($_POST['grabar']))
{
    $valor1 = val_alfanum($_POST['descripcion_final']);
    if ($valor1==0)
    {
       $aux=1;
       $alert_final=1;
    }

    $valor1 = val_alfanum($_POST['archivado']);
    if ($valor1==0)
    {
        $aux=2;
        $alert_arch=1;
    }

if ($aux == 0)
{
 
  mysql_query("UPDATE registroarchivo SET 
  registroarchivo_fecha_salida='$_POST[fecha_salida]',
  registroarchivo_estado='T',
  registroarchivo_terminar='S'
  WHERE registroarchivo_codigo='$sel_derivar'",$conn);
  
  
  $ssql2 = "INSERT INTO terminados(terminados_hoja_interna,terminados_cod_usr,terminados_descripcion_final,terminados_archivado,terminados_estado,terminados_fechatermino) VALUES      ('$sel_derivar','$codigo_usuario','$_POST[descripcion_final]','$_POST[archivado]','S','$_POST[fecha_salida]')";
  mysql_query($ssql2,$conn);
   	    
?>
 <script language="JavaScript">
   window.self.location="notas_terminadas.php";
 </script>
<?php	
  }
} //en if isset grabar

if (isset($_POST['cancelar']))
{
?>
    <script language="JavaScript">
    window.self.location="notas_recibidas.php";
    </script>
<?php
}
?>
<br>

<?php if ($aux == 0)
{
echo "<p><div class=\"fuente_titulo\" align=\"center\"><b>SALIDA DE DOCUMENTOS</b></div></p>";
}
else 
{ 
echo "<p><div class=\"fuente_normal_rojo\" align=\"center\"><b> !!! ERROR DATOS NO VALIDOS !!!</b></div></p>";
}
?>
<center>

<table width="60%" cellspacing="2" cellpadding="2" border="0">
<form  method="POST" name="enviar">
<tr class="border_tr3">
<td><span class="fuente_normal">Codigo Documento</td>
<td>
<?php
$ssql3="SELECT * FROM registroarchivo WHERE '$sel_derivar'= registroarchivo_codigo";
$rss3=mysql_query($ssql3,$conn);
if ($row3=mysql_fetch_array($rss3))
{
echo $row3["registroarchivo_hoja_interna"];
}
?>
</td>
</tr>

<tr class="border_tr3">
<td><span class="fuente_normal">Referencia</td>
<td>
<?php
echo $row3["registroarchivo_referencia"];
?>
</td>
</tr>


<tr class="border_tr3"><td><span class="fuente_normal">Fecha y Hora de Conclusion</td> 
<td><?php echo date("Y-m-d H:i:s");?>
<input type="hidden" name="fecha_salida" value="<?php echo date("Y-m-d H:i:s");?>">
</td>
</tr>

<tr class="border_tr3">
<td><span class="fuente_normal">Proveido</td>
<td>
<textarea name="descripcion_final" class="caja_texto" cols="60" rows="2">
<?php 
if (isset($aux))
{
echo $_POST['descripcion_final'];
}
?>
</textarea>
<?php Alert($alert_final);?>
</td>
</tr>

<tr class="border_tr3">
<td><span class="fuente_normal">Archivado en</td>
<td>
<textarea name="archivado" class="caja_texto" cols="60" rows="2">
<?php
if (isset($aux))
{
echo $_POST['archivado'];
}
?>
</textarea>
<?php Alert($alert_arch);?>
</td>
</tr>

<tr>
<td align="center" colspan="2">
<input type="submit" name="grabar" value="Aceptar" class="boton" />
<input type="submit" name="cancelar" value="Cancelar" class="boton"/>
</td>
</tr>
</form>
</table>
</center>

<?php
include("final.php");
?>
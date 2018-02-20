<?php
include("../filtro.php");
?>
<?php
include("inicio.php");
?>
<?php
include("../conecta.php");
include("../funcion.inc");
include("script/functions.inc");
include("script/cifrar.php");
$error = 0;
$cod_institucion = $_SESSION["institucion"];
$variable=descifrar($_GET['nro_registro']);
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
if(!is_numeric($variable))
{
    echo "<center><b>!!!! INTENTO DE MANIPULACION DE DATOS !!!!</b></center>";
    exit;
}
?>
<?php
if (isset($_POST['guardar'])) 
{
   // Validaciones 
	$foto_nombre= $_FILES['file']['name'];
	$foto_size= $_FILES['file']['size'];
	$foto_type=  $_FILES['file']['type'];
	$foto_temporal= $_FILES['file']['tmp_name'];
        if (($foto_type=="image/x-png" || $foto_type=="image/png") || ($foto_type=="image/pjpeg" ||
             $foto_type=="image/jpeg") || ($foto_type=="image/gif" || $foto_type=="image/gif")   ||
            ($foto_type=="application/pdf"))
        {
        }
        else
        {
                $error=1;
        }
  
  if ($error == 0) 
	  {

			$foto_nombre=strtolower($foto_nombre);
			$valor_aux=explode(".",$foto_nombre);
			$cantidad_valor_puntos=count($valor_aux);
			$foto_nombre_1=genera_password();
			$foto_nombre=$foto_nombre_1.".".$valor_aux[$cantidad_valor_puntos-1];
			$foto_nombre=date("dmY").$foto_nombre;
			$cont=1;
			while(file_exists("adjunto/".$foto_nombre))
            {
                 $foto_nombre=$cont.$foto_nombre;
	              $cont=$cont+1;
            }
			$lugar="adjunto/".$foto_nombre;
			 if (copy ($foto_temporal,$lugar)) 
               {
			   		mysql_query("UPDATE ingreso set
                                                     ingreso_adjunto_correspondencia='$lugar'
						     WHERE ingreso_nro_registro='$variable'",$conn);
			   }//fin if copy
?>
    <script language="JavaScript">
    window.self.location="ingreso_recepcion.php";
    </script>
<?php	
   }
} //en if isset enviar

if(isset($_POST['cancelar']))
{
?>
    <script language="JavaScript">
    window.self.location="ingreso_recepcion.php";
    </script>
<?php
}

?>
<br />
<?php 
if ($aux == 0)
{
?>
	<p class="fuente_titulo">
	<center><b>Adjuntar Correspodencia</b></center></p>
<?php
} 
else 
{ 
	echo "<p><div class=\"fuente_normal_rojo\" align=\"center\"><b>.....Verificar Datos</b></div></p>";
}

	$ssqlm = "SELECT * FROM ingreso WHERE '$variable'=ingreso_nro_registro AND ingreso_cod_institucion='$_SESSION[institucion]'";
	$rssm = mysql_query($ssqlm, $conn);
	while($rowm=mysql_fetch_array($rssm))
	{
	  $clasificacion = $rowm["ingreso_descripcion_clase_corresp"];
	  $imagen_adjunto= $rowm["ingreso_adjunto_correspondencia"];
	  $remitente = $rowm["ingreso_remitente"];
  	  $hoja_ruta = $rowm["ingreso_hoja_ruta"];
          $hoja_ruta_tipo_elegido = $rowm["ingreso_hoja_ruta_tipo"];
	} // while
	mysql_free_result($rssm);
?>
<center>
<table width="80%" cellspacing="2" cellpadding="2" border="0">
<form method="POST" ENCTYPE="multipart/form-data" name="enviar">
<tr class="border_tr3"><td><span class="fuente_normal"><b>Hoja de Ruta </b></td>
<td>
	<?php echo $hoja_ruta;?>
</td>
</tr>
<?php
if($hoja_ruta_tipo_elegido == 'e' || $hoja_ruta_tipo_elegido == 'i')
{
if($imagen_adjunto!="")
{
?>
<tr class="border_tr3">
	<td>
		<span class="fuente_normal">Adjunto Actual
	</td>
	<td>
       <a href="<?php echo $imagen_adjunto;?>" target="_blank"><img src="images/adjunto.jpg" align="absmiddle" border="0">ss[Ver Adjunto]</a>
	</td>
</tr>
<?php
}				
?>
	<tr class="border_tr3">
		<td>
			<span class="fuente_normal">Adjuntar Nota
		</td>
		<td>
			<INPUT type="file" name="file">(max. 1,2 MB)
		</td>
		</tr>
<tr>
<td align="center" colspan="2">
<br>
	<input type="submit" name="guardar" value="Aceptar" class="boton" />
	<input type="submit" name="cancelar" value="Cancelar" class="boton">
</td>
</tr>
<?php
}
else
{
?>
<tr>
<td align="center" colspan="2">
<br>
	<input type="submit" name="cancelar" value="Cancelar" class="boton">
</td>
</tr>
<?php
}
?>
</form>
</table>
</center>
<br>
<?php
include("final.php");
?>
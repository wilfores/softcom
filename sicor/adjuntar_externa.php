<?php
include("../filtro.php");
?>
<?php
include("inicio.php");
?>
<?php
include("../conecta.php");
include("script/functions.inc");
include("../funcion.inc");
$error = 0;
$cod_institucion = $_SESSION["institucion"];
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
<script><!--
function Abre_ventana (pagina) {
  ventana=window.open(pagina,"Asignar","toolbar=no,location=0,directories=no,status=no,menubar=no,scrollbars=yes,resizable=yes,width=300,height=250");
}

function Retornar(){
 document.enviar.action="ingreso_recepcion.php";
 document.enviar.submit();
}
-->
</script>
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
			//$foto_nombre = str_replace (" ","",$foto_nombre); 
			$foto_nombre=date("dmY").$foto_nombre;
			$cont=1;
			while(file_exists("adjunto_externas/".$foto_nombre))
            {
                 $foto_nombre=$cont.$foto_nombre;
	              $cont=$cont+1;
            }
			$lugar="adjunto_externas/".$foto_nombre;
			 if (copy ($foto_temporal,$lugar)) 
               {
			   		mysql_query("update hojaexterna set 
									hojaexterna_archivo='$lugar'
									WHERE hojaexterna_id='$_GET[valor]'",$conn);
			   }//fin if copy
?>
    <script language="JavaScript">
    window.self.location="bandeja_externa.php";
    </script>
<?php	
   }
} //en if isset enviar

if(isset($_POST['cancelar']))
{
?>
    <script language="JavaScript">
    window.self.location="bandeja_externa.php";
    </script>
<?php
}

?>
<script>
<!-- 
function Combo(){
  document.despachar.action="ingreso_modificar.php";
  document.despachar.submit();
}
function Retornar(){
  document.despachar.action="ingreso_recepcion.php";
  document.despachar.submit();
}
--->
</script>
<br>
<?php 
if ($aux == 0)
{
?>
	<p class="fuente_titulo">
	<center><b>Adjuntar Archivo</b></center></p>
<?php
} 
else 
{ 
	echo "<p><div class=\"fuente_normal_rojo\" align=\"center\"><b>.....Verificar Datos</b></div></p>";
}

	$ssqlm = "SELECT * FROM hojaexterna WHERE '$_GET[valor]'=hojaexterna_id";
	$rssm = mysql_query($ssqlm, $conn);
	while($rowm=mysql_fetch_array($rssm))
	{
  	  $hoja_ruta = $rowm["hojaexterna_hoja"];
	  $carguillo = $rowm["hojaexterna_cargo"];
	  $distinarin= $rowm["hojaexterna_destinatario"];
	 
	  } // while
	mysql_free_result($rssm);
?>
<center>
<table width="80%" cellspacing="2" cellpadding="2" border="0">
<form method="POST" ENCTYPE="multipart/form-data" name="enviar">
<tr class="border_tr3"><td><span class="fuente_normal"><b>Hoja Externa </b></td>
<td>
	<?php echo $hoja_ruta;?>
</td>
</tr>
<tr class="border_tr3"><td><span class="fuente_normal"><b>Datos Destinatario</b></td>
<td>
	<?php echo $distinarin;
	      echo "<br>";
		  echo "<b>".$carguillo."</b>";
	?>
</td>
</tr>

	<tr class="border_tr3">
		<td>
			<span class="fuente_normal">Adjuntar Archivo
		</td>
		<td>

	  		<INPUT type="hidden" name="lim_tamano" value="20000000">
			<INPUT type="file" name="file">(max. 1,2 MB)
		</td>
		</tr>
<tr>
<td align="center" colspan="2">
<br>
	<input type="hidden" name="sel_ingreso" value="<?php echo $_POST['sel_ingreso'];?>" />
	<input type="submit" name="guardar" value="Aceptar" class="boton" />
	<input type="submit" name="cancelar" value="Cancelar" class="boton">
</td>
</tr>
</form>
</table>
</center>
<br>
<?php
include("final.php");
?>
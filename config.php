<?php
include("filtro_adm.php");
?>
<?php
include("inicio.php");
?>
<?php
include("sicor/script/functions.inc");
include("sicor/script/cifrar.php");
include("conecta.php");
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
if (isset($_POST['cancelar']))
{
?>
 <script language="JavaScript">
window.self.location="menu.php";
 </script>
<?php
}

$error=0;
$imagen_institucional=0;
$imagen_institucional1=0;
$imagen_institucional2=0;

if (isset($_POST['actualizar'])) 
{
  $text=$_POST['cabecera'];
  $valor=alfanumerico($text);
  if ($valor==0)
	{
      $error=1;
	  $alert_cabecera=1;
    }
	
  $text1=$_POST['foot'];
  $valor1=alfanumerico($text1);
  if ($valor1==0)
	{
      $error=1;
	  $alert_foot=1;
    }	


	$foto_nombre= $_FILES['file']['name'];
	$foto_size= $_FILES['file']['size'];
	$foto_type=  $_FILES['file']['type'];
	$foto_temporal= $_FILES['file']['tmp_name'];
	if($foto_nombre!="")
	{

		if ($foto_type=="image/jpeg" || $foto_type=="image/pjpeg")
		{
				$imagen_institucional=1;
			
		}
		else
		{
			$error=1;
		}
	}

	
	$foto_nombre1= $_FILES['file1']['name'];
	$foto_size1= $_FILES['file1']['size'];
	$foto_type1=  $_FILES['file1']['type'];
	$foto_temporal1= $_FILES['file1']['tmp_name'];
	
	if($foto_nombre1!="")
	{

		if ($foto_type1=="image/jpeg" || $foto_type1=="image/pjpeg")
		{
				$imagen_institucional1=1;
			
		}
		else
		{
			$error=1;
		}
	}


	$foto_nombre2= $_FILES['file2']['name'];
	$foto_size2= $_FILES['file2']['size'];
	$foto_type2=  $_FILES['file2']['type'];
	$foto_temporal2= $_FILES['file2']['tmp_name'];
	
	if($foto_nombre2!="")
	{

		if ($foto_type2=="image/jpeg" || $foto_type2=="image/pjpeg")
		{
				$imagen_institucional2=1;
			
		}
		else
		{
			$error=1;
		}
	}

if($error==0)
{
/***********************************************************************************************
                         Seccion para subir el imagen para la Correspondencia
***********************************************************************************************/	
	if($imagen_institucional==1)
	{      
			$foto_nombre=strtolower($foto_nombre);
			$valor_aux=explode(".",$foto_nombre);
			$cantidad_valor_puntos=count($valor_aux);
			$foto_nombre_1=rand();
			$foto_nombre=$foto_nombre_1.".".$valor_aux[$cantidad_valor_puntos-1];
			$foto_nombre=date("dmY").$foto_nombre;

		
		if(!copy($foto_temporal, "logos/".$foto_nombre))
			{ 
				echo "<B><P class=\"parrafo_titulo\"><SPAN class=\"fuente_normal\"><CENTER><BR>error al copiar el archivo</CENTER><BR></B>";	
				echo "<br><a href=".$HTTP_REFERER."><img src=\"images/atras.gif\" border=\"0\" alt=\"Atras\"></a>";
				include("final.php");
				exit();
			} 
			else 
			{
                $logo = $foto_nombre;
                   
                mysql_query("UPDATE instituciones SET instituciones_logo='$logo', instituciones_membrete='$_POST[cabecera]', instituciones_foot='$_POST[foot]' WHERE instituciones_cod_institucion='$_SESSION[institucion]'",$conn);				
			?>
				<script>
				window.self.location="menu.php";
				</script>		
			<?php
			}
                        exit;

	}
	else
	{
		mysql_query("UPDATE instituciones SET instituciones_membrete='$_POST[cabecera]', instituciones_foot='$_POST[foot]' WHERE instituciones_cod_institucion='$_SESSION[institucion]'",$conn);
		?>
			<script>
			window.self.location="menu.php";
			</script>		
		<?php
	}
	
/***********************************************************************************************
                         Seccion para subir el encabezado  de la imagen
***********************************************************************************************/


	if($imagen_institucional1==1)
	{

			$foto_nombre1=strtolower($foto_nombre1);
			$valor_aux1=explode(".",$foto_nombre1);
			$cantidad_valor_puntos1=count($valor_aux1);
			$foto_nombre_11=rand();
			$foto_nombre1=$foto_nombre_11.".".$valor_aux1[$cantidad_valor_puntos1-1];
			$foto_nombre1=date("dmY").$foto_nombre1;
			
		if(!copy($foto_temporal1, "logos/".$foto_nombre1))
			{ 
				echo "<B><P class=\"parrafo_titulo\"><SPAN class=\"fuente_normal\"><CENTER><BR>error al copiar el archivo</CENTER><BR></B>";	
				echo "<br><a href=".$HTTP_REFERER."><img src=\"images/atras.gif\" border=\"0\" alt=\"Atras\"></a>";
				include("final.php");
				exit();
			} 
			else 
			{
  				$logo1 = $foto_nombre1;
                             
                mysql_query("UPDATE instituciones SET instituciones_membrete='$_POST[cabecera]', instituciones_logo_cabecera='$logo1' WHERE instituciones_cod_institucion='$_SESSION[institucion]'",$conn);				
			?>
				<script>
				window.self.location="menu.php";
				</script>		
			<?php
			}
                        exit;

	}
	else
	{
		mysql_query("UPDATE instituciones SET instituciones_membrete='$_POST[cabecera]', instituciones_foot='$_POST[foot]' WHERE instituciones_cod_institucion='$_SESSION[institucion]'",$conn);
		?>
			<script>
			window.self.location="menu.php";
			</script>		
		<?php
	}

/***********************************************************************************************
                         Seccion para subir el pie de la imagen
***********************************************************************************************/
	if($imagen_institucional2==1)
	{
   		    $foto_nombre2=strtolower($foto_nombre2);
			$valor_aux2=explode(".",$foto_nombre2);
			$cantidad_valor_puntos2=count($valor_aux2);
			$foto_nombre_12=rand();
			$foto_nombre2=$foto_nombre_12.".".$valor_aux2[$cantidad_valor_puntos2-1];
			$foto_nombre2=date("dmY").$foto_nombre2;
			
			
		if(!copy($foto_temporal2, "logos/".$foto_nombre2))
			{ 
				echo "<B><P class=\"parrafo_titulo\"><SPAN class=\"fuente_normal\"><CENTER><BR>error al copiar el archivo</CENTER><BR></B>";	
				echo "<br><a href=".$HTTP_REFERER."><img src=\"images/atras.gif\" border=\"0\" alt=\"Atras\"></a>";
				include("final.php");
				exit();
			} 
			else 
			{
				$logo2 = $foto_nombre2;
               mysql_query("UPDATE instituciones SET instituciones_membrete='$_POST[cabecera]', instituciones_logo_pie='$logo2' WHERE instituciones_cod_institucion='$_SESSION[institucion]'",$conn);				
			?>
				<script>
				window.self.location="menu.php";
				</script>		
			<?php
			}
                        exit;

	}
	else
	{
		mysql_query("UPDATE instituciones SET instituciones_membrete='$_POST[cabecera]', instituciones_foot='$_POST[foot]' WHERE instituciones_cod_institucion='$_SESSION[institucion]'",$conn);
		?>
			<script>
			window.self.location="menu.php";
			</script>		
		<?php
	}		
	
	
}	
}


$ssql = "SELECT * FROM instituciones WHERE '$_SESSION[institucion]'=instituciones_cod_institucion";
$rss = mysql_query($ssql, $conn);
if (!empty($rss)) 
{
$row = mysql_fetch_array($rss);
?>
<br>
<div class="fuente_normal" align="center"><b>CONFIGURACI&Oacute;N DE CORRESPONDENCIA</b></div>
<br>
<center>
<table border="0" width="70%" cellspacing="2" cellpadding="2">
<form name="config" method="POST" enctype="multipart/form-data">
<tr class="border_tr3">
<td width="35%"><span class="fuente_normal">Logo Actual</td>
<td>
	<?php
	if($row["instituciones_logo"]!="")
	{
	?>
		<img src="logos/<?php echo $row["instituciones_logo"]?>" width="75" height="75">
	<?php
	}
	else
	{
	  echo "SIN LOGO";
	}
	?>
</td>	
</tr>
<tr class="border_tr3">
<td><span class="fuente_normal"> Logo Nuevo</td>
<td>
	<input type="file" name="file" maxlength="100" size="30"/>Solo Archivos JPEG.
</td>
</tr>
<tr class="border_tr3">
<td><span class="fuente_normal"> Cabecera Correspondencia</td>
<td><input type="text" name="cabecera" maxlength="200" size="60" value="<?php echo $row["instituciones_membrete"];?>" />
<?php Alert($alert_cabecera); ?>
</td>
</tr>

<tr class="border_tr3">
<td><span class="fuente_normal">Pie de Pagina Correspondencia</td>
<td><input type="text" name="foot" maxlength="200" size="60" value="<?php echo $row["instituciones_foot"]?>"/>
<?php Alert($alert_foot); ?>
</td></tr>


<tr class="border_tr3">
<td width="35%"><span class="fuente_normal">Logo Actual Cabecera Documentos</td>
<td>
	<?php
	if($row["instituciones_logo_cabecera"]!="")
	{
	?>
		<img src="logos/<?php echo $row["instituciones_logo_cabecera"]?>" width="75" height="75">
	<?php
	}
	else
	{
	  echo "SIN LOGO";
	}
	?>
</td>	
</tr>

<tr class="border_tr3">
<td><span class="fuente_normal"> Logo Cabecera Documentos</td>
<td>
	<input type="file" name="file1" maxlength="100" size="30"/>Solo Archivos JPEG.
</td>
</tr>

<tr class="border_tr3">
<td width="35%"><span class="fuente_normal">Logo Actual Pie Documentos</td>
<td>
	<?php
	if($row["instituciones_logo_pie"]!="")
	{
	?>
		<img src="logos/<?php echo $row["instituciones_logo_pie"]?>" width="75" height="75">
	<?php
	}
	else
	{
	  echo "SIN LOGO";
	}
	?>
</td>	
</tr>
<tr class="border_tr3">
<td><span class="fuente_normal"> Logo Pie Documentos</td>
<td>
	<input type="file" name="file2" maxlength="100" size="30"/>Solo Archivos JPEG.
</td>
</tr>

<tr><td colspan="2" align="center">
<input type="submit" name="actualizar" value="Actualizar" class="boton" />
<input type="submit" name="cancelar" value="Cancelar" class="boton" />
</td></tr>
</table>
</form>
</center>
<?php
} 
else 
{
	echo "<br>";
	echo "<div class=\"fuente_normal\" align=\"center\">Datos no Disponibles</div>";
}
mysql_close($conn);
?>
<?php
include("final.php");
?>

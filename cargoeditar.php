<?php
include("filtro.php");
?>
<?php
include("inicio.php");
include("sicor/script/functions.inc");
include("sicor/script/cifrar.php");
?>

<?php
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
$variable=descryto($_GET['sel_inst']);


$respi100=mysql_query("select * from cargos",$conn);
if($rowvar=mysql_fetch_array($respi100))
{
$principal=$rowvar["cargos_id"];
}


$respi=mysql_query("select * from cargos where cargos_id='$variable'",$conn);
?>
<?php
$error=0;
if (isset($_POST['enviar']))
{
  
  /*if ($variable==$principal)
  {
  echo "<center>";
  echo "<br>";
  echo "<img src='images/maximo.jpg' border='0' alt='Volver Pantalla Anterior' align='center'/>";
  echo "<b class='fuente_normal_rojo'> ¡¡¡ USTED ELIGIO MODIFICAR EL CARGO MAXIMO, ESTE NO TIENE RELACI&Oacute;N DE DEPENDENDENCIA DENTRO DEL SISTEMA !!! </b>";
  echo "<br>";echo "<br>";
  echo "<a href='cargos.php'><img src='images/atras.gif' border='0' alt='Volver Pantalla Anterior' /></a>";
  echo "</center>";
  exit;
  }*/



     $result=mysql_query("SELECT * FROM cargos where cargos_cargo='$_POST[nombresito]' AND cargos_cod_institucion='$_SESSION[institucion]' AND         cargos_cod_depto='$_POST[depende]' AND cargos_edificio='$_POST[edificio]' AND cargos_dependencia=$_POST[dependencia]",$conn);
	 $lista=mysql_num_rows($result);
	 if($lista >0)
	{
	  $error=1;
	  $alert_duplicado=1;
 	}
  
  $text1=$_POST['nombresito'];
  $valor1=alfanumerico($text1);
  if ($valor1==0)
	{
      $error=1;
	  $alert_nombre=1;
    }

  if ($error==0)
  { 

	mysql_query("UPDATE cargos SET cargos_cargo='$_POST[nombresito]',cargos_cod_depto='$_POST[depende]',cargos_edificio='$_POST[edificio]',cargos_cod_institucion='$_SESSION[institucion]',cargos_dependencia=$_POST[dependencia] WHERE cargos_id='$variable'",$conn) or die("No se Actualizo el Registro");

  $ssql00="SELECT * FROM miderivacion where miderivacion_mi_codigo='$_POST[dependencia]' and miderivacion_su_codigo='$variable'";
  $rss100 = mysql_query($ssql00, $conn);
  if (mysql_num_rows($rss100) <> 1)
  {
  mysql_query("insert into miderivacion (miderivacion_mi_codigo,miderivacion_su_codigo,miderivacion_estado,miderivacion_original)values('$_POST[dependencia]','$variable','0','1')",$conn) or die("El Registro no Existe");
   mysql_query("DELETE FROM miderivacion WHERE miderivacion_mi_codigo <> '$_POST[dependencia]' and miderivacion_su_codigo='$variable'",$conn); 
  }
 
  $ssq200="SELECT * FROM asignar where asignar_mi_codigo='$_POST[dependencia]' and asignar_su_codigo='$variable'";
  $rss200 = mysql_query($ssq200, $conn);
  if (mysql_num_rows($rss200) <> 1)
  {
  mysql_query("UPDATE asignar SET asignar_su_codigo='$_POST[dependencia]' WHERE asignar_mi_codigo='$variable'",$conn) or die("No se Actualizo el Registro");
  mysql_query("UPDATE asignar SET asignar_mi_codigo='$_POST[dependencia]' WHERE asignar_su_codigo='$variable'",$conn) or die("No se Actualizo el Registro");
  }

	?>
			<script language='JavaScript'> 
				window.self.location="cargos.php"
			</script>
   <?php
  }
}
if (isset($_POST['cancelar']))
{
?>
			<script language='JavaScript'> 
				window.self.location="cargos.php"
			</script>
<?php
}
?>
<center>

<p class="fuente_titulo_principal">
<SPAN class="fuente_normal">
MODIFICAR DATOS DE LOS CARGOS		
</P>
<?php
if ($error>0)
{
  echo "<span class=fuente_normal_rojo>!! ERROR AL INTRODUCIR DATOS !!</span>";
}
echo "<br />";
	if (isset($alert_duplicado))
	{
	echo "<i class='fuente_normal_rojo'>ESTE CARGO YA EXISTE EN LA BASE DE DATOS</i>";echo "<br />";
	echo "<b>".$_POST['nombresito']."</b>";
	}
?>
<?php
if ($rowi=mysql_fetch_array($respi))
{
?>
<table>
<form method="post">
<tr class="border_tr3"><td><SPAN class="fuente_normal">EDIFICIO DE PERTENENCIA</td>
<td>
<select name="edificio" class="caja_texto">
<?php
//$conn = Conectarse();
$ssql="SELECT * FROM edificio where edificio_cod_institucion='$_SESSION[institucion]'";
$rss = mysql_query($ssql, $conn);
if (!empty($rss)) {
  while($row=mysql_fetch_array($rss))
	  {
      if ($rowi["cargos_edificio"]==$row["edificio_cod_edificio"]) 
	  {
         ?><option value="<?php echo $row["edificio_cod_edificio"];?>" selected>
         <?php echo $row["edificio_descripcion_ed"];
         echo "</option>";
       } 
	   else
	   {
	   ?>
	   <option value="<?php echo $row["edificio_cod_edificio"];?>" >
       <?php
		 echo $row["edificio_descripcion_ed"];
         echo "</option>"; 	   
	   }
  } // while  
}
?>
</select>
</td></tr>

<tr class="border_tr3">
<td><SPAN class="fuente_normal">DEPARTAMENTO:</td>
<td>
<select class="fuente_caja_texto" name="depende">
<?php
$ssql="SELECT * FROM departamento where departamento_cod_institucion='$_SESSION[institucion]' ORDER BY departamento_descripcion_dep";
$rss = mysql_query($ssql, $conn);
if (!empty($rss)) {
  while($row=mysql_fetch_array($rss))
	  {
      if ($rowi["cargos_cod_depto"]==$row["departamento_cod_departamento"]) 
	  {
         ?><option value="<?php echo $row["departamento_cod_departamento"];?>" selected>
         <?php echo $row["departamento_descripcion_dep"];
         echo "</option>";
       } 
	   else
	   {
	   ?>
	   <option value="<?php echo $row["departamento_cod_departamento"];?>" >
       <?php
		 echo $row["departamento_descripcion_dep"];
         echo "</option>"; 	   
	   }
  } // while  
}
?>
</select>
</td>
</tr>

<tr class="border_tr3">
<td><SPAN class="fuente_normal">DESCRIPCION CARGO:</td>
<td><input class="fuente_caja_texto" type="text" name="nombresito" size="50" value="<?php echo $rowi["cargos_cargo"];?>">
<?php Alert($alert_nombre); ?>
</td>
</tr>


<tr class="border_tr3">
<td><SPAN class="fuente_normal">DEPENDENCIA:</td>
<td>
<select class="fuente_caja_texto" name="dependencia">
<option value="">Seleccionar Dependencia</option>
<?php
$ssql="SELECT * FROM cargos WHERE '$_SESSION[institucion]'=cargos_cod_institucion and cargos_id <> '$variable' ORDER BY cargos_cargo";

$rss = mysql_query($ssql, $conn);
if (!empty($rss)) {
  while($row=mysql_fetch_array($rss))
	  {
      if ($rowi["cargos_dependencia"]==$row["cargos_id"]) 
	  {
         ?><option value="<?php echo $row["cargos_id"];?>" selected>
         <?php echo $row["cargos_cargo"];
         echo "</option>";
       } 
	   else
	   {
	   ?>
	   <option value="<?php echo $row["cargos_id"];?>" >
       <?php
		 echo $row["cargos_cargo"];
         echo "</option>"; 	   
	   }
  } // while  
}
?>
</select>
</td>
</tr>



<tr>
<td>&nbsp;

</td>
</tr>

<tr>
<td colspan="2" align="center">
<input class="boton" type="submit" name="enviar" value="Enviar">
<input class="boton" type="submit" name="cancelar" value="Cancelar">
</td>
</tr>
</form>
</table>
<br>
</center>
<?php
}
include("final.php");
?>

<?php
include("filtro.php");
?>
<?php
include("inicio.php");
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
$respi=mysql_query("select * from departamento where departamento_cod_departamento='$_GET[sel_inst]'",$conn);
?>
<?php
$error=0;
if (isset($_POST['enviar']))
{
	if(empty($_POST['nombresito']))
	{
	  $error=1;
	}
	if(empty($_POST['sigla']))
	{
	  $error=2;
	}
  if ($error==0)
  {
 	$var=$_SESSION["institucion"];
	mysql_query("UPDATE departamento SET departamento_sigla_dep='$_POST[sigla]',
	departamento_descripcion_dep='$_POST[nombresito]',
	departamento_cod_institucion='$var',
	departamento_dependencia_dep='$_POST[depende]',
	departamento_cod_edificio='$_POST[edificio]' WHERE departamento_cod_departamento='$_GET[sel_inst]'",$conn) or die("No se Guardo el Registro");
	?>
			<script language='JavaScript'> 
				window.self.location="departamento.php"
			</script>
   <?php
  }
}
if (isset($_POST['cancelar']))
{
?>
			<script language='JavaScript'> 
				window.self.location="departamento.php"
			</script>
<?php
}
?>
<center>
<?php
if ($error>0)
{
  echo "<br><span class=fuente_normal_rojo>!! Error al Introducir Datos !!</span>";
}
?>
<p class="fuente_titulo_principal">
<SPAN class="fuente_normal">
MODIFICAR DATOS DE LOS DEPARTAMENTOS					
</P>
<?php
if ($rowi=mysql_fetch_array($respi))
{
?>
<table>
<form method="post">
<tr class="border_tr3">
<td><SPAN class="fuente_normal">Nombre del Departamento:</td>
<td><input class="fuente_caja_texto" type="text" name="nombresito" value="<?php echo $rowi["departamento_descripcion_dep"];?>">
<input type="hidden" name="sel_inst" value="<?php echo $rowi["departamento_cod_departamento"];?>">
</td>
</tr>

<tr class="border_tr3">
<td><SPAN class="fuente_normal">Sigla del Departamento:</td>
<td><input class="fuente_caja_texto" type="text" name="sigla" value="<?php echo $rowi["departamento_sigla_dep"];?>"></td>
</tr>



<tr class="border_tr3">
<td><SPAN class="fuente_normal">Dependencia:</td>
<td>
<select class="fuente_caja_texto" name="depende">
<?php
$cod_institucion=$_SESSION["institucion"];
$ssql="SELECT * FROM departamento where departamento_cod_institucion='$cod_institucion'";
$rss = mysql_query($ssql, $conn);
if (!empty($rss)) {
  while($row=mysql_fetch_array($rss))
	  {
      if ($rowi["departamento_dependencia_dep"]==$row["departamento_cod_departamento"]) 
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
mysql_free_result($rss);
?>
</select>
</td>
</tr>
<tr class="border_tr3"><td><SPAN class="fuente_normal">Edificio de Pertenencia</td>
<td>
<select name="edificio" class="caja_texto">
<?php
//$conn = Conectarse();
$cod_institucion=$_SESSION["institucion"];
$ssql="SELECT * FROM edificio where edificio_cod_institucion='$cod_institucion'";
$rss = mysql_query($ssql, $conn);
if (!empty($rss)) {
  while($row=mysql_fetch_array($rss))
	  {
      if ($rowi["departamento_cod_edificio"]==$row["edificio_cod_edificio"]) 
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
mysql_free_result($rss);
?>
</select>
</td></tr>


<tr>
<td>&nbsp;

</td>
</tr>

<tr>
<td colspan="2" align="center">
<input class="boton" type="submit" name="enviar" value="Enviar" >
<input class="boton" type="submit" name="cancelar" value="Cancelar" >
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

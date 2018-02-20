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
?>
<?php
$error=0;
if (isset($_POST['enviar']))
{    

	$result=mysql_query("SELECT * FROM departamento where departamento_sigla_dep='$_POST[sigla]' AND departamento_descripcion_dep='$_POST[nombresito]' AND   departamento_dependencia_dep='$_POST[depende]' AND departamento_cod_edificio='$_POST[edificio]' AND departamento_cod_institucion='$_SESSION[institucion]'",$conn);
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
	
   if(empty($_POST['depende']))
	{
	  $error=1;
	  $alert_depende=1;
  	}
	
   if(empty($_POST['edificio']))
	{
	  $error=1;
	  $alert_edificio=1;
  	}	


  $text=$_POST['sigla'];
  $valor=sinespacios($text);
  if ($valor==0)
	{
      $error=1;
	  $alert_sigla=1;
    }	
	
  if ($error==0)
  {
	mysql_query("insert into departamento(departamento_descripcion_dep,departamento_sigla_dep,departamento_dependencia_dep,departamento_cod_institucion,departamento_cod_edificio)values('$_POST[nombresito]','$_POST[sigla]','$_POST[depende]','$_SESSION[institucion]','$_POST[edificio]') ",$conn);
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
<br>
<p class="fuente_titulo_principal">
<SPAN class="fuente_normal">
ADICION DE DEPARTAMENTOS
</P>
<?php
if ($error>0)
{
echo "<center><font size=2pt color=red>!!! ERROR DATOS NO VALIDOS !!!</font></center>";
}

if (isset($alert_duplicado))
{
echo "<i class='fuente_normal_rojo'>ESTE DEPARTAMENTO YA EXISTE EN LA BASE DE DATOS</i>";
}

?>


<table>
<form method="post">
<tr class="truno">
<td><SPAN class="fuente_normal">Edificio:</td>
<td>
<select class="fuente_caja_texto" name="edificio" onChange="this.form.submit()">
<option value="">Seleccione su Opcion</option>
<?php
$respss=mysql_query("select * from edificio where edificio_cod_institucion='$_SESSION[institucion]'",$conn);
while($rowass=mysql_fetch_array($respss))
{

	if($_POST['edificio']==$rowass["edificio_cod_edificio"])
	{
	?>
	<option value=<?php echo $rowass["edificio_cod_edificio"];?> selected="selected">
	<?php
	echo "<SPAN class=fuente_subtitulo>".$rowass["edificio_descripcion_ed"];
	?>
	</option>
	<?php
	}
	else
	{
	?>
	<option value=<?php echo $rowass["edificio_cod_edificio"];?>>
	<?php
	echo "<SPAN class=fuente_subtitulo>".$rowass["edificio_descripcion_ed"];
	?>
	</option>
	<?php
	}

}
?>
</select>
<?php Alert($alert_edificio);?>

</td>
</tr>

<tr class="truno">
<td><SPAN class="fuente_normal">Unidad de Dependencia:</td>
<td>

<?php
//$resp=mysql_query("select * from departamento where departamento_cod_institucion='Ministerio de Salud y Deportes' and departamento_cod_edificio='7'",$conn);
$resp=mysql_query("select * from departamento where departamento_cod_institucion='$_SESSION[institucion]' and departamento_cod_edificio='$_POST[edificio]' order by departamento_descripcion_dep",$conn);
 if(mysql_num_rows($resp)>0)
 { 
 ?>
           <select name="depende" class="fuente_caja_texto">
            <option value="">Selecione un Departamento</option>
 <?php
              
				while ($rowcinco=mysql_fetch_array($resp))
					 {  
						if($_POST['depende']==$rowcinco["departamento_cod_departamento"])
							{
			?>
								<option value="<?php echo $rowcinco["departamento_cod_departamento"]?>" selected>
								<?php
									echo $rowcinco["departamento_descripcion_dep"];
								?>
								 </option>
         				   <?php 
					  	    }
						  else
							{
							?>
								<option value="<?php echo $rowcinco["departamento_cod_departamento"]?>">
							<?php
								echo $rowcinco["departamento_descripcion_dep"];
							?>
								</option>
					<?php
						    }
   					 } 

             		?>
			
<?php 
}
else
{
echo "<select name='depende' class='fuente_caja_texto'>";
echo "<option value='1'>No Existen Datos</option>";
}
?>
</select>
<?php Alert($alert_depende);?>
</td>
</tr>

<tr class="truno">
<td ><SPAN class="fuente_normal">Nombre de la Unidad:</td>
<td><input class="fuente_caja_texto" type="text" name="nombresito" value="<?php echo $_POST['nombresito'];?>">
<?php Alert($alert_nombre); ?>
</td>
</tr>

<tr class="truno">
<td><SPAN class="fuente_normal">Sigla de la Unidad:</td>
<td><input class="fuente_caja_texto" type="text" name="sigla" value="<?php echo $_POST['sigla'];?>">
    <?php Alert($alert_sigla); ?>

</td>
</tr>

<tr>
<td colspan="2" align="center">
<input class="boton" type="submit" name="enviar" value="Adicionar" >
<input class="boton" type="submit" name="cancelar" value="Cancelar" ></td>
</tr>
</form>
</table>
<br>
</center>
<?php
include("final.php");
?>

<?php
include("filtro_adm.php");
?>
<?php
include("inicio.php");
include("conecta.php");
include("sicor/script/functions.inc");
include("sicor/script/cifrar.php");
?>
<B><P class="fuente_titulo_principal"><span class="fuente_normal"><CENTER>PERSONALIZAR DERIVACI&Oacute;N</CENTER></B>
<br />
<?php
$error = 0;
$cod_institucion = $_SESSION["institucion"];
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
if(isset($_POST['enviar']))
{
	if(empty($_POST['edificio_destino']))
	{
	  $error=1;
	  $alert_edifdestino=1;
  	}
	
	if(empty($_POST['unidad_destino']))
	{
	  $error=1;
	  $alert_uniddestino=1;
  	}
	
	if(empty($_POST['usuario_destino']))
	{
	  $error=1;
	  $alert_usuariodestino=1;
  	}
    
	if($error==0)
	{
	$_SESSION["codigo_miderivacion"]=$_POST['usuario_destino'];
	
?>
	<script>
        window.self.location="usuarioderivacion_1.php";
	</script>
<?php
   }
}
?>

<?php
if(isset($_POST['cancelar']))
{
?>
	<script>
        window.self.location="menu.php";
	</script>
<?php
}
?>

<center>
<table width="40%" cellspacing="2" cellpadding="2" border="0">
<form  method="POST" name="despachar">
<tr class="border_tr3"><td><span class="fuente_normal">Edificio/Destino</td>
		<td>
			<select name="edificio_destino" class="caja_texto" onChange="this.form.submit()">
            <option value="">Selecione un Edificio</option>
			<?php
				$ssqlcinco="SELECT * FROM edificio WHERE '$cod_institucion'=edificio_cod_institucion order by edificio_descripcion_ed ";
				$rsscinco = mysql_query($ssqlcinco, $conn);
				while ($rowcinco=mysql_fetch_array($rsscinco))
					 {
						if($_POST['edificio_destino']==$rowcinco["edificio_cod_edificio"])
							{
			?>
								<option value="<?php echo $rowcinco["edificio_cod_edificio"]?>" selected>
								<?php
									echo $rowcinco["edificio_descripcion_ed"];
								?>
								 </option>
         				   <?php 
					  	    }
						  else
							{
							?>
								<option value="<?php echo $rowcinco["edificio_cod_edificio"]?>">
							<?php
								echo $rowcinco["edificio_descripcion_ed"];
							?>
								</option>
					<?php
						    }
					 } 

					?>
			</select>
             <?php Alert($alert_edifdestino); ?>     
		</td>
        </tr>
		
        <tr class="border_tr3"><td><span class="fuente_normal">Unidad/Destino</td>
		<td>
			<select name="unidad_destino" class="caja_texto" onChange="this.form.submit()">
				<option value="">Selecione un Departamento</option>
				<?php
					$ssql="SELECT * FROM departamento WHERE '$cod_institucion'=departamento_cod_institucion and departamento_cod_edificio='$_POST[edificio_destino]' order by departamento_descripcion_dep ";
					$rss = mysql_query($ssql, $conn);
				   if (mysql_num_rows($rss) > 0) 
					 {
						while($row=mysql_fetch_array($rss))
							{
								if (isset($_POST['unidad_destino'])) 
									{
								      if ($_POST['unidad_destino']==$row["departamento_cod_departamento"])
						  				{
			    ?>
											<option value="<?php echo $row["departamento_cod_departamento"];?>" selected >
									         <?php echo $row["departamento_descripcion_dep"];
									         echo "</option>";
					       				} 
									   else 
									    {
									   ?>
									   		<option value="<?php echo $row["departamento_cod_departamento"];?>" >
									           <?php echo $row["departamento_descripcion_dep"];
								           echo "</option>"; 	   
						   				}  
				   					}
								   else
									{
									  ?>
									  		<option value="<?php echo $row["departamento_cod_departamento"];?>">
									  <?php 
												  echo $row["departamento_descripcion_dep"];
										   	echo "</option>";
				   					} //end if isset
						  } // while  
				}
			echo "</select>";

			if (isset($alert_uniddestino)) 
				{
			  		echo "<img src=\"images/eliminar.gif\" border=0 >";  
				}
		?>
		</td>
        </tr>

		<tr class="border_tr3"><td><span class="fuente_normal">Destinatario</td>
		<td>
			<select name="usuario_destino" class="caja_texto">
			<?php
				if (isset($_POST['usuario_destino'])) 
						{
						  $ssql2="SELECT * FROM cargos WHERE '$_POST[unidad_destino]'=cargos_cod_depto AND '$cod_institucion'=cargos_cod_institucion AND  cargos_edificio='$_POST[edificio_destino]'";
						  $rss2 = mysql_query($ssql2, $conn);
						  if (mysql_num_rows($rss2) > 0) 
							{
							  while($row2=mysql_fetch_array($rss2))
								{
  		   ?>  					      <option value="<?php echo $row2["cargos_id"];?>">
									   <?php echo $row2["cargos_cargo"]; 
							    echo "</option>";	
								} // while  
							}
						   else
							{
		     					echo "<option value=\"\">No hay registros para este Item </option>"; 
							}
							mysql_free_result($rss2);  
						 }
						else 
						 {
							echo "<option value=\"\">Seleccione un Cargo</option>";
						 }
						echo "</select>";
				if (isset($alert_usuariodestino)) 
					{
					  echo "<img src=\"images/eliminar.gif\" border=0 >";  
					}
		?>
		</td>
        </tr>
<tr>
<td align="center" colspan="2">
<input type="submit" name="enviar"  value="Aceptar" class="boton"/>
<input type="submit" name="cancelar" value="Cancelar" class="boton">
</td>
</tr>
</form>
</table>
</center>
<?php
include("final.php");
?>

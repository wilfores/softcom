<?php
include("../filtro.php");
?>
<?php
include("inicio.php");
?>
<?php
include("../conecta.php");
include("cifrar.php");
include("script/functions.inc");
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
$cod_institucion=$_SESSION["institucion"];
$cargo_unico=$_SESSION["cargo_asignado"];
	
		$respaaaa=mysql_query("select * from cargos where cargos_id='$cargo_unico'");
		if($rowaa=mysql_fetch_array($respaaaa))
		{
			$codigodepartamento=$rowaa["cargos_cod_depto"];
		}
?>
<script>
function Retornar(){
 document.enviar.action="ingreso_recepcion.php";
 document.enviar.submit();
}
</script>

<?php
	$respuesta=mysql_query("select * from departamento where departamento_cod_departamento='$codigodepartamento'",$conn);
	if ($rowasi=mysql_fetch_array($respuesta))
	{
		$varuss=$rowasi["departamento_cod_edificio"];
		$sigladep=$rowasi["departamento_sigla_dep"];
		$respuestatres=mysql_query("select * from edificio where edificio_cod_edificio='$varuss'",$conn);
		if ($rowasitres=mysql_fetch_array($respuestatres))
			{  
			   $codigoedificio=$rowasitres["edificio_cod_edificio"];		
			   $siglaedificio=$rowasitres["edificio_sigla_ed"];
			}
	   
    }
	
	if ($_POST['tipo']=='e')
	{
		$ssql="SELECT * FROM edificio 
		WHERE edificio_cod_edificio='$codigoedificio' order by edificio_hoja_ruta_ext DESC";
	}
	else 
	{
		$ssql="select departamento_nroregistro_e from departamento where departamento_cod_departamento='$codigodepartamento'";
	}

    $rss = mysql_query($ssql,$conn);
	if($row=mysql_fetch_array($rss))
	{
	 if ($_POST['tipo']=='i')
		{
		  $hoja_num = $row["departamento_nroregistro_e"];
		}
	}


	$respuesta=mysql_query("select * from instituciones where instituciones_cod_institucion='$cod_institucion'",$conn);
	if ($rowasi=mysql_fetch_array($respuesta))
		{
			 $nro_reg=$rowasi["instituciones_nro_registro"];		
		}

	$nro_reg=$nro_reg + 1;
	$hoja_ruta_v=$hoja_num + 1;
	if($_POST['tipo']=='e')
	{
		$hoja_ruta_v = $siglaedificio."-".$sigla_especial_a."-".$sigladep."-".$hoja_ruta_v."/".date("Y");
	}
	else
	{
		$hoja_ruta_v = $siglaedificio."-".$sigladep."-".$hoja_ruta_v."/".date("Y");
	}


if (isset($_POST['grabar'])) 
{
    
	if(empty($_POST['cod_departamento']))
	{ 
	 $error=TRUE;
     $alert_dep=1; 	
	}
	
	if(empty($_POST['remitente']))
	{ 
	 $error=TRUE;
     $alert_rem=1; 	
	}
	$numero_usado=$_POST['numero_cite'];
	if(empty($_POST['numero_cite']))
	{ 
	 $error=TRUE;
     $alert_cite=1; 	
	}
	
	if (empty($_POST['fecha_cite']))
	{
		 $error=TRUE;
		 $alert_fechacite=1; 
	}
	else
	{
		$guardar_fecha=$_POST['fecha_cite'];
		if($guardar_fecha > date("Y-m-d"))
		{ 
		 $error=TRUE;
		 $alert_fechacite=1; 	
		}
	}
	
	if(empty($_POST['referencia']))
	{ 
	 $error=TRUE;
     $alert_ref=1; 	
	}
	
	if(Val_numeros($_POST['cantidad_hojas']) == 1)
	{
	 $error= TRUE;
	 $alert_hojas=1;
	}
	
	if(Val_numeros($_POST['nro_anexos']) == 1)
	{
	 $error= TRUE;
	 $alert_anexos=1;
	}
	


 
 if (!$error) 
  {
        $respuesta=mysql_query("select * from departamento where departamento_cod_departamento='$codigodepartamento'",$conn);
		if ($rowasi=mysql_fetch_array($respuesta))
		{
			$varuss=$rowasi["departamento_cod_edificio"];
			$sigladep=$rowasi["departamento_sigla_dep"];
				$respuestatres=mysql_query("select * from edificio where edificio_cod_edificio='$varuss'",$conn);
				if ($rowasitres=mysql_fetch_array($respuestatres))
					{  
					   $codigoedificio=$rowasitres["edificio_cod_edificio"];		
					   $siglaedificio=$rowasitres["edificio_sigla_ed"];
				   }
		   
		}
	
	if ($_POST['tipo']=='e')
	{
		$ssql="SELECT * FROM edificio 
		WHERE edificio_cod_edificio='$codigoedificio' order by edificio_hoja_ruta_ext DESC";
	}
	else 
	{
		$ssql="select departamento_nroregistro_e from departamento where departamento_cod_departamento='$codigodepartamento'";
	}

	$rss = mysql_query($ssql,$conn);
	if($row=mysql_fetch_array($rss))
	{
	 if ($_POST['tipo']=='e')
		{
			 if($tipo_externa=='cg')
			 {
				$hoja_num = $row["edificio_hoja_ruta_ext"]; 
				$sigla_especial_a="CG";
			 }
			
	   }
		else
		{
			$hoja_num = $row["departamento_nroregistro_e"];
		}
	}


	$respuesta=mysql_query("select * from instituciones where instituciones_cod_institucion='$cod_institucion'",$conn);
	if ($rowasi=mysql_fetch_array($respuesta))
		{
			 $nro_registro_int=$rowasi["instituciones_nro_registro"];		
		}


	$nro_registro_int = $nro_registro_int + 1;
	$hoja_ruta_v =$hoja_num + 1;
	if($tipo=='e')
	{
		$hoja_ruta = $siglaedificio."-".$sigla_especial_a."-".$sigladep."-".$hoja_ruta_v."/".date("Y");
	}
	else
	{
		$hoja_ruta = $siglaedificio."-".$sigladep."-".$hoja_ruta_v."/".date("Y");
	}

 
$codigo_gestion=date("Y");
$fecha_ingreso=date("Y-m-d");
$hora_ingreso=date("H:i:s");
$fecha_cite=$fecha_cite;
$fecha_recepcion = $fecha_ingreso." ".$hora_ingreso;
	
	
	
	if ($_POST['tipo']=="e")
	  {
			$ssql2 = "INSERT INTO ingreso(ingreso_fecha_recepcion,ingreso_tipo_anexos,ingreso_nro_registro,ingreso_codigo_gestion,ingreso_hoja_ruta,ingreso_descripcion_clase_corresp,ingreso_nro_anexos,ingreso_fecha_ingreso,ingreso_hora_ingreso,ingreso_cantidad_hojas,ingreso_numero_cite,ingreso_fecha_cite,ingreso_referencia,ingreso_entidad_remite,ingreso_remitente,ingreso_cargo_remitente,ingreso_estado,ingreso_hoja_ruta_tipo,ingreso_cod_institucion,ingreso_cod_usr,ingreso_nro_registro_e,ingreso_destinatario_principal) 
			  VALUES ('$fecha_recepcion','$_POST[tipo_anexos]','$nro_registro_int','$codigo_gestion','$_POST[hoja_ruta]','$_POST[descripcion_clase_corresp]','$_POST[nro_anexos]','$fecha_ingreso','$hora_ingreso','$_POST[cantidad_hojas]','$_POST[numero_cite]','$_POST[fecha_cite]','$_POST[referencia]','$entidad_remite','$_POST[remitente]','$_POST[cargo_remitente]','P','$_POST[tipo]','$_POST[cod_inst]','$cargo_unico','$_POST[nro_registro]','$destinatario_principal_ext')";
	  }
	  else
	  {
			$ssql2 = "INSERT INTO ingreso(ingreso_fecha_recepcion,ingreso_tipo_anexos,ingreso_nro_registro,ingreso_codigo_gestion,ingreso_hoja_ruta,ingreso_descripcion_clase_corresp,ingreso_nro_anexos,ingreso_fecha_ingreso,ingreso_hora_ingreso,ingreso_cantidad_hojas,ingreso_numero_cite,ingreso_fecha_cite,ingreso_referencia,ingreso_cod_departamento,ingreso_remitente,ingreso_cargo_remitente,ingreso_estado,ingreso_hoja_ruta_tipo,ingreso_cod_institucion,ingreso_cod_usr,ingreso_nro_registro_e,ingreso_destinatario_principal) 
			  VALUES ('$fecha_recepcion','$_POST[tipo_anexos]','$nro_registro_int','$codigo_gestion','$_POST[hoja_ruta]','$_POST[descripcion_clase_corresp]','$_POST[nro_anexos]','$fecha_ingreso','$hora_ingreso','$_POST[cantidad_hojas]','$_POST[numero_cite]','$_POST[fecha_cite]','$_POST[referencia]','$_POST[cod_departamento]','$_POST[remitente]','$_POST[cargo_remitente]','P','$_POST[tipo]','$_POST[cod_inst]','$cargo_unico','$_POST[nro_registro]','$destinatario_principal_int')";
	  }

    mysql_query($ssql2,$conn);
	
	if ($_POST['tipo']!="e")
	{
	  $sql_res="update registroarchivo set registroarchivo_usado='S' where registroarchivo_hoja_interna='$numero_usado'";
	 
	}
	mysql_query($sql_res,$conn);
	
	if ($_POST['tipo'] == 'e')
	{
		 if($tipo_externa=='cg')
			 {
				$consulta_act="update edificio set 
				edificio_hoja_ruta_ext='$hoja_ruta_v' 
				WHERE edificio_cod_institucion='$cod_institucion' AND
				edificio_cod_edificio='$codigoedificio'";
			 }
			 
		  mysql_query($consulta_act,$conn);
	}
	else
	{
	  mysql_query("update departamento set departamento_nroregistro_e='$hoja_ruta_v' WHERE departamento_cod_departamento='$codigodepartamento' and departamento_cod_institucion='$cod_institucion'",$conn);
	}

mysql_query("update instituciones set instituciones_nro_registro='$nro_registro_int' WHERE instituciones_cod_institucion='$cod_institucion'",$conn);
?>
	 <script language="JavaScript">
			window.self.location="ingreso_recepcion.php";
	 </script>
 <?php  
 } 
}

   echo "<br>";
   echo "<p class=fuente_titulo>";
   echo "<center><B>INGRESO DE CORRESPONDENCIA";
   	   if ($_POST['tipo']=='e')
		{
		   echo " EXTERNA";
		}
		else
		{
			echo " INTERNA";
		}
   echo "</B></center></span>";
   echo "<br>";


if ($error != 0)
{
echo "<center><table width=25%><tr><td class=fuente_normal_rojo  align=left><center><b> !!! ERROR DATOS NO VALIDOS !!!</b></center>".$valor_error."</td></tr></table></center>";
}

?>
 <link href="script/estilos2.css" rel="stylesheet" type="text/css" />
<center>
<table width="90%" cellspacing="2" cellpadding="2"  border="0">
	<form  method="POST" name="enviar"> 
	<tr class="border_tr3" >
		<td align="center">
			<b>Hoja de Ruta: </b>&nbsp; 
			<?php echo "<b>".$hoja_ruta_v."</b>";?>		</td>
		<td align="left">
			<b>Nro de Registro Entrada:</b>&nbsp;
			<?php echo "<b>".$nro_reg."</b>";?>		</td>
	</tr>

		<tr class="border_tr3">
			<td>
				<span class="fuente_normal">Fecha y Hora de ingreso al sistema			</td>
			<td>
				<?php
					$fecha_ingreso=date("Y-m-d");
					$hora_ingreso=date("H:i:s");
					echo $fecha_ingreso." ".$hora_ingreso;
				?>
					<input type="hidden" name="fecha_recepcion" align="center"  size="10" maxlength="10"  value="<?php echo $fecha_ingreso;?>" >
					<input type="hidden" name="hora_recepcion" align="center"  size="8" maxlength="8"  value="<?php echo $hora_ingreso;?>">			</td>
			</tr>
		<tr class="border_tr3">
		<td>
			<span class="fuente_normal">Entidad Emisora		</td>
		<td>
   		<select name="cod_departamento" class="caja_texto" onChange="this.form.submit()">
			<option value="">Seleccione un Departamento</option>
			<?php
				$ssqlcinco="SELECT * FROM departamento where departamento_cod_institucion='$cod_institucion'";
				$rsscinco = mysql_query($ssqlcinco, $conn);
				while ($rowcinco=mysql_fetch_array($rsscinco))
					 {
						if($_POST['cod_departamento']==$rowcinco["departamento_cod_departamento"])
							{
		   ?>    				<option value="<?php echo $rowcinco["departamento_cod_departamento"]?>" selected>
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
			</select>
            <?php Alert($alert_dep);?>         </td>
		</tr>
		<tr class="border_tr3">
		<td>
			<span class="fuente_normal">Remitente       	</td>
		<td>
         <select name="remitente" class="caja_texto" onChange="this.form.submit()">
			<option value="">Seleccione un Usuario</option>
			<?php
				$ssqlcinco="SELECT * FROM usuario where usuario_cod_departamento='$_POST[cod_departamento]' AND usuario_ocupacion <> '' AND usuario_active='1'";
				$rsscinco = mysql_query($ssqlcinco, $conn);
				while ($rowcinco=mysql_fetch_array($rsscinco))
					 {
						if($_POST['remitente']==$rowcinco["usuario_ocupacion"])
							{
		   ?>    				<option value="<?php echo $rowcinco["usuario_ocupacion"]?>" selected>
								<?php
									echo $rowcinco["usuario_nombre"];
									$valor_clave=$rowcinco["usuario_ocupacion"];
									$conexion = mysql_query("SELECT * FROM cargos WHERE '$valor_clave'=cargos_id",$conn);
									if($fila_clave=mysql_fetch_array($conexion))
									{
									$rca=$fila_clave["cargos_cargo"];
								    }
								?>
								 </option>
         				   <?php 
					  	    }
						  else
							{
							?>
								<option value="<?php echo $rowcinco["usuario_ocupacion"]?>">
							<?php
								echo $rowcinco["usuario_nombre"];
								
							?>
								</option>
					<?php
						    }
					 } 

					?>
			</select> 
                <?php Alert($alert_rem);?>    
            </td>
	</tr>
<?php
if(!empty($_POST['remitente']))
{
?>
    <tr class="border_tr3">
	<td>
			<span class="fuente_normal">Cargo Remitente	</td>
	<td>
    <input type="hidden" name="cargo_remitente" class="caja_texto" value="<?php echo $valor_clave?>" />
    <?php
	echo $rca;
	?>
   </td>
	</tr>
<?php
}
?>
   <input type="hidden" name="cod_inst" class="caja_texto" value="<?php echo $cod_institucion;?>"> 
   <input type="hidden" name="tipo" class="caja_texto" value=<?php if (empty($_POST['tipo'])){echo "i";} else {echo $_POST['tipo'];}?>>
   <input type="hidden" name="nro_registro" class="caja_texto" value=<?php echo $nro_reg?>> 
   <input type="hidden" name="hoja_ruta" class="caja_texto" value=<?php echo $hoja_ruta_v;?>> 
   <input type="hidden" name="codigodepartamento" class="caja_texto" value=<?php echo $codigodepartamento?>> 


	    <tr class="border_tr3"><td><span class="fuente_normal">No. de CITE</td>
		
		<td><?php
	  echo "<input type=\"text\" name=\"numero_cite\" class=\"caja_texto\" value=".$_POST['numero_cite'].">";
	  Alert($alert_cite);
		?>		  <!--  <select name="numero_cite" class="caja_texto">
				<?php
					$ssql = "SELECT * FROM registroarchivo WHERE registroarchivo_usado=''";
					$rss = mysql_query($ssql,$conn);
					while($row=mysql_fetch_array($rss))
					 {  
					     
	               		  ?>	
  				         <option value="<?php echo $row["registroarchivo_hoja_interna"]?>" >
                         <?php
	                      echo $row["registroarchivo_hoja_interna"];
						  ?>
                  </option>
                          <?php
                         
						 
						  
					}	   
				           ?>
			   </select>-->		</td>
		</tr>
		<tr class="border_tr3"><td><span class="fuente_normal">Fecha del CITE</td>
		<td>
		<?php
echo "<input type=\"text\" name=\"fecha_cite\" readonly=\"readonly\" class=\"caja_texto\" id=\"dateArrival\" onClick=\"popUpCalendar(this, enviar.dateArrival, 'yyyy-mm-dd');\" size=\"10\" value=".$_POST['fecha_cite'].">";
echo " <img src=\"images/calendar.gif\" onClick=\"popUpCalendar(this, enviar.dateArrival, 'yyyy-mm-dd');\" alt=\"Calendario\" />";
 Alert($alert_fechacite);
   		?>        </td>
		</tr>
	  
       <tr class="border_tr3"><td width="30%"><span class="fuente_normal">Clasificacion</td>
		<td>
			<select name="descripcion_clase_corresp" class="caja_texto">
				<?php
					$ssql = "SELECT * FROM clasecorrespondencia order by clasecorrespondencia_descripcion_clase_corresp";
					$rss = mysql_query($ssql,$conn);
					while($row=mysql_fetch_array($rss))
					 {  
					     if ($_POST['descripcion_clase_corresp']==$row["clasecorrespondencia_descripcion_clase_corresp"])
						 {
	               		  ?>	
  				         <option value="<?php echo $row["clasecorrespondencia_descripcion_clase_corresp"]?>" selected="selected">
                         <?php
	                      echo $row["clasecorrespondencia_descripcion_clase_corresp"];
						  ?>
                          </option>
                          <?php
                          }
						  else
						  {			
						  ?>
						  <option value="<?php echo $row["clasecorrespondencia_descripcion_clase_corresp"]?>">
						  <?php
						  echo $row["clasecorrespondencia_descripcion_clase_corresp"];
						  ?>
						  </option>
						  <?php
						  }
					}	   
				           ?>
			   </select>	</td>
	</tr>
	<tr class="border_tr3">
    <td>
    <span class="fuente_normal">Referencia</td>
	<td>
	   <textarea name="referencia"  cols="60" rows="2"><?php echo $_POST['referencia'];?></textarea>
      <?php Alert($alert_ref);?>    </td>
	</tr>
	<tr class="border_tr3"><td><span class="fuente_normal">N&uacute;mero de Hojas</td>
	<td>
	<?php
	 echo "<input type=\"text\" name=\"cantidad_hojas\" maxlength=4 size=4 class=\"caja_texto\" value=".$_POST['cantidad_hojas'].">";
	 Alert($alert_hojas);
	?>    </td>
	</tr>
	<tr class="border_tr3">
	  <td><span class="fuente_normal">Cantidad Anexos</td>
	  <td><?php
			echo "<input type=\"text\" name=\"nro_anexos\" maxlength=4 size=4 class=\"caja_texto\" value=".$_POST['nro_anexos'].">";
			Alert($alert_anexos);
		?>      </td>
	  </tr>

    <tr class="border_tr3"><td><span class="fuente_normal">Tipo Anexo</td>
	<td>
       <?php
			echo "<input type=\"text\" name=\"tipo_anexos\" maxlength=100 size=50 class=\"caja_texto\" value=".$_POST['tipo_anexos'].">";
  	    ?>    </td>
	</tr>
	
    <tr>
	<td align="center" colspan="2">
			<input type="submit" name="grabar" value="Grabar" class="boton"/>
			<input type="reset" name="cancelar" value="Cancelar" class="boton" onClick="Retornar();"/>    </td>
    </tr>
	</form>
	</table>
</center>
<br>
<?php
include("final.php");
?>
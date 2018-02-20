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
include("../funcion.inc");

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
$depto=$_SESSION["departamento"];

//echo "$cargo_unico<br>";
//echo "$depto<br>";

?>
<script>
function Retornar(){
 document.enviar.action="menu2.php";
 document.enviar.submit();
}
</script>

<?php

/*PROCEDIMIENTO DE ENVIO DE CORRESPODENCIA*/

if (isset($_POST['grabar'])) 
{
/**********************************************************************************
                                VALIDACIONES NUEVAS 
***********************************************************************************/
    
	if(empty($_POST['cod_departamento']))
	{ 
	 $error=TRUE;
     $alert_dep=1; 	
	}
	
	if(empty($_POST['cod_de']))
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
	
	if(empty($_POST['fecha_cite']))
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
	
	if($_POST['clase_doc']=='')
	{ 
	 $error=TRUE;
     $alert_doc=1; 	
	}
	
	if (!ctype_digit($_POST['cantidad_hojas'])) 
	{
	$error= TRUE;
	$alert_hojas=1;
	}
		
	if (!ctype_digit($_POST['nro_anexos'])) 
	{
	$error= TRUE;
	$alert_anexos=1;
	}
	
 
 if (!$error) 
  {
    $fech_recep=$_POST['fecha_recepcion'];
	$cod_depto=$_POST['cod_departamento'];
	$cod_de=$_POST['cod_de'];
	$n_cite=$_POST['numero_cite'];
	$fech_cite=$_POST['fecha_cite'];
	$clase_doc=$_POST['clase_doc'];
	$ref=$_POST['referencia'];
	$cod_para=$_POST['cod_para'];  
	$cod_depto_para=$_POST['entidad_destinatario'];  
	$n_hojas=$_POST['cantidad_hojas'];
	$n_anexos=$_POST['nro_anexos'];
	$tip_anexos=$_POST['tipo_anexos'];
	$nom_arch_adj=$_POST['nom_arch_adj'];
	
	$rsigla = mysql_query("SELECT departamento_sigla_dep FROM departamento where departamento_cod_departamento='$cod_depto'", $conn);
	$rwsig=mysql_fetch_array($rsigla);
	$sigla_de=$rwsig['departamento_sigla_dep'];
	
	$rsigla2 = mysql_query("SELECT departamento_sigla_dep FROM departamento where departamento_cod_departamento='$depto'", $conn);
	$rwsig2=mysql_fetch_array($rsigla2);
	$sigla_para=$rwsig2['departamento_sigla_dep'];
	
	$ges=date("Y");
	
	echo "$fech_recep FECHA DE RECEPCION<br>";
	echo "$cod_depto CODIGO DE DEPTO<br>";
	echo "$cod_de CODIGO DE USUSARIO<br>";
	echo "$n_cite CITE QUE SE GENRO<br>";
	echo "$fech_cite FECHA DE CITE<br>";
	echo "$clase_doc CLASE DE DOCUMENTO<br>";
	echo "$ref REFERENCIA <br>";
	echo "$cod_para CODIGO PARA <br>";
	echo "$n_hojas NUEMRO DE HOJAS <br>";
	echo "$n_anexos ANEXOS <br>";
	echo "$tip_anexos DESCRIPCION D ANEXOS <br>";
	echo "$nom_arch_adj DOCUMENTO ADJUNTO <br>";
	echo "$sigla_de SIGLA DE<br>";
	echo "$sigla_para SIGLA PARA<br>";
	
		
	$qmr = "select max(registrodoc1_id)from registrodoc1";
	$rqmr = mysql_query($qmr,$conn);
	$reqmr = mysql_fetch_array($rqmr);			
	$v_m_id=$reqmr[0]+1;/*obtiene el maximmo del id del documento 2*/	
		
	$query1 = "select max(registrodoc1_n_h_r)from registrodoc1";
	$result1 = mysql_query($query1,$conn);
	$record1 = mysql_fetch_array($result1);			
	$id_fact1=$record1[0]+1;/*obtiene el maximmo de la hoja de ruta del documento 2*/	
		
	$hr=$sigla_de.'-'.$id_fact1.'-'.$sigla_para;	
		
	$rdoc=mysql_query("SELECT * from documentos 
							where documentos_id='$tipo_doc'",$conn);
	$rpd=mysql_fetch_array($rdoc);
	$sigla_doc=$rpd["documentos_sigla"];
		
	$query = "select max(registrodoc1_n_doc)from registrodoc1 where registrodoc1_doc='$sigla_doc'";
	$result = mysql_query($query,$conn);
	$record = mysql_fetch_array($result);			
	//$id_fact=$record[0]+1;/*obtiene el maximmo del id del documento*/
	$id_fact=0;/*obtiene el maximmo del id del documento*/
		
	if($val=='si'){$asoc=$asociar;}
	else {$asoc='NULL';}
	
	if($n_anexos=='') $n_anexos=0;
	if($tip_anexos=='') $tip_anexos='NULL';
	
	$res='SI';
	
	if($descr_adj=='')$descr_adj='NULL';
	
	if($_FILES["nom_arch_adj"]["name"]=='')
	{$foto_nombre='NULL';
    }
	else 
	{
		$archivo_nombre=$_FILES["nom_arch_adj"]["name"];
		//echo $archivo_nombre;
		$archivo_tamano = $_FILES["nom_arch_adj"]["size"];	
			
		$qd = "select max(arch_adj_id)from arch_adj";
		$resdoc = mysql_query($qd,$conn);
		$rdoc = mysql_fetch_array($resdoc);			
		$id_doc=$rdoc[0]+1;/*obtiene el maximmo del id del documento 2*/
	
		    $foto_type=  $_FILES['nom_arch_adj']['type'];
            $tmp_name = $_FILES["nom_arch_adj"]["tmp_name"];
            $foto_nombre = $_FILES["nom_arch_adj"]["name"];

            $foto_descripcion = $foto_nombre;

            $foto_nombre = strtolower($foto_nombre);
            $valor_aux = explode(".",$foto_nombre);
            $cantidad_valor_puntos = count($valor_aux);
            $foto_nombre_1 = genera_password();
            $foto_nombre = $foto_nombre_1.".".$valor_aux[$cantidad_valor_puntos-1];
            $foto_nombre = date("dmY").$foto_nombre;
            $cont=1;
                while(file_exists("adjunto/".$foto_nombre))
                {
                     $foto_nombre = $cont.$foto_nombre;
                     $cont=$cont+1;
                }

                $lugar="adjunto/".$foto_nombre;
                copy ($tmp_name,$lugar);
				move_uploaded_file($HTTP_POST_FILES['nom_arch_adj']['tmp_name'], './adjunto/'.$foto_nombre);

		   $insertar=" INSERT INTO `arch_adj` (`arch_adj_id`, `arch_adj_h_r`, `arch_adj_nombre`, `arch_adj_usuario`, `arch_adj_fecha`) VALUES 
		  ($id_doc, '$h_r', '$foto_nombre', $codigo, '$fecha')";		
		  
		  $resul = mysql_query($insertar,$conn);
		}
		
		$insertar=" INSERT INTO `registrodoc1` (`registrodoc1_id`, `registrodoc1_n_h_r`, `registrodoc1_hoja_ruta`, `registrodoc1_tipo`, `registrodoc1_cite`, `registrodoc1_referencia`, `registrodoc1_doc`, `registrodoc1_n_doc`, `registrodoc1_depto`, `registrodoc1_de`, `registrodoc1_para`, `registrodoc1_depto_para`, `registrodoc1_estado`, `registrodoc1_situacion`, `registrodoc1_fecha_elaboracion`, `registrodoc1_fecha_recepcion`, `registrodoc1_n_hojas`, `registrodoc1_prioridad`, `registrodoc1_respuesta`, `registrodoc1_gestion`, `registrodoc1_n_adjunto`, `registrodoc1_descrip_adj`, `registrodoc1_nom_arch_adj`, `registrodoc1_asociar`, `registrodoc1_asociar_h_r`, `registrodoc1_cc`) VALUES 
($v_m_id,$id_fact1,'$hr','INTERNO','$n_cite','$ref','$clase_doc',$id_fact,'$cod_depto','$cod_de',$cod_para,'$cod_depto_para','R','P','$fech_cite','$fech_recep',$n_hojas,'M','SI',$ges,$n_anexos,'$tip_anexos','$foto_nombre','NO','$asoc', 'NE')";
					
	$resul = mysql_query($insertar,$conn);
	
	?>
		<script language="JavaScript">
			window.self.location="listado_libro.php";
		</script>
	<?php
 } 
}

   echo "<br>";
   echo "<p class=fuente_normal>";
   echo "<center><B>REGISTRO DE CORRESPONDENCIA INTERNA";
   echo "</B></center></span>";
   echo "<br>";
   
if ($error != 0)
{
echo "<center><table width=25%><tr><td class=fuente_normal_rojo  align=left><center><b> !!! LLENE LOS CAMPOS VACIOS  !!!</b></center>".$valor_error."</td></tr></table></center>";
}

?>

<link href="script/estilos2.css" rel="stylesheet" type="text/css" />
<center>
<table width="70%" cellspacing="2" cellpadding="2"  border="0">
	<form  method="POST" name="enviar" enctype="multipart/form-data"> 
	<!--
	<tr class="border_tr3" >
		<td align="center">
			<b>Hoja de Ruta: </b>&nbsp; 
			<?php echo "<b>".$hoja_ruta_v."</b>";?>		</td>
		<td align="left">
			<b>Nro de Registro Entrada:</b>&nbsp;
			<?php echo "<b>".$nro_reg."</b>";?>		</td>
	</tr>
	-->
	<tr class="border_tr3">
			<td>
				<span class="fuente_normal"><strong>Fecha de Recepcion</strong></td>
			<td>
				<?php
					$fecha_ingreso=date("Y-m-d H:i:s");
					echo $fecha_ingreso;
				?>
					<input type="hidden" name="fecha_recepcion" align="center"  size="10" maxlength="10"  value="<?php echo $fecha_ingreso;?>" >
			</td>
	</tr>
	
	<tr class="border_tr3">
		<td>
			<span class="fuente_normal"><strong>Unidad Emisora</strong></td>
		<td>
   		<select name="cod_departamento" class="caja_texto" onChange="this.form.submit()">
			<option value="">Seleccione un Departamento</option>
			<?php
				$ssqlcinco="SELECT * FROM departamento ORDER BY departamento_descripcion_dep";
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
            <?php Alert($alert_dep);?>         
			</td>
		</tr>
		<tr class="border_tr3">
		<td>
			<span class="fuente_normal"><strong>Remitente</strong>       	</td>
		<td>
         <select name="cod_de" class="caja_texto" onChange="this.form.submit()">
			<option value="">Seleccione un Usuario</option>
			<?php
				$ssqlcinco="SELECT * FROM usuario where usuario_cod_departamento='$_POST[cod_departamento]' AND usuario_ocupacion <> '' AND usuario_active='1'";
				$rsscinco = mysql_query($ssqlcinco, $conn);
				while ($rowcinco=mysql_fetch_array($rsscinco))
					 {
						if($_POST['cod_de']==$rowcinco["usuario_ocupacion"])
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
          <!--remitente-->    </td>
	</tr>
<?php
if(!empty($_POST['cod_de']))
{
?>
    <tr class="border_tr3">
	<td>
			<span class="fuente_normal"><strong>Cargo Remitente</strong>	</td>
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



<tr class="border_tr3"><td><span class="fuente_normal"><strong>No. de CITE</strong></td>
		
			<td><?php
		  echo "<input type=\"text\" size=\"40\" name=\"numero_cite\" class=\"caja_texto\" value=".$_POST['numero_cite'].">";
		  	Alert($alert_cite);
			?>		 
			</td>
		</tr>
		<tr class="border_tr3"><td><span class="fuente_normal"><strong>Fecha del CITE</strong></td>
		<td>
		<?php
echo "<input type=\"text\" name=\"fecha_cite\" readonly=\"readonly\" class=\"caja_texto\" id=\"dateArrival\" onClick=\"popUpCalendar(this, enviar.dateArrival, 'yyyy-mm-dd');\" size=\"10\" value=".$_POST['fecha_cite'].">";
echo " <img src=\"images/cal_ico.png\" width=\"25\" height=\"25\" onClick=\"popUpCalendar(this, enviar.dateArrival, 'yyyy-mm-dd');\" alt=\"Calendario\" />";
 Alert($alert_fechacite);
   		?>        </td>
		</tr>
	  
       <tr class="border_tr3"><td width="30%"><span class="fuente_normal"><strong>Tipo de Documento</strong></td>
		<td>
			<select name="clase_doc" class="caja_texto">
			<option value="">Seleccione un Documento</option>
				<?php
					$ssql = "SELECT * FROM documentos order by documentos_descripcion";
					$rss = mysql_query($ssql,$conn);
					while($row=mysql_fetch_array($rss))
					 {  
					     if ($_POST['descripcion_clase_corresp']==$row["documentos_sigla"])
						 {
	               		  ?>	
  				         <option value="<?php echo $row["documentos_sigla"]?>" selected>
                         <?php
	                      echo $row["documentos_descripcion"];
						  ?>
                          </option>
                          <?php
                          }
						  else
						  {			
						  ?>
						  <option value="<?php echo $row["documentos_sigla"]?>">
						  <?php
						  echo $row["documentos_descripcion"];
						  ?>
						  </option>
						  <?php
						  }
					}	   
				           ?>
			   </select>	
			    <?php Alert($alert_doc);?>
			   </td>
	</tr>
	<tr class="border_tr3">
    <td>
    <span><strong>Referencia</strong></td>
	<td>
	   <textarea name="referencia"  cols="60" rows="2"><?php echo $_POST['referencia'];?></textarea>
      <?php Alert($alert_ref);?>    </td>
	</tr>
	
	<? 
		$rdep=mysql_query("select cargos_dependencia from cargos where cargos_id='$codigo'",$conn);
		$rwl=mysql_fetch_array($rdep);
		
		$dep=$rwl["cargos_dependencia"];
		
		$rbsdep=mysql_query("select departamento_descripcion_dep, cargos_cargo, usuario_nombre, usuario_ocupacion, departamento_cod_departamento from usuario, cargos, departamento
		where cargos_id='$dep' and usuario_ocupacion=cargos_id and cargos_cod_depto=departamento_cod_departamento",$conn);		
		$rw=mysql_fetch_array($rbsdep);
		if($rw>0)
		{
		?>
		<input type="hidden" name="cod_para" class="caja_texto" size="60" value="<?php echo $rw['usuario_ocupacion'];?>">
		<tr class="border_tr3">
		<td>			
			<span><strong>Unidad de Destino</strong></td>
	
		<td>		    
			<input type="hidden" name="entidad_destinatario" class="caja_texto" size="60" value="<?php echo $rw['departamento_cod_departamento'];?>">
			<?php echo $rw[departamento_descripcion_dep];?>	
		</td>
		</tr>
		<tr class="border_tr3">
		<td>
			<span><strong>Destinatario</strong></td>
		<td>
			<input type="hidden" name="destinatario" class="caja_texto" size="60" value="<?php echo $rw['usuario_nombre'];?>">
            <?php echo $rw['usuario_nombre'];?>
		</td>
		</tr>

		<tr class="border_tr3">
		<td>
				<span><strong>Cargo del Destinatario</strong></td>
		<td>
			<input type="hidden" name="cargo_destinatario" class="caja_texto" size="60" value="<?php echo $rw['cargos_cargo'];?>">
			<?php echo $rw['cargos_cargo'];?>
		</td>
		</tr>		
		<? 
		}
		?>
	
	<tr class="border_tr3"><td><span><strong>Numero de Hojas</strong></td>
	<td>
	<?php
	 echo "<input type=\"text\" name=\"cantidad_hojas\" maxlength=4 size=4 class=\"caja_texto\" value=".$_POST['cantidad_hojas'].">";
	 Alert($alert_hojas);
	?>    </td>
	</tr>
	<tr class="border_tr3">
	  <td><span class="fuente_normal"><strong>Cantidad Anexos</strong></td>
	  <td><?php
			echo "<input type=\"text\" name=\"nro_anexos\" maxlength=4 size=4 class=\"caja_texto\" value=".$_POST['nro_anexos'].">";
			Alert($alert_anexos);
			?>      
		</td>
	  </tr>
    <tr class="border_tr3"><td><span class="fuente_normal"><strong>Descripcion de Anexo</strong></td>
	<td>
       <?php
			echo "<input type=\"text\" name=\"tipo_anexos\" maxlength=100 size=50 class=\"caja_texto\" value=".$_POST['tipo_anexos'].">";
  	    ?>    </td>
	</tr>
	<tr class="border_tr3">
	<td><span class="fuente_normal"><strong>Subir Archivo Adjunto:</strong></td>
	<td><input style="font-size:9px; color:blue" name="nom_arch_adj" type="file" size="60"></td>
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
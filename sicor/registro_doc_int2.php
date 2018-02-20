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

$depto=$_SESSION["departamento"];
$cargo_fun=$_SESSION["cargo_fun"];
$codigo_usuario=$_SESSION["codigo"];
$codigo=$_SESSION["cargo_asignado"];
echo "$depto<br>";
echo "$cargo_fun<br>";
echo "$codigo_usuario<br>";
echo "$codigo<br>";
?>
<script>
<!--
function Abre_ventana (pagina)
{
     ventana=window.open(pagina,"Asignar","toolbar=no,location=0,directories=no,status=no,menubar=no,scrollbars=yes,resizable=yes,width=700,height=300");
}

function Retornar()
{
    //document.enviar.action="ingreso_recepcion.php";
    document.enviar.submit();
}
-->
</script>

<?php


$respaaaa=mysql_query("select * from cargos where cargos_id='$_SESSION[cargo_asignado]'");
if($rowaa=mysql_fetch_array($respaaaa))
{
	$codigodepartamento = $rowaa["cargos_cod_depto"];
}

?>
<?php
	$respuesta=mysql_query("SELECT * FROM departamento WHERE departamento_cod_departamento='$codigodepartamento'",$conn);
	if ($rowasi=mysql_fetch_array($respuesta))
	{
		$varuss=$rowasi["departamento_cod_edificio"];
		$sigladep=$rowasi["departamento_sigla_dep"];
	      	$respuestatres=mysql_query("SELECT * FROM edificio
                                            WHERE edificio_cod_edificio='$varuss'",$conn);
        	if ($rowasitres=mysql_fetch_array($respuestatres))
		{  
	               $codigoedificio=$rowasitres["edificio_cod_edificio"];		
   	               $siglaedificio=$rowasitres["edificio_sigla_ed"];
		}
	}
        
if(!empty($_POST[correspondencia_tipo]))
{
    $_SESSION[correspondencia_tipo_elegido] = $_POST[correspondencia_tipo];
    $_SESSION[correpondencia_regularizacion] = $_POST[fecha_regularizacion];
}

if ($_SESSION[correspondencia_tipo_elegido] == "Regularizacion")
{
      if($_SESSION[correpondencia_regularizacion] < date("Y-m-d") && !empty($_SESSION[correpondencia_regularizacion]))
      {
       $ssql = "SELECT * FROM ingreso
                WHERE ingreso_fecha_ingreso = '$_SESSION[correpondencia_regularizacion]'
                AND ingreso_hoja_ruta_tipo = 'e'
                ORDER BY ingreso_nro_registro DESC";
        $rss_consulta = mysql_query($ssql,$conn);
        if(mysql_num_rows($rss_consulta) > 0)
        {
         if($row = mysql_fetch_array($rss_consulta))
            {
                $fecha_ingreso = $_SESSION[correpondencia_regularizacion];
                $hora_ingreso = $row["ingreso_hora_ingreso"];
                $hoja_ruta_recuperado1  = explode("-",$row["ingreso_hoja_ruta"]);
                $hoja_ruta_recuperado2 = explode("/",$hoja_ruta_recuperado1[2]);

                if(substr_count($hoja_ruta_recuperado2[0],".") > 0)
                 {
                    $hoja_ruta_recuperado3 = explode(".",$hoja_ruta_recuperado2[0]);
                    $numero_correlativo = $hoja_ruta_recuperado3[1] + 1;
                    $hoja_ruta_nueva = $hoja_ruta_recuperado3[0].".".$numero_correlativo;
                 }
                 else
                 {
                     $hoja_ruta_nueva = $hoja_ruta_recuperado2[0].".1";
                 }
                 
                 $hoja_ruta_nueva = $hoja_ruta_nueva."/".$hoja_ruta_recuperado2[1];
                 $hoja_ruta_v = $hoja_ruta_recuperado1[0]."-".$hoja_ruta_recuperado1[1]."-".$hoja_ruta_nueva;

            }
          }
           else
           {
                     echo "<br /><br /><br />";
                     echo "<center>NO SE HA ENCONTRADO CORRESPONDENCIA EN LA FECHA INDICADA";
                     echo "<br /><br /><a href=\"elegir.php\" class=\"boton\" />&nbsp;&nbsp; [Volver...]&nbsp;&nbsp; </a></center>";
                     echo "<br /><br /><br />";
                     exit;
           }
         }
         else
          {
                     echo "<br /><br /><br />";
                     echo "<center>FECHA NO VALIDA";
                     echo "<br /><br /><a href=\"elegir.php\" class=\"boton\" />&nbsp;&nbsp; [Volver...]&nbsp;&nbsp; </a></center>";
                     echo "<br /><br /><br />";
                     exit;
           }

}
else
{
      /*$ssql="SELECT * FROM edificio
                   WHERE edificio_cod_edificio='$codigoedificio'
                   ORDER BY edificio_hoja_ruta_ext DESC";

        $rss_consulta = mysql_query($ssql,$conn);
            if($row=mysql_fetch_array($rss_consulta))
            {
                     $hoja_num = $row["edificio_hoja_ruta_ext"];
                     $hoja_ruta_v = $hoja_num + 1;
                     $hoja_ruta_v = $siglaedificio."-".$sigladep."-".$hoja_ruta_v."/".date("Y");
            }

*/

		$ssql="SELECT departamento_nroregistro_e FROM departamento
					   WHERE departamento_cod_departamento='$codigodepartamento'";
			$rss_consulta = mysql_query($ssql,$conn);
			if($row=mysql_fetch_array($rss_consulta))
			{
						  $hoja_num = $row["departamento_nroregistro_e"];
						  $hoja_ruta_v=$hoja_num + 1;
						  $hoja_ruta_v = $siglaedificio."/".$sigladep."/".$hoja_ruta_v."/".date("Y");
			}



          $fecha_ingreso = date("d-m-Y");
	  $hora_ingreso = date("H:i:s");
}

    $respuesta=mysql_query("SELECT  * FROM instituciones
                                           WHERE instituciones_cod_institucion='$_SESSION[institucion]'",$conn);
    if ($rowasi=mysql_fetch_array($respuesta))
    {
             $nro_reg=$rowasi["instituciones_nro_registro"];
    }

$nro_reg = $nro_reg + 1;




/*PROCEDIMIENTO DE ENVIO DE CORRESPODENCIA*/

if (isset($_POST['grabar'])) 
{
/**********************************************************************************
                                VALIDACIONES NUEVAS 
***********************************************************************************/
      $valor1=val_alfanum($_POST['entidad_remite']);
	if($valor1 == 0)
	{
             $error=TRUE;
             $alert_ent=1;
	}
	
        $valor1=val_alfanum($_POST['remitente']);
	if($valor1 == 0)
	{ 
            $error=TRUE;
            $alert_rem=1;
	}

         $valor1=val_alfanum($_POST['cargo_remitente']);
	if($valor1 == 0)
	{ 
             $error=TRUE;
             $alert_crem=1;
	}
	


        $valor1=val_alfanum($_POST['numero_cite']);
	if($valor1 == 0)
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

   $valor1=val_alfanum($_POST['referencia']);
	if($valor1 == 0)
	{ 
            $error=TRUE;
            $alert_ref=1;
	}
   $valor1=val_alfanum($_POST['lugar']);
	if($valor1 == 0)
	{ 
            $error=TRUE;
            $lugar=1;
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


         $valor1=val_alfanum($_POST['descripcion_clase_corresp']);
	if($valor1 == 0)
	{
	 $error=TRUE;
         $alert_clase=1;
	}



if (!$error) 
{

$respaaaa=mysql_query("select * from cargos where cargos_id='$_SESSION[cargo_asignado]'");
if($rowaa=mysql_fetch_array($respaaaa))
{
	$codigodepartamento = $rowaa["cargos_cod_depto"];
}
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
	

if ($_SESSION[correspondencia_tipo_elegido] == "Regularizacion")
{
        $ssql = "SELECT * FROM ingreso
                     WHERE ingreso_fecha_ingreso = '$_SESSION[correpondencia_regularizacion]'
                     AND ingreso_hoja_ruta_tipo = 'e'
                     ORDER BY ingreso_nro_registro DESC";
        $rss_consulta = mysql_query($ssql,$conn);
         if($row = mysql_fetch_array($rss_consulta))
            {
                 $fecha_ingreso = $_SESSION[correpondencia_regularizacion];
                 $hora_ingreso = $row["ingreso_hora_ingreso"];
                 $hoja_ruta_recuperado1  = explode("-",$row["ingreso_hoja_ruta"]);
                 $hoja_ruta_recuperado2 = explode("/",$hoja_ruta_recuperado1[2]);
                 
                 if(substr_count($hoja_ruta_recuperado2[0],".") > 0)
                 {
                    $hoja_ruta_recuperado3 = explode(".",$hoja_ruta_recuperado2);
                    $numero_correlativo = $hoja_ruta_recuperado3[1] + 1;
                    $hoja_ruta_nueva = $hoja_ruta_recuperado3[0].".".$numero_correlativo;
                 }
                 else
                 {
                     $hoja_ruta_nueva = $hoja_ruta_recuperado2[0].".1";
                 }

                 $hoja_ruta_nueva = $hoja_ruta_nueva."/".$hoja_ruta_recuperado2[1];
                 $hoja_ruta = $hoja_ruta_recuperado1[0]."-".$hoja_ruta_recuperado1[1]."-".$hoja_ruta_nueva;
				
            }
            mysql_free_result($rss_consulta);
}
else
{
     /* $ssql="SELECT * FROM edificio WHERE edificio_cod_edificio='$codigoedificio' ORDER BY edificio_hoja_ruta_ext DESC";
      $rss_consulta = mysql_query($ssql,$conn);
      if($row=mysql_fetch_array($rss_consulta))
            {
                     $hoja_num = $row["edificio_hoja_ruta_ext"];
                     $hoja_ruta_v = $hoja_num + 1;
                     $hoja_ruta = $siglaedificio."-".$sigladep."-".$hoja_ruta_v."/".date("Y");
            }
		*/	
		
	$ssql="SELECT departamento_nroregistro_e FROM departamento WHERE departamento_cod_departamento='$codigodepartamento'";
			$rss_consulta = mysql_query($ssql,$conn);
			if($row=mysql_fetch_array($rss_consulta))
			{
						  $hoja_num = $row["departamento_nroregistro_e"];
						  $hoja_ruta_v=$hoja_num + 1;
						  $hoja_ruta = $siglaedificio."/".$sigladep."/".$hoja_ruta_v."/".date("Y");
			}	
			
			
            mysql_free_result($rss_consulta);
            $fecha_ingreso=date("y-m-d");
            $hora_ingreso=date("H:i:s");
            $codigo_gestion=date("Y");
}

        $respuesta=mysql_query("SELECT * FROM departamento
                                WHERE departamento_cod_departamento='$codigodepartamento'",$conn);
	if ($rowasi=mysql_fetch_array($respuesta))
	{
              $nro_registro = $rowasi["departamento_nroregistro_e"];
	}

$nro_registro = $nro_registro + 1;

$respuestados=mysql_query("select * from instituciones
                           where instituciones_cod_institucion='$_SESSION[institucion]'",$conn);
if ($rowasidos=mysql_fetch_array($respuestados))
{
	   $nro_registro_int=$rowasidos["instituciones_nro_registro"];		
}
$nro_registro_int = $nro_registro_int + 1;


$fecha_actual_generado = date("Y-m-d H:i:s");

$ssql2 = "INSERT INTO ingreso SET 
          ingreso_fecha_recepcion = '$fecha_actual_generado',
          ingreso_tipo_anexos = '$_POST[tipo_anexos]',
          ingreso_nro_registro = '$nro_registro_int',
          ingreso_codigo_gestion = '$codigo_gestion',
          ingreso_hoja_ruta = '$hoja_ruta',
          ingreso_descripcion_clase_corresp = '$_POST[descripcion_clase_corresp]',
          ingreso_nro_anexos = '$_POST[nro_anexos]',
          ingreso_fecha_ingreso = '$fecha_ingreso',
          ingreso_hora_ingreso = '$hora_ingreso',
		  ingreso_lugar = '$_POST[lugar]',
          ingreso_cantidad_hojas = '$_POST[cantidad_hojas]',
          ingreso_numero_cite = '$_POST[numero_cite]',
          ingreso_fecha_cite = '$_POST[fecha_cite]',
          ingreso_referencia = '$_POST[referencia]',
          ingreso_entidad_remite = '$_POST[entidad_remite]',
          ingreso_remitente = '$_POST[remitente]',
          ingreso_cargo_remitente = '$_POST[cargo_remitente]',
          ingreso_estado = 'P',
          ingreso_hoja_ruta_tipo = 'e',
          ingreso_Cod_Institucion = '$_SESSION[institucion]',
          ingreso_cod_usr = '$_SESSION[cargo_asignado]',
          ingreso_nro_registro_e = '$nro_registro',
          ingreso_destinatario_principal  = '$destinatario_principal_ext',
		  ingreso_prioridad = '$_POST[prioridad]',
		  ingreso_identificador_llenado = '$_POST[unidad]'";
		  
	
mysql_query($ssql2,$conn);
$_SESSION[nro_reg]=$nro_registro_int;
mysql_query("UPDATE departamento SET departamento_nroregistro_e='$hoja_ruta_v' WHERE departamento_cod_departamento='$codigodepartamento'",$conn);



if ($_SESSION[correspondencia_tipo_elegido] != "Regularizacion")
{
        mysql_query("UPDATE edificio SET
                             edificio_hoja_ruta_ext='$hoja_ruta_v'
                             WHERE edificio_cod_institucion='$_SESSION[institucion]'
                             AND edificio_cod_edificio='$codigoedificio'",$conn);
}

        mysql_query("UPDATE instituciones SET
                             instituciones_nro_registro='$nro_registro_int'
                             WHERE instituciones_cod_institucion='$_SESSION[institucion]'",$conn);
        unset($_POST);

?>
	 <script language="JavaScript">
			//window.self.location="ingreso_recepcion.php";
			window.self.location="elegir2.php?ingreso_hoja_ruta = <?php echo cifrar($nro_reg); ?>";
			 											
	 </script>
 <?php  
 } 
}

   echo "<br>";
   echo "<p class=fuente_titulo>";
   echo "<center><B>INGRESO DE CORRESPONDENCIA INTERNA";
   echo "</B></center></span>";
   echo "<br>";

 if ($error != 0)
{
echo "<center><table width=25%><tr><td class=fuente_normal_rojo  align=left><center><b> !!! ERROR DATOS NO VALIDOS !!!</b></center>".$valor_error."</td></tr></table></center>";
}
?>

<center>
<table width="70%" cellspacing="2" cellpadding="2" border="0">
	<form  method="POST" name="enviar" action=""> 
		<tr class="border_tr3">
			<td>
				<span class="fuente_normal">Fecha y Hora de Ingreso al Sistema</span>			</td>
			<td>
				<?php
					echo $fecha_ingreso." ".$hora_ingreso;
				?>
				</td>
	  </tr>
	  <tr class="border_tr3">
		<td>
			<span class="fuente_normal">Unidad Emisora</span>		</td>
		<td>
		    <input type="text" name="val1" class="caja_texto" size="60" value="<?php echo $_POST['val1'];?>">
			<input type="text" name="val2" class="caja_texto" size="60" value="<?php echo $_POST['val2'];?>">
			<input type="text" name="val3" class="caja_texto" size="60" value="<?php echo $_POST['val3'];?>">
			<input type="text" name="val4" class="caja_texto" size="60" value="<?php echo $_POST['val4'];?>">
			<input type="text" name="val5" class="caja_texto" size="60" value="<?php echo $_POST['val5'];?>">
			<a href="javascript:Abre_ventana('busca_unidad.php')">
				<img src="images/puntos.gif"></a>
            <?php Alert($alert_ent);?>		
		</td>
		</tr>	
	<tr class="border_tr3">
		<td><span class="fuente_normal">No. de CITE</span>
		</td>
		<td>
		<?php
	  echo "<input type=\"text\" name=\"numero_cite\" class=\"caja_texto\" size=\"60\" value=".$_POST['numero_cite'].">";
	  Alert($alert_cite);
		?>		
		</td>
	</tr>
	<tr class="border_tr3"><td><span class="fuente_normal">Fecha del CITE</span></td>
		<td>
        <?php
echo "<input type=\"text\" name=\"fecha_cite\"  readonly=\"readonly\" class=\"caja_texto\" id=\"dateArrival\" onClick=\"popUpCalendar(this, enviar.dateArrival, 'yyyy-mm-dd');\" size=\"10\" value=".$_POST['fecha_cite'].">";
echo " <img src=\"images/calendar.gif\" onClick=\"popUpCalendar(this, enviar.dateArrival, 'yyyy-mm-dd');\" alt=\"Calendario\" />";
  Alert($alert_fechacite);
	    ?>        
		</td>
	</tr>
	<!--
	<tr class="border_tr3">
		  <td><span class="fuente_normal">Procedencia</span></td>
		  <td><?php
	  echo "<input type=\"text\" name=\"lugar\" class=\"caja_texto\" value=".$_POST['lugar'].">";
	  Alert($lugar);
		?></td>
	</tr>
	-->			
		<? 
		$rdep=mysql_query("select cargos_dependencia from cargos where cargos_id='$codigo'",$conn);
		$rwl=mysql_fetch_array($rdep);
		
		$dep=$rwl["cargos_dependencia"];
		
		$rbsdep=mysql_query("select departamento_descripcion_dep, cargos_cargo, usuario_nombre from usuario, cargos, departamento
		where cargos_id='$dep' and usuario_ocupacion=cargos_id and cargos_cod_depto=departamento_cod_departamento ",$conn);		
		$rw=mysql_fetch_array($rbsdep);
		if($rw>0)
		{
		?>
		
		<tr class="border_tr3">
		<td>			
			<span class="fuente_normal">Unidad de Destino</span>		</td>
	
		<td>		    
			<input type="text" name="entidad_destinatario" class="caja_texto" size="60" value="<?php echo $rw[departamento_descripcion_dep];?>">
			<input type="hidden" name="entidad_destinatario2" class="caja_texto">	
		</td>
		</tr>
		<tr class="border_tr3">
		<td>
			<span class="fuente_normal">Destinatario</span>		</td>
		<td>
			<input type="text" name="destinatario" class="caja_texto" size="60" value="<?php echo $rw['usuario_nombre'];?>">
            
		</td>
		</tr>

		<tr class="border_tr3">
		<td>
				<span class="fuente_normal">Cargo del Destinatario</span></td>
		<td>
				<input type="texto" name="cargo_destinatario" class="caja_texto" size="60" value="<?php echo $rw['cargos_cargo'];?>">
		</td>
		</tr>		
		<? 
		}
		else
		{
		?>
		 <tr class="border_tr3">
		<td colspan="2">NO EXISTE LA UNIDAD
		</td>
		</tr>
		<?
		}
		?>
		

		
	
	
	
	<tr class="border_tr3"><td width="30%"><span class="<fuente_normal">Tipo de Documento</span></td>
		<td>
			<select name="descripcion_clase_corresp" class="caja_texto">
            <option value="">Seleccione una Clasificacion</option>
				<?php
					$ssql = "SELECT * FROM documentos order by documentos_descripcion";
					$rss = mysql_query($ssql,$conn);
					while($row=mysql_fetch_array($rss))
					 {  
					     if ($_POST['descripcion_clase_corresp']==$row["documentos_descripcion"])
						 {
	               		  ?>	
  				         <option value="<?php echo $row["documentos_descripcion"]?>" selected="selected">
                         <?php
	                      echo $row["documentos_descripcion"];
						  ?>
                          </option>
                          <?php
                          }
						  else
						  {			
						  ?>
						  <option value="<?php echo $row["documentos_descripcion"]?>">
						  <?php
						  echo $row["documentos_descripcion"];
						  ?>
						  </option>
						  <?php
						  }
					}	   
				           ?>
			   </select>
            <?php Alert($alert_clase);?>	</td>
	</tr>
	<tr class="border_tr3"><td><span class="fuente_normal">Referencia</span></td>
	<td>
		<textarea name="referencia" cols="60" rows="2" class="caja_texto"><?php echo $_POST['referencia'];?></textarea>
        <?php Alert($alert_ref);?>	</td>
	</tr>
	<input type="hidden" name="prioridad" class="caja_texto" value="Media">
	<!--
    <tr class="border_tr3"><td><span class="fuente_normal">Prioridad</span></td>
	<td>
	
	<select name="prioridad">
    	<option value="Alta">Alta
       	<option value="Media">Media
       	<option value="Baja">Baja
     </select>
	</td>
	</tr>
	-->
	<tr class="border_tr3"><td><span class="fuente_normal">N&uacute;mero de Hojas</span></td>
	<td>
		<?php
		 echo "<input type=\"text\" name=\"cantidad_hojas\" maxlength=4 size=4 class=\"caja_texto\" value=".$_POST['cantidad_hojas'].">";
		 Alert($alert_hojas);
		 ?>	</td>
	</tr>
	<tr class="border_tr3">
	<td><span class="fuente_normal">Numero de Adjuntos</span></td>
	<td>
		<?php
			 	echo "<input type=\"text\" name=\"nro_anexos\" maxlength=4 size=4 class=\"caja_texto\" value=".$_POST['nro_anexos'].">";
				Alert($alert_anexos);
		?>	</td>
	</tr>
	<tr class="border_tr3">
	<td><span class="fuente_normal">Tipo de Documento Adjunto</span></td>
	<td>
		<?php
			echo "<input type=\"text\" name=\"tipo_anexos\" maxlength=100 size=50 class=\"caja_texto\" value=".$_POST['tipo_anexos'].">";
  	    ?>	</td>
	</tr>
	<tr>
	<td align="center" colspan="2">
        <input type="submit" name="grabar" value="Grabar" class="boton"/>
		<input type="reset" name="cancelar" value="Cancelar" class="boton" onClick="Retornar();"/></td></tr>
	</form>
	</table>
</center>
<br>
<?php
include("final.php");
?>
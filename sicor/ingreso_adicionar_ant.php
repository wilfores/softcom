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
?>
<script>
    function Retornar()
    {
         document.enviar.action="ingreso_recepcion.php";
         document.enviar.submit();
    }
</script>
<?php
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
$respaaaa=mysql_query("SELECT * FROM cargos
                       WHERE cargos_id='$_SESSION[cargo_asignado]'");
if($rowaa=mysql_fetch_array($respaaaa))
{
    $codigodepartamento=$rowaa["cargos_cod_depto"];
}
?>
<?php

	$respuesta=mysql_query("SELECT * FROM departamento 
                                WHERE departamento_cod_departamento='$codigodepartamento'",$conn);
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

if(!empty($_POST[correspondencia_tipo]))
{
    $_SESSION[correspondencia_tipo_elegido] = $_POST[correspondencia_tipo];
    $_SESSION[correpondencia_regularizacion] = $_POST[fecha_regularizacion];
}

if ($_SESSION[correspondencia_tipo_elegido] == "Regularizacion")
{
      if($_SESSION[correpondencia_regularizacion] < date("Y-m-d") AND !empty($_SESSION[correpondencia_regularizacion]))
      {
       $ssql = "SELECT * FROM ingreso
                     WHERE ingreso_fecha_ingreso = '$_SESSION[correpondencia_regularizacion]'
                     AND ingreso_hoja_ruta_tipo = 'i'
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
           echo "!!!! ERROR - INTENTO DE MANIPULACION !!!!";
           exit;
       }
}
else
{
    $ssql="SELECT departamento_nroregistro_e FROM departamento
               WHERE departamento_cod_departamento='$codigodepartamento'";
    $rss_consulta = mysql_query($ssql,$conn);
	if($row=mysql_fetch_array($rss_consulta))
	{
		  $hoja_num = $row["departamento_nroregistro_e"];
                  $hoja_ruta_v=$hoja_num + 1;
                  $hoja_ruta_v = $siglaedificio."-".$sigladep."-".$hoja_ruta_v."/".date("Y");
	}

          $fecha_ingreso = date("Y-m-d");
	  $hora_ingreso = date("H:i:s");
}
	
	$respuesta=mysql_query("select * from instituciones where instituciones_cod_institucion='$_SESSION[institucion]'",$conn);
	if ($rowasi=mysql_fetch_array($respuesta))
		{
			 $nro_reg=$rowasi["instituciones_nro_registro"];		
		}

	$nro_reg=$nro_reg + 1;



/**********************************************************************************
                ENVIO DEL FORMULARIO PARA VALIDACION
***********************************************************************************/
if (isset($_POST['grabar'])) 
{
	if(empty($_POST['cod_departamento']))
	{ 
             $error=TRUE;
             $alert_dep=1;
	}
	

if (!$error) 
  {

        $respaaaa=mysql_query("SELECT * FROM cargos
                               WHERE cargos_id='$_SESSION[cargo_asignado]'");
        if($rowaa=mysql_fetch_array($respaaaa))
        {
            $codigodepartamento=$rowaa["cargos_cod_depto"];
        }
        mysql_free_result($respaaaa);
        
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
              if($_SESSION[correpondencia_regularizacion] < date("Y-m-d") AND !empty($_SESSION[correpondencia_regularizacion]))
              {
               $ssql = "SELECT * FROM ingreso
                        WHERE ingreso_fecha_ingreso = '$_SESSION[correpondencia_regularizacion]'
                        AND ingreso_hoja_ruta_tipo = 'i'
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
                         $hoja_ruta = $hoja_ruta_recuperado1[0]."-".$hoja_ruta_recuperado1[1]."-".$hoja_ruta_nueva;

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
            $ssql="SELECT departamento_nroregistro_e FROM departamento
                       WHERE departamento_cod_departamento='$codigodepartamento'";
            $rss_consulta = mysql_query($ssql,$conn);
                if($row=mysql_fetch_array($rss_consulta))
                {
                          $hoja_num = $row["departamento_nroregistro_e"];
                          $hoja_ruta_v = $hoja_num + 1;
                          $hoja_ruta = $siglaedificio."-".$sigladep."-".$hoja_ruta_v."/".date("Y");
                }

                  $fecha_ingreso = date("Y-m-d");
                  $hora_ingreso = date("H:i:s");
                  $codigo_gestion=date("Y");
        }


	$respuesta=mysql_query("SELECT  * FROM instituciones
                                WHERE instituciones_cod_institucion='$_SESSION[institucion]'",$conn);
	if ($rowasi=mysql_fetch_array($respuesta))
            {
			 $nro_registro_int=$rowasi["instituciones_nro_registro"];		
	    }

	$nro_registro_int = $nro_registro_int + 1;

        $fecha_actual_generado = date("Y-m-d H:i:s");
		
		
		

        $consulclave=mysql_query("SELECT * FROM registroarchivo
                                  WHERE registroarchivo_codigo='$_POST[remitente]'",$conn);
	if(mysql_num_rows($consulclave)>0)
	{
	    if ($rowclave=mysql_fetch_array($consulclave))
            {
			          
			        $tipo_doc=$rowclave['registroarchivo_tipo'];
					$rss = mysql_query("SELECT * FROM documentos where documentos_id='$tipo_doc'",$conn);
					if($row=mysql_fetch_array($rss))
					 {
					 $descripcion_clase_corresp=$row["documentos_descripcion"];	
					 }
					 
			$numero_cite=$rowclave["registroarchivo_hoja_interna"];
			$fecha_citeaux=explode(" ",$rowclave["registroarchivo_fecha_pdf"]);
			$fecha_cite=$fecha_citeaux[0];
			$referencia=$rowclave["registroarchivo_referencia"];
			$remitente=$rowclave["registroarchivo_usuario_inicia"];

                        mysql_query("UPDATE registroarchivo SET
                                     registroarchivo_terminar='S'
                                     WHERE registroarchivo_codigo='$rowclave[registroarchivo_codigo]'",$conn);

			}
	}	

         $ssql2 = "INSERT INTO ingreso SET
                       ingreso_fecha_recepcion = '$fecha_actual_generado',
                       ingreso_tipo_anexos = '$_POST[tipo_anexos]',
                       ingreso_nro_registro = '$nro_registro_int',
                       ingreso_codigo_gestion = '$codigo_gestion',
                       ingreso_hoja_ruta = '$hoja_ruta',
                       ingreso_descripcion_clase_corresp = '$descripcion_clase_corresp',
                       ingreso_nro_anexos = '$_POST[nro_anexos]',
                       ingreso_fecha_ingreso = '$fecha_ingreso',
                       ingreso_hora_ingreso = '$hora_ingreso',
                       ingreso_cantidad_hojas = '$_POST[cantidad_hojas]',
                       ingreso_numero_cite = '$numero_cite',
                       ingreso_fecha_cite = '$fecha_cite',
                       ingreso_referencia = '$referencia',
                       ingreso_cod_departamento = '$_POST[cod_departamento]',
                       ingreso_remitente = '$remitente',
                       ingreso_cargo_remitente = '$remitente',
                       ingreso_estado = 'P',
                       ingreso_hoja_ruta_tipo = 'i',
                       ingreso_cod_institucion = '$_SESSION[institucion]',
                       ingreso_cod_usr = '$_SESSION[cargo_asignado]',
                       ingreso_nro_registro_e = '$_POST[nro_registro]',
				       ingreso_destinatario_principal = '$destinatario_principal_int'";
          mysql_query($ssql2,$conn);

	         
	  mysql_query("UPDATE departamento SET
                               departamento_nroregistro_e = '$hoja_ruta_v'
                               WHERE departamento_cod_departamento='$codigodepartamento'
                               AND departamento_cod_institucion='$_SESSION[institucion]'",$conn);
	
          mysql_query("UPDATE instituciones SET
                               instituciones_nro_registro='$nro_registro_int'
                               WHERE instituciones_cod_institucion='$_SESSION[institucion]'",$conn);

?>
	 <script language="JavaScript">
			window.self.location="ingreso_recepcion.php";
	 </script>
 <?php  
 } 
}

   echo "<br>";
   echo "<p class=fuente_titulo>";
   echo "<center><b>INGRESO DE CORRESPONDENCIA";
   echo " INTERNA";
   echo "</b></center></span>";
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
				<span class="fuente_normal">Fecha y Hora de ingreso al sistema
                </td>
		<td>
		<?php
                    echo $fecha_ingreso." ".$hora_ingreso;
		?>
		</td>
        	</tr>
		<tr class="border_tr3">
		<td>
			<span class="fuente_normal">Entidad Emisora		</td>
		<td>
   <select name="cod_departamento" class="caja_texto" onChange="this.form.submit()">
			<option value="">Seleccione un Departamento</option>
			<?php
				$ssqlcinco="SELECT * FROM departamento where departamento_cod_institucion='$_SESSION[institucion]'";
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
			<span class="fuente_normal">Archivo Recibidos</span>
       	</td>
		<td>
         <select name="remitente" class="caja_texto" onChange="this.form.submit()">
			<option value="">Seleccionar Archivo</option>
			<?php 
				$ssqlcinco="SELECT * FROM registroarchivo a, derivaciones b
                                            WHERE a.registroarchivo_depto='$_POST[cod_departamento]'
                                            AND a.registroarchivo_estado='T'
                                            AND a.registroarchivo_codigo =  b.derivaciones_hoja_interna
                                            AND b.departamento_cod_departamento='$codigodepartamento'
                                            AND b.derivaciones_estado = 'P'
                                            AND a.registroarchivo_terminar='N'
                                            ORDER BY a.registroarchivo_tipo ASC";
				$rsscinco = mysql_query($ssqlcinco, $conn);
				while ($rowcinco=mysql_fetch_array($rsscinco))
					 {
						if($_POST['remitente']==$rowcinco["registroarchivo_codigo"])
							{
		   ?>    				<option value="<?php echo $rowcinco["registroarchivo_codigo"]?>" selected>
								<?php
									echo $rowcinco["registroarchivo_hoja_interna"];
							
								
								?>
								 </option>
         				   <?php 
					  	    }
						  else
							{
							?>
								<option value="<?php echo $rowcinco["registroarchivo_codigo"]?>">
							<?php
								echo $rowcinco["registroarchivo_hoja_interna"];
								
							?>
								</option>
					<?php
						    }
					 } 

					?>
			</select> 
                <?php Alert($alert_rem); ?>    
          <!--remitente-->		
    </td>
	</tr>
<?php 
if(!empty($_POST['remitente']))
{
                $ssqlcinco33="SELECT * FROM registroarchivo where registroarchivo_codigo='$_POST[remitente]'";
				$rsscinco33 = mysql_query($ssqlcinco33, $conn);
				while ($rowcinco33=mysql_fetch_array($rsscinco33))
					 {
					 $usuario=$rowcinco33["registroarchivo_usuario_inicia"];
					 $cite=$rowcinco33["registroarchivo_hoja_interna"];
					 $fechacite=$rowcinco33["registroarchivo_fecha_recepcion"];
					 $clasificacion=$rowcinco33["registroarchivo_tipo"];
					 $referencia=$rowcinco33["registroarchivo_referencia"];
					 }
?>
    <tr class="border_tr3">
	<td>
			<span class="fuente_normal">Remitente</span>
	</td>
	<td>
    <input type="hidden" name="cargo_remitente" class="caja_texto" value="<?php echo $valor_clave?>" />
    <?php
		$ssqlcinco2="SELECT * FROM cargos where cargos_id='$usuario'";
		$rsscinco2 = mysql_query($ssqlcinco2, $conn);
		while ($rowcinco2=mysql_fetch_array($rsscinco2))
		{

				$ssqlcinco22="SELECT * FROM usuario where usuario_ocupacion='$usuario'";
		        $rsscinco22 = mysql_query($ssqlcinco22, $conn);
		        while ($rowcinco22=mysql_fetch_array($rsscinco22))
				{
		
		echo strtoupper($rowcinco22["usuario_nombre"])."</br>";
		echo "<b>".$rowcinco2["cargos_cargo"]."</b>";
				}
		
		}	
	
	?>
    <!--cargo_remitente -->	
    </td>
	</tr>

	    <tr class="border_tr3"><td><span class="fuente_normal">No. de CITE</td>
		<td>
		<?php
		echo"<b>".$cite."</b>";
		?>		
        
        </td>
		</tr>
       
		<tr class="border_tr3"><td><span class="fuente_normal">Fecha del CITE</td>
		<td>
		<?php
      echo "<b>".$fechacite."</b>";
   		?>   	    
        </td>
		</tr>
 	  
       <tr class="border_tr3"><td width="30%"><span class="fuente_normal">Clasificacion</td>
		<td>
		           <?php 
				    $ssql = "SELECT * FROM documentos where documentos_id='$clasificacion'";
					$rss = mysql_query($ssql,$conn);
					while($row=mysql_fetch_array($rss))
					 {
					 echo "<b>".$row["documentos_descripcion"]."</b>"; 
					 }
				   ?>
               </td>
	</tr>
	<tr class="border_tr3">
    <td>
    <span class="fuente_normal">Referencia</td>
	<td>
     <?php 
	  echo "<b>".$referencia."</b>";
	  ?>
    </td>
	</tr>
    
  <?php
}//ojo
?>  
    
    <tr class="border_tr3"><td><span class="fuente_normal">N&uacute;mero de Hojas</td>
	<td>
	<?php
	 echo "<input type=\"text\" name=\"cantidad_hojas\" maxlength=4 size=4 class=\"caja_texto\" value=".$_POST['cantidad_hojas'].">";
	 Alert($alert_hojas);
	?>
    </td>
	</tr>
	<tr class="border_tr3"><td><span class="fuente_normal">Cantidad Anexos</td>
	<td>
		<?php
			echo "<input type=\"text\" name=\"nro_anexos\" maxlength=4 size=4 class=\"caja_texto\" value=".$_POST['nro_anexos'].">";
			Alert($alert_anexos);
		?>	
    </td>
	</tr>
	
    <tr class="border_tr3"><td><span class="fuente_normal">Tipo Anexo</td>
	<td>
       <?php
			echo "<input type=\"text\" name=\"tipo_anexos\" maxlength=100 size=50 class=\"caja_texto\" value=".$_POST['tipo_anexos'].">";
  	    ?>
    
    </td>
	</tr>	
	
    <tr>
	<td align="center" colspan="2">
			<input type="submit" name="grabar" value="Grabar" class="boton"/>
			<input type="reset" name="cancelar" value="Cancelar" class="boton" onClick="Retornar();"/>
    </td>
    </tr>
	</form>
	</table>
</center>
<br>
<?php
include("final.php");
?>
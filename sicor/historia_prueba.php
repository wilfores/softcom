<?php
include("../filtro.php");
?>
<?php
include("inicio.php");
?>
<?php
include("script/functions.inc");
include("script/cifrar.php");
include("../conecta.php");
$cod_institucion=$_SESSION["institucion"];
$codigo_usuario=$_SESSION["cargo_asignado"];
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
unset($_SESSION[logo_pie]);
unset($_SESSION[logo_cabecera]);
?>
<?php
$valor_recibido = descifrar($_GET[valor]);
if(!is_numeric($valor_recibido))
{
    echo "!!! INTENTO DE MANIPULACION DEL SISTEMA !!!";
    exit;
}

$sql_valor = mysql_query("SELECT * FROM registroarchivo
                          WHERE registroarchivo_codigo = '$valor_recibido'",$conn);
if($fila_archivo = mysql_fetch_array($sql_valor))
{
?>
<center>
    <?php
    $sql_consulta_doc = mysql_query("SELECT documentos_descripcion FROM documentos
                                     WHERE documentos_id = '$fila_archivo[registroarchivo_tipo]'",$conn);
            if($fila_tipo = mysql_fetch_array($sql_consulta_doc))
            {
                echo "<br /><span class=fuente_titulo><b>".$fila_tipo["documentos_descripcion"]."</b></span><br /><br />";
            }
            mysql_free_result($sql_consulta_doc);
    ?>
<table border="0" cellpadding="0" cellspacing="2" align="center" width="80%">
<tr>
   <td align="center" colspan="2" class="border_tr2">
    <?php
    echo "<span class='fuente_titulo'><b>";
    echo "<center>CITE:" . $fila_archivo["registroarchivo_hoja_interna"] . "</center></b></span>";
    ?>
   </td>
</tr>
<tr class="border_tr3">
    <td align="right" class="border_tr2">
        <b>PARA:</b>
    </td>
    <td>
       <table width="95%" BORDER="0" CELLSPACING="2" CELLPADDING="0" class="fuente_normal">
        <?php
        echo "<tr><td bgcolor=\"#EFEBE3\" width=\"300\">";
        $consulta_aux = "SELECT b.usuario_nombre, c.cargos_cargo
                         FROM derivaciones a, usuario b, cargos c
                         WHERE a.derivaciones_hoja_interna = '$valor_recibido'
                         AND a.derivaciones_estado = 'P'
                         AND a.derivaciones_cod_usr = b.usuario_ocupacion
                         AND b.usuario_ocupacion = c.cargos_id";
        $rss_consulta = mysql_query($consulta_aux, $conn);
        while($fila_para = mysql_fetch_array($rss_consulta))
        {
            echo "<br />".$fila_para["usuario_nombre"];
            echo "<br /> <b>(".$fila_para["cargos_cargo"].")</b>";
        }
        echo "</td></tr>";
        mysql_free_result($rss_consulta);
        ?>
        </table>
        </td>
        </tr>
        <?php
        $consulta_aux = "SELECT b.usuario_nombre, c.cargos_cargo FROM derivaciones a, usuario b, cargos c
                         WHERE a.derivaciones_hoja_interna = '$valor_recibido'
                         AND a.derivaciones_estado = 'V'
                         AND a.derivaciones_cod_usr = b.usuario_ocupacion
                         AND b.usuario_ocupacion = c.cargos_id";
        $rss_consulta = mysql_query($consulta_aux, $conn);
        if(mysql_num_rows($rss_consulta) > 0)
        {
        ?>

        <tr class="border_tr3">
        <td align="right" class="border_tr2">
            <b>VIA:</b>
        </td>
        <td>
       <table width="95%" BORDER="0" CELLSPACING="2" CELLPADDING="0" class="fuente_normal">
        <?php
        echo "<tr><td bgcolor=\"#EFEBE3\" width=\"300\">";
        while($fila_para = mysql_fetch_array($rss_consulta))
        {
            echo "<br />".$fila_para["usuario_nombre"];
            echo "<br /> <b>(".$fila_para["cargos_cargo"].")</b>";
        }
        echo "</td></tr>";
        ?>
        </table>
        </td>
        </tr>
        <?php
      }
      mysql_free_result($rss_consulta);
      ?>
      <tr class="border_tr3">
        <td align="right" class="border_tr2">
            <b>DE:</b>
        </td>
        <td>
       <table width="95%" BORDER="0" CELLSPACING="2" CELLPADDING="0" class="fuente_normal">
<?php
         echo "<tr><td bgcolor=\"#EFEBE3\" width=\"300\">";

        $consulta_aux = "SELECT b.usuario_nombre, c.cargos_cargo FROM derivaciones a, usuario b, cargos c
                         WHERE a.derivaciones_hoja_interna = '$valor_recibido'
                         AND a.derivaciones_estado = 'D'
                         AND a.derivaciones_cod_usr = b.usuario_ocupacion
                         AND b.usuario_ocupacion = c.cargos_id";
        $rss_consulta = mysql_query($consulta_aux, $conn);
        while($fila_para = mysql_fetch_array($rss_consulta))
        {
            echo "<br />".$fila_para["usuario_nombre"];
            echo "<br /> <b>(".$fila_para["cargos_cargo"].")</b>";
        }
        echo "</td></tr>";
        mysql_free_result($rss_consulta);
        ?>
        </table>
        </td>
        </tr>
        <tr class="border_tr3">
        <td align="right" class="border_tr2">
            <b>REF.:</b>
        </td>
        <td>
            <?php echo $fila_archivo["registroarchivo_referencia"];?>
        </td>
        </tr>
        <tr class="border_tr3">
        <td align="right" class="border_tr2">
            <b>FECHA.:</b>
        </td>
        <td>
            <?php echo $fila_archivo["registroarchivo_fecha_pdf"];?>
        </td>
        </tr>
        <tr class="border_tr3">
        <td class="border_tr2" align="right">
            <b>ADJUNTOS:</b>
        </td>
        <td align="left"  valign="top" colspan="2">
            <?php
            $conexion_sql = mysql_query("SELECT * FROM adjunto
                                         WHERE adjunto_id='$valor_recibido'",$conn);
            while($fila_adjunto = mysql_fetch_array($conexion_sql))
            {
                $archivo_enviar = cifrar($fila_adjunto["adjunto_archivo"]);
            ?>
            <a href="<?php echo $fila_adjunto["adjunto_archivo"];?>" target="_blank" class="enlace_normal">
                <img src="images/archivo.jpeg" width="12" height="14" alt="Archivo" />
                &nbsp;&nbsp;<?php echo $fila_adjunto["adjunto_nombre"];?>
            </a>
            &nbsp;&nbsp;&nbsp;
            <?php
                echo "<br /><br />";
            }
            ?>
        </td>
        </tr>
        </table>
        <br />
         <a href="imprimir_borrar.php?valor=<?php echo $_GET[valor];?>" class="boton" target="_blank">
         &nbsp; <b>Imprimir</b> &nbsp;
        </a>
</center>

<br />
<?PHP 
$ssql2="SELECT * FROM ingreso, seguimiento
       WHERE ingreso.ingreso_numero_cite='$fila_archivo[registroarchivo_hoja_interna]'
       AND ingreso.ingreso_hoja_ruta_tipo = 'i'
       AND ingreso.ingreso_nro_registro=seguimiento.seguimiento_nro_registro
       AND '$cod_institucion'=ingreso.ingreso_cod_institucion
       AND ingreso.ingreso_cod_institucion=seguimiento.seguimiento_cod_institucion
       ORDER BY seguimiento.seguimiento_fecha_deriva ASC";

$respuesta=mysql_query($ssql2,$conn);
$validar=mysql_num_rows($respuesta);

if($validar > 0)
{
?>
<center>
<table width="100%" cellspacing="1" cellpadding="1" border="0">
<tr class="border_tr2">
<td width="3%" align="center"><span class="fuente_normal">Tipo</span></td>
<td width="10%" align="center"><span class="fuente_normal">Remitente</span></td>
<td width="10%" align="center"><span class="fuente_normal">Fecha de Derivacion</span></td>
<td width="10%" align="center"><span class="fuente_normal">Destinatario</span></td>
<td width="10%" align="center"><span class="fuente_normal">Fecha de Recepcion</span></td>
<td width="15%" align="center"><span class="fuente_normal">Instruccion</span></td>
<td width="10%" align="center"><span class="fuente_normal">Estado</span></td>
<td width="30%" align="center"><span class="fuente_normal">Observaciones</span></td>
</tr>
<?php
$ssql="SELECT * FROM ingreso, seguimiento
       WHERE ingreso.ingreso_numero_cite='$fila_archivo[registroarchivo_hoja_interna]'
       AND ingreso.ingreso_hoja_ruta_tipo = 'i'
       AND ingreso.ingreso_nro_registro=seguimiento.seguimiento_nro_registro
       AND '$cod_institucion'=ingreso.ingreso_cod_institucion
       AND ingreso.ingreso_cod_institucion=seguimiento.seguimiento_cod_institucion
       ORDER BY seguimiento.seguimiento_fecha_deriva ASC";

$respi=mysql_query($ssql,$conn);

if (!empty($respi))
{
$resaltador=0;
while($row=mysql_fetch_array($respi))
{
		if ($resaltador == 0)
		  {
		       echo "<tr class=truno>";
			   $resaltador=1;
	      }
		  else
		  {
			   echo "<tr class=trdos>";
		   	   $resaltador=0;
		  }
?>


<?php
  $depart = $row["seguimiento_cod_departamento"];
  $ssqlnew = "SELECT * FROM departamento WHERE '$depart'=departamento_cod_departamento";
  $rssnew = mysql_query($ssqlnew,$conn);
  if ($rownew = mysql_fetch_array($rssnew))
  {
  	$departamento_de_destino=$rownew["departamento_descripcion_dep"];
  }

?>

<?php
if ($row["seguimiento_dpto_remite"] <> '0')
{
  $ssqlnew = "SELECT * FROM departamento WHERE '$row[seguimiento_dpto_remite]'=departamento_cod_departamento";
  $rssnew = mysql_query($ssqlnew,$conn);
  if($rownew = mysql_fetch_array($rssnew))
  {
  	$departamento_de_origen=$rownew["departamento_descripcion_dep"];
  }

}
?>


<td width="3%" align="center">
   OR
</td>

<td width="15%" align="left">
	<?php
if ($guardar_tipo_hoja=='e' AND $row["seguimiento_fecha_plazo"]== NULL )
{
	if ($row["seguimiento_dpto_remite"]==0)
	{
	echo $row["seguimiento_remitente"]."<br />".$cargo_externo;
	}
	else
	{
		 	$valor_clave=$row["seguimiento_remitente"];
			$conexion = mysql_query("SELECT * FROM cargos WHERE '$valor_clave'=cargos_id",$conn);
			if($fila_clave=mysql_fetch_array($conexion))
			{
				$valor_cargo=$fila_clave["cargos_id"];
				$conexion2 = mysql_query("SELECT * FROM usuario WHERE '$valor_cargo'=usuario_ocupacion",$conn);
				if($fila_cargo=mysql_fetch_array($conexion2))
				{
				echo $fila_cargo["usuario_nombre"];
				echo "<br />".$fila_clave["cargos_cargo"];
				}
			}

	}

}
else
{
    $valor_clave=$row["seguimiento_remitente"];
			$conexion = mysql_query("SELECT * FROM cargos WHERE '$valor_clave'=cargos_id",$conn);
			if($fila_clave=mysql_fetch_array($conexion))
			{
				$valor_cargo=$fila_clave["cargos_id"];
				$conexion2 = mysql_query("SELECT * FROM usuario WHERE '$valor_cargo'=usuario_ocupacion",$conn);
				if($fila_cargo=mysql_fetch_array($conexion2))
				{
				echo $fila_cargo["usuario_nombre"];
				echo "<br />".$fila_clave["cargos_cargo"];
				}
			}
}
?>
</td>

<td width="15%" align="center">
<?php echo $row["seguimiento_fecha_deriva"];?>
</td>

<td width="15%" align="left">
	<?php
			$valor_clave=$row["seguimiento_destinatario"];
			$conexion = mysql_query("SELECT * FROM cargos WHERE '$valor_clave'=cargos_id",$conn);
			if($fila_clave=mysql_fetch_array($conexion))
			{
				$valor_cargo=$fila_clave["cargos_id"];
				$conexion2 = mysql_query("SELECT * FROM usuario WHERE '$valor_cargo'=usuario_ocupacion",$conn);
				if($fila_cargo=mysql_fetch_array($conexion2))
				{
				echo $fila_cargo["usuario_nombre"];
				}
			}
	  	echo "<br />".$departamento_de_destino;
	?>
</td>

<td width="15%" align="center"><?php echo $row["seguimiento_fecha_recibida"];?>
</td>

<td width="15%" align="center">
<?php
$instruccion = $row["seguimiento_codigo_instruccion"];
$ssql44 = "SELECT * FROM instruccion WHERE '$instruccion'=instruccion_codigo_instruccion";
$rss44 = mysql_query($ssql44,$conn);
while($row44=mysql_fetch_array($rss44)){
$instrucion_com=$row44["instruccion_instruccion"];
}
echo $instrucion_com;
?>
</td>

<?php
if($row["seguimiento_estado"]=='P')
{
  if ($row["seguimiento_tipo"]=='R')
  {
      $estadito="Recibido";
  }
  else
  {
	  if ($row["seguimiento_tipo"]=='D')
		 {
		  $estadito="Despachado";
		 }
		 else
		 {
			  if ($row["seguimiento_tipo"]=='A')
				 {
				    $estadito="No Recibido";
				  }
		  }
  }
 ?>
<td width="9%" align="center"><?php echo $estadito;?>
</td>

<td width="15%" align="left"><span class="fuente_normal"><?php echo $row["seguimiento_observaciones"];?>
</td>

 <?php
}
else
{
 $estadito="Terminado";
 $fecha_salida = $row["seguimiento_fecha_salida"];
 $aux=1;
  ?>
  <td width="9%" align="center"><?php echo $estadito;?>
  </td>

  <td width="15%"align="left"><span class="fuente_normal"><?php echo $row["seguimiento_observaciones"];?>
  </td>
  <?php
	  $des_final=$row["seguimiento_descripcion_final"];
	  $archivado_final=$row["seguimiento_archivado"];
  ?>
  </tr>
<?php
}

	$ssql_1=mysql_query("select * from correspondenciacopia where correspondenciacopia_codigo_seguimiento='$row[seguimiento_codigo_seguimiento]'",$conn);
	while ($row_copia=mysql_fetch_array($ssql_1))
	{
	  if ($resaltador==0)
		  {
		       echo "<tr class=truno>";
			   $resaltador=1;
	      }
		  else
		  {
			   echo "<tr class=trdos>";
		   	   $resaltador=0;
		  }
 	   ?>
		<?php
		  $depart = $row_copia["correspondenciacopia_cod_departamento"];
		  $ssqlnew = "SELECT * FROM departamento WHERE '$depart'=departamento_cod_departamento";
		  $rssnew = mysql_query($ssqlnew,$conn);
		  if ($rownew = mysql_fetch_array($rssnew))
		  {
		  	$departamento_de_destino=$rownew["departamento_descripcion_dep"];
		  }

		?>
		<?php
	  	  $ssqlnew = "SELECT * FROM departamento WHERE '$row_copia[correspondenciacopia_dpto_remite]'=departamento_cod_departamento";
		  $rssnew = mysql_query($ssqlnew,$conn);
		  if($rownew = mysql_fetch_array($rssnew))
			  {
		  			$departamento_de_origen=$rownew["departamento_descripcion_dep"];
			  }

		?>
			<td width="3%" align="center">
			   CC
			</td>
			<td width="15%" align="left">
			<?php
						$valor_clave=$row_copia["correspondenciacopia_remitente"];
						$conexion = mysql_query("SELECT * FROM cargos WHERE '$valor_clave'=cargos_id",$conn);
						if($fila_clave=mysql_fetch_array($conexion))
						{
							$valor_cargo=$fila_clave["cargos_id"];
							$conexion2 = mysql_query("SELECT * FROM usuario WHERE '$valor_cargo'=usuario_ocupacion",$conn);
							if($fila_cargo=mysql_fetch_array($conexion2))
							{
							echo $fila_cargo["usuario_nombre"];
							echo "<br />".$fila_clave["cargos_cargo"];
							}
						}

			?>
			</td>
			<td width="15%" align="center"><?php echo $row_copia["correspondenciacopia_fecha_deriva"];?></td>
			<td width="15%" align="left">
			<?php
						$valor_clave=$row_copia["correspondenciacopia_destinatario"];
						$conexion = mysql_query("SELECT * FROM cargos WHERE '$valor_clave'=cargos_id",$conn);
						if($fila_clave=mysql_fetch_array($conexion))
						{
							$valor_cargo=$fila_clave["cargos_id"];
							$conexion2 = mysql_query("SELECT * FROM usuario WHERE '$valor_cargo'=usuario_ocupacion",$conn);
							if($fila_cargo=mysql_fetch_array($conexion2))
							{
							echo $fila_cargo["usuario_nombre"];
							}
						}

				echo "<br />".$departamento_de_destino;
			?>
			</td>
			<td width="15%" align="center">
			<?php echo $row_copia["correspondenciacopia_fecha_recibida"];?>
            </td>
			<td width="15%" align="center">
			<?php
			$instruccion = $row_copia["correspondenciacopia_codigo_instruccion"];
			$ssql_co = "SELECT * FROM instruccion WHERE '$instruccion'=instruccion_codigo_instruccion";
			$rss_co = mysql_query($ssql_co,$conn);
			while($row_co=mysql_fetch_array($rss_co))
				{
					$instrucion_com=$row_co["instruccion_instruccion"];
				}
			echo $instrucion_com; ?>
			</td>
			<?php
			if($row_copia["correspondenciacopia_estado"]=='P')
			{
				if ($row_copia["correspondenciacopia_tipo"]=='R')
					{
				      $estadito="Recibido";
					}
					else
					{
					    if ($row_copia["correspondenciacopia_tipo"]=='D')
							{
						      $estadito="Despachado";
						    }
							else
							{
							  if ($row_copia["correspondenciacopia_tipo"]=='A')
								  {
									$estadito="No Recibido";
								  }
							}
					}
			 ?>
			<td width="9%" align="center" colspan=1><?php echo $estadito;?>
			</td>
			<td width="9%" align="center" colspan=1>&nbsp;
			</td>
			<?php
			}
			else
			{
			?>
				<td width="9%" align="center" colspan=1><?php echo "Terminado";?>
				</td>
				<td width="9%" align="left" colspan=1>
				<?php echo "<b>Finalizacion:</b><br />".$row_copia["correspondenciacopia_fecha_salida"]."<br /><br /><b>Proveido:</b><br />".$row_copia["correspondenciacopia_descripcion_final"]."<br /><br /><b>Archivado en:</b><br />".$row_copia["correspondenciacopia_archivado"];?>
				</td>
			<?php
			}
			?>
			</tr>

	<?php
}
}	// fin while
} // end if empty
if ($aux == 1)
{
?>
<tr class="border_tr3"><td colspan="3"></td>
<td class="border_tr2" colspan="1" align="left"><span class="texto_normal">OR &nbsp;&nbsp;&nbsp; Fecha Finalizacion</td>
<td colspan="3" align="center"><span class="texto_normal"><?php echo $fecha_salida;?></td>
</tr>
<tr class="border_tr3"><td colspan="3"></td>
<td class="border_tr2" colspan="1" align="left"><span class="texto_normal">OR &nbsp;&nbsp;&nbsp; Proveido</td>
<td colspan="3" align="center"><span class="texto_normal"><?php echo $des_final;?></td>
</tr>
<tr class="border_tr3"><td colspan="3"></td>
<td class="border_tr2" colspan="1" align="left"><span class="texto_normal">OR &nbsp;&nbsp;&nbsp; Archivado en</td>
<td colspan="3" align="center"><span class="texto_normal"><?php echo $archivado_final;?></td>
</tr>
<?php
}
?>

<?php
}
?>
<?php
mysql_close($conn);
?>
<br /><br />
<?PHP 
} // Finalizacion de sentencia de validacion
?>
<center>
<table width="70%" cellspacing="2" cellpadding="2" border="0">
<tr class="border_tr">
<td width="95%" align="center">
<?php
$pagina_ori=$_SERVER['HTTP_REFERER'];
$posicion=strrpos($pagina_ori,"/");
$ir_pagina=substr($pagina_ori,$posicion+1);
$historia_en = $_GET['datos'];
?>
<br>
<form action="<?php echo $ir_pagina;?>" method="POST">
<div align="center">
<input type="submit" name="buscar" value="Retornar" class="boton" /></div>
</form>
</td>
</tr>
</table>
</center>
<?php
include("../final.php");
?>
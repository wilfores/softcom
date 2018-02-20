<?php
include("../filtro.php");
include("script/functions.inc");
include("script/cifrar.php");
include("../conecta.php");
?>

<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.0 Transitional//EN">
<html>
<head>
<title>Imprime Hoja de Ruta</title>
<script language="JavaScript">
 function imprimir() {
    window.print()
 }
</script>
</head>
<body bgcolor="white" onLoad="imprimir();">

<?php
$cod_institucion=$_SESSION["institucion"];
$nom_usuario=$_SESSION["codigo"];
$aux=0;
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
$codigo_historia = descryto($_GET['historia']);

$ssqlinterno = "SELECT * FROM instituciones WHERE '$cod_institucion'=instituciones_cod_institucion";
$rssinterno = mysql_query($ssqlinterno, $conn);
$rowinterno = mysql_fetch_array($rssinterno);
//logo y cabecera
$cabezainterno = $rowinterno["instituciones_membrete"];
?>
<center>
<?php
	echo "<font size=3 color=#000000>".$cabezainterno."</font>";
?>
</center>
<br>
<p class="fuente_titulo">
<center>
  <b>Flujo de Correspondencia</b>
</center></p>

<?php
$codigo_historia = descifrar($_GET['historia']);
$ssql2="SELECT * FROM ingreso
        WHERE ingreso_nro_registro='$codigo_historia' 
        AND '$cod_institucion'=ingreso_cod_institucion";
$rssn = mysql_query($ssql2,$conn);
if ($rowi = mysql_fetch_array($rssn))
{
?>
<center>
<table width="60%" cellspacing="1" cellpadding="1" border="1" style="FONT-FAMILY: Verdana; font-size:10px;border-collapse:collapse;">
<tr>
<td width="30%">Hoja Ruta
</td>
<td width="70%">
<?php
echo $rowi["ingreso_hoja_ruta"];
$hoja_ruta = $rowi["ingreso_hoja_ruta"];
?>
</td>
</tr>
<tr>
<td width="30%">Tipo
</td>
<td width="70%">
<?php
	
if ($rowi["ingreso_hoja_ruta_tipo"]=='e')
{
echo "Externo";
}
else
{
echo "Interno";
}
?>
</td>
</tr>
<tr>
<td width="30%">Fecha de Ingreso
</td>
<td width="70%">
<?php echo $rowi["ingreso_fecha_ingreso"]." ".$rowi["ingreso_hora_ingreso"]; ?>
</td>
</tr>
<tr>
<td width="30%">Cite:
</td>
<td width="70%">
<?php echo $rowi["ingreso_numero_cite"]; ?>
</td>
</tr>
<tr>
<td width="30%">Tipo Doc</td>
<td width="70%">
<?php echo $rowi["ingreso_descripcion_clase_corresp"]; ?>
</td>
</tr>

<tr>
<td width="30%">Remitente</td>
<td width="70%">
<?php
 $guardar_tipo_hoja=$rowi["ingreso_hoja_ruta_tipo"];
    if($rowi["ingreso_hoja_ruta_tipo"]=='i')
    {
       	$valor_clave=$rowi["ingreso_remitente"]; 
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
		
    }
    else
    {
    echo $rowi["ingreso_remitente"]; 
    }	
    ?>
</td>
</tr>
<tr>
<td width="30%">Cargo Remitente</td>
<td width="70%">
<?php
    if($rowi["ingreso_hoja_ruta_tipo"]=='i')
    {
        $valor_clave=$rowi["ingreso_cargo_remitente"];
        $conexion = mysql_query("SELECT * FROM cargos WHERE '$valor_clave'=cargos_id",$conn);
        if($fila_clave=mysql_fetch_array($conexion))
        {
        echo $fila_clave["cargos_cargo"];
        } 
    }
    else
    { echo $rowi["ingreso_cargo_remitente"];
      $cargo_externo=$rowi["ingreso_cargo_remitente"];    	
	}	
    ?>
</td>
</tr>

<tr>
<td width="30%">Referencia</td>
<td width="70%">
<?php echo $rowi["ingreso_referencia"]; ?>
</td>
</tr>

<tr>
<td width="30%">Cantidad Hojas</td>
<td width="70%">
<?php echo $rowi["ingreso_cantidad_hojas"]; ?>
</td>
</tr>

<tr>
<td width="30%">Numero Anexos</td>
<td width="70%">
<?php echo $rowi["ingreso_nro_anexos"]; ?>
</td>
</tr>

<tr>
<td width="30%">Tipo Anexos</td>
<td width="70%">
<?php echo $rowi["ingreso_tipo_anexos"]; ?>
</td>
</tr>

</table>
</center>
<br>
<center>
<table width="100%" cellspacing="1" cellpadding="1" border="1" style="FONT-FAMILY: Verdana; font-size:10px;border-collapse:collapse;">
<tr>
<td width="3%" align="center">Tipo</td>
<td width="10%" align="center">Remitente</td>
<td width="10%" align="center">Fecha de Derivacion</td>
<td width="10%" align="center">Destinatario</td>
<td width="10%" align="center">Fecha de Recepcion</td>
<td width="15%" align="center">Instruccion</td>
<td width="10%" align="center">Estado</td>
<td width="30%" align="center">Observaciones</td>
</tr>
<?php
}
$ssql="select * from ingreso, seguimiento where ingreso.ingreso_nro_registro='$codigo_historia' and ingreso.ingreso_nro_registro=seguimiento.seguimiento_nro_registro and '$cod_institucion'=ingreso.ingreso_cod_institucion and ingreso.ingreso_cod_institucion=seguimiento.seguimiento_cod_institucion order by seguimiento.seguimiento_fecha_deriva ASC";
$respi=mysql_query($ssql,$conn);

if (!empty($respi)) 
{
while($row=mysql_fetch_array($respi))
{
?>
<tr>
<?php
  $depart = $row["seguimiento_cod_departamento"];
  $ssqlnew = "SELECT * FROM departamento WHERE '$depart'=departamento_cod_departamento";
  $rssnew = mysql_query($ssqlnew,$conn);
  if ($rownew = mysql_fetch_array($rssnew))
  {
  	$departamento_de_destino=$rownew["departamento_descripcion_dep"];
  }
 mysql_free_result($rssnew);
?>
<?php
  $ssqlnew = "SELECT * FROM departamento WHERE '$row[seguimiento_dpto_remite]'=departamento_cod_departamento";
  $rssnew = mysql_query($ssqlnew,$conn);
  if($rownew = mysql_fetch_array($rssnew))
  {
  	$departamento_de_origen=$rownew["departamento_descripcion_dep"];
  }
   mysql_free_result($rssnew);
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
	echo $row["seguimiento_remitente"]."<br>".$cargo_externo;
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
				echo "<br>".$fila_clave["cargos_cargo"];
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
				echo "<br>".$fila_clave["cargos_cargo"];
				}
			}
}	

	?>
</td>
<td width="15%" align="center"><?php echo $row["seguimiento_fecha_deriva"];?></td>
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
	  	echo "<br>".$departamento_de_destino;
	?>
</td>
<td width="15%" align="center"><?php echo $row["seguimiento_fecha_recibida"];?></td>
<td width="15%" align="center">
<?php
$instruccion = $row["seguimiento_codigo_instruccion"];
$ssql44 = "SELECT * FROM instruccion WHERE '$instruccion'=instruccion_codigo_instruccion";
$rss44 = mysql_query($ssql44,$conn);
while($row44=mysql_fetch_array($rss44)){
$instrucion_com=$row44["instruccion_instruccion"];
}
mysql_free_result($rss44);

echo $instrucion_com; ?></td>
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
<td width="15%"align="right"><?php echo $row["seguimiento_observaciones"];?>
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
  <td width="15%"align="right"><?php echo $row["seguimiento_observaciones"];?>
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
		 mysql_free_result($rssnew);
		?>
		<?php
	  	  $ssqlnew = "SELECT * FROM departamento WHERE '$row_copia[correspondenciacopia_dpto_remite]'=departamento_cod_departamento";
		  $rssnew = mysql_query($ssqlnew,$conn);
		  if($rownew = mysql_fetch_array($rssnew))
			  {
		  			$departamento_de_origen=$rownew["departamento_descripcion_dep"];
			  }
		   mysql_free_result($rssnew);
		?>
			<td width="3%" align="center">
			   CC
			</td>
			<td width="15%" align="left">
			<?php
						$valor_clave=$row["seguimiento_remitente"];
			$conexion = mysql_query("SELECT * FROM cargos WHERE '$valor_clave'=cargos_id",$conn);
			if($fila_clave=mysql_fetch_array($conexion))
			{
				$valor_cargo=$fila_clave["cargos_id"];
				$conexion2 = mysql_query("SELECT * FROM usuario WHERE '$valor_cargo'=usuario_ocupacion",$conn);
				if($fila_cargo=mysql_fetch_array($conexion2))
				{
				echo $fila_cargo["usuario_nombre"];
				echo "<br>".$fila_clave["cargos_cargo"];
				}
			}		
				
			?>
			</td>
			<td width="15%" align="center"><?php echo $row_copia["correspondenciacopia_fecha_deriva"];?></td>
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
				echo "<br>".$departamento_de_destino;
			?>
			</td>
			<td width="15%" align="center"><?php echo $row_copia["correspondenciacopia_fecha_recibida"];?></td>
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
				<?php echo "<b>Finalizacion:</b><br>".$row_copia["correspondenciacopia_fecha_salida"]."<br><br><b>Proveido:</b><br>".$row_copia["correspondenciacopia_descripcion_final"]."<br><br><b>Archivado en:</b><br>".$row_copia["correspondenciacopia_archivado"];?>
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
<tr><td colspan="3"></td>
<td colspan="1" align="left"><span class="texto_normal">OR &nbsp;&nbsp;&nbsp; Fecha Finalizacion</td>
<td colspan="3" align="center"><span class="texto_normal"><?php echo $fecha_salida;?></td>
</tr>
<tr><td colspan="3"></td>
<td colspan="1" align="left"><span class="texto_normal">OR &nbsp;&nbsp;&nbsp; Proveido</td>
<td colspan="3" align="center"><span class="texto_normal"><?php echo $des_final;?></td>
</tr>
<tr><td colspan="3"></td>
<td colspan="1" align="left"><span class="texto_normal">OR &nbsp;&nbsp;&nbsp; Archivado en</td>
<td colspan="3" align="center"><span class="texto_normal"><?php echo $archivado_final;?></td>
</tr>
<?php    
}
?>
</table>
</center>
<?php
mysql_free_result($rssn);
mysql_free_result($respi);
?>


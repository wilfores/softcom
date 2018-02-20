<?php
include("../filtro.php");
?>
<?php
//include("inicio.php");
?>
<?php
include("script/functions.inc");
include("script/cifrar.php");
include("../conecta.php");
$codigo_historia = descifrar($_GET['historia']);
$cod_institucion=$_SESSION["institucion"];
$cargo_unico=$_SESSION["cargo_asignado"];
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

$aux=0;
?>
 <br />
<p class="fuente_titulo"><span class="fuente_normal">
<center>
  <b>FLUJO DE CORRESPONDENCIA</b>
</center></p>

<?php
$ssql2="select * from ingreso where ingreso_nro_registro='$codigo_historia' and '$cod_institucion'=ingreso_cod_institucion";
$rssn = mysql_query($ssql2,$conn);
$rowi = mysql_fetch_array($rssn);
?>
<center>
<table width="60%" cellspacing="1" cellpadding="1" border="0" style="font-size: 8pt;">
    <tr class="border_tr3" style="font-size: 8pt;" bgcolor="#BCCFEF">
    <td width="30%"><span class="fuente_normal">Hoja Ruta</span></td>
    <td width="70%">
        <span class="fuente_normal">
    <?php
	echo $rowi["ingreso_hoja_ruta"];
    $hoja_ruta = $rowi["ingreso_hoja_ruta"];
    ?>
        </span>
    </td>
    </tr>

    <tr class="border_tr3">
    <td width="30%"><span class="fuente_normal">Tipo</span></td>
    <td width="70%">
        <span class="fuente_normal">
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
        </span>
    </td>
    </tr>

    <tr class="border_tr3">
    <td width="30%"><span class="fuente_normal">Fecha de Ingreso</td>
    <td width="70%"><span class="fuente_normal">
    <?php echo $rowi["ingreso_fecha_ingreso"]." ".$rowi["ingreso_hora_ingreso"]; 
	?>
    </td>
    </tr>
    
    <tr class="border_tr3">
    <td width="30%"><span class="fuente_normal">Cite:</td>
    <td width="70%"><span class="fuente_normal">
    <?php echo $rowi["ingreso_numero_cite"]; ?>
    </td>
    </tr>

    <tr class="border_tr3">
    <td width="30%"><span class="fuente_normal">Tipo Doc</td>
    <td width="70%"><span class="fuente_normal">
    <?php echo $rowi["ingreso_descripcion_clase_corresp"]; ?>
    </td>
    </tr>

    <tr class="border_tr3">
    <td width="30%"><span class="fuente_normal">Remitente</td>
    <td width="70%"><span class="fuente_normal">
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
    
    <tr class="border_tr3">
    <td width="30%"><span class="fuente_normal">Cargo Remitente</td>
    <td width="70%"><span class="fuente_normal">
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
    
    <tr class="border_tr3">
    <td width="30%"><span class="fuente_normal">Referencia</td>
    <td width="70%"><span class="fuente_normal">
    <?php echo $rowi["ingreso_referencia"]; ?>
    </td>
    </tr>

    <tr class="border_tr3">
    <td width="30%"><span class="fuente_normal">Cantidad Hojas</td>
    <td width="70%"><span class="fuente_normal">
    <?php echo $rowi["ingreso_cantidad_hojas"]; ?>
    </td>
    </tr>

    <tr class="border_tr3">
    <td width="30%"><span class="fuente_normal">Numero Anexos</td>
    <td width="70%"><span class="fuente_normal">
    <?php echo $rowi["ingreso_nro_anexos"]; ?>
    </td>
    </tr>
    
    <tr class="border_tr3">
    <td width="30%"><span class="fuente_normal">Tipo Anexos</td>
    <td width="70%"><span class="fuente_normal">
    <?php echo $rowi["ingreso_tipo_anexos"]; ?>
    </td>
    </tr>
    
    <?php 
    if($rowi["ingreso_adjunto_correspondencia"]!="")
     {
	?>
    <tr class="border_tr3">
    <td width="30%"><span class="fuente_normal">Documento Adjunto</td>
    <td width="70%"><span class="fuente_normal">
    <a href="<?php echo $rowi["ingreso_adjunto_correspondencia"];?>" target="_blank"><b>[Ver Adjunto]</b></a>
    <?php
    }
    ?>
    </td>
    </tr>

</table>
</center>

<br />

<center>
<table width="100%" cellspacing="1" cellpadding="1" border="0" style="font-size: 8pt;">
<tr class="border_tr2" style="font-size: 8pt;" bgcolor="#BCCFEF">
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
       WHERE ingreso.ingreso_nro_registro='$codigo_historia' 
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
<tr>
<td colspan="10">
<?php
$pagina_ori=$_SERVER['HTTP_REFERER'];
$posicion=strrpos($pagina_ori,"/");
$ir_pagina=substr($pagina_ori,$posicion+1);
$historia_en = cifrar($codigo_historia);
?>
<br />

<form action="<?php echo $ir_pagina."?busqueda=".$_GET[busqueda]."&&clase=".$_GET[clase];?>" method="POST">
    <div align="center">
        <input type="reset" name="imprimir" value="Imprimir" class="boton" onClick="JavaScript:window.open('imprime_historia.php?historia=<?php echo $_GET['historia'];?>')" >
        <input type="submit" name="buscar" value="Retornar" class="boton" />
    </div>
</form>
<br />
</td>
</tr>

</table>
</center>

<?php
//mysql_close();
include("final.php");
?>

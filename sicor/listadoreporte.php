<?php include("../filtro.php");
?>
<?php
include("inicio.php");
?>
<?php
include("script/functions.inc");
include("../conecta.php");
include("script/cifrar.php");
?>
<script language="JavaScript">
function Imprimir()
	{
	   document.impresion.action="vereporte.php";
	   document.impresion.target="_blank";
	   document.impresion.submit();
	}
function Retornar()
	{
   document.impresion.action="reportes.php";
   document.impresion.target="_self";
   document.impresion.submit();
}
</script>

<?php
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

$ssqlinterno = "SELECT * FROM instituciones WHERE '$cod_institucion'=instituciones_cod_institucion";
$rssinterno = mysql_query($ssqlinterno, $conn);
$rowinterno = mysql_fetch_array($rssinterno);

//logo y cabecera
$logointerno = $rowinterno["instituciones_logo"];
$cabezainterno = $rowinterno["instituciones_membrete"];
?>
<?php
$var_sw=0;
if(!empty($_POST['fechaini']) && !empty($_POST['fechafin']))
{
    $fechaini=$_POST['fechaini'];
    $fechafin=$_POST['fechafin'];
    if ($fechaini<=$fechafin)
    {
        $var_sw=1;
    }
	
}

switch ($_POST['clase'])
{
	case 'por_pendientes':
							$consul="select * from seguimiento where '$cod_institucion'=seguimiento_cod_institucion AND seguimiento_tipo <> 'D' and seguimiento_estado='P'";
							if ($var_sw==1)
								{ 
									$consul .="AND  DATE(seguimiento_fecha_deriva) >= '$fechaini' AND DATE(seguimiento_fecha_deriva) <= '$fechafin'";
								}
							$mititulo="CORRESPONDENCIA PENDIENTE";
	break;
	case 'por_terminados': 
							$consul="select * from seguimiento where '$cod_institucion'=seguimiento_cod_institucion AND seguimiento_estado='T'";
							if ($var_sw==1)
								{ 
								   $consul .="AND  DATE(seguimiento_fecha_deriva) >= '$fechaini' AND DATE(seguimiento_fecha_deriva) <= '$fechafin'";
								}
							$mititulo="CORRESPONDENCIA TERMINADA";
	 break;
	 case 'por_funcionariop':
            if ($_POST['revisar']=='%' OR $_POST['revisar']=='')
			{
			$consul="select * from seguimiento where seguimiento_destinatario LIKE '%$_POST[revisar]%' AND '$cod_institucion'=seguimiento_cod_institucion AND seguimiento_tipo <> 'D' AND seguimiento_estado='P'";
							if ($var_sw==1)
								{ 
								   $consul .="AND  DATE(seguimiento_fecha_deriva) >= '$fechaini' AND DATE(seguimiento_fecha_deriva) <= '$fechafin'";
								}
							$mititulo="FUNCIONARIO CON CORRESPONDENCIA PENDIENTE";
			}
			else
			{
			$conexion = mysql_query("SELECT * FROM usuario WHERE usuario_nombre LIKE '%$_POST[revisar]%' AND usuario_active='1'",$conn);
			if($fila_clave=mysql_fetch_array($conexion))
			{
			$busqueda1=$fila_clave["usuario_ocupacion"];
			}
			$consul="select * from seguimiento where seguimiento_destinatario='$busqueda1' AND '$cod_institucion'=seguimiento_cod_institucion AND seguimiento_tipo <> 'D' AND seguimiento_estado='P'";
							if ($var_sw==1)
								{ 
								   $consul .="AND  DATE(seguimiento_fecha_deriva) >= '$fechaini' AND DATE(seguimiento_fecha_deriva) <= '$fechafin'";
								}
							$mititulo="FUNCIONARIO CON CORRESPONDENCIA PENDIENTE";
			}  	        
	 
	 break;
	 case 'por_funcionariot':
	        if ($_POST['revisar']=='%' OR $_POST['revisar']=='')
			{
			$consul="select * from seguimiento where seguimiento_destinatario LIKE '%$_POST[revisar]%' AND '$cod_institucion'=seguimiento_cod_institucion AND seguimiento_estado='T'";
							if ($var_sw==1)
								{ 
								   $consul .="AND  DATE(seguimiento_fecha_deriva) >= '$fechaini' AND DATE(seguimiento_fecha_deriva) <= '$fechafin'";
								}
							$mititulo="FUNCIONARIO CON CORRESPONDENCIA TERMINADA";
			}
			else
			{
			$conexion = mysql_query("SELECT * FROM usuario WHERE usuario_nombre LIKE '%$_POST[revisar]%' AND usuario_active='1'",$conn);
			if($fila_clave=mysql_fetch_array($conexion))
			{
			$busqueda1=$fila_clave["usuario_ocupacion"];
			}  
							$consul="select * from seguimiento where seguimiento_destinatario='$busqueda1' AND '$cod_institucion'=seguimiento_cod_institucion AND seguimiento_estado='T'";
							if ($var_sw==1)
								{ 
								   $consul .="AND  DATE(seguimiento_fecha_deriva) >= '$fechaini' AND DATE(seguimiento_fecha_deriva) <= '$fechafin'";
								}
							$mititulo="FUNCIONARIO CON CORRESPONDENCIA TERMINADA";
			} 
	       
	 break;
	 case 'por_departamentop': 
							$consul="select *
									 from
									 seguimiento INNER JOIN departamento ON seguimiento.seguimiento_cod_departamento=departamento.departamento_cod_departamento
									 AND '$cod_institucion'=seguimiento.seguimiento_cod_institucion
									 AND seguimiento.seguimiento_tipo <> 'D'
									 AND seguimiento.seguimiento_estado='P'
									 where departamento.departamento_descripcion_dep LIKE '%$_POST[revisar]%'";
							if ($var_sw==1)
								{ 
								   $consul .="AND  DATE(seguimiento_fecha_deriva) >= '$fechaini' AND DATE(seguimiento_fecha_deriva) <= '$fechafin'";
								}
							$mititulo="DEPARTAMENTEO CON CORRESPONDENCIA PENDIENTE";
	 break;
	case 'por_departamentot': 
							$consul="select * 
									from
									seguimiento INNER JOIN departamento ON seguimiento.seguimiento_cod_departamento=departamento.departamento_cod_departamento
									AND '$cod_institucion'=seguimiento.seguimiento_cod_institucion
									AND seguimiento.seguimiento_estado='T'
									where  departamento.departamento_descripcion_dep LIKE '%$_POST[revisar]%'";
							if ($var_sw==1)
								{ 
								   $consul .="AND  DATE(seguimiento_fecha_deriva) >= '$fechaini' AND DATE(seguimiento_fecha_deriva) <= '$fechafin'";
								}
							$mititulo="DEPARTAMENTEO CON CORRESPONDENCIA TERMINADA";
	 break;
	 case 'por_eremitente': 
							$consul="select *
									 from seguimiento INNER JOIN ingreso ON ingreso.ingreso_nro_registro=seguimiento.seguimiento_nro_registro
									 AND '$cod_institucion'=ingreso.ingreso_cod_institucion
									 AND '$cod_institucion'=seguimiento.seguimiento_cod_institucion
									 AND seguimiento.seguimiento_dpto_remite='0'
									 AND ingreso.ingreso_hoja_ruta_tipo='e'
									 where ingreso.ingreso_entidad_remite LIKE '%$_POST[revisar]%'";
							if ($var_sw==1)
								{ 
								   $consul .="AND  DATE(ingreso.ingreso_fecha_ingreso) >= '$fechaini' AND DATE(ingreso.ingreso_fecha_ingreso) <= '$fechafin'";
								}
							$mititulo="ENTIDAD REMITENTE";


	  break;
	  case 'por_premitente':
	                        
								$conexion = mysql_query("SELECT * FROM usuario WHERE usuario_nombre LIKE '%$_POST[revisar]%' AND usuario_active='1'",$conn);
								if($fila_clave=mysql_fetch_array($conexion))
								{
								$busqueda1=$fila_clave["usuario_ocupacion"];
								$consul="select *
									 from seguimiento INNER JOIN ingreso ON ingreso.ingreso_nro_registro=seguimiento.seguimiento_nro_registro
									 AND '$cod_institucion'=ingreso.ingreso_cod_institucion
									 AND '$cod_institucion'=seguimiento.seguimiento_cod_institucion
									 AND seguimiento.seguimiento_dpto_remite='0'
									 where ingreso.ingreso_remitente='$busqueda1' OR ingreso.ingreso_remitente LIKE '%$_POST[revisar]%'";
									 if ($var_sw==1)
									{ 
									   $consul .="AND  DATE(ingreso.ingreso_fecha_ingreso) >= '$fechaini' AND DATE(ingreso.ingreso_fecha_ingreso) <= '$fechafin'";
									}
										$mititulo="REMITENTE";
								}
								else
								{
								$consul="select *
									 from seguimiento INNER JOIN ingreso ON ingreso.ingreso_nro_registro=seguimiento.seguimiento_nro_registro
									 AND '$cod_institucion'=ingreso.ingreso_cod_institucion
									 AND '$cod_institucion'=seguimiento.seguimiento_cod_institucion
									 AND seguimiento.seguimiento_dpto_remite='0'
									 where ingreso.ingreso_remitente LIKE '%$_POST[revisar]%'";
									if ($var_sw==1)
										{ 
										   $consul .="AND  DATE(ingreso.ingreso_fecha_ingreso) >= '$fechaini' AND DATE(ingreso.ingreso_fecha_ingreso) <= '$fechafin'";
										}
									$mititulo="REMITENTE";
								}
																				
	   break;
	   case 'por_ingreso': 
							$consul ="select *
							from seguimiento a INNER JOIN ingreso b ON b.ingreso_nro_registro=a.seguimiento_nro_registro
							INNER JOIN usuario c ON b.ingreso_cod_usr=c.usuario_ocupacion
							AND '$cod_institucion'=b.ingreso_cod_institucion 
							AND '$cod_institucion'=a.seguimiento_cod_institucion  
							AND a.seguimiento_dpto_remite='0' where c.usuario_nombre LIKE '%$_POST[revisar]%'";
							 if ($var_sw==1)
								{ 
								 $consul .="AND  b.ingreso_fecha_ingreso >= '$fechaini' AND b.ingreso_fecha_ingreso <= '$fechafin'";
								}
							$mititulo="INGRESO DE CORRESPONDENCIA";
		break;
}
?>
<br>
<br>

<font size="2" color="#000000"><center><b>REPORTE SEG&Uacute;N <?php echo $mititulo;?></b></center></p></center></font>
<table width="100%" cellspacing="1" cellpadding="1" border="0">
<tr class="border_tr2">
    <td align="center" class="border_table_imp"><b>Nro Registro</b></td>
    <td align="center" class="border_table_imp"><b>Hoja de Ruta</b></td>
    <td align="center" class="border_table_imp"><b>Tipo</b></td>
    <td align="center" class="border_table_imp"><b>Remitente/<br>Entidad</b></td>
	<td align="center" class="border_table_imp"><b>Referencia</b></td>
	<td align="center" class="border_table_imp">
	<?php
	if ($_POST['clase'] == 'por_ingreso')
	{
	  echo "<b>Destinatario/<br>Departamento</b>";
	}
	else
	{
		if ($_POST['clase'] == 'por_destinatario_original')
		{
			echo "<b>Dirigido a /<br>Departamento</b>";
		}
		else
		{
			echo "<b>Funcionario Actual/<br>Departamento</b>";
		}
		
	}
	?>
	</td>
		<?php
	if ($_POST['clase'] == 'por_ingreso')
	{
		  echo "<td align=center class=border_table_imp><b>Fecha Ingreso</td><td align=center class=border_table_imp><b>Cite</td><td align=center class=border_table_imp><b>Fecha_Cite</td>";
	  
	}
	else
	{
		if ($_POST['clase']=='por_destinatario_original')
		{
		  echo "<td align=center class=border_table_imp><b>Fecha Ingreso</td><td align=center class=border_table_imp><b>Cite</td><td align=center class=border_table_imp><b>Fecha_Cite</td>";
	  	}
		else
		{
		  echo "<td align=center class=border_table_imp><b>Fecha Derivacion</td><td align=center class=border_table_imp><b>Fecha De Recepcion</td><td align=center class=border_table_imp><b>Estado</td>";	
		}

	}
	?>
    
  </tr>
<?php
$resaltador=0;
$respuestauno=mysql_query($consul,$conn);
while ($rowas=mysql_fetch_array($respuestauno))
{
  $ssql11="select * from ingreso where ingreso.ingreso_nro_registro='$rowas[seguimiento_nro_registro]' AND '$cod_institucion'=ingreso.ingreso_cod_institucion";
 $respuestamas=mysql_query($ssql11,$conn);
if($rowamas=mysql_fetch_array($respuestamas))
{
	if ($rowamas["ingreso_hoja_ruta_tipo"] == 'i')
		{
		 $tipito="Interno"; 
		 $respuestados=mysql_query("select * from departamento where departamento_cod_departamento='$rowas[seguimiento_cod_departamento]'",$conn);
		if ($rowdos=mysql_fetch_array($respuestados))
			{ 
		   		$nombresitouno=$rowdos["departamento_descripcion_dep"];
			}
         }
        else
           { 
             $tipito="Externo";
			}
  ?>
  <?php 
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
	$historia = cifrar($rowas["seguimiento_nro_registro"]);
  ?>
      <td align="center" class="border_table_imp"><?php echo $rowamas["ingreso_nro_registro"]; ?></td>
    <td align="left" class="border_table_imp"><a href="imprime_historia.php?historia=<?php echo $historia;?>" target="_blank" class="enlace_normal">
	<?php echo $rowas["seguimiento_hoja_ruta"]; ?></a>
    </td>
    <td align="center" class="border_table_imp"><?php echo $tipito; ?>
    </td>
    <td align="left" class="border_table_imp">
	<?php 
	if($rowamas["ingreso_hoja_ruta_tipo"]=='i')
    {
      	$valor_clave=$rowamas["ingreso_remitente"];
		$conexion = mysql_query("SELECT * FROM cargos WHERE '$valor_clave'=cargos_id",$conn);
		if($fila_clave=mysql_fetch_array($conexion))
		{
			$valor_cargo=$fila_clave["cargos_id"];
			$carguillo=$fila_clave["cargos_cargo"];
			$conexion2 = mysql_query("SELECT * FROM usuario WHERE '$valor_cargo'=usuario_ocupacion",$conn);
			if($fila_cargo=mysql_fetch_array($conexion2))
			{
			echo $fila_cargo["usuario_nombre"]."<br>".$carguillo;
			}
		}
	}
		else
		{
		echo $rowamas["ingreso_remitente"];
		echo "<br>".$rowamas["ingreso_entidad_remite"];
		}	 
    ?>
	</td>
    <td align="left" class="border_table_imp"><?php echo $rowamas["ingreso_referencia"];  ?></td>
	<?php
	if ($_POST['clase']=='por_destinatario_original')
		{
		?>
			<td align="center" class="border_table_imp"><?php echo $rowas["seguimiento_destinatario_principal"];  ?>
		<?php
		}
		else
		{
		?>
			<td align="center" class="border_table_imp">
		<?php 
		$valor_clave=$rowas["seguimiento_destinatario"];
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
		?>
		
		<?php
		}
		?>

	<?php 
    if ($_POST['clase']=='por_destinatario_original')
		{
			$respuestatres=mysql_query("select a.Descripcion_dep from departamento a, usuario b where b.Nombre='$rowas[seguimiento_destinatario_principal]' AND b.usuario_cod_departamento=a.departamento_cod_departamento",$conn);
		}
		else
		{
			$respuestatres=mysql_query("select * from departamento where departamento_cod_departamento='$rowas[seguimiento_cod_departamento]'",$conn);
		}
	if ($rowtres=mysql_fetch_array($respuestatres))
		{ 
		   $nombresitouno=$rowtres["departamento_descripcion_dep"];
		}
	echo "<br>".$nombresitouno;
	?>
	</td>
	<?php
	if ($_POST['clase'] =='por_ingreso')
	{
	?>
		<td align="center" class="border_table_imp"><?php echo $rowas["ingreso_fecha_ingreso"];?></td>
		<td align="center" class="border_table_imp"><?php echo $rowas["ingreso_numero_cite"];?></td>
		<td align="center" class="border_table_imp"><?php echo $rowas["ingreso_fecha_cite"];?></td>
	<?php  
	}
	else
	{
		if ($_POST['clase']=='por_destinatario_original')
		{
		?>
			<td align="center" class="border_table_imp"><?php echo $rowas["ingreso_fecha_ingreso"]."<br>".$rowas["ingreso_hora_ingreso"];?></td>
			<td align="center" class="border_table_imp"><?php echo $rowas["ingreso_numero_cite"];?></td>
			<td align="center" class="border_table_imp"><?php echo $rowas["ingreso_fecha_cite"];?></td>

		<?php 
	  	}
		else
		{
			if ($_POST['clase']=='por_premitente')
			{
			?>
			<td align="center" class="border_table_imp"><?php echo $rowas["seguimiento_fecha_deriva"];?></td>
			<td align="center" class="border_table_imp"><?php echo $rowas["seguimiento_fecha_recibida"];?></td>
            <?php
                $var=$rowamas["ingreso_nro_registro"]; 			
				$estados = mysql_query("select *
				from seguimiento where seguimiento_nro_registro='$var'
			    AND '$cod_institucion'=seguimiento.seguimiento_cod_institucion ORDER BY seguimiento_estado DESC LIMIT 1",$conn);
					if($sacaestado=mysql_fetch_array($estados))
					{
					$estado_final=$sacaestado["seguimiento_estado"];
					}
				
			?>
            <td align="center" class="border_table_imp">
				<?php
                if ($estado_final=='P')
                { echo "Pendiente";
                }
                else
                {echo "Terminado";
                }
                ?>
            </td>
			<?php
			}
	       else
		    {
		?>
			<td align="center" class="border_table_imp"><?php echo $rowas["seguimiento_fecha_deriva"];?></td>
			<td align="center" class="border_table_imp"><?php echo $rowas["seguimiento_fecha_recibida"];?></td>
			<td align="center" class="border_table_imp">

		<?php
	           if($rowas["seguimiento_estado"]=='P')
			   {echo "Pendiente";}
			   else
			   {echo "Terminado";}
		     }
		}	 
	?>
	</td>

	 <?php 
	}
	?>
  </tr>
<?php
} 
} 
?>
</table>
<center>
<form method="POST" name="impresion">
<input type="hidden" name="fechaini" value="<?php echo $fechaini;?>">
<input type="hidden" name="fechafin" value="<?php echo $fechafin;?>">
<input type="hidden" name="revisar" value="<?php echo $_POST['revisar'];?>">
<input type="hidden" name="clase" value="<?php echo $_POST['clase'];?>">
<br><br>
<input type="reset" name="imprimir" value="Imprimir" class="boton" onClick="Imprimir();"/>
<input type="reset" name="cancelar" value="Cancelar" class="boton" onClick="Retornar();" />
<br><br>
</form>
</center>
</body>
</html>


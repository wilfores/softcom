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
<link href="script/estilos2.css" rel="stylesheet" type="text/css" />
<center>
<br /> 
 <?
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

$hruta=descifrar($_GET['hr1']);
$ext=0;
if($_GET['ext']){
$ext = 1;
}
echo "$hruta";
	
	$s_hr="select * from registrodoc1 where registrodoc1_hoja_ruta like '%$hruta%' AND registrodoc1_asociar!='si'";
	$r_hr = mysql_query($s_hr, $conn);
	$row_dep=mysql_fetch_array($r_hr);

if($row_dep['registrodoc1_situacion']=='D' || $row_dep['registrodoc1_situacion']=='P')
{
	if ($ext==0){
	$s_rm="select
			u.usuario_nombre, c.cargos_cargo
			from 
			usuario u,
			cargos c
			where
			u.usuario_ocupacion='$row_dep[registrodoc1_de]'
			and
			u.usuario_ocupacion=c.cargos_id";
	}else{
	$s_rm="select
			usuarioexterno_nombre, usuarioexterno_cargo
			from 
			usuarioexterno
			where
			usuarioexterno_codigo='$row_dep[registrodoc1_de]'";
		$ext=0;	

	}
	$r_rm = mysql_query($s_rm, $conn);
	$row_rm=mysql_fetch_array($r_rm);
	$nom_rm=$row_rm[0];
	$cargo_rm=$row_rm[1];
	
		$s_de="select
			u.usuario_nombre, c.cargos_cargo
			from 
			usuario u,
			cargos c
			where
			u.usuario_ocupacion='$row_dep[registrodoc1_para]'
			and
			u.usuario_ocupacion=c.cargos_id";
	
	$r_de = mysql_query($s_de, $conn);
	$row_de=mysql_fetch_array($r_de);
	$nom_de=$row_de[0];
	$cargo_de=$row_de[1];
?>
<table width="80%">
    <tr style="font-size: 8pt; color:#FFFFFF" bgcolor="#3E6BA3">
		<td><b>SEGUIMIENTO DE CORRESPONDENCIA HOJA DE RUTA Nro: <? echo "$hruta";?></b></td>
	</tr>
    <tr>
		<td>
		  <table width="100%" style="font-size: 8pt; color:#FFFFFF">
			  <tr class="truno">
				  <td colspan="2">REFERENCIA: <i><b><? echo "$row_dep[registrodoc1_referencia]"; ?></b></i></td>	
			  </tr>
			  <tr class="truno">
				  <td width="50%">Fecha de Elaboracion: <b><? echo "$row_dep[registrodoc1_fecha_elaboracion]"; ?></b></td>
				  <td width="50%" align="right">Fecha Limite: <b>NINGUNA</b>&nbsp;</td>
			  </tr>
			  <tr class="truno">
				  <td colspan="2">Estado: <? if($row_dep['registrodoc1_situacion']=='D'){ echo "<b>DOCUMENTO DERIVADO</b>";} 
				  if($row_dep['registrodoc1_situacion']=='P'){ echo "<b style=color:#990000>DOCUMENTO NO RECEPCIONADO</b>"; }?></td>	
			  </tr>
		  </table>
     	</td>
	 </tr>
    
	<tr>
	<td>
		<table width="100%" style="border: solid 1px #000000;" bgcolor="#FFFFFF" border="1">
			<tr>
				<td style="font-size: 7pt;">REMITE</td>
				<td style="font-size: 7pt;" align="right">[]</td>		
				<td colspan="2" style="font-size: 7pt;">DESTINO</td>
				<td style="font-size: 7pt;" align="right">[]</td>
			</tr>
			<tr>
				<td width="44%" style="font-size:10px"><strong><? echo "$nom_rm"; ?></strong>
					<br /><? echo "$cargo_rm"; ?>	
				</td>
				
				<td width="5%"><img border="0" src="images/ir.png" alt="" /></td>		
				
				<td width="32%" style="font-size:10px"><strong><? echo "$nom_de"; ?></strong>
					<br /><? echo "$cargo_de"; ?>
				</td>
				<td width="12%" valign="top"></td>
				<td width="7%">
				<?php if($row_dep['registrodoc1_estado']=='SR')
						{
						?><img border="0" src="images/negativo.png" alt="" />
						<?php
						}
						else
						{
						?><img border="0" src="images/ok.png" alt="" />
						<?php
						}
				
				?>				
				</td>
			</tr>
			<tr>		
				<td colspan="2" style="font-size: 7pt;">Fecha y Hora de Derivacin: <b><? echo "$row_dep[registrodoc1_fecha_elaboracion]"; ?></b></td>
				<td colspan="2" style="font-size: 7pt;">Fecha y Hora de Recepcin: <b><? echo "$row_dep[registrodoc1_fecha_recepcion]"; ?></b></td>
				<td style="font-size: 7pt;" align="right">
				<? $f1=$row_dep['registrodoc1_fecha_elaboracion'];
				   $f2=$row_dep['registrodoc1_fecha_recepcion'];  
				   $fch1=DiferenciaEntreFechas($f1, $f2, $f3);
				   
				   //$fch=tiempo_resta($f1, $f2);		
				   if($fch1>=3600){ $fch1=floor($fch1/3600); echo "$fch1 Hor";}
				   else {$fch1=floor($fch1/60); echo "$fch1 Min";}   
				?>&nbsp;
				</td>
			</tr>
			<tr>
				<td colspan="5">
		
					<table width="100%" style="font-size: 7pt;" cellpadding="0" cellspacing="0">
						<tr>
							<td width="25%">Plazo: <b></b></td>
							<td width="25%">Prioridad: <b><span style="color: #000000">NORMAL</span></b></td>
							<td width="25%">&nbsp;Requiere Respuesta: <b>SI</b></td>
							<td width="25%">Cdigo de Derivacin: <a href="correspondencia.php?t=derivado&did=482"><b></b></a></td>
		
						</tr>
					</table>
				</td>
			</tr>
			<tr>
				<td colspan="5" style="font-size: 7pt;">PROVEIDO:</td>
			</tr>
			<tr>		
				<td colspan="5" style="font-size: 12pt;"><? echo "$row_dep[registrodoc1_referencia]"; ?></td>
			</tr>
			<tr class="truno">		
				<td colspan="5" style="font-size: 12pt;">.</td>
			</tr>
		</table>
	</td>
   </tr>
	<?php 
	$s_derv="select * from derivardoc where derivardoc_hoja_ruta like '%$hruta%' ORDER BY derivardoc_n_derivacion";
	$r_derv = mysql_query($s_derv, $conn);
	while($rowderv=mysql_fetch_array($r_derv))
	{
	
	$s_rm1="select
			u.usuario_nombre, c.cargos_cargo
			from 
			usuario u,
			cargos c
			where
			u.usuario_ocupacion='$rowderv[derivardoc_de]'
			and
			u.usuario_ocupacion=c.cargos_id";
	$r_rm1 = mysql_query($s_rm1, $conn);
	$row_rm1=mysql_fetch_array($r_rm1);
	$nom_rm1=$row_rm1[0];
	$cargo_rm1=$row_rm1[1];
	
	$s_de1="select
			u.usuario_nombre, c.cargos_cargo
			from 
			usuario u,
			cargos c
			where
			u.usuario_ocupacion='$rowderv[derivardoc_para]'
			and
			u.usuario_ocupacion=c.cargos_id";
	$r_de1 = mysql_query($s_de1, $conn);
	$row_de1=mysql_fetch_array($r_de1);
	$nom_de1=$row_de1[0];
	$cargo_de1=$row_de1[1];
	
	?>
	<tr>
	<td>
		<table width="100%" style="border: solid 1px #000000;" bgcolor="#FFFFFF" border="1">
			<tr>
				<td style="font-size: 7pt;">REMITE</td>
				<td style="font-size: 7pt;" align="right">[]</td>		
				<td colspan="2" style="font-size: 7pt;">DESTINO</td>
				<td style="font-size: 7pt;" align="right">[]</td>
			</tr>
			<tr>
				<td width="44%" style="font-size:10px"><strong><? echo "$nom_rm1"; ?></strong>
					<br /><? echo "$cargo_rm1"; ?>	
				</td>
				
				<td width="5%"><img border="0" src="images/ir.png" alt="" /></td>		
				
				<td width="32%" style="font-size:10px"><strong><? echo "$nom_de1"; ?></strong>
					<br /><? echo "$cargo_de1"; ?>
				</td>
				<td width="12%" valign="top"></td>
				<td width="7%">
				<?php if($rowderv['derivardoc_situacion']=='SR')
						{
						?><img border="0" src="images/negativo.png" alt="" />
						<?php
						}
						else
						{
						?><img border="0" src="images/ok.png" alt="" />
						<?php
						}
				
				?>
				
				</td>
			</tr>
			<tr>		
				<td colspan="2" style="font-size: 7pt;">Fecha y Hora de Derivacin: <b><? echo "$rowderv[derivardoc_fec_derivacion]"; ?></b></td>
				<td colspan="2" style="font-size: 7pt;">Fecha y Hora de Recepcin: <b><?
					if($rowderv['derivardoc_fec_recibida'] !='0000-00-00 00:00:00')
					{ echo "$rowderv[derivardoc_fec_recibida]";}
					else
					{ echo " <b style=color:#990000>  NO RECEPCIONADO </b>"; }
					  ?></b>
				</td>
				<td style="font-size: 7pt;" align="right">
				<? $f1=$rowderv['derivardoc_fec_derivacion'];
				   $f2=$rowderv['derivardoc_fec_recibida'];  
				   $fch1=DiferenciaEntreFechas($f1, $f2, $f3);
				   
				   //$fch=tiempo_resta($f1, $f2);		
				   if($fch1>=3600){ $fch1=floor($fch1/3600); echo "$fch1 Hor";}
				   else {$fch1=floor($fch1/60); echo "$fch1 Min";}   
				?>&nbsp;
				</td>
			</tr>
			<tr>
				<td colspan="5">
		
					<table width="100%" style="font-size: 7pt;" cellpadding="0" cellspacing="0">
						<tr>
							<td width="25%">Plazo: <b></b></td>
							<td width="25%">Prioridad: <b><span style="color: #000000">NORMAL</span></b></td>
							<td width="25%">&nbsp;Requiere Respuesta: <b>SI</b></td>
							<td width="25%">Cdigo de Derivacin: <a href="correspondencia.php?t=derivado&did=482"><b></b></a></td>
		
						</tr>
					</table>
				</td>
			</tr>
			<tr>
				<td colspan="5" style="font-size: 7pt;">PROVEIDO:</td>
			</tr>
			<tr>		
				<td colspan="5" style="font-size: 12pt;"><? echo "$rowderv[derivardoc_proveido]"; ?></td>
			</tr>
			<tr class="truno">		
				<td colspan="5" style="font-size: 12pt;">.</td>
			</tr>
		</table>
	</td>
   </tr>
   <tr>	
	 <td>
   		<?php
		if($rowderv['derivardoc_estado']=='A')
		{
		?>			
 		<table width="" cellspacing="5" cellpadding="5" border="0" height="" align="center">
		
		<?php 
		$slista="SELECT * FROM archivados WHERE archivados_hoja_ruta LIKE '%$hruta%'";
		$rslista=mysql_query($slista,$conn);
		if (!empty($rslista)) 
		{
		?>
		<tr style="font-size: 8pt; color:#FFFFFF;" bgcolor="#3E6BA3">
			<td width="" align="center"><span >Fecha de Archivado</td>
			<td width="" align="center"><span >Proveido</td>
			<td width="" align="center"><span >Lugar de Archivado</td>
			<td width="" align="center"><span >Quien lo archivo</td>
		</tr>
		<tr>
		<?php

		 $resaltador=0;
		 $rwlista=mysql_fetch_array($rslista);
		 
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
		<td align="center"><?php echo $rwlista[2];?>
		</td>
		
		<td align="center"><?php echo $rwlista[3]; ?>
		</td>
		
		<td align="center"><?php echo $rwlista[4];?>
		</td>	
		<td align="center"><?php 
			$s_de1_a="select
			u.usuario_nombre, c.cargos_cargo
			from 
			usuario u,
			cargos c
			where
			u.usuario_ocupacion='$rwlista[5]'
			and
			u.usuario_ocupacion=c.cargos_id";
			$r_de1_a = mysql_query($s_de1_a, $conn);
			$row_de1_a=mysql_fetch_array($r_de1_a);
			$nom_de1_a=$row_de1_a[0];
		
		echo $nom_de1_a;?>
		</td>
		</tr>
		<?php
		
		}
		?>
		</table>			
						
		<?php 
		}
		?>
		</td>
		</tr>	
	<?php 	
	}//fin de while
	
	?>   
	
</table>
<?
}
else
{  //echo "el documento fue Archivado";


	$s_rm="select
			u.usuario_nombre, c.cargos_cargo
			from 
			usuario u,
			cargos c
			where
			u.usuario_ocupacion='$row_dep[registrodoc1_de]'
			and
			u.usuario_ocupacion=c.cargos_id";
	$r_rm = mysql_query($s_rm, $conn);
	$row_rm=mysql_fetch_array($r_rm);
	$nom_rm=$row_rm[0];
	$cargo_rm=$row_rm[1];
	
	$s_de="select
			u.usuario_nombre, c.cargos_cargo
			from 
			usuario u,
			cargos c
			where
			u.usuario_ocupacion='$row_dep[registrodoc1_para]'
			and
			u.usuario_ocupacion=c.cargos_id";
	$r_de = mysql_query($s_de, $conn);
	$row_de=mysql_fetch_array($r_de);
	$nom_de=$row_de[0];
	$cargo_de=$row_de[1];
?>
<table width="80%">
    <tr style="font-size: 8pt; color:#FFFFFF" bgcolor="#3E6BA3">
		<td><b>SEGUIMIENTO DE CORRESPONDENCIA HOJA DE RUTA Nro: <? echo "$hruta";?></b></td>
	</tr>
    <tr>
		<td>
		  <table width="100%" style="font-size: 8pt; color:#FFFFFF">
			  <tr class="truno">
				  <td colspan="2">REFERENCIA: <i><b><? echo "$row_dep[registrodoc1_referencia]"; ?></b></i></td>	
			  </tr>
			  <tr class="truno">
				  <td width="50%">Fecha de Elaboracion: <b><? echo "$row_dep[registrodoc1_fecha_elaboracion]"; ?></b></td>
				  <td width="50%" align="right">Fecha Limite: <b>NINGUNA</b>&nbsp;</td>
			  </tr>
			  <tr class="truno">
				  <td colspan="2">Estado: <b><? if($row_dep['registrodoc1_situacion']=='A'){ echo "DOCUMENTO ARCHIVADO";} ?></b></td>	
			  </tr>
		  </table>
     	</td>
	 </tr>
    
	<tr>
	<td>
		<table width="100%" style="border: solid 1px #000000;" bgcolor="#FFFFFF" border="1">
			<tr>
				<td style="font-size: 7pt;">REMITE</td>
				<td style="font-size: 7pt;" align="right">[]</td>		
				<td colspan="2" style="font-size: 7pt;">DESTINO</td>
				<td style="font-size: 7pt;" align="right">[]</td>
			</tr>
			<tr>
				<td width="44%" style="font-size:10px"><strong><? echo "$nom_rm"; ?></strong>
					<br /><? echo "$cargo_rm"; ?>	
				</td>
				
				<td width="5%"><img border="0" src="images/ir.png" alt="" /></td>		
				
				<td width="32%" style="font-size:10px"><strong><? echo "$nom_de"; ?></strong>
					<br /><? echo "$cargo_de"; ?>
				</td>
				<td width="12%" valign="top"></td>
				<td width="7%">
				<?php if($row_dep['registrodoc1_estado']=='SR')
						{
						?><img border="0" src="images/negativo.png" alt="" />
						<?php
						}
						else
						{
						?><img border="0" src="images/ok.png" alt="" />
						<?php
						}
				
				?>				
				</td>
			</tr>
			<tr>		
				<td colspan="2" style="font-size: 7pt;">Fecha y Hora de Derivacin: <b><? echo "$row_dep[registrodoc1_fecha_elaboracion]"; ?></b></td>
				<td colspan="2" style="font-size: 7pt;">Fecha y Hora de Recepcin: <b><? echo "$row_dep[registrodoc1_fecha_recepcion]"; ?></b></td>
				<td style="font-size: 7pt;" align="right">
				<? $f1=$row_dep['registrodoc1_fecha_elaboracion'];
				   $f2=$row_dep['registrodoc1_fecha_recepcion'];  
				   $fch1=DiferenciaEntreFechas($f1, $f2, $f3);
				   
				   //$fch=tiempo_resta($f1, $f2);		
				   if($fch1>=3600){ $fch1=floor($fch1/3600); echo "$fch1 Hor";}
				   else {$fch1=floor($fch1/60); echo "$fch1 Min";}   
				?>&nbsp;
				</td>
			</tr>
			<tr>
				<td colspan="5">
		
					<table width="100%" style="font-size: 7pt;" cellpadding="0" cellspacing="0">
						<tr>
							<td width="25%">Plazo: <b></b></td>
							<td width="25%">Prioridad: <b><span style="color: #000000">NORMAL</span></b></td>
							<td width="25%">&nbsp;Requiere Respuesta: <b>SI</b></td>
							<td width="25%">Cdigo de Derivacin: <a href="correspondencia.php?t=derivado&did=482"><b></b></a></td>
		
						</tr>
					</table>
				</td>
			</tr>
			<tr>
				<td colspan="5" style="font-size: 7pt;">PROVEIDO:</td>
			</tr>
			<tr>		
				<td colspan="5" style="font-size: 12pt;"><? echo "$row_dep[registrodoc1_referencia]"; ?></td>
			</tr>
			<tr class="truno">		
				<td colspan="5" style="font-size: 12pt;">.</td>
			</tr>
		</table>
	</td>
   </tr>
   	
   <tr>
    <td>
	  <table width="" cellspacing="5" cellpadding="5" border="0" height="" align="center">
		
		<?php 
		$slista="SELECT * FROM archivados WHERE archivados_hoja_ruta LIKE '%$hruta%'";
		$rslista=mysql_query($slista,$conn);
		if (!empty($rslista)) 
		{
		?>
		<tr style="font-size: 8pt; color:#FFFFFF;" bgcolor="#3E6BA3">
			<td width="" align="center"><span >Fecha de Archivado</td>
			<td width="" align="center"><span >Proveido</td>
			<td width="" align="center"><span >Lugar de Archivado</td>
			<td width="" align="center"><span >Quien lo archivo</td>
		</tr>
		<tr>
		<?php

		 $resaltador=0;
		 $rwlista=mysql_fetch_array($rslista);
		 
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
		<td align="center"><?php echo $rwlista[2];?>
		</td>
		
		<td align="center"><?php echo $rwlista[3]; ?>
		</td>
		
		<td align="center"><?php echo $rwlista[4];?>
		</td>	
		<td align="center"><?php 
			$s_de1_a="select
			u.usuario_nombre, c.cargos_cargo
			from 
			usuario u,
			cargos c
			where
			u.usuario_ocupacion='$rwlista[5]'
			and
			u.usuario_ocupacion=c.cargos_id";
			$r_de1_a = mysql_query($s_de1_a, $conn);
			$row_de1_a=mysql_fetch_array($r_de1_a);
			$nom_de1_a=$row_de1_a[0];
		
		echo $nom_de1_a;?>
		</td>
		</tr>
		<?php
		
		}
		?>
		</table>
   	</td>
   </tr>
   
</table>

<?
}
?>

</center>
<br><br>
<?php
include("final.php");
?>


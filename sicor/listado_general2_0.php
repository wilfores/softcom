<?php
include("../filtro.php");
?>
<?php
include("inicio.php");
?>
<?php
include("../conecta.php");
include("script/functions.inc");
include("script/cifrar.php");
include("../funcion.inc");

$cod_institucion=$_SESSION["institucion"];
$codigo_usuario=$_SESSION["codigo"];
$codigo=$_SESSION["cargo_asignado"];
//unset($_SESSION["codigo_libro_reg"]);
$fecha_hoy = date("Y-m-d");
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
//echo "$codigo <br>";
//echo "$codigo_usuario <br>";
?>

<script language="JavaScript">
function CopiaValor(objeto) {
	document.ingreso.sel_ingreso.value = objeto.value;
}

function Retornar(){
	document.ingreso.action="menu2.php";
	document.ingreso.submit();
}

function libro_usuario()
{
	if (document.lista.sel_usuario.value!="")
	{
		document.lista.action="listado_de_mi.php";
		document.lista.submit();
	}
}

</script>
<script language="JavaScript">
function Abre_ventana (pagina)
{
     ventana=window.open(pagina,"Asignar","toolbar=no,location=0,directories=no,status=no,menubar=no,scrollbars=yes,resizable=yes,width=420,height=200");
}
function Retornar(){
	document.ingreso.action="menu2.php";
	document.ingreso.submit();
}
</script>
<script>

function Combo()
{
  document.derivar.action="derivar.php";
  document.derivar.submit();
}

function Retornar()
{
  document.enviar.action="recepcion_lista.php";
  document.enviar.submit();
}

</script>

<br>
<p class="fuente_titulo">
<center><b style=" font-size:18px">BUSQUEDA DE CORRESPONDENCIA</b></center></p></center>
<table width="50%" cellspacing="1" cellpadding="1" border="0" align="center">
<form method="post" name="enviar">
<tr style="font-size: 8pt; color:#FFFFFF" bgcolor="#3E6BA3">

	<td width="7%" align="center"><span >
   <select class="fuente_caja_texto" name="tipo_doc" onchange="this.form.submit()">
        <option value="">Seleccione Tipo de Busqueda</option>
  <?php
  if ($_POST[tipo_doc]=='hr')
  {
  echo "<option value='hr' selected='selected'>Hoja de Ruta</option>";
  }
  else
  {
	  if ($_POST[tipo_doc]=='ct')
	  {
	  echo "<option value='ct' selected='selected'>Cite</option>";
	  }
	  else
	  {
		  if ($_POST[tipo_doc]=='fe')
		  {
		  echo "<option value='fe' selected='selected'>Fecha de Elaboracion</option>";
		  }
		  else
		  {
			  if ($_POST[tipo_doc]=='fr')
			  {
			  echo "<option value='fr' selected='selected'>Fecha de Recepcion</option>";
			  }
			  else
			  {
				  if ($_POST[tipo_doc]=='des')
				  {
				  echo "<option value='des' selected='selected'>Destinatario</option>";
				  }
				  else
				  {
					  if ($_POST[tipo_doc]=='re')
					  {
					  echo "<option value='re' selected='selected'>Remitente</option>";
					  }
					  else
					  {
					  	 if ($_POST[tipo_doc]=='ref')
						  {
						  echo "<option value='ref' selected='selected'>Referencia</option>";
						  }
						  else
						  {
						  	  if ($_POST[tipo_doc]=='un')
							  {
							  echo "<option value='un' selected='selected'>Unidad</option>";
							  }
							  else
							  {
							  	  if ($_POST[tipo_doc]=='td')
								  {
								  echo "<option value='td' selected='selected'>Tipo de Documento</option>";
								  }
								  else
								  {
								  	  if ($_POST[tipo_doc]=='es')
									  {
									  echo "<option value='es' selected='selected'>Estado</option>";
									  }								  
								  }
							  }
						  }
					  }
				  }
			  }
		  
     	  }
	  } 
  }
   echo "<option value='hr'>Hoja de Ruta</option>";
   echo "<option value='ct'>Cite</option>";
   echo "<option value='fe'>Fecha de Elaboracion</option>";
   echo "<option value='fr'>Fecha de Recepcion</option>";
   echo "<option value='des'>Destinatario</option>";
   echo "<option value='re'>Remitente</option>";
   echo "<option value='ref'>Referencia</option>";
   echo "<option value='un'>Unidad</option>";
   echo "<option value='td'>Tipo de Documento</option>";
   echo "<option value='es'>Estado</option>";
   
   ?>
    </select>
	</td>
</tr>	

<tr style="font-size: 8pt; color:#FFFFFF" bgcolor="#3E6BA3">	
		
		<?php		 
		if($_POST[tipo_doc]=='fe')/*FECHA DE ELABORACION*/
		{
		?>
		<td width="8%" align="center">DE:
<?php
echo "<input type=\"text\" name=\"fecha_ela1\" class=\"caja_texto\" id=\"dateArrival\" onClick=\"popUpCalendar(this, enviar.dateArrival, 'yyyy-mm-dd');\" size=\"10\" value=".$_POST['fecha_ela1'].">";
echo " <img src=\"images/cal_ico.png\" width=\"25\" height=\"25\" onClick=\"popUpCalendar(this, enviar.dateArrival, 'yyyy-mm-dd');\" alt=\"Calendario\" />";
?>	
.                   .HASTA:        
<?php
echo "<input type=\"text\" name=\"fecha_recep1\" class=\"caja_texto\" id=\"dateArrival1\" onClick=\"popUpCalendar(this, enviar.dateArrival1, 'yyyy-mm-dd');\" size=\"10\" value=".$_POST['fecha_recep1'].">";
echo " <img src=\"images/cal_ico.png\" width=\"25\" height=\"25\" onClick=\"popUpCalendar(this, enviar.dateArrival1, 'yyyy-mm-dd');\" alt=\"Calendario\" />";
?>	
		<input class="boton" name="enviar2" type="submit" value="Filtrar">
		</td>
		<?php 
		}
		if($_POST[tipo_doc]=='fr')/*FECHA DE RECEPCION*/
		{
		?>
		<td width="8%" align="center">DE:
<?php
echo "<input type=\"text\" name=\"fecha_ela2\" class=\"caja_texto\" id=\"dateArrival\" onClick=\"popUpCalendar(this, enviar.dateArrival, 'yyyy-mm-dd');\" size=\"10\" value=".$_POST['fecha_ela'].">";
echo " <img src=\"images/cal_ico.png\" width=\"25\" height=\"25\" onClick=\"popUpCalendar(this, enviar.dateArrival, 'yyyy-mm-dd');\" alt=\"Calendario\" />";
?>	
.                   .HASTA:        
<?php
echo "<input type=\"text\" name=\"fecha_recep2\" class=\"caja_texto\" id=\"dateArrival1\" onClick=\"popUpCalendar(this, enviar.dateArrival1, 'yyyy-mm-dd');\" size=\"10\" value=".$_POST['fecha_recep'].">";
echo " <img src=\"images/cal_ico.png\" width=\"25\" height=\"25\" onClick=\"popUpCalendar(this, enviar.dateArrival1, 'yyyy-mm-dd');\" alt=\"Calendario\" />";
?>
		<input class="boton" name="enviar2" type="submit" value="Filtrar">
		</td>
		<?php 
		}		
		if($_POST[tipo_doc]=='hr')
		{
		?>
		<td width="8%" align="center"><span ><input name="campo_hr" type="text" value="<?=$_POST['campo_hr'];?>">
				<input class="boton" name="enviar2" type="submit" value="Filtrar">
		</td>
		<?php 
		}
		if($_POST[tipo_doc]=='ct')
		{
		?>
		<td width="8%" align="center"><span ><input name="campo_ct" type="text" value="<?=$_POST['campo_ct'];?>">
				<input class="boton" name="enviar2" type="submit" value="Filtrar">
		</td>
		<?php 			
		}
		if($_POST[tipo_doc]=='des')
		{
		?>
		<td width="8%" align="center"><span ><input name="campo_des" type="text" value="<?=$_POST['campo_des'];?>">
				<input class="boton" name="enviar2" type="submit" value="Filtrar">
		</td>
		<?php 			
		}
		if($_POST[tipo_doc]=='re')
		{
		?>
		<td width="8%" align="center"><span ><input name="campo_re" type="text" value="<?=$_POST['campo_re'];?>">
				<input class="boton" name="enviar2" type="submit" value="Filtrar">
		</td>
		<?php 			
		}
		if($_POST[tipo_doc]=='ref')
		{
		?>
		<td width="8%" align="center"><span ><input name="campo_ref" type="text" value="<?=$_POST['campo_ref'];?>">
				<input class="boton" name="enviar2" type="submit" value="Filtrar">
		</td>
		<?php 			
		}
		if($_POST[tipo_doc]=='un')
		{
		?>
		<td width="8%" align="center"><span ><input name="campo_un" type="text" value="<?=$_POST['campo_un'];?>">
				<input class="boton" name="enviar2" type="submit" value="Filtrar">
		</td>
		<?php 			
		}
		if($_POST[tipo_doc]=='td')
		{
		?>
		<td width="8%" align="center"><span >
		<select name="campo_td" style="font-size:9px">
		  <option value="">Selecione el Tipo de Documento</option>
		  <?php
			$respss=mysql_query("select documentos_descripcion, documentos_sigla 
									from documentos  
									order by documentos_descripcion",$conn);
			while($rowass=mysql_fetch_array($respss))
			{
				if($_POST['campo_td']==$rowass["documentos_descripcion"])
				{
				?>
		  <option value="<?=$rowass['documentos_descripcion'];?>" selected><?php echo $rowass["documentos_descripcion"];?></option>
		  <?php 
				}
				else
				{
					?>
		  <option value="<?=$rowass['documentos_descripcion'];?>"><?php echo $rowass["documentos_descripcion"];?></option>
		  <?php
				}//fin de else
						 
				
			}//fin de while
	
				?>
		</select>
				
				 <input class="boton" name="enviar2" type="submit" value="Filtrar">
		</td>
		<?php 			
		}
		if($_POST[tipo_doc]=='es')
		{
		?>
		<td width="8%" align="center"><span ><!--<input name="campo_es" type="text" value="<?=$_POST['campo_es'];?>">-->
		<select name="campo_es" style="font-size:10px">
		  <option value="">Selecione el Estado del Documento</option>
		  <option value="R">Recepcionados</option>
		  <option value="SR">Sin Recepcionar</option>
		  <option value="R">Sin Recepcionar</option>
		</select>
				<input class="boton" name="enviar2" type="submit" value="Filtrar">
		</td>
		<?php 			
		}
		?>
</tr>
</form>	
</table>
<br>
<?php 
if(isset($_POST['enviar2']))
{

$t=10;
if(!isset($_GET['pagina'])) {
$pagina=1;
$inicio=0;
}
else {
$pagina=$_GET['pagina'];
$inicio=($pagina-1)*$t;
}

  	if(isset($_POST['fecha_ela1']))
	{

		if($_POST['fecha_recep1']!='')
		{
		$fech1=explode("-",$_POST[fecha_ela1]);
		$fech2=explode("-",$_POST[fecha_recep1]);
		
		//echo "$fech1[0]<br>";//año
		//echo "$fech1[1]<br>";//mes
		//echo "$fech1[2]<br>";//dia
		
		$slista="SELECT 
	registrodoc1_hoja_ruta, registrodoc1_cite, registrodoc1_fecha_elaboracion, registrodoc1_fecha_recepcion, usuario_nombre, registrodoc1_referencia, documentos_descripcion, registrodoc1_estado, registrodoc1_asociar, registrodoc1_asociar_h_r, registrodoc1_cc, registrodoc1_cite, usuario_ocupacion
	FROM `registrodoc1`, `documentos`, `usuario` 
	where 
    (
    ( YEAR( `registrodoc1_fecha_elaboracion` ) >='$fech1[0]' AND YEAR( `registrodoc1_fecha_elaboracion` ) <='$fech2[0]') 
    AND 
    ( MONTH( `registrodoc1_fecha_elaboracion` ) >='$fech1[1]' AND MONTH(`registrodoc1_fecha_elaboracion`)<='$fech2[1]')
    AND
    ( DAY( `registrodoc1_fecha_elaboracion` ) >='$fech1[2]' AND DAY(`registrodoc1_fecha_elaboracion`)<='$fech2[2]')
    )
    and registrodoc1_para=usuario_ocupacion
	and registrodoc1_doc=documentos_sigla
	ORDER BY registrodoc1_fecha_elaboracion ASC";
	/*GROUP BY registrodoc1_cite ORDER BY registrodoc1_fecha_elaboracion ASC";*/
		
		}
		else
		{
		
		$slista="SELECT 
	registrodoc1_hoja_ruta, registrodoc1_cite, registrodoc1_fecha_elaboracion, registrodoc1_fecha_recepcion, usuario_nombre, registrodoc1_referencia, documentos_descripcion, registrodoc1_estado, registrodoc1_asociar, registrodoc1_asociar_h_r, registrodoc1_cc, registrodoc1_cite, usuario_ocupacion
	FROM `registrodoc1`, `documentos`, `usuario` 
	where (registrodoc1_fecha_elaboracion like '%$_POST[fecha_ela1]%')
    and registrodoc1_para=usuario_ocupacion
	and registrodoc1_doc=documentos_sigla
	ORDER BY registrodoc1_n_h_r ASC";
	/*GROUP BY registrodoc1_cite ORDER BY registrodoc1_n_h_r ASC";*/
		}

	}
  	if(isset($_POST['fecha_recep2']))
	{
		if($_POST['fecha_ela2']!='')
		{
		$fech1=explode("-",$_POST[fecha_ela2]);
		$fech2=explode("-",$_POST[fecha_recep2]);
		
		$slista="SELECT 
	registrodoc1_hoja_ruta, registrodoc1_cite, registrodoc1_fecha_elaboracion, registrodoc1_fecha_recepcion, usuario_nombre, registrodoc1_referencia, documentos_descripcion, registrodoc1_estado, registrodoc1_asociar, registrodoc1_asociar_h_r, registrodoc1_cc, registrodoc1_cite, usuario_ocupacion
	FROM `registrodoc1`, `documentos`, `usuario` 
	where 
    (
    ( YEAR( `registrodoc1_fecha_recepcion` ) >='$fech1[0]' AND YEAR( `registrodoc1_fecha_recepcion` ) <='$fech2[0]') 
    AND 
    ( MONTH( `registrodoc1_fecha_recepcion` ) >='$fech1[1]' AND MONTH(`registrodoc1_fecha_recepcion`)<='$fech2[1]')
    AND
    ( DAY( `registrodoc1_fecha_recepcion` ) >='$fech1[2]' AND DAY(`registrodoc1_fecha_recepcion`)<='$fech2[2]')
    )
    and registrodoc1_para=usuario_ocupacion
	and registrodoc1_doc=documentos_sigla
	ORDER BY registrodoc1_fecha_recepcion ASC";
	/*GROUP BY registrodoc1_cite ORDER BY registrodoc1_fecha_recepcion ASC";*/	
		}
		else
		{
	$slista="SELECT 
	registrodoc1_hoja_ruta, registrodoc1_cite, registrodoc1_fecha_elaboracion, registrodoc1_fecha_recepcion, usuario_nombre, registrodoc1_referencia, documentos_descripcion, registrodoc1_estado, registrodoc1_asociar, registrodoc1_asociar_h_r, registrodoc1_cc, registrodoc1_cite, usuario_ocupacion
	FROM `registrodoc1`, `documentos`, `usuario` 
	where (registrodoc1_fecha_recepcion like '%$_POST[fecha_recep2]%')
    and registrodoc1_para=usuario_ocupacion
	and registrodoc1_doc=documentos_sigla
	ORDER BY registrodoc1_n_h_r ASC";
	/*GROUP BY registrodoc1_cite ORDER BY registrodoc1_n_h_r ASC";*/	
		}
	}
	if(isset($_POST['campo_hr']))
	{
	$slista="SELECT 
	registrodoc1_hoja_ruta, registrodoc1_cite, registrodoc1_fecha_elaboracion, registrodoc1_fecha_recepcion, usuario_nombre, registrodoc1_referencia, documentos_descripcion, registrodoc1_estado, registrodoc1_asociar, registrodoc1_asociar_h_r, registrodoc1_cc, registrodoc1_cite, usuario_ocupacion
	FROM `registrodoc1`, `documentos`, `usuario` 
	where registrodoc1_hoja_ruta LIKE '%$_POST[campo_hr]%'
    and registrodoc1_para=usuario_ocupacion
	and registrodoc1_doc=documentos_sigla ORDER BY registrodoc1_n_h_r ASC";
	/*GROUP BY registrodoc1_cite ORDER BY registrodoc1_n_h_r ASC";*/
	}
	if(isset($_POST['campo_ct']))
	{
	$slista="SELECT 
	registrodoc1_hoja_ruta, registrodoc1_cite, registrodoc1_fecha_elaboracion, registrodoc1_fecha_recepcion, usuario_nombre, registrodoc1_referencia, documentos_descripcion, registrodoc1_estado, registrodoc1_asociar, registrodoc1_asociar_h_r, registrodoc1_cc, registrodoc1_cite, usuario_ocupacion
	FROM `registrodoc1`, `documentos`, `usuario` 
	where registrodoc1_cite LIKE '%$_POST[campo_ct]%'
    and registrodoc1_para=usuario_ocupacion
	and registrodoc1_doc=documentos_sigla ORDER BY registrodoc1_n_h_r ASC";
	/*GROUP BY registrodoc1_cite ORDER BY registrodoc1_n_h_r ASC";*/
	}
	if(isset($_POST['campo_des']))
	{
	$slista="SELECT 
	registrodoc1_hoja_ruta, registrodoc1_cite, registrodoc1_fecha_elaboracion, registrodoc1_fecha_recepcion, usuario_nombre, registrodoc1_referencia, documentos_descripcion, registrodoc1_estado, registrodoc1_asociar, registrodoc1_asociar_h_r, registrodoc1_cc, registrodoc1_cite, usuario_ocupacion
	FROM `registrodoc1`, `documentos`, `usuario` 
	where usuario_nombre LIKE '%$_POST[campo_des]%'
    and registrodoc1_para=usuario_ocupacion
	and registrodoc1_doc=documentos_sigla
	ORDER BY registrodoc1_n_h_r ASC";
	/*GROUP BY registrodoc1_cite ORDER BY registrodoc1_n_h_r ASC";*/
	}
	if(isset($_POST['campo_re']))
	{
	$slista="SELECT 
	registrodoc1_hoja_ruta, registrodoc1_cite, registrodoc1_fecha_elaboracion, registrodoc1_fecha_recepcion, usuario_nombre, registrodoc1_referencia, documentos_descripcion, registrodoc1_estado, registrodoc1_asociar, registrodoc1_asociar_h_r, registrodoc1_cc, registrodoc1_cite, usuario_ocupacion
	FROM `registrodoc1`, `documentos`, `usuario` 
	where usuario_nombre LIKE '%$_POST[campo_re]%'
    and registrodoc1_de=usuario_ocupacion
	and registrodoc1_doc=documentos_sigla
	ORDER BY registrodoc1_n_h_r ASC";
	/*GROUP BY registrodoc1_cite ORDER BY registrodoc1_n_h_r ASC";*/
	}
	if(isset($_POST['campo_ref']))
	{
	$slista="SELECT 
	registrodoc1_hoja_ruta, registrodoc1_cite, registrodoc1_fecha_elaboracion, registrodoc1_fecha_recepcion, usuario_nombre, registrodoc1_referencia, documentos_descripcion, registrodoc1_estado, registrodoc1_asociar, registrodoc1_asociar_h_r, registrodoc1_cc, registrodoc1_cite, usuario_ocupacion
	FROM `registrodoc1`, `documentos`, `usuario` 
	where registrodoc1_referencia LIKE '%$_POST[campo_ref]%'
    and registrodoc1_de=usuario_ocupacion
	and registrodoc1_doc=documentos_sigla
	ORDER BY registrodoc1_n_h_r ASC";
	/*GROUP BY registrodoc1_cite ORDER BY registrodoc1_n_h_r ASC";*/
	}
	if(isset($_POST['campo_un']))
	{
		echo "$_POST[campo_un]";
	}
	if(isset($_POST['campo_td']))
	{
	$slista="SELECT 
	registrodoc1_hoja_ruta, registrodoc1_cite, registrodoc1_fecha_elaboracion, registrodoc1_fecha_recepcion, usuario_nombre, registrodoc1_referencia, documentos_descripcion, registrodoc1_estado, registrodoc1_asociar, registrodoc1_asociar_h_r, registrodoc1_cc, registrodoc1_cite, usuario_ocupacion
	FROM `registrodoc1`, `documentos`, `usuario` 
	where documentos_descripcion LIKE '%$_POST[campo_td]%'
    and registrodoc1_de=usuario_ocupacion
	and registrodoc1_doc=documentos_sigla
	GROUP BY registrodoc1_cite ORDER BY registrodoc1_n_h_r ASC";
	/*GROUP BY registrodoc1_cite ORDER BY registrodoc1_n_h_r ASC";*/
	}
	if(isset($_POST['campo_es']))
	{
	$slista="SELECT 
	registrodoc1_hoja_ruta, registrodoc1_cite, registrodoc1_fecha_elaboracion, registrodoc1_fecha_recepcion, usuario_nombre, registrodoc1_referencia, documentos_descripcion, registrodoc1_estado, registrodoc1_asociar, registrodoc1_asociar_h_r, registrodoc1_cc, registrodoc1_cite, usuario_ocupacion
	FROM `registrodoc1`, `documentos`, `usuario` 
	where registrodoc1_estado='$_POST[campo_es]'
    and registrodoc1_de=usuario_ocupacion
	and registrodoc1_doc=documentos_sigla
	GROUP BY registrodoc1_cite ORDER BY registrodoc1_n_h_r ASC";
	/*GROUP BY registrodoc1_cite ORDER BY registrodoc1_n_h_r ASC";*/
	}

$rslista=mysql_query($slista,$conn);
$lim_inferior=1;
$lim_superior=1;
$total_paginas = ceil(mysql_num_rows($rslista) / $t);

		if (!empty($rslista)) 
		{
		  ?>	
		<table width="95%" cellspacing="1" cellpadding="1" border="0" align="center">
		<tr style="font-size: 8pt; color:#FFFFFF" bgcolor="#3E6BA3">
			<td align="center"><span >Hoja Ruta</td>
			<td align="center"><span >Cite</td>
			<td align="center"><span >Fecha Elaboracion</td>
			<td align="center"><span >Fecha Recepcion</td>
			<?php if(isset($_POST['campo_re']))
			{
			?>
			<td align="center"><span >Remitente</td>
			<?php 
			}else
			{
			?>
			<td align="center"><span >Destinatario</td>
			<?php 
			} 
			?>
			<td align="center"><span >Referencia</td>
			<td align="center"><span >Tipo Doc</td>
			<td align="center"><span >Estado</td>	
			<td align="center"></td>
			
		</tr>
		<?php
		 $resaltador=0;
		 while($rwlista=mysql_fetch_array($rslista))
		 {
			 //$valor_vect=$row["libroregistro_cod_registro"];
			//if ($lim_inferior>$inicio && $lim_superior<=$t)
			//{
			 $doc_arch=cifrar($rwlista["registrodoc1_hoja_ruta"]);
			 $doc_arch2=cifrar($rwlista["registrodoc1_cite"]);
		 
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
		<td align="center"><?php 
		if($rwlista[registrodoc1_asociar]=='si'){echo "<font color=#CC0000>Doc. Asociado $rwlista[registrodoc1_asociar_h_r]";}
		else {echo $rwlista[registrodoc1_hoja_ruta];}?>
		</td>
		<td align="center"><?php echo $rwlista[registrodoc1_cite];?>
		</td>
		<td align="center"><?php echo $rwlista[registrodoc1_fecha_elaboracion];?>
		</td>
		<td align="center"><?php echo $rwlista[registrodoc1_fecha_recepcion];?>
		</td>
		
		<td align="left"><?php echo $rwlista[usuario_nombre];?>
		</td>
		
		<td align="left"><?php echo $rwlista[registrodoc1_referencia]; ?>
		</td>
		
		<td align="left"><?php echo $rwlista[documentos_descripcion];?></td>
		
		<?php
		if($rwlista['registrodoc1_estado']=='SR') 
		{$rep='No Recepcionado';?><td align="center" style="color:#990000; font-size:10px"><?php echo "$rep";?></td>
		<?php }
		else {$rep='Recepcionado';?>
		<td align="center" style="font-size:10px"><?php echo "$rep";?></td>
		 <?php }?>
		</td>
		<td align="center">
		<a href="seguimiento_doc.php?hr1=<?php echo $doc_arch;?>" onMouseOver="window.status='Guia de sitio';return true" onMouseOut="window.status='';return true">
		<img src="images/ver.png" onMouseOver="this.src='images/ver1.png'" onMouseOut="this.src='images/ver.png'"></a>
		</td>
		</tr>
		<?php
			$lim_superior++;
		  //}//FIN DE IF
		$lim_inferior++;
		}// FIN DE WHILE 
		?>
		</table>
		<?php 
		}
	
	?>
	<center>
	<?php
	for ($i=1;$i<=$total_paginas;$i++) 
	{
		if ($i!=$pagina) 
		{	$suiguiente=$i;
		echo "<a href=$PHP_SELF?pagina=$i><font color=#FF6600>$i</font></a> ";
		}
		else {
		echo " | ".$i." | ";
		}
	}
	
	?>
	<br>
	</center>
	<?php
}//fin de if(enviar2)
else
{

if($_POST[tipo_doc]=='')
{
//++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++
/*
	$slista="SELECT 
	registrodoc1_hoja_ruta, registrodoc1_cite, registrodoc1_fecha_elaboracion, registrodoc1_fecha_recepcion, usuario_nombre, registrodoc1_referencia, documentos_descripcion, registrodoc1_estado, registrodoc1_asociar, registrodoc1_asociar_h_r, registrodoc1_cc, registrodoc1_cite, usuario_ocupacion
	FROM `registrodoc1`, `documentos`, `usuario` 
	where registrodoc1_de=usuario_ocupacion
	and registrodoc1_doc=documentos_sigla
	and registrodoc1_depto='$depto'
	and registrodoc1_n_h_r<>'0'
	GROUP BY registrodoc1_cite ORDER BY registrodoc1_n_h_r ASC";

$rslista=mysql_query($slista,$conn);
$lim_inferior=1;
$lim_superior=1;
$total_paginas = ceil(mysql_num_rows($rslista) / $t);

		if (!empty($rslista)) 
		{
		  ?>
		<center> 	
		<table width="95%" cellspacing="1" cellpadding="1" border="0" align="center">
		<tr style="font-size: 8pt; color:#FFFFFF" bgcolor="#3E6BA3">
			<td align="center"><span >Hoja Ruta</td>
			<td align="center"><span >Cite</td>
			<td align="center"><span >Fecha Elaboracion</td>
			<td align="center"><span >Fecha Recepcion</td>
			<?php if(isset($_POST['campo_re']))
			{
			?>
			<td align="center"><span >Remitente</td>
			<?php 
			}else
			{
			?>
			<td align="center"><span >Destinatario</td>
			<?php 
			} 
			?>
			<td align="center"><span >Referencia</td>
			<td align="center"><span >Tipo Doc</td>
			<td align="center"><span >Estado</td>	
			<td align="center"></td>
		</tr>
		<?php
		 $resaltador=0;
		 while($rwlista=mysql_fetch_array($rslista))
		 {
			 //$valor_vect=$row["libroregistro_cod_registro"];
			//if ($lim_inferior>$inicio && $lim_superior<=$t)
			//{
			 $doc_arch=cifrar($rwlista["registrodoc1_hoja_ruta"]);
			 $doc_arch2=cifrar($rwlista["registrodoc1_cite"]);
		 
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
		<td align="center"><?php 
		if($rwlista[registrodoc1_asociar]=='si'){echo "<font color=#CC0000>Doc. Asociado $rwlista[registrodoc1_asociar_h_r]";}
		else {echo $rwlista[registrodoc1_hoja_ruta];}?>		</td>
		<td align="center"><?php echo $rwlista[registrodoc1_cite];?>		</td>
		<td align="center"><?php echo $rwlista[registrodoc1_fecha_elaboracion];?>		</td>
		<td align="center"><?php echo $rwlista[registrodoc1_fecha_recepcion];?>		</td>
		
		<td align="left"><?php echo $rwlista[usuario_nombre];?>		</td>
		
		<td align="left"><?php echo $rwlista[registrodoc1_referencia]; ?>		</td>
		
		<td align="left"><?php echo $rwlista[documentos_descripcion];?></td>
		
		<?php
		if($rwlista['registrodoc1_estado']=='SR') 
		{$rep='No Recepcionado';?><td align="center" style="color:#990000; font-size:10px"><?php echo "$rep";?></td>
		<?php }
		else {$rep='Recepcionado';?>
		<td align="center" style="font-size:10px"><?php echo "$rep";?></td>
		 <?php }?>
		</td>
		<td align="center"><a href="seguimiento_doc.php?hr1=<?php echo $doc_arch;?>" onmouseover="window.status='Guia de sitio';return true" onmouseout="window.status='';return true"><img src="images/ver.png" onmouseover="this.src='images/ver1.png'" onmouseout="this.src='images/ver.png'" /></a></td>
		</tr>
		<?php
			$lim_superior++;
		  //}//FIN DE IF
		$lim_inferior++;
		}// FIN DE WHILE 
		?>
		</table>
		<center>
		<?php 
		}
*/	
//+++++++++++++++++++++++++++++++++++++++++++++++++
	}
}

?>
<?php $conn = Desconectarse();?>

<?php
include("final.php");
?>
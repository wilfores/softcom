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

/*
$ssql="SELECT * FROM libroregistro WHERE '$cargo_unico'=libroregistro_cod_usr ORDER BY libroregistro_cod_registro DESC LIMIT $inicial,$cantidad";
$rss=mysql_query($ssql,$conn);

$contar = "SELECT 
registrodoc1_hoja_ruta, registrodoc1_fecha_elaboracion, usuario_nombre, registrodoc1_referencia, documentos_descripcion, registrodoc1_estado, registrodoc1_asociar, registrodoc1_asociar_h_r
FROM `registrodoc1`, `documentos`, `usuario`
where registrodoc1_de = '$codigo' 
and registrodoc1_para=usuario_ocupacion
and registrodoc1_doc=documentos_sigla
GROUP BY registrodoc1_hoja_ruta DESC LIMIT $inicial,$cantidad";
*/

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
<?php
/*$busqueda = "prueba"; 
$link = mysql_connect("host","user","pass");
mysql_select_db("db",$link);
$result = mysql_query("select contenidos from tabla 
where keyword LIKE %$busqueda%",$link); 
while($row = mysql_fetch_row($result)) {
echo str_replace($busqueda,"<span style=background-color: #88AAEE>
$busqueda</span>",$row[0]);
echo "<br><br>";
}*/
?>

<br>
<p class="fuente_titulo">
<center><b>BUSQUEDA DE CORRESPONDENCIA</b></center></p>
<center>
<table width="95%" cellspacing="1" cellpadding="1" border="0" align="center">
<form method="post" name="enviar">
<tr style="font-size: 8pt; color:#FFFFFF" bgcolor="#3E6BA3">

	<td width="7%" align="center"><span >
   <select class="fuente_caja_texto" name="ci_ciudad" onchange="this.form.submit()">
        <option value="">Seleccione Tipo de Busqueda</option>
  <?php
  if ($_POST[ci_ciudad]=='hr')
  {
  echo "<option value='hr' selected='selected'>Hoja de Ruta</option>";
  }
  else
  {
	  if ($_POST[ci_ciudad]=='ct')
	  {
	  echo "<option value='ct' selected='selected'>Cite</option>";
	  }
	  else
	  {
		  if ($_POST[ci_ciudad]=='fe')
		  {
		  echo "<option value='fe' selected='selected'>Fecha de Elaboracion</option>";
		  }
		  else
		  {
			  if ($_POST[ci_ciudad]=='fr')
			  {
			  echo "<option value='fr' selected='selected'>Fecha de Recepcion</option>";
			  }
			  else
			  {
				  if ($_POST[ci_ciudad]=='des')
				  {
				  echo "<option value='des' selected='selected'>Destinatario</option>";
				  }
				  else
				  {
					  if ($_POST[ci_ciudad]=='re')
					  {
					  echo "<option value='re' selected='selected'>Remitente</option>";
					  }
					  else
					  {
					  	 if ($_POST[ci_ciudad]=='ref')
						  {
						  echo "<option value='ref' selected='selected'>Referencia</option>";
						  }
						  else
						  {
						  	  if ($_POST[ci_ciudad]=='un')
							  {
							  echo "<option value='un' selected='selected'>Unidad</option>";
							  }
							  else
							  {
							  	  if ($_POST[ci_ciudad]=='td')
								  {
								  echo "<option value='td' selected='selected'>Tipo de Documento</option>";
								  }
								  else
								  {
								  	  if ($_POST[ci_ciudad]=='es')
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
<?php /*?><?php */
if($_POST[ci_ciudad]!='' )
{

	 ?>
	 <tr style="font-size: 8pt; color:#FFFFFF" bgcolor="#3E6BA3">	
		
		<?php 
		if($_POST[ci_ciudad]=='fe' || $_POST[ci_ciudad]=='fr')
		{
		?>
		<td width="8%" align="center">
<?php
echo "<input type=\"text\" name=\"fecha_plazo\" class=\"caja_texto\" id=\"dateArrival\" onClick=\"popUpCalendar(this, enviar.dateArrival, 'yyyy-mm-dd');\" size=\"10\" value=".$_POST['fecha_plazo'].">";
echo " <img src=\"images/cal_ico.png\" width=\"25\" height=\"25\" onClick=\"popUpCalendar(this, enviar.dateArrival, 'yyyy-mm-dd');\" alt=\"Calendario\" />";
?>
		<input class="boton" name="enviar2" type="submit" value="Filtrar">
		</td>
		<?php 
		}
		else
		{
		?>
		<td width="8%" align="center"><span ><input name="campo" type="text" value="<?=$_POST['campo'];?>">
				<input class="boton" name="enviar2" type="submit" value="Filtrar">
		</td>
		<?php 
		}
		?>
	</tr>
	<?php
		
	if(isset($_POST['enviar2']))
	{
		if($_POST[ci_ciudad]=='hr' || $_POST[ci_ciudad]=='ct' || $_POST[ci_ciudad]=='des' || $_POST[ci_ciudad]=='re' || $_POST[ci_ciudad]=='ref' || $_POST[ci_ciudad]=='un' || $_POST[ci_ciudad]=='td' || $_POST[ci_ciudad]=='es')
		{
		
			if($_POST[ci_ciudad]=='hr')
			{
				$h_ruta=$_POST['campo'];
				echo "$h_ruta";
				
				/*$slista="SELECT 
	registrodoc1_hoja_ruta, registrodoc1_fecha_elaboracion, usuario_nombre, registrodoc1_referencia, documentos_descripcion, registrodoc1_estado, registrodoc1_asociar, registrodoc1_asociar_h_r, registrodoc1_cc, registrodoc1_cite, usuario_ocupacion
	FROM `registrodoc1`, `documentos`, `usuario` 
	where registrodoc1_hoja_ruta='$h_ruta'
	and registrodoc1_para=usuario_ocupacion
	and registrodoc1_doc=documentos_sigla";*/
	
		$slista1="SELECT 
	registrodoc1_hoja_ruta, registrodoc1_fecha_elaboracion, usuario_nombre, registrodoc1_referencia, documentos_descripcion, registrodoc1_estado, registrodoc1_asociar, registrodoc1_asociar_h_r, registrodoc1_cc, registrodoc1_cite, usuario_ocupacion
	FROM `registrodoc1`, `documentos`, `usuario` 
	where registrodoc1_para=usuario_ocupacion
	and registrodoc1_doc=documentos_sigla
	GROUP BY registrodoc1_cite ORDER BY registrodoc1_n_h_r ASC LIMIT $inicial,$cantidad";
			
			?>		
		<table width="95%" cellspacing="1" cellpadding="1" border="0" align="center">
		<tr style="font-size: 8pt; color:#FFFFFF" bgcolor="#3E6BA3">
			<td width="7%" align="center"><span >Hoja Ruta</td>
			<td width="8%" align="center"><span >Fecha Elaboracion</td>
			<td width="15%" align="center"><span >Destinatario</td>
			<td width="20%" align="center"><span >Referencia</td>
			<td width="14%" align="center"><span >Tipo Doc</td>
			<td width="8%" align="center"><span >Estado</td>	
			<td width="15%" align="center"></td>
			
		</tr>
		<!--<meta content="5;URL=listado_de_mi2.php" http-equiv="REFRESH">-->
		<?php
		$rslista1=mysql_query($slista1,$conn);
		$lim_inferior=1;
		$lim_superior=1;
		$total_paginas = ceil(mysql_num_rows($rslista) / $t);
		if (!empty($rslista1)) 
		{
		 $resaltador=0;
		 while($rwlista=mysql_fetch_array($rslista1))
		 {
			 //$valor_vect=$row["libroregistro_cod_registro"];
			if ($lim_inferior>$inicio && $lim_superior<=$t)
			{
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
		
		<td align="center"><?php echo $rwlista[registrodoc1_fecha_elaboracion];?>
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
			}//FIN DE IF
		$lim_inferior++;
		}// FIN DE WHILE 
		}
		?>
		</table>
		<?php

			}
			if($_POST[ci_ciudad]=='ct')
			{
			
			}
			if($_POST[ci_ciudad]=='des')
			{
			
			}
			if($_POST[ci_ciudad]=='re')
			{
			
			}
			if($_POST[ci_ciudad]=='ref')
			{
			
			}
			if($_POST[ci_ciudad]=='un')
			{
			
			}
			if($_POST[ci_ciudad]=='td')
			{
			
			}
			if($_POST[ci_ciudad]=='es')
			{
			
			}
			
		}
		if($_POST[ci_ciudad]=='fe' || $_POST[ci_ciudad]=='fr')
		{
			if($_POST[ci_ciudad]=='fe')
			{
			
			}
			if($_POST[ci_ciudad]=='fr')
			{
			
			}
		}
		

	}
}
else
{
	//codigo de paginacion
	if (!isset($pg))
	$pg = 0; // $pg es la pagina actual
	$cantidad=10; // cantidad de resultados por página
	$inicial = $pg * $cantidad;
	
	
	$slista="SELECT 
	registrodoc1_hoja_ruta, registrodoc1_fecha_elaboracion, usuario_nombre, registrodoc1_referencia, documentos_descripcion, registrodoc1_estado, registrodoc1_asociar, registrodoc1_asociar_h_r, registrodoc1_cc, registrodoc1_cite, usuario_ocupacion
	FROM `registrodoc1`, `documentos`, `usuario` 
	where registrodoc1_para=usuario_ocupacion
	and registrodoc1_doc=documentos_sigla
	GROUP BY registrodoc1_cite ORDER BY registrodoc1_n_h_r ASC LIMIT $inicial,$cantidad";
	
	//	where registrodoc1_de = '$codigo' and registrodoc1_para=usuario_ocupacion
	
	$contarok=mysql_query($slista,$conn);
	$total_records = mysql_num_rows($contarok);
	$pages = intval($total_records / $cantidad);
	
	//Declaramos el tamaño de registros que se van a visualizar por pagina.
	$t=10;
	if(!isset($_GET['pagina'])) {
	$pagina=1;
	$inicio=0;
	}
	else {
	$pagina=$_GET['pagina'];
	$inicio=($pagina-1)*$t;
	}


?>
</form>	
</table>

<table width="95%" cellspacing="1" cellpadding="1" border="0" align="center">
<tr style="font-size: 8pt; color:#FFFFFF" bgcolor="#3E6BA3">
	<td width="7%" align="center"><span >Hoja Ruta</td>
	<td width="8%" align="center"><span >Fecha Elaboracion</td>
	<td width="15%" align="center"><span >Destinatario</td>
	<td width="20%" align="center"><span >Referencia</td>
	<td width="14%" align="center"><span >Tipo Doc</td>
	<td width="8%" align="center"><span >Estado</td>	
	<td width="15%" align="center"></td>
	
</tr>
<!--<meta content="5;URL=listado_de_mi2.php" http-equiv="REFRESH">-->
<?php
$rslista=mysql_query($slista,$conn);
$lim_inferior=1;
$lim_superior=1;
$total_paginas = ceil(mysql_num_rows($rslista) / $t);
if (!empty($rslista)) 
{
 $resaltador=0;
 while($rwlista=mysql_fetch_array($rslista))
 {
	 //$valor_vect=$row["libroregistro_cod_registro"];
	if ($lim_inferior>$inicio && $lim_superior<=$t)
	{
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

<td align="center"><?php echo $rwlista[registrodoc1_fecha_elaboracion];?>
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
	}//FIN DE IF
$lim_inferior++;
}// FIN DE WHILE 
	/*
		echo "<p class=fonty>";
		if ($pg != 0) {
		$url = $pg - 1;
		echo "<a href='$PHP_SELF?pg=".$url."'>&laquo; Anterior</a>&nbsp;";
		} else {
		echo " ";
		}
		for ($i = 0; $i <= $pages; $i++) {
		if ($i == $pg) {
		if ($i == "0") {
		echo "<b> 1 </b>";
		} else {
		$i = $i+1;
		echo "<b> ".$i." </b>";
		}
		} else {
		if ($i == "0") {
		echo "<a href=$PHP_SELF?pg=".$i.">1</a> ";
		} else {
		echo "<a href='$PHP_SELF?pg=".$i."'>";
		$i = $i+1;
		echo $i."</a>&nbsp;";
		}
		}
		}
		if ($pg < $pages) {
		$url = $pg + 1;
		echo "<a href='$PHP_SELF?pg=".$url."'>Siguiente &raquo;</a>";
		} else {
		echo " ";
		}
		echo "</p>";
		*/
}
?>
</table>
</center>
</meta>

<center>
<?php
for ($i=1;$i<=$total_paginas;$i++) 
{
	if ($i!=$pagina) 
	{	$siguiente=$i;
	echo "<a href=$PHP_SELF?pagina=$i><font color=#FF6600>$i</font></a> ";
	}
	else {
	echo " | ".$i." | ";
	}
}

?>
<br>
</form>
</center>

<?php
}
include("final.php");
?>
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
$depto=$_SESSION["departamento"];
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
<center><b style=" font-size:18px">CORRESPONDENCIA OBSERVADA</b></center></p></center>
<table width="50%" cellspacing="1" cellpadding="1" border="0" align="center">

</table>
<?php 
	$slista="SELECT 
	registrodoc1_hoja_ruta, registrodoc1_cite, registrodoc1_fecha_elaboracion, registrodoc1_fecha_recepcion, usuario_nombre, registrodoc1_referencia, documentos_descripcion, registrodoc1_estado, registrodoc1_asociar, registrodoc1_asociar_h_r, registrodoc1_cc, registrodoc1_cite, usuario_ocupacion
	FROM `registrodoc1`, `documentos`, `usuario` 
	where registrodoc1_depto='$depto'
	and registrodoc1_de=usuario_ocupacion
	and registrodoc1_situacion='O'
	and registrodoc1_hoja_ruta<>'0'
	and registrodoc1_asociar<>'si'
	and registrodoc1_doc=documentos_sigla
	GROUP BY registrodoc1_cite ORDER BY registrodoc1_n_h_r ASC";

$rslista=mysql_query($slista,$conn);
$lim_inferior=1;
$lim_superior=1;
$total_paginas = ceil(mysql_num_rows($rslista) / $t);
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

		<td align="center"><a href="seguimiento_doc.php?hr1=<?php echo $doc_arch;?>" onMouseOver="window.status='Guia de sitio';return true" onMouseOut="window.status='';return true"><img src="images/observacion.png" onMouseOver="this.src='images/observacion1.png'" onMouseOut="this.src='images/observacion.png'" /></a></td>
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

?>
<?php
include("final.php");
?>
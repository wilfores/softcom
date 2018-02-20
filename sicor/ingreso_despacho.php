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
$cargo_unico=$_SESSION["cargo_asignado"];
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
if(isset($_POST['imprimir']))
{
	$nro_registro123=encryto($_POST['sel_ingreso']);
	
	$aux1=mysql_query("select * from seguimiento where seguimiento_nro_registro='$_POST[sel_ingreso]' and seguimiento_cod_institucion='$cod_institucion' order by seguimiento_codigo_seguimiento");
	if ($filas=mysql_fetch_array($aux1))
		{
			$usuario_destino=$filas["seguimiento_destinatario"];
			$unidad_destino=$filas["seguimiento_cod_departamento"];
		}

	$huaychi=mysql_query("select * from instituciones where instituciones_cod_institucion = '$cod_institucion'",$conn);
	if ($huaychi2=mysql_fetch_array($huaychi))
	{
	  $hoja_tipoaa=$huaychi2["instituciones_tipo_hoja"];
	}

	if ($hoja_tipoaa=='4')
	{
	?>
    <script language="JavaScript">
				
				window.open('imprime_hoja34.php?imprimeh=<?php echo $nro_registro123;?>&unidad_destino=<?php echo $unidad_destino;?>&usuario_destino=<?php echo $usuario_destino;?>','Imprimir')		
			    window.self.location="ingreso_despacho.php";
			</script>
	<?php	
	}
}
$ssql="SELECT * FROM ingreso WHERE '$cod_institucion'=ingreso_cod_institucion AND ('T'=ingreso_estado) and ingreso_cod_usr='$cargo_unico' ORDER BY ingreso_nro_registro DESC";

$rss=mysql_query($ssql,$conn);
?>
<script language="JavaScript">
<!--
function CopiaValor(objeto) {
	document.ingreso.sel_ingreso.value = objeto.value;
}

function Retornar(){
	document.ingreso.action="principal.php";
	document.ingreso.submit();
}
</script>

<br>
<p class="fuente_titulo">
<center><b>LISTA DE CORRESPONDENCIA DESPACHADA Y NO ACEPTADA</b></center></p></center>

<table width="100%" cellspacing="1" cellpadding="1" border="0">
<tr class="border_tr2">

<td width="3%" align="center">&nbsp;<b>*</b></td>
<td width="13%" align="center"><span>Hoja Ruta</td>
<td width="12%" align="center"><span>Fecha Recepcion</td>
<td width="12%" align="center"><span >Fecha Despacho</td>
<td width="4%" align="center"><span >Entrada</td>
<td width="10%" align="center"><span >Tipo Doc</td>
<td width="15%" align="center"><span >Remitente</td>
<td width="15%" align="center"><span >Destinatario</td>
<td width="10%" align="center"><span >Cite Doc.</td>
<td width="3%" align="center"><span >Hojas</td>
<td width="3%" align="center"><span >Anexo</td>
</tr>
</table>
<DIV class=tableContainer id=tableContainer>
<div style="overflow:auto; width:100%; height:210px; align:left;">
<center>
<table width="100%" cellspacing="1" cellpadding="1" border="0">
<form name="ingreso" method="POST">
<?php
if (!empty($rss)) 
{
 $resaltador=0;
 while($row=mysql_fetch_array($rss))
 {
      if ($resaltador==0)
	  {
       echo "<tr class=truno><td align=center width=3%>";
	   $resaltador=1;
      }
	  else
	  {
       echo "<tr class=trdos><td align=center width=3%>";
   	   $resaltador=0;
	  }
 
?>
<input type="checkbox" name="cod_ingreso" value="<?php echo $row["ingreso_nro_registro"];?>" onclick="javascript:CopiaValor(this);"/>
</td>
<td align="center" width="13%"><?php echo $row["ingreso_hoja_ruta"];?></td>
<td align="center" width="12%"><?php echo $row["ingreso_fecha_ingreso"]." ". $row["ingreso_hora_ingreso"];?></td>
<?php 
$nro_registro = $row["ingreso_nro_registro"];
$rss2 = mysql_query("SELECT * FROM seguimiento WHERE '$nro_registro'=seguimiento_nro_registro and seguimiento_cod_institucion='$cod_institucion' ORDER BY seguimiento_codigo_seguimiento DESC",$conn);
while($row2=mysql_fetch_array($rss2)){
  $usuario_des = $row2["seguimiento_destinatario"];
  $fecha_deriva = $row2["seguimiento_fecha_deriva"];
}
$tipo = $row["ingreso_hoja_ruta_tipo"];
if ($tipo=="e") {
  $tipo_hr = "externo";
} else 
{ $tipo_hr = "interno"; }
?>
<td align="center" width="12%"><?php echo $fecha_deriva; ?></td>
<td align="center" width="4%"><?php echo $tipo_hr; ?></td>
<td align="center" width="10%"><?php echo $row["ingreso_descripcion_clase_corresp"];?></td>
<td align="center" width="15%">
<?php
if ($tipo=="e")
{
  echo $row["ingreso_remitente"];
} else 
{ 
	$valor_clave=$row["ingreso_remitente"];
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
?>
</td>
<td align="center" width="15%">
<?php  
    $valor_clave=$usuario_des;
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
</td>
<td align="center" width="10%"><?php echo $row["ingreso_numero_cite"];?></td>
<td align="center" width="3%"><?php echo $row["ingreso_cantidad_hojas"];?></td>
<td align="center" width="3%"><?php echo $row["ingreso_nro_anexos"];?></td>
</tr>
<?php
}   
}
?>
</table>
</center>
</div>
<br>
<center>
<table width="70%" cellspacing="2" cellpadding="2" border="0">
<tr class="border_tr">
<td width="95%" align="center">
<input type="hidden" name="sel_ingreso">
<input type="hidden" name="cod_institucion" value="<?php echo $cod_institucion;?>">
<input type="submit" name="imprimir" value="Imprimir" class="boton"/>
<input type="reset" name="cancelar" value="Cancelar" onClick="Retornar();" class="boton" />
</td>
</tr>
</table>
</form>

</center>
<?php
include("final.php");
?>
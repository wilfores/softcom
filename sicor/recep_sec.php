<?php
include("script/functions.inc");
include("../conecta.php");
include("script/cifrar.php");
$cod_institucion=$_SESSION["institucion"];
$cargo_unico=$_SESSION["cargo_asignado"];
$sw=0;

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

	if (!isset($_GET['orden']))
	{
            $orden = "seguimiento_fecha_deriva";
	}
	else
	{
            $orden=$_GET['orden'];
	}
        
$ssql="SELECT * FROM seguimiento
       WHERE '$cargo_unico'= seguimiento_destinatario
       AND (seguimiento_tipo='A' OR seguimiento_tipo='R')
       AND seguimiento_estado='P' ORDER BY ".$orden." DESC";
$rss=mysql_query($ssql,$conn);
?>

<STYLE type="text/css"> 
    A:link {text-decoration:none;color:#FFFFFF;} 
    A:visited {text-decoration:none;color:#CEDCEA;} 
    A:active {text-decoration:none;color:#FFFFFF;} 
    A:hover {text-decoration:underline;color:#DDE5EE;} 
</STYLE>

<script language="JavaScript">
function CopiaValor(objeto) {
	document.recepcion.sel_derivar.value = objeto.value;
}

function Retornar()
{
	document.recepcion.action="principal.php";
	document.recepcion.submit();
}
</script>

<br>
<p class="fuente_titulo"><center><b>RECEPCI&Oacute;N DE CORRESPONDENCIA POR DEPARTAMENTO</b>
</center></p>
<div style="overflow:auto; width:100%; height:400px; align:left;">

<table width="100%" cellspacing="1" cellpadding="1" border="1" style="font-size: 8pt;">
<tr class="border_tr2" style="font-size: 8pt;" bgcolor="#BCCFEF">
<td width="4%" align="center"><span class="fuente_normal">Prioridad</td>
<td width="10%" align="center"><span class="fuente_normal"><a href="recepcion_lista.php?orden=seguimiento_hoja_ruta" style="color:#0000FF">Hoja de Ruta</a></td>
<td width="3%" align="center"><span class="fuente_normal">Adj</td>
<td width="10%" align="center"><span class="fuente_normal"><a href="recepcion_lista.php?orden=seguimiento_fecha_deriva" style="color:#0000FF">Fecha Despacho</a></td>
<td width="13%" align="center"><span class="fuente_normal">Origen/Documento</td>
<td width="4%" align="center"><span class="fuente_normal">Tipo</td>
<td width="10%" align="center"><span class="fuente_normal"><a href="recepcion_lista.php?orden=seguimiento_remitente" style="color:#0000FF">Remitente</a></td>
<td width="15%" align="center"><span class="fuente_normal">Unidad/Remitente</td>
<td width="19%" align="center"><span class="fuente_normal">Observaciones</td>
<!--<td colspan="3" width="12%" align="center"><span class="fuente_normal">*</td>-->
</tr>
<!--
</table>

<DIV class=tableContainer id=tableContainer>
<div style="overflow:auto; width:100%; height:210px; align:left;">
<center>
<table width="100%" cellspacing="1" cellpadding="1" border="0">
-->
<form name="recepcion" method="POST">
<?php
$resaltador=0;
if (mysql_num_rows($rss) > 0) 
{
   while($row=mysql_fetch_array($rss))
   {
		 $limite= $row["seguimiento_fecha_plazo"];
		 
		  if ($resaltador==0)
			  {
				   echo "<tr class=truno bgcolor=#E3E8EC>";
				   $resaltador=1;
			  }
			  else
			  {
				   echo "<tr class=trdos>";
				   $resaltador=0;
			  }
?>
<!--<tr style="font-size: 8pt; color: #0000FF;">-->
<td width="4%" align="center">
<?php
	switch ($row["seguimiento_prioridad"])
		{
			case 'Alta':echo "<img src=images/alta.gif>";break;
			case 'Media':echo "<img src=images/media.gif>";break;
			case 'Baja':echo "<img src=images/baja.png>";break;
		}
?>
</td>

<td align=left width="10%" valign=middle>
	<?php
    /*******************************************************************************************
    $fechalimite_plazo=explode("-",$limite) sacamos El A?o de una fecha Ej. 2010 de 2010-04-22
    sss********************************************************************************************/
    $fechalimite_plazo=explode("-",$limite);
	   // if (($limite <= date("Y-m-d")) AND ($fechalimite_plazo[0] > '2009'))
    
    if (($limite >= date("Y-m-d")))
    {
       echo "<img src=\"images/alerta.gif\" border=0 align=center/>";     
    }
    $datosv = cifrar($row["seguimiento_codigo_seguimiento"]);
    ?>
    
    <a href="visualizar.php?datosv=<?php echo $datosv;?>" style="color:#184E93" target="mainFrame">
        <?php echo $row["seguimiento_hoja_ruta"];?>
    </a>
</td>

<?php 
$nro_registro=$row["seguimiento_nro_registro"];
$ssql2 = "SELECT * FROM ingreso WHERE '$nro_registro'=ingreso_nro_registro
          AND '$cod_institucion'=ingreso_cod_institucion";
$rss2 = mysql_query($ssql2,$conn);
if(mysql_num_rows($rss2) > 0)
{
	$row2=mysql_fetch_array($rss2);
	$hoja_ruta_tipo = $row2["ingreso_hoja_ruta_tipo"];
   ?>
   <td width="3%" align="center"><span class="fuente_normal"><b>
   <?php
        if($hoja_ruta_tipo=="e")
        {
            if($row2["ingreso_adjunto_correspondencia"]!="")
            {
            ?>
                    <a href="<?php echo $row2["ingreso_adjunto_correspondencia"]; ?>" target="_blank"><img src="images/adjunto.jpg" border="0" /></a>
            <?php
            }
            else
            {
            ?>
                   &nbsp;
            <?php
            }
        }
        else
        {
        ?>
            <a href="archivo_adjunto.php?valor=<?php echo cifrar($row2["ingreso_numero_cite"]);?>">
                <img src="images/documentos.png" border="0" alt="archivo" />
            </a>
        <?php
        }
      ?>
            </b></span></td>
      <?php


}
?>
<td align="left" width="10%"><?php echo $row["seguimiento_fecha_deriva"];?></td>
<td align="left" width="13%">
<?php
if ($hoja_ruta_tipo == "e") {
  echo $row2["ingreso_entidad_remite"];
  $tipo_hoja = "Externo";
} else {
  $tipo_hoja = "Interno";
  $depart = $row2["ingreso_cod_departamento"];
  
  /*OBTIENE LA DESCRIPCION DEL DEPARTAMENTO*/
  $ssqlnew = "SELECT * FROM departamento WHERE '$depart'=departamento_cod_departamento";
  $rssnew = mysql_query($ssqlnew,$conn);
  if(mysql_num_rows($rssnew) > 0)
	{
	  $rownew = mysql_fetch_array($rssnew);
	  echo $rownew["departamento_descripcion_dep"];
	}
  mysql_free_result($rssnew);
}
echo "</td>";
?>
</td>
<td align="center" width="5%"><?php echo $tipo_hoja;?></td>
<td align="left" width="10%">
<?php
if ($hoja_ruta_tipo=='e' AND $row["seguimiento_fecha_plazo"] == NULL )
{
	if ($row["seguimiento_dpto_remite"]==0)
	{
	echo $row["seguimiento_remitente"];
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
			}
		}
}
?>
</td>
<?php mysql_free_result($rss2); ?>
<td align="left" width="15%">
<?php 
$unidad_origen=$row["seguimiento_dpto_remite"];
if ($unidad_origen == 0) 
	{
		 echo "Ventanilla";
	}
	else
	{
		 $rsso = mysql_query("SELECT departamento_descripcion_dep FROM departamento WHERE '$unidad_origen'=departamento_cod_departamento",$conn);
		 if(mysql_num_rows($rsso)> 0)
		 {
			$rowo = mysql_fetch_array($rsso);
			 echo $rowo["departamento_descripcion_dep"];
		 }
	}
?>
</td>
<td align="left" width="20%">

<?php 
	echo $row["seguimiento_observaciones"];
?>

</td>
</tr>
<tr bgcolor="maroon">
<?php
$datos = cifrar($row["seguimiento_codigo_seguimiento"]);
if ($row["seguimiento_tipo"]=="R") {
?>

<td align="center" colspan="9">
<a href="derivar.php?datos=<?php echo $datos;?>" class="botonte">Derivar</a>
<a href="terminar.php?datos=<?php echo $datos;?>" class="botonte">Terminar</a>
<a href="ingreso_nota.php?datos=<?php echo $datos;?>" class="botonte">Responder</a>
</td>
<?php
 } else 
 {  
?>
<td align="center" colspan="9"><a href="recibido.php?datos=<?php echo $datos;?>" class="botonte">&nbsp;Recepcionar&nbsp;</a></td>
<?php
 } 
 ?>
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
<!--
<table width="70%" cellspacing="2" cellpadding="2" border="0">
<tr class="border_tr">
<td width="95%" align="center">
<input type="hidden" name="sel_derivar">
<input type="reset" name="cancelar" value="Cancelar" onClick="Retornar();" class="boton" />
</td>
</tr>
</table>
-->
</form>
</center>



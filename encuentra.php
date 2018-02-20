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
?>
	<STYLE type="text/css"> 
        A:link {text-decoration:none;color:#FFFFFF;} 
        A:visited {text-decoration:none;color:#CEDCEA;} 
        A:active {text-decoration:none;color:#FFFFFF;} 
        A:hover {text-decoration:underline;color:#DDE5EE;} 
    </STYLE>
    <script language="JavaScript">
    function Imprimir(){
       document.impresion.action="imprime_seguimiento.php";
       document.impresion.target="_blank";
       document.impresion.submit();
    }
    function Retornar(){
       document.impresion.action="seguimiento.php";
       document.impresion.submit();
    }
    </script>
    
    <?php
	if (empty($_POST['busqueda']))
	{
	?>
	 <script language="JavaScript">
	window.self.location="seguimiento.php";
	 </script>
    <?php  
	}
	
	
$busqueda = trim($_POST['busqueda']);
$clase = trim($_POST['clase']);

switch ($clase)
{
	case 'por_hoja': 
    if ($_SESSION["nivel_usr"]==2) 
	{	
	  $ssql="select * from ingreso where '$cod_institucion'=ingreso_cod_institucion AND ingreso_hoja_ruta LIKE '%$busqueda%'";
	  $imp = "select * from ingreso where '$cod_institucion'=ingreso_cod_institucion AND ingreso_hoja_ruta LIKE '%$busqueda%' ";
	} 
	else 
	{
      $ssql="select * from ingreso where '$cod_institucion'=ingreso_cod_institucion AND ingreso_hoja_ruta LIKE '%$busqueda%'";	
	  $imp ="select * from ingreso where '$cod_institucion'=ingreso_cod_institucion AND ingreso_hoja_ruta LIKE '%$busqueda%'";	
	}
	break;
	
	case 'por_referencia': 
	$ssql="select * from ingreso where ingreso_referencia LIKE '%$busqueda%' AND '$cod_institucion'=ingreso_cod_institucion ORDER BY ingreso_hoja_ruta DESC";
	$imp = "select * from ingreso where ingreso_referencia LIKE '%$busqueda%' AND '$cod_institucion'=ingreso_cod_institucion ORDER BY ingreso_hoja_ruta DESC";
	break;
	
	case 'por_cite': 
	$ssql="select * from ingreso where ingreso_numero_cite LIKE '%$busqueda%' AND '$cod_institucion'=ingreso_cod_institucion ORDER BY ingreso_hoja_ruta DESC";
	$imp = "select * from ingreso where ingreso_numero_cite LIKE '%$busqueda%' AND '$cod_institucion'=ingreso_cod_institucion ORDER BY ingreso_hoja_ruta DESC";
	break;
	
	case 'por_fecha': 
	$ssql="select * from ingreso where ingreso_fecha_ingreso LIKE '%$busqueda%' AND '$cod_institucion'=ingreso_cod_institucion ORDER BY ingreso_hoja_ruta DESC";
	$imp = "select * from ingreso where ingreso_fecha_ingreso LIKE '%$busqueda%' AND '$cod_institucion'=ingreso_cod_institucion ORDER BY ingreso_hoja_ruta DESC";
	break;
	
	case 'por_eremitente': 
	$ssql="select * from ingreso where ingreso_entidad_remite LIKE '%$busqueda%' AND ingreso_hoja_ruta_tipo='e' AND '$cod_institucion'=ingreso_cod_institucion ORDER BY ingreso_hoja_ruta DESC";
	$imp = "select * from ingreso where ingreso_entidad_remite LIKE '%$busqueda%' AND ingreso_hoja_ruta_tipo='e' AND '$cod_institucion'=ingreso_cod_institucion ORDER BY ingreso_hoja_ruta DESC";
	break;
	
	case 'por_remitente': 
	        $conexion = mysql_query("SELECT * FROM usuario WHERE usuario_nombre LIKE '%$busqueda%' AND usuario_active='1'",$conn);
			if($fila_clave=mysql_fetch_array($conexion))
			{
			$valor_clave=$fila_clave["usuario_ocupacion"];
			$ssql= "select * from ingreso where (ingreso_remitente='$valor_clave' OR ingreso_remitente LIKE '%$busqueda%') AND '$cod_institucion'=ingreso_cod_institucion ORDER BY ingreso_hoja_ruta DESC";
	        $imp = "select * from ingreso where (ingreso_remitente='$valor_clave' OR ingreso_remitente LIKE '%$busqueda%') AND '$cod_institucion'=ingreso_cod_institucion ORDER BY ingreso_hoja_ruta DESC";
		    } 
			else
			{
			$ssql= "select * from ingreso where ingreso_remitente LIKE '%$busqueda%' AND '$cod_institucion'=ingreso_cod_institucion ORDER BY ingreso_hoja_ruta DESC";
	        $imp = "select * from ingreso where ingreso_remitente LIKE '%$busqueda%' AND '$cod_institucion'=ingreso_cod_institucion ORDER BY ingreso_hoja_ruta DESC";
			}
  	 
	break;
	
	case 'por_funcionariop': 
	      if ($_POST['busqueda']=='%')
			{
		$ssql="select ingreso.ingreso_nro_registro,ingreso.ingreso_hoja_ruta,ingreso.ingreso_entidad_remite,seguimiento.seguimiento_destinatario,ingreso.ingreso_hoja_ruta_tipo,ingreso.ingreso_fecha_ingreso,ingreso.ingreso_referencia, seguimiento.seguimiento_estado, seguimiento.seguimiento_tipo 
		from ingreso INNER JOIN seguimiento ON ingreso.ingreso_nro_registro=seguimiento.seguimiento_nro_registro
		AND seguimiento.seguimiento_estado='P' 
		AND (seguimiento.seguimiento_tipo='R' OR seguimiento.seguimiento_tipo='A')
		AND '$cod_institucion'=ingreso.ingreso_cod_institucion
		AND '$cod_institucion'=seguimiento.seguimiento_cod_institucion
		WHERE  seguimiento.seguimiento_destinatario LIKE '%$busqueda%'  ORDER BY ingreso_hoja_ruta DESC";

		$imp = "select ingreso.ingreso_nro_registro,ingreso.ingreso_hoja_ruta,ingreso.ingreso_entidad_remite,seguimiento.seguimiento_destinatario,ingreso.ingreso_hoja_ruta_tipo,ingreso.ingreso_fecha_ingreso,ingreso.ingreso_referencia, seguimiento.seguimiento_estado, seguimiento.seguimiento_tipo 
		from ingreso,seguimiento 
		WHERE seguimiento.seguimiento_estado='P' 
		AND (seguimiento.seguimiento_tipo='R' OR seguimiento.seguimiento_tipo='A') 
		AND ingreso.ingreso_nro_registro=seguimiento.seguimiento_nro_registro  
		AND seguimiento.seguimiento_destinatario LIKE '%$busqueda%'
		AND '$cod_institucion'=ingreso.ingreso_cod_institucion 
		AND '$cod_institucion'=seguimiento.seguimiento_cod_institucion  ORDER BY ingreso_hoja_ruta DESC";
			}
			else
			{
			$conexion = mysql_query("SELECT * FROM usuario WHERE usuario_nombre LIKE '%$busqueda%' AND usuario_active='1'",$conn);
			if($fila_clave=mysql_fetch_array($conexion))
			{
			$busqueda1=$fila_clave["usuario_ocupacion"];
			} 
		$ssql="select ingreso.ingreso_nro_registro,ingreso.ingreso_hoja_ruta,ingreso.ingreso_entidad_remite,seguimiento.seguimiento_destinatario,ingreso.ingreso_hoja_ruta_tipo,ingreso.ingreso_fecha_ingreso,ingreso.ingreso_referencia, seguimiento.seguimiento_estado, seguimiento.seguimiento_tipo 
		from ingreso INNER JOIN seguimiento ON ingreso.ingreso_nro_registro=seguimiento.seguimiento_nro_registro
		AND seguimiento.seguimiento_estado='P' 
		AND (seguimiento.seguimiento_tipo='R' OR seguimiento.seguimiento_tipo='A')
		AND '$cod_institucion'=ingreso.ingreso_cod_institucion
		AND '$cod_institucion'=seguimiento.seguimiento_cod_institucion
		WHERE  seguimiento.seguimiento_destinatario='$busqueda1'  ORDER BY ingreso_hoja_ruta DESC";

		$imp = "select ingreso.ingreso_nro_registro,ingreso.ingreso_hoja_ruta,ingreso.ingreso_entidad_remite,seguimiento.seguimiento_destinatario,ingreso.ingreso_hoja_ruta_tipo,ingreso.ingreso_fecha_ingreso,ingreso.ingreso_referencia, seguimiento.seguimiento_estado, seguimiento.seguimiento_tipo 
		from ingreso,seguimiento 
		WHERE seguimiento.seguimiento_estado='P' 
		AND (seguimiento.seguimiento_tipo='R' OR seguimiento.seguimiento_tipo='A') 
		AND ingreso.ingreso_nro_registro=seguimiento.seguimiento_nro_registro  
		AND seguimiento.seguimiento_destinatario='$busqueda1'
		AND '$cod_institucion'=ingreso.ingreso_cod_institucion 
		AND '$cod_institucion'=seguimiento.seguimiento_cod_institucion  ORDER BY ingreso_hoja_ruta DESC";
			}
	        
	break;

	case 'por_funcionariot': 
	        if ($_POST['busqueda']=='%')
			{
	$ssql="select			ingreso.ingreso_nro_registro,ingreso.ingreso_hoja_ruta,ingreso.ingreso_entidad_remite,seguimiento.seguimiento_destinatario,ingreso.ingreso_hoja_ruta_tipo,ingreso.ingreso_fecha_ingreso,ingreso.ingreso_referencia, seguimiento.seguimiento_estado 
	from ingreso INNER JOIN seguimiento  ON ingreso.ingreso_nro_registro=seguimiento.seguimiento_nro_registro
	AND  seguimiento.seguimiento_estado='T'
	AND '$cod_institucion'=ingreso.ingreso_cod_institucion 
	AND '$cod_institucion'=seguimiento.seguimiento_cod_institucion
	WHERE  seguimiento.seguimiento_destinatario LIKE '%$_POST[busqueda]%'  ORDER BY ingreso_hoja_ruta DESC";
	$imp = "select ingreso.ingreso_nro_registro,ingreso.ingreso_hoja_ruta,ingreso.ingreso_entidad_remite,seguimiento.seguimiento_destinatario,ingreso.ingreso_hoja_ruta_tipo,ingreso.ingreso_fecha_ingreso,ingreso.ingreso_referencia, seguimiento.seguimiento_estado from ingreso,seguimiento WHERE seguimiento.seguimiento_estado='T' AND ingreso.ingreso_nro_registro=seguimiento.seguimiento_nro_registro  AND seguimiento.seguimiento_destinatario LIKE '%$_POST[busqueda]%'AND '$cod_institucion'=ingreso.ingreso_cod_institucion AND '$cod_institucion'=seguimiento.seguimiento_cod_institucion  ORDER BY ingreso_hoja_ruta DESC";
	break;
			}
			else
			{
			$conexion = mysql_query("SELECT * FROM usuario WHERE usuario_nombre LIKE '%$_POST[busqueda]%' AND usuario_active='1'",$conn);
			if($fila_clave=mysql_fetch_array($conexion))
			{
			  	$busqueda1=$fila_clave["usuario_ocupacion"];
            }  		 

	$ssql="select			ingreso.ingreso_nro_registro,ingreso.ingreso_hoja_ruta,ingreso.ingreso_entidad_remite,seguimiento.seguimiento_destinatario,ingreso.ingreso_hoja_ruta_tipo,ingreso.ingreso_fecha_ingreso,ingreso.ingreso_referencia, seguimiento.seguimiento_estado 
	from ingreso INNER JOIN seguimiento  ON ingreso.ingreso_nro_registro=seguimiento.seguimiento_nro_registro
	AND  seguimiento.seguimiento_estado='T'
	AND '$cod_institucion'=ingreso.ingreso_cod_institucion 
	AND '$cod_institucion'=seguimiento.seguimiento_cod_institucion
	WHERE  seguimiento.seguimiento_destinatario='$busqueda1'  ORDER BY ingreso_hoja_ruta DESC";
	$imp = "select ingreso.ingreso_nro_registro,ingreso.ingreso_hoja_ruta,ingreso.ingreso_entidad_remite,seguimiento.seguimiento_destinatario,ingreso.ingreso_hoja_ruta_tipo,ingreso.ingreso_fecha_ingreso,ingreso.ingreso_referencia, seguimiento.seguimiento_estado from ingreso,seguimiento WHERE seguimiento.seguimiento_estado='T' AND ingreso.ingreso_nro_registro=seguimiento.seguimiento_nro_registro  AND seguimiento.seguimiento_destinatario='$busqueda1' AND '$cod_institucion'=ingreso.ingreso_cod_institucion AND '$cod_institucion'=seguimiento.seguimiento_cod_institucion  ORDER BY ingreso_hoja_ruta DESC";
	      }
	break;
			
	case 'por_departamento': 
      
	  $ssql22 = "SELECT * FROM departamento WHERE departamento_descripcion_dep LIKE '%$_POST[busqueda]%'";
	  $rss22 = mysql_query($ssql22, $conn);
	  if($row22 = mysql_fetch_array($rss22))
	  {
	  $busqueda = $row22["departamento_cod_departamento"];
	  }
	$ssql="select ingreso.ingreso_nro_registro,ingreso.ingreso_hoja_ruta,ingreso.ingreso_entidad_remite,seguimiento.seguimiento_remitente,seguimiento.seguimiento_destinatario,ingreso.ingreso_hoja_ruta_tipo,ingreso.ingreso_fecha_ingreso,ingreso.ingreso_referencia 
	from ingreso,seguimiento 
	WHERE ingreso.ingreso_nro_registro=seguimiento.seguimiento_nro_registro  
	AND seguimiento.seguimiento_cod_departamento='$busqueda' 
	AND '$cod_institucion'=ingreso.ingreso_cod_institucion 
	AND '$cod_institucion'=seguimiento.seguimiento_cod_institucion ORDER BY ingreso_hoja_ruta DESC";
	$imp = "select ingreso.ingreso_nro_registro,ingreso.ingreso_hoja_ruta,ingreso.ingreso_entidad_remite,seguimiento.seguimiento_remitente,seguimiento.seguimiento_destinatario,ingreso.ingreso_hoja_ruta_tipo,ingreso.ingreso_fecha_ingreso,ingreso.ingreso_referencia from ingreso,seguimiento WHERE ingreso.ingreso_nro_registro=seguimiento.seguimiento_nro_registro  AND seguimiento.seguimiento_cod_departamento='$busqueda' AND '$cod_institucion'=ingreso.ingreso_cod_institucion AND '$cod_institucion'=seguimiento.seguimiento_cod_institucion ORDER BY ingreso_hoja_ruta DESC";
	break;

case 'por_pendientes': 
 	$ssql="select ingreso.ingreso_nro_registro,ingreso.ingreso_hoja_ruta,seguimiento.seguimiento_remitente,seguimiento.seguimiento_destinatario,ingreso.ingreso_hoja_ruta_tipo,ingreso.ingreso_fecha_ingreso,ingreso.ingreso_referencia 
	from ingreso,seguimiento 
	WHERE ingreso.ingreso_nro_registro=seguimiento.seguimiento_nro_registro  
	AND seguimiento.seguimiento_tipo='A' 
	AND '$cod_institucion'=ingreso.ingreso_cod_institucion 
	AND '$cod_institucion'=seguimiento.seguimiento_cod_institucion ORDER BY ingreso_hoja_ruta DESC";
	$imp = "select ingreso.ingreso_nro_registro,ingreso.ingreso_hoja_ruta,seguimiento.seguimiento_remitente,seguimiento.seguimiento_destinatario,ingreso.ingreso_hoja_ruta_tipo,ingreso.ingreso_fecha_ingreso,ingreso.ingreso_referencia 
	from ingreso,seguimiento 
	WHERE ingreso.ingreso_nro_registro=seguimiento.seguimiento_nro_registro  
	AND seguimiento.seguimiento_tipo='A' 
	AND '$cod_institucion'=ingreso.ingreso_cod_institucion 
	AND '$cod_institucion'=seguimiento.seguimiento_cod_institucion ORDER BY ingreso_hoja_ruta DESC";
		break;
}
$respi=mysql_query($ssql,$conn);
?>

<br>
<center><b>CORRESPONDENCIA ENCONTRADA</b></center>
<br />

<table width="100%" cellspacing="1" cellpadding="1" border="0">
<tr class="border_tr2">
<td width="8%" align="center"><span class="fuente_normal">Hoja Ruta</td>
<td width="20%" align="center"><span class="fuente_normal">Entidad Remitente</td>
<?php 
if ($_POST['clase'] == "por_funcionariop" or $_POST['clase']=="por_departamento" or $_POST['clase'] == "por_funcionariot" or $_POST['clase'] == "por_pendientes") 
{
 echo "<td width=\"15%\" align=\"center\"><span class=\"fuente_normal\">Destinatario</td>";
} else {
  echo "<td width=\"15%\" align=\"center\"><span class=\"fuente_normal\">Remitente</td>";
}
?>
<td width="7%" align="center"><span class="fuente_normal">Tipo</td>
<td width="10%" align="center"><span class="fuente_normal">Fecha de Ingreso</td>
<td width="15%" align="center"><span class="fuente_normal">Referencia</td>
<td width="5%" align="center"><span class="fuente_normal">Accion</td>
</tr>
</table>
<DIV class=tableContainer id=tableContainer>
<div style="overflow:auto; width:100%; height:210px; align:left;">
<center>
<table width="100%" cellspacing="1" cellpadding="1" border="0">
<?php
if (!empty($respi)) 
{
	$resaltador=0;
 while($row=mysql_fetch_array($respi))
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
<td align="center" width="8%">
<?php echo $row["ingreso_hoja_ruta"];?>
</td>


<?php
$nro_registro=$row["ingreso_nro_registro"];
$ssql2 = "SELECT * FROM ingreso WHERE '$nro_registro'=ingreso_nro_registro and ingreso_cod_institucion='$cod_institucion'";
$rss2 = mysql_query($ssql2,$conn);
$row2=mysql_fetch_array($rss2);

$hoja_ruta_tipo = $row2["ingreso_hoja_ruta_tipo"];
  echo "<td align=\"justify\" width=\"20%\">";

if ($hoja_ruta_tipo == "e") {
  echo $row2["ingreso_entidad_remite"];
  $tipo_hoja = "Externo";
} else {
  $tipo_hoja = "Interno";
  $depart = $row2["ingreso_cod_departamento"];
  $ssqlnew = "SELECT * FROM departamento WHERE '$depart'=departamento_cod_departamento";
  $rssnew = mysql_query($ssqlnew,$conn);
  $rownew = mysql_fetch_array($rssnew);
  echo $rownew["departamento_descripcion_dep"];
  mysql_free_result($rssnew);
}
echo "</td>";
?>
</td>
<td align="left" width="15%">
<?php 
if ($_POST['clase'] == "por_funcionariop" OR $_POST['clase'] == "por_departamento" OR $_POST['clase'] == "por_funcionariot" )
{
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
} 
else 
{  

if ($_POST['clase']=="por_pendientes")
{
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
} 
else
{
	 if ($hoja_ruta_tipo=="i")
	 { 	$valor_clave=$row["ingreso_remitente"];
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
	  { echo $row["ingreso_remitente"];
	  }	
	  
 }
}

 
?>
</td>
<td align="center" width="7%"><?php echo $tipo_hoja;?></td>
<td align="center" width="10%"><?php echo $row2["ingreso_fecha_ingreso"];?></td>
<?php mysql_free_result($rss2);?>
<td align="left" width="15%">
<?php 
	echo $row["ingreso_referencia"];
	$historia = encryto($row["ingreso_nro_registro"]);
?>
</td>
<td width="5%" align="center">
<a href="historia.php?historia=<?php echo $historia;?>&busqueda=<?php echo $busqueda;?>&clase=<?php echo $clase;?>" class="botonte">Ver</a>
</td>
</tr>
<?php
}   
}
mysql_close($conn);
?>
</table>
</center>
</div>
<br>
<center>
<table width="70%" cellspacing="2" cellpadding="2" border="0">
<tr class="border_tr">
<td width="95%" align="center">
<form method="POST" name="impresion">
<input type="hidden" name="busqueda" value="<?php echo $_POST['busqueda'];?>" >
<input type="hidden" name="clase" value="<?php echo $_POST['clase'];?>" >
<input type="hidden" name="imp" value="<?php echo $imp;?>" >
<input type="reset" name="imprimir" value="Imprimir" class="boton" onClick="Imprimir();"/>
<input type="reset" name="cancelar" value="Cancelar" class="boton" onClick="Retornar();" />
</form>
</td>
</tr>
</table>

<?php
include("../final.php");
?>
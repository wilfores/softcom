<?php
include("../filtro.php");
?>
<?php
require_once("tcpdf/config/lang/eng.php");
require_once("tcpdf/tcpdf.php");
include("../conecta.php");
include("script/cifrar.php");
include("script/functions.inc");
include("../funcion.inc");
// create new PDF document
//$pdf = new TCPDF(PDF_PAGE_ORIENTATION, PDF_UNIT,PDF_PAGE_FORMAT,true); 
$pdf = new TCPDF(PDF_PAGE_ORIENTATION, PDF_UNIT, PDF_PAGE_FORMAT, true, 'UTF-8', false); 
// set document information
$pdf->SetCreator(PDF_CREATOR);
$pdf->SetAuthor("Nic Bolivia");
$pdf->SetTitle("Factura");
$pdf->SetSubject("Factura");
$pdf->SetKeywords("Factura");

//remove default header/footer
$pdf->setPrintHeader(false);
$pdf->setPrintFooter(false);
//set margins
$pdf->SetMargins(PDF_MARGIN_LEFT, PDF_MARGIN_TOP, PDF_MARGIN_RIGHT);
//set auto page breaks
//$pdf->SetAutoPageBreak(TRUE, PDF_MARGIN_BOTTOM);
//set image scale factor
$pdf->setImageScale(PDF_IMAGE_SCALE_RATIO); 
//set some language-dependent strings
$pdf->setLanguageArray($l); 
//initialize document
$pdf->AliasNbPages();
// set font*/
$pdf->SetFont('times', '', 7);
// add a page
$pdf->AddPage();
//Datos solo de ejemplos 
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
$nro_registro=descryto($_GET['imprimeh']);
//logo institucional
$institucion = $_SESSION["institucion"];
$prov=$_GET[proveido];
$ssqli = "SELECT * FROM instituciones WHERE '$institucion'=instituciones_cod_institucion";
$rssi = mysql_query($ssqli, $conn);
if ($rowi = mysql_fetch_array($rssi))
	{
		$logo = $rowi["instituciones_logo"];
		$cabecera = $rowi["instituciones_membrete"];
    }

$sql = "SELECT * FROM departamento WHERE '$_GET[unidad_destino]'=departamento_cod_departamento AND departamento_cod_institucion='$institucion'";
$res = mysql_query($sql,$conn);
$filas = mysql_fetch_array($res);
$unidad_destino = $filas["departamento_descripcion_dep"];


$ssql = "SELECT * FROM ingreso WHERE '$nro_registro'=ingreso_nro_registro AND ingreso_cod_institucion='$institucion'";
$rss = mysql_query($ssql,$conn);
if ($row=mysql_fetch_array($rss))
{
    $hoja_rutax = split("-",$row["ingreso_hoja_ruta"]);
	$hoja_rutax = $hoja_rutax[2];
	$hoja_rutax = split("/",$hoja_rutax);
	$hoja_rutax = $hoja_rutax[0];
	
	$lugarcito = $row["ingreso_lugar"];
	$guardar_tipo=$row["ingreso_hoja_ruta_tipo"];
	if ($row["ingreso_hoja_ruta_tipo"] == "e") 
		{
			 $tipo = "EXTERNA";
			  
		}
		else
		{
			  $tipo = "INTERNA";
		}

	$loguito="../logos/".$logo;
				
	if ($row["ingreso_hoja_ruta_tipo"] == "e") 
	{
		 $entidad_datos=$row["ingreso_entidad_remite"];
	} 
	else 
	{
		$departamento = $row["ingreso_cod_departamento"];
		$record = mysql_query("SELECT * FROM departamento WHERE '$departamento'=departamento_cod_departamento",$conn);
		$filita = mysql_fetch_array($record);
		$entidad_datos=$filita["departamento_descripcion_dep"];
	}

	if (!isset($_GET['usuario_destino']))
	{
	  $ssql2 = "SELECT * FROM seguimiento WHERE '$nro_registro'=seguimiento_nro_registro and seguimiento_cod_institucion='$institucion' order by seguimiento_nro_registro";
	  $rss2 = mysql_query($ssql2, $conn);
	  $row2 = mysql_fetch_array($rss2);
	  $usuario_destino=$row2["seguimiento_destinatario"];
	  $instruccion=$row2["seguimiento_codigo_instruccion"];
	  $fecha_deriva = $row2["seguimiento_fecha_deriva"];
	  $depto= $row2["seguimiento_cod_departamento"];
	  $rss4 = mysql_query("SELECT * FROM departamento WHERE '$depto'=departamento_cod_departamento",$conn);
	  $row4 = mysql_fetch_array($rss4);
	  $unidad_destino=$row4["departamento_descripcion_dep"];
	}  
	else 
	{

	  $ssql2 = "SELECT * FROM seguimiento WHERE '$nro_registro'=seguimiento_nro_registro AND '$institucion'=seguimiento_cod_institucion order by seguimiento_nro_registro";
	  $rss2	= mysql_query($ssql2, $conn);
	  $row2 = mysql_fetch_array($rss2);
	  $instruccion=$row2["seguimiento_codigo_instruccion"];
	  $fecha_deriva = $row2["seguimiento_fecha_deriva"];
	}

		
	$rss44 = mysql_query("SELECT * FROM instruccion WHERE instruccion_codigo_instruccion='$instruccion'",$conn);
	while($fila_instruccion=mysql_fetch_array($rss44))
	{
		$observaciones=elimina_acentos($fila_instruccion["instruccion_instruccion"]);
	}

	$var_sql_user=mysql_query("select * from usuario where usuario_ocupacion='$row[ingreso_cod_usr]'",$conn);
	if($fila_user=mysql_fetch_array($var_sql_user))
	{
	  $gestor=$fila_user["usuario_nombre"];
	}

	$tramite=$row["ingreso_hoja_ruta"];
	$cite=$row["ingreso_numero_cite"];
	$fecha=$row["ingreso_fecha_cite"];
	$fecha2=$row["ingreso_fecha_recepcion"];
	$procedencia=$entidad_datos;

	if ($guardar_tipo=='i')
	{
		$valor_clave=$row["ingreso_remitente"];
		$conexion = mysql_query("SELECT * FROM cargos WHERE '$valor_clave'=cargos_id",$conn);
		if($fila_clave=mysql_fetch_array($conexion))
		{
			$valor_clave=$fila_clave["cargos_id"];
			$conexion = mysql_query("SELECT * FROM cargos WHERE '$valor_clave'=cargos_id",$conn);
			if($fila_clave=mysql_fetch_array($conexion))
			{
				$valor_cargo=$fila_clave["cargos_id"];
				$conexion2 = mysql_query("SELECT * FROM usuario WHERE '$valor_cargo'=usuario_ocupacion",$conn);
				if($fila_cargo=mysql_fetch_array($conexion2))
				{
				$remitente=$fila_cargo["usuario_nombre"];
				}
			}	
		}
	}
	else
	{
	$remitente=$row["ingreso_remitente"];
	}

	if ($guardar_tipo=='i')
	{
		$valor_clave=$row["ingreso_cargo_remitente"];
		$conexion = mysql_query("SELECT * FROM cargos WHERE '$valor_clave'=cargos_id",$conn);
		if($fila_clave=mysql_fetch_array($conexion))
		{
		$cargo_remitente=elimina_acentos($fila_clave["cargos_cargo"]);
		}
	}
	else
	{
	$cargo_remitente=$row["ingreso_cargo_remitente"];
	}

	$tipodecambio='Ninguno';
	$adjuntos=$row["ingreso_nro_anexos"];
	$nodehojas=$row["ingreso_cantidad_hojas"];
	$prioridad=$row["ingreso_categoria"];
	$tipo_documento=$row["ingreso_descripcion_clase_corresp"];
	$referencia=elimina_acentos($row["ingreso_referencia"]);
	$areadestino=$unidad_destino;

	$valor_clave=$_GET['usuario_destino'];
	$conexion = mysql_query("SELECT * FROM cargos WHERE '$valor_clave'=cargos_id",$conn);
	if($fila_clave=mysql_fetch_array($conexion))
	{
		$valor_cargo=$fila_clave["cargos_id"];
		$conexion2 = mysql_query("SELECT * FROM usuario WHERE '$valor_cargo'=usuario_ocupacion",$conn);
		if($fila_cargo=mysql_fetch_array($conexion2))
		{
		$nombre_aux=elimina_acentos($fila_cargo["usuario_nombre"]);
		}
	}


	$prioridad_a="Normal";
	
	$valor_clave=$valor_cargo;
	$conexion = mysql_query("SELECT * FROM cargos WHERE '$valor_clave'=cargos_id",$conn);
	if($fila_clave=mysql_fetch_array($conexion))
	{
	$cargo_aux=elimina_acentos($fila_clave["cargos_cargo"]);
	}
}
/*
$cabeza1="<table border=\"1\" cellpadding=\"1\" cellspacing=\"1\" style=\"font-size:9px;\">
  <tr>
  <td width=\"104\" rowspan=\"2\"  align=\"center\"><img src=\"".$loguito."\" border=\"0\" height=\"55\" width=\"55\" /></td>
   
   <td colspan=\"3\" rowspan=\"2\" align=\"center\" width=\"301\"><br /><style=\"font-size:5px;\">".utf8_encode($cabecera)."</style><br/><strong  style=\"font-size:13px;\">HOJA DE RUTA<br />".$tipo." Nº ".utf8_encode($hoja_rutax)."</strong></td>
    <td width=\"113\" rowspan=\"2\"  align=\"center\"><img src=\"..\logos\LOGOSNIS.png\" border=\"0\" height=\"55\" width=\"55\" /></td> 
  </tr>
  <tr>

	
  </tr>
  <tr>
    <td align=\"left\" bgcolor=\"#ededed\" width=\"104\">PROCEDENCIA</td>
    <td width=\"301\">&nbsp;".utf8_encode($procedencia)."</td>
	<td align=\"center\" bgcolor=\"#ededed\" width=\"113\" style=\"font-size:12px;\"><strong>TRÁMITE</strong></td>
    
  </tr>
  <tr>
    <td align=\"left\" bgcolor=\"#ededed\" width=\"104\">LUGAR</td>
    <td width=\"301\">&nbsp;".utf8_encode($lugarcito)."</td>
	<td width=\"113\" align=\"center\">".utf8_encode($tramite)."</td>
  </tr>
  <tr>
    <td align=\"left\" bgcolor=\"#ededed\" width=\"104\">REMITENTE</td>
    <td colspan=\"3\" width=\"301\">&nbsp;".utf8_encode($remitente)."</td>
    <td colspan=\"2\" align=\"center\" bgcolor=\"#ededed\"  width=\"113\"  style=\"font-size:12px;\"><strong>CITE</strong></td>
  </tr>
  <tr>
    <td align=\"left\" bgcolor=\"#ededed\" width=\"104\">CARGO REMITENTE</td>
    <td colspan=\"3\" width=\"301\">&nbsp;".utf8_encode($cargo_remitente)."</td>
    <td colspan=\"2\"  width=\"113\" align=\"center\">".utf8_encode($cite)."</td>
  </tr>
  <tr>
    <td align=\"left\" bgcolor=\"#ededed\" width=\"104\">ADJUNTOS</td>
    <td colspan=\"3\" width=\"301\">&nbsp;".utf8_encode($adjuntos)."</td>
    <td colspan=\"2\" rowspan=\"2\" align=\"center\" bgcolor=\"#ededed\"  width=\"113\"  style=\"font-size:10px;\"><strong>FECHA Y HORA DE REGISTROS</strong></td>
  </tr>
  <tr>
    <td align=\"left\" bgcolor=\"#ededed\" width=\"104\">N&ordm; DE HOJAS </td>
    <td colspan=\"3\" width=\"301\">&nbsp;".$nodehojas."</td>
  </tr>
  <tr>
    <td align=\"left\" bgcolor=\"#ededed\" width=\"104\">TIPO DE ADJUNTO</td>
    <td colspan=\"3\" width=\"301\">&nbsp;".utf8_encode($tipo_documento)."</td>
    <td colspan=\"2\" rowspan=\"1\" width=\"113\" align=\"center\">".$fecha2."</td>
  </tr>
  <tr>
    <td  align=\"left\" bgcolor=\"#ededed\" width=\"104\">REFERENCIA\n</td>
    <td  colspan=\"5\" width=\"414\">&nbsp;".utf8_encode($referencia)."</td>
  </tr>
  <tr>
  
    <td rowspan=\"2\" align=\"left\"  bgcolor=\"#ededed\" width=\"104\">AREA DESTINO </td>
    <td width=\"220\" rowspan=\"2\">&nbsp;".utf8_encode($areadestino)."</td>
    <td width=\"45\" align=\"center\" bgcolor=\"#ededed\">NOMBRE </td>
    <td colspan=\"3\" width=\"149\">&nbsp;".utf8_encode($nombre_aux)."</td>
  </tr>
  <tr>
    <td align=\"left\" bgcolor=\"#ededed\" width=\"45\">CARGO</td>
    <td colspan=\"3\" width=\"149\">&nbsp;".utf8_encode($cargo_aux)."</td>
  </tr>
  <tr>
    <td align=\"left\" bgcolor=\"#ededed\" width=\"104\">RECIBIDO POR </td>
    <td colspan=\"5\" width=\"414\">&nbsp;".utf8_encode($gestor)."</td>
  </tr>
</table>";
*/
/*
$cabeza1="<table border=\"1\" cellpadding=\"1\" cellspacing=\"1\" style=\"font-size:9px;\">
  <tr>
  <td width=\"104\" rowspan=\"2\"  align=\"center\"><img src=\"1002201119301.jpg\" border=\"0\" height=\"55\" width=\"55\" /></td>
   
   <td colspan=\"3\" rowspan=\"2\" align=\"center\" width=\"301\"><br /><style=\"font-size:5px;\">MINISTERIO DE SALUD Y DEPORTES</style><br/><strong  style=\"font-size:13px;\">HOJA DE RUTA<br />".$tipo." Nº ".utf8_encode($hoja_rutax)."</strong></td>
    <td width=\"113\" rowspan=\"2\"  align=\"center\"><img src=\"..\logos\LOGOSNIS.png\" border=\"0\" height=\"55\" width=\"55\" /></td> 
  </tr>
  <tr>

	
  </tr>
  <tr>
    <td align=\"left\" bgcolor=\"#ededed\" width=\"104\">PROCEDENCIA</td>
    <td width=\"301\">&nbsp;DE AQUI</td>
	<td align=\"center\" bgcolor=\"#ededed\" width=\"113\" style=\"font-size:12px;\"><strong>TRÁMITE</strong></td>
    
  </tr>
  <tr>
    <td align=\"left\" bgcolor=\"#ededed\" width=\"104\">LUGAR</td>
    <td width=\"301\">&nbsp;4654465</td>
	<td width=\"113\" align=\"center\">12331</td>
  </tr>
  <tr>
    <td align=\"left\" bgcolor=\"#ededed\" width=\"104\">REMITENTE</td>
    <td colspan=\"3\" width=\"301\">&nbsp;ELLAA</td>
    <td colspan=\"2\" align=\"center\" bgcolor=\"#ededed\"  width=\"113\"  style=\"font-size:12px;\"><strong>CITE</strong></td>
  </tr>
  <tr>
    <td align=\"left\" bgcolor=\"#ededed\" width=\"104\">CARGO REMITENTE</td>
    <td colspan=\"3\" width=\"301\">&nbsp;ELLAS</td>
    <td colspan=\"2\"  width=\"113\" align=\"center\">ELLOS</td>
  </tr>
  <tr>
    <td align=\"left\" bgcolor=\"#ededed\" width=\"104\">ADJUNTOS</td>
    <td colspan=\"3\" width=\"301\">&nbsp;0</td>
    <td colspan=\"2\" rowspan=\"2\" align=\"center\" bgcolor=\"#ededed\"  width=\"113\"  style=\"font-size:10px;\"><strong>FECHA Y HORA DE REGISTROS</strong></td>
  </tr>
  <tr>
    <td align=\"left\" bgcolor=\"#ededed\" width=\"104\">N&ordm; DE HOJAS </td>
    <td colspan=\"3\" width=\"301\">&nbsp;1</td>
  </tr>
  <tr>
    <td align=\"left\" bgcolor=\"#ededed\" width=\"104\">TIPO DE ADJUNTO</td>
    <td colspan=\"3\" width=\"301\">&nbsp;NADA</td>
    <td colspan=\"2\" rowspan=\"1\" width=\"113\" align=\"center\">01-06-2012</td>
  </tr>
  <tr>
    <td  align=\"left\" bgcolor=\"#ededed\" width=\"104\">REFERENCIA\n</td>
    <td  colspan=\"5\" width=\"414\">&nbsp;MAL ESTADO PRUEBA</td>
  </tr>
  <tr>
  
    <td rowspan=\"2\" align=\"left\"  bgcolor=\"#ededed\" width=\"104\">AREA DESTINO </td>
    <td width=\"220\" rowspan=\"2\">&nbsp;SISTEMAS</td>
    <td width=\"45\" align=\"center\" bgcolor=\"#ededed\">NOMBRE </td>
    <td colspan=\"3\" width=\"149\">&nbsp;LUIS DELGADO</td>
  </tr>
  <tr>
    <td align=\"left\" bgcolor=\"#ededed\" width=\"45\">CARGO</td>
    <td colspan=\"3\" width=\"149\">&nbsp;AUXILIAR</td>
  </tr>
  <tr>
    <td align=\"left\" bgcolor=\"#ededed\" width=\"104\">RECIBIDO POR </td>
    <td colspan=\"5\" width=\"414\">&nbsp;Mary</td>
  </tr>
</table>";
$pdf->writeHTML($cabeza1, true, 0, true, 0);
*/
$cuerp="
<table >
<tr>
	<td><img src=\"images/escudo.gif\" border=\"0\" height=\"84\" width=\"100\" /></td>
	<td>MINISTERIO DE SALUD Y DEPORTES Software de Correspondencia Ministerial</td>
	<td></td>
</tr>
</table>
";
$pdf->writeHTML($cuerp, true, 0, true, 0);

/*   
$cabeza_mod="<font size=\"10\" align=\"justify\" >".$prov."</font><BR /><br /><br /><br /><br /><br /><br /><br /><br /><br /><br /><font align=\"right\">---------------------------------------<BR />FIRMA Y SELLO           </font><br />

&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;

<table border=\"1\" align=\"right\">
	    <tr>
          <td align=\"center\" bgcolor=\"#ededed\" width=\"59\">Fecha</td>
          <td align=\"center\" bgcolor=\"#ededed\" width=\"59\">Hora</td>
        </tr>
        <tr>
          <td width=\"59\">&nbsp;</td>
          <td width=\"59\">&nbsp;</td>
        </tr>
    </table>";


$subcabeza2="<font size=\"10\" align=\"center\" >P R O V E I D O</font><BR /><br /><br /><br /><br /><br /><br /><br /><br /><br /><br /><font align=\"right\">---------------------------------------<BR />FIRMA Y SELLO           </font><br />
&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
&nbsp;&nbsp;&nbsp;
<table border=\"1\" align=\"right\">
	    <tr>
          <td align=\"center\" bgcolor=\"#ededed\" width=\"59\">Fecha</td>
          <td align=\"center\" bgcolor=\"#ededed\" width=\"59\">Hora</td>
        </tr>
        <tr>
          <td width=\"59\">&nbsp;</td>
          <td width=\"59\">&nbsp;</td>
        </tr>
    </table>";
	
$cabeza2="<table border=\"1\" cellpadding=\"1\" cellspacing=\"1\" style=\"font-size:7px;\">
  <tr>
    <td colspan=\"2\" align=\"center\" bgcolor=\"#ededed\" width=\"140\" style=\"font-size:7px;\"><strong>ACCI&Oacute;N</strong></td>
    <td width=\"50\" align=\"center\" bgcolor=\"#ededed\">Destinatario</td>
    <td colspan=\"4\" width=\"174\">&nbsp;</td>
	 <td colspan=\"2\" align=\"center\" bgcolor=\"#ededed\" width=\"90\">Plazo Respuesta </td>
    <td width=\"65\">&nbsp;</td>
  </tr>
  <tr>
    <td width=\"125\">Preparar Informe</td>
    <td width=\"15\">&nbsp;</td>
    
    <td colspan=\"2\" rowspan=\"12\" valign=\"bottom\" width=\"379\">".$cabeza_mod."</td>
  </tr>
  <tr>
    <td width=\"125\">Preparar Respuesta para mi firma </td>
    <td width=\"15\">&nbsp;</td>
    
  </tr>
  <tr>
    <td width=\"125\">Elaborar Resolucion</td>
    <td width=\"15\">&nbsp;</td>
  </tr>
  <tr>
    <td width=\"125\">Proceder segun lo establecido</td>
    <td width=\"15\">&nbsp;</td>
  </tr>
  <tr>
    <td width=\"125\">Hacer Seguimiento</td>
    <td width=\"15\">&nbsp;</td>
  </tr>
  <tr>
    <td width=\"125\">Para su Conocimiento </td>
    <td width=\"15\">&nbsp;</td>
  </tr>
  <tr>
    <td width=\"125\">Agendar</td>
    <td width=\"15\">&nbsp;</td>
  </tr>
  <tr>
    <td width=\"125\">Reunion en mi despacho</td>
    <td width=\"15\">&nbsp;</td>
  </tr>
  <tr>
    <td width=\"125\">Circularizar</td>
    <td width=\"15\">&nbsp;</td>
  </tr>
  <tr>
    <td width=\"125\">Recomendar Curso de Accion</td>
    <td width=\"15\">&nbsp;</td>
  </tr>
  <tr>
    <td width=\"125\">Acudir en mi representacion</td>
    <td width=\"15\">&nbsp;</td>
  </tr>
  <tr>
    <td width=\"125\">Archivar</td>
    <td width=\"15\">&nbsp;</td>
  </tr>
  <tr>
    <td width=\"125\">Coordinar con: </td>
    <td colspan=\"4\" width=\"170\">&nbsp;</td>
    <td width=\"52\" align=\"center\" bgcolor=\"#ededed\">Con Copia a: </td>
    <td width=\"172\">&nbsp;</td>
  </tr>
</table>";
$pdf->writeHTML($cabeza2, true, 0, true, 0);

$cabeza2="<table border=\"1\" cellpadding=\"1\" cellspacing=\"1\" style=\"font-size:7px;\">
  <tr>
    <td colspan=\"2\" align=\"center\" bgcolor=\"#ededed\" width=\"140\" style=\"font-size:7px;\"><strong>ACCI&Oacute;N</strong></td>
    <td width=\"50\" align=\"center\" bgcolor=\"#ededed\">Destinatario</td>
    <td colspan=\"4\" width=\"174\">&nbsp;</td>
	 <td colspan=\"2\" align=\"center\" bgcolor=\"#ededed\" width=\"90\">Plazo Respuesta </td>
    <td width=\"65\">&nbsp;</td>
  </tr>
  <tr>
    <td width=\"125\">Preparar Informe</td>
    <td width=\"15\">&nbsp;</td>
    
    <td colspan=\"2\" rowspan=\"12\" valign=\"bottom\" width=\"379\">".$subcabeza2."</td>
  </tr>
  <tr>
    <td width=\"125\">Preparar Respuesta para mi firma </td>
    <td width=\"15\">&nbsp;</td>
    
  </tr>
  <tr>
    <td width=\"125\">Elaborar Resolucion</td>
    <td width=\"15\">&nbsp;</td>
  </tr>
  <tr>
    <td width=\"125\">Proceder segun lo establecido</td>
    <td width=\"15\">&nbsp;</td>
  </tr>
  <tr>
    <td width=\"125\">Hacer Seguimiento</td>
    <td width=\"15\">&nbsp;</td>
  </tr>
  <tr>
    <td width=\"125\">Para su Conocimiento </td>
    <td width=\"15\">&nbsp;</td>
  </tr>
  <tr>
    <td width=\"125\">Agendar</td>
    <td width=\"15\">&nbsp;</td>
  </tr>
  <tr>
    <td width=\"125\">Reunion en mi despacho</td>
    <td width=\"15\">&nbsp;</td>
  </tr>
  <tr>
    <td width=\"125\">Circularizar</td>
    <td width=\"15\">&nbsp;</td>
  </tr>
  <tr>
    <td width=\"125\">Recomendar Curso de Accion</td>
    <td width=\"15\">&nbsp;</td>
  </tr>
  <tr>
    <td width=\"125\">Acudir en mi representacion</td>
    <td width=\"15\">&nbsp;</td>
  </tr>
  <tr>
    <td width=\"125\">Archivar</td>
    <td width=\"15\">&nbsp;</td>
  </tr>
  <tr>
    <td width=\"125\">Coordinar con: </td>
    <td colspan=\"4\" width=\"170\">&nbsp;</td>
    <td width=\"52\" align=\"center\" bgcolor=\"#ededed\">Con Copia a: </td>
    <td width=\"172\">&nbsp;</td>
  </tr>
</table>";
$pdf->writeHTML($cabeza2, true, 0, true, 0);

$cabeza3="<table border=\"1\" cellpadding=\"1\" cellspacing=\"1\" style=\"font-size:7px;\">
  <tr>
    <td colspan=\"2\" align=\"center\" bgcolor=\"#ededed\" width=\"140\" style=\"font-size:7px;\"><strong>ACCI&Oacute;N</strong></td>
    <td width=\"50\" align=\"center\" bgcolor=\"#ededed\">Destinatario</td>
    <td colspan=\"4\" width=\"174\">&nbsp;</td>
	 <td colspan=\"2\" align=\"center\" bgcolor=\"#ededed\" width=\"90\">Plazo Respuesta </td>
    <td width=\"65\">&nbsp;</td>
  </tr>
  <tr>
    <td width=\"125\">Preparar Informe</td>
    <td width=\"15\">&nbsp;</td>
    
    <td colspan=\"2\" rowspan=\"12\" valign=\"bottom\" width=\"379\">".$subcabeza2."</td>
  </tr>
  <tr>
    <td width=\"125\">Preparar Respuesta para mi firma </td>
    <td width=\"15\">&nbsp;</td>
    
  </tr>
  <tr>
    <td width=\"125\">Elaborar Resolucion</td>
    <td width=\"15\">&nbsp;</td>
  </tr>
  <tr>
    <td width=\"125\">Proceder segun lo establecido</td>
    <td width=\"15\">&nbsp;</td>
  </tr>
  <tr>
    <td width=\"125\">Hacer Seguimiento</td>
    <td width=\"15\">&nbsp;</td>
  </tr>
  <tr>
    <td width=\"125\">Para su Conocimiento </td>
    <td width=\"15\">&nbsp;</td>
  </tr>
  <tr>
    <td width=\"125\">Agendar</td>
    <td width=\"15\">&nbsp;</td>
  </tr>
  <tr>
    <td width=\"125\">Reunion en mi despacho</td>
    <td width=\"15\">&nbsp;</td>
  </tr>
  <tr>
    <td width=\"125\">Circularizar</td>
    <td width=\"15\">&nbsp;</td>
  </tr>
  <tr>
    <td width=\"125\">Recomendar Curso de Accion</td>
    <td width=\"15\">&nbsp;</td>
  </tr>
  <tr>
    <td width=\"125\">Acudir en mi representacion</td>
    <td width=\"15\">&nbsp;</td>
  </tr>
  <tr>
    <td width=\"125\">Archivar</td>
    <td width=\"15\">&nbsp;</td>
  </tr>
  <tr>
    <td width=\"125\">Coordinar con: </td>
    <td colspan=\"4\" width=\"170\">&nbsp;</td>
    <td width=\"52\" align=\"center\" bgcolor=\"#ededed\">Con Copia a: </td>
    <td width=\"172\">&nbsp;</td>
  </tr>
</table>";
*/
$pdf->writeHTML($cabeza3, true, 0, true, 0);


$pdf->Output("imprimir_pdf.pdf", "I", "I");
/*}*/
?>
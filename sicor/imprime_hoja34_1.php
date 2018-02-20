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
//create new PDF document
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
$pdf->SetFont('times', '', 9);
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
$nro_reg = $nro_registro;
//logo institucional
$institucion = $_SESSION["institucion"];
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

		if ($row["ingreso_nro_anexos"]==0)
		{
		$adjuntos=$row["ingreso_nro_anexos"];	
		}
		else
		{
		$adjuntos=$row["ingreso_nro_anexos"]."-(".$row["ingreso_tipo_anexos"].")";
		}
	
	$nodehojas=$row["ingreso_cantidad_hojas"];
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

$cabeza1="<table border=\"1\" cellpadding=\"1\" cellspacing=\"1\" style=\"font-size:26px;\">
  <tr>
    <td width=\"117\" rowspan=\"2\"  align=\"center\"><img src=\"".$loguito."\" border=\"0\" height=\"50\" width=\"90\" /></td>
    <td colspan=\"3\" rowspan=\"2\" align=\"center\" width=\"400\"><br />".$cabecera."<br/><strong  style=\"font-size:50px;\">HOJA DE RUTA<br /></strong><strong style=\"font-size:40px;\">".$tipo."</strong><br />    </td>
    <td scolspan=\"2\" align=\"center\" bgcolor=\"#ededed\" width=\"117\" ><strong>NUMERO DE REGISTRO <br /><strong style=\"font-size:50px;\"> ".$nro_reg."</strong><BR /></strong></td>
  </tr>
  <tr>
    <td colspan=\"2\"  width=\"117\" align=\"center\"><strong style=\"font-size:30px;\">TR&Aacute;MITE</strong><br />".$tramite."</td>
  </tr>
  <tr>
    <td align=\"left\" bgcolor=\"#ededed\" width=\"117\">PROCEDENCIA</td>
    <td colspan=\"3\" width=\"400\">&nbsp;".$procedencia."</td>
	
    <td colspan=\"2\" align=\"center\" bgcolor=\"#ededed\"  width=\"117\"  style=\"font-size:30px;\"><strong>CITE</strong></td>
  </tr>
  <tr>
    <td align=\"left\" bgcolor=\"#ededed\" width=\"117\">REMITENTE</td>
    <td colspan=\"3\" width=\"400\">&nbsp;".utf8_encode($remitente)."</td>
    <td colspan=\"2\"  width=\"117\" align=\"center\">".utf8_encode($cite)."</td>
  </tr>
  <tr>
    <td align=\"left\" bgcolor=\"#ededed\" width=\"117\">CARGO REMITENTE</td>
    <td colspan=\"3\" width=\"400\">&nbsp;".$cargo_remitente."</td>
    <td width=\"60\" align=\"center\" bgcolor=\"#ededed\"><b>FECHA CITE</b></td>
    <td width=\"56\" align=\"center\">".$fecha."</td>
  </tr>
  <tr>
    <td align=\"left\" bgcolor=\"#ededed\" width=\"117\">ADJUNTOS</td>
    <td colspan=\"3\" width=\"400\">&nbsp;".$adjuntos."</td>
    <td colspan=\"2\" rowspan=\"2\" align=\"center\" bgcolor=\"#ededed\"  width=\"117\"  style=\"font-size:30px;\"><strong>FECHA Y HORA DE REGISTRO</strong></td>
  </tr>
  <tr>
    <td align=\"left\" bgcolor=\"#ededed\" width=\"117\">N&ordm; DE HOJAS </td>
    <td colspan=\"3\" width=\"400\">&nbsp;".$nodehojas."</td>
  </tr>
  <tr>
    <td align=\"left\" bgcolor=\"#ededed\" width=\"117\">TIPO DE DOCUMENTO</td>
    <td colspan=\"3\" width=\"400\">&nbsp;".$tipo_documento."</td>
    <td colspan=\"2\" rowspan=\"1\" width=\"117\" align=\"center\">".$fecha2."</td>
  </tr>
  <tr>
    <td  align=\"left\" bgcolor=\"#ededed\" width=\"117\">REFERENCIA</td>
    <td colspan=\"5\" width=\"518\">&nbsp;".utf8_encode($referencia)."</td>
  </tr>
  <tr>
  
    <td rowspan=\"2\" align=\"left\"  bgcolor=\"#ededed\" width=\"117\">AREA DESTINO </td>
    <td width=\"220\" rowspan=\"2\">".$areadestino."</td>
    <td width=\"45\" align=\"center\" bgcolor=\"#ededed\">NOMBRE </td>
    <td colspan=\"3\" width=\"251\">&nbsp;".$nombre_aux."</td>
  </tr>
  <tr>
    <td align=\"center\" bgcolor=\"#ededed\" width=\"45\">CARGO</td>
    <td colspan=\"3\" width=\"251\">&nbsp;".$cargo_aux."</td>
  </tr>
  <tr>
    <td align=\"left\" bgcolor=\"#ededed\" width=\"117\">GESTOR VUC </td>
    <td colspan=\"5\" width=\"518\">&nbsp;".$gestor."</td>
  </tr>
</table>";
$pdf->writeHTML($cabeza1, true, 0, true, 0);
   
$subcabeza2="<font size=\"11\" align=\"center\" style=\"color: rgb(153, 153, 153);\">P R O V E I D O</font><BR /><BR /><br /><br /><br /><br /><br /><br /><br /><br /><font align=\"right\">---------------------------------------<BR />FIRMA Y SELLO           </font><br />
&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
&nbsp;&nbsp;&nbsp;&nbsp;
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
	
$cabeza2="<table border=\"1\" cellpadding=\"1\" cellspacing=\"1\" style=\"font-size:26px;\">
  <tr>
    <td colspan=\"2\" align=\"center\" bgcolor=\"#ededed\" width=\"195\" style=\"font-size:30px;\"><strong>ACCI&Oacute;N</strong></td>
    <td width=\"114\" align=\"center\" bgcolor=\"#ededed\">Destinatario</td>
    <td colspan=\"4\" width=\"326\">&nbsp;</td>
  </tr>
  <tr>
    <td width=\"164\">Preparar Informe</td>
    <td width=\"30\">&nbsp;</td>
    <td colspan=\"2\" align=\"center\" bgcolor=\"#ededed\" width=\"114\">Plazo Respuesta </td>
    <td width=\"60\">&nbsp;</td>
    <td colspan=\"2\" rowspan=\"12\" valign=\"bottom\" width=\"266\">".$subcabeza2."</td>
  </tr>
  <tr>
    <td width=\"164\">Preparar Respuesta para mi firma </td>
    <td width=\"30\">&nbsp;</td>
    <td colspan=\"3\" rowspan=\"11\" width=\"175\"><font size=\"9\" align=\"center\" style=\"color: rgb(153, 153, 153);\">SELLO/FIRMA DE RECEPCI&Oacute;N</font><br /><br /><br /><br /><br /><br /></td>
  </tr>
  <tr>
    <td width=\"164\">Elaborar Resolucion</td>
    <td width=\"30\">&nbsp;</td>
  </tr>
  <tr>
    <td width=\"164\">Proceder segun lo establecido</td>
    <td width=\"30\">&nbsp;</td>
  </tr>
  <tr>
    <td width=\"164\">Hacer Seguimiento</td>
    <td width=\"30\">&nbsp;</td>
  </tr>
  <tr>
    <td width=\"164\">Para su Conocimiento </td>
    <td width=\"30\">&nbsp;</td>
  </tr>
  <tr>
    <td width=\"164\">Agendar</td>
    <td width=\"30\">&nbsp;</td>
  </tr>
  <tr>
    <td width=\"164\">Reunion en mi despacho</td>
    <td width=\"30\">&nbsp;</td>
  </tr>
  <tr>
    <td width=\"164\">Circularizar</td>
    <td width=\"30\">&nbsp;</td>
  </tr>
  <tr>
    <td width=\"164\">Recomendar Curso de Accion</td>
    <td width=\"30\">&nbsp;</td>
  </tr>
  <tr>
    <td width=\"164\">Acudir en mi representacion</td>
    <td width=\"30\">&nbsp;</td>
  </tr>
  <tr>
    <td width=\"164\">Archivar</td>
    <td width=\"30\">&nbsp;</td>
  </tr>
  <tr>
    <td width=\"164\">Coordinar con: </td>
    <td colspan=\"4\" width=\"206\">&nbsp;</td>
    <td width=\"52\" align=\"center\" bgcolor=\"#ededed\">Con Copia a: </td>
    <td width=\"213\">&nbsp;</td>
  </tr>
</table>";
$pdf->writeHTML($cabeza2, true, 0, true, 0);


$subcabeza3="<font size=\"11\" align=\"center\" style=\"color: rgb(153, 153, 153);\">P R O V E I D O</font><BR /><BR /><br /><br /><br /><br /><br /><br /><br /><br /><font align=\"right\">---------------------------------------<BR />FIRMA Y SELLO           </font><br />
&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
&nbsp;&nbsp;&nbsp;&nbsp;
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
	
$cabeza3="<table border=\"1\" cellpadding=\"1\" cellspacing=\"1\" style=\"font-size:26px;\">
  <tr>
    <td colspan=\"2\" align=\"center\" bgcolor=\"#ededed\" width=\"195\" style=\"font-size:30px;\"><strong>ACCI&Oacute;N</strong></td>
    <td width=\"114\" align=\"center\" bgcolor=\"#ededed\">Destinatario</td>
    <td colspan=\"4\" width=\"326\">&nbsp;</td>
  </tr>
  <tr>
    <td width=\"164\">Preparar Informe</td>
    <td width=\"30\">&nbsp;</td>
    <td colspan=\"2\" align=\"center\" bgcolor=\"#ededed\" width=\"114\">Plazo Respuesta </td>
    <td width=\"60\">&nbsp;</td>
    <td colspan=\"2\" rowspan=\"12\" valign=\"bottom\" width=\"266\">".$subcabeza3."</td>
  </tr>
  <tr>
    <td width=\"164\">Preparar Respuesta para mi firma </td>
    <td width=\"30\">&nbsp;</td>
    <td colspan=\"3\" rowspan=\"11\" width=\"175\"><font size=\"9\" align=\"center\" style=\"color: rgb(153, 153, 153);\">SELLO/FIRMA DE RECEPCI&Oacute;N</font><br /><br /><br /><br /><br /><br /></td>
  </tr>
  <tr>
    <td width=\"164\">Elaborar Resolucion</td>
    <td width=\"30\">&nbsp;</td>
  </tr>
  <tr>
    <td width=\"164\">Proceder segun lo establecido</td>
    <td width=\"30\">&nbsp;</td>
  </tr>
  <tr>
    <td width=\"164\">Hacer Seguimiento</td>
    <td width=\"30\">&nbsp;</td>
  </tr>
  <tr>
    <td width=\"164\">Para su Conocimiento </td>
    <td width=\"30\">&nbsp;</td>
  </tr>
  <tr>
    <td width=\"164\">Agendar</td>
    <td width=\"30\">&nbsp;</td>
  </tr>
  <tr>
    <td width=\"164\">Reunion en mi despacho</td>
    <td width=\"30\">&nbsp;</td>
  </tr>
  <tr>
    <td width=\"164\">Circularizar</td>
    <td width=\"30\">&nbsp;</td>
  </tr>
  <tr>
    <td width=\"164\">Recomendar Curso de Accion</td>
    <td width=\"30\">&nbsp;</td>
  </tr>
  <tr>
    <td width=\"164\">Acudir en mi representacion</td>
    <td width=\"30\">&nbsp;</td>
  </tr>
  <tr>
    <td width=\"164\">Archivar</td>
    <td width=\"30\">&nbsp;</td>
  </tr>
  <tr>
    <td width=\"164\">Coordinar con: </td>
    <td colspan=\"4\" width=\"206\">&nbsp;</td>
    <td width=\"52\" align=\"center\" bgcolor=\"#ededed\">Con Copia a: </td>
    <td width=\"213\">&nbsp;</td>
  </tr>
</table>";
$pdf->writeHTML($cabeza3, true, 0, true, 0);

$subcabeza4="<font size=\"11\" align=\"center\" style=\"color: rgb(153, 153, 153);\">P R O V E I D O</font><BR /><BR /><br /><br /><br /><br /><br /><br /><br /><br /><font align=\"right\">---------------------------------------<BR />FIRMA Y SELLO           </font><br />
&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
&nbsp;&nbsp;&nbsp;&nbsp;
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
	
$cabeza4="<table border=\"1\" cellpadding=\"1\" cellspacing=\"1\" style=\"font-size:26px;\">
  <tr>
    <td colspan=\"2\" align=\"center\" bgcolor=\"#ededed\" width=\"195\" style=\"font-size:30px;\"><strong>ACCI&Oacute;N</strong></td>
    <td width=\"114\" align=\"center\" bgcolor=\"#ededed\">Destinatario</td>
    <td colspan=\"4\" width=\"326\">&nbsp;</td>
  </tr>
  <tr>
    <td width=\"164\">Preparar Informe</td>
    <td width=\"30\">&nbsp;</td>
    <td colspan=\"2\" align=\"center\" bgcolor=\"#ededed\" width=\"114\">Plazo Respuesta </td>
    <td width=\"60\">&nbsp;</td>
    <td colspan=\"2\" rowspan=\"12\" valign=\"bottom\" width=\"266\">".$subcabeza4."</td>
  </tr>
  <tr>
    <td width=\"164\">Preparar Respuesta para mi firma </td>
    <td width=\"30\">&nbsp;</td>
    <td colspan=\"3\" rowspan=\"11\" width=\"175\"><font size=\"9\" align=\"center\" style=\"color: rgb(153, 153, 153);\">SELLO/FIRMA DE RECEPCI&Oacute;N</font><br /><br /><br /><br /><br /><br /></td>
  </tr>
  <tr>
    <td width=\"164\">Elaborar Resolucion</td>
    <td width=\"30\">&nbsp;</td>
  </tr>
  <tr>
    <td width=\"164\">Proceder segun lo establecido</td>
    <td width=\"30\">&nbsp;</td>
  </tr>
  <tr>
    <td width=\"164\">Hacer Seguimiento</td>
    <td width=\"30\">&nbsp;</td>
  </tr>
  <tr>
    <td width=\"164\">Para su Conocimiento </td>
    <td width=\"30\">&nbsp;</td>
  </tr>
  <tr>
    <td width=\"164\">Agendar</td>
    <td width=\"30\">&nbsp;</td>
  </tr>
  <tr>
    <td width=\"164\">Reunion en mi despacho</td>
    <td width=\"30\">&nbsp;</td>
  </tr>
  <tr>
    <td width=\"164\">Circularizar</td>
    <td width=\"30\">&nbsp;</td>
  </tr>
  <tr>
    <td width=\"164\">Recomendar Curso de Accion</td>
    <td width=\"30\">&nbsp;</td>
  </tr>
  <tr>
    <td width=\"164\">Acudir en mi representacion</td>
    <td width=\"30\">&nbsp;</td>
  </tr>
  <tr>
    <td width=\"164\">Archivar</td>
    <td width=\"30\">&nbsp;</td>
  </tr>
  <tr>
    <td width=\"164\">Coordinar con: </td>
    <td colspan=\"4\" width=\"206\">&nbsp;</td>
    <td width=\"52\" align=\"center\" bgcolor=\"#ededed\">Con Copia a: </td>
    <td width=\"213\">&nbsp;</td>
  </tr>
</table>";
$pdf->writeHTML($cabeza4, true, 0, true, 0);
$pdf->Output("imprime_hoja34.pdf", "I", "I");
}
?>
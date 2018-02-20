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

// remove default header/footer
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
$nro_registro=descifrar($_GET['imprimeh']);
//logo institucional
$institucion = $_SESSION["institucion"];
$ssqli = "SELECT * FROM instituciones WHERE '$institucion'=instituciones_cod_institucion";
$rssi = mysql_query($ssqli, $conn);
if ($rowi = mysql_fetch_array($rssi))
	{
		$logo = $rowi["instituciones_logo"];
		$cabecera = $rowi["instituciones_membrete"];
    }
		$loguito="../logos/".$logo;

$ssql = "SELECT * FROM ingreso WHERE '$nro_registro'=ingreso_nro_registro AND  ingreso_cod_institucion='$institucion'";
$rss = mysql_query($ssql,$conn);
if ($row=mysql_fetch_array($rss))
	{

		if ($row["ingreso_hoja_ruta_tipo"] == "e") 
			{
				  $tipo = "EXTERNA";
				 
			}
			else
			{
				  $tipo = "INTERNA";
			}
	$tramite=$row["ingreso_hoja_ruta"];
			
	}

$cabecera='<table border="1" cellpadding="1"  cellspacing="1" style="font-size:26px;">
  <tr>
    <td  rowspan="2" width="117"  align="center"><img src="'.$loguito.'" width="40" height="40" border="0" align="bottom" /></td>
    <td colspan="3" width="400" rowspan="2" align="center" >'.$cabecera.'<br/><strong  style="font-size:40px;">HOJA DE RUTA </strong><br />'.$tipo.'</td>
    <td colspan="2" width="117" align="center" bgcolor="#ededed"  style="font-size:30px;"><strong>TRAMITE<BR /></strong></td>
  
  </tr>
  <tr>
    <td colspan="2" align="center" width="117">'.$tramite.'</td>
  </tr>
 </table>';
 $pdf->writeHTML($cabecera, true, 0, true, 0);

$subcabeza8="<font size=\"11\" align=\"center\" style=\"color: rgb(153, 153, 153);\">P R O V E I D O</font><BR /><BR /><br /><br /><br /><br /><br /><br /><br /><br /><font align=\"right\">---------------------------------------<BR />FIRMA Y SELLO           </font><br />
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
	
$cabeza8="<table border=\"1\" cellpadding=\"1\" cellspacing=\"1\" style=\"font-size:26px;\">
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
    <td colspan=\"2\" rowspan=\"12\" valign=\"bottom\" width=\"266\">".$subcabeza8."</td>
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
$pdf->writeHTML($cabeza8, true, 0, true, 0);


$subcabeza9="<font size=\"11\" align=\"center\" style=\"color: rgb(153, 153, 153);\">P R O V E I D O</font><BR /><BR /><br /><br /><br /><br /><br /><br /><br /><br /><font align=\"right\">---------------------------------------<BR />FIRMA Y SELLO           </font><br />
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
	
$cabeza9="<table border=\"1\" cellpadding=\"1\" cellspacing=\"1\" style=\"font-size:26px;\">
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
    <td colspan=\"2\" rowspan=\"12\" valign=\"bottom\" width=\"266\">".$subcabeza9."</td>
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
$pdf->writeHTML($cabeza9, true, 0, true, 0);


$subcabeza10="<font size=\"11\" align=\"center\" style=\"color: rgb(153, 153, 153);\">P R O V E I D O</font><BR /><BR /><br /><br /><br /><br /><br /><br /><br /><br /><font align=\"right\">---------------------------------------<BR />FIRMA Y SELLO           </font><br />
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
	
$cabeza10="<table border=\"1\" cellpadding=\"1\" cellspacing=\"1\" style=\"font-size:26px;\">
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
    <td colspan=\"2\" rowspan=\"12\" valign=\"bottom\" width=\"266\">".$subcabeza10."</td>
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
$pdf->writeHTML($cabeza10, true, 0, true, 0);


$pdf->Output('bcb2.pdf', 'I');
?>

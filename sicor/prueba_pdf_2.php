<?php
include("../filtro.php");
?>
<?php
require_once("tcpdf/config/lang/eng.php");
require_once("tcpdf/tcpdf.php");

// create new PDF document
$pdf = new TCPDF(PDF_PAGE_ORIENTATION, PDF_UNIT, PDF_PAGE_FORMAT, true); 

// set document information
$pdf->SetCreator(PDF_CREATOR);
$pdf->SetAuthor("Nicola Asuni");
$pdf->SetTitle("TCPDF Example 002");
$pdf->SetSubject("TCPDF Tutorial");
$pdf->SetKeywords("TCPDF, PDF, example, test, guide");

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

// add a page
$pdf->SetFont('times', '', 7);


//initialize document
$pdf->AliasNbPages();

// add a page
$pdf->AddPage();

// ---------------------------------------------------------
/*
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

*/
$tablealign = '<h1>Image alignments on HTML table</h1><table cellpadding="1" cellspacing="1" border="1" style="text-align:center;">
<tr><td><img src="tcpdf/images/logo_example.png" border="0" height="41" width="41" /></td></tr>
<tr style="text-align:left;"><td><img src="tcpdf/images/logo_example.png" border="0" height="41" width="41" align="top" /></td></tr>
<tr style="text-align:center;"><td><img src="tcpdf/images/logo_example.png" border="0" height="41" width="41" align="middle" /></td></tr>
<tr style="text-align:right;"><td><img src="tcpdf/images/logo_example.png" border="0" height="41" width="41" align="bottom" /></td></tr>
<tr><td style="text-align:left;"><img src="tcpdf/images/logo_example.png" border="0" height="41" width="41" align="top" /></td></tr>
<tr><td style="text-align:center;"><img src="tcpdf/images/logo_example.png" border="0" height="41" width="41" align="middle" /></td></tr>
<tr><td style="text-align:right;"><img src="tcpdf/images/logo_example.png" border="0" height="41" width="41" align="bottom" /></td></tr>
</table>';

// output the HTML content
$pdf->writeHTML($tablealign, true, 0, true, 0);

$subcabeza2="<font size=\"10\" align=\"center\" style=\"color: rgb(153, 153, 153);\">P R O V E I D O</font><BR /><br /><br /><br /><br /><br /><br /><br /><br /><br /><br /><font align=\"right\">---------------------------------------<BR />FIRMA Y SELLO           </font><br />
&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
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
// ---------------------------------------------------------

//Close and output PDF document
$pdf->Output("imorime_hoja34mas.pdf", "I");

//============================================================+
// END OF FILE                                                 
//============================================================+
?>
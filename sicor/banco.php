<?php
require_once('tcpdf/config/lang/eng.php');
require_once('tcpdf/tcpdf.php');
// create new PDF document
$pdf = new TCPDF(PDF_PAGE_ORIENTATION, PDF_UNIT, 'LETTER',true); 

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
$pdf->SetAutoPageBreak(TRUE, PDF_MARGIN_BOTTOM);

//set image scale factor
$pdf->setImageScale(PDF_IMAGE_SCALE_RATIO); 

//set some language-dependent strings
$pdf->setLanguageArray($l); 

//initialize document
$pdf->AliasNbPages();

// add a page
$pdf->AddPage();
$pdf->SetFont("times", "B", 9);
$pdf->Image("tcpdf/images/bcbLogo.png");

$pdf->Cell(0, 12, 'SISTEMA DE CORRESPONDENCIA DEL BCB', 1, 0, 'C'); 
$pdf->Cell(0, 5, 'TRAMITE', 1, 0, 'R'); 
$pdf->Cell(0, 20, 'BCB-SISTEMAS-001/09', 1, 1, 'R');


/*$pdf->Cell(0, 5, "PROCENDENCIA", 1, 1, 'L', 0, '', 0);
$pdf->Cell(0, 5, "REMITENTE", 1, 1, 'L', 0, '', 0);
$pdf->Cell(0, 5, "TIPO DE CAMBIO", 1, 1, 'L', 0, '', 0);
$pdf->Cell(0, 5, "ADJUNTOS", 1, 1, 'L', 0, '', 0);
$pdf->Cell(0, 5, "No DE HOJAS", 1, 1, 'L', 0, '', 0); 
$pdf->Cell(0, 5, "PRIORIDAD", 1, 1, 'L', 0, '', 0); 
$pdf->Cell(0, 5, "CATEGORIA", 1, 1, 'L', 0, '', 0); 
$pdf->Cell(0, 5, "REFERENCIA", 1, 1, 'L', 0, '', 0); 
$pdf->Cell(0, 5, "OBSERVACIONES", 1, 1, 'L', 0, '', 0); 
$pdf->Cell(0, 5, "AREA DESTINO", 1, 1, 'L', 0, '', 0); 
$pdf->Cell(0, 5, "GESTOR VUC", 1, 1, 'L', 0, '', 0); */


$pdf->SetFillColor(239, 239, 239); 
$pdf->MultiCell(40, 5, "PROCEDENCIA", 1, 'L', 1, 0, 0 ,0, true);
$pdf->MultiCell(110, 5, "Agencia para el Desarrollo se la Sociedad de la Información en Bolivia", 1, 'L', 0, 0, 0 ,0, true);
$pdf->MultiCell(36, 5, "CITE", 1, 'C', 1, 1, 0 ,0, true);

$pdf->MultiCell(40, 5, "REMITENTE", 1, 'L', 1, 0, 0 ,0, true);
$pdf->MultiCell(110, 5, "Jose Machicado", 1, 'L', 0, 0, 0 ,0, true);
$pdf->MultiCell(36, 5, "DESP-009/09", 1, 'C', 0, 1, 0 ,0, true);

$pdf->MultiCell(40, 5, "TIPO DE CAMBIO", 1, 'L', 1, 0, 0 ,0, true);
$pdf->MultiCell(110, 5, "Ninguno", 1, 'L', 0, 0, 0 ,0, true);
$pdf->MultiCell(15, 5, "FECHA", 1, 'C', 1, 0, 0 ,0, true);
$pdf->MultiCell(21, 5, "02/03/2009", 1, 'C', 0, 1, 0 ,0, true);

$pdf->MultiCell(40, 5, "ADJUNTOS\n\n", 1, 'L', 1, 0, 0 ,0, true);
$pdf->MultiCell(110, 5, "2\n\n", 1, 'L', 0, 0, 0 ,0, true);
$pdf->MultiCell(36, 5, "FECHA Y HORA DE REGISTROS", 1, 'C', 1, 1, 0 ,0, true);

$pdf->MultiCell(40, 5, "No DE HOJAS", 1, 'L', 1, 0, 0 ,0, true);
$pdf->MultiCell(110, 5, "3", 1, 'L', 0, 0, 0 ,0, true);
$pdf->MultiCell(36, 5, "02-03-2009  02:54:38", 1, 'C', 0, 1, 0 ,0, true);


$pdf->MultiCell(40, 5, "PRIORIDAD", 1, 'L', 1, 0, 0 ,0, true);
$pdf->MultiCell(146, 5, "Alta", 1, 'L', 0, 1, 0 ,0, true);

$pdf->MultiCell(40, 5, "CATEGORIA", 1, 'L', 1, 0, 0 ,0, true);
$pdf->MultiCell(146, 5, "Documentos", 1, 'L', 0, 1, 0 ,0, true);

$pdf->MultiCell(40, 5, "REFERENCIA", 1, 'L', 1, 0, 0 ,0, true);
$pdf->MultiCell(146, 5, "Reunión CASO Formulario para el Sistema de Correspondencia", 1, 'L', 0, 1, 0 ,0, true);

$pdf->MultiCell(40, 5, "OBSERVACIONES", 1, 'L', 1, 0, 0 ,0, true);
$pdf->MultiCell(146, 5, "Ninguna", 1, 'L', 0, 1, 0 ,0, true);

$pdf->MultiCell(40, 5, "AREA DESTINO", 1, 'L', 1, 0, 0 ,0, true);
$pdf->MultiCell(70, 5, "Gerencia de Sistemas", 1, 'L', 0, 0, 0 ,0, true);
$pdf->MultiCell(25, 5, "NOMBRE", 1, 'C', 1, 0, 0 ,0, true);
$pdf->MultiCell(51, 5, "Alfredo Lupe", 1, 'L', 0, 1, 0 ,0, true);

$pdf->MultiCell(40, 5, "GESTOR VUC", 1, 'L', 1, 0, 0 ,0, true);
$pdf->MultiCell(146, 5, "Andres Peralta", 1, 'L', 0, 1, 0 ,0, true);




$subtable = "<table border=\"1\" cellspacing=\"1\" cellpadding=\"1\"><tr><td>a</td><td>b</td></tr><tr><td>c</td><td>d</td></tr></table>"; 
$htmltable = "<h2>HTML TABLE:</h2>
<table border=\"1\" cellspacing=\"2\" cellpadding=\"2\">
<tr>
<th>#</th>
<th align=\"right\">RIGHT align</th>
<th align=\"left\">LEFT align</th>
<th>4A</th>
</tr>

<tr>
<td>1</td>
<td bgcolor=\"#cccccc\" align=\"center\" colspan=\"2\">A1 ex<i>amp</i>le <a href=\"http://www.tcpdf.org\">link</a> column span. One two tree four five six seven eight nine ten.<br />line after br<br /><small>small text</small> normal <sub>subscript</sub> normal <sup>superscript</sup> normal  bla bla bla bla bla bla bla bla bla bla bla bla bla bla bla bla bla bla bla bla bla bla bla<ol><li>first<ol><li>sublist</li><li>sublist</li></ol></li><li>second</li></ol><small color=\"#FF0000\" bgcolor=\"#FFFF00\">small small small small small small small small small small small small small small small small small small small small</small>
</td>
<td>4B</td>
</tr>

<tr>
<td>".$subtable."</td>
<td bgcolor=\"#0000FF\" color=\"yellow\" align=\"center\">A2 â‚¬ &euro; &#8364; &amp; Ã¨ &egrave;<br/>A2 â‚¬ &euro; &#8364; &amp; Ã¨ &egrave;</td><td bgcolor=\"#FFFF00\" align=\"left\"><font color=\"#FF0000\">Red</font> Yellow BG
</td>
<td>4C</td>
</tr>

<tr>
<td>1A</td>
<td rowspan=\"2\" colspan=\"2\" bgcolor=\"#FFFFCC\">2AA<br />2AB<br />2AC</td>
<td bgcolor=\"#FF0000\">4D</td>
</tr>

<tr>
<td>1B</td>
<td>4E</td>
</tr>

<tr>
<td>1C</td>
<td>2C</td>
<td>3C</td>
<td>4F</td>
</tr>
</table>";
// output the HTML content
$pdf->writeHTML($htmltable, true, 0, true, 0); 


//$pdf->SetFont("freesans", "", 12);
//$pdf->MultiCell(120,20,"SISTEMA DE SEGUIMIENTO DE CORRESPONDENCIA DEL BCB",0,'L',0,0);
$tablealign = '<h1>Image alignments on HTML table</h1>
<table cellpadding="1" cellspacing="1" border="1" style="text-align:center;">
<tr>
<td><img src="tcpdf/images/logo_example.png" border="0" height="41" width="41" align="bottom" /></td>
</tr>

</table>';

// output the HTML content
$pdf->writeHTML($tablealign, true, 0, true, 0);





$tablas="<table  border=\"1\" cellpadding=\"0\" cellspacing=\"0\" style=\"text-align:right; font-size:5px;\">
  <tr>
    <td align=\"center\" bgcolor=\"#efefef\" width=\"175\"><strong>ACCION</strong></td>
    <td  align=\"center\" bgcolor=\"#efefef\" width=\"60\">Destinatario</td>
    <td width=\"290\">hola</td>
  </tr>
 
  <tr>
    <td width=\"525\"></td>
    
  </tr>
 
  </table>";
$pdf->writeHTML($tablas, true, 0, true, 0); 

$pdf->Output("banco.pdf", "I");
?>
<?php
include("../filtro.php");
?>
<?php
require_once("tcpdf/config/lang/eng.php");
require_once("tcpdf/tcpdf.php");
include("../conecta.php");

// create new PDF document
//$pdf = new TCPDF(PDF_PAGE_ORIENTATION, PDF_UNIT, PDF_PAGE_FORMAT, true); 

$pdf = new TCPDF("L", PDF_UNIT, PDF_PAGE_FORMAT, true, 'UTF-8', false); 

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

$valordoc=$_SESSION['valordocumento'];
$coddepartamento=$_SESSION["departamento"];	
$valor=$_SESSION['valor'];

$ssql = "SELECT documentos_descripcion,documentos_id FROM documentos where documentos_id='$valordoc'";
$rss = mysql_query($ssql, $conn);
$dato=mysql_fetch_array($rss);

$ssq2 = "SELECT departamento_sigla_dep FROM departamento where departamento_cod_departamento='$coddepartamento'";
$rss2 = mysql_query($ssq2, $conn);
$depto=mysql_fetch_array($rss2);

// ---------------------------------------------------------
$cabeza1="<table border=\"1\" cellpadding=\"1\" cellspacing=\"1\" style=\"font-size:9px;\">
  <tr>
  <td/></td>    
  <td/></td>    
  <td/>&nbsp;</td>    
  </tr>

  <tr>
  <td width=\"180\" rowspan=\"2\"  align=\"center\"><img src=\"..\images\logominsalud.jpg\" border=\"0\" height=\"65\" width=\"90\" /></td>    
  <td width=\"390\" rowspan=\"2\"  align=\"center\"><strong  style=\"font-size:15px;\">CORRESPONDENCIA DE NOTAS INTERNAS<br/>".$dato[0]." - ".$depto[0]." - 2011</strong></td> 
  <td width=\"180\" rowspan=\"2\"  align=\"center\"><img src=\"..\images\logominsalud1.jpg\" border=\"0\" height=\"65\" width=\"90\" /></td> 
  </tr>
</table>";
$pdf->writeHTML($cabeza1, true, 0, true, 0);

$cabeza2="<table border=\"1\" cellpadding=\"1\" cellspacing=\"1\" style=\"font-size:7px;\">
  <tr>
     <td valign=\"middle\" align=\"center\" bgcolor=\"#ededed\" width=\"50\" style=\"font-size:8px;\"><strong>N CORR.</strong></td>
	 <td valign=\"middle\" align=\"center\" bgcolor=\"#ededed\" width=\"100\" style=\"font-size:8px;\"><strong>CITE</strong></td>
	 <td valign=\"middle\" align=\"center\" bgcolor=\"#ededed\" width=\"60\" style=\"font-size:8px;\"><strong>FECHA</strong></td>
	 <td valign=\"middle\" align=\"center\" bgcolor=\"#ededed\" width=\"150\" style=\"font-size:8px;\"><strong>PROCESOS</strong></td>
	 <td valign=\"middle\" align=\"center\" bgcolor=\"#ededed\" width=\"200\" style=\"font-size:8px;\"><strong>REFERENCIA</strong></td>
	 <td valign=\"middle\" align=\"center\" bgcolor=\"#ededed\" width=\"100\" style=\"font-size:8px;\"><strong>RESPONSABLE DE ELABORACION DE NOTA</strong></td>
	 <td valign=\"middle\" align=\"center\" bgcolor=\"#ededed\" width=\"90\" style=\"font-size:8px;\"><strong>FIRMA</strong></td>
  </tr></table>";
$pdf->writeHTML($cabeza2, false, 0, false, 0);
  
$contador=1;  

  $cabezainicio="<table border=\"1\" cellpadding=\"1\" cellspacing=\"1\" style=\"font-size:7px;\">";
  $cabezafin="</table>";

foreach ($valor as $valor){

$ssq2="select registroarchivo_hoja_interna,registroarchivo_referencia,LOWER( DATE_FORMAT(registroarchivo_fecha_recepcion, '%d-%m-%Y')) AS fecha,
u.usuario_nombre,departamento_sigla_dep,registroarchivo_codigo
from registroarchivo ra, usuario u, cargos c, departamento d
where ra.registroarchivo_codigo='$valor' and ra.registroarchivo_usuario_inicia=u.usuario_ocupacion 
and u.usuario_ocupacion=c.cargos_id and c.cargos_cod_depto=d.departamento_cod_departamento and d.departamento_cod_departamento='$coddepartamento'
ORDER BY ra.registroarchivo_codigo asc";	 

$rss2 = mysql_query($ssq2, $conn);
$valor2=mysql_fetch_array($rss2);
$vector=split("/",$valor2[0]);


$cabeza2=$cabezainicio."<tr><td  align=\"center\" width=\"50\" style=\"font-size:9px;\">".$vector[3]."</td>
 	      <td align=\"center\" width=\"100\" style=\"font-size:9px;\">".$valor2[0]."</td>
	      <td align=\"center\" width=\"60\" style=\"font-size:9px;\">".$valor2[2]."</td>
	      <td align=\"center\" width=\"150\" style=\"font-size:9px;\">".$valor2[4]."</td>
	      <td align=\"center\" width=\"200\" style=\"font-size:9px;\">".$valor2[1]."</td>
	      <td align=\"center\" width=\"100\" style=\"font-size:9px;\">".$valor2[3]."</td>
	      <td align=\"center\" width=\"90\" style=\"font-size:9px;\"><br /></td></tr>".$cabezafin;



$contador=$contador+1;

$pdf->writeHTML($cabeza2, false, 0, true, 0);
}  


// ---------------------------------------------------------

//Close and output PDF document
$pdf->Output("imprime_notasinternas.pdf", "I");

//============================================================+
// END OF FILE                                                 
//============================================================+
?>
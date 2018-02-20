<?php
include('pdf4/mpdf.php');

include("script/functions.inc");
include("script/cifrar.php");
include("../conecta.php");

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
$codigo=$_SESSION["cargo_asignado"];
$depto=$_SESSION["departamento"];
$hruta=descifrar($_GET['hr1']);

$var=$_POST['lista_hr'];

	$elementos = count($var);
	for($i=0; $i < $elementos; $i++)
	{
		//echo "$var[$i]<br>";
	}
$html.='
<table border="0" cellspacing="0" cellpadding="0" width="100%" style="font-family:Arial, Helvetica, sans-serif;">
	<tr>
		<td align="center" style="font-size:16px"><strong><em>MINISTERIO DE SALUD Y DEPORTES</em></strong></td>
	</tr>
</table>	
';
$html2.='
<table border="0" cellspacing="0" cellpadding="0" width="100%" style="font-family:Arial, Helvetica, sans-serif; font-size:8pt;">
	<tr>
		<td align="center">CORRESPONDENCIA RECIBIDA Y DESPACHADA</td>
	</tr>
</table>	
';
$html3.='
<table width="0" border="1" cellpadding="0" style="font-size:12px">
  <tr>
    <td>H.R.</td>
    <td>F<br>E<br>C<br>H<br>A</td>
    <td>UNIDAD<br> SOLICITANTE</td>
    <td>CITE</td>
    <td>REMITENTE</td>
    <td>DESCRIPCION</td>
    <td style="font-size:8px">A<br>D<br>J<br>U<br>D<br>I<br>C<br>A<br>D<br>O<br> A:</td>
    <td>
		<table width="0" border="0" cellpadding="0" style="font-size:12px">
  			<tr>
   			 	<td>MONTO</td>
  			</tr>
  			<tr>
    			<td><table width="100%" border="1" cellpadding="0" style="font-size:9px">
			  			<tr>
							<td>T<br>O<br>T<br>A<br>L</td>
							<td>T<br>O<br>T<br>A<br>L</td>
							<td>T<br>O<br>T<br>A<br>L</td>
			  			</tr>
					</table>
				</td>
  			</tr>
		</table>
	</td>
    <td>No<br> FOJAS</td>
    <td>FIRMAS<BR>DERIVADO A:</td>
    <td>FIRMAS<BR>DERIVADO A:</td>
    <td>FIRMAS<BR>DERIVADO A:</td>
  </tr>
  <tr>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
	<td>&nbsp;</td>
  </tr>
</table>
';

$mpdf=new mPDF ('','LEGAL','','',5,5,5,5);
//$mpdf->AddPage('','','','','','',5,5,10,5,1,5);
$mpdf->AddPage('L','','','','','','','','','','','');
//$mpdf->AddPage();
$mpdf->SetFooter('MSyD||Copyright {DATE j-m-Y}');
//$mpdf->SetFooter('MSyD|{PAGENO} de {nb}|Copyright {DATE j-m-Y}');
$mpdf->WriteHTML($html);
$mpdf->WriteHTML($html2);
$mpdf->WriteHTML($html3);
$mpdf->Output();
exit;
?>
 
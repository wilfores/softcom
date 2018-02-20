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

$html.='
	<table border="0" cellspacing="0" cellpadding="0" width="100%" style="font-family:Arial, Helvetica, sans-serif; font-size:8pt;">
			  <tr>
				<td width="20%" align="center"><img src="imagenes2/escudo.png"/></td>
				<td align="center">MINISTERIO DE SALUD Y DEPORTES<br />
				SOFTWARE DE CORRESPONDENCIA MINISTERIAL MSyD-2012</td>
				<td width="20%">&nbsp;</td>
			  </tr>
			  <tr>
				<td width="20%" style="font-size: 8px; align="center">ESTADO PLURINACIONAL DE BOLIVA</td>
				<td>&nbsp;</td>
				<td width="20%" >&nbsp;</td>
			  </tr>
	</table>	
';

$mpdf=new mPDF ('','LEGAL','','',10,8,5,20);
//$mpdf->AddPage('','','','','','',5,5,10,5,1,5);
$mpdf->AddPage('L','','','','','','','','','','','');
//$mpdf->AddPage();
$mpdf->SetFooter('Encargado de Fideicomiso|{PAGENO} de {nb}|Copyright {DATE j-m-Y}');
$mpdf->WriteHTML($html);
$mpdf->Output();
exit;
?>

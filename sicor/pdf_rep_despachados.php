<?php
 //include ("datos/conexion.php");
 //require ("datos/functions.lib.php");
 include("pdf4/mpdf.php");
 //require('libreria.php');

 //$conexion = conectar ();

 //$formato=$_POST["campo1"];
 //$depto=$_POST["campo2"];
 //$estado=$_POST["campo3"];

 //$titulo=strtoupper($vt);
$html.='
<table width="800" border="0" align="center">
  <tr>
  	 <td colspan="2">
	 <table width="100%" border="0" cellpadding="1">
		  <tr>
			<td><img src="images/escudo_nacional12.png" width="100" height="76" align="right"/></td>
			<td align="center"><strong style="font-size:14px">SOFTWARE DE CORRESPONDENCIA MINISTERIAL MSyD-2012</strong></td>
			<td><img src="images/logo_ministerio12.png" width="100" height="65" /></td>
		  </tr>
		</table>     
	  </td>
  </tr>  
 </table>
';

$mpdf=new mPDF ('','LEGAL','','',10,8,5,20);
//$mpdf->AddPage('','','','','','',5,5,10,5,1,5);
//$mpdf->AddPage('L','','','','','','','','','','','');
$mpdf->AddPage();
$mpdf->SetFooter('Encargado de Fideicomiso|{PAGENO} de {nb}|Copyright {DATE j-m-Y}');
$mpdf->WriteHTML($html);

$mpdf->Output();


exit;

?>
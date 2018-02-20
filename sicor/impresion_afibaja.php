<?php
//include('pdf4/mpdf.php');
include('mpdf/mpdf.php');

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

	$s_hr="select * from afiliacionbaja where afiliacionbaja_id='$hruta'";
	mysql_query("SET CHARACTER SET utf8");
	//mysql_query("SET NAMES utf8");	
	mysql_query ("SET NAMES 'utf8'");
	$r_hr = mysql_query($s_hr, $conn);
	$row_dep=mysql_fetch_array($r_hr);

$numafi1=$row_dep[1];
$afipat1=utf8_decode($row_dep[2]);
$afimat1=utf8_decode($row_dep[3]);
$afinom1=utf8_decode($row_dep[4]);
$afinuma1=$row_dep[5];

$afisalm1=$row_dep[6];
$afifndia1=$row_dep[7];
$afifnmes1=$row_dep[8];
$afifnano1=$row_dep[9];
$afizon1=utf8_decode($row_dep[10]);
$afifdepto=$row_dep[13];
$fecha_afi1=$row_dep[14];
$fbexp=$row_dep[17];
/*
$afical1=utf8_decode($row_dep[11]);
$afinro1=$row_dep[12];
$afiloc1=$row_dep[13];

$afiocup1=utf8_decode($row_dep[15]);
$afifndia21=$row_dep[16];
$afifnmes21=$row_dep[17];
$afifnano21=$row_dep[18];

*/

$separar=explode('-',$fecha_afi1);

$fecha_afidia3=$separar[2];
$fecha_afimes3=$separar[1];
$fecha_afiano3=$separar[0];

if($afisex1=='M' || $afisex1=='m'){$afisex1='Masculino';}
if($afisex1=='F' || $afisex1=='f'){$afisex1='Femenino';}


if($fecha_afimes3==1){$fecha_afimes3='Enero';}
if($fecha_afimes3==2){$fecha_afimes3='Febrero';}
if($fecha_afimes3==3){$fecha_afimes3='Marzo';}
if($fecha_afimes3==4){$fecha_afimes3='Abril';}
if($fecha_afimes3==5){$fecha_afimes3='Mayo';}
if($fecha_afimes3==6){$fecha_afimes3='Junio';}
if($fecha_afimes3==7){$fecha_afimes3='Julio';}
if($fecha_afimes3==8){$fecha_afimes3='Agosto';}
if($fecha_afimes3==9){$fecha_afimes3='Septiembre';}
if($fecha_afimes3==10){$fecha_afimes3='Octubre';}
if($fecha_afimes3==11){$fecha_afimes3='Noviembre';}
if($fecha_afimes3==12){$fecha_afimes3='Diciembre';}

$html.='
<table width="721" border="0" cellpadding="0">
  
  <tr>
    <td height="72" colspan="8" align="center"></td>
  </tr>
  <tr>
	<td width="58" align="center" style="font-size:12px"></td>
    <td width="59" align="center" style="font-size:12px"></td>
    <td width="58" align="center" style="font-size:12px"></td>
    <td width="78" align="right" style="font-size:12px"></td>
    <td width="116" align="right" style="font-size:12px"></td>
    <td width="143" align="center" style="font-size:10px"></td>
    <td width="81" align="left" style="font-size:12px"></td>
    <td width="116" align="left" style="font-size:12px">CI: '.utf8_encode ($numafi1).'  '.utf8_encode ($fbexp).'</td>
   </tr>
    <tr>
    <td height="48" colspan="8" align="center"></td>
  </tr>
  <tr>
    <td colspan="3" align="center" style="font-size:12px">'.utf8_encode ($afipat1).'</td>
    <td colspan="2" align="center" style="font-size:12px">'.utf8_encode ($afimat1).'</td>
    <td align="center" style="font-size:12px">'.utf8_encode ($afinom1).'</td>
    <td colspan="2" align="center" style="font-size:12px">'.utf8_encode ($afinuma1).'</td>
  </tr>
  <tr>
    <td height="52" colspan="8" align="center"></td>
  </tr>
  <tr>
    <td width="58" height="41" align="center" style="font-size:12px"></td>
    <td width="59" align="center" style="font-size:12px">'.utf8_encode ($afisalm1).'</td>
    <td width="58" align="center" style="font-size:12px"></td>
    <td width="78" align="right" style="font-size:12px">'.utf8_encode ($afifndia1).'</td>
    <td width="116" align="right" style="font-size:12px">'.utf8_encode ($afifnmes1).'</td>
    <td width="143" align="center" style="font-size:10px"></td>
    <td width="81" align="left" style="font-size:12px">'.utf8_encode ($afifnano1).'</td>
    <td width="116" align="left" style="font-size:10px">'.utf8_encode ($afizon1).'</td>
  </tr>
  
  <tr>
    <td height="30" colspan="8" align="center"></td>
  </tr>
 
  <tr>
    <td height="41" colspan="6" align="center">MINISTERIO DE SALUD </td>
    <td colspan="2" align="right">01-911-0009</td>
  </tr>
  <tr>
    <td height="36" colspan="6" align="center" style="font-size:13px">'.utf8_encode ($afifdepto).', '.utf8_encode ($fecha_afidia3).' de '.utf8_encode ($fecha_afimes3).' de '.utf8_encode ($fecha_afiano3).'</td>
    <td colspan="2"></td>
  </tr>
</table>

';
 
$mpdf=new mPDF ('','','','',10,5,5,5);
//$mpdf->AddPage('','','','','','',5,5,10,5,1,5);
//$mpdf->AddPage('L','','','','','','','','','','','');
//$mpdf->AddPage();
$mpdf->WriteHTML($html);
$mpdf->Output();
exit;
?>

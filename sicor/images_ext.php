<?php
require_once("../rtf/Rtf.php");
include("script/functions.inc");
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
//paragraph formats
$parF = new ParFormat();

$parGreyLeft = new ParFormat();
$parGreyLeft->setShading(10);

$parGreyCenter = new ParFormat('center');
$parGreyCenter->setShading(10);

$rtf = new Rtf();
$null = null;

$header = &$rtf->addHeader('all');
$header->addImage('images/cabezaMSD.jpg', $parF,15);
$header->writeText("<hr>", new Font(), new ParFormat());
//$header->writeText(' Image in header.', new Font(), new ParFormat());
//inicio para
//referencia y fecha
$bus= mysql_query("SELECT * FROM hojaexterna where hojaexterna_id='$_GET[valor_enviado]'",$conn);
if($fila=mysql_fetch_array($bus))
{      $hoja=$fila["hojaexterna_hoja"];
	   $refere=$fila["hojaexterna_referencia"];
	   $carg=$fila["hojaexterna_cargo"];
       $fecha=MesLiteral($fila["hojaexterna_fecha"]);
	   $destina=$fila["hojaexterna_destinatario"];
}

$sect = &$rtf->addSection();
$sect->writeText("La Paz, $fecha", new Font(12, 'tahoma', '#000000'), new ParFormat('left'));
$sect->writeText("<b>CITE: $hoja</b>", new Font(12, 'tahoma', '#000000'), new ParFormat('left'));
$sect->writeText("\n", new Font(), new ParFormat());
$sect->writeText("Senor(a):", new Font(12, 'tahoma', '#000000'), new ParFormat('left'));
$sect->writeText("$destina", new Font(12, 'tahoma', '#000000'), new ParFormat('left'));
$sect->writeText("<b>$carg</b>", new Font(12, 'tahoma', '#000000'), new ParFormat('left'));
$sect->writeText("\n", new Font(), new ParFormat());
$sect->writeText("<b>REF. $refere</b>", new Font(12, 'tahoma', '#000000'), new ParFormat('right'));


$sect->writeText("\n", new Font(), new ParFormat());
//PONER CUERPO SI LO DESEAN

$footer = &$rtf->addFooter('all');
$footer->addImage('images/pieMSD.jpg', $parF,16);
$rtf->sendRtf('Images');
?>
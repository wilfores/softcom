<?php
require_once("../rtf/Rtf.php");
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
$header->addImage('images/adsib123.jpg', $parF,15);
$header->writeText("<hr>", new Font(), new ParFormat());



//$header->writeText(' Image in header.', new Font(), new ParFormat());

$sect = &$rtf->addSection();
$sect->writeText("<b>MEMORANDUM</b>", new Font(12, 'tahoma', '#000000'), new ParFormat('center'));
$sect->writeText("<b>$valor_enviado</b>", new Font(12, 'tahoma', '#000000'), new ParFormat('center'));
$sect->writeText("\n", new Font(), new ParFormat());

//inicio para
$resultado= mysql_query("SELECT * FROM derivaciones where derivaciones_hoja_interna='$valor_enviado' AND derivaciones_estado='P'" ,$conn);
//referencia y fecha
$bus= mysql_query("SELECT * FROM registroarchivo where registroarchivo_hoja_interna='$valor_enviado' AND registroarchivo_tipo='MEMORANDUMS'" ,$conn);
$var = mysql_fetch_array($bus);
$referencia=$var["registroarchivo_referencia"];
$fecha=$var["registroarchivo_fecha"];
//fin de referncia y fecha
$sw=0;
while($registro = mysql_fetch_array($resultado))
{ $ci=$registro["derivaciones_cod_usr"];
$ultimo= mysql_query("SELECT * FROM usuario where usuario_cod_usr='$ci'" ,$conn);
$identificador= mysql_fetch_array($ultimo);
$nombre=$identificador["usuario_nombre"];
$cargo=$identificador["usuario_ocupacion"];
if ($sw==0)
{$sect->writeText("            PARA   :   ".$nombre, new Font(11, 'tahoma', '#000000'), new ParFormat());
$sect->writeText("                        <b>".strtoupper($cargo)."</b>", new Font(11, 'tahoma', '#000000'), new ParFormat());
 $sw=1;
}
else
{
$sect->writeText("                        ".$nombre, new Font(11, 'tahoma', '#000000'), new ParFormat());
$sect->writeText("                        <b>".strtoupper($cargo)."</b>", new Font(11, 'tahoma', '#000000'), new ParFormat());
}
}
//fin para
$sect->writeText("\n", new Font(), new ParFormat());
//inicio via
$resultado1= mysql_query("SELECT * FROM derivaciones where derivaciones_hoja_interna='$valor_enviado' AND derivaciones_estado='V'" ,$conn);
$sw=1;
while($registro1 = mysql_fetch_array($resultado1))
{
$ci1=$registro1["derivaciones_cod_usr"];
$ultimo1= mysql_query("SELECT * FROM usuario where usuario_cod_usr='$ci1'" ,$conn);
$identificador1= mysql_fetch_array($ultimo1);
$nombre1=$identificador1["usuario_nombre"];
$cargo1=$identificador1["usuario_ocupacion"];

if ($sw1==0)
{
$sect->writeText("            VIA     :   ".$nombre1, new Font(11, 'tahoma', '#000000'), new ParFormat());
$sect->writeText("                        <b>".strtoupper($cargo1)."</b>", new Font(11, 'tahoma', '#000000'), new ParFormat());
$sw1=1;
}
else
{
$sect->writeText("                        ".$nombre1, new Font(11, 'tahoma', '#000000'), new ParFormat());
$sect->writeText("                        <b>".strtoupper($cargo1)."</b>", new Font(11, 'tahoma', '#000000'), new ParFormat());
}
}
//fin via
$sect->writeText("\n", new Font(), new ParFormat());
//inicio de
$resultado2= mysql_query("SELECT * FROM derivaciones where derivaciones_hoja_interna='$valor_enviado' AND derivaciones_estado='D'" ,$conn);
$sw=2;
while($registro2 = mysql_fetch_array($resultado2))
{
$ci2=$registro2["derivaciones_cod_usr"];
$ultimo2= mysql_query("SELECT * FROM usuario where usuario_cod_usr='$ci2'" ,$conn);
$identificador2= mysql_fetch_array($ultimo2);
$nombre2=$identificador2["usuario_nombre"];
$cargo2=$identificador2["usuario_ocupacion"];

if ($sw2==0)
{
$sect->writeText("            DE      :   ".$nombre2, new Font(11, 'tahoma', '#000000'), new ParFormat());
$sect->writeText("                        <b>".strtoupper($cargo2)."</b>", new Font(11, 'tahoma', '#000000'), new ParFormat());
$sw2=1;
}
else
{
$sect->writeText("                        ".$nombre2, new Font(11, 'tahoma', '#000000'), new ParFormat());
$sect->writeText("                        <b>".strtoupper($cargo2)."</b>", new Font(11, 'tahoma', '#000000'), new ParFormat());
}
}
//fin de
$sect->writeText("\n", new Font(), new ParFormat());
$sect->writeText("            REF.    :   ".$referencia, new Font(11, 'tahoma', '#000000'), new ParFormat());
$sect->writeText("\n", new Font(), new ParFormat());
$sect->writeText("            FECHA :    ".$fecha, new Font(11, 'tahoma', '#000000'), new ParFormat());
$sect->writeText("<HR>", new Font(), new ParFormat());
$sect->writeText("<BR/>", new Font(), new ParFormat());
$sect->writeText("<BR/>", new Font(), new ParFormat());
$sect->writeText("<BR/>", new Font(), new ParFormat());

$footer = &$rtf->addFooter('all');
$footer->addImage('images/pie.jpg', $parF,16);
$rtf->sendRtf('Images');
?>
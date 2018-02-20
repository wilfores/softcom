<?php
include("../filtro.php");
?>
<?php
require_once("../rtf/Rtf.php");
include("script/functions.inc");
include("../conecta.php");
//$gestion=$_SESSION["gestion"];
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
//$conn=mysql_connect("localhost","root","");
//mysql_select_db($base,$conn);
$codigo = $_SESSION["codigo"];
$depto= $_SESSION["departamento"];
$hr=descifrar($_GET["hr1"]);
$docas=$_GET["as"];

$tipo_doc=mysql_query("select documentos_id, documentos_descripcion 
 from `registrodoc2`, `documentos`
 where registrodoc2_cite='$hr'
 and registrodoc2_doc=documentos_sigla
 GROUP by registrodoc2_hoja_ruta",$conn);
$rdoc=mysql_fetch_array($tipo_doc);
$notas=$rdoc[0];
$tipo_doc=$rdoc[1];

$doc=mysql_query("select * 
 from `registrodoc2`
 where registrodoc2_cite='$hr'
 GROUP by registrodoc2_hoja_ruta",$conn);
$rver=mysql_fetch_array($doc);

  $int_ext=$rver["registrodoc2_tipo"];/*tipo de doc interno o externo*/
  $cite=$rver["registrodoc2_cite"];/*cite*/
  $ref=$rver["registrodoc2_referencia"];
  //$tipo_doc=$rver["registrodoc1_doc"];
  $de=$rver["registrodoc2_de"];
  $cod_depto_de=$rver["registrodoc2_depto"];
  $para=$rver["registrodoc2_para"];
  $cod_depto_para=$rver["registrodoc2_depto_para"];
  $fech_ela=$rver["registrodoc2_fecha_elaboracion"];
  
  $depto_cod_a=$rver["registrodoc2_depto"];
  $depto_cod_para=$rver["registrodoc2_depto_para"];


//paragraph formats
$parF = new ParFormat();
$parGreyLeft = new ParFormat();
$parGreyLeft->setShading(10);
$parGreyCenter = new ParFormat('center');
$parGreyCenter->setShading(10);
$rtf = new Rtf();
$null = null;
$header = &$rtf->addHeader('all');

//$header->addImage('images/adsib123.jpg', $parF,15);
//$header->writeText(' Image in header.', new Font(), new ParFormat());

$texto = str_replace ("&ntilde;", "ñ" ,$parrafo);
$texto = str_replace ("&oacute;", "o" ,$texto);
$texto = str_replace ("&iacute;", "i" ,$texto);
$texto = str_replace ("&nbsp;", " " ,$texto);
$texto = str_replace ("&Oacute;", "O" ,$texto);
$texto = str_replace ("</p>", "" ,$texto);
$texto = str_replace ("<p>", "" ,$texto);
$texto = str_replace ("&uacute;", "u" ,$texto);
$texto = str_replace ("&eacute;", "e" ,$texto);
$texto = str_replace ("&deg;", "ª" ,$texto);
$texto = str_replace ("&Eacute;", "E" ,$texto);
$texto = str_replace ("&aacute;", "a" ,$texto);
$texto = str_replace ("&ldquo;", "'" ,$texto);
$texto = str_replace ("&rdquo;", "'" ,$texto);

    
	$array_fech=split('-',$fech_ela);
		
	$anio=$array_fech['0'];
	$mes=$array_fech['1'];
	$di=$array_fech['2'];
	
	$array_fech=split(' ',$di);
	$dia=$array_fech['0'];
	$hor=$array_fech['1'];
	
	if($mes=="01"){ $mes1=Enero;}
	elseif($mes=="02"){ $mes1=Febrero;}
	elseif($mes=="03"){ $mes1=Marzo;}
	elseif($mes=="04"){ $mes1=Abril;}
	elseif($mes=="05"){ $mes1=Mayo;}
	elseif($mes=="06"){ $mes1=Junio;}
	elseif($mes=="07"){ $mes1=Julio;}
	elseif($mes=="08"){ $mes1=Agosto;}
	elseif($mes=="09"){ $mes1=Septiembre;}
	elseif($mes=="10"){ $mes1=Octubre;}
	elseif($mes=="11"){ $mes1=Noviembre;}
	elseif($mes=="12"){ $mes1=Diciembre;}
	
	$fecha_act="La Paz, ".$dia." de ".$mes1." de ".$anio;
	
	//$fecha_act=date("Y-m-d H:i:s");
	//$uni='AREA DE SISTEMAS E INFORMATICA';

if($notas =='50' || $notas =='51' || $notas =='52' || $notas =='53' || $notas =='54')/*MEMORANDUM DE ADQUISION */
{	
		
	$header->addImage('images/cabezaMEMO.jpg', $parF,16);

	$sect = &$rtf->addSection();
	//$sect->writeText("".$tipo_doc, new Font(15, 'tahoma', '#000000'), new ParFormat('center'));
	$sect->writeText("<b>MEMORANDUM</b>", new Font(24, 'tahoma', '#000000'), new ParFormat('center'));
	$sect->writeText("<b>".$cite."</b>", new Font(12, 'tahoma', '#000000'), new ParFormat('center'));
	$sect->addImage('images/barra_memo.jpg');
	$sect->writeText("                                              	||			     ", new Font(9, 'tahoma', '#000000'), new ParFormat('left'));
	$sect->writeText("<b>"."MINISTERIO DE SALUD          "."</b>"." 	||               ", new Font(9, 'tahoma', '#000000'), new ParFormat('RIGHT'));
	$sect->writeText("                                              	||   ".utf8_encode(Señor), new Font(9, 'tahoma', '#000000'), new ParFormat('left'));
	//$sect->writeText("                                              	||   ", new Font(9, 'tahoma', '#000000'), new ParFormat('left'));
	$sect->writeText("                                              	||   ".utf8_encode($para).".  ".utf8_encode($rwlista[3]), new Font(9, 'tahoma', '#000000'), new ParFormat('left'));
    $sect->writeText("                                                 ||   "."<b>".Presente.".-"."</b>", new Font(9, 'tahoma', '#000000'), new ParFormat('left'));
	$sect->writeText("                                              	|| ", new Font(9, 'tahoma', '#000000'), new ParFormat('left'));
	

	$sect->writeText("".$fecha_act."                          ", new Font(9, 'tahoma', '#000000'), new ParFormat('left'));
	$sect->addImage('images/barra_memo2.png');
	//$sect->writeText("<b><hr></b>", new Font(9, 'Monotype Corsiva', '#000000'), new ParFormat('center'));
	$sect->writeText("\n", new Font(), new ParFormat());				
	$sect->writeText("De mi ".utf8_encode(consideraciòn), new Font(11, 'tahoma', '#000000'), new ParFormat('left'));

	//$footer = &$rtf->addFooter('all');
	//$footer->addImage('', $parF,15);
	$footer = &$rtf->addFooter('all');
	$footer->addImage('images/logo22013.jpg', $parF,15);
	$rtf->sendRtf('Images');

}



?>
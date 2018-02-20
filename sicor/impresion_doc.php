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
 from `registrodoc1`, `documentos`
 where registrodoc1_cite='$hr'
 and registrodoc1_doc=documentos_sigla
 GROUP by registrodoc1_hoja_ruta",$conn);
$rdoc=mysql_fetch_array($tipo_doc);
$notas=$rdoc[0];
$tipo_doc=$rdoc[1];

$doc=mysql_query("select * 
 from `registrodoc1`
 where registrodoc1_cite='$hr'
 GROUP by registrodoc1_hoja_ruta",$conn);
$rver=mysql_fetch_array($doc);

  $int_ext=$rver["registrodoc1_tipo"];/*tipo de doc interno o externo*/
  $cite=$rver["registrodoc1_cite"];/*cite*/
  $ref=$rver["registrodoc1_referencia"];
  //$tipo_doc=$rver["registrodoc1_doc"];
  $de=$rver["registrodoc1_de"];
  $cod_depto_de=$rver["registrodoc1_depto"];
  $para=$rver["registrodoc1_para"];
  $cod_depto_para=$rver["registrodoc1_depto_para"];
  $fech_ela=$rver["registrodoc1_fecha_elaboracion"];
  
  $depto_cod_a=$rver["registrodoc1_depto"];
  $depto_cod_para=$rver["registrodoc1_depto_para"];


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

if($notas == '6' || $notas =='7')/*CIRCULAR-----INSTRUCTIVO*/
{	
	$texto='A LOS SEÑORES-AS  VICEMINISTROS-AS DIRECTORES-AS GENERALES JEFES-AS DE UNIDAD, COORDINADORES-AS, RESPONSABLES DE PROGRAMAS Y PROYECTOS Y PERSONAL EN GENERAL DEL MINISTERIO DE SALUD';	
	
	$pie='2012 AÑO DE LA NO VIOLENCIA CONTRA LA NIÑEZ Y ADOLECENCIA EN EL ESTADO PLURINACIONAL';
	
	$header->addImage('images/cabezaMSD.jpg', $parF,16);

	$sect = &$rtf->addSection();
	//$sect->writeText("".$uni, new Font(9, 'Monotype Corsiva', '#000000'), new ParFormat('right'));
	$sect->writeText("<u><b>".$tipo_doc."</b></u>", new Font(18, 'tahoma', '#000000'), new ParFormat('center'));
	$sect->writeText("<b>".$cite."</b>", new Font(12, 'tahoma', '#000000'), new ParFormat('center'));
	$sect->writeText("<em></em>", new Font(15, 'tahoma', '#000000'), new ParFormat('center'));	
	$sect->writeText("<em>".utf8_encode($texto)."</em>", new Font(15, 'tahoma', '#000000'), new ParFormat('justify'));
	$sect->writeText("\n", new Font(), new ParFormat());		
	$sect->writeText("\n", new Font(), new ParFormat());	
	$sect->writeText("\n", new Font(), new ParFormat());		
	$sect->writeText("\n", new Font(), new ParFormat());
	$sect->writeText("\n", new Font(), new ParFormat());		
	$sect->writeText("\n", new Font(), new ParFormat());	
	$sect->writeText("\n", new Font(), new ParFormat());		
	$sect->writeText("\n", new Font(), new ParFormat());
	$sect->writeText("\n", new Font(), new ParFormat());		
	$sect->writeText("\n", new Font(), new ParFormat());	
	$sect->writeText("\n", new Font(), new ParFormat());		
	$sect->writeText("\n", new Font(), new ParFormat());
	$sect->writeText("\n", new Font(), new ParFormat());		
	$sect->writeText("\n", new Font(), new ParFormat());	
	$sect->writeText("\n", new Font(), new ParFormat());		
	$sect->writeText("\n", new Font(), new ParFormat());
	$sect->writeText("\n", new Font(), new ParFormat());		
	$sect->writeText("\n", new Font(), new ParFormat());	
	$sect->writeText("\n", new Font(), new ParFormat());		
	$sect->writeText("\n", new Font(), new ParFormat());
	$sect->writeText("\n", new Font(), new ParFormat());		
	$sect->writeText("\n", new Font(), new ParFormat());	
	$sect->writeText("\n", new Font(), new ParFormat());		
	$sect->writeText("\n", new Font(), new ParFormat());	
	
	$sect->writeText("".$fecha_act, new Font(11, 'tahoma', '#000000'), new ParFormat('center'));
	//$sect->writeText("<hr>", new Font(9, 'Monotype Corsiva', '#000000'), new ParFormat('right'));
	$sect->writeText("\n", new Font(), new ParFormat());
	//$sect->writeText(utf8_encode($pie), new Font(8, 'tahoma', '#000000'), new ParFormat('center'));
	$footer = &$rtf->addFooter('all');
	
	$footer->addImage('images/logo22013.jpg', $parF,15);
	$rtf->sendRtf('Images');
}

if($notas =='19' || $notas =='1' || $notas =='34' || $notas =='35' || $notas =='36' || $notas =='39')/*MEMORANDUM DE ADQUISION */
{	
		
	$header->addImage('images/cabezaMEMO.jpg', $parF,16);

	$sect = &$rtf->addSection();
	//$sect->writeText("".$tipo_doc, new Font(15, 'tahoma', '#000000'), new ParFormat('center'));
	$sect->writeText("MEMORANDUM", new Font(15, 'tahoma', '#000000'), new ParFormat('center'));
	$sect->writeText("<b>".$cite."</b>", new Font(15, 'tahoma', '#000000'), new ParFormat('center'));
	$sect->addImage('images/barra_memo.jpg');
	$sect->writeText("                                              	|			     ", new Font(9, 'tahoma', '#000000'), new ParFormat('left'));
	$sect->writeText("<b>"."      MINISTERIO DE SALUD     "."</b>"." 	|               ", new Font(9, 'tahoma', '#000000'), new ParFormat('RIGHT'));
	$sect->writeText("                                              	|   ".utf8_encode(Señores), new Font(9, 'tahoma', '#000000'), new ParFormat('left'));
	
	$slista="SELECT 
	registrodoc1_hoja_ruta, registrodoc1_fecha_elaboracion, usuario_titulo, usuario_nombre, registrodoc1_referencia, documentos_descripcion, registrodoc1_estado
	FROM `registrodoc1`, `documentos`, `usuario`
	where registrodoc1_cite='$hr'
	and registrodoc1_para=usuario_ocupacion
	and registrodoc1_doc=documentos_sigla";
	$rslista=mysql_query($slista,$conn);
	while($rwlista=mysql_fetch_array($rslista))
 	{	$fech_2=$rwlista[1];
		
		$array_fech=split('-',$rwlista[1]);
		
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
	
	$sect->writeText("                                              	|   ".utf8_encode($rwlista[2]).".  ".utf8_encode($rwlista[3]), new Font(9, 'tahoma', '#000000'), new ParFormat('left'));	
	}
	//$sect->writeText("                                              	|   ", new Font(9, 'tahoma', '#000000'), new ParFormat('left'));
	$sect->writeText("                                                 |   "."<b>".Presente.".-"."</b>", new Font(9, 'tahoma', '#000000'), new ParFormat('left'));
	$sect->writeText("                                              	| ", new Font(9, 'tahoma', '#000000'), new ParFormat('left'));
	
	if($notas =='19')
    {
	$sect->writeText("                                                 |   "."<b>".COMISION." ".DE." ".CALIFICACION."</b>", new Font(9, 'tahoma', '#000000'), new ParFormat('left'));
	}
	if($notas =='39')
    {
	$sect->writeText("                                                 |   "."<b>".COMISION." ".DE." ".RECEPCION."</b>", new Font(9, 'tahoma', '#000000'), new ParFormat('left'));
	}
	$sect->writeText(" ".$fecha_act."	                 |   ", new Font(9, 'tahoma', '#000000'), new ParFormat('left'));
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

if($notas =='17' || $notas=='18' || $notas=='21')/*RESOLUCION-----CONTRATO----DOCUMENTO BASE DE CONTRATACION*/
{
	$header->addImage('images/cabezaMSD.jpg', $parF,16);

	$sect = &$rtf->addSection();
	//$sect->writeText("".$uni, new Font(9, 'Monotype Corsiva', '#000000'), new ParFormat('right'));
	$sect->writeText("".$tipo_doc, new Font(15, 'tahoma', '#000000'), new ParFormat('center'));
	$sect->writeText("<b>".$cite."</b>", new Font(15, 'tahoma', '#000000'), new ParFormat('center'));	
	$sect->writeText("".$texto, new Font(11, 'tahoma', '#000000'), new ParFormat('justify'));
	$sect->writeText("\n", new Font(), new ParFormat());		
	$sect->writeText("\n", new Font(), new ParFormat());		
	//$sect->writeText("".$fecha_act, new Font(11, 'tahoma', '#000000'), new ParFormat('center'));

	//$footer = &$rtf->addFooter('all');
	//$footer->addImage('', $parF,15);
	$footer = &$rtf->addFooter('all');
	$footer->addImage('images/logo22013.jpg', $parF,15);
	$rtf->sendRtf('Images');

}

if($notas =='22')/*INFORME DE COMISION*/ 
{
	$ll=0;
	
		$sig_usu_para=mysql_query("SELECT usuario_nombre, cargos_cargo, usuario_titulo
		from usuario , departamento , cargos 
		where usuario_ocupacion='$para'
		and usuario_cod_departamento=departamento_cod_departamento
		and usuario_ocupacion=cargos_id",$conn);
		$r_usu_para=mysql_fetch_array($sig_usu_para);
		$nom_para=$r_usu_para['usuario_nombre'];
		$cargo_para=$r_usu_para['cargos_cargo'];
		$titulo=$r_usu_para['usuario_titulo'];
		
	$header->addImage('images/cabezaMSD.jpg', $parF,16);

	$sect = &$rtf->addSection();
	//$sect->writeText("".$uni, new Font(9, 'Monotype Corsiva', '#000000'), new ParFormat('right'));
	$sect->writeText("".$tipo_doc, new Font(15, 'tahoma', '#000000'), new ParFormat('center'));
	$sect->writeText("<b>".$cite."</b>", new Font(15, 'tahoma', '#000000'), new ParFormat('center'));
	$sect->writeText("\n", new Font(), new ParFormat());	
	$sect->writeText("	A:"."       ".$titulo.". ".utf8_encode($nom_para), new Font(10,'arial', '#000000'), new ParFormat('left'));
	$sect->writeText("	         "."<b>".$cargo_para."</b>", new Font(10,'arial', '#000000'), new ParFormat('left'));
	$sect->writeText("\n", new Font(), new ParFormat());
	
		$slista="SELECT 
	registrodoc1_hoja_ruta, registrodoc1_fecha_elaboracion, usuario_titulo, usuario_nombre, registrodoc1_referencia, documentos_descripcion, registrodoc1_estado
	FROM `registrodoc1`, `documentos`, `usuario`
	where registrodoc1_cite='$hr'
	and registrodoc1_de=usuario_ocupacion
	and registrodoc1_doc=documentos_sigla";
	$rslista=mysql_query($slista,$conn);
	while($rwlista=mysql_fetch_array($rslista))
 	{	
	if($ll==0){
		$sect->writeText("	De:"."      ".$rwlista[usuario_titulo].". ".utf8_encode($rwlista[usuario_nombre]), new Font(10,'arial', '#000000'), new ParFormat('left'));
		}
	else{
		$sect->writeText("	   "."      ".$rwlista[usuario_titulo].". ".utf8_encode($rwlista[usuario_nombre]), new Font(10,'arial', '#000000'), new ParFormat('left'));
	}
	$ll=1;
	
	}
	//$sect->writeText("	         "."<b>"."COMISION DE"."</b>", new Font(10,'arial', '#000000'), new ParFormat('left'));
	$sect->writeText("\n", new Font(), new ParFormat());
	$sect->writeText("	Ref:"."     "."<b>".utf8_encode($ref)."</b>", new Font(10,'arial', '#000000'), new ParFormat('left'));
	$sect->writeText("\n", new Font(), new ParFormat());	
	
		
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
	$sect->writeText("	Fecha:"."  "."<b>".utf8_encode($fecha_act)."</b>", new Font(10,'arial', '#000000'), new ParFormat('left'));
	$sect->writeText("<b><hr></b>", new Font(15, 'Monotype Corsiva', '#000000'), new ParFormat('center'));	
	$sect->writeText("\n", new Font(), new ParFormat());
	//$footer = &$rtf->addFooter('all');
	//$footer->addImage('', $parF,15);
	$footer = &$rtf->addFooter('all');
	$footer->addImage('images/logo22013.jpg', $parF,15);
	$rtf->sendRtf('Images');

}

if($notas =='8' || $notas=='13' || $notas=='42' || $notas=='43')/*INFORME INTERNO, NOTAS INTERNAS*/ 
{	$hrt=$hr;
	$array_sig=split('-',$hrt);
	  
	if($cod_depto_de==$cod_depto_para)
	{
		$sig_usu_para=mysql_query("SELECT usuario_nombre, cargos_cargo, usuario_titulo
		from usuario , departamento , cargos 
		where usuario_ocupacion='$para'
		and usuario_cod_departamento=departamento_cod_departamento
		and usuario_ocupacion=cargos_id",$conn);
		$r_usu_para=mysql_fetch_array($sig_usu_para);
		$nom_para=$r_usu_para['usuario_nombre'];
		$cargo_para=$r_usu_para['cargos_cargo'];
		$titulo=$r_usu_para['usuario_titulo'];
		
		$header->addImage('images/cabezaMSD.jpg', $parF,16);
	
		$sect = &$rtf->addSection();
		//$sect->writeText("".$uni, new Font(9, 'Monotype Corsiva', '#000000'), new ParFormat('right'));
		$sect->writeText("".$tipo_doc, new Font(15, 'tahoma', '#000000'), new ParFormat('center'));
		$sect->writeText("<b>".$cite."</b>", new Font(15, 'tahoma', '#000000'), new ParFormat('center'));
		$sect->writeText("\n", new Font(), new ParFormat());	
		$sect->writeText("	A:"."       ".$titulo.". ".utf8_encode($nom_para), new Font(10,'arial', '#000000'), new ParFormat('left'));
		$sect->writeText("	         "."<b>".$cargo_para."</b>", new Font(10,'arial', '#000000'), new ParFormat('left'));
		$sect->writeText("\n", new Font(), new ParFormat());
		
			$slista=mysql_query("SELECT usuario_nombre, cargos_cargo, usuario_titulo
		from usuario , departamento , cargos 
		where usuario_ocupacion='$de'
		and usuario_cod_departamento=departamento_cod_departamento
		and usuario_ocupacion=cargos_id",$conn);
		$rwlista=mysql_fetch_array($slista);
		$sect->writeText("	De:"."      ".$rwlista[usuario_titulo].". ".utf8_encode($rwlista[usuario_nombre]), new Font(10,'arial', '#000000'), new ParFormat('left'));
		$sect->writeText("	         "."<b>".$rwlista[cargos_cargo]."</b>", new Font(10,'arial', '#000000'), new ParFormat('left'));
		$sect->writeText("\n", new Font(), new ParFormat());
		$sect->writeText("	Ref:"."     "."<b>".utf8_encode($ref)."</b>", new Font(10,'arial', '#000000'), new ParFormat('left'));
		$sect->writeText("\n", new Font(), new ParFormat());	
		
		
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
		$sect->writeText("	Fecha:"."  "."<b>".utf8_encode($fecha_act)."</b>", new Font(10,'arial', '#000000'), new ParFormat('left'));
		$sect->writeText("<b><hr></b>", new Font(15, 'Monotype Corsiva', '#000000'), new ParFormat('center'));	
		$sect->writeText("\n", new Font(), new ParFormat());
		//$footer = &$rtf->addFooter('all');
		//$footer->addImage('', $parF,15);
		$footer = &$rtf->addFooter('all');
	    $footer->addImage('images/logo22013.jpg', $parF,15);
		$rtf->sendRtf('Images');
	}
	else
	{
		$bvi=mysql_query("select * from via where via_mi_codigo='$codigo' and via_orden<>0 order by via_orden desc",$conn);
		if(mysql_num_rows($bvi) > 0)
        {
			$sig_usu_para=mysql_query("SELECT usuario_nombre, cargos_cargo, usuario_titulo
			from usuario , departamento , cargos 
			where usuario_ocupacion='$para'
			and usuario_cod_departamento=departamento_cod_departamento
			and usuario_ocupacion=cargos_id",$conn);
			$r_usu_para=mysql_fetch_array($sig_usu_para);
			$nom_para=$r_usu_para['usuario_nombre'];
			$cargo_para=$r_usu_para['cargos_cargo'];
			$titulo=$r_usu_para['usuario_titulo'];
			
			$header->addImage('images/cabezaMSD.jpg', $parF,16);
		
			$sect = &$rtf->addSection();
			//$sect->writeText("".$uni, new Font(9, 'Monotype Corsiva', '#000000'), new ParFormat('right'));
			$sect->writeText("".$tipo_doc, new Font(15, 'tahoma', '#000000'), new ParFormat('center'));
			$sect->writeText("<b>".$cite."</b>", new Font(15, 'tahoma', '#000000'), new ParFormat('center'));
			$sect->writeText("\n", new Font(), new ParFormat());	
			$sect->writeText("	A:"."       ".$titulo.". ".utf8_encode($nom_para), new Font(10,'arial', '#000000'), new ParFormat('left'));
			$sect->writeText("	         "."<b>".$cargo_para."</b>", new Font(10,'arial', '#000000'), new ParFormat('left'));
			$sect->writeText("\n", new Font(), new ParFormat());
			
			$rsli=mysql_query("select * from via where via_mi_codigo='$codigo' and via_orden<>0 and via_su_codigo<>'$para' order by via_orden desc",$conn);
			while($rwlista=mysql_fetch_array($rsli))
			{	
				$sig_de=mysql_query("SELECT usuario_nombre, cargos_cargo, usuario_titulo
				from usuario , departamento , cargos 
				where usuario_ocupacion='$rwlista[1]'
				and usuario_cod_departamento=departamento_cod_departamento
				and usuario_ocupacion=cargos_id",$conn);
				$r_usu_para=mysql_fetch_array($sig_de);
				$nom_via=$r_usu_para['usuario_nombre'];
				$cargo_via=$r_usu_para['cargos_cargo'];
				$tit_via=$r_usu_para['usuario_titulo'];
				
				$sect->writeText("	Via:"."     ".$tit_via.". ".utf8_encode($nom_via), new Font(10,'arial', '#000000'), new ParFormat('left'));
				$sect->writeText("	         "."<b>".$cargo_via."</b>", new Font(10,'arial', '#000000'), new ParFormat('left'));
			}
			
				$slista=mysql_query("SELECT usuario_nombre, cargos_cargo, usuario_titulo
				from usuario , departamento , cargos 
				where usuario_ocupacion='$de'
				and usuario_cod_departamento=departamento_cod_departamento
				and usuario_ocupacion=cargos_id",$conn);
				$rwlista=mysql_fetch_array($slista);
				$sect->writeText("\n", new Font(), new ParFormat());
				$sect->writeText("	De:"."      ".$rwlista[usuario_titulo].". ".utf8_encode($rwlista[usuario_nombre]), new Font(10,'arial', '#000000'), new ParFormat('left'));
				$sect->writeText("	         "."<b>".$rwlista[cargos_cargo]."</b>", new Font(10,'arial', '#000000'), new ParFormat('left'));
				$sect->writeText("\n", new Font(), new ParFormat());
				$sect->writeText("	Ref:"."     "."<b>".utf8_encode($ref)."</b>", new Font(10,'arial', '#000000'), new ParFormat('left'));
				$sect->writeText("\n", new Font(), new ParFormat());	
				
				
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
				$sect->writeText("	Fecha:"."  "."<b>".utf8_encode($fecha_act)."</b>", new Font(10,'arial', '#000000'), new ParFormat('left'));
				$sect->writeText("<b><hr></b>", new Font(15, 'Monotype Corsiva', '#000000'), new ParFormat('center'));
				$sect->writeText("\n", new Font(), new ParFormat());
			
			//$footer = &$rtf->addFooter('all');
			//$footer->addImage('', $parF,15);
			$footer = &$rtf->addFooter('all');
			$footer->addImage('images/logo22013.jpg', $parF,15);
			$rtf->sendRtf('Images');
		}
		else
		{
			$sig_usu_para=mysql_query("SELECT usuario_nombre, cargos_cargo, usuario_titulo
			from usuario , departamento , cargos 
			where usuario_ocupacion='$para'
			and usuario_cod_departamento=departamento_cod_departamento
			and usuario_ocupacion=cargos_id",$conn);
			$r_usu_para=mysql_fetch_array($sig_usu_para);
			$nom_para=$r_usu_para['usuario_nombre'];
			$cargo_para=$r_usu_para['cargos_cargo'];
			$titulo=$r_usu_para['usuario_titulo'];
			
			$header->addImage('images/cabezaMSD.jpg', $parF,16);
		
			$sect = &$rtf->addSection();
			//$sect->writeText("".$uni, new Font(9, 'Monotype Corsiva', '#000000'), new ParFormat('right'));
			$sect->writeText("".$tipo_doc, new Font(15, 'tahoma', '#000000'), new ParFormat('center'));
			$sect->writeText("<b>".$cite."</b>", new Font(15, 'tahoma', '#000000'), new ParFormat('center'));
			$sect->writeText("\n", new Font(), new ParFormat());	
			$sect->writeText("	A:"."       ".$titulo.". ".utf8_encode($nom_para), new Font(10,'arial', '#000000'), new ParFormat('left'));
			$sect->writeText("	         "."<b>".$cargo_para."</b>", new Font(10,'arial', '#000000'), new ParFormat('left'));
			$sect->writeText("\n", new Font(), new ParFormat());
			
			$rsli=mysql_query("select * from via where via_mi_codigo='$codigo' and via_orden<>0 order by via_orden desc",$conn);
			while($rwlista=mysql_fetch_array($rsli))
			{	
				$sig_de=mysql_query("SELECT usuario_nombre, cargos_cargo, usuario_titulo
				from usuario , departamento , cargos 
				where usuario_ocupacion='$rwlista[1]'
				and usuario_cod_departamento=departamento_cod_departamento
				and usuario_ocupacion=cargos_id",$conn);
				$r_usu_para=mysql_fetch_array($sig_de);
				$nom_via=$r_usu_para['usuario_nombre'];
				$cargo_via=$r_usu_para['cargos_cargo'];
				$tit_via=$r_usu_para['usuario_titulo'];
				
				$sect->writeText("	Via:"."     ".$tit_via.". ".utf8_encode($nom_via), new Font(10,'arial', '#000000'), new ParFormat('left'));
				$sect->writeText("	         "."<b>".$cargo_via."</b>", new Font(10,'arial', '#000000'), new ParFormat('left'));
				$sect->writeText("\n", new Font(), new ParFormat());
			}
			
				$slista=mysql_query("SELECT usuario_nombre, cargos_cargo, usuario_titulo
				from usuario , departamento , cargos 
				where usuario_ocupacion='$de'
				and usuario_cod_departamento=departamento_cod_departamento
				and usuario_ocupacion=cargos_id",$conn);
				$rwlista=mysql_fetch_array($slista);
				//$sect->writeText("\n", new Font(), new ParFormat());
				$sect->writeText("	De:"."      ".$rwlista[usuario_titulo].". ".utf8_encode($rwlista[usuario_nombre]), new Font(10,'arial', '#000000'), new ParFormat('left'));
				$sect->writeText("	         "."<b>".$rwlista[cargos_cargo]."</b>", new Font(10,'arial', '#000000'), new ParFormat('left'));
				$sect->writeText("\n", new Font(), new ParFormat());
				$sect->writeText("	Ref:"."     "."<b>".utf8_encode($ref)."</b>", new Font(10,'arial', '#000000'), new ParFormat('left'));
				$sect->writeText("\n", new Font(), new ParFormat());	
				
				
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
				$sect->writeText("	Fecha:"."  "."<b>".utf8_encode($fecha_act)."</b>", new Font(10,'arial', '#000000'), new ParFormat('left'));
				$sect->writeText("<b><hr></b>", new Font(15, 'Monotype Corsiva', '#000000'), new ParFormat('center'));
				$sect->writeText("\n", new Font(), new ParFormat());
			//$footer = &$rtf->addFooter('all');
			//$footer->addImage('', $parF,15);
			$footer = &$rtf->addFooter('all');
			$footer->addImage('images/logo22013.jpg', $parF,15);
			$rtf->sendRtf('Images');
		}
	}

}
if($notas =='10' || $notas=='47')
{	/*TODOS LOS DEMAS DOCUMENTOS */
	$header->addImage('images/cabezaMSD.jpg', $parF,16);
	$s='Señor(a)';
	$sect = &$rtf->addSection();
	//$sect->writeText("".$uni, new Font(9, 'Monotype Corsiva', '#000000'), new ParFormat('right'));
	//$sect->writeText("".$tipo_doc, new Font(15, 'tahoma', '#000000'), new ParFormat('center'));
	$sect->writeText("\n", new Font(), new ParFormat());
	$sect->writeText("".$fecha_act, new Font(11, 'tahoma', '#000000'), new ParFormat('left'));
	$sect->writeText("<strong><em><b>".$cite."</b></em></strong>", new Font(11, 'tahoma', '#000000'), new ParFormat('left'));	
    $sect->writeText("\n", new Font(), new ParFormat());			
	$sect->writeText("<strong><b>".utf8_encode($s).":</b></strong>", new Font(11, 'tahoma', '#000000'), new ParFormat('left'));
	$sect->writeText("\n", new Font(), new ParFormat());		
	$sect->writeText("\n", new Font(), new ParFormat());
	$sect->writeText("<strong><b>Presente:</b></strong>", new Font(11, 'tahoma', '#000000'), new ParFormat('left'));			
	$sect->writeText("\n", new Font(), new ParFormat());	
	$sect->writeText("<strong><em><b>Ref.:".utf8_encode($ref)."</b></em></strong>", new Font(11, 'tahoma', '#000000'), new ParFormat('center'));	
	$sect->writeText("\n", new Font(), new ParFormat());
	
	//$footer = &$rtf->addFooter('all');
	//$footer->addImage('', $parF,15);
	$footer = &$rtf->addFooter('all');
	$footer->addImage('images/logo22013.jpg', $parF,15);
	$rtf->sendRtf('Images');
}

if($notas =='45')
{	/*TODOS LOS DEMAS DOCUMENTOS */
	$header->addImage('images/cabezaMSD.jpg', $parF,16);
	$s='Señor(a)';
	$M='MINISTERIO DE SALUD';
	$sect = &$rtf->addSection();
	//$sect->writeText("".$uni, new Font(9, 'Monotype Corsiva', '#000000'), new ParFormat('right'));
	//$sect->writeText("".$tipo_doc, new Font(15, 'tahoma', '#000000'), new ParFormat('center'));
	$sect->writeText("\n", new Font(), new ParFormat());
	$sect->writeText("".$fecha_act, new Font(11, 'tahoma', '#000000'), new ParFormat('left'));
	$sect->writeText("<strong><em><b>".$cite."</b></em></strong>", new Font(11, 'tahoma', '#000000'), new ParFormat('left'));	
    $sect->writeText("\n", new Font(), new ParFormat());			
	$sect->writeText("<strong><b>".utf8_encode($s).":</b></strong>", new Font(11, 'tahoma', '#000000'), new ParFormat('left'));
	
	$sig_usu_para=mysql_query("SELECT usuario_nombre, cargos_cargo, usuario_titulo
		from usuario , departamento , cargos 
		where usuario_ocupacion='$para'
		and usuario_cod_departamento=departamento_cod_departamento
		and usuario_ocupacion=cargos_id",$conn);
		$r_usu_para=mysql_fetch_array($sig_usu_para);
		$nom_para=$r_usu_para['usuario_nombre'];
		$cargo_para=$r_usu_para['cargos_cargo'];
		$titulo=$r_usu_para['usuario_titulo'];

		//$sect->writeText("".$uni, new Font(9, 'Monotype Corsiva', '#000000'), new ParFormat('right'));	
	$sect->writeText("".$titulo.". ".utf8_encode($nom_para), new Font(10,'arial', '#000000'), new ParFormat('left'));
	$sect->writeText(""."<b>".$cargo_para."</b>", new Font(10,'arial', '#000000'), new ParFormat('left'));
	$sect->writeText("<strong><b>".utf8_encode($M)."</b></strong>", new Font(11, 'tahoma', '#000000'), new ParFormat('left'));
	//$sect->writeText("\n", new Font(), new ParFormat());		
	$sect->writeText("\n", new Font(), new ParFormat());
	$sect->writeText("<strong><b>Presente:</b></strong>", new Font(11, 'tahoma', '#000000'), new ParFormat('left'));	
	$sect->writeText("\n", new Font(), new ParFormat());			
	$sect->writeText("<strong><em><b>Ref.:".utf8_encode($ref)."</b></em></strong>", new Font(11, 'tahoma', '#000000'), new ParFormat('center'));	
	$sect->writeText("\n", new Font(), new ParFormat());
	
	//$footer = &$rtf->addFooter('all');
	//$footer->addImage('', $parF,15);
	$footer = &$rtf->addFooter('all');
	$footer->addImage('images/logo22013.jpg', $parF,15);
	$rtf->sendRtf('Images');
}
else
{	/*TODOS LOS DEMAS DOCUMENTOS */
	$header->addImage('images/cabezaMSD.jpg', $parF,16);

	$sect = &$rtf->addSection();
	//$sect->writeText("".$uni, new Font(9, 'Monotype Corsiva', '#000000'), new ParFormat('right'));
	$sect->writeText("".$tipo_doc, new Font(15, 'tahoma', '#000000'), new ParFormat('center'));
	$sect->writeText("<b>".$cite."</b>", new Font(15, 'tahoma', '#000000'), new ParFormat('center'));	
	$sect->writeText("".$texto, new Font(11, 'tahoma', '#000000'), new ParFormat('justify'));
	$sect->writeText("\n", new Font(), new ParFormat());		
	$sect->writeText("\n", new Font(), new ParFormat());		
	$sect->writeText("".$fecha_act, new Font(11, 'tahoma', '#000000'), new ParFormat('center'));
	$sect->writeText("\n", new Font(), new ParFormat());
	//$footer = &$rtf->addFooter('all');
	//$footer->addImage('', $parF,15);
	$footer = &$rtf->addFooter('all');
	$footer->addImage('images/logo22013.jpg', $parF,15);
	$rtf->sendRtf('Images');
}

?>
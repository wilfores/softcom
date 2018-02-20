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
$cod_usr = $_SESSION["codigo"];
$unidad = $_SESSION["departamento"];
$nota=$_GET["nota"];
//paragraph formats
$parF = new ParFormat();
$parGreyLeft = new ParFormat();
$parGreyLeft->setShading(10);
$parGreyCenter = new ParFormat('center');
$parGreyCenter->setShading(10);
$rtf = new Rtf();
$null = null;
$consulta_unidad = "select departamento_descripcion_dep from departamento where departamento_cod_departamento='$unidad'";
$rss_dep = mysql_query($consulta_unidad, $conn);
$fila_dep = mysql_fetch_array($rss_dep);
$uni = $fila_dep[0];
$header = &$rtf->addHeader('all');
//$header->addImage('images/adsib123.jpg', $parF,15);
$cabeza=mysql_query("SELECT * FROM registroarchivo",$conn);
$row= mysql_fetch_array($cabeza);
//$header->writeText(' Image in header.', new Font(), new ParFormat());
$consulta_documento = "SELECT documentos_descripcion,registroarchivo_hoja_interna,registroarchivo_referencia,registroarchivo_texto,registroarchivo_membrete,
                        LOWER( DATE_FORMAT(registroarchivo_fecha_recepcion, '%d-%m-%Y')) AS fecha 
                         FROM documentos d, registroarchivo r WHERE r.registroarchivo_codigo = '$_SESSION[valor_enviado_archivo]'
                         AND r.registroarchivo_tipo=d.documentos_id";	
$rss_documento = mysql_query($consulta_documento, $conn);
$fila_documento = mysql_fetch_array($rss_documento);
$notas=$fila_documento[0];
$notas1=$fila_documento[1];
$texto = str_replace ("&ntilde;", "ñ" ,$fila_documento[3]);
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
$membrete=$fila_documento[4];
    $array_fech=split('-',$fila_documento[5]);
	$dia=$array_fech['0'];
	$mes=$array_fech['1'];
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
	$anio=$array_fech['2'];
	$fecha_act="La Paz ".$dia." de ".$mes1." de ".$anio;

if ($membrete == 'S') 
{
$header->addImage('images/cabezaMSD.jpg', $parF,16);
$header->writeText("<hr>", new Font(), new ParFormat());
}
else
{
//$header->addImage('images/cabeza_vaciaMPD.jpg', $parF,15);
$header->addImage('images/cabezaMSD.jpg', $parF,16);
$header->writeText("<hr>", new Font(), new ParFormat());
}
$consulta_para = "SELECT b.usuario_nombre, c.cargos_cargo, usuario_cod_departamento, b.usuario_titulo
                         FROM derivaciones a, usuario b, cargos c
                         WHERE a.derivaciones_hoja_interna = '$_SESSION[valor_enviado_archivo]'
                         AND a.derivaciones_estado = 'P'
                         AND a.derivaciones_cod_usr = b.usuario_ocupacion
                         AND b.usuario_ocupacion = c.cargos_id";
$rss_para = mysql_query($consulta_para, $conn);

        
$consulta_para = "SELECT b.usuario_nombre, c.cargos_cargo FROM derivaciones a, usuario b, cargos c
                         WHERE a.derivaciones_hoja_interna = '$_SESSION[valor_enviado_archivo]'
                         AND a.derivaciones_estado = 'V'
                         AND a.derivaciones_cod_usr = b.usuario_ocupacion
                         AND b.usuario_ocupacion = c.cargos_id";	
$rss_via = mysql_query($consulta_para, $conn);
$rss_contador = mysql_num_rows($rss_via);

$consulta_de = "SELECT b.usuario_nombre, c.cargos_cargo FROM derivaciones a, usuario b, cargos c
                         WHERE a.derivaciones_hoja_interna = '$_SESSION[valor_enviado_archivo]'
                         AND a.derivaciones_estado = 'D'
                         AND a.derivaciones_cod_usr = b.usuario_ocupacion
                         AND b.usuario_ocupacion = c.cargos_id";
$rss_de = mysql_query($consulta_de, $conn);

// Inicio de carta Interna o Externa
if($notas == "CARTA INTERNA" || $notas =="CARTA EXTERNA")
{

	$sect = &$rtf->addSection();
	$sect->writeText("".$fecha_act, new Font(11, 'tahoma', '#000000'), new ParFormat('left'));
	$sect->writeText("CITE: ".$notas1, new Font(11, 'tahoma', '#000000'), new ParFormat('left'));	
	$sect->writeText("\n", new Font(), new ParFormat());
	$sect->writeText("\n", new Font(), new ParFormat());
	
    $sect->writeText("Senor(a) ", new Font(11, 'tahoma', '#000000'), new ParFormat('left'));	
	
	$fila_para = mysql_fetch_array($rss_para);
	$sect->writeText("".$fila_para[0], new Font(11, 'tahoma', '#000000'), new ParFormat('left'));
	$sect->writeText("<b>".strtoupper($fila_para[1])."</b>", new Font(11, 'tahoma', '#000000'), new ParFormat());
	$sect->writeText("Presente.-", new Font(11, 'tahoma', '#000000'), new ParFormat());
	$sect->writeText("\n", new Font(), new ParFormat());
	$sect->writeText("\n", new Font(), new ParFormat());		

	$sect->writeText("REF.: <b>".$fila_documento[2]."</b>", new Font(11, 'tahoma', '#000000'), new ParFormat('right'));
	
	$sect->writeText("".$texto, new Font(11, 'tahoma', '#000000'), new ParFormat('justify'));
	
	$sect->writeText("\n", new Font(), new ParFormat());		
	$sect->writeText("\n", new Font(), new ParFormat());		
	
	
	if($rss_contador > 0)
	{
		while($fila_via = mysql_fetch_array($rss_via))
		{  
		    $sect->writeText("".$fila_via[0].", ".$fila_via[1], new Font(), new ParFormat('left'));
			
			//$sect->writeText("".$fila_via[0]." ".strtoupper($fila_via[1])., new Font(11, 'tahoma', '#000000'), new ParFormat());
		}
   	  $sect->writeText("c.c. Archivo", new Font(), new ParFormat('left'));	
	  $sect->writeText("\n", new Font(), new ParFormat());
	}
} // fin de carta interna o externa
// Inicio de carta Interna o Externa
if($notas == "MEMORANDUM")
{

	$sect = &$rtf->addSection();
	$sect->writeText("".$notas, new Font(18, 'tahoma', '#000000'), new ParFormat('center'));
	$sect->writeText("<b>CITE: ".$notas1."</b>", new Font(9, 'tahoma', '#000000'), new ParFormat('center'));	
	$sect->writeText("\n", new Font(), new ParFormat());
	$sect->writeText("".$uni, new Font(9, 'Monotype Corsiva', '#000000'), new ParFormat('right'));	
	
	$sect->writeText("\n", new Font(), new ParFormat());
    $sect->writeText("                                              |   Senor(a) ", new Font(9, 'tahoma', '#000000'), new ParFormat('left'));	
	
	$fila_para = mysql_fetch_array($rss_para);
	$sect->writeText("                                              |  ".$fila_para[0], new Font(9, 'tahoma', '#000000'), new ParFormat('left'));
	$sect->writeText("                                              |  <b>".strtoupper($fila_para[1])."</b>", new Font(9, 'tahoma', '#000000'), new ParFormat());
	$sect->writeText("<hr>", new font(), new parformat());
	$sect->writeText($fecha_act."            |  Presente.-", new Font(9, 'tahoma', '#000000'), new ParFormat());
	$sect->writeText("\n", new Font(), new ParFormat());

	$sect->writeText("REF.: <b>".$fila_documento[2]."</b>", new Font(9, 'tahoma', '#000000'), new ParFormat('right'));
	//	$sect->writeText("".$fecha_act, new Font(9, 'tahoma', '#000000'), new ParFormat('left'));
	$sect->writeText("\n", new Font(), new ParFormat());		

	$sect->writeText("".$texto, new Font(9, 'tahoma', '#000000'), new ParFormat('justify'));
	
	$sect->writeText("\n", new Font(), new ParFormat());		
	$sect->writeText("\n", new Font(), new ParFormat());		
	
	
	if($rss_contador > 0)
	{
		while($fila_via = mysql_fetch_array($rss_via))
		{  
		    $sect->writeText("".$fila_via[0].", ".$fila_via[1], new Font(), new ParFormat('left'));
			
			//$sect->writeText("".$fila_via[0]." ".strtoupper($fila_via[1])., new Font(11, 'tahoma', '#000000'), new ParFormat());
		}
   	  $sect->writeText("c.c. Archivo", new Font(), new ParFormat('left'));	
	  $sect->writeText("\n", new Font(), new ParFormat());
	}
} // fin de carta interna o externa


// Inicio de CIRCULAR
if($notas == "CIRCULAR" || $notas =="INSTRUCTIVO" || $notas =="COMUNICADO")
{

	$sect = &$rtf->addSection();
	$sect->writeText("".$uni, new Font(9, 'Monotype Corsiva', '#000000'), new ParFormat('right'));
	$sect->writeText("".$notas, new Font(15, 'tahoma', '#000000'), new ParFormat('center'));
	$sect->writeText("<b>".$notas1."</b>", new Font(15, 'tahoma', '#000000'), new ParFormat('center'));	
	
	//$sect->writeText("Ministerio de Salud y Deportes", new Font(15, 'tahoma', '#000000'), new ParFormat('center'));
	//$sect->writeText("\n", new Font(), new ParFormat());
	
	//$control2=1;
	//while($fila_de = mysql_fetch_array($rss_de))
	//{  if($control2 == 1)
	 //  { $sect->writeText("   DE:        ".$fila_de[0], new Font(11, 'tahoma', '#000000'), new ParFormat());
	//	 $sect->writeText("               <b>".strtoupper($fila_de[1])."</b>", new Font(11, 'tahoma', '#000000'), new ParFormat());
	 //  }
	  // else
	   //{ $sect->writeText("              ".$fila_de[0], new Font(11, 'tahoma', '#000000'), new ParFormat());
	//	 $sect->writeText("              <b>".strtoupper($fila_de[1])."</b>", new Font(11, 'tahoma', '#000000'), new ParFormat());
	//   }
	 //  $control2=$control2+1;
	   
	//}
	//$sect->writeText("\n", new Font(), new ParFormat());
	
    //$sect->writeText("   REF.:      <b>".$fila_documento[2]."</b>", new Font(11, 'tahoma', '#000000'), new ParFormat());
	//$sect->writeText("\n", new Font(), new ParFormat());
	
	
	//$sect->writeText("<HR>", new Font(), new ParFormat());
	//$sect->writeText("\n", new Font(), new ParFormat());

	$sect->writeText("".$texto, new Font(11, 'tahoma', '#000000'), new ParFormat('justify'));
	
	$sect->writeText("\n", new Font(), new ParFormat());		
	$sect->writeText("\n", new Font(), new ParFormat());		
	$sect->writeText("".$fecha_act, new Font(11, 'tahoma', '#000000'), new ParFormat('center'));
} // fin de carta interna o externa

if($notas=="COMUNICACION EXTERNA")
{

	$sect = &$rtf->addSection();
	$sect->writeText("".$notas, new Font(15, 'tahoma', '#000000'), new ParFormat('center'));
	$sect->writeText("<b>".$notas1."</b>", new Font(15, 'tahoma', '#000000'), new ParFormat('center'));	
	$sect->writeText("\n", new Font(), new ParFormat());
	$sect->writeText("".$uni, new Font(11, 'Monotype Corsiva', '#000000'), new ParFormat('right'));
	$sect->writeText("\n", new Font(), new ParFormat());
	$control2=1;
	while($fila_de = mysql_fetch_array($rss_para))
	{  if($control2 == 1)
	   { $sect->writeText("   PARA:      ".$fila_de[0], new Font(11, 'tahoma', '#000000'), new ParFormat());
		 $sect->writeText("               <b>".strtoupper($fila_de[1])."</b>", new Font(11, 'tahoma', '#000000'), new ParFormat());
	   }
	   else
	   { $sect->writeText("              ".$fila_de[0], new Font(11, 'tahoma', '#000000'), new ParFormat());
		 $sect->writeText("              <b>".strtoupper($fila_de[1])."</b>", new Font(11, 'tahoma', '#000000'), new ParFormat());
	   }
	   $control2=$control2+1;
	   
	}
		$sect->writeText("\n", new Font(), new ParFormat());
	while($fila_de = mysql_fetch_array($rss_de))
	{  if($control2 == 2)
	   { $sect->writeText("   DE:        ".$fila_de[0], new Font(11, 'tahoma', '#000000'), new ParFormat());
		 $sect->writeText("               <b>".strtoupper($fila_de[1])."</b>", new Font(11, 'tahoma', '#000000'), new ParFormat());
	   }
	   else
	   { $sect->writeText("              ".$fila_de[0], new Font(11, 'tahoma', '#000000'), new ParFormat());
		 $sect->writeText("              <b>".strtoupper($fila_de[1])."</b>", new Font(11, 'tahoma', '#000000'), new ParFormat());
	   }
	   $control2=$control2+1;
	   
	}
	$sect->writeText("\n", new Font(), new ParFormat());
	
    $sect->writeText("   REF.:      <b>".$fila_documento[2]."</b>", new Font(11, 'tahoma', '#000000'), new ParFormat());
	$sect->writeText("\n", new Font(), new ParFormat());
	
	$sect->writeText("   FECHA:    ".$fecha_act, new Font(11, 'tahoma', '#000000'), new ParFormat());
	$sect->writeText("<HR>", new Font(), new ParFormat());
	$sect->writeText("\n", new Font(), new ParFormat());

	$sect->writeText("".$texto, new Font(11, 'tahoma', '#000000'), new ParFormat('justify'));
	
	$sect->writeText("\n", new Font(), new ParFormat());		
	$sect->writeText("\n", new Font(), new ParFormat());		

} // fin de carta interna o externa


// Inicio de nota Interna o Externa
//if($notas == "NOTA INTERNA" || $notas =="NOTA EXTERNA" || $notas =="INFORME INTERNO" || $notas =="INFORME EXTERNO" )
if($notas == "INFORME DE VIAJE" || $notas=="INFORME TECNICO")
{

	$sect = &$rtf->addSection();
	$sect->writeText("".$notas, new Font(14, 'tahoma', '#000000'), new ParFormat('center'));
	$sect->writeText("".$notas1, new Font(11, 'tahoma', '#000000'), new ParFormat('center'));
	$sect->writeText("\n", new Font(), new ParFormat());
	$sect->writeText("".$uni, new Font(11, 'Monotype Corsiva', '#000000'), new ParFormat('right'));
	$sect->writeText("\n", new Font(), new ParFormat());
	
	while($fila_para = mysql_fetch_array($rss_para))
	{  $sect->writeText("   A:          ".$fila_para[0], new Font(11, 'tahoma', '#000000'), new ParFormat());
	   $sect->writeText("               <b>".strtoupper($fila_para[1])."</b>", new Font(11, 'tahoma', '#000000'), new ParFormat());
//	  $sect->writeText("\n", new Font(), new ParFormat());
	}
//	$prueba="SELECT departamento_descripcion_dep FROM departamento where departamento_cod_departamento = $fila_para[2]";
//	$resss=mysql_query($prueba,$conn);
//	$res_depto=mysql_affected_rows($resss);
	$sect->writetext("".$res_depto[0], new font(11, 'Tahoma', '#000000'), new ParFormat('center'));
	$control=1;
	
	if($rss_contador > 0)
	{
		while($fila_via = mysql_fetch_array($rss_via))
		{  if($control == 1)
		   { $sect->writeText("   VIA:        ".$fila_via[0], new Font(11, 'tahoma', '#000000'), new ParFormat());
			 $sect->writeText("               <b>".strtoupper($fila_via[1])."</b>", new Font(11, 'tahoma', '#000000'), new ParFormat());
		   }
		   else
		   { $sect->writeText("               ".$fila_via[0], new Font(11, 'tahoma', '#000000'), new ParFormat());
			 $sect->writeText("               <b>".strtoupper($fila_via[1])."</b>", new Font(11, 'tahoma', '#000000'), new ParFormat());
		   }
		   $control=$control+1;
		}
	  $sect->writeText("\n", new Font(), new ParFormat());
	}
	
	$control2=1;
	while($fila_de = mysql_fetch_array($rss_de))
	{  if($control2 == 1)
	   { $sect->writeText("   DE:        ".$fila_de[0], new Font(11, 'tahoma', '#000000'), new ParFormat());
		 $sect->writeText("               <b>".strtoupper($fila_de[1])."</b>", new Font(11, 'tahoma', '#000000'), new ParFormat());
	   }
	   else
	   { $sect->writeText("              ".$fila_de[0], new Font(11, 'tahoma', '#000000'), new ParFormat());
		 $sect->writeText("              <b>".strtoupper($fila_de[1])."</b>", new Font(11, 'tahoma', '#000000'), new ParFormat());
	   }
	   $control2=$control2+1;
	   
	}
	$sect->writeText("\n", new Font(), new ParFormat());
	
		$sect->writeText("   REF.:      <b>".$fila_documento[2]."</b>", new Font(11, 'tahoma', '#000000'), new ParFormat());
	
	$sect->writeText("\n", new Font(), new ParFormat());
	
	$sect->writeText("   FECHA:    ".$fecha_act, new Font(11, 'tahoma', '#000000'), new ParFormat());
	
	$sect->writeText("<HR>", new Font(), new ParFormat());
	$sect->writeText("\n", new Font(), new ParFormat());
	
	
	$sect->writeText("".$texto, new Font(11, 'tahoma', '#000000'), new ParFormat('justify'));

} // fin de nota interna o externa


$footer = &$rtf->addFooter('all');

if ($membrete == 'S') 
{
$footer->addImage('images/pieMSD.jpg', $parF,15);
$rtf->sendRtf('Images');

}
else
{
$footer->addImage('images/pieMSD.jpg', $parF,15);
$rtf->sendRtf('Images');

}


?>
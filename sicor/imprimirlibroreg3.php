<?php
include("../filtro.php");
include('pdf4/mpdf.php');
?>
<?php
//include("inicio.php");
?>
<?php
include("script/functions.inc");
include("script/cifrar.php");
include("../conecta.php");

$cod_institucion=$_SESSION["institucion"];
$codigo_usuario=$_SESSION["codigo"];
$codigo=$_SESSION["cargo_asignado"];
$depto=$_SESSION["departamento"];

$fecha_hoy = date("Y-m-d");
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

$cantid = $_GET["icanid"];
$arraid = $_GET["iarrid"];
$vecdatos = explode(",", $arraid);
//**
$cantid2 = $_GET["dcanid"];
$arraid2 = $_GET["darrid"];
$vecdatos2 = explode(",", $arraid2);
$gestion = date("Y");
//$html = "<div rotate='-90'><h3>LISTADO DE RECIBIDOS</h3></div>";
//$html.="<div id='tablasalida'>";
$html = "<h3 align='center'>LISTA DE CORRESPONDENCIA RECEPCIONADA</h3>";

$html.="<table border='1' cellspacing='1' cellpadding='1' align='center' id='tabladentro' style='table-layout: fixed; width: 1400px; ' >
			<tr height='20%' style='background:#CCCCCC'>
				<td  align='center'  style='font-size:12px; font-family:arial; text-rotate:90;'>HOJA DE RUTA</td>
				<td  align='center'  style='font-size:12px; font-family:arial; text-rotate:90;'>FECHA</td>
				<td  align='center'  style='font-size:12px; font-family:arial'>UNIDAD SOLICITANTE</td>
				<td  align='center'  style='font-size:12px; font-family:arial'>CITE</td>
				<td  align='center'  style='font-size:12px; font-family:arial'>REMITENTE</td>
				<td  align='center'  style='font-size:12px; font-family:arial; text-rotate:90;'>Nro. FOJAS</td>
				<td  align='center'  style='font-size:12px; font-family:arial'>DESCRIPCION</td>
				<td  align='center'  style='font-size:12px; font-family:arial'>ADJUDICADO A:</td>
				<td  align='center'  style='font-size:12px; font-family:arial'>DESTINATARIO 1</td>
				<td  align='center'  style='font-size:12px; font-family:arial'>DESTINATARIO 2</td>
				<td  align='center'  style='font-size:12px; font-family:arial'>DESTINATARIO 3</td>
			</tr>";
for($i=0;$i<$cantid;$i++){

$consulta = "SELECT 
				registrodoc1_id, registrodoc1_hoja_ruta, DATE(registrodoc1_fecha_recepcion) as fecha, 
				registrodoc1_de, usuario_nombre, registrodoc1_referencia, documentos_descripcion, 
				registrodoc1_estado, registrodoc1_asociar, registrodoc1_asociar_h_r, 
				registrodoc1_cc, registrodoc1_cite, usuario_ocupacion, registrodoc1_asociar, documentos_id
				FROM `registrodoc1`, `documentos`, `usuario`
				where registrodoc1_depto_para = '$depto'
				and registrodoc1_id = '$vecdatos[$i]'  
				and registrodoc1_para=usuario_ocupacion
				and registrodoc1_doc=documentos_sigla";
	$rslista=mysql_query($consulta,$conn);
	$rwlista=mysql_fetch_array($rslista);
	if($rwlista != ""){
			$doc_arch=cifrar($rwlista["registrodoc1_hoja_ruta"]);
			$doc_arch2=cifrar($rwlista["registrodoc1_cite"]);
			$doc_aso=$rwlista["registrodoc1_asociar"];
			$doc_rem = $rwlista["registrodoc1_de"];
			//
			$econs = "select usuario_nombre as unombre, usuario_cod_departamento from usuario where usuario_ocupacion= '$doc_rem'";
			$eresp = mysql_query($econs, $conn);
			$remitente = mysql_fetch_array($eresp);	
			$depu = "select departamento_descripcion_dep as depnom from departamento 
					 where departamento_cod_departamento = $remitente[usuario_cod_departamento]";
			$depresp = mysql_query($depu, $conn);
			$midepto = mysql_fetch_array($depresp);

	}
	else{
			$consulta = "SELECT registrodoc1_id, registrodoc1_hoja_ruta, 
						DATE(registrodoc1_fecha_recepcion) as fecha, registrodoc1_de, 
						usuarioexterno_nombre, registrodoc1_referencia, clasecorrespondencia_descripcion_clase_corresp as descri, 
						registrodoc1_estado, registrodoc1_asociar, registrodoc1_asociar_h_r, 
						registrodoc1_cc, registrodoc1_cite, usuarioexterno_codigo, 
						registrodoc1_asociar
						FROM registrodoc1, clasecorrespondencia, usuarioexterno
						where registrodoc1_depto_para = '$depto' 
						and registrodoc1_id = '$vecdatos[$i]'  
						and registrodoc1_de=usuarioexterno_codigo
						and registrodoc1_doc=clasecorrespondencia_codigo_clase_corresp";
			$rslista=mysql_query($consulta,$conn);
			$rwlista=mysql_fetch_array($rslista);
			//--------------
			$doc_arch=cifrar($rwlista["registrodoc1_hoja_ruta"]);
			$doc_arch2=cifrar($rwlista["registrodoc1_cite"]);
			$doc_aso=$rwlista["registrodoc1_asociar"];
			$doc_rem = $rwlista["registrodoc1_de"];
			//
			$econs = "select usuarioexterno_nombre as unombre, entidades_entidad_cod from usuarioexterno where usuarioexterno_codigo = '$rwlista[registrodoc1_de]'";
			$eresp = mysql_query($econs, $conn);
			$remitente = mysql_fetch_array($eresp);	
			$depu = "select entidades_entidad_nombre as depnom from entidades
			 where entidades_codigo = '$remitente[entidades_entidad_cod]'";
			$depresp = mysql_query($depu, $conn);
			$midepto = mysql_fetch_array($depresp);
	}  
	$conref = mysql_query("select registrodoc1_referencia from registrodoc1 where registrodoc1_id ='$resmid[menor]' ");
	$obtref = mysql_fetch_array($conref);
	$html .= "<tr style='font-size: 8pt;' >
				<td align='center' style='font-size:18px; font-family:arial; text-rotate:90;' width=24>".$rwlista['registrodoc1_hoja_ruta']."</td>
				<td align='center' style='font-size:14px; font-family:arial; text-rotate:90;' width=32>".$rwlista['fecha']."</td>
				<td align='center' style='font-size:12px; font-family:arial' width=76>".$midepto['depnom']."</td>
				<td align='center' style='font-size:16px; font-family:arial' width=132>".$rwlista['registrodoc1_cite']."</td>
				<td align='center' style='font-size:16px; font-family:arial' width=36>".$remitente['unombre']."</td>
				<td align='center' style='font-size:10px; font-family:arial' width=34>&nbsp;</td>
				<td align='center' style='font-size:16px; font-family:arial' width=90>".$rwlista['registrodoc1_referencia']."</td>
				<td align='center' style='font-size:10px; font-family:arial' width=66>&nbsp;</td>
				<td align='center' style='font-size:10px; font-family:arial' width=280>&nbsp;<br><br><br><br><br><br><br><br></td>
				<td align='center' style='font-size:10px; font-family:arial' width=280>&nbsp;<br><br><br><br><br><br><br><br></td>
				<td align='center' style='font-size:10px; font-family:arial' width=280>&nbsp;<br><br><br><br><br><br><br><br></td>
			  </tr>";
}
//-----------------DIBUJANDO CELDAS PARA LAS DERIVADAS
for($j=0;$j<$cantid2;$j++){

$consulta = "SELECT 
			derivardoc_cod, derivardoc_hoja_ruta, DATE(derivardoc_fec_recibida) as fecha, derivardoc_de, usuario_nombre, derivardoc_proveido,  derivardoc_situacion, derivardoc_cc, usuario_ocupacion, derivardoc_copia_de, derivardoc_gestion 
			FROM `derivardoc`, `usuario`
			where derivardoc_para=usuario_ocupacion  
			and derivardoc_cod = '$vecdatos2[$j]'";
	$rslista=mysql_query($consulta,$conn);
	$rwlista=mysql_fetch_array($rslista);
	if($rwlista != ""){
			$doc_arch=cifrar($rwlista["derivardoc_hoja_ruta"]);
//			$doc_arch2=cifrar($rwlista["registrodoc1_cite"]);
//			$doc_aso=$rwlista["registrodoc1_asociar"];
			$doc_rem = $rwlista["derivardoc_de"];
			//
			$econs = "select usuario_nombre as unombre, usuario_cod_departamento from usuario where usuario_ocupacion= '$doc_rem'";
			$eresp = mysql_query($econs, $conn);
			$remitente = mysql_fetch_array($eresp);	
			$depu = "select departamento_descripcion_dep as depnom from departamento 
					 where departamento_cod_departamento = $remitente[usuario_cod_departamento]";
			$depresp = mysql_query($depu, $conn);
			$midepto = mysql_fetch_array($depresp);
			
			//************ OBTENCION DEL CITE
			if($rwlista["derivardoc_copia_de"] == '0'){
				$obtmid = mysql_query("select min(registrodoc1_id) as menor from registrodoc1 
				where registrodoc1_hoja_ruta = '$rwlista[derivardoc_hoja_ruta]' and 
				'$rwlista[derivardoc_gestion]' = '$gestion' ", $conn);
				$resmid = mysql_fetch_array($obtmid);

				$rescite = mysql_query("select registrodoc1_cite, registrodoc1_doc
				from registrodoc1 where registrodoc1_hoja_ruta = '$rwlista[derivardoc_hoja_ruta]'",$conn);
				
			}
			else {
				$obtmid = mysql_query("select min(registrodoc1_id) as menor from registrodoc1 
				where registrodoc1_hoja_ruta = '$rwlista[derivardoc_copia_de]' and 
				'$rwlista[derivardoc_gestion]' = '$gestion' ", $conn);
				$resmid = mysql_fetch_array($obtmid);
				
				$rescite = mysql_query("select registrodoc1_cite, registrodoc1_doc 
				from registrodoc1 where registrodoc1_hoja_ruta = '$rwlista[derivardoc_copia_de]'",$conn);					
			}
			$obtcite = mysql_fetch_array($rescite);
			$conref = mysql_query("select registrodoc1_referencia from registrodoc1 where registrodoc1_id ='$resmid[menor]' ");
			$obtref = mysql_fetch_array($conref);
			//************
			/*
			//-------------OBTENEMOS EL TIPO DE DOCUMENTO
				$tipodocu = mysql_query("select documentos_descripcion from documentos 
				where documentos_sigla = '$obtcite[registrodoc1_doc]' ",$conn);
				$obtipdoc = mysql_fetch_array($tipodocu);
			//-------------FIN DE OBTENER EL TIPO DE DOCUMENTO
			*/
			$html .= "<tr style='min-height:300px' >
				<td align='center' style='font-size:18px; font-family:arial; text-rotate:90;' width='24' height='100'>".$rwlista['derivardoc_hoja_ruta']."</td>
				<td align='center' style='font-size:14px; font-family:arial; text-rotate:90;' width='32'>".$rwlista['fecha']."</td>
				<td align='center' style='font-size:12px; font-family:arial; ' width='76'>".$midepto['depnom']."</td>
				<td align='center' style='font-size:16px; font-family:arial; ' width='132'>".$obtcite['registrodoc1_cite']."</td>
				<td align='center' style='font-size:16px; font-family:arial; ' width='36'>".$remitente['unombre']."</td>
				<td align='center' style='font-size:10px; font-family:arial; ' width='34'>&nbsp;<br><br><br><br><br><br><br><br></td>
				<td align='center' style='font-size:16px; font-family:arial; ' width='90'>".$obtref['registrodoc1_referencia']."</td>
				<td align='center' style='font-size:10px; font-family:arial; ' width='66'>&nbsp;</td>
				<td align='center' style='font-size:10px; font-family:arial; ' width='280'>&nbsp;<br><br><br><br><br><br><br><br></td>
				<td align='center' style='font-size:10px; font-family:arial; ' width='280'>&nbsp;<br><br><br><br><br><br><br><br></td>
				<td align='center' style='font-size:10px; font-family:arial; ' width='280'>&nbsp;<br><br><br><br><br><br><br><br></td>
			  </tr>";
	
	}	
}


//** FIN DE DIBUJO DE CELDAS PARA LAS DERIVADAS
$html .="</table>";
//echo $html;


$mpdf=new mPDF ('','LEGAL','','',5,5,5,5);
//$mpdf->AddPage('L','','','','','','','','','','','');
//$mpdf->AddPage('L','','','','','','','','','','','Folio');
$mpdf->AddPage('L','','','','',20,2,7,7,'Folio');
//$mpdf->AddPage('L','','','','',25,5,5,5,0,0,'','','','','','','','','','Folio');
/*    'orientation' => 'L',
    'condition' => '',
    'resetpagenum' => '',
    'pagenumstyle' => '',
    'suppress' => '',
    'mgl' => '',
    'mgr' => '',
    'mgt' => '',
    'mgb' => '',
    'mgh' => '',
    'mgf' => '',
    'ohname' => '',
    'ehname' => '',
    'ofname' => '',
    'efname' => '',
    'ohvalue' => 0,
    'ehvalue' => 0,
    'ofvalue' => 0,
    'efvalue' => 0,
    'pagesel' => '',
    'newformat' => '',
    );
	*/
//$mpdf=new mPDF ('c','LEGAL','','',5,5,5,5,5,5,'P');
//$mpdf=new mPDF ('','LEGAL','','',5,5,5,5,'P');
//$mpdf=new mPDF('','LEGAL', 0, '', 5, 5, 5, 5, 0, 0, 'P');
//S$mpdf->AddPage('A4','','','','',5,5,15,15,18,12);
//$mpdf->AddPage('','','','','','',5,5,10,5,1,5);
//$mpdf->new mPDF('C');
//$mpdf->AddPage('L','','','','','','','','','','','');
//$mpdf->AddPage();
//$mpdf->SetFooter('MSyD||Copyright {DATE j-m-Y}');
//$mpdf->SetFooter('MSyD|{PAGENO} de {nb}|Copyright {DATE j-m-Y}');
//$stylesheet = file_get_contents('estilosimpresion.css');
//$mpdf->WriteHTML($stylesheet,1);
$mpdf->WriteHTML($html);
//$mpdf->WriteHTML($html2);
//$mpdf->WriteHTML($html3);
$mpdf->Output();
//exit;
?>
<?
/*

	document.write("<td align='center' style='font-size:10px'>"+aux[3]+"</td><td align='center' style='font-size:10px'>"+aux[4]+"</td><td align='center' style='font-size:10px'>&nbsp;</td><td align='center' style='font-size:10px'>&nbsp;</td><td align='center' style='font-size:10px'>&nbsp;</td><td align='center' style='font-size:10px'>&nbsp;</td>");
	document.write("<td align='center' style='font-size:10px'>&nbsp;</td><td align='center' style='font-size:10px'>&nbsp;</td><td align='center' style='font-size:10px'>&nbsp;</td><td align='center' style='font-size:10px'>&nbsp;</td>");
	document.write("</tr>");
	
	}
	document.write("</table>");
}
*/
?>
<?php
//include("final.php");
?>

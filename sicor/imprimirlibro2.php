<?php
include("../filtro.php");
include('pdf4/mpdf.php');
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
$cantid2 = $_GET["dcanid"];
$arraid2 = $_GET["darrid"];
$vecdatos2 = explode(",", $arraid2);
$html = "<h3>LISTA DE CORRESPONDENCIA ENVIADA</h3>";
$html.="<table border='1' width='90%' cellspacing='1' cellpadding='1' align='center' style='table-layout: fixed; width: 1400px;'>
			<tr >
				<td  align='center' style='font-size:12px; font-family:arial; text-rotate:90;'>HOJA DE RUTA</td>
				<td  align='center' style='font-size:12px; font-family:arial; text-rotate:90;'>FECHA</td>
				<td  align='center' style='font-size:12px; font-family:arial'>UNIDAD DESTINO</td>
				<td  align='center' style='font-size:12px; font-family:arial'>CITE</td>
				<td  align='center' style='font-size:12px; font-family:arial'>REMITENTE</td>
				<td  align='center' style='font-size:12px; font-family:arial; text-rotate:90;'>Nro. FOJAS</td>
				<td  align='center' style='font-size:12px; font-family:arial'>REFERENCIA</td>
				<td  align='center' style='font-size:12px; font-family:arial'>ADJUDICADO A:</td>
				<td  align='center' style='font-size:12px; font-family:arial'>DESTINATARIO 1</td>
				<td  align='center' style='font-size:12px; font-family:arial'>DESTINATARIO 2</td>
				<td  align='center' style='font-size:12px; font-family:arial'>DESTINATARIO 3</td>
			</tr>";
for($i=0;$i<$cantid;$i++){

$consulta = "SELECT 
				registrodoc1_id, registrodoc1_hoja_ruta, DATE(registrodoc1_fecha_elaboracion) as fecha, 
				registrodoc1_de, usuario_nombre, registrodoc1_referencia, documentos_descripcion, 
				registrodoc1_estado, registrodoc1_asociar, registrodoc1_asociar_h_r, registrodoc1_depto_para, 
				registrodoc1_cc, registrodoc1_cite, usuario_ocupacion, registrodoc1_asociar, documentos_id
				FROM `registrodoc1`, `documentos`, `usuario`
				where registrodoc1_depto = '$depto'
				and registrodoc1_id = '$vecdatos[$i]'  
				and registrodoc1_para=usuario_ocupacion
				and registrodoc1_doc=documentos_sigla";
	$rslista=mysql_query($consulta,$conn);
	$rwlista=mysql_fetch_array($rslista);
	$doc_arch=cifrar($rwlista["registrodoc1_hoja_ruta"]);
	$doc_arch2=cifrar($rwlista["registrodoc1_cite"]);
	$doc_aso=$rwlista["registrodoc1_asociar"];
	$doc_rem = $rwlista["registrodoc1_de"];
	//debemos verificar si el destinatario no perteneza a una unidad externa
	 $veri = mysql_query("select count(*) as total from usuario where usuario_ocupacion = '$rwlista[registrodoc1_para]' ",$conn);
	 $verir = mysql_fetch_array($veri);
	 if($verir["total"]>0){
	// -_-¡
		$econs = "select usuario_nombre as repnombre, usuario_cod_departamento from usuario where usuario_ocupacion= '$doc_rem'";
		$eresp = mysql_query($econs, $conn);
		$remitente = mysql_fetch_array($eresp);	
		$depu = "select departamento_descripcion_dep as repdepto from departamento 
				 where departamento_cod_departamento = $rwlista[registrodoc1_depto_para]";
		$depresp = mysql_query($depu, $conn);
		$deptopara = mysql_fetch_array($depresp);
	}//si es falso, entonces es un usuario externo,a si q debemos rescatar los datos de su tabla
	else{
//		as repnombre
		
		$econs = "select usuario_nombre as repnombre, usuario_cod_departamento from usuario where usuario_ocupacion= '$doc_rem'";
		$eresp = mysql_query($econs, $conn);
		$remitente = mysql_fetch_array($eresp);
		$econs2 = "select usuarioexterno_nombre, entidades_entidad_cod from usuarioexterno where usuarioexterno_codigo= '$rwlista[registrodoc1_para]'";	
		$eresp2 = mysql_query($econs2, $conn);
		$remitente2 = mysql_fetch_array($eresp2);	
		$depu = "select entidades_entidad_nombre as repdepto from entidades 
				 where entidades_codigo = $remitente2[entidades_entidad_cod]";
		$depresp = mysql_query($depu, $conn);
		$deptopara = mysql_fetch_array($depresp);
	}

	$html .= "<tr>
				<td align='center' style='font-size:18px; font-family:arial; text-rotate:90;' width=24>".$rwlista['registrodoc1_hoja_ruta']."</td>
				<td align='center' style='font-size:14px; font-family:arial; text-rotate:90;' width=32>".$rwlista['fecha']."</td>
				<td align='center' style='font-size:12px; font-family:arial' width=76>".$deptopara['repdepto']."</td>
				<td align='center' style='font-size:16px; font-family:arial' width=132>".$rwlista['registrodoc1_cite']."</td>
				<td align='center' style='font-size:16px; font-family:arial' width=36>".$remitente['repnombre']."</td>
				<td align='center' style='font-size:10px; font-family:arial' width=34>&nbsp;</td>
				<td align='center' style='font-size:16px; font-family:arial' width=90>".$rwlista['registrodoc1_referencia']."</td>
				<td align='center' style='font-size:10px; font-family:arial' width=66>&nbsp;<br><br><br><br><br><br><br><br></td>
				<td align='center' style='font-size:10px; font-family:arial' width=280>&nbsp;</td>
				<td align='center' style='font-size:10px; font-family:arial' width=280>&nbsp;</td>
				<td align='center' style='font-size:10px; font-family:arial' width=280>&nbsp;</td>
			  </tr>";
}
//-----------------DIBUJANDO CELDAS PARA LAS DERIVADAS
for($j=0;$j<$cantid2;$j++){

$consulta = "SELECT 
			derivardoc_cod, derivardoc_hoja_ruta, DATE(derivardoc_fec_derivacion) as fecha, derivardoc_de, usuario_nombre, derivardoc_proveido,  derivardoc_situacion, derivardoc_cc, usuario_ocupacion, derivardoc_copia_de, derivardoc_gestion 
			FROM `derivardoc`, `usuario`
			where derivardoc_de=usuario_ocupacion  
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
				where registrodoc1_hoja_ruta = '$rwlista[derivardoc_hoja_ruta]'", $conn);
				$resmid = mysql_fetch_array($obtmid);
			
				$rescite = mysql_query("select registrodoc1_cite, registrodoc1_doc
				from registrodoc1 where registrodoc1_hoja_ruta = '$rwlista[derivardoc_hoja_ruta]'",$conn);
			}
			else {
				$obtmid = mysql_query("select min(registrodoc1_id) as menor from registrodoc1 
				where registrodoc1_hoja_ruta = '$rwlista[derivardoc_copia_de]'", $conn);
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
			$html .= "<tr '>
				<td align='center' style='font-size:18px; font-family:arial; text-rotate:90;' width=24>".$rwlista['derivardoc_hoja_ruta']."</td>
				<td align='center' style='font-size:14px; font-family:arial; text-rotate:90;' width=32>".$rwlista['fecha']."</td>
				<td align='center' style='font-size:12px; font-family:arial' width=76>".$midepto['depnom']."</td>
				<td align='center' style='font-size:16px; font-family:arial' width=132>".$obtcite['registrodoc1_cite']." </td>
				<td align='center' style='font-size:16px; font-family:arial' width=36>".$remitente['unombre']."</td>
				<td align='center' style='font-size:10px; font-family:arial' width=34>&nbsp;<br><br><br><br><br></td>
				<td align='center' style='font-size:16px; font-family:arial' width=90>".$obtref['registrodoc1_referencia']."</td>
				<td align='center' style='font-size:10px; font-family:arial' width=66>&nbsp;<br><br><br><br><br><br><br><br></td>
				<td align='center' style='font-size:10px; font-family:arial' width=280>&nbsp;<br><br><br><br><br></td>
				<td align='center' style='font-size:10px; font-family:arial' width=280>&nbsp;<br><br><br><br><br></td>
				<td align='center' style='font-size:10px; font-family:arial' width=280>&nbsp;<br><br><br><br><br></td>
			  </tr>";
	
	}	
}
//** FIN DE DIBUJO DE CELDAS PARA LAS DERIVADAS
$html .="</table>";
$mpdf=new mPDF ('','LEGAL','','',5,5,5,5);
//$mpdf->AddPage('L','','','','','','','','','','','');
$mpdf->AddPage('L','','','','',20,2,7,7,'Folio');
//$mpdf=new mPDF ();
//$mpdf->AddPage('L','','','','',5,5,15,15,18,12);
//$mpdf->AddPage('','','','','','',5,5,10,5,1,5);
//$mpdf->AddPage('L','','','','','','','','','','','');
//$mpdf->AddPage();
//$mpdf->SetFooter('MSyD||Copyright {DATE j-m-Y}');
//$mpdf->SetFooter('MSyD|{PAGENO} de {nb}|Copyright {DATE j-m-Y}');
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

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
$hrutaoriginal=descifrar($_GET['hr2']);



	$s_hr="select * from derivardoc where derivardoc_hoja_ruta='$hruta'";
	mysql_query("SET CHARACTER SET utf8");
	mysql_query("SET NAMES utf8");	
	$r_hr = mysql_query($s_hr, $conn);
	$row_dep=mysql_fetch_array($r_hr);
	$cod_dep=$row_dep['derivardoc_de'];
	$cod_para=$row_dep['derivardoc_para'];
	$estado=$row_dep['derivardoc_estado'];
	//***OBTENCION DEL CITE
		$obtcite = mysql_query("select * from registrodoc1 where registrodoc1_hoja_ruta like '$hrutaoriginal'");
		$rescite = mysql_fetch_array($obtcite);
		$cite=$rescite['registrodoc1_cite'];
		$prioridad=$rescite['registrodoc1_prioridad'];
		$tipo_doc=$rescite['registrodoc1_doc'];
	
	//****************
	$fech_ela=$row_dep["derivardoc_fec_derivacion"];
//	$fech_rec=$row_dep["registrodoc1_fecha_recepcion"];
	$gest=$row_dep["derivardoc_gestion"];
	$ref=strtoupper($row_dep["derivardoc_proveido"]);
	
//	$tipo = $row_dep["registrodoc1_tipo"];
/*	
	if ($tipo=="INTERNO") 
	{
*/
	$r_rm = mysql_query("select usuario_nombre, cargos_cargo, usuario_titulo from usuario, cargos where usuario_ocupacion='$cod_dep' and usuario_ocupacion=cargos_id", $conn);
	$row_rm=mysql_fetch_array($r_rm);
	$tit_rm=$row_rm['usuario_titulo'];
	$nom_rm=$row_rm['usuario_nombre'];
	$cargo_rm=$row_rm['cargos_cargo'];	
	
	$rdoc=mysql_query("SELECT * from documentos 
					where documentos_sigla='$tipo_doc'",$conn);
	$rpd=mysql_fetch_array($rdoc);

	$descr=$rpd['documentos_descripcion'];	
		
	$con= "UPDATE derivardoc
                SET
			derivardoc_cc='SI'
                WHERE
            derivardoc_hoja_ruta='$hruta'
            AND derivardoc_cc='NO'";
			/*registrodoc_respuesta='$res', SE CAMBIO POR (SI) */
    $res = mysql_query($con,$conn); 
	/*
	} 
	else 
	{ 
	
	$r_rm = mysql_query("SELECT * FROM usuarioexterno WHERE '$cod_dep'=usuarioexterno_codigo",$conn);
	$row_rm=mysql_fetch_array($r_rm);
	//$tit_rm='Sr';
	$nom_rm=$row_rm['usuarioexterno_nombre'];
	$cargo_rm=$row_rm['usuarioexterno_cargo'];	
	
	$rdocsig=mysql_query("SELECT * from clasecorrespondencia 
							where clasecorrespondencia_codigo_clase_corresp='$tipo_doc'",$conn);
	$rpdoc=mysql_fetch_array($rdocsig);
	$descr=$rpdoc['clasecorrespondencia_descripcion_clase_corresp'];
	
		
	$con= "UPDATE registrodoc1
                SET
			registrodoc1_cc='E'
                WHERE
            registrodoc1_hoja_ruta='$hruta'
            AND registrodoc1_cc='NE'";
			//registrodoc_respuesta='$res', SE CAMBIO POR (SI) 
    $res = mysql_query($con,$conn); 
	}*/	
	
	$r_des = mysql_query("select usuario_nombre, cargos_cargo, usuario_titulo from usuario, cargos where usuario_ocupacion='$cod_para' and usuario_ocupacion=cargos_id", $conn);
	$row_des=mysql_fetch_array($r_des);
	$tit_des=$row_des['usuario_titulo'];
	$nom_des=$row_des['usuario_nombre'];
	$cargo_des=$row_des['cargos_cargo'];

if($prioridad=='M'){ $priorid='MEDIA';}
if($prioridad=='B'){ $priorid='BAJA';}
if($prioridad=='A'){ $priorid='ALTA';}

$html.='
<table border="0">
<tr>
<td>
	<table border="0" cellspacing="0" cellpadding="0" width="100%" style="font-family:Arial, Helvetica, sans-serif; font-size:8pt;">
		<tr>
		 <td  colspan="2">
			 <table width="800" border="0" cellpadding="1">
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
		 </td>
    	</tr>
	  <tr>
	  </tr>
		
	  <tr>
       <td width="420">
    	<table  border="0">
			  <tr>
				<td class="p" width="100">Destinatario:</td>
				<td class="ka" width="400">'.utf8_encode ($tit_des).' '.utf8_encode ($nom_des).'</td>
			  </tr>
			  <tr>
				<td class="p">Cargo:</td>
				<td class="ka">'.utf8_encode ($cargo_des).'</td>
			  </tr>
			  <tr>
				<td class="p"><br /></td>
				<td class="ka"><br /></td>
			  </tr>
			  <tr>
				<td class="p">Remitente:</td>
				<td class="ka">'.utf8_encode ($tit_rm).' '.utf8_encode ($nom_rm).'</td>
			  </tr>
			  <tr>
				<td class="p">Cargo:</td>
				<td class="ka">'.utf8_encode ($cargo_rm).'</td>
			  </tr>
		 </table>			
	   </td>
	   <td width="380">
			<table  border="0">
			  <tr>
				<td class="p" style="font-size:12px"><strong>HOJA DE RUTA:</strong></td>
				<td class="ka" style="font-size:16px"><strong>'.utf8_encode ($hruta).'</strong></td>
			  </tr>
			  <tr>
				<td class="p">CITE</td>
				<td style="font-size:9px">'.utf8_encode ($cite).'</td>
			  </tr>
			  <tr>
				<td class="p">Gestion</td>
				<td class="ka">MSyD - '.utf8_encode ($gest).'</td>
			  </tr>	
			  <tr>
				<td class="p">Fecha de Derivacion</td>
				<td class="ka">'.utf8_encode ($fech_ela).'</td>
			  </tr>		
			  <tr>
				<td class="p">Prioridad:</td>
				<td class="ka">'.utf8_encode ($priorid).'</td>
			  </tr>  			 
			  <tr>
				<td>Tipo de Documento</td>
				<td>'.utf8_encode ($descr).'</td>
			  </tr>
			</table>					
		</td>
	  </tr>
	<tr>
    <td colspan="2">
    <table bgcolor="#FFCC00">
        <tr>
        	<td>Referencia:</td>
        	<td>'.utf8_encode ($ref).'</td>
        </tr>
     </table>    
   </td>
  </tr>
  </table>
  
  <table width="800" height="150" border="1">
	  <tr>
		<td width="592" height="30" style="font-size:11px"><strong>PRIMER DESTINATARIO</strong>................................................................... </td>
		<td width="181" style="font-size:11px"> N&ordm; DE HOJAS:...............     </td>
	  </tr>
	  <tr>
		<td colspan="2">
		<table width="100%" height="150" border="0" cellpadding="0">
		  <tr>
			<td width="90%"><br>Proveido:.............................................................................................................................................................................................<br><br>
............................................................................................................................................................................................................<br><br>
............................................................................................................................................................................................................<br><br>
............................................................................................................................................................................................................<br><br><br>		
</td>
			<td width="10%" align="left" style="font-size:9px">
			  <p>&nbsp;</p>
			  <p>&nbsp;</p>
			  <p>&nbsp;</p>
			  <p>&nbsp;</p>
			  <p>&nbsp;</p>
			  <p>&nbsp;</p>
			  <p>&nbsp;</p>
			  <p>&nbsp;</p>
			  <p>.             .SELLO Y FIRMA</p>
			</td>
		  </tr>
		</table>
		</td>
	  </tr>
	  <tr>
		<td colspan="2" style="font-size:11px" height="30">Fecha de Ingreso: ......../......./........ hora: ...................... Fecha de Salida: .........../........../.......... </td>
	  </tr>  
	</table>

	<table width="789" height="128" border="1">
	  <tr>
		<td width="592" height="30" style="font-size:11px"><strong>SEGUNDO DESTINATARIO</strong>................................................................... </td>
		<td width="181" style="font-size:11px"> N&ordm; DE HOJAS:...............     </td>
	  </tr>
	  	  <tr>
		<td colspan="2">
		<table width="100%" height="100" border="0" cellpadding="0">
		  <tr>
			<td width="90%"><br>Proveido:.............................................................................................................................................................................................<br><br>
............................................................................................................................................................................................................<br><br>
............................................................................................................................................................................................................<br><br>
............................................................................................................................................................................................................<br><br><br>		
</td>
			<td width="10%" align="left" style="font-size:9px">
			  <p>&nbsp;</p>
			  <p>&nbsp;</p>
			  <p>&nbsp;</p>
			  <p>&nbsp;</p>
			  <p>&nbsp;</p>
			  <p>&nbsp;</p>
			  <p>&nbsp;</p>
			  <p>&nbsp;</p>
			  <p>.             .SELLO Y FIRMA</p>
			</td>
		  </tr>
		</table>
		</td>
	  </tr>
	  <tr>
		<td colspan="2" style="font-size:11px" height="30">Fecha de Ingreso: ......../......./........ hora: ...................... Fecha de Salida: .........../........../.......... </td>
	  </tr>  
	</table>
	
	<table width="789" height="128" border="1">
	  <tr>
		<td width="592" height="30" style="font-size:11px"><strong>TERCER DESTINATARIO</strong>................................................................... </td>
		<td width="181" style="font-size:11px"> N&ordm; DE HOJAS:...............     </td>
	  </tr>
	  	  <tr>
		<td colspan="2">
		<table width="100%" height="100" border="0" cellpadding="0">
		  <tr>
			<td width="90%"><br>Proveido:.............................................................................................................................................................................................<br><br>
............................................................................................................................................................................................................<br><br>
............................................................................................................................................................................................................<br><br>
............................................................................................................................................................................................................<br><br><br>		
</td>
			<td width="10%" align="left" style="font-size:9px">
			  <p>&nbsp;</p>
			  <p>&nbsp;</p>
			  <p>&nbsp;</p>
			  <p>&nbsp;</p>
			  <p>&nbsp;</p>
			  <p>&nbsp;</p>
			  <p>&nbsp;</p>
			  <p>&nbsp;</p>
			  <p>.             .SELLO Y FIRMA</p>
			</td>
		  </tr>
		</table>
		</td>
	  </tr>
	  <tr>
		<td colspan="2" style="font-size:11px" height="30">Fecha de Ingreso: ......../......./........ hora: ...................... Fecha de Salida: .........../........../.......... </td>
	  </tr>  
	</table>
	
	<table width="789" height="128" border="1">
	  <tr>
		<td width="592" height="30" style="font-size:11px"><strong>CUARTO DESTINATARIO</strong>................................................................... </td>
		<td width="181" style="font-size:11px"> N&ordm; DE HOJAS:...............     </td>
	  </tr>
	 	  <tr>
		<td colspan="2">
		<table width="100%" height="100" border="0" cellpadding="0">
		  <tr>
			<td width="90%"><br>Proveido:.............................................................................................................................................................................................<br><br>
............................................................................................................................................................................................................<br><br>
............................................................................................................................................................................................................<br><br>
............................................................................................................................................................................................................<br><br><br>		
</td>
			<td width="10%" align="left" style="font-size:9px">
			  <p>&nbsp;</p>
			  <p>&nbsp;</p>
			  <p>&nbsp;</p>
			  <p>&nbsp;</p>
			  <p>&nbsp;</p>
			  <p>&nbsp;</p>
			  <p>&nbsp;</p>
			  <p>&nbsp;</p>
			  <p>.             .SELLO Y FIRMA</p>
			</td>
		  </tr>
		</table>
		</td>
	  </tr>
	  <tr>
		<td colspan="2" style="font-size:11px" height="30">Fecha de Ingreso: ......../......./........ hora: ...................... Fecha de Salida: .........../........../.......... </td>
	  </tr>  
	</table>


	
  </td>
 </tr>
</table>
';


 
$mpdf=new mPDF ('','LETTER','','',5,5,5,5);
//$mpdf->AddPage('','','','','','',5,5,10,5,1,5);
//$mpdf->AddPage('L','','','','','','','','','','','');
//$mpdf->AddPage();
//$mpdf->SetFooter('Encargado de Fideicomiso|{PAGENO} de {nb}|Copyright {DATE j-m-Y}');
$mpdf->SetFooter('| Copyright - 2012 Ministerio de Salud y Deportes. Todos los Derechos Reservados |');
$mpdf->WriteHTML($html);
$mpdf->Output();
exit;
?>

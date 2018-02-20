<?php

/**
 * @abstract Define la estructura global del sitio.
 */	 
include '../estructura.inc.php';

/**
 * @abstract Define las variables globales del sistema y la cadena de
 * conexion a la Base de Datos.
 */	 
include '../local_config.inc_proyectos.php';

/**
 * @abstract Funciones globales.
 */
include '../includes/functions.lib.php';
//incluimos la clase html2fpdf indicando la ruta del archivo donde está contenida
$departamento = 'CHUQUISACA';
/*Cargamos los datos para modificarlos*/
			$query = "
				  SELECT
					*
				  FROM
					proyecto , ubicacion, contrato_ejecucion_obra
				  WHERE
					ubicacion.ubi_departamento = '$departamento' AND proyecto.proy_id = ubicacion.id_proyecto AND contrato_ejecucion_obra.id_proyecto = proyecto.proy_id
				ORDER BY proyecto.proy_id";
$datos_proyectos = mysql_query ($query);
	$html .='
	<table border="0" cellspacing="4" cellpadding="0" width="100%" style="font-family:Arial, Helvetica, sans-serif; font-size:8pt;">
	<tr><td width="4%">&nbsp;</td><td valign="top"><img src="../images/escudo.png"/></td>
	<td align="center" width="800"><em>ESTADO PLURINACIONAL DE BOLIVIA</em><br/>
	Ministerio de Obras P&uacute;blicas Servicios y Vivienda<br/>
	Viceministerio de Vivienda y Urbanismo<br/><br/>
	ESTADO DE SITUACION DE PROYECTOS</td>
	<td valign="top"><img src="../images/logo_viceministerio.png"/></td>
	</tr>
	</table></div>
	<table border="1" cellspacing="0" cellpadding="0" width="1040" style="font-family:Arial, Helvetica, sans-serif; font-size:8pt;">
<tr bgcolor="#a5a5a5">
<td width="2%" align="center" rowspan="2">N&ordm;</td>
<td width="18%" rowspan="2">Nombre del Proyecto</td>
<td width="7%" rowspan="2">Localizaci&oacute;n</td>
<td width="3%" align="center" rowspan="2">SP</td>
<td width="4%" align="center" rowspan="2">N&ordm;<br/>Acta</td>
<td width="7%" align="center" rowspan="2">Fecha <br/>Aprobaci&oacute;n</td>
<td width="10%" align="center" colspan="2">Vigencia Contrato</td>
<td width="7%" align="center" colspan="2">Financiamiento</td>
<td width="7%" align="center" colspan="2">Vigencia P&oacute;liza</td>
<td width="5%" align="center" rowspan="2">% de<br/>Avance<br/>Fisico</td>
<td width="5%" align="center" rowspan="2">% de<br/>Avance<br/>Financiero</td>
<td width="7%" align="center" rowspan="2">Estado</td>
<td width="10%" rowspan="2">Problemas</td>
<td width="10%" rowspan="2">Soluciones</td>
<td width="7%" align="center" rowspan="2">Fecha<br/>Conclusion</td>
<td width="7%" align="center" rowspan="2">Fecha<br/>Conclusion</td>
</tr>
<tr>
        <td width="8%" bgcolor="#a5a5a5">Fecha de<br/> la firma </td>
        <td width="8%" bgcolor="#a5a5a5">Fecha de Vencimiento </td>
        <td width="8%" bgcolor="#a5a5a5">Monto total Compr.</td>
        <td width="8%" bgcolor="#a5a5a5">Monto total ejecutado </td>
        <td width="8%" bgcolor="#a5a5a5">Fecha de<br/>la firma </td>
        <td width="8%" bgcolor="#a5a5a5">Fecha de Vencimiento </td>
      </tr>';
$i=0;
while($proyectos=mysql_fetch_array($datos_proyectos)){
$i++;
$html.='<tr>
<td align="center" height="25">'.$i.'</td>
<td>'.htmlentities($proyectos[proy_nombre]).'</td>
<td>'.htmlentities ($proyectos[ubi_departamento]).'</td>
<td align="center">'.$proyectos[proy_subprograma].'</td>
<td align="center">'.$proyectos[proy_numActa].'</td>
<td align="center">'.desplegarFecha($proyectos[proy_fechaAprobacion]).'</td>
<td>'.$proyectos[proy_subprograma].'</td>
<td>'.$proyectos[proy_subprograma].'</td>
<td>'.$proyectos[proy_subprograma].'</td>
<td>'.$proyectos[proy_subprograma].'</td>
<td>'.$proyectos[proy_subprograma].'</td>
<td>'.$proyectos[proy_subprograma].'</td>
<td>'.$proyectos[proy_subprograma].'</td>
<td>'.$proyectos[proy_subprograma].'</td>
<td>'.$proyectos[proy_subprograma].'</td>
<td></td>
<td>'.$proyectos[proy_subprograma].'</td>
<td>'.$proyectos[proy_subprograma].'</td>
<td>'.$proyectos[proy_subprograma].'</td>
</tr>';
}
$html.='</table>';
$footer = '<div align="center" style="color:black;font-family:Arial;font-size:6pt;font-style:italic;">
Calle Fernando Guachalla N&ordm; 411 Esq.  20 de Octubre &ndash; Sopocachi<br/>Tel&eacute;fonos:  2419090 &ndash; 2124391 - 2124382&nbsp;Fax: 2124390 - 2114988 Pagina WEB:  www.vivienda.gov.bo<br/>{PAGENO}</div>';
// conversion HTML => PDF
include("mpdf.php");
$mpdf=new mPDF ('','A4','','',5);
$mpdf->AddPage('L','','','','','',5,5,10,5,1,5);
$mpdf->SetHTMLFooter($footer);  
$mpdf->WriteHTML($html);
$mpdf->Output();
exit;
?>

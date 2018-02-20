<?php
include("../filtro.php");
?>
<?php
require_once("tcpdf/config/lang/eng.php");
require_once("tcpdf/tcpdf.php");
include("script/functions.inc");
include("script/cifrar.php");
include("../conecta.php");
$cod_institucion=$_SESSION["institucion"];
$codigo_usuario=$_SESSION["cargo_asignado"];
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
 $sql_logo = mysql_query("SELECT instituciones_logo_cabecera, instituciones_logo_pie FROM instituciones
                                 WHERE instituciones_cod_institucion = '$cod_institucion'",$conn);
        if($fila_logo = mysql_fetch_array($sql_logo))
        {
            if($fila_logo["instituciones_logo_cabecera"] != "")
            {
                $_SESSION[logo_cabecera] = "../logos/".$fila_logo["instituciones_logo_cabecera"];
            }

            if($fila_logo["instituciones_logo_pie"] != "")
            {
                 $_SESSION[logo_pie] = "../logos/".$fila_logo["instituciones_logo_pie"];
            }
        }
        mysql_free_result($sql_logo);
        
class MYPDF extends TCPDF
{

    //Page header
    public function Header()
    {
       

        if($_SESSION[logo_cabecera] != "")
        {
            $this->Image($_SESSION[logo_cabecera], 15, 5, 185 , 20, 'JPEG', '', 'T', false, 300, '', false, false, 0, false, false, false);
        }
        // Set font
       // $this->SetFont('helvetica', 'B', 20);
        // Title
        //$this->Cell(0, 15, '<< TCPDF Example 003 >>', 0, false, 'C', 0, '', 0, false, 'M', 'M');
        $this->Ln();
    }

    // Page footer
    public function Footer()
    {
        // Position at 15 mm from bottom
        
        if($_SESSION[logo_pie] != "")
        {
            $this->Image($_SESSION[logo_pie], 15, 265, 185 , 10, 'JPEG', '', 'T', false, 300, '', false, false, 0, false, false, false);
        }
        
        $this->SetY(-22);
        // Set font
        $this->SetFont('helvetica', 'I', 5);
        // Page number
        $this->Cell(0, 10, 'Pag. '.$this->getAliasNumPage().'/'.$this->getAliasNbPages(), 0, false, 'C', 0, '', 0, false, 'T', 'M');
    }
}

$pdf = new MYPDF(PDF_PAGE_ORIENTATION, PDF_UNIT, 'LETTER', true, 'UTF-8', false);
// set document information
$pdf->SetCreator(PDF_CREATOR);
$pdf->SetAuthor("ADSIB");
$pdf->SetTitle("SISTEMA DE CORRESPONDENCIA");
$pdf->SetSubject("EV");
$pdf->SetKeywords("EV");

$pdf->SetHeaderData(PDF_HEADER_LOGO, PDF_HEADER_LOGO_WIDTH, PDF_HEADER_TITLE, PDF_HEADER_STRING);

// set header and footer fonts
$pdf->setHeaderFont(Array(PDF_FONT_NAME_MAIN, '', PDF_FONT_SIZE_MAIN));
$pdf->setFooterFont(Array(PDF_FONT_NAME_DATA, '', PDF_FONT_SIZE_DATA));

// set default monospaced font
$pdf->SetDefaultMonospacedFont(PDF_FONT_MONOSPACED);

//set margins
$pdf->SetMargins(PDF_MARGIN_LEFT, PDF_MARGIN_TOP, PDF_MARGIN_RIGHT);
$pdf->SetHeaderMargin(PDF_MARGIN_HEADER);
$pdf->SetFooterMargin(PDF_MARGIN_FOOTER);

//set auto page breaks
$pdf->SetAutoPageBreak(TRUE, PDF_MARGIN_BOTTOM);

//set image scale factor
$pdf->setImageScale(PDF_IMAGE_SCALE_RATIO);

//set some language-dependent strings
$pdf->setLanguageArray($l);
// set font*/
$pdf->SetFont('times', '', 11);
// add a page
$pdf->AddPage();
//Datos solo de ejemplos


$valor_recibido = descifrar($_GET[valor]);
if(!is_numeric($valor_recibido))
{
    echo "<center><b>!!!! INTENTO DE MANIPULACION DE DATOS !!!!</b></center>";
    exit;
}

$sql_valor = mysql_query("SELECT * FROM registroarchivo
                           WHERE registroarchivo_codigo = '$valor_recibido'
                           AND (registroarchivo_estado <> 'P' OR registroarchivo_estado <> 'O')",$conn);
if($fila_archivo = mysql_fetch_array($sql_valor))
{
            $registroarchivo_referencia = $fila_archivo["registroarchivo_referencia"];
            $registroarchivo_texto = $fila_archivo["registroarchivo_texto"];

            $sql_consulta_doc = mysql_query("SELECT documentos_descripcion FROM documentos
                                             WHERE documentos_id = '$fila_archivo[registroarchivo_tipo]'",$conn);
            if($fila_tipo = mysql_fetch_array($sql_consulta_doc))
            {
                $tipo_de_nota = $fila_tipo["documentos_descripcion"];
            }
            mysql_free_result($sql_consulta_doc);

$informe = '<center>
                <table border="0" cellpadding="0" cellspacing="2" width="180mm" style=" font-family: Arial, Verdana;font-size: 12pt; color: #000;">
                 <tr>
                     <td colspan="3" align="center">
                         <center><b>
                         '.$tipo_de_nota.'<br />'.$fila_archivo["registroarchivo_hoja_interna"].'</b></center>
                     </td>
                 </tr>
                <tr>
                    <td align="right" width="50mm">
                        &nbsp;
                    </td>
                    <td width="20mm" align="left">
                                    <b>PARA:</b>
                    </td>
                    <td align="left" width="110mm">
           ';
                    $consulta_aux = "SELECT b.usuario_nombre, c.cargos_cargo
                                     FROM derivaciones a, usuario b, cargos c
                                     WHERE a.derivaciones_hoja_interna = '$valor_recibido'
                                     AND a.derivaciones_estado = 'P'
                                     AND a.derivaciones_cod_usr = b.usuario_ocupacion
                                     AND b.usuario_ocupacion = c.cargos_id";
                    $rss_consulta = mysql_query($consulta_aux, $conn);
                    while($fila_para = mysql_fetch_array($rss_consulta))
                    {
$informe .= "<br />".$fila_para["usuario_nombre"].'<br /><b>'.$fila_para["cargos_cargo"].'</b>' ;
                    }
                   mysql_free_result($rss_consulta);
$informe .= '  </td>
                 </tr>
            ';

                    $consulta_aux = "SELECT b.usuario_nombre, c.cargos_cargo
                                     FROM derivaciones a, usuario b, cargos c
                                     WHERE a.derivaciones_hoja_interna = '$valor_recibido'
                                     AND a.derivaciones_estado = 'V'
                                     AND a.derivaciones_cod_usr = b.usuario_ocupacion
                                     AND b.usuario_ocupacion = c.cargos_id";
                    $rss_consulta = mysql_query($consulta_aux, $conn);
                    if(mysql_num_rows($rss_consulta) > 0)
                    {

$informe .= '<tr>
                    <td align="right" width="50mm">
                        &nbsp;
                    </td>
                    <td align="left" width="20mm">
                            <b>VIA:</b>&nbsp;&nbsp;
                    </td>
                    <td align="left" width="110mm">
             ';
                   if($fila_para = mysql_fetch_array($rss_consulta))
                    {
$informe .= "<br />".$fila_para["usuario_nombre"].'<br /><b>'.$fila_para["cargos_cargo"].'</b>';
                    }
$informe .= '  </td>
                 </tr>';
                    }
                   mysql_free_result($rss_consulta);
                   
$informe .= '  <tr>

                    <td align="right" width="50mm">
                        &nbsp;
                    </td>
                    <td align="left" width="20mm">
                            <b>DE:</b>&nbsp;&nbsp;
                    </td>
                    <td align="left" width="110mm">
             ';
                    $consulta_aux = "SELECT b.usuario_nombre, c.cargos_cargo
                                     FROM derivaciones a, usuario b, cargos c
                                     WHERE a.derivaciones_hoja_interna = '$valor_recibido'
                                     AND a.derivaciones_estado = 'D'
                                     AND a.derivaciones_cod_usr = b.usuario_ocupacion
                                     AND b.usuario_ocupacion = c.cargos_id";
                    $rss_consulta = mysql_query($consulta_aux, $conn);
                    while($fila_para = mysql_fetch_array($rss_consulta))
                    {
$informe .= "<br />".$fila_para["usuario_nombre"].'<br /><b>'.$fila_para["cargos_cargo"].'</b>';
                    }
                   mysql_free_result($rss_consulta);
$informe .= '</td>
            </tr>';

/*$sql_ciudad = mysql_query("SELECT * FROM edificio
                           WHERE edificio_cod_institucion ='$_SESSION[institucion]'",$conn);
if($fila_ciudad = mysql_fetch_array($sql_ciudad))
{
$ciudad=$fila_ciudad["edificio_ciudad"];
}*/

$sql_ciudad = mysql_query("SELECT * FROM edificio e, departamento d
                           WHERE  d.departamento_cod_departamento='$_SESSION[departamento]'
						   AND d.departamento_cod_edificio = e.edificio_cod_edificio
						   AND e.edificio_cod_institucion ='$_SESSION[institucion]'",$conn);
if($fila_ciudad = mysql_fetch_array($sql_ciudad))
{
$ciudad=$fila_ciudad["edificio_ciudad"];
}


if(!empty($fila_archivo["registroarchivo_adj_documento"]))
{
$fecha_recibido=explode(" ",$fila_archivo[registroarchivo_fecha_pdf]);
$informe .= '<tr>
             <td align="right" width="50mm">
                        &nbsp;
            </td>
            <td align="left" width="20mm">
                    <b>FECHA:</b>&nbsp;&nbsp;
            </td>
             <td align="left" width="110mm">'.$ciudad.', '.MesLiteral($fecha_recibido[0]).'
             </td>
            </tr>';
}

$informe .= '<tr>
              <td align="right" width="50mm">
                        &nbsp;
            </td>
            <td align="left" width="20mm">
                    <b>REF:</b>&nbsp;&nbsp;
            </td>
             <td align="left" width="110mm">'.$fila_archivo[registroarchivo_referencia].'
             </td>
            </tr>
            </table>
            </center>
            <hr />';

$pdf->writeHTML($informe, true, false, false, false,'');

$pdf->writeHTML($fila_archivo[registroarchivo_texto], true, false, false, false,'');

}

$pdf->lastPage(); 
$pdf->Output("imprime_hoja34.pdf", "I", "I");

?>
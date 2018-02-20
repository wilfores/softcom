<?php
include("../filtro.php");
require_once("dompdf/dompdf_config.inc.php");
?>
<?php
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
?>
<?php
$valor_recibido = descifrar($_GET[valor]);

$sql_valor = mysql_query("SELECT * FROM registroarchivo
                           WHERE registroarchivo_codigo = '$valor_recibido'
                           AND registroarchivo_estado = 'T'",$conn);
if($fila_archivo = mysql_fetch_array($sql_valor))
{
            $registroarchivo_referencia = $fila_archivo["registroarchivo_referencia"];
            $registroarchivo_texto = $fila_archivo["registroarchivo_texto"];

$informe = '<center>
              <img src="./images/banner.jpg">
                <table border="0" cellpadding="0" cellspacing="2" align="center" width="80%">
                <tr>
                     <td colspan=2>
                         <center><b>'.$fila_archivo["registroarchivo_hoja_interna"].'</b></center>
                     </td>
                </tr>
                <tr>
                    <td align="right">
                            <b>Para:</b>
                    </td>
                    <td align="left">
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
$informe .= $fila_para["usuario_nombre"].'<br /><b>'.$fila_para["cargos_cargo"].'</b><br />';
                    }
                   mysql_free_result($rss_consulta);
             
$informe .= '</td>
            </tr>';
$informe .= '<tr><td colspan="2">'.$fila_archivo[registroarchivo_texto].'
    </td>
    </tr>
 </table>
 </center>
   ';
}
?>
<?php
$dompdf = new DOMPDF();
$dompdf->load_html($informe);
$dompdf->render();
$dompdf->stream('archivo.pdf');
?>
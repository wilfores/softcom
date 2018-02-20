<?php
include("../filtro.php");
?>
<?php
include("inicio.php");
?>

<?php
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
$fecha=date("Y-m-d H:i:s");

$tipo_doc=$_POST["tipo_doc"];
$doc_para=$_POST["doc_para"];
$nom=$_POST["nom"];
$ref=$_POST["tema"];
/*selecion ale cite de la tabla departamento*/
$rcite=mysql_query("SELECT d.departamento_forma_cite from cargos c, departamento d 
					where c.cargos_id='$codigo' and c.cargos_cod_depto=d.departamento_cod_departamento",$conn);
$rpc=mysql_fetch_array($rcite);

$rdoc=mysql_query("SELECT * from documentos 
					where documentos_id='$tipo_doc'",$conn);
$rpd=mysql_fetch_array($rdoc);

$cite=$rpc["0"].'/'.$rpd["documentos_sigla"].'/';

echo "$codigo del q envia <br />";
echo "$tipo_doc numero de documento<br />";
echo "$doc_para para quien sera el documento<br />";
echo "$ref <br />";
echo "$cite";
?>

<a href="javascript:window.print();" align="center">
<font face="Arial, Helvetica, sans-serif" size="2"><b><img src="images/printready.gif" border="0">Imprimir 
  P&aacute;gina</b></font></a>
<table width="794" height="194" border="1" cellpadding="1">
  <tr>
    <td width="159" rowspan="3" align="center">
	<img src="images/escudo_bolivia.gif" width="100" height="70" align="middle" />
	</td>
    <td width="306" rowspan="3">Ministerio de Salud y Deportes<br />
    Software de Correspondencia Ministerial</td>
    <td width="136">Hoja de Ruta: </td>
    <td width="165">MSD/II-14/2012</td>
  </tr>
  <tr>
    <td height="24">Gestion:</td>
    <td height="24">MSyD - 2012 </td>
  </tr>
  <tr>
    <td>Fecha Limmite: </td>
    <td>NINGUNA</td>
  </tr>
  <tr>
    <td colspan="1">REFERENCIA:</td>
    <td colspan="3">DOCUMENTACION INTERNA DEL PERSONAL </td>
  </tr>
  <tr>
    <td>Fecha de Creacion: </td>
    <td colspan="3">22/06/2012 17:17 </td>
  </tr>
  <tr>
    <td colspan="4" align="center"><strong>ACTA DE ENTREGA DE CORRESPONDENCIA </strong></td>
  </tr>
  <tr>
    <td colspan="4"><strong>Detalle de Derivacion </strong></td>
  </tr>
  <tr>
    <td><strong>Remite:</strong></td>
    <td colspan="3"><p>Lic. Nicolas Torrez</p>
    <p>DIRECTOR GENERAL DE ASUNTOS ADMINISTRATIVOS </p></td>
  </tr>
  <tr>
    <td><strong>Destino:</strong></td>
    <td colspan="3"><p>Dr. Gui Alberto Vargas</p>
    <p>DIRECTOR GENERAL DE PLANIFICACION </p></td>
  </tr>
  <tr>
    <td colspan="4">Fecha y hora de Derivacion: 22/06/2012 17.17 </td>
  </tr>
  <tr>
    <td colspan="4">Prioridad: NORMAL . . .Plazo: 3 diasn Habiles . . . .Requiere Respuesta: SI </td>
  </tr>
  <tr>
    <td colspan="4"><p>Instruccion: REALIZAR COPIAS DIGITALES DE TODOS LOS ARCHIVOS </p>    </td>
  </tr>
  <tr>
    <td colspan="2"><p><strong>RESUMEN DE DOCUMENTACION </strong></p>
      <p>Documentacion Asociada: .1 . . . . . .<br />Total de Hojas: . 1 . . . . . <br />Total Anexo: . 2 . . . </p>
    <p>Fecha de Recepcion ............../............/............. Hora:......................... </p></td>
    <td colspan="2" align="center"><p>&nbsp;</p>
    <p>&nbsp;</p>
    <p>&nbsp;</p>
    <p>Sello y Firma </p></td>
  </tr>
</table>

<?php
include("../final.php");
?>

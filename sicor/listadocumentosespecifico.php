<?php
include("../filtro.php");
?>
<?php
include("../conecta.php");
?>
<?php
include("script/functions.inc");
include("script/cifrar.php");
include("inicio.php");

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

if($_POST['controlcito']==1)
{ $_SESSION['valordocumento'] = $_POST['valordocumento'];
}  

$valordoc=$_SESSION['valordocumento'];
$coddepartamento=$_SESSION["departamento"];		

$ssql = "SELECT documentos_descripcion,documentos_id FROM documentos where documentos_id='$valordoc'";
$rss = mysql_query($ssql, $conn);
$valor=mysql_fetch_array($rss);



$var=$_POST['valor'];
$sel_inst1=$var[0];
if (isset($_POST['Impresion'])and isset($sel_inst1))
{
  
   $_SESSION['valor']=$_POST['valor'];
/*   foreach ($_POST['valor'] as $valor)
        { echo "$valor<br>"; }
		exit;*/
?>
<script language="javascript">

    open('imprime_notasinternas.php');
	
    window.self.location="listadocumentosespecifico.php";

</script>

<?PHP }
if (isset($_POST['cancelar'])) {
?>
    <script language="javascript">
        window.self.location="listadocumentos.php";
    </script>
<?php
}
?>
<br>
<div align="center"><span class="fuente_titulo"><b>LISTADO GENERAL DE  DOCUMENTOS GENERADOS DE <?PHP echo $valor[0]?></b></div>
<br>

<form method="POST" name="aceptar">
<table width="100%" border="0" align="center" cellpadding="1" cellspacing="1">
<tr class="border_tr2">
  <td width="3%" align="center">&nbsp;</td>
<td width="10%" align="center">N&ordm; CORRELAVITO</td>
<td width="10%" align="center">CITE</td>
<td width="7%" align="center">FECHA</td>
<td width="25%" align="center">PROCESO</td>
<td width="30%" align="center">REFERENCIA</td>
<td width="15%" align="center">RESPONSABLE DE ELABORACION DE NOTA </td>
<td width="5%" align="center">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</td>
</tr>
</table>
<div id="main" style="height:300px; width:100%; overflow : hidden; overflow-y : scroll; background-color:#EFF1F5; ">
<table width="100%" border="0" align="center" cellpadding="1" cellspacing="1">
<?PHP
$ssq2="select registroarchivo_hoja_interna,registroarchivo_referencia,LOWER( DATE_FORMAT(registroarchivo_fecha_recepcion, '%d-%m-%Y')) AS fecha,
u.usuario_nombre,departamento_sigla_dep,registroarchivo_codigo
from registroarchivo ra, usuario u, cargos c, departamento d
where ra.registroarchivo_tipo='$valordoc' and ra.registroarchivo_usuario_inicia=u.usuario_ocupacion 
and u.usuario_ocupacion=c.cargos_id and c.cargos_cod_depto=d.departamento_cod_departamento and d.departamento_cod_departamento='$coddepartamento'
ORDER BY ra.registroarchivo_codigo asc";	 
$rss2 = mysql_query($ssq2, $conn);
$resaltador=0;
while($valor2=mysql_fetch_array($rss2))
{

if ($resaltador==0)
	  {
       echo "<tr class=truno>";
	   $resaltador=1;
      }
	  else
	  {
       echo "<tr class=trdos>";
   	   $resaltador=0;
	  }
	$vector=split("/",$valor2[0]);
?>

<td width="3%" align="center"><input type="checkbox" name="valor[]" value="<?php echo $valor2[5] ?>" /></td>
<td width="10%" align="center" height="25"><?PHP echo $vector[3];?></td>
<td width="10%" align="center"><?PHP echo $valor2[0];?></td>
<td width="7%" align="center"><?PHP echo $valor2[2];?></td>
<td width="25%" align="center">&nbsp;&nbsp;<?PHP echo $valor2[4];?></td>
<td width="30%" align="left">&nbsp;&nbsp;<?PHP echo $valor2[1];?></td>
<td width="15%" align="left">&nbsp;&nbsp;<?PHP echo $valor2[3];?> </td>
</tr>
<?PHP }?>
<tr >
  <td colspan="8" align="center"></td>
</tr>
</table>
</div>
<table width="100%" border="0" align="center" cellpadding="1" cellspacing="1">
<tr >
  <td colspan="8" align="center">&nbsp;</td>
</tr>
<tr >
<td colspan="8" align="center"><input type="submit" name="Impresion" value="Imprimir" class="boton"/>
<input type="submit" name="cancelar" value="Cancelar" class="boton"  />
</td>
</tr>
</table>
</form>

<?php
include("final.php");
?>


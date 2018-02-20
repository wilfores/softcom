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
$depto=$_SESSION["departamento"];
$tipo_doc=$_SESSION["documento"];

$fecha=date("Y-m-d H:i:s");
$ges=date('Y');
//$tipo_doc=$_POST["tipo_doc"];
$doc_para=$_SESSION["para"];
$nom=$_POST["nom"];
$ref=$_SESSION["ref"];
$asoc=$_SESSION["asoc"];
$val=$_SESSION["valor"];


/*selecion ale cite de la tabla departamento*/
$rcite=mysql_query("SELECT d.departamento_forma_cite from cargos c, departamento d 
					where c.cargos_id='$codigo' and c.cargos_cod_depto=d.departamento_cod_departamento",$conn);
$rpc=mysql_fetch_array($rcite);

$rdoc=mysql_query("SELECT * from documentos 
					where documentos_id='$tipo_doc'",$conn);
$rpd=mysql_fetch_array($rdoc);

$rdoc=mysql_query("SELECT documentos_sigla FROM documentos
						where documentos_id='$tipo_doc'",$conn);
$rdc=mysql_fetch_array($rdoc);/*saca la sigla del documento*/
	
$query = "select max(registrodoc_n_doc)from registrodoc where registrodoc_doc='$rdc[0]'";
$result = mysql_query($query,$conn);
$record = mysql_fetch_array($result);			
$id_fact=$record[0]+1;/*obtiene el maximmo del id del documento*/

$cite=$rpc["0"].'/'.$rpd["documentos_sigla"].'/'.$id_fact.'/'.$ges;

echo "$codigo del q envia <br />";
echo "$tipo_doc numero de documento $rdc[0]<br />";
echo "$doc_para para quien sera el documento<br />";
echo "$ref <br />";
echo "$cite<br />";
echo "$asoc<br />";
echo "$val<br />";


$sig_usu_de=mysql_query("SELECT d.departamento_sigla_dep, u.usuario_nombre, c.cargos_cargo
from usuario u, departamento d, cargos c
where u.usuario_ocupacion='$codigo'
and u.usuario_cod_departamento=d.departamento_cod_departamento
and u.usuario_ocupacion=c.cargos_id",$conn);
$r_usu_de=mysql_fetch_array($sig_usu_de);
$r_usu_de1=$r_usu_de[0];
$nom_de=$r_usu_de[1];
$cargo_de=$r_usu_de[2];

$sig_usu_para=mysql_query("SELECT d.departamento_sigla_dep, u.usuario_nombre, c.cargos_cargo
from usuario u, departamento d, cargos c
where u.usuario_ocupacion='$doc_para'
and u.usuario_cod_departamento=d.departamento_cod_departamento
and u.usuario_ocupacion=c.cargos_id",$conn);
$r_usu_para=mysql_fetch_array($sig_usu_para);
$r_usu_para1=$r_usu_para[0];
$nom_para=$r_usu_para[1];
$cargo_para=$r_usu_para[2];

?>
<br />
<?

?>
<br />
<?php
include("final.php");
?>

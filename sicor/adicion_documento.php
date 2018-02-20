<?php
include("../filtro.php");
include("../conecta.php");
include("cifrar.php");
include("script/functions.inc");
?>
<link rel="stylesheet" type="text/css" href="script/estilos2.css" title="estilos2" />
<?php
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
$gestion = strftime("%Y");

$cod_institucion=$_SESSION["institucion"];
$aux1 =0;

if(isset($_POST['cancelar']))
{
?>
 <script language="JavaScript">
 window.self.location="busca_documento.php";
 </script>
<?php
}


if (isset($_POST['enviar'])) 
{
  if(empty($_POST['entidad_nombre']))
	{
    $error = TRUE;
	$alert_nombre=1; 	
	$aux1 = 1;
    } 
 
 if(!empty($_POST['entidad_sigla']))
 { 
	$sql_ent = "SELECT * FROM clasecorrespondencia";
	$rs_ent2 = mysql_query($sql_ent, $conn);
	while ($row= mysql_fetch_array($rs_ent2))
	 {
	 	if($_POST['entidad_sigla']==$row['clasecorrespondencia_codigo_clase_corresp'])
		{	 $error=TRUE;
		     $alert_sigla=1; 
		 }	
	 }	 
	}
  
 if (!$error)
 {
	$nom_doc = strtoupper($_POST[entidad_nombre]);
	$sigla_doc ='E-'. strtoupper($_POST[entidad_sigla]);	

	mysql_query("insert into clasecorrespondencia 			(clasecorrespondencia_codigo_clase_corresp,clasecorrespondencia_descripcion_clase_corresp)values('$sigla_doc','$nom_doc')",$conn);


 ?>
 <script language="JavaScript">
 window.self.location="busca_documento.php";
 </script>
 <?php  
 } 
} 
else 
{
?>
<br>
<p class="fuente_titulo"><span class="fuente_normal">
<center><B>ADICIONAR TIPO DE DOCUMENTO</B></center>
<br>
<?php
}
?>

<center>
<?php
if ($error != 0)
{
echo "<center><table><tr><td class=fuente_normal_rojo  align=left><center><b> !!! ERROR, DATOS DUPLICADOS !!!</b></center>".$valor_error."</td></tr></table></center>";
}
?>
<table width="80%" cellspacing="2" cellpadding="2" border="0">
<form action="" method="POST" name="enviar">

<tr class="border_tr3">
<td>
<span class="fuente_normal">Nombre del Documento</span>
</td>
<td>
<input type="text" name="entidad_nombre" maxlength="250" size="30" class="caja_texto" value="<?php echo $_POST['nombre_entidad'];?>"/>
<?php Alert($alert_nombre);?>
</td>
</tr>

<tr class="border_tr3">
<td>
<span class="fuente_normal">Sigla del Documento</span>
</td>
<td>
<input type="text" name="entidad_sigla" maxlength="250" size="30" class="caja_texto" value="<?php echo $_POST['nombre_entidad'];?>"/>
<?php Alert($alert_sigla); ?>
</td>
</tr>


<tr>
<td align="center" colspan="2">
<input type="submit" name="enviar" value="Aceptar" class="boton"/>
<input type="submit" name="cancelar" value="Cancelar" class="boton"/></td>
</tr>
</form>
</table>
</center>
<br>
<?php
include("final.php");
?>

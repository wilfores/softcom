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
$cod_institucion=$_SESSION["institucion"];
$nom_usuario=$_SESSION["nombre"];
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
<script language="JavaScript">
function Adicionar(){
	document.ingreso.action="ingreso_nota.php";
	document.ingreso.submit();
}
function Retornar()
{
	document.ingreso.action="encuentra2.php";
	document.ingreso.submit();
}
</script>
<?php
$ssql="select * from registroarchivo a, derivaciones b 
	   where a.registroarchivo_codigo=b.derivaciones_hoja_interna 
	   AND b.derivaciones_cod_usr='$_SESSION[cargo_asignado]'
	   AND b.derivaciones_estado='TR'
	   AND a.registroarchivo_adj_documento ='1'"; 
	   
$respi=mysql_query($ssql,$conn);

?>
<br />
<center>
<p class="fuente_titulo">
    <span class="fuente_normal">
        <center><b>ARCHIVO DERIVADO</b></center>
    </span>
</p></center>

<table width="100%" cellspacing="1" cellpadding="1" border="0">
<tr class="border_tr2">
<td width="8%" align="center"><span class="fuente_normal">Hoja Interna</span></td>
<td width="13%" align="center"><span class="fuente_normal">Tipo</span></td>
<td width="20%" align="center"><span class="fuente_normal">Referencia</span></td>
<td width="5%" align="center"><span class="fuente_normal">Fecha Derivacion</span></td>
<td width="6%" align="center" colspan="1"><span class="fuente_normal">Accion</span></td>
</tr>
</table>
<DIV class=tableContainer id=tableContainer>
<div style="overflow:auto; width:100%; height:210px; align:left;">
<center>
<table width="100%" cellspacing="1" cellpadding="1" border="0" style="font-size:10px">
<?php 
  $resaltador=0;
 while($row=mysql_fetch_array($respi))
{

    $identificador = cifrar($row["registroarchivo_codigo"]);
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
?>
<td align="center" width="8%">&nbsp;&nbsp;&nbsp;&nbsp;<b><?php echo $row["registroarchivo_hoja_interna"];?></b></td>
<td align="center" width="13%">
&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
<b>
<?php
        $valor_cargo=$row["registroarchivo_tipo"]; 
		$conexion2 = mysql_query("SELECT * FROM documentos WHERE '$valor_cargo'=documentos_id",$conn);
		if($fila_cargo=mysql_fetch_array($conexion2))
		{
		echo $fila_cargo["documentos_descripcion"];
		}
?>
</b>
</td>
<td align="justify" width="20%"><?php echo $row["registroarchivo_referencia"];?></td>

<td width="5%" align="center">
        <?php echo $row["derivaciones_fecha_derivacion"];?>
</td>

<td width="6%" align="center"><a href="historia_nota.php?valor=<?php echo $identificador;?>" class="botonte">Ver</a></td>
</td>

</tr>
<?php
}   
mysql_close($conn);
?>
</table>
</center>
</div>
<br>
<center>

<table width="70%" cellspacing="2" cellpadding="2" border="0">
<tr class="border_tr">
<td width="95%" align="center">
<form method="POST" name="ingreso">
<input type="submit" name="cancelar" value="Cancelar" class="boton" onClick="Retornar();" />
</form>
</td>
</tr>
</table>
<?php
include("../final.php");
?>
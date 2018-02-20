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
unset($_SESSION[pagina_original]);
?>
<script language="JavaScript">
function Retornar()
{
	document.ingreso.action="menu.php";
	document.ingreso.submit();
}
</script>
<?php
$ssql="select * from registroarchivo a, derivaciones b
   where a.registroarchivo_codigo=b.derivaciones_hoja_interna
   AND b.derivaciones_cod_usr='$_SESSION[cargo_asignado]'
   AND b.derivaciones_estado='V' AND b.derivaciones_proveido='S'
   ORDER BY a.registroarchivo_fecha_pdf DESC";
   //AND a.registroarchivo_estado = 'A'";
$respi=mysql_query($ssql,$conn);
?>
<br />
<p class="fuente_titulo">
    <span class="fuente_normal">
    <center>
        <b>ARCHIVO PARA VISTO BUENO</b>
    </center>
    </span>
</p>

<table width="100%" cellspacing="1" cellpadding="1" border="0" >
<tr class="border_tr2">
<td width="5%" align="center"><span class="fuente_normal"><b>*</b></span></td>
<td width="10%" align="center"><span class="fuente_normal">Hoja Interna</span></td>
<td width="10%" align="center"><span class="fuente_normal">Fecha elaboracion</span></td>
<td width="10%" align="center"><span class="fuente_normal">Estado</span></td>
<td width="10%" align="center"><span class="fuente_normal">Tipo</span></td>
<td width="30%" align="center"><span class="fuente_normal">Referencia</span></td>
<td width="10%" align="center"><span class="fuente_normal">Archivo</span></td>
<td width="15%" align="center" colspan="2"><span class="fuente_normal">Accion</span></td>
</tr>
</table>
<div style="overflow:auto; width:100%; height:320px; align:left;">
<center>
<table width="100%" cellspacing="1" cellpadding="1" border="0" style="font-size:10px">
<?php
  $resaltador=0;
 while($row=mysql_fetch_array($respi))
{
  $id_encriptado = cifrar($row["registroarchivo_codigo"]);
        $buscar = $row["registroarchivo_codigo"];
	$busqueda = "SELECT * FROM terminados
                     WHERE terminados_hoja_interna='$buscar'
                     AND terminados_cod_usr='$codigo_usuario'";
	$buscar = mysql_query($busqueda,$conn);
	$num = mysql_num_rows($buscar);
 if ($num == '')
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
?>
<td align="left" width="5%">
<b>        <?php echo $row["derivaciones_tipo_derivacion"];?>
</b>
</td>
<td align="left"" width="10%">
<b><a href="historia_nota.php?valor=<?php echo $id_encriptado;?>" class="enlace_normal">
        <?php echo $row["registroarchivo_hoja_interna"];?>
</a></b>
</td>
<td align="left"" width="10%"><?php echo $row["registroarchivo_fecha_pdf"];?></td>
<td align="left" width="10%">
        <center>
            <b>
           <?php
                switch($row["registroarchivo_estado"])
           {
                 case 'P': echo "Elaboracion";break;
                 case 'T': echo "Presentado";break;
                 case 'O': echo "Observado";break;
                 case 'A': echo "VoBo VIA";break;
                 case 'D': echo "VoBo PARA";break;
           };
           ?>
            </b>
        </center>
</td>
<td align="left"" width="10%">
<?php
    $valor_cargo= $row["registroarchivo_tipo"];
    $conexion2 = mysql_query("SELECT * FROM documentos WHERE '$valor_cargo'=documentos_id",$conn);
    if($fila_cargo=mysql_fetch_array($conexion2))
    {
        echo "<b>".$fila_cargo["documentos_descripcion"]."</b>";
    }

?>
</td>
<td align="left"" width="30%"><?php echo $row["registroarchivo_referencia"];?></td>
<td width="10%" align="center">
    <a href="historia_prueba.php?valor=<?php echo $id_encriptado;?>"><img src="images/documentos.png" border="0">
    </a>
</td>
<td width="15%" align="center">
 <?php
 if($row["registroarchivo_estado"]=='A' || $row["registroarchivo_estado"]=='D' || $row["registroarchivo_estado"]=='O')
 {
 ?>
    <a href="nota_aprobar.php?valor=<?php echo $id_encriptado;?>" class="botonte">Aprobar</a>&nbsp;&nbsp;
    <a href="nota_observar.php?valor=<?php echo $id_encriptado;?>" class="botonte">Observar</a>
 <?php
 }
 else
 {
   if($row["registroarchivo_estado"]=='T')
    {
    ?>
    <a href="historia_prueba.php?valor=<?php echo $id_encriptado;?>" class="botonte">Ver</a>&nbsp;&nbsp;
    <?php
    }
    else
    {
    ?>
    <a href="historia_seguimiento.php?valor=<?php echo $id_encriptado;?>" class="botonte">Ver</a>&nbsp;&nbsp;
    <?php
    }
 }
 ?>
</td>
</tr>
<?php
}
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
</center>
<?php
include("../final.php");
?>
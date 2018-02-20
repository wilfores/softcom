<?php
include("filtro_adm.php");
?>
<?php
include("inicio.php");
include("conecta.php");
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
$codigo=$_SESSION["codigo_miderivacion"];
$institucion=$_SESSION["institucion"];

/***************************************************************************************************************
                                          CONSULTA PARA ASIGAR TIPO DE DOCUMENTOS
***************************************************************************************************************/

$ssql="SELECT * from documentos ORDER BY documentos_id";
$ssqll="SELECT * from documentocargo where documentocargo.documentocargo_cargo='$_SESSION[codigo_miderivacion]' ORDER BY documentocargo_doc";

if (isset($_POST['enviar']))
{
$var=$_POST['cod_usuario'];
$elementos = count($var);
  for($i=0; $i < $elementos; $i++)
  {
            $respu=mysql_query("select * from documentocargo where documentocargo_cargo='$codigo'and documentocargo_doc='$var[$i]'",$conn);
            $Lista=mysql_fetch_row($respu);
	if($Lista[0])
	{
		echo " ";
	}
	else
	{
            mysql_query("insert into documentocargo (documentocargo_doc,documentocargo_cargo)values('$var[$i]','$codigo')",$conn) or die("El Registro no Existe");

	}
   } //end for

?>
<script>
        window.self.location="tipo_doc.php";
</script>
<?php
}//fin enviar


 if (isset($_POST['regresar']))
 {  $var=$_POST['cod_usuario'];
	$elementos = count($var);
	for($i=0; $i < $elementos; $i++)
	{
	mysql_query("delete from documentocargo where documentocargo_id='$var[$i]'",$conn) or die("El Registro no Existe");
	}
	?>
	<script>
			window.self.location="tipo_doc.php";
	</script>
	<?php
  }//fin regresar
?>

<div align="center" class="fuente_normal_rojo">

<?php
    $valor_clave=$_SESSION["codigo_miderivacion"];
	$conexion = mysql_query("SELECT * FROM cargos WHERE '$valor_clave'=cargos_id",$conn);
	if($fila_clave=mysql_fetch_array($conexion))
	{
		$guardadito=strtoupper($fila_clave["cargos_cargo"]);
	}
?>
</div>
<br>
<B><P class="fuente_titulo_principal"><span class="fuente_normal">
<CENTER> SELECCION DE TIPO DE DOCUMENTO <BR>USUARIO :<b class="fuente_normal_rojo"><?php echo $guardadito; ?></b> 
</CENTER></B>
<BR>
<center>
<table border=1 width="40%">
<tr>
<td width="50%" align="left">
<center><span class="fuente_subtitulo">Listado Total Documentos</span></center>
<form name="enviar" method="post">
<div style="overflow:auto; width:250; height:200px; align:left;">
<table boder=1 align="center" width="100%">
<tr>
<th height="10" colspan="1" bgcolor="#eeeeee">
        <center><input class="boton1" name="boton" type="reset" value="*" ></center>
    </th> 
<th><span class="fuente_subtitulo">Sigla</span></th>
<th><span class="fuente_subtitulo">Documento</span></th>
</tr>
<?php
$resulta=mysql_query($ssql,$conn); 
while($row=mysql_fetch_array($resulta))
{
echo "<tr>";
?>
<td height="10" colspan="1" bgcolor="#EFEBE3">
<input type="checkbox" value="<?php echo $row["documentos_id"];?>" name="cod_usuario[]">
</td>
<?php
echo "<td bgcolor=#EFEBE3><span class=fuente_normal>".$row["documentos_sigla"]."</span></td>";
echo "<td bgcolor=#EFEBE3><span class=fuente_normal>".$row["documentos_descripcion"]."</span></td>";
echo "</tr>";
}
?>
</table>
</div>
<center>
<input class="boton" type="submit" name="enviar" value="Adicionar">
<br /><br />
</center>
<input class="boton" type="button"  value="Marcar Todo" onclick="javascript:seleccionar_todo()" >
<input class="boton" type="button"  value="Desmarcar Todo" onclick="javascript:deseleccionar_todo()" >
</form>
<?php
/**************************************************************************************************
                                          PERSONAL DOCUMENTOS-SELECCIONADOS
**************************************************************************************************/
?>

</td>
<td width="50%" align="left">
<center><span class="fuente_subtitulo">Documentos Asignados</span></center>
<form name="regresar" method="post">
<div style="overflow:auto; width:250; height:200px; align:left;">
<table boder=1 width="100%" align="center">
<tr>
<th height="10" colspan="1" bgcolor="#eeeeee">
        <center><input class="boton1" name="boton" type="reset" value="*" ></center>
    </th> 
<th><span class="fuente_subtitulo">Sigla</span></th>
<th><span class="fuente_subtitulo">Documento</span></th>


</tr>
<?php
$resu=mysql_query($ssqll,$conn);// resulta=RS
while ($rows=mysql_fetch_array($resu))
{
echo "<tr>";
?>
<td height="10" colspan="1" bgcolor="#EFEBE3">
<input  type="checkbox" value="<?php echo $rows["documentocargo_id"];?>" name="cod_usuario[]" >
</td>
<?php
    $valor_clave=$rows["documentocargo_doc"];
	$conexion = mysql_query("SELECT * FROM documentos WHERE '$valor_clave'=documentos_id",$conn);
	if($fila_clave=mysql_fetch_array($conexion))
	{
echo "<td bgcolor=#EFEBE3> <span class=fuente_normal>".$fila_clave["documentos_sigla"]."</span></td>";
echo "<td bgcolor=#EFEBE3><span class=fuente_normal>".$fila_clave["documentos_descripcion"]."</span></td>";
	 }

}
?>
</table>
</div>
<center>
<input class="boton" type="submit" name="regresar" value="Quitar">
<br /><br />
</center>
<input class="boton" type="button"  value="Marcar Todo" onclick="javascript:seleccionar_todo2()" >
<input class="boton" type="button"  value="Desmarcar Todo" onclick="javascript:deseleccionar_todo2()" >

</form>


</td>
</tr>
</table>
<br>
<form method="get" action="asignar2.php">
<input type="submit" value="Cancelar" class="boton">
</form> 
<br>
</center>
<?php
include("final.php");
?>		
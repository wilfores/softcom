<?php
include("filtro.php");
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
$codigo=$_SESSION["codigo"];
?>

<?php
if(isset($_POST['cambiar']))
{
mysql_query("UPDATE usuario SET  usuario_titulo='$_POST[titulo]' WHERE  usuario_cod_usr='$codigo'",$conn);
?>
<script language="javascript">
	window.self.location="menu.php";
</script>
<?php
}

if(isset($_POST['password']))
{
?>
<script language="javascript">
window.self.location="usuariopassword.php";
</script>
<?php
}

if(isset($_POST['cancelar']))
{
?>
<script language="javascript">
window.self.location="menu.php";
</script>
<?php
}
?>
<?php
$ssql = "SELECT * FROM  usuario WHERE '$codigo'=usuario_cod_usr";
$rss=mysql_query($ssql, $conn);
$row=mysql_fetch_array($rss);
?>
<TABLE WIDTH="70%" BORDER="0" CELLSPACING="1" CELLPADDING="0" HEIGHT="10" ALIGN="center">
  <TR>
    <TD WIDTH="528" HEIGHT="10" COLSPAN="2">
	<B><P class="fuente_titulo_principal"><SPAN class="fuente_normal"><CENTER><BR>DATOS PERSONALES DEL USUARIO
	</CENTER><BR></B>
    </TD> 
  </TR>
  <form method="post">
  <tr bgcolor="#EFEBE3">
    <td width="40%"><P class="parrafo_normal"><SPAN class="fuente_normal">Titulo</td>
    <td width="60%">
    <input class="fuente_caja_texto" name="titulo" type="text" size="10" value="<?php echo $row["usuario_titulo"];?>" />
    </td>
  </tr>
 
  <tr bgcolor="#EFEBE3">
    <td ><P class="parrafo_normal"><SPAN class="fuente_normal">Nombre</td>
   <td ><?php echo "<span class=fuente_normal>".$row["usuario_nombre"];?></td>
  </tr>
 
  <tr bgcolor="#EFEBE3">
    <td><p class="parrafo_normal"><span class="fuente_normal">Cargo</td>
    <td><p class="parrafo_normal"><span class="fuente_normal"><?php echo $row["usuario_cargo"];?></td>
  </tr>
  
   <tr bgcolor="#EFEBE3">
    <td><p class="parrafo_normal"><SPAN class="fuente_normal">Email</td>
    <td><p class="parrafo_normal"><SPAN class="fuente_normal"><?php echo $row["usuario_email"];?></td>
  </tr>
  
  <tr bgcolor="#EFEBE3">
    <td><p class="parrafo_normal"><span class="fuente_normal">Username</td>
    <td><p class="parrafo_normal"><span class="fuente_normal"><?php echo $row["usuario_username"];?></td>
  </tr>


</table>
<p><center>
<input class="boton" type="submit" value="Guardar Cambios" name="cambiar">
<input class="boton" type="submit" value="Cambiar Password" name="password">
<input class="boton" type="submit" value="Cancelar" name="cancelar">
</center></p>
</form>
<?php
include("final.php");
?>

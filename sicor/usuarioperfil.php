<?php
include("../filtro.php");
?>
<?php
include("inicio.php");
?>
<?php
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
$ssql = "SELECT * FROM  usuario WHERE '$codigo'=usuario_ocupacion";
$rss=mysql_query($ssql, $conn);
$row=mysql_fetch_array($rss);
?>

<?php
if(isset($_POST['cambiar']))
{
mysql_query("UPDATE usuario SET usuario_email='$_POST[correo]', usuario_titulo='$_POST[titulo]', usuario_carnet='$_POST[ci]', usuario_carnet_ciudad='$_POST[ci_ciudad]' WHERE  usuario_ocupacion='$codigo'",$conn);
?>
<script language="javascript">
	window.self.location="menu2.php";
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
window.self.location="menu2.php";
</script>
<?php
}
?>
</script>
<B><P class="fuente_titulo_principal"><SPAN class="fuente_normal"><CENTER><BR>DATOS PERSONALES DEL USUARIO
	</CENTER><BR></B>
<TABLE WIDTH="60%" BORDER="0" CELLSPACING="1" CELLPADDING="1" HEIGHT="10" ALIGN="center" class="border_tr3">
  <form method="POST" name="actual">
   <tr class="border_tr3">
    <td width="10%"><strong>Cargo</strong></td>
    <td width="50%"><p><?php echo $row["usuario_cargo"];?></td>
  </tr>
  <tr class="border_tr3">
    <td><strong>Email</strong></td>
    <td><INPUT class="fuente_caja_texto" NAME="correo" TYPE="text" SIZE="30" value="<?php echo $row["usuario_email"];?>"></td>
  </tr>
  <tr class="border_tr3">
    <td><strong>Username</strong></td>
    <td><p><span class="fuente_normal"><?php echo $row["usuario_username"];?></td>
  </tr>
  
   <TR class="border_tr3">
    <TD><strong>Titulo</strong></TD>
    <TD><INPUT class="fuente_caja_texto" NAME="titulo" TYPE="text" SIZE="30" value="<?php echo $row["usuario_titulo"];?>"></TD>
  </TR>
  
   <TR class="border_tr3">
    <TD ><strong>Nombre</strong></TD>
   <TD ><p><span class="fuente_normal"><?php echo $row["usuario_nombre"];?></TD>
   <!--<TD ><INPUT class="fuente_caja_texto" NAME="nombre" TYPE="text" SIZE="30" value="<?php echo $row["usuario_nombre"];?>"></TD>-->
  </tr>
  
   <TR class="border_tr3">
    <TD ><strong>Carnet de Identidad</strong></TD>
   <TD ><INPUT class="fuente_caja_texto" NAME="ci" TYPE="text" SIZE="15" value="<?php echo $row["usuario_carnet"];?>">
  <b style="font-size: 10px;">
  <?php echo $row["usuario_carnet_ciudad"];?>
  </b>
  <i style="font-size: 9px;">&nbsp;&nbsp;&nbsp; Si desea cambiar la procedencia del CI seleccione aqui</i> -->
  <select class="fuente_caja_texto" name="ci_ciudad">
        <option value="LP">LP</option>
        <option value="CBBA">CBBA</option>
        <option value="SC">SC</option>
        <option value="OR">OR</option>
        <option value="BE">BE</option>
        <option value="PA">PA</option>
        <option value="EA">EA</option>
        <option value="CHU">CHU</option>
        <option value="PO">PO</option>
        <option value="TA">TJ</option>
   </select>
   </TD>
  </tr>
    
 </table>
<p><center>
<input style="font-size:9px; color:blue;" type="submit" value="Guardar Cambios" name="cambiar">
<input style="font-size:9px; color:blue;" type="submit" value="Cambiar Password" name="password">
<input style="font-size:9px; color:blue;" type="submit" value="Cancelar" name="cancelar">
</center></p>
</form>
<?php
include("final.php");
?>

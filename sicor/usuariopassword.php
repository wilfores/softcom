<?php
include("../filtro.php");
?>
<?php
include("inicio.php");
?>
<?php
include("../conecta.php");
$codigo=$_SESSION["cargo_asignado"];
$depto=$_SESSION["departamento"];
//echo "$codigo";
//$codigo_aux_a=$_POST["cargo_asignado"];
$error=0;
if (isset($_POST['enviar']))
{
                
			/*echo "$codigo <br>";
			echo "$_POST[actual] <br>";
			echo "$_POST[nueva] <br>";
			echo "$_POST[renueva] <br>";
			*/
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
						
                $ssql = "SELECT usuario_password FROM usuario WHERE '$codigo'= usuario_ocupacion";
                $rsdos = mysql_query($ssql, $conn);
                if ($rowdos = mysql_fetch_array($rsdos))
		{
                    //echo "$rowdos[usuario_password]";

		if ( md5($_POST['actual']) != $rowdos["usuario_password"])
                     {
                       $error=1;
                     }
                 }
                 if ($_POST['nueva'] != $_POST['renueva'])
                     {
                       $error=2;
                     }
                 if ($error==0)
                 {
                   $passren2=md5($_POST['nueva']);
				   
				   mysql_query("update usuario set usuario_password='$passren2' where '$codigo'=usuario_ocupacion",$conn);
?>
<br><br>
<div align="center">
<span style="font-family: Verdana, Arial, Helvetica, sans-serif; font-size: 12px; color: #990000;; font-weight: bold">Cambio realizado Satisfactoriamente</span>
  </p>
</div>
  <p align="center"><img src="images/pass.jpg" border="0" /><br /><br />
   <span style="font-weight: bold"><a href="menu2.php">[Continuar..]</a>
   <br />                                         
<?php
 exit;
}
}

if(isset($_POST['cancelar']))
{
?>
</span>
   <script language='JavaScript'>
   window.self.location="usuarioperfil.php"
   </script>
<?php
}
?>
 </p>
 </div>

 <div align="center">
 <br>
 <br>
   <b class="Estilo57"> Modificaci&oacute;n de Contrase&ntilde;a </b>
 <br>
 <br>

<?php
  if ($error==1)
  {
        echo "<center>Contrase�a Actual No Valida</center><br>";
  }
  else
  {
        if ($error==2)
        {
                echo "<center>Contrase&ntilde;as Nuevas No Coinciden</center><br>";
        }
  }

?>
<form method="post">
<TABLE WIDTH="40%" BORDER="0" CELLSPACING="1" CELLPADDING="0" HEIGHT="10" ALIGN="center">
  <tr class="border_tr3">
    <td width="20%"><P class="parrafo_normal"><SPAN class="fuente_normal"><b>Contrase&ntilde;a Actual: </td>
    <td width="30%"><label>
      <input name="actual" type="password" id="actual">
      <input name="codigo_aux_a" type="hidden" value="<?php echo $codigo_aux_a;?>">
    </label></td>
  </tr>
  <tr class="border_tr3">
    <td><P class="parrafo_normal"><SPAN class="fuente_normal"><b>Nueva Contrase&ntilde;a: </td>
    <td><input name="nueva" type="password" id="nueva"></td>
  </tr>
  <tr class="border_tr3">
    <td><P class="parrafo_normal"><SPAN class="fuente_normal"><b>Repetir Nueva Contrase&ntilde;a </td>
    <td><input name="renueva" type="password" id="renueva"></td>
  </tr>
  <tr class="border_tr3">
    <td colspan="2" align="center">
	<br>
	<label>
      <input style="font-size:10px; color:blue;" name="enviar" type="submit" id="enviar" value="Enviar">
      <input style="font-size:10px; color:blue;" name="cancelar" type="submit" id="cancelar" value="Cancelar">
    </label></td>
    </tr>
</table>
</form>
</div>
<?php
include("final.php");
?>

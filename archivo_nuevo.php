<?php
include("filtro_adm.php");
?>
<?php
include("inicio.php");
?>
<?php
include("conecta.php");
include("sicor/script/functions.inc");
$gestion = strftime("%Y");
$error = 0;
$cod_institucion = $_SESSION["institucion"];
if (isset($_POST['enviar']))
 {
  $_POST['tipo_codigo'] = trim($_POST['tipo_codigo']);
  $valor1=val_alfanum($_POST['tipo_codigo']);
  if($valor1 == 0)
  {
  	 $error = 1;
	 $tipo_doc = 1;
   }

  $valor1=val_alfanum($_POST['descripcion']);
  if($valor1 == 0)
  {
	 $error = 2;
	 $descri = 1;
   }


  if ($error == 0)
   {

       if($_POST[via] == 'via')
      {
          $via=1;
      }
      else
      {
           $via=0;
      }

        if($_POST[para] == 'para')
      {
          $para=1;
      }
      else
      {
           $para=0;
      }

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
       $ssql = "INSERT INTO  documentos (documentos_sigla, documentos_descripcion, documentos_via, documentos_para)
	VALUES (UCASE('$_POST[tipo_codigo]'), UCASE('$_POST[descripcion]'),'$via','$para')";
	mysql_query($ssql, $conn);
	
?>
    <script language="JavaScript">
        window.self.location="archivo.php";
    </script>
<?php	
   }
} 

if(isset($_POST['cancelar']))
{
?>
    <script language="JavaScript">
        window.self.location="archivo.php";
    </script>
<?php
}
?>
<br />
<?php if ($error == 0)
{
    echo "<p><div class=\"fuente_titulo\" align=\"center\"><b>NUEVO DOCUMENTO</b></div></p>";
} else 
{   echo "<p><div class=\"fuente_normal_rojo\" align=\"center\"><b>VERIFICAR DATOS</b></div></p>";
}
?>
<center>
<table width="20%" cellspacing="2" cellpadding="2" border="0">
<form  method="POST" name="documento">

<tr class="border_tr3"><td><span class="fuente_normal">Codigo</span></td>
<td><input type="text" name="tipo_codigo" value="<?php echo $_POST["tipo_codigo"];?>"  size="5" />
<?php if ($tipo_doc == 1) {
    echo "<img src=\"images/eliminar.gif\" border=0>";
   }?>
</td></tr>

<tr class="border_tr3"><td><span class="fuente_normal">Descripcion</span></td>
<td><input type="text" name="descripcion" value="<?php echo $_POST["descripcion"];?>" maxlength="50" size="20" />
<?php if ($descri == 1) 
{
    echo "<img src=\"images/eliminar.gif\" border=0>";
}
?>
</td>
</tr>
<tr class="border_tr3"><td><span class="fuente_normal">Atributos</span></td>
<td>
    VIA <input type="checkbox" name="via" value="via" <?php if($_POST[via] =='via'){echo "checked";} ?>> <br />
    PARA multiple<input type="checkbox" name="para" value="para" <?if($_POST[para] =='para'){echo "checked";} ?>
</td>
</tr>

<tr>
<td align="center" colspan="2">
	<input type="submit" name="enviar" value="Aceptar" class="boton" />
	<input type="submit" name="cancelar" value="Cancelar" class="boton" />
</td>
</tr>
</form>
</table>
</center>
<br>
<?php
include("final.php");
?>
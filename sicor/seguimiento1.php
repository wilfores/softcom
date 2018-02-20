<?php
include("../filtro.php");
?>
<?php
include("inicio.php");
?>
<?php
include("../conecta.php");
include("cifrar.php");
include("script/functions.inc");
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
<script>
<!--
function Retornar(){
  document.buscar.action="principal.php";
  document.buscar.submit();
}
-->
</script>
<br />
<p class="fuente_titulo"><span class="fuente_normal">
<center><b>BUSCAR ARCHIVOS</b></center>
<br />
<center>
<form name="buscar" method="POST" action="encuentra1.php">
<table width="75%" cellspacing="2" cellpadding="2" border="0">
<tr class="border_tr3"><td> &nbsp;&nbsp; <b>Buscar</b> &nbsp;&nbsp;</td>
<td>&nbsp;&nbsp; <input type="text" name="busqueda" size="25" /> &nbsp;&nbsp;</td>
<td>&nbsp;&nbsp;POR : 
<select name="clase" class="caja_texto">
    <option value="Referencia" selected="selected">
            REFERENCIA
    </option>
<?php
            $ssql="SELECT * FROM documentos";
            $rss = mysql_query($ssql,$conn);
            while($row=mysql_fetch_array($rss))
             {
                 if ($_POST['clase']==$row["documentos_id"])
                  {
    ?>
             <option value="<?php echo $row["documentos_id"];?>" selected="selected">
                    <?php
                        echo $row["documentos_descripcion"];
                    ?>
             </option>
<?php
                  }
                  else
                  {
                  ?>
                      <option value="<?php echo $row["documentos_id"];?>">
                          <?php
                          echo $row["documentos_descripcion"];
                          ?>
                      </option>
                  <?php
                  }
            }
?>
</select>	
&nbsp;&nbsp;
</td>
</tr>
<tr><td align="center" colspan="3">
<br />
<input type="submit" name="buscar" value="Buscar" class="boton"/>
</table>
</form>
<br /><br />
<a href="menu.php" class="enlace_normal">[Volver]</a>
</center>
<br />
<?php
include("final.php");
?>
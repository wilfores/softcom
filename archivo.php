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
$ssql = "SELECT * FROM documentos order by(documentos_descripcion)";
$rss = mysql_query($ssql,$conn);
?>
<?php
if(isset($_POST['adicionar']))
{
?>
<script language="javascript">
window.self.location="archivo_nuevo.php";
</script>
<?php
}

if (isset($_POST['eliminar']))
{
$var=$_POST['sel_corresp'];
$elementos = count($var);
for($i=0; $i< $elementos; $i++){
mysql_query("DELETE FROM documentos WHERE documentos_id='$var[$i]'",$conn); 
}
?>
<script language="javascript">
window.self.location="archivo.php";
</script>
<?php
}

if (isset($_POST['cancelar']))
{
?>
<script language="javascript">
window.self.location="menu.php";
</script>
<?php
}
?>
<br>
<center>
<table border="0" cellpadding="2" cellspacing="2" width="50%" style="font-size:9px">
<form method="POST" name="archivo">
<tr>
    <td bgcolor="#3E6BA3" align="center" width="5%" style="color:#FFFFFF; font-size:11">*</td>
    <td bgcolor="#3E6BA3" align="center" width="10%" style="color:#FFFFFF; font-size:11">SIGLA</td>
    <td bgcolor="#3E6BA3" align="center" width="30%" style="color:#FFFFFF; font-size:11">TIPO DOCUMENTO</td>
    <!--<td bgcolor="#3E6BA3" align="center" width="40%" colspan="2" style="color:#FFFFFF; font-size:11">ATRIBUTOS</td>-->
	

</tr>
<?php
while($row=mysql_fetch_array($rss))
{
	     if ($resaltador==0)
		  {
			   echo "<tr class=trdos>";
			   $resaltador=1;
		  }
		  else
		  {
			   echo "<tr class=truno>";
			   $resaltador=0;
		  }

        if($row["documentos_via"]==1)
        {
            $valor_uno = "VIA: Habilitado";
        }
        else
        {
            $valor_uno = "";
        }

        if($row["documentos_para"]==1)
        {
            $valor_dos = "PARA: Multiple Habilitado";
        }
         else
        {
            $valor_dos = "";
        }


        echo "<td class=\"border_tr\"><input type=\"checkbox\" name=\"sel_corresp[]\" value=".$row["documentos_id"]."></td>";
	echo "<td class=\"border_tr\">".$row["documentos_sigla"]."</td>";
	echo "<td class=\"border_tr\" align='left'>".$row["documentos_descripcion"]."</td>";
        //echo "<td class=\"border_tr\">".$valor_uno."</td>";
        //echo "<td class=\"border_tr\">".$valor_dos."</td>";
	echo "</tr>";
} // while
?>
<tr>
    <td colspan="5" align="center">
        <br />
        <input type="submit" name="adicionar" value="Adicionar" class="boton"  />
        &nbsp;<input type="submit" name="eliminar" value="Eliminar" class="boton" />
        &nbsp;<input type="submit" name="cancelar" value="Cancelar" class="boton" />
        </td>
</tr>
</table>
</form>
</center>
<?php
include("final.php");
?>
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
$error=0;
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
if(isset($_POST['aceptar']))
{ 
	if(empty($_POST['nota']))
	{
	  $error=2;
		 
	}
	
	if ($error==0)
	{
	    $valor_enviado = cifrar($_POST[nota]);
	?>
	<script language="JavaScript">
		window.self.location="pinforme.php?sel=<?php echo $valor_enviado;?>";
	</script>
	<?php 
	}
}

if(isset($_POST['cancelar']))
{
	?>
				 <script language="JavaScript">
				   window.self.location="encuentra2.php";
				 </script>
	 <?php 
}
?>


<br>
<center>
<table  width="50%"cellspacing="2" cellpadding="2" border="0">
<tr class="border_tr">
<td width="95%" align="center" >
<p align="center" class="fuente_menu" >SELECCIONE EL TIPO DE DOCUMENTO</p>
<?php
if ($error>0)
{
echo "<center><font size=2pt color=red>!!! ERROR DATOS NO SELECCIONADOS !!!</font></center>";
}
?>
      <form method="POST" name="impresion">
        <table cellspacing="2" cellpadding="2" border="2" class="border_tr3" style="font-size:7px">
        <tr>
            <td class="truno" class="border_tr3">
        <?php
		
		echo "$_SESSION[cargo_asignado]<br />";
		
        $consulta="SELECT * from documentocargo where documentocargo_cargo='$_SESSION[cargo_asignado]'";
        $conexion=mysql_query($consulta,$conn);
		if (mysql_num_rows($conexion) > 0)
		{
        while($fila=mysql_fetch_array($conexion))
        { 
        ?>
        <input type="radio" name="nota" value="<?php echo $fila["documentocargo_doc"];?>">
      
		<?php
		$valor_cargo=$fila["documentocargo_doc"];
		$conexion2 = mysql_query("SELECT * FROM documentos WHERE '$valor_cargo'=documentos_id",$conn);
			if($fila_cargo=mysql_fetch_array($conexion2))
			{
			echo $fila_cargo["documentos_descripcion"];
			}
	    ?>
        <?php
        echo "<br>";echo "<br>";
        }
		}
		else
		{
		echo "NO EXISTE NINGUN DOCUMENTO ASOCIADO A ESTE USUARIO";
		}
        ?>  
         
        </td>
        </tr>
        
        <tr>
            <td align="center">
            <input type="submit" name="aceptar" value="Aceptar" class="boton"/>
            <input type="submit" name="cancelar" value="Cancelar" class="boton"/>
            </td>
        </tr>
        </table>
        </form>
</td>
</tr>
</table>
<?php
include("../final.php");
?>
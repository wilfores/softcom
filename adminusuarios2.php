<?php
include("filtro.php");
include("conecta.php");
include("sicor/script/functions.inc");
include("sicor/script/cifrar.php");
?>
<?php
	 include("inicio.php");
?>
<?php
if (isset($_SESSION["adminvirtual"])) 
{
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
if ($_SESSION["adminvirtual"]=="adminvirtual") {
	$ssql="SELECT * FROM usuario where usuario_cod_nivel='2' order by usuario_cod_usr";    
}
else
{
    $ssql="SELECT * FROM usuario WHERE usuario_cod_nivel!='3' and usuario_cargo <> '' and usuario_cod_institucion='$_SESSION[institucion]' order by usuario_cod_usr";
}

$rss=mysql_query($ssql,$conn);
?>
<?php
if(isset($_POST['adicionar']))
{
		?>
			<script language='JavaScript'> 
				window.self.location="usuarionuevo.php"
			</script>
		<?php
}

$var=$_POST['cod_usuario'];
$sel_inst1=$var[0];
if(isset($_POST['modificar']) and isset($sel_inst1))
{
		?>
			<script language='JavaScript'> 
				window.self.location="usuarioeditar.php?sel_usuario=<?php echo encryto($var[0]);?>"
			</script>
		<?php
}

$var=$_POST['cod_usuario'];
$sel_inst1=$var[0];
if(isset($_POST['liberar']) and isset($sel_inst1))
{
		?>
			<script language='JavaScript'> 
				window.self.location="liberarusuario.php?sel_usuario=<?php echo encryto($var[0]);?>"
			</script>
		<?php
}


if(isset($_POST['eliminar']))
{
$var2=$_POST['cod_usuario'];
$elementos = count($var2);
for($i=0; $i< $elementos; $i++)
{
   $ssqlm = "SELECT * FROM usuario WHERE '$var2[$i]'=usuario_cod_usr";
	$rssm = mysql_query($ssqlm, $conn);
	if (mysql_num_rows($rssm)>0)
	{ 
		if($rowm=mysql_fetch_array($rssm))
		{
		$ocupacion=$rowm["usuario_ocupacion"];
	mysql_query("UPDATE miderivacion SET miderivacion_estado='0' WHERE miderivacion_su_codigo='$ocupacion'",$conn) or die("No se Guardo el Registro");	
	mysql_query("UPDATE asignar SET asignar_estado='0' WHERE asignar_su_codigo='$ocupacion'",$conn) or die("No se Guardo el Registro");	
	    }
	}
   mysql_query("DELETE FROM usuario WHERE usuario_cod_usr='$var2[$i]'",$conn) or die("El Registro no Existe");
 	
} 
		?>
			<script language='JavaScript'> 
				window.self.location="adminusuarios.php"
			</script>
		<?php
}
?>
<center>
<TABLE WIDTH="75%" BORDER="0" CELLSPACING="2" CELLPADDING="0" class="parrafo_general">
  <TR>
    <TD HEIGHT="10" COLSPAN="3">
	<B><SPAN class="fuente_normal"><CENTER>ADMINISTRACION DE USUARIOS DE LAS INSTITUCIONES
	</CENTER><BR></B>
    </TD> 
  </TR>
  
  <TR>
    <TD HEIGHT="10" COLSPAN="3" bgcolor="#eeeeee" align="center">
	<P class="parrafo_titulo"><SPAN class="fuente_normal"><B>LISTA DE USUARIOS</B><BR>
    </TD> 
  </TR>

  <TR>
    <TD COLSPAN="3" bgcolor="#d3daed" align="top">
    
<form name="lista" method="POST">
<TABLE width="100%" BORDER="0" CELLSPACING="2" CELLPADDING="0">
  <tr>
    <td width="3%" bgcolor="#eeeeee" align="center"><CENTER>*</CENTER></td> 
    <td width="5%" bgcolor="#eeeeee"><span class="fuente_normal"><b><center>C&Oacute;DIGO</center></b></td>
	<td width="15%" bgcolor="#eeeeee"><span class="fuente_normal"><B><CENTER>NOMBRE Y APELLIDO</CENTER></B></td> 
    <td width="12%" bgcolor="#eeeeee"><span class="fuente_normal"><B><CENTER>CI</CENTER></B></td>     
    <td width="20%" bgcolor="#eeeeee"><span class="fuente_normal"><B><CENTER>CARGO</CENTER></B></td>
	<td width="15%" bgcolor="#eeeeee"><span class="fuente_normal"><B><CENTER>UNIDAD</CENTER></B></td> 
	<!--<td width="15%" bgcolor="#eeeeee"><span class="fuente_normal"><B><CENTER>CORREO ELECTR&Oacute;NICO</CENTER></B></td> -->
	 </TR>
</TABLE> 

<div style="overflow:auto; width:100%; height:300px; ">

<TABLE width="100%" BORDER="0" CELLSPACING="0" CELLPADDING="0">
<?php
$resaltador=0;
if (!empty($rss))
{
while($row = mysql_fetch_array($rss)) 
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
?>
    <td width="3%" align="center">
	<input type="checkbox" value="<?php echo $row["usuario_cod_usr"];?>" name="cod_usuario[]">
	</td>
    
    <td width="5%" align="center">
    <P class="parrafo_normal"><span class="fuente_normal">
	<?php echo $row["usuario_cod_usr"];?>
	</td> 
    
    <td width="15%">
    <P class="parrafo_normal"><span class="fuente_normal">
	<?php echo $row["usuario_nombre"];?>	
	</td>
    
    <td width="12%">
    <P class="parrafo_normal"><span class="fuente_normal">
	<?php echo $row["usuario_carnet"];echo " ".$row["usuario_carnet_ciudad"];?>	
	</td>
    
       <td width="20%">
    <P class="parrafo_normal"><span class="fuente_normal">
		
	<?php
if ($_SESSION["adminvirtual"]=="adminvirtual")
{
echo "Administrador del Sistema";
}	  
else
{		$valor_clave=$row["usuario_ocupacion"];
		if($valor_clave=='0')
		{
			echo "<span class=fuente_alerta> USUARIO LIBERADO</span>";
		}
		else
		{
			//$conexion = mysql_query("SELECT * FROM cargos WHERE '$valor_clave'=cargos_id",$conn);
			$conexion = mysql_query("SELECT * FROM cargos, departamento WHERE '$valor_clave'=cargos_id and cargos_cod_depto=departamento_cod_departamento ORDER BY departamento_descripcion_dep",$conn);
			if($fila_clave=mysql_fetch_array($conexion))
			{
			echo $fila_clave["cargos_cargo"];
			}
		?>
		</td>
		<td width="15%" align="center">
		<?php 
			echo $fila_clave["departamento_descripcion_dep"];
		}
		

}	
	?>
	
   <!-- <P class="parrafo_normal"><span class="fuente_normal">-->
	<?php //echo $row["usuario_username"];?>
	</td>
	<!--
	<td width="15%">
    <P class="parrafo_normal"><span class="fuente_normal">
	<?php echo $row["usuario_email"];?>
	</td> 
	-->
 </TR>
<?php
} // fin while  

} // fin empty
mysql_close($conn);
?>
</TABLE>
</div>
</CENTER>

<TABLE width="95%" BORDER="0" CELLSPACING="2" CELLPADDING="0">
<TR>
	<td align="center">
<?php
if($_SESSION["nivel"]=='3')
{
?>
	
	<input class="boton" type="submit" value="Adicionar" name="adicionar" >
	
<?php 
}
else
{
?>
	<input class="boton" type="submit" value="Adicionar" name="adicionar" >
	<input class="boton" type="submit" value="Modificar" name="modificar" >
   	<input class="boton" type="submit" value="Liberar" name="liberar" onclick="return window.confirm('Est&aacute; Seguro(a) de LIBERAR &eacute;ste Registro?')">
	<input class="boton" type="submit" value="Eliminar" name="eliminar" onclick="return window.confirm('Est&aacute; Seguro(a) de ELIMINAR &eacute;ste Registro?')">

<?php
}
?>	
    </td>
</TR>
</TABLE>
</FORM>
<?php
}
include("final.php");
?>

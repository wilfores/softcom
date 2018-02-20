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
$ssql="SELECT * FROM cargos 
       WHERE cargos_cod_institucion='$institucion'
       AND cargos_id <>'$codigo'
       ORDER BY cargos_cod_depto";

$ssqll="SELECT * FROM miderivacion WHERE miderivacion_mi_codigo='$codigo'";

if (isset($_POST['enviar']))
{
$var=$_POST['cod_usuario'];
$elementos = count($var);
	for($i=0; $i < $elementos; $i++)
	{
	$respu=mysql_query("select * from miderivacion where miderivacion_mi_codigo='$codigo'and miderivacion_su_codigo='$var[$i]'",$conn);
	$Lista=mysql_fetch_row($respu);
	if($Lista[0])
	{
		echo " ";
	}
	else
	{
	$compro=mysql_query("select * from usuario where usuario_ocupacion='$var[$i]' and usuario_active='1'",$conn);
	if (mysql_num_rows($compro) > 0)
	{	
    mysql_query("insert into miderivacion (miderivacion_mi_codigo,miderivacion_su_codigo,miderivacion_estado)values('$codigo','$var[$i]','1')",$conn) or die("El Registro no Existe");
	}
	else
	{
	    mysql_query("insert into miderivacion (miderivacion_mi_codigo,miderivacion_su_codigo,miderivacion_estado)values('$codigo','$var[$i]','0')",$conn) or die("El Registro no Existe");
	}
	}
   } //end for

?>
	<script>
     window.self.location="usuarioderivacion_1.php";
    </script>
<?php
}//fin enviar


 if (isset($_POST['regresar']))
 {  $var=$_POST['cod_usuario'];
	$elementos = count($var);
	for($i=0; $i < $elementos; $i++)
	{
	mysql_query("delete from miderivacion where miderivacion_mi_codigo='$codigo'and miderivacion_su_codigo='$var[$i]'",$conn) or die("El Registro no Existe");
	}
	?>
	<script>
			window.self.location="usuarioderivacion_1.php";
	</script>
	<?php
  }//fin regresar
?>
<B><P class="fuente_titulo_principal"><span class="fuente_normal">
<CENTER>ASIGNAR CORRESPONDENCIA SEG&Uacute;N CARGOS
</CENTER></B>
<div align="center" class="fuente_normal">
<?php
 $valor_clave=$_SESSION["codigo_miderivacion"];
	$conexion = mysql_query("SELECT * FROM cargos WHERE '$valor_clave'=cargos_id",$conn);
	if($fila_clave=mysql_fetch_array($conexion))
	{
		    $valor_clave1=$fila_clave["cargos_edificio"];
			$conexion1 = mysql_query("SELECT * FROM edificio WHERE '$valor_clave1'=edificio_cod_edificio",$conn);
			if($fila_clave1=mysql_fetch_array($conexion1))
			{
			echo "<strong>".strtoupper($fila_clave1["edificio_descripcion_ed"]);echo "</strong><br>";
			}		

		    $valor_clave2=$fila_clave["cargos_cod_depto"];
			$conexion2 = mysql_query("SELECT * FROM departamento WHERE '$valor_clave2'=departamento_cod_departamento",$conn);
			if($fila_clave2=mysql_fetch_array($conexion2))
			{
		    echo "<strong>UNIDAD: ".strtoupper($fila_clave2["departamento_descripcion_dep"]);echo "</strong><br>";
			}			
			echo "<strong>CARGO:  ".strtoupper($fila_clave["cargos_cargo"]);echo "</strong><br>";
	}
?>
<br />
</div>
<center>
<?php
/**************************************************************************************************
                                          LISTADO TOTAL DE CARGOS SELECCIONADOS
**************************************************************************************************/
?>
<table border=1 width="60%">
<tr>
<td width="50%" align="left">
<center><span class="fuente_normal">LISTADO TOTAL DE CARGOS</span></center>
<form name="enviar" method="post">
<div style="overflow:auto; width:600; height:300px; align:left;">
<table boder=1>
<tr>
<td bgcolor="#3E6BA3"><center><input class="boton1" name="boton" type="reset" value="*" ></center></td> 
<td bgcolor="#3E6BA3" style="color:#FFFFFF; font-size:11"><span>CARGO</span></td>
<td bgcolor="#3E6BA3" style="color:#FFFFFF; font-size:11"><span>UNIDAD</span></td>
<td bgcolor="#3E6BA3" style="color:#FFFFFF; font-size:11"><span>FUNCIONARIO</span></td>
</tr>
<?php
$resulta=mysql_query($ssql,$conn); 
$resaltador=0;
while ($row=mysql_fetch_array($resulta))
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
<td>
<input type="checkbox" value="<?php echo $row["cargos_id"];?>" name="cod_usuario[]">
</td>
<?php
echo "<td><span class=fuente_normal>".$row["cargos_cargo"]."</span></td>";
$valor_clave=$row["cargos_cod_depto"];
$valor_clave1=$row["cargos_id"];
$conexion = mysql_query("SELECT * FROM departamento WHERE '$valor_clave'=departamento_cod_departamento and departamento_cod_institucion='$institucion'",$conn);
	if($fila_clave=mysql_fetch_array($conexion))
	{
	echo "<td><span class=fuente_normal>".$fila_clave["departamento_descripcion_dep"]."</span></td>";
	        
			//$valor_clave1=$fila_clave["departamento_dependencia_dep"];
			//$conexion1 = mysql_query("SELECT departamento_descripcion_dep FROM departamento WHERE '$valor_clave1'=departamento_dependencia_dep",$conn);
			$conexion1 = mysql_query("SELECT * FROM usuario WHERE '$valor_clave1'=usuario_ocupacion",$conn);
			if($fila_clave1=mysql_fetch_array($conexion1))
			{
			echo "<td><span class=fuente_normal>".$fila_clave1["usuario_nombre"]."</span></td>";
			}		
	}
}
?>
        
</table>
</div>
<center>
<input class="boton" type="submit" name="enviar" value="Adicionar">
<br />
<input class="boton" type="button"  value="Marcar Todo" onclick="javascript:seleccionar_todo()" >
<input class="boton" type="button"  value="Desmarcar Todo" onclick="javascript:deseleccionar_todo()" >
</center>
</form>
<?php
/**************************************************************************************************
                                          CARGOS SELECCIONADO
**************************************************************************************************/
?>

</td>
<td width="50%" align="left">
<center><span class="fuente_normal">CARGOS SELECCIONADOS</span></center>
<form name="regresar" method="post">
<div style="overflow:auto; width:600; height:300px; align:left;">
<table boder=1 width="100%" style="font-size:10px">
<tr>

<td bgcolor="#3E6BA3"><center><input class="boton1" name="boton" type="reset" value="*" ></center></td> 
<td bgcolor="#3E6BA3" style="color:#FFFFFF; font-size:11"><span>CARGO</span></td>
<td bgcolor="#3E6BA3" style="color:#FFFFFF; font-size:11"><span>UNIDAD</span></td>
<!--<td bgcolor="#3E6BA3" style="color:#FFFFFF; font-size:11"><span>DEPENDENCIA</span></td>-->

</tr>
<?php
$resaltador=0;
$resu=mysql_query($ssqll,$conn);// resulta=RS
while ($rows=mysql_fetch_array($resu))
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
<td>
<?php
if($rows["miderivacion_original"]=='1')
{
?>
 <input  type="checkbox" value="<?php echo $rows["miderivacion_su_codigo"];?>" name="cod_usuario[]" disabled="disabled">
 <?php
 }
 else
 {
 ?>
  <input  type="checkbox" value="<?php echo $rows["miderivacion_su_codigo"];?>" name="cod_usuario[]">
 <?php
 }
 ?>
</td>
<?php
$result=mysql_query("SELECT * FROM cargos,departamento where cargos.cargos_id='$rows[miderivacion_su_codigo]' and cargos.cargos_cod_depto=departamento.departamento_cod_departamento",$conn);

	if ($row=mysql_fetch_array($result))
	{
	$varia=$row["cargos_cargo"];
	$cargito=$row["departamento_descripcion_dep"];
	
	    $valor_clave1=$row["departamento_dependencia_dep"];
		$conexion1 = mysql_query("SELECT departamento_descripcion_dep FROM departamento WHERE '$valor_clave1'=departamento_dependencia_dep",$conn);
		if($fila_clave1=mysql_fetch_array($conexion1))
		{
		$edificio=$fila_clave1["departamento_descripcion_dep"];
		}		
	}
	
echo "<td > <span class=fuente_normal>".$varia."</span></td>";
echo "<td > <span class=fuente_normal>".$cargito."</span></td>";
//echo "<td > <span class=fuente_normal>".$edificio."</span></td>";
}
?>
</table>
</div>
<center>
<input class="boton" type="submit" name="regresar" value="Quitar">
<br />
<input class="boton" type="button"  value="Marcar Todo" onclick="javascript:seleccionar_todo2()" >
<input class="boton" type="button"  value="Desmarcar Todo" onclick="javascript:deseleccionar_todo2()" >
</center>
</form>


</td>
</tr>
</table>
<br>
<form method="get" action="usuarioderivacion.php">
<input type="submit" value="Cancelar" class="boton">
</form> 
<br>
</center>

<?php
include("final.php");
?>
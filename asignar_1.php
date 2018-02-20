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

// ENVIAR PARA
$codigo=$_SESSION["codigo_miderivacion"];
//echo "$codigo ";
$institucion=$_SESSION["institucion"];

$ssql="SELECT * from cargos where cargos_cod_institucion='$institucion' and cargos_id <>'$codigo' ORDER BY cargos_cod_depto";
$ssqll="SELECT * from asignar where asignar_mi_codigo='$codigo'";
$ssql2="SELECT * from via where via_mi_codigo='$codigo'";

if (isset($_POST['enviar']))
{

$var=$_POST['cod_usuario'];
$elementos = count($var);
	for($i=0; $i < $elementos; $i++)
	{
		$respu=mysql_query("select * from asignar where asignar_mi_codigo='$codigo'and asignar_su_codigo='$var[$i]'",$conn);
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
			mysql_query("insert into asignar (asignar_mi_codigo,asignar_su_codigo,asignar_estado)values('$codigo','$var[$i]','1')",$conn) or die("El Registro no Existe");
			}
			else
			{
			mysql_query("insert into asignar (asignar_mi_codigo,asignar_su_codigo,asignar_estado)values('$codigo','$var[$i]','0')",$conn) or die("El Registro no Existe");
			}
		
		}
   } //end for

?>
<script>
        window.self.location="asignar_1.php";
</script>
<?php
}//fin enviar

// ENVIAR VIA
if (isset($_POST['enviar2']))
{ 

	$var=$_POST['cod_usuario2'];
	$elementos = count($var);
	echo "$elementos<br>";
	$j=0;
	for($i=0; $i < $elementos; $i++)
	{ $j=$i+1;
	$respu=mysql_query("select * from via where via_mi_codigo='$codigo'and via_su_codigo='$var[$i]'",$conn);
	$Lista=mysql_fetch_row($respu);
		if($Lista[0])
		{
			echo " $Lista[0]";
		}
		else
		{
			$compro=mysql_query("select * from usuario where usuario_ocupacion='$var[$i]' and usuario_active='1'",$conn);
			if (mysql_num_rows($compro) > 0)
			{
				echo "$codigo<br/>";
				echo "$var[$i]<br/>";
			mysql_query("insert into via (via_mi_codigo,via_su_codigo,via_orden)values('$codigo','$var[$i]','$j')",$conn) or die("El Registro no Existe 1");
			
			}
			else
			{
			mysql_query("insert into via (via_mi_codigo,via_su_codigo,via_orden)values('$codigo','$var[$i]','0')",$conn) or die("El Registro no Existe 2");
			
			}		
		}
   } //end for
    mysql_query("UPDATE via SET via_original='0' WHERE '$codigo'=via_mi_codigo",$conn) or die("El Registro no Existe");
	$_SESSION["ctrolvia"]=0;
?>
<script>
        window.self.location="asignar_1.php";
</script>
<?php
}//fin enviar

// REGISTRAR PARA
 if (isset($_POST['regresar']))
 { 
    $var=$_POST['cod_usuario'];
	$elementos = count($var);
	for($i=0; $i < $elementos; $i++)
	{
	mysql_query("delete from asignar where asignar_mi_codigo='$codigo'and asignar_su_codigo='$var[$i]'",$conn) or die("El Registro no Existe");
	}
	?>
	<script>
			window.self.location="asignar_1.php";
	</script>
	<?php
    
  }//fin regresar
//REGRESAR VIA

 if (isset($_POST['regresar2']))
 {  $var=$_POST['cod_usuario2'];
	$elementos = count($var);
	for($i=0; $i < $elementos; $i++)
	{
	mysql_query("delete from via where via_mi_codigo='$codigo'and via_su_codigo='$var[$i]'",$conn) or die("El Registro no Existe");
	}
	mysql_query("UPDATE via SET via_original='0' WHERE '$codigo'=via_mi_codigo",$conn) or die("El Registro no Existe");	
	$_SESSION["ctrolvia"]=0;
	?>
	<script>
			window.self.location="asignar_1.php";
	</script>
	<?php
  }//fin regresar
  
?>
	<style type="text/css">
<!--
.Estilo1 {
	color: #FF0000;
	font-weight: bold;
}
-->
    </style>
<B><P class="fuente_titulo_principal"><span class="fuente_normal">
<CENTER> SELECCION DE CARGOS A LAS QUE PUEDE ASIGNAR ARCHIVOS
</CENTER></B><br />
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
		    echo "<strong>UNIDAD:  ".strtoupper($fila_clave2["departamento_descripcion_dep"]);echo "</strong><br>";
			}			
			echo "<strong>CARGO:  ".strtoupper($fila_clave["cargos_cargo"]);echo "</strong><br>";
	}
?>
</div>
<BR>
<center>
<table border=1 width="80%">
<tr>
  <td height="23" colspan="2" align="center" valign="top"><span class="fuente_titulo_principal">PARA</span></td>
  </tr>
<tr>
<td width="50%" height="200" align="left" valign="top">
<center><span class="fuente_normal">LISTADO TOTAL DE CARGOS</span>
</center>
<?php
$resulta=mysql_query($ssql,$conn); // resulta=RS
?>

<form name="enviar" method="post">
<div style="overflow:auto; width:500; height:150px; align:left;">
<table boder=1>
<tr>
<td bgcolor="#3E6BA3"><center><input class="boton1" name="boton" type="reset" value="*" ></center></td> 
<td bgcolor="#3E6BA3" style="color:#FFFFFF; font-size:11"><span>CARGO</span></td>
<td bgcolor="#3E6BA3" style="color:#FFFFFF; font-size:11"><span>UNIDAD</span></td>
<td bgcolor="#3E6BA3" style="color:#FFFFFF; font-size:11"><span>FUNCIONARIO</span></td>
</tr>
<?php
$resaltador=0;
while ($row=mysql_fetch_array($resulta))
{
		  if ($resaltador==0)
			  {
				   /*echo "<tr class=trdos>";*/
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
<input type="checkbox" value="<?php echo $row["cargos_id"];?>" name="cod_usuario[]"></td>
<?php
echo "<td ><span class=fuente_normal>".$row["cargos_cargo"]."</span></td>";
$valor_clave=$row["cargos_cod_depto"];
$valor_clave1=$row["cargos_id"];
$conexion = mysql_query("SELECT * FROM departamento WHERE '$valor_clave'=departamento_cod_departamento and departamento_cod_institucion='$institucion'",$conn);
	if($fila_clave=mysql_fetch_array($conexion))
	{
	echo "<td><span class=fuente_normal>".$fila_clave["departamento_descripcion_dep"]."</span></td>";
	        
			//$valor_clave1=$fila_clave["departamento_cod_edificio"];
			//$conexion1 = mysql_query("SELECT * FROM edificio WHERE '$valor_clave1'=edificio_cod_edificio",$conn);
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
                                          PERSONAL SELECCIONADO
**************************************************************************************************/
?></td>
<td width="50%" align="left" valign="top">
<center><span class="fuente_normal">CARGOS SELECCIONADOS</span>
</center>
<form name="regresar" method="post">
<div style="overflow:auto; width:500; height:150px; align:left;">
<table boder=1 width="100%">
<tr>
<td bgcolor="#3E6BA3"><center><input class="boton1" name="boton" type="reset" value="*" ></center></td> 
<td bgcolor="#3E6BA3" style="color:#FFFFFF; font-size:11"><span>CARGO</span></td>
<td bgcolor="#3E6BA3" style="color:#FFFFFF; font-size:11"><span>UNIDAD</span></td>
<td bgcolor="#3E6BA3" style="color:#FFFFFF; font-size:11"><span>DEPENDENCIA</span></td>
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
if($rows["asignar_original"]=='1')
{
?>
 <input  type="checkbox" value="<?php echo $rows["asignar_su_codigo"];?>" name="cod_usuario[]" >

 <?php
 }
 else
 {
 ?>
 <input  type="checkbox" value="<?php echo $rows["asignar_su_codigo"];?>" name="cod_usuario[]">

 <?php
 }
 ?></td>
<?php
$result=mysql_query("SELECT * FROM cargos,departamento where cargos.cargos_id='$rows[asignar_su_codigo]' and cargos.cargos_cod_depto=departamento.departamento_cod_departamento",$conn);

	if ($row=mysql_fetch_array($result))
	{
	$varia=$row["cargos_cargo"];
	$cargito=$row["departamento_descripcion_dep"];
	    $valor_clave1=$row["cargos_edificio"];
		$conexion1 = mysql_query("SELECT * FROM edificio WHERE '$valor_clave1'=edificio_cod_edificio",$conn);
		if($fila_clave1=mysql_fetch_array($conexion1))
		{
		$edificio=$fila_clave1["edificio_sigla_ed"];
		}		
	}
	
echo "<td> <span class=fuente_normal>".$varia."</span></td>";
echo "<td> <span class=fuente_normal>".$cargito."</span></td>";
echo "<td> <span class=fuente_normal>".$edificio."</span></td>";
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
</form></td>
</tr>
</table>
<!------------------------------------------------------------------------------------------------------------------>
<!---------------------------------ASIGNA CARGOS PARA VIA----------------------------------------------------------->

<table border="1" width="80%">
  <tr>
    <td height="23" colspan="2" align="center" valign="top"><span class="fuente_titulo_principal">VIA</span></td>
  </tr>
  <tr>
    <td width="50%" height="200" align="left" valign="top"><center>
      <span class="fuente_normal">LISTADO TOTAL DE CARGOS</span>
    </center>
        <?php
$resulta=mysql_query($ssql,$conn); // resulta=RS
?>
        <form method="post" name="enviar2" id="enviar2">
          <div style="overflow:auto; width:500; height:150px; align:left;">
            <table boder="1">
              <tr>
				<td bgcolor="#3E6BA3"><center><input class="boton1" name="boton" type="reset" value="*" ></center></td> 
				<td bgcolor="#3E6BA3" style="color:#FFFFFF; font-size:11"><span>CARGO</span></td>
				<td bgcolor="#3E6BA3" style="color:#FFFFFF; font-size:11"><span>UNIDAD</span></td>
				<td bgcolor="#3E6BA3" style="color:#FFFFFF; font-size:11"><span>DEPENDENCIA</span></td>
              </tr>
              <?php
			$rvec=mysql_query("SELECT * FROM cargos",$conn);		  
			$resaltador=0;
			while ($rowvec=mysql_fetch_array($rvec))
			{	
				$rcarg=mysql_query("SELECT cargos_id, cargos_dependencia, cargos_cargo,cargos_cod_depto FROM cargos WHERE cargos_id='$codigo'",$conn);
				$rowcarg=mysql_fetch_array($rcarg);
				if($rowcarg[1] != 0)
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
					<td><input type="checkbox" value="<?php echo $rowcarg[1];?>" name="cod_usuario2[]" /></td>					
					<?php
					$rcardep=mysql_query("SELECT cargos_cargo FROM cargos WHERE cargos_id='$rowcarg[1]'",$conn);
					$rowcardep=mysql_fetch_array($rcardep);
					echo "<td ><span class=fuente_normal>".$rowcardep[0]."</span></td>";
					$valor_clave=$row["cargos_cod_depto"];
					$conexion = mysql_query("SELECT * FROM departamento WHERE '$rowcarg[3]'=departamento_cod_departamento and departamento_cod_institucion='$institucion'",$conn);
						if($fila_clave=mysql_fetch_array($conexion))
						{
						echo "<td><span class=fuente_normal>".$fila_clave["departamento_descripcion_dep"]."</span></td>";
								
								$valor_clave1=$fila_clave["departamento_cod_edificio"];
								$conexion1 = mysql_query("SELECT * FROM edificio WHERE '$valor_clave1'=edificio_cod_edificio",$conn);
								if($fila_clave1=mysql_fetch_array($conexion1))
								{
								echo "<td><span class=fuente_normal>".$fila_clave1["edificio_sigla_ed"]."</span></td>";
								}		
						
						}
					$codigo=$rowcarg[1];
					}//end if	
				}//end de while
				?>
              </tr>
            </table>
          </div>
          <center>
            <input class="boton" type="submit" name="enviar2" value="Adicionar" />
			<br />
          	<input name="button" type="button" class="boton" onclick="javascript:seleccionar_todo_2()"  value="Marcar Todo">
          	<input name="button" type="button" class="boton" onclick="javascript:deseleccionar_todo_2()"  value="Desmarcar Todo">
           </center>
		</form>
      <?php
/**************************************************************************************************
                                          PERSONAL SELECCIONADO
**************************************************************************************************/
?></td>
    <td width="50%" align="left" valign="top"><center>
      <span class="fuente_normal">CARGOS SELECCIONADOS</span>
    </center>
        <form method="post" name="regresar2" id="regresar2">
          <div style="overflow:auto; width:500; height:150px; align:left;">
            <table boder="1" width="100%">
              <tr>
				<td bgcolor="#3E6BA3"><center><input class="boton1" name="boton" type="reset" value="*" ></center></td> 
				<td bgcolor="#3E6BA3" style="color:#FFFFFF; font-size:11"><span>CARGO</span></td>
				<td bgcolor="#3E6BA3" style="color:#FFFFFF; font-size:11"><span>UNIDAD</span></td>
				<td bgcolor="#3E6BA3" style="color:#FFFFFF; font-size:11"><span>DEPENDENCIA</span></td>
              </tr>
              <?php
$resaltador=0;
$resu=mysql_query($ssql2,$conn);// resulta=RS
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
              <tr>
                <td><?php
if($rows["via_original"]=='1')
{
?>
                    <input  type="checkbox" value="<?php echo $rows["via_su_codigo"];?>" name="cod_usuario2[]">
                    <?php
 }
 else
 {
 ?>
                    <input  type="checkbox" value="<?php echo $rows["via_su_codigo"];?>" name="cod_usuario2[]" />
                    <?php
 }
 ?></td>
                <?php
$result=mysql_query("SELECT * FROM cargos,departamento where cargos.cargos_id='$rows[via_su_codigo]' and cargos.cargos_cod_depto=departamento.departamento_cod_departamento",$conn);
	if ($row=mysql_fetch_array($result))
	{
	$varia=$row["cargos_cargo"];
	$cargito=$row["departamento_descripcion_dep"];
	    $valor_clave1=$row["cargos_edificio"];
		$conexion1 = mysql_query("SELECT * FROM edificio WHERE '$valor_clave1'=edificio_cod_edificio",$conn);
		if($fila_clave1=mysql_fetch_array($conexion1))
		{
		$edificio=$fila_clave1["edificio_sigla_ed"];
		}		
	}
	
echo "<td> <span class=fuente_normal>".$varia."</span></td>";
echo "<td> <span class=fuente_normal>".$cargito."</span></td>";
echo "<td> <span class=fuente_normal>".$edificio."</span></td>";
}
?>
              </tr>
            </table>
          </div>
          <center>
            <input class="boton" type="submit" name="regresar2" value="Quitar" />
			<br />
            <input name="button" type="button" class="boton" onclick="javascript:seleccionar_todo2_2()"  value="Marcar Todo">
            <input name="button" type="button" class="boton" onclick="javascript:deseleccionar_todo2_2()"  value="Desmarcar Todo">
      	  </center>
		</form>
	  </td>
  </tr>
</table>
<br>
<form method="get" action="asignar.php">
<input type="submit" value="Cancelar" class="boton">
</form> 
<br>
</center>
<?php
include("final.php");
?>		
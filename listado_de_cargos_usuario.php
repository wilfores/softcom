<?php
include("filtro.php");
?>
<?php
include("inicio.php");
include("sicor/script/functions.inc");
include("sicor/script/cifrar.php");
?>
<?php
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
<center>
<br>
<table>
<form method="post">
<tr class="truno">
<td align="center" bgcolor="#003399"><SPAN style="font-size:14px; color:#FFFFFF">UNIDAD DE DEPENDENCIA</td>
</tr>
<tr class="truno">
<td align="center">

<?php
//$resp=mysql_query("select * from departamento where departamento_cod_institucion='Ministerio de Salud y Deportes' and departamento_cod_edificio='7'",$conn);
$resp=mysql_query("select * from departamento order by departamento_descripcion_dep",$conn);
 if(mysql_num_rows($resp)>0)
 { 
 ?>
           <select name="depende" class="fuente_caja_texto">
            <option value="">Selecione un Departamento</option>
 <?php
              
				while ($rowcinco=mysql_fetch_array($resp))
					 {  
						if($_POST['depende']==$rowcinco["departamento_cod_departamento"])
							{
			?>
								<option value="<?php echo $rowcinco["departamento_cod_departamento"]?>" selected>
								<?php
									echo $rowcinco["departamento_descripcion_dep"];
								?>
								 </option>
         				   <?php 
					  	    }
						  else
							{
							?>
								<option value="<?php echo $rowcinco["departamento_cod_departamento"]?>">
							<?php
								echo $rowcinco["departamento_descripcion_dep"];
							?>
								</option>
					<?php
						    }
   					 } 

             		?>
			
<?php 
}
else
{
echo "<select name='depende' class='fuente_caja_texto'>";
echo "<option value=''>No Existen Datos</option>";
}
?>
</select>
</td>
</tr>
<tr>
<td colspan="2" align="center">
<input class="boton" type="submit" name="enviar" value="VER" >
</td>
</tr>
</form>
</table>
<?php 
if (isset($_POST['enviar']))
{
$depto_cod=$_POST['depende'];
//echo "$depto_cod";


?>

<table width="0" border="1" cellpadding="1" cellspacing="4">
  <tr>
    <td colspan="5">
	<table width="0" border="2" cellpadding="0" align="center">
	  <tr>
		<td style="font-size:12px; color:#FFFFFF" bgcolor="#333333">UNIDAD O DIRECCION</td>
		<td bgcolor="#003399" style="font-size:10px; color:#FFFFFF">
		<?php 	
	$uni=mysql_query("SELECT departamento_descripcion_dep, departamento_dependencia_dep FROM departamento WHERE departamento_cod_departamento='$depto_cod'",$conn);
	$r_un=mysql_fetch_array($uni);
	echo "$r_un[departamento_descripcion_dep]";
	?>
		</td>
	  </tr>
	  <tr>
		<td style="font-size:12px; color:#FFFFFF" bgcolor="#333333">DEPENDENCIA</td>
		<td bgcolor="#003399" style="font-size:10px; color:#FFFFFF">	
		<?php 	
	$dep=mysql_query("SELECT departamento_descripcion_dep FROM departamento WHERE departamento_cod_departamento='$r_un[departamento_dependencia_dep]'",$conn);
	$r_dep=mysql_fetch_array($dep);
	echo "$r_dep[departamento_descripcion_dep]";
	?>	</td>
	  </tr>
	</table>

	
	</td>
  </tr>
  
  <tr>
    <td colspan="5">&nbsp;</td>
  </tr>

  <tr style="font-size:12px; color:#FFFFFF" bgcolor="#003399">
    <td>NOMBRE DE USUARIO</td>
    <td>CARNET</td>
    <td>CARGO</td>
    <td>UNIDAD O DEPTO</td>
    <td>DEPENDENCIA</td>
  </tr>
<?php 
$resp1=mysql_query("select u.usuario_titulo, u.usuario_nombre, u.usuario_carnet, c1.cargos_cargo, d.departamento_descripcion_dep, c1.cargos_dependencia
from usuario u, cargos c1, departamento d
where d.departamento_cod_departamento='$depto_cod'
and c1.cargos_id=u.usuario_ocupacion
and c1.cargos_cod_depto=d.departamento_cod_departamento
and u.usuario_cod_nivel<>3 
and u.usuario_cod_nivel<>2
order by c1.cargos_dependencia, u.usuario_nombre, c1.cargos_cargo",$conn);
$resaltador=0;
while ($r_w=mysql_fetch_array($resp1))
	{ 
	
		if ($resaltador==0)
		 {
		  ?>
		  <tr style="color:#254D78; margin:4px; font-size:11px; background-color:#BCC9E0; padding:10px" bordercolor="#FFFFFF">
		   <?php
		   //<tr style=margin: 4px; border: 0px solid #cccccc; background-color:#BCC9E0; padding: 10px; font-size: 11px; color: #254D78; >
		   $resaltador=1;
		  }
		  else
		  {
		  ?>
		  <tr style="color:#254D78; margin:4px; font-size:11px; background-color:#ffffff; padding:10px" bordercolor="#FFFFFF">
		   <?php
		   //echo "<tr class=trdos2>";
		   $resaltador=0;
		  }
	?>	
  
    <td><?php echo "$r_w[0]  $r_w[1]";?></td>
    <td><?php echo "$r_w[2]";?></td>
    <td><?php echo "$r_w[3]";?></td>
    <td><?php echo "$r_w[4]";?></td>
    <td><?php 
	$re=mysql_query("SELECT cargos_cargo FROM cargos WHERE cargos_id='$r_w[5]'",$conn);
	$r_w2=mysql_fetch_array($re);
	echo "$r_w2[0]";?></td>
  </tr>
 <?php
 } 
 ?>
</table>
<?php 
}
?>
</center>
<?php
include("final.php");
?>

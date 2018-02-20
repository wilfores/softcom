<?php
include("../filtro.php");
?>
<link rel="stylesheet" type="text/css" href="script/estilos2.css" title="estilos2" />
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
$cod_institucion=$_SESSION["institucion"];
$cod_usr=$_SESSION["codigo"];
?>
<center>
<p class=fuente_titulo>LISTADO DE USUARIOS</p>
<table  border="0">
  <tr bgcolor="#eeeeee">
    <td class="fuente_subtitulo" align="center">&nbsp;&nbsp;<b>NOMBRE DEL FUNCIONARIO</b>&nbsp;&nbsp;</th>
    <td class="fuente_subtitulo" align="center">&nbsp;&nbsp;<b>CARGO</b>&nbsp;&nbsp;</th>
  </tr>
<?php
	$res=mysql_query("select * from usuario where usuario_cod_departamento='$unidad' order by usuario_nombre ASC",$conn);
		while  ($row=mysql_fetch_array($res))
			{
?>
	  <tr bgcolor="#EFEBE3">
    		<td>
			<?php
				$consul_dos=mysql_query("select * from departamento where departamento_cod_departamento='$unidad'",$conn);
				if($row_c=mysql_fetch_array($consul_dos))
				{
				$nombre_departamento=$row_c["departamento_descripcion_dep"];
				}
				$nombre_ent=$row["usuario_cod_usr"];
				$codigo_departamento=$unidad;
				$ocupacion_usuario=$row["usuario_ocupacion"];
				echo "<a href=\"#\" onclick=\"window.opener.document.enviar.departamento_remite.value='$nombre_departamento';window.opener.document.enviar.departamento_remite_di.value='$nombre_departamento';window.opener.document.enviar.cod_departamento.value='$unidad';window.opener.document.enviar.remitente.value='$nombre_ent';window.opener.document.enviar.remitente_di.value='$nombre_ent';window.opener.document.enviar.cargo_remitente.value='$ocupacion_usuario';window.opener.document.enviar.cargo_remitente_di.value='$ocupacion_usuario';self.close();\">";
				
				
					$valor_clave=$nombre_ent;
					$conexion = mysql_query("SELECT * FROM usuario WHERE '$valor_clave'=usuario_cod_usr",$conn);
					if($fila_clave=mysql_fetch_array($conexion))
					{
					echo "<span class=fuente_normal>".$fila_clave["usuario_nombre"]."</span>";
					}
			?>
			</td>
			 <td>
			<?php
			
					$valor_clave=$row["usuario_ocupacion"];
					$conexion = mysql_query("SELECT * FROM cargos WHERE '$valor_clave'=cargos_id",$conn);
					if($fila_clave=mysql_fetch_array($conexion))
					{
					echo "<span class=fuente_normal>".$fila_clave["cargos_cargo"]."</span>";
					}
			?>
			</td>
		 
	  </tr>
<?php
}
?>
</table>
<?php
include("final.php");
?>
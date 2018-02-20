<?php
include("filtro.php");
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

$consulta_a=mysql_query("SELECT * from usuario where usuario_cod_usr='$usuario'",$conn);
if($fila_b=mysql_fetch_array($consulta_a))
{
	if($fila_b["usuario_nombre"] =='$Nombre')
	{
		mysql_query("UPDATE usuario SET usuario_cod_departamento='$Cod_Departamento', usuario_titulo = '$Titulo' , usuario_cargo='$car_codigo' , usuario_carnet='$ci',usuario_carnet_ciudad='$ci_ciudad' WHERE  usuario_cod_usr= '$usuario'",$conn)
		 or die("No se Guardo el Registro");

		$result_uno=mysql_query("SELECT * FROM usuario,departamento where usuario.usuario_cod_usr='$usuario' and usuario.usuario_cod_departamento=departamento.departamento_cod_departamento",$conn);
		if ($row=mysql_fetch_array($result_uno))
		{
			$departamento_nombre=$row["departamento_descripcion_dep"];
		} 
			
	}
	else
	{
			mysql_query("UPDATE usuario SET usuario_cod_departamento='$Cod_Departamento', usuario_nombre = '$Nombre' , usuario_titulo = '$Titulo' , usuario_cargo='$car_codigo',usuario_carnet='$ci',usuario_carnet_ciudad='$ci_ciudad' WHERE  usuario_cod_usr= '$usuario'",$conn)
		 or die("No se Guardo el Registro");
		 
		$result_uno=mysql_query("SELECT * FROM usuario,departamento where usuario.usuario_cod_usr='$usuario' and usuario.usuario_cod_departamento=departamento.departamento_cod_departamento",$conn);
		if ($row=mysql_fetch_array($result_uno))
		{
			$departamento_nombre=$row["departamento_descripcion_dep"];
			$codigo_departamento_a=$row["departamento_cod_departamento"];
		} 
						
		?>
			<script>
				window.self.location="adminusuarios.php";
			</script>
		<?php
		 include("final.php");
	}
}
		?>
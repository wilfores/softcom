<?php 
include("../conecta.php");
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

$codigo=$_SESSION["cargo_asignado"];
$cod_usu=$_GET['hr1'];

/*
echo "$codigo<BR>";
echo "$cod_usu<BR>";
echo "$nomb<BR>";
echo "$cargo<BR>";
echo "$depto<BR>";
echo "esto se guardara en la tabla temporal";
*/
if($cod_usu=='todos')
{
	$stod=mysql_query("select usuario_ocupacion, usuario_nombre, usuario_carnet, cargos_cargo, departamento_descripcion_dep, cargos_cod_depto
	from usuario, cargos, departamento
	where 
	usuario_ocupacion=cargos_id
	and cargos_cod_depto=departamento_cod_departamento
	and usuario_cod_nivel<>3 
	and usuario_cod_nivel<>2
	and usuario_active=1
	order by departamento_descripcion_dep, usuario_nombre",$conn);
	
	while($row=mysql_fetch_array($stod))
	{
	
	mysql_query("INSERT INTO 
	temp1 (temp1_cod_mio,temp1_cod_para,temp1_nom,temp1_cargo,temp1_depto,temp1_x1,temp1_x2)
	VALUES ($codigo,$row[usuario_ocupacion],'$row[usuario_nombre]','$row[cargos_cargo]','$row[departamento_descripcion_dep]','$row[cargos_cod_depto]','0')",$conn);
	
	}		
	?>
	<script language="JavaScript">
        window.self.location="listado_usuarios.php";
    </script>
	<?
}
else{
		if($cod_usu=='gera')
		{ 
			$stod=mysql_query("select usuario_ocupacion, usuario_nombre, usuario_carnet, cargos_cargo, departamento_descripcion_dep, cargos_cod_depto
			from usuario, cargos, departamento
			where 
			usuario_ocupacion=cargos_id
			and cargos_cod_depto=departamento_cod_departamento
			and usuario_cod_nivel<>3 
			and usuario_cod_nivel<>2
			and cargos_dependencia=15
			and cargos_cod_depto<>9
			and usuario_active=1
			order by departamento_descripcion_dep, usuario_nombre",$conn);
			
			while($row=mysql_fetch_array($stod))
			{
			
			mysql_query("INSERT INTO 
			temp1 (temp1_cod_mio,temp1_cod_para,temp1_nom,temp1_cargo,temp1_depto,temp1_x1,temp1_x2)
			VALUES ($codigo,$row[usuario_ocupacion],'$row[usuario_nombre]','$row[cargos_cargo]','$row[departamento_descripcion_dep]','$row[cargos_cod_depto]','0')",$conn);
			
			}		
			?>
			<script language="JavaScript">
				window.self.location="listado_usuarios.php";
			</script>
			<?
		}
		else
		{ 
			$nomb=$_GET['val'];
			$cargo=$_GET['val1'];
			$depto=$_GET['val2'];
			$cod_depto1=$_GET['val3'];

			$ssql2 = "INSERT INTO 
		  	temp1 (temp1_cod_mio,temp1_cod_para,temp1_nom,temp1_cargo,temp1_depto,temp1_x1,temp1_x2)
		 	VALUES ($codigo,$cod_usu,'$nomb','$cargo','$depto','$cod_depto1','0')";
			mysql_query($ssql2,$conn);			
			?>
			<script language="JavaScript">
             	window.self.location="listado_usuarios.php";
            </script>
			<?			
		}
}
	  
?>
                



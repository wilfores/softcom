<?php
// include("JSON.php");
include("../filtro.php");
 include("script/functions.inc");
 require_once("JSON.php");
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

 $json = new Services_JSON;
 $datos = array();
if($_GET['action'] == 'listar')
{
	
	//$hru almacena el codigo del usuario (cargo_codigo)
	$hru   = $_GET['hru'];
	$cvalue="";
	$ccargo="";
	//*******************
	$ssql55_1 = "SELECT * FROM usuario where usuario_ocupacion='$hru' and usuario_active='1'";
	$rss55_1 = mysql_query($ssql55_1,$conn);  
	if (mysql_num_rows($rss55_1) > 0)
	{  
	  
			$ssql55 = "SELECT * FROM miderivacion where miderivacion_mi_codigo='$hru' and miderivacion_estado='1'";
			$rss55 = mysql_query($ssql55,$conn);
			while($row55=mysql_fetch_array($rss55))
			{	
				
				if ($_POST['destinatario']==$row55["miderivacion_su_codigo"])
				  { 
						//echo "<option value=".$row55["miderivacion_su_codigo"]." selected>";
		 			    $cvalue = $row55["miderivacion_su_codigo"];
						$valor_clave=$row55["miderivacion_su_codigo"];
						$conexion = mysql_query("SELECT * FROM cargos WHERE '$valor_clave'=cargos_id",$conn);
						if($fila_clave=mysql_fetch_array($conexion))
						{
							$valor_cargo=$fila_clave["cargos_id"];
							$conexion2 = mysql_query("SELECT * FROM usuario WHERE '$valor_cargo'=usuario_ocupacion",$conn);
							if($fila_cargo=mysql_fetch_array($conexion2))
							{
							//echo $fila_cargo["usuario_nombre"];
							   $ccargo = $fila_cargo["usuario_nombre"];
							}
							
				  			$datos[] = array(
								'value'  => $cvalue,
								'cargo'    => $ccargo
							);
						}
						
					//echo "</option>";
				  }
				else
				  {
						//echo "<option value=".$row55["miderivacion_su_codigo"].">";
						$cvalue =$row55["miderivacion_su_codigo"];
						$valor_clave=$row55["miderivacion_su_codigo"];
						$conexion = mysql_query("SELECT * FROM cargos WHERE '$valor_clave'=cargos_id",$conn);
						if($fila_clave=mysql_fetch_array($conexion))
						{
							$valor_cargo=$fila_clave["cargos_id"];
							$conexion2 = mysql_query("SELECT * FROM usuario WHERE '$valor_cargo'=usuario_ocupacion",$conn);
							if($fila_cargo=mysql_fetch_array($conexion2))
							{
								//echo $fila_cargo["usuario_nombre"];
								$ccargo =$fila_cargo["usuario_nombre"];
							}
							$datos[] = array(
								'value'  => $cvalue,
								'cargo'    => $ccargo
							);
			
						}		  
					//echo "</option>";
				   }
			}
	}
	//echo "-_-";
	echo $json->encode($datos);

}
 
?>

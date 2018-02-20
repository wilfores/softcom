<?php 
include("conecta.php");

//$conn = Conectarse();
//$usuario1 = strtolower($_POST['username']);
//echo "$usuario1";


//$gestion=mysql_real_escape_string($_POST['gestion']);
/*
$usuario=$_POST['username'];
$password=$_POST['clave'];
*/
$camb_gest=$_POST['camb_gest'];
$vancho=$_POST['ancho'];
$usuario=$_POST['username'];
$password=md5($_POST['clave']);

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


	$ssql = "SELECT * FROM usuario WHERE '$usuario'=usuario_username AND '$password'=usuario_password AND usuario_active='1'";
	$rs = mysql_query($ssql, $conn);
	if ($row = mysql_fetch_array($rs)) 
	{
		//if (md5($row["usuario_username"],$row["usuario_password"])== md5(strtolower($_POST['username']),$_POST['clave']))
		
		if(($row["usuario_username"]==$_POST['username']) && (md5($_POST['clave'])==$row["usuario_password"]))
		  {session_start();
		  
			$_SESSION["camb_gest"]=$camb_gest;
			$_SESSION["gestion"]=date("Y");
			$_SESSION["autentificado"]="SI";
			$_SESSION["username"]= $row["usuario_username"];
			$_SESSION["codigo"]=$row["usuario_cod_usr"];
			$_SESSION["institucion"]=$row["usuario_cod_institucion"];
			$_SESSION["password"]=$row["usuario_password"];	
			$_SESSION["nivel"]=$row["usuario_cod_nivel"];
			$_SESSION["departamento"]=$usu_depto=$row["usuario_cod_departamento"];		
			$_SESSION["cargo"]=$row["usuario_cargo"];
			$_SESSION["cargo_asignado"]=$row["usuario_ocupacion"];//PARA CARGO	
			$_SESSION["nivel_usr"]= $row["usuario_nivel_usuario"];	
			
			$_SESSION["dire"]= $row["usuario_nivel_usuario"];
			$_SESSION["nom"]= $row["usuario_nombre"];
			$_SESSION["carg"]= $row["usuario_nivel_usuario"];
			$_SESSION["nivel_usr"]= $row["usuario_nivel_usuario"];
			$_SESSION["wit"]=$vancho;
			$car_fun=$row["usuario_ocupacion"];
			
			
			echo "$ges";
			$ssql2= "SELECT * FROM cargos WHERE '$car_fun'=cargos_id";		
			$rs2 = mysql_query($ssql2, $conn);
			if ($rs2 = mysql_fetch_array($rs2)) 
			{ 
				$_SESSION["cargo_fun"]=$rs2["cargos_cargo"];
			}     
						  
			   if ($row["usuario_cod_nivel"]== 3) 
				{
					$_SESSION["adminvirtual"]="adminvirtual";
					?>
					<script language='JavaScript'> 
						window.self.location="menu.php"
					</script>
					<?php
					exit;
				}
				
				if ($row["usuario_cod_nivel"]== 2) 
				{
					$_SESSION["adminvirtual"]="adminlocal";
					?>
					<script language='JavaScript'> 
						window.self.location="menu.php"
					</script>
					<?php
					exit;
				}
				if($row["usuario_cod_nivel"]== 4)
				{
				$_SESSION["adminvirtual"]="adminlocal";
					?>
					<script language='JavaScript'> 
						window.self.location="menu4.php"
					</script>
					<?php
					exit;
				}
				?>
				
					<script language='JavaScript'> 
						//window.open("comunicado.html","_blank","menubar=no, location=no, resizable=no, width=750, height=700" );
						window.self.location="sicor/menucon.php"
					</script>
				
				<?php
				exit;
				}
				/*fin de la prueba de menu_min
				} */
				else
				{ //else 2
					header("Location:index.php?errorusuario=1");	
				} //fin if else 2   
	} 
	else 
	{
	//si no existe le mando otra vez a la portada
	header("Location:index.php?errorusuario=2");
	}

?>

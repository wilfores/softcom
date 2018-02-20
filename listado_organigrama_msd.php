<?php
include("filtro.php");
?>
<?php
include("inicio.php");
include("sicor/script/functions.inc");
include("sicor/script/cifrar.php");
?>
<table width="600" border="1" cellpadding="1" align="center">
  <tr style="font-size:11px">
    <td>
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

/*$ssql="SELECT * FROM departamento WHERE '$_SESSION[institucion]'=departamento_cod_institucion and departamento_cod_edificio='$_POST[edificito]' order by departamento_descripcion_dep ";*/
echo "MINISTERIO DE SALUD<br>";
$sql1="SELECT * FROM departamento WHERE departamento_dependencia_dep=9 AND departamento_cod_departamento!=9";
$rs1 = mysql_query($sql1, $conn);
while($rw1=mysql_fetch_array($rs1))
{
	echo "<font color=#0000FF>&nbsp;&nbsp;&nbsp;&nbsp;$rw1[departamento_descripcion_dep]<br>";
		$sql2="SELECT * FROM departamento WHERE departamento_dependencia_dep='$rw1[departamento_cod_departamento]'";
		$rs2 = mysql_query($sql2, $conn);
		while($rw2=mysql_fetch_array($rs2))
		{
			echo "<font color=#CC3333>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;$rw2[departamento_descripcion_dep]<br>";
				$sql3="SELECT * FROM departamento WHERE departamento_dependencia_dep='$rw2[departamento_cod_departamento]'";
				$rs3 = mysql_query($sql3, $conn);
				while($rw3=mysql_fetch_array($rs3))
				{
					echo "<font color=#FF9900>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;$rw3[departamento_descripcion_dep]<br>";
						$sql4="SELECT * FROM departamento WHERE departamento_dependencia_dep='$rw3[departamento_cod_departamento]'";
						$rs4 = mysql_query($sql4, $conn);
						while($rw4=mysql_fetch_array($rs4))
						{
							echo "<font color=#009933>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;$rw4[departamento_descripcion_dep]<br>";
								$sql5="SELECT * FROM departamento WHERE departamento_dependencia_dep='$rw4[departamento_cod_departamento]'";
								$rs5 = mysql_query($sql5, $conn);
								while($rw5=mysql_fetch_array($rs5))
								{
									echo "<font color=#009933>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;$rw5[departamento_descripcion_dep]<br>";
								
								}
							
						}	
				}
				
		}
}					
?>
	</td>
  </tr>
</table>
<?php
include("final.php");
?>


<?php
include("../filtro.php");
?>
<?php
include("inicio.php");
?>
<?php
include("script/functions.inc");
include("script/cifrar.php");
include("../conecta.php");

$cod_institucion=$_SESSION["institucion"];
$codigo_usuario=$_SESSION["codigo"];
$codigo=$_SESSION["cargo_asignado"];
//unset($_SESSION["codigo_libro_reg"]);
$fecha_hoy = date("Y-m-d");
$camb_gest=$_SESSION["camb_gest"];
$hridm=descifrar($_GET['hrid1']);
$hrnrom=descifrar($_GET['nrohjrt']); 

//echo "$hrnrom";
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
//echo "$hridm para modificar la hoja de ruta<br>";
//echo "$codigo_usuario <br>";
?>
<link rel="stylesheet" href="jquery.mobile-1.0.min.css" /> 
<script src="jquery-1.7.1.min.js"></script>
<script src="jquery.mobile-1.0.min.js"></script>

<script language="JavaScript">
function Abre_ventana (pagina)
{
     ventana=window.open(pagina,"Asignar","toolbar=no,location=0,directories=no,status=no,menubar=no,scrollbars=yes,resizable=yes,width=700,height=400");
}
function Retornar(){
	document.ingreso.action="menu2.php";
	document.ingreso.submit();
}
</script>

<script languaje="javascript">

function habilita(form)
{ 
form.intereses[0].disabled = false;
}

function deshabilita(form)
{ 
form.intereses[0].disabled = true;
}
</script>



<?php 
if(isset($_POST['crear']))
{
    if(empty($_POST['doc_para']))
	{
	  $error=1;
	  $alert_tipo_des=1;
  	}
	
	if(empty($_POST['temamod']))
	{
	  $error=1;
	  $alert_tema=1;
  	}
	
	if($error==0)
	{
	$refmodf=$_POST['temamod'];
	$usumodf=$_POST['doc_para'];
	
		$rparamodf=mysql_query("select  `cargos_cod_depto`, `departamento_sigla_dep`
							from `cargos`, `departamento`  
							where
							`cargos_id`='$usumodf'
							and 
							cargos_cod_depto=departamento_cod_departamento",$conn);
		$rpmodf=mysql_fetch_array($rparamodf);
		
		$rparamodf2=mysql_query("select d.`departamento_forma_cite`, `departamento_sigla_dep`
							from `cargos` c , `departamento` d
							where
							c.`cargos_id`='$codigo_usuario'
							and
							c.`cargos_cod_depto`=d.`departamento_cod_departamento`",$conn);
		$rpmodf2=mysql_fetch_array($rparamodf2);
			
		$rslista=mysql_query("SELECT  * FROM `registrodoc1` where registrodoc1_id='$hridm' and registrodoc1_estado='SR'
and registrodoc1_situacion='P' and registrodoc1_asociar<>'si' ",$conn);
	$valmod=mysql_fetch_array($rslista);
		
		$codmodpara=$rpmodf[0];
		$siglmod=$rpmodf[1];
		$siglmodpa=$rpmodf2[1];	
			
		$citemodf=$rpmodf2[0].'/NI/'.$valmod[7].'/'.$valmod[19];
		$nrohjruta=$rpmodf2[1].'-'.$valmod[1].'-'.$rpmodf[1];
	/*
	echo "$refmodf 1 <br>";	
	echo "$usumodf 2<br>";
	echo "$codmodpara 5<br>";
	*/
	
	mysql_query("update registrodoc1 set 
	  registrodoc1_hoja_ruta='$nrohjruta', registrodoc1_referencia='$refmodf', registrodoc1_para=$usumodf, registrodoc1_depto_para='$codmodpara', registrodoc1_cc='NE'
	  where registrodoc1_id='$hridm' and registrodoc1_estado='SR'
and registrodoc1_situacion='P' and registrodoc1_asociar<>'si'",$conn);
	
/*
	echo "$siglmodpa 6<br>";
	echo "$siglmod 3<br>";	
	echo "$citemodf 4<br>";
	echo "$nrohjruta 7";
	*/
?>
	<script>
        window.self.location="listado_de_mi2.php";
	</script>
<?php
   }
}	
?>
<?php 
if(isset ($_POST[cancelar]))
{
?>
      <script language="JavaScript">
         window.self.location="listado_de_mi2.php";
      </script>
<?php
}
?>
<br>
<p class="fuente_titulo">
<center><b></b></center></p>
</center>
<form action="" method="post">
<!--<form action="genera_cite.php" method="post" name="crear">-->
<table width="693" height="290" border="0" align="center" cellspacing="3" cellpadding="3" class="border_tr3">
  <tr class="border_tr3">
    <td colspan="3" align="center" bgcolor="#3E6BA3"><strong style="color:#FFFFFF; font-size:15px">MODIFCAR DESTINATARIO</strong></td>
  </tr>
  <tr class="border_tr3">
    <td colspan="3" align="center" bgcolor="#3E6BA3"><strong style="color:#FFFFFF; font-size:15px">A LA HOJA DE RUTA :  <?php echo "$hrnrom";?></strong></td>
  </tr>
  <tr class="border_tr3">
    <td colspan="3"></td>
  </tr>
  <tr class="border_tr3">
    <td colspan="3"><strong>1) Nuevo Destinatario</strong></td>
  </tr>
  <tr class="border_tr3">
    <td>&nbsp;</td>
    <td><strong>Nombre y Cargo del Funcionario:</strong> </td> 
	<td>	
	<select name="doc_para" style="font-size:9px">
		<option value="">Dirigido a:</option>
		<?php
		$rpara=mysql_query("select a.`asignar_su_codigo`, u.`usuario_nombre`, c.`cargos_cargo`, c.`cargos_cod_depto`
							from `asignar` a , `cargos` c , `usuario` u
							where
							a.`asignar_mi_codigo`='$codigo'
							and
							a.`asignar_su_codigo`=c.`cargos_id`
							and
							c.`cargos_id`=u.`usuario_ocupacion` order by u.`usuario_nombre`",$conn);
		while($rp=mysql_fetch_array($rpara))
		{
			?>			
			<option value=<?php echo $rp["0"];?> selected><?php echo $rp["1"]; echo ".....("; echo $rp["2"]; echo ")";?></option>
			<?php
		}

			?>
	 </select>
	<?php echo $rp["0"];?>
	</td>
  </tr>
  <tr class="border_tr3">
    <td colspan="3"><strong>2) Detalle</strong></td>
  </tr>
  <tr class="border_tr3">
    <td height="84">&nbsp;</td>
    <td ><strong>Referencia:</strong></td>
    <td><textarea name="temamod" rows="3" cols="50"></textarea>
	<?php Alert($alert_tema);?>
	</td>
  </tr>
  <tr>
	<td colspan="3" align="center" >
	<input style="font-size:10px; color:blue;" type="submit" value="Modificar" name="crear"/>
	<input style="font-size:10px; color:blue;" type="submit" value="Cancelar" name="cancelar"/>
	</td>
  </tr>
  
</form>
 				  
</table>	
<br />
<br />

<?php
include("final.php");
?>
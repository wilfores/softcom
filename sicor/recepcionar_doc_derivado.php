<?php
include("../filtro.php");
?>
<?php
include("inicio.php");
?>
<?php
include("../conecta.php");
include("cifrar.php");
include("script/functions.inc");
$gestion=$_SESSION["gestion"];

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
$cargo_unico=$_SESSION["cargo_asignado"];
//echo "$cargo_unico <br />";
$error=0;
$hruta=descifrar($_GET['hr1']);
$hrutadatos = $hruta;
//echo "$hruta <br /> holaaaaaa<br>";
	
	//*******************
	$llavecopia=0;    // 0  es normal, 1 es copia
	$buscareg = mysql_query("select derivardoc_n_derivacion from `derivardoc`
		where derivardoc_hoja_ruta = '$hruta'", $conn);
	$rbuscareg =mysql_fetch_array($buscareg);
	if(strlen($rbuscareg['derivardoc_n_derivacion']) > 3){
	//	echo "<script> alert('copiaaa')";
	
		$rdatoscopia = mysql_query("select derivardoc_copia_de from derivardoc where derivardoc_hoja_ruta = '$hruta'", $conn);
		$filadatos = mysql_fetch_array($rdatoscopia);
		$hrutadatos = $filadatos["derivardoc_copia_de"];
		$llaveregistro = 1; //es coipa
//		echo "es copia";
/*		$s_hr="select * from derivardoc 
					where derivardoc_hoja_ruta='$hrutadatos' 
					and derivardoc_estado ='P'
					and derivardoc_situacion = 'SR' ";		
		*/

	}
	else{
	//	echo "<script> alert('normal')";
//		$rhrutacopia = 0 ;
//		echo "es normal";
		$llaveregistro = 0; 	//es normal
		/*$s_hr="select * from derivardoc 
					where derivardoc_hoja_ruta='$hruta' 
					and derivardoc_estado ='P' 
					and derivardoc_situacion = 'SR' ";		

		*/
	}

//	$s_hr="select * from registrodoc1 where registrodoc1_hoja_ruta='$hrutadatos' and registrodoc1_asociar<>'si'";	
	$s_hr="select * from derivardoc 
					where derivardoc_hoja_ruta='$hruta' 
					and derivardoc_estado ='P' 
					and derivardoc_situacion = 'SR' ";
	$r_hr = mysql_query($s_hr, $conn);
	$row_dep=mysql_fetch_array($r_hr);
/*	$cod_dep=$row_dep['registrodoc1_de'];
	$estado=$row_dep['registrodoc1_estado'];
	$tipo = $row_dep["registrodoc1_tipo"];*/
	$cod_dep=$row_dep['derivardoc_de'];
	$estado=$row_dep['derivardoc_situacion'];
	
	$restipo = mysql_query("select * from registrodoc1  where registrodoc1_hoja_ruta = '$row_dep[derivardoc_hoja_ruta]' ", $conn);
	if ($llaveregistro > 0){
		$restipo = mysql_query("select * from registrodoc1  where registrodoc1_hoja_ruta = '$hrutadatos' ", $conn);	
	}
	$obtcite = mysql_fetch_array($restipo);
	$tipo = $obtcite["registrodoc1_tipo"];
	
	//echo "$tipo<br>";
	
	if ($tipo=='INTERNO')
	{
//		echo "es interno";
		$s_rm="select
				u.usuario_nombre, c.cargos_cargo
				from 
				usuario u,
				cargos c
				where
				u.usuario_ocupacion='$cod_dep'
				and
				u.usuario_ocupacion=c.cargos_id";
		$r_rm = mysql_query($s_rm, $conn);
		$row_rm=mysql_fetch_array($r_rm);
		$nom_rm=$row_rm[0];
		$cargo_rm=$row_rm[1];
	 
	}
	 else 
	{ 
//		echo "es externo";
		// --> DEBEMOS AVERIGUAR SI ES UN EXTERNO DERIVADO O SI ES UN EXTERNO DERIVADO MULTIPLE
		// OSEA QE NO SE ENCUENTRAN LOS DATOS EN DERIVARDOC
		
		$buscader = mysql_query("select count(*) as total from derivardoc 
			where derivardoc_hoja_ruta='$row_dep[derivardoc_hoja_ruta]'", $conn);
		$resder = mysql_fetch_array($buscader);
		if ($resder["total"] > 0){
			$s_rm="select
				u.usuario_nombre, c.cargos_cargo
				from 
				usuario u,
				cargos c
				where
				u.usuario_ocupacion='$cod_dep'
				and
				u.usuario_ocupacion=c.cargos_id";
			$r_rm = mysql_query($s_rm, $conn);
			$row_rm=mysql_fetch_array($r_rm);
			$nom_rm=$row_rm[0];
			$cargo_rm=$row_rm[1];	
		}
		else{
	//		$valor_clave=$row_dep["registrodoc1_de"];
	//		$valor_clave=$row_dep["derivardoc_de"];
	//		$conexion = mysql_query("SELECT * FROM usuarioexterno WHERE '$valor_clave'=usuarioexterno_codigo",$conn);
			$conexion = mysql_query("SELECT * FROM usuarioexterno WHERE '$obtcite[registrodoc1_de]'=usuarioexterno_codigo",$conn);
			$row_rm2=mysql_fetch_array($conexion);
			$nom_rm=$row_rm2[2];
			$cargo_rm=$row_rm2[3];
		}
	}


if(isset ($_POST[grabar]))
{
	
	$hrt=$_POST["hr"];
	$estado=$_POST["est"];	/*estado del doc R o SR*/
	$f_rec=$_POST["fecha_recepcion"]; /*fecha de recepcion*/
	$n_hoj=$_POST["n_hojas"];	/* numero de hojas de documento*/
	$priorid=$_POST["prioridad"]; /*prioridad del doc ALTA MEDIA BAJA*/
	$res_p=$_POST["res_si"];	/*si necesita una respuesta positiva*/
	$res_n=$_POST["res_no"];	/*si NO necesita una respuesta el doc*/	
	$n_adj=$_POST["nro_adj"];	/*numero de adjuntos q tiene el doc*/
	$descr_adj=$_POST["descripcion"];	/*descripcion de adjunto*/
	$nom_arch_ad=$_FILES["nom_arch_adj"];	/*nombre de archivo adjunto*/
	if($res_p=='on') $res='SI';
	else $res='NO';
	
	if($descr_adj=='')$descr_adj='NULL';
	
	if($_FILES["nom_arch_adj"]["name"]=='')
	{$archivo_nombre='NULL';
    }
	else 
	{
	$archivo_nombre=$_FILES["nom_arch_adj"]["name"];
	//echo $archivo_nombre;
	$archivo_tamano = $_FILES["nom_arch_adj"]["size"];
	}
	/*echo "$hrt hoja de ruta <br />";
	echo "$estado que que se encuentra<br />";
	echo "$f_rec fecha de recepcion<br />";
	echo "$n_hoj numero de hojas<br />";
	echo "$priorid prioridad<br />";
	echo "$res respuesta positiva<br />";
	echo "$n_adj numero de adjuntos<br />";
	echo "$descr_adj descripcion<br />";
	echo "$nom_arch_ad nombre del archivo<br />";
	
	echo "$archivo_nombre nombre del archivo<br />";
	echo "$archivo_tamano tamaño del archivo<br />";
	*/
	
	$con= "UPDATE derivardoc
                SET
			derivardoc_fec_recibida='$f_rec',
			derivardoc_situacion='R',
			derivardoc_realizado='H'
                WHERE
            derivardoc_hoja_ruta='$hrt'
            and derivardoc_situacion='SR'
			and derivardoc_estado='P'
			";
			/*
			and derivardoc_para='$cargo_unico'
			registrodoc_respuesta='$res', SE CAMBIO POR (SI) */

    $res = mysql_query($con,$conn);  

?>
  <script language="JavaScript">
    window.self.location="menu2.php";
  </script>
<?php	

}
?>
<script>
function Retornar(){
 document.enviar.action="menu2.php";
 document.enviar.submit();
}
function cerrarse(){ 
window.close() 
} 

function disableCheck(field, causer) 
{
	if (causer.checked) 
	{
	field.checked = false;
	field.disabled = true;
	}
	else 
	{
	field.disabled = false;
	}
}

function disableOthers(field) 
{
	disableCheck(formulario.dos, field);
	//disableCheck(formulario.tres, field);
}

function disableUno() 
{
	field = formulario.uno
	
	if (formulario.dos.checked) 
		{
		field.checked = false;
		field.disabled = true;
		}
	else {
		field.disabled = false;
		}
}
</script>
<br>
<?php

if ($error == 0)
{
echo "<p><div class=\"fuente_titulo\" align=\"center\"><b>RECEPCION DE DOCUMENTO DERIVADO</b></div></p>";
} 
else 
{ 
echo "<center><table width=25%><tr><td class=fuente_normal_rojo  align=left><center><b> !!! ERROR DATOS NO VALIDOS !!!</b></center>".$valor_error."</td></tr></table></center>";
}
?>
<link href="script/estilos2.css" rel="stylesheet" type="text/css" />
<center>
<table width="700" cellspacing="2" cellpadding="2"  border="0">
	<form  method="POST" name="enviar" enctype="multipart/form-data"> 
	
	<input type="hidden" name="hr" value="<?=$hruta;?>" />
	<input type="hidden" name="est" value="<?=$estado;?>" />
	<tr class="border_tr3" >
		<td align="left">
			<b>Hoja de Ruta: </b>
			</td>
		<td align="left">
			<?php echo "<b>".$hruta."</b>";?>		</td>
	</tr>

	<tr class="border_tr3">
			<td>
				<span class="fuente_normal">Fecha y Hora de Recepcion</td>
			<td>
				<?php
					$fecha_recep=date("Y-m-d H:i:s");
					echo "<b>".$fecha_recep."</b>";
				?>
					<input type="hidden" name="fecha_recepcion" align="center"  size="10" maxlength="10"  value="<?php echo $fecha_recep;?>" >			
			</td>
	</tr>
	<tr class="border_tr3">
		<td>
				<span class="fuente_normal">Remitente </td>
		<td>    
			<?php echo "<b>".$nom_rm."</b>";?>		
		</td>
	</tr>
	<tr class="border_tr3">
		<td>
					<span class="fuente_normal">Cargo Remitente	</td>
		<td>   
		<?php echo "<b>".$cargo_rm."</b>";?>
		</td>
	</tr>			
	<tr class="border_tr3"><td><span class="fuente_normal">No. de CITE</td>		
		<td>	
		<?php 
				//------------------------------------------------------------------
				$rescite = mysql_query("select * from registrodoc1 where registrodoc1_hoja_ruta = '$hruta'");
				if( $llaveregistro > 0){
					$rescite = mysql_query("select * from registrodoc1 where registrodoc1_hoja_ruta = '$hrutadatos'");
				}
				$row_dep2 = mysql_fetch_array($rescite);
				echo "<b>".$row_dep2['registrodoc1_cite']."</b>";
				
		?>
		</td>
		</tr>
		<tr class="border_tr3"><td><span class="fuente_normal">Fecha del CITE</td>
		<td>
		<?php
//		echo "<b>".$row_dep['registrodoc1_fecha_elaboracion']."</b>";
		echo "<b>".$row_dep2['registrodoc1_fecha_elaboracion']."</b>";
		/*
echo "<input type=\"text\" name=\"fecha_cite\" readonly=\"readonly\" class=\"caja_texto\" id=\"dateArrival\" onClick=\"popUpCalendar(this, enviar.dateArrival, 'yyyy-mm-dd');\" size=\"10\" value=".$_POST['fecha_cite'].">";
echo " <img src=\"images/calendar.gif\" onClick=\"popUpCalendar(this, enviar.dateArrival, 'yyyy-mm-dd');\" alt=\"Calendario\" />";
 Alert($alert_fechacite);*/
   		?>        
		</td>
		</tr>
	<tr class="border_tr3">
    <td>
    <span class="fuente_normal">Referencia</td>
	<td>
	<?php 
//		echo "<b>".$row_dep2['registrodoc1_referencia']."</b>";
		echo "<b>".$row_dep['derivardoc_proveido']."</b>";
	?>
	  </td>
	</tr>
	<!--
	<tr class="border_tr3"><td width="30%"><span class="fuente_normal">Solicita Respuesta</td>
		<td>		
			Si:<input name="res_si" type="checkbox"/>&nbsp;&nbsp; 
			No:<input name="res_no" type="checkbox"/>
		
		</td>
	</tr>-->
	<tr class="border_tr3"><td width="30%"><span class="fuente_normal">Prioridad</td>
		<td>
	<?php	/*
			if($row_dep['registrodoc1_prioridad']=='A'){echo "<b>".URGENTE."</b>";}
			if($row_dep['registrodoc1_prioridad']=='M'){echo "<b>".NORMAL."</b>";}
			*/
			if($row_dep['derivardoc_prioridad']=='A'){echo "<b>".URGENTE."</b>";}
			if($row_dep['derivardoc_prioridad']=='M'){echo "<b>".NORMAL."</b>";}
	?>
		</td>
	</tr>
	<tr class="border_tr3"><td><span class="fuente_normal">No de Hojas</td>
	<td>
	<?php 
		//echo "<b>".$row_dep['derivardoc_n_hojas']."</b>";
		echo "<b>".$row_dep2['registrodoc1_n_hojas']."</b>";
	?>    
	</td>
	</tr>
	<?php 
//	if ($row_dep['derivardoc_n_adjunto']==0)
	if ($row_dep['derivardoc_n_adjunto']==0)
	{
	?>
	<tr class="border_tr3">
	  <td><span class="fuente_normal">SIN DATOS ADJUNTOS</td>
	  <td>   
	  </td>
	 </tr>
	<?php 
	}
	else
	{
	
	?>
	<tr class="border_tr3">
	  <td><span class="fuente_normal">No de Adjuntos:</td>
	  <td><?php
//		echo "<b>".$row_dep['registrodoc1_n_adjunto']."</b>";
		echo "<b>".$row_dep2['registrodoc1_n_adjunto']."</b>";
		?>      
	  </td>
	 </tr>
    <tr class="border_tr3"><td><span class="fuente_normal">Descripcion de Adjunto:</td>
	<td>
       <?php
			//echo "<input type=\"areatext\" name=\"tipo_anexos\" maxlength=100 size=70 class=\"caja_texto\" value=".$_POST['tipo_anexos'].">";
			//echo "<b>".$row_dep['registrodoc1_descrip_adj']."</b>";
			echo "<b>".$row_dep2['registrodoc1_descrip_adj']."</b>";
  	    ?>    
	</td>
	</tr>
	
	<tr class="border_tr3">
		<td><span class="fuente_normal">Ver Archivo Adjunto:</td>
		<td>
		<a href="" class="botonte" target="_top" onMouseMove="window.status='Hola, no me ves';" onMouseOut="window.status='';">
		 <?php 
//			echo "<b>".$row_dep['registrodoc1_descrip_adj']."</b>";
			echo "<b>".$row_dep2['registrodoc1_descrip_adj']."</b>";
			
			?></a> Archivo Adjunto
		</td>
	</tr>
	
	<?php 
	} /*fin de else*/
	?>
    <tr>
	<td align="center" colspan="2">
			<input type="submit" name="grabar" value="Grabar" class="boton"/>
			<input type="reset" name="cancelar" value="Cancelar" class="boton" onClick="Retornar();"/>    </td>
    </tr>
	</form>
	</table>
</center>
<br><br>
<?php

include("final.php");
?>
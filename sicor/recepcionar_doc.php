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
include("../funcion.inc");

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

$hruta=descifrar($_GET['hr1']);
//echo "$hruta <br />";

	$s_hr="select * from registrodoc1 where registrodoc1_hoja_ruta='$hruta'";
	$r_hr = mysql_query($s_hr, $conn);
	$row_dep=mysql_fetch_array($r_hr);
	$cod_dep=$row_dep['registrodoc1_de'];
	$estado=$row_dep['registrodoc1_estado'];
	$s_td=mysql_query("select * from documentos where documentos_sigla='$row_dep[registrodoc1_doc]'", $conn);
	$row_td=mysql_fetch_array($s_td);
	$descrp=$row_td['documentos_descripcion'];
	
	
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
	$cite2=$_POST["cite1"];	/*nombre de archivo adjunto*/
	if($res_p=='on') $res='SI';
	else $res='NO';
	
	if($descr_adj=='')$descr_adj='NULL';
	
	if($_FILES["nom_arch_adj"]["name"]=='')
	{$foto_nombre='NULL';
    }
	else 
	{
		$fecha=date("Y-m-d H:i:s");
		
		$qd = "select max(arch_adj_id)from arch_adj";
		$resdoc = mysql_query($qd,$conn);
		$rdoc = mysql_fetch_array($resdoc);			
		$id_doc=$rdoc[0]+1;/*obtiene el maximmo del id del documento 2*/
	
		    $foto_type=  $_FILES['nom_arch_adj']['type'];
            $tmp_name = $_FILES["nom_arch_adj"]["tmp_name"];
            $foto_nombre = $_FILES["nom_arch_adj"]["name"];

            $foto_descripcion = $foto_nombre;

            $foto_nombre = strtolower($foto_nombre);
            $valor_aux = explode(".",$foto_nombre);
            $cantidad_valor_puntos = count($valor_aux);
            $foto_nombre_1 = genera_password();
            $foto_nombre = $foto_nombre_1.".".$valor_aux[$cantidad_valor_puntos-1];
            $foto_nombre = date("dmY").$foto_nombre;
            $cont=1;
                while(file_exists("adjunto/".$foto_nombre))
                {
                     $foto_nombre = $cont.$foto_nombre;
                     $cont=$cont+1;
                }

                $lugar="adjunto/".$foto_nombre;
                copy ($tmp_name,$lugar);
				move_uploaded_file($HTTP_POST_FILES['nom_arch_adj']['tmp_name'], './adjunto/'.$foto_nombre);

		$insertar=" INSERT INTO `arch_adj` (`arch_adj_id`, `arch_adj_h_r`, `arch_adj_nombre`, `arch_adj_usuario`, `arch_adj_fecha`) VALUES 
  ($id_doc, '$cite2', '$foto_nombre', $cargo_unico, '$fecha')";		
  
  		$resul = mysql_query($insertar,$conn);
	
	}
	/*
	echo "$hrt hoja de ruta <br />";
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
	
	
	$con= "UPDATE registrodoc1
                SET
			registrodoc1_estado='R',
			registrodoc1_fecha_recepcion='$f_rec',
			registrodoc1_n_hojas=$n_hoj,
			registrodoc1_prioridad='$priorid',
			registrodoc1_respuesta='SI',
			registrodoc1_n_adjunto=$n_adj,
			registrodoc1_descrip_adj='$descr_adj',
			registrodoc1_nom_arch_adj='$foto_nombre'
                WHERE
            registrodoc1_hoja_ruta='$hrt'
            AND registrodoc1_estado='SR'";
	
			/*registrodoc_respuesta='$res', SE CAMBIO POR (SI) */
    $res = mysql_query($con,$conn);  
	
	?>

				<script language="JavaScript">
				//window.self.location="hoja_ruta123.php";
				//window.open("acta_de_recep.php?hr1=<?php echo $hrt;?>","Actaderecep","resizable=yes,width=800,height=800");
                window.self.location="menu2.php";
                </script>
				
	<?php

}
?>
<script language="JavaScript">
function Abre_ventana (pagina)
{
     ventana=window.open(pagina,"Asignar","toolbar=no,location=0,directories=no,status=no,menubar=no,scrollbars=yes,resizable=yes,width=800,height=800");
}
function Retornar(){
	document.ingreso.action="menu2.php";
	document.ingreso.submit();
}
</script>
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

<link href="script/estilos2.css" rel="stylesheet" type="text/css" />
<center>
<?php 
   echo "<br>";
   echo "<p class=fuente_normal>";
   echo "<center><B>RECEPCION DE DOCUMENTOS";
   echo "</B></center></span>";
   echo "<br>";
?>

<table width="700" cellspacing="2" cellpadding="2"  border="0">
	<form  method="POST" name="enviar" enctype="multipart/form-data"> 
	
	<input type="hidden" name="hr" value="<?=$hruta;?>" />
	<input type="hidden" name="est" value="<?=$estado;?>" />
	<tr>
		<td colspan="2">
		  <table width="100%" style="font-size: 8pt; color:#FFFFFF">
		  	  <tr class="truno" >
					<td align="left">
						Hoja de Ruta: <?php echo "<b>".$hruta."</b>";?>
						</td>
				  <td align="left">
				        No. de CITE: <?php echo "<b>".$row_dep['registrodoc1_cite']."</b>";?>
						<input type="hidden" name="cite1" value="<?=$row_dep['registrodoc1_cite'];?>" >	
				  </td>
			  </tr>
			  <tr class="truno">
				  <td colspan="2">Referencia: <i><b><? echo "$row_dep[registrodoc1_referencia]"; ?></b></i></td>	
			  </tr>
			  <tr class="truno">
				  <td colspan="2">Remite: <i><b><?php echo "<b>".$nom_rm."</b>";?></b></i></td>	
			  </tr>
			  <tr class="truno">
				  <td colspan="2">Cargo: <i><b><?php echo "<b>".$cargo_rm."</b>";?></b></i></td>	
			  </tr>
			  
			  <tr class="truno">
				  <td colspan="2">Fecha de Elaboracion: <b><? echo "$row_dep[registrodoc1_fecha_elaboracion]"; ?></b></td>
			  </tr>
			  	  <tr class="truno">
				  <td colspan="2">Tipo de Documento: <b><? echo "$descrp"; ?></b></td>	
			  </tr>
		  </table>
     	</td>
	 </tr>
	 
		<tr class="border_tr3">
			<td>
				<span class="fuente_normal">Fecha y Hora de Recepcion</td>
			<td>
				<?php
					$fecha_recep=date("Y-m-d H:i:s");
					echo $fecha_recep;
				?>
					<input type="hidden" name="fecha_recepcion" align="center"  size="10" maxlength="10"  value="<?php echo $fecha_recep;?>" >			
			</td>
		</tr>
	<!--
	<tr class="border_tr3"><td width="30%"><span class="fuente_normal">Solicita Respuesta</td>
		<td>		
			Si:<input name="res_si" type="checkbox"/>&nbsp;&nbsp; 
			No:<input name="res_no" type="checkbox"/>
		
		</td>
	</tr>-->

		<?php
		if (($_SESSION["cargo"] == "Ventanilla") or  ($_SESSION["cargo"] == "Secretaria") )
		 {?>
		 <input type="hidden" name="prioridad" value="M" >
		 <?php
         }
  		else
		 {
		 ?>
		 <input type="hidden" name="prioridad" value="M" >
		<!--
		<tr class="border_tr3"><td width="30%"><span class="fuente_normal">Prioridad</td>
		<td>
		 <select name="prioridad">
			<option value='M' >Media</option>
			<option value='B' >Baja</option>
			<option value='A' >Alta</option>   		
		</select>
		</td>
	    </tr>-->
		 <?php
         }
         ?>
	<tr class="border_tr3"><td><span class="fuente_normal">No de Hojas</td>
	<td>
	<?php
	 echo "<input type=\"text\" name=\"n_hojas\" maxlength=4 size=4 class=\"caja_texto\" value=\"0\">";
	 Alert($alert_hojas);
	?>    
	</td>
	</tr>
	<tr class="border_tr3">
	  <td><span class="fuente_normal">No de Adjuntos:</td>
	  <td><?php
			echo "<input type=\"text\" name=\"nro_adj\" maxlength=4 size=4 class=\"caja_texto\" value=\"0\">";
			Alert($alert_anexos);
		?>      </td>
	  </tr>
	<!--/*<!--<tr class="border_tr3"><td><span class="fuente_normal">Cantidad Anexos</td>
	<td>
		<?php
			echo "<input type=\"text\" name=\"nro_anexos\" maxlength=4 size=4 class=\"caja_texto\" value=\"0\">";
			Alert($alert_anexos);
		?>	
    </td>
	</tr>-->
	
    <tr class="border_tr3"><td><span class="fuente_normal">Descripcion de Adjunto:</td>
	<td>
       <?php
			//echo "<input type=\"areatext\" name=\"tipo_anexos\" maxlength=100 size=70 class=\"caja_texto\" value=".$_POST['tipo_anexos'].">";
			echo "<textarea name=\"descripcion\" rows=\"4\" cols=\"50\"></textarea>";
  	    ?>    
	</td>
	</tr>
	<tr class="border_tr3">
	<td><span class="fuente_normal">Subir Archivo Adjunto:</td>
	<td><input style="font-size:9px; color:blue" name="nom_arch_adj" type="file"></td>
	</tr>
	
    <tr>
	<td align="center" colspan="2">

			<input type="submit" name="grabar" value="Guardar" class="boton"/>
			<input type="reset" name="cancelar" value="Cancelar" class="boton" onClick="Retornar();"/>    
	</form>	
	<!--
	<a href="javascript:Abre_ventana('hoja_ruta_doc.php?hr1=<?php echo $hruta;?>')" onmouseover="window.status='Guia de sitio';return true" onmouseout="window.status='';return true">
	<img src="images/imp_h_r.png" onmouseover="this.src='images/imp_h_r1.png'" onmouseout="this.src='images/imp_h_r.png'">
	</a>-->
	
	</td>
    </tr>

	</table>
</center>
<br><br>
<?php
include("final.php");
?>
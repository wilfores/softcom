<?php
//include("../filtro.php");
?>
<?php
//include("inicio.php");
?>

<?php
include("script/functions.inc");
include("script/cifrar.php");
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
$depto=$_SESSION["departamento"];
$hruta=$_GET['hr1'];

	$s_hr="select * from registrodoc1 where registrodoc1_hoja_ruta='$hruta'";
	$r_hr = mysql_query($s_hr, $conn);
	$row_dep=mysql_fetch_array($r_hr);
	$cod_dep=$row_dep['registrodoc1_de'];
	$cod_para=$row_dep['registrodoc1_para'];
	$estado=$row_dep['registrodoc1_estado'];
	$cite=$row_dep['registrodoc1_cite'];
	$prioridad=$row_dep['registrodoc1_prioridad'];
	$fech_ela=$row_dep["registrodoc1_fecha_elaboracion"];
	$tipo_doc=$row_dep["registrodoc1_doc"];
	$gest=$row_dep["registrodoc1_gestion"];
	$ref=strtoupper($row_dep["registrodoc1_referencia"]);
	
	$rdoc=mysql_query("SELECT * from documentos 
					where documentos_sigla='$tipo_doc'",$conn);
	$rpd=mysql_fetch_array($rdoc);
	$descr=$rpd['documentos_descripcion'];
	
	$r_rm = mysql_query("select usuario_nombre, cargos_cargo, usuario_titulo from usuario, cargos where usuario_ocupacion='$cod_dep' and usuario_ocupacion=cargos_id", $conn);
	$row_rm=mysql_fetch_array($r_rm);
	$tit_rm=$row_rm['usuario_titulo'];
	$nom_rm=$row_rm['usuario_nombre'];
	$cargo_rm=$row_rm['cargos_cargo'];
	
	$r_des = mysql_query("select usuario_nombre, cargos_cargo, usuario_titulo from usuario, cargos where usuario_ocupacion='$cod_para' and usuario_ocupacion=cargos_id", $conn);
	$row_des=mysql_fetch_array($r_des);
	$tit_des=$row_des['usuario_titulo'];
	$nom_des=$row_des['usuario_nombre'];
	$cargo_des=$row_des['cargos_cargo'];

?>
<style>
.p
{
    font-size: 12px;
    color: #0000FF;
}
.ka{
    font-size: 11px;
    color: #000080;
}
</style>
<div align="center" style="color:#FFFFFF" >
<a href="javascript:window.print();" align="center">
<font face="Arial, Helvetica, sans-serif" size="2"><b><img src="images/printready.gif" border="0">Imprimir 
  P&aacute;gina</b></font></a>
<table width="800" border="0">
  <tr>
  	<td style="font-size: 8px; color: #808080;">
		<img src="images/escudo_bolivia.gif" width="100" height="76" />
		<br />MINISTERIO DE SALUD Y DEPORTES <br />
		Software de Correspondencia Ministerial
	  </td>
		<td>
		<!--<img src="images/codigo.png" width="176" height="40" />-->
		</td>
  </tr>
  
  <tr>
    <td>
    	<table width="500" border="0">
			  <tr>
				<td class="p" width="100">Destinatario:</td>
				<td class="ka" width="400"><?php echo"$tit_des. $nom_des";?></td>
			  </tr>
			  <tr>
				<td class="p">Cargo:</td>
				<td class="ka"><?php echo"$cargo_des";?></td>
			  </tr>
			  <tr>
				<td class="p"><br /></td>
				<td class="ka"><br /></td>
			  </tr>
			  <tr>
				<td class="p">Remitente:</td>
				<td class="ka"><?php echo"$tit_rm. $nom_rm";?></td>
			  </tr>
			  <tr>
				<td class="p">Cargo:</td>
				<td class="ka"><?php echo"$cargo_rm";?></td>
			  </tr>
		</table>			
   </td>
   <td>
			<table width="300" border="0">
			  <tr>
				<td class="p">HOJA DE RUTA:</td>
				<td class="ka"><?php echo "$hruta";?></td>
			  </tr>
			  <tr>
				<td class="p">CITE:</td>
				<td class="ka"><?php echo "$cite";?></td>
			  </tr>
			  <tr>
				<td class="p">Gestion:</td>
				<td class="ka">MSyD - <?php echo "$gest";?></td>
			  </tr>
			  <tr>
				<td class="p">Fecha de Inicio:</td>
				<td class="ka"><?php 
									if($prioridad=='A'){echo "<font color=#FF0000>$fech_ela</font>";}
									else {	echo "$fech_ela";}?></td>
			  </tr>
			  <tr>
				<td class="p">Prioridad:</td>
				<td class="ka"><?php 	if($prioridad=='M'){echo "MEDIA";}
										if($prioridad=='B'){echo "BAJA";}
										if($prioridad=='A'){echo "<font color=#FF0000>ALTA</font>";}?></td>
			  </tr>
			  <tr>
				<td>Tipo de Documento</td>
				<td><?php echo "$descr";?></td>
			  </tr>
			</table>					
    </td>
  </tr>
  <tr>
    <td colspan="2">
    <table bgcolor="#FFCC00">
        <tr>
        	<td>Referencia:</td>
        	<td><?php echo "$ref";?></td>
        </tr>
     </table>    
   </td>
  </tr>
</table>

<table width="789" height="128" border="1">
  <tr>
    <td width="592" height="20" style="font-size:11px"><strong>PRIMER DESTINATARIO</strong>................................................................... </td>
    <td width="181" style="font-size:11px"> N&ordm; DE HOJAS:...............     </td>
  </tr>
  <tr>
    <td colspan="2">
	<table width="778" height="100" border="0" cellpadding="0">
      <tr>
        <td width="591"><p>Proveido:...........................................................................................................................................<br>
          .........................................................................................................................................................<br>
          .........................................................................................................................................................<br>		.........................................................................................................................................................</td>
        <td width="172"><p>&nbsp;</p>
          <p>&nbsp;</p>
          <p align="center" style="font-size:9px">SELLO Y FIRMA</p></td>
      </tr>
    </table>
	</td>
  </tr>
  <tr>
    <td colspan="2" style="font-size:11px">Fecha de Ingreso: ......../......./........ hora: ...................... Fecha de Salida: .........../........../.......... </td>
  </tr>  
</table>

<table width="789" height="128" border="1">
  <tr>
    <td width="592" height="20" style="font-size:11px"><strong>SEGUNDO DESTINATARIO</strong>................................................................... </td>
    <td width="181" style="font-size:11px"> N&ordm; DE HOJAS:...............     </td>
  </tr>
  <tr>
    <td colspan="2">
	<table width="778" height="100" border="0" cellpadding="0">
      <tr>
        <td width="591"><p>Proveido:...........................................................................................................................................<br>
          .........................................................................................................................................................<br>
          .........................................................................................................................................................<br>		.........................................................................................................................................................</td>
        <td width="172"><p>&nbsp;</p>
          <p>&nbsp;</p>
          <p align="center" style="font-size:9px">SELLO Y FIRMA</p></td>
      </tr>
    </table>
	</td>
  </tr>
  <tr>
    <td colspan="2" style="font-size:11px">Fecha de Ingreso: ......../......./........ hora: ...................... Fecha de Salida: .........../........../.......... </td>
  </tr>  
</table>

<table width="789" height="128" border="1">
  <tr>
    <td width="592" height="20" style="font-size:11px"><strong>TERCER DESTINATARIO</strong>................................................................... </td>
    <td width="181" style="font-size:11px"> N&ordm; DE HOJAS:...............     </td>
  </tr>
  <tr>
    <td colspan="2">
	<table width="778" height="100" border="0" cellpadding="0">
      <tr>
        <td width="591"><p>Proveido:...........................................................................................................................................<br>
          .........................................................................................................................................................<br>
          .........................................................................................................................................................<br>		.........................................................................................................................................................</td>
        <td width="172"><p>&nbsp;</p>
          <p>&nbsp;</p>
          <p align="center" style="font-size:9px">SELLO Y FIRMA</p></td>
      </tr>
    </table>
	</td>
  </tr>
  <tr>
    <td colspan="2" style="font-size:11px">Fecha de Ingreso: ......../......./........ hora: ...................... Fecha de Salida: .........../........../.......... </td>
  </tr>  
</table>

<table width="789" height="128" border="1">
  <tr>
    <td width="592" height="20" style="font-size:11px"><strong>CUARTO DESTINATARIO</strong>................................................................... </td>
    <td width="181" style="font-size:11px"> N&ordm; DE HOJAS:...............     </td>
  </tr>
  <tr>
    <td colspan="2">
	<table width="778" height="100" border="0" cellpadding="0">
      <tr>
        <td width="591"><p>Proveido:...........................................................................................................................................<br>
          .........................................................................................................................................................<br>
          .........................................................................................................................................................<br>		.........................................................................................................................................................</td>
        <td width="172"><p>&nbsp;</p>
          <p>&nbsp;</p>
          <p align="center" style="font-size:9px">SELLO Y FIRMA</p></td>
      </tr>
    </table>
	</td>
  </tr>
  <tr>
    <td colspan="2" style="font-size:11px">Fecha de Ingreso: ......../......./........ hora: ...................... Fecha de Salida: .........../........../.......... </td>
  </tr>  
</table>

<table width="789" height="128" border="1">
  <tr>
    <td width="592" height="20" style="font-size:11px"><strong>QUINTO DESTINATARIO</strong>................................................................... </td>
    <td width="181" style="font-size:11px"> N&ordm; DE HOJAS:...............     </td>
  </tr>
  <tr>
    <td colspan="2">
	<table width="778" height="100" border="0" cellpadding="0">
      <tr>
        <td width="591"><p>Proveido:...........................................................................................................................................<br>
          .........................................................................................................................................................<br>
          .........................................................................................................................................................<br>		.........................................................................................................................................................</td>
        <td width="172"><p>&nbsp;</p>
          <p>&nbsp;</p>
          <p align="center" style="font-size:9px">SELLO Y FIRMA</p></td>
      </tr>
    </table>
	</td>
  </tr>
  <tr>
    <td colspan="2" style="font-size:11px">Fecha de Ingreso: ......../......./........ hora: ...................... Fecha de Salida: .........../........../.......... </td>
  </tr>  
</table>

<table width="789" height="128" border="1">
  <tr>
    <td width="592" height="20" style="font-size:11px"><strong>SEXTO DESTINATARIO</strong>................................................................... </td>
    <td width="181" style="font-size:11px"> N&ordm; DE HOJAS:...............     </td>
  </tr>
  <tr>
    <td colspan="2">
	<table width="778" height="100" border="0" cellpadding="0">
      <tr>
        <td width="591"><p>Proveido:...........................................................................................................................................<br>
          .........................................................................................................................................................<br>
          .........................................................................................................................................................<br>		.........................................................................................................................................................</td>
        <td width="172"><p>&nbsp;</p>
          <p>&nbsp;</p>
          <p align="center" style="font-size:9px">SELLO Y FIRMA</p></td>
      </tr>
    </table>
	</td>
  </tr>
  <tr>
    <td colspan="2" style="font-size:11px">Fecha de Ingreso: ......../......./........ hora: ...................... Fecha de Salida: .........../........../.......... </td>
  </tr>  
</table>

<table width="789" height="128" border="1">
  <tr>
    <td width="592" height="20" style="font-size:11px"><strong>SEPTIMO DESTINATARIO</strong>................................................................... </td>
    <td width="181" style="font-size:11px"> N&ordm; DE HOJAS:...............     </td>
  </tr>
  <tr>
    <td colspan="2">
	<table width="778" height="100" border="0" cellpadding="0">
      <tr>
        <td width="591"><p>Proveido:...........................................................................................................................................<br>
          .........................................................................................................................................................<br>
          .........................................................................................................................................................<br>		.........................................................................................................................................................</td>
        <td width="172"><p>&nbsp;</p>
          <p>&nbsp;</p>
          <p align="center" style="font-size:9px">SELLO Y FIRMA</p></td>
      </tr>
    </table>
	</td>
  </tr>
  <tr>
    <td colspan="2" style="font-size:11px">Fecha de Ingreso: ......../......./........ hora: ...................... Fecha de Salida: .........../........../.......... </td>
  </tr>  
</table>

</div>
<?php
include("../final.php");
?>
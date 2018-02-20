<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.0 Transitional//EN">
<html>
<head>
<title>Software de Correspondencia Ministerial</title>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<!--<meta http-equiv="Content-Type" content="text/html; charset=latin-1" />-->
<link rel="stylesheet" type="text/css" href="script/estilos2.css">
<link rel="stylesheet" type="text/css" href="script/acerca.css">
<link rel="stylesheet" type="text/css" href="script/styles.css">
<link href="sicor/images/bol_ico.ico" type="image/x-icon" rel="shortcut icon" />
<script language="JavaScript" src="script/ie.js" type="text/JavaScript"></script>
<script language='javascript' src="popcalendar.js"></script>
<script language='javascript' src="busquedas.js"></script>
</head>
<body class="caja_texto">
<?php
$cargo_fun=$_SESSION["cargo_fun"];
$depto=$_SESSION["departamento"];
$ancho=$_SESSION["wit"];
$nom=$_SESSION["nom"];
$codigo=$_SESSION["cargo_asignado"];
 ?>
<table border="0" cellpadding="no" cellspacing="no" width="100%" align="center">
    <tbody align="center">
		<tr align="center">
			<td width="100%" height="85" align="center">
			<?php
			if($_SESSION["camb_gest"]==2013)
			{
				$col_ban=255187;
				if($ancho >= 1366) {?>
				<img src="images/banner_3_2013.jpg" />
				<? }
				if($ancho >= 1200 && $ancho < 1366) {?>
				<img src="images/banner_2_2013.jpg" />
				<? }
				if($ancho <= 1100) {?>
				<img src="images/banner_1_2013.jpg" />
				<? }
			}
			if($_SESSION["camb_gest"]==2014)
			{
				$col_ban=214099;
				if($ancho >= 1366) {?>
				<img src="images/banner_3_2014.jpg" />
				<? }
				if($ancho >= 1200 && $ancho < 1366) {?>
				<img src="images/banner_2_2014.jpg" />
				<? }
				if($ancho <= 1100) {?>
				<img src="images/banner_1_2014.jpg" />
				<? }
			}
			if($_SESSION["camb_gest"]==2015)
			{
				//$col_ban='5c1b2f';
				$col_ban=204081;
				if($ancho >= 1366) {?>
				<img src="images/banner_3_2015.jpg" />
				<?php }
				if($ancho >= 1200 && $ancho < 1366) {?>
				<img src="images/banner_2_2015.jpg" />
				<?php }
				if($ancho <= 1100) {?>
				<img src="images/banner_1_2015.jpg" />
				<?php }
			}
			?>
			</td>
		</tr>
	</tbody>
</table>

<table width="100%" border="0" cellspacing="0" cellpadding="0" align="center">
<tr class="border_tr">
<td align="left" height="20px" bgcolor="<?=$col_ban ?>">
    <table border="0">
        <tr>
        	<td width="1000" align="left">

                <span class="parrafo_izquierda" style="font-size: 10px;">
                <?php
                   echo "<font size=2pt><b>Usuario:</b> ".$nom."</font>"; ?>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<?php
    	           echo "<font size=2pt><b>Cargo    :</b> ".$_SESSION["cargo_fun"]."</font>";?>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<?php 
                   $dias = array("Domingo","Lunes","Martes","Miercoles","Jueves","Viernes","Sabado");
                    $mes = array(" ","enero","febrero","marzo","abril","mayo","junio","julio","agosto","septiembre","octubre","noviembre","diciembre");
                    echo $dias[date('w')].", ".date("d")." de ".$mes[date('n')]." de ".date("Y");
                ?>
             </span>
            </td>
            <td width="50">
            <form action='../salir.php'>
            <input style="font-size: 9px; color: blue;" type="submit" value="Cerrar Sesion" name="enviar" />
            </form>
            </td>
        </tr>
    </table>
</td>
</tr>
</table>

<TABLE align="center" width="100%" cellspacing="0" cellpadding="0" BORDER="0" class="border_table">
<TR>
<TD WIDTH="100%" bgcolor="">
<!-- INICIA MENU -->
<?php
if (empty($_SESSION["cargo"]))
{
?>
<!--vacio -->
<?php    
}
else
{
  if (($_SESSION["cargo"] == "Ventanilla") or  ($_SESSION["cargo"]=="Secretaria") or ($_SESSION["cargo"]=="Jefe"))
  {   
  ?>
  
 <ul id="navmenu">
  <li><a href="menucon.php">INICIO</a>
      <ul>
	  <li><a href="menu2.php">BAN. ENTRADA</a></li>
	  <li><a href="menu3.php">BAN. PENDIENTES y SALIDA</a></li>
      </ul>
	</li>
  <li><a href="for_nuevo_doc2.php">NUEVO DOCUMENTO</a></li>
  <li><a href="#">REGISTRO</a>
    <ul>
	  <li><a href="registro_doc_int.php">DOC. INTERNO</a></li>
      <li><a href="registro_doc_ext.php">DOC. EXTERNO</a></li>
    </ul>
  </li>
  <li><a href="listado_de_mi2.php">LISTA DE ARCHIVOS GENERADOS</a></li>
  <li><a href="#">SEGUIMIENTO</a>
    <ul>
		<li><a href="listado_general2.php">SEGUIMIENTO INTERNO</a></li>    
		<li><a href="listado_general3.php">SEGUIMIENTO EXTERNO</a></li>    
  	</ul>
  </li> 
<li><a href="#">LIBRO DE REGISTRO</a>
      <ul>
		<li><a href="listado_libro.php">IMPRIMIR H.R.</a></li>    
		<li><a href="librocites.php">LIBRO DE CITES</a></li>  
		<li><a href="libroregistro3.php">LIB. RECIBIDOS</a></li>
		<li><a href="librorecibidos.php">LIB. RECIBIDOS</a></li>
  	</ul>
  </li>  
   <li><a href="#">PDF'S</a>
    <ul>
      <li><a href="hoja_ruta_correlativo.php" target="_blank">HR CORRELATIVO 5-10</a></li>
	  <li><a href="hoja_ruta_correlativo11_16.php" target="_blank">HR CORRELATIVO 11-16</a></li>
	  <li><a href="hoja_ruta_correlativo17_22.php" target="_blank">HR CORRELATIVO 17-22</a></li>
	  <li><a href="hoja_ruta_correlativo23_28.php" target="_blank">HR CORRELATIVO 23-28</a></li>
	  <li><a href="hoja_ruta_correlativo29_34.php" target="_blank">HR CORRELATIVO 29-34</a></li>
	  <li><a href="hoja_ruta_correlativo35_40.php" target="_blank">HR CORRELATIVO 35-40</a></li>
    </ul>
   </li>
    <li><a href="usuarioperfil.php">CAMBIAR CONTRASEÑA</a></li>
	<li><a href="#">FORMULARIOS</a>
		<ul>
		  <li><a href="documentos/FOR_VAC_FCP21.xls" target="_blank">FORMULARIO-VAC</a></li>
		  <li><a href="documentos/PROGRAMACION DE VACACIONES 2015-1.xls" target="_blank">PROGRAMACION_VAC</a></li>
		  <li><a href="documentos/contactodes.txt" target="_blank">CONTACTOS</a></li>
		</ul>
	</li>
 </ul> 
 <br>
<?php    
 }
 else
 {
?>

 <ul id="navmenu">
  <li><a href="menucon.php">INICIO</a>
    <ul>
	  <li><a href="menu2.php">BAN. ENTRADA</a></li>
	  <li><a href="menu3.php">BAN. PENDIENTES y SALIDA</a></li>
     </ul>
  </li>
  <li><a href="for_nuevo_doc2.php">NUEVO DOCUMENTO</a>
  <li><a href="listado_de_mi2.php">LISTA DE ARCHIVOS GENERADOS</a></li>
  <li><a href="#">SEGUIMIENTO</a>
    <ul>
		<li><a href="listado_general2.php">SEGUIMIENTO INTERNO</a></li>    
		<li><a href="listado_general3.php">SEGUIMIENTO EXTERNO</a></li>    
  	</ul>
  </li>
  <li><a href="usuarioperfil.php">CAMBIAR CONTRASEÑA</a></li>
  <li><a href="documentos/Manual de Usuario SOFTCOM.pdf" target="_blank">AYUDA</a></li>
  <li><a href="#">PDF'S</a>
    <ul>
      <li><a href="hoja_ruta_correlativo.php" target="_blank">HR CORRELATIVO 5-10</a></li>
	  <li><a href="hoja_ruta_correlativo11_16.php" target="_blank">HR CORRELATIVO 11-16</a></li>
	  <li><a href="hoja_ruta_correlativo17_22.php" target="_blank">HR CORRELATIVO 17-22</a></li>
	  <li><a href="hoja_ruta_correlativo23_28.php" target="_blank">HR CORRELATIVO 23-28</a></li>
	  <li><a href="hoja_ruta_correlativo29_34.php" target="_blank">HR CORRELATIVO 29-34</a></li>
	  <li><a href="hoja_ruta_correlativo35_40.php" target="_blank">HR CORRELATIVO 35-40</a></li>
    </ul>
   </li>  
   <li><a href="#">FORMULARIOS</a>
		<ul>
		  <li><a href="documentos/FOR_VAC_FCP21.xls" target="_blank">FORMULARIO-VAC</a></li>
		  <li><a href="documentos/PROGRAMACION DE VACACIONES 2015-1.xls" target="_blank">PROGRAMACION_VAC</a></li>
		  <li><a href="documentos/contactodes.txt" target="_blank">CONTACTOS</a></li>
		</ul>
	  </li>	  
</ul>

<?php
}
}
?>

</TD>
</tr>
<tr>
<TD WIDTH="100%" VALIGN="TOP" bgcolor="">

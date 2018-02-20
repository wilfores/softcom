<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.0 Transitional//EN">
<HTML><HEAD>
<?php
$tiempo = time();
$cc=date("j", $tiempo);
$bb=date("n", $tiempo);
$aa=date("Y", $tiempo);
?>
<TITLE>Software de Correspondencia Ministerial</TITLE>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<!--<meta http-equiv="Content-Type" content="text/html; ISO-8859-1">-->
<META NAME="DC.Language" SCHEME="RFC1766" CONTENT="Spanish">
<META NAME="AUTHOR" CONTENT="Jose luis Delgado">
<META NAME="REPLY-TO" CONTENT="lui_delgado@yahoo.com">
<LINK REV="made" href="mailto:lui_delgado@yahoo.com">
<META NAME="DESCRIPTION" CONTENT="Escritorio virtual del funcionario publico">
<META NAME="KEYWORDS" CONTENT="Escritorio virtual funcionario publico">
<META NAME="Resource-type" CONTENT="Document">
<META NAME="DateCreated" CONTENT="28-06-2012">
<META NAME="Revisit-after" CONTENT="5 days">
<META NAME="robots" content="NOFOLLOW">
<LINK  href="script/qstyle.css" rel=stylesheet type=text/css>
<link rel="stylesheet" type="text/css" href="sicor/script/acerca.css">
<link rel="stylesheet" type="text/css" href="sicor/script/estilos2.css" title="estilos2" />
<LINK  href="sicor/script/styles.css" rel=stylesheet type=text/css>
<script language="JavaScript" src="sicor/script/ie.js" type="text/JavaScript"></script>
<script>
function seleccionar_todo()
{//Funcion que permite seleccionar todos los checkbox

form = document.forms["enviar"]
for (i=0;i<form.elements.length;i++)
    {
    if(form.elements[i].type == "checkbox")form.elements[i].checked=1;
    }
} 
function seleccionar_todo_2()
{//Funcion que permite seleccionar todos los checkbox

form = document.forms["enviar2"]
for (i=0;i<form.elements.length;i++)
    {
    if(form.elements[i].type == "checkbox")form.elements[i].checked=1;
    }
} 

function deseleccionar_todo()
{//Funcion que permite deseleccionar todos los checkbox

form = document.forms["enviar"]
for (i=0;i<form.elements.length;i++)
    {
    if(form.elements[i].type == "checkbox")form.elements[i].checked=0;
    }
}
function deseleccionar_todo_2()
{//Funcion que permite deseleccionar todos los checkbox

form = document.forms["enviar2"]
for (i=0;i<form.elements.length;i++)
    {
    if(form.elements[i].type == "checkbox")form.elements[i].checked=0;
    }
}


function seleccionar_todo2()
{//Funcion que permite seleccionar todos los checkbox

form = document.forms["regresar"]
for (i=0;i<form.elements.length;i++)
    {
    if(form.elements[i].type == "checkbox")form.elements[i].checked=1;
    }regresar
} 

function seleccionar_todo2_2()
{//Funcion que permite seleccionar todos los checkbox

form = document.forms["regresar2"]
for (i=0;i<form.elements.length;i++)
    {
    if(form.elements[i].type == "checkbox")form.elements[i].checked=1;
    }regresar
} 

function deseleccionar_todo2()
{//Funcion que permite deseleccionar todos los checkbox

form = document.forms["regresar"]
for (i=0;i<form.elements.length;i++)
    {
    if(form.elements[i].type == "checkbox")form.elements[i].checked=0;
    }
}

function deseleccionar_todo2_2()
{//Funcion que permite deseleccionar todos los checkbox

form = document.forms["regresar2"]
for (i=0;i<form.elements.length;i++)
    {
    if(form.elements[i].type == "checkbox")form.elements[i].checked=0;
    }
}

</script>
<body style="background-color: #BCCFEF;" class="caja_texto" bgcolor="#BCCFEF">

<table border="0" cellpadding="0" cellspacing="0" width="100%" align="center">
    <tbody>
		<tr>		
			<td width="100%" height="100" align="center"><img src="images/banner_1.jpg" ></td>
		</tr>
	</tbody>
</table>

<table width="965" border="0" cellspacing="0" cellpadding="0" align="center">
<tr class="border_tr">
<td align="left" height="25px" background="images/barra_medio.gif">
    <table border="0">
        <tr>
            <td width="900" align="left">
            <span class="parrafo_izquierda" style="font-size: 10px;">
                <?php
    	          $dias = array("Domingo","Lunes","Martes","Miercoles","Jueves","Viernes","Sabado");
                    $mes = array(" ","enero","febrero","marzo","abril","mayo","junio","julio","agosto","septiembre","octubre","noviembre","diciembre");
                    echo "<font size=2pt><b>Usuario:</b>".$_SESSION["nom"]."</font>";?>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<?php
    	             echo $dias[date('w')].", ".date("d")." de ".$mes[date('n')]." de ".date("Y");
                ?></span>
            </td>
			<td width="65" align="right">
			<form action='salir.php'>
            <input style="font-size: 9px; color: blue;" type="submit" value="Cerrar Sesion" name="enviar" />
            </form>
            </td>
            
        </tr>
    </table>
</td>
</tr>
</table>

<table width="965" align="center" cellspacing="0" cellpadding="0" BORDER="0" class="border_table">
<tr>
<?php
if($_SESSION["nivel"]=='4')
{
?>
<td WIDTH="965" background="images/bg22.gif">
<ul id="navmenu">
  <li><a href="institucion.php">INSTITUCION</a></li>
  <li><a href="edificio.php">EDIFICIOS</a></li>
  <li><a href="#">UNIDADES</a>
     <ul>
      <li><a href="departamento.php">LISTADO DE UNIDADES</a></li>
      <li><a href="departamentonuevo.php">ADICIONAR UNIDAD</a></li>
     </ul>
  </li>
  <li><a href="archivo.php">CREAR ARCHIVOS</a></li>   
  <li><a href="#">CARGOS</a>
     <ul>
      <li><a href="cargos.php">LISTADO DE CARGOS</a></li>
      <li><a href="cargonuevo.php">ADICIONAR CARGOS</a></li>
     </ul>
  </li>	 
  <li><a href="adminusuarios.php">USUARIOS</a></li>
  <li><a href="usuarioderivacion.php">DERIVACIONES</a></li>
  <li><a href="#">ADM. ARCHIVOS</a>
     <ul>
      <li><a href="asignar.php">ASIGNAR USUARIO</a></li>
      <li><a href="asignar2.php">ASIGNAR TIPO DOC</a></li>
     </ul>
   </li> 
  
  
 <!-- <li><a href="#">ADMINISTRACION</a>
     <ul>
      <li><a href="tipo_documento.php">TIPO DE DOCUMENTO</a></li>
      <li><a href="instrucciones.php">INSTRUCCIONES</a></li>
      <li><a href="config.php">LOGO INSTITUCIONAL</a></li>
      <li><a href="usuarioderivacion.php">DERIVACIONES</a></li>
     </ul>
   </li>-->
  <li><a href="listado_organigrama_msd.php">ORGANIGRAMA</a></li>
  <li><a href="listado_de_cargos_usuario.php">LISTADO CARGOS</a>
      <ul>
      <!--<li><a href="listado_de_cargos_usuario.php">LISTADO DE CARGOS</a></li>
	 <li><a href="asignar_usu_cred.php">ASIGNAR CREDENCIAL</a></li>-->
	  <ul>
  </li>
   <li><a href="#">PDF'S</a>
    <ul>
      <li><a href="sicor/hoja_ruta_correlativo.php" target="_blank">HR CORRELATIVO 5-10</a></li>
	  <li><a href="sicor/hoja_ruta_correlativo11_16.php" target="_blank">HR CORRELATIVO 11-16</a></li>
	  <li><a href="sicor/hoja_ruta_correlativo17_22.php" target="_blank">HR CORRELATIVO 17-22</a></li>
	  <li><a href="sicor/hoja_ruta_correlativo23_28.php" target="_blank">HR CORRELATIVO 23-28</a></li>
	  <li><a href="sicor/hoja_ruta_correlativo29_34.php" target="_blank">HR CORRELATIVO 29-34</a></li>
	  <li><a href="sicor/hoja_ruta_correlativo35_40.php" target="_blank">HR CORRELATIVO 35-40</a></li>
    </ul>
   </li>
  <!--<li><a href="salir.php">AYUDA</a></li>-->
</ul>
</td>
<?php 
}
if ($_SESSION["nivel"]=='3')
{
?>
    <td width="965" background="images/bg22.gif">
    <ul id="navmenu">
      <li><a href="institucion.php">INSTITUCIONES</a></li>
      <li><a href="adminusuarios.php">USUARIO ADMINISTRADOR</a></li>
      <li><a href="#">CAMBIO DE GESTI&Oacute;N</a>
         <ul>
          <li><a href="crearbd.php">MIGRAR BASE DE DATOS</a></li>
         </ul>
      </li>  
	  <li><a href="#">UNIDADES</a>
		 <ul>
		  <li><a href="departamento.php">LISTADO DE UNIDADES</a></li>
		  <li><a href="departamentonuevo.php">ADICIONAR UNIDAD</a></li>
		 </ul>
  	  </li>  
	  <li><a href="#">CARGOS</a>
		 <ul>
		  <li><a href="cargos.php">LISTADO DE CARGOS</a></li>
		  <li><a href="cargonuevo.php">ADICIONAR CARGOS</a></li>
		 </ul>
      </li>	 
	  <li><a href="adminusuarios.php">USUARIOS</a></li>
	  <li><a href="#">ADMINISTRACION</a>
		 <ul>
		  <!--<li><a href="tipo_documento.php">TIPO DE DOCUMENTO</a></li>
		  <li><a href="instrucciones.php">INSTRUCCIONES</a></li>
		  <li><a href="config.php">LOGO INSTITUCIONAL</a></li>-->
		  <li><a href="usuarioderivacion.php">DERIVACIONES</a></li>
		 </ul>
	   </li>
	  <li><a href="#">ADM. ARCHIVOS</a>
		 <ul>
		  <li><a href="archivo.php">CREAR ARCHIVOS</a></li>
		  <li><a href="asignar.php">ASIGNAR USUARIO</a></li>
		  <li><a href="asignar2.php">ASIGNAR TIPO DOC</a></li>
		 </ul>
	   </li> 
	   <li><a href="listado_organigrama_msd.php">ORGANIGRAMA</a></li>
	   <li><a href="listado_de_cargos_usuario.php">LISTADO CARGOS</a></li>
	  <li><a href="#">PDF'S</a>
		<ul>
		  <li><a href="sicor/hoja_ruta_correlativo.php" target="_blank">HR CORRELATIVO 5-10</a></li>
		  <li><a href="sicor/hoja_ruta_correlativo11_16.php" target="_blank">HR CORRELATIVO 11-16</a></li>
		  <li><a href="sicor/hoja_ruta_correlativo17_22.php" target="_blank">HR CORRELATIVO 17-22</a></li>
		  <li><a href="sicor/hoja_ruta_correlativo23_28.php" target="_blank">HR CORRELATIVO 23-28</a></li>
		  <li><a href="sicor/hoja_ruta_correlativo29_34.php" target="_blank">HR CORRELATIVO 29-34</a></li>
		  <li><a href="sicor/hoja_ruta_correlativo35_40.php" target="_blank">HR CORRELATIVO 35-40</a></li>
		</ul>
	   </li>	   
      <li><a href="reporte_proyect.php">REPORTE PROYECTO</a></li>
    </ul>
    </td>

<?php
}
if($_SESSION["nivel"]=='2')
{
?>
<td WIDTH="965" background="images/bg22.gif">
<ul id="navmenu">
  <!--
  <li><a href="#">CARGOS</a>
     <ul>
      <li><a href="cargos.php">LISTADO DE CARGOS</a></li>
      <li><a href="cargonuevo.php">ADICIONAR CARGOS</a></li>
     </ul>
  </li>	
-->  
  <li><a href="adminusuarios.php">USUARIOS</a></li>
  <li><a href="usuarioderivacion.php">DERIVACIONES</a></li>

  <li><a href="#">ADM. ARCHIVOS</a>
    <ul>
      <li><a href="asignar.php">ASIGNAR USUARIO</a></li>
      <li><a href="asignar2.php">ASIGNAR TIPO DOC</a></li>
     </ul>
   </li> 
  <li><a href="listado_organigrama_msd.php">ORGANIGRAMA</a></li>
  <li><a href="listado_de_cargos_usuario.php">LISTADO CARGOS</a></li>
  <li><a href="#">PDF'S</a>
    <ul>
      <li><a href="sicor/hoja_ruta_correlativo.php" target="_blank">HR CORRELATIVO 5-10</a></li>
	  <li><a href="sicor/hoja_ruta_correlativo11_16.php" target="_blank">HR CORRELATIVO 11-16</a></li>
	  <li><a href="sicor/hoja_ruta_correlativo17_22.php" target="_blank">HR CORRELATIVO 17-22</a></li>
	  <li><a href="sicor/hoja_ruta_correlativo23_28.php" target="_blank">HR CORRELATIVO 23-28</a></li>
	  <li><a href="sicor/hoja_ruta_correlativo29_34.php" target="_blank">HR CORRELATIVO 29-34</a></li>
	  <li><a href="sicor/hoja_ruta_correlativo35_40.php" target="_blank">HR CORRELATIVO 35-40</a></li>
    </ul>
   </li>
  <!--<li><a href="archivado_directo.php">LISTADO CARGOS</a></li>-->
</ul>
</td>
<?php
}
?>
</tr>
</table>

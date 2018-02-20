<?php
include("filtro_adm.php");
?>
<?php
include("inicio.php");
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
$codigo=$_SESSION["codigo"];
$tiempo = time();
$cc=date("d", $tiempo);
$bb=date("m", $tiempo);
$aa=date("Y", $tiempo);
$fecha_hoy=$aa."-".$bb."-".$cc;
?>
<?php
$ssql = "SELECT * FROM usuario WHERE '$codigo'=usuario_cod_usr";
$rs = mysql_query($ssql, $conn);
if ($row = mysql_fetch_array($rs)) 
{ $nombre=$row["usuario_nombre"];
}
?>


<center>

<table width="100%" >
<tr >
<td colspan="2" width="75%" valign="top">

<!--
    <table width="100%">
    <tr>
    <td valign="top" align="center">
    <br>
    <br>
        <table width="60%"  border="0" align="center" cellpadding="0" cellspacing="0" bordercolor="#006699">
                <tr>
                  <td background="images/tablita.gif">
                   <div align="left" >
                      <font size="2pt" color="#ffffff"><b>Bienvenido(a):</b></font>
                  </div>
                 </td>
                </tr>
        </table>
     <table width="60%"  border="1" align="center" bgcolor="#ffffff" cellpadding="5" cellspacing="0" bordercolor="#006699">
            <tr>
             <th scope="col" background="images/fondo1.gif">
             <div align="left">         
                       
        <span class="fuente_normal_imp">
        <hr width="100%" size="1" >
        </span>
        <span class="fuente_normal_imp">
        <p align="justify">
        Sr(a): <?php echo "<b>".strtoupper($nombre)."</b>";?> al 
        <b>SISTEMA de CORRESPONDENCIA</b> del funcionario p&uacute;blico. En este sitio usted encontrar&aacute; 
        herramientas digitales que contribuir&aacute;
        n a impulsar eficazmente el desarrollo integral de la sociedad de la informaci&oacute;n en nuestro pa&iacute;s.
        </p>
        
        <p align="justify">
        El <b>SISTEMA DE CORRESPONDENCIA</b> 
        representa una apuesta clara y decidida de la Agencia para el 
        Desarrollo de la Sociedad de la Informaci&oacute;n en Bolivia - ADSIB, 
        para coadyuvar al Estado en la construcci&oacute;n y la aplicaci&oacute;n de 
        nuevas tecnolog&iacute;as de informaci&oacute;n en Bolivia.
        </p>
        </span>
        
        <br>
        <br>
               <div align="center">
                <form  method="post" action="usuarioperfil.php">
               <?php echo "<input type=\"submit\" value=\"ACTUALIZACI&Oacute;N DE DATOS\" class=\"boton\"/>";?>
                </form>
                </div>
        
        </td>
        </tr>
    </table>
    </div>
    </th>
    </tr>
    </table>
    -->
    
</td>
<!--inicio del final php-->

<!--fin del final php-->

<?php
include("final.php");
?>

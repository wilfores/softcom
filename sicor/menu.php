<?php 
include("../filtro.php");
?>
<?php
include("inicio.php");
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
//$codigo=$_SESSION["codigo"];
$codigo=$_SESSION["cargo_asignado"];
$cargo_fun=$_SESSION["cargo_fun"];
$depto=$_SESSION["departamento"];

echo "$codigo cargo<br />";
echo "$depto depto";
$tiempo = time();
$cc=date("j", $tiempo);
$bb=date("n", $tiempo);
$aa=date("Y", $tiempo);
$fecha_hoy=$aa."-".$bb."-".$cc;
?>
<?php
$ssql = "SELECT * FROM usuario WHERE '$codigo'=usuario_ocupacion";
$rs = mysql_query($ssql, $conn);
if ($row = mysql_fetch_array($rs)) 
{ $nombre=$row["usuario_nombre"];
}

$ssql_c = "SELECT * FROM cargos WHERE '$codigo'=cargos_id";
$rs_c = mysql_query($ssql_c, $conn);
if ($row_c = mysql_fetch_array($rs_c)) 
{ 
	$_SESSION["cargo_fun"]=$row_c["cargos_cargo"];
}

?>
<center>

<?php
$ssql = "SELECT * FROM usuario WHERE '$codigo'=usuario_ocupacion";
$rs = mysql_query($ssql, $conn);
if ($row = mysql_fetch_array($rs)) 
{ $nombre=$row["usuario_nombre"];
}

$ssql_1="select distinct (seguimiento_hoja_ruta) from seguimiento where seguimiento_estado = 'P'";
$rss_1=mysql_query($ssql_1,$conn);
$cont_pendiente=mysql_num_rows($rss_1);

$ssql_2="select distinct (seguimiento_hoja_ruta) from seguimiento where seguimiento_estado = 'T'";
$rss_2=mysql_query($ssql_2,$conn);
$cont_terminado=mysql_num_rows($rss_2);

// Implementado 
$ssql="SELECT * FROM seguimiento WHERE '$codigo'=seguimiento_destinatario AND (seguimiento_tipo='A' OR seguimiento_tipo='R') AND seguimiento_estado='P' ORDER BY seguimiento_fecha_deriva DESC";
	$rss=mysql_query($ssql,$conn);
	$urgente=0;
	$alta=0;
	$media=0;
	$baja=0;
	
	
	
 while($row=mysql_fetch_array($rss))
	{	$limite= $row["seguimiento_fecha_plazo"];
	  $fechalimite_plazo=explode("-",$limite);
      if (($limite <= date("Y-m-d")) AND ($fechalimite_plazo[0] > '2000'))
       {
         //echo "<img src=\"images/alerta.gif\" border=0 align=center/>";
		 $urgente=$urgente+1;
       }
	  switch ($row["seguimiento_prioridad"])
		{
			//case 'Alta':echo "<img src=images/alta.gif>"; $alta=$alta+1;break;
			//case 'Media':echo "<img src=images/media.gif>";$media=$media+1;break;
			//case 'Baja':echo "<img src=images/baja.gif>";$baja=$baja+1;break;
			
			case 'Alta': $alta=$alta+1;break;
			case 'Media':$media=$media+1;break;
			case 'Baja':$baja=$baja+1;break;
			
		}
		
	 }
	 $t_doc=$alta+$media+$baja;
	?>
		<!--	
		<script language ='JavaScript'>
		    alert('PENDIENTES...\nNo respondidas en el plazo establecido <?php echo $urgente;?> correspondencias...\nDETALLE...\nCorrespondencias de prioridad ALTA 			<?php echo  $alta; ?>\nCorrespondencias de prioridad MEDIA <?php echo $media; ?>\nCorrespondencias de prioridad BAJA <?php echo $baja; ?>');
		</script>-->
		    <script language='JavaScript'> 
    
			/*window.alert('Usted tiene los siguientes documentos en su bandeja \n.\n.\nCorrespondencia Pendiente <?php echo $t_doc;?>');*/
				
    		</script>

<!--
<table width="100%" align="center" cellspacing="0" bgcolor="#BCCFEF">
<tr>
<td valign="top" align="center">
<br>-->


<br>
<?
if (($_SESSION["cargo"] == "Ventanilla") or  ($_SESSION["cargo"]=="Secretaria"))
  { /*genera la tabla de la secretaria y su menu*/
  ?>
  
  <table width="950" height="600" border="0px" align="center" cellpadding="0" cellspacing="0" bgcolor="#BCCFEF">
    
    <tr>    
	  <td width="150px" rowspan="0">	 
        <iframe height="100%" width="200px" frameborder="0" name="menuFrame" scrolling="no" src="menu_sec.php">
        </iframe>
	  </td>
	  <!-- fin de menu -->
      
	  <td width="*"> 
        <table cellpadding="0px" cellspacing="0px" width="100%" height="100%" border="1px" >               
          <tr height="*">		  
            <td width="*" style="background-image:url(images/d14.gif); background-repeat:repeat;">
                 <iframe  height="100%" width="100%" frameborder="0" name="mainFrame" scrolling="si" src="recep_sec.php">
                 </iframe>
            </td>
		  </tr>
          
          <tr height="1px">
            <td>
            </td>
		  </tr>
		</table> 
	  </td>


	  <td width="10px"> 
        <table cellpadding="0px" cellspacing="0px" width="100%" height="100%" border="0px" >
          	   
          <tr height="33px">
            <td style="background-image:url(images/d101.gif); background-repeat:no-repeat;">
            </td>
          </tr>  	   
		</table> 
	  </td>

	</tr>  
  </table>
    
    
<?    
  }
  else
  {
  
    
    echo "esto es la tabla del personal";
?>
  <table width="950" height="600" border="0px" align="center" cellpadding="0" cellspacing="0" bgcolor="#BCCFEF">
    
    <tr>    
	  <td width="150px" rowspan="0">	 
        <iframe height="100%" width="200px" frameborder="0" name="menuFrame" scrolling="no" src="../menu_izq_personal.php">
        </iframe>
	  </td>
	  
      
	  <td width="*"> 
        <table cellpadding="0px" cellspacing="0px" width="100%" height="100%" border="1px" >               
          <tr height="*">		  
            <td width="*" style="background-image:url(images/d14.gif); background-repeat:repeat;">
                 <iframe  height="100%" width="100%" frameborder="0" name="mainFrame" scrolling="si" src="menu_desplegable.php">
                 </iframe>
            </td>
		  </tr>
          
          <tr height="1px">
            <td>
            </td>
		  </tr>
		</table> 
	  </td>


	  <td width="10px"> 
        <table cellpadding="0px" cellspacing="0px" width="100%" height="100%" border="0px" >
          	   
          <tr height="33px">
            <td style="background-image:url(images/d101.gif); background-repeat:no-repeat;">
            </td>
          </tr>  	   
		</table> 
	  </td>

	</tr>  
  </table>

    
<?    
  }
?>

 <!--
<table width="60%"  border="0" align="center" cellpadding="0" cellspacing="0" bordercolor="#006699">
        <tr>
          <td background="../images/tablita.gif">
           <div align="left" >
               <font size="2pt" color="#ffffff"><b>Bienvenido(a):</b></font>
          </div>
         </td>
        </tr>
</table>
    
    <table width="60%"  border="0" align="center" bgcolor="#ffffff" cellpadding="5" cellspacing="0" bordercolor="#006699">
        <tr>
            <th scope="col" background="../images/fondo1.gif">
            <div align="left">      
                           
        <br /> 
            
        <span class="fuente_normal_imp">
            <p align="justify">
            Sr(a): <?php echo "<b>".strtoupper($nombre)."</b>";?> al <b>SISTEMA DE CORRESPONDENCIA</b> del funcionario p&uacute;blico. En este sitio usted encontrar&aacute; herramientas digitales que contribuir&aacute;n a impulsar eficazmente el desarrollo integral de la sociedad de la informaci&oacute;n en nuestro pa&iacute;s.
            </p>
    
            <p align="justify">
            El <b>SISTEMA DE CORRESPONDENCIA</b> representa una apuesta clara y decidida de la Agencia para el Desarrollo de la Sociedad de la Informaci&oacute;n en Bolivia - ADSIB, para coadyuvar al Estado en la construcci&oacute;n y la aplicaci&oacute;n de nuevas tecnolog&iacute;as de informaci&oacute;n en Bolivia.
            </p>
            <table width="100%">
                <tr>
                    <td><span class="fuente_normal_imp"><p align="justify">
                    <b>CORRESPONDENCIA PENDIENTE</b> <BR><BR>
                    &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<img src="images/alerta.gif" border=0 align=center/> No respondida en el plazo establecido  <?php echo $urgente;?><BR>
                    &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<img src=images/alta.gif> Correspondencia de prioridad <B>ALTA&nbsp;&nbsp;  <?php echo $alta;?></B><BR>
                    &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<img src=images/media.gif> Correspondenica de prioridad <B>MEDIA  <?php echo $media;?></B><BR>
                    &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<img src=images/baja.gif> Correspondencia de prioridad <B>BAJA&nbsp;&nbsp; <?php echo $baja;?></B><BR>
                    </p></span>
                    </td>
            		<td><span class="fuente_normal_imp"><p align="justify">
                    <b>SEGUIMIENTO CORRESPONDENCIA</b> <BR><BR>
                    &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Total correspondencia  <?php echo $urgente;?><BR>
                    &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<img src=images/alta.gif> Correspondencia Pendiente <B>&nbsp;&nbsp;  <?php echo $cont_pendiente_1;?></B><BR>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<img src=images/baja.gif> Correspondencia Finalizada<B>&nbsp;&nbsp;  <?php echo $cont_terminado_1;?></B><BR><BR>
                    </p></span>
                    </td>
        		</tr>
    		</table>      
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
     -->
 <!--       
 </div>
 </th>
</tr>
</table>-->

</center>

<?php
include("final.php");
?>

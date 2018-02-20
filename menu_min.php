<!--<html>  
 <head> 
  <title>Software de Correspondencia Ministerial</title>   
  <meta http-equiv=Content-Type content="text/html; charset=iso-8859-1">
  <meta name="author" content="Area de Sistemas e Informatica - Ministerio de Salud y Deportes">
  <meta name="date" content="2012-05-01">  
  
</head>

<body bgcolor="#BCCFEF" onkeydown="return false">
<table border="0" cellpadding="0" cellspacing="0" width="965" align="center">

	<tbody>
		<tr>		
			<td width="964" height="100" align="center"><img src="images/banner_1.jpg" ></td>
		</tr>
	</tbody>
    
    
</table>-->

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

  <table width="950" height="50%" border="0px" align="center" cellpadding="0" cellspacing="0" bgcolor="#BCCFEF">
    
    <tr>    
	  <td width="100px" rowspan="0" >	 
        <iframe  height="80%" width="100px" frameborder="0" name="menuFrame" scrolling="no" src="menu_izq_personal.php">
        </iframe>
	  </td>
	  <!-- fin de menu -->
      
	  <td width="*"> 
        <table cellpadding="0px" cellspacing="0px" width="100%" height="80%" border="1px" bgcolor="#BCCFEF">               
          <tr height="*">		  
            <td width="*" style="background-image:url(images/d14.gif); background-repeat:repeat;">
                 <iframe  height="80%" width="100%" frameborder="0" name="mainFrame" scrolling="no" src="sicor/menu_desplegable.php">
                 </iframe>
            </td>
		  </tr>
          
          <tr height="1px">
            <td>
            </td>
		  </tr>
		</table> 
	  </td>

<!--
	  <td width="10px"> 
        <table cellpadding="0px" cellspacing="0px" width="100%" height="100%" border="0px" >
          	   
          <tr height="33px">
            <td style="background-image:url(images/d101.gif); background-repeat:no-repeat;">
            </td>
          </tr>  	   
		</table> 
	  </td>
-->
	</tr>  
  </table>
</center>  
<?php
include("final.php");
?>
<!-- 
<br>  
</body>
</html>--> 
  

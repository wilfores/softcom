<html>
<HEAD>
<TITLE>Software de Correspondencia Ministerial</TITLE>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
<META NAME="DC.Language" SCHEME="RFC1766" CONTENT="Spanish">
<META NAME="AUTHOR" CONTENT="Ing. Jose Luis Delgado">
<META NAME="Resource-type" CONTENT="Document">
<META NAME="DateCreated" CONTENT="23-04-2012">
<META NAME="Revisit-after" CONTENT="1 days">
<META NAME="robots" content="ALL">
<link rel="stylesheet" type="text/css" href="sicor/script/estilos2.css" title="estilos2" />
<link href="images/bol_ico.ico" type="image/x-icon" rel="shortcut icon" />
<style type="text/css">
   body {
         padding:10px 10px;
         height:100%;
         width:100%;
         filter:progid:DXImageTransform.Microsoft.gradient(startColorstr=#BCCFEF, endColorstr=#FFFFFF, GradientType=0);
   		}

</style>

</HEAD>

<BODY bgcolor="#BCCFEF">
<center>
<br /><br />
<br /><br />
<br /><br />
<br /><br />
<br /><br />

<form method="post" action="control.php" >

    <strong style="font-size:17px; color: #0000CC; font-family:Verdana, Arial, Helvetica, sans-serif">¡Bienvenido al Software de Correspondencia Ministerial!</strong>
    <br /> 
    <table width="400" border="0" align="center" cellpadding="2" cellspacing="2">
      <tr>
      	<?php
			if(empty($_REQUEST['errorusuario']))
			 {
			 ?>
				<td colspan="2"><div align="center"></div></td>
			 <?php
			 }
			 else
			  {
			 ?>
			 	<td colspan="2">
                 <div align="center" style="color: #CC0033; font-size: 12px;">
                 <strong>!! ERROR EN EL INGRESO !!<br>
                 Intente de Nuevo Por Favor
                 </strong>
                 </div>
                 </td>
			 <?php
			 }
			$siteurl = $_SERVER['REQUEST_URI']; 
			$GLOBALS['siteurl'] = $siteurl; 
			require('gtres.php'); 
			//echo "$width <br>"; 
			//echo "$height";
			?> 		
        </tr>
	   <tr>
        <td align="right">Usuario:</td>
        <td><input type="text" name="username"></td>
      </tr>
      <tr>
        <td align="right">Clave:</td>
        <td><input type="password" name="clave"></td>
      </tr>
	  <input type="hidden" name="ancho" value="<?php echo $width; ?>" >   
      <tr>      
        <td style="color:#660000; font-size:17px" align="right">Selecione la Gestion:</td>
        <td><select name="camb_gest">
		<option value="2015" selected>2015</option>
		<option value="0" selected>Elegir la Gestion...</option>
		</select>
		</td>
      </tr>
     
      <tr>
        <td colspan="2" class="">
		  <div align="center">
		    <input type="submit" value="Ingresar" name="enviar">
            &nbsp;&nbsp;&nbsp;
            <input name="limpiar" type="reset" value="Limpiar" />
          </div>
        </td>
      </tr>
    </table>
</form>
</center>
</BODY>
</HTML>
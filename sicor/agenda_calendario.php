<?php

//include ("inicio.php");
##||||             agenda_calendario.php              ||||##
##|||  Escritorio Virtual  v.0.1  ramiro@adsib.gov.bo  |||##
##||   ----------------------------------------------   ||##
##||||                2003/03/05  13:02               ||||##


//global $username, $id_usr;

##||||
##|||  Genera un calendario
##||i

$meses = array("","ENERO","FEBRERO","MARZO","ABRIL","MAYO","JUNIO","JULIO","AGOSTO","SEPTIEMBRE","OCTUBRE","NOVIEMBRE","DICIEMBRE");
$dias = array("DOMINGO","LUNES","MARTES","MIERCOLES","JUEVES","VIERNES","SABADO");
$diasc = array("DOMINGO","LUNES","MARTES","MIERCOLES","JUEVES","VIERNES","SABADO");
//$diasc = array("LANG_SUNDAY","LANG_MONDAY","LANG_TUESDAY","LANG_WEDNESDAY","LANG_THURSDAY","LANG_FRIDAY","LANG_SATURDAY");

?>

<html>
<head>
<title>Calendario</title>
<meta http-equiv="Content-Type" content="text/html; charset=---CHARSET---">
<style type="text/css">
<!--
body {  font-family: Trebuchet MS, Arial, Helvetica, sans-serif; font-size: 11px
}
td {  font-family: Trebuchet MS, Arial, Helvetica, sans-serif; font-size: 11px}
a:link {text-decoration: none}
a:hover {text-decoration: underline; color: #CC3300}
a:visited {text-decoration: none}
.plr2 {  padding-right: 2px; padding-left: 2px}
.p2 {  padding: 2px}
.bluenav {  color: #FFFFFF; padding-right: 3px; padding-left: 3px}
.black {  color: #000000; text-decoration: none}
.black:link {  text-decoration: none}
.black:hover {  color: #FFFFFF; text-decoration: underline}
.black:visited {  text-decoration: none}
.menu {  color: #000000; text-decoration: none}
.menu:link {  text-decoration: none}
.menu:hover {  color: #CC0000; text-decoration: underline}
.menu:visited {  text-decoration: none}
.white {  color: #FFFFFF; text-decoration: none}
.white:link {  text-decoration: none}
.white:hover {  color: #E8E8E8; text-decoration: underline}
.white:visited {  text-decoration: none}
.green {  color: green; text-decoration: none}
.green:link {  text-decoration: none}
.green:hover {  color: #CC3300; text-decoration: underline}
.green:visited {  text-decoration: none}
.loginbox {  font-family: Arial, Helvetica, sans-serif; font-size: 9px; background-color: #E8E8E8; border: #000000; border-style: solid; border-top-width: 1px; border-right-width: 1px; border-bottom-width: 1px; border-left-width: 1px}
.monthyear {  font-family: Trebuchet MS, Arial, Helvetica, sans-serif; font-size: 18px; font-style: normal; line-height: normal; font-weight: bold; color: #000000; text-decoration: none}
.daynames {  font-family: Trebuchet MS, Helvetica, sans-serif; font-size: 9px; font-style: normal; font-weight: normal; color: #000000; text-decoration: none}
.dates {  font-family: Trebuchet MS, Arial, Helvetica, sans-serif; font-size: 9px; font-style: normal; font-weight: normal; color: #000000; text-decoration: none}
.border {border: #CC3300; border-style: solid; border-top-width: 1px; border-right-width: 1px; border-bottom-width: 1px; border-left-width: 1px}
.box {  font-family: Arial, Helvetica, sans-serif; font-size: 9px; border: #000000; border-style: solid; border-top-width: 1px; border-right-width: 1px; border-bottom-width: 1px; border-left-width: 1px}
-->
</style>
</head>
<body bgcolor="#FFFFFF" text="#000000" link="#0066CC" vlink="#0066CC" alink="#0066CC" leftmargin="0" topmargin="0" marginwidth="0" marginheight="0">

<?php

##
## Recopila toda la informacion
##

if (!$HTTP_POST_VARS) {
	list($dia,$mes,$ano,$diasem)=split('\|',date("j|n|Y|w",time()));
    	$nom_mes = $meses["$mes"];
   	}

if(isset($funcion)) { 
	list($dia,$mes,$ano)=split('\|',date("j|n|Y",mktime(0,0,0,$mes,$dia,$ano)));
	$nom_mes = $meses["$mes"]; 
	unset($funcion);
	}

?>

<table border="0" cellspacing=0 cellpadding=2 align="center">
  <tr align="center" valign="middle">
    <td height="25" valign="top" bgcolor="#2F6669">
      <table width="100%" border="0" cellpadding="1" cellspacing="1">
        <tr align="center" valing="middle">
	<form method="post" action="<?php echo $PHP_SELF; ?>">
          <td>
              <input type="hidden" name="funcion" value="ala">
              <input type="hidden" name="fch" value="<?php echo $fch;?>">
              <input type="hidden" name="dia" value="<?php echo $dia;?>">
              <input type="hidden" name="mes" value="
<?php

##
## Mes anterior
##

if (($mes-1) < 1 ) echo "12"; 
else echo $mes-1; 
?>
		">
	    <input type="hidden" name="ano" VALUE="
<?php

##
## Ano anterior
##

if (($mes-1)<1) echo $ano-1;
else echo $ano; 
?>
		">
	          <input type="submit" value="<<" style="font-family: Arial; font-size: 8px">
          </td>
          </form>
          <td align="center" class="bluenav">
	    <font size="2"><b><?php echo "$nom_mes $ano"; ?></b>
	  </td>
          <form method="post" action="<?php echo $PHP_SELF; ?>">
          <td align="center" valign="center">
              <input type="hidden" name="funcion" value="ala">
              <input type="hidden" name="fch" value="<?php echo $fch;?>">
              <input type="hidden" name="dia" value="<?php echo $dia;?>">
              <input type="hidden" name="mes" value="
<?php

##
## Mes siguiente 
##

if (($mes+1) > 12) echo "1";
else echo $mes+1;
?>
                ">
              <input type="hidden" name="ano" VALUE="
<?php

##
## Ano siguiente 
##

if (($mes+1) > 12) echo $ano+1;
else echo $ano;
?>
                ">
              <input type="submit" value=">>" style="font-family: Arial; font-size: 8px">
          </td>
          </form>
        </tr>
      </table>
    </td>
  </tr>	
  <tr align="center">
    <td>
      <table border="0" cellspacing="1" cellpadding="1" bgcolor="#000000">
        <tr align="right" valign="top">
		
<?php
for($i=0;$i<sizeof($dias);$i++)
    echo "<td bgcolor=\"#D6DECE\"><font size=\"1\" color=\"#13255B\">$dias[$i]</font></td>";
?> 
        </tr>

<?php
    $d = 1;
    list($hdia,$hmes,$hano,$hdsem,$num_dias)=split('\|',date("j|n|Y|w|t",mktime(0,0,0,$mes,1,$ano)));
    $hnom_mes = $meses[$hmes];
    $psemana = TRUE;
    while ( $d <= $num_dias) {
        if ($psemana) {
            echo "<tr align=\"right\" valign=\"middle\" bgcolor=\"#EEEEEE\">";
            for ($i=1; $i<=$hdsem; $i++) {
                echo "<td></td>";
            }
            $psemana = FALSE;
        }

        if ($hdsem==0){
            echo "<tr align=\"right\" valign=\"middle\" bgcolor=\"#EEEEEE\">";
        }
            echo "<td"; if ($d == $dia) echo " bgcolor=\"#D6DECE\"";
	    echo "><a href=\"#\" Onclick=\"window.opener.document.enviar.".$fch.".value='$d' + '-' + '$mes' + '-' + '$ano';self.close()\";><font size=\"1\""; if($d == $dia) echo "color=\"#13255B\"";
	    echo ">$d</font></a></td>";

        if ($hdsem==6) {
            echo "</tr>\n";
        }

        $hdsem++;
        $hdsem = $hdsem % 7;
        $d++;
    }
    ?>
      </table>
    </td>
  </tr>
  <tr>
    <td align="center"><font size="1"><!--<?php echo "".$diasc[$diasem]." $dia de $nom_mes de $ano";?>--></font></td>
  </tr>
  <tr>
   <form method="post" action="<?php echo $PHP_SELF; ?>">
    <td align="center" bgcolor="#2F6669">
	<input type="hidden" name="funcion" value="ala">
        <input type="hidden" name="fch" value="<?php echo $fch;?>">
	<font size="1" class="bluenav"></font>
	<select name="mes" style="background-color: rgb(214,222,206); color: rgb(19,37,91);  cursor: default; font-family: Arial; font-size: 10px">
<?php
for($i=1;$i<sizeof($meses);$i++){
	echo "<option value=\"$i\" ";
	if($i==$mes) echo "SELECTED";
	echo ">".$meses[$i]."</option>";
	} 
?>
	</select> 
	<select name="ano" style="background-color: rgb(214,222,206); color: rgb(19,37,91);  cursor: default; font-family: Arial; font-size: 10px">
<?php
for($i=$ano-5;$i<=$ano+5;$i++){
        echo "<option value=$i ";
        if($i==$ano) echo "selected";
        echo ">$i</option>";
        }
?>
        </select>
        <input type="hidden" name="dia" value="<?php echo $dia;?>">
	<input type="submit" value=">>>" style="font-family: Arial; font-size: 8px">
    </td>
   <form>
  </tr>
</table>
</body>
</html>

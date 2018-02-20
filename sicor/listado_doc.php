<?php
include("../filtro.php");
include("../conecta.php");
include("cifrar.php");
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
?>
<link rel="stylesheet" type="text/css" href="script/estilos2.css" title="estilos2" />
<script> 
function cerrarse(){ 
window.close() 
} 
</script> 

<script>
String.prototype.preg_quote=function(){
    p= /([:.\+*?[^\]$(){}=!<>|:)])/g;
    return this.replace(p,"\\$1");
}
function buscar(cadena){
       resetear();
    if(!cadena.length)return;
    var info3;
    cadena=cadena.preg_quote();
    var patron=new RegExp(cadena+'(?!\}\})','gim');
    var espacio=/^\s$/;
    var el=document.getElementById('tabla').getElementsByTagName('*');
   for(var ii=0;ii<el.length;ii++){
        if(el[ii].hasChildNodes && el[ii].nodeName.toLowerCase()!='title' && el[ii].nodeName.toLowerCase()!='script' && el[ii].nodeName.toLowerCase()!='meta' && el[ii].nodeName.toLowerCase()!='link' && el[ii].nodeName.toLowerCase()!='style'){
            var tt=el[ii].childNodes;
            for(var jj in tt){
                if(tt[jj].nodeType==3 && !espacio.test(tt[jj].nodeValue)){
                    patron.lastIndex = 0;
                    if(info3=patron.exec(tt[jj].nodeValue)){
                        tt[jj].nodeValue=tt[jj].nodeValue.replace(patron,'{{'+tt[jj].nodeValue.substr(info3['index'],cadena.length)+'}}');
                
                    }
                }

            }        
        }
    }
   document.getElementById('tabla').innerHTML=document.getElementById('tabla').innerHTML.split('}}').join('</span>').split('{{').join('<span style="background-color: yellow">');
    
}
function resetear(){
    document.getElementById('tabla').innerHTML=original;
}
window.onload=function(){
    original=document.getElementById('tabla').innerHTML;
}
</script>

<?php



/*
BUSCA UNA CADENA DENTRO DE OTRA CADENA
  $string = 'Hello World!';
  if(stristr($string, 'earth') === FALSE) {
    echo '"earth" not found in string';
  }*/
// salida: "earth" not found in string

?>
<div class="fuente_normal" align="center"><b>LISTADO DE USUARIOS</b></div>
<br>
<table  border="1" cellpadding="1" cellspacing="1" align="center">

	<tr class="border_tr3">
		<form name="entidad" method="post" action="filtrado_de_usu.php">
		<td valign"middle">
		<input type="text" name="nomb" size="30" value="" />
		</td>
		<td>
		<input type="submit" name="buscar" class="boton" value="Filtrar"/>
		</td>

		<td>		
		</td>
		<td>
 
		</td>
	</tr>
	
</table>

<center> 
<div id="tabla" style="overflow:auto; width:98%; height:250px; align:left;">
<table border="1" cellpadding="1" cellspacing="1" bgcolor="#ededed">
<tr class="border_tr3">
	<td align="center"><span class="fuente_normal"><b></b></span></td>
	<td align="center"><span class="fuente_normal"><b>Nombre</b></span></td>
	<td align="center"><span class="fuente_normal"><b>Cargo</b></span></td>
	<td align="center"><span class="fuente_normal"><b>Unidad</b></span></td>
</tr>

<?php
$res=mysql_query("select registrodoc_hoja_ruta, registrodoc_cite, registrodoc_referencia, usuario_nombre
					from registrodoc, usuario 
					where registrodoc_de = usuario_ocupacion 
					and registrodoc_situacion='D'",$conn);
while($row=mysql_fetch_array($res))
{
?>
	<tr>
		<td>
		<!--<input name="valordocumento" type="checkbox" value="<?PHP echo $row[0]?>" />-->
		</td>
		<td  style="font-size:10px">
		<? //echo "$row[1]";?>
		
		 <a href="guar_tem.php?hr1=<?=$row[0];?>&val=<?=$row[1];?>&val1=<?=$row[3];?>&val2=<?=$row[4];?>" style="color:#0033FF; text-decoration:underline"><? echo "$row[1]";?></a>
			
		</td>
		<td  style="font-size:9px"><? echo "$row[3]";?>
		</td>
		<td  style="font-size:9px"><? echo "$row[4]";?>
		</td>
		<?php
		}
		?>
  	</tr>
</table>
</div>
</form>
</center>


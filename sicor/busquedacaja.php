<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<title>test</title>
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
</head>

<body>
<form id="form1" name="form1" method="post" action="">
  <input name="key" type="text" id="key" onkeyup="buscar(this.value)" />
  <br />
  <div id="tabla">
  <table width="300" border="1" cellpadding="1" >
    
    <tr>
      <td>Pepe</td>
      <td>L�pez</td>
    </tr>
    <tr>
      <td>Jos�</td>
      <td>San Mart�n </td>
    </tr>
  </table>
  </div>
</form>
</body>
</html>


<?php
/****************************************** 
ing. Jose luis Delgado
lui_delgadoQyahoo.com
77200300
******************************************/ 
?> 
<script language="javascript"> 
function SetCookie() { 
var width = screen.width; 
var height = screen.height; 
var res = width + 'x' + height; 
document.cookie = 'PHPRes='+res; 
location = '<?=$GLOBALS['siteurl'];?>'; 
} 

function CheckResolution(width, height) { 
if(width != screen.width && height != screen.height) { 
SetCookie(); 
} 
} 
</script> 
<?php 
if(isset($_COOKIE['PHPRes']) || !empty($_COOKIE['PHPRes'])) { 
$res = explode("x",$_COOKIE['PHPRes']); 
$width = $res[0]; 
$height = $res[1]; 
?> 
<script language="javascript"> 
CheckResolution(<?=$width;?>,<?=$height;?>); 
</script> 
<?php
} else { 
?> 
<script language="javascript"> 
SetCookie(); 
</script> 
<?php 
} 
?> 


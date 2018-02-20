<? if (!isset($res)) $res = 0; ?> 
<html> 
<head> 
<script> 
function resol(op) { 

if (op == 0) { 
location.href='resol.php?res='+screen.width; 
} 
} 
</script> 
</head> 
<body onLoad='resol(<? echo $res;?>)'> 

<table width="400" border="1" cellpadding="1">
  <tr>
  <?php 
  ?>
    <td>
	</td>
  </tr>
</table>

<? echo "Resolucion : $res";?> 
</body> 
</html>

<html>

<head>
  <title></title>
</head>

<body>

<h1>Seleccione su nueva imagen.</h1>

<form method='post' action='modules.php' enctype='multipart/form-data'>

<input name='fotografia' type='file' /><br><br>

<input name='enviar' type='submit' value='Cambiar Imagen' />
<input name='limpiar' type='reset' value='Limpiar' />
</form></center>

<?php
/*
echo "<form action=\"modules.php\" method=\"post\" ENCTYPE=\"multipart/form-data\">\n";

echo "<INPUT TYPE=\"hidden\" name=\"op\" value=\"modload\">\n";

echo "<INPUT TYPE=\"hidden\" name=\"file\" value=\"upload\">\n";

echo "<INPUT TYPE=\"hidden\" name=\"MAX_FILE_SIZE\" value=\"200000\">\n";

echo "<tr><td>"._MEMFILE.": <input type=\"file\" size=\"40\" name=\"uploadfile1\"></td></tr>\n";

echo "File type: <select name=\"type\">\n";
echo "<option value=\"jpg\">jpg</option>\n";
echo "<option value=\"gif\">gif</option>\n";
echo "</select>\n";

echo "<tr><td><input type=\"submit\" value=\"Subir\">  <input type=\"reset\" value=\"Borrar\"></td></tr>\n";

echo "</form>\n";
 */
?>



</body>

</html>
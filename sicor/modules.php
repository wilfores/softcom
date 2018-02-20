<html>

<head>
  <title></title>
</head>

<body>

<?php
if(empty($fotografia))
	{echo '<script language="javascript">alert("Introdusca fotografia");</script>';}

    $extension = explode(".",$fotografia_name);

     if ($_FILES["fotografia"]["tmp_name"]!='') {
	$archivo_nombre=$_FILES["fotografia"]["name"];
	//echo $archivo_nombre;
	$archivo_tamano = $_FILES["fotografia"]["size"];
	$archivo_temporal=$_FILES["fotografia"]["tmp_name"];


    }

    $updir=$_SERVER['DOCUMENT_ROOT'].”/adjunto/”;
    echo "la priemra es: $updir<br>";

    $url= getcwd(). "\adjunto";
    mkdir($url, 0777);
    copy( $fotografia, $updir.$_FILES["fotografia"]["name"] );
    move_uploaded_file($fotografia, $updir.$fotografia_name);
    echo "la direccion es: $url<br>";

    if (!file_exists($url))
	mkdir($url, 0777);

    //c:/fotografias_ventas/

$dir=$updir;

if (move_uploaded_file($_FILES["fotografia"]["tmp_name"], $dir.$_FILES["fotografia"]["name"]))
{
                $estado='Realizado';
                $sql="UPDATE trab_foto
                			SET  `n_archivo`='$archivo_nombre',
                                        `estado`='$estado'
                           	 where cod_cliente='$cod_cliente'
                                ";
				//$datos_proy = mysql_query ($sql, $conexion);

                echo 'SE SUBIO LA FOTOGRAFIA CORRECTAMENTE';
}
else
{
echo "<br><br>NO SE PUDO SUBIR SU FOTOGRAFIA";

}


/*
if (is_uploaded_file($HTTP_POST_FILES['im']['tmp_name'])  )
{
//recojo la imagen
$imagen = $HTTP_POST_FILES['im']['name'];
echo"$imagen";
//Obtengo el nombre de la imagen y la extensión de la foto
$imagen1 = explode(".",$imagen);
//Genero un nombre aleatorio con números y se asigno la extensión botenido anteriormente
$imagen2 = rand(0,9).rand(100,9999).rand(100,9999).".".$imagen1[1];
//Coloco la iamgen del usuario en la carpeta correspondiente con el nuevo nombre
move_uploaded_file($HTTP_POST_FILES['im']['tmp_name'], "./fotografias/".$imagen2);
//Asigno a la foto permisos
$ruta="./fotografias/".$imagen2;
echo"<br>$ruta";
mkdir($ruta, 0777);
chmod($ruta,0777);
//A partir de aqui sólo si quiero eliminar una foto
//$resultArchivos = mysql_query("Selecciono el nombre de la foto antigua");
//$rowArchivos= mysql_fetch_array($resultArchivos);
//unlink("carpeta/".$rowArchivos[0]);
echo "Tu nueva imagen ha sido subida.";
}
  */
/*


$server_dir = "http://localhost/ventas/fotografias";

if (! $uploadfile1_name) {
echo "Archivo no especificado.\n
<a href=javascript:history.back(-1)>Regresar al formulario</a>
";
exit;
}

$upload_dir = "$server_dir";
$uploadtemp1 = $uploadfile1;
$original = array("$uploadtemp1");
$uploadreal1 = $uploadfile1_name;
$file = array("$uploadreal1");

for($I = 0; $I <=1; $I++){
$file[$I] = ereg_replace(" ", "_", $file[$I]);
$file[$I] = ereg_replace("%20", "_", $file[$I]);
$copyfile = "$upload_dir/$file[$I]";
echo"<br>direccion: $copyfile";
$copiado = move_uploaded_file($original[$I], $copyfile);
unlink($original[$I]);
rename ("$upload_dir/$file[$I]", "$upload_dir/$user.$type");
}
*/
?>

</body>

</html>
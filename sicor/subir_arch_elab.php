<?php
include("../filtro.php");
include("../conecta.php");
include("script/functions.inc");
include("../funcion.inc");
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
$h_r=descifrar($_GET["hr1"]);

//echo "$codigo<br>";
//echo "$h_r<br>";
?>
<link rel="stylesheet" type="text/css" href="script/estilos2.css" title="estilos2" />
<script> 
function cerrarse(){ 
window.close() 
} 
</script> 
<?php 
if (isset($_POST['grabar']))
{
	
	if($_FILES["nom_arch_adj"]["name"]!='')
	{
		$archivo_nombre=$_FILES["nom_arch_adj"]["name"];
		$archivo_tamano = $_FILES["nom_arch_adj"]["size"];		
		$fecha=date("Y-m-d H:i:s");
		
		$qd = "select max(arch_adj_id)from arch_adj";
		$resdoc = mysql_query($qd,$conn);
		$rdoc = mysql_fetch_array($resdoc);			
		$id_doc=$rdoc[0]+1;/*obtiene el maximmo del id del documento 2*/
	
		    $foto_type=  $_FILES['nom_arch_adj']['type'];
            $tmp_name = $_FILES["nom_arch_adj"]["tmp_name"];
            $foto_nombre = $_FILES["nom_arch_adj"]["name"];

            $foto_descripcion = $foto_nombre;

            $foto_nombre = strtolower($foto_nombre);
            $valor_aux = explode(".",$foto_nombre);
            $cantidad_valor_puntos = count($valor_aux);
            $foto_nombre_1 = genera_password();
            $foto_nombre = $foto_nombre_1.".".$valor_aux[$cantidad_valor_puntos-1];
            $foto_nombre = date("dmY").$foto_nombre;
            $cont=1;
                while(file_exists("adjunto/".$foto_nombre))
                {
                     $foto_nombre = $cont.$foto_nombre;
                     $cont=$cont+1;
                }

                $lugar="adjunto/".$foto_nombre;
                copy ($tmp_name,$lugar);
				move_uploaded_file($HTTP_POST_FILES['nom_arch_adj']['tmp_name'], './adjunto/'.$foto_nombre);

	$insertar=" INSERT INTO `arch_adj` (`arch_adj_id`, `arch_adj_h_r`, `arch_adj_nombre`, `arch_adj_usuario`, `arch_adj_fecha`) VALUES 
  ($id_doc, '$h_r', '$foto_nombre', $codigo, '$fecha')";		
  
  $resul = mysql_query($insertar,$conn);
  	
	$con= "UPDATE registrodoc1
                SET
			registrodoc1_cc='E'
                WHERE
            registrodoc1_cite='$h_r'
            AND registrodoc1_cc='NE'";
			/*registrodoc_respuesta='$res', SE CAMBIO POR (SI) */
    $res = mysql_query($con,$conn); 

/****funcion de envio correo*****/
	$para = 'luisdelgado2708@gmail.com';
	$titulo = 'MINISTERIO DE SALUD Y DEPORTES SOFTCOM';
	$mensaje = 'TIENE UN DOCUMENTO POR RECEPCIONAR EN SU BANDEJA DEL SOFTCOM';	
	mail("$para", "$titulo", "$mensaje");
/****************************/	
	 ?>
 <script>
	window.opener.location.reload(true);
	window.close();
</script> 
	<?php	
	
	}
	

}
?>
<CENTER>
<div class="fuente_normal" align="center"><b>SUBIR ARCHIVO ELABORADO</b></div>
<br>
<form  method="POST" name="enviar" enctype="multipart/form-data" onclick="recargar()">
  <table border="0" cellpadding="1">
  <tr>
    <td><input style="font-size:9px; color:blue" name="nom_arch_adj" type="file" size="50"></td>
  </tr>
</table>
<input type="submit" name="grabar" value="Guardar Archivo" class="boton" />
<input type="submit" name="cancelar" value="Cerrar" class="boton" onClick="cerrarse()">
</form>
</CENTER>


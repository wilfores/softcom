<?php
include("../filtro.php");
?>
<?php
include("inicio.php");
?>
<?php
include("../conecta.php");
include("script/functions.inc");
include("../funcion.inc");
$error = 0;
$cod_institucion = $_SESSION["institucion"];
$gestion=$_SESSION["gestion"];
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
?>
<script type="text/javascript">
var numero = 0; //Esta es una variable de control para mantener nombres
            //diferentes de cada campo creado dinamicamente.
evento = function (evt) { //esta funcion nos devuelve el tipo de evento disparado
   return (!evt) ? event : evt;
}

//Aqui se hace lamagia... jejeje, esta funcion crea dinamicamente los nuevos campos file
addCampo = function () { 
//Creamos un nuevo div para que contenga el nuevo campo
   nDiv = document.createElement('div');
//con esto se establece la clase de la div
   nDiv.className = 'archivo';
//este es el id de la div, aqui la utilidad de la variable numero
//nos permite darle un id unico
   nDiv.id = 'file' + (++numero);
//creamos el input para el formulario:
   nCampo = document.createElement('input');
//le damos un nombre, es importante que lo nombren como vector, pues todos los campos
//compartiran el nombre en un arreglo, asi es mas facil procesar posteriormente con php
   nCampo.name = 'archivos[]';
//Establecemos el tipo de campo
   nCampo.type = 'file';
//Ahora creamos un link para poder eliminar un campo que ya no deseemos
   a = document.createElement('a');
//El link debe tener el mismo nombre de la div padre, para efectos de localizarla y eliminarla
   a.name = nDiv.id;
//Este link no debe ir a ningun lado
   a.href = '#';
//Establecemos que dispare esta funcion en click
   a.onclick = elimCamp;
//Con esto ponemos el texto del link
   a.innerHTML = 'Eliminar';
//Bien es el momento de integrar lo que hemos creado al documento,
//primero usamos la funci�n appendChild para adicionar el campo file nuevo
   nDiv.appendChild(nCampo);
//Adicionamos el Link
   nDiv.appendChild(a);
//Ahora si recuerdan, en el html hay una div cuyo id es 'adjuntos', bien
//con esta funci�n obtenemos una referencia a ella para usar de nuevo appendChild
//y adicionar la div que hemos creado, la cual contiene el campo file con su link de eliminaci�n:
   container = document.getElementById('adjuntos');
   container.appendChild(nDiv);
}
//con esta funci�n eliminamos el campo cuyo link de eliminaci�n sea presionado
elimCamp = function (evt){
   evt = evento(evt);
   nCampo = rObj(evt);
   div = document.getElementById(nCampo.name);
   div.parentNode.removeChild(div);
}
//con esta funci�n recuperamos una instancia del objeto que disparo el evento
rObj = function (evt) { 
   return evt.srcElement ?  evt.srcElement : evt.target;
}
</script>


<?php
if (isset($_POST['envia'])) 
{
    if (isset ($_FILES["archivos"]))
	 {
         //de se asi, para procesar los archivos subidos al servidor solo debemos recorrerlo
         //obtenemos la cantidad de elementos que tiene el arreglo archivos
         $tot = count($_FILES["archivos"]["name"]);
         //este for recorre el arreglo
         for ($i = 0; $i < $tot; $i++)
		 {
         //con el indice $i, poemos obtener la propiedad que desemos de cada archivo
         //para trabajar con este
		    
		    $foto_type=  $_FILES['archivos']['type'][$i];
            $tmp_name = $_FILES["archivos"]["tmp_name"][$i];
            $name ="adjunto/".$_FILES["archivos"]["name"][$i];
		/**********************************************************************************
		               VERIFICAMOS SI ES ALGUN GRAFICO O PDF PARA SUBIR AL SERVIDOR
		**********************************************************************************/	
		
				if (($foto_type=="image/x-png" || $foto_type=="image/png") || ($foto_type=="image/pjpeg" ||
					 $foto_type=="image/jpeg") || ($foto_type=="image/gif" || $foto_type=="image/gif")   ||
					 ($foto_type=="application/pdf"))
				{
                                        $error=0;
				}
				else
				{
					$error=1;
				}
			
			
			
		if ($error==0)	
		{ 
		 $fecha=date("Y-m-d H:i:s");
		 //copy ($tmp_name,$lugar);
		  if (copy ($tmp_name,$name))
		  {
	      mysql_query("insert into adjunto(adjunto_id,adjunto_archivo,adjunto_usuario,adjunto_fecha) values ('$_GET[valor]','$name','$_SESSION[cargo_asignado]','$fecha')",$conn);
		  }	
      }  //verificar tipo de documento
	}//end for
	     $fecha_pdf=date("Y-m-d H:i:s");  
	     mysql_query("UPDATE registroarchivo SET registroarchivo_adj_documento='1', registroarchivo_fecha_pdf='$fecha_pdf', registroarchivo_estado='T' WHERE registroarchivo_codigo='$_GET[valor]'",$conn) or die("No se Guardo el Registro");   
}      
?>
    <script language="JavaScript">
    window.self.location="encuentra2.php";
    </script>
<?php	

} //en if isset enviar

if(isset($_POST['cancelar']))
{
?>
    <script language="JavaScript">
    window.self.location="encuentra2.php";
    </script>
<?php
}

?>
<br>
<?php 
if ($aux == 0)
{
?>
	<p class="fuente_titulo">
	<center><b>ADJUNTAR ARCHIVO</b></center></p>
       
    
<?php
} 
else 
{ 
	echo "<p><div class=\"fuente_normal_rojo\" align=\"center\"><b>.....Verificar Datos</b></div></p>";
}

	$ssqlm = "SELECT * FROM registroarchivo WHERE '$_GET[valor]'=registroarchivo_codigo";
	$rssm = mysql_query($ssqlm, $conn);
	while($rowm=mysql_fetch_array($rssm))
	{
	  $imagen_adjunto= $rowm["registroarchivo_adj_documento"];
  	  $hoja_ruta = $rowm["registroarchivo_hoja_interna"];
	} 
?>


<form name="formu" id="formu" method="post" enctype="multipart/form-data">
<table width="40%" cellspacing="2" cellpadding="2" border="0" align="center">
<tr class="border_tr3"><td><span class="fuente_normal"><b>Hoja de Ruta </b></td>
<td>
	<?php echo $hoja_ruta;?>
</td>
</tr>

<tr class="border_tr3">
<td><span class="fuente_normal"><b>Adjuntar Archivo:</b></td>
<td>
   <div id="adjuntos">
   <input type="file" name="archivos[]"/><k>(max. 1,2 MB)</k>
   </div>
</td>
</tr>

<tr class="border_tr3">
<td colspan="2" align="center"> <a href="#" onClick="addCampo()" class="boton"><BR /><span class="fuente_normal"><b>[Adjuntar otro Archivo]</b></a>
</td>
</tr>

<tr class="border_tr3">
<td colspan="2" align="center">
   <input type="hidden" name="valor" value="<?php echo $_GET['valor'];?>" />
   <input type="submit" value="Enviar" id="envia" name="envia" class="boton" />
   
</td>
</tr>

<tr class="border_tr3">
<td colspan="2" align="center">
</form>
<?php
$pagina_ori=$_SERVER['HTTP_REFERER'];
$posicion=strrpos($pagina_ori,"/");
$ir_pagina=substr($pagina_ori,$posicion+1);
$historia_en = $_GET['datos'];
?>
<br>
<form action="<?php echo $ir_pagina;?>" method="POST">
<div align="center">
<!-- <input type="reset" name="imprimir" value="Imprimir" class="boton" onClick="JavaScript:window.open('imprime_historia.php?datos=<?php echo $_GET['datos'];?>')" >-->
<input type="hidden" name="busqueda" value="<?php echo $_GET['busqueda'];?>" >
<input type="hidden" name="clase" value="<?php echo $_GET['clase']; ?>" >
<input type="submit" name="buscar" value="Retornar" class="boton" /></div>
</form>
</td>
</tr>
</table>
<br>

<br>
<span class="fuente_titulo"><span class="fuente_normal">
<center><b>DOCUMENTOS ADJUNTOS</b></center></span></center>

<table width="100%" cellspacing="1" cellpadding="1" border="0">
<tr class="border_tr2">
<td width="15%" align="center"><span class="fuente_normal">Archivos</td>
<td width="15%" align="center"><span class="fuente_normal">Tipo Archivo</td>
<td width="20%" align="center"><span class="fuente_normal">Adjuntado por:</td>
<td width="15%" align="center"><span class="fuente_normal">Fecha Adjunto</td>
</tr>
</table>


<table width="100%" cellspacing="1" cellpadding="1" border="0" style="font-size:10px">
<?php 
$conexion=mysql_query("select * from  adjunto where adjunto_id=$_GET[valor]",$conn);
  $resaltador=0;
while($row=mysql_fetch_array($conexion))
{
if ($resaltador==0)
	  {
       echo "<tr class=truno>";
	   $resaltador=1;
      }
	  else
	  {
       echo "<tr class=trdos>";
   	   $resaltador=0;
	  }
?>
<td align="center" width="15%"><a href="<?php echo $row["adjunto_archivo"];?>" target="_blank">[Bajar Archivos]</a></td>
<td align="left" width="15%"><?php echo $row["adjunto_archivo"];?> </td>
<td align="center" width="20%">
<?php
      $valor_cargo=$row["adjunto_usuario"];
		$conexion2 = mysql_query("SELECT * FROM cargos WHERE '$valor_cargo'=cargos_id",$conn);
		if($fila_cargo=mysql_fetch_array($conexion2))
		{
			echo $fila_cargo["cargos_cargo"];
		}
?> 
</td>
<td align="center" width="15%"><?php echo $row["adjunto_fecha"];?> </td>
</tr>
<?php
}
?>
</table>


<?php
include("final.php");
?>
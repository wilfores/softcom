<?php
include("../filtro.php");
?>
<?php
include("inicio.php");
include("script/functions.inc");
include("../funcion.inc");
include("../conecta.php");
$institucion = $_SESSION["institucion"];
$codigo = $_SESSION["codigo"];
$cod_depar = $_SESSION["departamento"];
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
$h_r=descifrar($_GET["hr1"]);
?>
<?php
 include("ckeditor/ckeditor.php");
?>
<script type="text/javascript">
var numero = 0; //Esta es una variable de control para mantener nombres
            //diferentes de cada campo creado dinamicamente.
evento = function (evt) { //esta funcion nos devuelve el tipo de evento disparado
   return (!evt) ? event : evt;
}

//Aqui se hace la magia... jejeje, esta funcion crea dinamicamente los nuevos campos file
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
/*if(!empty($_GET[valor]))
{
    $valor_enviado = descifrar($_GET[valor]);
    if(!is_numeric($valor_enviado))
        {
            echo "<center><b>!!!! INTENTO DE MANIPULACION DE DATOS !!!!</b></center>";
            exit;
        }
    unset($_GET[valor]);
    $_SESSION[valor_enviado_archivo] = $valor_enviado;
}*/

$error = 0;
if(isset($_POST[finalizar]))
{


}
if(isset ($_POST[cancelar]))
{
?>
                <script language="JavaScript">
                window.self.location="menu2.php";
                </script>
<?php
}

if($error > 0)
{
   $registroarchivo_referencia = $_POST[registroarchivo_referencia];
    
   $registroarchivo_texto = $_POST[registroarchivo_texto];
     echo $registroarchivo_texto;
}
else
{


        $sql_valor = mysql_query("SELECT * FROM registroarchivo
                                  WHERE registroarchivo_codigo = '$_SESSION[valor_enviado_archivo]'
                                  AND (registroarchivo_estado = 'P' OR registroarchivo_estado = 'O')",$conn);
        if($fila_archivo = mysql_fetch_array($sql_valor))
        {
            $registroarchivo_referencia = $fila_archivo["registroarchivo_referencia"];	
			//echo $registroarchivo_referencia; 		
            $registroarchivo_texto = $fila_archivo["registroarchivo_texto"];
			//echo $registroarchivo_texto;			
            $registroarchivo_estado = $fila_archivo["registroarchivo_estado"];
			//echo $registroarchivo_estado;			
        }
}

echo"$institucion<br>";
echo"$codigo<br>";
echo"$cod_depar<br>";
echo"$h_r<br>";

$rslista=mysql_query("SELECT * FROM registrodoc1 WHERE '$h_r'=registrodoc1_hoja_ruta",$conn);
$rwlista=mysql_fetch_array($rslista);
$contar = mysql_num_rows($rslista);

if($contar==1)
{
	echo "$contar numero de filas en la tabla registro<br>";
	echo "$rwlista[registrodoc1_cite]<br>";
	echo "$rwlista[registrodoc1_de]<br>";
	echo "$rwlista[registrodoc1_para]<br>";
	$para=$rwlista['registrodoc1_para'];
}
else
{
	if($contar>13)
	{
		$para='TODOS LOS USUARIOS';
	}
	else
	{
		$para='VICEMINISTROS, DIRECTORES GENERALES, JEFES DE UNIDAD,RESPONSABLES DE AREA, PROGRAMAS, PROYECTOS Y COORDINADORES, DESCENTRALIZADAS';
	}
	echo "$contar numero de filas en la tabla registro<br>";
	echo "$rwlista[registrodoc1_cite]<br>";
	echo "$rwlista[registrodoc1_de]<br>";
	
}
?>
<center>
<form name="envio" method="POST" enctype="multipart/form-data" action="pinforme_editar.php?tipo=?<?php echo $_POST['tipo']; ?>">
<table border="0" cellpadding="0" cellspacing="2" align="center" width="80%">
         <tr style="font-size: 8pt; color:#FFFFFF" bgcolor="#3E6BA3">
                <td align="center" colspan="2">
                    <span class="fuente_normal">
<?php
echo "<b class='fuente_titulo'>";
echo "<center>CITE:" . $rwlista['registrodoc1_cite'] . "</center></b>";
$cite=$rwlista["registrodoc1_hoja_ruta"];

?>
    <tr class="border_tr3">
        <td align="right">
            <b>Para:</b>
        </td>
        <td>
       <table width="95%" BORDER="0" CELLSPACING="2" CELLPADDING="0" class="fuente_normal">
		<?php
		if($contar==1)
		{
        echo "<tr><td width=\"500\">";
        $consulta_aux = "SELECT b.usuario_nombre, c.cargos_cargo
                         FROM usuario b, cargos c
                         WHERE b.usuario_ocupacion='$para'
                         AND b.usuario_ocupacion = c.cargos_id";
        $rss_consulta = mysql_query($consulta_aux, $conn);
        while($fila_para = mysql_fetch_array($rss_consulta))
        {
            echo $fila_para["usuario_nombre"];
			$usuario=$fila_para["usuario_nombre"];
			echo " <b>(".$fila_para["cargos_cargo"].")</b><br />";
			$cargo=$fila_para["cargos_cargo"];			
        }
        echo "</td></tr>";
        mysql_free_result($rss_consulta);
		}
		else
		{
			if($contar>13)
			{
			echo "<tr><td width=\"400\">";
			echo "$para";
			echo "</td></tr>";
			}
			else
			{
			echo "<tr><td width=\"400\">";
			echo "$para";
			echo "</td></tr>";
			}
		}
        
		?>
        </table>
        </td>
      </tr>
        <?php
        $consulta_aux = "SELECT b.usuario_nombre, c.cargos_cargo FROM derivaciones a, usuario b, cargos c
                         WHERE a.derivaciones_hoja_interna = '$_SESSION[valor_enviado_archivo]'
                         AND a.derivaciones_estado = 'V'
                         AND a.derivaciones_cod_usr = b.usuario_ocupacion
                         AND b.usuario_ocupacion = c.cargos_id";						 
        $rss_consulta = mysql_query($consulta_aux, $conn);
        if(mysql_num_rows($rss_consulta) > 0)
        {
        ?>

        <tr class="border_tr3">
        <td align="right">
            <b>VIA:</b>
        </td>
        <td>
       <table width="95%" BORDER="0" CELLSPACING="2" CELLPADDING="0" class="fuente_normal">
        <?php
        echo "<tr><td bgcolor=\"#EFEBE3\" width=\"500\">";
        while($fila_para = mysql_fetch_array($rss_consulta))
        {
            echo $fila_para["usuario_nombre"];
            echo " <b>(".$fila_para["cargos_cargo"].")</b><br />";
        }
        echo "</td></tr>";
        ?>
        </table>
        </td>
        </tr>
        <?php
      }
      mysql_free_result($rss_consulta);
      ?>
      <tr class="border_tr3">
        <td align="right">
            <b>De:</b>
        </td>
        <td>
       <table width="95%" BORDER="0" CELLSPACING="2" CELLPADDING="0" class="fuente_normal">
<?php
         echo "<tr><td width=\"400\">";

        $consulta_aux = "SELECT b.usuario_nombre, c.cargos_cargo FROM usuario b, cargos c
                         WHERE b.usuario_ocupacion='$codigo'
                         AND b.usuario_ocupacion = c.cargos_id";
        $rss_consulta = mysql_query($consulta_aux, $conn);
		$fila_para = mysql_fetch_array($rss_consulta);
            echo $fila_para["usuario_nombre"];	
			$usuario_de=$fila_para["usuario_nombre"];
            echo " <b>(".$fila_para["cargos_cargo"].")</b><br />";
			$cargo_de=$fila_para["cargos_cargo"];
        echo "</td></tr>";
        mysql_free_result($rss_consulta);
		
		?>	
        </table>
        </td>
      </tr>
        <tr class="border_tr3">
        <td align="right">
            <b>Referencia:</b>
        </td>
        <td>
            <textarea name="registroarchivo_referencia" rows="2" cols="50"><?php echo $rwlista[registrodoc1_referencia]; ?></textarea>
            <?php Alert($referencia_error);?>
        </td>
        </tr>
        <tr class="border_tr3">
        <td colspan="2">
                <?php
                    if($registroarchivo_estado == 'O')
                    {
                        echo "<center><table  cellspacing=2 border=1><tr bgcolor=#F7BE81>";
                        echo "<td><center><b><span class=fuente_titulo>Usuario</span></b></center></td>
                              <td><center><b><span class=fuente_titulo>Fecha</span></b></center></td>
                              <td><center><b><span class=fuente_titulo>Observacion</span></b></center></td>
                              </tr>";
                        $sql_estado = mysql_query("SELECT * FROM observacionarchivo
                                                   WHERE registroarchivo_codigo='$_SESSION[valor_enviado_archivo]'
                                                   ORDER BY id_observacionarchivo DESC",$conn);
                        while($fila_estado = mysql_fetch_array($sql_estado))
                        {
                            $sql_cargo = mysql_query("SELECT a.usuario_nombre, b.cargos_cargo FROM usuario a, cargos b
                                                      WHERE a.usuario_ocupacion = '$fila_estado[cargos_id]'
                                                      AND b.cargos_id = a.usuario_ocupacion",$conn);
                            if($fila_cargo = mysql_fetch_array($sql_cargo))
                            {
                             echo "<tr class=trdos><td><center>".$fila_cargo["usuario_nombre"]."<br /><b>(".$fila_cargo["cargos_cargo"].")</b></center></td>";																				
                            }
                            mysql_free_result($sql_cargo);
                            echo "<td>".$fila_estado["fecha_observacionarchivo"]."</td>";
                            echo "<td>".$fila_estado["observacion_observacionarchivo"]."</td>";
                            echo "</tr>";
                        }
                        echo "</table></center>";
                        mysql_free_result($sql_estado);
                    }
                ?></td>
        </tr>
         <tr class="border_tr3">
        <td align="center"  valign="top" colspan="2">
            <?php
				// The initial value to be displayed in the editor.
				$initialValue = '<p>This is some <strong>sample text</strong>.</p>';
				// Create class instance.
				$CKEditor = new CKEditor();
				// Path to CKEditor directory, ideally instead of relative dir, use an absolute path:
				//   $CKEditor->basePath = '/ckeditor/'
				// If not set, CKEditor will try to detect the correct path.
				$CKEditor->basePath = 'ckeditor/';
				// Create textarea element and attach CKEditor to it.
				$CKEditor->editor("registroarchivo_texto", $registroarchivo_texto);
			
                                Alert($texto_error);
              ?>
        </td>
        </tr>
	
	
	<!--	
    </table>
    
	<table border="0" cellpadding="0" cellspacing="2" align="center" width="80%">
        <tr class="border_tr3">
        <td>            
                <div id="adjuntos">
                    <input type="file" name="archivos[]" /><b>(max. 1,2 MB)</b>                
				</div>
                <a href="#" onClick="addCampo()" class="boton">
                <br /><span style="color:#003399">
                    <b>[Adjuntar otro Archivo]</b>
                    </span>               
				</a>
                <?php
                Alert($formato_error);
                ?>        
		</td>
        
		<td>
				<div id="resultado_datos">
				<?php
				$conexion_sql = mysql_query("SELECT * FROM adjunto
											 WHERE adjunto_id='$_SESSION[valor_enviado_archivo]'",$conn);
				while($fila_adjunto = mysql_fetch_array($conexion_sql))
				{
					$archivo_enviar = cifrar($fila_adjunto["adjunto_archivo"]);
				?>
				<a href="<?php echo $fila_adjunto["adjunto_archivo"];?>" target="_blank">
					<?php echo $fila_adjunto["adjunto_nombre"];?> 
				</a>
				&nbsp; 
				<a href="adjunto_eliminar.php?identificador=<?php echo $archivo_enviar;?>">
					 <span style="color:#003399"><b>[Eliminar]</b></span>            
				</a>
				<?php
					echo "<br /><br />";
				}
				mysql_free_result($conexion_sql);
				?>

			  <?php 		  
			  $radio_membrete=$_POST['tipo1'];
	
			  ?>				
			   </div>  		   
			   <A href="impresion_cm_ne.php?nota=<?php echo $cite; ?>">
			   <img src='images/word2007.gif' border='0'><span style="color:#003399">&nbsp;&nbsp;IMPRIMIR</span>
			   </a>		   
		   </td>
        </tr>
        <tr>
          <td align="center" colspan="2"></td>
        </tr>
		-->

        <tr>
            <td align="center" colspan="2">
                <br />
                <input type="submit" name="borrador" value="Guardar Borrador" class="boton" />
                <input type="submit" name="finalizar" value="Guardar y Finalizar" class="boton" />
                <input type="submit" name="cancelar" value="Cancelar" class="boton" />            </td>
        </tr>
    </table>
</form>
</center>
<p>
  <?php
include("final.php");
?>
</p>
<p>
  <input type="hidden" name="numero_cite" value=" <?php echo $registroarchivo_referencia;?>" />
</p>

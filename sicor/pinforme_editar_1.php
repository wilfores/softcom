<?php
include("../filtro.php");
?>
<?php
include("inicio.php");
include("script/functions.inc");
include("../funcion.inc");
include("../conecta.php");
$institucion = $_SESSION["institucion"];
$cod_usr = $_SESSION["codigo"];
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
if(!empty($_GET[valor]))
{
    $valor_enviado = descifrar($_GET[valor]);
    if(!is_numeric($valor_enviado))
        {
            echo "<center><b>!!!! INTENTO DE MANIPULACION DE DATOS !!!!</b></center>";
            exit;
        }
    unset($_GET[valor]);
    $_SESSION[valor_enviado_archivo] = $valor_enviado;
}


$error = 0;
if(isset($_POST[borrador]))
{

    $valor1=val_alfanum($_POST[registroarchivo_referencia]);
    if($valor1 == 0)
    {
       $error = 1;
       $referencia_error = 1;
    }


    if(empty($_POST[registroarchivo_texto]))
    {
        $error = 2;
        $texto_error = 1;
    }

    $tiene_adjuntos = 0;
    $total = count($_FILES["archivos"]["name"]);
    if(($total == 1) && ($_FILES["archivos"]["name"][0] == ""))
    {
        $tiene_adjuntos = 1;
    }

    if ($tiene_adjuntos == 0)
    {
      for ($i = 0; $i < $total; $i++)
      {
        $foto_type=  $_FILES['archivos']['type'][$i];
        $tmp_name = $_FILES["archivos"]["tmp_name"][$i];
         if ($foto_type=="image/x-png"     || $foto_type=="image/png"          || $foto_type=="image/pjpeg" ||
             $foto_type=="image/jpeg"      || $foto_type=="image/gif"          || $foto_type=="application/vnd.ms-powerpoint"   ||
             $foto_type=="application/pdf" || $foto_type=="application/msword" || $foto_type=="application/vnd.ms-excel" ||
             $foto_type=="application/vnd.oasis.opendocument.text"  || $foto_type=="application/vnd.oasis.opendocument.spreadsheet" ||
             $foto_type=="application/vnd.oasis.opendocument.presentation" || $foto_type=="application/vnd.openxmlformats-officedocument.wordprocessingml.document"
             || $foto_type=="application/vnd.openxmlformats-officedocument.spreadsheetml.sheet" || $foto_type=="application/vnd.openxmlformats-officedocument.presentationml.presentation")
            {
                    $tiene_adjuntos = 0;
            }
            else
            {
                    $error = 3;
                    $formato_error = 1;
            }

      }
    }

    if($error == 0)
    {
        if ($tiene_adjuntos == 0)
        {
            for ($i = 0; $i < $total; $i++)
              {
                $foto_type=  $_FILES['archivos']['type'][$i];
                $tmp_name = $_FILES["archivos"]["tmp_name"][$i];
                $foto_nombre = $_FILES["archivos"]["name"][$i];

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
                if (copy ($tmp_name,$lugar))
                {
                    $fecha=date("Y-m-d H:i:s");
                     mysql_query("INSERT INTO adjunto(adjunto_id,adjunto_archivo,adjunto_nombre,adjunto_usuario,adjunto_fecha)
                                 VALUES ('$_SESSION[valor_enviado_archivo]','$lugar','$foto_descripcion','$_SESSION[cargo_asignado]','$fecha')",$conn);
                   /* mysql_query("INSERT INTO adjunto(adjunto_id,adjunto_archivo,adjunto_usuario,adjunto_fecha)
                                 VALUES ('$_SESSION[valor_enviado_archivo]','$lugar','$_SESSION[cargo_asignado]','$fecha'",$conn);*/
                }//fin if copy
              }
         }
            mysql_query("UPDATE registroarchivo SET
                         registroarchivo_referencia = '$_POST[registroarchivo_referencia]',
                         registroarchivo_texto = '$_POST[registroarchivo_texto]'
                         WHERE registroarchivo_codigo='$_SESSION[valor_enviado_archivo]'",$conn);
            ?>
                <script language="JavaScript">
                window.self.location="encuentra2.php";
                </script>
            <?php
     }

}


if(isset($_POST[finalizar]))
{

    $valor1=val_alfanum($_POST[registroarchivo_referencia]);
    if($valor1 == 0)
    {
       $error = 1;
       $referencia_error = 1;
    }

    if(empty($_POST[registroarchivo_texto]))
    {
        $error = 2;
        $texto_error = 1;
    }

    $tiene_adjuntos = 0;
    $total = count($_FILES["archivos"]["name"]);
    if(($total == 1) && ($_FILES["archivos"]["name"][0] == ""))
    {
        $tiene_adjuntos = 1;
    }

    if ($tiene_adjuntos == 0)
    {
      $tiene_adjuntos = 0;
      $total = count($_FILES["archivos"]["name"]);
      for ($i = 0; $i < $total; $i++)
      {
        $foto_type=  $_FILES['archivos']['type'][$i];
        $tmp_name = $_FILES["archivos"]["tmp_name"][$i];

         if ($foto_type=="image/x-png"     || $foto_type=="image/png"          || $foto_type=="image/pjpeg" ||
             $foto_type=="image/jpeg"      || $foto_type=="image/gif"          || $foto_type=="application/vnd.ms-powerpoint"   ||
             $foto_type=="application/pdf" || $foto_type=="application/msword" || $foto_type=="application/vnd.ms-excel" ||
             $foto_type=="application/vnd.oasis.opendocument.text"  || $foto_type=="application/vnd.oasis.opendocument.spreadsheet" ||
             $foto_type=="application/vnd.oasis.opendocument.presentation" || $foto_type=="application/vnd.openxmlformats-officedocument.wordprocessingml.document"
             || $foto_type=="application/vnd.openxmlformats-officedocument.spreadsheetml.sheet" || $foto_type=="application/vnd.openxmlformats-officedocument.presentationml.presentation")
            {
                    
                    $tiene_adjuntos = 0;
            }
            else
            {
                    $error = 3;
                    $formato_error = 1;
            }

      }
    }

    if($error == 0)
    {
        $fecha=date("Y-m-d H:i:s");
        
        if ($tiene_adjuntos == 0)
        {
            for ($i = 0; $i < $total; $i++)
              {
                $foto_type=  $_FILES['archivos']['type'][$i];
                $tmp_name = $_FILES["archivos"]["tmp_name"][$i];
                $foto_nombre = $_FILES["archivos"]["name"][$i];

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
                if (copy ($tmp_name,$lugar))
                {
                    
                    mysql_query("INSERT INTO adjunto(adjunto_id,adjunto_archivo,adjunto_nombre,adjunto_usuario,adjunto_fecha)
                                 VALUES ('$_SESSION[valor_enviado_archivo]','$lugar','$foto_descripcion','$_SESSION[cargo_asignado]','$fecha')",$conn);
                }
              }
         }

            

           $consulta_aux = "SELECT * FROM derivaciones
                             WHERE derivaciones_hoja_interna = '$_SESSION[valor_enviado_archivo]'
                             AND derivaciones_estado = 'V'";
            $rss_consulta = mysql_query($consulta_aux, $conn);
            if(mysql_num_rows($rss_consulta) > 0)
            {
                $estado_archivo = 'A';
            }
            else
            {
                $rss_consulta_dos =   mysql_query("SELECT * FROM documentos a, registroarchivo b
                                           WHERE b.registroarchivo_codigo='$_SESSION[valor_enviado_archivo]'
                                           AND b.registroarchivo_tipo=a.documentos_id
                                           AND a.documentos_via=1",$conn);
                    if(mysql_num_rows($rss_consulta_dos) > 0)
                    {
                        $estado_archivo = 'D';
                    }
                    else
                    {
                       $estado_archivo = 'T';
                    }
                    mysql_free_result($rss_consulta_dos);
            }
            mysql_free_result($rss_consulta);


            mysql_query("UPDATE registroarchivo SET
                         registroarchivo_adj_documento='1',
                         registroarchivo_estado = '$estado_archivo',
                         registroarchivo_fecha_pdf = '$fecha',
                         registroarchivo_referencia = '$_POST[registroarchivo_referencia]',
                         registroarchivo_texto = '$_POST[registroarchivo_texto]'
                         WHERE registroarchivo_codigo='$_SESSION[valor_enviado_archivo]'",$conn);
            ?>
                <script language="JavaScript">
                window.self.location="encuentra2.php";
                </script>
           <?php
     }
}

if(isset ($_POST[cancelar]))
{
?>
                <script language="JavaScript">
                window.self.location="encuentra2.php";
                </script>
<?php
}

if($error > 0)
{
   $registroarchivo_referencia = $_POST[registroarchivo_referencia];
   $registroarchivo_texto = $_POST[registroarchivo_texto];
}
else
{


        $sql_valor = mysql_query("SELECT * FROM registroarchivo
                                  WHERE registroarchivo_codigo = '$_SESSION[valor_enviado_archivo]'
                                  AND (registroarchivo_estado = 'P' OR registroarchivo_estado = 'O')",$conn);
        if($fila_archivo = mysql_fetch_array($sql_valor))
        {
            $registroarchivo_referencia = $fila_archivo["registroarchivo_referencia"];
            $registroarchivo_texto = $fila_archivo["registroarchivo_texto"];
            $registroarchivo_estado = $fila_archivo["registroarchivo_estado"];
        }

}

?>
<center>
<form name="envio" method="POST" enctype="multipart/form-data">
<table border="0" cellpadding="0" cellspacing="2" align="center" width="80%">
         <tr>
                <td align="center" colspan="2" style="background-color: #1E679A; font-weight: bold; color: #ffffff; padding: 1 1 1 1px;">
                    <span class="fuente_normal">
<?php
echo "<b class='fuente_titulo'>";
echo "<center>CITE:" . $fila_archivo["registroarchivo_hoja_interna"] . "</center></b>";
?>
    <tr class="border_tr3">
        <td align="right">
            <b>Para:</b>        </td>
        <td>
       <table width="95%" BORDER="0" CELLSPACING="2" CELLPADDING="0" class="fuente_normal">
<?php
        echo "<tr><td bgcolor=\"#EFEBE3\" width=\"500\">";
        $consulta_aux = "SELECT b.usuario_nombre, c.cargos_cargo
                         FROM derivaciones a, usuario b, cargos c
                         WHERE a.derivaciones_hoja_interna = '$_SESSION[valor_enviado_archivo]'
                         AND a.derivaciones_estado = 'P'
                         AND a.derivaciones_cod_usr = b.usuario_ocupacion
                         AND b.usuario_ocupacion = c.cargos_id";
        $rss_consulta = mysql_query($consulta_aux, $conn);
        while($fila_para = mysql_fetch_array($rss_consulta))
        {
            echo $fila_para["usuario_nombre"];
            echo " <b>(".$fila_para["cargos_cargo"].")</b><br />";
        }
        echo "</td></tr>";
        mysql_free_result($rss_consulta);
        ?>
        </table>        </td>
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
            <b>VIA:</b>        </td>
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
        </table>        </td>
        </tr>
        <?php
      }
      mysql_free_result($rss_consulta);
      ?>
      <tr class="border_tr3">
        <td align="right">
            <b>De:</b>        </td>
        <td>
       <table width="95%" BORDER="0" CELLSPACING="2" CELLPADDING="0" class="fuente_normal">
<?php
         echo "<tr><td bgcolor=\"#EFEBE3\" width=\"500\">";

        $consulta_aux = "SELECT b.usuario_nombre, c.cargos_cargo FROM derivaciones a, usuario b, cargos c
                         WHERE a.derivaciones_hoja_interna = '$_SESSION[valor_enviado_archivo]'
                         AND a.derivaciones_estado = 'D'
                         AND a.derivaciones_cod_usr = b.usuario_ocupacion
                         AND b.usuario_ocupacion = c.cargos_id";
        $rss_consulta = mysql_query($consulta_aux, $conn);
        while($fila_para = mysql_fetch_array($rss_consulta))
        {
            echo $fila_para["usuario_nombre"];
            echo " <b>(".$fila_para["cargos_cargo"].")</b><br />";
        }
        echo "</td></tr>";
        mysql_free_result($rss_consulta);
        ?>
        </table>        </td>
        </tr>
        <tr class="border_tr3">
        <td align="right">
            <b>Referencia:</b>        </td>
        <td>
            <textarea name="registroarchivo_referencia" rows="2" cols="50"><?php echo $registroarchivo_referencia;?></textarea>
            <?php Alert($referencia_error);?>        </td>
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
                ?>        </td>
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
                           ?>        </td>
        </tr>
        </table>
        <table border="0" cellpadding="0" cellspacing="2" align="center" width="80%">
        <tr class="border_tr3">
        <td>
            
                 <div id="adjuntos">
                    <input type="file" name="archivos[]" /><b>(max. 1,2 MB)</b>
                </div>
                <a href="#" onClick="addCampo()" class="boton">
                <br /><span class="fuente_normal">
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
            <a href="<?php echo $fila_adjunto["adjunto_archivo"];?>" target="_blank" class="enlace_normal">
                <?php echo $fila_adjunto["adjunto_nombre"];?>
            </a>
            &nbsp;&nbsp;&nbsp;
            <a href="adjunto_eliminar.php?identificador=<?php echo $archivo_enviar;?>" class="enlace_normal">
                 <b>[Eliminar]</b>
            </a>
            <?php
                echo "<br /><br />";
            }
            mysql_free_result($conexion_sql);
            ?>
           </div>
        </td>
        </tr>
        <tr>
            <td align="center" colspan="2">
                <br />
                <input type="submit" name="borrador" value="Guardar Borrador" class="boton" />
                <input type="submit" name="finalizar" value="Guardar y Finalizar" class="boton" />
                <input type="submit" name="cancelar" value="Cancelar" class="boton" />
            </td>
        </tr>
    </table>
</form>
</center>
<?php
include("final.php");
?>

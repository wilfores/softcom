<?php
include("../filtro.php");
?>
<?php
include("inicio.php");
?>
<?php
include("script/functions.inc");
include("script/cifrar.php");
include("../conecta.php");
$cod_institucion=$_SESSION["institucion"];
$codigo_usuario=$_SESSION["cargo_asignado"];
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
unset($_SESSION[logo_pie]);
unset($_SESSION[logo_cabecera]);
?>
<?php
$valor_recibido = descifrar($_GET[valor]);
if(!is_numeric($valor_recibido))
{
    echo "!!! INTENTO DE MANIPULACION DEL SISTEMA !!!";
    exit;
}
$sql_valor = mysql_query("SELECT * FROM registroarchivo
                           WHERE registroarchivo_codigo = '$valor_recibido'",$conn);
if($fila_archivo = mysql_fetch_array($sql_valor))
{
?>
<center>
    <?php
    $sql_consulta_doc = mysql_query("SELECT documentos_descripcion FROM documentos
                                     WHERE documentos_id = '$fila_archivo[registroarchivo_tipo]'",$conn);
            if($fila_tipo = mysql_fetch_array($sql_consulta_doc))
            {
                echo "<br /><span class=fuente_titulo><b>".$fila_tipo["documentos_descripcion"]."</b></span><br /><br />";
            }
            mysql_free_result($sql_consulta_doc);
    ?>
<table border="0" cellpadding="0" cellspacing="2" align="center" width="80%">
<tr>
   <td align="center" colspan="2" class="border_tr2">
    <?php
    echo "<span class='fuente_titulo'><b>";
    echo "<center>CITE:" . $fila_archivo["registroarchivo_hoja_interna"] . "</center></b></span>";
    ?>
   </td>
</tr>
<tr class="border_tr3">
    <td align="right" class="border_tr2">
        <b>PARA:</b>
    </td>
    <td>
       <table width="95%" BORDER="0" CELLSPACING="2" CELLPADDING="0" class="fuente_normal">
        <?php
        echo "<tr><td bgcolor=\"#EFEBE3\" width=\"300\">";
        $consulta_aux = "SELECT b.usuario_nombre, c.cargos_cargo
                         FROM derivaciones a, usuario b, cargos c
                         WHERE a.derivaciones_hoja_interna = '$valor_recibido'
                         AND a.derivaciones_estado = 'P'
                         AND a.derivaciones_cod_usr = b.usuario_ocupacion
                         AND b.usuario_ocupacion = c.cargos_id";
        $rss_consulta = mysql_query($consulta_aux, $conn);
        while($fila_para = mysql_fetch_array($rss_consulta))
        {
            echo "<br />".$fila_para["usuario_nombre"];
            echo "<br /> <b>(".$fila_para["cargos_cargo"].")</b>";
        }
        echo "</td></tr>";
        mysql_free_result($rss_consulta);
        ?>
        </table>
        </td>
        </tr>
        <?php
        $consulta_aux = "SELECT b.usuario_nombre, c.cargos_cargo FROM derivaciones a, usuario b, cargos c
                         WHERE a.derivaciones_hoja_interna = '$valor_recibido'
                         AND a.derivaciones_estado = 'V'
                         AND a.derivaciones_cod_usr = b.usuario_ocupacion
                         AND b.usuario_ocupacion = c.cargos_id";
        $rss_consulta = mysql_query($consulta_aux, $conn);
        if(mysql_num_rows($rss_consulta) > 0)
        {
        ?>

        <tr class="border_tr3">
        <td align="right" class="border_tr2">
            <b>VIA:</b>
        </td>
        <td>
       <table width="95%" BORDER="0" CELLSPACING="2" CELLPADDING="0" class="fuente_normal">
        <?php
        echo "<tr><td bgcolor=\"#EFEBE3\" width=\"300\">";
        while($fila_para = mysql_fetch_array($rss_consulta))
        {
            echo "<br />".$fila_para["usuario_nombre"];
            echo "<br /> <b>(".$fila_para["cargos_cargo"].")</b>";
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
        <td align="right" class="border_tr2">
            <b>DE:</b>
        </td>
        <td>
       <table width="95%" BORDER="0" CELLSPACING="2" CELLPADDING="0" class="fuente_normal">
<?php
         echo "<tr><td bgcolor=\"#EFEBE3\" width=\"300\">";

        $consulta_aux = "SELECT b.usuario_nombre, c.cargos_cargo FROM derivaciones a, usuario b, cargos c
                         WHERE a.derivaciones_hoja_interna = '$valor_recibido'
                         AND a.derivaciones_estado = 'D'
                         AND a.derivaciones_cod_usr = b.usuario_ocupacion
                         AND b.usuario_ocupacion = c.cargos_id";
        $rss_consulta = mysql_query($consulta_aux, $conn);
        while($fila_para = mysql_fetch_array($rss_consulta))
        {
            echo "<br />".$fila_para["usuario_nombre"];
            echo "<br /> <b>(".$fila_para["cargos_cargo"].")</b>";
        }
        echo "</td></tr>";
        mysql_free_result($rss_consulta);
        ?>
        </table>
        </td>
        </tr>
        <tr class="border_tr3">
        <td align="right" class="border_tr2">
            <b>REF.:</b>
        </td>
        <td>
            <?php echo $fila_archivo["registroarchivo_referencia"];?>
        </td>
        </tr>
        <tr class="border_tr3">
        <td align="right" class="border_tr2">
            <b>FECHA.:</b>
        </td>
        <td>
            <?php echo $fila_archivo["registroarchivo_fecha_pdf"];?>
        </td>
        </tr>
        <tr class="border_tr3">
        <td class="border_tr2" align="right">
            <b>ADJUNTOS:</b>
        </td>
        <td align="left"  valign="top" colspan="2">
            <?php
            $conexion_sql = mysql_query("SELECT * FROM adjunto
                                         WHERE adjunto_id='$valor_recibido'",$conn);
            while($fila_adjunto = mysql_fetch_array($conexion_sql))
            {
                $archivo_enviar = cifrar($fila_adjunto["adjunto_archivo"]);
            ?>
            <a href="<?php echo $fila_adjunto["adjunto_archivo"];?>" target="_blank" class="enlace_normal">
                <img src="images/archivo.jpeg" width="12" height="14" alt="Archivo" />
                &nbsp;&nbsp;<?php echo $fila_adjunto["adjunto_nombre"];?>
            </a>
            &nbsp;&nbsp;&nbsp;
            <?php
                echo "<br /><br />";
            }
            ?>
        </td>
        </tr>
        </table>
        <br />
         <a href="imprimir_borrar.php?valor=<?php echo $_GET[valor];?>" class="boton" target="_blank">
         &nbsp; <b>Imprimir</b> &nbsp;
        </a>
</center>
<?php
}
?>

<br /><br />
        <?php
                $sql_estado = mysql_query("SELECT * FROM observacionarchivo
                                           WHERE registroarchivo_codigo='$valor_recibido'
                                           ORDER BY id_observacionarchivo DESC",$conn);
                if(mysql_num_rows($sql_estado) > O)
                {
                     echo "<center><table  cellspacing=2 border=1><tr bgcolor=#F7BE81>";
                     echo "<td><center><b><span class=fuente_titulo>Usuario</span></b></center></td>
                           <td><center><b><span class=fuente_titulo>Fecha</span></b></center></td>
                           <td><center><b><span class=fuente_titulo>Observacion</span></b></center></td>
                           </tr>";
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

                }
                mysql_free_result($sql_estado);
?>
<br /><br />
</tr>
</table>
<?php
mysql_close($conn);
?>
</table>
</center>
<br />
<center>
<table width="70%" cellspacing="2" cellpadding="2" border="0">
<tr class="border_tr">
<td width="95%" align="center">
<?php
$pagina_ori=$_SERVER['HTTP_REFERER'];
$posicion=strrpos($pagina_ori,"/");
$ir_pagina=substr($pagina_ori,$posicion+1);
$historia_en = $_GET['datos'];
?>
<br>
<form action="<?php echo $ir_pagina;?>" method="POST">
<div align="center">
<input type="submit" name="buscar" value="Retornar" class="boton" /></div>
</form>
</td>
</tr>
</table>
<?php
include("../final.php");
?>
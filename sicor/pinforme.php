<?php
include("../filtro.php");
?>
<?php
include("inicio.php");
include("script/functions.inc");
include("../conecta.php");
$institucion = $_SESSION["institucion"];
$cod_usr = $_SESSION["codigo"];
$cod_depar = $_SESSION["departamento"];
$ctrolvia=$_SESSION["ctrolvia"];
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
/* * *************************************************************************************************
                                GENERAR EL NUMERO DEL CITE
 * ************************************************************************************************* */
$valor_enviado = descifrar($_GET[sel]);
echo "$valor_enviado valo enviado";
if(!is_numeric($valor_enviado))
{
    echo "<center><b>!!!! INTENTO DE MANIPULACION DE DATOS !!!!</b></center>";
    exit;
}

$consul = mysql_query("SELECT * FROM departamento
                       WHERE departamento_cod_departamento='$cod_depar'", $conn);
if ($rcon = mysql_fetch_array($consul))
    {
	$dep2 = $rcon["departamento_dependencia_dep"];
    $buscar = mysql_query("SELECT * FROM documentodoc
                             WHERE documentodoc_depto='$cod_depar'
                             AND documentodoc_doc='$valor_enviado'", $conn);
    if (mysql_num_rows($buscar) > 0)
    {
        if ($fila = mysql_fetch_array($buscar))
        {
            $correlativo = $fila["documentodoc_correlativo"] + 1;
        }
    } 
    else
    {
        $insertar_correlativo = "INSERT INTO documentodoc(documentodoc_depto,documentodoc_doc,documentodoc_correlativo)
		  VALUES ('$cod_depar','$valor_enviado','0')";
        mysql_query($insertar_correlativo, $conn);
        $correlativo = 1;
    }

    $conexion2 = mysql_query("SELECT * FROM documentos WHERE '$valor_enviado'=documentos_id", $conn);
    if ($fila_cargo = mysql_fetch_array($conexion2))
    {
        $tipo_doc = $fila_cargo["documentos_sigla"];
        $tipo_descripcion = $fila_cargo["documentos_descripcion"];
    }
	//insertado
	$sSql = mysql_query("SELECT * FROM edificio WHERE edificio_cod_institucion='$institucion'", $conn);
    if ($edificio = mysql_fetch_array($sSql))
    {
        $edif = $edificio["edificio_sigla_ed"];
    }
	$prueba = mysql_query("SELECT * FROM departamento WHERE departamento_cod_departamento='$dep2'",$conn);
	if($dependencia=mysql_fetch_array($prueba))
	{
	$dep=$dependencia["departamento_sigla_dep"];
	}
	if ($dep == 'DPC')
	{
	$numcite = $edif . "/". strtoupper($rcon["departamento_sigla_dep"]) . "/" . $tipo_doc . "/" . $correlativo . "/" . date("Y");
	}
	else
	{
    $numcite = $edif . "/" .$dep. "/" . strtoupper($rcon["departamento_sigla_dep"]) . "/" . $tipo_doc . "/" . $correlativo . "/" . date("Y");
	}
}
mysql_free_result($consul);
?>
<?php
$error = 0;
if (isset($_POST['verimprimir']))
  {

    $ssql_consulta = mysql_query("SELECT * FROM documentos
                                  WHERE documentos_id = '$valor_enviado'", $conn);
    if (mysql_num_rows($ssql_consulta) > 0)
    {
      if ($fila_documento = mysql_fetch_array($ssql_consulta))
       {
                $variable_via = $fila_documento["documentos_via"];
                $verifica = count($_POST[tarde]);
                if ($verifica == 0)
                {
                    $error = 1;
                    $fun_para = 1;
                }

             /*  if (($variable_via == 1) && ($_SESSION[tipo_documento_enviado] == 0))
                {
                        if (empty($_POST[tarde1]))
                        {
                            $error = 2;
                            $fun_via = 1;
                        }
                }*/
       }
    }

    $verifica = count($_POST[tarde2]);
    if ($verifica == 0)
    {
        $error = 3;
        $fun_de = 1;
    }
    
    $valor1=val_alfanum($_POST[tema]);
    if($valor1 == 0)
    {
          $error = 4;
        $alert_tem = 1;
    }	

    if ($error == 0)
    {
        $fechahoy = date("Y-m-d");
        $horaactual = date("H:i:s");

        $consul = mysql_query("SELECT * FROM departamento
                               WHERE departamento_cod_departamento='$cod_depar'", $conn);
        if ($rcon = mysql_fetch_array($consul))
        {
            $buscar = mysql_query("SELECT * FROM documentodoc
                                   WHERE documentodoc_depto='$cod_depar'
                                   AND documentodoc_doc='$valor_enviado'", $conn);
            if (mysql_num_rows($buscar) > 0)
              {
                if ($fila = mysql_fetch_array($buscar))
                {
                    $correlativo = $fila["documentodoc_correlativo"] + 1;
                    mysql_query("UPDATE documentodoc SET
                                 documentodoc_correlativo='$correlativo'
                                 WHERE '$cod_depar'=documentodoc_depto
                                 AND documentodoc_doc='$valor_enviado'", $conn);
                }
              }
            else
            {
                $insertar_correlativo = "INSERT INTO documentodoc(documentodoc_depto,documentodoc_doc,documentodoc_correlativo)
                                         VALUES ('$cod_depar','$valor_enviado','1')";
                mysql_query($insertar_correlativo, $conn);
            }

            $conexion2 = mysql_query("SELECT * FROM documentos 
                                      WHERE '$valor_enviado' = documentos_id", $conn);
            if ($fila_cargo = mysql_fetch_array($conexion2))
            {
                $tipo_doc = $fila_cargo["documentos_sigla"];
                $tipo_descripcion = $fila_cargo["documentos_descripcion"];
            }

            $numcite = $edif . "/" . strtoupper($rcon["departamento_sigla_dep"]) . "/" . $tipo_doc . "/" . $correlativo . "/" . date("Y");
        }

        mysql_query("INSERT INTO registroarchivo(registroarchivo_hoja_interna,registroarchivo_usuario_inicia,registroarchivo_referencia,registroarchivo_fecha_recepcion, registroarchivo_hora_recepcion, registroarchivo_tipo,registroarchivo_depto,registroarchivo_cite,registroarchivo_membrete)
                     VALUES ('$numcite','$_SESSION[cargo_asignado]','$_POST[tema]','$fechahoy','$horaactual','$valor_enviado','$_SESSION[departamento]','$_POST[hoja_ruta_ref]','$_POST[tipo1]')", $conn);

        $numero_clave = mysql_insert_id(); //CORRELATIVO DE LA HOJA RUTA REGISTRADA



        /****************************************************************************
                                    GUARDA LA INFORMACION DE PARA
         *****************************************************************************/

               $elementos = count($_POST['tarde']);
               $via_igual_para = 0;
                foreach ($_POST['tarde'] as $value)
               {
                  
                   if($elementos == 1) 
                   {
                     if($_POST[tarde1] == $value)
                     {
                       $via_igual_para = 1;
                     }

                     $sql_consulta = mysql_query("SELECT cargos_cod_depto FROM cargos
                                                  WHERE cargos_id='$value'",$conn);
                     if($fila_cargo=mysql_fetch_array($sql_consulta))
                     {
                         $codigo_departamento_adquirido = $fila_cargo["cargos_cod_depto"];
                     }
                     mysql_free_result($sql_consulta);

                     $consulta_existe = "SELECT * FROM via WHERE via_mi_codigo='$_SESSION[cargo_asignado]'";
					 $rss_existe = mysql_query($consulta_existe, $conn);
			 		 $bandera= mysql_num_rows($rss_existe);
	                 if($bandera > 0)
						{
					        $int_rca = "INSERT INTO derivaciones SET
                            derivaciones_hoja_interna='$numero_clave',
                            derivaciones_cod_usr='$value',
                            departamento_cod_departamento='$codigo_departamento_adquirido',
                            derivaciones_estado='P',
                            derivaciones_estadoinicial='P',
							derivaciones_proveido='S'";
                         mysql_query($int_rca, $conn);
					   }
					 else
					   {    $int_rca = "INSERT INTO derivaciones SET
                            derivaciones_hoja_interna='$numero_clave',
                            derivaciones_cod_usr='$value',
                            departamento_cod_departamento='$codigo_departamento_adquirido',
                            derivaciones_estado='P',
                            derivaciones_estadoinicial='P',
							derivaciones_proveido='N'";
                         mysql_query($int_rca, $conn);
					   }  
					 
					 
					 
                   }
                   else
                   {
                      if ($_POST[tarde1] > 0)
                        {
                           if($_POST[tarde1] != $value)
                             {
								 $consulta_existe = "SELECT * FROM via WHERE via_mi_codigo='$_SESSION[cargo_asignado]'";
								 $rss_existe = mysql_query($consulta_existe, $conn);
								 $bandera= mysql_num_rows($rss_existe);
								 if($bandera > 0)
									{								 
								 
										 $int_rca = "INSERT INTO  derivaciones SET
													 derivaciones_hoja_interna='$numero_clave',
													 derivaciones_cod_usr='$value',
													 derivaciones_estado='P',
													 derivaciones_estadoinicial='P',
													 derivaciones_proveido='S'";											 
										 mysql_query($int_rca, $conn);
									}
								  else
								    {
										 $int_rca = "INSERT INTO  derivaciones SET
													 derivaciones_hoja_interna='$numero_clave',
													 derivaciones_cod_usr='$value',
													 derivaciones_estado='P',
													 derivaciones_estadoinicial='P',
													 derivaciones_proveido='N'";											 
										 mysql_query($int_rca, $conn);

									}		 
                              }
                        }
                        else
                        {
                              $int_rca = "INSERT INTO  derivaciones SET
                                             derivaciones_hoja_interna='$numero_clave',
                                             derivaciones_cod_usr='$value',
                                             derivaciones_estado='P',
                                             derivaciones_estadoinicial='P'";
                              mysql_query($int_rca, $conn);
                        }
                   }
				                      
               
        }


        /*****************************************************************************
                                GUARDA LA INFORMACION DE VIA
         *****************************************************************************/

       if (($variable_via == 1) && ($_SESSION[tipo_documento_enviado] == 0))
          {
            if ($_POST[tarde1] > 0)
            {
			     // modificado
                   if($via_igual_para == 0)
                   {
                   /* $int_rca1 = "INSERT INTO derivaciones(derivaciones_hoja_interna, derivaciones_cod_usr, derivaciones_estado,derivaciones_estadoinicial) VALUES ('$numero_clave','$_POST[tarde1]','V','V')";
                    mysql_query($int_rca1, $conn);
                   }*/
				   
				   foreach($_POST['tarde1'] as $value1)
					{
						$int_rca1 = "INSERT INTO derivaciones(derivaciones_hoja_interna,derivaciones_cod_usr,derivaciones_estado,derivaciones_estadoinicial,derivaciones_proveido) VALUES ('$numero_clave','$value1','V','V','S')";
						
						mysql_query($int_rca1,$conn);  
					}
				   }
				   
				   
				   
            }
          }

        /*****************************************************************************
                                GUARDA LA INFORMACION DE DE
         *****************************************************************************/

        $elementos2 = count($_POST['tarde2']);
        
        foreach ($_POST['tarde2'] as $value2)
        {
            $int_rca2 = "INSERT INTO derivaciones(derivaciones_hoja_interna,derivaciones_cod_usr,derivaciones_estado,derivaciones_estadoinicial,derivaciones_proveido) VALUES ('$numero_clave','$value2','D','D','S')";
            mysql_query($int_rca2, $conn);
        }
?>
        <script language="JavaScript">
            window.self.location="encuentra2.php";
        </script>
<?php
    }
}
?>

<?php
if (isset($_POST['cancelar'])) {
?>
    <script language="javascript">
        window.self.location="ingreso_nota.php";
    </script>
<?php
}
if (isset($_POST['Arriba'])) {

$orden1 = $_POST['orden1'];
$orden2 = $_POST['orden2'];
$orden3 = $_POST['orden3'];

$user1 = $_POST['user1'];
$user2 = $_POST['user2'];
$user3 = $_POST['user3'];


$ssql_ini = mysql_query("SELECT min(via_orden) FROM via", $conn);
$row_ini = mysql_fetch_array($ssql_ini);
$viaini=$row_ini[0];

if($orden2==$viaini)
{?> 
    <script language="javascript">
        alert("Error, el registro se encuentra en la primera posición");
    </script>
<?PHP 
}
else
{ 
  mysql_query("UPDATE via SET via_orden='$orden1' WHERE via_mi_codigo='$_SESSION[cargo_asignado]' AND via_su_codigo='$user2'", $conn);
  mysql_query("UPDATE via SET via_orden='$orden2' WHERE via_mi_codigo='$_SESSION[cargo_asignado]' AND via_su_codigo='$user1'", $conn);	

$orden1 = $_POST['orden1'];
$orden2 = $_POST['orden2'];
$orden3 = $_POST['orden3'];

$user1 = $_POST['user2'];
$user2 = $_POST['user1'];
$user3 = $_POST['user3'];
	
	
}


}



if (isset($_POST['Abajo'])) {

$orden1 = $_POST['orden1'];
$orden2 = $_POST['orden2'];
$orden3 = $_POST['orden3'];

$user1 = $_POST['user1'];
$user2 = $_POST['user2'];
$user3 = $_POST['user3'];

$ssql_fin = mysql_query("SELECT max(via_orden) FROM via", $conn);
$row_fin = mysql_fetch_array($ssql_fin);
$viafin=$row_fin[0];

if ($orden2==$viafin)
{?>
    <script language="javascript">
        alert("Error, el registro se encuentra en la ultima posición");
    </script>
<?PHP 
}
else
{
  mysql_query("UPDATE via SET via_orden='$orden2' WHERE via_mi_codigo='$_SESSION[cargo_asignado]' AND via_su_codigo='$user3'", $conn);
  mysql_query("UPDATE via SET via_orden='$orden3' WHERE via_mi_codigo='$_SESSION[cargo_asignado]' AND via_su_codigo='$user2'", $conn);	

$orden1 = $_POST['orden1'];
$orden2 = $_POST['orden2'];
$orden3 = $_POST['orden3'];

$user1 = $_POST['user1'];
$user2 = $_POST['user3'];
$user3 = $_POST['user2'];	
}
}
?>


<script language="javascript">
function asignar(var1,var2,var3,var4,var5,var6)
{   
   document.envio.orden1.value=var1;
   document.envio.user1.value=var2;
   document.envio.orden2.value=var3;
   document.envio.user2.value=var4;
   document.envio.orden3.value=var5;
   document.envio.user3.value=var6;
} 
</script>
<style type="text/css">
<!--
.Estilo1 {font-weight: bold}
-->
</style>

<center>
<?php
if ($error != 0) {
    echo "<center><table width=25%><tr><td class=fuente_normal_rojo  align=left><center><b> !!! ERROR DATOS NO VALIDOS !!!</b></center>" . $valor_error . "</td></tr></table></center>";
}
?>

<form name="envio" method="POST">

<table border="0" cellpadding="0" cellspacing="2" align="center" width="60%" >
         <tr>
                <td align="center" colspan="2" style="background-color: #1E679A; font-weight: bold; color: #ffffff; padding: 2 2 2 2px;">
                    <span class="fuente_normal">
<?php
echo "<br>";
echo "<b class='fuente_titulo'>";
echo "<center>TIPO DE DOCUMENTO: " . $tipo_descripcion . "</center></b>";

echo "<b class='fuente_titulo_principal'>CITE : " . $numcite . "</b>";
?>
            <br />                </td>
    </tr>
<?php
$ssql_consulta = mysql_query("SELECT * FROM documentos
                              WHERE documentos_id = '$valor_enviado'", $conn);

if (mysql_num_rows($ssql_consulta) > 0)
{
  if ($fila_documento = mysql_fetch_array($ssql_consulta))
   {
?>
    <tr class="border_tr3">
        <td align="right"  valign="top">
            <b>Para:</b>        </td>
        <td>
        <table width="95%" BORDER="0" CELLSPACING="2" CELLPADDING="0" class="fuente_normal" >
            <tr bgcolor="#CCCCCC">
                <td width="250"><b>FUNCIONARIO</b>                </td>
              <td width="350"><b>CARGO</b>            </tr>
        </table>
       <div style="overflow:auto; width:98%; height:100px; align:left;">
       <table width="95%" BORDER="0" CELLSPACING="2" CELLPADDING="0" class="fuente_normal">
<?php
    if ($fila_documento["documentos_para"] == 1)
    {
        $para_solouno = 0;
        $sql_aux = mysql_query("SELECT * FROM cargos
                                WHERE cargos_id='$_SESSION[cargo_asignado]'
                                AND cargos_dependencia=0",$conn);
        if(mysql_num_rows($sql_aux) > 0)
        {
            $para_solouno = 3;
            $consulta_aux = "SELECT * FROM asignar
                             WHERE asignar_mi_codigo='$_SESSION[cargo_asignado]'
                             AND asignar_estado = '1'";
            $rss_consulta = mysql_query($consulta_aux, $conn);
        }
        else
        {
            $consulta_aux = "SELECT * FROM asignar
                             WHERE asignar_mi_codigo='$_SESSION[cargo_asignado]'
                             AND asignar_estado = '1'
                             AND asignar_original <> '1'";
            $rss_consulta = mysql_query($consulta_aux, $conn);
            if(mysql_num_rows($rss_consulta) > 0)
            {
                mysql_free_result($rss_consulta) ;
                $consulta_aux = "SELECT * FROM asignar
                                 WHERE asignar_mi_codigo='$_SESSION[cargo_asignado]'
                                 AND asignar_estado = '1'";
                $rss_consulta = mysql_query($consulta_aux, $conn);
            }
            else
            {
                 $para_solouno = 1;
                 mysql_free_result($rss_consulta) ;
                 $consulta_aux = "SELECT * FROM asignar
                                  WHERE asignar_mi_codigo='$_SESSION[cargo_asignado]'
                                  AND asignar_estado = '1'
                                  AND asignar_original = '1'";
                 $rss_consulta = mysql_query($consulta_aux, $conn);
            }
        }
    }
    else
    {
    $para_solouno = 2;
    $consulta_aux = "SELECT * FROM asignar
                     WHERE asignar_mi_codigo='$_SESSION[cargo_asignado]'
                     AND asignar_estado = '1'
                     AND asignar_original = '1'";
    $rss_consulta = mysql_query($consulta_aux, $conn);
    }

    
    $_SESSION[tipo_documento_enviado] = $para_solouno;

    if (mysql_num_rows($rss_consulta) > 0)
    {
        while ($row2 = mysql_fetch_array($rss_consulta))
        {
?>
             <tr>
              <td bgcolor="#EFEBE3" width="270">
			   <?php if (!empty($_POST['tarde']))
                {
                ?>
                 <input type="checkbox" value="<?php echo $row2["asignar_su_codigo"];?>" name="tarde[]" <?php if(in_array($row2["asignar_su_codigo"],$_POST['tarde'])) {echo "checked";} ?> />
                <?php
                }
                else
                {	
				?>
                  <input type="checkbox" value="<?php echo $row2["asignar_su_codigo"]; ?>" name="tarde[]" selected />
              
                   <?php
				   }
				    Alert($fun_para); 
					?>
                    <?php
                    $valor_nombre = $row2["asignar_su_codigo"];
                    $conexion = mysql_query("SELECT * FROM usuario
                                             WHERE '$valor_nombre'=usuario_ocupacion
                                             AND usuario_active=1", $conn);
                    if ($fila_clave = mysql_fetch_array($conexion))
                    {
                        $nombre_aux = $fila_clave["usuario_nombre"];
                        echo "<span class=fuente_normal>" . strtoupper($nombre_aux) . "</span>";
                    }
                    ?>               </td>
               <td width="330">
<?php
                    $valor_clave = $row2["asignar_su_codigo"];
                    $conexion = mysql_query("SELECT * FROM cargos WHERE '$valor_clave'=cargos_id", $conn);
                    if ($fila_clave = mysql_fetch_array($conexion))
                    {
                        $cargo_aux = $fila_clave["cargos_cargo"];
                        echo "<span class=fuente_normal>" . strtoupper($cargo_aux) . "</span>";
                    }
?>               </td>
                    <?php
        }
      }
      ?>
          </table>
                        <br />
          </div>
                    <!--fin multiples -->      </td>
    </tr>

<?php


if ($fila_documento["documentos_via"] == 1 && $para_solouno == 0)
{
    $via_habilitado = $fila_documento["documentos_via"];
	
	$consulta_existe = "SELECT * FROM via WHERE via_mi_codigo='$_SESSION[cargo_asignado]'";
	$rss_existe = mysql_query($consulta_existe, $conn);
	$bandera= mysql_num_rows($rss_existe);
	if($bandera > 0)
	{
?>
            <tr class="border_tr3">
                <td align="right" valign="top">
                    <table width="50" border="0" cellpadding="0" cellspacing="0">
                      <tr class="border_tr3">
                        <td align="right"><strong>Via:&nbsp;</strong></td>
                      </tr>
                      <tr>
                        <td height="46" align="right" valign="top"><input type="submit" name="Arriba" id="button" value="arriba" class="boton"/>
                        <input type="hidden" name="orden1" id="orden1" value="<?PHP echo $orden1?>" />
                        <input type="hidden" name="user1" id="user1" value="<?PHP echo $user1?>" />
                        <input type="hidden" name="orden2" id="orden2" value="<?PHP echo $orden2?>" />
                        <input type="hidden" name="user2" id="user2" value="<?PHP echo $user2?>" />
                        <input type="hidden" name="orden3" id="orden3" value="<?PHP echo $orden3?>" />
                        <input type="hidden" name="user3" id="user3" value="<?PHP echo $user3?>" />
                        </td>
                      </tr>
                      <tr>
                        <td height="47" align="right" valign="bottom"><input type="submit" name="Abajo" id="button2" value="abajo" class="boton" /></td>
                      </tr>
      </table></td>
                <td>
                    <!--multiples -->
                    <table width="95%" BORDER="0" CELLSPACING="2" CELLPADDING="0" class="fuente_normal">
                        <tr bgcolor="#CCCCCC">
                            <td width="250"><b>FUNCIONARIO</b>                            </td>
                          <td width="350"><b>CARGO</b>                        </tr>
                  </table>


                    <div style="overflow:auto; width:98%; height:100px; align:left;">
                        <table width="95%" BORDER="0" CELLSPACING="2" CELLPADDING="0" class="fuente_normal">
                                <?php
                                mysql_free_result($rss_consulta);
																				  
                                $rss_consulta = mysql_query("SELECT * FROM cargos
                                                             WHERE cargos_id = '$_SESSION[cargo_asignado]'", $conn);
															
                                if (mysql_num_rows($rss_consulta) > 0)
                                 {
                                    if ($fila_via = mysql_fetch_array($rss_consulta))
                                    {
                                            // operacion Anulado
											// $sql_aux=mysql_query("SELECT * FROM cargos a, usuario b
                                            //                      WHERE a.cargos_id='$fila_via[cargos_dependencia]'
                                            //                      AND a.cargos_id=b.usuario_ocupacion",$conn);
											// operacion anulado
											if($ctrolvia=='0' || $ctrolvia=="")
											{ 
											  $sql_aux=mysql_query("SELECT * FROM via v, usuario b, cargos c
                                                WHERE v.via_mi_codigo='$_SESSION[cargo_asignado]'
                                                     AND v.via_su_codigo=b.usuario_ocupacion and
													 v.via_estado='1' and v.via_su_codigo=c.cargos_id order by c.cargos_dependencia",$conn);
  											  $sql_aux2=mysql_query("SELECT * FROM via v, usuario b, cargos c
                                                WHERE v.via_mi_codigo='$_SESSION[cargo_asignado]'
                                                     AND v.via_su_codigo=b.usuario_ocupacion and
													 v.via_estado='1' and v.via_su_codigo=c.cargos_id order by c.cargos_dependencia",$conn);
											}
											else
											{ 
											  $sql_aux=mysql_query("SELECT * FROM via v, usuario b, cargos c
                                                WHERE v.via_mi_codigo='$_SESSION[cargo_asignado]'
                                                     AND v.via_su_codigo=b.usuario_ocupacion and
													 v.via_estado='1' and v.via_su_codigo=c.cargos_id order by v.via_orden",$conn);
											  $sql_aux2=mysql_query("SELECT * FROM via v, usuario b, cargos c
                                                WHERE v.via_mi_codigo='$_SESSION[cargo_asignado]'
                                                     AND v.via_su_codigo=b.usuario_ocupacion and
													 v.via_estado='1' and v.via_su_codigo=c.cargos_id order by v.via_orden",$conn);
											}
                                            //if($fila_via_dos!=  mysql_fetch_array($sql_aux)) modificado
											$cont=1;
											$pos=1;
											while($fila_via_dos2=  mysql_fetch_array($sql_aux2))
                                            {   $usuario_dependencia_pos[$pos]=$fila_via_dos2["usuario_ocupacion"];
 										        $pos=$pos+1;
											}
											while($fila_via_dos=  mysql_fetch_array($sql_aux))
                                            {   
                                                $usuario_dependencia=$fila_via_dos["usuario_ocupacion"];
												$inicio= $fila_via_dos["via_orden"]-1;
												$medio= $fila_via_dos["via_orden"];
												$final= $fila_via_dos["via_orden"]+1;
												
												$_SESSION["ctrolvia"]=1;
												if($fila_via_dos[via_original]=='0')
												{ mysql_query("UPDATE via SET via_orden='$cont', via_original='1'
				                                  WHERE '$fila_via_dos[via_mi_codigo]'=via_mi_codigo
                				                  AND via_su_codigo='$fila_via_dos[via_su_codigo]'", $conn);
                                                 $cont=$cont+1;
												 
												}
                               ?>
                                    <tr>
                                        <td bgcolor="#EFEBE3" width="270">
											  <input type="checkbox" value="<?php echo $fila_via_dos["usuario_ocupacion"]; ?>" name="tarde1[]"  <?php if(in_array($fila_via_dos["usuario_ocupacion"],$_POST['tarde1'])) {echo "checked";} ?>/>
											  <input type="radio" onclick="asignar(
                                              '<?php echo $fila_via_dos["via_orden"]-1;?>',
                                              '<?php echo $usuario_dependencia_pos[$inicio];?>',
                                              '<?php echo $fila_via_dos["via_orden"]; ?>',
                                              '<?php echo $usuario_dependencia_pos[$medio];?>',
                                              '<?php echo $fila_via_dos["via_orden"]+1; ?>',
                                              '<?php echo $usuario_dependencia_pos[$final];?>')" name="radio" id="radio" value="radio" />
									   <?php Alert($fun_via); ?>
									   
                                          <?php
                                            $nombre_aux = $fila_via_dos["usuario_nombre"];
                                            echo "<span class=fuente_normal>" . strtoupper($nombre_aux) . "</span>";
                                          ?>
                                         </td>
                                       <td width="330">
                                        <?php
                                            $cargo_aux = $fila_via_dos["cargos_cargo"];
                                            echo "<span class=fuente_normal>" . strtoupper($cargo_aux) . "</span>";
                                       ?>                                       </td>
<?php
                                            }
                                            mysql_free_result($sql_aux);
                                    }
                                }
?>
                      </table>
                                    <br>
                  </div>
                                <!--fin multiples -->              </td>
    </tr>
	
	
	
	
<?php
 }
 } 
?>
                        <?php
}
}
?>
                        <tr class="border_tr3">
                            <td align="right"  valign="top" ><strong>
                          De:&nbsp;&nbsp;                            </strong></td>
                            <td>
                                <!--multiples -->
                                <table width="95%" BORDER="0" CELLSPACING="2" CELLPADDING="0" class="fuente_normal">
                                    <tr bgcolor="#CCCCCC">
                                        <td width="250"><b>FUNCIONARIO</b>                                        </td>
                                    <td width="350"><b>CARGO</b>                                    </tr>
                                </table>
                                <div style="overflow:auto; width:98%; height:100px;  align:left;">
                                    <table width="95%" BORDER="0" CELLSPACING="2" CELLPADDING="0" class="fuente_normal">
                                    <?php
                                   
                                    if($via_habilitado == 1)
                                    {
                                        $sql_consulta_de = "SELECT * FROM usuario a, cargos b
                                                            WHERE b.cargos_id = a.usuario_ocupacion
                                                            AND b.cargos_id <> '$usuario_dependencia'
                                                            AND a.usuario_cod_departamento = '$cod_depar'";
															                                    }
                                     else
                                    {
                                        $sql_consulta_de = "SELECT * FROM usuario a, cargos b
                                                         WHERE b.cargos_id = '$_SESSION[cargo_asignado]'
                                                         AND b.cargos_id = a.usuario_ocupacion";

                                     }
                                    
                                    $rss_consulta_de = mysql_query($sql_consulta_de, $conn);
                                    if (mysql_num_rows($rss_consulta_de) > 0)
                                    {
                                      while ($row22 = mysql_fetch_array($rss_consulta_de))
                                      {
                                        ?>
                                        <tr>
                                        <td bgcolor="#EFEBE3" width="270">
                                          <?php
                                          if($row22["usuario_ocupacion"] == $_SESSION[cargo_asignado])
                                          {
                                          ?>
                                          <input type="checkbox" value="<?php echo $row22["usuario_ocupacion"]; ?>" name="tarde2[]" checked="checked" />
                                          <?php
                                          }
                                          else
                                          {
                                           ?>
                                          <input type="checkbox" value="<?php echo $row22["usuario_ocupacion"]; ?>" name="tarde2[]">
                                          <?php
                                          }
                                          ?>
                                          <?php Alert($fun_de); ?>
                                           <?php
                                            echo "<span class=fuente_normal>" . strtoupper($row22["usuario_nombre"]) . "</span>";
                                            ?>                                          </td>
                                            <td width="330">
                                            <?php
                                            echo "<span class=fuente_normal>" . strtoupper($row22["cargos_cargo"]) . "</span>";
                                            ?>                                            </td>
<?php
                                        }
                                    }
?>
                                </table>
                                <br>
                            </div>
                            <!--fin multiples -->                        </td>
                    </tr>
                    <tr class="border_tr3">
                        <td align="right"  valign="top" size="30">
                            REF.:&nbsp;&nbsp;                        </td>
                        <td>
                           <textarea name="tema" rows="2" cols="50"><?php echo $_POST['tema']; ?></textarea>
                            <?php
                            Alert($alert_tem);
                           ?>                </td>
            </tr>

                  <!--  <tr class="border_tr3">
                      <td align="right"><b>H.R. REF.:</b></td>
                      <td align="left"><select name="hoja_ruta_ref">
                        <option value="0">Elegir...</option>
                        <?PHP 
		$consulta_cite = "SELECT ingreso_hoja_ruta FROM ingreso";
        $_consulta = mysql_query($consulta_cite, $conn);
        
		while($_para = mysql_fetch_array($_consulta))
        {?>
                        <option value="<?PHP echo $_para['ingreso_hoja_ruta'] ?>"><?PHP echo $_para['ingreso_hoja_ruta'] ?></option>
                        <?PHP 
		}
		?>
                      </select></td>
                    </tr> -->
                    <tr class="border_tr3">
                      <td align="right">&nbsp;</td>
                      <td align="center"><span class="Estilo1"><strong>CON MEMBRETE</strong>
                          <input name="tipo1" type="radio" value="S" onclick="javascript:CopiaValor(this);" />
SIN MEMBRETE
<input name="tipo1" type="radio" value="N" onclick="javascript:CopiaValor(this);" />
                      </span></td>
                    </tr>
            <tr class="border_tr3">
                <td align="right">
&nbsp;&nbsp;                </td>
                <td >&nbsp;</td>
            </tr>
  </table>
</center>

<center>
    <table border="0" cellpadding="0" cellspacing="2" align="center" width="80%">
        <tr>
            <td align="center" colspan="2">
                <input type="submit" name="verimprimir" value="Aceptar" class="boton"/>
                <input type="submit" name="cancelar" value="Cancelar" class="boton"  />
            </td>
        </tr>
    </table>
</cente>
</form>
<?php
include("final.php");
?>

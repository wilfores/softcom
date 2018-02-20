<?php
include("../filtro.php");
include("inicio.php");
include("script/functions.inc");
include("../conecta.php");
$institucion = $_SESSION["institucion"];
$cod_usr=$_SESSION["cargo_asignado"];
$cod_depar=$_SESSION["departamento"];
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
/***************************************************************************************************
   		                            GENERAR EL NUMERO DEL CITE
***************************************************************************************************/
$consul=mysql_query("select * from departamento where departamento_cod_departamento='$cod_depar'",$conn);
if ($rcon=mysql_fetch_array($consul))
{
    $guardar=$rcon["departamento_cod_edificio"];
	$consuledif=mysql_query("select * from edificio where edificio_cod_edificio='$guardar'",$conn);
	if ($edif=mysql_fetch_array($consuledif))
	{
	$edificio=$edif["edificio_sigla_ed"];
	}

	$buscar=mysql_query("select * from externa where externa_depto='$cod_depar' and externa_cargo='$cod_usr'",$conn);//ojo

	if (mysql_num_rows($buscar) > 0)
	{
		   if($fila=mysql_fetch_array($buscar))
		   {
		   $correlativo=$fila["externa_correlativo"] + 1;
		   }
		   
	}
	else
	{
	
		$buscar_aux=mysql_query("select * from externa where externa_depto='$cod_depar'",$conn);
		if (mysql_num_rows($buscar_aux) > 0)
		{
			   if($fila_aux=mysql_fetch_array($buscar_aux))
			   {
			   $correlativo=$fila_aux["externa_correlativo"] + 1;
			   $correlativo_aux=$fila_aux["externa_correlativo"];
			  $insertar_correlativo = "INSERT INTO externa(externa_depto,externa_cargo,externa_correlativo) VALUES ('$cod_depar','$cod_usr','$correlativo_aux')";
	          mysql_query($insertar_correlativo,$conn);		  
	         }
		}
        else
	    {
	         $insertar_correlativo = "INSERT INTO externa(externa_depto,externa_cargo,externa_correlativo) VALUES ('$cod_depar','$cod_usr','0')";
	         mysql_query($insertar_correlativo,$conn);		  
	         $correlativo=1;	
	    }		
   }
    
   $numcite=$edificio."-".strtoupper($rcon["departamento_sigla_dep"])."-No. ".$correlativo."/".date("Y");

 }  
?>

<?php
if (isset($_POST['verimprimir'])) 
{ 
  
  if(empty($_POST['tema'])){
    $error = TRUE;
	$alert_tem = 1;
  } 
  
    if(empty($_POST['destinatario']))
	{
    $error = TRUE;
	$alert_destinatario = 1;
    } 
	
    if(empty($_POST['hojas']))
	{
    $error = TRUE;
	$alert_hojas = 1;
    } 	
	
    if(empty($_POST['cargo_d']))
	{
    $error = TRUE;
	$alert_cargo_d = 1;
    } 	
 


  
if (!$error) 
  { 
	  $fechahoy=date("Y-m-d");
	  $horaactual=date("H:i:s");
	  

   
	 /*********************************************************************************************************************
	                                         VERIFICACION DE EXISTENCIA DE DOCUMENTO-CORRELATIVO
	 *********************************************************************************************************************/
	 
$consul=mysql_query("select * from departamento where departamento_cod_departamento='$cod_depar'",$conn);
if ($rcon=mysql_fetch_array($consul))
{


    $guardar=$rcon["departamento_cod_edificio"];
	$consuledif=mysql_query("select * from edificio where edificio_cod_edificio='$guardar'",$conn);
	if ($edif=mysql_fetch_array($consuledif))
	{
	$edificio=$edif["edificio_sigla_ed"];
	}
	
	$buscar=mysql_query("select * from externa where externa_depto='$cod_depar' and externa_cargo='$cod_usr'",$conn);//ojo
	if (mysql_num_rows($buscar) > 0)
	{
		   if($fila=mysql_fetch_array($buscar))
		   {
		   $correlativo=$fila["externa_correlativo"] + 1;
	    mysql_query("UPDATE externa SET externa_correlativo='$correlativo' WHERE '$cod_depar'=externa_depto",$conn);		   
		   }
		   
	}
	else
	{
	
		$buscar_aux=mysql_query("select * from externa where externa_depto='$cod_depar'",$conn);
		if (mysql_num_rows($buscar_aux) > 0)
		{
			   if($fila_aux=mysql_fetch_array($buscar_aux))
			   {
			   $correlativo=$fila_aux["externa_correlativo"] + 1;
			   $correlativo_aux=$fila_aux["externa_correlativo"];
			  $insertar_correlativo = "INSERT INTO externa(externa_depto,externa_cargo,externa_correlativo) VALUES ('$cod_depar','$cod_usr','$correlativo_aux')";
	          mysql_query($insertar_correlativo,$conn);		  
	         }
		}
        else
	    {
	         $insertar_correlativo = "INSERT INTO externa(externa_depto,externa_cargo,externa_correlativo) VALUES ('$cod_depar','$cod_usr','0')";
	         mysql_query($insertar_correlativo,$conn);		  
	         $correlativo=1;	
	    }		
   }
    
   $numcite=$edificio."-".strtoupper($rcon["departamento_sigla_dep"])."-No. ".$correlativo."/".date("Y");
}

mysql_query("INSERT INTO hojaexterna(hojaexterna_generador,hojaexterna_depto,hojaexterna_hoja, hojaexterna_fecha,hojaexterna_hora, hojaexterna_destinatario, hojaexterna_cargo,hojaexterna_referencia,hojaexterna_hojas,hojaexterna_adjunto) VALUES ('$_SESSION[cargo_asignado]','$_SESSION[departamento]','$numcite','$fechahoy','$horaactual','$_POST[destinatario]','$_POST[cargo_d]','$_POST[tema]','$_POST[hojas]','$_POST[adjunto]')",$conn);
 


		
	?>
    <script language="JavaScript">
    window.self.location="bandeja_externa.php";
    </script>
  	<?php
  
	}
 }  
?>

<?php 
if (isset($_POST['cancelar']))
{
?>
<script language="javascript">
window.self.location="bandeja_externa.php";
</script>
<?php
}
?>
<center>
<?php
if ($error != 0)
{
echo "<center><table width=25%><tr><td class=fuente_normal_rojo  align=left><center><b> !!! ERROR DATOS NO VALIDOS !!!</b></center>".$valor_error."</td></tr></table></center>";
}
?>
<table border="0" cellpadding="0" cellspacing="2" align="center" width="60%" >
<form name="envio" method="POST">
<tr>
<td align="center" colspan="2" >
<span class="fuente_normal">
<?php
    echo "<br>";
	echo "<b class='fuente_titulo'>";
    echo "<br>";
   echo "<b class='fuente_titulo_principal'>CITE : ".$numcite."</b>";
	
?>
    <div align="center" style="background-color: #1E679A; font-weight: bold; color: #ffffff; padding: 2 2 2 2px;">
	<input type="hidden" name="numcite" value="<?php echo $numcite;?>" />
    <input type="hidden" name="correlativo" value="<?php echo $correlativo;?>" />
    </div>
    <BR />

</td>
</tr>

<tr class="border_tr3">
<td align="left"   >
DESTINATARIO: 
</td>
<td>
&nbsp;&nbsp;&nbsp;
<?php
if (isset($_POST['destinatario'])) {
?><input type="text" name="destinatario" size="100" value="<?php echo $_POST['destinatario']; ?>" ><?php
}else{
   echo "<input type=\"text\" name=\"destinatario\" size=\"100\"/>";    
}
 Alert($alert_destinatario); ?>
</td>
</tr>


<tr class="border_tr3">
<td align="left"   >
CARGO DESTINATARIO: 
</td>
<td>
&nbsp;&nbsp;&nbsp;
<?php
if (isset($_POST['cargo_d'])) {
?><input type="text" name="cargo_d"  value="<?php echo $_POST['cargo_d']; ?>" ><?php
}else{
   echo "<input type=\"text\" name=\"cargo_d\" size=\"100\"/>";    
}
 Alert($alert_cargo_d); ?>
</td>
</tr>



<tr class="border_tr3">
<td align="right"  >
REF.: 
</td>
<td>

	   <textarea name="tema"  cols="60" rows="2"><?php echo $_POST['tema'];?></textarea>
      <?php Alert($alert_tem);?>

</td>
</tr>


<tr class="border_tr3">
<td align="left"   >
CANTIDAD HOJAS: 
</td>
<td>

<?php
if (isset($_POST['hojas'])) {
?><input type="text" name="hojas" size="10"  value="<?php echo $_POST['hojas']; ?>" ><?php
}else{
   echo "<input type=\"text\" name=\"hojas\" size=\"10\"/>";    
}
 Alert($alert_hojas); 
?>
</td>
</tr>


<tr class="border_tr3">
<td align="left"   >
TIPO ANEXOS: 
</td>
<td>
<input type="text" name="adjunto" size="100" value="<?php echo $_POST['adjunto'];?>" >
</td>
</tr>


<tr class="border_tr3">
<td align="right">
&nbsp;&nbsp;
</td>
<td align="left">
&nbsp;&nbsp;
</td>
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
</form>
</tr>
</table>
</center>
<?php
include("final.php");
?>


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
$codigo_usuario=$_SESSION["codigo"];
$codigo=$_SESSION["cargo_asignado"];
$depto=$_SESSION["departamento"];
//unset($_SESSION["codigo_libro_reg"]);
$fecha_hoy = date("Y-m-d");
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
//echo "$codigo <br>";
//echo "$codigo_usuario <br>";

//variables para el filtrado
$h_rut="";	
$t_doc="";
$n_cit="";
if($_POST["h_rut"])
{
	$h_rut=$_POST["h_rut"];
}else{
	if($_GET["h_rut"]){
		$h_rut=$_GET["h_rut"];
	}
}
if($_POST["t_doc"])
{
	$t_doc=$_POST["t_doc"];
}else{
	if($_GET["t_doc"])
	{
		$t_doc=$_GET["t_doc"];
	}
}
if($_POST["n_cit"])
{
	$n_cit=$_POST["n_cit"];
}else{
	if($_GET["n_cit"])
	{
		$n_cit=$_GET["n_cit"];
	}
}

?>
<style>
	.nuevos{
		margin: 4px;
		border: 0px solid #cccccc;
		/*background-color: #e3e9ef; */
		/*background-color:#BCC9E0; */
		background-color:#F8C2C4; 
		padding: 10px;
		font-size: 11px;
		color: #254D78;
	}
	.externos{
		margin: 4px;
		border: 0px solid #cccccc;
		/*background-color: #e3e9ef; */
		/*background-color:#BCC9E0; */
		background-color:#FEF996; 
		padding: 10px;
		font-size: 11px;
		color: #254D78;	
	}
	.derivados{
		margin: 4px;
		border: 0px solid #cccccc;
		/*background-color: #e3e9ef; */
		/*background-color:#BCC9E0; */
		background-color:#A7FCA3; 
		padding: 10px;
		font-size: 11px;
		color: #254D78;	
	}
</style>
<script language="JavaScript">

	var totsel=0;
	var vechru= new Array();
	var arrmostrar="";
	var cantidad=1;
	var cantidad2=1;
	
function armar(val){
	if(totsel<5){			
		
			document.getElementById("canid").value=cantidad;
			document.getElementById("icanid").value=cantidad;
			cantidad++;
			//arrmostrar=arrmostrar+"&"+val+"="+nom;
			document.getElementById("arrid").value+=val+", ";
			document.getElementById("iarrid").value+=val+", ";			
			//alert(document.getElementById("canid").value);
			//alert(document.getElementById("arrid").value);
			document.getElementById("iarrid").value=document.getElementById("iarrid").value;
//			alert(document.getElementById("iarrid").value);
			totsel++;			
	}
	else{
		alert("solo puede elegir 5 registros");
	}

}
function armard(val){
	if(totsel<5){			
//		alert(val);
			document.getElementById("dcanid").value=cantidad2;
			cantidad2++;
			document.getElementById("darrid").value+=val+", ";			
			//alert(document.getElementById("canid").value);
			//alert(document.getElementById("arrid").value);
			totsel++;			
	}
	else{
		alert("solo puede elegir 5 registros");
	}

}
function Abre_ventana (pagina)
{
     ventana=window.open(pagina,"Asignar","toolbar=no,location=0,directories=no,status=no,menubar=no,scrollbars=yes,resizable=yes,width=420,height=200");
}

function Retornar(){
	document.ingreso.action="menu2.php";
	document.ingreso.submit();
}
</script>

<br>
<p class="fuente_titulo">
<center><b style=" font-size:18px">LISTADO DE ENVIADOS</b></center></p>
<center>
<form name="formfiltro" action="libroregistro2.php" method="POST">
	Hoja de Ruta: <input type="text" name="h_rut" value="<? echo $h_rut; ?>" size=5>
    &nbsp; &nbsp;
	Nro de cite: <input type="text" name="n_cit" value="<? echo $n_cit; ?>" size=5>
    &nbsp; &nbsp;
	Tipo de Documento: <select name="t_doc" style="width:150px">
    <option value="<? echo $t_doc; ?>"><? echo $t_doc; ?></option>
    <?php
		$respss=mysql_query("select documentocargo_doc, documentos_descripcion, documentos_sigla 
								from documentocargo, documentos 
								where documentocargo_doc=documentos_id 
								group by documentos_descripcion
								order by documentos_descripcion",$conn);
		while($rowass=mysql_fetch_array($respss))
		{
				echo " <option value='".$rowass['documentos_descripcion']."'>"; 
				echo $rowass["documentos_descripcion"];
				echo "</option>";
		}
	?>
      </select>
    &nbsp; &nbsp;  
   	<input type="hidden" value="" id="canid" name="canid">
	<input type="hidden" value="" id="arrid" name="arrid">
    <input type="submit" value="Buscar" class="boton">
    &nbsp; &nbsp;  
    <input type="button"  value="Ver Todo" class="boton" onClick="window.location='libroregistro2.php'">
</form>
<!--  style="font-size:9px; color:blue;"-->
</center>

<table width="90%" cellspacing="1" cellpadding="1" border="0" align="center">
<tr style="font-size: 8pt; color:#FFFFFF" bgcolor="#3E6BA3">
	<td width="3%" align="center"><span >Elija</td>
	<td width="6%" align="center"><span >Hoja Ruta</td>
	<td width="6%" align="center"><span >No Cite</td>
	<td width="8%" align="center"><span >Fecha Elaboracion</td>
	<td width="15%" align="center"><span >Elaborado por</td>
	<td width="14%" align="center"><span >Destinatario</td>
	<td width="10%" align="center"><span >Tipo Doc</td>
	<td width="8%" align="center"><span >Estado</td>	
	
</tr>
<div class="nuevos"> CORRESPONDENCIA NUEVA</div>
<div class="externos"> CORRESPONDENCIA EXTERNA</div>
<div class="derivados"> CORRESPONDENCIA DERIVADA</div>
<!--<meta content="5;URL=listado_de_mi2.php" http-equiv="REFRESH">-->
<?php
echo "<form name='miform'>";
$slista="SELECT 
registrodoc1_id, registrodoc1_hoja_ruta, registrodoc1_fecha_elaboracion, registrodoc1_de, usuario_nombre, registrodoc1_referencia, documentos_descripcion, registrodoc1_estado, registrodoc1_asociar, registrodoc1_asociar_h_r, registrodoc1_cc, registrodoc1_cite, usuario_ocupacion, registrodoc1_asociar, documentos_id
FROM `registrodoc1`, `documentos`, `usuario`
where registrodoc1_depto = '$depto' 
and registrodoc1_para=usuario_ocupacion
and registrodoc1_situacion= 'P' 
and registrodoc1_doc=documentos_sigla ";

if($h_rut!=""){
$slista = $slista. "and registrodoc1_hoja_ruta like '%$h_rut%' ";
}
if($t_doc!=""){
$slista = $slista. "and documentos_descripcion like '%$t_doc%' ";
}
if($n_cit!=""){
$slista = $slista. "and registrodoc1_cite like '%/$n_cit/%' ";
}
//$slista = $slista. "ORDER BY documentos_descripcion desc, registrodoc1_cite";
$slista = $slista. "ORDER BY registrodoc1_fecha_elaboracion DESC";
$rslista=mysql_query($slista,$conn);

$resaltador=0;
$indice=1;
/*
$lista_hru="";
*/
 while($rwlista=mysql_fetch_array($rslista))
 {
	 $doc_arch=cifrar($rwlista["registrodoc1_hoja_ruta"]);
	 $doc_arch2=cifrar($rwlista["registrodoc1_cite"]);
	 $doc_aso=$rwlista["registrodoc1_asociar"];
 	
		
	 $doc_rem = $rwlista["registrodoc1_de"];
     if ($resaltador==0)
	  {
//       echo "<tr class=truno>";
       echo "<tr class=nuevos>";
	   $resaltador=1;
      }
	  else
	  {
//       echo "<tr class=trdos>";
       echo "<tr class=nuevos>";
   	   $resaltador=0;
	  } 
		// obtenemos el nombre del remitente del correo
		$econs = "select usuario_nombre from usuario where usuario_ocupacion= '$doc_rem'";
		$eresp = mysql_query($econs, $conn);
		$remitente = mysql_fetch_array($eresp);		
		//******
	
?>
	<td align="center">
    	<input type="checkbox" name="<?php echo "check".$indice; ?>" value="<?php echo $rwlista["registrodoc1_id"];?>" onclick="armar(this.value);">
    
    </td>
    <td align="center"><?php 
    if($rwlista["registrodoc1_asociar"]=='si'){echo "<font color=#CC0000>Doc. Asociado $rwlista[registrodoc1_asociar_h_r]";}
    else {echo $rwlista["registrodoc1_hoja_ruta"];}?>
    </td>
    
    <td align="center"><?php echo $rwlista["registrodoc1_cite"];?>
    </td>
    
    <td align="center"><?php echo $rwlista["registrodoc1_fecha_elaboracion"];?>
    </td>

    <td align="left"><?php echo $remitente["usuario_nombre"];?></td>
    
    <td align="left"><?php echo $rwlista["usuario_nombre"];?>
    </td>
    
    
    <td align="left"><?php echo $rwlista["documentos_descripcion"];?></td>
    
    <?php
    if($rwlista['registrodoc1_estado']=='SR') 
    {$rep='No Recepcionado';?><td align="center" style="color:#990000; font-size:10px"><?php echo "$rep";?></td>
    <?php }
    else {$rep='Recepcionado';?>
    <td align="center" style="font-size:10px"><?php echo "$rep";?></td>
     <?php }?>
    </td>
    </tr>
    <?php
	$indice++;
  }
//*************************************************
$slista="SELECT registrodoc1_id, registrodoc1_hoja_ruta, registrodoc1_fecha_elaboracion, registrodoc1_de, usuarioexterno_nombre, registrodoc1_referencia, documentos_descripcion, registrodoc1_estado, registrodoc1_asociar, registrodoc1_asociar_h_r, registrodoc1_cc, registrodoc1_cite, usuarioexterno_codigo, registrodoc1_asociar, documentos_id
FROM `registrodoc1`, `documentos`, `usuarioexterno`
where registrodoc1_depto = '$depto' 
and registrodoc1_para=usuarioexterno_codigo
and registrodoc1_situacion = 'P' 
and registrodoc1_doc=documentos_sigla ";

if($h_rut!=""){
$slista = $slista. "and registrodoc1_hoja_ruta like '%$h_rut%' ";
}
if($t_doc!=""){
$slista = $slista. "and documentos_descripcion like '%$t_doc%' ";
}
if($n_cit!=""){
$slista = $slista. "and registrodoc1_cite like '%/$n_cit/%' ";
}
//$slista = $slista. "ORDER BY documentos_descripcion desc, registrodoc1_cite";
$slista = $slista. "ORDER BY registrodoc1_fecha_elaboracion DESC";
$rslista=mysql_query($slista,$conn);

$resaltador=0;
$indice=1;
/*
$lista_hru="";
*/
 while($rwlista=mysql_fetch_array($rslista))
 {
	 $doc_arch=cifrar($rwlista["registrodoc1_hoja_ruta"]);
	 $doc_arch2=cifrar($rwlista["registrodoc1_cite"]);
	 $doc_aso=$rwlista["registrodoc1_asociar"];
 	
		
	 $doc_rem = $rwlista["registrodoc1_de"];
     if ($resaltador==0)
	  {
//       echo "<tr class=truno>";
       echo "<tr class=externos>";
	   $resaltador=1;
      }
	  else
	  {
//       echo "<tr class=trdos>";
       echo "<tr class=externos>";
   	   $resaltador=0;
	  } 
		// obtenemos el nombre del remitente del correo
		$econs = "select usuario_nombre from usuario where usuario_ocupacion= '$doc_rem'";
		$eresp = mysql_query($econs, $conn);
		$remitente = mysql_fetch_array($eresp);		
		//******
	
?>
	<td align="center">
    	<input type="checkbox" name="<?php echo "check".$indice; ?>" value="<?php echo $rwlista["registrodoc1_id"];?>" onclick="armar(this.value);">
    
    </td>
    <td align="center"><?php 
    if($rwlista["registrodoc1_asociar"]=='si'){echo "<font color=#CC0000>Doc. Asociado $rwlista[registrodoc1_asociar_h_r]";}
    else {echo $rwlista["registrodoc1_hoja_ruta"];}?>
    </td>
    
    <td align="center"><?php echo $rwlista["registrodoc1_cite"];?>
    </td>
    
    <td align="center"><?php echo $rwlista["registrodoc1_fecha_elaboracion"];?>
    </td>

    <td align="left"><?php echo $remitente["usuario_nombre"];?></td>
    
    <td align="left"><?php echo $rwlista["usuario_nombre"];?>
    </td>
    
    
    <td align="left"><?php echo $rwlista["documentos_descripcion"];?></td>
    
    <?php
    if($rwlista['registrodoc1_estado']=='SR') 
    {$rep='No Recepcionado';?><td align="center" style="color:#990000; font-size:10px"><?php echo "$rep";?></td>
    <?php }
    else {$rep='Recepcionado';?>
    <td align="center" style="font-size:10px"><?php echo "$rep";?></td>
     <?php }?>
    </td>
    </tr>
    <?php
	$indice++;
}
//********************************************************* externos
//------------------------------------------------------------DERIVARDOC -_-¡

//obtenemos los empleados del departamento...
$listemp = mysql_query("select * from usuario where usuario_cod_departamento = '$depto' ",$conn);
while($respemp=mysql_fetch_array($listemp)){

			$slista="SELECT 
			derivardoc_cod, derivardoc_hoja_ruta, derivardoc_fec_recibida, derivardoc_de, usuario_nombre, derivardoc_proveido,  derivardoc_situacion, derivardoc_cc, usuario_ocupacion, derivardoc_copia_de
			FROM `derivardoc`, `usuario`
			where derivardoc_de = '$respemp[usuario_ocupacion]' 
			and derivardoc_de = usuario_ocupacion 
			and derivardoc_estado = 'P' 
			and derivardoc_situacion = 'R' ";
			
			if($h_rut!=""){
			$slista = $slista. "and derivardoc_hoja_ruta like '%$h_rut%' ";
			}
			//$slista = $slista. "ORDER BY documentos_descripcion desc, registrodoc1_cite";
			$slista = $slista. "ORDER BY derivardoc_fec_recibida DESC";
			
			$rslista=mysql_query($slista,$conn);
			
			$resaltador=0;
			$indice=1;
			
			//$resaltador=0;
			/*
			$lista_hru="";
			*/
			 while($rwlista=mysql_fetch_array($rslista))
			 {
				 $doc_arch=cifrar($rwlista["derivardoc_hoja_ruta"]);
//				 $doc_arch2=cifrar($rwlista["registrodoc1_cite"]);
	//			 $doc_aso=$rwlista["registrodoc1_asociar"];
				
					
				 $doc_rem = $rwlista["derivardoc_de"];
				 if ($resaltador==0)
				  {
//				   echo "<tr class=truno>";
				   echo "<tr class=derivados>";
				   $resaltador=1;
				  }
				  else
				  {
//				   echo "<tr class=trdos>";
				   echo "<tr class=derivados>";
				   $resaltador=0;
				  } 
					// obtenemos el nombre del remitente del correo
					$econs = "select usuario_nombre from usuario where usuario_ocupacion= '$doc_rem'";
					$eresp = mysql_query($econs, $conn);
					$remitente = mysql_fetch_array($eresp);		
					//******
				
			?>
				<td align="center">
					<input type="checkbox" name="<?php echo "check".$indice; ?>" value="<?php echo $rwlista['derivardoc_cod'];?>" onclick="armard(this.value);">
				
				</td>
				<td align="center"><?php echo $rwlista["derivardoc_hoja_ruta"];?>
				</td>
				<?php 
					//************ OBTENCION DEL CITE
					if($rwlista["derivardoc_copia_de"] == '0'){
						$rescite = mysql_query("select registrodoc1_cite, registrodoc1_doc
						from registrodoc1 where registrodoc1_hoja_ruta like '$rwlista[derivardoc_hoja_ruta]'",$conn);
					}
					else {
						$rescite = mysql_query("select registrodoc1_cite, registrodoc1_doc 
						from registrodoc1 where registrodoc1_hoja_ruta like '$rwlista[derivardoc_copia_de]'",$conn);					
					}
					$obtcite = mysql_fetch_array($rescite);
					//************
					//-------------OBTENEMOS EL TIPO DE DOCUMENTO
						$tipodocu = mysql_query("select documentos_descripcion from documentos 
						where documentos_sigla = '$obtcite[registrodoc1_doc]' ",$conn);
						$obtipdoc = mysql_fetch_array($tipodocu);
					//-------------FIN DE OBTENER EL TIPO DE DOCUMENTO
				
				?>
				<td align="center"><?php echo $obtcite["registrodoc1_cite"];?>
				</td>
				
				<td align="center"><?php echo $rwlista["derivardoc_fec_recibida"];?>
				</td>
			
				<td align="left"><?php echo $remitente["usuario_nombre"];?></td>
				
				<td align="left"><?php echo $rwlista["usuario_nombre"];?>
				</td>
				
				
				<td align="left"><?php echo $obtipdoc["documentos_descripcion"];?></td>
				
				<?php
				if($rwlista['derivardoc_situacion']=='SR') 
				{$rep='No Recepcionado';?><td align="center" style="color:#990000; font-size:10px"><?php echo "$rep";?></td>
				<?php }
				else {$rep='Recepcionado';?>
				<td align="center" style="font-size:10px"><?php echo "$rep";?></td>
				 <?php }?>
				</td>
				</tr>
				<?php
				$indice++;
			}
}
//------------------------------------------------FIN DERIVARDOC
?>
</form>
</table>
</center>
</meta>
<center>

<br>
<form name="formdibuja" action="dibujalibro3.php" method="GET">

    &nbsp; &nbsp;  
    <!-- <input type="submit"  value="Ver Seleccion" class="boton" >
    -->
</form>
<form name="formimprime" action="imprimirlibro2.php" method="GET" target="_blank">
	<input type="hidden" value="" id="icanid" name="icanid">
	<input type="hidden" value="" id="iarrid" name="iarrid">
	<input type="hidden" value="" id="dcanid" name="dcanid">
	<input type="hidden" value="" id="darrid" name="darrid">
    &nbsp; &nbsp;  
    <input type="submit"  value="Imprimir" class="boton" >
</form>
</center>

<?php
include("final.php");
?>

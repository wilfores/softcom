<?php 
include("../filtro.php");

$hora =  date("Y-m-d H-i-s", time());
$f = fopen("logs/zz_derivado_$hora .php", "w+");
?>
<?php 
include("inicio.php");

include("../conecta.php");
include("script/functions.inc");
include("script/cifrar.php");
include("../funcion.inc");

$cod_institucion = $_SESSION["institucion"];
$cargo_unico=$_SESSION["cargo_asignado"];
$codigo=$_SESSION["cargo_asignado"];


?>
<link rel="stylesheet" type="text/css" href="script/ventanita.css">
<script type="text/javascript" src="jquery/jquery.js"></script>
<script language="javascript">
	var numsel = 1;	
	$(document).ready(function(){
			$("#incluirotro").hide();
			$("#crearcopia").click(function(){
				incluirselect();
				$("#incluirotro").show();
			});
			$("#incluirotro").click(function(){
				incluirselect();
			});
	
	
	});
	function incluirselect(){
				llenarselect("sel"+numsel);
				$("#totalcopias").attr('value',numsel);
				numsel++;
	}
	function llenarselect(idsel){
			$.ajax({
				type: "GET",
				dataType: "json",
				url: "listadocargos.php?action=listar&hru=<?php  echo $cargo_unico; ?>",
				success: function(data){
					var html = '';
						if(data.length > 0){
							//html += '<option value='+idsel+'>'+idsel+'</option>';
							$.each(data, function(i,item){
								html += '<option value='+item.value+'>'+item.cargo+'</option>';
							});
						}
						if(html == '') html = '<option value=nada>no hay nada q mostrar</option>';
							//$("#copias").append("<select name="+idsel+" id="+idsel+">"+html+"</select><br>");	
							$("#copias").append("<select name="+idsel+">"+html+"</select><br>");	
							
						}	
			});
	}
</script>



<?php 

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
$hruta=descifrar($_GET['hr1']);
$llaveregistro=0;	//llaveregistro identifica si se trata de un registro nuevo o de un registro de derivardoc
					//0 significa nuevo, 1 significa q viene de derivardoc
//**ooooooooooooo identificacion de la hoja de ruta si pertenece a derivardoc o a registro doc1, en caso de estar en la tabla derivardoc se contara con lel dato derivardoc_codia_de, en caso de no encontrarse, simplemente se le asigna a rhrutacopia igual a 0 pues solo se encuentra en registrodoc1 y no se tendra el dato por lo que jamas se habilitaria la derivacion multiple

$buscareg = mysql_query("select derivardoc_n_derivacion from `derivardoc`
    where derivardoc_hoja_ruta = '$hruta'", $conn);
/*#############################*/
$error = mysql_error($conn);
$qsqs = "select derivardoc_n_derivacion from `derivardoc` where derivardoc_hoja_ruta = '$hruta'";
$qsqs=str_replace("\n"," ",$qsqs); fwrite($f," \r\n$hora \t $error \t $qsqs \r\n");
/*#############################*/
$rbuscareg =mysql_fetch_array($buscareg);

if(strlen($rbuscareg['derivardoc_n_derivacion']) > 3){
//	echo "<script> alert('copiaaa')";

	$rdatoscopia = mysql_query("select derivardoc_copia_de from derivardoc where derivardoc_hoja_ruta like '$hruta'", $conn);
	$qsqs = "select derivardoc_copia_de from derivardoc where derivardoc_hoja_ruta like '$hruta'"; 
	/*#############################*/
	$error = mysql_error($conn);
	$qsqs=str_replace("\n"," ",$qsqs); fwrite($f," \r\n$hora \t $error \t $qsqs \r\n");
	/*#############################*/
	$filadatos = mysql_fetch_array($rdatoscopia);
	$rhrutacopia = $filadatos["derivardoc_copia_de"];
	$llaveregistro = 1;
}
else{
//	echo "<script> alert('normal')";
	$rhrutacopia = 0 ;
}
//echo "$hruta <br />holaaaaaa<br>";
//echo "$rhrutacopia <br />";

$ssqlao = "SELECT * FROM cargos WHERE '$cargo_unico'=cargos_id";
$rsao = mysql_query($ssqlao,$conn);
/*#############################*/
$qsqs = "SELECT * FROM cargos WHERE '$cargo_unico'=cargos_id";
$error = mysql_error($conn);
$qsqs=str_replace("\n"," ",$qsqs); fwrite($f," \r\n$hora \t $error \t $qsqs \r\n");
/*#############################*/
if ($rowao = mysql_fetch_array($rsao)) 
{
$departamentillo=$rowao["cargos_id"];
//echo "$departamentillo <br />";
}
mysql_free_result($rsao);
/*
$sel_derivar=descifrar($_GET['datos']);
if(!is_numeric($sel_derivar))
{
    echo "<center><b>!!!! INTENTO DE MANIPULACION DE DATOS !!!!</b></center>";
    exit;
}*/

		/**************************************************************************
							DESDE AQUI ENTRA PARA GRABAR
		***************************************************************************/
$error=0;

if (isset($_POST['grabar']))
{
	$hruta=$_POST['h_ruta'];
	$fec_deri=$_POST['f_deriv'];
	$dest=$_POST['destinatario'];
	$prior=$_POST['prioridad_total'];
	$fec_plazo=$_POST['fecha_plazo'];
	$inst=$_POST['codigo_inst'];
	$prov=$_POST['observaciones'];
	
	$totalsel= $_POST['totalcopias'];
	$arrcarg = $_POST['arraycargos'];
	//if($_POST['sel1'])
	/*	echo "<script>alert('llego el sel1');</script>";
	echo "<script>alert('el total de selects es '+$totalsel);</script>";*/
	/*for($j=1;$j<=(int)$totalsel;$j++){
		$destinatario = $_POST["sel".$j];
		echo "<script>alert($destinatario);</script>";
	}
	*/
	$cod_dep=$_POST['cod_departamento'];
	
	$n_adj=$_POST["nro_adj"];	/*numero de adjuntos q tiene el doc*/
	$descr_adj=$_POST["descripcion"];	/*descripcion de adjunto*/
	$nom_arch_ad=$_FILES["nom_arch_adj"];	/*nombre de archivo adjunto*/
	if($res_p=='on') $res='SI';
	else $res='NO';
	
		$s_hr="select * from registrodoc1 where registrodoc1_hoja_ruta='$hruta'";
		$r_hr = mysql_query($s_hr, $conn);
		/*#############################*/
		$qsqs = $s_hr;
		$error = mysql_error($conn);
		$qsqs=str_replace("\n"," ",$qsqs); fwrite($f," \r\n$hora \t $error \t $qsqs \r\n");
		/*#############################*/
		$row_dep=mysql_fetch_array($r_hr);
		$cite=$row_dep['registrodoc1_cite'];
	
	if($descr_adj=='') $descr_adj='NULL';

	 if(empty($_POST['destinatario'])){ 
	  $error=TRUE;
      $alert_coddepto=1; 	
	 }
	
	if(empty($_POST['observaciones']))
	{ 
	 $error=TRUE;
     $alert_obs=1; 	
	}
	
	if(empty($_POST['fecha_plazo']))
	{
		 $error=TRUE;
		 $alert_fechaplazo=1; 
	}
	else
	{
		$guardar_fecha=$_POST['fecha_plazo'];
		if(date("Y-m-d")>$guardar_fecha)
		{ 
		 $error=TRUE;
		 $alert_fechaplazo=1; 	
		}
	}
	
	if (!ctype_digit($_POST['nro_adj'])) 
	{
	$error= TRUE;
	$alert_anexos=1;
	}
	
	/*
	if(empty($_POST['codigo_inst']))
   {
            $error=TRUE;
            $codigo_instruccion=1;
   }	
	*/
    if (!$error)
    {
		  
		  $conn = Conectarse();
		  /*
			echo "$error<br />";
			echo "$codigo<br />";
			echo "$hruta<br />";
			echo "$fec_deri<br />";
			echo "$dest<br />";
			echo "$prior<br />";
			echo "$fec_plazo<br />";
			echo "$inst<br />";
			echo "$prov<br />";
		*/	
		
		
		if($_FILES["nom_arch_adj"]["name"]=='')
		{$foto_nombre='NULL';
		}
		else 
		{
			$fecha=date("Y-m-d H:i:s");
			
			$qd1 = "select max(arch_adj_id)from arch_adj";
			$resdoc1 = mysql_query($qd1,$conn);
			/*#############################*/
			$qsqs =  $qd1;
			$error = mysql_error($conn);
			$qsqs=str_replace("\n"," ",$qsqs); fwrite($f," \r\n$hora \t $error \t $qsqs \r\n");
			/*#############################*/
			$rdoc1 = mysql_fetch_array($resdoc1);			
			$id_docadj=$rdoc1[0]+1;/*obtiene el maximmo del id del documento 2*/
		
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
	
			$insert=" INSERT INTO `arch_adj` (`arch_adj_id`, `arch_adj_h_r`, `arch_adj_nombre`, `arch_adj_usuario`, `arch_adj_fecha`) VALUES 
			($id_docadj, '$cite', '$foto_nombre', $codigo, '$fecha')";		
	  
			$resul = mysql_query($insert,$conn);
			/*#############################*/
			$qsqs = $insert;
			$error = mysql_error($conn);
			$qsqs=str_replace("\n"," ",$qsqs); fwrite($f," \r\n$hora \t $error \t $qsqs \r\n");
			/*#############################*/
		}
		
		$qt = "select max(derivardoc_cod)from derivardoc";
		$resta = mysql_query($qt,$conn);
		/*#############################*/
		$qsqs = $qt;
		$error = mysql_error($conn);
		$qsqs=str_replace("\n"," ",$qsqs); fwrite($f," \r\n$hora \t $error \t $qsqs \r\n");
		/*#############################*/
		$rtab = mysql_fetch_array($resta);			
		$id_ta=$rtab[0]+1;/*obtiene el maximmo del id de la tabla*/
		
		$qd = "select max(derivardoc_n_derivacion)from derivardoc where derivardoc_hoja_ruta='$hruta'";
		$resdoc = mysql_query($qd,$conn);
		/*#############################*/
		$qsqs = $qd;
		$error = mysql_error($conn);
		$qsqs=str_replace("\n"," ",$qsqs); fwrite($f," \r\n$hora \t $error \t $qsqs \r\n");
		/*#############################*/
		$rdoc = mysql_fetch_array($resdoc);			
		$id_doc=$rdoc[0]+1;/*obtiene el maximmo del id del documento 2*/
	/*	if($_POST["tienecopias"]){
			$id_doc=1001;
		}*/
		$ges=date("Y");
		if ($totalsel == 0){
			$respval = mysql_query("select derivardoc_copia_de as original from derivardoc where derivardoc_hoja_ruta = '$hruta'");
			/*#############################*/
			$qsqs = "select derivardoc_copia_de as original from derivardoc where derivardoc_hoja_ruta = '$hruta'"; 
			$error = mysql_error($conn);
			$qsqs=str_replace("\n"," ",$qsqs); fwrite($f," \r\n$hora \t $error \t $qsqs \r\n");
			/*#############################*/
			$filaval = mysql_fetch_array($respval);
			if ($llaveregistro == 0){
				$insertar=" INSERT INTO `derivardoc` (`derivardoc_cod`, `derivardoc_hoja_ruta`, `derivardoc_n_derivacion`, `derivardoc_de`, `derivardoc_para`, `derivardoc_fec_derivacion`, `derivardoc_fec_recibida`, `derivardoc_fec_plazo`, `derivardoc_fec_salida`, `derivardoc_prioridad`, `derivardoc_codigo_instruccion`, `derivardoc_situacion`, `derivardoc_estado`,`derivardoc_realizado`, `derivardoc_proveido`, `derivardoc_cc`, `derivardoc_gestion`, `derivardoc_n_adj`, `derivardoc_descrip_adj`, `derivardoc_nom_arch_adj`, `derivardoc_copia_de`) VALUES 
			  ($id_ta,'$hruta',$id_doc,$codigo,$dest,'$fec_deri','0000-00-00 00:00:00','$fec_plazo','0000-00-00 00:00:00','$prior',17,'SR','P','NH','$prov','NO',$ges,$n_adj,'$descr_adj','$foto_nombre','$filaval[original]')";
			}
			else{
				echo "<script> alert('es copia'); </script>";
				$insertar=" INSERT INTO `derivardoc` (`derivardoc_cod`, `derivardoc_hoja_ruta`, `derivardoc_n_derivacion`, `derivardoc_de`, `derivardoc_para`, `derivardoc_fec_derivacion`, `derivardoc_fec_recibida`, `derivardoc_fec_plazo`, `derivardoc_fec_salida`, `derivardoc_prioridad`, `derivardoc_codigo_instruccion`, `derivardoc_situacion`, `derivardoc_estado`,`derivardoc_realizado`, `derivardoc_proveido`, `derivardoc_cc`, `derivardoc_gestion`, `derivardoc_n_adj`, `derivardoc_descrip_adj`, `derivardoc_nom_arch_adj`, `derivardoc_copia_de`) VALUES 
			  ($id_ta,'$hruta',$id_doc,$codigo,$dest,'$fec_deri','0000-00-00 00:00:00','$fec_plazo','0000-00-00 00:00:00','$prior',17,'SR','P','NH','$prov','NO',$ges,$n_adj,'$descr_adj','$foto_nombre','0')";		
			}		 
			$resul = mysql_query($insertar, $conn);
			/*#############################*/
			$qsqs = $insertar;
			$error = mysql_error($conn);
			$qsqs=str_replace("\n"," ",$qsqs); fwrite($f," \r\n$hora \t $error \t $qsqs \r\n");
			/*#############################*/
		}				
		else{
				for($j=0;$j<=$totalsel;$j++){
					if ( $j == 0){
						$destinatario = $dest;
					}
					else {
						$destinatario = $_POST["sel".$j];
					}
					$ncopia="-C".$j;
					//$destinatario = $_POST["sel".$j];
					/*echo "<script>alert($destinatario);</script>";*/
					$qt = "select max(derivardoc_cod)from derivardoc";
					$resta = mysql_query($qt,$conn);
					/*#############################*/
					$qsqs = $qt;
					$error = mysql_error($conn);
					$qsqs=str_replace("\n"," ",$qsqs); fwrite($f," \r\n$hora \t $error \t $qsqs \r\n");
					/*#############################*/
					$rtab = mysql_fetch_array($resta);			
					$id_ta=$rtab[0]+1;/*obtiene el maximmo del id de la tabla*/
					
					$qd = "select max(derivardoc_n_derivacion)from derivardoc where derivardoc_hoja_ruta='$hruta'";
					$resdoc = mysql_query($qd,$conn);
					/*#############################*/
					$qsqs = $qd;
					$error = mysql_error($conn);
					$qsqs=str_replace("\n"," ",$qsqs); fwrite($f," \r\n$hora \t $error \t $qsqs \r\n");
					/*#############################*/
					$rdoc = mysql_fetch_array($resdoc);			
		//			$id_doc=$rdoc[0]*1000+1;/*obtiene el maximmo del id del documento 2*/
					$id_doc=(($j+1)*1000)+1;		
					$ges=date("Y");
					$insertacopia = "INSERT INTO `derivardoc` (`derivardoc_cod`, `derivardoc_hoja_ruta`, `derivardoc_n_derivacion`, `derivardoc_de`, `derivardoc_para`, `derivardoc_fec_derivacion`, `derivardoc_fec_recibida`, `derivardoc_fec_plazo`, `derivardoc_fec_salida`, `derivardoc_prioridad`, `derivardoc_codigo_instruccion`, `derivardoc_situacion`, `derivardoc_estado`,`derivardoc_realizado`, `derivardoc_proveido`, `derivardoc_cc`, `derivardoc_gestion`, `derivardoc_n_adj`, `derivardoc_descrip_adj`, `derivardoc_nom_arch_adj`, `derivardoc_copia_de`) VALUES 
		  ($id_ta,'$hruta$ncopia',$id_doc,$codigo,$destinatario,'$fec_deri','0000-00-00 00:00:00','$fec_plazo','0000-00-00 00:00:00','$prior',17,'SR','P','NH','$prov','NO',$ges,$n_adj,'$descr_adj','$foto_nombre','$hruta')";
					$resultado = mysql_query($insertacopia,$conn);
					/*#############################*/
					$qsqs = $insertacopia;
					$error = mysql_error($conn);
					$qsqs=str_replace("\n"," ",$qsqs); fwrite($f," \r\n$hora \t $error \t $qsqs \r\n");
					/*#############################*/
				}
	
		}
		$con= "UPDATE registrodoc1
					SET
				registrodoc1_situacion='D'
					WHERE
				registrodoc1_hoja_ruta='$hruta'
				AND registrodoc1_situacion='P'";
				/*registrodoc_respuesta='$res', SE CAMBIO POR (SI) */
		$res = mysql_query($con,$conn); 
		/*#############################*/
		$qsqs = $con;
		$error = mysql_error($conn)." rowsAffeted=".mysql_affected_rows();
		$qsqs=str_replace("\n"," ",$qsqs); fwrite($f," \r\n$hora \t $error \t $qsqs \r\n");
		/*#############################*/
		
		$con1= "UPDATE derivardoc
					SET
				derivardoc_estado='D'
					WHERE
				derivardoc_hoja_ruta='$hruta'
				and derivardoc_situacion='R'
				AND derivardoc_estado='P'
				and derivardoc_realizado='H'";
		
				/*registrodoc_respuesta='$res', SE CAMBIO POR (SI) */
		$res1 = mysql_query($con1,$conn); 
		/*#############################*/
		$qsqs = $con1;
		$error = mysql_error($conn)." rowsAffeted=".mysql_affected_rows();;
		$qsqs=str_replace("\n"," ",$qsqs); fwrite($f," \r\n$hora \t $error \t $qsqs \r\n");
		/*#############################*/
		//ahora insertamos los registros en derivardoc en caso de que se hayan incorporados selects
		/*echo "<script>alert($totalsel);</script>";*/
		
	?>
	  <script language="JavaScript">
		window.self.location="menu2.php";
	  </script>
	<?php 	
  }//fin if error
} //fin if isset grabar

if (isset($_POST['cancelar']))
	{
	?>
		  <script language="JavaScript">
			window.self.location="menu2.php";
		  </script>
	<?php 
	}
?>
<script>

function Combo()
{
  document.derivar.action="derivar.php";
  document.derivar.submit();
}

function Retornar()
{
  document.enviar.action="recepcion_lista.php";
  document.enviar.submit();
}

</script>
<br>
<?php 
if ($error == 0)
{
echo "<p><div class=\"fuente_titulo\" align=\"center\"><b>DERIVACION DE CORRESPONDENCIA</b></div></p>";
} 
else 
{ 
echo "<center><table width=25%><tr><td class=fuente_normal_rojo  align=left><center><b> !!! ERROR DATOS NO VALIDOS !!!</b></center>".$valor_error."</td></tr></table></center>";
}
?>
<center>

<form  method="POST" name="enviar" enctype="multipart/form-data" id="miform">
<table width="700" cellspacing="2" cellpadding="2"  border="0">
<tr class="border_tr3">
<td><span class="fuente_normal">Hoja de Ruta</td>

<td>

<?php 
$ssql3="SELECT * FROM seguimiento WHERE '$sel_derivar'= seguimiento_codigo_seguimiento";
$rss3=mysql_query($ssql3,$conn);
/*#############################*/
$qsqs = $ssql3;
$error = mysql_error($conn);
$qsqs=str_replace("\n"," ",$qsqs); fwrite($f," \r\n$hora \t $error \t $qsqs \r\n");
/*#############################*/
$row3=mysql_fetch_array($rss3);
echo $hruta;
?>

<input type=hidden name="h_ruta" value="<?php  echo $hruta;?>">
</td>
</tr>
<tr class="border_tr3">
<td><span class="fuente_normal">Fecha y Hora de Derivacion</td> 
<td>
<?php  echo date("Y-m-d H:i:s");
$f_derivacion=date("Y-m-d H:i:s");
?>
<input type=hidden name="f_deriv" value="<?php  echo $f_derivacion;?>">
</td>
</tr>
<tr class="border_tr3">
<td>
<span class="fuente_normal">Funcionario/Destino</td>
<td>
<select name="destinatario" onchange="this.form.submit()" id="selprincipal">
  <option value=""> Seleccione un Funcionario</option>
  <?php 
$ssql55_1 = "SELECT * FROM usuario where usuario_ocupacion='$cargo_unico' and usuario_active='1'";
$rss55_1 = mysql_query($ssql55_1,$conn);
/*#############################*/
$qsqs = $ssql55_1;
$error = mysql_error($conn);
$qsqs=str_replace("\n"," ",$qsqs); fwrite($f," \r\n$hora \t $error \t $qsqs \r\n");
/*#############################*/ 
if (mysql_num_rows($rss55_1) > 0)
{  
  
$ssql55 = "SELECT * FROM miderivacion,usuario,cargos where miderivacion_mi_codigo='$cargo_unico' and miderivacion_estado='1' and usuario_ocupacion = cargos_id and miderivacion_su_codigo = cargos_id order by usuario_nombre limit 0, 1000";
$rss55 = mysql_query($ssql55,$conn);
/*#############################*/
$qsqs = $ssql55;
$error = mysql_error($conn);
$qsqs=str_replace("\n"," ",$qsqs); fwrite($f," \r\n$hora \t $error \t $qsqs \r\n");
/*#############################*/
while($row55=mysql_fetch_array($rss55))
{
	if ($_POST['destinatario']==$row55["miderivacion_su_codigo"])
	  { 
		    echo "<option value=".$row55["miderivacion_su_codigo"]." selected>";
			$valor_clave=$row55["miderivacion_su_codigo"];
			$conexion = mysql_query("SELECT * FROM cargos WHERE '$valor_clave'=cargos_id",$conn);
			/*#############################*/
			$qsqs = "SELECT * FROM cargos WHERE '$valor_clave'=cargos_id";
			$error = mysql_error($conn);
			$qsqs=str_replace("\n"," ",$qsqs); fwrite($f," \r\n$hora \t $error \t $qsqs \r\n");
			/*#############################*/
			if($fila_clave=mysql_fetch_array($conexion))
			{
				$valor_cargo=$fila_clave["cargos_id"];
				$conexion2 = mysql_query("SELECT * FROM usuario WHERE '$valor_cargo'=usuario_ocupacion",$conn);
				/*#############################*/
				$qsqs = "SELECT * FROM usuario WHERE '$valor_cargo'=usuario_ocupacion";
				$error = mysql_error($conn);
				$qsqs=str_replace("\n"," ",$qsqs); fwrite($f," \r\n$hora \t $error \t $qsqs \r\n");
				/*#############################*/
				if($fila_cargo=mysql_fetch_array($conexion2))
				{
				echo $fila_cargo["usuario_nombre"];
				}
			}
			
		echo "</option>";
      }
    else
      {
	        echo "<option value=".$row55["miderivacion_su_codigo"].">";
			$valor_clave=$row55["miderivacion_su_codigo"];
			$conexion = mysql_query("SELECT * FROM cargos WHERE '$valor_clave'=cargos_id",$conn);
			/*#############################*/
			$qsqs = "SELECT * FROM cargos WHERE '$valor_clave'=cargos_id";
			$error = mysql_error($conn);
			$qsqs=str_replace("\n"," ",$qsqs); fwrite($f," \r\n$hora \t $error \t $qsqs \r\n");
			/*#############################*/
			if($fila_clave=mysql_fetch_array($conexion))
			{
				$valor_cargo=$fila_clave["cargos_id"];
				$conexion2 = mysql_query("SELECT * FROM usuario WHERE '$valor_cargo'=usuario_ocupacion",$conn);
				/*#############################*/
				$qsqs = "SELECT * FROM usuario WHERE '$valor_cargo'=usuario_ocupacion";
				$error = mysql_error($conn);
				$qsqs=str_replace("\n"," ",$qsqs); fwrite($f," \r\n$hora \t $error \t $qsqs \r\n");
				/*#############################*/
				if($fila_cargo=mysql_fetch_array($conexion2))
				{
				echo $fila_cargo["usuario_nombre"];
				}

			}		  
		echo "</option>";
	   }
}
}//if
mysql_free_result($rss55);
?>
</select>
<?php  
	$vhru = str_split($hruta);
	$tothru=count($vhru);
	$codcopia = $vhru[count($vhru)-2];
/*	echo "<script> alert('".$codcopia."')</script>";*/
	if($rhrutacopia =='0'){
?>
<input type=radio id="crearcopia" name="tienecopias"> Con copia a:
<?php 
 }
?>

</input>
<input type=button id="incluirotro" value="incluir otro"> 
</input>
<input type=hidden id="totalcopias" name="totalcopias" value=0> 
</input>
<input type=hidden id="arraycargos" name="arraycargos" value=""> 
</input>
<div id="copias"></div>
 <?php  Alert($alert_coddepto);?>
</td>
</tr>

<?php 
	if(!empty($_POST['destinatario']))
	{
	$valor_clave=$_POST['destinatario'];
	}
	else
	{
	$valor_clave=0;
	}
	$conexion = mysql_query("SELECT * FROM cargos WHERE '$valor_clave'=cargos_id",$conn);
	/*#############################*/
	$qsqs = "SELECT * FROM cargos WHERE '$valor_clave'=cargos_id";
	$error = mysql_error($conn);
	$qsqs=str_replace("\n"," ",$qsqs); fwrite($f," \r\n$hora \t $error \t $qsqs \r\n");
	/*#############################*/
	if($fila_clave=mysql_fetch_array($conexion))
	{
	?>
	<tr class="border_tr3">
	<td>
	<span class="fuente_normal">Cargo Destinatario</td>
	<td>
	<?php 
		$valor_clave=$fila_clave["cargos_id"];
		$conexion = mysql_query("SELECT * FROM cargos WHERE '$valor_clave'=cargos_id",$conn);
		/*#############################*/
		$qsqs = "SELECT * FROM cargos WHERE '$valor_clave'=cargos_id";
		$error = mysql_error($conn);
		$qsqs=str_replace("\n"," ",$qsqs); fwrite($f," \r\n$hora \t $error \t $qsqs \r\n");
		/*#############################*/
		if($fila_clave=mysql_fetch_array($conexion))
		{
		echo $fila_clave["cargos_cargo"];
		$salvado_destino=$fila_clave["cargos_cod_depto"];
		}	
	?></td>
	</tr>
	<tr class="border_tr3">
	<td>
	<span class="fuente_normal">Departamento/Destino</td>
	<td>
	<?php 
	$valor_clave=$salvado_destino;
	$conexion = mysql_query("SELECT * FROM departamento WHERE '$valor_clave'=departamento_cod_departamento",$conn);
	/*#############################*/
	$qsqs = "SELECT * FROM departamento WHERE '$valor_clave'=departamento_cod_departamento";
	$error = mysql_error($conn);
	$qsqs=str_replace("\n"," ",$qsqs); fwrite($f," \r\n$hora \t $error \t $qsqs \r\n");
	/*#############################*/
		if($fila_clave=mysql_fetch_array($conexion))
		{
		echo $fila_clave["departamento_descripcion_dep"];
		?>
		<input type=hidden name="cod_departamento" value="<?php  echo $fila_clave["departamento_cod_departamento"];?>">
		<?php 
		}
	?></td>
	</tr>
<?php 
}
?>

<tr class="border_tr3">
<td>
<span class="fuente_normal">Prioridad</td>
<td>
<select name="prioridad_total">
<?php 
if (!empty($_POST['prioridad_total']))
{
	if ($_POST['prioridad_total']=='Urgente')
	{ 
   	  echo "<option value='M' >Normal</option>";
	  echo "<option value='A' >Urgente</option>";
	}
	else
	{
	   if ($_POST['prioridad_total']=='Normal')
		{
		 echo "<option value='M' >Normal</option>";
		 echo "<option value='A' >Urgente</option>";
		}
		else
		{
 		 echo "<option value='M' >Normal</option>";
		 echo "<option value='A' >Urgente</option>";
		}
	}
	
	}
else
{
echo "<option value='M' >Normal</option>";
echo "<option value='A' >Urgente</option>";
}
?>
</select>
</td>
</tr>
<tr class="border_tr3"><td><span class="fuente_normal">Fecha Plazo</td>
<td>
<?php 
echo "<input type=\"text\" name=\"fecha_plazo\" class=\"caja_texto\" id=\"dateArrival\" onClick=\"popUpCalendar(this, enviar.dateArrival, 'yyyy-mm-dd');\" size=\"10\" value=".$_POST['fecha_plazo'].">";
echo " <img src=\"images/cal_ico.png\" width=\"25\" height=\"25\" onClick=\"popUpCalendar(this, enviar.dateArrival, 'yyyy-mm-dd');\" alt=\"Calendario\" />";
 Alert($alert_fechaplazo);
?></td>
</tr>
<!--
<tr class="border_tr3"><td><span class="fuente_normal">Instruccion</td>
<td>
<select name="codigo_inst" class="caja_texto">
<option value="">Seleccione una Instruccion</option>
<?php 
$ssql4 = "SELECT * FROM instruccion order by instruccion_instruccion";
$rss4 = mysql_query($ssql4,$conn);
/*#############################*/
$qsqs = "SELECT * FROM instruccion order by instruccion_instruccion";
$error = mysql_error($conn);
$qsqs=str_replace("\n"," ",$qsqs); fwrite($f," \r\n$hora \t $error \t $qsqs \r\n");
/*#############################*/
while($row4=mysql_fetch_array($rss4))
{
  if($_POST['codigo_inst']==$row4["instruccion_codigo_instruccion"])
  {
  echo "<option value=".$row4['instruccion_codigo_instruccion']." selected>";
  echo $row4["instruccion_instruccion"];
  echo "</option>";
  }
  else
  {
  echo "<option value=".$row4['instruccion_codigo_instruccion'].">";
  echo $row4["instruccion_instruccion"];
  echo "</option>";
  }
}
mysql_free_result($rss4);
?>
</select>
 <?php  Alert($codigo_instruccion);?>
</td>
</tr>-->

<tr class="border_tr3"><td><span class="fuente_normal">Proveido</td>
<td>
<textarea name="observaciones" class="caja_texto" cols="60" rows="2">
<?php 
 if (isset($error))
 {
   echo $_POST['observaciones'];    
 }
?>
</textarea>
 <?php  Alert($alert_obs);?>
</td>
</tr>

<tr class="border_tr3">
	  <td><span class="fuente_normal">No de Adjuntos:</td>
	  <td><?php 
			echo "<input type=\"text\" name=\"nro_adj\" maxlength=4 size=4 class=\"caja_texto\" value=\"0\">";
			Alert($alert_anexos);
		?>      </td>
	  </tr>
	<!--/*<!--<tr class="border_tr3"><td><span class="fuente_normal">Cantidad Anexos</td>
	<td>
		<?php 
			echo "<input type=\"text\" name=\"nro_anexos\" maxlength=4 size=4 class=\"caja_texto\" value=\"0\">";
			Alert($alert_anexos);
		?>	
    </td>
	</tr>-->
	
    <tr class="border_tr3"><td><span class="fuente_normal">Descripcion de Adjunto:</td>
	<td>
       <?php 
			//echo "<input type=\"areatext\" name=\"tipo_anexos\" maxlength=100 size=70 class=\"caja_texto\" value=".$_POST['tipo_anexos'].">";
			echo "<textarea name=\"descripcion\" rows=\"4\" cols=\"50\"></textarea>";
  	    ?>    
	</td>
	</tr>
	<tr class="border_tr3"><td><span class="fuente_normal">Subir Archivo Adjunto:</td>
	<td><input style="font-size:9px; color:blue" name="nom_arch_adj" type="file"></td>
	</tr>

<tr>
<td align="center" colspan="2">
<input type="submit" name="grabar" value="Aceptar" class="boton" />
<input type="submit" name="cancelar" value="Cancelar" class="boton">
</td>
</tr>
</form>
</table>
</center>
<br>
<?php 
include("final.php");
fclose($f);
?>
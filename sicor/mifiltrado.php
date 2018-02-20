<?php
// include("JSON.php");
 include("script/functions.inc");
 require_once("JSON.php");
 include("../conecta.php");
include("../filtro.php"); 
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
 
 $json = new Services_JSON;
 $datos = array();
if($_GET['action'] == 'listar')
{
    // valores recibidos por POST o GET
	
	//$hru almacena el codigo del usuario (cargo_codigo)
    $hru   = $_GET['hru'];
	$cad   = $_GET['cadena'];
	
	//--> incio de acoplamiento de pendientes en caso ventanilla y secretaria
	if (($_SESSION["cargo"] == "Ventanilla") or  ($_SESSION["cargo"]=="Secretaria")){
		$s_dep_s="select cargos_dependencia from cargos where cargos_id='$hru'";
		$r_dep_s = mysql_query($s_dep_s, $conn);
		$row_dep=mysql_fetch_array($r_dep_s);
		$cod_dep=$row_dep[0];
		//ORDER BY registrodoc1_fecha_recepcion DESC
		//$sql_ent = "SELECT * FROM registrodoc1 WHERE '$cod_dep'=registrodoc1_para and 
		$sql_ent = "SELECT registrodoc1_de,  registrodoc1_hoja_ruta, registrodoc1_fecha_elaboracion,
					registrodoc1_referencia, registrodoc1_prioridad, (registrodoc1_fecha_elaboracion - NOW())/100000 as orden
					FROM registrodoc1 WHERE '$cod_dep'=registrodoc1_para and 
					registrodoc1_estado='SR' and registrodoc1_situacion='P' and 
					registrodoc1_cc='E' and registrodoc1_asociar<>'si' and	registrodoc1_hoja_ruta !='0' ";
					
		if($cad != ''){
			$sql_ent = $sql_ent." and registrodoc1_hoja_ruta like '%$cad%'";
		}
		
		$rs_ent = mysql_query($sql_ent, $conn);
		while ($row_ent = mysql_fetch_array($rs_ent)) 
		{  
			$rimg="images/media.gif";
			//aca deberia estar un CIFRADO
			$sql_usu="SELECT * FROM usuario WHERE usuario_ocupacion='$row_ent[registrodoc1_de]'";
			$rs_usu= mysql_query($sql_usu, $conn);
			$nom_usu=mysql_fetch_array($rs_usu);
			$doc_arch=cifrar($row_ent['registrodoc1_hoja_ruta']);
			if($row_derv['registrodoc1_prioridad']=='A')
				$rimg="images/alta.gif";
			
			$datos[] = array(
	            'orden'    => $row_ent['orden'],
    	        'prioridad'  => $rimg,
	            'hoja'    => $row_ent['registrodoc1_hoja_ruta'],
	            'fecha'   => $row_ent['registrodoc1_fecha_elaboracion'],
	            'refe' 	  => $row_ent['registrodoc1_referencia'],
				'remi'	  => $nom_usu['2'],
				'tipo'	  => "reg",
				'cifra'    => $doc_arch
			);

		}
		
		//$sql_derv = "SELECT * FROM derivardoc 
		$sql_derv = "SELECT derivardoc_hoja_ruta,  derivardoc_de, derivardoc_prioridad, derivardoc_fec_derivacion,
					 derivardoc_proveido, (derivardoc_fec_derivacion - NOW())/100000 as orden
					 FROM derivardoc 
					 WHERE '$cod_dep'=derivardoc_para and derivardoc_situacion='SR' and	derivardoc_hoja_ruta !='0' ";
		
			if($cad != ''){
				$sql_derv = $sql_derv." and derivardoc_hoja_ruta like '%$cad%'";
			}
		
		$rs_derv = mysql_query($sql_derv, $conn);
		while ($row_derv = mysql_fetch_array($rs_derv)) 
		{ 
			$rimg="images/media.gif";
			$doc_arch=cifrar($row_derv['derivardoc_hoja_ruta']);
					
			$sql_usu="SELECT * FROM usuario WHERE usuario_ocupacion='$row_derv[derivardoc_de]'";
			$rs_usu= mysql_query($sql_usu, $conn);
			$nom_usu=mysql_fetch_array($rs_usu);
			$doc_arch=cifrar($row_derv['derivardoc_hoja_ruta']);
			
			if($row_derv['derivardoc_prioridad']=='A')
				$rimg="images/alta.gif";
						
			$datos[] = array(
	            'orden'    => $row_derv['orden'],
    	        'prioridad'  => $rimg,
	            'hoja'    => $row_derv['derivardoc_hoja_ruta'],
	            'fecha'   => $row_derv['derivardoc_fec_derivacion'],
	            'refe'    => $row_derv['derivardoc_proveido'],
				'remi'	  => $nom_usu['2'],
				'tipo'	  => "der",				
				'cifra'    => $doc_arch
	     	);
				
		}		
	
	}
	//--> fin del acoplamiento de pendientes en caso ventanilla y secretaria
	//***********ahora para los jefes q veran las bandejas de entrada de sus secres
	if ($_SESSION["cargo"]=="Jefe") {
		$s_sec_s="select cargos_cargo, cargos_id from cargos 
					where cargos_dependencia = '$hru' and
					cargos_cargo like '%secretaria%'";
		$r_sec_s = mysql_query($s_sec_s, $conn);
		$row_sec=mysql_fetch_array($r_sec_s);
		$cod_sec=$row_sec["cargos_id"];
		//ORDER BY registrodoc1_fecha_recepcion DESC
		//$sql_ent = "SELECT * FROM registrodoc1 WHERE '$cod_dep'=registrodoc1_para and 
		$sql_ent = "SELECT registrodoc1_de,  registrodoc1_hoja_ruta, registrodoc1_fecha_elaboracion,
					registrodoc1_referencia, registrodoc1_prioridad, (registrodoc1_fecha_elaboracion - NOW())/100000 as orden
					FROM registrodoc1 WHERE '$cod_sec'=registrodoc1_para and 
					registrodoc1_estado='SR' and registrodoc1_situacion='P' and 
					registrodoc1_cc='E' and registrodoc1_asociar<>'si' and	registrodoc1_hoja_ruta !='0' ";
					
		if($cad != ''){
			$sql_ent = $sql_ent." and registrodoc1_hoja_ruta like '%$cad%'";
		}
		
		$rs_ent = mysql_query($sql_ent, $conn);
		while ($row_ent = mysql_fetch_array($rs_ent)) 
		{  
			$rimg="images/media.gif";
			//aca deberia estar un CIFRADO
			$sql_usu="SELECT * FROM usuario WHERE usuario_ocupacion='$row_ent[registrodoc1_de]'";
			$rs_usu= mysql_query($sql_usu, $conn);
			$nom_usu=mysql_fetch_array($rs_usu);
			$doc_arch=cifrar($row_ent['registrodoc1_hoja_ruta']);
			if($row_derv['registrodoc1_prioridad']=='A')
				$rimg="images/alta.gif";
			
			$datos[] = array(
	            'orden'    => $row_ent['orden'],
    	        'prioridad'  => $rimg,
	            'hoja'    => $row_ent['registrodoc1_hoja_ruta'],
	            'fecha'   => $row_ent['registrodoc1_fecha_elaboracion'],
	            'refe' 	  => $row_ent['registrodoc1_referencia'],
				'remi'	  => $nom_usu['2'],
				'tipo'	  => "reg",
				'cifra'    => $doc_arch
			);

		}
		
		//$sql_derv = "SELECT * FROM derivardoc 
		$sql_derv = "SELECT derivardoc_hoja_ruta,  derivardoc_de, derivardoc_prioridad, derivardoc_fec_derivacion,
					 derivardoc_proveido, (derivardoc_fec_derivacion - NOW())/100000 as orden
					 FROM derivardoc 
					 WHERE '$cod_sec'=derivardoc_para and derivardoc_situacion='SR' and	derivardoc_hoja_ruta !='0' ";
		
			if($cad != ''){
				$sql_derv = $sql_derv." and derivardoc_hoja_ruta like '%$cad%'";
			}
		
		$rs_derv = mysql_query($sql_derv, $conn);
		while ($row_derv = mysql_fetch_array($rs_derv)) 
		{ 
			$rimg="images/media.gif";
			$doc_arch=cifrar($row_derv['derivardoc_hoja_ruta']);
					
			$sql_usu="SELECT * FROM usuario WHERE usuario_ocupacion='$row_derv[derivardoc_de]'";
			$rs_usu= mysql_query($sql_usu, $conn);
			$nom_usu=mysql_fetch_array($rs_usu);
			$doc_arch=cifrar($row_derv['derivardoc_hoja_ruta']);
			
			if($row_derv['derivardoc_prioridad']=='A')
				$rimg="images/alta.gif";
						
			$datos[] = array(
	            'orden'    => $row_derv['orden'],
    	        'prioridad'  => $rimg,
	            'hoja'    => $row_derv['derivardoc_hoja_ruta'],
	            'fecha'   => $row_derv['derivardoc_fec_derivacion'],
	            'refe'    => $row_derv['derivardoc_proveido'],
				'remi'	  => $nom_usu['2'],
				'tipo'	  => "der",				
				'cifra'    => $doc_arch
	     	);
				
		}		
	
	}
	
	
	//***********fin de rescate de datos por parte de los jefes a sus secres
// 	echo $hru;
	 //ORDER BY derivardoc_fec_derivacion DESC
    //$sql_derv = "SELECT * 
    $sql_derv = "SELECT derivardoc_hoja_ruta,  derivardoc_de, derivardoc_prioridad, derivardoc_fec_derivacion,
				 derivardoc_proveido, (derivardoc_fec_derivacion - NOW())/100000 as orden
				 FROM derivardoc WHERE '$hru'=derivardoc_para and
				 derivardoc_situacion='SR' and	derivardoc_hoja_ruta !='0' ";
	
		if($cad != ''){
			$sql_derv = $sql_derv." and derivardoc_hoja_ruta like '%$cad%'";
		}
			 
				 
	$rs_derv = mysql_query($sql_derv);
	while ($row_derv = mysql_fetch_array($rs_derv)) 
	{   

		$rimg="images/media.gif";	
		//-----------inicio de obtencion de remitente
		$sql_usu="SELECT * FROM usuario WHERE usuario_ocupacion='$row_derv[derivardoc_de]'";
		$rs_usu= mysql_query($sql_usu, $conn);
		$nom_usu=mysql_fetch_array($rs_usu);
		$doc_arch=cifrar($row_derv['derivardoc_hoja_ruta']);	
		//-----------fin de obtencion de remitente
		
		//-----------identificando la imagen
		if($row_derv['derivardoc_prioridad']=='A')
			$rimg="images/alta.gif";
		//-----------fin de la identificacion de la imagen
		$datos[] = array(
	            'orden'    => $row_derv['orden'],
    	        'prioridad'  => $rimg,
	            'hoja'    => $row_derv['derivardoc_hoja_ruta'],
	            'fecha'   => $row_derv['derivardoc_fec_derivacion'],
	            'refe'    => $row_derv['derivardoc_proveido'],
				'remi'	  => $nom_usu['2'],
				'tipo'	  => "der",
				'cifra'    => $doc_arch
     	);
	}
	
	//ORDER BY registrodoc1_fecha_elaboracion DESC
    //$sql_doc1 = "SELECT * FROM registrodoc1 
    $sql_doc1 = "SELECT registrodoc1_de,  registrodoc1_hoja_ruta, registrodoc1_fecha_elaboracion,
				 registrodoc1_referencia, registrodoc1_prioridad, (registrodoc1_fecha_elaboracion - NOW())/100000 as orden
				 FROM registrodoc1 
				 WHERE '$hru'=registrodoc1_para and
				 registrodoc1_estado='SR' and 
				 registrodoc1_situacion='P' and 
				 registrodoc1_cc='E' and 
				 registrodoc1_asociar<>'si' and	registrodoc1_hoja_ruta != '0' ";
		if($cad != ''){
			$sql_doc1 = $sql_doc1." and registrodoc1_hoja_ruta like '%$cad%'";
		}
		
	$rs_doc1 = mysql_query($sql_doc1);
	while ($row_doc1 = mysql_fetch_array($rs_doc1)) 
	{ 
		$rimg="images/media.gif";
		//-----------inicio de obtencion de remitente
		$sql_usu="SELECT * FROM usuario WHERE usuario_ocupacion='$row_doc1[registrodoc1_de]'";
		$rs_usu= mysql_query($sql_usu, $conn);
		$nom_usu=mysql_fetch_array($rs_usu);
		$doc_arch=cifrar($row_doc1['registrodoc1_hoja_ruta']);	
		//-----------fin de obtencion de remitente
		if($row_derv['derivardoc_prioridad']=='A')
			$rimg="images/alta.gif";
		
		$datos[] = array(
	            'orden'    => $row_doc1['orden'],
    	        'prioridad'  => $rimg,
	            'hoja'    => $row_doc1['registrodoc1_hoja_ruta'],
	            'fecha'   => $row_doc1['registrodoc1_fecha_elaboracion'],
	            'refe' 	  => $row_doc1['registrodoc1_referencia'],
				'remi'	  => $nom_usu['2'],
				'tipo'	  => "reg",
				'cifra'    => $doc_arch
    	 );
	}
	//echo "-_-".$cad."---";
	echo $json->encode($datos);

}
 
?>

<?php
include("../filtro.php");
 include("script/functions.inc");
 require_once("JSON.php");
 include("../conecta.php");
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
	/*
	//--> incio de acoplamiento de pendientes en caso ventanilla y secretaria
	if (($_SESSION["cargo"] == "Ventanilla") or  ($_SESSION["cargo"]=="Secretaria")){
		$s_dep_s="select cargos_dependencia from cargos where cargos_id='$hru'";
		$r_dep_s = mysql_query($s_dep_s, $conn);
		$row_dep=mysql_fetch_array($r_dep_s);
		$cod_dep=$row_dep[0];
		//ORDER BY registrodoc1_fecha_recepcion DESC
		$sql_ent = "SELECT * FROM registrodoc1 WHERE '$cod_dep'=registrodoc1_para and 
					registrodoc1_situacion='P' ";
					
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
			if($row_derv['derivardoc_prioridad']=='A')
				$rimg="images/alta.gif";
			
			$datos[] = array(
    	        'prioridad'  => $rimg,
	            'adju'    => $doc_arch,
	            'hoja'    => $row_ent['registrodoc1_hoja_ruta'],
	            'fecha'   => $row_ent['registrodoc1_fecha_elaboracion'],
				'prove'   => "",
	            'refe' 	  => $row_ent['registrodoc1_referencia'],
				'remi'	  => $nom_usu['2'],
				'cifra'    => $doc_arch
			);

		}
		
		$sql_derv = "SELECT * FROM derivardoc WHERE '$cod_dep'=derivardoc_para and
					 derivardoc_situacion='R' and derivardoc_estado='P' ";
		
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
    	        'prioridad'  => $rimg,
	            'adju'    => $doc_arch,
	            'hoja'    => $row_derv['derivardoc_hoja_ruta'],
	            'fecha'   => $row_derv['derivardoc_fec_derivacion'],
				'prove'   => "",
	            'refe'    => $row_derv['derivardoc_proveido'],
				'remi'	  => $nom_usu['2'],
				'cifra'    => $doc_arch
	     	);
				
		}		
	
	}
	//--> fin del acoplamiento de pendientes en caso ventanilla y secretaria
	*/
// 	echo $hru;
	 //ORDER BY derivardoc_fec_derivacion DESC
    $sql_derv = "SELECT derivardoc_cod, derivardoc_hoja_ruta, derivardoc_n_derivacion,
				 derivardoc_de, derivardoc_para, derivardoc_proveido, derivardoc_fec_derivacion, derivardoc_fec_recibida,
				 derivardoc_fec_plazo,  derivardoc_copia_de, (derivardoc_fec_plazo - CURDATE() ) as restante,
				 (derivardoc_fec_derivacion - NOW())/100000 as orden
 				 FROM derivardoc WHERE '$hru'=derivardoc_para and
				 derivardoc_situacion='R' and derivardoc_estado='P'";
	
		if($cad != ''){
			$sql_derv = $sql_derv." and derivardoc_hoja_ruta like '%$cad%'";
		}
	$rs_derv = mysql_query($sql_derv);
	while ($row_derv = mysql_fetch_array($rs_derv)) 
	{   

		//para determinar los proveidos			 
		$sql_ent11 = "SELECT * FROM registrodoc1 WHERE '$row_derv[derivardoc_hoja_ruta]'=registrodoc1_hoja_ruta";
		$rs_ent11 = mysql_query($sql_ent11, $conn);
		$row_ent11 = mysql_fetch_array($rs_ent11);
		//fin consulta de proveidos en la tabla derivadoc		 


		$rimg="images/media.gif";	
		//-----------inicio de obtencion de remitente
		$sql_usu="SELECT * FROM usuario WHERE usuario_ocupacion='$row_derv[derivardoc_de]'";
		$rs_usu= mysql_query($sql_usu, $conn);
		$nom_usu=mysql_fetch_array($rs_usu);
			if($nom_usu==""){
				$nom_usu[2]="Usuario Externo";
			}
		$doc_arch=cifrar($row_derv['derivardoc_hoja_ruta']);	
		//-----------fin de obtencion de remitente
		
		//-----------identificando la imagen
		if($row_derv['derivardoc_prioridad']=='A')
			$rimg="images/alta.gif";
		//-----------fin de la identificacion de la imagen
		$datos[] = array(
	            'orden'    => $row_derv['orden'],
    	        'prioridad'  => $rimg,
	            'adju'    => $doc_arch,
	            'hoja'    => $row_derv['derivardoc_hoja_ruta'],
	            'fecha'   => $row_derv['derivardoc_fec_derivacion'],
				'refe'   => $row_ent11['registrodoc1_referencia'],
	            'restante'   => $row_derv['restante'],
	            'prove'    => $row_derv['derivardoc_proveido'],
				'remi'	  => $nom_usu['2'],
				'cifra'    => $doc_arch
     	);
	}
	
	//ORDER BY registrodoc1_fecha_elaboracion DESC
//    $sql_doc1 = "SELECT * FROM registrodoc1 WHERE '$hru'=registrodoc1_para and
    $sql_doc1 = "SELECT registrodoc1_hoja_ruta, registrodoc1_fecha_elaboracion, registrodoc1_de, 
				 registrodoc1_referencia, registrodoc1_tipo, (registrodoc1_fecha_elaboracion - NOW())/100000 as orden
				 FROM registrodoc1 WHERE '$hru'=registrodoc1_para and
				 registrodoc1_estado='R' and 
				 registrodoc1_situacion='P' and 
				 registrodoc1_cc='E' and 
				 registrodoc1_asociar<>'si' ";
		if($cad != ''){
			$sql_doc1 = $sql_doc1." and registrodoc1_hoja_ruta like '%$cad%'";
		}
		
	$rs_doc1 = mysql_query($sql_doc1);
	while ($row_doc1 = mysql_fetch_array($rs_doc1)) 
	{ 
		$rimg="images/media.gif";
		//-----------inicio de obtencion de remitente
		if($row_doc1['registrodoc1_tipo']=='EXTERNO')
		{
			$r_rm = mysql_query("SELECT * FROM usuarioexterno WHERE '$row_doc1[registrodoc1_de]'=usuarioexterno_codigo",$conn);
			$row_rm=mysql_fetch_array($r_rm);
			//$tit_rm='Sr';
			$nombrusu=$row_rm['usuarioexterno_nombre'];
		}
		else
		{
			$sql_usu="SELECT * FROM usuario WHERE usuario_ocupacion='$row_doc1[registrodoc1_de]'";
			$rs_usu= mysql_query($sql_usu, $conn);
			$nom_usu=mysql_fetch_array($rs_usu);
			$nombrusu=$nom_usu['2'];
		}

		$doc_arch=cifrar($row_doc1['registrodoc1_hoja_ruta']);	
		//-----------fin de obtencion de remitente
		if($row_derv['derivardoc_prioridad']=='A')
			$rimg="images/alta.gif";
		
		$datos[] = array(
	            'orden'    => $row_doc1['orden'],
    	        'prioridad'  => $rimg,
	            'adju'    => $doc_arch,
	            'hoja'    => $row_doc1['registrodoc1_hoja_ruta'],
	            'fecha'   => $row_doc1['registrodoc1_fecha_elaboracion'],
				'prove'   => "",
	            'restante'   => "",
	            'refe' 	  => $row_doc1['registrodoc1_referencia'],
				'remi'	  => $nombrusu,
				'cifra'    => $doc_arch
    	 );
	}
	//echo "-_-".$cad."---";
	echo $json->encode($datos);

}
 
?>
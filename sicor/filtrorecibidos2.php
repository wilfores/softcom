<?php
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
 $mes = date("m");
 $anio = date ("Y");
 $datos = array();
if($_GET['action'] == 'listar')
{
//    $hru   = $_GET['hru'];
	$depto = $_GET["dpto"];
	$cad   = $_GET['cadena'];
	// RECEPCION DE DOCUMENTOS NUEVOS -- TABLA REGISTRODOC1
    $sqlreg1 = "SELECT registrodoc1_id, registrodoc1_hoja_ruta, registrodoc1_fecha_recepcion, 
				registrodoc1_de, registrodoc1_para, usuario_nombre, registrodoc1_referencia, documentos_descripcion, 
				registrodoc1_estado, registrodoc1_asociar, registrodoc1_asociar_h_r, registrodoc1_cc, 
				registrodoc1_cite, usuario_ocupacion, registrodoc1_asociar, documentos_id, registrodoc1_situacion, 
				TIMESTAMPDIFF(DAY,  DATE(registrodoc1_fecha_recepcion),CURDATE() ) as orden
				FROM `registrodoc1`, `documentos`, `usuario`
				where registrodoc1_depto_para = '$depto' 
				and registrodoc1_para=usuario_ocupacion 
				and registrodoc1_doc=documentos_sigla 
				and registrodoc1_estado = 'R' 
				and DATE_FORMAT(registrodoc1_fecha_recepcion, '%m') = '$mes' 
				and registrodoc1_gestion = '$anio' ";
	
	if($cad != ''){
		$sqlreg1 = $sqlreg1." and registrodoc1_hoja_ruta like '%$cad%'";
	}
	$rs_sqlreg1 = mysql_query($sqlreg1);
	while ($row_reg1 = mysql_fetch_array($rs_sqlreg1)) 
	{   

		$sql_usu="SELECT usuario_nombre FROM usuario WHERE usuario_ocupacion='$row_reg1[registrodoc1_de]'";
		$rs_usu= mysql_query($sql_usu, $conn);
		$nom_usu=mysql_fetch_array($rs_usu);
		$sql_des="SELECT usuario_nombre FROM usuario WHERE usuario_ocupacion='$row_reg1[registrodoc1_para]'";
		$rs_des= mysql_query($sql_des, $conn);
		$nom_des=mysql_fetch_array($rs_des);
		//-----------fin de obtencion de destinatario
		$datos[] = array(
				'orden'	  => $row_reg1['orden'],
				'id'	  => $row_reg1['registrodoc1_id'],
	            'hoja'    => $row_reg1['registrodoc1_hoja_ruta'],
	            'cite'    => $row_reg1['registrodoc1_cite'],
	            'fecha'   => $row_reg1['registrodoc1_fecha_recepcion'],
				'remi'	  => $nom_usu['usuario_nombre'],
				'desti'	  => $nom_des['usuario_nombre'],
				'tipo'	  => $row_reg1['documentos_descripcion'],
				'estado'  => $row_reg1['registrodoc1_situacion'],
				'tabla'  => "re1"
				//'cifra'    => $doc_arch
     	);
	}
    $sqlreg2 = "SELECT registrodoc1_id, registrodoc1_hoja_ruta, registrodoc1_fecha_recepcion, 
				registrodoc1_de, registrodoc1_para, usuarioexterno_nombre, registrodoc1_referencia, 
				clasecorrespondencia_descripcion_clase_corresp as descri, registrodoc1_doc, 
				registrodoc1_estado, registrodoc1_asociar, registrodoc1_asociar_h_r, registrodoc1_situacion, 
				registrodoc1_cc, registrodoc1_cite, usuarioexterno_codigo, registrodoc1_asociar,
				clasecorrespondencia_descripcion_clase_corresp as descripcion, 
				TIMESTAMPDIFF(DAY,  DATE(registrodoc1_fecha_recepcion),CURDATE() ) as orden
				FROM registrodoc1, clasecorrespondencia, usuarioexterno
				where registrodoc1_depto_para = '$depto' 
				and registrodoc1_de=usuarioexterno_codigo
				and registrodoc1_doc=clasecorrespondencia_codigo_clase_corresp
				and registrodoc1_estado = 'R' 
				and DATE_FORMAT(registrodoc1_fecha_recepcion, '%m') = '$mes' 
				and registrodoc1_gestion = '$anio' ";
	
	if($cad != ''){
		$sqlreg2 = $sqlreg2." and registrodoc1_hoja_ruta like '%$cad%'";
	}
	$rs_sqlreg2 = mysql_query($sqlreg2);
	while ($row_reg2 = mysql_fetch_array($rs_sqlreg2)) 
	{   

		$sql_des="SELECT usuario_nombre FROM usuario WHERE usuario_ocupacion='$row_reg2[registrodoc1_para]'";
		$rs_des= mysql_query($sql_des, $conn);
		$nom_des=mysql_fetch_array($rs_des);
		//-----------fin de obtencion de destinatario
		$datos[] = array(
				'orden'	  => $row_reg2['orden'],
				'id'	  => $row_reg2['registrodoc1_id'],
	            'hoja'    => $row_reg2['registrodoc1_hoja_ruta'],
	            'cite'    => $row_reg2['registrodoc1_cite'],
	            'fecha'   => $row_reg2['registrodoc1_fecha_recepcion'],
				'remi'	  => $row_reg2['usuarioexterno_nombre'],
				'desti'	  => $nom_des['usuario_nombre'],
				'tipo'	  => $row_reg2['descripcion'],
				'estado'  => $row_reg2['registrodoc1_situacion'],
				'tabla'  => "re1"
				//'cifra'    => $doc_arch
     	);
	}
    $listemp = mysql_query("select usuario_ocupacion, usuario_nombre 
							from usuario where usuario_cod_departamento = '$depto' ",$conn);
	while($respemp=mysql_fetch_array($listemp)){
//		echo $respemp["usuario_ocupacion"]."****";
		$sqlder = "SELECT derivardoc_cod, derivardoc_hoja_ruta, derivardoc_fec_recibida, 
				   derivardoc_de, derivardoc_para, usuario_nombre, derivardoc_proveido,  derivardoc_estado, 
				   derivardoc_cc, usuario_ocupacion, derivardoc_copia_de, 
				   TIMESTAMPDIFF(DAY,  DATE(derivardoc_fec_recibida),CURDATE() ) as orden
				   FROM `derivardoc`, `usuario`
				   where derivardoc_para = '$respemp[usuario_ocupacion]' 
				   and derivardoc_para=usuario_ocupacion 
				   and derivardoc_situacion = 'R'  
				   and DATE_FORMAT(derivardoc_fec_recibida, '%m') = '$mes' 
				   and derivardoc_gestion = '$anio' ";
		
		if($cad != ''){
			$sqlder = $sqlder." and derivardoc_hoja_ruta like '%$cad%'";
		}
		$rs_sqlder = mysql_query($sqlder);
		while ($row_der = mysql_fetch_array($rs_sqlder)) 
		{   
			$sql_rem="SELECT usuario_nombre FROM usuario WHERE usuario_ocupacion='$row_der[derivardoc_de]'";
			$rs_rem= mysql_query($sql_rem, $conn);
			$nom_rem=mysql_fetch_array($rs_rem);
			if($row_der["derivardoc_copia_de"] == '0'){
				$rescite = mysql_query("select registrodoc1_cite, registrodoc1_doc, registrodoc1_tipo 
				from registrodoc1 where registrodoc1_hoja_ruta = '$row_der[derivardoc_hoja_ruta]'",$conn);
			}
			else {
//				echo "es copia*****";
				$rescite = mysql_query("select registrodoc1_cite, registrodoc1_doc, registrodoc1_tipo  
				from registrodoc1 where registrodoc1_hoja_ruta = '$row_der[derivardoc_copia_de]'",$conn);					
			}
			$obtcite = mysql_fetch_array($rescite);
			if($obtcite[registrodoc1_tipo]=='INTERNO') {
			$tipodocu = mysql_query("select documentos_descripcion as descripcion
				from documentos where documentos_sigla = '$obtcite[registrodoc1_doc]' ",$conn);
			}
			else{
//			echo "doc externo**";
			$tipodocu = mysql_query("select clasecorrespondencia_descripcion_clase_corresp as descripcion
				from clasecorrespondencia where clasecorrespondencia_codigo_clase_corresp = '$obtcite[registrodoc1_doc]' ",$conn);			
			}
			$obtipdoc = mysql_fetch_array($tipodocu);
			
			$datos[] = array(
					'orden'	  => $row_der['orden'],
					'id'	  => $row_der['derivardoc_cod'],
					'hoja'    => $row_der['derivardoc_hoja_ruta'],
					'cite'    => $obtcite['registrodoc1_cite'],
					'fecha'   => $row_der['derivardoc_fec_recibida'],
					'remi'	  => $nom_rem['usuario_nombre'],
					'desti'	  => $row_der['usuario_nombre'],
					'tipo'	  => $obtipdoc['descripcion'],
					'estado'  => $row_der['derivardoc_estado'],
					'tabla'  => "der"

			);
		}
	}
	echo $json->encode($datos);

}
 
?>
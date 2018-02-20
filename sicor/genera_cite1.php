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

$camb_gest=$_SESSION["camb_gest"];
//$conn = Conectarse();
if($camb_gest==2013)
{
	$conn = Conectarse();
	$ges=date('2013');
}
if($camb_gest==2014)
{
	$conn = Conectarse2();
	$ges=date('2014');
}
if($camb_gest==2015)
{
	$conn = Conectarse3();
	$ges=date('Y');
}

$codigo=$_SESSION["cargo_asignado"];
$depto=$_SESSION["departamento"];
$tipo_doc=$_SESSION["documento"];

$fecha=date("Y-m-d H:i:s");
/* $ges=date('Y');  CAMBIO DE GESTION PARA CITE*/
//$tipo_doc=$_POST["tipo_doc"];
$doc_para=$_SESSION["para"];
$dept_para=$_SESSION["depto_para"];
//$nom=$_POST["nom"];
$ref=$_SESSION["ref"];
//$asoc=$_SESSION["asoc"];
$val=$_SESSION["valor"];
$hrasdoc2=$_SESSION["hrasd"];

//echo "EL PRIMERO $hrasdoc2<br>";
//echo "$val<br>";

//debemos verificar si la hoja de ruta es una derivacion mukltilpe, pues en ese caso no cuenta con hojaderuta en la tabla registro doc 1
$verihr = mysql_query("select count(registrodoc1_hoja_ruta) as total from registrodoc1 where registrodoc1_hoja_ruta = '$hrasdoc2' ", $conn);
$reshr = mysql_fetch_array($verihr);
if($reshr["total"] == 0 ){
	$verihr2 = mysql_query("select derivardoc_copia_de from derivardoc where derivardoc_hoja_ruta = '$hrasdoc2' ", $conn);
	$reshr2 = mysql_fetch_array($verihr2);
	$hrasdoc = $reshr2["derivardoc_copia_de"];
}
else
{
$hrasdoc=$hrasdoc2;
}

if($tipo_doc=='17' || $tipo_doc=='18' || $tipo_doc=='25' || $tipo_doc=='26' || $tipo_doc=='27' || $tipo_doc=='28' || $tipo_doc=='29' || $tipo_doc=='30' || $tipo_doc=='31' || $tipo_doc=='32' || $tipo_doc=='33' || $tipo_doc=='47')
	{
		$rdoc=mysql_query("SELECT * from documentos 
							where documentos_id='$tipo_doc'",$conn);
		$rpd=mysql_fetch_array($rdoc);
		$sigla_doc=$rpd["documentos_sigla"];
		
		$query = "select max(registrodoc1_n_doc)from registrodoc1 where registrodoc1_doc='$sigla_doc' and registrodoc1_depto='$depto'";
		$result = mysql_query($query,$conn);
		$record = mysql_fetch_array($result);	
		$id_fact=$record[0]+1;/*obtiene el maximmo del id del documento*/

			
		$sig_usu_de=mysql_query("SELECT d.departamento_sigla_dep, u.usuario_nombre, c.cargos_cargo
		from usuario u, departamento d, cargos c
		where u.usuario_ocupacion='$codigo'
		and u.usuario_cod_departamento=d.departamento_cod_departamento
		and u.usuario_ocupacion=c.cargos_id",$conn);
		$r_usu_de=mysql_fetch_array($sig_usu_de);
		$r_usu_de1=$r_usu_de[0];
		$nom_de=$r_usu_de[1];
		$cargo_de=$r_usu_de[2];
		

		if($tipo_doc=='17'){ $cite=$id_fact;}
		if($tipo_doc=='18'){ $cite=$id_fact.'/'.$ges;}
		if($tipo_doc=='25'){$cite=ANPE.'/'.B.'-'.$id_fact.'/'.$ges; }/*ANPE BIENES*/
		if($tipo_doc=='26'){$cite=ANPE.'/'.M.'-'.$id_fact.'/'.$ges; }/*ANPE MEDICAMENTOS*/
		if($tipo_doc=='27'){$cite=ANPE.'/'.S.'-'.$id_fact.'/'.$ges; }/*ANPE CONSULTORIA*/
		if($tipo_doc=='28'){$cite=ANPE.'/'.C.'-'.$id_fact.'/'.$ges; }/*ANPE SERVICIOS*/
		if($tipo_doc=='29'){$cite=LP.'/'.B.'-'.$id_fact.'/'.$ges; }/*LICITACION PUBLICA BIENES*/
		if($tipo_doc=='30'){$cite=LP.'/'.M.'-'.$id_fact.'/'.$ges; }/*LICITACION PUBLICA MEDICAMENTOS*/
		if($tipo_doc=='31'){$cite=LP.'/'.S.'-'.$id_fact.'/'.$ges; }/*LICITACION PUBLICA CONSULTORIA*/
		if($tipo_doc=='32'){$cite=LP.'/'.C.'-'.$id_fact.'/'.$ges; }/*LICITACION PUBLICA SERVICIOS*/
		if($tipo_doc=='33'){ $cite=CD.'/'.$id_fact.'/'.$ges; }/*CONTRATACION DIRECTA*/	
		
		if($tipo_doc=='47'){ $cite=$id_fact.'/'.$ges; }/*DOCUMENTO DE DESPACHO*/		
	
	}
	else
	{
		
		/*selecion ale cite de la tabla departamento*/
		$rcite=mysql_query("SELECT d.departamento_forma_cite from cargos c, departamento d 
							where c.cargos_id='$codigo' and c.cargos_cod_depto=d.departamento_cod_departamento",$conn);
		$rpc=mysql_fetch_array($rcite);
		
		$rdoc=mysql_query("SELECT * from documentos 
							where documentos_id='$tipo_doc'",$conn);
		$rpd=mysql_fetch_array($rdoc);
		$sigla_doc=$rpd["documentos_sigla"];
			
		$query = "select max(registrodoc1_n_doc)from registrodoc1 where registrodoc1_doc='$sigla_doc' and registrodoc1_depto='$depto'";
		$result = mysql_query($query,$conn);
		$record = mysql_fetch_array($result);
		$id_fact=$record[0]+1;/*obtiene el maximmo del id del documento*/
					
		$sig_usu_de=mysql_query("SELECT d.departamento_sigla_dep, u.usuario_nombre, c.cargos_cargo
		from usuario u, departamento d, cargos c
		where u.usuario_ocupacion='$codigo'
		and u.usuario_cod_departamento=d.departamento_cod_departamento
		and u.usuario_ocupacion=c.cargos_id",$conn);
		$r_usu_de=mysql_fetch_array($sig_usu_de);
		$r_usu_de1=$r_usu_de[0];
		$nom_de=$r_usu_de[1];
		$cargo_de=$r_usu_de[2];
				
		$sig_usu_para=mysql_query("SELECT d.departamento_sigla_dep, u.usuario_nombre, c.cargos_cargo
		from usuario u, departamento d, cargos c
		where u.usuario_ocupacion='$doc_para'
		and u.usuario_cod_departamento=d.departamento_cod_departamento
		and u.usuario_ocupacion=c.cargos_id",$conn);
		$r_usu_para=mysql_fetch_array($sig_usu_para);
		$r_usu_para1=$r_usu_para[0];
		$nom_para=$r_usu_para[1];
		$cargo_para=$r_usu_para[2];
		
		if($tipo_doc=='45')
		{ $cite=$r_usu_de1.'/'.$id_fact.'/'.$ges; }/*DOCUMENTO DE DESPACHO*/
		else
		{				
		$cite=$rpc["0"].'/'.$rpd["documentos_sigla"].'/'.$id_fact.'/'.$ges;
		}

}

if(isset ($_POST[cancelar]))
{
	if($_POST['tipo_doc']=='22')
	{
	mysql_query("DELETE FROM temp2 WHERE temp2_cod_mio='$codigo'",$conn);
	}
	
	if($_POST['tipo_doc']=='6' || $_POST['tipo_doc']=='7' || $_POST['tipo_doc']=='19' || $_POST['tipo_doc']=='34' || $_POST['tipo_doc']=='35' || $_POST['tipo_doc']=='36' || $_POST['tipo_doc']=='39')
	{
	mysql_query("DELETE FROM temp1 WHERE temp1_cod_mio='$codigo'",$conn);
	}

?>
                <script language="JavaScript">
                window.self.location="menu2.php";
                </script>
<?php
}
/***********************************************************************/
/**************GUARDA DATOS Y SACA DE LOS TEMPORALES *******************/
if(isset ($_POST[finalizar]))
{
	$tipo_doc=$_POST["tipo_doc"];
	
	if($tipo_doc=='17' || $tipo_doc=='18' || $_POST['tipo_doc']=='25' || $_POST['tipo_doc']=='26' || $_POST['tipo_doc']=='27' || $_POST['tipo_doc']=='28' || $_POST['tipo_doc']=='29' || $_POST['tipo_doc']=='30' || $_POST['tipo_doc']=='31' || $_POST['tipo_doc']=='32' || $_POST['tipo_doc']=='33' || $_POST['tipo_doc']=='10' || $_POST['tipo_doc']=='47')
	{
	
		$doc_para=$_POST["doc_para"];
		//$cod_dept_para=$_POST["cod_depto_pa"];
		//$nom=$_POST["nom"];
		$ref=$_POST["ref"];
		$cite=$_POST["cite"];
		$fecha=$_POST["fecha"];
		$sigla_de=$_POST["sigl_de1"];
		$sigla_para=$_POST["sigl_para1"];
		$asociar=$_POST["asociar"];
		
		if($_POST['tipo_doc']=='10' || $_POST['tipo_doc']=='47')
		{ 
		 $ref=$_POST["ref"];
		}
		else
		{
		 $ref='NULL';
		}		
		
		if(mysql_fetch_array(mysql_query("SELECT registrodoc1_cite FROM `registrodoc1` where registrodoc1_cite='$cite'", $conn))) 
		{

				$rdoc=mysql_query("SELECT * from documentos where documentos_id='$tipo_doc'",$conn);
				$rpd=mysql_fetch_array($rdoc);
				$sigla_doc=$rpd["documentos_sigla"];
				
				$query = "select max(registrodoc1_n_doc)from registrodoc1 where registrodoc1_doc='$sigla_doc' and registrodoc1_depto='$depto'";
				$result = mysql_query($query,$conn);
				$record = mysql_fetch_array($result);	
				$id_fact=$record[0]+1;/*obtiene el maximmo del id del documento*/
				
				$ges=date('Y');
				
				if($tipo_doc=='17'){ $cite=$id_fact;}
				if($tipo_doc=='18'){ $cite=$id_fact.'/'.$ges;}
				if($tipo_doc=='25'){$cite=ANPE.'/'.B.'-'.$id_fact.'/'.$ges; }/*ANPE BIENES*/
				if($tipo_doc=='26'){$cite=ANPE.'/'.M.'-'.$id_fact.'/'.$ges; }/*ANPE MEDICAMENTOS*/
				if($tipo_doc=='27'){$cite=ANPE.'/'.S.'-'.$id_fact.'/'.$ges; }/*ANPE CONSULTORIA*/
				if($tipo_doc=='28'){$cite=ANPE.'/'.C.'-'.$id_fact.'/'.$ges; }/*ANPE SERVICIOS*/
				if($tipo_doc=='29'){$cite=LP.'/'.B.'-'.$id_fact.'/'.$ges; }/*LICITACION PUBLICA BIENES*/
				if($tipo_doc=='30'){$cite=LP.'/'.M.'-'.$id_fact.'/'.$ges; }/*LICITACION PUBLICA MEDICAMENTOS*/
				if($tipo_doc=='31'){$cite=LP.'/'.S.'-'.$id_fact.'/'.$ges; }/*LICITACION PUBLICA CONSULTORIA*/
				if($tipo_doc=='32'){$cite=LP.'/'.C.'-'.$id_fact.'/'.$ges; }/*LICITACION PUBLICA SERVICIOS*/
				if($tipo_doc=='33'){ $cite=CD.'/'.$id_fact.'/'.$ges; }/*CONTRATACION DIRECTA*/	
				
				if($tipo_doc=='47'){ $cite=$id_fact.'/'.$ges; }/*DOCUMENTO DE DESPACHO*/
					

		}
		
		$qmr = "select max(registrodoc1_id)from registrodoc1";
		$rqmr = mysql_query($qmr,$conn);
		$reqmr = mysql_fetch_array($rqmr);			
		$v_m_id=$reqmr[0]+1;/*obtiene el maximmo del id del documento 2*/	
			
		if($hrasdoc!='' || $val=='si')
		{
		$query1 = "select registrodoc1_n_h_r from registrodoc1 where registrodoc1_hoja_ruta='$hrasdoc'";
		$result1 = mysql_query($query1,$conn);
		$record1 = mysql_fetch_array($result1);	
		$id_fact1=$record1[0];/*obtiene el maximmo de la hoja de ruta del documento 2*/	
		$hr=$hrasdoc2;
		}
		else
		{
		$query1 = "select max(registrodoc1_n_h_r)from registrodoc1";
		$result1 = mysql_query($query1,$conn);
		$record1 = mysql_fetch_array($result1);	
		$id_fact1=0;/*obtiene el maximmo de la hoja de ruta del documento 2*/	
		$hr=0;
		}
					
		$rdoc=mysql_query("SELECT * from documentos 
							where documentos_id='$tipo_doc'",$conn);
		$rpd=mysql_fetch_array($rdoc);
		$sigla_doc=$rpd["documentos_sigla"];
		
		$query = "select max(registrodoc1_n_doc)from registrodoc1 where registrodoc1_doc='$sigla_doc' and registrodoc1_depto='$depto'";
		$result = mysql_query($query,$conn);
		$record = mysql_fetch_array($result);
		$id_fact=$record[0]+1;/*obtiene el maximmo del id del documento*/

		if($val=='si'){$asoc=$hrasdoc2;}
		else $asoc='NULL';

		$insertar=" INSERT INTO `registrodoc1` (`registrodoc1_id`, `registrodoc1_n_h_r`, `registrodoc1_hoja_ruta`, `registrodoc1_tipo`, `registrodoc1_cite`, `registrodoc1_referencia`, `registrodoc1_doc`, `registrodoc1_n_doc`, `registrodoc1_depto`, `registrodoc1_de`, `registrodoc1_para`, `registrodoc1_depto_para`, `registrodoc1_estado`, `registrodoc1_situacion`, `registrodoc1_fecha_elaboracion`, `registrodoc1_fecha_recepcion`, `registrodoc1_n_hojas`, `registrodoc1_prioridad`, `registrodoc1_respuesta`, `registrodoc1_gestion`, `registrodoc1_n_adjunto`, `registrodoc1_descrip_adj`, `registrodoc1_nom_arch_adj`, `registrodoc1_asociar`, `registrodoc1_asociar_h_r`, `registrodoc1_cc`) VALUES 
($v_m_id,$id_fact1,'$hr','INTERNO','$cite','$ref','$sigla_doc',$id_fact,'$depto','$codigo',$codigo,'$depto','R','D','$fecha','$fecha',0,'M','NO',$ges,0,'NULL','NULL','$val','$asoc', 'NE')";
					
	$resul = mysql_query($insertar,$conn);
	
	?>
		<script language="JavaScript">
			window.self.location="listado_de_mi2.php";
		</script>
	<?php
	
	} /* FIN DE TIPO DE DOCUMENTO  '17' '18' '25' '26' '27' '28' '29' '30' '31' '32' '33' '10' */
	else 
	{		
		$doc_para=$_POST["doc_para"];
		$cod_dept_para=$_POST["cod_depto_pa"];
		//$nom=$_POST["nom"];
		$ref=$_POST["ref"];
		$cite=$_POST["cite"];
		$fecha=$_POST["fecha"];
		$sigla_de=$_POST["sigl_de1"];
		$sigla_para=$_POST["sigl_para1"];
		$asociar=$_POST["asociar"];

		if(mysql_fetch_array(mysql_query("SELECT registrodoc1_cite FROM `registrodoc1` where registrodoc1_cite='$cite'", $conn))) 
		{
			$rcite=mysql_query("SELECT d.departamento_forma_cite from cargos c, departamento d 
								where c.cargos_id='$codigo' and c.cargos_cod_depto=d.departamento_cod_departamento",$conn);
			$rpc=mysql_fetch_array($rcite);
			
			$rdoc=mysql_query("SELECT * from documentos 
								where documentos_id='$tipo_doc'",$conn);
			$rpd=mysql_fetch_array($rdoc);
			$sigla_doc=$rpd["documentos_sigla"];
				
			$query = "select max(registrodoc1_n_doc)from registrodoc1 where registrodoc1_doc='$sigla_doc' and registrodoc1_depto='$depto'";
			$result = mysql_query($query,$conn);
			$record = mysql_fetch_array($result);
			$id_fact=$record[0]+1;/*obtiene el maximmo del id del documento*/
			
			$sig_usu_de=mysql_query("SELECT d.departamento_sigla_dep, u.usuario_nombre, c.cargos_cargo
			from usuario u, departamento d, cargos c
			where u.usuario_ocupacion='$codigo'
			and u.usuario_cod_departamento=d.departamento_cod_departamento
			and u.usuario_ocupacion=c.cargos_id",$conn);
			$r_usu_de=mysql_fetch_array($sig_usu_de);
			$r_usu_de1=$r_usu_de[0];
			
			$ges=date('Y');
			
			if($tipo_doc=='45')
			{ $cite=$r_usu_de1.'/'.$id_fact.'/'.$ges; }/*DOCUMENTO DE DESPACHO*/
			else
			{				
			$cite=$rpc["0"].'/'.$rpd["documentos_sigla"].'/'.$id_fact.'/'.$ges;
			}
					
			//$cite=$rpc["0"].'/'.$rpd["documentos_sigla"].'/'.$id_fact.'/'.$ges;

		}
		
		if($ref=='')
		{
			
			?>
					<script language="JavaScript">
					alert("Error, Debe Ingresar la REFERENCIA");
					</script>
					<script language="JavaScript">
					window.self.location="for_nuevo_doc2.php";
					</script>
			<?php
			
		}
		else
		{		
			if($tipo_doc=='6' || $tipo_doc=='7' || $tipo_doc=='19' || $tipo_doc=='34' || $tipo_doc=='35' || $tipo_doc=='36' || $tipo_doc=='39')
			{
				/*
				echo "*******************<br>";
				echo "$tipo_doc documeto<br>";
				echo "$doc_para documrnto ara<br>";
				echo "$nom nombreee<br>";
				echo "$ref refrencia<br>";
				echo "$cite numero de cite<br>";
				echo "$fecha fecha actual<br>";
				echo "$sigla_de numero de sigla<br>";
				echo "$sigla_para numero para sigla<br>";
				echo "$val<br>";
				echo "$asociar asociar<br>";
				*/
				
				$qmr = "select max(registrodoc1_id)from registrodoc1";
				$rqmr = mysql_query($qmr,$conn);
				$reqmr = mysql_fetch_array($rqmr);			
				$v_m_id=$reqmr[0]+1;/*obtiene el maximmo del id del documento 2*/	
				
				/*
				$query1 = "select max(registrodoc1_n_h_r)from registrodoc1";
				$result1 = mysql_query($query1,$conn);
				$record1 = mysql_fetch_array($result1);			
				$id_fact1=$record1[0]+1;/*obtiene el maximmo del id del documento 2*/					
				/*$hr=$sigla_de.'-'.$id_fact1.'-'.$sigla_de;	*/
				
				if($hrasdoc!='' || $val=='si')
				{
				$query1 = "select registrodoc1_n_h_r from registrodoc1 where registrodoc1_hoja_ruta='$hrasdoc'";
				$result1 = mysql_query($query1,$conn);
				$record1 = mysql_fetch_array($result1);	
				$id_fact1=$record1[0];/*obtiene el maximmo de la hoja de ruta del documento 2*/	
				$hr=$hrasdoc2;
				}
				else
				{
				$query1 = "select max(registrodoc1_n_h_r)from registrodoc1";
				$result1 = mysql_query($query1,$conn);
				$record1 = mysql_fetch_array($result1);	
				$id_fact1=0;/*obtiene el maximmo de la hoja de ruta del documento 2*/	
				$hr=0;
				/*$id_fact1=$record1[0]+1;/*obtiene el maximmo de la hoja de ruta del documento 2*/	
				/*$hr=$sigla_de.'-'.$id_fact1.'-'.$sigla_de;*/
				}
				
				echo "$id_fact1<br>";
				echo "$hr<br>";
				
				$rdoc=mysql_query("SELECT * from documentos 
									where documentos_id='$tipo_doc'",$conn);
				$rpd=mysql_fetch_array($rdoc);
				$sigla_doc=$rpd["documentos_sigla"];
				
				$qmr = "select max(registrodoc1_id)from registrodoc1";
				$rqmr = mysql_query($qmr,$conn);
				$reqmr = mysql_fetch_array($rqmr);			
				$v_m_id=$reqmr[0]+1;/*obtiene el maximmo del id del documento 2*/	
				
				$query = "select max(registrodoc1_n_doc)from registrodoc1 where registrodoc1_doc='$sigla_doc' and registrodoc1_depto='$depto'";
				$result = mysql_query($query,$conn);
				$record = mysql_fetch_array($result);			
				$id_fact=$record[0]+1;/*obtiene el maximmo de ls hoja de ruta del documento*/
				
				if($val=='si'){$asoc=$hrasdoc2;}
				else $asoc='NULL';
				
				if($doc_para=='')
				{
					$sqlcont = "SELECT * FROM temp1 WHERE temp1_cod_mio='$codigo'";
					$recont = mysql_query($sqlcont, $conn);
					$contar = mysql_num_rows($recont);
					
					/**************generar cite independiente****/
					$array_fech=split('-',$cite);				
					$sig1=$array_fech['0'];
					$num=$array_fech['1'];
					$sig2=$array_fech['2'];
					/***********************************************/
									 
					if($contar>13)
					{
					
					$sqlcont = "SELECT * FROM temp1 WHERE temp1_cod_mio='$codigo'";
					$rs_cont = mysql_query($sqlcont, $conn);
					while ($row_cont = mysql_fetch_array($rs_cont)) 
						{ 	
						
							$query1 = "select max(registrodoc1_n_h_r)from registrodoc1";
							$result1 = mysql_query($query1,$conn);
							$record1 = mysql_fetch_array($result1);			
							//$id_fact1=$record1[0]+1;/*obtiene el maximmo del id del documento 2*/					
							//$hr=$sigla_de.'-'.$id_fact1.'-'.$sigla_de;	
						
						$cod_para=$row_cont['temp1_cod_para'];
						$cod_dept_para=$row_cont['temp1_x1'];
						
						/*$insertar=" INSERT INTO `registrodoc1` (`registrodoc1_id`, `registrodoc1_n_h_r`, `registrodoc1_hoja_ruta`, `registrodoc1_tipo`, `registrodoc1_cite`, `registrodoc1_referencia`, `registrodoc1_doc`, `registrodoc1_n_doc`, `registrodoc1_depto`, `registrodoc1_de`, `registrodoc1_para`, `registrodoc1_depto_para`, `registrodoc1_estado`, `registrodoc1_situacion`, `registrodoc1_fecha_elaboracion`, `registrodoc1_fecha_recepcion`, `registrodoc1_n_hojas`, `registrodoc1_prioridad`, `registrodoc1_respuesta`, `registrodoc1_gestion`, `registrodoc1_n_adjunto`, `registrodoc1_descrip_adj`, `registrodoc1_nom_arch_adj`, `registrodoc1_asociar`, `registrodoc1_asociar_h_r`, `registrodoc1_cc`) VALUES ($v_m_id,0,'0','INTERNO','$cite','$ref','$sigla_doc',$id_fact,'$depto','$codigo',$cod_para,'$cod_dept_para','SR','P','$fecha','0000-00-00 00:00:00',0,'M','NO',$ges,0,'NULL','NULL','$val','$asoc', 'NE')";*/
						
						$insertar=" INSERT INTO `registrodoc1` (`registrodoc1_id`, `registrodoc1_n_h_r`, `registrodoc1_hoja_ruta`, `registrodoc1_tipo`, `registrodoc1_cite`, `registrodoc1_referencia`, `registrodoc1_doc`, `registrodoc1_n_doc`, `registrodoc1_depto`, `registrodoc1_de`, `registrodoc1_para`, `registrodoc1_depto_para`, `registrodoc1_estado`, `registrodoc1_situacion`, `registrodoc1_fecha_elaboracion`, `registrodoc1_fecha_recepcion`, `registrodoc1_n_hojas`, `registrodoc1_prioridad`, `registrodoc1_respuesta`, `registrodoc1_gestion`, `registrodoc1_n_adjunto`, `registrodoc1_descrip_adj`, `registrodoc1_nom_arch_adj`, `registrodoc1_asociar`, `registrodoc1_asociar_h_r`, `registrodoc1_cc`) VALUES ($v_m_id,$id_fact1,'$hr','INTERNO','$cite','$ref','$sigla_doc',$id_fact,'$depto','$codigo',$cod_para,'$cod_dept_para','SR','P','$fecha','0000-00-00 00:00:00',0,'M','NO',$ges,0,'NULL','NULL','$val','$asoc', 'NE')";					
						
						$resul = mysql_query($insertar,$conn);
						$v_m_id=$v_m_id+1;
						
						
						}
						
					mysql_query("DELETE FROM temp1 WHERE temp1_cod_mio='$codigo'",$conn);
					//echo 'El número de registros de la tabla es: '.$contar.'';
					}
					else
					{
						if($contar==1)
						{
							
							$sqlcont = "SELECT * FROM temp1 WHERE temp1_cod_mio='$codigo'";
							$rs_cont = mysql_query($sqlcont, $conn);
							$row_cont = mysql_fetch_array($rs_cont);
							$cod_para=$row_cont['temp1_cod_para'];
							
							/*$insertar=" INSERT INTO `registrodoc1` (`registrodoc1_id`, `registrodoc1_n_h_r`, `registrodoc1_hoja_ruta`, `registrodoc1_tipo`, `registrodoc1_cite`, `registrodoc1_referencia`, `registrodoc1_doc`, `registrodoc1_n_doc`, `registrodoc1_depto`, `registrodoc1_de`, `registrodoc1_para`, `registrodoc1_depto_para`, `registrodoc1_estado`, `registrodoc1_situacion`, `registrodoc1_fecha_elaboracion`, `registrodoc1_fecha_recepcion`, `registrodoc1_n_hojas`, `registrodoc1_prioridad`, `registrodoc1_respuesta`, `registrodoc1_gestion`, `registrodoc1_n_adjunto`, `registrodoc1_descrip_adj`, `registrodoc1_nom_arch_adj`, `registrodoc1_asociar`, `registrodoc1_asociar_h_r`, `registrodoc1_cc`) VALUES ($v_m_id,0,'0','INTERNO','$cite','$ref','$sigla_doc',$id_fact,'$depto','$codigo',$cod_para,'$cod_dept_para','SR','P','$fecha','0000-00-00 00:00:00',0,'M','NO',$ges,0,'NULL','NULL','$val','$asoc', 'NE')";*/
							
							$insertar=" INSERT INTO `registrodoc1` (`registrodoc1_id`, `registrodoc1_n_h_r`, `registrodoc1_hoja_ruta`, `registrodoc1_tipo`, `registrodoc1_cite`, `registrodoc1_referencia`, `registrodoc1_doc`, `registrodoc1_n_doc`, `registrodoc1_depto`, `registrodoc1_de`, `registrodoc1_para`, `registrodoc1_depto_para`, `registrodoc1_estado`, `registrodoc1_situacion`, `registrodoc1_fecha_elaboracion`, `registrodoc1_fecha_recepcion`, `registrodoc1_n_hojas`, `registrodoc1_prioridad`, `registrodoc1_respuesta`, `registrodoc1_gestion`, `registrodoc1_n_adjunto`, `registrodoc1_descrip_adj`, `registrodoc1_nom_arch_adj`, `registrodoc1_asociar`, `registrodoc1_asociar_h_r`, `registrodoc1_cc`) VALUES ($v_m_id,$id_fact1,'$hr','INTERNO','$cite','$ref','$sigla_doc',$id_fact,'$depto','$codigo',$cod_para,'$cod_dept_para','SR','P','$fecha','0000-00-00 00:00:00',0,'M','NO',$ges,0,'NULL','NULL','$val','$asoc', 'NE')";
														
							
							$resul = mysql_query($insertar,$conn);
							mysql_query("DELETE FROM temp1 WHERE temp1_cod_mio='$codigo'",$conn);
							
							//echo 'El número de registros de la tabla es: '.$contar.'';
							
						}
						else
						{
							$sqlcont = "SELECT * FROM temp1 WHERE temp1_cod_mio='$codigo'";
							$rs_cont = mysql_query($sqlcont, $conn);
							while ($row_cont = mysql_fetch_array($rs_cont)) 
								{ 	
								
									/*$query1 = "select max(registrodoc1_n_h_r)from registrodoc1";
									$result1 = mysql_query($query1,$conn);
									$record1 = mysql_fetch_array($result1);			
									$id_fact1=$record1[0]+1;/*obtiene el maximmo del id del documento 2*/														
									/*$hr=$sigla_de.'-'.$id_fact1.'-'.$sigla_de;*/	
									
									if($hrasdoc!='' || $val=='si')
									{
									$query1 = "select registrodoc1_n_h_r from registrodoc1 where registrodoc1_hoja_ruta='$hrasdoc'";
									$result1 = mysql_query($query1,$conn);
									$record1 = mysql_fetch_array($result1);	
									$id_fact1=$record1[0];/*obtiene el maximmo de la hoja de ruta del documento 2*/	
									$hr=$hrasdoc2;
									}
									else
									{
									$query1 = "select max(registrodoc1_n_h_r)from registrodoc1";
									$result1 = mysql_query($query1,$conn);
									$record1 = mysql_fetch_array($result1);	
									/*$id_fact1=$record1[0]+1;/*obtiene el maximmo de la hoja de ruta del documento 2*/	
									/*$hr=$sigla_de.'-'.$id_fact1.'-'.$sigla_de;*/
									$id_fact1=0;/*obtiene el maximmo de la hoja de ruta del documento 2*/	
									$hr=0;
									}
									
									$cod_para=$row_cont['temp1_cod_para'];
									$cod_dept_para=$row_cont['temp1_x1'];
								
								
											echo "*******************<br>";
											echo "$tipo_doc documeto<br>";
											echo "$doc_para documrnto ara<br>";
											echo "$nom nombreee<br>";
											echo "$ref refrencia<br>";
											echo "$cite numero de cite<br>";
											echo "$fecha fecha actual<br>";
											echo "$sigla_de numero de sigla<br>";
											echo "$cod_para numero para sigla<br>";
											echo "$val<br>";
											echo "$asociar asociar<br>";
											
								/*mysql_query(" INSERT INTO `registrodoc1` (`registrodoc1_id`,  `registrodoc1_n_h_r`, `registrodoc1_hoja_ruta`, `registrodoc1_tipo`, `registrodoc1_cite`, `registrodoc1_referencia`, `registrodoc1_doc`, `registrodoc1_n_doc`, `registrodoc1_depto`, `registrodoc1_de`, `registrodoc1_para`, `registrodoc1_depto_para`, `registrodoc1_estado`, `registrodoc1_situacion`, `registrodoc1_fecha_elaboracion`, `registrodoc1_fecha_recepcion`, `registrodoc1_n_hojas`, `registrodoc1_prioridad`, `registrodoc1_respuesta`, `registrodoc1_gestion`, `registrodoc1_n_adjunto`, `registrodoc1_descrip_adj`, `registrodoc1_nom_arch_adj`, `registrodoc1_asociar`, `registrodoc1_asociar_h_r`, `registrodoc1_cc`) VALUES ($v_m_id,0,'0','INTERNO','$cite','$ref','$sigla_doc',$id_fact,'$depto','$codigo',$row_cont[temp1_cod_para],'$cod_dept_para','SR','P','$fecha','0000-00-00 00:00:00',0,'M','NO',$ges,0,'NULL','NULL','$val','$asoc', 'NE')",$conn);*/
						
								mysql_query(" INSERT INTO `registrodoc1` (`registrodoc1_id`,  `registrodoc1_n_h_r`, `registrodoc1_hoja_ruta`, `registrodoc1_tipo`, `registrodoc1_cite`, `registrodoc1_referencia`, `registrodoc1_doc`, `registrodoc1_n_doc`, `registrodoc1_depto`, `registrodoc1_de`, `registrodoc1_para`, `registrodoc1_depto_para`, `registrodoc1_estado`, `registrodoc1_situacion`, `registrodoc1_fecha_elaboracion`, `registrodoc1_fecha_recepcion`, `registrodoc1_n_hojas`, `registrodoc1_prioridad`, `registrodoc1_respuesta`, `registrodoc1_gestion`, `registrodoc1_n_adjunto`, `registrodoc1_descrip_adj`, `registrodoc1_nom_arch_adj`, `registrodoc1_asociar`, `registrodoc1_asociar_h_r`, `registrodoc1_cc`) VALUES ($v_m_id,$id_fact1,'$hr','INTERNO','$cite','$ref','$sigla_doc',$id_fact,'$depto','$codigo',$row_cont[temp1_cod_para],'$cod_dept_para','SR','P','$fecha','0000-00-00 00:00:00',0,'M','NO',$ges,0,'NULL','NULL','$val','$asoc', 'NE')",$conn);
								
								$v_m_id=$v_m_id+1;
								
								}
								mysql_query("DELETE FROM temp1 WHERE temp1_cod_mio='$codigo'",$conn);
								//echo 'El número de registros de la tabla es: '.$contar.'';
						}
					}
					
				}//fin de doc_para=''
					
			  }
			else
			{
				if($tipo_doc=='22')	
				{
					/*
					echo "*******************<br>";
					echo "$tipo_doc documeto<br>";
					echo "$doc_para documrnto ara<br>";
					echo "$nom nombreee<br>";
					echo "$ref refrencia<br>";
					echo "$cite numero de cite<br>";
					echo "$fecha fecha actual<br>";
					echo "$sigla_de numero de sigla<br>";
					echo "$sigla_para numero para sigla<br>";
					echo "$val<br>";
					echo "$asociar asociar<br>";
					*/
					
					$qmr = "select max(registrodoc1_id)from registrodoc1";
					$rqmr = mysql_query($qmr,$conn);
					$reqmr = mysql_fetch_array($rqmr);			
					$v_m_id=$reqmr[0]+1;/*obtiene el maximmo del id del documento 2*/	
					
					/*$query1 = "select max(registrodoc1_n_h_r)from registrodoc1";
					$result1 = mysql_query($query1,$conn);
					$record1 = mysql_fetch_array($result1);			
					$id_fact1=$record1[0]+1;/*obtiene el maximmo del id del documento 2*/		
					/*$hr=$sigla_de.'-'.$id_fact1.'-'.$sigla_para;	*/
					
					if($hrasdoc!='' || $val=='si')
					{
					$query1 = "select registrodoc1_n_h_r from registrodoc1 where registrodoc1_hoja_ruta='$hrasdoc'";
					$result1 = mysql_query($query1,$conn);
					$record1 = mysql_fetch_array($result1);	
					$id_fact1=$record1[0];/*obtiene el maximmo de la hoja de ruta del documento 2*/	
					$hr=$hrasdoc2;
					}
					else
					{
					$query1 = "select max(registrodoc1_n_h_r)from registrodoc1";
					$result1 = mysql_query($query1,$conn);
					$record1 = mysql_fetch_array($result1);	
					/*$id_fact1=$record1[0]+1;/*obtiene el maximmo de la hoja de ruta del documento 2*/	
					/*$hr=$sigla_de.'-'.$id_fact1.'-'.$sigla_para;*/
					$id_fact1=0;/*obtiene el maximmo de la hoja de ruta del documento 2*/	
					$hr=0;
					}
					
					echo "$v_m_id<br>";
					echo "$id_fact1<br>";
					echo "$hr<br>";
					
					$rdoc=mysql_query("SELECT * from documentos 
										where documentos_id='$tipo_doc'",$conn);
					$rpd=mysql_fetch_array($rdoc);
					$sigla_doc=$rpd["documentos_sigla"];
					
					$qmr = "select max(registrodoc1_id)from registrodoc1";
					$rqmr = mysql_query($qmr,$conn);
					$reqmr = mysql_fetch_array($rqmr);			
					$v_m_id=$reqmr[0]+1;/*obtiene el maximmo del id del documento 2*/	
					
					$query = "select max(registrodoc1_n_doc)from registrodoc1 where registrodoc1_doc='$sigla_doc' and registrodoc1_depto='$depto'";
					$result = mysql_query($query,$conn);
					$record = mysql_fetch_array($result);			
					$id_fact=$record[0]+1;/*obtiene el maximmo de ls hoja de ruta del documento*/
					
					echo "$id_fact<br>";
					
					if($val=='si'){$asoc=$hrasdoc2;}
					else $asoc='NULL';
					
					echo "$asoc";
					
					$sqlcont = "SELECT * FROM temp2 WHERE temp2_cod_mio='$codigo'";
					$rs_cont = mysql_query($sqlcont, $conn);
					while ($row_cont = mysql_fetch_array($rs_cont)) 
					{ 	
						$cod_para=$row_cont['temp2_cod_para'];
						$dpt_para1=$row_cont['temp2_x1'];
								
						/*mysql_query(" INSERT INTO `registrodoc1` (`registrodoc1_id`,  `registrodoc1_n_h_r`, `registrodoc1_hoja_ruta`, `registrodoc1_tipo`, `registrodoc1_cite`, `registrodoc1_referencia`, `registrodoc1_doc`, `registrodoc1_n_doc`, `registrodoc1_depto`, `registrodoc1_de`, `registrodoc1_para`, `registrodoc1_depto_para`, `registrodoc1_estado`, `registrodoc1_situacion`, `registrodoc1_fecha_elaboracion`, `registrodoc1_fecha_recepcion`, `registrodoc1_n_hojas`, `registrodoc1_prioridad`, `registrodoc1_respuesta`, `registrodoc1_gestion`, `registrodoc1_n_adjunto`, `registrodoc1_descrip_adj`, `registrodoc1_nom_arch_adj`, `registrodoc1_asociar`, `registrodoc1_asociar_h_r`, `registrodoc1_cc`) VALUES ($v_m_id,0,'0','INTERNO','$cite','$ref','$sigla_doc',$id_fact,'$depto','$cod_para',$doc_para,'$dpt_para1','SR','P','$fecha','0000-00-00 00:00:00',0,'M','NO',$ges,0,'NULL','NULL','$val','$asoc', 'NE')",$conn);*/
						
						mysql_query(" INSERT INTO `registrodoc1` (`registrodoc1_id`,  `registrodoc1_n_h_r`, `registrodoc1_hoja_ruta`, `registrodoc1_tipo`, `registrodoc1_cite`, `registrodoc1_referencia`, `registrodoc1_doc`, `registrodoc1_n_doc`, `registrodoc1_depto`, `registrodoc1_de`, `registrodoc1_para`, `registrodoc1_depto_para`, `registrodoc1_estado`, `registrodoc1_situacion`, `registrodoc1_fecha_elaboracion`, `registrodoc1_fecha_recepcion`, `registrodoc1_n_hojas`, `registrodoc1_prioridad`, `registrodoc1_respuesta`, `registrodoc1_gestion`, `registrodoc1_n_adjunto`, `registrodoc1_descrip_adj`, `registrodoc1_nom_arch_adj`, `registrodoc1_asociar`, `registrodoc1_asociar_h_r`, `registrodoc1_cc`) VALUES ($v_m_id,$id_fact1,'$hr','INTERNO','$cite','$ref','$sigla_doc',$id_fact,'$depto','$cod_para',$doc_para,'$dpt_para1','SR','P','$fecha','0000-00-00 00:00:00',0,'M','NO',$ges,0,'NULL','NULL','$val','$asoc', 'NE')",$conn);
								
						$v_m_id=$v_m_id+1;
								
					}
					mysql_query("DELETE FROM temp2 WHERE temp2_cod_mio='$codigo'",$conn);
									
				}	
				else
				{				
					/*
					echo "*******************<br>";
					echo "$tipo_doc documeto<br>";
					echo "$doc_para documrnto ara<br>";
					echo "$nom nombreee<br>";
					echo "$ref refrencia<br>";
					echo "$cite numero de cite<br>";
					echo "$fecha fecha actual<br>";
					echo "$sigla_de numero de sigla<br>";
					echo "$sigla_para numero para sigla<br>";
					echo "$val<br>";
					echo "$asociar asociar<br>";
					*/
					
					if($tipo_doc=='8' || $tipo_doc=='13' || $tipo_doc=='42' || $tipo_doc=='43' || $tipo_doc=='44')
					{
					
					$qmpara=mysql_fetch_array(mysql_query("select cargos_cod_depto from cargos where cargos_id='$doc_para'",$conn));
					
					$qmr = "select max(registrodoc1_id)from registrodoc1";
					$rqmr = mysql_query($qmr,$conn);
					$reqmr = mysql_fetch_array($rqmr);			
					$v_m_id=$reqmr[0]+1;/*obtiene el maximmo del id del documento 2*/	
					
					/*$query1 = "select max(registrodoc1_n_h_r)from registrodoc1";
					$result1 = mysql_query($query1,$conn);
					$record1 = mysql_fetch_array($result1);			
					$id_fact1=$record1[0]+1;/*obtiene el maximmo del id del documento 2*/		
					/*$hr=$sigla_de.'-'.$id_fact1.'-'.$sigla_para;	*/
					
					if($hrasdoc!='' || $val=='si')
					{
					$query1 = "select registrodoc1_n_h_r from registrodoc1 where registrodoc1_hoja_ruta='$hrasdoc'";
					$result1 = mysql_query($query1,$conn);
					$record1 = mysql_fetch_array($result1);	
					$id_fact1=$record1[0];/*obtiene el maximmo de la hoja de ruta del documento 2*/	
					$hr=$hrasdoc2;
					}
					else
					{
					$query1 = "select max(registrodoc1_n_h_r)from registrodoc1";
					$result1 = mysql_query($query1,$conn);
					$record1 = mysql_fetch_array($result1);	
					$id_fact1=$record1[0]+1;/*obtiene el maximmo de la hoja de ruta del documento 2*/	
					//$hr=$sigla_de.'-'.$id_fact1.'-'.$sigla_para;
					/*
					habilita hoja de ruta 
					*/
					  if($tipo_doc=='13')
					  {
						$hr=$sigla_de.'-'.$id_fact1.'-'.$sigla_para;
					  }
					   else
					  {
					    $hr=0;
					  }
					
					}
					
					echo "$v_m_id<br>";
					echo "$id_fact1<br>";
					echo "$hr<br>";
					
					$rdoc=mysql_query("SELECT * from documentos 
										where documentos_id='$tipo_doc'",$conn);
					$rpd=mysql_fetch_array($rdoc);
					$sigla_doc=$rpd["documentos_sigla"];
					
					$qmr = "select max(registrodoc1_id)from registrodoc1";
					$rqmr = mysql_query($qmr,$conn);
					$reqmr = mysql_fetch_array($rqmr);			
					$v_m_id=$reqmr[0]+1;/*obtiene el maximmo del id del documento 2*/	
					
					$query = "select max(registrodoc1_n_doc)from registrodoc1 where registrodoc1_doc='$sigla_doc' and registrodoc1_depto='$depto'";
					$result = mysql_query($query,$conn);
					$record = mysql_fetch_array($result);			
					$id_fact=$record[0]+1;/*obtiene el maximmo de ls hoja de ruta del documento*/
					
					echo "$id_fact<br>";
					
					if($val=='si'){$asoc=$hrasdoc2;}
					else $asoc='NULL';
					
					echo "$asoc";
					
					/*$insertar=" INSERT INTO `registrodoc1` (`registrodoc1_id`, `registrodoc1_n_h_r`, `registrodoc1_hoja_ruta`, `registrodoc1_tipo`, `registrodoc1_cite`, `registrodoc1_referencia`, `registrodoc1_doc`, `registrodoc1_n_doc`, `registrodoc1_depto`, `registrodoc1_de`, `registrodoc1_para`, `registrodoc1_depto_para`, `registrodoc1_estado`, `registrodoc1_situacion`, `registrodoc1_fecha_elaboracion`, `registrodoc1_fecha_recepcion`, `registrodoc1_n_hojas`, `registrodoc1_prioridad`, `registrodoc1_respuesta`, `registrodoc1_gestion`, `registrodoc1_n_adjunto`, `registrodoc1_descrip_adj`, `registrodoc1_nom_arch_adj`, `registrodoc1_asociar`, `registrodoc1_asociar_h_r`, `registrodoc1_cc`) VALUES ($v_m_id,0,'0','INTERNO','$cite','$ref','$sigla_doc',$id_fact,'$depto','$codigo',$doc_para,'$qmpara[0]','SR','P','$fecha','0000-00-00 00:00:00',0,'M','NO',$ges,0,'NULL','NULL','$val','$asoc', 'NE')";*/
					
					$insertar=" INSERT INTO `registrodoc1` (`registrodoc1_id`, `registrodoc1_n_h_r`, `registrodoc1_hoja_ruta`, `registrodoc1_tipo`, `registrodoc1_cite`, `registrodoc1_referencia`, `registrodoc1_doc`, `registrodoc1_n_doc`, `registrodoc1_depto`, `registrodoc1_de`, `registrodoc1_para`, `registrodoc1_depto_para`, `registrodoc1_estado`, `registrodoc1_situacion`, `registrodoc1_fecha_elaboracion`, `registrodoc1_fecha_recepcion`, `registrodoc1_n_hojas`, `registrodoc1_prioridad`, `registrodoc1_respuesta`, `registrodoc1_gestion`, `registrodoc1_n_adjunto`, `registrodoc1_descrip_adj`, `registrodoc1_nom_arch_adj`, `registrodoc1_asociar`, `registrodoc1_asociar_h_r`, `registrodoc1_cc`) VALUES ($v_m_id,$id_fact1,'$hr','INTERNO','$cite','$ref','$sigla_doc',$id_fact,'$depto','$codigo',$doc_para,'$qmpara[0]','SR','P','$fecha','0000-00-00 00:00:00',0,'M','NO',$ges,0,'NULL','NULL','$val','$asoc', 'NE')";
					
					$resul = mysql_query($insertar,$conn);
					
					}
					else
					{
					
					$qmpara=mysql_fetch_array(mysql_query("select cargos_cod_depto from cargos where cargos_id='$doc_para'",$conn));
					
					$qmr = "select max(registrodoc1_id)from registrodoc1";
					$rqmr = mysql_query($qmr,$conn);
					$reqmr = mysql_fetch_array($rqmr);			
					$v_m_id=$reqmr[0]+1;/*obtiene el maximmo del id del documento 2*/	
					
					/*$query1 = "select max(registrodoc1_n_h_r)from registrodoc1";
					$result1 = mysql_query($query1,$conn);
					$record1 = mysql_fetch_array($result1);			
					$id_fact1=$record1[0]+1;/*obtiene el maximmo del id del documento 2*/		
					/*$hr=$sigla_de.'-'.$id_fact1.'-'.$sigla_para;	*/
					
					if($hrasdoc!='' || $val=='si')
					{
					$query1 = "select registrodoc1_n_h_r from registrodoc1 where registrodoc1_hoja_ruta='$hrasdoc'";
					$result1 = mysql_query($query1,$conn);
					$record1 = mysql_fetch_array($result1);	
					$id_fact1=$record1[0];/*obtiene el maximmo de la hoja de ruta del documento 2*/	
					$hr=$hrasdoc2;
					}
					else
					{
					$query1 = "select max(registrodoc1_n_h_r)from registrodoc1";
					$result1 = mysql_query($query1,$conn);
					$record1 = mysql_fetch_array($result1);	
					$id_fact1=0;/*obtiene el maximmo de la hoja de ruta del documento 2*/	
					$hr=0;
					/*$id_fact1=$record1[0]+1;/*obtiene el maximmo de la hoja de ruta del documento 2*/	
					/*$hr=$sigla_de.'-'.$id_fact1.'-'.$sigla_para;*/
					}
					
					echo "$v_m_id<br>";
					echo "$id_fact1<br>";
					echo "$hr<br>";
					
					$rdoc=mysql_query("SELECT * from documentos 
										where documentos_id='$tipo_doc'",$conn);
					$rpd=mysql_fetch_array($rdoc);
					$sigla_doc=$rpd["documentos_sigla"];
					
					$qmr = "select max(registrodoc1_id)from registrodoc1";
					$rqmr = mysql_query($qmr,$conn);
					$reqmr = mysql_fetch_array($rqmr);			
					$v_m_id=$reqmr[0]+1;/*obtiene el maximmo del id del documento 2*/	
					
					$query = "select max(registrodoc1_n_doc)from registrodoc1 where registrodoc1_doc='$sigla_doc' and registrodoc1_depto='$depto'";
					$result = mysql_query($query,$conn);
					$record = mysql_fetch_array($result);			
					$id_fact=$record[0]+1;/*obtiene el maximmo de ls hoja de ruta del documento*/
					
					echo "$id_fact<br>";
					
					if($val=='si'){$asoc=$hrasdoc2;}
					else $asoc='NULL';
					
					echo "$asoc";
					
					/*$insertar=" INSERT INTO `registrodoc1` (`registrodoc1_id`, `registrodoc1_n_h_r`, `registrodoc1_hoja_ruta`, `registrodoc1_tipo`, `registrodoc1_cite`, `registrodoc1_referencia`, `registrodoc1_doc`, `registrodoc1_n_doc`, `registrodoc1_depto`, `registrodoc1_de`, `registrodoc1_para`, `registrodoc1_depto_para`, `registrodoc1_estado`, `registrodoc1_situacion`, `registrodoc1_fecha_elaboracion`, `registrodoc1_fecha_recepcion`, `registrodoc1_n_hojas`, `registrodoc1_prioridad`, `registrodoc1_respuesta`, `registrodoc1_gestion`, `registrodoc1_n_adjunto`, `registrodoc1_descrip_adj`, `registrodoc1_nom_arch_adj`, `registrodoc1_asociar`, `registrodoc1_asociar_h_r`, `registrodoc1_cc`) VALUES ($v_m_id,0,'0','INTERNO','$cite','$ref','$sigla_doc',$id_fact,'$depto','$codigo',$doc_para,'$qmpara[0]','SR','P','$fecha','0000-00-00 00:00:00',0,'M','NO',$ges,0,'NULL','NULL','$val','$asoc', 'NE')";*/
					
					$insertar=" INSERT INTO `registrodoc1` (`registrodoc1_id`, `registrodoc1_n_h_r`, `registrodoc1_hoja_ruta`, `registrodoc1_tipo`, `registrodoc1_cite`, `registrodoc1_referencia`, `registrodoc1_doc`, `registrodoc1_n_doc`, `registrodoc1_depto`, `registrodoc1_de`, `registrodoc1_para`, `registrodoc1_depto_para`, `registrodoc1_estado`, `registrodoc1_situacion`, `registrodoc1_fecha_elaboracion`, `registrodoc1_fecha_recepcion`, `registrodoc1_n_hojas`, `registrodoc1_prioridad`, `registrodoc1_respuesta`, `registrodoc1_gestion`, `registrodoc1_n_adjunto`, `registrodoc1_descrip_adj`, `registrodoc1_nom_arch_adj`, `registrodoc1_asociar`, `registrodoc1_asociar_h_r`, `registrodoc1_cc`) VALUES ($v_m_id,$id_fact1,'$hr','INTERNO','$cite','$ref','$sigla_doc',$id_fact,'$depto','$codigo',$doc_para,'$qmpara[0]','SR','P','$fecha','0000-00-00 00:00:00',0,'M','NO',$ges,0,'NULL','NULL','$val','$asoc', 'NE')";
					
					$resul = mysql_query($insertar,$conn);
					}				
				}
				
			}  
			  
		}//fin de else de ref==''
		?>
					<script language="JavaScript">
					window.self.location="listado_de_mi2.php";
					</script>
		<?php

	}//fin de else 	/*********************/
}//fin de FINALIZAR
?>
<br />

<form action="" method="post">

<input type="hidden" name="tipo_doc" value="<?=$tipo_doc;?>" />
<input type="hidden" name="doc_para" value="<?=$doc_para;?>" />
<input type="hidden" name="cod_depto_pa" value="<?=$dept_para;?>" />
<input type="hidden" name="ref" value="<?=$ref;?>" />
<input type="hidden" name="cite" value="<?=$cite;?>" />
<input type="hidden" name="fecha" value="<?=$fecha;?>" />
<input type="hidden" name="sigl_de1" value="<?=$r_usu_de1;?>" />
<input type="hidden" name="sigl_para1" value="<?=$r_usu_para1;?>" />
<input type="hidden" name="asoci" value="<?=$asoc;?>" />

<?php 

?>
<table width="696" height="146" border="0" align="center" cellpadding="1" style="font-size: 8pt" >
  <tr class="border_tr3">
    <td align="center" style="font-size:15px" bgcolor="#3E6BA3"><strong style="color:#FFFFFF">CITE CREADO CORRECTAMENTE </strong></div></td>
  </tr>
  <tr class="border_tr3">
    <td align="center" style="font-size:13px"><strong>Fecha de CITE: <?php echo $fecha;?></strong></div></td>
  </tr>
  <?php
  if($tipo_doc=='17' || $tipo_doc=='18' || $tipo_doc=='25' || $tipo_doc=='26' || $tipo_doc=='27' || $tipo_doc=='28' || $tipo_doc=='29' || $tipo_doc=='30' || $tipo_doc=='31' || $tipo_doc=='32' || $tipo_doc=='33')
	 {
	 
	 ?>  
	  <tr class="border_tr3">
		<td><div align="center"></div></td>
	  </tr>
	  <tr class="border_tr3">
		<td align="center" style="font-size:13px"><strong><?php echo $rpd["documentos_descripcion"];?> </strong></div></td>
	  </tr>
	  <tr class="border_tr3">
		<td align="center" style="font-size:15px"><strong>No <?php echo $cite;?> </strong></div></td>
	  </tr>
	  </table>
	  <table width="703" height="153" border="0" align="center" cellpadding="1" style="font-size: 8pt;" class="border_tr3">
	  <?php 
	  if($val=='si')
	  {
	  ?>
		  <tr>
			<td colspan="3"><strong>Documento Asociado a Hoja de Ruta No:  </strong> 
			<strong style=" color:#003366; font-size:16px"><?php echo " $hrasdoc"; ?> </strong></td>
		  </tr>
		<?php
		}//fin de if
	}
  else
	{
	?> 
	  <tr class="border_tr3">
		<td><div align="center"></div></td>
	  </tr>
	  <tr class="border_tr3">
		<td align="center" style="font-size:13px"><strong><?php echo $rpd["documentos_descripcion"];?></strong></div></td>
	  </tr>
	  <tr class="border_tr3">
		<td align="center" style="font-size:15px"><strong>No CITE: <?php echo $cite;?></strong></div></td>
	  </tr>
	</table>
	<br />
	<table width="703" height="153" border="0" align="center" cellpadding="1" style="font-size: 8pt;" class="border_tr3">
	 <tr>
		<td><strong>A:</strong></td>	
		<?php 
		if($tipo_doc=='6' || $tipo_doc=='7' || $tipo_doc=='19' || $tipo_doc=='34' || $tipo_doc=='35' || $tipo_doc=='36' || $tipo_doc=='39')
		{
		?>
		<td>
		<?php
		$res=mysql_query("select * from temp1 where temp1_cod_mio='$codigo' order by temp1_nom",$conn);
		?>
			<table border="0" cellpadding="1" cellspacing="5">
			<?php
			while($row=mysql_fetch_array($res))
			{
			?>
			<tr style="font-size:9px" class="border_tr3">	
				<td><?php echo "$row[2]"; ?></td>
				<td><?php echo "$row[3]"; ?></td>
			</tr>
			<?php
			}
			?>
			</table>
		</td>
		<td>&nbsp;</td>
		</tr>
		<?php 
		}
		else
		{
		
		?>
		
		<td><?php echo "$nom_para";?></td>
		<td>&nbsp;</td>
	  </tr>
	  <tr>
		<td>&nbsp;</td>    
		<td><strong><?php echo "$cargo_para";?></strong></td>	
		<td>&nbsp;</td>
	  </tr>
		<?php
		}
		?>	  
	  <tr>
		<td>&nbsp;</td>
		<td>&nbsp;</td>
		<td>&nbsp;</td>
	  </tr>
		<?php
		if($tipo_doc=='22')
		{
		?>
		<tr>
		<td><strong>DE:</strong></td>
		<td>
		<?php
		$res=mysql_query("select * from temp2 where temp2_cod_mio='$codigo' order by temp2_nom",$conn);
		?>
			<table border="0" cellpadding="1" cellspacing="5">
			<?php
			while($row=mysql_fetch_array($res))
			{
			?>
			<tr style="font-size:9px" class="border_tr3">	
				<td><?php echo "$row[2]"; ?></td>
				<td><?php echo "$row[3]"; ?></td>
			</tr>
			<?php
			}
			?>
			</table>
		</td>
		<td>&nbsp;</td>
		</tr>
		<?php
		}
		else
		{
		?>
	   <tr>
		<td><strong>DE:</strong></td>
		<td><?php echo "$nom_de";?> </td>
		<td>&nbsp;</td>
	  </tr>
	  <tr>
		<td>&nbsp;</td>
		<td><strong><?php echo "$cargo_de";?></strong></td>
		<td>&nbsp;</td>
	  </tr>
		<?php
		}
		?>	  
	  <tr>
		<td>&nbsp;</td>
		<td>&nbsp;</td>
		<td>&nbsp;</td>
	  </tr>
	  <tr>
		<td><strong>Ref.:</strong></td>
		<td><strong><?php echo "$ref";?></strong></td>
		<td>&nbsp;</td>
	  </tr>
	  
	  <tr>
		<td>&nbsp;</td>
		<td>&nbsp;</td>
		<td>&nbsp;</td>
	  </tr>
		  
	<?php 
	  if($val=='si')
	  {
	  ?>
		  <tr>
			<td colspan="3"><strong>Documento Asociado a Hoja de Ruta No:  </strong> 
			<strong style=" color:#003366; font-size:16px"><?php echo " $hrasdoc2"; ?> </strong></td>
		  </tr>
		<?php
		}//fin de if
	}
  	?>    
  <tr>
    <td align="center" colspan="3">
                <br />
				<input style="font-size:10px; color:blue;" type="submit" name="finalizar" value="Guardar"/>
				<input style="font-size:10px; color:blue;" type="submit" name="cancelar" value="Cancelar" />  
               
     </td>
   </tr>
</table>

</form>
<br />
<br />
<?php
include("final.php");
?>

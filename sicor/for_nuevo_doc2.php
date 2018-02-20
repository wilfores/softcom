<?php
include("../filtro.php");
?>
<?php
include("inicio.php");
include("script/functions.inc");
include("script/cifrar.php");
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

$codigo=$_SESSION["cargo_asignado"];
$depto=$_SESSION["departamento"];

$hrasdoc=descifrar($_GET['hr1']);
//echo "$hrasdoc";

?>
<link rel="stylesheet" href="jquery.mobile-1.0.min.css" /> 
<script src="jquery-1.7.1.min.js"></script>
<script src="jquery.mobile-1.0.min.js"></script>

<script language="JavaScript">
function Abre_ventana (pagina)
{
     ventana=window.open(pagina,"Asignar","toolbar=no,location=0,directories=no,status=no,menubar=no,scrollbars=yes,resizable=yes,width=700,height=400");
}
function Retornar(){
	document.ingreso.action="menu2.php";
	document.ingreso.submit();
}
</script>

<script languaje="javascript">

function habilita(form)
{ 
form.intereses[0].disabled = false;
}

function deshabilita(form)
{ 
form.intereses[0].disabled = true;
}
</script>



<?php 
if(isset($_POST['crear']))
{
    if(empty($_POST['tipo_doc']))
	{
	  $error=1;
	  $alert_tipo_doc=1;
  	}
	
	/*if(empty($_POST['tema']))
	{
	  $error=1;
	  $alert_tema=1;
  	}*/
	
	if($error==0)
	{
	$_SESSION["documento"]=$_POST['tipo_doc'];
	$_SESSION["ref"]=$_POST['tema'];
	$_SESSION["para"]=$_POST['doc_para'];
	//$_SESSION["depto_para"]=$_POST['dept_para'];
	//$_SESSION["asoc"]=$_POST['asociar'];
	$_SESSION["valor"]=$_POST['val1'];
	//$_SESSION["ndbc"]=$_POST['coanpe'];
	$_SESSION["hrasd"]=$_POST['hrasdoc'];
	
	
?>
	<script>
        window.self.location="genera_cite1.php";
	</script>
<?php
   }
}	
?>
<br>
<p class="fuente_titulo">
<center><b></b></center></p>
</center>
<form action="" method="post" name="crear">
<!--<form action="genera_cite.php" method="post" name="crear">-->
<table width="693" height="290" border="0" align="center" cellspacing="3" cellpadding="3" class="border_tr3">
  <tr class="border_tr3">
    <td colspan="3" align="center" bgcolor="#3E6BA3"><strong style="color:#FFFFFF; font-size:15px">NUEVO DOCUMENTO</strong></td>
  </tr>
  <tr class="border_tr3">
    <td colspan="3" ><strong>1) Tipo de Correspondencia</strong></td>
  </tr>
  <tr class="border_tr3">
    <td width="102"></td>
    <td width="160"><strong>Tipo de Documento: </strong></td>
    <td width="409" style="font-size:10; color:#333333">
	<select name="tipo_doc" style="font-size:9px" onchange="this.form.submit()">
      <option value="">Selecione el Tipo de Documento</option>
      <?php
		$respss=mysql_query("select documentocargo_doc, documentos_descripcion, documentos_sigla 
								from documentocargo, documentos 
								where documentocargo_cargo='$codigo'
								and documentocargo_doc=documentos_id 
								order by documentos_descripcion",$conn);
		while($rowass=mysql_fetch_array($respss))
		{
			/*?>
			<option value=<?php echo $rowass["documentocargo_doc"];?> selected><?php echo $rowass["documentos_descripcion"];?></option>
			<?php
			*/
			if($_POST['tipo_doc']==$rowass["documentocargo_doc"])
			{
			?>
      <option value="<?=$rowass['documentocargo_doc'];?>" selected>
      <?php
					echo $rowass["documentos_descripcion"];
					?>
      </option>
      <?php 
			}
			else
			{
				?>
      <option value="<?=$rowass['documentocargo_doc'];?>">
      <?php
					echo $rowass["documentos_descripcion"];
				?>
      </option>
      <?php
			}//fin de else
					 
			
		}//fin de while

			?>
    </select>
    <?php Alert($alert_tipo_doc); ?>	</td>
  </tr>
  
  <?php

if($_POST['tipo_doc']=='17' || $_POST['tipo_doc']=='18' || $_POST['tipo_doc']=='25' || $_POST['tipo_doc']=='26' || $_POST['tipo_doc']=='27' || $_POST['tipo_doc']=='28' || $_POST['tipo_doc']=='29' || $_POST['tipo_doc']=='30' || $_POST['tipo_doc']=='31' || $_POST['tipo_doc']=='32' || $_POST['tipo_doc']=='33' || $_POST['tipo_doc']=='10' || $_POST['tipo_doc']=='47')
{
	/*
	if($_POST['tipo_doc']=='25' || $_POST['tipo_doc']=='26' || $_POST['tipo_doc']=='27' || $_POST['tipo_doc']=='28')
	{
	  ?>
	  <tr class="border_tr3">
		<td><strong>ANPE</strong></td>
		<td colspan="2">
		<input name="coanpe" type="checkbox" value="anpe1" />Bienes
		<input name="coanpe" type="checkbox" value="anpe2" />Medicamentos
		<input name="coanpe" type="checkbox" value="anpe3" />Consultoria
		<input name="coanpe" type="checkbox" value="anpe4" />Servicios
		</td>
	  </tr>	  
	  <tr class="border_tr3">
		<td><strong>LICITACION PUBLICA</strong></td>
		<td colspan="2">
		<input name="coanpe" type="checkbox" value="lp1" />Bienes
		<input name="coanpe" type="checkbox" value="lp2" />Medicamentos
		<input name="coanpe" type="checkbox" value="lp3" />Consultoria
		<input name="coanpe" type="checkbox" value="lp4" />Servicios
		</td>
	  </tr> 
	  <tr class="border_tr3">
		<td><strong>CONTRATACION DIRECTA</strong>
		</td>
		<td colspan="2">
		<input name="coanpe" type="checkbox" value="cdirect" />
		</td>
		
	  </tr> 
	 <?	
	}*/
		if($_POST['tipo_doc']=='10' || $_POST['tipo_doc']=='47')
		{
			?>
		  <tr class="border_tr3">
			<td colspan="3"><strong>2) Detalle</strong></td>
		  </tr>
		  <tr class="border_tr3">
			<td height="84">&nbsp;</td>
			<td ><strong>Referencia:</strong></td>
			<td><textarea name="tema" rows="3" cols="50"></textarea>
			<?php Alert($alert_tema);?>
			</td>
		  </tr>
		  <tr class="border_tr3">
			<td colspan="3">&nbsp;</td>
		  </tr>  
		  <?php if($hrasdoc!='') { ?>
		  <tr class="border_tr3">
			<td colspan="3"><strong>3) Asociado a Hoja de Ruta</strong></td>
		  </tr>
		  <tr class="border_tr3">
			<td height="20">&nbsp;</td>
			<td ><strong>Documento Asociado a Hoja de Ruta No:</strong></td>
			<td style=" color:#003366; font-size:16px">
			<strong>
			<input type="hidden" name="val1" value="si" />
			<input type="hidden" name="hrasdoc" value="<?=$hrasdoc;?>"/>
			<?php echo "$hrasdoc";?></strong>
			</td>
		  </tr>	   
			   <?php 
			   }		
		
		}
		else
		{
		
			?>
	  <tr class="border_tr3">
		<td colspan="3">&nbsp;</td>
	  </tr>  
	  <?php if($hrasdoc!='') { ?>
	  <tr class="border_tr3">
		<td colspan="3"><strong>2) Asociado a Hoja de Ruta</strong></td>
	  </tr>
	  <tr class="border_tr3">
		<td height="20">&nbsp;</td>
		<td ><strong>Documento Asociado a Hoja de Ruta No:</strong></td>
		<td style=" color:#003366; font-size:16px">
		<strong>
		<input type="hidden" name="val1" value="si" />
		<input type="hidden" name="hrasdoc" value="<?=$hrasdoc;?>"/>
		<?php echo "$hrasdoc";?></strong>
		</td>
	  </tr>	   
		   <?php 
		   }
		
		}

}
else
{

  if($_POST['tipo_doc']=='6' || $_POST['tipo_doc']=='7' || $_POST['tipo_doc']=='19' || $_POST['tipo_doc']=='34' || $_POST['tipo_doc']=='35' || $_POST['tipo_doc']=='36' || $_POST['tipo_doc']=='39')
  { 
   ?>
   
  <tr class="border_tr3">
    <td colspan="3"><strong>2) Destinatario</strong></td>
  </tr> 
  <tr class="border_tr3">
    <td height="84">&nbsp;</td>
    <td ><strong>Para:</strong></td>
    <td>	
	<a href="javascript:Abre_ventana('listado_usuarios.php')">
		<img src="images/puntos1.gif">
	</a>
	
	<iframe  height="150" width="400" frameborder="1" name="mainFrame" src="listado_escogidos.php" class="barrades">
    </iframe>		    
    <?php Alert($alert_ent);?>	
	
	 </td>
  </tr>
  
  <?php
  }
  else
  {
  ?>
  <tr class="border_tr3">
    <td colspan="3"><strong>2) Destinatario</strong></td>
  </tr> 
  <tr class="border_tr3">
    <td>&nbsp;</td>
    <td><strong>Cargo y Nombre del Funcionario:</strong> </td> 
	<td>	
	<select name="doc_para" style="font-size:9px">
		<option value="">Dirigido a:</option>
		<?php
		$rpara=mysql_query("select a.`asignar_su_codigo`, u.`usuario_nombre`, c.`cargos_cargo`, c.`cargos_cod_depto`
							from `asignar` a , `cargos` c , `usuario` u
							where
							a.`asignar_mi_codigo`='$codigo'
							and
							a.`asignar_su_codigo`=c.`cargos_id`
							and
							c.`cargos_id`=u.`usuario_ocupacion` order by u.`usuario_nombre`",$conn);
		while($rp=mysql_fetch_array($rpara))
		{
			?>			
			<option value=<?php echo $rp["0"];?> selected><?php echo $rp["1"]; echo ".....("; echo $rp["2"]; echo ")";?></option>
			
			<?php
		}

			?>
	 </select>
	<?php echo $rp["0"];?>
	</td>
  </tr>
  
  <?php
  }
  if($_POST['tipo_doc']=='22')
  {
  ?>
  <tr class="border_tr3">
    <td colspan="3"><strong>3) Comision</strong></td>
  </tr> 
  <tr class="border_tr3">
    <td height="84">&nbsp;</td>
    <td ><strong>De:</strong></td>
    <td>
	<a href="javascript:Abre_ventana('listado_comision.php')">
		<img src="images/puntos1.gif">
	</a>
	<iframe  height="150" width="400" frameborder="1" name="mainFrame" src="listado_esc_comision.php" class="barrades">
    </iframe>		    
    <?php Alert($alert_ent);?>	
	 </td>
  </tr>
  <tr class="border_tr3">
    <td colspan="3"><strong>4) Detalle</strong></td>
  </tr>
  <tr class="border_tr3">
    <td height="84">&nbsp;</td>
    <td ><strong>Referencia:</strong></td>
    <td><textarea name="tema" rows="3" cols="50"></textarea>
	<?php Alert($alert_tema);?>
	</td>
  </tr>
  <?php if($hrasdoc!='') { ?>
  <tr class="border_tr3">
    <td colspan="3"><strong>5) Asociado a Hoja de Ruta</strong></td>
  </tr>
  <tr class="border_tr3">
    <td height="20">&nbsp;</td>
    <td ><strong>Documento Asociado a Hoja de Ruta No:</strong></td>
    <td style=" color:#003366; font-size:16px">
	<strong>
	<input type="hidden" name="val1" value="si" />
	<input type="hidden" name="hrasdoc" value="<?=$hrasdoc;?>"/>
	<?php echo "$hrasdoc";?></strong>
    </td>
  </tr>	   
	   <?php 
	   }
  }
  else
  {
  ?>  
  <tr class="border_tr3">
    <td colspan="3"><strong>3) Detalle</strong></td>
  </tr>
  <tr class="border_tr3">
    <td height="84">&nbsp;</td>
    <td ><strong>Referencia:</strong></td>
    <td><textarea name="tema" rows="3" cols="50"></textarea>
	<?php Alert($alert_tema);?>
	</td>
  </tr>
  <?php if($hrasdoc!='') { ?>
  <tr class="border_tr3">
    <td colspan="3"><strong>4) Asociado a Hoja de Ruta</strong></td>
  </tr>
  <tr class="border_tr3">
    <td height="20">&nbsp;</td>
    <td ><strong>Documento Asociado a Hoja de Ruta No:</strong></td>
    <td style=" color:#003366; font-size:16px">
	<strong>
	<input type="hidden" name="val1" value="si" />
	<input type="hidden" name="hrasdoc" value="<?=$hrasdoc;?>"/>
	<?php echo "$hrasdoc";?></strong>
    </td>
  </tr>	   
	   <?php 
	   }
   }

 }
 ?>

  <tr>
	<td colspan="3" align="center" >
	<input style="font-size:10px; color:blue;" type="submit" value="Crear Cite" name="crear"/>
	</td>
  </tr>
  
</form>
  
 <!--   <tr>
	<td colspan="3" align="center" >
		<A href="impresion_cm_ne.php">
	    <img src='images/word2007.gif' border='0'><span style="font-weight: bold">&nbsp;&nbsp;IMPRIMIR</span>
		</a>
	</td>
  </tr>
		-->
				  
</table>	
<br />
<br />
<?php
include("final.php");
?>


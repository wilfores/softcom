
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

$t=10;
if(!isset($_GET['pagina'])) {
$pagina=1;
$inicio=0;
}
else {
$pagina=$_GET['pagina'];
$inicio=($pagina-1)*$t;
}

?>
<script language="JavaScript">

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
<center><b style=" font-size:18px">LISTADO DE ARCHIVOS GENERADOS</b></center></p></center>
<form name="ingreso" action="for_nuevo_doc2.php" method="POST">
<center>
<!--<input type="reset" name="cancelar" value="Cancelar" onClick="Retornar();" class="boton"/>-->
<input type="submit" name="imprimir" value="Nuevo Documento" class="boton"/>
</form>
<form name="formfiltro" action="listado_de_mi2.php" method="POST">
	Hoja de Ruta: <input type="text" name="h_rut" value="<? echo $h_rut; ?>" >
    &nbsp; &nbsp;
	Nro de cite: <input type="text" name="n_cit" value="<? echo $n_cit; ?>" size=5>
    &nbsp; &nbsp;
	Tipo de Documento: <select name="t_doc">
    <option value="<? echo $t_doc; ?>"><? echo $t_doc; ?></option>
    <?php
		$respss=mysql_query("select documentocargo_doc, documentos_descripcion, documentos_sigla 
								from documentocargo, documentos 
								where documentocargo_cargo='$codigo'
								and documentocargo_doc=documentos_id 
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
    <input type="submit" value="Buscar" class="boton">
    &nbsp; &nbsp;  
    <?php        
	  //  echo "<a href=".$PHP_SELF.">";
//	    echo "<a href='listado_de_mi2.php'>";
	?>
    <input type="button"  value="Ver Todo" class="boton"  onClick="window.location='listado_de_mi2.php'">
	<?php        
        //echo "</a>";
    ?>
</form>
<!--  style="font-size:9px; color:blue;"-->
</center>

<table width="90%" cellspacing="1" cellpadding="1" border="0" align="center">
<tr style="font-size: 8pt; color:#FFFFFF" bgcolor="#3E6BA3">
	<td width="7%" align="center"><span >Hoja Ruta</td>
	<td width="8%" align="center"><span >Fecha Elaboracion</td>
	<td width="15%" align="center"><span >Destinatario</td>
	<td width="20%" align="center"><span >Proveido</td>
	<td width="8%" align="center"><span >Estado</td>	
	<td width="15%" align="center">IMPRIMIR</td>
	
</tr>
<!--<meta content="5;URL=listado_de_mi2.php" http-equiv="REFRESH">-->
<?php
$slista="SELECT derivardoc_hoja_ruta, derivardoc_fec_derivacion, 
		usuario_nombre, derivardoc_proveido, derivardoc_copia_de, 
		derivardoc_situacion, derivardoc_cc, usuario_ocupacion 
		FROM `derivardoc`, `usuario`
		where derivardoc_de = '$codigo' 
		and derivardoc_para = usuario_ocupacion 
		and derivardoc_copia_de != '0' ";

if($h_rut!=""){
$slista = $slista. "and derivardoc_hoja_ruta like '%$h_rut%' ";
}
$slista = $slista. "ORDER BY derivardoc_fec_derivacion DESC";
$rslista=mysql_query($slista,$conn);
$lim_inferior=1;
$lim_superior=1;
$total_paginas = ceil(mysql_num_rows($rslista) / $t);

if (!empty($rslista)) 
{
 $resaltador=0;
 while($rwlista=mysql_fetch_array($rslista))
 {
		 //$valor_vect=$row["libroregistro_cod_registro"];
		if ($lim_inferior>$inicio && $lim_superior<=$t)
		{
		 $doc_arch=cifrar($rwlista["derivardoc_hoja_ruta"]);
		 $doc_arch2=cifrar($rwlista["derivardoc_copia_de"]);
//		 $doc_arch2=cifrar($rwlista["derivardoc_cite"]);
		 $doc_aso=$rwlista["derivardoc_asociar"];
	 
		 if ($resaltador==0)
		  {
		   echo "<tr class=truno>";
		   $resaltador=1;
		  }
		  else
		  {
		   echo "<tr class=trdos>";
		   $resaltador=0;
		  }
 
		?>
		<td align="center"><?php 
		if($rwlista[registrodoc1_asociar]=='si'){echo "<font color=#CC0000>Doc. Asociado $rwlista[registrodoc1_asociar_h_r]";}
		else {echo $rwlista[derivardoc_hoja_ruta];}?>
		</td>
		
		<td align="center"><?php echo $rwlista[derivardoc_fec_derivacion];?>
		</td>
		
		<td align="left"><?php echo $rwlista[usuario_nombre];?>
		</td>
		
		<td align="left"><?php echo $rwlista[derivardoc_proveido]; ?>
		</td>
			
		<?php
		if($rwlista['derivardoc_situacion']=='SR') 
		{$rep='No Recepcionado';?><td align="center" style="color:#990000; font-size:10px"><?php echo "$rep";?></td>
		<?php }
		else {$rep='Recepcionado';?>
		<td align="center" style="font-size:10px"><?php echo "$rep";?></td>
		 <?php }?>
		</td>
		<td align="center">
			<a href="hoja_ruta_doc2.php?hr1=<?php echo $doc_arch;?>&hr2=<?php echo $doc_arch2;?>" onmouseover="window.status='Guia de sitio';return true" onmouseout="window.status='';return true" target="_blank">
				<img src="images/imp_h_r.png" onmouseover="this.src='images/imp_h_r1.png'" onmouseout="this.src='images/imp_h_r.png'">
			</a>
		</td>
		<?
		/*
			if($rwlista['derivardoc_asociar']<>'si')
			{ 
				if($rwlista['documentos_id']==8 or $rwlista['documentos_id']==13)
				{
			?>
			<td align="center">
				<a href="hoja_ruta_doc.php?hr1=<?php echo $doc_arch;?>" onmouseover="window.status='Guia de sitio';return true" onmouseout="window.status='';return true" target="_blank">
				<img src="images/imp_h_r.png" onmouseover="this.src='images/imp_h_r1.png'" onmouseout="this.src='images/imp_h_r.png'">
				</a>
			</td>
			<?
				}
				else
				{
				?>
				<td align="center">
				</td>
				<?
				}
			}
			else
			{
			?>
			<td align="center">
			</td>
			<?
			}
			*/
		
?>
    </tr>
    <?php
        $lim_superior++;
        }//FIN DE IF
    $lim_inferior++;
    }// FIN DE WHILE 
    
}
?>
</table>
</center>
</meta>
<center>
<?php
for ($i=1;$i<=$total_paginas;$i++) 
{
	if ($i!=$pagina) 
	{	$suiguiente=$i;
	//echo "<a href=$PHP_SELF?pagina=$i><font color=#FF6600>$i</font></a> ";
	echo "<a href=$PHP_SELF?pagina=$i&h_rut=$h_rut&t_doc=$t_doc&n_cit=$n_cit><font color=#FF6600>$i</font></a> ";
	}
	else {
	echo " | ".$i." | ";
	}
}

?>
<br>

</center>

<?php
include("final.php");
?>

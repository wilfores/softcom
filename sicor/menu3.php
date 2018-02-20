<?php 
session_start();
include("../filtro.php");
?>
<?php
include("inicio.php");
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
//$codigo=$_SESSION["codigo"];
$codigo=$_SESSION["cargo_asignado"];
$cargo_fun=$_SESSION["cargo_fun"];
$depto=$_SESSION["departamento"];
$car_fun=$_SESSION["cargo"];

//echo "$codigo cargo<br />";
//echo "$car_fun cargo<br />";
//echo "$depto depto";
/*
$tiempo = time();
$cc=date("j", $tiempo);
$bb=date("n", $tiempo);
$aa=date("Y", $tiempo);
$fecha_hoy=$aa."-".$bb."-".$cc;


$ssql = "SELECT * FROM usuario WHERE '$codigo'=usuario_ocupacion";
$rs = mysql_query($ssql, $conn);
if ($row = mysql_fetch_array($rs)) 
{ $nombre=$row["usuario_nombre"];
}

$ssql_c = "SELECT * FROM cargos WHERE '$codigo'=cargos_id";
$rs_c = mysql_query($ssql_c, $conn);
if ($row_c = mysql_fetch_array($rs_c)) 
{ 
	$_SESSION["cargo_fun"]=$row_c["cargos_cargo"];
}

$ssql = "SELECT * FROM usuario WHERE '$codigo'=usuario_ocupacion";
$rs = mysql_query($ssql, $conn);
if ($row = mysql_fetch_array($rs)) 
{ $nombre=$row["usuario_nombre"];
}
*/

/* Sumatoria de bandeja de entrada*/

/*
$rss=mysql_query("SELECT registrodoc1_para, registrodoc1_prioridad 
FROM registrodoc1 
WHERE '$codigo'=registrodoc1_para and registrodoc1_estado='SR' 
and registrodoc1_situacion='P' 
and registrodoc1_asociar<>'si'
and registrodoc1_hoja_ruta<>'0'
and registrodoc1_cc='E'",$conn);
$s_sreg = mysql_num_rows($rss);

while($row=mysql_fetch_array($rss))
 	{	switch ($row["registrodoc1_prioridad"])
		{			
			case 'A': $alta=$alta+1;break;
			case 'M':$media=$media+1;break;			
		}
		$s_sreg=$s_sreg+1;
	 }

$rss1=mysql_query("SELECT derivardoc_para, derivardoc_prioridad FROM derivardoc WHERE '$codigo'=derivardoc_para and derivardoc_situacion='SR'",$conn);
$s_sder = mysql_num_rows($rss1);

$alta1=0;	$media1=0; $s_sder=0;
while($row1=mysql_fetch_array($rss1))
 	{	switch ($row1["derivardoc_prioridad"])
		{			
			case 'A': $alta1=$alta1+1;break;
			case 'M':$media1=$media1+1;break;			
		}
		$s_sder=$s_sder+1;		
	 }
	*/
	
/*Bandeja de pendientes*/	 
$rss2=mysql_query("SELECT registrodoc1_para, registrodoc1_para FROM registrodoc1 WHERE '$codigo'=registrodoc1_para and registrodoc1_estado='R' and registrodoc1_situacion='P' and registrodoc1_cc='E' and registrodoc1_asociar<>'si' and registrodoc1_hoja_ruta<>'0'",$conn);
$s_sreg2=mysql_num_rows($rss2);
/*
$alta2=0; $media2=0; $s_sreg2=0;
while($row2=mysql_fetch_array($rss2))
 	{	switch ($row2["registrodoc1_prioridad"])
		{			
			case 'A': $alta2=$alta2+1;break;
			case 'M':$media2=$media2+1;break;			
		}
		$s_sreg2=$s_sreg2+1;
	 }
*/

$rss3=mysql_query("SELECT derivardoc_para, derivardoc_prioridad FROM derivardoc WHERE '$codigo'=derivardoc_para and derivardoc_situacion='R' and derivardoc_estado='P' and derivardoc_realizado<>'NH'",$conn);
$s_sder3=mysql_num_rows($rss3);
/*
$alta3=0;	$media3=0; $s_sder3=0;
while($row3=mysql_fetch_array($rss3))
 	{	switch ($row3["derivardoc_prioridad"])
		{			
			case 'A': $alta3=$alta3+1;break;
			case 'M': $media3=$media3+1;break;			
		}
		$s_sder3=$s_sder3+1;		
	 }
	 */
/*bandeja de salida*/
$rss4=mysql_query("SELECT registrodoc1_de, registrodoc1_prioridad FROM registrodoc1 WHERE '$codigo'=registrodoc1_de and registrodoc1_estado='SR' and registrodoc1_cc='E' AND registrodoc1_situacion='P' AND registrodoc1_asociar !='si' and registrodoc1_hoja_ruta<>'0'",$conn);
$s_sreg4=mysql_num_rows($rss4);
/*
$alta4=0; $media4=0; $s_sreg4=0;
while($row4=mysql_fetch_array($rss4))
 	{	switch ($row4["registrodoc1_prioridad"])
		{			
			case 'A': $alta4=$alta4+1;break;
			case 'M':$media4=$media4+1;break;			
		}
		$s_sreg4=$s_sreg4+1;
	 }
*/
$rss5=mysql_query("SELECT derivardoc_de, derivardoc_prioridad FROM derivardoc WHERE '$codigo'=derivardoc_de and derivardoc_situacion='SR' and derivardoc_estado='P'",$conn);
$s_sder5=mysql_num_rows($rss5);
/*
$alta5=0;	$media5=0; $s_sder5=0;
while($row5=mysql_fetch_array($rss5))
 	{	switch ($row5["derivardoc_prioridad"])
		{			
			case 'A': $alta5=$alta5+1;break;
			case 'M':$media5=$media5+1;break;			
		}
		$s_sder5=$s_sder5+1;		
	 }
	 */
$s_t_r_d=$s_sreg+$s_sder;
$s_t_r_d2=$s_sreg2+$s_sder3;
$s_t_r_d3=$s_sreg4+$s_sder5;

$t_doc=0;	
$t_doc=$t_doc+$s_t_r_d+$s_t_r_d2+$s_t_r_d3;
$t_urg=$alta+$alta1+$alta2+$alta3;
$t_med=$media+$media1+$media2+$media3;
	
	?>
    
	<script language='JavaScript'>     
			/*window.alert('Usted tiene los siguientes documentos en su bandeja \n.\n.\nCorrespondencia Pendiente <?php echo $t_doc;?>');*/   
	</script>
	<script type="text/javascript">
   function actual_location()
   {
      alert(location);
   }
   function cambiar_location()
   {
      window.location="http://www.google.es/";
   }
</script>

    <style>
    boton{
    background: url("images/12220.png"left top no-repeat;
    margin-left:auto;
    margin-right:auto;
    }
    </style>

<center>
<table width="100%" border="0" cellpadding="1" align="center">
  <tr align="center" style="font-size: 9px;">
    <td colspan="2">
    <img src="images/alta.gif"/><b>URGENTE</b> 
    &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
    <img src="images/media.gif" /><b>NORMAL</b>
    </td>
	<!--<td colspan="2">
	<img src="images/archivos2.png"/><b>TOTAL=<?php echo $t_doc;?></b> 
    &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
    <img src="images/alta.gif"/><b>URGENTE=<?php echo $t_urg;?></b> 
    &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
    <img src="images/media.gif" /><b>NORMAL=<?php echo $t_med;?></b>
    </td>-->
  </tr>
 
  <tr>   
     <!--inicio de correspondencia pendiente-->
    <td width="50%" height="400" bgcolor="#333333">
	 <div>
         <table width="450" border="0">
                    <tr>
                        <td style="font-size: 12px; color:#FFFFFF"><strong>BANDEJA DE PENDIENTES</strong></td>				 	
						<!--
						<input type="text" id="entrada" size="12" />
                        <a href="#" id="limp_ent" class="botonvent" style="background-color: black;">Limpiar filtro</a>
					-->
						<td style="font-size: 12px; color:#FFFFFF" align="right"><b>Total de Archivos:&nbsp;&nbsp;<? echo "$s_t_r_d2";?></b>
						</td>	
					</tr>
          </table>
        </div>
        <iframe  height="480" width="100%" frameborder="0" name="mainFrame" scrolling="si" src="bandejarecepcion.php"> </iframe>
       <!-- 
       <iframe  height="220" width="100%" frameborder="1" name="mainFrame" scrolling="si" src="recepcion_hoy.php"> </iframe>		
       -->      
	
	</td>
	<!--fin de correspondencia pendiente-->
<!--inicio de bandena de salida-->
    <td width="50%" height="400" bgcolor="#333333">	 
	   <div>
         <table width="450" border="0">
                    <tr>
                        <td style="font-size: 12px; color:#FFFFFF"><strong>BANDEJA DE SALIDA&nbsp;&nbsp;&nbsp;</strong></td> 
						<!--
						<input type="text" id="entrada" size="12" />
                        <a href="#" id="limp_ent" class="botonvent" style="background-color: black;">Limpiar filtro</a>
                        -->
						<td style="font-size: 12px; color:#FFFFFF" align="right"><b>Total de Archivos:&nbsp;&nbsp;<? echo "$s_t_r_d3";?></b>
						</td>						
					</tr>
          </table>
        </div>  
        <iframe width="100%" height="480" frameborder="0" name="mainFrame" src="bandeja_salida.php" class="barrades">
        </iframe>	
	
	</td>
	<!--fin de bandena de salida-->
	
   <!--inicio de bandena de salida no recepcionada-->
   
   <!--<td width="100%" height="180" bgcolor="#969696">
	   <div>
         <table width="100%" border="0">
                    <tr>
                        <td style="font-size: 11px; color:#FFFFFF"><strong>BANDEJA NO RECEPCIONADAS&nbsp;&nbsp;&nbsp; HR :</strong> 
						<input type="text" id="entrada" size="12" />
                        <a href="#" id="limp_ent" class="botonvent" style="background-color: black;">Limpiar filtro</a>
						</td>
						<td align="right"><b class="button large yellow"></b>
						</td>
					</tr>
          </table>
        </div>  
        <iframe  height="180" width="100%" frameborder="1" name="mainFrame" scrolling="si" src="doc_despachado_por.php">
        </iframe>	
	</td>
fin de bandena de salida no recepcionada-->
  </tr>
  <tr>
    <td colspan="2" align="center">
		<table border="0">
		  <tr>
		  	<!--
			<td><a href="listado_de_mi.php" onmouseover="window.status='Guia de sitio';return true" onmouseout="window.status='';return true">
			<img src="images/vobo.png" onmouseover="this.src='images/vobo1.png'" onmouseout="this.src='images/vobo.png'"></a></td>
			<td><a href="listado_de_mi2.php" onmouseover="window.status='Guia de sitio';return true" onmouseout="window.status='';return true">
			<img src="images/q_debo.png" onmouseover="this.src='images/q_debo1.png'" onmouseout="this.src='images/q_debo.png'"></a></td>
			<td><a href="for_nuevo_doc2.php">
			<img src="images/m_depen.png" onmouseover="this.src='images/m_depen1.png'" onmouseout="this.src='images/m_depen.png'"></a></td>
			<td><a href="ingreso_adicionar_e.php">
			<img src="images/q_debe_mi_direc.png" onmouseover="this.src='images/q_debe_mi_direc1.png'" onmouseout="this.src='images/q_debe_mi_direc.png'"></a></td>-->
			
			
			<!--
			
			<td><a href="listado_archivados.php" onmouseover="window.status='Guia de sitio';return true" onmouseout="window.status='';return true">
			<img src="images/q_debo.png" onmouseover="this.src='images/q_debo1.png'" onmouseout="this.src='images/q_debo.png'"></a></td>
			<td><a href="listado_archivados.php">
			<img src="images/m_depen.png" onmouseover="this.src='images/m_depen1.png'" onmouseout="this.src='images/m_depen.png'"></a></td>
			<td><a href="listado_seguimiento.php">
			<img src="images/seguimiento.png" onmouseover="this.src='images/seguimiento1.png'" onmouseout="this.src='images/seguimiento.png'"></a></td>
			-->
			<td><a href="que_debe_uni.php">
			<img src="images/q_debe_mi_direc.png" onmouseover="this.src='images/q_debe_mi_direc1.png'" onmouseout="this.src='images/q_debe_mi_direc.png'"></a></td>
			
			<td><a href="listado_archivados.php">
			<img src="images/archivado.png" onmouseover="this.src='images/archivado1.png'" onmouseout="this.src='images/archivado.png'"></a></td>
			<!--
			<td><a href="nuevaestadistica.php">
			<font color=white>...</font></a></td>
			<td><a href="bandejarecepcion.php">            
			<font color=white>ccccccccc</font></a></td>
			<td><a href="libroenviados.php">            
			<font color=white>eeeeeeeee</font></a></td>
			<td><a href="librorecibidos.php">            
			<font color=white>rrrrrrrrr</font></a></td>
			<td><a href="librocites.php">            
			<font color=white>ccccccccc</font></a></td>
			
			<td><a href="#">
			<img src="images/bonton_abajo2.png" onmouseover="this.src='images/bonton_abajo.png'" onmouseout="this.src='images/bonton_abajo2.png'"></a></td>-->
		  </tr>
		</table>	
	</td>
  </tr>
</table>
</center>
<?php $conn = Desconectarse();?>
<?php
include("final.php");
?>

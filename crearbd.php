<?php
include("filtro.php");
include("conecta.php");
include("inicio.php");
include("sicor/script/functions.inc");
/*************************************************************************************
INGRESAR EL NOMBRE DE LA BASE DE DATOS DE LA PRESENTE GESTION Y EL NOMBRE DE LA BASE 
                      DE DATOS VACIA SOLO CON LA ESTRUCTURA	
**************************************************************************************/
$baseactual="correspondencia";//introducir base actual
$basenueva="nb_2011";//introducir base nueva

//base de datos original de la anterior gestion usuario y contrasena
$conn1=mysql_connect('localhost','root','');
mysql_select_db($baseactual,$conn1);

//base de datos gestion actual gestion usuario y contrasena
$conn2=mysql_connect('localhost','root','');
mysql_select_db($basenueva,$conn2);

//usuario
$qry1u=mysql_query("select * from $baseactual.usuario",$conn1);
$qry2u=mysql_query("select * from $basenueva.usuario",$conn2);

//miderivacion
$qry1mi=mysql_query("select * from $baseactual.miderivacion",$conn1);
$qry2mi=mysql_query("select * from $basenueva.miderivacion",$conn2);

//instruccion
$qry1ins=mysql_query("select * from $baseactual.instruccion",$conn1);
$qry2ins=mysql_query("select * from $basenueva.instruccion",$conn2);

//instituciones
$qry1inst=mysql_query("select * from $baseactual.instituciones",$conn1);
$qry2inst=mysql_query("select * from $basenueva.instituciones",$conn2);

//entidades
$qry1en=mysql_query("select * from $baseactual.entidades",$conn1);
$qry2en=mysql_query("select * from $basenueva.entidades",$conn2);

//edificio
$qry1ed=mysql_query("select * from $baseactual.edificio",$conn1);
$qry2ed=mysql_query("select * from $basenueva.edificio",$conn2);

//documentos
$qry1doc=mysql_query("select * from $baseactual.documentos",$conn1);
$qry2doc=mysql_query("select * from $basenueva.documentos",$conn2);

//documentocargo
$qry1docc=mysql_query("select * from $baseactual.documentocargo",$conn1);
$qry2docc=mysql_query("select * from $basenueva.documentocargo",$conn2);

//departamento
$qry1dep=mysql_query("select * from $baseactual.departamento",$conn1);
$qry2dep=mysql_query("select * from $basenueva.departamento",$conn2);

//clasecorrespondencia
$qry1cla=mysql_query("select * from $baseactual.clasecorrespondencia",$conn1);
$qry2cla=mysql_query("select * from $basenueva.clasecorrespondencia",$conn2);

//cargos
$qry1car=mysql_query("select * from $baseactual.cargos",$conn1);
$qry2car=mysql_query("select * from $basenueva.cargos",$conn2);

//asignar
$qry1asi=mysql_query("select * from $baseactual.asignar",$conn1);
$qry2asi=mysql_query("select * from $basenueva.asignar",$conn2);
?>

<?php
//usuario
if (isset($_POST['usuario']))
{

if (mysql_num_rows($qry1u)>0)
{    

while($fila=mysql_fetch_array($qry1u))
{
$var1=$fila["usuario_cod_usr"];
$var2=$fila["usuario_cod_departamento"];
$var3=$fila["usuario_nombre"];
$var4=$fila["usuario_titulo"];
$var5=$fila["usuario_email"];
$var6=$fila["usuario_username"];
$var7=$fila["usuario_dominio"];
$var8=$fila["usuario_cod_nivel"];
$var9=$fila["usuario_password"];
$var10=$fila["usuario_cod_institucion"];
$var11=$fila["usuario_cargo"];
$var12=$fila["usuario_uid"];
$var13=$fila["usuario_gid"];
$var14=$fila["usuario_home"];
$var15=$fila["usuario_maildir"];
$var16=$fila["usuario_active"];
$var17=$fila["usuario_nivel_usuario"];
$var18=$fila["usuario_sigla_usuario"];
$var19=$fila["usuario_ninterna"];
$var20=$fila["usuario_informe"];
$var21=$fila["usuario_memorandum"];
$var22=$fila["usuario_acceso"];
$var23=$fila["usuario_ocupacion"];
$var24=$fila["usuario_nro_correspondencia"];
$var25=$fila["usuario_carnet"];
$var26=$fila["usuario_carnet_ciudad"];

mysql_query("INSERT INTO  usuario(usuario_cod_usr, usuario_cod_departamento, usuario_nombre, usuario_titulo, usuario_email, usuario_username, usuario_dominio, usuario_cod_nivel, usuario_password, usuario_cod_institucion, usuario_cargo, usuario_uid, usuario_gid, usuario_home, usuario_maildir, usuario_active, usuario_nivel_usuario, usuario_sigla_usuario, usuario_ninterna, usuario_informe, usuario_memorandum, usuario_acceso, usuario_ocupacion, usuario_nro_correspondencia, usuario_carnet, usuario_carnet_ciudad) 
			   VALUES ('$var1','$var2','$var3','$var4','$var5','$var6','$var7','$var8','$var9','$var10','$var11','$var12','$var13','$var14','$var15','$var16','$var17','$var18','$var19','$var20','$var21','$var22','$var23','$var24','$var25','$var26')",$conn2);
//mysql_free_result($qry1u);
//mysql_free_result($qry2u);
}
}
else
{
echo "<br />";
echo "<br />";
echo "<div align='center'>";
echo "Base de Datos Usuario sin Datos";
echo "<br />";
echo "<a href='crearbd.php'><img src='images/atras.gif' border='0' /></a>";
echo "</div>";
exit;
}

		?>
			<script language='JavaScript'> 
				window.self.location="crearbd.php"
			</script> 
		<?php
}


//miderivacion
if (isset($_POST['miderivacion']))
{

if (mysql_num_rows($qry1mi)>0)
{    

while($fila=mysql_fetch_array($qry1mi))
{
$var1=$fila["miderivacion_mi_codigo"];
$var2=$fila["miderivacion_su_codigo"];
$var3=$fila["miderivacion_estado"];
$var4=$fila["miderivacion_original"];

mysql_query("INSERT INTO  miderivacion(miderivacion_mi_codigo, miderivacion_su_codigo, miderivacion_estado, miderivacion_original) 
			   VALUES ('$var1','$var2','$var3','$var4')",$conn2);
//mysql_free_result($qry1mi);
//mysql_free_result($qry2mi);
}
}
else
{
echo "<br />";
echo "<br />";
echo "<div align='center'>";
echo "Base de Datos Miderivacion sin Datos";
echo "<br />";
echo "<a href='crearbd.php'><img src='images/atras.gif' border='0' /></a>";
echo "</div>";
exit;
}

		?>
			<script language='JavaScript'> 
				window.self.location="crearbd.php"
			</script> 
		<?php
}


//instruccion
if (isset($_POST['instruccion']))
{

if (mysql_num_rows($qry1ins)>0)
{    

while($fila=mysql_fetch_array($qry1ins))
{
$var1=$fila["instruccion_codigo_instruccion"]; 	
$var2=$fila["instruccion_instruccion"];

mysql_query("INSERT INTO  instruccion(instruccion_codigo_instruccion, instruccion_instruccion) 
			   VALUES ('$var1','$var2')",$conn2);
//mysql_free_result($qry1ins);
//mysql_free_result($qry2ins);
}
}
else
{
echo "<br />";
echo "<br />";
echo "<div align='center'>";
echo "Base de Datos Instrucci&oacute;n sin Datos";
echo "<br />";
echo "<a href='crearbd.php'><img src='images/atras.gif' border='0' /></a>";
echo "</div>";
exit;
}

		?>
			<script language='JavaScript'> 
				window.self.location="crearbd.php"
			</script> 
		<?php
}


//instituciones
if (isset($_POST['instituciones']))
{

if (mysql_num_rows($qry1inst)>0)
{    

while($fila=mysql_fetch_array($qry1inst))
{
$var1=$fila["instituciones_cod_institucion"];
$var2=$fila["instituciones_descripcion_inst"];
$var3=$fila["instituciones_sigla_inst"];
$var4=$fila["instituciones_dependencia_inst"];
$var5=$fila["instituciones_logo"];
$var6=$fila["instituciones_hoja_ruta_interna"];
$var7=$fila["instituciones_hoja_ruta_externa"];
$var8="0";
$var9=$fila["instituciones_membrete"];
$var10=$fila["instituciones_foot"];
$var11=$fila["instituciones_tipo_hoja"];
$var12=$fila["instituciones_dominio"];
$var13=$fila["instituciones_logo_cabecera"];
$var14=$fila["instituciones_logo_pie"];

mysql_query("INSERT INTO  instituciones(instituciones_cod_institucion, instituciones_descripcion_inst, instituciones_sigla_inst, instituciones_dependencia_inst, instituciones_logo, instituciones_hoja_ruta_interna, instituciones_hoja_ruta_externa, instituciones_nro_registro, instituciones_membrete, instituciones_foot, instituciones_tipo_hoja, instituciones_dominio, instituciones_logo_cabecera, instituciones_logo_pie) 
			   VALUES ('$var1','$var2','$var3','$var4','$var5','$var6','$var7','$var8','$var9','$var10','$var11','$var12','$var13','$var14')",$conn2);
//mysql_free_result($qry1inst);
//mysql_free_result($qry2inst);

}
}
else
{
echo "<br />";
echo "<br />";
echo "<div align='center'>";
echo "Base de Datos Instituciones sin Datos";
echo "<br />";
echo "<a href='crearbd.php'><img src='images/atras.gif' border='0' /></a>";
echo "</div>";
exit;
}

		?>
			<script language='JavaScript'> 
				window.self.location="crearbd.php"
			</script> 
		<?php
}


//entidades
if (isset($_POST['entidades']))
{

if (mysql_num_rows($qry1en)>0)
{    

while($fila=mysql_fetch_array($qry1en))
{
$var1=$fila["entidades_entidad_codigo"];
$var2=$fila["entidades_entidad_nombre"];
$var3=$fila["entidades_entidad_sigla"];
$var4=$fila["entidades_cod_institucion"];

mysql_query("INSERT INTO  entidades(entidades_entidad_codigo, entidades_entidad_nombre, entidades_entidad_sigla, entidades_cod_institucion) 
			   VALUES ('$var1','$var2','$var3','$var4')",$conn2);
//mysql_free_result($qry1en);
//mysql_free_result($qry2en);
}
}
else
{
echo "<br />";
echo "<br />";
echo "<div align='center'>";
echo "Base de Datos Entidades sin Datos";
echo "<br />";
echo "<a href='crearbd.php'><img src='images/atras.gif' border='0' /></a>";
echo "</div>";
exit;
}

		?>
			<script language='JavaScript'> 
				window.self.location="crearbd.php"
			</script> 
		<?php
}


//edificio
if (isset($_POST['edificio']))
{

if (mysql_num_rows($qry1ed)>0)
{    

while($fila=mysql_fetch_array($qry1ed))
{
$var1=$fila["edificio_cod_edificio"];
$var2=$fila["edificio_descripcion_ed"];
$var3=$fila["edificio_cod_institucion"];
$var4=$fila["edificio_hoja_ruta_ext"];
$var5=$fila["edificio_sigla_ed"];
$var6=$fila["edificio_ciudad"];

mysql_query("INSERT INTO edificio(edificio_cod_edificio, edificio_descripcion_ed, edificio_cod_institucion, edificio_hoja_ruta_ext, edificio_sigla_ed, edificio_ciudad) VALUES ('$var1','$var2','$var3','$var4','$var5','$var6')",$conn2);
//mysql_free_result($qry1ed);
//mysql_free_result($qry2ed);
}
}
else
{
echo "<br />";
echo "<br />";
echo "<div align='center'>";
echo "Base de Datos Edificio sin Datos";
echo "<br />";
echo "<a href='crearbd.php'><img src='images/atras.gif' border='0' /></a>";
echo "</div>";
exit;
}

		?>
			<script language='JavaScript'> 
				window.self.location="crearbd.php"
			</script> 
		<?php
}


//documentos
if (isset($_POST['documentos']))
{

if (mysql_num_rows($qry1doc)>0)
{    

while($fila=mysql_fetch_array($qry1doc))
{
$var1=$fila["documentos_id"];
$var2=$fila["documentos_sigla"];
$var3=$fila["documentos_descripcion"];
$var4=$fila["documentos_via"];
$var5=$fila["documentos_para"];
mysql_query("INSERT INTO  documentos(documentos_id, documentos_sigla, documentos_descripcion, documentos_via, documentos_para) 
			   VALUES ('$var1','$var2','$var3','$var4','$var5')",$conn2);
//mysql_free_result($qry1doc);
//mysql_free_result($qry2doc);
}
}
else
{
echo "<br />";
echo "<br />";
echo "<div align='center'>";
echo "Base de Datos Documentos sin Datos";
echo "<br />";
echo "<a href='crearbd.php'><img src='images/atras.gif' border='0' /></a>";
echo "</div>";
exit;
}

		?>
			<script language='JavaScript'> 
				window.self.location="crearbd.php"
			</script> 
		<?php
}


//documentocargo
if (isset($_POST['documentocargo']))
{
if (mysql_num_rows($qry1docc)>0)
{    

while($fila=mysql_fetch_array($qry1docc))
{
$var1=$fila["documentocargo_id"];
$var2=$fila["documentocargo_doc"];
$var3=$fila["documentocargo_cargo"];

mysql_query("INSERT INTO  documentocargo(documentocargo_id,documentocargo_doc,documentocargo_cargo) 
			   VALUES ('$var1','$var2','$var3')",$conn2);
//mysql_free_result($qry1docc);
//mysql_free_result($qry2docc);
}
}
else
{
echo "<br />";
echo "<br />";
echo "<div align='center'>";
echo "Base de Datos DocumentoCargo sin Datos";
echo "<br />";
echo "<a href='crearbd.php'><img src='images/atras.gif' border='0' /></a>";
echo "</div>";
exit;
}

		?>
			<script language='JavaScript'> 
				window.self.location="crearbd.php"
			</script> 
		<?php
}



//departamento
if (isset($_POST['departamento']))
{

if (mysql_num_rows($qry1dep)>0)
{    

while($fila=mysql_fetch_array($qry1dep))
{
$var1=$fila["departamento_cod_departamento"];
$var2=$fila["departamento_descripcion_dep"];
$var3=$fila["departamento_dependencia_dep"];
$var4=$fila["departamento_cod_institucion"];
$var5=$fila["departamento_sigla_dep"];
$var6=$fila["departamento_forma_cite"];
$var7=$fila["departamento_ninterna"];
$var8=$fila["departamento_informe"];
$var9=$fila["departamento_memorandum"];
$var10=$fila["departamento_cod_edificio"];
$var11=$fila["departamento_nroregistro_s"];
$var12="0";


mysql_query("INSERT INTO  departamento(departamento_cod_departamento, departamento_descripcion_dep, departamento_dependencia_dep, departamento_cod_institucion, departamento_sigla_dep, departamento_forma_cite, departamento_ninterna, departamento_informe, departamento_memorandum, departamento_cod_edificio, departamento_nroregistro_s, departamento_nroregistro_e) 
			   VALUES ('$var1','$var2','$var3','$var4','$var5','$var6','$var7','$var8','$var9','$var10','$var11','$var12')",$conn2);
//mysql_free_result($qry1dep);
//mysql_free_result($qry2dep);
}
}
else
{
echo "<br />";
echo "<br />";
echo "<div align='center'>";
echo "Base de Datos Departamento sin Datos";
echo "<br />";
echo "<a href='crearbd.php'><img src='images/atras.gif' border='0' /></a>";
echo "</div>";
exit;
}

		?>
			<script language='JavaScript'> 
				window.self.location="crearbd.php"
			</script> 
		<?php
}


//clasecorrespondencia
if (isset($_POST['clasecorrespondencia']))
{

if (mysql_num_rows($qry1cla)>0)
{    

while($fila=mysql_fetch_array($qry1cla))
{
$var1=$fila["clasecorrespondencia_codigo_clase_corresp"];
$var2=$fila["clasecorrespondencia_descripcion_clase_corresp"];

mysql_query("INSERT INTO  clasecorrespondencia(clasecorrespondencia_codigo_clase_corresp, clasecorrespondencia_descripcion_clase_corresp) 
			   VALUES ('$var1','$var2')",$conn2);
//mysql_free_result($qry1cla);
//mysql_free_result($qry2cla);
}
}
else
{
echo "<br />";
echo "<br />";
echo "<div align='center'>";
echo "Base de Datos Clasecorrespondencia sin Datos";
echo "<br />";
echo "<a href='crearbd.php'><img src='images/atras.gif' border='0' /></a>";
echo "</div>";
exit;
}

		?>
			<script language='JavaScript'> 
				window.self.location="crearbd.php"
			</script> 
		<?php
}

//cargos
if (isset($_POST['cargos']))
{

if (mysql_num_rows($qry1car)>0)
{    

while($fila=mysql_fetch_array($qry1car))
{
$var1=$fila["cargos_id"];
$var2=$fila["cargos_cargo"];
$var3=$fila["cargos_cod_institucion"];
$var4=$fila["cargos_cod_depto"];
$var5=$fila["cargos_edificio"];
$var6=$fila["cargos_dependencia"];

mysql_query("INSERT INTO  cargos(cargos_id, cargos_cargo, cargos_cod_institucion, cargos_cod_depto, cargos_edificio, cargos_dependencia) 
			   VALUES ('$var1','$var2','$var3','$var4','$var5','$var6')",$conn2);
//mysql_free_result($qry1car);
//mysql_free_result($qry2car);
}
}
else
{
echo "<br />";
echo "<br />";
echo "<div align='center'>";
echo "Base de Datos Cargos sin Datos";
echo "<br />";
echo "<a href='crearbd.php'><img src='images/atras.gif' border='0' /></a>";
echo "</div>";
exit;
}

		?>
			<script language='JavaScript'> 
				window.self.location="crearbd.php"
			</script> 
            
		<?php
}


//asignar
if (isset($_POST['asignar']))
{

if (mysql_num_rows($qry1asi)>0)
{    

while($fila=mysql_fetch_array($qry1asi))
{
$var1=$fila["asignar_mi_codigo"];
$var2=$fila["asignar_su_codigo"];
$var3=$fila["asignar_estado"];
$var4=$fila["asignar_original"];

mysql_query("INSERT INTO  asignar(asignar_mi_codigo, asignar_su_codigo, asignar_estado, asignar_original) 
			   VALUES ('$var1','$var2','$var3','$var4')",$conn2);
//mysql_free_result($qry1asi);
//mysql_free_result($qry2asi);
}
}
else
{
echo "<br />";
echo "<br />";
echo "<div align='center'>";
echo "Base de Datos Asignar sin Datos";
echo "<br />";
echo "<a href='crearbd.php'><img src='images/atras.gif' border='0' /></a>";
echo "</div>";
exit;
}

		?>
			<script language='JavaScript'> 
				window.self.location="crearbd.php"
			</script> 
		<?php
}




if (isset($_POST['cancelar']))
{
?>
			<script language='JavaScript'> 
				window.self.location="menu.php"
			</script>
<?php
}
?>

<center>
<br>
<p class="fuente_titulo_principal">
<SPAN class="fuente_normal">
MIGRACI&Oacute;N NUEVA GESTI&Oacute;N
</P>


<table width="50%" cellpadding="2" cellspacing="2">
<form method="post">
<tr class="truno">
<td>
<p class="truno" class="fuente_normal">Previamente para realizar la migraci&oacute;n se deber&aacute; realizar los siguientes pasos:
<br /><br />
1. Crear una Base de Datos en blanco, en la raiz de la aplicaci&oacute;n encontrara una carpeta llamada <b>'bdmigracion'</b>  en el cual se encuentra el arhivo <b>base.sql</b> que contiene solo la estructura de la Base de Datos.
<br /><br />
2. En la raiz de la aplicaci&oacute;n editar el script <b>crearbd.php</b> introduciendo los parametros correctos ralacionados a la conexi&oacute;n de Base de Datos (Usuario, Password), tanto para la Base de Datos en blanco y la Base de Datos de la Gesti&oacute;n pasada.
</p>
</td>
<td>


</td>
</tr>

<tr>
<td colspan="2" align="center">
    <br />
	<div align="left">
    <SPAN class="fuente_subtitulo">PUEDE MIGRAR LAS TABLAS INSDISTINTAMENTE DE LA POSICION EN LA CUAL SE ENCUENTRAN</SPAN>
    <br /><br />
    <?php
    if (mysql_num_rows($qry2u)== '0')
    {    
    echo "<input class='boton' type='submit' name='usuario' value='Migracion Usuario'>";
    }
	echo "<br />";
	if (mysql_num_rows($qry2mi)== '0')
    {    
    echo "<input class='boton' type='submit' name='miderivacion' value='Migracion Miderivacion'>";
    }
	echo "<br />";
    if (mysql_num_rows($qry2ins)== '0')
    {    
    echo "<input class='boton' type='submit' name='instruccion' value='Migracion Instruccion'>";
    }
	echo "<br />";
    if (mysql_num_rows($qry2inst)== '0')
    {    
    echo "<input class='boton' type='submit' name='instituciones' value='Migracion Instituciones'>";
    }
	echo "<br />";
    if (mysql_num_rows($qry2en)== '0')
    {    
    echo "<input class='boton' type='submit' name='entidades' value='Migracion Entidades'>";
    }	
    echo "<br />";
    
	if (mysql_num_rows($qry2ed)== '0')
    {    
    echo "<input class='boton' type='submit' name='edificio' value='Migracion Edificio'>";
    }
    
	echo "<br />";
	if (mysql_num_rows($qry2doc)== '0')
    {    
    echo "<input class='boton' type='submit' name='documentos' value='Migracion Documentos'>";
    }	
	echo "<br />";
	if (mysql_num_rows($qry2docc)== '0')
    {    
    echo "<input class='boton' type='submit' name='documentocargo' value='Migracion DocumentosCargo'>";
    }	
	echo "<br />";
	if (mysql_num_rows($qry2dep)== '0')
    {    
    echo "<input class='boton' type='submit' name='departamento' value='Migracion Departamento'>";
    }
	echo "<br />";
	if (mysql_num_rows($qry2cla)== '0')
    {    
    echo "<input class='boton' type='submit' name='clasecorrespondencia' value='Migracion Clasecorrespondencia'>";
    }	
    echo "<br />";
	if (mysql_num_rows($qry2car)== '0')
    {    
    echo "<input class='boton' type='submit' name='cargos' value='Migracion Cargos'>";
    }
	echo "<br />";
	if (mysql_num_rows($qry2asi)== '0')
    {    
    echo "<input class='boton' type='submit' name='asignar' value='Migracion Asignar'>";
    }				
	?>
    <BR />
    <BR />
    <P align="center">    
		<input class="boton" type="submit" name="cancelar" value="Cancelar" >
    </P>    
   </div>     
</td>
</tr>
</form>
</table>
<br>
</center>
<?php
include("final.php");
?>

<?php
include("filtro.php");
?>
<?php
include("inicio.php");
include("sicor/script/functions.inc");
include("sicor/script/cifrar.php");
?>
<?php
include("conecta.php");
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
?>
<?php
$error=0;
if (isset($_POST['enviar']))
{ 
     $result=mysql_query("SELECT * FROM cargos 
                            where cargos_cargo='$_POST[carguito]' 
                            AND cargos_cod_institucion='$_SESSION[institucion]' 
                            AND cargos_cod_depto='$_POST[departamentito]' 
                            AND cargos_edificio='$_POST[edificito]'",$conn);
	 $lista=mysql_num_rows($result);
	 if($lista >0)
	{
	  $error=1;
	  $alert_duplicado=1;
 	}

  $text1=$_POST['carguito'];
  $valor1=alfanumerico($text1);
  if ($valor1==0)
	{
      $error=1;
	  $alert_carguito=1;
    }	

	 if(empty($_POST['departamentito']))
	{
	  $error=1;
	  $alert_departamentito=1;
  	}	
	
	 if(empty($_POST['edificito']))
	{
	  $error=1;
	  $alert_edificito=1;
  	}
	
	/*if(empty($_POST['dependencia']))
	{
	  $error=1;
	  $alert_dependencia=1;
  	}*/
	
  if ($error==0)
	{
		$rs1 = mysql_query("SELECT * from cargos",$conn);
		
		if (mysql_fetch_row($rs1)>0) 
		{
		mysql_query("insert into cargos(cargos_cargo, cargos_cod_institucion, cargos_cod_depto, cargos_edificio,cargos_dependencia)values('$_POST[carguito]','$_SESSION[institucion]','$_POST[departamentito]','$_POST[edificito]','$_POST[dependencia]') ",$conn);
		//desde aqui
		$rs = mysql_query("SELECT max(cargos_id) from cargos");
		
			if ($numero = mysql_fetch_row($rs)) 
				{
				$numero1=$numero[0];
				}
		 //DIRECTA		
		 mysql_query("insert into miderivacion (miderivacion_mi_codigo,miderivacion_su_codigo,miderivacion_estado,miderivacion_original)values('$_POST[dependencia]','$numero1','1','1')",$conn) or die("El Registro no Existe");		
			
		 mysql_query("insert into asignar (asignar_mi_codigo,asignar_su_codigo,asignar_estado,asignar_original)values('$_POST[dependencia]','$numero1','1','1')",$conn) or die("El Registro no Existe");
		 
		 //INVERSA 
		 mysql_query("insert into asignar (asignar_mi_codigo,asignar_su_codigo,asignar_estado,asignar_original)values('$numero1','$_POST[dependencia]','1','1')",$conn) or die("El Registro no Existe");
		}
		else
		{
		mysql_query("insert into cargos(cargos_cargo, cargos_cod_institucion, cargos_cod_depto, cargos_edificio,cargos_dependencia)values('$_POST[carguito]','$_SESSION[institucion]','$_POST[departamentito]','$_POST[edificito]','$_POST[dependencia]') ",$conn);
		}
		//hasta aqui		
		
			?>
					<script language='JavaScript'> 			
						window.self.location="cargos.php"
					</script>
		   <?php
	}//fin error 
} //fin de isset enviar
if (isset($_POST['cancelar']))
{
?>
			<script language='JavaScript'> 
				window.self.location="cargos.php"
			</script>
<?php
}
?>

<center>
<br>

<p class="fuente_titulo_principal">
<SPAN class="fuente_normal">
ADICION DE CARGOS
</P>
<?php
 if ($error != '0')
        {
        echo "<center><font size=2pt color=red>!!! ERROR DATOS NO VALIDOS !!!</font></center>";
        }
		
	if (isset($alert_duplicado))
	{
	echo "<i class='fuente_normal_rojo'>ESTE CARGO YA EXISTE EN LA BASE DE DATOS</i>";
	}
?>
<table>
<form method="post">
<tr class="border_tr3">
<td><SPAN class="fuente_normal">EDIFICIO PERTENENCIA:</td>
<td>
          <select name="edificito" class="fuente_caja_texto" onChange="this.form.submit()">
            <option value="">Selecione un Edificio</option>
			<?php
				$ssqlcinco="SELECT * FROM edificio 
                            WHERE '$_SESSION[institucion]'=edificio_cod_institucion 
                            order by edificio_descripcion_ed ";
                            
				$rsscinco = mysql_query($ssqlcinco, $conn);
				while ($rowcinco=mysql_fetch_array($rsscinco))
					 {
						if($_POST['edificito']==$rowcinco["edificio_cod_edificio"])
							{
			?>
								<option value="<?php echo $rowcinco["edificio_cod_edificio"]?>" selected>
								<?php
									echo $rowcinco["edificio_descripcion_ed"];
								?>
								 </option>
         				   <?php 
					  	    }
						  else
							{
							?>
								<option value="<?php echo $rowcinco["edificio_cod_edificio"]?>">
							<?php
								echo $rowcinco["edificio_descripcion_ed"];
							?>
                                                    
								</option>
					<?php
						    }
					 } 

					?>
			</select>
                  <?php Alert($alert_edificito);?>

</td>
</tr>

<tr class="border_tr3">
<td><SPAN class="fuente_normal">UNIDAD:</td>
<td>
        <select name="departamentito" class="fuente_caja_texto" onChange="this.form.submit()">
				<option value="">Selecione un Departamento</option>
				<?php
					$ssql="SELECT * FROM departamento 
                    WHERE '$_SESSION[institucion]'=departamento_cod_institucion 
                    and departamento_cod_edificio='$_POST[edificito]' 
                    order by departamento_descripcion_dep ";
					
					$rss = mysql_query($ssql, $conn);
				   if (mysql_num_rows($rss) > 0) 
					 {
						while($row=mysql_fetch_array($rss))
							{
								if (isset($_POST['departamentito'])) 
									{
								      if ($_POST['departamentito']==$row["departamento_cod_departamento"])
						  				{
			    ?>
											<option value="<?php echo $row["departamento_cod_departamento"];?>" selected >
									         <?php echo $row["departamento_descripcion_dep"];
									         echo "</option>";
					       				} 
									   else 
									    {
									   ?>
									   		<option value="<?php echo $row["departamento_cod_departamento"];?>" >
									           <?php echo $row["departamento_descripcion_dep"];
								           echo "</option>"; 	   
						   				}  
				   					}
								   else
									{
									  ?>
									  		<option value="<?php echo $row["departamento_cod_departamento"];?>">
									  <?php 
												  echo $row["departamento_descripcion_dep"];
										   	echo "</option>";
				   					} //end if isset
						  } // while  
						  
				}
				
			 echo "</select>";
			 ?>
               <?php Alert($alert_departamentito);?>
           

</td>
</tr>
<tr class="border_tr3">
<td ><SPAN class="fuente_normal">NOMBRE DEL CARGO NUEVO:</td>
<td><input class="fuente_caja_texto" type="text" name="carguito" value="<?php echo $_POST['carguito'];?>" size="40">
<?php Alert($alert_carguito); ?>
</td>
</tr>

<?php
        if ($_POST['departamentito'])
        {
        ?>
        <tr class="border_tr3" >
        <td><span class="fuente_normal" >DEPENDENCIA:</td>
		<td >
			<select name="dependencia" class="caja_texto"  >
    		<?php
						 //MODIFICADO CESAR
						  $ssql2="SELECT * FROM cargos WHERE '$_SESSION[institucion]'=cargos_cod_institucion AND  cargos_edificio='$_POST[edificito]' and cargos_cod_depto='$_POST[departamentito]' order by cargos_id";
						  $rss2 = mysql_query($ssql2, $conn);
						  echo "$rss2[0]";
						  if (mysql_num_rows($rss2) > 0) 
							{
							 while($row2=mysql_fetch_array($rss2))
							  {
								if ($_POST['dependencia']==$row2["cargos_id"])
								 {
			 ?>  					     <option value="<?php echo $row2["cargos_id"];?>" class="botonde" selected="selected">
										   <?php echo $row2["cargos_cargo"]; 
									echo "</option>";	
								 }
								 else
								 {
								 ?>
								    <option value="<?php echo $row2["cargos_id"];?>" class="botonde" selected="selected">
										   <?php echo $row2["cargos_cargo"]; 
									echo "</option>";
								 }
							  }	// End while 
								    
							}
						   else
							{
							echo "<option value=''>No hay registros para este Item </option>"; 
							} //isset
					
							 
							
						echo "</select>";
				
				    if (isset($alert_dependencia)) 
					{
					  //echo "<img src=\"images/eliminar.gif\" border=0 >";  
					}
		?>
		</td>
        </tr>
        <?php
        }
		?>



<tr>
<td colspan="2" align="center">
<input class="boton" type="submit" name="enviar" value="Adicionar" >
<input class="boton" type="submit" name="cancelar" value="Cancelar" ></td>
</tr>
</form>
</table>
<br>
</center>
<?php
include("final.php");
?>

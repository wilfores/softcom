<?php
session_start();
include("inicio.php");
?>
<link rel="stylesheet" type="text/css" href="script/ventanita.css">
<?php
include("script/functions.inc");
include("../conecta.php");
include("script/cifrar.php");
$cod_institucion=$_SESSION["institucion"];
$cargo_unico=$_SESSION["cargo_asignado"];
$dpto=$_SESSION["departamento"];
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
//echo date("Y");

?>
<style>
	.resaltado{
		color:red;
	}
	.normal{
	
	}
</style>
<?
// $mes = date("m");
// echo date("Y");
$mes ="";
 switch(date("m")){
 	case 01 : $mes = "ENERO";
		 	 break;
 	case 02 : $mes = "FEBRERO";
		 	 break;
 	case 03 : $mes = "MARZO";
		 	 break;
 	case 04 : $mes = "ABRIL";
		 	 break;
 	case 05 : $mes = "MAYO";
		 	 break;
 	case 06 : $mes = "JUNIO";
		 	 break;
 	case 07 : $mes = "JULIO";
		 	 break;
 	case 08 : $mes = "AGOSTO";
		 	 break;
 	case 09 : $mes = "SEPTIEMBRE";
		 	 break;
 	case 10 : $mes = "OCTUBRE";
		 	 break;
 	case 11 : $mes = "NOVIEMBRE";
		 	 break;
 	case 12 : $mes = "DICIEMBRE";
		 	 break;
		
 }

?>
<script src="jquery/jquery.uitablefilter.js" type="text/javascript"></script>
<script src="jquery/jquery.js" type="text/javascript"></script>
<script language="javascript">
	var cantidad=1;
	var cantidad2=1;
	var contador=0;
	var ordenar = '';
	$(document).ready(function(){
		filtrar()
		$("#btnfiltrar").click(function(){ 
			filtrar();
		});
		$("#btncancel").click(function(){
//			$(".filtro input").val('');
			$("#cadena").attr('value', '');
//			$("#imp").attr('value', 'Imprimir');
//			$("#lim").attr('value', 'Limpiar Lista');
			filtrar();
		});
	});
	function filtrar(){
		$.ajax({
			data: $("#frm_filtro").serialize()+ordenar,
			type: "GET",
			dataType: "json",
			url: "filtrorecibidos.php?action=listar&dpto=<? echo $dpto; ?>",
			success: function(data){
				data.sort(function (a,b) {
					if ( parseFloat(a["orden"]) < parseFloat(b["orden"])) return  -1;
					if ( parseFloat(a["orden"]) > parseFloat(b["orden"])) return  1;
					return 0;
				});
				var html = '';
				var tipodoc;
				var resaltador=1;
				if(data.length > 0){
					$.each(data, function(i,item){
						var fun="anadir";
						var miestado = "otro";
						if(resaltador%2==0)
						{
							cfondo='#FFFFFF';
						}else{
							cfondo='#BCC9E0';
						}
						if(item.tabla == "der")
						{
							fun="anadird";
						}
						switch(item.estado){
							case 'A':
								miestado = "Archivado";
								break;
							case 'O':
								miestado = "Observado";
								break;
							case 'E':
								miestado = "Eliminado";
								break;
							case 'P':
								miestado = "Pendiente";
								break;
							case 'D':
								miestado = "Derivado";
								break;
							default : 
								miestado = "otro";
								break;
						}
						html += '<tr class=datosfila style="background:'+cfondo+'" id='+item.id+'>'
						html += '<td align="center">'+item.hoja+'</td>'
						html += '<td align="center">'+item.cite+'</td>'
						html += '<td align="center">'+item.fecha+'</td>'
						html += '<td align="center">'+item.remi+'</td>'
						html += '<td align="center">'+item.desti+'</td>'
						html += '<td align="center">'+item.tipo+'</td>'
						html += '<td align="center">'+miestado+'</td>'
//						html += '<td align="center">'+item.tabla+'</td>'
//						html += '<td align="center"><input type=button onclick="anadir('+item.hoja+','+item.id+');" value="añadir"></td>'
//						html += '<td align="center"><input type=button onclick=anadir("'+item.hoja+'","'+item.id+'"); 
						html += '<td align="center"><input type=button onclick='+fun+'("'+item.hoja+'","'+item.id+'"); value="añadir" class="boton"></td>'
						html += '</tr>';
						resaltador++;
					});
				}
			if(html == '') html = '<tr><td colspan="4" align="center">No se encontraron registros..</td></tr>'
			$("#data tbody").html(html);
			}
		});
	}
		
	function anadir(a,b){
		if (contador < 5){
			document.getElementById("listado").innerHTML += a+"<br>";
			contador++;
			
			document.getElementById("icanid").value=cantidad;
			cantidad++;
			document.getElementById("iarrid").value+=b+", ";
			$("#"+b).addClass("resaltado");

		}
		else{
			alert ("solo puede seleccionar 5 hojas de ruta");
		}
	}
	function anadird(a,b){
		if (contador < 5){
			document.getElementById("listado").innerHTML += a+"<br>";
			contador++;
			
			document.getElementById("dcanid").value=cantidad2;
			cantidad2++;
			document.getElementById("darrid").value+=b+", ";
			$("#"+b).addClass("resaltado");			
		}
		else{
			alert ("solo puede seleccionar 5 hojas de ruta");
		}
	}
	function limpiar(){
		document.formimprime.reset();
		document.getElementById("listado").innerHTML = "";
		contador = 0;
		
		document.getElementById("icanid").value="";
		document.getElementById("iarrid").value="";
		document.getElementById("dcanid").value="";
		document.getElementById("darrid").value="";
		cantidad=1;
		cantidad2=1;
		//-------------------------------------
		$("tr").removeClass("resaltado");

	}
	function saludar(){
		alert ("-_-");
	}
	</script>
	<div id="content">
        <div class="filtro">
            <form id="frm_filtro" method="GET" action="">
                        <center><h2>LISTADO DE RECIBIDOS MES DE  <?PHP echo "$mes"; ?></h2>
                         Hoja de Ruta <input type="text" name="cadena" size="25" id="cadena" />
                        <button type="button" id="btnfiltrar" class="boton">Buscar</button>
                        <button type="button" id="btncancel" class="boton">Todos</button>
                        </center>
            </form>
        </div>
        <div><h3>Nota. el tamaño de papel debe ser 21.5 x 35.5</h3></div>
        <h3>Exportar el listado a Excel <a href="muestraexcel.php"><img src="images/icono_excel.jpg"></img></a></h3>
        <div class="filtro">
    <form name="formimprime" action="imprimirlibro3.php" method="GET" target="_blank">
        <table>
        <tr> <td colspan=2>
                <h4>Registros a Imprimir:</h4>
             </td>
        </tr>
        <tr>
             <td> &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;

            <input type="hidden" value="" id="icanid" name="icanid">
            <input type="hidden" value="" id="iarrid" name="iarrid">
            <input type="hidden" value="" id="dcanid" name="dcanid">
            <input type="hidden" value="" id="darrid" name="darrid">
            </td>
            <td><div  id="listado"> </div></td>
        </tr>
        <tr>
	        <td colspan =2>
            &nbsp; &nbsp;  
            <input type="submit" id="imp" value="Imprimir" class="boton" >
            <input type="button" id="lim" value="Limpiar Lista" class="boton" onClick="limpiar();">
            </td>
        </form>
        </div>
        <table ellspacing="2" cellpadding="2" border="1" style="font-size:8pt;" width="90%" bordercolor="#FFFFFF" id="data" align="center">
            <thead>
                <tr style="font-size: 8pt; color:#FFFFFF;" bgcolor="#3E6BA3">
                    <th width="15%"><span title="Hoja de Ruta">Hoja de Ruta</span></th>
                    <th width="20%"><span title="Cite">Cite</span></th>
                    <th width="10%"><span title="Fecha elaboracion/derivacion">Fecha de Recepcion</span></th>
                    <th width="15%"><span title="Remitente">Remitente</span></th>
                    <th width="15%"><span title="Destinatario">Destinatario</span></th>
                    <th width="10%"><span title="tipo">Tipo</span></th>
                    <th width="10"><span title="estado">Estado</span></th>
                    <th width="5%"><span title="accion">Accion</span></th>
                </tr>
            </thead>
            <tbody>
     
            </tbody>
        </table>
	</div>

<?php
include("script/functions.inc");
include("../conecta.php");
include("script/cifrar.php");
$dpto=$_SESSION["departamento"];
//$conn = Conectarse();
?>
<style type="text/css">
.botonExcel{cursor:pointer;}
</style>
<script src="jquery/jquery.js" type="text/javascript"></script>
<script language="javascript">
	var cantidad=1;
	var cantidad2=1;
	var contador=0;
	var ordenar = '';
	var html ='';
	$(document).ready(function(){
		filtrar()
		$("#btnfiltrar").click(function(){ 
			filtrar();
		});
		$("#btncancel").click(function(){
			$("#cadena").attr('value', '');
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
//				var html = '';
				html += '<table><tr><th>Hoja de ruta</th><th>Cite</th><th>Fecha de Recepcion</th><th>Remitente</th><th>Destinatario</th><th>Tipo</th><th>Estado</th></tr>';
				var tipodoc;
				if(data.length > 0){
					$.each(data, function(i,item){
						var miestado = "otro";
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
						html += '<tr >'
						html += '<td align="center">'+item.hoja+'</td>'
						html += '<td align="center">'+item.cite+'</td>'
						html += '<td align="center">'+item.fecha+'</td>'
						html += '<td align="center">'+item.remi+'</td>'
						html += '<td align="center">'+item.desti+'</td>'
						html += '<td align="center">'+item.tipo+'</td>'
						html += '<td align="center">'+miestado+'</td>'
						html += '</tr>';
					});
				}
					
				if(html == '') {html = '<tr><td colspan="4" align="center">No se encontraron registros..</td></tr>';}
				else{ html+= '</table>';}
				//$("#datos").html(html);
				//*********
				$("#datos_a_enviar").val(html);
				$("#FormularioExportacion").submit();
				window.location='librorecibidos.php';
				//*********
				//$("#datos").html(html);
				//SendToExcel(html):
			}
		});

	}
	</script>

<div id=datos>
</div>
<form action="ficheroExcel.php" method="post" target="_blank" id="FormularioExportacion">
<input type="hidden" id="datos_a_enviar" name="datos_a_enviar" />
</form>
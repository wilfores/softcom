<link rel="stylesheet" type="text/css" href="script/ventanita.css">
<?php

include("../filtro.php");
include("script/functions.inc");
include("../conecta.php");
include("script/cifrar.php");

$cod_institucion=$_SESSION["institucion"];
$cargo_unico=$_SESSION["cargo_asignado"];
//echo $cargo_unico;
$sw=0;

$gestion=$_SESSION["gestion"];
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

if (!isset($_GET['orden']))
	{
            $orden = "seguimiento_fecha_deriva";
	}
	else
	{
            $orden=$_GET['orden'];
	}
	
?>
<STYLE type="text/css"> 
    A:link {text-decoration:none;color:#FFFFFF;} 
    A:visited {text-decoration:none;color:#CEDCEA;} 
    A:active {text-decoration:none;color:#FFFFFF;} 
    A:hover {text-decoration:underline;color:#DDE5EE;} 
</STYLE>

<style>
c { white-space: pre; }
.datosfila{
	color:#254D78;
	margin:4px;
	font-size:11px;
	background:#ffffff;
	padding:10px;  
}
</style> 
<script language="JavaScript">
//var codigo = "<? echo $cargo_unico; ?>";
function CopiaValor(objeto) {
	document.recepcion.sel_derivar.value = objeto.value;
}

function Retornar()
{
	document.recepcion.action="principal.php";
	document.recepcion.submit();
}
function Abre_ventana (pagina)
{
     ventana=window.open(pagina,"Asignar","toolbar=no,location=0,directories=no,status=no,menubar=no,scrollbars=yes,resizable=yes,width=450,height=300");
}
</script>

	<script src="jquery/jquery.uitablefilter.js" type="text/javascript"></script>
   	<script src="jquery/jquery.js" type="text/javascript"></script>
		
	<script language="javascript">
		var ordenar = '';
		$(document).ready(function(){

			filtrar()

			$("#btnfiltrar").click(function(){ 
			
				filtrar();
			});
			$("#btncancel").click(function(){
				$(".filtro input").val('')
				filtrar();
			});

		});
		function filtrar(){

			$.ajax({
				data: $("#frm_filtro").serialize()+ordenar,
				type: "GET",
				dataType: "json",
				url: "mifiltrado.php?action=listar&hru=<? echo $cargo_unico; ?>",
					success: function(data){
						//alert("llego la respuesta"+data);
						data.sort(function (a,b) {
						//alert(a["orden"]);
							if ( parseFloat(a["orden"]) < parseFloat(b["orden"])) return  1;
							if ( parseFloat(a["orden"]) > parseFloat(b["orden"])) return  -1;
							return 0;
						});
						var html = '';
						var tipodoc;
						var resaltador=1;
						// si la consulta ajax devuelve datos
						if(data.length > 0){
	
							$.each(data, function(i,item){
								var rechazar="";
								if(item.tipo=='reg'){
									tipodoc = '<a href="recepcionar_doc.php?hr1=';
					
								}
								else{
									tipodoc = '<a href="recepcionar_doc_derivado.php?hr1=';																
								}
								if(resaltador%2==0)
								{
									cfondo='#FFFFFF';
								}else{
									cfondo='#BCC9E0';
								}
															
								html += '<tr class=datosfila style="background:'+cfondo+'">'
									//html += '<td>'+item.prioridad+'</td>'
									html += '<td align="center"><center><img src='+item.prioridad+'></img></center></td>'
									html += '<td align="center">'+item.hoja+'</td>'
									html += '<td align="center">'+item.fecha+'</td>'
									html += '<td align="center">'+item.refe+'</td>'
									html += '<td align="center">'+item.remi+'</td>'
									html += '<td align="center"><br>'+tipodoc+item.cifra+'" class=botonte target="_top">Recepcionar</a><br>'+rechazar+'</td>'
								html += '</tr>';
 		 						resaltador++;
							});
						}
							if(html == '') html = '<tr><td colspan="4" align="center">No se encontraron registros..</td></tr>'
									$("#data tbody").html(html);
					}
			});
		}
		
		
	</script>
	<div id="content">
    <div class="filtro" align="center">
        <form id="frm_filtro" method="GET" action="">
					 <label>BUSCAR HOJA DE RUTA </label>
                     <input type="text" name="cadena" size="25" />
                    <button type="button" id="btnfiltrar">Buscar</button>
                    <button type="button" id="btncancel">Todos</button>
        </form>
    </div>
    <table ellspacing="2" cellpadding="2" border="1" style="font-size:8pt;" width="90%" bordercolor="#FFFFFF" id="data">
        <thead align="center">
            <tr style="font-size: 8pt; color:#FFFFFF;" bgcolor="#3E6BA3">
                <th width="3%"><span title="Prioridad">Prioridad</span></th>
                <th width="10%"><span title="Hoja de Ruta">Hoja de Ruta</span></th>
                <th width="8%"><span title="Fecha de recepcion">Fecha Recepcion</span></th>
                <th width="22%"><span title="Referencia">Referencia</span></th>
                <th width="10%"><span title="Remitente">Remitente</span></th>
                <th width="8%"><span title="Accion">Operacion</span></th>
            </tr>
        </thead>
        <tbody>
 
        </tbody>
    </table>
	</div>
<?php $conn = Desconectarse();?>





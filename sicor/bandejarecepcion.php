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
.fondoalerta{
	background:url('images/alertac.jpg') no-repeat;
}

</style> 
<script language="JavaScript">
//var codigo = "<?php echo $cargo_unico; ?>";
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
			//var codigousuario = 

		 
			// Llamando a la funcion de busqueda al
			// cargar la pagina
			filtrar()
			// filtrar al darle click al boton
			$("#btnfiltrar").click(function(){ 
				//alert ("inicio de filtrado");
				filtrar();
			});
			$("#btncancel").click(function(){
				$(".filtro input").val('')
				filtrar();
			});

		});
		function filtrar(){
		// funcion ajax de jquery, hara la peticion enviandole
		// los parametros, y este devolvera resultado en formato
		// json
			//alert ("procesando filtrado");
			$.ajax({
				data: $("#frm_filtro").serialize()+ordenar,
				type: "GET",
				dataType: "json",
				url: "mifiltrado2.php?action=listar&hru=<?php echo $cargo_unico; ?>",
					success: function(data){
						//lert(data);
						data.sort(function (a,b) {
							//alert(a["orden"]);
							if ( parseFloat(a["orden"]) < parseFloat(b["orden"])) return  1;
							if ( parseFloat(a["orden"]) > parseFloat(b["orden"])) return  -1;
							return 0;
						});
						var proveido;
						//alert("llego la respuesta"+data);
						var html = '';
						var resaltador=1;
						var cfondo='';
						var restante='';
						// si la consulta ajax devuelve datos
						if(data.length > 0){
							// hacemos un bucle al json, para recorrer cada registro
							// e irlos almacenando en filas html
							//alert("data mayor a cero");
							$.each(data, function(i,item){
								proveido="";
								fondoa='';
								if(item.prove!=''){
								proveido = '<font color=red>Proveido: </font>'+item.prove+'<hr><font color=red> Referencia: </font>';							
								}
								/*if(item.restante!=''){
									if(item.restante>0){
									restante = '<br><font color=red>PLAZO RESTANTE: '+item.restante+' DIAS </font>';
									}
									else{
									restante = '<br><font color=red>PLAZO VENCIDO ! </font>';									
									fondoa='fondoalerta';
									}
								}else{
									restante='';
								}
								*/
								if(resaltador%2==0)
								{
									cfondo='#FFFFFF';
								}else{
									cfondo='#BCC9E0';
								}
								
								html += '<tr class=datosfila style="background:'+cfondo+'">'
									//html += '<td>'+item.prioridad+'</td>'
									html += '<td align="center"><center><img src='+item.prioridad+'></img></center></td>'
									html += '<td align="center"><a href="ver_doc_adjuntos.php?hr1='+item.adju+'" target="_top"><img src="images/arch_adj.png" border="0"></img></a></td>'
									html += '<td align="center" class="'+fondoa+'">'+item.hoja+restante+'</td>'
									html += '<td align="center">'+item.fecha+'</td>'
									html += '<td align="center">'+proveido+''+item.refe+'</td>'
									html += '<td align="center">'+item.remi+'</td>'
									html += '<td align="center"><br><a href="derivar_doc.php?hr1='+item.cifra+'" class="botonte" target="_top">Derivar  .</a><br><hr><a href="for_nuevo_doc2.php?hr1='+item.cifra+'" class="botonte" target="_top">Responder  .</a><hr><a href="archivar_doc.php?hr1='+item.cifra+'" class="botonte" target="_top">Archivar .</a></td>'
									//html += '<td align="center"><br><a href="derivar_doc.php?hr1='+item.cifra+'" class="botonte" target="_top">Derivar  .</a><br><hr><a href="for_nuevo_doc2.php?hr1='+item.cifra+'" class="botonte" target="_top">Responder  .</a><hr><a href="observadodoc.php?hr1='+item.cifra+'" class="botonte" target="_top">Observado  .</a><hr><a href="archivar_doc.php?hr1='+item.cifra+'" class="botonte" target="_top">Archivar .</a></td>'
								html += '</tr>';
		 						resaltador++;
							});
						}
						// si no hay datos mostramos mensaje de no encontraron registros
						if(html == '') html = '<tr><td colspan="4" align="center">No se encontraron registros..</td></tr>'
						// añadimos  a nuestra tabla todos los datos encontrados mediante la funcion html
						$("#data tbody").html(html);
					}
			});
		}
		
		
	</script>
	<div id="content">
    <div class="filtro">
        <form id="frm_filtro" method="GET" action="">
					 <label>BUSCAR HOJA DE RUTA </label>
                     <input type="text" name="cadena" size="25" />
                    <button type="button" id="btnfiltrar">Buscar</button>
                    <button type="button" id="btncancel">Todos</button>
        </form>
    </div>
    <table ellspacing="2" cellpadding="2" border="1" style="font-size:8pt;" width="90%" bordercolor="#FFFFFF" id="data">
        <thead>
            <tr style="font-size: 8pt; color:#FFFFFF;" bgcolor="#3E6BA3">
                <th width="5%"><span title="Prioridad">Pri</span></th>
                <th width="12%"><span title="Archivos Adjuntos">Doc. Adjuntos</span></th>
                <th width="12%"><span title="Hoja de Ruta">Hoja de Ruta</span></th>
                <th width="10%"><span title="Fecha de Derivacion">Fecha de Derivacion</span></th>
                <th width="15%"><span title="Referencia">Referencia</span></th>
                <th width="20%"><span title="Remitente">Remitente</span></th>
                <th width="22%"><span title="Operacion">Operacion</span></th>
            </tr>
        </thead>
        <tbody>
 
        </tbody>
    </table>
	</div>
<?php $conn = Desconectarse();?>





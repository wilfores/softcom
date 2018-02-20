<?php
function valida_datos($dato1,$dato2)
{
switch ($dato1){

case "nombre":
		if(ereg("^[a-zA-Z Ññ]{3,160}$", $dato2))
		{
		   return(1);
		}
		else
		{
		   return(0);
		}
	break;

case "fecha":
			if(!eregi("^[0-9]{1,2}-[0-9]{1,2}-[0-9]{4}$",$dato2))
			{
				return (0);
			}else
			{
				return (1);
			}
			break;
			
 case "numero":
		        if (ereg("^[0-9]+$",$dato2))
			{
				return (1);
		        }
			else
			{
				return (0);
		        }
		        break;
case "numero_decimal":
			if (ereg("^[0-9]+\.[0-9]+$|^[0-9]+$",$dato2))
			{
				return (1);
			}
			else
			{
				return (0);
			}
			break;
case "alfa":
		if(ereg("^[a-zA-Z0-9 /Ññ\.&#,-]+$",$dato2))
		{
		return(1);
		}
		else
		{
		return(0);
		}
	break;
       }
}	


function FechaInv($fecha){
  list($a,$b,$c)=split("-",$fecha);
  $fecha = "$c-$b-$a";
  return $fecha;
}

function FechaHora($fhora){
  list($fecha,$hora)=split(" ",$fhora);
  $fechad=FechaInv($fecha)." ".$hora;
  return $fechad;
}

function FechaHoy(){
  $fechahoy = strftime("%Y")."-". strftime("%m")."-".strftime("%d");
  return $fechahoy;
}

function HoraActual(){
    $horaactual = strftime("%H").":". date("i").":".date("s");  
	return $horaactual;
}

function Val_fechas($fecha){
  if (ereg ('([0-9]{4})-([0-9]{1,2})-([0-3]{1})([0-9]{1})', $fecha)) {
    list($anio,$mes,$dia) = split("-",$fecha);
    if (checkdate($mes,$dia,$anio)) {
       return 0;
    } else {
      return 1;
    }
  } else { return 1; }
}


function Val_numeros($numero){
  if (ereg ('^[0-9]+$', $numero)) {
     return 0;
  } else {
     return 1;
  }
}


function sinespacios($nombre)
{
if (!ereg("^[a-zA-Z]+$",$nombre))
 {
return 0;
 }
else
 {
 return 1;
 }
}

function solocadenas($nombre)
{
if (!ereg("^[a-zA-Z]+$",$nombre))
{
  return 0;
}
else
{
  return 1;
}
}

function alfanumerico($nombre)
{
if (!ereg("^[a-zA-Z0-9 ]+$",$nombre))
{
  return 0;
}
else
{
  return 1;
}
}


function val_alfanum($datos)
{
  if(!eregi('^[a-zA-Z0-9 ()/\#:ºáéíóúÁÉÍÓÚÑñ_\,.-]+$', $datos)){
     return 0;
  } else {
     return 1;
  }
}

function Validacion($campo,$mensaje){
  if (empty($campo)) {
      include("inicio.php");
      echo "<br><br><center><p>";
      echo $mensaje;
      echo "<br><br><a href=\"javascript:history.back(-1)\">Retornar</a>";
	  echo "</p></center>";
      include("final.php");
	  exit();
  }
}

function Alert($campo)
{
 if ($campo == 1) {
   echo "<img src=\"images/eliminar.gif\" border=0 align=center/>";
 }
}


function MesLiteral($fecha){
   list( $anio, $mes, $dia ) = split("-",$fecha ); 
   $numero = mktime(0,0,0,$mes,$dia,$anio);
   // $dias = array("Domingo","Lunes","Martes","Miercoles","Jueves","Viernes","Sabado");
	$mes = array(" ","Enero","Febrero","Marzo","Abril","Mayo","Junio","Julio","Agosto","Septiembre","Octubre","Noviembre","Diciembre");
    $fecha_literal = date("d",$numero)." de ".$mes[date('n',$numero)]." de ".date("Y",$numero);
	return $fecha_literal;
}

function cite($tipop,$planilla,$conn,$institucion,$cod_depar,$cod_usr)
{
if ($tipop=='departamento')
{
$siglaD=mysql_query("select * from departamento where Cod_Departamento='$cod_depar'",$conn);

switch ($planilla)
{
case 'carta': 
if ($rowd=mysql_fetch_array($siglaD))
{
$numD=$rowd["carta"]+1;
}
break;
case 'informe':
if ($rowd=mysql_fetch_array($siglaD))
{
$numD=$rowd["informe"]+1;
}
break;
case 'nota':
if ($rowd=mysql_fetch_array($siglaD))
{
$numD=$rowd["nota"]+1;
}
break;
case 'comunicacion':
if ($rowd=mysql_fetch_array($siglaD))
{
$numD=$rowd["comunicacion"]+1;
}
break;
case 'memorandum':
if ($rowd=mysql_fetch_array($siglaD))
{
$numD=$rowd["memorandum"]+1;
}
break;
case 'notafax':
if ($rowd=mysql_fetch_array($siglaD))
{
$numD=$rowd["notafax"]+1;
}
break;
}//fin switch
$numD="/No ".strtoupper($numD);
}
else
{

$siglaD=mysql_query("select * from usuario where Cod_usr='$cod_usr'",$conn);

switch ($planilla)
{
case 'carta': 
if ($rowd=mysql_fetch_array($siglaD))
{
$numD=$rowd["carta"]+1;
$nomD=$rowd["sigla_usuario"];
$numD=strtoupper($nomD)."/No ".strtoupper($numD);

}
break;
case 'informe':
if ($rowd=mysql_fetch_array($siglaD))
{
$numD=$rowd["informe"]+1;
$nomD=$rowd["sigla_usuario"];
$numD=strtoupper($nomD)."/No ".strtoupper($numD);
}
break;
case 'memorandum':
if ($rowd=mysql_fetch_array($siglaD))
{
$numD=$rowd["memorandum"]+1;
$nomD=$rowd["sigla_usuario"];
$numD=strtoupper($nomD)."/No ".strtoupper($numD);
}
break;
}//fin switch
}
return ($numD."/".date("Y"));
///*/*/*/*/*/*/*/*/*/*/*/*/*/*/*/*/*/*/*/   Aqui termina numerito /**/*/*/*/*/*/*/*/*/*/
//*/*/*/*/*/*/*//*/*/*/*/*/*/*//*/*/*/*/*/*/*//*/*/*/*/*/*/*//*/*//*/*/*/*//*/*/*/*/*/*/
}



function leef ($fichero) { 
    $texto = file($fichero); 
    $tamleef = sizeof($texto); 
    for ($n=0;$n<$tamleef;$n++) {$todo= $todo.$texto[$n];} 
    return $todo; 
} 




function rtf($sql, $plantilla, $fsalida, $matequivalencias,$conexion)
{ 
$pre=time(); 
$fsalida="temp_informes/".$pre.$fsalida; 


//Paso no 1.-Leo una plantilla rtf 
$txtplantilla = leef($plantilla); 
//Paso no.2 Saca cabecera, el cuerpo y el final 
$matriz=explode("sectd", $txtplantilla); 
$cabecera=$matriz[0]."sectd"; 
$inicio=strlen($cabecera); 
$final=strrpos($txtplantilla,"}"); 
$largo=$final-$inicio; 
$cuerpo=substr($txtplantilla, $inicio, $largo); 
//Paso no.3 Escribo el fichero 
$punt = fopen($fsalida, "w"); 
fputs($punt,$cabecera); 

$result = mysql_query($sql,$conexion); 


While($row=mysql_fetch_object($result)){ 
      $despues=$cuerpo; 
      foreach ($matequivalencias as $dato) { 
      $datosql=$row->$dato[1]; 
      $datosql= stripslashes ($datosql); 
      $datortf=$dato[0]; 
      $despues=str_replace($datortf,$datosql,$despues); 
    } 
    fputs($punt,$despues); 
      $saltopag="\par \page \par"; 
    fputs($punt,$saltopag); 
   

} 
fputs($punt,"}"); 
fclose ($punt); 
return $fsalida; 
} 

function cifrar($datos_enviados)
{
   $valor_encryptado = $datos_enviados;
    for($i=1;$i<10;$i++)
    {
        $valor_encryptado = base64_encode($valor_encryptado);
    }

     return $valor_encryptado;
}

function descifrar($datos_enviados)
{
    $valor_encryptado = $datos_enviados;
    for($i=1;$i<10;$i++)
    {
        $valor_encryptado = base64_decode($valor_encryptado);
    }
    return $valor_encryptado;
}

function tiempo_resta($fecha1, $fecha2){
   //separo la fecha1
   list($fecha,$hora)=split(' ',$fecha1);
   list($año,$mes,$dia)=split('-', $fecha);
   list($hor,$min,$sec)=split(':',$hora);
   //calculo timestamp de la fecha1
   $y=mktime($hor,$min,$sec,$mes,$dia,$año);
   
   //separo la fecha2
   list($fecha,$hora)=split(' ',$fecha2);
   list($año,$mes,$dia)=split('-', $fecha);
   list($hor,$min,$sec)=split(':',$hora);

   //calculo timestamp de la fecha1
   $z=mktime($hor,$min,$sec,$mes,$dia,$año);    

   $resta = $z - $y; 
   $min=floor($resta/60);
   $hor=floor(($resta/60)/60);
   
   echo $dias = $resta / 86400;
   return $min;
   
   
}

function DiferenciaEntreFechas($fecha_principal, $fecha_secundaria){
   $f0 = strtotime($fecha_principal);
   $f1 = strtotime($fecha_secundaria);
   if ($f0 == $f1) {$formato_salida=0;}
   else
   { 
   if($f0 < $f1){ $tmp = $f1; $f1 = $f0; $f0 = $tmp; 
   $formato_salida=$f0-$f1;
   }
   }
   return $formato_salida;
}

?>
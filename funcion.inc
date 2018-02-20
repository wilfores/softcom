<?php
function elimina_acentos($archivo){
$nuevo_archivo="";
$temporal = $archivo;
$tamano = strlen($archivo);
for ($j=0; $j < $tamano; $j++){
$caracter = substr($temporal,0,1);
  switch (ord($caracter)) {
    case 225:
	$caracter = "&aacute;";
    break;
	case 233:
	$caracter = "&eacute;";
    break;
	case 237:
	$caracter = "&iacute;";
    break;
    case 243:
	$caracter = "&oacute;";
    break;
	case 250:
	$caracter = "&uacute;";
    break;
	case 252:
	$caracter = "&uacute;";
    break;
	case 241:
	$caracter = "&ntilde;";
    break;

    case 193:
	$caracter = "&Aacute;";
    break;
	case 201:
	$caracter = "&Eacute;";
    break;
	case 205:
	$caracter = "&Iacute;";
    break;
    case 211:
	$caracter = "&Oacute;";
    break;
	case 218:
	$caracter = "&Uacute;";
    break;
	case 220:
	$caracter = "&Uacute;";
    break;
	case 209:
	$caracter = "&Ntilde;";
    break;
    default:
    break;
 }
$tamano22 = strlen($temporal);
$temporal = substr($temporal,1,($tamano22-1));
$nuevo_archivo = $nuevo_archivo.$caracter;
}
return $nuevo_archivo;
}

function acortar($text,$longitud)
{
	$texto = substr("$text",0,$longitud);
	if (strlen($text) > $longitud)
	   {return $texto."...";}
	else
	   {return $texto;}
}

function crypto ($cadena){
	$rar = mt_rand(0,10000000);
	$one = base64_encode($cadena."-".$rar);
	return($one);
}	


function descrypto($cadena1){	
	$cadena2 = base64_decode($cadena1);
	$trees = explode("-", $cadena2);
	return ($trees[0]);
}


function  genera_password()
{
$str = "ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz1234567890";
$cad = "";
for($i=0;$i<5;$i++) {
$cad .= substr($str,rand(0,62),1);
}
return ($cad);
}

//- Funciones auxiliares--------------------------------------------------------
function walk_tolower(&$val){
	$val=strtolower($val);
}
function array_lower($a_arr){
	array_walk($a_arr, 'walk_tolower');
	return $a_arr;
}


//- Funciones de abstracción de formularios -------------------------------------

//=CREA UN SELECT= en base a un array de textos y valores de misma dimension
// $default puede ser 1texto ( o un array) de valor/es que estarán seleccionado/s
// $extra_tag se añadirá al select:  ej: "class='frm' onclick=alert('')"
function frm_select($name,$arr_txt,$arr_vals,$default,$extra_tag=''){
	$tmp="<select name='$name' $extra_tag>";
	$items=count($arr_txt);
	if($items!=count($arr_vals)) return $tmp."<option>ERR! en el array de valores</select></td>";
	for($i=0;$i<$items;$i++)
	{
		$sel=' selected';
		$val=$arr_vals[$i];
		if(is_array($default)){
			if(!in_array( strtolower($val), array_lower($default) )) $sel='';
		}else{
			if(!eregi($val,$default)) $sel='';
		}
		$tmp.="<option value='$val'$sel>".$arr_txt[$i]."</option>";
	}
	return $tmp.'</select>';
}

//=CREA UNA LISTA=  de tamaño visible = $size,  lo demás es igual que frm_select
function frm_list($name,$size,  $arr_txt, $arr_vals, $default='', $extra_tag=''){
	return frm_select($name, $arr_txt, $arr_vals, $default, "size=$size $extra_tag");
}

//=CREA UNA LISTA DE SELECCION MULTIPLE=, como valores seleccionados se puede pasar un array
function frm_list_multi($name, $size, $arr_txt, $arr_vals, $default='', $extra_tag=''){
	return frm_list($name."[]", $size, $arr_txt, $arr_vals, $default, "multiple $extra_tag");
}

//=CREA UN CHECKBOX=, Si se le pasa una variable por $var_in y coincide con $ck_val, se selecciona
function frm_check($name, $ck_val, $var_in='', $extra_tag='')
{
	$ck='';
	if(strtolower($ck_val)==strtolower($var_in)) $ck=' checked';
	return "<input type=checkbox name='$name' value='$ck_val'$extra_tag$ck>";
}

//=CREA UN RADIO=, Si se le pasa una variable por $var_in y coincide con $ck_val, se selecciona
function frm_radio($name, $val, $var_in='', $extra_tag=''){
	$ck='';
	if(strtolower($val)==strtolower($var_in)) $ck=' checked';
	return "<input type=radio name='$name' value='$val' $extra_tag$ck>";
}

//=CREA UN TEXTBOX=
function frm_text($name, $val, $size, $max_length, $extra_tag='')
{
	
	
	return "<input type=text name='$name' size='$size' maxlength='$max_length' value='$val' $extra_tag>";
}

//=CREA UN HIDDEN=
function frm_hidden($name, $val, $size, $max_length, $extra_tag='')
{
	
	
	return "<input type=hidden name='$name' size='$size' maxlength='$max_length' value='$val' $extra_tag>";
}

//=CREA UN PASSWORD=
function frm_password($name, $val, $size, $max_length, $extra_tag=''){
	return "<input type=password name='$name' size='$size' maxlength='$max_length' value='$val'$extra_tag>";
}

//=CREA UN SUBMIT=
function frm_submit($name, $val, $extra_tag='')
{
	return "<input type=submit name='$name' value='$val' $extra_tag class='caja_texto'>";
}

//=CREA Subir un archivo al servidor=
function frm_file($name,$lim_tamano,$tipo_archivo,$lugar_subir)
{
	return "<input type=hidden name='lim_tamano' value='$lim_tamano'><input type='file' name='$name'><input type=hidden name='tipo_archivo' value='$tipo_archivo'><input type=hidden name='lugar_subir' value='$lugar_subir' class='caja_texto'>";
}


/*** FUNCIONES VALIDADORES ***/


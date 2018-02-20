<?php
include("../filtro.php");
?>
<?php
require("fpdf.php");
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
class PDF extends FPDF
{
//Cargar los datos
function LoadData($file)
{
    //Leer las líneas del fichero
    $lines=file($file);
    $data=array();
    foreach($lines as $line)
        $data[]=explode(';',chop($line));
    return $data;
}

//Tabla simple
function BasicTable($header,$data)
{
    //Cabecera
    foreach($header as $col)
        $this->Cell(40,7,$col,1);
    $this->Ln();
    //Datos
    foreach($data as $row)
    {
        foreach($row as $col)
            $this->Cell(40,6,$col,1);
        $this->Ln();
    }
}




//Una tabla más completa
function ImprovedTable($header,$data)
{
    //Anchuras de las columnas
    $w=array(40,35,40,45);
    //Cabeceras
    for($i=0;$i<count($header);$i++)
        $this->Cell($w[$i],7,$header[$i],0,0,'C');
    $this->Ln();
    //Datos
    foreach($data as $row)
    {
        $this->Cell($w[0],6,$row[0],'LR');
        $this->Cell($w[1],6,$row[1],'LR');
        $this->Cell($w[2],6,number_format($row[2]),'LR',0,'L');
        $this->Cell($w[3],6,number_format($row[3]),'LR',0,'L');
        $this->Ln();
    }
    //Línea de cierre
    $this->Cell(array_sum($w),0,'','T');
}

//Tabla coloreada
function FancyTable($header,$data)
{
    //Colores, ancho de línea y fuente en negrita
    $this->SetFillColor(255,0,0);
    $this->SetTextColor(255);
    $this->SetDrawColor(128,0,0);
    $this->SetLineWidth(.3);
    $this->SetFont('','B');
    //Cabecera
    $w=array(40,35,40,45);
    for($i=0;$i<count($header);$i++)
        $this->Cell($w[$i],7,$header[$i],0,0,'C',1);
    $this->Ln();
    //Restauración de colores y fuentes
    $this->SetFillColor(224,235,255);
    $this->SetTextColor(0);
    $this->SetFont('');
    //Datos
    $fill=0;
    foreach($data as $row)
    {
        $this->Cell($w[0],6,$row[0],'LR',0,'L',$fill);
        $this->Cell($w[1],6,$row[1],'LR',0,'L',$fill);
        $this->Cell($w[2],6,number_format($row[2]),'LR',0,'L',$fill);
        $this->Cell($w[3],6,number_format($row[3]),'LR',0,'L',$fill);
        $this->Ln();
        $fill=!$fill;
    }
    $this->Cell(array_sum($w),0,'','T');
}
}
$cod_institucion=$_SESSION["institucion"];

$conn=Conectarse();

$pdf=new PDF('L','mm','Legal');
//FPDF([string orientation [, string unit [, mixed format]]]) 
$pdf->AddPage();

//$pdf->ImprovedTable($header,$data);

   switch($_POST['position'])
   	{
   		case '1':$valor_y='29';break;
		case '2':$valor_y='56';break;
		case '3':$valor_y='83';break;
		case '4':$valor_y='110';break;
		case '5':$valor_y='137';break;
		case '6':$valor_y='164';break;
  	}

   $w=array(12,20,50,40,50,20,20,30,10,55,25);
   $header=array('Nro','Fecha Hora','Institucion','Remitente','Cargo', 'Lugar','Fecha','Cite','Fojas','Referencia','Firma');

  foreach ($_SESSION["codigo_libro_reg"] as $indice=>$valor)
  {
  	$resp_sql=mysql_query("select * from libroregistro where libroregistro_cod_registro='$valor'",$conn);
   	if ($row=mysql_fetch_array($resp_sql))
   	{
		
		$res_sql=mysql_query("update libroregistro set libroregistro_impreso='S' where libroregistro_cod_registro='$valor'",$conn);
		if ($valor_y > 164)
		{
			$pdf->AddPage();
			$valor_y=29;
		}
		
		if ($valor_y==29)
		{
           $pdf->SetFont('Arial','B',15);
		   $pdf->SetXY(120,10);
		   $pdf->Write(10,'REGISTRO DE CORRESPONDENCIA');
		   $pdf->Ln();

	       $pdf->SetFont('Arial','B',9);
            for($i=0;$i<count($header);$i++)
			{
		     $pdf->SetFillColor(255,0,0);
			 $pdf->Cell($w[$i],6,$header[$i],1,0,'C');
		    }
			
		}
		
		$pdf->SetFont('Arial','',8);
		$pdf->Ln();
		
	    $valor_x=10;
		$pdf->Rect($valor_x,$valor_y,$w[0],15);
		$pdf->SetXY($valor_x,$valor_y); 
		$pdf->MultiCell($w[0],10,$row["libroregistro_nro_libro"],0,'L',0);

		$valor_x=$valor_x + $w[0];
		$pdf->Rect($valor_x,$valor_y,$w[1],15);
		$pdf->SetXY($valor_x,$valor_y); 
		$pdf->MultiCell($w[1],5,$row["libroregistro_fecha_recepcion"],0,'L',0);

        $valor_x=$valor_x + $w[1];
		$pdf->Rect($valor_x,$valor_y,$w[2],15);
		$pdf->SetXY($valor_x,$valor_y); 
		$datos_hr=$row["libroregistro_procedencia"];
			
		$pdf->MultiCell($w[2],5,$datos_hr,0,'C',0);
		
		
		/*if ($row["libroregistro_tipo"]=='e')
		{
		$datos_hr1="EXTERNO";
		}
		else
		{
		$datos_hr1="INTERNA";
		}*/
		$valor_x=$valor_x + $w[2];
		$pdf->Rect($valor_x,$valor_y,$w[3],15);
		$pdf->SetXY($valor_x,$valor_y); 
		$pdf->MultiCell($w[3],5,$row["libroregistro_remitente"],0,'L',0);
		
				
  	    $valor_x=$valor_x + $w[3];
		$pdf->Rect($valor_x,$valor_y,$w[4],15);
		$pdf->SetXY($valor_x,$valor_y); 
		if ($row["libroregistro_tipo"]=='i')
		{
			$valor_clave=$row["libroregistro_remitente"];
			$conexion = mysql_query("SELECT * FROM cargos WHERE '$valor_clave'=cargos_id",$conn);
			if($fila_clave=mysql_fetch_array($conexion))
			{
				$valor_cargo=$fila_clave["cargos_id"];
				$conexion2 = mysql_query("SELECT * FROM usuario WHERE '$valor_cargo'=usuario_ocupacion",$conn);
				if($fila_cargo=mysql_fetch_array($conexion2))
				{
					$remitente=$fila_cargo["usuario_nombre"];
				}
			}
			$pdf->MultiCell($w[4],5,$remitente,0,'L',0);
		}
		else
		{
			$pdf->MultiCell($w[4],5,$row["libroregistro_cargo_remitente"],0,'L',0);
		}
	
	
		$var=$row["libroregistro_hoja_ruta"];
		$conexion3 = mysql_query("SELECT ingreso_lugar FROM ingreso WHERE ingreso_hoja_ruta='$var'");	
	
		if($fila_clave1=mysql_fetch_array($conexion3))
		{
			$lugarcito=$fila_clave1["ingreso_lugar"];
		}
   		$valor_x=$valor_x + $w[4];
		$pdf->Rect($valor_x,$valor_y,$w[5],15);
		$pdf->SetXY($valor_x,$valor_y); 
		$pdf->Multicell($w[5],6,$lugarcito,0,'L',0);
	
		$valor_x=$valor_x + $w[5];
		$pdf->Rect($valor_x,$valor_y,$w[6],15);
		$pdf->SetXY($valor_x,$valor_y); 
		$pdf->MultiCell($w[6],7,$row["libroregistro_fecha_recepcion"],0,'L',0);
	
		$valor_x=$valor_x + $w[6];
		$pdf->Rect($valor_x,$valor_y,$w[7],15);
		$pdf->SetXY($valor_x,$valor_y); 
		$pdf->MultiCell($w[7],8,$row["libroregistro_hoja_ruta"],0,'L',0);
	
		$valor_x=$valor_x + $w[7];
		$pdf->Rect($valor_x,$valor_y,$w[8],15);
		$pdf->SetXY($valor_x,$valor_y); 
		$pdf->MultiCell($w[8],9,$row["libroregistro_hojas"],0,'L',0);
		
		$valor_x=$valor_x + $w[8];
		$pdf->Rect($valor_x,$valor_y,$w[9],15);
		$pdf->SetXY($valor_x,$valor_y); 
		$pdf->MultiCell($w[9],10,$row["libroregistro_referencia"],0,'L',0);
		
		$valor_x=$valor_x + $w[9];
		$pdf->Rect($valor_x,$valor_y,$w[10],15);
		$pdf->SetXY($valor_x,$valor_y); 
		$pdf->MultiCell($w[10],5,"  ",0,'L',0);

		/*$valor_x=$valor_x + $w[2];
		$pdf->Rect($valor_x,$valor_y,$w[3],25);
		$pdf->SetXY($valor_x,$valor_y); 
		$pdf->MultiCell($w[3],5,$datos_hr1,0,'C',0);*/

		$valor_y=$valor_y + 15;
	
	
  }
}

$pdf->Output();
?> 
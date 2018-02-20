<?php
 //include ("datos/conexion.php");
 //require ("datos/functions.lib.php");
 include('pdf4/mpdf.php');
 //include('libreria.php');

 //$conexion = conectar ();

 //$f1=$_POST["campo1"];
 //$f2=$_POST["campo2"];
 //$estado=$_POST["campo3"];

 //$titulo=strtoupper($vt);
$html.='
	<table border="1" cellspacing="4" cellpadding="0" width="100%" style="font-family:Arial, Helvetica, sans-serif; font-size:8pt;">
		<tr>
        	<td width="5%">&nbsp;</td>
	        <td valign="center"><img src="escudo_bol.png"/></td>
	        <td width="5%">&nbsp;</td>
	        <td align="center" width="60%">ESTADO PLURINACIONAL DE BOLIVIA<br/>
	            Ministerio de Salud y Deportes<br/>
	            Area de Sistemas<br/>
	        <td width="5%">&nbsp;</td>
	        <td valign="center"><img src="escudo.gif"/></td>
	        <td width="5%">&nbsp;</td>
    	</tr>
    </table>

';
/*
$html.='
		<table border="0" align="center" style="font-family:Arial, Helvetica, sans-serif; font-size:8pt;">
                <tr >
                    <td>&nbsp;</td>
	                <td><b>DESEMBOLSO POR FECHAS
                    	DE FECHA : '.utf8_encode ($f1).' A LA FECHA: '.utf8_encode ($f2).'
	                </td>
                    <td>&nbsp;</td>

	            </tr>
     		</table> ';

          $html.='
       	  <table width="800" border="1" cellspacing="1" cellpadding="1" style="font-family:Arial, Helvetica, sans-serif; font-size:7pt;">
                  <tr>
	                <th width="10%">COD_PROYECTO</th>
	                <th width="25%">NOMBRE DE PROYECTO </th>
	                <th width="5%" align="center">SP</th>
	                <th width="5%" align="center">Nro Viv </th>
	                <th width="5%" align="center">Nro DESEM </th>
	                <th width="5" align="center">C.O.</th>
	                <th width="10%" align="center">FECHA</th>
	                <th width="10%" align="center">FECHA REC. </th>
	                <th width="10%" align="center">FECHA DESEM. </th>
	                <th width="5%" align="center">CHEQUE</th>
	                <th width="10%" align="center">IMPORTE Bs. </th>
	              </tr>

              ';

                		$qfechas = "SELECT
	                                p.proy_id,
	                                p.proy_cod,
	                                p.proy_nombre,
	                                p.proy_subprograma,
	                                p.proy_numViviendas,
	                                d.num_desembolso,
	                                d.desem_num_carta_operativa,
	                                d.desem_fecha_desembolso,
	                                d.desem_num_cheque,
	                                d.desem_importe_desembolso
	                                FROM desembolso d, proyecto p
	                                where p.proy_id=d.id_proy
	                                AND d.desem_fecha_desembolso >='$f1'
	                                AND d.desem_fecha_desembolso <='$f2'
	                                order by d.desem_fecha_desembolso ";
	                    $rfechas = mysql_query($qfechas,$conexion);
                        $total_desem=0;
	                    while ($rwfech=mysql_fetch_array($rfechas))
                        	{
                                 $dat1=fecha_mysql2($rwfech[7]);

                                 $qf = "select
                    	            fecha_emision,
	                                fecha_recepcion
	                                from fondesiv_dat where num_carta_ope='$rwfech[6]'";
                        	    $ref = mysql_query($qf,$conexion);
	                            $recf = mysql_fetch_array($ref);
	                            $fec_emi=fecha_mysql2($recf[0]);
	                            $fec_rec=fecha_mysql2($recf[1]);

                                $m_desem=number_format($rwfech[9],2,",",".");

						$html.='
                                    <tr>
	                                    <td width="10%">'.utf8_encode ($rwfech[1]).'</td>
	                                    <td width="25%">'.utf8_encode ($rwfech[2]).'</td>
	                                    <td width="5%" align="center">'.utf8_encode ($rwfech[3]).'</td>
	                                    <td width="5%" align="center">'.utf8_encode ($rwfech[4]).'</td>
	                                    <td width="5%" align="center">'.utf8_encode ($rwfech[5]).'</td>
	                                    <td width="5%" align="right">'.utf8_encode ($rwfech[6]).'</td>
	                                    <td width="10%" align="right">'.utf8_encode ($fec_emi).'</td>
	                                    <td width="10%" align="right">'.utf8_encode ($fec_rec).'</td>
	                                    <td width="10%" align="right">'.utf8_encode ($dat1).'</td>
	                                    <td width="5%" align="right">'.utf8_encode ($rwfech[8]).'</td>
	                                    <td width="10%" align="right">'.utf8_encode ($m_desem).'</td>
	                                  </tr>

                            ';

                            $total_desem=$total_desem+$rwfech[9] ;
                            }

                            $total_desem1=number_format($total_desem,2,",",".");

                            $html.='
              </table>

              <table width="800" border="0" cellspacing="1" cellpadding="1" style="font-family:Arial, Helvetica, sans-serif; font-size:9pt;">
	              <tr>
	                <td>&nbsp;</td>
	                <th align="right">TOTAL DE LOS DESEMBOLSOS</td>
	                <th align="right">'.utf8_encode ($total_desem1).'</td>
	              </tr>
	            </table>

';
*/

$mpdf=new mPDF ('','LEGAL','','',10,8,5,20);
//$mpdf->AddPage('','','','','','',5,5,10,5,1,5);
//$mpdf->AddPage('L','','','','','','','','','','','');
$mpdf->AddPage();
$mpdf->SetFooter('Encargado de Fideicomiso|{PAGENO} de {nb}|Copyright {DATE j-m-Y}');
$mpdf->WriteHTML($html);

$mpdf->Output();


exit;

?>
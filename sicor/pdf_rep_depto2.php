<?php
/*
header("Content-type: application/pdf");
header("Content-Length: $len");
header("Content-Disposition: inline; filename=reportin.pdf");
header("Cache-Control: post-check=0, pre-check=0", false);
header("Pragma: no-cache");
*/
 include ("datos/conexion.php");
 //require ("datos/functions.lib.php");
 include('pdf4/mpdf.php');
 //require('libreria.php');

 $conexion = conectar ();

 $formato=$_POST["campo1"];
 $depto=$_POST["campo2"];
 $estado=$_POST["campo3"];

 //$titulo=strtoupper($vt);
$html.='
	<table border="0" cellspacing="4" cellpadding="0" width="100%" style="font-family:Arial, Helvetica, sans-serif; font-size:8pt;">
		<tr>
        	<td width="5%">&nbsp;</td>
	        <td valign="center"><img src="imagenes2/escudo.png"/></td>
	        <td width="5%">&nbsp;</td>
	        <td align="center" width="60%">ESTADO PLURINACIONAL DE BOLIVIA<br/>
	            Ministerio de Obras P&uacute;blicas, Servicios y Vivienda<br/>
	            Viceministerio de Vivienda y Urbanismo<br/>
	        <td width="5%">&nbsp;</td>
	        <td valign="center"><img src="imagenes2/logo_viceministerio2.png"/></td>
	        <td width="5%">&nbsp;</td>
    	</tr>
    </table>
     <table align="center" border="0" cellspacing="4" cellpadding="0" width="800" style="font-family:Arial, Helvetica, sans-serif; font-size:6pt;">
        <tr>
            <th align="center" style="font-size:8pt">REPORTE DEPARTAMENTAL Y ESTADO DE PROYECTO<br/>
           (Expresado en Bolivianos)</th>
        </tr>
    </table>
';
switch ($formato)
        {
	            case 1:
                {  	$html.='
                               <table width="800" border="1" align="center" cellspacing="0" cellpadding="0" style="font-family:Arial, Helvetica, sans-serif; font-size:7pt;">
                                 <tr>
	                                <td>
                                    	<table width="800" border="1" cellspacing="0" cellpadding="0" style="font-family:Arial, Helvetica, sans-serif; font-size:7pt;">
	                                      <tr>
	                                        <td width="800">DEPARTAMENTO</td>
	                                      </tr>
	                                      <tr>
	                                        <td width="800">SUBPROGRAMA</td>
	                                      </tr>
                                          <tr>
	                                        <td>
                                              <table width="800" border="1" cellspacing="0" cellpadding="0" style="font-family:Arial, Helvetica, sans-serif; font-size:7pt;">
                                              	<tr>
	                                                <td width="2%">Nro</td>
	                                                <td width="10%">COD.PROY.</td>
	                                                <td width="30%">NOMBRE DEL PROYECTO </td>
	                                                <td width="3%">&nbsp;</td>
	                                                <td width="10%">ACTA</td>
	                                                <td width="7%">FECH. APR. </td>
	                                                <td width="7%">Nro VIV. </td>
	                                                <td width="10%" align="right">COMPROMETIDO</td>
	                                                <td width="10%">&nbsp;</td>
	                                                <td width="10%">&nbsp;</td>
	                                              </tr>
	                                              <tr>
	                                                <td width="2%">&nbsp;</td>
	                                                <td width="10%">&nbsp;</td>
	                                                <td width="30%">&nbsp;</td>
	                                                <td width="3%">Nro</td>
	                                                <td width="10%" align="right">CARTA OPERATIVO </td>
	                                                <td width="7%" align="right">CHEQUE</td>
	                                                <td width="7%" align="right">FES.DES.</td>
	                                                <td width="10%">&nbsp;</td>
	                                                <td width="10%" align="right">Imp. Desembolso </td>
	                                                <td width="10%" align="right">Saldo x Desembolso </td>
	                                              </tr>
	                                          </table>
                                            </td>
	                                      </tr>

	                                    </table>
                                    </td>
	                              </tr>
                                  ';
                                  if($depto=='TODOS')
               	   				  {
	                                $query = "SELECT  DISTINCT ubi_departamento FROM ubicacion ORDER BY ubi_departamento";
	                                $result = mysql_query($query,$conexion);
	                                $dp1=0;
	                                while ($row=mysql_fetch_array($result))
	                                {    $dep[$dp1]=$row['ubi_departamento'];
	                                     $dp1=$dp1+1;
	                                 }
	                                mysql_free_result($result);

	                                if($estado=='TODOS')
                                     {
                                        $n_viv_nacional=0;
                                     	$monto_compr_nacional=0;
                                     	$monto_desem_nacional=0;

                                    	for($i=0;$i<count($dep);$i++)
	                                       {
											$html.='
                                          <tr >
	                               				<td width="800" ><b>'.utf8_encode ($dep[$i]).'</td>
	                              		  </tr>
                                          ';
                                                $quer = "SELECT DISTINCT
	                                                    p.proy_subprograma
	                                                    FROM ubicacion u, proyecto p
	                                                    where p.proy_id=u.id_proyecto
	                                                    AND u.ubi_departamento='$dep[$i]'
	                                                    ORDER BY (p.proy_subprograma)";
	                                            $resul = mysql_query($quer,$conexion);

                                                $n_viv_depto=0;
                                                $monto_compr_depto=0;
                                                $monto_desem_depto=0;

	                                            while ($row1=mysql_fetch_array($resul))
	                                            {
											$html.='
                                           <tr >
	                                       		<td width="800"><b>SubPrograma N '.utf8_encode ($row1[0]).'</td>
	                                       </tr>

                                           <tr>
                                            <td>
                                                <table width="800" border="0" cellspacing="0" cellpadding="0" style="font-family:Arial, Helvetica, sans-serif; font-size:7pt;">
                                           ';
                                           			$que = "SELECT
                                                         p.proy_id,
	                                                     p.proy_cod,
	                                                     p.proy_nombre,
	                                                     p.proy_numActa,
	                                                     p.proy_fechaAprobacion,
	                                                     p.proy_numViviendas,
	                                                     p.proy_monto_total_aprobado,
                                                         p.proy_subprograma

	                                                    FROM proyecto p, ubicacion u
	                                                    where p.proy_id=u.id_proyecto
	                                                    and p.proy_subprograma='$row1[0]'
	                                                    and u.ubi_departamento='$dep[$i]'
	                                                    ORDER BY (p.proy_cod)";
	                                                $resu = mysql_query($que,$conexion);
	                                                $st1=0;

                                                    $cont_d_proy=0;//contador de proyecto

                                                    $n_viv=0;
                                                    $monto_compro_de_proyecto=0; //nomto comprometido por proyecto
                                                    $monto_desem_de_proyecto=0; //nomto desembolsado por proyecto

                                                    while ($row2=mysql_fetch_array($resu))
	                                                {     	$cont_d_proy=$cont_d_proy+1;
                                                    		$m_desem=number_format($row2[6],2,",",".");
										   			$html.='
	                                                <tr>
                                                        <td width="2%">'.utf8_encode ($cont_d_proy).'</td>
	                                                    <td width="10%">'.utf8_encode ($row2[1]).'</td>
	                                                    <td width="30%">'.utf8_encode ($row2[2]).'</td>
	                                                    <td width="3%">&nbsp;</td>
	                                                    <td width="10%" align="right">'.utf8_encode ($row2[3]).'</td>
	                                                    <td width="7%" align="right">'.utf8_encode ($row2[4]).'</td>
	                                                    <td width="7%" align="right">'.utf8_encode ($row2[5]).'</td>
	                                                    <td width="10%" align="right">'.utf8_encode ($m_desem).'</td>
	                                                    <td width="10%">&nbsp;</td>
	                                                    <td width="10%">&nbsp;</td>
	                                                  </tr>
                                                      ';

	                                                  		$qdesem = "SELECT * FROM desembolso WHERE id_proy='$row2[0]'";
	                                                        $rdesem = mysql_query($qdesem,$conexion);

	                                                        $sw=1;
	                                                        $monto_desembolso=0;
	                                                        $saldo_proyecto=0;

	                                                        while ($rowdesem=mysql_fetch_array($rdesem))
	                                                        {     $imp_desem=number_format($rowdesem[7],2,",",".");
	                                                        $html.='
	                                                        <tr align="right">
	                                                        	<td width="2%">&nbsp;</td>
	                                                            <td width="10%">&nbsp;</td>
	                                                            <td width="30%">&nbsp;</td>
	                                                            <td width="3%" align="right">'.utf8_encode ($rowdesem[2]).'</td>
	                                                            <td width="10%" align="right">'.utf8_encode ($rowdesem[5]).'</td>
	                                                            <td width="7%" align="right">'.utf8_encode ($rowdesem[8]).'</td>
	                                                            <td width="7%" align="right">'.utf8_encode ($rowdesem[6]).'</td>
	                                                            <td width="10%">&nbsp;</td>
	                                                            <td width="10%" align="right">'.utf8_encode ($imp_desem).'</td>
	                                                            <td width="10%">&nbsp;</td>
	                                                        </tr>
	                                                  ';
	                                                            $monto_desembolso=$monto_desembolso+$rowdesem[7];
	                                                            } //fin de DESEMBOLSO
	                                                            $saldo_proyecto=$row2[6]-$monto_desembolso;

                                                                $monto_desembolso2=number_format($monto_desembolso,2,",",".");
                                                                $saldo_proyecto2=number_format($saldo_proyecto,2,",",".");
                                                       $html.='

                                                       <tr align="right">
                                                       	<td >&nbsp;</td>
                                                        <td >&nbsp;</td>
                                                        <td >&nbsp;</td>
                                                        <td colspan="5"  align="right"><b>Total del Proyecto Bs.</td>
                                                        <td align="right"><b>'.utf8_encode ($monto_desembolso2).'</td>
                                                        <td align="right"><b>'.utf8_encode ($saldo_proyecto2).'</td>
                                                      </tr>

													   ';
                                                             $n_viv=$n_viv+$row2[5];
                                                             $monto_compro_de_proyecto=$monto_compro_de_proyecto+$row2[6]; //nomto comprometido por proyecto
                                                    		 $monto_desem_de_proyecto=$monto_desem_de_proyecto+$monto_desembolso; //nomto desembolsado por proyecto

                                                             }
                                                             $saldo_subpr=$monto_compro_de_proyecto-$monto_desem_de_proyecto;

                                                             $monto_compro_de_proyecto2=number_format($monto_compro_de_proyecto,2,",",".");
                                                             $monto_desem_de_proyecto2=number_format($monto_desem_de_proyecto,2,",",".");
                                                             $saldo_subpr2=number_format($saldo_subpr,2,",",".");

	                                                    //mysql_free_result($resu);
                                                       $sp[$j]='';
                                                       $html.='


	                                                </table>
	                                            </td>
	                                      </tr>

                                          <tr>
                                    	    <td><table width="800" border="1" cellspacing="0" cellpadding="0" style="font-family:Arial, Helvetica, sans-serif; font-size:7pt;">
	                                          <tr align="right">
	                                            <td width="30%">&nbsp;</td>
	                                            <td width="30%" align="right">Subtotal del Subprograma en Bs. </td>
	                                            <td width="10%" align="right">Nro Viv.'.utf8_encode ($n_viv).'</td>
	                                            <td width="10%" align="right">'.utf8_encode ($monto_compro_de_proyecto2).'</td>
	                                            <td width="10%" align="right">'.utf8_encode ($monto_desem_de_proyecto2).'</td>
	                                            <td width="10%" align="right">'.utf8_encode ($saldo_subpr2).'</td>
	                                          </tr>
	                                        </table></td>
	                                      </tr>
                                       ';
                                                       	$n_viv_depto=$n_viv_depto+$n_viv;
                                                		$monto_compr_depto=$monto_compr_depto+$monto_compro_de_proyecto;
                                                		$monto_desem_depto=$monto_desem_depto+$monto_desem_de_proyecto;
                                                      }
                                                      $saldo_depto=$monto_compr_depto-$monto_desem_depto;

                                       $html.='

                                  <tr>
	                                <td><table width="800" border="1" cellspacing="0" cellpadding="0" style="font-family:Arial, Helvetica, sans-serif; font-size:7pt;">
	                                  <tr align="right">
	                                  	 <td width="30%">&nbsp;</td>
	                                     <td width="30%" align="right"><b>SUBTOTAL DEL DEPARTAMENTO EN Bs: </td>
                                         <td width="10%" align="right">Nro Viv.'.utf8_encode ($n_viv_depto).'</td>
                                         <td width="10%" align="right">'.utf8_encode ($monto_compr_depto).'</td>
	                                     <td width="10%" align="right">'.utf8_encode ($monto_desem_depto).'</td>
	                                     <td width="10%" align="right">'.utf8_encode ($saldo_depto).'</td>
	                                   </tr>
	                                </table></td>
	                              </tr>

                                  ';
                                     $n_viv_nacional=$n_viv_nacional+$n_viv_depto;
                                     $monto_compr_nacional=$monto_compr_nacional+$monto_compr_depto;
                                     $monto_desem_nacional=$monto_desem_nacional+$monto_desem_depto;
                                     }  // fin de for
                                     $saldo_nacional=$monto_compr_nacional-$monto_desem_nacional;

                                 $html.='
                                  <tr>
                                     <td><table width="800" border="1" cellspacing="0" cellpadding="0" style="font-family:Arial, Helvetica, sans-serif; font-size:7pt;">
                                       <tr align="right">
                                         <td width="30%">&nbsp;</td>
                                         <td width="30%" align="right"><b>TOTAL NACIONAL EN Bs: </td>
                                         <td width="10%" align="right">Nro Viv.'.utf8_encode ($n_viv_nacional).'</td>
                                         <td width="10%" align="right">'.utf8_encode ($monto_compr_nacional).'</td>
                                         <td width="10%" align="right">'.utf8_encode ($monto_desem_nacional).'</td>
                                         <td width="10%" align="right">'.utf8_encode ($saldo_nacional).'</td>
                                      </tr>
                                    </table></td>
                                  </tr>

                                    ';
	                                 } //fin de if de estado=todos
                                    else
                                    {
                                        $n_viv_nacional=0;
                                     	$monto_compr_nacional=0;
                                     	$monto_desem_nacional=0;

                                    	for($i=0;$i<count($dep);$i++)
	                                       {
											$html.='
                                          <tr >
	                               				<td width="800" ><b>'.utf8_encode ($dep[$i]).'</td>
	                              		  </tr>
                                          ';
                                                $quer = "SELECT DISTINCT
	                                                    p.proy_subprograma
	                                                    FROM ubicacion u, proyecto p
	                                                    where p.proy_id=u.id_proyecto
	                                                    AND u.ubi_departamento='$dep[$i]'
                                                        and p.proy_situacion='$estado'
	                                                    ORDER BY (p.proy_subprograma)";
	                                            $resul = mysql_query($quer,$conexion);

                                                $n_viv_depto=0;
                                                $monto_compr_depto=0;
                                                $monto_desem_depto=0;

	                                            while ($row1=mysql_fetch_array($resul))
	                                            {
											$html.='
                                           <tr >
	                                       		<td width="800"><b>SubPrograma N '.utf8_encode ($row1[0]).'</td>
	                                       </tr>

                                           <tr>
                                            <td>
                                                <table width="800" border="0" cellspacing="0" cellpadding="0" style="font-family:Arial, Helvetica, sans-serif; font-size:7pt;">
                                           ';
                                           			$que = "SELECT
                                                         p.proy_id,
	                                                     p.proy_cod,
	                                                     p.proy_nombre,
	                                                     p.proy_numActa,
	                                                     p.proy_fechaAprobacion,
	                                                     p.proy_numViviendas,
	                                                     p.proy_monto_total_aprobado,
                                                         p.proy_subprograma

	                                                    FROM proyecto p, ubicacion u
	                                                    where p.proy_id=u.id_proyecto
	                                                    and p.proy_subprograma='$row1[0]'
	                                                    and u.ubi_departamento='$dep[$i]'
                                                        and p.proy_situacion='$estado'
	                                                    ORDER BY (p.proy_cod)";
	                                                $resu = mysql_query($que,$conexion);
	                                                $st1=0;

                                                    $cont_d_proy=0;//contador de proyecto

                                                    $n_viv=0;
                                                    $monto_compro_de_proyecto=0; //nomto comprometido por proyecto
                                                    $monto_desem_de_proyecto=0; //nomto desembolsado por proyecto

                                                    while ($row2=mysql_fetch_array($resu))
	                                                {     $cont_d_proy=$cont_d_proy+1;
										   $html.='
	                                                <tr>
                                                        <td width="2%">'.utf8_encode ($cont_d_proy).'</td>
	                                                    <td width="10%">'.utf8_encode ($row2[1]).'</td>
	                                                    <td width="30%">'.utf8_encode ($row2[2]).'</td>
	                                                    <td width="3%">&nbsp;</td>
	                                                    <td width="10%" align="right">'.utf8_encode ($row2[3]).'</td>
	                                                    <td width="7%" align="right">'.utf8_encode ($row2[4]).'</td>
	                                                    <td width="7%" align="right">'.utf8_encode ($row2[5]).'</td>
	                                                    <td width="10%" align="right">'.utf8_encode ($row2[6]).'</td>
	                                                    <td width="10%">&nbsp;</td>
	                                                    <td width="10%">&nbsp;</td>
	                                                  </tr>
                                                      ';

	                                                  		$qdesem = "SELECT * FROM desembolso WHERE id_proy='$row2[0]'";
	                                                        $rdesem = mysql_query($qdesem,$conexion);

	                                                        $sw=1;
	                                                        $monto_desembolso=0;
	                                                        $saldo_proyecto=0;

	                                                        while ($rowdesem=mysql_fetch_array($rdesem))
	                                                        {
	                                                        $html.='
	                                                        <tr align="right">
	                                                        	<td width="2%">&nbsp;</td>
	                                                            <td width="10%">&nbsp;</td>
	                                                            <td width="30%">&nbsp;</td>
	                                                            <td width="3%" align="right">'.utf8_encode ($rowdesem[2]).'</td>
	                                                            <td width="10%" align="right">'.utf8_encode ($rowdesem[5]).'</td>
	                                                            <td width="7%" align="right">'.utf8_encode ($rowdesem[8]).'</td>
	                                                            <td width="7%" align="right">'.utf8_encode ($rowdesem[6]).'</td>
	                                                            <td width="10%">&nbsp;</td>
	                                                            <td width="10%" align="right">'.utf8_encode ($rowdesem[7]).'</td>
	                                                            <td width="10%">&nbsp;</td>
	                                                        </tr>
	                                                  ';
	                                                            $monto_desembolso=$monto_desembolso+$rowdesem[7];
	                                                            } //fin de DESEMBOLSO
	                                                            $saldo_proyecto=$row2[6]-$monto_desembolso;

                                                       $html.='

                                                       <tr align="right">
                                                       	<td >&nbsp;</td>
                                                        <td >&nbsp;</td>
                                                        <td >&nbsp;</td>
                                                        <td colspan="5" align="right"><b>Total del Proyecto Bs.</td>
                                                        <td align="right">'.utf8_encode ($monto_desembolso).'</td>
                                                        <td align="right">'.utf8_encode ($saldo_proyecto).'</td>
                                                      </tr>

													   ';
                                                             $monto_compro_de_proyecto=$monto_compro_de_proyecto+$row2[6]; //nomto comprometido por proyecto
                                                    		 $monto_desem_de_proyecto=$monto_desem_de_proyecto+$monto_desembolso; //nomto desembolsado por proyecto
                                                             $n_viv=$n_viv+$row2[5];
                                                             }
                                                             $saldo_subpr=$monto_compro_de_proyecto-$monto_desem_de_proyecto;
	                                                    //mysql_free_result($resu);
                                                       $sp[$j]='';
                                                       $html.='


	                                                </table>
	                                            </td>
	                                      </tr>

                                          <tr>
                                    	    <td><table width="800" border="1" cellspacing="0" cellpadding="0" style="font-family:Arial, Helvetica, sans-serif; font-size:7pt;">
	                                          <tr align="right">
	                                            <td width="30%">&nbsp;</td>
	                                            <td width="30%" align="right"><b>SUBTOTAL DEL SUBPROGRAMA EN Bs: </td>
	                                            <td width="10%" align="right">Nro Viv.'.utf8_encode ($n_viv).'</td>
	                                            <td width="10%" align="right">'.utf8_encode ($monto_compro_de_proyecto).'</td>
	                                            <td width="10%" align="right">'.utf8_encode ($monto_desem_de_proyecto).'</td>
	                                            <td width="10%" align="right">'.utf8_encode ($saldo_subpr).'</td>
	                                          </tr>
	                                        </table></td>
	                                      </tr>
                                       ';
                                                       	$n_viv_depto=$n_viv_depto+$n_viv;
                                                		$monto_compr_depto=$monto_compr_depto+$monto_compro_de_proyecto;
                                                		$monto_desem_depto=$monto_desem_depto+$monto_desem_de_proyecto;
                                                      }
                                                      $saldo_depto=$monto_compr_depto-$monto_desem_depto;
                                       $html.='

                                  <tr>
	                                <td><table width="800" border="1" cellspacing="0" cellpadding="0" style="font-family:Arial, Helvetica, sans-serif; font-size:7pt;">
	                                  <tr align="right">
	                                  	<td width="30%">&nbsp;</td>
	                                     <td width="30%" align="right"><b>SUBTOTAL DEL DEPARTAMENTO EN Bs: </td>
                                         <td width="10%" align="right">Nro Viv.'.utf8_encode ($n_viv_depto).'</td>
                                         <td width="10%" align="right">'.utf8_encode ($monto_compr_depto).'</td>
	                                     <td width="10%" align="right">'.utf8_encode ($monto_desem_depto).'</td>
	                                     <td width="10%" align="right">'.utf8_encode ($saldo_depto).'</td>
	                                   </tr>
	                                </table></td>
	                              </tr>

                                  ';
                                     $n_viv_nacional=$n_viv_nacional+$n_viv_depto;
                                     $monto_compr_nacional=$monto_compr_nacional+$monto_compr_depto;
                                     $monto_desem_nacional=$monto_desem_nacional+$monto_desem_depto;
                                     }  // fin de for
                                     $saldo_nacional=$monto_compr_nacional-$monto_desem_nacional;

                                 $html.='
                                  <tr>
                                     <td><table width="800" border="1" cellspacing="0" cellpadding="0" style="font-family:Arial, Helvetica, sans-serif; font-size:7pt;">
                                       <tr align="right">
                                         <td width="30%">&nbsp;</td>
                                         <td width="30%" align="right"><b>TOTAL NACIONAL EN Bs: </td>
                                         <td width="10%" align="right">Nro Viv.'.utf8_encode ($n_viv_nacional).'</td>
                                         <td width="10%" align="right">'.utf8_encode ($monto_compr_nacional).'</td>
                                         <td width="10%" align="right">'.utf8_encode ($monto_desem_nacional).'</td>
                                         <td width="10%" align="right">'.utf8_encode ($saldo_nacional).'</td>
                                      </tr>
                                    </table></td>
                                  </tr>
                                    ';


                                    }//fin de else de estado=1

                                 }   //fin de if depto=todos


                               else
                                 {
                                  	$query = "SELECT  DISTINCT ubi_departamento
	                                            FROM ubicacion
	                                            WHERE ubi_departamento='$depto'
	                                            ORDER BY ubi_departamento";

	                                $result = mysql_query($query,$conexion);
                                   	$row=mysql_fetch_array($result);

	                                mysql_free_result($result);


	                                if($estado=='TODOS')
                                     {
                                        $n_viv_nacional=0;
                                     	$monto_compr_nacional=0;
                                     	$monto_desem_nacional=0;

                                    	for($i=0;$i<count($row);$i++)
	                                       {
											$html.='
                                          <tr >
	                               				<td width="800" ><b>'.utf8_encode ($row[$i]).'</td>
	                              		  </tr>
                                          ';
                                                $quer = "SELECT DISTINCT
	                                                    p.proy_subprograma
	                                                    FROM ubicacion u, proyecto p
	                                                    where p.proy_id=u.id_proyecto
	                                                    AND u.ubi_departamento='$row[$i]'
	                                                    ORDER BY (p.proy_subprograma)";
	                                            $resul = mysql_query($quer,$conexion);

                                                $n_viv_depto=0;
                                                $monto_compr_depto=0;
                                                $monto_desem_depto=0;

	                                            while ($row1=mysql_fetch_array($resul))
	                                            {
											$html.='
                                           <tr >
	                                       		<td width="800"><b>SubPrograma N '.utf8_encode ($row1[0]).'</td>
	                                       </tr>

                                           <tr>
                                            <td>
                                                <table width="800" border="0" cellspacing="0" cellpadding="0" style="font-family:Arial, Helvetica, sans-serif; font-size:7pt;">
                                           ';
                                           			$que = "SELECT
                                                         p.proy_id,
	                                                     p.proy_cod,
	                                                     p.proy_nombre,
	                                                     p.proy_numActa,
	                                                     p.proy_fechaAprobacion,
	                                                     p.proy_numViviendas,
	                                                     p.proy_monto_total_aprobado,
                                                         p.proy_subprograma

	                                                    FROM proyecto p, ubicacion u
	                                                    where p.proy_id=u.id_proyecto
	                                                    and p.proy_subprograma='$row1[0]'
	                                                    and u.ubi_departamento='$row[$i]'
	                                                    ORDER BY (p.proy_cod)";
	                                                $resu = mysql_query($que,$conexion);
	                                                $st1=0;

                                                    $cont_d_proy=0;//contador de proyecto

                                                    $n_viv=0;
                                                    $monto_compro_de_proyecto=0; //nomto comprometido por proyecto
                                                    $monto_desem_de_proyecto=0; //nomto desembolsado por proyecto

                                                    while ($row2=mysql_fetch_array($resu))
	                                                {     $cont_d_proy=$cont_d_proy+1;
										   $html.='
	                                                <tr>
                                                        <td width="2%">'.utf8_encode ($cont_d_proy).'</td>
	                                                    <td width="10%">'.utf8_encode ($row2[1]).'</td>
	                                                    <td width="30%">'.utf8_encode ($row2[2]).'</td>
	                                                    <td width="3%">&nbsp;</td>
	                                                    <td width="10%" align="right">'.utf8_encode ($row2[3]).'</td>
	                                                    <td width="7%" align="right">'.utf8_encode ($row2[4]).'</td>
	                                                    <td width="7%" align="right">'.utf8_encode ($row2[5]).'</td>
	                                                    <td width="10%" align="right">'.utf8_encode ($row2[6]).'</td>
	                                                    <td width="10%">&nbsp;</td>
	                                                    <td width="10%">&nbsp;</td>
	                                                  </tr>
                                                      ';

	                                                  		$qdesem = "SELECT * FROM desembolso WHERE id_proy='$row2[0]'";
	                                                        $rdesem = mysql_query($qdesem,$conexion);

	                                                        $sw=1;
	                                                        $monto_desembolso=0;
	                                                        $saldo_proyecto=0;

	                                                        while ($rowdesem=mysql_fetch_array($rdesem))
	                                                        {
	                                                        $html.='
	                                                        <tr align="right">
	                                                        	<td width="2%">&nbsp;</td>
	                                                            <td width="10%">&nbsp;</td>
	                                                            <td width="30%">&nbsp;</td>
	                                                            <td width="3%" align="right">'.utf8_encode ($rowdesem[2]).'</td>
	                                                            <td width="10%" align="right">'.utf8_encode ($rowdesem[5]).'</td>
	                                                            <td width="7%" align="right">'.utf8_encode ($rowdesem[8]).'</td>
	                                                            <td width="7%" align="right">'.utf8_encode ($rowdesem[6]).'</td>
	                                                            <td width="10%">&nbsp;</td>
	                                                            <td width="10%" align="right">'.utf8_encode ($rowdesem[7]).'</td>
	                                                            <td width="10%">&nbsp;</td>
	                                                        </tr>
	                                                  ';
	                                                            $monto_desembolso=$monto_desembolso+$rowdesem[7];
	                                                            } //fin de DESEMBOLSO
	                                                            $saldo_proyecto=$row2[6]-$monto_desembolso;

                                                       $html.='

                                                       <tr align="right">
                                                       	<td >&nbsp;</td>
                                                        <td >&nbsp;</td>
                                                        <td >&nbsp;</td>
                                                        <td colspan="5"  align="right"><b>Total del Proyecto Bs.</td>
                                                        <td align="right">'.utf8_encode ($monto_desembolso).'</td>
                                                        <td align="right">'.utf8_encode ($saldo_proyecto).'</td>
                                                      </tr>

													   ';
                                                             $monto_compro_de_proyecto=$monto_compro_de_proyecto+$row2[6]; //nomto comprometido por proyecto
                                                    		 $monto_desem_de_proyecto=$monto_desem_de_proyecto+$monto_desembolso; //nomto desembolsado por proyecto
                                                             $n_viv=$n_viv+$row2[5];
                                                             }
                                                             $saldo_subpr=$monto_compro_de_proyecto-$monto_desem_de_proyecto;
	                                                    //mysql_free_result($resu);
                                                       $sp[$j]='';
                                                       $html.='


	                                                </table>
	                                            </td>
	                                      </tr>

                                          <tr>
                                    	    <td><table width="800" border="1" cellspacing="0" cellpadding="0" style="font-family:Arial, Helvetica, sans-serif; font-size:7pt;">
	                                          <tr align="right">
	                                            <td width="30%">&nbsp;</td>
	                                            <td width="30%" align="right"><b>SUBTOTAL DEL SUBPROGRAMA EN Bs: </td>
	                                            <td width="10%" align="right">Nro Viv.'.utf8_encode ($n_viv).'</td>
	                                            <td width="10%" align="right">'.utf8_encode ($monto_compro_de_proyecto).'</td>
	                                            <td width="10%" align="right">'.utf8_encode ($monto_desem_de_proyecto).'</td>
	                                            <td width="10%" align="right">'.utf8_encode ($saldo_subpr).'</td>
	                                          </tr>
	                                        </table></td>
	                                      </tr>
                                       ';
                                                       	$n_viv_depto=$n_viv_depto+$n_viv;
                                                		$monto_compr_depto=$monto_compr_depto+$monto_compro_de_proyecto;
                                                		$monto_desem_depto=$monto_desem_depto+$monto_desem_de_proyecto;
                                                      }
                                                      $saldo_depto=$monto_compr_depto-$monto_desem_depto;

                                       if($row[$i]!=''){
                                       $html.='
                                  <tr>
	                                <td><table width="800" border="1" cellspacing="0" cellpadding="0" style="font-family:Arial, Helvetica, sans-serif; font-size:7pt;">
	                                  <tr align="right">
	                                  	<td width="30%">&nbsp;</td>
	                                     <td width="30%" align="right"><b>SUBTOTAL DEL DEPARTAMENTO EN Bs: </td>
                                         <td width="10%" align="right">Nro Viv.'.utf8_encode ($n_viv_depto).'</td>
                                         <td width="10%" align="right">'.utf8_encode ($monto_compr_depto).'</td>
	                                     <td width="10%" align="right">'.utf8_encode ($monto_desem_depto).'</td>
	                                     <td width="10%" align="right">'.utf8_encode ($saldo_depto).'</td>
	                                   </tr>
	                                </table></td>
	                              </tr>

                                  '; 	}
                                     $n_viv_nacional=$n_viv_nacional+$n_viv_depto;
                                     $monto_compr_nacional=$monto_compr_nacional+$monto_compr_depto;
                                     $monto_desem_nacional=$monto_desem_nacional+$monto_desem_depto;
                                     }  // fin de for
                                     $saldo_nacional=$monto_compr_nacional-$monto_desem_nacional;

                                 $html.='
                                  <tr>
                                     <td><table width="800" border="1" cellspacing="0" cellpadding="0" style="font-family:Arial, Helvetica, sans-serif; font-size:7pt;">
                                       <tr align="right">
                                         <td width="30%">&nbsp;</td>
                                         <td width="30%" align="right"><b>TOTAL NACIONAL EN Bs: </td>
                                         <td width="10%" align="right">Nro Viv.'.utf8_encode ($n_viv_nacional).'</td>
                                         <td width="10%" align="right">'.utf8_encode ($monto_compr_nacional).'</td>
                                         <td width="10%" align="right">'.utf8_encode ($monto_desem_nacional).'</td>
                                         <td width="10%" align="right">'.utf8_encode ($saldo_nacional).'</td>
                                      </tr>
                                    </table></td>
                                  </tr>
                                    ';
	                                 } //fin de if de estado=todos
                                    else
                                    {
                                        $n_viv_nacional=0;
                                     	$monto_compr_nacional=0;
                                     	$monto_desem_nacional=0;

                                    	for($i=0;$i<count($row);$i++)
	                                       {
											$html.='
                                          <tr >
	                               				<td width="800" ><b>'.utf8_encode ($row[$i]).'</td>
	                              		  </tr>
                                          ';
                                                $quer = "SELECT DISTINCT
	                                                    p.proy_subprograma
	                                                    FROM ubicacion u, proyecto p
	                                                    where p.proy_id=u.id_proyecto
	                                                    AND u.ubi_departamento='$row[$i]'
                                                        and p.proy_situacion='$estado'
	                                                    ORDER BY (p.proy_subprograma)";
	                                            $resul = mysql_query($quer,$conexion);

                                                $n_viv_depto=0;
                                                $monto_compr_depto=0;
                                                $monto_desem_depto=0;

	                                            while ($row1=mysql_fetch_array($resul))
	                                            {
											$html.='
                                           <tr >
	                                       		<td width="800"><b>SubPrograma N '.utf8_encode ($row1[0]).'</td>
	                                       </tr>

                                           <tr>
                                            <td>
                                                <table width="800" border="0" cellspacing="0" cellpadding="0" style="font-family:Arial, Helvetica, sans-serif; font-size:7pt;">
                                           ';
                                           			$que = "SELECT
                                                         p.proy_id,
	                                                     p.proy_cod,
	                                                     p.proy_nombre,
	                                                     p.proy_numActa,
	                                                     p.proy_fechaAprobacion,
	                                                     p.proy_numViviendas,
	                                                     p.proy_monto_total_aprobado,
                                                         p.proy_subprograma

	                                                    FROM proyecto p, ubicacion u
	                                                    where p.proy_id=u.id_proyecto
	                                                    and p.proy_subprograma='$row1[0]'
	                                                    and u.ubi_departamento='$row[$i]'
                                                        and p.proy_situacion='$estado'
	                                                    ORDER BY (p.proy_cod)";
	                                                $resu = mysql_query($que,$conexion);
	                                                $st1=0;

                                                    $cont_d_proy=0;//contador de proyecto

                                                    $n_viv=0;
                                                    $monto_compro_de_proyecto=0; //nomto comprometido por proyecto
                                                    $monto_desem_de_proyecto=0; //nomto desembolsado por proyecto

                                                    while ($row2=mysql_fetch_array($resu))
	                                                {     $cont_d_proy=$cont_d_proy+1;
										   $html.='
	                                                <tr>
                                                        <td width="2%">'.utf8_encode ($cont_d_proy).'</td>
	                                                    <td width="10%">'.utf8_encode ($row2[1]).'</td>
	                                                    <td width="30%">'.utf8_encode ($row2[2]).'</td>
	                                                    <td width="3%">&nbsp;</td>
	                                                    <td width="10%" align="right">'.utf8_encode ($row2[3]).'</td>
	                                                    <td width="7%" align="right">'.utf8_encode ($row2[4]).'</td>
	                                                    <td width="7%" align="right">'.utf8_encode ($row2[5]).'</td>
	                                                    <td width="10%" align="right">'.utf8_encode ($row2[6]).'</td>
	                                                    <td width="10%">&nbsp;</td>
	                                                    <td width="10%">&nbsp;</td>
	                                                  </tr>
                                                      ';

	                                                  		$qdesem = "SELECT * FROM desembolso WHERE id_proy='$row2[0]'";
	                                                        $rdesem = mysql_query($qdesem,$conexion);

	                                                        $sw=1;
	                                                        $monto_desembolso=0;
	                                                        $saldo_proyecto=0;

	                                                        while ($rowdesem=mysql_fetch_array($rdesem))
	                                                        {
	                                                        $html.='
	                                                        <tr align="right">
	                                                        	<td width="2%">&nbsp;</td>
	                                                            <td width="10%">&nbsp;</td>
	                                                            <td width="30%">&nbsp;</td>
	                                                            <td width="3%" align="right">'.utf8_encode ($rowdesem[2]).'</td>  <!--NUMERO DE DESEMBOLSO -->
	                                                            <td width="10%" align="right">'.utf8_encode ($rowdesem[5]).'</td> <!--CARTA OPERATIVA -->
	                                                            <td width="7%" align="right">'.utf8_encode ($rowdesem[8]).'</td>  <!--NUMERO CHEQUE -->
	                                                            <td width="7%" align="right">'.utf8_encode ($rowdesem[6]).'</td> <!--FECHA DE DESEMBOLSO -->
	                                                            <td width="10%">&nbsp;</td>
	                                                            <td width="10%" align="right">'.utf8_encode ($rowdesem[7]).'</td> <!--IMPORTE DE DESEMBOLSO-->
	                                                            <td width="10%">&nbsp;</td>
	                                                        </tr>
	                                                  ';
	                                                            $monto_desembolso=$monto_desembolso+$rowdesem[7];
	                                                            } //fin de DESEMBOLSO
	                                                            $saldo_proyecto=$row2[6]-$monto_desembolso;

                                                       $html.='

                                                       <tr align="right">
                                                       	<td >&nbsp;</td>
                                                        <td >&nbsp;</td>
                                                        <td >&nbsp;</td>
                                                        <td colspan="5"  align="right">Total del Proyecto Bs.</td>
                                                        <td align="right">'.utf8_encode ($monto_desembolso).'</td>
                                                        <td align="right">'.utf8_encode ($saldo_proyecto).'</td>
                                                      </tr>

													   ';
                                                             $monto_compro_de_proyecto=$monto_compro_de_proyecto+$row2[6]; //nomto comprometido por proyecto
                                                    		 $monto_desem_de_proyecto=$monto_desem_de_proyecto+$monto_desembolso; //nomto desembolsado por proyecto
                                                             $n_viv=$n_viv+$row2[5];
                                                             }
                                                             $saldo_subpr=$monto_compro_de_proyecto-$monto_desem_de_proyecto;
	                                                    //mysql_free_result($resu);
                                                       $sp[$j]='';
                                                       $html.='


	                                                </table>
	                                            </td>
	                                      </tr>

                                          <tr>
                                    	    <td><table width="800" border="1" cellspacing="0" cellpadding="0" style="font-family:Arial, Helvetica, sans-serif; font-size:7pt;">
	                                          <tr align="right">
	                                            <td width="30%">&nbsp;</td>
	                                            <td width="30%" align="right"><b>SUBTOTAL DEL SUBPROGRAMA EN Bs: </td>
	                                            <td width="10%" align="right">Nro Viv.'.utf8_encode ($n_viv).'</td>
	                                            <td width="10%" align="right">'.utf8_encode ($monto_compro_de_proyecto).'</td>
	                                            <td width="10%" align="right">'.utf8_encode ($monto_desem_de_proyecto).'</td>
	                                            <td width="10%" align="right">'.utf8_encode ($saldo_subpr).'</td>
	                                          </tr>
	                                        </table></td>
	                                      </tr>
                                       ';
                                                       	$n_viv_depto=$n_viv_depto+$n_viv;
                                                		$monto_compr_depto=$monto_compr_depto+$monto_compro_de_proyecto;
                                                		$monto_desem_depto=$monto_desem_depto+$monto_desem_de_proyecto;
                                                      }
                                                      $saldo_depto=$monto_compr_depto-$monto_desem_depto;
                                   if($row[$i]!=''){
                                       $html.='
                                  <tr>
	                                <td><table width="800" border="1" cellspacing="0" cellpadding="0" style="font-family:Arial, Helvetica, sans-serif; font-size:7pt;">
	                                  <tr align="right">
	                                  	<td width="30%">&nbsp;</td>
	                                     <td width="30%" align="right"><b>SUBTOTAL DEL DEPARTAMENTO EN Bs: </td>
                                         <td width="10%" align="right">Nro Viv.'.utf8_encode ($n_viv_depto).'</td>
                                         <td width="10%" align="right">'.utf8_encode ($monto_compr_depto).'</td>
	                                     <td width="10%" align="right">'.utf8_encode ($monto_desem_depto).'</td>
	                                     <td width="10%" align="right">'.utf8_encode ($saldo_depto).'</td>
	                                   </tr>
	                                </table></td>
	                              </tr>
                                  ';
                                  		}
                                     $n_viv_nacional=$n_viv_nacional+$n_viv_depto;
                                     $monto_compr_nacional=$monto_compr_nacional+$monto_compr_depto;
                                     $monto_desem_nacional=$monto_desem_nacional+$monto_desem_depto;
                                     }  // fin de for
                                     $saldo_nacional=$monto_compr_nacional-$monto_desem_nacional;

                                 $html.='
                                  <tr>
                                     <td><table width="800" border="1" cellspacing="0" cellpadding="0" style="font-family:Arial, Helvetica, sans-serif; font-size:7pt;">
                                       <tr align="right">
                                         <td width="30%">&nbsp;</td>
                                         <td width="30%" align="right"><b>TOTAL NACIONAL EN Bs: </td>
                                         <td width="10%" align="right">Nro Viv.'.utf8_encode ($n_viv_nacional).'</td>
                                         <td width="10%" align="right">'.utf8_encode ($monto_compr_nacional).'</td>
                                         <td width="10%" align="right">'.utf8_encode ($monto_desem_nacional).'</td>
                                         <td width="10%" align="right">'.utf8_encode ($saldo_nacional).'</td>
                                      </tr>
                                    </table></td>
                                  </tr>
                                    ';

                                    }//fin de else de estado=1
                                 }
							$html.='
	                		</table>
                    		';

                    $mpdf=new mPDF ('','LETTER','','',10,8,5,20);
	                //$mpdf->AddPage('','','','','','',5,5,10,5,1,5);
	                $mpdf->AddPage('L','','','','','','','','','','','');
	                //$mpdf->AddPage();
	                $mpdf->SetFooter('Encargado de Fideicomiso|{PAGENO} de {nb}|Copyright {DATE j-m-Y}');
	                $mpdf->WriteHTML($html);

	                $mpdf->Output();
	            break;
                }
                
	            case 2:
                 {
                   $html.='
                               <table width="800" border="1" align="center" cellspacing="0" cellpadding="0" style="font-family:Arial, Helvetica, sans-serif; font-size:7pt;">
                                 <tr>
	                                <td>
                                    	<table width="800" border="1" cellspacing="0" cellpadding="0" style="font-family:Arial, Helvetica, sans-serif; font-size:7pt;">
	                                      <tr>
	                                        <td width="800">DEPARTAMENTO</td>
	                                      </tr>
	                                      <tr>
	                                        <td width="800">SUBPROGRAMA</td>
	                                      </tr>
	                                      <tr>
	                                        <td>
                                              <table width="800" border="1" cellspacing="0" cellpadding="0" style="font-family:Arial, Helvetica, sans-serif; font-size:7pt;">
                                              	<tr>
	                                                <td width="2%">Nro</td>
	                                                <td width="10%">COD.PROY.</td>
	                                                <td width="30%">NOMBRE DEL PROYECTO </td>
	                                                <td width="3%">&nbsp;</td>
	                                                <td width="10%" align="right">ACTA</td>
	                                                <td width="7%" align="right">FECH. APR. </td>
	                                                <td width="7%" align="right">Nro VIV. </td>
	                                                <td width="10%" align="right">COMPROMETIDO</td>
	                                                <td width="10%" align="right">DESEMBOLSO</td>
	                                                <td width="10%" align="right">SALDO X DESEM.</td>
	                                              </tr>
	                                          </table>
                                            </td>
	                                      </tr>

	                                    </table>
                                    </td>
	                              </tr>
                                  ';
                                  if($depto=='TODOS')
               	   				  {
	                                $query = "SELECT  DISTINCT ubi_departamento FROM ubicacion ORDER BY ubi_departamento";
	                                $result = mysql_query($query,$conexion);
	                                $dp1=0;
	                                while ($row=mysql_fetch_array($result))
	                                {    $dep[$dp1]=$row['ubi_departamento'];
	                                     $dp1=$dp1+1;
	                                 }
	                                mysql_free_result($result);

	                                if($estado=='TODOS')
                                     {
                                        $n_viv_nacional=0;
                                     	$monto_compr_nacional=0;
                                     	$monto_desem_nacional=0;

                                    	for($i=0;$i<count($dep);$i++)
	                                       {
											$html.='
                                          <tr >
	                               				<td width="800" ><b>'.utf8_encode ($dep[$i]).'</td>
	                              		  </tr>
                                          ';
                                                $quer = "SELECT DISTINCT
	                                                    p.proy_subprograma
	                                                    FROM ubicacion u, proyecto p
	                                                    where p.proy_id=u.id_proyecto
	                                                    AND u.ubi_departamento='$dep[$i]'
	                                                    ORDER BY (p.proy_subprograma)";
	                                            $resul = mysql_query($quer,$conexion);

                                                $n_viv_depto=0;
                                                $monto_compr_depto=0;
                                                $monto_desem_depto=0;

	                                            while ($row1=mysql_fetch_array($resul))
	                                            {
											$html.='
                                           <tr>
	                                       		<td width="800"><b>SubPrograma N '.utf8_encode ($row1[0]).'</td>
	                                       </tr>

                                           <tr>
                                            <td>
                                                <table width="800" border="0" cellspacing="0" cellpadding="0" style="font-family:Arial, Helvetica, sans-serif; font-size:7pt;">
                                           ';
                                           			$que = "SELECT
                                                         p.proy_id,
	                                                     p.proy_cod,
	                                                     p.proy_nombre,
	                                                     p.proy_numActa,
	                                                     p.proy_fechaAprobacion,
	                                                     p.proy_numViviendas,
	                                                     p.proy_monto_total_aprobado,
                                                         p.proy_subprograma

	                                                    FROM proyecto p, ubicacion u
	                                                    where p.proy_id=u.id_proyecto
	                                                    and p.proy_subprograma='$row1[0]'
	                                                    and u.ubi_departamento='$dep[$i]'
	                                                    ORDER BY (p.proy_cod)";
	                                                $resu = mysql_query($que,$conexion);
	                                                $st1=0;

                                                    $cont_d_proy=0;//contador de proyecto

                                                    $n_viv=0;
                                                    $monto_compro_de_proyecto=0; //nomto comprometido por proyecto
                                                    $monto_desem_de_proyecto=0; //nomto desembolsado por proyecto

                                                    while ($row2=mysql_fetch_array($resu))
	                                                {     $cont_d_proy=$cont_d_proy+1;

                                                          $qdesem = "SELECT * FROM desembolso WHERE id_proy='$row2[0]'";
	                                                        $rdesem = mysql_query($qdesem,$conexion);

	                                                        $sw=1;
	                                                        $monto_desembolso=0;
	                                                        $saldo_proyecto=0;

	                                                        while ($rowdesem=mysql_fetch_array($rdesem))
	                                                        {
	                                                            $monto_desembolso=$monto_desembolso+$rowdesem[7];
	                                                            } //fin de DESEMBOLSO
	                                                            $saldo_proyecto=$row2[6]-$monto_desembolso;
										   $html.='
	                                                <tr>
                                                        <td width="2%">'.utf8_encode ($cont_d_proy).'</td>
	                                                    <td width="10%">'.utf8_encode ($row2[1]).'</td>
	                                                    <td width="30%">'.utf8_encode ($row2[2]).'</td>
	                                                    <td width="3%">&nbsp;</td>
	                                                    <td width="10%" align="right">'.utf8_encode ($row2[3]).'</td>
	                                                    <td width="7%" align="right">'.utf8_encode ($row2[4]).'</td>
	                                                    <td width="7%" align="right">'.utf8_encode ($row2[5]).'</td>
	                                                    <td width="10%" align="right">'.utf8_encode ($row2[6]).'</td>
	                                                    <td width="10%" align="right">'.utf8_encode ($monto_desembolso).'</td>
	                                                    <td width="10%" align="right">'.utf8_encode ($saldo_proyecto).'</td>
	                                                  </tr>
													   ';
                                                             $monto_compro_de_proyecto=$monto_compro_de_proyecto+$row2[6]; //nomto comprometido por proyecto
                                                    		 $monto_desem_de_proyecto=$monto_desem_de_proyecto+$monto_desembolso; //nomto desembolsado por proyecto
                                                             $n_viv=$n_viv+$row2[5];
                                                             }
                                                             $saldo_subpr=$monto_compro_de_proyecto-$monto_desem_de_proyecto;
	                                                    //mysql_free_result($resu);
                                                       $sp[$j]='';
                                                       $html.='
	                                                </table>
	                                            </td>
	                                      </tr>

                                          <tr>
                                    	    <td><table width="800" border="1" cellspacing="0" cellpadding="0" style="font-family:Arial, Helvetica, sans-serif; font-size:7pt;">
	                                          <tr align="right">
	                                            <td width="30%">&nbsp;</td>
	                                            <td width="30%" align="right"><b>SUBTOTAL DEL SUBPROGRAMA EN Bs: </td>
	                                            <td width="10%" align="right">Nro Viv.'.utf8_encode ($n_viv).'</td>
	                                            <td width="10%" align="right">'.utf8_encode ($monto_compro_de_proyecto).'</td>
	                                            <td width="10%" align="right">'.utf8_encode ($monto_desem_de_proyecto).'</td>
	                                            <td width="10%" align="right">'.utf8_encode ($saldo_subpr).'</td>
	                                          </tr>
	                                        </table></td>
	                                      </tr>
                                       ';
                                                       	$n_viv_depto=$n_viv_depto+$n_viv;
                                                		$monto_compr_depto=$monto_compr_depto+$monto_compro_de_proyecto;
                                                		$monto_desem_depto=$monto_desem_depto+$monto_desem_de_proyecto;
                                                      }
                                                      $saldo_depto=$monto_compr_depto-$monto_desem_depto;
                                       $html.='

                                  <tr>
	                                <td><table width="800" border="1" cellspacing="0" cellpadding="0" style="font-family:Arial, Helvetica, sans-serif; font-size:7pt;">
	                                  <tr align="right">
	                                  	<td width="30%">&nbsp;</td>
	                                     <td width="30%" align="right"><b>SUBTOTAL DEL DEPARTAMENTO EN Bs: </td>
                                         <td width="10%" align="right">Nro Viv.'.utf8_encode ($n_viv_depto).'</td>
                                         <td width="10%" align="right">'.utf8_encode ($monto_compr_depto).'</td>
	                                     <td width="10%" align="right">'.utf8_encode ($monto_desem_depto).'</td>
	                                     <td width="10%" align="right">'.utf8_encode ($saldo_depto).'</td>
	                                   </tr>
	                                </table></td>
	                              </tr>

                                  ';
                                     $n_viv_nacional=$n_viv_nacional+$n_viv_depto;
                                     $monto_compr_nacional=$monto_compr_nacional+$monto_compr_depto;
                                     $monto_desem_nacional=$monto_desem_nacional+$monto_desem_depto;
                                     }  // fin de for
                                     $saldo_nacional=$monto_compr_nacional-$monto_desem_nacional;

                                 $html.='
                                  <tr>
                                     <td><table width="800" border="1" cellspacing="0" cellpadding="0" style="font-family:Arial, Helvetica, sans-serif; font-size:7pt;">
                                       <tr align="right">
                                         <td width="30%">&nbsp;</td>
                                         <td width="30%" align="right"><b>TOTAL NACIONAL EN Bs: </td>
                                         <td width="10%" align="right">Nro Viv.'.utf8_encode ($n_viv_nacional).'</td>
                                         <td width="10%" align="right">'.utf8_encode ($monto_compr_nacional).'</td>
                                         <td width="10%" align="right">'.utf8_encode ($monto_desem_nacional).'</td>
                                         <td width="10%" align="right">'.utf8_encode ($saldo_nacional).'</td>
                                      </tr>
                                    </table></td>
                                  </tr>
                                    ';
	                                 } //fin de if de estado=todos
                                    else
                                    {
                                        $n_viv_nacional=0;
                                     	$monto_compr_nacional=0;
                                     	$monto_desem_nacional=0;

                                    	for($i=0;$i<count($dep);$i++)
	                                       {
											$html.='
                                          <tr >
	                               				<td width="800" ><b>'.utf8_encode ($dep[$i]).'</td>
	                              		  </tr>
                                          ';
                                                $quer = "SELECT DISTINCT
	                                                    p.proy_subprograma
	                                                    FROM ubicacion u, proyecto p
	                                                    where p.proy_id=u.id_proyecto
	                                                    AND u.ubi_departamento='$dep[$i]'
                                                        and p.proy_situacion='$estado'
	                                                    ORDER BY (p.proy_subprograma)";
	                                            $resul = mysql_query($quer,$conexion);

                                                $n_viv_depto=0;
                                                $monto_compr_depto=0;
                                                $monto_desem_depto=0;

	                                            while ($row1=mysql_fetch_array($resul))
	                                            {
											$html.='
                                           <tr >
	                                       		<td width="800"><b>SubPrograma N '.utf8_encode ($row1[0]).'</td>
	                                       </tr>

                                           <tr>
                                            <td>
                                                <table width="800" border="0" cellspacing="0" cellpadding="0" style="font-family:Arial, Helvetica, sans-serif; font-size:7pt;">
                                           ';
                                           			$que = "SELECT
                                                         p.proy_id,
	                                                     p.proy_cod,
	                                                     p.proy_nombre,
	                                                     p.proy_numActa,
	                                                     p.proy_fechaAprobacion,
	                                                     p.proy_numViviendas,
	                                                     p.proy_monto_total_aprobado,
                                                         p.proy_subprograma

	                                                    FROM proyecto p, ubicacion u
	                                                    where p.proy_id=u.id_proyecto
	                                                    and p.proy_subprograma='$row1[0]'
	                                                    and u.ubi_departamento='$dep[$i]'
                                                        and p.proy_situacion='$estado'
	                                                    ORDER BY (p.proy_cod)";
	                                                $resu = mysql_query($que,$conexion);
	                                                $st1=0;

                                                    $cont_d_proy=0;//contador de proyecto

                                                    $n_viv=0;
                                                    $monto_compro_de_proyecto=0; //nomto comprometido por proyecto
                                                    $monto_desem_de_proyecto=0; //nomto desembolsado por proyecto

                                                    while ($row2=mysql_fetch_array($resu))
	                                                {     $cont_d_proy=$cont_d_proy+1;

                                                          $qdesem = "SELECT * FROM desembolso WHERE id_proy='$row2[0]'";
	                                                        $rdesem = mysql_query($qdesem,$conexion);

	                                                        $sw=1;
	                                                        $monto_desembolso=0;
	                                                        $saldo_proyecto=0;

	                                                        while ($rowdesem=mysql_fetch_array($rdesem))
	                                                        {
	                                                            $monto_desembolso=$monto_desembolso+$rowdesem[7];
	                                                            } //fin de DESEMBOLSO
	                                                            $saldo_proyecto=$row2[6]-$monto_desembolso;
										   $html.='
	                                                <tr>
                                                        <td width="2%">'.utf8_encode ($cont_d_proy).'</td>
	                                                    <td width="10%">'.utf8_encode ($row2[1]).'</td>
	                                                    <td width="30%">'.utf8_encode ($row2[2]).'</td>
	                                                    <td width="3%">&nbsp;</td>
	                                                    <td width="10%" align="right">'.utf8_encode ($row2[3]).'</td>
	                                                    <td width="7%" align="right">'.utf8_encode ($row2[4]).'</td>
	                                                    <td width="7%" align="right">'.utf8_encode ($row2[5]).'</td>
	                                                    <td width="10%" align="right">'.utf8_encode ($row2[6]).'</td>
	                                                    <td width="10%" align="right">'.utf8_encode ($monto_desembolso).'</td>
	                                                    <td width="10%" align="right">'.utf8_encode ($saldo_proyecto).'</td>
	                                                  </tr>
													   ';
                                                             $monto_compro_de_proyecto=$monto_compro_de_proyecto+$row2[6]; //nomto comprometido por proyecto
                                                    		 $monto_desem_de_proyecto=$monto_desem_de_proyecto+$monto_desembolso; //nomto desembolsado por proyecto
                                                             $n_viv=$n_viv+$row2[5];
                                                             }
                                                             $saldo_subpr=$monto_compro_de_proyecto-$monto_desem_de_proyecto;
	                                                    //mysql_free_result($resu);
                                                       $sp[$j]='';
                                                       $html.='


	                                                </table>
	                                            </td>
	                                      </tr>

                                          <tr>
                                    	    <td><table width="800" border="1" cellspacing="0" cellpadding="0" style="font-family:Arial, Helvetica, sans-serif; font-size:7pt;">
	                                          <tr align="right">
	                                            <td width="30%">&nbsp;</td>
	                                            <td width="30%" align="right"><b>SUBTOTAL DEL SUBPROGRAMA EN Bs: </td>
	                                            <td width="10%" align="right">Nro Viv.'.utf8_encode ($n_viv).'</td>
	                                            <td width="10%" align="right">'.utf8_encode ($monto_compro_de_proyecto).'</td>
	                                            <td width="10%" align="right">'.utf8_encode ($monto_desem_de_proyecto).'</td>
	                                            <td width="10%" align="right">'.utf8_encode ($saldo_subpr).'</td>
	                                          </tr>
	                                        </table></td>
	                                      </tr>
                                       ';
                                                       	$n_viv_depto=$n_viv_depto+$n_viv;
                                                		$monto_compr_depto=$monto_compr_depto+$monto_compro_de_proyecto;
                                                		$monto_desem_depto=$monto_desem_depto+$monto_desem_de_proyecto;
                                                      }
                                                      $saldo_depto=$monto_compr_depto-$monto_desem_depto;
                                       $html.='

                                  <tr>
	                                <td><table width="800" border="1" cellspacing="0" cellpadding="0" style="font-family:Arial, Helvetica, sans-serif; font-size:7pt;">
	                                  <tr align="right">
	                                  	<td width="30%">&nbsp;</td>
	                                     <td width="30%" align="right"><b>SUBTOTAL DEL DEPARTAMENTO EN Bs: </td>
                                         <td width="10%" align="right">Nro Viv.'.utf8_encode ($n_viv_depto).'</td>
                                         <td width="10%" align="right">'.utf8_encode ($monto_compr_depto).'</td>
	                                     <td width="10%" align="right">'.utf8_encode ($monto_desem_depto).'</td>
	                                     <td width="10%" align="right">'.utf8_encode ($saldo_depto).'</td>
	                                   </tr>
	                                </table></td>
	                              </tr>

                                  ';
                                     $n_viv_nacional=$n_viv_nacional+$n_viv_depto;
                                     $monto_compr_nacional=$monto_compr_nacional+$monto_compr_depto;
                                     $monto_desem_nacional=$monto_desem_nacional+$monto_desem_depto;
                                     }  // fin de for
                                     $saldo_nacional=$monto_compr_nacional-$monto_desem_nacional;

                                 $html.='
                                  <tr>
                                     <td><table width="800" border="1" cellspacing="0" cellpadding="0" style="font-family:Arial, Helvetica, sans-serif; font-size:7pt;">
                                       <tr align="right">
                                         <td width="30%">&nbsp;</td>
                                         <td width="30%" align="right"><b>TOTAL NACIONAL EN Bs: </td>
                                         <td width="10%" align="right">Nro Viv.'.utf8_encode ($n_viv_nacional).'</td>
                                         <td width="10%" align="right">'.utf8_encode ($monto_compr_nacional).'</td>
                                         <td width="10%" align="right">'.utf8_encode ($monto_desem_nacional).'</td>
                                         <td width="10%" align="right">'.utf8_encode ($saldo_nacional).'</td>
                                      </tr>
                                    </table></td>
                                  </tr>
                                    ';

                                    }//fin de else de estado=1
                                 }  //fin de if depto=todos

                               else
                                 {
                                  	$query = "SELECT  DISTINCT ubi_departamento
	                                            FROM ubicacion
	                                            WHERE ubi_departamento='$depto'
	                                            ORDER BY ubi_departamento";

	                                $result = mysql_query($query,$conexion);
                                   	$row=mysql_fetch_array($result);

	                                mysql_free_result($result);


	                                if($estado=='TODOS')
                                     {
                                        $n_viv_nacional=0;
                                     	$monto_compr_nacional=0;
                                     	$monto_desem_nacional=0;

                                    	for($i=0;$i<count($row);$i++)
	                                       {
											$html.='
                                          <tr >
	                               				<td width="800" ><b>'.utf8_encode ($row[$i]).'</td>
	                              		  </tr>
                                          ';
                                                $quer = "SELECT DISTINCT
	                                                    p.proy_subprograma
	                                                    FROM ubicacion u, proyecto p
	                                                    where p.proy_id=u.id_proyecto
	                                                    AND u.ubi_departamento='$row[$i]'
	                                                    ORDER BY (p.proy_subprograma)";
	                                            $resul = mysql_query($quer,$conexion);

                                                $n_viv_depto=0;
                                                $monto_compr_depto=0;
                                                $monto_desem_depto=0;

	                                            while ($row1=mysql_fetch_array($resul))
	                                            {
											$html.='
                                           <tr >
	                                       		<td width="800"><b>SubPrograma N '.utf8_encode ($row1[0]).'</td>
	                                       </tr>

                                           <tr>
                                            <td>
                                                <table width="800" border="0" cellspacing="0" cellpadding="0" style="font-family:Arial, Helvetica, sans-serif; font-size:7pt;">
                                           ';
                                           			$que = "SELECT
                                                         p.proy_id,
	                                                     p.proy_cod,
	                                                     p.proy_nombre,
	                                                     p.proy_numActa,
	                                                     p.proy_fechaAprobacion,
	                                                     p.proy_numViviendas,
	                                                     p.proy_monto_total_aprobado,
                                                         p.proy_subprograma

	                                                    FROM proyecto p, ubicacion u
	                                                    where p.proy_id=u.id_proyecto
	                                                    and p.proy_subprograma='$row1[0]'
	                                                    and u.ubi_departamento='$row[$i]'
	                                                    ORDER BY (p.proy_cod)";
	                                                $resu = mysql_query($que,$conexion);
	                                                $st1=0;

                                                    $cont_d_proy=0;//contador de proyecto

                                                    $n_viv=0;
                                                    $monto_compro_de_proyecto=0; //nomto comprometido por proyecto
                                                    $monto_desem_de_proyecto=0; //nomto desembolsado por proyecto

                                                   while ($row2=mysql_fetch_array($resu))
	                                                {     $cont_d_proy=$cont_d_proy+1;

                                                          $qdesem = "SELECT * FROM desembolso WHERE id_proy='$row2[0]'";
	                                                        $rdesem = mysql_query($qdesem,$conexion);

	                                                        $sw=1;
	                                                        $monto_desembolso=0;
	                                                        $saldo_proyecto=0;

	                                                        while ($rowdesem=mysql_fetch_array($rdesem))
	                                                        {
	                                                            $monto_desembolso=$monto_desembolso+$rowdesem[7];
	                                                            } //fin de DESEMBOLSO
	                                                            $saldo_proyecto=$row2[6]-$monto_desembolso;
										   $html.='
	                                                <tr>
                                                        <td width="2%">'.utf8_encode ($cont_d_proy).'</td>
	                                                    <td width="10%">'.utf8_encode ($row2[1]).'</td>
	                                                    <td width="30%">'.utf8_encode ($row2[2]).'</td>
	                                                    <td width="3%">&nbsp;</td>
	                                                    <td width="10%" align="right">'.utf8_encode ($row2[3]).'</td>
	                                                    <td width="7%" align="right">'.utf8_encode ($row2[4]).'</td>
	                                                    <td width="7%" align="right">'.utf8_encode ($row2[5]).'</td>
	                                                    <td width="10%" align="right">'.utf8_encode ($row2[6]).'</td>
	                                                    <td width="10%" align="right">'.utf8_encode ($monto_desembolso).'</td>
	                                                    <td width="10%" align="right">'.utf8_encode ($saldo_proyecto).'</td>
	                                                  </tr>
													   ';
                                                             $monto_compro_de_proyecto=$monto_compro_de_proyecto+$row2[6]; //nomto comprometido por proyecto
                                                    		 $monto_desem_de_proyecto=$monto_desem_de_proyecto+$monto_desembolso; //nomto desembolsado por proyecto
                                                             $n_viv=$n_viv+$row2[5];
                                                             }
                                                             $saldo_subpr=$monto_compro_de_proyecto-$monto_desem_de_proyecto;
	                                                    //mysql_free_result($resu);
                                                       $sp[$j]='';
                                                       $html.='
	                                                </table>
	                                            </td>
	                                      </tr>

                                          <tr>
                                    	    <td><table width="800" border="1" cellspacing="0" cellpadding="0" style="font-family:Arial, Helvetica, sans-serif; font-size:7pt;">
	                                          <tr align="right">
	                                            <td width="30%">&nbsp;</td>
	                                            <td width="30%" align="right"><b>SUBTOTAL DEL SUBPROGRAMA EN Bs: </td>
	                                            <td width="10%" align="right">Nro Viv.'.utf8_encode ($n_viv).'</td>
	                                            <td width="10%" align="right">'.utf8_encode ($monto_compro_de_proyecto).'</td>
	                                            <td width="10%" align="right">'.utf8_encode ($monto_desem_de_proyecto).'</td>
	                                            <td width="10%" align="right">'.utf8_encode ($saldo_subpr).'</td>
	                                          </tr>
	                                        </table></td>
	                                      </tr>
                                       ';
                                                       	$n_viv_depto=$n_viv_depto+$n_viv;
                                                		$monto_compr_depto=$monto_compr_depto+$monto_compro_de_proyecto;
                                                		$monto_desem_depto=$monto_desem_depto+$monto_desem_de_proyecto;
                                                      }
                                                      $saldo_depto=$monto_compr_depto-$monto_desem_depto;

                                       if($row[$i]!=''){
                                       $html.='
                                  <tr>
	                                <td><table width="800" border="1" cellspacing="0" cellpadding="0" style="font-family:Arial, Helvetica, sans-serif; font-size:7pt;">
	                                  <tr align="right">
	                                  	<td width="30%">&nbsp;</td>
	                                     <td width="30%" align="right">SUBTOTAL DEL DEPARTAMENTO EN Bs: </td>
                                         <td width="10%" align="right">Nro Viv.'.utf8_encode ($n_viv_depto).'</td>
                                         <td width="10%" align="right">'.utf8_encode ($monto_compr_depto).'</td>
	                                     <td width="10%" align="right">'.utf8_encode ($monto_desem_depto).'</td>
	                                     <td width="10%" align="right">'.utf8_encode ($saldo_depto).'</td>
	                                   </tr>
	                                </table></td>
	                              </tr>

                                  '; 	}
                                     $n_viv_nacional=$n_viv_nacional+$n_viv_depto;
                                     $monto_compr_nacional=$monto_compr_nacional+$monto_compr_depto;
                                     $monto_desem_nacional=$monto_desem_nacional+$monto_desem_depto;
                                     }  // fin de for
                                     $saldo_nacional=$monto_compr_nacional-$monto_desem_nacional;

                                 $html.='
                                  <tr>
                                     <td><table width="800" border="1" cellspacing="0" cellpadding="0" style="font-family:Arial, Helvetica, sans-serif; font-size:7pt;">
                                       <tr align="right">
                                         <td width="30%">&nbsp;</td>
                                         <td width="30%" align="right"><b>TOTAL NACIONAL EN Bs: </td>
                                         <td width="10%" align="right">Nro Viv.'.utf8_encode ($n_viv_nacional).'</td>
                                         <td width="10%" align="right">'.utf8_encode ($monto_compr_nacional).'</td>
                                         <td width="10%" align="right">'.utf8_encode ($monto_desem_nacional).'</td>
                                         <td width="10%" align="right">'.utf8_encode ($saldo_nacional).'</td>
                                      </tr>
                                    </table></td>
                                  </tr>
                                    ';
	                                 } //fin de if de estado=todos
                                    else
                                    {
                                        $n_viv_nacional=0;
                                     	$monto_compr_nacional=0;
                                     	$monto_desem_nacional=0;

                                    	for($i=0;$i<count($row);$i++)
	                                       {
											$html.='
                                          <tr >
	                               				<td width="800" ><b>'.utf8_encode ($row[$i]).'</td>
	                              		  </tr>
                                          ';
                                                $quer = "SELECT DISTINCT
	                                                    p.proy_subprograma
	                                                    FROM ubicacion u, proyecto p
	                                                    where p.proy_id=u.id_proyecto
	                                                    AND u.ubi_departamento='$row[$i]'
                                                        and p.proy_situacion='$estado'
	                                                    ORDER BY (p.proy_subprograma)";
	                                            $resul = mysql_query($quer,$conexion);

                                                $n_viv_depto=0;
                                                $monto_compr_depto=0;
                                                $monto_desem_depto=0;

	                                            while ($row1=mysql_fetch_array($resul))
	                                            {
											$html.='
                                           <tr >
	                                       		<td width="800"><b>SubPrograma N '.utf8_encode ($row1[0]).'</td>
	                                       </tr>

                                           <tr>
                                            <td>
                                                <table width="800" border="1" cellspacing="0" cellpadding="0" style="font-family:Arial, Helvetica, sans-serif; font-size:7pt;">
                                           ';
                                           			$que = "SELECT
                                                         p.proy_id,
	                                                     p.proy_cod,
	                                                     p.proy_nombre,
	                                                     p.proy_numActa,
	                                                     p.proy_fechaAprobacion,
	                                                     p.proy_numViviendas,
	                                                     p.proy_monto_total_aprobado,
                                                         p.proy_subprograma

	                                                    FROM proyecto p, ubicacion u
	                                                    where p.proy_id=u.id_proyecto
	                                                    and p.proy_subprograma='$row1[0]'
	                                                    and u.ubi_departamento='$row[$i]'
                                                        and p.proy_situacion='$estado'
	                                                    ORDER BY (p.proy_cod)";
	                                                $resu = mysql_query($que,$conexion);
	                                                $st1=0;

                                                    $cont_d_proy=0;//contador de proyecto

                                                    $n_viv=0;
                                                    $monto_compro_de_proyecto=0; //nomto comprometido por proyecto
                                                    $monto_desem_de_proyecto=0; //nomto desembolsado por proyecto

                                                    while ($row2=mysql_fetch_array($resu))
	                                                {     $cont_d_proy=$cont_d_proy+1;

                                                          $qdesem = "SELECT * FROM desembolso WHERE id_proy='$row2[0]'";
	                                                        $rdesem = mysql_query($qdesem,$conexion);

	                                                        $sw=1;
	                                                        $monto_desembolso=0;
	                                                        $saldo_proyecto=0;

	                                                        while ($rowdesem=mysql_fetch_array($rdesem))
	                                                        {
	                                                            $monto_desembolso=$monto_desembolso+$rowdesem[7];
	                                                            } //fin de DESEMBOLSO
	                                                            $saldo_proyecto=$row2[6]-$monto_desembolso;
										   $html.='
	                                                <tr>
                                                        <td width="2%">'.utf8_encode ($cont_d_proy).'</td>
	                                                    <td width="10%">'.utf8_encode ($row2[1]).'</td>
	                                                    <td width="30%">'.utf8_encode ($row2[2]).'</td>
	                                                    <td width="3%">&nbsp;</td>
	                                                    <td width="10%" align="right">'.utf8_encode ($row2[3]).'</td>
	                                                    <td width="7%" align="right">'.utf8_encode ($row2[4]).'</td>
	                                                    <td width="7%" align="right">'.utf8_encode ($row2[5]).'</td>
	                                                    <td width="10%" align="right">'.utf8_encode ($row2[6]).'</td>
	                                                    <td width="10%" align="right">'.utf8_encode ($monto_desembolso).'</td>
	                                                    <td width="10%" align="right">'.utf8_encode ($saldo_proyecto).'</td>
	                                                  </tr>
													   ';
                                                             $monto_compro_de_proyecto=$monto_compro_de_proyecto+$row2[6]; //nomto comprometido por proyecto
                                                    		 $monto_desem_de_proyecto=$monto_desem_de_proyecto+$monto_desembolso; //nomto desembolsado por proyecto
                                                             $n_viv=$n_viv+$row2[5];
                                                             }
                                                             $saldo_subpr=$monto_compro_de_proyecto-$monto_desem_de_proyecto;
	                                                    //mysql_free_result($resu);
                                                       $sp[$j]='';
                                                       $html.='
	                                                </table>
	                                            </td>
	                                      </tr>

                                          <tr>
                                    	    <td><table width="800" border="1" cellspacing="0" cellpadding="0" style="font-family:Arial, Helvetica, sans-serif; font-size:7pt;">
	                                          <tr align="right">
	                                            <td width="30%">&nbsp;</td>
	                                            <td width="30%" align="right"><b>SUBTOTAL DEL SUBPROGRAMA EN Bs: </td>
	                                            <td width="10%" align="right">Nro Viv.'.utf8_encode ($n_viv).'</td>
	                                            <td width="10%" align="right">'.utf8_encode ($monto_compro_de_proyecto).'</td>
	                                            <td width="10%" align="right">'.utf8_encode ($monto_desem_de_proyecto).'</td>
	                                            <td width="10%" align="right">'.utf8_encode ($saldo_subpr).'</td>
	                                          </tr>
	                                        </table></td>
	                                      </tr>
                                       ';
                                                       	$n_viv_depto=$n_viv_depto+$n_viv;
                                                		$monto_compr_depto=$monto_compr_depto+$monto_compro_de_proyecto;
                                                		$monto_desem_depto=$monto_desem_depto+$monto_desem_de_proyecto;
                                                      }
                                                      $saldo_depto=$monto_compr_depto-$monto_desem_depto;
                                   if($row[$i]!=''){
                                       $html.='
                                  <tr>
	                                <td><table width="800" border="1" cellspacing="0" cellpadding="0" style="font-family:Arial, Helvetica, sans-serif; font-size:7pt;">
	                                  <tr align="right">
	                                  	<td width="30%">&nbsp;</td>
	                                     <td width="30%" align="right"><b>SUBTOTAL DEL DEPARTAMENTO EN Bs: </td>
                                         <td width="10%" align="right">Nro Viv.'.utf8_encode ($n_viv_depto).'</td>
                                         <td width="10%" align="right">'.utf8_encode ($monto_compr_depto).'</td>
	                                     <td width="10%" align="right">'.utf8_encode ($monto_desem_depto).'</td>
	                                     <td width="10%" align="right">'.utf8_encode ($saldo_depto).'</td>
	                                   </tr>
	                                </table></td>
	                              </tr>
                                  ';
                                  		}
                                     $n_viv_nacional=$n_viv_nacional+$n_viv_depto;
                                     $monto_compr_nacional=$monto_compr_nacional+$monto_compr_depto;
                                     $monto_desem_nacional=$monto_desem_nacional+$monto_desem_depto;
                                     }  // fin de for
                                     $saldo_nacional=$monto_compr_nacional-$monto_desem_nacional;

                                 $html.='
                                  <tr>
                                     <td><table width="800" border="1" cellspacing="0" cellpadding="0" style="font-family:Arial, Helvetica, sans-serif; font-size:7pt;">
                                       <tr align="right">
                                         <td width="30%">&nbsp;</td>
                                         <td width="30%" align="right"><b>TOTAL NACIONAL EN Bs: </td>
                                         <td width="10%" align="right">Nro Viv.'.utf8_encode ($n_viv_nacional).'</td>
                                         <td width="10%" align="right">'.utf8_encode ($monto_compr_nacional).'</td>
                                         <td width="10%" align="right">'.utf8_encode ($monto_desem_nacional).'</td>
                                         <td width="10%" align="right">'.utf8_encode ($saldo_nacional).'</td>
                                      </tr>
                                    </table></td>
                                  </tr>
                                    ';

                                    }//fin de else de estado=1
                                 }
							$html.='
	                		</table>

                    ';
                $mpdf=new mPDF ('','LETTER','','',10,8,5,20);
	            //$mpdf->AddPage('','','','','','',5,5,10,5,1,5);
	            $mpdf->AddPage('L','','','','','','','','','','','');
	            //$mpdf->AddPage();
	            $mpdf->SetFooter('Encargado de Fideicomiso|{PAGENO} de {nb}|Copyright {DATE j-m-Y}');
	            $mpdf->WriteHTML($html);

	            $mpdf->Output();

	            break;
                }
                case 3:
                {
                    $html.='
                               <table align="center" width="800" border="1" cellspacing="0" cellpadding="0" style="font-family:Arial, Helvetica, sans-serif; font-size:8pt;">
                                      <tr>
	                                        <th colspan="5" align="left">DEPARTAMENTO</th>
	                                  </tr>
                                      <tr>
	                                  		<td align="right" width="40%">SUBPROGRAMA </td>
	                                      	<td align="right" width="15%">Nro VIV. </td>
	                                        <td align="right" width="15%">COMPROMETIDO</td>
	                                        <td align="right" width="15%">DESEMBOLSO</td>
	                                        <td align="right" width="15%">SALDO X DESEM.</td>
	                                  </tr>
                                  ';
                                  if($depto=='TODOS')
               	   				  {
	                                $query = "SELECT  DISTINCT ubi_departamento FROM ubicacion ORDER BY ubi_departamento";
	                                $result = mysql_query($query,$conexion);
	                                $dp1=0;
	                                while ($row=mysql_fetch_array($result))
	                                {    $dep[$dp1]=$row['ubi_departamento'];
	                                     $dp1=$dp1+1;
	                                 }
	                                mysql_free_result($result);

	                                if($estado=='TODOS')
                                     {
                                        $n_viv_nacional=0;
                                     	$monto_compr_nacional=0;
                                     	$monto_desem_nacional=0;

                                    	for($i=0;$i<count($dep);$i++)
	                                       {
											$html.='
                                          <tr >
	                               				<th colspan="5" align="left"><b>'.utf8_encode ($dep[$i]).'</th>
	                              		  </tr>
                                          ';
                                                $quer = "SELECT DISTINCT
	                                                    p.proy_subprograma
	                                                    FROM ubicacion u, proyecto p
	                                                    where p.proy_id=u.id_proyecto
	                                                    AND u.ubi_departamento='$dep[$i]'
	                                                    ORDER BY (p.proy_subprograma)";
	                                            $resul = mysql_query($quer,$conexion);

                                                $n_viv_depto=0;
                                                $monto_compr_depto=0;
                                                $monto_desem_depto=0;

	                                            while ($row1=mysql_fetch_array($resul))
	                                            {
                                           			$que = "SELECT
                                                         p.proy_id,
	                                                     p.proy_cod,
	                                                     p.proy_nombre,
	                                                     p.proy_numActa,
	                                                     p.proy_fechaAprobacion,
	                                                     p.proy_numViviendas,
	                                                     p.proy_monto_total_aprobado,
                                                         p.proy_subprograma

	                                                    FROM proyecto p, ubicacion u
	                                                    where p.proy_id=u.id_proyecto
	                                                    and p.proy_subprograma='$row1[0]'
	                                                    and u.ubi_departamento='$dep[$i]'
	                                                    ORDER BY (p.proy_cod)";
	                                                $resu = mysql_query($que,$conexion);
	                                                $st1=0;

                                                    $cont_d_proy=0;//contador de proyecto

                                                    $n_viv=0;
                                                    $monto_compro_de_proyecto=0; //nomto comprometido por proyecto
                                                    $monto_desem_de_proyecto=0; //nomto desembolsado por proyecto

                                                    while ($row2=mysql_fetch_array($resu))
	                                                {     $cont_d_proy=$cont_d_proy+1;

                                                          $qdesem = "SELECT * FROM desembolso WHERE id_proy='$row2[0]'";
	                                                        $rdesem = mysql_query($qdesem,$conexion);

	                                                        $sw=1;
	                                                        $monto_desembolso=0;
	                                                        $saldo_proyecto=0;

	                                                        while ($rowdesem=mysql_fetch_array($rdesem))
	                                                        {
	                                                            $monto_desembolso=$monto_desembolso+$rowdesem[7];
	                                                            } //fin de DESEMBOLSO
	                                                            $saldo_proyecto=$row2[6]-$monto_desembolso;
                                                             $monto_compro_de_proyecto=$monto_compro_de_proyecto+$row2[6]; //nomto comprometido por proyecto
                                                    		 $monto_desem_de_proyecto=$monto_desem_de_proyecto+$monto_desembolso; //nomto desembolsado por proyecto
                                                             $n_viv=$n_viv+$row2[5];
                                                             }
                                                             $saldo_subpr=$monto_compro_de_proyecto-$monto_desem_de_proyecto;
	                                                    //mysql_free_result($resu);
                                                       $sp[$j]='';

                                                      $html.='
                                              <tr>
	                                            <td align="right" width="40%">SubPrograma N '.utf8_encode ($row1[0]).'</td>
	                                            <td align="right" width="15%">'.utf8_encode ($n_viv).'</td>
	                                            <td align="right" width="15%">'.utf8_encode ($monto_compro_de_proyecto).'</td>
	                                            <td align="right" width="15%">'.utf8_encode ($monto_desem_de_proyecto).'</td>
	                                            <td align="right" width="15%">'.utf8_encode ($saldo_subpr).'</td>
	                                          </tr>

                                       ';
                                                       	$n_viv_depto=$n_viv_depto+$n_viv;
                                                		$monto_compr_depto=$monto_compr_depto+$monto_compro_de_proyecto;
                                                		$monto_desem_depto=$monto_desem_depto+$monto_desem_de_proyecto;
                                                      }
                                                      $saldo_depto=$monto_compr_depto-$monto_desem_depto;
                                       $html.='

                                    <tr>
	                                     <td align="right" width="40%" ><b>SUBTOTAL DEL DEPARTAMENTO EN Bs: </td>
                                         <td align="right" width="15%" >'.utf8_encode ($n_viv_depto).'</td>
                                         <td align="right" width="15%" >'.utf8_encode ($monto_compr_depto).'</td>
	                                     <td align="right" width="15%" >'.utf8_encode ($monto_desem_depto).'</td>
	                                     <td align="right" width="15%" >'.utf8_encode ($saldo_depto).'</td>
	                                   </tr>
                                  ';
                                     $n_viv_nacional=$n_viv_nacional+$n_viv_depto;
                                     $monto_compr_nacional=$monto_compr_nacional+$monto_compr_depto;
                                     $monto_desem_nacional=$monto_desem_nacional+$monto_desem_depto;
                                     }  // fin de for
                                     $saldo_nacional=$monto_compr_nacional-$monto_desem_nacional;

                                 $html.='
                                      <tr>
                                         <td align="right" width="40%"><b>TOTAL NACIONAL EN Bs: </td>
                                         <td align="right" width="15%"><b>'.utf8_encode ($n_viv_nacional).'</td>
                                         <td align="right" width="15%"><b>'.utf8_encode ($monto_compr_nacional).'</td>
                                         <td align="right" width="15%"><b>'.utf8_encode ($monto_desem_nacional).'</td>
                                         <td align="right" width="15%"><b>'.utf8_encode ($saldo_nacional).'</td>
                                      </tr>
                                    </table>
                                    ';
	                                 } //fin de if de estado=todos
                                    else
                                    {
                                        $n_viv_nacional=0;
                                     	$monto_compr_nacional=0;
                                     	$monto_desem_nacional=0;

                                    	for($i=0;$i<count($dep);$i++)
	                                       {
											$html.='
                                          <tr >
	                               				<td colspan="5" align="left"><b>'.utf8_encode ($dep[$i]).'</td>
	                              		  </tr>
                                          ';
                                                $quer = "SELECT DISTINCT
	                                                    p.proy_subprograma
	                                                    FROM ubicacion u, proyecto p
	                                                    where p.proy_id=u.id_proyecto
	                                                    AND u.ubi_departamento='$dep[$i]'
                                                        and p.proy_situacion='$estado'
	                                                    ORDER BY (p.proy_subprograma)";
	                                            $resul = mysql_query($quer,$conexion);

                                                $n_viv_depto=0;
                                                $monto_compr_depto=0;
                                                $monto_desem_depto=0;

	                                            while ($row1=mysql_fetch_array($resul))
	                                            {
                                                   $que = "SELECT
                                                         p.proy_id,
	                                                     p.proy_cod,
	                                                     p.proy_nombre,
	                                                     p.proy_numActa,
	                                                     p.proy_fechaAprobacion,
	                                                     p.proy_numViviendas,
	                                                     p.proy_monto_total_aprobado,
                                                         p.proy_subprograma

	                                                    FROM proyecto p, ubicacion u
	                                                    where p.proy_id=u.id_proyecto
	                                                    and p.proy_subprograma='$row1[0]'
	                                                    and u.ubi_departamento='$dep[$i]'
                                                        and p.proy_situacion='$estado'
	                                                    ORDER BY (p.proy_cod)";
	                                                $resu = mysql_query($que,$conexion);
	                                                $st1=0;

                                                    $cont_d_proy=0;//contador de proyecto

                                                    $n_viv=0;
                                                    $monto_compro_de_proyecto=0; //nomto comprometido por proyecto
                                                    $monto_desem_de_proyecto=0; //nomto desembolsado por proyecto

                                                    while ($row2=mysql_fetch_array($resu))
	                                                {     $cont_d_proy=$cont_d_proy+1;

                                                          $qdesem = "SELECT * FROM desembolso WHERE id_proy='$row2[0]'";
	                                                        $rdesem = mysql_query($qdesem,$conexion);

	                                                        $sw=1;
	                                                        $monto_desembolso=0;
	                                                        $saldo_proyecto=0;

	                                                        while ($rowdesem=mysql_fetch_array($rdesem))
	                                                        {
	                                                            $monto_desembolso=$monto_desembolso+$rowdesem[7];
	                                                            } //fin de DESEMBOLSO
	                                                            $saldo_proyecto=$row2[6]-$monto_desembolso;

                                                             $monto_compro_de_proyecto=$monto_compro_de_proyecto+$row2[6]; //nomto comprometido por proyecto
                                                    		 $monto_desem_de_proyecto=$monto_desem_de_proyecto+$monto_desembolso; //nomto desembolsado por proyecto
                                                             $n_viv=$n_viv+$row2[5];
                                                             }
                                                             $saldo_subpr=$monto_compro_de_proyecto-$monto_desem_de_proyecto;
	                                                    //mysql_free_result($resu);
                                                       $sp[$j]='';
                                                       $html.='
                                             <tr>
	                                            <td align="right" width="40%">SubPrograma N '.utf8_encode ($row1[0]).'</td>
	                                            <td align="right" width="15%">'.utf8_encode ($n_viv).'</td>
	                                            <td align="right" width="15%">'.utf8_encode ($monto_compro_de_proyecto).'</td>
	                                            <td align="right" width="15%">'.utf8_encode ($monto_desem_de_proyecto).'</td>
	                                            <td align="right" width="15%">'.utf8_encode ($saldo_subpr).'</td>
	                                          </tr>
                                       ';
                                                       	$n_viv_depto=$n_viv_depto+$n_viv;
                                                		$monto_compr_depto=$monto_compr_depto+$monto_compro_de_proyecto;
                                                		$monto_desem_depto=$monto_desem_depto+$monto_desem_de_proyecto;
                                                      }
                                                      $saldo_depto=$monto_compr_depto-$monto_desem_depto;
                                       $html.='

                                     <tr>
	                                     <td align="right" width="40%">SUBTOTAL DEL DEPARTAMENTO EN Bs: </td>
                                         <td align="right" width="15%">'.utf8_encode ($n_viv_depto).'</td>
                                         <td align="right" width="15%">'.utf8_encode ($monto_compr_depto).'</td>
	                                     <td align="right" width="15%">'.utf8_encode ($monto_desem_depto).'</td>
	                                     <td align="right" width="15%">'.utf8_encode ($saldo_depto).'</td>
	                                   </tr>
                                  ';
                                     $n_viv_nacional=$n_viv_nacional+$n_viv_depto;
                                     $monto_compr_nacional=$monto_compr_nacional+$monto_compr_depto;
                                     $monto_desem_nacional=$monto_desem_nacional+$monto_desem_depto;
                                     }  // fin de for
                                     $saldo_nacional=$monto_compr_nacional-$monto_desem_nacional;

                                 $html.='
                                     <tr>
                                         <td align="right" width="40%"><b>TOTAL NACIONAL EN Bs: </td>
                                         <td align="right" width="15%"><b>'.utf8_encode ($n_viv_nacional).'</td>
                                         <td align="right" width="15%"><b>'.utf8_encode ($monto_compr_nacional).'</td>
                                         <td align="right" width="15%"><b>'.utf8_encode ($monto_desem_nacional).'</td>
                                         <td align="right" width="15%"><b>'.utf8_encode ($saldo_nacional).'</td>
                                      </tr>
                                    </table>
                                    ';
                                    }//fin de else de estado=1
                                 }  //fin de if depto=todos

                               else
                                 {
                                  	$query = "SELECT  DISTINCT ubi_departamento
	                                            FROM ubicacion
	                                            WHERE ubi_departamento='$depto'
	                                            ORDER BY ubi_departamento";

	                                $result = mysql_query($query,$conexion);
                                   	$row=mysql_fetch_array($result);

	                                mysql_free_result($result);


	                                if($estado=='TODOS')
                                     {
                                        $n_viv_nacional=0;
                                     	$monto_compr_nacional=0;
                                     	$monto_desem_nacional=0;

                                    	for($i=0;$i<count($row);$i++)
	                                       {
											$html.='
                                          <tr >
	                               				<td colspan="5" align="left"><b>'.utf8_encode ($row[$i]).'</td>
	                              		  </tr>
                                          ';
                                                $quer = "SELECT DISTINCT
	                                                    p.proy_subprograma
	                                                    FROM ubicacion u, proyecto p
	                                                    where p.proy_id=u.id_proyecto
	                                                    AND u.ubi_departamento='$row[$i]'
	                                                    ORDER BY (p.proy_subprograma)";
	                                            $resul = mysql_query($quer,$conexion);

                                                $n_viv_depto=0;
                                                $monto_compr_depto=0;
                                                $monto_desem_depto=0;

	                                            while ($row1=mysql_fetch_array($resul))
	                                            {
                                             		$que = "SELECT
                                                         p.proy_id,
	                                                     p.proy_cod,
	                                                     p.proy_nombre,
	                                                     p.proy_numActa,
	                                                     p.proy_fechaAprobacion,
	                                                     p.proy_numViviendas,
	                                                     p.proy_monto_total_aprobado,
                                                         p.proy_subprograma

	                                                    FROM proyecto p, ubicacion u
	                                                    where p.proy_id=u.id_proyecto
	                                                    and p.proy_subprograma='$row1[0]'
	                                                    and u.ubi_departamento='$row[$i]'
	                                                    ORDER BY (p.proy_cod)";
	                                                $resu = mysql_query($que,$conexion);
	                                                $st1=0;

                                                    $cont_d_proy=0;//contador de proyecto

                                                    $n_viv=0;
                                                    $monto_compro_de_proyecto=0; //nomto comprometido por proyecto
                                                    $monto_desem_de_proyecto=0; //nomto desembolsado por proyecto

                                                   while ($row2=mysql_fetch_array($resu))
	                                                {     $cont_d_proy=$cont_d_proy+1;

                                                          $qdesem = "SELECT * FROM desembolso WHERE id_proy='$row2[0]'";
	                                                        $rdesem = mysql_query($qdesem,$conexion);

	                                                        $sw=1;
	                                                        $monto_desembolso=0;
	                                                        $saldo_proyecto=0;

	                                                        while ($rowdesem=mysql_fetch_array($rdesem))
	                                                        {
	                                                            $monto_desembolso=$monto_desembolso+$rowdesem[7];
	                                                            } //fin de DESEMBOLSO
	                                                            $saldo_proyecto=$row2[6]-$monto_desembolso;

                                                             $monto_compro_de_proyecto=$monto_compro_de_proyecto+$row2[6]; //nomto comprometido por proyecto
                                                    		 $monto_desem_de_proyecto=$monto_desem_de_proyecto+$monto_desembolso; //nomto desembolsado por proyecto
                                                             $n_viv=$n_viv+$row2[5];
                                                             }
                                                             $saldo_subpr=$monto_compro_de_proyecto-$monto_desem_de_proyecto;
	                                                    //mysql_free_result($resu);
                                                       $sp[$j]='';
                                                       $html.='
                                             <tr>
	                                            <td align="right" width="40%">SubPrograma N '.utf8_encode ($row1[0]).'</td>
	                                            <td align="right" width="15%">'.utf8_encode ($n_viv).'</td>
	                                            <td align="right" width="15%">'.utf8_encode ($monto_compro_de_proyecto).'</td>
	                                            <td align="right" width="15%">'.utf8_encode ($monto_desem_de_proyecto).'</td>
	                                            <td align="right" width="15%">'.utf8_encode ($saldo_subpr).'</td>
	                                          </tr>
                                       ';
                                                       	$n_viv_depto=$n_viv_depto+$n_viv;
                                                		$monto_compr_depto=$monto_compr_depto+$monto_compro_de_proyecto;
                                                		$monto_desem_depto=$monto_desem_depto+$monto_desem_de_proyecto;
                                                      }
                                                      $saldo_depto=$monto_compr_depto-$monto_desem_depto;

                                       if($row[$i]!=''){
                                       $html.='
                                    <tr>
	                                     <td align="right" width="40%">SUBTOTAL DEL DEPARTAMENTO EN Bs: </td>
                                         <td align="right" width="15%">'.utf8_encode ($n_viv_depto).'</td>
                                         <td align="right" width="15%">'.utf8_encode ($monto_compr_depto).'</td>
	                                     <td align="right" width="15%">'.utf8_encode ($monto_desem_depto).'</td>
	                                     <td align="right" width="15%">'.utf8_encode ($saldo_depto).'</td>
	                                   </tr>
                                  '; 	}
                                     $n_viv_nacional=$n_viv_nacional+$n_viv_depto;
                                     $monto_compr_nacional=$monto_compr_nacional+$monto_compr_depto;
                                     $monto_desem_nacional=$monto_desem_nacional+$monto_desem_depto;
                                     }  // fin de for
                                     $saldo_nacional=$monto_compr_nacional-$monto_desem_nacional;

                                 $html.='
                                      <tr>
                                         <td align="right" width="40%"><b>TOTAL NACIONAL EN Bs: </td>
                                         <td align="right" width="15%"><b>'.utf8_encode ($n_viv_nacional).'</td>
                                         <td align="right" width="15%"><b>'.utf8_encode ($monto_compr_nacional).'</td>
                                         <td align="right" width="15%"><b>'.utf8_encode ($monto_desem_nacional).'</td>
                                         <td align="right" width="15%"><b>'.utf8_encode ($saldo_nacional).'</td>
                                      </tr>
                                    </table>
                                    ';
	                                 } //fin de if de estado=todos
                                    else
                                    {
                                        $n_viv_nacional=0;
                                     	$monto_compr_nacional=0;
                                     	$monto_desem_nacional=0;

                                    	for($i=0;$i<count($row);$i++)
	                                       {
											$html.='
                                          <tr >
	                               				<td colspan="5" align="left"><b>'.utf8_encode ($row[$i]).'</td>
	                              		  </tr>
                                          ';
                                                $quer = "SELECT DISTINCT
	                                                    p.proy_subprograma
	                                                    FROM ubicacion u, proyecto p
	                                                    where p.proy_id=u.id_proyecto
	                                                    AND u.ubi_departamento='$row[$i]'
                                                        and p.proy_situacion='$estado'
	                                                    ORDER BY (p.proy_subprograma)";
	                                            $resul = mysql_query($quer,$conexion);

                                                $n_viv_depto=0;
                                                $monto_compr_depto=0;
                                                $monto_desem_depto=0;

	                                            while ($row1=mysql_fetch_array($resul))
	                                            {

                                           			$que = "SELECT
                                                         p.proy_id,
	                                                     p.proy_cod,
	                                                     p.proy_nombre,
	                                                     p.proy_numActa,
	                                                     p.proy_fechaAprobacion,
	                                                     p.proy_numViviendas,
	                                                     p.proy_monto_total_aprobado,
                                                         p.proy_subprograma

	                                                    FROM proyecto p, ubicacion u
	                                                    where p.proy_id=u.id_proyecto
	                                                    and p.proy_subprograma='$row1[0]'
	                                                    and u.ubi_departamento='$row[$i]'
                                                        and p.proy_situacion='$estado'
	                                                    ORDER BY (p.proy_cod)";
	                                                $resu = mysql_query($que,$conexion);
	                                                $st1=0;

                                                    $cont_d_proy=0;//contador de proyecto

                                                    $n_viv=0;
                                                    $monto_compro_de_proyecto=0; //nomto comprometido por proyecto
                                                    $monto_desem_de_proyecto=0; //nomto desembolsado por proyecto

                                                    while ($row2=mysql_fetch_array($resu))
	                                                {     $cont_d_proy=$cont_d_proy+1;

                                                          $qdesem = "SELECT * FROM desembolso WHERE id_proy='$row2[0]'";
	                                                        $rdesem = mysql_query($qdesem,$conexion);

	                                                        $sw=1;
	                                                        $monto_desembolso=0;
	                                                        $saldo_proyecto=0;

	                                                        while ($rowdesem=mysql_fetch_array($rdesem))
	                                                        {
	                                                            $monto_desembolso=$monto_desembolso+$rowdesem[7];
	                                                            } //fin de DESEMBOLSO
	                                                            $saldo_proyecto=$row2[6]-$monto_desembolso;

                                                             $monto_compro_de_proyecto=$monto_compro_de_proyecto+$row2[6]; //nomto comprometido por proyecto
                                                    		 $monto_desem_de_proyecto=$monto_desem_de_proyecto+$monto_desembolso; //nomto desembolsado por proyecto
                                                             $n_viv=$n_viv+$row2[5];
                                                             }
                                                             $saldo_subpr=$monto_compro_de_proyecto-$monto_desem_de_proyecto;
	                                                    //mysql_free_result($resu);
                                                       $sp[$j]='';
                                                       $html.='
                                            <tr>
	                                            <td align="right" width="40%">SubPrograma N '.utf8_encode ($row1[0]).'</td>
	                                            <td align="right" width="15%">'.utf8_encode ($n_viv).'</td>
	                                            <td align="right" width="15%">'.utf8_encode ($monto_compro_de_proyecto).'</td>
	                                            <td align="right" width="15%">'.utf8_encode ($monto_desem_de_proyecto).'</td>
	                                            <td align="right" width="15%">'.utf8_encode ($saldo_subpr).'</td>
	                                          </tr>
                                       ';
                                                       	$n_viv_depto=$n_viv_depto+$n_viv;
                                                		$monto_compr_depto=$monto_compr_depto+$monto_compro_de_proyecto;
                                                		$monto_desem_depto=$monto_desem_depto+$monto_desem_de_proyecto;
                                                      }
                                                      $saldo_depto=$monto_compr_depto-$monto_desem_depto;
                                   if($row[$i]!=''){
                                       $html.='
                                     <tr>
	                                     <td align="right" width="40%">SUBTOTAL DEL DEPARTAMENTO EN Bs: </td>
                                         <td align="right" width="15%">'.utf8_encode ($n_viv_depto).'</td>
                                         <td align="right" width="15%">'.utf8_encode ($monto_compr_depto).'</td>
	                                     <td align="right" width="15%">'.utf8_encode ($monto_desem_depto).'</td>
	                                     <td align="right" width="15%">'.utf8_encode ($saldo_depto).'</td>
	                                   </tr>
                                  ';
                                  		}
                                     $n_viv_nacional=$n_viv_nacional+$n_viv_depto;
                                     $monto_compr_nacional=$monto_compr_nacional+$monto_compr_depto;
                                     $monto_desem_nacional=$monto_desem_nacional+$monto_desem_depto;
                                     }  // fin de for
                                     $saldo_nacional=$monto_compr_nacional-$monto_desem_nacional;

                                 $html.='
                                       <tr>
                                         <td align="right" width="40%">TOTAL NACIONAL EN Bs: </td>
                                         <td align="right" width="15%">'.utf8_encode ($n_viv_nacional).'</td>
                                         <td align="right" width="15%">'.utf8_encode ($monto_compr_nacional).'</td>
                                         <td align="right" width="15%">'.utf8_encode ($monto_desem_nacional).'</td>
                                         <td align="right" width="15%">'.utf8_encode ($saldo_nacional).'</td>
                                      </tr>
                                    </table>
                                    ';

                                    }//fin de else de estado=1
                                 }
							$html.='
	                		</table>
                    ';
                $mpdf=new mPDF ('','LEGAL','','',10,8,5,20);
	            //$mpdf->AddPage('','','','','','',5,5,10,5,1,5);
	            $mpdf->AddPage('P','','','','','','','','','','','');
	            //$mpdf->AddPage();
	            $mpdf->SetFooter('Encargado de Fideicomiso|{PAGENO} de {nb}|Copyright {DATE j-m-Y}');
	            $mpdf->WriteHTML($html);

	            $mpdf->Output();
	            break;
                }

 }  //FIN DE SWITCH

exit;

?>
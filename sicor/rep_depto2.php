<?php
header("Expires: Mon, 26 Jul 1997 05:00:00 GMT");
header("Last-Modified: " . gmdate("D, d M Y H:i:s") . " GMT");
header("Cache-Control: no-store, no-cache, must-revalidate");
header("Cache-Control: post-check=0, pre-check=0", false);
header("Pragma: no-cache");

include ("datos/conexion.php");
include ("datos/functions.lib.php");
include ("datos/sistema.php");
include ("libreria.php");

$usuario='supervisor';

$conexion = conectar ();

?>

<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN"  >
<html>
<head>

  <meta http-equiv="Content-Type" content="text/html; charset=windows-1252" />
  <meta http-equiv="content-type" content="text/html; charset=iso-8859-1" />
  <meta http-equiv="Content-Type" content="text/html; charset=Latin1" />
  <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />


  <title> PROYECTO FODEICOMISO</title>


<link rel="stylesheet" type="text/css" media="all" href="datos/calendario/calendar-blue2.css" />
<link rel="stylesheet" type="text/css" href="styles/azul.css">

<script type="text/javascript" src="datos/funciones.js"></script>
<script src="datos/calendario/calendar.js" type="text/javascript"></script>
<script src="datos/calendario/calendar-es.js" type="text/javascript"></script>
<script src="datos/calendario/calendar-setup.js" type="text/javascript"></script>
<script src="datos/calendario/functions.js" type="text/javascript"></script>

<style type="text/css">

A:link{font: 9pt Arial; color:#ffffff;text-decoration:none;}
A:visited{font: 9pt Arial; color:#ffffff;text-decoration:none;}
A:hover{font: 9pt Arial; color:#000088;text-decoration:none}

#menu div.barraMenu,
#menu div.barraMenu

a.botonMenu {
font-family: sans-serif, Verdana, Arial;
font-size: 9pt;
color: white;
}

#menu div.barraMenu {
text-align: left;
}

#menu div.barraMenu
a.botonMenu {
background-color: #556975;
color: white;
cursor: pointer;
padding: 4px 6px 2px 5px;
text-decoration: none;
}

#menu div.barraMenu
a.botonMenu:hover {
background-color: #637D4D;
}

#menu div.barraMenu
a.botonMenu:active {
background-color: #637D4D;
color: black;
}


.fondo{
	width:100%;height:100%;
	filter: progid:DXImageTransform.Microsoft.gradient(startColorstr=#336699, endColorstr=#FFFFFF,
    GradientType=1)
	}
     .estilo1 {
   	font-family: Arial, Helvetica, sans-serif;
	font-size: 13px;
    color: #ffffff;
    background-color: #800000;
	}

    .estilo2 {
	color: #400000;
    font-size: 11px;
	font-weight: bold;
	}
    .estilo3 {
	font-family: Arial, Helvetica, sans-serif;
	font-size: 11px;
    color: #ffffff;
    background-color: #800000;
    }
     .estilo4 {
	font-family: Arial, Helvetica, sans-serif;
	font-size: 12px;
	color: #FFFFFF;
    background-color: #804000;
 	}
    .estilo5 {
	font-family: Arial, Helvetica, sans-serif;
	font-size: 11px;
    color:#FFFFFF;
    background-color: #000000;
    }

   body {
         padding:5px 10px;
         height:100%;
         width:100%;
         filter:progid:DXImageTransform.Microsoft.gradient(startColorstr=#75bd42, endColorstr=#FFFFFF);
   		}
	td {font-family: arial,verdana;font-size: 11px;}


	.d {font-family: arial,verdana;
    font-size: 11px;
    }

    .e {font-family: arial,verdana;
    font-size: 12px;
    color:#FFFFFF;
    background-color: #004080;
    }
      .f {font-family: arial,verdana;
    font-size: 12px;
    color:#FFFFFF;
    background-color: #8080FF;
    }

    .g {font-family: arial,verdana;
    font-size: 12px;
    color:#000000;
    background-color: #FF9F71;
    }
    .n {font-family: arial,verdana;
    font-size: 9px;
    color:#0000FF;
    }

</style>


</head>

<body bgcolor="#96cd6f" text="#000000" link="#3366cc" vlink="#0066ff" alink="#3366cc" leftmargin="0" marginwidth="0" topmargin="0" marginheight="0" >

<!--<div id="div1" class="fondo1" style="document.getElementById(padding:5px 10px;height:100%; width:100%;filter:progid:DXImageTransform.Microsoft.gradient(startColorstr=#75bd42, endColorstr=#FFFFFF)).style.display ='';">-->
<div >
<div align="center" >
<div align="left" style="border: 0px solid black ; width:1010px; background: ##FF0000 " >
        <!--empieza imagen y menu-->
       <table width="100%" border="0" align="center" bordercolor="#800000" >
        	<tr >
	            <td height="138px" style="background-image:url(imagenes2/ban1.png);background-repeat:no-repeat;">
	            </td>
	        </tr>
         	<tr>
            <td height="50px" style="background-image:url(imagenes2/des_menu2.png);background-repeat:no-repeat;">
	            <table width="" height="55px" border="0" align="center" bordercolor="#004080">
                    <tr>

                    <td>
                    <form action="" method="post">
                    <div id="menu">
	                <div class="barraMenu">
	                <a class="botonMenu" href="ver.php">--Volver a Inicio</a>
	                </div>
	                </div>
                    </form>
                    </td>
                    <td>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
						&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                    </td>

                    <td>
                    	<form action="" method="post">
	                    <div id="menu">
	                    <div class="barraMenu">
	                    <a class="botonMenu" href="depto.php">Departamentos</a>
	                    </div>
	                    </div>
	                    </form>
                    </td>
                    <td>&nbsp;</td>
                    <td>
                    	<form action="" method="post">
	                    <div id="menu">
	                    <div class="barraMenu">
	                    <a class="botonMenu" href="subp.php">subprogramas</a>
	                    </div>
	                    </div>
	                    </form>
                    </td>
                    <td>&nbsp;</td>
                    <td>
                    	<form action="" method="post">
                    	<div id="menu">
	                    <div class="barraMenu">
	                    <a class="botonMenu" href="financiera.php">financieras</a>
	                    </div>
	                    </div>
                        </form>
                    </td>
                    <td>&nbsp;</td>
                    <td>
                        <form action="" method="post">
                    	<div id="menu">
	                    <div class="barraMenu">
	                    <a class="botonMenu" href="desem_x_mes.php">desembolso x Mes</a>
	                    </div>
	                    </div>
                        </form>
                     </td>
                     <td>&nbsp;</td>

                    <td>&nbsp;</td>
                    <td>
                        <form action="" method="post">
                    	<div id="menu">
	                    <div class="barraMenu">
	                    <a class="botonMenu" href="proy_x_actas.php">Proy. Segun Actas</a>
	                    </div>
	                    </div>
                        </form>
                     </td>
	              </tr>

	            </table>
	         </td>

	        </tr>
     	</table>
        <!--fim imagen y menu-->
      <?

  	   	$depto=$_POST["departamento"];
 		$estado=$_POST["situacion"];
 		$formato=$_POST["chek"];


         if($formato==1)
        { $descrip='DETALLADO';
        }
        else
        { if($formato==2)
        	{ $descrip='RESUMIDO';}
            else
            {if($formato==3)
        		{ $descrip='POR TITULO';}
            }
        }
      ?>

        <?
        switch ($formato)  //FORMATO DE IMPRESION
        {
	            case 1:    //IMPRESION DETALLADO
                {  	?>
                              <table width="" border="0" align="center">
	                             <form action="pdf_2_rep_depto.php"  method="POST" target="_blank">
	                                 <tr align="center">
	                                    <th><img src="imagenes2/PDF.jpg" width="23" height="23" /></th>
	                                  </tr>
	                                  <tr align="center">
	                                    <td>
	                                        <input type="hidden" name="campo1" value="<?=$formato;?>">
	                                        <input type="hidden" name="campo2" value="<?=$depto;?>">
	                                        <input type="hidden" name="campo3" value="<?=$estado;?>">
	                                        <input align="center" type="submit" class="n" value="I M P R I M I R" >
	                                    </td>
	                                  </tr>
	                                </form>
	                            </table>

                            	<table border="1" align="center" >
	                                    <tr >
	                                        <td><b>Departamento de:</b> <?  echo"$depto"; ?></td>
	                                        <td><b>Estado de Proyecto:</b> <?  echo"$estado"; ?></td>
	                                        <td><b>tipo de Reporte:</b> <?  echo"$descrip"; ?></td>
	                                    </tr>
	                            </table>

                               <table width="100%" border="0" cellspacing="1" cellpadding="1">
                                 <tr>
	                                <td>
                                    	<table width="100%" border="0" cellspacing="1" cellpadding="1">
	                                      <!--
                                          <tr>
	                                        <td width="100%">DEPARTAMENTO</td>
	                                      </tr>
	                                      <tr>
	                                        <td width="100%">SUBPROGRAMA</td>
	                                      </tr>

	                                      <tr>
	                                        <td>
                                              <table width="100%" border="1" cellspacing="1" cellpadding="1">
                                              	<tr>
	                                                <td width="2%">N&ordm;</td>
	                                                <td width="10%">COD.PROY.</td>
	                                                <td width="30%">NOMBRE DEL PROYECTO </td>
	                                                <td width="3%">&nbsp;</td>
	                                                <td width="10%">ACTA</td>
	                                                <td width="7%">FECH. APR. </td>
	                                                <td width="7%">N&ordm; VIV. </td>
	                                                <td width="10%" align="right">COMPROMETIDO</td>
	                                                <td width="10%">&nbsp;</td>
	                                                <td width="10%">&nbsp;</td>
	                                              </tr>
	                                              <tr>
	                                                <td width="2%">&nbsp;</td>
	                                                <td width="10%">&nbsp;</td>
	                                                <td width="30%">&nbsp;</td>
	                                                <td width="3%">N&ordm;</td>
	                                                <td width="10%">CARTA OPERATIVO </td>
	                                                <td width="7%">CHEQUE</td>
	                                                <td width="7%">FES.DES.</td>
	                                                <td width="10%">&nbsp;</td>
	                                                <td width="10%" align="right">Imp. Desembolso </td>
	                                                <td width="10%" align="right">Saldo</td>
	                                              </tr>
	                                          </table>
                                            </td>
	                                      </tr>
                                           -->
	                                    </table>
                                    </td>
	                              </tr>
                                  <?
                                  if($depto=='TODOS')
               	   				  {
                                  	//SELECCIONA DEPARTAMENTO
	                                $query = "SELECT  DISTINCT ubi_departamento FROM ubicacion ORDER BY ubi_departamento";
	                                $result = mysql_query($query,$conexion);
	                                $dp1=0;
	                                while ($row=mysql_fetch_array($result))
	                                {    $dep[$dp1]=$row['ubi_departamento'];
	                                     $dp1=$dp1+1;
	                                 }
	                                mysql_free_result($result);

	                                if($estado=='TODOS') //VERIFICA ESTADO DE PROYECTO
                                     {
                                        $n_viv_nacional=0;
                                     	$monto_compr_nacional=0;
                                     	$monto_desem_nacional=0;

                                    	for($i=0;$i<count($dep);$i++)
	                                       {
											?>
                                          <tr class="estilo1">
	                               				<td width="100%" ><b><?echo"$dep[$i]";?></td>
	                              		  </tr>
                                          <?    //SELECCIONA SUBPROGRAMA DE PROYECTO
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
											?>
                                           <tr class="e">
	                                       		<td width="100%"><b><?echo"SUBPROGRAMA Nº $row1[0]";?></td>
	                                       </tr>

                                           <tr>
	                                        <td>
                                              <table width="100%" border="0" cellspacing="1" cellpadding="1">
                                              	<tr>
	                                                <td width="2%"><b>N&ordm;</td>
	                                                <td width="10%"><b>Cod.Proy.</td>
	                                                <td width="30%" ><b>Nombre Del Proyecto </td>
	                                                <td width="3%">&nbsp;</td>
	                                                <td width="10%" align="center"><b>Acta</td>
	                                                <td width="10%" align="center"><b>Fech. Aprob. </td>
	                                                <td width="7%" align="center"><b>N&ordm; Viv. </td>
	                                                <td width="10%" align="right"><b>Comprometido</td>
	                                                <td width="10%">&nbsp;</td>
	                                                <td width="10%">&nbsp;</td>
	                                              </tr>
	                                              <tr>
	                                                <td width="2%">&nbsp;</td>
	                                                <td width="10%">&nbsp;</td>
	                                                <td width="30%">&nbsp;</td>
	                                                <td width="3%" align="center"><i>N&ordm;</td>
	                                                <td width="10%" align="center" ><i>Carta Operativa </td>
	                                                <td width="10%" align="center"><i>Cheque</td>
	                                                <td width="7%" align="center"><i>Fech.Desem.</td>
	                                                <td width="10%">&nbsp;</td>
	                                                <td width="10%" align="right"><i>Imp. Desembolso </td>
	                                                <td width="10%" align="right"><i>Saldo</td>
	                                              </tr>
	                                          </table>
                                            </td>
	                                      </tr>

                                          <tr>
                                          	<td width="100%" colspan="10"><hr width="100%" size="1" style="color:black" /></td>
                                          </tr>

                                           <tr>
                                            <td>
                                                <table width="100%" border="0" cellspacing="1" cellpadding="1">
                                           <?

                                                    if($row1[0]==1 || $row1[0]==4)
                                                    {
                                                       $que = "SELECT
                                                         p.proy_id,
	                                                     p.proy_cod,
	                                                     p.proy_nombre,
	                                                     p.proy_numActa,
	                                                     p.proy_fechaAprobacion,
	                                                     p.proy_numViviendas,
	                                                     p.total_finan_pvs_cons,
                                                         p.proy_subprograma

	                                                    FROM proyecto p, ubicacion u
	                                                    where p.proy_id=u.id_proyecto
	                                                    and p.proy_subprograma='$row1[0]'
	                                                    and u.ubi_departamento='$dep[$i]'
	                                                    ORDER BY (p.proy_cod)";
                                                    }
                                                    else
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
                                                    }

	                                                $resu = mysql_query($que,$conexion);    //SELECCIONA PROYECTO Y UBICACION DE PROYECTO POR DEPTO.
	                                                $st1=0;

                                                    $cont_d_proy=0;//contador de proyecto

                                                    $n_viv=0;
                                                    $monto_compro_de_proyecto=0; //nomto comprometido por proyecto
                                                    $monto_desem_de_proyecto=0; //nomto desembolsado por proyecto

                                                    while ($row2=mysql_fetch_array($resu))
	                                                {     	$cont_d_proy=$cont_d_proy+1;
                                                    		$m_desem=number_format($row2[6],2,",",".");
										   ?>
	                                                <tr>
                                                        <td width="2%"><?echo"$cont_d_proy";?></td>
	                                                    <td width="10%"><?echo"$row2[1]";?></td><!--CODIGO DE PROYECTO -->
	                                                    <td width="30%"><?echo"$row2[2]";?></td><!--NOMBRE DE PROYECTO -->
	                                                    <td width="3%">&nbsp;</td>
	                                                    <td width="10%" align="center"><?echo"$row2[3]";?></td><!--NUMERO DE ACTA -->
	                                                    <td width="10%" align="center"><?echo"$row2[4]";?></td> <!--FECHA DE APROBACION -->
	                                                    <td width="7%" align="center"><?echo"$row2[5]";?></td> <!--NUMERO DE VIVIENDA -->
	                                                    <td width="10%" align="right"><?echo"$m_desem";?></td>  <!--MONTO COMPROMETIDO -->
	                                                    <td width="10%">&nbsp;</td>
	                                                    <td width="10%">&nbsp;</td>
	                                                  </tr>
                                                      <?

	                                                  		$qdesem = "SELECT * FROM desembolso WHERE id_proy='$row2[0]'";
	                                                        $rdesem = mysql_query($qdesem,$conexion);  //SELECCIONA DESEMBOLSO

	                                                        $sw=1;
	                                                        $monto_desembolso=0;
	                                                        $saldo_proyecto=0;

	                                                        while ($rowdesem=mysql_fetch_array($rdesem))
	                                                        {     $imp_desem=number_format($rowdesem[7],2,",",".");
	                                                        ?>

                                                            <tr>
	                                                        	<td width="2%">&nbsp;</td>
	                                                            <td width="10%">&nbsp;</td>
	                                                            <td width="30%">&nbsp;</td>
	                                                            <td width="3%" align="center"><i><?echo"$rowdesem[2]";?></td>  <!--NUMERO DE DESEMBOLSO -->
	                                                            <td width="10%" align="center"><i><?echo"$rowdesem[5]";?></td> <!--CARTA OPERATIVA -->
	                                                            <td width="10%" align="center"><i><?echo"$rowdesem[8]";?></td>  <!--NUMERO CHEQUE -->
	                                                            <td width="7%" align="center"><i><?echo"$rowdesem[6]";?></td> <!--FECHA DE DESEMBOLSO -->
	                                                            <td width="10%">&nbsp;</td>
	                                                            <td width="10%" align="right"><i><?echo"$imp_desem";?></td> <!--IMPORTE DE DESEMBOLSO-->
	                                                            <td width="10%">&nbsp;</td>
	                                                        </tr>
	                                                  <?
	                                                            $monto_desembolso=$monto_desembolso+$rowdesem[7];
	                                                            } //fin de DESEMBOLSO
                                                                mysql_free_result($rdesem);

	                                                            $saldo_proyecto=$row2[6]-$monto_desembolso;

                                                                $monto_desembolso2=number_format($monto_desembolso,2,",",".");
                                                                $saldo_proyecto2=number_format($saldo_proyecto,2,",",".");
                                                       ?>

                                                       <tr align="right">
                                                       	<td >&nbsp;</td>
                                                        <td >&nbsp;</td>
                                                        <td >&nbsp;</td>
                                                        <td colspan="5" class="estilo5" align="right">Total del Proyecto Bs.</td>
                                                        <td class="estilo5"><?echo"$monto_desembolso2";?></td>
                                                        <td class="estilo5"><?echo"$saldo_proyecto2";?></td>
                                                      </tr>

                                                      <tr>
                                                        <td width="100%" colspan="10"><hr width="100%" size="1" style="color:black" /></td>
                                                      </tr>

													   <?
                                                             $n_viv=$n_viv+$row2[5];
                                                             $monto_compro_de_proyecto=$monto_compro_de_proyecto+$row2[6]; //nomto comprometido por proyecto
                                                    		 $monto_desem_de_proyecto=$monto_desem_de_proyecto+$monto_desembolso; //nomto desembolsado por proyecto

                                                             }
                                                             $saldo_subpr=$monto_compro_de_proyecto-$monto_desem_de_proyecto;

                                                             $monto_compro_de_proyecto2=number_format($monto_compro_de_proyecto,2,",",".");
                                                             $monto_desem_de_proyecto2=number_format($monto_desem_de_proyecto,2,",",".");
                                                             $saldo_subpr2=number_format($saldo_subpr,2,",",".");

	                                                    mysql_free_result($resu);

                                                       $sp[$j]='';
                                                       ?>


	                                                </table>
	                                            </td>
	                                      </tr>

                                          <tr>
                                    	    <td><table width="100%" border="0" cellspacing="1" cellpadding="1">
	                                          <tr align="right">
	                                            <td width="" colspan="6"><b>SUBTOTAL del PROGRAMA en Bs. </td>
	                                            <td width="10%"><b>Nro Viv.<?echo"$n_viv";?></td>
	                                            <td width="10%"><b><?echo"$monto_compro_de_proyecto2";?></td>
	                                            <td width="10%"><b><?echo"$monto_desem_de_proyecto2";?></td>
	                                            <td width="10%"><b><?echo"$saldo_subpr2";?></td>
	                                          </tr>
	                                        </table></td>
	                                      </tr>
                                       <?

                                                      $n_viv_depto=$n_viv_depto+$n_viv;
                                                	  $monto_compr_depto=$monto_compr_depto+$monto_compro_de_proyecto;
                                                	  $monto_desem_depto=$monto_desem_depto+$monto_desem_de_proyecto;
                                                      }
                                                      mysql_free_result($resul);

                                                      $saldo_depto=$monto_compr_depto-$monto_desem_depto;

                                                      $monto_compr_depto1=number_format($monto_compr_depto,2,",",".");
                                                      $monto_desem_depto1=number_format($monto_desem_depto,2,",",".");
                                                      $saldo_depto1=number_format($saldo_depto,2,",",".");

                                       ?>

                                  <tr>
                                  <td width="100%" colspan="10"><hr width="100%" size="1" style="color:black" /></td>
                                  </tr>

                                  <tr>
	                                <td><table width="100%" border="0" cellspacing="1" cellpadding="1">
	                                  <tr align="right">
	                                     <td width="" colspan="6"><b>SUBTOTAL DEL DEPARTAMENTO EN Bs: </td>
                                         <td width="10%"><b>Nº Viv.<?echo"$n_viv_depto";?></td>
                                         <td width="10%"><b><?echo"$monto_compr_depto1";?></td>
	                                     <td width="10%"><b><?echo"$monto_desem_depto1";?></td>
	                                     <td width="10%"><b><?echo"$saldo_depto1";?></td>
	                                   </tr>
	                                </table></td>
	                              </tr>

                                  <?

                                     $n_viv_nacional=$n_viv_nacional+$n_viv_depto;
                                     $monto_compr_nacional=$monto_compr_nacional+$monto_compr_depto;
                                     $monto_desem_nacional=$monto_desem_nacional+$monto_desem_depto;
                                     }  // fin de for
                                     $saldo_nacional=$monto_compr_nacional-$monto_desem_nacional;

                                     $monto_compr_nacional1=number_format($monto_compr_nacional,2,",",".");
                                     $monto_desem_nacional1=number_format($monto_desem_nacional,2,",",".");
                                     $saldo_nacional1=number_format($saldo_nacional,2,",",".");

                                 ?>
                                 <tr>
                                  <td width="100%" colspan="10"><hr width="100%" size="1" style="color:black" /></td>
                                  </tr>
                                  <tr>
                                     <td><table width="100%" border="0" cellspacing="1" cellpadding="1">
                                       <tr align="right">
                                         <td width="" colspan="6"><b>TOTAL NACIONAL EN Bs: </td>
                                         <td width="10%"><b>N Viv.<?echo"$n_viv_nacional";?></td>
                                         <td width="10%"><b><?echo"$monto_compr_nacional1";?></td>
                                         <td width="10%"><b><?echo"$monto_desem_nacional1";?></td>
                                         <td width="10%"><b><?echo"$saldo_nacional1";?></td>
                                      </tr>
                                    </table></td>
                                  </tr>
                                    <?
	                                 } //fin de if de estado=todos
                                    else
                                    {
                                        $n_viv_nacional=0;
                                     	$monto_compr_nacional=0;
                                     	$monto_desem_nacional=0;

                                    	for($i=0;$i<count($dep);$i++)
	                                       {
											?>
                                          <tr class="estilo1">
	                               				<td width="100%" ><b><?echo"$dep[$i]";?></td>
	                              		  </tr>
                                          <?
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
											?>
                                           <tr class="e">
	                                       		<td width="100%"><b><?echo"SUBPROGRAMA Nº $row1[0]";?></td>
	                                       </tr>

                                           <tr>
	                                        <td>
                                              <table width="100%" border="0" cellspacing="1" cellpadding="1">
                                              	<tr>
	                                                <td width="2%"><b>N&ordm;</td>
	                                                <td width="10%"><b>Cod.Proy.</td>
	                                                <td width="30%" ><b>Nombre Del Proyecto </td>
	                                                <td width="3%">&nbsp;</td>
	                                                <td width="10%" align="center"><b>Acta</td>
	                                                <td width="10%" align="center"><b>Fech. Aprob. </td>
	                                                <td width="7%" align="center"><b>N&ordm; Viv. </td>
	                                                <td width="10%" align="right"><b>Comprometido</td>
	                                                <td width="10%">&nbsp;</td>
	                                                <td width="10%">&nbsp;</td>
	                                              </tr>
	                                              <tr>
	                                                <td width="2%">&nbsp;</td>
	                                                <td width="10%">&nbsp;</td>
	                                                <td width="30%">&nbsp;</td>
	                                                <td width="3%" align="center"><i>N&ordm;</td>
	                                                <td width="10%" align="center" ><i>Carta Operativa </td>
	                                                <td width="10%" align="center"><i>Cheque</td>
	                                                <td width="7%" align="center"><i>Fech.Desem.</td>
	                                                <td width="10%">&nbsp;</td>
	                                                <td width="10%" align="right"><i>Imp. Desembolso </td>
	                                                <td width="10%" align="right"><i>Saldo</td>
	                                              </tr>
	                                          </table>
                                            </td>
	                                      </tr>

                                          <tr>
                                          	<td width="100%" colspan="10"><hr width="100%" size="1" style="color:black" /></td>
                                          </tr>

                                           <tr>
                                            <td>
                                                <table width="100%" border="0" cellspacing="1" cellpadding="1">
                                           <?

                                                    if($row1[0]==1 || $row1[0]==4)
                                                    {
                                                       $que = "SELECT
                                                         p.proy_id,
	                                                     p.proy_cod,
	                                                     p.proy_nombre,
	                                                     p.proy_numActa,
	                                                     p.proy_fechaAprobacion,
	                                                     p.proy_numViviendas,
	                                                     p.total_finan_pvs_cons,
                                                         p.proy_subprograma

	                                                    FROM proyecto p, ubicacion u
	                                                    where p.proy_id=u.id_proyecto
	                                                    and p.proy_subprograma='$row1[0]'
	                                                    and u.ubi_departamento='$dep[$i]'
                                                        and p.proy_situacion='$estado'
	                                                    ORDER BY (p.proy_cod)";
                                                    }
                                                    else
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
                                                    }


	                                                $resu = mysql_query($que,$conexion);
	                                                $st1=0;

                                                    $cont_d_proy=0;//contador de proyecto

                                                    $n_viv=0;
                                                    $monto_compro_de_proyecto=0; //nomto comprometido por proyecto
                                                    $monto_desem_de_proyecto=0; //nomto desembolsado por proyecto

                                                    while ($row2=mysql_fetch_array($resu))
	                                                {     $cont_d_proy=$cont_d_proy+1;
                                                    	  $compr=number_format($row2[6],2,",",".");
										    	   ?>
	                                                <tr>
                                                        <td width="2%"><?echo"$cont_d_proy";?></td>
	                                                    <td width="10%"><?echo"$row2[1]";?></td><!--CODIGO DE PROYECTO -->
	                                                    <td width="30%"><?echo"$row2[2]";?></td><!--NOMBRE DE PROYECTO -->
	                                                    <td width="3%">&nbsp;</td>
	                                                    <td width="10%" align="center"><?echo"$row2[3]";?></td><!--NUMERO DE ACTA -->
	                                                    <td width="10%" align="center"><?echo"$row2[4]";?></td> <!--FECHA DE APROBACION -->
	                                                    <td width="7%" align="center"><?echo"$row2[5]";?></td> <!--NUMERO DE VIVIENDA -->
	                                                    <td width="10%" align="right"><?echo"$compr";?></td>  <!--MONTO COMPROMETIDO -->
	                                                    <td width="10%">&nbsp;</td>
	                                                    <td width="10%">&nbsp;</td>
	                                                  </tr>
                                                      <?


	                                                  		$qdesem = "SELECT * FROM desembolso WHERE id_proy='$row2[0]'";
	                                                        $rdesem = mysql_query($qdesem,$conexion);

	                                                        $sw=1;
	                                                        $monto_desembolso=0;
	                                                        $saldo_proyecto=0;

	                                                        while ($rowdesem=mysql_fetch_array($rdesem))
	                                                        {
                                                            $imp_desem=number_format($rowdesem[7],2,",",".");
	                                                        ?>
	                                                        <tr>
	                                                        	<td width="2%">&nbsp;</td>
	                                                            <td width="10%">&nbsp;</td>
	                                                            <td width="30%">&nbsp;</td>
	                                                            <td width="3%" align="center"><i><?echo"$rowdesem[2]";?></td>  <!--NUMERO DE DESEMBOLSO -->
	                                                            <td width="10%" align="center"><i><?echo"$rowdesem[5]";?></td> <!--CARTA OPERATIVA -->
	                                                            <td width="10%" align="center"><i><?echo"$rowdesem[8]";?></td>  <!--NUMERO CHEQUE -->
	                                                            <td width="7%" align="center"><i><?echo"$rowdesem[6]";?></td> <!--FECHA DE DESEMBOLSO -->
	                                                            <td width="10%">&nbsp;</td>
	                                                            <td width="10%" align="right"><i><?echo"$imp_desem";?></td> <!--IMPORTE DE DESEMBOLSO-->
	                                                            <td width="10%">&nbsp;</td>
	                                                        </tr>

                                                      <?
	                                                            $monto_desembolso=$monto_desembolso+$rowdesem[7];
	                                                            } //fin de DESEMBOLSO
	                                                            $saldo_proyecto=$row2[6]-$monto_desembolso;

                                                                $monto_desembolso1=number_format($monto_desembolso,2,",",".");
                                                                $saldo_proyecto1=number_format($saldo_proyecto,2,",",".");

                                                       ?>

                                                       <tr align="right">
                                                       	<td >&nbsp;</td>
                                                        <td >&nbsp;</td>
                                                        <td >&nbsp;</td>
                                                        <td colspan="5" class="estilo5" align="right">Total del Proyecto Bs.</td>
                                                        <td class="estilo5"><?echo"$monto_desembolso1";?></td>
                                                        <td class="estilo5"><?echo"$saldo_proyecto1";?></td>
                                                      </tr>

                                                      <tr>
                                                        <td width="100%" colspan="10"><hr width="100%" size="1" style="color:black" /></td>
                                                      </tr>

													   <?

                                                             $monto_compro_de_proyecto=$monto_compro_de_proyecto+$row2[6]; //nomto comprometido por proyecto
                                                    		 $monto_desem_de_proyecto=$monto_desem_de_proyecto+$monto_desembolso; //nomto desembolsado por proyecto
                                                             $n_viv=$n_viv+$row2[5];
                                                             }
                                                             $saldo_subpr=$monto_compro_de_proyecto-$monto_desem_de_proyecto;

                                                             $monto_compro_de_proyecto1=number_format($monto_compro_de_proyecto,2,",",".");
                                                             $monto_desem_de_proyecto1=number_format($monto_desem_de_proyecto,2,",",".");
                                                             $saldo_subpr1=number_format($saldo_subpr,2,",",".");

	                                                    //mysql_free_result($resu);
                                                       $sp[$j]='';
                                                       ?>

	                                                </table>
	                                            </td>
	                                      </tr>

                                          <tr>
                                    	    <td><table width="100%" border="0" cellspacing="1" cellpadding="1">
	                                          <tr align="right">
	                                            <td width="" colspan="6"><b>SUBTOTAL DEL SUBPROGRAMA EN Bs: </td>
	                                            <td width="10%"><b>Nro Viv.<?echo"$n_viv";?></td>
	                                            <td width="10%"><b><?echo"$monto_compro_de_proyecto1";?></td>
	                                            <td width="10%"><b><?echo"$monto_desem_de_proyecto1";?></td>
	                                            <td width="10%"><b><?echo"$saldo_subpr1";?></td>
	                                          </tr>
	                                        </table></td>
	                                      </tr>
                                       <?

                                                      $n_viv_depto=$n_viv_depto+$n_viv;
                                                	  $monto_compr_depto=$monto_compr_depto+$monto_compro_de_proyecto;
                                                	  $monto_desem_depto=$monto_desem_depto+$monto_desem_de_proyecto;
                                                      }
                                                      $saldo_depto=$monto_compr_depto-$monto_desem_depto;

                                                      $monto_compr_depto1=number_format($monto_compr_depto,2,",",".");
                                                      $monto_desem_depto1=number_format($monto_desem_depto,2,",",".");
                                                      $saldo_depto1=number_format($saldo_depto,2,",",".");


                                       ?>

                                  <tr>
                                  <td width="100%" colspan="10"><hr width="100%" size="1" style="color:black" /></td>
                                  </tr>

                                  <tr>
	                                <td><table width="100%" border="0" cellspacing="1" cellpadding="1">
	                                  <tr align="right">
	                                     <td width="" colspan="6"><b>SUBTOTAL DEL DEPARTAMENTO EN Bs: </td>
                                         <td width="10%"><b>Nº Viv.<?echo"$n_viv_depto";?></td>
                                         <td width="10%"><b><?echo"$monto_compr_depto1";?></td>
	                                     <td width="10%"><b><?echo"$monto_desem_depto1";?></td>
	                                     <td width="10%"><b><?echo"$saldo_depto1";?></td>
	                                   </tr>
	                                </table></td>
	                              </tr>

                                    <?

                                     $n_viv_nacional=$n_viv_nacional+$n_viv_depto;
                                     $monto_compr_nacional=$monto_compr_nacional+$monto_compr_depto;
                                     $monto_desem_nacional=$monto_desem_nacional+$monto_desem_depto;
                                     }  // fin de for
                                     $saldo_nacional=$monto_compr_nacional-$monto_desem_nacional;

                                     $monto_compr_nacional1=number_format($monto_compr_nacional,2,",",".");
                                     $monto_desem_nacional1=number_format($monto_desem_nacional,2,",",".");
                                     $saldo_nacional1=number_format($saldo_nacional,2,",",".");

                                 ?>
                                 <tr>
                                  <td width="100%" colspan="10"><hr width="100%" size="1" style="color:black" /></td>
                                  </tr>
                                  <tr>
                                     <td><table width="100%" border="0" cellspacing="1" cellpadding="1">
                                       <tr align="right">
                                         <td width="" colspan="6"><b>TOTAL NACIONAL EN Bs: </td>
                                         <td width="10%"><b>N Viv.<?echo"$n_viv_nacional";?></td>
                                         <td width="10%"><b><?echo"$monto_compr_nacional1";?></td>
                                         <td width="10%"><b><?echo"$monto_desem_nacional1";?></td>
                                         <td width="10%"><b><?echo"$saldo_nacional1";?></td>
                                      </tr>
                                    </table></td>
                                  </tr>
                                    <?
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
											?>
                                          <tr class="estilo1">
	                               				<td width="100%" ><b><?echo"$row[$i]";?></td>
	                              		  </tr>
                                          <?
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
											?>
                                           <tr class="e">
	                                       		<td width="100%"><b><?echo"SUBPROGRAMA Nº $row1[0]";?></td>
	                                       </tr>

                                           <tr>
	                                        <td>
                                              <table width="100%" border="0" cellspacing="1" cellpadding="1">
                                              	<tr>
	                                                <td width="2%"><b>N&ordm;</td>
	                                                <td width="10%"><b>Cod.Proy.</td>
	                                                <td width="30%" ><b>Nombre Del Proyecto </td>
	                                                <td width="3%">&nbsp;</td>
	                                                <td width="10%" align="center"><b>Acta</td>
	                                                <td width="10%" align="center"><b>Fech. Aprob. </td>
	                                                <td width="7%" align="center"><b>N&ordm; Viv. </td>
	                                                <td width="10%" align="right"><b>Comprometido</td>
	                                                <td width="10%">&nbsp;</td>
	                                                <td width="10%">&nbsp;</td>
	                                              </tr>
	                                              <tr>
	                                                <td width="2%">&nbsp;</td>
	                                                <td width="10%">&nbsp;</td>
	                                                <td width="30%">&nbsp;</td>
	                                                <td width="3%" align="center"><i>N&ordm;</td>
	                                                <td width="10%" align="center" ><i>Carta Operativa </td>
	                                                <td width="10%" align="center"><i>Cheque</td>
	                                                <td width="7%" align="center"><i>Fech.Desem.</td>
	                                                <td width="10%">&nbsp;</td>
	                                                <td width="10%" align="right"><i>Imp. Desembolso </td>
	                                                <td width="10%" align="right"><i>Saldo</td>
	                                              </tr>
	                                          </table>
                                            </td>
	                                      </tr>

                                           <tr>
                                            <td>
                                                <table width="100%" border="0" cellspacing="1" cellpadding="1">
                                           <?
                                                   if($row1[0]==1 || $row1[0]==4)
                                                    {
                                                       $que = "SELECT
                                                         p.proy_id,
	                                                     p.proy_cod,
	                                                     p.proy_nombre,
	                                                     p.proy_numActa,
	                                                     p.proy_fechaAprobacion,
	                                                     p.proy_numViviendas,
	                                                     p.total_finan_pvs_cons,
                                                         p.proy_subprograma

	                                                    FROM proyecto p, ubicacion u
	                                                    where p.proy_id=u.id_proyecto
	                                                    and p.proy_subprograma='$row1[0]'
	                                                    and u.ubi_departamento='$row[$i]'
	                                                    ORDER BY (p.proy_cod)";
                                                    }
                                                    else
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
                                                    }


	                                                $resu = mysql_query($que,$conexion);
	                                                $st1=0;

                                                    $cont_d_proy=0;//contador de proyecto

                                                    $n_viv=0;
                                                    $monto_compro_de_proyecto=0; //nomto comprometido por proyecto
                                                    $monto_desem_de_proyecto=0; //nomto desembolsado por proyecto

                                                    while ($row2=mysql_fetch_array($resu))
	                                                {     $cont_d_proy=$cont_d_proy+1;
                                                    	  $compr=number_format($row2[6],2,",",".");
										    	   ?>
	                                                <tr>
                                                        <td width="2%"><?echo"$cont_d_proy";?></td>
	                                                    <td width="10%"><?echo"$row2[1]";?></td><!--CODIGO DE PROYECTO -->
	                                                    <td width="30%"><?echo"$row2[2]";?></td><!--NOMBRE DE PROYECTO -->
	                                                    <td width="3%">&nbsp;</td>
	                                                    <td width="10%" align="center"><?echo"$row2[3]";?></td><!--NUMERO DE ACTA -->
	                                                    <td width="10%" align="center"><?echo"$row2[4]";?></td> <!--FECHA DE APROBACION -->
	                                                    <td width="7%" align="center"><?echo"$row2[5]";?></td> <!--NUMERO DE VIVIENDA -->
	                                                    <td width="10%" align="right"><?echo"$compr";?></td>  <!--MONTO COMPROMETIDO -->
	                                                    <td width="10%">&nbsp;</td>
	                                                    <td width="10%">&nbsp;</td>
	                                                  </tr>
                                                      <?

	                                                  		$qdesem = "SELECT * FROM desembolso WHERE id_proy='$row2[0]'";
	                                                        $rdesem = mysql_query($qdesem,$conexion);

	                                                        $sw=1;
	                                                        $monto_desembolso=0;
	                                                        $saldo_proyecto=0;

	                                                        while ($rowdesem=mysql_fetch_array($rdesem))
	                                                        {
                                                            $imp_desem=number_format($rowdesem[7],2,",",".");
	                                                        ?>
	                                                        <tr>
	                                                        	<td width="2%">&nbsp;</td>
	                                                            <td width="10%">&nbsp;</td>
	                                                            <td width="30%">&nbsp;</td>
	                                                            <td width="3%" align="center"><i><?echo"$rowdesem[2]";?></td>  <!--NUMERO DE DESEMBOLSO -->
	                                                            <td width="10%" align="center"><i><?echo"$rowdesem[5]";?></td> <!--CARTA OPERATIVA -->
	                                                            <td width="10%" align="center"><i><?echo"$rowdesem[8]";?></td>  <!--NUMERO CHEQUE -->
	                                                            <td width="7%" align="center"><i><?echo"$rowdesem[6]";?></td> <!--FECHA DE DESEMBOLSO -->
	                                                            <td width="10%">&nbsp;</td>
	                                                            <td width="10%" align="right"><i><?echo"$imp_desem";?></td> <!--IMPORTE DE DESEMBOLSO-->
	                                                            <td width="10%">&nbsp;</td>
	                                                        </tr>

                                                      <?
	                                                            $monto_desembolso=$monto_desembolso+$rowdesem[7];
	                                                            } //fin de DESEMBOLSO
	                                                            $saldo_proyecto=$row2[6]-$monto_desembolso;

                                                                $monto_desembolso1=number_format($monto_desembolso,2,",",".");
                                                                $saldo_proyecto1=number_format($saldo_proyecto,2,",",".");

                                                       ?>

                                                       <tr align="right">
                                                       	<td >&nbsp;</td>
                                                        <td >&nbsp;</td>
                                                        <td >&nbsp;</td>
                                                        <td colspan="5" class="estilo5" align="right">Total del Proyecto Bs.</td>
                                                        <td class="estilo5"><?echo"$monto_desembolso1";?></td>
                                                        <td class="estilo5"><?echo"$saldo_proyecto1";?></td>
                                                      </tr>

                                                      <tr>
                                                        <td width="100%" colspan="10"><hr width="100%" size="1" style="color:black" /></td>
                                                      </tr>

													   <?
                                                             $monto_compro_de_proyecto=$monto_compro_de_proyecto+$row2[6]; //nomto comprometido por proyecto
                                                    		 $monto_desem_de_proyecto=$monto_desem_de_proyecto+$monto_desembolso; //nomto desembolsado por proyecto
                                                             $n_viv=$n_viv+$row2[5];
                                                             }
                                                             $saldo_subpr=$monto_compro_de_proyecto-$monto_desem_de_proyecto;

                                                             $monto_compro_de_proyecto1=number_format($monto_compro_de_proyecto,2,",",".");
                                                             $monto_desem_de_proyecto1=number_format($monto_desem_de_proyecto,2,",",".");
                                                             $saldo_subpr1=number_format($saldo_subpr,2,",",".");

	                                                    //mysql_free_result($resu);
                                                       $sp[$j]='';
                                                       ?>

	                                                </table>
	                                            </td>
	                                      </tr>

                                          <tr>
                                    	    <td><table width="100%" border="0" cellspacing="0" cellpadding="0">
	                                          <tr align="right">
	                                            <td width="" colspan="6"><b>SUBTOTAL DEL SUBPROGRAMA EN Bs: </td>
	                                            <td width="10%"><b>Nro Viv.<?echo"$n_viv";?></td>
	                                            <td width="10%"><b><?echo"$monto_compro_de_proyecto1";?></td>
	                                            <td width="10%"><b><?echo"$monto_desem_de_proyecto1";?></td>
	                                            <td width="8%"><b><?echo"$saldo_subpr1";?></td>
	                                          </tr>
	                                        </table></td>
	                                      </tr>
                                       <?

                                                      $n_viv_depto=$n_viv_depto+$n_viv;
                                                	  $monto_compr_depto=$monto_compr_depto+$monto_compro_de_proyecto;
                                                	  $monto_desem_depto=$monto_desem_depto+$monto_desem_de_proyecto;
                                                      }
                                                      $saldo_depto=$monto_compr_depto-$monto_desem_depto;

                                                      $monto_compr_depto1=number_format($monto_compr_depto,2,",",".");
                                                      $monto_desem_depto1=number_format($monto_desem_depto,2,",",".");
                                                      $saldo_depto1=number_format($saldo_depto,2,",",".");

                                       if($row[$i]!=''){
                                       ?>

                                  <tr>
                                  <td width="100%" colspan="10"><hr width="100%" size="1" style="color:black" /></td>
                                  </tr>

                                  <tr>
	                                <td><table width="100%" border="0" cellspacing="0" cellpadding="0">
	                                  <tr align="right">
	                                     <td width="" colspan="6"><b>SUBTOTAL DEL DEPARTAMENTO EN Bs: </td>
                                         <td width="10%"><b>Nº Viv.<?echo"$n_viv_depto";?></td>
                                         <td width="10%"><b><?echo"$monto_compr_depto1";?></td>
	                                     <td width="10%"><b><?echo"$monto_desem_depto1";?></td>
	                                     <td width="8%"><b><?echo"$saldo_depto1";?></td>
	                                   </tr>
	                                </table></td>
	                              </tr>

                                  <? 	}
                                     $n_viv_nacional=$n_viv_nacional+$n_viv_depto;
                                     $monto_compr_nacional=$monto_compr_nacional+$monto_compr_depto;
                                     $monto_desem_nacional=$monto_desem_nacional+$monto_desem_depto;
                                     }  // fin de for
                                     $saldo_nacional=$monto_compr_nacional-$monto_desem_nacional;

                                 ?>
                                  <!--
                                  <tr>
                                     <td><table width="100%" border="1" cellspacing="1" cellpadding="1">
                                       <tr align="right">
                                         <td width="30%">&nbsp;</td>
                                         <td width="30%">TOTAL NACIONAL EN Bs: </td>
                                         <td width="10%">N Viv.<?echo"$n_viv_nacional";?></td>
                                         <td width="10%"><?echo"$monto_compr_nacional";?></td>
                                         <td width="10%"><?echo"$monto_desem_nacional";?></td>
                                         <td width="10%"><?echo"$saldo_nacional";?></td>
                                      </tr>
                                    </table></td>
                                  </tr> -->

                                    <?
	                                 } //fin de if de estado=todos
                                    else
                                    {
                                        $n_viv_nacional=0;
                                     	$monto_compr_nacional=0;
                                     	$monto_desem_nacional=0;

                                    	for($i=0;$i<count($row);$i++)
	                                       {
											?>
                                          <tr class="estilo1">
	                               				<td width="100%" ><b><?echo"$row[$i]";?></td>
	                              		  </tr>
                                          <?
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
											?>
                                           <tr class="e">
	                                       		<td width="100%"><b><?echo"SUBPROGRAMA Nº $row1[0]";?></td>
	                                       </tr>

                                           <tr>
	                                        <td>
                                              <table width="100%" border="0" cellspacing="1" cellpadding="1">
                                              	<tr>
	                                                <td width="2%"><b>N&ordm;</td>
	                                                <td width="10%"><b>Cod.Proy.</td>
	                                                <td width="30%" ><b>Nombre Del Proyecto </td>
	                                                <td width="3%">&nbsp;</td>
	                                                <td width="10%" align="center"><b>Acta</td>
	                                                <td width="10%" align="center"><b>Fech. Aprob. </td>
	                                                <td width="7%" align="center"><b>N&ordm; Viv. </td>
	                                                <td width="10%" align="right"><b>Comprometido</td>
	                                                <td width="10%">&nbsp;</td>
	                                                <td width="10%">&nbsp;</td>
	                                              </tr>
	                                              <tr>
	                                                <td width="2%">&nbsp;</td>
	                                                <td width="10%">&nbsp;</td>
	                                                <td width="30%">&nbsp;</td>
	                                                <td width="3%" align="center"><i>N&ordm;</td>
	                                                <td width="10%" align="center" ><i>Carta Operativa </td>
	                                                <td width="10%" align="center"><i>Cheque</td>
	                                                <td width="7%" align="center"><i>Fech.Desem.</td>
	                                                <td width="10%">&nbsp;</td>
	                                                <td width="10%" align="right"><i>Imp. Desembolso </td>
	                                                <td width="10%" align="right"><i>Saldo</td>
	                                              </tr>
	                                          </table>
                                            </td>
	                                      </tr>

                                          <tr>
                                           <td width="100%" colspan="10"><hr width="100%" size="1" style="color:black" /></td>
                                          </tr>

                                           <tr>
                                            <td>
                                                <table width="100%" border="0" cellspacing="1" cellpadding="1">
                                           <?
                                                   if($row1[0]==1 || $row1[0]==4)
                                                    {
                                                       $que = "SELECT
                                                         p.proy_id,
	                                                     p.proy_cod,
	                                                     p.proy_nombre,
	                                                     p.proy_numActa,
	                                                     p.proy_fechaAprobacion,
	                                                     p.proy_numViviendas,
	                                                     p.total_finan_pvs_cons,
                                                         p.proy_subprograma

	                                                    FROM proyecto p, ubicacion u
	                                                    where p.proy_id=u.id_proyecto
	                                                    and p.proy_subprograma='$row1[0]'
	                                                    and u.ubi_departamento='$row[$i]'
                                                        and p.proy_situacion='$estado'
	                                                    ORDER BY (p.proy_cod)";
                                                    }
                                                    else
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
                                                    }

	                                                $resu = mysql_query($que,$conexion);
	                                                $st1=0;

                                                    $cont_d_proy=0;//contador de proyecto

                                                    $n_viv=0;
                                                    $monto_compro_de_proyecto=0; //nomto comprometido por proyecto
                                                    $monto_desem_de_proyecto=0; //nomto desembolsado por proyecto

                                                    while ($row2=mysql_fetch_array($resu))
	                                                {     $cont_d_proy=$cont_d_proy+1;
                                                    	  $compr=number_format($row2[6],2,",",".");
										    	   ?>
	                                                <tr>
                                                        <td width="2%"><?echo"$cont_d_proy";?></td>
	                                                    <td width="10%"><?echo"$row2[1]";?></td><!--CODIGO DE PROYECTO -->
	                                                    <td width="30%"><?echo"$row2[2]";?></td><!--NOMBRE DE PROYECTO -->
	                                                    <td width="3%">&nbsp;</td>
	                                                    <td width="10%" align="center"><?echo"$row2[3]";?></td><!--NUMERO DE ACTA -->
	                                                    <td width="10%" align="center"><?echo"$row2[4]";?></td> <!--FECHA DE APROBACION -->
	                                                    <td width="7%" align="center"><?echo"$row2[5]";?></td> <!--NUMERO DE VIVIENDA -->
	                                                    <td width="10%" align="right"><?echo"$compr";?></td>  <!--MONTO COMPROMETIDO -->
	                                                    <td width="10%">&nbsp;</td>
	                                                    <td width="10%">&nbsp;</td>
	                                                  </tr>
                                                      <?

	                                                  		$qdesem = "SELECT * FROM desembolso WHERE id_proy='$row2[0]'";
	                                                        $rdesem = mysql_query($qdesem,$conexion);

	                                                        $sw=1;
	                                                        $monto_desembolso=0;
	                                                        $saldo_proyecto=0;

	                                                        while ($rowdesem=mysql_fetch_array($rdesem))
	                                                        {
                                                            	$imp_desem=number_format($rowdesem[7],2,",",".");
	                                                        ?>
	                                                        <tr>
	                                                        	<td width="2%">&nbsp;</td>
	                                                            <td width="10%">&nbsp;</td>
	                                                            <td width="30%">&nbsp;</td>
	                                                            <td width="3%" align="center"><i><?echo"$rowdesem[2]";?></td>  <!--NUMERO DE DESEMBOLSO -->
	                                                            <td width="10%" align="center"><i><?echo"$rowdesem[5]";?></td> <!--CARTA OPERATIVA -->
	                                                            <td width="10%" align="center"><i><?echo"$rowdesem[8]";?></td>  <!--NUMERO CHEQUE -->
	                                                            <td width="7%" align="center"><i><?echo"$rowdesem[6]";?></td> <!--FECHA DE DESEMBOLSO -->
	                                                            <td width="10%">&nbsp;</td>
	                                                            <td width="10%" align="right"><i><?echo"$imp_desem";?></td> <!--IMPORTE DE DESEMBOLSO-->
	                                                            <td width="10%">&nbsp;</td>
	                                                        </tr>
	                                                  <?
	                                                            $monto_desembolso=$monto_desembolso+$rowdesem[7];
	                                                            } //fin de DESEMBOLSO
	                                                            $saldo_proyecto=$row2[6]-$monto_desembolso;

                                                                $monto_desembolso1=number_format($monto_desembolso,2,",",".");
                                                                $saldo_proyecto1=number_format($saldo_proyecto,2,",",".");

                                                       ?>

                                                       <tr align="right">
                                                       	<td >&nbsp;</td>
                                                        <td >&nbsp;</td>
                                                        <td >&nbsp;</td>
                                                        <td colspan="5" class="estilo5" align="right">Total del Proyecto Bs.</td>
                                                        <td class="estilo5"><?echo"$monto_desembolso1";?></td>
                                                        <td class="estilo5"><?echo"$saldo_proyecto1";?></td>
                                                      </tr>

                                                      <tr>
                                                        <td width="100%" colspan="10"><hr width="100%" size="1" style="color:black" /></td>
                                                      </tr>

													   <?
                                                             $monto_compro_de_proyecto=$monto_compro_de_proyecto+$row2[6]; //nomto comprometido por proyecto
                                                    		 $monto_desem_de_proyecto=$monto_desem_de_proyecto+$monto_desembolso; //nomto desembolsado por proyecto
                                                             $n_viv=$n_viv+$row2[5];
                                                             }
                                                             $saldo_subpr=$monto_compro_de_proyecto-$monto_desem_de_proyecto;

                                                             $monto_compro_de_proyecto1=number_format($monto_compro_de_proyecto,2,",",".");
                                                             $monto_desem_de_proyecto1=number_format($monto_desem_de_proyecto,2,",",".");
                                                             $saldo_subpr1=number_format($saldo_subpr,2,",",".");
	                                                    //mysql_free_result($resu);
                                                       $sp[$j]='';
                                                       ?>

	                                                </table>
	                                            </td>
	                                      </tr>

                                          <tr>
                                    	    <td><table width="100%" border="0" cellspacing="0" cellpadding="0">
	                                          <tr align="right">
	                                            <td width="" colspan="6"><b>SUBTOTAL DEL SUBPROGRAMA EN Bs: </td>
	                                            <td width="10%"><b>Nro Viv.<?echo"$n_viv";?></td>
	                                            <td width="10%"><b><?echo"$monto_compro_de_proyecto1";?></td>
	                                            <td width="10%"><b><?echo"$monto_desem_de_proyecto1";?></td>
	                                            <td width="8%"><b><?echo"$saldo_subpr1";?></td>
	                                          </tr>
	                                        </table></td>
	                                      </tr>
                                       <?
                                                       	$n_viv_depto=$n_viv_depto+$n_viv;
                                                		$monto_compr_depto=$monto_compr_depto+$monto_compro_de_proyecto;
                                                		$monto_desem_depto=$monto_desem_depto+$monto_desem_de_proyecto;
                                                      }
                                                      $saldo_depto=$monto_compr_depto-$monto_desem_depto;

                                                      $monto_compr_depto1=number_format($monto_compr_depto,2,",",".");
                                                      $monto_desem_depto1=number_format($monto_desem_depto,2,",",".");
                                                      $saldo_depto1=number_format($saldo_depto,2,",",".");
                                   if($row[$i]!=''){
                                       ?>
                                  <tr>
                                  <td width="100%" colspan="10"><hr width="100%" size="1" style="color:black" /></td>
                                  </tr>

                                  <tr>
	                                <td><table width="100%" border="0" cellspacing="0" cellpadding="0">
	                                  <tr align="right">
	                                     <td width="" colspan="6"><b>SUBTOTAL DEL DEPARTAMENTO EN Bs: </td>
                                         <td width="10%"><b>Nº Viv.<?echo"$n_viv_depto";?></td>
                                         <td width="10%"><b><?echo"$monto_compr_depto1";?></td>
	                                     <td width="10%"><b><?echo"$monto_desem_depto1";?></td>
	                                     <td width="8%"><b><?echo"$saldo_depto1";?></td>
	                                   </tr>
	                                </table></td>
	                              </tr>
                                  <?
                                  		}
                                     $n_viv_nacional=$n_viv_nacional+$n_viv_depto;
                                     $monto_compr_nacional=$monto_compr_nacional+$monto_compr_depto;
                                     $monto_desem_nacional=$monto_desem_nacional+$monto_desem_depto;
                                     }  // fin de for
                                     $saldo_nacional=$monto_compr_nacional-$monto_desem_nacional;

                                     $monto_compr_nacional1=number_format($monto_compr_nacional,2,",",".");
                                     $monto_desem_nacional1=number_format($monto_desem_nacional,2,",",".");
                                     $saldo_nacional1=number_format($saldo_nacional,2,",",".");
                                     /*
                                 ?>
                                  <tr>
                                     <td><table width="100%" border="1" cellspacing="1" cellpadding="1">
                                       <tr align="right">
                                         <td width="30%">&nbsp;</td>
                                         <td width="30%"><b>TOTAL NACIONAL EN Bs: </td>
                                         <td width="10%"><b>N Viv.<?echo"$n_viv_nacional";?></td>
                                         <td width="10%"><b><?echo"$monto_compr_nacional1";?></td>
                                         <td width="10%"><b><?echo"$monto_desem_nacional1";?></td>
                                         <td width="10%"><b><?echo"$saldo_nacional1";?></td>
                                      </tr>
                                    </table></td>
                                  </tr>
                                    <?
                                      */
                                    }//fin de else de estado=1
                                 }
							?>
	                		</table>

                    <?
	            break;
                }
	            case 2:
                 {
                   ?>
                               <table width="" border="0" align="center">
	                             <form action="pdf_rep_depto2.php"  method="POST" target="_blank">
	                                 <tr align="center">
	                                    <th><img src="imagenes2/PDF.jpg" width="23" height="23" /></th>
	                                  </tr>
	                                  <tr align="center">
	                                    <td>
	                                        <input type="hidden" name="campo1" value="<?=$formato;?>">
	                                        <input type="hidden" name="campo2" value="<?=$depto;?>">
	                                        <input type="hidden" name="campo3" value="<?=$estado;?>">
	                                        <input align="center" type="submit" class="n" value="I M P R I M I R" >
	                                    </td>
	                                  </tr>
	                                </form>
	                            </table>

                                <table border="1" align="center" >
	                                    <tr >
	                                        <td><b>Departamento de:</b> <?  echo"$depto"; ?></td>
	                                        <td><b>Estado de Proyecto:</b> <?  echo"$estado"; ?></td>
	                                        <td><b>tipo de Reporte:</b> <?  echo"$descrip"; ?></td>
	                                    </tr>
	                            </table>

                               <table width="100%" border="0" cellspacing="1" cellpadding="1">
                                <!--
                                 <tr>
	                                <td>
                                    	<table width="100%" border="0" cellspacing="1" cellpadding="1">
	                                      <tr>
	                                        <td width="100%">DEPARTAMENTO</td>
	                                      </tr>
	                                      <tr>
	                                        <td width="100%">SUBPROGRAMA</td>
	                                      </tr>
	                                    </table>
                                    </td>
	                              </tr> -->
                                  <?
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
											?>
                                          <tr class="estilo1">
	                               				<td width="100%" ><b><?echo"$dep[$i]";?></td>
	                              		  </tr>
                                          <?
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
											?>
                                           <tr class="e">
	                                       		<td width="100%"><b><?echo"SUBPROGRAMA Nº $row1[0]";?></td>
	                                       </tr>

                                           <tr>
	                                        <td>
                                              <table width="100%" border="0" cellspacing="1" cellpadding="1">
                                              	<tr>
	                                                <td width="2%"><b>N&ordm;</td>
	                                                <td width="10%"><b>COD.PROY.</td>
	                                                <td width="30%"><b>NOMBRE DEL PROYECTO </td>
	                                                <td width="3%"><b>&nbsp;</td>
	                                                <td width="10%" align="center"><b>ACTA</td>
	                                                <td width="7%" align="center"><b>FECH. APR. </td>
	                                                <td width="7%" align="center"><b>N&ordm; VIV. </td>
	                                                <td width="10%" align="right"><b>COMPROMETIDO</td>
	                                                <td width="10%" align="right"><b>DESEMBOLSO</td>
	                                                <td width="10%" align="right"><b>SALDO X DESEM.</td>
	                                              </tr>
	                                          </table>
                                            </td>
	                                      </tr>

                                          <tr>
                                          	<td><hr width="100%" size="1" style="color:black" /></td>
                                          </tr>

                                           <tr>
                                            <td>
                                                <table width="100%" border="0" cellspacing="1" cellpadding="1">
                                           <?

                                           			if($row1[0]==1 || $row1[0]==4)
                                                    {
                                                       $que = "SELECT
                                                         p.proy_id,
	                                                     p.proy_cod,
	                                                     p.proy_nombre,
	                                                     p.proy_numActa,
	                                                     p.proy_fechaAprobacion,
	                                                     p.proy_numViviendas,
	                                                     p.total_finan_pvs_cons,
                                                         p.proy_subprograma

	                                                    FROM proyecto p, ubicacion u
	                                                    where p.proy_id=u.id_proyecto
	                                                    and p.proy_subprograma='$row1[0]'
	                                                    and u.ubi_departamento='$dep[$i]'
	                                                    ORDER BY (p.proy_cod)";
                                                    }
                                                    else
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
                                                    }

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

                                                                $monto_desembolso1=number_format($monto_desembolso,2,",",".");
                                                                $saldo_proyecto1=number_format($saldo_proyecto,2,",",".");
										                        $compr=number_format($row2[6],2,",",".");
                                                  ?>
                                                    <tr>
                                                        <td width="2%"><?echo"$cont_d_proy";?></td>
	                                                    <td width="10%"><?echo"$row2[1]";?></td><!--CODIGO DE PROYECTO -->
	                                                    <td width="30%"><?echo"$row2[2]";?></td><!--NOMBRE DE PROYECTO -->
	                                                    <td width="3%">&nbsp;</td>
	                                                    <td width="10%" align="center"><?echo"$row2[3]";?></td><!--NUMERO DE ACTA -->
	                                                    <td width="7%" align="center"><?echo"$row2[4]";?></td> <!--FECHA DE APROBACION -->
	                                                    <td width="7%" align="center"><?echo"$row2[5]";?></td> <!--NUMERO DE VIVIENDA -->
	                                                    <td width="10%" align="right"><?echo"$compr";?></td>  <!--MONTO COMPROMETIDO -->
	                                                    <td width="10%" align="right"><?echo"$monto_desembolso1";?></td>
	                                                    <td width="10%" align="right"><?echo"$saldo_proyecto1";?></td>
	                                                  </tr>
													   <?
                                                             $monto_compro_de_proyecto=$monto_compro_de_proyecto+$row2[6]; //nomto comprometido por proyecto
                                                    		 $monto_desem_de_proyecto=$monto_desem_de_proyecto+$monto_desembolso; //nomto desembolsado por proyecto
                                                             $n_viv=$n_viv+$row2[5];
                                                             }
                                                             $saldo_subpr=$monto_compro_de_proyecto-$monto_desem_de_proyecto;

                                                             $monto_compro_de_proyecto1=number_format($monto_compro_de_proyecto,2,",",".");
                                                             $monto_desem_de_proyecto1=number_format($monto_desem_de_proyecto,2,",",".");
                                                             $saldo_subpr1=number_format($saldo_subpr,2,",",".");
	                                                    //mysql_free_result($resu);
                                                       $sp[$j]='';
                                                       ?>
	                                                </table>
	                                            </td>
	                                      </tr>

                                          <tr>
                                          	<td><hr width="100%" size="1" style="color:black" /></td>
                                          </tr>

                                          <tr>
                                    	    <td><table width="100%" border="0" cellspacing="1" cellpadding="1">
	                                          <tr align="right">
	                                            <td width="30%">&nbsp;</td>
	                                            <td width="30%"><b>SUBTOTAL DEL SUBPROGRAMA EN Bs: </td>
	                                            <td width="10%"><b>Nro Viv.<?echo"$n_viv";?></td>
	                                            <td width="10%"><b><?echo"$monto_compro_de_proyecto1";?></td>
	                                            <td width="10%"><b><?echo"$monto_desem_de_proyecto1";?></td>
	                                            <td width="10%"><b><?echo"$saldo_subpr1";?></td>
	                                          </tr>
	                                        </table></td>
	                                      </tr>
                                       <?
                                                       	$n_viv_depto=$n_viv_depto+$n_viv;
                                                		$monto_compr_depto=$monto_compr_depto+$monto_compro_de_proyecto;
                                                		$monto_desem_depto=$monto_desem_depto+$monto_desem_de_proyecto;
                                                      }
                                                      $saldo_depto=$monto_compr_depto-$monto_desem_depto;

                                                      $monto_compr_depto1=number_format($monto_compr_depto,2,",",".");
                                                      $monto_desem_depto1=number_format($monto_desem_depto,2,",",".");
                                                      $saldo_depto1=number_format($saldo_depto,2,",",".");

                                       ?>
                                  <tr>
                                  <td><hr width="100%" size="1" style="color:black" /></td>
                                  </tr>

                                  <tr>
	                                <td><table width="100%" border="0" cellspacing="1" cellpadding="1">
	                                  <tr align="right">
	                                  	<td width="30%">&nbsp;</td>
	                                     <td width="30%"><b>SUBTOTAL DEL DEPARTAMENTO EN Bs: </td>
                                         <td width="10%"><b>Nº Viv.<?echo"$n_viv_depto";?></td>
                                         <td width="10%"><b><?echo"$monto_compr_depto1";?></td>
	                                     <td width="10%"><b><?echo"$monto_desem_depto1";?></td>
	                                     <td width="10%"><b><?echo"$saldo_depto1";?></td>
	                                   </tr>
	                                </table></td>
	                              </tr>

                                  <?
                                     $n_viv_nacional=$n_viv_nacional+$n_viv_depto;
                                     $monto_compr_nacional=$monto_compr_nacional+$monto_compr_depto;
                                     $monto_desem_nacional=$monto_desem_nacional+$monto_desem_depto;
                                     }  // fin de for
                                     $saldo_nacional=$monto_compr_nacional-$monto_desem_nacional;

                                     $monto_compr_nacional1=number_format($monto_compr_nacional,2,",",".");
                                     $monto_desem_nacional1=number_format($monto_desem_nacional,2,",",".");
                                     $saldo_nacional1=number_format($saldo_nacional,2,",",".");

                                 ?>
                                  <tr>
                                  <td><hr width="100%" size="1" style="color:black" /></td>
                                  </tr>
                                  <tr>
                                     <td><table width="100%" border="0" cellspacing="1" cellpadding="1">
                                       <tr align="right">
                                         <td width="30%">&nbsp;</td>
                                         <td width="30%"><b>TOTAL NACIONAL EN Bs: </td>
                                         <td width="10%"><b>N Viv.<?echo"$n_viv_nacional";?></td>
                                         <td width="10%"><b><?echo"$monto_compr_nacional1";?></td>
                                         <td width="10%"><b><?echo"$monto_desem_nacional1";?></td>
                                         <td width="10%"><b><?echo"$saldo_nacional1";?></td>
                                      </tr>
                                    </table></td>
                                  </tr>
                                    <?
	                                 } //fin de if de estado=todos
                                    else
                                    {
                                        $n_viv_nacional=0;
                                     	$monto_compr_nacional=0;
                                     	$monto_desem_nacional=0;

                                    	for($i=0;$i<count($dep);$i++)
	                                       {
											?>
                                          <tr class="estilo1">
	                               				<td width="100%" ><b><?echo"$dep[$i]";?></td>
	                              		  </tr>
                                          <?
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
											?>
                                           <tr class="e">
	                                       		<td width="100%"><b><?echo"SUBPROGRAMA Nº $row1[0]";?></td>
	                                       </tr>

                                           <tr>
	                                        <td>
                                              <table width="100%" border="0" cellspacing="1" cellpadding="1">
                                              	<tr>
	                                                <td width="2%"><b>N&ordm;</td>
	                                                <td width="10%"><b>COD.PROY.</td>
	                                                <td width="30%"><b>NOMBRE DEL PROYECTO </td>
	                                                <td width="3%"><b>&nbsp;</td>
	                                                <td width="10%" align="center"><b>ACTA</td>
	                                                <td width="7%" align="center"><b>FECH. APR. </td>
	                                                <td width="7%" align="center"><b>N&ordm; VIV. </td>
	                                                <td width="10%" align="right"><b>COMPROMETIDO</td>
	                                                <td width="10%" align="right"><b>DESEMBOLSO</td>
	                                                <td width="10%" align="right"><b>SALDO X DESEM.</td>
	                                              </tr>
	                                          </table>
                                            </td>
	                                      </tr>

                                          <tr>
                                          	<td><hr width="100%" size="1" style="color:black" /></td>
                                          </tr>

                                           <tr>
                                            <td>
                                                <table width="100%" border="0" cellspacing="1" cellpadding="1">
                                           <?

                                                    if($row1[0]==1 || $row1[0]==4)
                                                    {
                                                       $que = "SELECT
                                                         p.proy_id,
	                                                     p.proy_cod,
	                                                     p.proy_nombre,
	                                                     p.proy_numActa,
	                                                     p.proy_fechaAprobacion,
	                                                     p.proy_numViviendas,
	                                                     p.total_finan_pvs_cons,
                                                         p.proy_subprograma

	                                                    FROM proyecto p, ubicacion u
	                                                    where p.proy_id=u.id_proyecto
	                                                    and p.proy_subprograma='$row1[0]'
	                                                    and u.ubi_departamento='$dep[$i]'
                                                        and p.proy_situacion='$estado'
	                                                    ORDER BY (p.proy_cod)";
                                                    }
                                                    else
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
                                                    }

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

                                                                $monto_desembolso1=number_format($monto_desembolso,2,",",".");
                                                                $saldo_proyecto1=number_format($saldo_proyecto,2,",",".");
										                        $compr=number_format($row2[6],2,",",".");
										   ?>
	                                                <tr>
                                                        <td width="2%"><?echo"$cont_d_proy";?></td>
	                                                    <td width="10%"><?echo"$row2[1]";?></td><!--CODIGO DE PROYECTO -->
	                                                    <td width="30%"><?echo"$row2[2]";?></td><!--NOMBRE DE PROYECTO -->
	                                                    <td width="3%">&nbsp;</td>
	                                                    <td width="10%" align="center"><?echo"$row2[3]";?></td><!--NUMERO DE ACTA -->
	                                                    <td width="7%" align="center"><?echo"$row2[4]";?></td> <!--FECHA DE APROBACION -->
	                                                    <td width="7%" align="center"><?echo"$row2[5]";?></td> <!--NUMERO DE VIVIENDA -->
	                                                    <td width="10%" align="right"><?echo"$compr";?></td>  <!--MONTO COMPROMETIDO -->
	                                                    <td width="10%" align="right"><?echo"$monto_desembolso1";?></td>
	                                                    <td width="10%" align="right"><?echo"$saldo_proyecto1";?></td>
	                                                  </tr>
													   <?
                                                             $monto_compro_de_proyecto=$monto_compro_de_proyecto+$row2[6]; //nomto comprometido por proyecto
                                                    		 $monto_desem_de_proyecto=$monto_desem_de_proyecto+$monto_desembolso; //nomto desembolsado por proyecto
                                                             $n_viv=$n_viv+$row2[5];
                                                             }
                                                             $saldo_subpr=$monto_compro_de_proyecto-$monto_desem_de_proyecto;

                                                             $monto_compro_de_proyecto1=number_format($monto_compro_de_proyecto,2,",",".");
                                                             $monto_desem_de_proyecto1=number_format($monto_desem_de_proyecto,2,",",".");
                                                             $saldo_subpr1=number_format($saldo_subpr,2,",",".");

	                                                    //mysql_free_result($resu);
                                                       $sp[$j]='';
                                                       ?>


	                                                </table>
	                                            </td>
	                                      </tr>

                                          <tr>
                                          	<td><hr width="100%" size="1" style="color:black" /></td>
                                          </tr>

                                          <tr>
                                    	    <td><table width="100%" border="0" cellspacing="1" cellpadding="1">
	                                          <tr align="right">
	                                            <td width="30%">&nbsp;</td>
	                                            <td width="30%"><b>SUBTOTAL DEL SUBPROGRAMA EN Bs: </td>
	                                            <td width="10%"><b>Nro Viv.<?echo"$n_viv";?></td>
	                                            <td width="10%"><b><?echo"$monto_compro_de_proyecto1";?></td>
	                                            <td width="10%"><b><?echo"$monto_desem_de_proyecto1";?></td>
	                                            <td width="10%"><b><?echo"$saldo_subpr1";?></td>
	                                          </tr>
	                                        </table></td>
	                                      </tr>
                                       <?
                                                       	$n_viv_depto=$n_viv_depto+$n_viv;
                                                		$monto_compr_depto=$monto_compr_depto+$monto_compro_de_proyecto;
                                                		$monto_desem_depto=$monto_desem_depto+$monto_desem_de_proyecto;
                                                      }
                                                      $saldo_depto=$monto_compr_depto-$monto_desem_depto;

                                                      $monto_compr_depto1=number_format($monto_compr_depto,2,",",".");
                                                      $monto_desem_depto1=number_format($monto_desem_depto,2,",",".");
                                                      $saldo_depto1=number_format($saldo_depto,2,",",".");
                                       ?>

                                  <tr>
                                  <td><hr width="100%" size="1" style="color:black" /></td>
                                  </tr>
                                  <tr>
	                                <td><table width="100%" border="0" cellspacing="1" cellpadding="1">
	                                  <tr align="right">
	                                  	<td width="30%">&nbsp;</td>
	                                     <td width="30%"><b>SUBTOTAL DEL DEPARTAMENTO EN Bs: </td>
                                         <td width="10%"><b>Nº Viv.<?echo"$n_viv_depto";?></td>
                                         <td width="10%"><b><?echo"$monto_compr_depto1";?></td>
	                                     <td width="10%"><b><?echo"$monto_desem_depto1";?></td>
	                                     <td width="10%"><b><?echo"$saldo_depto1";?></td>
	                                   </tr>
	                                </table></td>
	                              </tr>

                                  <?
                                     $n_viv_nacional=$n_viv_nacional+$n_viv_depto;
                                     $monto_compr_nacional=$monto_compr_nacional+$monto_compr_depto;
                                     $monto_desem_nacional=$monto_desem_nacional+$monto_desem_depto;
                                     }  // fin de for
                                     $saldo_nacional=$monto_compr_nacional-$monto_desem_nacional;

                                     $monto_compr_nacional1=number_format($monto_compr_nacional,2,",",".");
                                     $monto_desem_nacional1=number_format($monto_desem_nacional,2,",",".");
                                     $saldo_nacional1=number_format($saldo_nacional,2,",",".");

                                 ?>
                                 <tr>
                                  <td><hr width="100%" size="1" style="color:black" /></td>
                                  </tr>
                                  <tr>
                                     <td><table width="100%" border="0" cellspacing="1" cellpadding="1">
                                       <tr align="right">
                                         <td width="30%">&nbsp;</td>
                                         <td width="30%"><b>TOTAL NACIONAL EN Bs: </td>
                                         <td width="10%"><b>N Viv.<?echo"$n_viv_nacional";?></td>
                                         <td width="10%"><b><?echo"$monto_compr_nacional1";?></td>
                                         <td width="10%"><b><?echo"$monto_desem_nacional1";?></td>
                                         <td width="10%"><b><?echo"$saldo_nacional1";?></td>
                                      </tr>
                                    </table></td>
                                  </tr>
                                    <?

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
											?>
                                          <tr class="estilo1">
	                               				<td width="100%" ><b><?echo"$row[$i]";?></td>
	                              		  </tr>
                                          <?
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
											?>
                                           <tr class="e">
	                                       		<td width="100%"><b><?echo"SUBPROGRAMA Nº $row1[0]";?></td>
	                                       </tr>

                                           <tr>
	                                        <td>
                                              <table width="100%" border="0" cellspacing="1" cellpadding="1">
                                              	<tr>
	                                                <td width="2%"><b>N&ordm;</td>
	                                                <td width="10%"><b>COD.PROY.</td>
	                                                <td width="30%"><b>NOMBRE DEL PROYECTO </td>
	                                                <td width="3%"><b>&nbsp;</td>
	                                                <td width="10%" align="center"><b>ACTA</td>
	                                                <td width="7%" align="center"><b>FECH. APR. </td>
	                                                <td width="7%" align="center"><b>N&ordm; VIV. </td>
	                                                <td width="10%" align="right"><b>COMPROMETIDO</td>
	                                                <td width="10%" align="right"><b>DESEMBOLSO</td>
	                                                <td width="10%" align="right"><b>SALDO X DESEM.</td>
	                                              </tr>
	                                          </table>
                                            </td>
	                                      </tr>

                                          <tr>
                                          	<td><hr width="100%" size="1" style="color:black" /></td>
                                          </tr>

                                           <tr>
                                            <td>
                                                <table width="100%" border="0" cellspacing="1" cellpadding="1">
                                           <?

                                           			if($row1[0]==1 || $row1[0]==4)
                                                    {
                                                       $que = "SELECT
                                                         p.proy_id,
	                                                     p.proy_cod,
	                                                     p.proy_nombre,
	                                                     p.proy_numActa,
	                                                     p.proy_fechaAprobacion,
	                                                     p.proy_numViviendas,
	                                                     p.total_finan_pvs_cons,
                                                         p.proy_subprograma

	                                                    FROM proyecto p, ubicacion u
	                                                    where p.proy_id=u.id_proyecto
	                                                    and p.proy_subprograma='$row1[0]'
	                                                    and u.ubi_departamento='$row[$i]'
	                                                    ORDER BY (p.proy_cod)";
                                                    }
                                                    else
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
                                                    }

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

                                                                $monto_desembolso1=number_format($monto_desembolso,2,",",".");
                                                                $saldo_proyecto1=number_format($saldo_proyecto,2,",",".");
										                        $compr=number_format($row2[6],2,",",".");
										   ?>
	                                                <tr>
                                                        <td width="2%"><?echo"$cont_d_proy";?></td>
	                                                    <td width="10%"><?echo"$row2[1]";?></td><!--CODIGO DE PROYECTO -->
	                                                    <td width="30%"><?echo"$row2[2]";?></td><!--NOMBRE DE PROYECTO -->
	                                                    <td width="3%">&nbsp;</td>
	                                                    <td width="10%" align="center"><?echo"$row2[3]";?></td><!--NUMERO DE ACTA -->
	                                                    <td width="7%" align="center"><?echo"$row2[4]";?></td> <!--FECHA DE APROBACION -->
	                                                    <td width="7%" align="center"><?echo"$row2[5]";?></td> <!--NUMERO DE VIVIENDA -->
	                                                    <td width="10%" align="right"><?echo"$compr";?></td>  <!--MONTO COMPROMETIDO -->
	                                                    <td width="10%" align="right"><?echo"$monto_desembolso1";?></td>
	                                                    <td width="10%" align="right"><?echo"$saldo_proyecto1";?></td>
	                                                  </tr>
													   <?
                                                             $monto_compro_de_proyecto=$monto_compro_de_proyecto+$row2[6]; //nomto comprometido por proyecto
                                                    		 $monto_desem_de_proyecto=$monto_desem_de_proyecto+$monto_desembolso; //nomto desembolsado por proyecto
                                                             $n_viv=$n_viv+$row2[5];
                                                             }
                                                             $saldo_subpr=$monto_compro_de_proyecto-$monto_desem_de_proyecto;

                                                             $monto_compro_de_proyecto1=number_format($monto_compro_de_proyecto,2,",",".");
                                                             $monto_desem_de_proyecto1=number_format($monto_desem_de_proyecto,2,",",".");
                                                             $saldo_subpr1=number_format($saldo_subpr,2,",",".");
	                                                    //mysql_free_result($resu);
                                                       $sp[$j]='';
                                                       ?>
	                                                </table>
	                                            </td>
	                                      </tr>

                                          <tr>
                                          	<td><hr width="100%" size="1" style="color:black" /></td>
                                          </tr>

                                          <tr>
                                    	    <td><table width="100%" border="0" cellspacing="1" cellpadding="1">
	                                          <tr align="right">
	                                            <td width="30%">&nbsp;</td>
	                                            <td width="30%"><b>SUBTOTAL DEL SUBPROGRAMA EN Bs: </td>
	                                            <td width="10%"><b>Nro Viv.<?echo"$n_viv";?></td>
	                                            <td width="10%"><b><?echo"$monto_compro_de_proyecto1";?></td>
	                                            <td width="10%"><b><?echo"$monto_desem_de_proyecto1";?></td>
	                                            <td width="10%"><b><?echo"$saldo_subpr1";?></td>
	                                          </tr>
	                                        </table></td>
	                                      </tr>
                                       <?
                                                       	$n_viv_depto=$n_viv_depto+$n_viv;
                                                		$monto_compr_depto=$monto_compr_depto+$monto_compro_de_proyecto;
                                                		$monto_desem_depto=$monto_desem_depto+$monto_desem_de_proyecto;
                                                      }
                                                      $saldo_depto=$monto_compr_depto-$monto_desem_depto;

                                                      $monto_compr_depto1=number_format($monto_compr_depto,2,",",".");
                                                      $monto_desem_depto1=number_format($monto_desem_depto,2,",",".");
                                                      $saldo_depto1=number_format($saldo_depto,2,",",".");


                                       if($row[$i]!=''){
                                       ?>
                                  <tr>
                                  <td><hr width="100%" size="1" style="color:black" /></td>
                                  </tr>
                                  <tr>
	                                <td><table width="100%" border="0" cellspacing="1" cellpadding="1">
	                                  <tr align="right">
	                                  	<td width="30%">&nbsp;</td>
	                                     <td width="30%"><b>SUBTOTAL DEL DEPARTAMENTO EN Bs: </td>
                                         <td width="10%"><b>Nº Viv.<?echo"$n_viv_depto";?></td>
                                         <td width="10%"><b><?echo"$monto_compr_depto1";?></td>
	                                     <td width="10%"><b><?echo"$monto_desem_depto1";?></td>
	                                     <td width="10%"><b><?echo"$saldo_depto1";?></td>
	                                   </tr>
	                                </table></td>
	                              </tr>

                                  <? 	}
                                     $n_viv_nacional=$n_viv_nacional+$n_viv_depto;
                                     $monto_compr_nacional=$monto_compr_nacional+$monto_compr_depto;
                                     $monto_desem_nacional=$monto_desem_nacional+$monto_desem_depto;
                                     }  // fin de for
                                     $saldo_nacional=$monto_compr_nacional-$monto_desem_nacional;

                                 ?>
                                 <!--
                                  <tr>
                                     <td><table width="100%" border="1" cellspacing="1" cellpadding="1">
                                       <tr align="right">
                                         <td width="30%">&nbsp;</td>
                                         <td width="30%">TOTAL NACIONAL EN Bs: </td>
                                         <td width="10%">N Viv.<?echo"$n_viv_nacional";?></td>
                                         <td width="10%"><?echo"$monto_compr_nacional";?></td>
                                         <td width="10%"><?echo"$monto_desem_nacional";?></td>
                                         <td width="10%"><?echo"$saldo_nacional";?></td>
                                      </tr>
                                    </table></td>
                                  </tr>-->
                                    <?
	                                 } //fin de if de estado=todos
                                    else
                                    {
                                        $n_viv_nacional=0;
                                     	$monto_compr_nacional=0;
                                     	$monto_desem_nacional=0;

                                    	for($i=0;$i<count($row);$i++)
	                                       {
											?>
                                          <tr class="estilo1">
	                               				<td width="100%" ><b><?echo"$row[$i]";?></td>
	                              		  </tr>
                                          <?
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
											?>
                                           <tr class="e">
	                                       		<td width="100%"><b><?echo"SUBPROGRAMA Nº $row1[0]";?></td>
	                                       </tr>

                                           <tr>
	                                        <td>
                                              <table width="100%" border="0" cellspacing="1" cellpadding="1">
                                              	<tr>
	                                                <td width="2%"><b>N&ordm;</td>
	                                                <td width="10%"><b>COD.PROY.</td>
	                                                <td width="30%"><b>NOMBRE DEL PROYECTO </td>
	                                                <td width="3%"><b>&nbsp;</td>
	                                                <td width="10%" align="center"><b>ACTA</td>
	                                                <td width="7%" align="center"><b>FECH. APR. </td>
	                                                <td width="7%" align="center"><b>N&ordm; VIV. </td>
	                                                <td width="10%" align="right"><b>COMPROMETIDO</td>
	                                                <td width="10%" align="right"><b>DESEMBOLSO</td>
	                                                <td width="10%" align="right"><b>SALDO X DESEM.</td>
	                                              </tr>
	                                          </table>
                                            </td>
	                                      </tr>

                                          <tr>
                                          	<td><hr width="100%" size="1" style="color:black" /></td>
                                          </tr>

                                           <tr>
                                            <td>
                                                <table width="100%" border="0" cellspacing="1" cellpadding="1">
                                           <?

                                           			if($row1[0]==1 || $row1[0]==4)
                                                    {
                                                       $que = "SELECT
                                                         p.proy_id,
	                                                     p.proy_cod,
	                                                     p.proy_nombre,
	                                                     p.proy_numActa,
	                                                     p.proy_fechaAprobacion,
	                                                     p.proy_numViviendas,
	                                                     p.total_finan_pvs_cons,
                                                         p.proy_subprograma

	                                                    FROM proyecto p, ubicacion u
	                                                    where p.proy_id=u.id_proyecto
	                                                    and p.proy_subprograma='$row1[0]'
	                                                    and u.ubi_departamento='$row[$i]'
                                                        and p.proy_situacion='$estado'
	                                                    ORDER BY (p.proy_cod)";
                                                    }
                                                    else
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
                                                    }

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

                                                                $monto_desembolso1=number_format($monto_desembolso,2,",",".");
                                                                $saldo_proyecto1=number_format($saldo_proyecto,2,",",".");
										                        $compr=number_format($row2[6],2,",",".");
										   ?>
	                                                <tr>
                                                        <td width="2%"><?echo"$cont_d_proy";?></td>
	                                                    <td width="10%"><?echo"$row2[1]";?></td><!--CODIGO DE PROYECTO -->
	                                                    <td width="30%"><?echo"$row2[2]";?></td><!--NOMBRE DE PROYECTO -->
	                                                    <td width="3%">&nbsp;</td>
	                                                    <td width="10%" align="center"><?echo"$row2[3]";?></td><!--NUMERO DE ACTA -->
	                                                    <td width="7%" align="center"><?echo"$row2[4]";?></td> <!--FECHA DE APROBACION -->
	                                                    <td width="7%" align="center"><?echo"$row2[5]";?></td> <!--NUMERO DE VIVIENDA -->
	                                                    <td width="10%" align="right"><?echo"$compr";?></td>  <!--MONTO COMPROMETIDO -->
	                                                    <td width="10%" align="right"><?echo"$monto_desembolso1";?></td>
	                                                    <td width="10%" align="right"><?echo"$saldo_proyecto1";?></td>
	                                                  </tr>
													   <?
                                                             $monto_compro_de_proyecto=$monto_compro_de_proyecto+$row2[6]; //nomto comprometido por proyecto
                                                    		 $monto_desem_de_proyecto=$monto_desem_de_proyecto+$monto_desembolso; //nomto desembolsado por proyecto
                                                             $n_viv=$n_viv+$row2[5];
                                                             }
                                                             $saldo_subpr=$monto_compro_de_proyecto-$monto_desem_de_proyecto;

                                                             $monto_compro_de_proyecto1=number_format($monto_compro_de_proyecto,2,",",".");
                                                             $monto_desem_de_proyecto1=number_format($monto_desem_de_proyecto,2,",",".");
                                                             $saldo_subpr1=number_format($saldo_subpr,2,",",".");
	                                                    //mysql_free_result($resu);
                                                       $sp[$j]='';
                                                       ?>
	                                                </table>
	                                            </td>
	                                      </tr>

                                          <tr>
                                          	<td><hr width="100%" size="1" style="color:black" /></td>
                                          </tr>

                                          <tr>
                                    	    <td><table width="100%" border="0" cellspacing="1" cellpadding="1">
	                                          <tr align="right">
	                                            <td width="30%">&nbsp;</td>
	                                            <td width="30%"><b>SUBTOTAL DEL SUBPROGRAMA EN Bs: </td>
	                                            <td width="10%"><b>Nro Viv.<?echo"$n_viv";?></td>
	                                            <td width="10%"><b><?echo"$monto_compro_de_proyecto1";?></td>
	                                            <td width="10%"><b><?echo"$monto_desem_de_proyecto1";?></td>
	                                            <td width="10%"><b><?echo"$saldo_subpr1";?></td>
	                                          </tr>
	                                        </table></td>
	                                      </tr>
                                       <?
                                                       	$n_viv_depto=$n_viv_depto+$n_viv;
                                                		$monto_compr_depto=$monto_compr_depto+$monto_compro_de_proyecto;
                                                		$monto_desem_depto=$monto_desem_depto+$monto_desem_de_proyecto;
                                                      }
                                                      $saldo_depto=$monto_compr_depto-$monto_desem_depto;

                                                      $monto_compr_depto1=number_format($monto_compr_depto,2,",",".");
                                                      $monto_desem_depto1=number_format($monto_desem_depto,2,",",".");
                                                      $saldo_depto1=number_format($saldo_depto,2,",",".");
                                   if($row[$i]!=''){
                                       ?>
                                  <tr>
                                  <td><hr width="100%" size="1" style="color:black" /></td>
                                  </tr>

                                  <tr>
	                                <td><table width="100%" border="0" cellspacing="1" cellpadding="1">
	                                  <tr align="right">
	                                  	<td width="30%">&nbsp;</td>
	                                     <td width="30%"><b>SUBTOTAL DEL DEPARTAMENTO EN Bs: </td>
                                         <td width="10%"><b>Nº Viv.<?echo"$n_viv_depto";?></td>
                                         <td width="10%"><b><?echo"$monto_compr_depto1";?></td>
	                                     <td width="10%"><b><?echo"$monto_desem_depto1";?></td>
	                                     <td width="10%"><b><?echo"$saldo_depto1";?></td>
	                                   </tr>
	                                </table></td>
	                              </tr>
                                  <?
                                  		}
                                     $n_viv_nacional=$n_viv_nacional+$n_viv_depto;
                                     $monto_compr_nacional=$monto_compr_nacional+$monto_compr_depto;
                                     $monto_desem_nacional=$monto_desem_nacional+$monto_desem_depto;
                                     }  // fin de for
                                     $saldo_nacional=$monto_compr_nacional-$monto_desem_nacional;

                                 ?>
                                 <!--
                                  <tr>
                                     <td><table width="100%" border="1" cellspacing="1" cellpadding="1">
                                       <tr align="right">
                                         <td width="30%">&nbsp;</td>
                                         <td width="30%">TOTAL NACIONAL EN Bs: </td>
                                         <td width="10%">N Viv.<?echo"$n_viv_nacional";?></td>
                                         <td width="10%"><?echo"$monto_compr_nacional";?></td>
                                         <td width="10%"><?echo"$monto_desem_nacional";?></td>
                                         <td width="10%"><?echo"$saldo_nacional";?></td>
                                      </tr>
                                    </table></td>
                                  </tr>-->
                                    <?

                                    }//fin de else de estado=1
                                 }
							?>
	                		</table>

                    <?
	            break;
                }
                case 3:
                {
                    ?>
                               <table width="" border="0" align="center">
	                             <form action="pdf_rep_depto2.php"  method="POST" target="_blank">
	                                 <tr align="center">
	                                    <th><img src="imagenes2/PDF.jpg" width="23" height="23" /></th>
	                                  </tr>
	                                  <tr align="center">
	                                    <td>
	                                        <input type="hidden" name="campo1" value="<?=$formato;?>">
	                                        <input type="hidden" name="campo2" value="<?=$depto;?>">
	                                        <input type="hidden" name="campo3" value="<?=$estado;?>">
	                                        <input align="center" type="submit" class="n" value="I M P R I M I R" >
	                                    </td>
	                                  </tr>
	                                </form>
	                            </table>

                                <table border="1" align="center" >
	                                    <tr >
	                                        <td><b>Departamento de:</b> <?  echo"$depto"; ?></td>
	                                        <td><b>Estado de Proyecto:</b> <?  echo"$estado"; ?></td>
	                                        <td><b>tipo de Reporte:</b> <?  echo"$descrip"; ?></td>
	                                    </tr>
	                            </table>

                               <table width="100%" border="0" cellspacing="1" cellpadding="1">

                                  <?
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
											?>
                                          <tr class="estilo1">
	                               				<td width="100%" ><b><?echo"$dep[$i]";?></td>
	                              		  </tr>

                                          <tr>
	                                        <td>
                                              <table width="100%" border="0" cellspacing="1" cellpadding="1">
                                              	<tr>
	                                                <td width="30%" align="right"><b>SUBPROGRAMA </td>
	                                                <td width="10%" align="center"><b>N&ordm; VIV. </td>
	                                                <td width="10%" align="right"><b>COMPROMETIDO</td>
	                                                <td width="10%" align="right"><b>DESEMBOLSO</td>
	                                                <td width="10%" align="right"><b>SALDO X DESEM.</td>
	                                              </tr>
	                                          </table>
                                            </td>
	                                      </tr>

                                          <tr>
                                  			<td><hr width="100%" size="1" style="color:black" /></td>
                                  		  </tr>
                                          <?
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
											?>
                                           <tr>
                                            <td>
                                                <table width="100%" border="0" cellspacing="1" cellpadding="1">
                                           <?

                                                    if($row1[0]==1 || $row1[0]==4)
                                                    {
                                                       $que = "SELECT
                                                         p.proy_id,
	                                                     p.proy_cod,
	                                                     p.proy_nombre,
	                                                     p.proy_numActa,
	                                                     p.proy_fechaAprobacion,
	                                                     p.proy_numViviendas,
	                                                     p.total_finan_pvs_cons,
                                                         p.proy_subprograma

	                                                    FROM proyecto p, ubicacion u
	                                                    where p.proy_id=u.id_proyecto
	                                                    and p.proy_subprograma='$row1[0]'
	                                                    and u.ubi_departamento='$dep[$i]'
	                                                    ORDER BY (p.proy_cod)";
                                                    }
                                                    else
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
                                                    }
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
                                                       ?>
	                                                </table>
	                                            </td>
	                                      </tr>

                                          <tr>
                                    	    <td><table width="100%" border="0" cellspacing="1" cellpadding="1">
	                                          <tr>
	                                            <td width="30%" align="right"><?echo"SUBPROGRAMA Nº $row1[0]";?></td>
	                                            <td width="10%" align="center"><?echo"$n_viv";?></td>
	                                            <td width="10%" align="right"><?echo"$monto_compro_de_proyecto";?></td>
	                                            <td width="10%" align="right"><?echo"$monto_desem_de_proyecto";?></td>
	                                            <td width="10%" align="right"><?echo"$saldo_subpr";?></td>
	                                          </tr>
	                                        </table></td>
	                                      </tr>
                                       <?
                                                       	$n_viv_depto=$n_viv_depto+$n_viv;
                                                		$monto_compr_depto=$monto_compr_depto+$monto_compro_de_proyecto;
                                                		$monto_desem_depto=$monto_desem_depto+$monto_desem_de_proyecto;
                                                      }
                                                      $saldo_depto=$monto_compr_depto-$monto_desem_depto;
                                       ?>

                                  <tr>
                                  <td><hr width="100%" size="1" style="color:black" /></td>
                                  </tr>

                                  <tr>
	                                <td><table width="100%" border="0" cellspacing="1" cellpadding="1">
	                                  <tr align="right" class="estilo5">
	                                     <td width="30%">SUBTOTAL DEL DEPARTAMENTO EN Bs: </td>
                                         <td width="10%" align="center"><?echo"$n_viv_depto";?></td>
                                         <td width="10%"><?echo"$monto_compr_depto";?></td>
	                                     <td width="10%"><?echo"$monto_desem_depto";?></td>
	                                     <td width="10%"><?echo"$saldo_depto";?></td>
	                                   </tr>
	                                </table></td>
	                              </tr>

                                  <?
                                     $n_viv_nacional=$n_viv_nacional+$n_viv_depto;
                                     $monto_compr_nacional=$monto_compr_nacional+$monto_compr_depto;
                                     $monto_desem_nacional=$monto_desem_nacional+$monto_desem_depto;
                                     }  // fin de for
                                     $saldo_nacional=$monto_compr_nacional-$monto_desem_nacional;

                                 ?>
                                  <tr>
                                     <td><table width="100%" border="0" cellspacing="1" cellpadding="1">
                                       <tr align="right">
                                         <td width="30%">TOTAL NACIONAL EN Bs: </td>
                                         <td width="10%" align="center"><?echo"$n_viv_nacional";?></td>
                                         <td width="10%"><?echo"$monto_compr_nacional";?></td>
                                         <td width="10%"><?echo"$monto_desem_nacional";?></td>
                                         <td width="10%"><?echo"$saldo_nacional";?></td>
                                      </tr>
                                    </table></td>
                                  </tr>
                                    <?
	                                 } //fin de if de estado=todos
                                    else
                                    {
                                        $n_viv_nacional=0;
                                     	$monto_compr_nacional=0;
                                     	$monto_desem_nacional=0;

                                    	for($i=0;$i<count($dep);$i++)
	                                       {
											?>
                                          <tr class="estilo1">
	                               				<td width="100%" ><b><?echo"$dep[$i]";?></td>
	                              		  </tr>

                                          <tr>
	                                        <td>
                                              <table width="100%" border="0" cellspacing="1" cellpadding="1">
                                              	<tr>
	                                                <td width="30%" align="right"><b>SUBPROGRAMA </td>
	                                                <td width="10%" align="center"><b>N&ordm; VIV. </td>
	                                                <td width="10%" align="right"><b>COMPROMETIDO</td>
	                                                <td width="10%" align="right"><b>DESEMBOLSO</td>
	                                                <td width="10%" align="right"><b>SALDO X DESEM.</td>
	                                              </tr>
	                                          </table>
                                            </td>
	                                      </tr>

                                          <tr>
                                  			<td><hr width="100%" size="1" style="color:black" /></td>
                                  		  </tr>

                                          <?
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
											?>
                                           <tr>
                                            <td>
                                                <table width="100%" border="1" cellspacing="1" cellpadding="1">
                                           <?

                                           			if($row1[0]==1 || $row1[0]==4)
                                                    {
                                                       $que = "SELECT
                                                         p.proy_id,
	                                                     p.proy_cod,
	                                                     p.proy_nombre,
	                                                     p.proy_numActa,
	                                                     p.proy_fechaAprobacion,
	                                                     p.proy_numViviendas,
	                                                     p.total_finan_pvs_cons,
                                                         p.proy_subprograma

	                                                    FROM proyecto p, ubicacion u
	                                                    where p.proy_id=u.id_proyecto
	                                                    and p.proy_subprograma='$row1[0]'
	                                                    and u.ubi_departamento='$dep[$i]'
                                                        and p.proy_situacion='$estado'
	                                                    ORDER BY (p.proy_cod)";
                                                    }
                                                    else
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
                                                    }

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
                                                       ?>
	                                                </table>
	                                            </td>
	                                      </tr>

                                          <tr>
                                    	    <td><table width="100%" border="1" cellspacing="1" cellpadding="1">
	                                          <tr align="right">
	                                            <td width="30%"><?echo"SUBPROGRAMA Nº $row1[0]";?></td>
	                                            <td width="10%"><?echo"$n_viv";?></td>
	                                            <td width="10%"><?echo"$monto_compro_de_proyecto";?></td>
	                                            <td width="10%"><?echo"$monto_desem_de_proyecto";?></td>
	                                            <td width="10%"><?echo"$saldo_subpr";?></td>
	                                          </tr>
	                                        </table></td>
	                                      </tr>
                                       <?
                                                       	$n_viv_depto=$n_viv_depto+$n_viv;
                                                		$monto_compr_depto=$monto_compr_depto+$monto_compro_de_proyecto;
                                                		$monto_desem_depto=$monto_desem_depto+$monto_desem_de_proyecto;
                                                      }
                                                      $saldo_depto=$monto_compr_depto-$monto_desem_depto;
                                       ?>

                                  <tr>
	                                <td><table width="100%" border="1" cellspacing="1" cellpadding="1">
	                                  <tr align="right" class="estilo5">
	                                     <td width="30%">SUBTOTAL DEL DEPARTAMENTO EN Bs: </td>
                                         <td width="10%"><?echo"$n_viv_depto";?></td>
                                         <td width="10%"><?echo"$monto_compr_depto";?></td>
	                                     <td width="10%"><?echo"$monto_desem_depto";?></td>
	                                     <td width="10%"><?echo"$saldo_depto";?></td>
	                                   </tr>
	                                </table></td>
	                              </tr>

                                  <?
                                     $n_viv_nacional=$n_viv_nacional+$n_viv_depto;
                                     $monto_compr_nacional=$monto_compr_nacional+$monto_compr_depto;
                                     $monto_desem_nacional=$monto_desem_nacional+$monto_desem_depto;
                                     }  // fin de for
                                     $saldo_nacional=$monto_compr_nacional-$monto_desem_nacional;

                                 ?>
                                 <tr>
                                     <td><table width="100%" border="1" cellspacing="1" cellpadding="1">
                                       <tr align="right">
                                         <td width="30%">TOTAL NACIONAL EN Bs: </td>
                                         <td width="10%"><?echo"$n_viv_nacional";?></td>
                                         <td width="10%"><?echo"$monto_compr_nacional";?></td>
                                         <td width="10%"><?echo"$monto_desem_nacional";?></td>
                                         <td width="10%"><?echo"$saldo_nacional";?></td>
                                      </tr>
                                    </table></td>
                                  </tr>
                                    <?
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
											?>
                                          <tr class="estilo1">
	                               				<td width="100%" ><b><?echo"$row[$i]";?></td>
	                              		  </tr>

                                          <tr>
	                                        <td>
                                              <table width="100%" border="0" cellspacing="1" cellpadding="1">
                                              	<tr>
	                                                <td width="30%" align="right"><b>SUBPROGRAMA </td>
	                                                <td width="10%" align="center"><b>N&ordm; VIV. </td>
	                                                <td width="10%" align="right"><b>COMPROMETIDO</td>
	                                                <td width="10%" align="right"><b>DESEMBOLSO</td>
	                                                <td width="10%" align="right"><b>SALDO X DESEM.</td>
	                                              </tr>
	                                          </table>
                                            </td>
	                                      </tr>

                                          <tr>
                                  			<td><hr width="100%" size="1" style="color:black" /></td>
                                  		  </tr>

                                          <?
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
											?>
                                           <tr>
                                            <td>
                                                <table width="100%" border="1" cellspacing="1" cellpadding="1">
                                           <?
                                                  if($row1[0]==1 || $row1[0]==4)
                                                    {
                                                       $que = "SELECT
                                                         p.proy_id,
	                                                     p.proy_cod,
	                                                     p.proy_nombre,
	                                                     p.proy_numActa,
	                                                     p.proy_fechaAprobacion,
	                                                     p.proy_numViviendas,
	                                                     p.total_finan_pvs_cons,
                                                         p.proy_subprograma

	                                                    FROM proyecto p, ubicacion u
	                                                    where p.proy_id=u.id_proyecto
	                                                    and p.proy_subprograma='$row1[0]'
	                                                    and u.ubi_departamento='$row[$i]'
	                                                    ORDER BY (p.proy_cod)";
                                                    }
                                                    else
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
                                                    }

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
                                                       ?>
	                                                </table>
	                                            </td>
	                                      </tr>

                                          <tr>
                                    	    <td><table width="100%" border="1" cellspacing="1" cellpadding="1">
	                                          <tr align="right">
	                                            <td width="30%"><?echo"SUBPROGRAMA Nº $row1[0]";?></td>
	                                            <td width="10%"><?echo"$n_viv";?></td>
	                                            <td width="10%"><?echo"$monto_compro_de_proyecto";?></td>
	                                            <td width="10%"><?echo"$monto_desem_de_proyecto";?></td>
	                                            <td width="10%"><?echo"$saldo_subpr";?></td>
	                                          </tr>
	                                        </table></td>
	                                      </tr>
                                       <?
                                                       	$n_viv_depto=$n_viv_depto+$n_viv;
                                                		$monto_compr_depto=$monto_compr_depto+$monto_compro_de_proyecto;
                                                		$monto_desem_depto=$monto_desem_depto+$monto_desem_de_proyecto;
                                                      }
                                                      $saldo_depto=$monto_compr_depto-$monto_desem_depto;

                                       if($row[$i]!=''){
                                       ?>
                                 <tr>
	                                <td><table width="100%" border="1" cellspacing="1" cellpadding="1">
	                                  <tr align="right" class="estilo5">
	                                     <td width="30%">SUBTOTAL DEL DEPARTAMENTO EN Bs: </td>
                                         <td width="10%"><?echo"$n_viv_depto";?></td>
                                         <td width="10%"><?echo"$monto_compr_depto";?></td>
	                                     <td width="10%"><?echo"$monto_desem_depto";?></td>
	                                     <td width="10%"><?echo"$saldo_depto";?></td>
	                                   </tr>
	                                </table></td>
	                              </tr>
                                  <? 	}
                                     $n_viv_nacional=$n_viv_nacional+$n_viv_depto;
                                     $monto_compr_nacional=$monto_compr_nacional+$monto_compr_depto;
                                     $monto_desem_nacional=$monto_desem_nacional+$monto_desem_depto;
                                     }  // fin de for
                                     $saldo_nacional=$monto_compr_nacional-$monto_desem_nacional;

                                 ?>
                                   <tr>
                                     <td><table width="100%" border="1" cellspacing="1" cellpadding="1">
                                       <tr align="right">
                                         <td width="30%">TOTAL NACIONAL EN Bs: </td>
                                         <td width="10%"><?echo"$n_viv_nacional";?></td>
                                         <td width="10%"><?echo"$monto_compr_nacional";?></td>
                                         <td width="10%"><?echo"$monto_desem_nacional";?></td>
                                         <td width="10%"><?echo"$saldo_nacional";?></td>
                                      </tr>
                                    </table></td>
                                  </tr>
                                    <?
	                                 } //fin de if de estado=todos
                                    else
                                    {
                                        $n_viv_nacional=0;
                                     	$monto_compr_nacional=0;
                                     	$monto_desem_nacional=0;

                                    	for($i=0;$i<count($row);$i++)
	                                       {
											?>
                                          <tr class="estilo1">
	                               				<td width="100%" ><b><?echo"$row[$i]";?></td>
	                              		  </tr>

                                          <tr>
	                                        <td>
                                              <table width="100%" border="0" cellspacing="1" cellpadding="1">
                                              	<tr>
	                                                <td width="30%" align="right"><b>SUBPROGRAMA </td>
	                                                <td width="10%" align="center"><b>N&ordm; VIV. </td>
	                                                <td width="10%" align="right"><b>COMPROMETIDO</td>
	                                                <td width="10%" align="right"><b>DESEMBOLSO</td>
	                                                <td width="10%" align="right"><b>SALDO X DESEM.</td>
	                                              </tr>
	                                          </table>
                                            </td>
	                                      </tr>

                                          <tr>
                                  			<td><hr width="100%" size="1" style="color:black" /></td>
                                  		  </tr>
                                          <?
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
											?>
                                           <tr>
                                            <td>
                                                <table width="100%" border="1" cellspacing="1" cellpadding="1">
                                           <?

                                                    if($row1[0]==1 || $row1[0]==4)
                                                    {
                                                       $que = "SELECT
                                                         p.proy_id,
	                                                     p.proy_cod,
	                                                     p.proy_nombre,
	                                                     p.proy_numActa,
	                                                     p.proy_fechaAprobacion,
	                                                     p.proy_numViviendas,
	                                                     p.total_finan_pvs_cons,
                                                         p.proy_subprograma

	                                                    FROM proyecto p, ubicacion u
	                                                    where p.proy_id=u.id_proyecto
	                                                    and p.proy_subprograma='$row1[0]'
	                                                    and u.ubi_departamento='$row[$i]'
                                                        and p.proy_situacion='$estado'
	                                                    ORDER BY (p.proy_cod)";
                                                    }
                                                    else
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
                                                    }

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
                                                       ?>
	                                                </table>
	                                            </td>
	                                      </tr>

                                          <tr>
                                    	    <td><table width="100%" border="1" cellspacing="1" cellpadding="1">
	                                          <tr align="right">
	                                            <td width="30%"><?echo"SUBPROGRAMA Nº $row1[0]";?></td>
	                                            <td width="10%"><?echo"$n_viv";?></td>
	                                            <td width="10%"><?echo"$monto_compro_de_proyecto";?></td>
	                                            <td width="10%"><?echo"$monto_desem_de_proyecto";?></td>
	                                            <td width="10%"><?echo"$saldo_subpr";?></td>
	                                          </tr>
	                                        </table></td>
	                                      </tr>
                                       <?
                                                       	$n_viv_depto=$n_viv_depto+$n_viv;
                                                		$monto_compr_depto=$monto_compr_depto+$monto_compro_de_proyecto;
                                                		$monto_desem_depto=$monto_desem_depto+$monto_desem_de_proyecto;
                                                      }
                                                      $saldo_depto=$monto_compr_depto-$monto_desem_depto;
                                   if($row[$i]!=''){
                                       ?>
                                  <tr>
	                                <td><table width="100%" border="1" cellspacing="1" cellpadding="1">
	                                  <tr align="right" class="estilo5">
	                                     <td width="30%">SUBTOTAL DEL DEPARTAMENTO EN Bs: </td>
                                         <td width="10%"><?echo"$n_viv_depto";?></td>
                                         <td width="10%"><?echo"$monto_compr_depto";?></td>
	                                     <td width="10%"><?echo"$monto_desem_depto";?></td>
	                                     <td width="10%"><?echo"$saldo_depto";?></td>
	                                   </tr>
	                                </table></td>
	                              </tr>
                                  <?
                                  		}
                                     $n_viv_nacional=$n_viv_nacional+$n_viv_depto;
                                     $monto_compr_nacional=$monto_compr_nacional+$monto_compr_depto;
                                     $monto_desem_nacional=$monto_desem_nacional+$monto_desem_depto;
                                     }  // fin de for
                                     $saldo_nacional=$monto_compr_nacional-$monto_desem_nacional;

                                 ?>
                                   <tr>
                                     <td><table width="100%" border="1" cellspacing="1" cellpadding="1">
                                       <tr align="right">
                                         <td width="30%">TOTAL NACIONAL EN Bs: </td>
                                         <td width="10%"><?echo"$n_viv_nacional";?></td>
                                         <td width="10%"><?echo"$monto_compr_nacional";?></td>
                                         <td width="10%"><?echo"$monto_desem_nacional";?></td>
                                         <td width="10%"><?echo"$saldo_nacional";?></td>
                                      </tr>
                                    </table></td>
                                  </tr>
                                    <?

                                    }//fin de else de estado=1
                                 }
							?>
	                		</table>

                    <?
	            break;
                }

        }      //FIN DE SWITCH
        ?>


</div>
</div>
</div>

<?php
desconectar($conexion);
?>

</body>
</html>
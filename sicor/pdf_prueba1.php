<?php

$html.= '
<table border="1">
<thead>
<tr>
<th>Data</th>
<td>Data</td>
<td>Data</td>
<td>Data<br />2nd line</td>
</tr>
</thead>
<tbody>
<tr>
<th>More Data</th>
<td>More Data</td>
<td>More Data</td>
<td>Data<br />2nd line</td>
</tr>
<tr>
<th>Data</th>
<td>Data</td>
<td>Data</td>
<td>Data<br />2nd line</td>
</tr>
<tr>
<th>Data</th>
<td>Data</td>
<td>Data</td>
<td>Data<br />2nd line</td>
</tr>
</tbody>
</table>
';

include("pdf4/mpdf.php");

$mpdf=new mPDF(); 

$mpdf->AddPage();
$mpdf->SetFooter('Encargado de Fideicomiso|{PAGENO} de {nb}|Copyright {DATE j-m-Y}');
$mpdf->WriteHTML($html);

$mpdf->Output();
exit;

?>
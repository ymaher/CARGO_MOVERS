<?php
include('class/class.ezpdf.php');

//Query
include('.../dbConnect.php');
$sql = "select * from transporter";
$res = mysql_query($sql);

$pdf = new Cezpdf();
$pdf->selectFont('class/fonts/Helvetica.afm');
$pdf->ezText('Master Cargo Movers',14);
$pdf->ezText('',12);
$j=0;
$i=0;
while( $row = mysql_fetch_array($res) ) 
{
	$data[] = $row;
}

$pdf->ezTable($data,"","Tansporters Details",array('width'=>550,'showHeadings' => 1,'shaded'=> 1));
$pdf->ezText('',12);
$pdf->ezText('© 2010,Master Cargo Movers Logistic Software by Techno Vertex',10);  
$pdf->ezStream();
exit;
?>		
<?php 
	include("dbconnection.php");
	

require_once('tcpdf_include.php');

$pdf = new TCPDF(PDF_PAGE_ORIENTATION, PDF_UNIT, PDF_PAGE_FORMAT, true, 'UTF-8', false);

$pdf->SetCreator(PDF_CREATOR);
$pdf->SetAuthor('All India NGO');
$pdf->SetTitle('NGO Report');
$pdf->SetSubject('TCPDF Tutorial');
$pdf->SetKeywords('TCPDF, PDF, example, test, guide');

$pdf->SetHeaderData(PDF_HEADER_LOGO, PDF_HEADER_LOGO_WIDTH, 'All India NGO`s','', array(0,64,255), array(0,64,128));
$pdf->setFooterData(array(0,64,0), array(0,64,128));

$pdf->setHeaderFont(Array(PDF_FONT_NAME_MAIN, '', PDF_FONT_SIZE_MAIN));
$pdf->setFooterFont(Array(PDF_FONT_NAME_DATA, '', PDF_FONT_SIZE_DATA));

$pdf->SetDefaultMonospacedFont(PDF_FONT_MONOSPACED);

$pdf->SetMargins(PDF_MARGIN_LEFT, PDF_MARGIN_TOP, PDF_MARGIN_RIGHT);
$pdf->SetHeaderMargin(PDF_MARGIN_HEADER);
$pdf->SetFooterMargin(PDF_MARGIN_FOOTER);

$pdf->SetAutoPageBreak(TRUE, PDF_MARGIN_BOTTOM);

$pdf->setImageScale(PDF_IMAGE_SCALE_RATIO);

// set some language-dependent strings (optional)
if (@file_exists(dirname(__FILE__).'/lang/eng.php')) {
	require_once(dirname(__FILE__).'/lang/eng.php');
	$pdf->setLanguageArray($l);
}

$pdf->setFontSubsetting(true);

$pdf->SetFont('dejavusans', '', 8, '', true);

$pdf->AddPage();

$pdf->setTextShadow(array('enabled'=>true, 'depth_w'=>0.2, 'depth_h'=>0.2, 'color'=>array(196,196,196), 'opacity'=>1, 'blend_mode'=>'Normal'));

$rs=$con->query("select * from ngo_table n, area a, city c,state s where a.areaid=n.areaid and a.cityid=c.cityid and s.stateid=c.stateid and a.cityid='".$_POST["cid"]."'");
$html="Date:".date("d-m-Y");
$html = $html.<<<EOD
<br>
<h3><b>Citywise NGO Report</b></h3>
<br>
<table border="1">
<tr>
 	<td style="border:1px solid black;padding:5px">NGO Name</td>
	<td style="border:1px solid black;padding:5px">Address</td>
	<td style="border:1px solid black;padding:5px">Area</td>
        <td style="border:1px solid black;padding:5px">City</td>
	<td style="border:1px solid black;padding:5px">State</td>
	<td style="border:1px solid black;padding:5px">Emailid</td>
	<td style="border:1px solid black;padding:5px">Website</td>
	<td style="border:1px solid black;padding:5px">Phone</td>
	<td style="border:1px solid black;padding:5px">Registration Date</td>
	</tr>
EOD;

//$html=$html."<table border='1'>";

while($rd=$rs->fetch())
{
$org=$rd["rdate"];
$html=$html."<tr><td>".$rd["NGOname"]."</td>";
$html=$html."<td>".$rd["address"]."</td>";
$html=$html."<td>".$rd["areaname"]."</td>";
$html=$html."<td>".$rd["cityname"]."</td>";
$html=$html."<td>".$rd["statename"]."</td>";
$html=$html."<td>".$rd["emailid"]."</td>";
$html=$html."<td>".$rd["website"]."</td>";
$html=$html."<td>".$rd["phone"]."</td>";
$html=$html."<td>".date("d-m-Y", strtotime($org))."</td></tr>";

}
$html=$html."</table>";



$pdf->writeHTMLCell(0, 0, '', '', $html, 0, 1, 0, true, '',true);

$pdf->Output('example_001.pdf', 'I');



?>


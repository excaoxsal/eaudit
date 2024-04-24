<?php
//============================================================+
// File name   : example_003.php
// Begin       : 2008-03-04
// Last Update : 2013-05-14
//
// Description : Example 003 for TCPDF class
//               Custom Header and Footer
//
// Author: Nicola Asuni
//
// (c) Copyright:
//               Nicola Asuni
//               Tecnick.com LTD
//               www.tecnick.com
//               info@tecnick.com
//============================================================+

/**
 * Creates an example PDF TEST document using TCPDF
 * @package com.tecnick.tcpdf
 * @abstract TCPDF - Example: Custom Header and Footer
 * @author Nicola Asuni
 * @since 2008-03-04
 */

// Extend the TCPDF class to create custom Header and Footer
class MYPDF extends TCPDF {

    //Page header
    public function Header() {
        // Logo
        $image_file = K_PATH_IMAGES.'logo-ipc-ss.png';
		$this->setJPEGQuality(100);
		$this->Image($image_file, 25, 15, 0, 25, 'PNG', '', 'T', true, 300, '', false, false, 0, false, false, false);
		// Set font
        $this->SetFont('helvetica', 'B', 20);
    }

    // Page footer
    public function Footer() {
        // Position at 15 mm from bottom
        $this->SetY(-15);
        // Set font
        $this->SetFont('helvetica', 'I', 8);
        // Page number
        $this->Cell(0, 10, 'Page '.$this->getAliasNumPage().'/'.$this->getAliasNbPages(), 0, false, 'C', 0, '', 0, false, 'T', 'M');
    }
}

// create new PDF document
$pdf = new MYPDF(PDF_PAGE_ORIENTATION, PDF_UNIT, PDF_PAGE_FORMAT, true, 'UTF-8', false);

// set document information
$pdf->SetCreator(PDF_CREATOR);
$pdf->SetAuthor('Nicola Asuni');
$pdf->SetTitle('TCPDF Example 003');
$pdf->SetSubject('TCPDF Tutorial');
$pdf->SetKeywords('TCPDF, PDF, example, test, guide');

// set default header data
$pdf->SetHeaderData(PDF_HEADER_LOGO, PDF_HEADER_LOGO_WIDTH, PDF_HEADER_TITLE, PDF_HEADER_STRING);

// set header and footer fonts
$pdf->setHeaderFont(Array(PDF_FONT_NAME_MAIN, '', PDF_FONT_SIZE_MAIN));
$pdf->setFooterFont(Array(PDF_FONT_NAME_DATA, '', PDF_FONT_SIZE_DATA));

// set default monospaced font
$pdf->SetDefaultMonospacedFont(PDF_FONT_MONOSPACED);

// set margins
$pdf->SetMargins(PDF_MARGIN_LEFT, PDF_MARGIN_TOP, PDF_MARGIN_RIGHT);
$pdf->SetHeaderMargin(PDF_MARGIN_HEADER);
$pdf->SetFooterMargin(PDF_MARGIN_FOOTER);

// set auto page breaks
$pdf->SetAutoPageBreak(TRUE, PDF_MARGIN_BOTTOM);

// set image scale factor
$pdf->setImageScale(PDF_IMAGE_SCALE_RATIO);

// set some language-dependent strings (optional)
if (@file_exists(dirname(__FILE__).'/lang/eng.php')) {
    require_once(dirname(__FILE__).'/lang/eng.php');
    $pdf->setLanguageArray($l);
}

// ---------------------------------------------------------

// set font
// $pdf->SetFont('times', 'BI', 12);
// $pdf->SetFont('times');
$pdf->SetFont('dejavusans', '', 12, '', true);

// add a page
$pdf->AddPage();

$FOTO_CV = ".jpg";
ob_start();
$html = '
<style>
h5{
	text-align: center;
	text-decoration: underline;
}
th {
	color: white;
	background-color: #60a9f7;
  }
</style>
<div class="title">
	<h5>BUKTI PEMINJAMAN/PENGEMBALIAN DOKUMEN</h5>
</div>
<br>
<table border="0" width="100%">
	<tr>
		<td width="65%"></td>
		<td>------------------------</td>
	</tr>
	<tr>
		<td width="65%"></td>
		<td>-------------------</td>
	</tr>
	<tr>
		<td width="65%"></td>
		<td style="font-size:13px">Kepada Yth.</td>
	</tr>
	<tr>
		<td width="65%"></td>
		<td>---------------------------------------</td>
	</tr>
	<tr>
		<td width="65%"></td>
		<td>-------</td>
	</tr>
	<tr>
		<td width="65%"></td>
		<td>---------------------------------------</td>
	</tr>
	<tr>
		<td width="65%"></td>
		<td>---------------------------------------</td>
	</tr>
	<tr>
		<td style="font-size:13px" width="65%">
			Dalam rangka audit internal yang sedang dilakukan, mohon
			dapat dipinjamkan dokumen berikut:
		</td>
		<td>----------*)</td>
	</tr>
</table>
<br>
<br>
<table border="1" width="100%">
	<thead>
		<tr style="text-align:center;">
			<th width="5%" rowspan="2">NO</th>
			<th width="25%" rowspan="2">NAMA DOKUMEN</th>
			<th width="25%" colspan="2">DITERIMA</th>
			<th width="25%" colspan="2">DIKEMBALIKAN</th>
			<th width="20%" rowspan="2">KETERANGAN</th>
		</tr>
		<tr style="text-align:center;">
			<th>TGL</th>
			<th>NAMA/PARAF</th>
			<th>TGL</th>
			<th>NAMA/PARAF</th>
		</tr>
	</thead>
	<tbody>
';
foreach ($lampiran as $key => $item) {
	$html .= '
	<tr>
		<td width="5%">'.($key+1).'</td>
		<td width="25%">'.$item['LAMPIRAN'].'</td>
		<td width="12.5%"></td>
		<td width="12.5%"></td>
		<td width="12.5%"></td>
		<td width="12.5%"></td>
		<td width="20%"></td>
	</tr> ';
}
$html .= '</tbody>
</table>
<br>
<div style="font-size:13px">
	Demikian kami sampaikan, atas perhatiannya kami ucapkan terima kasih
</div>
<br>
<table border="0" width="100%">
	<tr>
		<td width="80%"></td>
		<td style="font-size:13px">Ketua Tim,</td>
	</tr>
	<tr>
		<td width="75%"></td>
		<td style="font-size:13px">&nbsp;</td>
	</tr>
	<tr>
		<td width="75%"></td>
		<td style="font-size:13px">&nbsp;</td>
	</tr>
	<tr>
		<td width="75%"></td>
		<td style="font-size:13px">&nbsp;</td>
	</tr>
	<tr>
		<td width="75%"></td>
		<td style="font-size:13px">----------------------------------</td>
	</tr>
</table>
<br>
<br>
<br>
<div style="font-size:13px">
	*) Sesuai Divisi/Cabang/Unit Kerja yang diaudit
</div>';
// output the HTML content
// $pdf->writeHTML($html, true, false, true, false, '');
$pdf->writeHTMLCell($w='', $h='', $x=15, $y=37.5, $html, $border=0, $ln=1, $fill=0, $reseth=true, $align='', $autopadding=true);
// $pdf->SetMargins(100, 100, 100, true);

// ---------------------------------------------------------

//Close and output PDF document
ob_end_clean();
$pdf->Output('Audit Planning Memorandum.pdf', 'I');

//============================================================+
// END OF FILE
//============================================================+

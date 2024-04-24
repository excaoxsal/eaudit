<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
$pdf = new Pdf('P', 'mm', 'A4', true, 'UTF-8', false);

class MYPDF extends TCPDF {

    function __construct()
    {
        parent::__construct();
    }

    public function Header() {
        //$image_file = "http://ams.ptp.co.id/assets/img/logos/ptp.png";
        //$this->Image($image_file, 155, 10, 40, '', 'png', '', 'T', false, 300, '', false, false, 0, false, false, false);
        
        $bMargin = $this->getBreakMargin();
        // get current auto-page-break mode
        $auto_page_break = $this->AutoPageBreak;
        // disable auto-page-break
        $this->SetAutoPageBreak(false, 0);
        // restore auto-page-break status
        $this->SetAutoPageBreak($auto_page_break, $bMargin);
        // set the starting point for the page content
        $this->setPageMark();
    }

    // Page footer
    public function Footer() {
        // Position at 15 mm from bottom
        // $this->SetY(-15);
        // // Set font
        // $this->SetFont('helvetica', 'I', 8);
        // Page number
        $this->Cell(0, 10, APK_NAME.' - '.COMPANY, 0, false, 'C', 0, '', 0, false, 'T', 'M');
        $this->Cell(0, 10, 'Page '.$this->getAliasNumPage().'/'.$this->getAliasNbPages(), 0, false, 'C', 0, '', 0, false, 'T', 'M');
        $this->SetFont('times', 'B', 8);
        $this->SetY(-60);
        $this->SetX(0);
        $this->Cell(200, 100, '', 0, false, 'R', 0, '', 0, false, 'T', 'M');
    }
}

// create new PDF document
$pdf = new MYPDF(PDF_PAGE_ORIENTATION, PDF_UNIT, PDF_PAGE_FORMAT, true, 'UTF-8', false);

// set document information
$pdf->SetCreator(PDF_CREATOR);
$pdf->SetAuthor(COMPANY);
$pdf->SetTitle(APK_NAME);
$pdf->SetSubject('Notulen Entrance Meeting');
$pdf->SetKeywords('TCPDF, PDF, example, test, guide');

// set default header data
$pdf->SetHeaderData(PDF_HEADER_LOGO, PDF_HEADER_LOGO_WIDTH, PDF_HEADER_TITLE, PDF_HEADER_STRING);

// set header and footer fonts
$pdf->setHeaderFont(Array(PDF_FONT_NAME_MAIN, '', PDF_FONT_SIZE_MAIN));
$pdf->setFooterFont(Array(PDF_FONT_NAME_DATA, '', PDF_FONT_SIZE_DATA));

// set default monospaced font
$pdf->SetDefaultMonospacedFont(PDF_FONT_MONOSPACED);

// set margins
$pdf->SetMargins(PDF_MARGIN_LEFT, 40, PDF_MARGIN_RIGHT);
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

ob_start();
if($data_baem->TANDA_TANGAN != '') $ttd = '<img height="100" src="http://ams.ptp.co.id/storage/upload/tanda_tangan/'.$data_baem->TANDA_TANGAN.'">';
else $ttd = '<br><br><br><br>';
$html = '
<style>
.title{
	font-size: 15px;
	text-align: center;
	padding: 10px;
	background-color: rgb(217, 217, 217);
	color: rgb(103, 144, 194);
}
table tr td{
	font-size: 10px;
}
.text-header{
	background-color: #8EC3E6;
	text-align: center;
}
.text-center{
	text-align: center;
}
.text-subheader{
	background-color: #FFFF1F;
}
.nomor_surat{
    text-align: center;
}
.img-logo{
	width: 150px;
}
</style>

<table border="1" width="100%" cellpadding="5">
	<tr>
		<td width="30%" rowspan="4">
			<table border="0" width="100%">
			<tr>
			<td width="20%"><br><br><br></td>
			<td width="60%"></td>
			<td width="20%"></td>
			</tr>
			<tr>
			<td></td>
			<td><img class="img-logo" src="http://ams.ptp.co.id/assets/img/logos/ptp.png"></td>
			<td></td>
			</tr>
			</table>
		</td>
		<td width="70%" colspan="2">
			<table border="1" cellpadding="10">
				<tr>
					<td class="title">
						NOTULEN RAPAT<br>
						Exit Meeting Audit Rutin Kantor Pusat Tahun '.$tahun.'<br>
						PT Pelabuhan Tanjung Priok
					</td>
				</tr>
			</table>
		</td>
	</tr>
	<tr>
		<td>Hari / Tanggal</td>
		<td>'.$hari.' / '.$tanggal.'</td>
	</tr>
	<tr>
		<td>Waktu</td>
		<td>'.$data_baem->WAKTU.'</td>
	</tr>
	<tr>
		<td>Tempat</td>
		<td>'.$data_baem->TEMPAT.'</td>
	</tr>
</table>
<br><br>
<table border="1" width="100%" cellpadding="5">
	<tr>
		<td>Penyelenggara Rapat</td>
		<td>'.$data_baem->NAMA_DIVISI.'</td>
	</tr>
	<tr>
		<td>Judul Rapat</td>
		<td>'.$data_baem->JUDUL.'</td>
	</tr>
	<tr>
		<td>Perserta Rapat</td>
		<td>
';
foreach ($peserta as $item) {
	$html .= '- '.$item['NAMA'] . '<br>'; 
}
$html .= '</td>
	</tr>
</table>
<br><br>
<table border="1" width="100%" cellpadding="5">
	<tr>
		<td class="text-center"><h3>POKOK-POKOK BAHASAN RAPAT</h3></td>
	</tr>
	<tr>
		<td>
			'.$data_baem->DETAIL_A.'
		</td>
	</tr>
</table>
<br><br>
<table border="0" width="100%" cellpadding="5">
	<tr>
		<td colspan="6">Demikian Notulen rapat ini dibuat untuk dapat dipergunakan sebagaimana mestinya.</td>
	</tr>
	<tr nobr="true">
		<td></td>
		<td></td>
		<td></td>
		<td></td>
		<td colspan="2" class="text-center">
			NOTULIS,<br>
			'.$ttd.'
			<br>
			'.$data_baem->NAMA.'
		</td>
	</tr>
</table>
';

// output the HTML content
// $pdf->writeHTML($html, true, false, true, false, '');
$pdf->writeHTMLCell($w='', $h='', $x=15, $y=17.5, $html, $border=0, $ln=1, $fill=0, $reseth=true, $align='', $autopadding=true);
// $pdf->SetMargins(100, 100, 100, true);

// ---------------------------------------------------------

//Close and output PDF document
ob_end_clean();
$pdf->Output('Notulen Rapat '.$data_baem->NAMA_DIVISI.'.pdf', 'I');

//============================================================+
// END OF FILE
//============================================================+

?>

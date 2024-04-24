<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
$pdf = new Pdf('P', 'mm', 'A4', true, 'UTF-8', false);

class MYPDF extends TCPDF {

    function __construct()
    {
        parent::__construct();
    }

    public function Header() {
        $image_file = "http://ams.ptp.co.id/assets/img/logos/ptp.png";
        $this->Image($image_file, 155, 10, 40, '', 'png', '', 'T', false, 300, '', false, false, 0, false, false, false);
        
        $bMargin = $this->getBreakMargin();

        if($this->APPROVED_COUNT != $this->APPROVER_COUNT)
        {	
        	$img_file = base_url()."storage/images/draft.png";
        	$this->Image($img_file, 0, 30, 210, 280, '', '', '', false, 300, '', false, false, 0);
        }
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
$pdf->APPROVED_COUNT = $spa->APPROVED_COUNT;
$pdf->APPROVER_COUNT = $spa->APPROVER_COUNT;

// set document information
$pdf->SetCreator(PDF_CREATOR);
$pdf->SetAuthor(COMPANY);
$pdf->SetTitle(APK_NAME);
$pdf->SetSubject('Surat Perintah Audit');
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
$tanggal = date("j", strtotime($spa->PADA_TANGGAL));
$bulan = date("n", strtotime($spa->PADA_TANGGAL));
if($bulan == 1) $bulan = 'Januari';
if($bulan == 2) $bulan = 'Februari';
if($bulan == 3) $bulan = 'Maret';
if($bulan == 4) $bulan = 'April';
if($bulan == 5) $bulan = 'Mei';
if($bulan == 6) $bulan = 'Juni';
if($bulan == 7) $bulan = 'Juli';
if($bulan == 8) $bulan = 'Agustus';
if($bulan == 9) $bulan = 'September';
if($bulan == 10) $bulan = 'Oktober';
if($bulan == 11) $bulan = 'November';
if($bulan == 12) $bulan = 'Desember';
$tahun = date("Y", strtotime($spa->PADA_TANGGAL));
if($spa->PADA_TANGGAL == '' || $spa->PADA_TANGGAL == NULL) $tanggal_dikeluarkan = '';
else $tanggal_dikeluarkan = $tanggal.' '.$bulan.' '.$tahun;
if($spa->NOMOR_SURAT == '' || $spa->NOMOR_SURAT == NULL) $spasi = '&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;';
else $spasi = '';
$html = '
<style>
.title{
	font-size: 20px;
}
table tr td{
	font-size: 12px;
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
	font-size: 12px;
}
ul, ol{
	padding-left: 0;
	list-style: inside decimal;
}
ol{
	list-style-type: lower-alpha;
}
</style>

<p class="text-center">
<u class="title">SURAT PERINTAH</u><br>
<small class="nomor_surat" id="myDiv">Nomor: '.$spa->NOMOR_SURAT.'</small>'.$spasi.'
<br><br>
</p>
<table border="0" width="100%" cellpadding="5">
	<tr>
		<td width="5%">1.</td>
		<td width="22%">Dasar</td>
		<td width="3%">:</td>
		<td width="70%" colspan="3">
		<table border="0">';
		
		// .$spa->DASAR_AUDIT.
		$no = 'a';
		foreach ($dasar as $key => $value) {
		$html.= '<tr><td width="7%">'.$no.'.</td><td width="93%">'.$value['DASAR'].'</td></tr>';
		$no ++;
	}
	$html .='
	</table></td></tr>
	<tr>
		<td>2.</td>
		<td>Diperintahkan kepada</td>
		<td>:</td>
		<td colspan="3">
			<table border="0">';
$no = 'a';
foreach ($tim_audit as $key => $item) {
	if($item['JABATAN'] == 1) $jabatan = 'Ketua Tim';
	else if($item['JABATAN'] == 2) $jabatan = 'Pengawas';
	else if($item['JABATAN'] == 3) $jabatan = 'Anggota Tim';
	else $jabatan = '';
$html .= '
	<tr>
		<td width="7%">'.$no.'.</td>
		<td width="63%" style="height: 20px;">'.$item['NAMA'].'</td>
		<td width="30%">('.$jabatan.')</td>
	</tr> ';
$no++;
}	

$html .=			'
			</table>
		</td>
	</tr>
	<tr>
		<td>3.</td>
		<td>Isi Perintah</td>
		<td>:</td>
		<td colspan="3"><table border="0">';
		
		// .$spa->DASAR_AUDIT.
		$no = 'a';
		foreach ($perintah as $key => $value) {
		$html.= '<tr><td width="7%">'.$no.'.</td><td width="93%">'.$value['PERINTAH'].'</td></tr>';
		$no ++;
	}
	$html .='
	</table></td>
	</tr>
	<tr>
		<td>4.</td>
		<td colspan="5">Perintah Selesai.</td>
	</tr>
	<br><br>
	<tr>
		<td></td>
		<td></td>
		<td></td>
		<td></td>
		<td colspan="2">Dikeluarkan di : '.$spa->DIKELUARKAN.'</td>
	</tr>
	<tr>
		<td></td>
		<td></td>
		<td></td>
		<td></td>
		<td colspan="2">Pada tanggal &nbsp;&nbsp;: '.$tanggal_dikeluarkan.'</td>
	</tr>
	<br><br>
	<tr nobr="true">
		<td></td>
		<td></td>
		<td></td>
		<td></td>
		<td colspan="2" class="text-center">
			PT PELABUHAN TANJUNG PRIOK<br>
			'.$ttd_spa[0][JABATAN].'
			<p></p>
			<p></p>
			<p></p>
			<p></p>
			<p></p>
			<u>'.$ttd_spa[0][NAMA].'</u>
		</td>
	</tr>
	<tr>
		<td colspan="6">
			<u>Tembusan Yth.</u><br>
			';
		
		// .$spa->DASAR_AUDIT.
		foreach ($tembusan as $key => $value) {
		$html.= '- '.$value['TEMBUSAN'].'<br>';
	}
	$html .='
		</td>
	</tr>
</table>

';

$js = <<<EOD


EOD;
// app.alert('JavaScript Popup Example');

// force print dialog
$js .= 'print(true);';

// set javascript
$pdf->IncludeJS($js);
// output the HTML content
// $pdf->writeHTML($html, true, false, true, false, '');
$pdf->writeHTMLCell($w='', $h='', $x=15, $y=37.5, $html, $border=0, $ln=1, $fill=0, $reseth=true, $align='', $autopadding=true);
        // $this->comparePdfs($pdf);
// $pdf->SetMargins(100, 100, 100, true);

// ---------------------------------------------------------

//Close and output PDF document
ob_end_clean();
$pdf->Output('REKAP_TL_'.$bulan.'_'.$tahun.'.pdf', 'I');

//============================================================+
// END OF FILE
//============================================================+

?>
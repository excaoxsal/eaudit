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
        // $this->Cell(0, 10, 'Page '.$this->getAliasNumPage().'/'.$this->getAliasNbPages(), 0, false, 'C', 0, '', 0, false, 'T', 'M');
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
$pdf->SetSubject('Berita Acara');
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
$pdf->SetFont('dejavusans', '', 11, '', true);

// add a page
$pdf->AddPage();

ob_start();
$tgl 		= substr($data_ba->TANGGAL, 8, 2);
$bln 		= substr($data_ba->TANGGAL, 5, 2);
$thn 		= substr($data_ba->TANGGAL, 0, 4);
$ttd_sm_spi = $sm_spi[0]['TANDA_TANGAN'] == '' ? '<div style="height:100px;"></div>' : $sm_spi[0]['TANDA_TANGAN'];
$ttd_pic 	= $pic['TANDA_TANGAN'] == '' ? '<div style="height:100px;"></div>' : $pic['TANDA_TANGAN'];
$html = '
<style>
.title{
	font-size: 12px;
	letter-spacing: 3px;
	font-weight: bold;
}
.tentang{
	font-size: 11px;
}
table tr td{
	font-size: 11px;
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
	font-size: 11px;
	text-align: left;
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
<u class="title"><b>BERITA ACARA</b></u><br>
<small class="nomor_surat"><b>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;NOMOR: '.$data_ba->NOMOR.'</b></small>
<br><br>
<p class="tentang"><b>
TENTANG<br>
HASIL MONITORING TINDAKLANJUT REKOMENDASI AUDIT RUTIN TAHUN ' . $tahun . '<br>
PADA PT. PELABUHAN TANJUNG PRIOK ' . strtoupper($divisi[0]['NAMA_DIVISI']) . '
</p>	
</b></p>
<table width="100%" cellpadding="5" style="text-align: justify;">
	<tr>
		<td colspan="3">Pada hari ini <b>'.hari_indo($data_ba->TANGGAL).'</b> tanggal <b>'.terbilang((int)$tgl).'</b> bulan <b>'.bulan_indo($data_ba->TANGGAL).'</b> tahun <b>'.terbilang($thn).'</b> ('.$tgl.'-'.$bln.'-'.$thn.'), yang bertandatangan di bawah ini :</td>
	</tr>
	<tr>
		<td width="5%">1.</td>
		<td width="35%">' . ucwords($sm_spi[0]['NAMA']) . '</td>
		<td width="60%">(' . str_replace("Branch Manager","<i>Branch Manager</i>",$sm_spi[0]['NAMA_JABATAN']) . ')</td>
		</tr>
	<tr>
		<td width="5%">2.</td>
		<td width="35%">'.$pic[NAMA].'</td>
		<td width="60%">('.str_replace("Branch Manager","<i>Branch Manager</i>",$pic[NAMA_JABATAN]).')</td>
	</tr>
	<tr>
		<td colspan="3">
		Bahwa telah melaksanakan Monitoring Tindak Lanjut Rekomendasi Hasil Audit Rutin Tahun  '. $tahun . ' pada PT. Pelabuhan Tanjung Priok ' . ($divisi[0]['NAMA_DIVISI']) . ', dan telah dilakukan konfirmasi serta pembahasan bersama antara Satuan Pengawasan Internal PT. Pelabuhan Tanjung Priok dengan <i>Branch Manager</i> ' . ($divisi[0]['NAMA_DIVISI']) . ', dengan hasil <b>"SELURUH REKOMENDASI TELAH SELESAI DITINDAKLANJUTI"</b>.</td>
	</tr>
</table>
<br>
<br>
<br>
<br>
<br>
<table width="100%" cellpadding="20">
<tr>
<td width="50%" class="text-center">
<b>PT PELABUHAN TANJUNG PRIOK</b>
<br>
<b>DIVISI PENGAWASAN INTERNAL & HUKUM</b>
<br>
<b>' . strtoupper($sm_spi[0]['NAMA_JABATAN']) . '</b>
<br><br>
<!--<img height="100" src="'.base_url().'storage/upload/tanda_tangan/'.$ttd_sm_spi.'">-->
<img height="100" src="http://ams.ptp.co.id/storage/upload/tanda_tangan/'.$ttd_sm_spi.'">
<br>
<b><u>' . $sm_spi[0]['NAMA'] . '</u></b>
<br>
<b>NIPP. ' . $sm_spi[0]['NIPP'] . '</b>
</td>
<td width="50%" class="text-center">
<b>PT PELABUHAN TANJUNG PRIOK</b>
<br>
<b>' . strtoupper($divisi[0]['NAMA_DIVISI']) . '</b>
<br>
<b><i>BRANCH MANAGER</i></b>
<br><br>
<img height="100" src="'.base_url().'storage/upload/tanda_tangan/'.$ttd_pic.'">
<br>
<b><u>'.$pic[NAMA].'</u></b>
<br>
<b>NIPP. '.$pic[NIPP].'</b>
</td>
</tr>
<table>
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
$pdf->Output('BA MONITORING TL.pdf', 'I');

//============================================================+
// END OF FILE
//============================================================+

?>
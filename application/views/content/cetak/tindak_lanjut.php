<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
$pdf = new Pdf('P', 'mm', 'A4', true, 'UTF-8', false);

class MYPDF extends TCPDF {

    function __construct()
    {
        parent::__construct();
    }

    public function Header() {
        // $image_file = base_url()."assets/img/logos/iptp.png";
        // $this->Image($image_file, 155, 10, 40, '', 'png', '', 'T', false, 300, '', false, false, 0, false, false, false);
        
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
$pdf->SetSubject('Dokumen Peminjaman');
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
$ttd = $pic_rekomendasi->TANDA_TANGAN != '' ? '<img height="100" src="'.base_url().'storage/upload/tanda_tangan/'.$pic_rekomendasi->TANDA_TANGAN.'">' : '<br><br><br><br>';
$html = '
<style>
.title{
	color: rgb(103, 144, 194);
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
    text-align: center;
}
.img-logo{
	width: 150px;
}
.form{
	text-align: right;
	color: #000;
	font-size: 12px;
}
th {
	color: white;	
	background-color: #60a9f7;
	font-size: 12px;
	font-weight: bold;
}
</style>

<table border="0" width="100%">
	<tr>
		<td width="70%">
		
		</td>
		<td width="30%">
			<p class="form">Form Tindak Lanjut LHA</p>
		</td>
	</tr>
</table>
<br><br>

<br><br>
<table border="0" width="100%">
	<tr>
		<td class="text-center">
		<h3>
			TINDAK LANJUT LAPORAN HASIL AUDIT SPI<br>
			PT PELABUHAN TANJUNG PRIOK<br>
			'.strtoupper($detail_rekomendasi['NAMA_DIVISI']).'
		</h3><br><br></td>
	</tr>
</table>
<br><br>
<table border="0" width="100%">
	<tr>
		<td width="3%">1.</td>
		<td width="22%">Tahun Temuan</td>
		<td width="2%">:</td>
		<td width="73%">'.$detail_rekomendasi['TAHUN'].'</td>
	</tr>
	<br>
	<tr>
		<td>2.</td>
		<td>Divisi / Bidang</td>
		<td>:</td>
		<td>'.$detail_rekomendasi['NAMA_DIVISI'].'</td>
	</tr>
	<br>
	<tr>
		<td>3.</td>
		<td>No / Judul Temuan</td>
		<td>:</td>
		<td>'.$detail_rekomendasi['NO_URUT'].' / '.$detail_rekomendasi['JUDUL_TEMUAN'].'</td>
	</tr>
	<br>
	<tr>
		<td>4.</td>
		<td>Rekomendasi</td>
		<td>:</td>
		<td>'.$detail_rekomendasi['REKOMENDASI'].'</td>
	</tr>
	<br>
	<tr>
		<td>5.</td>
		<td>Tindak Lanjut</td>
		<td colspan="2">:</td>
	</tr>
	<tr>
		<td></td>
		<td colspan="3">'.$detail_rekomendasi['HASIL_MONITORING'].'</td>
	</tr>
	<br>
	<tr>
		<td>6.</td>
		<td colspan="3">Dokumen Pendukung (Lampiran)</td>
	</tr>
	<tr>
		<td></td>
		<td colspan="3">'.$detail_rekomendasi['DOKUMEN_PENDUKUNG'].'</td>
	</tr>
	<br>
	<br>
	<tr>
		<td width="50%"></td>
		<td width="50%" class="text-center">
		Tanjung Priok, '.tgl_indo($detail_rekomendasi['TGL_PENYELESAIAN']).'
		<br>
		<br>PT PELABUHAN TANJUNG PRIOK
		<br>'.$detail_rekomendasi['NAMA_DIVISI'].'
		<br>'.$pic_rekomendasi->NAMA_JABATAN.'
		<br>'.$ttd.'
		<br>'.$pic_rekomendasi->NAMA.'
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
$pdf->Output('Dokumen Peminjaman - '.$kepada.' - '.$tanggal.'.pdf', 'I');

//============================================================+
// END OF FILE
//============================================================+

?>

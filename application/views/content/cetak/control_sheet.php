<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
$pdf = new Pdf('P', 'mm', 'A4', true, 'UTF-8', false);

class MYPDF extends TCPDF {

    function __construct()
    {
        parent::__construct();
    }

    public function Header() {
    	$html = '<p style="font-size: 18px;">LAMPIRAN 1</p>';
        $this->writeHTMLCell($w='', $h='', $x=15, $y=10, $html, $border=0, $ln=1, $fill=0, $reseth=true, $align='', $autopadding=true);
        
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
$pdf->SetSubject('Control Sheet');
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
$html = '
<style>
.title{
	font-size: 18px;
	text-align: center;
	background-color: rgb(217, 217, 217);
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
</style>
<table border="1" width="100%" cellpadding="3">
	<tr>
		<td colspan="4" class="title">
		PT PELABUHAN INDONESIA II (PERSERO)<br>
		SATUAN PENGAWASAN INTERN
		</td>
	</tr>
	<tr>
		<td colspan="4" class="text-center">
		CONTROL SHEET UNTUK PERENCANAAN AUDIT
		</td>
	</tr>
	<tr>
		<td colspan="4">
		Nama audit: '.$data_cs->NAMA_AUDIT.'
		</td>
	</tr>
	<tr>
		<td colspan="4">
		<i>Auditee</i>: '.$data_cs->AUDITEE.'
		</td>
	</tr>
	<tr>
		<td colspan="4">
		Periode audit: '.tgl_indo($data_cs->TGL_PERIODE_MULAI).' - '.tgl_indo($data_cs->TGL_PERIODE_SELESAI).'
		</td>
	</tr>
	<tr>
		<td width="60%" colspan="2" class="text-center"><b>Aktivitas Terkait Perencanaan Audit</b><br>
		<i>(Sesuai dengan SOP Perencanaan Audit)</i>
		</td>
		<td width="20%" class="text-center"><b>PIC</b><br>
		<i>(Isi dengan nama dan paraf orang yang bertanggung jawab)</i>
		</td>
		<td width="20%" class="text-center"><b>Date</b><br>
		<i>(Isi dengan tanggal penyelesaian)
		</i></td>
	</tr>
	<tr><td colspan="4" style="background-color:black;font-size:2px;"></td></tr>
	<tr>
		<td width="7%">1.</td>
		<td width="53%">Surat Perintah Audit telah disusun dan disetujui.</td>
		<td width="20%" style="text-align:center">'.$data_cs->PIC_DISETUJUI.'</td>
		<td width="20%" style="text-align:center">'.tgl_indo($data_cs->TGL_DISETUJUI).'</td>
	</tr>
	<tr>
		<td width="7%">2.</td>
		<td width="53%">Surat Perintah Audit telah didistribusikan ke auditee, paling tidak pada 4 (empat) hari kerja sebelum penugasan audit dimulai.</td>
		<td width="20%" style="text-align:center">'.$data_cs->PIC_DIDISTRIBUSI.'</td>
		<td width="20%" style="text-align:center">'.tgl_indo($data_cs->TGL_DIDISTRIBUSI).'</td>
	</tr>
	<tr>
		<td width="7%">3.</td>
		<td width="53%"><i>Audit Planning Memorandum</i> telah disusun, diperbaharui sesuai dengan informasi yang diperoleh selama penugasan audit, direview, dan disetujui.</td>
		<td width="20%" style="text-align:center">'.$data_cs->PIC_APM_DISUSUN.'</td>
		<td width="20%" style="text-align:center">'.tgl_indo($data_cs->TGL_APM_DISUSUN).'</td>
	</tr>
	<tr>
		<td width="7%">4.</td>
		<td width="53%"><i>Risk and Control Matrix</i> termasuk audit program dan pemilihan sampel telah disusun, diperbaharui sesuai dengan informasi yang diperoleh selama penugasan audit, direview, dan disetujui.</td>
		<td width="20%" style="text-align:center">'.$data_cs->PIC_RCM_DISUSUN.'</td>
		<td width="20%" style="text-align:center">'.tgl_indo($data_cs->TGL_RCM_DISUSUN).'</td>
	</tr>
	<tr>
		<td width="7%">5.</td>
		<td width="53%">Notulen <i>Entrance Meeting</i> telah disusun.</td>
		<td width="20%" style="text-align:center">'.$data_cs->PIC_ENTRANCE_DISUSUN.'</td>
		<td width="20%" style="text-align:center">'.tgl_indo($data_cs->TGL_ENTRANCE_DISUSUN).'</td>
	</tr>
</table>

';

// output the HTML content
// $pdf->writeHTML($html, true, false, true, false, '');
$pdf->writeHTMLCell($w='', $h='', $x=15, $y=25, $html, $border=0, $ln=1, $fill=0, $reseth=true, $align='', $autopadding=true);
// $pdf->SetMargins(100, 100, 100, true);

// ---------------------------------------------------------

//Close and output PDF document
ob_end_clean();
$pdf->Output('Control Sheet'.$bulan.'_'.$tahun.'.pdf', 'I');

//============================================================+
// END OF FILE
//============================================================+

?>

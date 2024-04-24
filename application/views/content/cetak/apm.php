<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
$pdf = new Pdf('P', 'mm', 'A4', true, 'UTF-8', false);

class MYPDF extends TCPDF {

    function __construct()
    {
        parent::__construct();
    }

    public function Header() {
        $html = '
        <p style="text-align: center">
        <br>
        <b>PT. PELABUHAN TANJUNG PRIOK<br>
        SATUAN PENGAWASAN INTERN<br>
        AUDIT PLANNING MEMORANDUM<br></b>
        <b>NAMA AUDIT:</b> <i>'.$this->NAMA_AUDIT.'</i><br>
        <b>TANGGAL:  '.$this->TGL_PERIODE_MULAI.' sd '.$this->TGL_PERIODE_SELESAI.'</b><br>
        </p>
        ';
        $this->writeHTMLCell($w='', $h='', $x=15, $y=7.5, $html, $border=0, $ln=1, $fill=0, $reseth=true, $align='', $autopadding=true);
        
        $bMargin = $this->getBreakMargin();
        if($this->pemeriksa2 != '2')
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
$pdf->NAMA_AUDIT = $data_apm->NAMA_AUDIT;
$pdf->pemeriksa1 = $status1;
$pdf->pemeriksa2 = $status2;
$pdf->TGL_PERIODE_MULAI = tgl_indo($data_apm->TGL_PERIODE_MULAI);
$pdf->TGL_PERIODE_SELESAI = tgl_indo($data_apm->TGL_PERIODE_SELESAI);

// set document information
$pdf->SetCreator(PDF_CREATOR);
$pdf->SetAuthor(COMPANY);
$pdf->SetTitle(APK_NAME);
$pdf->SetSubject('Audit Planning Memorandum');
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
    background-color: rgb(217, 217, 217);
    text-align: center;
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
</style>
<table border="0" width="100%" cellpadding="3">
    <tr>
        <td class="title"><i>TUJUAN DAN RUANG LINGKUP AUDIT</i></td>
    </tr>
</table>
<br><br>
<table border="0" width="100%" cellpadding="3">
    <tr>
        <td width="5%"><b>A.</b></td>
        <td width="95%"><b>Tujuan:</b></td>
    </tr>
    <tr>
        <td width="5%"></td>
        <td width="95%">'.$data_apm->TUJUAN.'</td>
    </tr>
    <tr>
        <td width="5%"><b>B.</b></td>
        <td width="95%"><b>Ruang Lingkup Audit:</b></td>
    </tr>
    <tr>
        <td width="5%"></td>
        <td width="95%">'.$data_apm->RUANG_LINGKUP.'</td>
    </tr>
    <tr>
        <td width="5%"><b>C.</b></td>
        <td width="95%"><b>Periode yang diaudit:</b></td>
    </tr>
    <tr>
        <td width="5%"></td>
        <td width="95%">'.$data_apm->PERIODE_AUDIT.'</td>
    </tr>
</table>
<br><br>
<table border="0" width="100%" cellpadding="3">
    <tr>
        <td class="title"><i>LATAR BELAKANG</i></td>
    </tr>
</table>
<br><br>
<table border="0" width="100%" cellpadding="3">
    <tr>
        <td width="5%"><b>A.</b></td>
        <td width="95%"><b>Deskripsi singkat mengenai Auditee:</b></td>
    </tr>
    <tr>
        <td width="5%"></td>
        <td width="95%">'.$data_apm->DESKRIPSI_TEXT.'</td>
    </tr>
    <tr>
        <td width="5%"><b>B.</b></td>
        <td width="95%"><b>Proses Bisnis:</b></td>
    </tr>
    <tr>
        <td width="5%"></td>
        <td width="95%">'.$data_apm->PROSES_BISNIS_TEXT.'</td>
    </tr>
    <tr>
        <td width="5%"><b>C.</b></td>
        <td width="95%"><b>Risiko yang diidentifikasi dan kontrol yang akan diuji (merujuk ke Risk & Control Matrix):</b></td>
    </tr>
    <tr>
        <td width="5%"></td>
        <td width="95%">'.$data_apm->RESIKO.'</td>
    </tr>
    <tr>
        <td width="5%"><b>D.</b></td>
        <td width="95%"><b>Catatan dari audit sebelumnya:</b></td>
    </tr>
    <tr>
        <td width="5%"></td>
        <td width="95%">'.$data_apm->CATATAN.'</td>
    </tr>
    <tr>
        <td width="5%"><b>E.</b></td>
        <td width="95%"><b>Review Analitis:</b></td>
    </tr>
    <tr>
        <td width="5%"></td>
        <td width="95%">'.$data_apm->REVIEW_ANALISIS.'</td>
    </tr>
    <tr>
        <td width="5%"><b>F.</b></td>
        <td width="95%"><b>Berita, Peraturan, dan pembaharuan pada industri yang terkait:</b></td>
    </tr>
    <tr>
        <td width="5%"></td>
        <td width="95%">'.$data_apm->BERITA_ATURAN.'</td>
    </tr>
</table>
<br><br>
<table border="0" width="100%" cellpadding="3">
    <tr>
        <td class="title"><i>RISIKO POTENSIAL</i></td>
    </tr>
    <tr>
        <td>'.$data_apm->DAFTAR_RESIKO_POTENSIAL.'</td>
    </tr>
</table>
<br><br>
<table border="0" width="100%" cellpadding="3">
    <tr>
        <td class="title"><i>KOMUNIKASI & KOORDINASI</i></td>
    </tr>
</table>
<br><br>
<table border="0" width="100%" cellpadding="3">
    <tr>
        <td width="5%"><b>A.</b></td>
        <td width="95%"><b>TIM AUDIT</b></td>
    </tr>
</table>
<br><br>
<table border="0" width="100%" cellpadding="3">
    <tr nobr="true">
        <td><table border="1" width="100%" cellpadding="3">
    <tr nobr="true">
        <td style="background-color: rgb(230, 230, 230);text-align:center;">NAMA</td>
        <td style="background-color: rgb(230, 230, 230);text-align:center;">POSISI</td>
    </tr>';
foreach ($tim_audit as $key => $item) {
if($item['JABATAN'] == 1) $jabatan = 'Ketua Tim';
if($item['JABATAN'] == 2) $jabatan = 'Pengawas';
if($item['JABATAN'] == 3) $jabatan = 'Anggota Tim';
$html .= '
    <tr>
        <td>'.$item['NAMA'].'</td>
        <td>'.$jabatan.'</td>
    </tr> ';
}
$html .= '
</table></td>
    </tr>
</table>
<br><br>
<table border="0" width="100%" cellpadding="3">
    <tr>
        <td width="5%"><b>B.</b></td>
        <td width="95%"><b>JADWAL AUDIT</b></td>
    </tr>
</table>
<br><br>
<table border="1" width="100%" cellpadding="3">
    <tr>
        <td style="background-color: rgb(230, 230, 230);text-align:center;">AKTIVITAS</td>
        <td style="background-color: rgb(230, 230, 230);text-align:center;">TANGGAL</td>
    </tr>
    <tr>
        <td>Perencanaan Audit</td>
        <td style="text-align:center;">'.tgl_indo($data_apm->JADWAL_PERENCANAAN).'</td>
    </tr>
    <tr>
        <td><i>Entrance Meeting </i></td>
        <td style="text-align:center;">'.tgl_indo($data_apm->JADWAL_ENTRANCE_MEETING).'</td>
    </tr>
    <tr>
        <td>Pelaksanaan Penugasan Audit</td>
        <td style="text-align:center;">'.tgl_indo($data_apm->JADWAL_PELAKSANAAN).' s/d '.tgl_indo($data_apm->JADWAL_PELAKSANAAN).'</td>
    </tr>
    <tr>
        <td><i>Exit Meeting</i></td>
        <td style="text-align:center;">'.tgl_indo($data_apm->JADWAL_EXIT_MEETING).'</td>
    </tr>
    <tr>
        <td>Draf Laporan Hasil Pemeriksaan</td>
        <td style="text-align:center;">'.tgl_indo($data_apm->JADWAL_DRAFT_LAPORAN).'</td>
    </tr>
    <tr>
        <td>Laporan Hasil Pemeriksaan</td>
        <td style="text-align:center;">'.tgl_indo($data_apm->JADWAL_LAPORAN_HASIL).'</td>
    </tr>
</table>
<br><br>
<table border="0" width="100%" cellpadding="3">
    <tr>
        <td width="5%"><b>C.</b></td>
        <td width="95%"><b>DOKUMEN YANG DIBUTUHKAN DARI AUDITEE</b></td>
    </tr>
</table>
<br><br>
<table border="0" width="100%" cellpadding="3">
    <tr>
        <td>'.$data_apm->DAFTAR_DOKUMEN.'</td>
    </tr>
</table>
<br>
<hr>
<table border="0" width="100%" cellpadding="3">
    <tr>
        <td width="20%"></td>
        <td width="60%">
        </td>
        <td width="20%"></td>
    </tr>
</table>
<table border="0" width="100%" cellpadding="3">
    <tr nobr="true">
        <td width="20%"></td>
        <td width="60%">
            <table border="1" width="100%" cellpadding="3">
                <tr>
                    <td style="background-color: rgb(230, 230, 230);text-align:center;"></td>
                    <td style="background-color: rgb(230, 230, 230);text-align:center;">Disiapkan Oleh</td>
                    <td style="background-color: rgb(230, 230, 230);text-align:center;">Direview Oleh</td>
                </tr>
                <tr>
                    <td style="text-align:center;">Nama:</td>
                    <td style="text-align:center;">';
foreach ($tim_audit as $key => $item) {
if($item['JABATAN'] == 1){ 
$html .= '
    <i>'.$item['NAMA'].'
    </i> ';
}}
$html .= '</td>
                    <td style="text-align:center;">';
foreach ($tim_audit as $key => $item) {
if($item['JABATAN'] == 2){ 
$html .= '
    <i>'.$item['NAMA'].'
    </i> ';
}}
$html .= '</td>
                </tr>
                <tr>
                    <td style="text-align:center;">Tanggal:</td>
                    <td style="text-align:center;">'.$tanggal_atasan1.'</td>
                    <td style="text-align:center;">'.$tanggal_atasan2.'</td>
                </tr>
                <tr>
                    <td style="text-align:center;">Tanda Tangan:</td>
                    <td style="text-align:center;height:80px;">';

    if($status1 == '2'){
$html .= '
    <img height="100" src="'.base_url().'storage/upload/tanda_tangan/'.$ttd1.'">
    ';
}

$html .= '</td>
                    <td style="text-align:center;height:80px;">';

    if($status2 == '2'){
$html .= '
    <img height="100" src="'.base_url().'storage/upload/tanda_tangan/'.$ttd2.'">
    ';
}
$html .= '</td>
                </tr>
            </table>
        </td>
        <td width="20%"></td>
    </tr>
</table>

';

// output the HTML content
// $pdf->writeHTML($html, true, false, true, false, '');
$pdf->writeHTMLCell($w='', $h='', $x=15, $y=37.5, $html, $border=0, $ln=1, $fill=0, $reseth=true, $align='', $autopadding=true);
// $pdf->SetMargins(100, 100, 100, true);

// ---------------------------------------------------------

//Close and output PDF document
ob_end_clean();
$pdf->Output('APM.pdf', 'I');

//============================================================+
// END OF FILE
//============================================================+

?>

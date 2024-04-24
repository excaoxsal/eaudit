<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
$pdf = new Pdf('L', 'mm', 'A4', true, 'UTF-8', false);

class MYPDF extends TCPDF {

    function __construct()
    {
        parent::__construct();
    }

    public function Header() {
        // $image_file = base_url()."assets/img/logos/ptpi.png";
        // $this->Image($image_file, 155, 10, 40, '', 'png', '', 'T', false, 300, '', false, false, 0, false, false, false);
        
        $bMargin = $this->getBreakMargin();
        if($this->pemeriksa2 != '2')
        {   
            $img_file = base_url()."storage/images/draft.png";
            $this->Image($img_file, 100, 50, 310, 390, '', '', '', false, 300, '', false, false, 0);
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

// set document information
$pdf->SetCreator(PDF_CREATOR);
$pdf->SetAuthor(COMPANY);
$pdf->SetTitle(APK_NAME);
$pdf->SetSubject('Risk and Control Matrix');
$pdf->SetKeywords('TCPDF, PDF, example, test, guide');
$pdf->pemeriksa1 = $status1;
$pdf->pemeriksa2 = $status2;

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
$pdf->AddPage('L');

ob_start();
$html = '
<style>
table tr td{
	font-size: 8px;
}
.text-header{
    background-color: rgb(217, 217, 217);
	text-align: center;
}
.text-center{
	text-align: center;
}
.header{
	background-color: rgb(217, 217, 217);
}
</style>
<h3>
Risk and Control Matrix<br>
</h3>
<table border="0" width="100%">
    <tbody>
    <tr>
        <td width="31%"><table border="1" cellpadding="3">
                <tr>
                    <td class="header" width="30%">Auditee</td>
                    <td width="70%">'.$data_rcm->KEPADA.'</td>
                </tr>
                <tr>
                    <td class="header">Area Audit</td>
                    <td>'.$data_rcm->AREA_AUDIT.'</td>
                </tr>
                <tr>
                    <td class="header">Periode Audit</td>
                    <td>'.tgl_indo($data_rcm->TGL_PERIODE_MULAI).' - '.tgl_indo($data_rcm->TGL_PERIODE_SELESAI).'</td>
                </tr>
            </table>
        </td>
        <td width="6.9%"></td>
        <td width="6.9%"></td>
        <td width="6.9%"></td>
        <td width="6.9%"></td>
        <td width="41.4%"><table border="1" cellpadding="3">
                <tr>
                    <td class="text-header"></td>
                    <td class="text-header">Disiapkan oleh</td>
                    <td class="text-header">Direview oleh</td>
                </tr>
                <tr>
                    <td>Nama:</td>
                    <td style="text-align:center">';
foreach ($tim_audit as $key => $item) {
if($item['JABATAN'] == 1){ 
$html .= '
    '.$item['NAMA'].'
     ';
}}
$html .= '</td>
                    <td style="text-align:center">';
foreach ($tim_audit as $key => $item) {
if($item['JABATAN'] == 2){ 
$html .= '
    '.$item['NAMA'].'
     ';
}}
$html .= '</td>
                </tr>
                <tr>
                    <td>Tanggal:</td>
                    <td style="text-align:center">'.$tanggal_atasan1.'</td>
                    <td style="text-align:center">'.$tanggal_atasan2.'</td>
                </tr>
                <tr>
                    <td>Tanda Tangan:</td>
                    <td style="heigh:80px;">';
    if($status1 == '2'){
$html .= '
    <img height="100" src="'.base_url().'storage/upload/tanda_tangan/'.$ttd1.'">
    ';
}
$html .= '</td>
                    <td style="heigh:80px;">';

    if($status2 == '2'){
$html .= '
    <img height="100" src="'.base_url().'storage/upload/tanda_tangan/'.$ttd2.'">
    ';
}
$html .= '</td>
                </tr>
            </table>
        </td>
    </tr>
    </tbody>
</table>
<br><br>
<table border="1" width="100%" cellpadding="3">
    <tr>
        <td class="text-header" rowspan="2" width="3.4%">No</td>
        <td class="text-header" rowspan="2" width="6.9%">Deskripsi Proses<br>(A)</td>
        <td class="text-header" rowspan="2" width="6.9%">Deskripsi Risiko<br>(B)</td>
        <td class="text-header" rowspan="2" width="6.9%">Prioritas Risiko (Tinggi/Sedang/Rendah)<br>(C)</td>
        <td class="text-header" colspan="3" width="20.7%">Kontrol Terkait Dengan Risiko<br></td>
        <td class="text-header" rowspan="2" width="6.9%">Auditee<br>(G)</td>
        <td class="text-header" rowspan="2" width="6.9%">Tipe Kontrol<br>(H)</td>
        <td class="text-header" rowspan="2" width="6.9%">Frekuensi Kontrol<br>(I)</td>
        <td class="text-header" rowspan="2" width="6.9%">Audit Program<br>(J)</td>
        <td class="text-header" rowspan="2" width="6.9%">Ada Kelemahan Desain Kontrol (Ya/Tidak)<br>(K)</td>
        <td class="text-header" colspan="3" width="20.7%">Tidak terdapat kelemahan desain kontrol à Test of Control harus dilakukan<br></td>
    </tr>
    <tr>
        <td class="text-header">Kontrol Standar <br>(D)</td>
        <td class="text-header">Kontrol "As-Is" <br>(E)</td>
        <td class="text-header">Kontrol "Should Be" <br>(F)</td>
        <td class="text-header">Jumlah Sampel<br>(L)</td>
        <td class="text-header">Anggaran Mandays <br>(M)</td>
        <td class="text-header">Referensi KKP <br>(N)</td>
    </tr>
    <tbody>
    ';
    $no= 0;
foreach ($list_add_proses as $key => $item) {
    $no++;
$html .= '
    <tr>
        <td width="3.4%">'.$no.'</td>
        <td width="6.9%">'.$item[DESKRIPSI_PROSES].'</td>
        <td width="6.9%">'.$item[DESKRIPSI_RESIKO].'</td>
        <td width="6.9%">'.$item[TR_RESIKO].'</td>
        <td width="6.9%">'.$item[KONTROL_STANDAR].'</td>
        <td width="6.9%">'.$item[KONTROL_AS_IS].'</td>
        <td width="6.9%">'.$item[KONTROL_SHOULD_BE].'</td>
        <td width="6.9%">'.$item[AUDITEE].'</td>
        <td width="6.9%">'.$item[TIPE_KONTROL].'</td>
        <td width="6.9%">'.$item[FREKUENSI_KONTROL].'</td>
        <td width="6.9%">'.$item[AUDIT_PROGRAM].'</td>
        <td width="6.9%">'.$item[KELEMAHAN].'</td>
        <td width="6.9%">'.$item[JML_SAMPLE].'</td>
        <td width="6.9%">'.$item[ANGGARAN_MANDAYS].'</td>
        <td width="6.9%">'.$item[REFERENSI_KKP].'</td>
    </tr> ';
}
$html .= '
    
    </tbody>
</table>

';

// output the HTML content
// $pdf->writeHTML($html, true, false, true, false, '');
$pdf->writeHTMLCell($w='', $h='', $x=15, $y=15, $html, $border=0, $ln=1, $fill=0, $reseth=true, $align='', $autopadding=true);
// $pdf->SetMargins(100, 100, 100, true);

// ---------------------------------------------------------

//Close and output PDF document
ob_end_clean();
$pdf->Output('RCM.pdf', 'I');

//============================================================+
// END OF FILE
//============================================================+

?>

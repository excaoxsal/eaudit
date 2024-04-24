<?php if (!defined('BASEPATH')) exit('No direct script access allowed');
$pdf = new Pdf('L', 'mm', 'A4', true, 'UTF-8', false);

class MYPDF extends TCPDF
{

    function __construct()
    {
        parent::__construct();
    }

    public function Header()
    {
        if ($this->page != 1) {

            // $image_file = base_url() . "assets/img/logos/ptpi.png";
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
    }

    // Page footer
    public function Footer()
    {
        // Position at 15 mm from bottom
        // $this->SetY(-15);
        // // Set font
        // $this->SetFont('helvetica', 'I', 8);
        // Page number
        $this->Cell(0, 10, APK_NAME.' - '.COMPANY, 0, false, 'C', 0, '', 0, false, 'T', 'M');
        $this->Cell(0, 10, 'Page ' . $this->getAliasNumPage() . '/' . $this->getAliasNbPages(), 0, false, 'C', 0, '', 0, false, 'T', 'M');
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
$pdf->SetSubject('Tindak Lanjut Rekomendasi Hasil Audit');
$pdf->SetKeywords('TCPDF, PDF, example, test, guide');

// set default header data
$pdf->SetHeaderData(PDF_HEADER_LOGO, PDF_HEADER_LOGO_WIDTH, PDF_HEADER_TITLE, PDF_HEADER_STRING);

// set header and footer fonts
$pdf->setHeaderFont(array(PDF_FONT_NAME_MAIN, '', PDF_FONT_SIZE_MAIN));
$pdf->setFooterFont(array(PDF_FONT_NAME_DATA, '', PDF_FONT_SIZE_DATA));

// set default monospaced font
$pdf->SetDefaultMonospacedFont(PDF_FONT_MONOSPACED);

// set margins
$pdf->SetMargins(PDF_MARGIN_LEFT, 18, PDF_MARGIN_RIGHT);
$pdf->SetHeaderMargin(PDF_MARGIN_HEADER);
$pdf->SetFooterMargin(PDF_MARGIN_FOOTER);

// set auto page breaks
$pdf->SetAutoPageBreak(TRUE, 15);

// set image scale factor
$pdf->setImageScale(PDF_IMAGE_SCALE_RATIO);

// set some language-dependent strings (optional)
if (@file_exists(dirname(__FILE__) . '/lang/eng.php')) {
    require_once(dirname(__FILE__) . '/lang/eng.php');
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
$ttd_asm_spi    = $asm_spi[0]['TANDA_TANGAN'] == '' ? '<div style="height:100px;"></div>' : $asm_spi[0]['TANDA_TANGAN'];
$ttd_pic        = $pic_div['TANDA_TANGAN'] == '' ? '<div style="height:100px;"></div>' : $pic_div['TANDA_TANGAN'];
$divisi_header  = ($divisi[0]['IS_CABANG'] === 'Y') ? $divisi[0]['NAMA_DIVISI'] : "PTP KANTOR PUSAT";
$html = '
<style>
h3{
    text-align: center;
}
table tr td{
	font-size: 10px;
}
.text-header{
	background-color: #8EC3E6;
	text-align: center;
    vertical-align: middle;
}
.text-center{
	text-align: center;
}
.text-subheader{
	background-color: #FFFF1F;
}
.content td {
    font-size: 6px;
}

.header th {
    font-size: 8px;
}
.jenis_audit {
    font-weight: bold;
    font-size: 12px;
}
</style>
<table border="" width="100%" cellpadding="3">
<tr>
<td width="90%"></td>
<td class="text-center text-header jenis_audit" width="10%">' . $jenis_audit . '</td>
</tr>
</table>
<h3>
TINDAK LANJUT REKOMENDASI HASIL AUDIT<br>
SATUAN PENGAWASAN INTERNAL<br>
' . strtoupper($divisi_header) . '<br>
TAHUN ' . $tahun . '<br>
</h3>
<table border="1" width="100%" cellpadding="3">
    <tr class="header">
    	<td class="text-header" rowspan="3" width="3%">NO</td>
    	<td class="text-header" rowspan="3" colspan="2" width="37%">UNIT AUDITI</td>
    	<td class="text-header" colspan="2" width="20%">JUMLAH</td>
    	<td class="text-header" colspan="4" width="44%">STATUS TINDAK LANJUT</td>
    </tr>
    <tr class="header">
    	<td class="text-header" rowspan="2">TEMUAN</td>
    	<td class="text-header" rowspan="2">REKOMENDASI</td>
    	<td class="text-header" rowspan="2">SELESAI</td>
    	<td class="text-header" colspan="2">PANTAU</td>
    	<td class="text-header" rowspan="2" width="11%">TEMUAN TIDAK DAPAT<br>DITINDAK-LANJUTI<br>(TPTD)</td>
    </tr>
    <tr class="header">
    	<td class="text-header">SUDAH<br>DITINDAK-LANJUTI<br>(STL)</td>
    	<td class="text-header">BELUM<br>DITINDAK-LANJUTI<br>(BTL)</td>
    </tr>
    <tbody>
	    <tr >
	    	<td width="3%">1</td>
	    	<td colspan="2" width="37%">' . strtoupper($divisi[0]['NAMA_DIVISI']) . '</td>
	    	<td width="10%">' . count($temuan) . '</td>
	    	<td width="10%">' . $total_rekom . '</td>
	    	<td width="11%">' . $tk_penyelesaian['selesai'] . '</td>
	    	<td width="11%">' . $tk_penyelesaian['stl'] . '</td>
	    	<td width="11%">' . $tk_penyelesaian['btl'] . '</td>
	    	<td width="11%">' . $tk_penyelesaian['tptd'] . '</td>
	    </tr>
	    <tr>
	    	<td width="3%"></td>
	    	<td colspan="2" width="37%">JUMLAH</td>
	    	<td width="10%">' . count($temuan) . '</td>
	    	<td width="10%">' . $total_rekom . '</td>
	    	<td width="11%">' . $tk_penyelesaian['selesai'] . '</td>
	    	<td width="11%">' . $tk_penyelesaian['stl'] . '</td>
	    	<td width="11%">' . $tk_penyelesaian['btl'] . '</td>
	    	<td width="11%">' . $tk_penyelesaian['tptd'] . '</td>
	    </tr>
    </tbody>
</table>
<br><br>
<table border="1" width="100%" cellpadding="2">
    <thead>
    <tr class="header">
    	<th class="text-header" rowspan="3" width="2%">NO</th>
    	<th class="text-header" rowspan="3" width="31%">TEMUAN HASIL PEMERIKSAAN</th>
    	<th class="text-header" rowspan="3" width="15%">REKOMENDASI</th>
    	<th class="text-header" rowspan="3" width="6%">BATAS WAKTU</th>
    	<th class="text-header" rowspan="3" width="7%">TGL PENYELESAIAN</th>
    	<th class="text-header" rowspan="3" width="10%">PIC</th>
    	<th class="text-header" rowspan="3" width="17%">HASIL MONITORING</th>
    	<th class="text-header" colspan="4" width="16%">TINGKAT PENYELESAIAN</th>
    </tr>
    <tr class="header"> 
    	<th class="text-header" rowspan="2">SELESAI</th>
    	<th class="text-header" colspan="2">PANTAU</th>
    	<th class="text-header" rowspan="2">TPTD</th>
        
    </tr>
    <tr class="header">
    	<th class="text-header">STL</th>
    	<th class="text-header">BTL</th>
    </tr>
    <tr>
    	<td class="text-subheader" colspan="15"></td>
    </tr>
    </thead>
    
    
    <tbody>
        ';
foreach ($rekomendasi as $key => $item) {

    $count_rekom = count($item['REKOMEN']);
    $rs = 0;
    $total_tp = '
                <td width="4%" class="text-center" rowspan="' . $count_rekom . '" style="">' . $tk_penyelesaian_rekom[$item['ID']]['selesai'] . '</td>
                <td width="4%" class="text-center" rowspan="' . $count_rekom . '" style="">' . $tk_penyelesaian_rekom[$item['ID']]['stl'] . '</td>
                <td width="4%" class="text-center" rowspan="' . $count_rekom . '" style="">' . $tk_penyelesaian_rekom[$item['ID']]['btl'] . '</td>
                <td width="4%" class="text-center" rowspan="' . $count_rekom . '" style="">' . $tk_penyelesaian_rekom[$item['ID']]['tptd'] . '</td>
            ';

    $data_temuan = "<p><strong>" . $item['JUDUL_TEMUAN'] . "</strong></p>" . str_replace('text-indent', '', str_replace('font-size:', '', $item['TEMUAN']));
    $temuan = '<td width="2%" rowspan="' . $count_rekom . '" class="text-center">' . ($key + 1) . '</td>
    <td width="31%" rowspan="' . $count_rekom . '">' . $data_temuan . '</td>';

    if ($count_rekom != 0) {
        foreach ($item['REKOMEN'] as $key => $item) {
            if ($item['TK_PENYELESAIAN'] == 'Selesai') $Selesai = '✓';
            else $Selesai = '';
            if ($item['TK_PENYELESAIAN'] == 'BTL') $BTL = '✓';
            else $BTL = '';
            if ($item['TK_PENYELESAIAN'] == 'TPTD') $TPTD = '✓';
            else $TPTD = '';
            if ($item['TK_PENYELESAIAN'] == 'STL') $STL = '✓';
            else $STL = '';

            //PIC
            $pic = join("<br/><br>", json_decode($item['PIC']));

            if ($rs != 0) {
                $total_tp = '';
                $temuan = '';
            }

            $temuan_ = str_replace('data:image/jpeg;base64,', '@', $temuan);
            $rekom_ = str_replace('data:image/jpeg;base64,', '@', $item['REKOMENDASI']);
            $rekom_ = str_replace('text-indent', '', str_replace('font-size:', '', $rekom_));
            $hasil_ = str_replace('data:image/jpeg;base64,', '@', $item['HASIL_MONITORING']);

            $html .= '
                        <tr class="content">
                            ' . str_replace('data:image/png;base64,', '@', $temuan_) . '
                            <td width="15%">' . str_replace('data:image/png;base64,', '@', $rekom_) . '</td>
                            <td width="6%" class="text-center">' . tgl_indo($item['BATAS_WAKTU']) . '</td>
                            <td width="7%" class="text-center">' . tgl_indo($item['TGL_PENYELESAIAN']) . '</td>
                            <td width="10%" class="text-center">' . $pic . '</td>
                            <td width="17%">' . str_replace('data:image/png;base64,', '@', $hasil_) . '</td>
                            <td width="4%" class="text-center" style="font-size:10px">' . $Selesai . '</td>
                            <td width="4%" class="text-center" style="font-size:10px">' . $STL . '</td>
                            <td width="4%" class="text-center" style="font-size:10px">' . $BTL . '</td>
                            <td width="4%" class="text-center" style="font-size:10px">' . $TPTD . '</td>
                        </tr>';

            $rs++;
        }
    } else {
        $html .= '<tr class="content">
        ' . $temuan . '
            <td width="15%"></td>
            <td width="6%" class="text-center"></td>
            <td width="7%" class="text-center"></td>
            <td width="10%" class="text-center"></td>
            <td width="17%"></td>
            <td width="4%" class="text-center" style="font-size:10px"></td>
            <td width="4%" class="text-center" style="font-size:10px"></td>
            <td width="4%" class="text-center" style="font-size:10px"></td>
            <td width="4%" class="text-center" style="font-size:10px"></td>
            <td width="4%" class="text-center" style="">0</td>
            <td width="4%" class="text-center" style="">0</td>
            <td width="4%" class="text-center" style="">0</td>
            <td width="4%" class="text-center" style="">0</td>
        </tr>';
    }
}
$html .= '
    </tbody>
</table>
<br>

<center>
<table width="100%" cellpadding="20">
<tr>
<td width="55%" class="text-center">
PT. PELABUHAN TANJUNG PRIOK
<br>
' . strtoupper($asm_spi[0]['NAMA_JABATAN']) . '
<br><br>
<img height="100" src="http://ams.ptp.co.id/storage/upload/tanda_tangan/'.$ttd_asm_spi.'">

<br>
<u>' . $asm_spi[0]['NAMA'] . '</u>
<br>
NIPP. ' . $asm_spi[0]['NIPP'] . '
</td>
<td width="45%" class="text-center">
PT. PELABUHAN TANJUNG PRIOK
<br>
 ' . strtoupper($divisi[0]['NAMA_DIVISI']) . '
<br><br>
<img height="100" src="http://ams.ptp.co.id/storage/upload/tanda_tangan/'.$ttd_pic.'">
<br>
<u>'.$pic_div[NAMA].'</u>
<br>
NIPP. '.$pic_div[NIPP].'
</td>
</tr>
<table>
</center>
';

// output the HTML content
// $pdf->writeHTML($html, true, false, true, false, '');
$pdf->writeHTMLCell($w = '', $h = '', $x = 4, $y = 10, $html, $border = 0, $ln = 1, $fill = 0, $reseth = true, $align = '', $autopadding = true);
// $pdf->SetMargins(100, 100, 100, true);

// ---------------------------------------------------------

//Close and output PDF document
ob_end_clean();
$pdf->Output('REKAP_' . strtoupper($divisi_header) . '_' . $jenis_audit . '_' . $tahun . '.pdf', 'I');

//============================================================+
// END OF FILE
//============================================================+

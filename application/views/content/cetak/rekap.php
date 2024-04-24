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
		// $image_file = base_url() . "theme/html/dist/assets/media/logos/ptpi.png";
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

		if ($this->page != 1) {

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
				<td class="text-header" rowspan="3" width="5%">NO</td>
				<td class="text-header" rowspan="3" colspan="2" width="34.9%">KEGIATAN AUDIT</td>
				<td class="text-header" colspan="2" width="19.9%">JUMLAH</td>
				<td class="text-header" colspan="4" width="39.8%">STATUS TINDAK LANJUT</td>
			</tr>
			<tr>
				<td class="text-header" rowspan="2">TEMUAN</td>
				<td class="text-header" rowspan="2">REKOMENDASI</td>
				<td class="text-header" rowspan="2">SELESAI</td>
				<td class="text-header" colspan="2">PANTAU</td>
				<td class="text-header" rowspan="2">TEMUAN TIDAK DAPAT<br>DITINDAK-LANJUTI<br>(TPTD)</td>
			</tr>
			<tr>
				<td class="text-header">SUDAH<br>DITINDAK-LANJUTI<br>(STL)</td>
				<td class="text-header">BELUM<br>DITINDAK-LANJUTI<br>(BTL)</td>
				<td class="text-header"></td>
			</tr></table>';

			$this->writeHTMLCell($w = '', $h = '', $x = 16, $y = 10, $html, $border = 0, $ln = 1, $fill = 0, $reseth = true, $align = '', $autopadding = true);
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
		$this->Cell(0, 10, 'Rekap Monitoring Tindak Lanjut Audit - PT Pelabuhan Tanjung Priok', 0, false, 'C', 0, '', 0, false, 'T', 'M');
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
$pdf->SetSubject('Rekap Monitoring Tindak Lanjut Audit');
$pdf->SetKeywords('TCPDF, PDF, example, test, guide');

// set default header data
$pdf->SetHeaderData(PDF_HEADER_LOGO, PDF_HEADER_LOGO_WIDTH, PDF_HEADER_TITLE, PDF_HEADER_STRING);

// set header and footer fonts
$pdf->setHeaderFont(array(PDF_FONT_NAME_MAIN, '', PDF_FONT_SIZE_MAIN));
$pdf->setFooterFont(array(PDF_FONT_NAME_DATA, '', PDF_FONT_SIZE_DATA));

// set default monospaced font
$pdf->SetDefaultMonospacedFont(PDF_FONT_MONOSPACED);

// set margins
$pdf->SetMargins(PDF_MARGIN_LEFT, 36, PDF_MARGIN_RIGHT);
$pdf->SetHeaderMargin(PDF_MARGIN_HEADER);
$pdf->SetFooterMargin(PDF_MARGIN_FOOTER);

// set auto page breaks
$pdf->SetAutoPageBreak(TRUE, PDF_MARGIN_BOTTOM);

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

$alphabet = range('A', 'Z');

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
}
.text-center{
	text-align: center;
}
.text-subheader{
	background-color: #FFFF1F;
}
.text-bold {
	font-weight: bold;
</style>
<h3>
REKAPITULASI MONITORING TINDAK LANJUT REKOMENDASI<br>
SATUAN PENGAWASAN INTERNAL<br>
PT. PELABUHAN TANJUNG PRIOK<br>
BULAN : ' . $bulan_str . ' ' . $tahun . '<br>
</h3>
<table border="1" width="100%" cellpadding="3">
    <tr>
    	<td class="text-header" rowspan="3" width="5%">NO</td>
    	<td class="text-header" rowspan="3" colspan="2" width="35%">KEGIATAN AUDIT</td>
    	<td class="text-header" colspan="2" width="20%">JUMLAH</td>
    	<td class="text-header" colspan="4" width="40%">STATUS TINDAK LANJUT</td>
																				
    </tr>
    <tr>
    	<td class="text-header" rowspan="2">TEMUAN</td>
    	<td class="text-header" rowspan="2">REKOMENDASI</td>
    	<td class="text-header" rowspan="2">SELESAI</td>
    	<td class="text-header" colspan="2">PANTAU</td>
    	<td class="text-header" rowspan="2">TEMUAN TIDAK DAPAT<br>DITINDAK-LANJUTI<br>(TPTD)</td>
    </tr>
    <tr>
    	<td class="text-header">SUDAH<br>DITINDAK-LANJUTI<br>(STL)</td>
    	<td class="text-header">BELUM<br>DITINDAK-LANJUTI<br>(BTL)</td>
    	<td class="text-header"></td>
										 
									 
									 
									  
    </tr>
    <tbody>';

$i = 0;
$total_alpha = '';
foreach ($rekap['REKAP'] as $rekapItem) {

	if (count($rekapItem['DATA']) != 0) {

		$html .= '
					<tr>
						<td class="text-subheader" width="5%">' . $alphabet[$i] . '</td>
						<td class="text-subheader" colspan="2" width="35%">' . strtoupper($rekapItem["JENIS_AUDIT"]) . '</td>
						<td class="text-subheader" width="10%"></td>
						<td class="text-subheader" width="10%"></td>
						<td class="text-subheader" width="10%"></td>
									  
						<td class="text-subheader" width="10%"></td>
									  
						<td class="text-subheader" width="10%"></td>
									  
						<td class="text-subheader" width="10%"></td>
									  
					</tr>';
		$z = 1;
		$count_alpha = count($rekapItem['DATA']) + 1;
		$total_alpha .= ($i < count($rekapItem['DATA'])) ? $alphabet[$i] . ' + ' : $alphabet[$i];
		foreach ($rekapItem['DATA'] as $data) {
			if($data['REKOMENDASI']==$data['SELESAI']+$data['TPTD']) 
				$count_alpha = $count_alpha-1;
		}
		$total_temuan 	= 0;
		$total_rekom 	= 0;
		$total_selesai 	= 0;
		$total_stl 		= 0;
		$total_btl 		= 0;
		$total_tptd 	= 0;
		foreach ($rekapItem['DATA'] as $data) {
			if($data['REKOMENDASI']!=$data['SELESAI']+$data['TPTD']){
				$alpha = '';
				if ($z === 1) {
					$alpha = '<td width="5%" rowspan="' . $count_alpha . '"></td>';
				}
				$total_temuan 	= $total_temuan + $data['TEMUAN'];
				$total_rekom 	= $total_rekom + $data['REKOMENDASI'];
				$total_selesai 	= $total_selesai + $data['SELESAI'];
				$total_stl 		= $total_stl + $data['STL'];
				$total_btl 		= $total_btl + $data['BTL'];
				$total_tptd 	= $total_tptd + $data['TPTD'];
				$html .= '
					<tr>
						' . $alpha . '
						<td width="5%">' . $z . '</td>
						<td width="30%">' . $data['DIVISI'] . '</td>
						<td width="10%" class="text-center">' . $data['TEMUAN'] . '</td>
						<td width="10%" class="text-center">' . $data['REKOMENDASI'] . '</td>
						<td width="10%" class="text-center">' . $data['SELESAI'] . '</td>
						<td width="10%" class="text-center">' . $data['STL'] . '</td>
						<td width="10%" class="text-center">' . $data['BTL'] . '</td>
						<td width="10%" class="text-center">' . $data['TPTD'] . '</td>
																														  
																													  
																													  
																													   
					</tr>';
				$z++;
			}
		}

		if (count($rekapItem['DATA']) != 0) {
			$html .= '
		<tr>
			<td width="35%" colspan="2" class="text-header text-bold ">TOTAL: </td>
			<td width="10%" class="text-center text-header text-bold">' . $total_temuan . '</td>
			<td width="10%" class="text-center text-header text-bold">' . $total_rekom . '</td>
			<td width="10%" class="text-center text-header text-bold">' . $total_selesai . '</td>
			<td width="10%" class="text-center text-header text-bold">' . $total_stl . '</td>
			<td width="10%" class="text-center text-header text-bold">' . $total_btl . '</td>
			<td width="10%" class="text-center text-header text-bold">' . $total_tptd . '</td>
																																									  
																																								  
																																								  
																																								   
		</tr>';
		} else {
			$html .= '
		<tr>
			<td width="5%"></td>
			<td width="35%"class="text-header text-bold ">TOTAL: </td>
			<td width="10%" class="text-center text-header text-bold">' . $rekapItem['TOTAL']['TEMUAN'] . '</td>
			<td width="10%" class="text-center text-header text-bold">' . $rekapItem['TOTAL']['REKOMENDASI'] . '</td>
			<td width="10%" class="text-center text-header text-bold">' . $rekapItem['TOTAL']['SELESAI'] . '</td>
			<td width="10%" class="text-center text-header text-bold">' . $rekapItem['TOTAL']['STL'] . '</td>
			<td width="10%" class="text-center text-header text-bold">' . $rekapItem['TOTAL']['BTL'] . '</td>
			<td width="10%" class="text-center text-header text-bold">' . $rekapItem['TOTAL']['TPTD'] . '</td>
																																									  
																																								  
																																								  
																																								   
		</tr>';
		}

		$i++;
	}
}


$html .= '
	<tr>
			<td width="5%" class="text-header"></td>
			<td width="35%" colspan="2" class="text-header text-bold ">TOTAL (' . $total_alpha . '): </td>
			<td width="10%" class="text-center text-header text-bold">' . $rekap['TOTAL']['TEMUAN'] . '</td>
			<td width="10%" class="text-center text-header text-bold">' . $rekap['TOTAL']['REKOMENDASI'] . '</td>
			<td width="10%" class="text-center text-header text-bold">' . $rekap['TOTAL']['SELESAI'] . '</td>
			<td width="10%" class="text-center text-header text-bold">' . $rekap['TOTAL']['STL'] . '</td>
			<td width="10%" class="text-center text-header text-bold">' . $rekap['TOTAL']['BTL'] . '</td>
			<td width="10%" class="text-center text-header text-bold">' . $rekap['TOTAL']['TPTD'] . '</td>
																																							  
																																						  
																																						  
																																						   
		</tr>
    </tbody>
</table>

';

// output the HTML content
// $pdf->writeHTML($html, true, false, true, false, '');
$pdf->writeHTMLCell($w = '', $h = '', $x = 15, $y = 16, $html, $border = 0, $ln = 1, $fill = 0, $reseth = true, $align = '', $autopadding = true);
// $pdf->SetMargins(100, 100, 100, true);

// ---------------------------------------------------------

//Close and output PDF document
ob_end_clean();
$pdf->Output('REKAP_TL_' . $bulan . '_' . $tahun . '.pdf', 'I');

//============================================================+
// END OF FILE
//============================================================+

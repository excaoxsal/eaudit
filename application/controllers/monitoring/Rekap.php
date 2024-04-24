<?php
defined('BASEPATH') or exit('No direct script access allowed');

require('./excel/vendor/autoload.php');

use PhpOffice\PhpSpreadsheet\Helper\Sample;
use PhpOffice\PhpSpreadsheet\IOFactory;
use PhpOffice\PhpSpreadsheet\Spreadsheet;

class Rekap extends MY_Controller
{

	public function __construct()
	{
		parent::__construct();
		$this->load->library('Pdf');
		$this->load->model('monitoring/m_rekap', 'm_rekap');
		$this->is_login();
		if(!$this->is_auditor()) $this->load->view('/errors/html/err_401');
	}

	public function index()
	{
		$data['menu']           = 'monitoring';
		$data['sub_menu']       = 'rekap';
		$data['sub_menu_2']     = 'keseluruhan';
		$data['title']          = 'Rekap Bulanan Monitoring TL SPI';
        $data['content']        = 'content/monitoring/v_rekap';
        $this->show($data);
	}

	public function cetak($bulan, $tahun, $status='')
	{
		if ($bulan == '1') $bulan_str 	= 'JANUARI';
		if ($bulan == '2') $bulan_str 	= 'FEBRUARI';
		if ($bulan == '3') $bulan_str 	= 'MARET';
		if ($bulan == '4') $bulan_str 	= 'APRIL';
		if ($bulan == '5') $bulan_str 	= 'MEI';
		if ($bulan == '6') $bulan_str 	= 'JUNI';
		if ($bulan == '7') $bulan_str 	= 'JULI';
		if ($bulan == '8') $bulan_str 	= 'AGUSTUS';
		if ($bulan == '9') $bulan_str 	= 'SEPTEMBER';
		if ($bulan == '10') $bulan_str 	= 'OKTOBER';
		if ($bulan == '11') $bulan_str 	= 'NOVEMBER';
		if ($bulan == '12') $bulan_str 	= 'DESEMBER';
		$data['bulan'] 				= $bulan;
		$data['bulan_str'] 			= $bulan_str;
		$data['tahun'] 				= $tahun;
		$jenisAudit 				= $this->m_rekap->getJenisAudit();
		$rekap 						= array();
		$z 							= 0;
		$grand_total_temuan 		= 0;
		$grand_total_rekomendasi 	= 0;
		$grand_total_selesai 		= 0;
		$grand_total_stl 			= 0;
		$grand_total_btl 			= 0;
		$grand_total_tptd 			= 0;
		foreach ($jenisAudit as $itemJenis) {
			$year 					= date('Y');
			$dataEntry 				= $this->m_rekap->getEntry($itemJenis['ID_JENIS_AUDIT'], $year);
			$report 				= array();
			$i 					= 0;
			$total_temuan 		= 0;
			$total_rekomendasi 	= 0;
			$total_selesai 		= 0;
			$total_stl 			= 0;
			$total_btl 			= 0;
			$total_tptd 		= 0;
			foreach ($dataEntry as $itemEntry) {
				$report[$i]['DIVISI'] = $itemEntry['NAMA_DIVISI'] . ' ' . $itemEntry['TAHUN'];

				$field 					= array('ID');
				// $temuan = $this->m_rekap->getData($field, 'ID_TL', $itemEntry['ID_TL'], 'TL_TEMUAN');
				$temuan 				= $this->m_rekap->getTemuan($itemEntry['ID_TL']);
				// print_r($temuan);die();
				$report[$i]['TEMUAN'] 	= count($temuan);

				$report[$i]['REKOMENDASI'] 	= 0;
				$report[$i]['SELESAI'] 		= 0;
				$report[$i]['STL'] 			= 0;
				$report[$i]['BTL'] 			= 0;
				$report[$i]['TPTD'] 		= 0;

				$total_rekom 	= 0;
				$selesai 		= 0;
				$stl 			= 0;
				$btl 			= 0;
				$tptd 			= 0;
				foreach ($temuan as $itemTemuan) {
					$field = array('ID', 'TK_PENYELESAIAN');
					// $rekomendasi = $this->m_rekap->getData($field, 'ID_TEMUAN', $itemTemuan['ID'], 'TL_REKOMENDASI');
					$rekomendasi = $this->m_rekap->getRekom($itemTemuan['ID']);
					$total_rekom = $total_rekom + count($rekomendasi);

					foreach ($rekomendasi as $itemRekom) {
						if ($itemRekom['TK_PENYELESAIAN'] == 'Selesai') $selesai++;
						if ($itemRekom['TK_PENYELESAIAN'] == 'STL') $stl++;
						if ($itemRekom['TK_PENYELESAIAN'] == 'BTL') $btl++;
						if ($itemRekom['TK_PENYELESAIAN'] == 'TPTD') $tptd++;
					}

					$report[$i]['REKOMENDASI'] 	= $total_rekom;
					$report[$i]['SELESAI'] 		= $selesai;
					$report[$i]['STL'] 			= $stl;
					$report[$i]['BTL'] 			= $btl;
					$report[$i]['TPTD'] 		= $tptd;
				}

				$total_temuan 		= $total_temuan + count($temuan);
				$total_rekomendasi 	= $total_rekomendasi + $total_rekom;
				$total_selesai 		= $total_selesai + $selesai;
				$total_stl 			= $total_stl + $stl;
				$total_btl 			= $total_btl + $btl;
				$total_tptd 		= $total_tptd + $tptd;

				$i++;
			}

			$rekap[$z]['JENIS_AUDIT'] 	= $itemJenis['JENIS_AUDIT'];
			$rekap[$z]['DATA'] 			= $report;
			$rekap[$z]['TOTAL'] 		= array('TEMUAN' => $total_temuan, 'REKOMENDASI' => $total_rekomendasi, 'SELESAI' => $total_selesai, 'STL' => $total_stl, 'BTL' => $total_btl, 'TPTD' => $total_tptd);

			$grand_total_temuan 		= $grand_total_temuan + $total_temuan;
			$grand_total_rekomendasi 	= $grand_total_rekomendasi + $total_rekomendasi;
			$grand_total_selesai 		= $grand_total_selesai + $total_selesai;
			$grand_total_stl 			= $grand_total_stl + $total_stl;
			$grand_total_btl 			= $grand_total_btl + $total_btl;
			$grand_total_tptd 			= $grand_total_tptd + $total_tptd;

			$z++;
		}

		$grand_total 	= array('TEMUAN' => $grand_total_temuan, 'REKOMENDASI' => $grand_total_rekomendasi, 'SELESAI' => $grand_total_selesai, 'STL' => $grand_total_stl, 'BTL' => $grand_total_btl, 'TPTD' => $grand_total_tptd);
		$data['rekap'] 	= array('REKAP' => $rekap, 'TOTAL' => $grand_total);

		if($status=='SELESAI')
			$this->load->view('/content/cetak/rekap_selesai', $data);
		else
			$this->load->view('/content/cetak/rekap', $data);
	}

	public function cetak_persen($bulan, $tahun, $status='')
	{
		if ($bulan == '1') $bulan_str 	= 'JANUARI';
		if ($bulan == '2') $bulan_str 	= 'FEBRUARI';
		if ($bulan == '3') $bulan_str 	= 'MARET';
		if ($bulan == '4') $bulan_str 	= 'APRIL';
		if ($bulan == '5') $bulan_str 	= 'MEI';
		if ($bulan == '6') $bulan_str 	= 'JUNI';
		if ($bulan == '7') $bulan_str 	= 'JULI';
		if ($bulan == '8') $bulan_str 	= 'AGUSTUS';
		if ($bulan == '9') $bulan_str 	= 'SEPTEMBER';
		if ($bulan == '10') $bulan_str 	= 'OKTOBER';
		if ($bulan == '11') $bulan_str 	= 'NOVEMBER';
		if ($bulan == '12') $bulan_str 	= 'DESEMBER';
		$data['bulan'] 				= $bulan;
		$data['bulan_str'] 			= $bulan_str;
		$data['tahun'] 				= $tahun;
		$jenisAudit 				= $this->m_rekap->getJenisAudit();
		$rekap 						= array();
		$z 							= 0;
		$grand_total_temuan 		= 0;
		$grand_total_rekomendasi 	= 0;
		$grand_total_selesai 		= 0;
		$grand_total_stl 			= 0;
		$grand_total_btl 			= 0;
		$grand_total_tptd 			= 0;
		foreach ($jenisAudit as $itemJenis) {
			$year 					= date('Y');
			$dataEntry 				= $this->m_rekap->getEntry($itemJenis['ID_JENIS_AUDIT'], $year);
			$report 				= array();
			$i 					= 0;
			$total_temuan 		= 0;
			$total_rekomendasi 	= 0;
			$total_selesai 		= 0;
			$total_stl 			= 0;
			$total_btl 			= 0;
			$total_tptd 		= 0;
			foreach ($dataEntry as $itemEntry) {
				$report[$i]['DIVISI'] 	= $itemEntry['NAMA_DIVISI'] . ' ' . $itemEntry['TAHUN'];
				$report[$i]['TGL_LHA'] 	= $itemEntry['TANGGAL_LHA'];

				$field 					= array('ID');
				// $temuan = $this->m_rekap->getData($field, 'ID_TL', $itemEntry['ID_TL'], 'TL_TEMUAN');
				$temuan 				= $this->m_rekap->getTemuan($itemEntry['ID_TL']);
				$report[$i]['TEMUAN'] 	= count($temuan);

				$report[$i]['REKOMENDASI'] 	= 0;
				$report[$i]['SELESAI'] 		= 0;
				$report[$i]['STL'] 			= 0;
				$report[$i]['BTL'] 			= 0;
				$report[$i]['TPTD'] 		= 0;

				$total_rekom 	= 0;
				$selesai 		= 0;
				$stl 			= 0;
				$btl 			= 0;
				$tptd 			= 0;
				foreach ($temuan as $itemTemuan) {
					$field = array('ID', 'TK_PENYELESAIAN');
					// $rekomendasi = $this->m_rekap->getData($field, 'ID_TEMUAN', $itemTemuan['ID'], 'TL_REKOMENDASI');
					$rekomendasi = $this->m_rekap->getRekom($itemTemuan['ID']);
					$total_rekom = $total_rekom + count($rekomendasi);

					foreach ($rekomendasi as $itemRekom) {
						if ($itemRekom['TK_PENYELESAIAN'] == 'Selesai') $selesai++;
						if ($itemRekom['TK_PENYELESAIAN'] == 'STL') $stl++;
						if ($itemRekom['TK_PENYELESAIAN'] == 'BTL') $btl++;
						if ($itemRekom['TK_PENYELESAIAN'] == 'TPTD') $tptd++;
					}

					$report[$i]['REKOMENDASI'] 	= $total_rekom;
					$report[$i]['SELESAI'] 		= $selesai;
					$report[$i]['STL'] 			= $stl;
					$report[$i]['BTL'] 			= $btl;
					$report[$i]['TPTD'] 		= $tptd;
				}

				$total_temuan 		= $total_temuan + count($temuan);
				$total_rekomendasi 	= $total_rekomendasi + $total_rekom;
				$total_selesai 		= $total_selesai + $selesai;
				$total_stl 			= $total_stl + $stl;
				$total_btl 			= $total_btl + $btl;
				$total_tptd 		= $total_tptd + $tptd;

				$i++;
			}

			$rekap[$z]['JENIS_AUDIT'] 	= $itemJenis['JENIS_AUDIT'];
			$rekap[$z]['DATA'] 			= $report;
			$rekap[$z]['TOTAL'] 		= array('TEMUAN' => $total_temuan, 'REKOMENDASI' => $total_rekomendasi, 'SELESAI' => $total_selesai, 'STL' => $total_stl, 'BTL' => $total_btl, 'TPTD' => $total_tptd);

			$grand_total_temuan 		= $grand_total_temuan + $total_temuan;
			$grand_total_rekomendasi 	= $grand_total_rekomendasi + $total_rekomendasi;
			$grand_total_selesai 		= $grand_total_selesai + $total_selesai;
			$grand_total_stl 			= $grand_total_stl + $total_stl;
			$grand_total_btl 			= $grand_total_btl + $total_btl;
			$grand_total_tptd 			= $grand_total_tptd + $total_tptd;

			$z++;
		}

		$grand_total 	= array('TEMUAN' => $grand_total_temuan, 'REKOMENDASI' => $grand_total_rekomendasi, 'SELESAI' => $grand_total_selesai, 'STL' => $grand_total_stl, 'BTL' => $grand_total_btl, 'TPTD' => $grand_total_tptd);
		$data['rekap'] 	= array('REKAP' => $rekap, 'TOTAL' => $grand_total);

		if($status=='SELESAI')
			$this->load->view('/content/cetak/rekap_selesai_persen', $data);
		else
			$this->load->view('/content/cetak/rekap_persen', $data);
	}

	public function export($bulan, $tahun)
	{
		$divisi   		= $this->m_divisi->divisi();
		// Create new Spreadsheet object
		$spreadsheet 	= new Spreadsheet();

		// Set document properties
		$spreadsheet->getProperties()->setCreator(COMPANY)
			->setLastModifiedBy(COMPANY)
			->setTitle(APK_NAME)
			->setSubject('Rekap Monitoring Tindak Lanjut Audit')
			->setDescription('Rekap Monitoring Tindak Lanjut Audit - '.COMPANY)
			->setKeywords('Rekap Monitoring Tindak Lanjut Audit')
			->setCategory('Rekap Monitoring Tindak Lanjut Audit');

		// Add some data
		$spreadsheet->setActiveSheetIndex(0)
			->setCellValue('A2', 'REKAPITULASI MONITORING TINDAK LANJUT REKOMENDASI')
			->setCellValue('A3', 'SATUAN PENGAWASAN INTERNAL')
			->setCellValue('A4', 'PT. PELABUHAN TANJUNG PRIOK')
			->setCellValue('A5', 'BULAN : DESEMBER 2020')
			->setCellValue('A7', 'NO')
			->setCellValue('B7', 'KEGIATAN AUDIT')
			->setCellValue('D7', 'JUMLAH')
			->setCellValue('D8', 'TEMUAN')
			->setCellValue('E8', 'REKOMENDASI')
			->setCellValue('F7', 'STATUS TINDAK LANJUT')
			->setCellValue('F8', 'SELESAI')
			->setCellValue('G8', 'PANTAU')
			->setCellValue('G9', 'SUDAH DITINDAK-LANJUTI (STL)')
			->setCellValue('H9', 'BELUM DITINDAK-LANJUTI (BTL)')
			->setCellValue('I8', 'TEMUAN TIDAK DAPAT DITINDAK-LANJUTI (TPTD)')
			->setCellValue('A10', 'A')
			->setCellValue('B10', 'AUDIT INTERNAL SPI PTP')
			->setCellValue('B10', 'AUDIT INTERNAL SPI PTP');

		$i = 11;
		foreach ($divisi as $divisi) {

			$spreadsheet->setActiveSheetIndex(0)
				->setCellValue('B' . $i, $divisi[ID_DIVISI])
				->setCellValue('C' . $i, $divisi[NAMA_DIVISI]);
			$i++;
		}
		$spreadsheet->setActiveSheetIndex(0)
			->setCellValue('B' . $i, 'TOTAL :');
		$spreadsheet->getActiveSheet()->mergeCells("B" . $i . ":C" . $i);
		$spreadsheet->getActiveSheet()->getStyle("B" . $i . ":I" . $i)->getFill()->setFillType(\PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID)->getStartColor()->setARGB('8EC3E6');

		// Rename worksheet
		foreach (range('A', 'I') as $columnID) {
			$spreadsheet->getActiveSheet()->getColumnDimension($columnID)
				->setAutoSize(true);
			$spreadsheet->getActiveSheet()->getStyle($columnID)->getAlignment()->setHorizontal('center');
		}
		$spreadsheet->getActiveSheet()->setTitle('REKAP_' . date('d-m-Y'));
		$spreadsheet->getActiveSheet()->mergeCells("A2:I2");
		$spreadsheet->getActiveSheet()->mergeCells("A3:I3");
		$spreadsheet->getActiveSheet()->mergeCells("A4:I4");
		$spreadsheet->getActiveSheet()->mergeCells("A5:I5");
		$spreadsheet->getActiveSheet()->getStyle("A2:I2")->getFont()->setSize(20)->setBold(true);
		$spreadsheet->getActiveSheet()->getStyle("A3:I3")->getFont()->setSize(18)->setBold(true);
		$spreadsheet->getActiveSheet()->getStyle("A4:I4")->getFont()->setSize(18)->setBold(true);
		$spreadsheet->getActiveSheet()->getStyle("A5:I5")->getFont()->setSize(18)->setBold(true);
		$spreadsheet->getActiveSheet()->getStyle("A2:I2")->getAlignment()->setHorizontal('center');
		$spreadsheet->getActiveSheet()->getStyle("A3:I3")->getAlignment()->setHorizontal('center');
		$spreadsheet->getActiveSheet()->getStyle("A4:I4")->getAlignment()->setHorizontal('center');
		$spreadsheet->getActiveSheet()->getStyle("A5:I5")->getAlignment()->setHorizontal('center');

		$spreadsheet->getActiveSheet()->mergeCells("A7:A9");
		$spreadsheet->getActiveSheet()->mergeCells("B7:C9");
		$spreadsheet->getActiveSheet()->mergeCells("D7:E7");
		$spreadsheet->getActiveSheet()->mergeCells("D8:D9");
		$spreadsheet->getActiveSheet()->mergeCells("E8:E9");
		$spreadsheet->getActiveSheet()->mergeCells("F7:I7");
		$spreadsheet->getActiveSheet()->mergeCells("F8:F9");
		$spreadsheet->getActiveSheet()->mergeCells("G8:H8");
		$spreadsheet->getActiveSheet()->mergeCells("I8:I9");
		$spreadsheet->getActiveSheet()->mergeCells("B10:C10");
		$spreadsheet->getActiveSheet()->getStyle("A7:I9")->getFill()->setFillType(\PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID)->getStartColor()->setARGB('8EC3E6');
		$spreadsheet->getActiveSheet()->getStyle("A10:I10")->getFill()->setFillType(\PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID)->getStartColor()->setARGB('FFFF1F');
		$spreadsheet->getActiveSheet()->getStyle("A7:I9")->getBorders()->getAllBorders()->setBorderStyle(\PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THICK)->getColor()->setARGB('000');

		// Set active sheet index to the first sheet, so Excel opens this as the first sheet
		$spreadsheet->setActiveSheetIndex(0);

		// Redirect output to a client’s web browser (Xlsx)
		header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
		header('Content-Disposition: attachment;filename="REKAP_TL_' . $bulan . "_" . $tahun . '.xlsx"');
		header('Cache-Control: max-age=0');

		$writer = IOFactory::createWriter($spreadsheet, 'Xlsx');
		$writer->save('php://output');
		exit;
	}
}

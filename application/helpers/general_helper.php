<?php
if ( ! function_exists('dd'))
{
	function dd($data)
	{
		echo json_encode($data); die;
	}
}

if ( ! function_exists('tgl_indo'))
{
	function tgl_indo($tanggal){
		$bulan = array (
			1 =>   'Januari',
			'Februari',
			'Maret',
			'April',
			'Mei',
			'Juni',
			'Juli',
			'Agustus',
			'September',
			'Oktober',
			'November',
			'Desember'
		);
		$pecahkan = explode('-', $tanggal);
		
		// variabel pecahkan 0 = tanggal
		// variabel pecahkan 1 = bulan
		// variabel pecahkan 2 = tahun
	
		return $pecahkan[2] . ' ' . $bulan[ (int)$pecahkan[1] ] . ' ' . $pecahkan[0];
	}
}

if ( ! function_exists('bulan_indo'))
{
	function bulan_indo($tanggal){
		$bulan = array (
			1 =>   'Januari',
			'Februari',
			'Maret',
			'April',
			'Mei',
			'Juni',
			'Juli',
			'Agustus',
			'September',
			'Oktober',
			'November',
			'Desember'
		);
		$pecahkan = explode('-', $tanggal);
	
		return $bulan[ (int)$pecahkan[1] ];
	}
}
// function untuk menampilkan nama hari ini dalam bahasa indonesia
// di buat oleh malasngoding.com
if ( ! function_exists('hari_indo'))
{
  function hari_indo($tanggal){
    $timestamp = strtotime($tanggal);

		$hari = date('D', $timestamp);

    switch($hari){
      case 'Sun':
        $hari_ind = "Minggu";
      break;

      case 'Mon':			
        $hari_ind = "Senin";
      break;

      case 'Tue':
        $hari_ind = "Selasa";
      break;

      case 'Wed':
        $hari_ind = "Rabu";
      break;

      case 'Thu':
        $hari_ind = "Kamis";
      break;

      case 'Fri':
        $hari_ind = "Jumat";
      break;

      case 'Sat':
        $hari_ind = "Sabtu";
      break;
      
      default:
        $hari_ind = "";		
      break;
    }

    return $hari_ind;

  }
}

if ( ! function_exists('is_empty_return_null'))
{
  function is_empty_return_null($data){
		if (empty($data))
			return null;
		return $data;
	}
}

if ( ! function_exists('terbilang'))
{
  function terbilang($nilai){
		$nilai = abs($nilai);
		$huruf = array("", "satu", "dua", "tiga", "empat", "lima", "enam", "tujuh", "delapan", "sembilan", "sepuluh", "sebelas");
		$temp = "";
		if ($nilai < 12) {
			$temp = " ". $huruf[$nilai];
		} else if ($nilai <20) {
			$temp = terbilang($nilai - 10). " belas";
		} else if ($nilai < 100) {
			$temp = terbilang($nilai/10)." puluh". terbilang($nilai % 10);
		} else if ($nilai < 200) {
			$temp = " seratus" . terbilang($nilai - 100);
		} else if ($nilai < 1000) {
			$temp = terbilang($nilai/100) . " ratus" . terbilang($nilai % 100);
		} else if ($nilai < 2000) {
			$temp = " seribu" . terbilang($nilai - 1000);
		} else if ($nilai < 1000000) {
			$temp = terbilang($nilai/1000) . " ribu" . terbilang($nilai % 1000);
		} else if ($nilai < 1000000000) {
			$temp = terbilang($nilai/1000000) . " juta" . terbilang($nilai % 1000000);
		} else if ($nilai < 1000000000000) {
			$temp = terbilang($nilai/1000000000) . " milyar" . terbilang(fmod($nilai,1000000000));
		} else if ($nilai < 1000000000000000) {
			$temp = terbilang($nilai/1000000000000) . " trilyun" . terbilang(fmod($nilai,1000000000000));
		}     
		return $temp;
	}
}

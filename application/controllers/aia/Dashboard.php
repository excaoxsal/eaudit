<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Dashboard extends MY_Controller
{

    public function __construct()
    {
        parent::__construct();
        $this->load->model('monitoring/m_status_tl', 'm_status_tl');
        $this->load->model('monitoring/m_rekap', 'm_rekap');
		$this->load->model('aia/M_dashboard', 'm_dashboard');
        $this->is_login();
        $this->is_auditor();
        if(!$this->is_auditor()) $this->load->view('/errors/html/err_401');
    }

    public function index()
    {
        $data['menu']       = 'dashboard';
        $data['list_ja']    = $this->master_act->jenis_audit();
        $iso = $this->m_dashboard->getIso();
        $years  = $this->m_status_tl->getYearTl();
        $years_ = (!empty($years)) ? max($years)['TAHUN'] : date('Y');

        $year   = ($this->input->get('year')) ? $this->input->get('year') : $years_;
        $divisi = $this->input->get('auditee');

        $data['list_divisi']    = $this->m_status_tl->getAuditeeTl($year);
        $data['rekap']          = $this->data($year, $divisi);
        //$data['rekom']              = $this->m_status_tl->rekomDashboard($year, $divisi);
        $data['iso']          = $iso;
        $data['years']          = $years;
        $data['year_filter']    = $year;
        $data['auditee']        = $divisi;
        $data['data_table']     = $this->m_status_tl->temuanDashboard($year, $divisi);

        $this->load->view('/content/aia/v_dashboard', $data);
    }

    public function getTemuanData() {
        // Query untuk mendapatkan data kasus dari provinsi di Jawa
        $iso = $this->input->get('iso');
        // var_dump($iso);die;
        if($iso=="ALL"){
            $query = $this->db->query('
            SELECT 
                i."NOMOR_ISO",
                SUM(CASE WHEN t."STATUS" = \'CLOSE\' THEN 1 ELSE 0 END) AS "SUDAH_CLOSED",
                SUM(CASE WHEN t."STATUS" != \'CLOSE\' THEN 1 ELSE 0 END) AS "BELUM_CLOSED"
            FROM 
                "TEMUAN_DETAIL" t
            JOIN 
                "RESPONSE_AUDITEE_H" h ON t."ID_RESPONSE" = h."ID_HEADER"
            right JOIN
                "TM_ISO" i on h."ID_ISO" = i."ID_ISO" 
            GROUP BY 
                i."NOMOR_ISO"
        ');
        }
        else{
            $query = $this->db->query('
            SELECT 
                i."NOMOR_ISO",
                SUM(CASE WHEN t."STATUS" = \'CLOSE\' THEN 1 ELSE 0 END) AS "SUDAH_CLOSED",
                SUM(CASE WHEN t."STATUS" != \'CLOSE\' THEN 1 ELSE 0 END) AS "BELUM_CLOSED"
            FROM 
                "TEMUAN_DETAIL" t
            JOIN 
                "RESPONSE_AUDITEE_H" h ON t."ID_RESPONSE" = h."ID_HEADER"
            right JOIN
                "TM_ISO" i on h."ID_ISO" = i."ID_ISO" 
            WHERE 
                i."ID_ISO" = '.$iso.'
            GROUP BY 
                i."NOMOR_ISO"
        ');
        }

        
        

        // Mengubah hasil query menjadi array
        $data = $query->result_array();
        // var_dump($data);die;

        // Mengirim data dalam format JSON untuk digunakan di chart
        echo json_encode($data);
    }

    public function getTemuanDataDivisi() {
        // Query untuk mendapatkan data kasus dari provinsi di Jawa
        $iso = $this->input->get('iso');
        // var_dump($iso);die;
        $query = $this->db->query('
            SELECT 
                d."NAMA_DIVISI",
                SUM(CASE WHEN t."STATUS" = \'CLOSE\' THEN 1 ELSE 0 END) AS "SUDAH_CLOSED",
                SUM(CASE WHEN t."STATUS" != \'CLOSE\' THEN 1 ELSE 0 END) AS "BELUM_CLOSED"
            FROM 
                "TEMUAN_DETAIL" t
            JOIN 
                "RESPONSE_AUDITEE_H" h ON t."ID_RESPONSE" = h."ID_HEADER"
            right JOIN
                "TM_DIVISI" d on h."DIVISI" = d."KODE_PARENT" 
            GROUP BY 
                d."NAMA_DIVISI"
        ');

        
        

        // Mengubah hasil query menjadi array
        $data = $query->result_array();
        // var_dump($data);die;

        // Mengirim data dalam format JSON untuk digunakan di chart
        echo json_encode($data);
    }

    public function data($year, $divisi)
    {
        $rekap                      = array();
        $grand_total_temuan         = 0;
        $grand_total_rekomendasi    = 0;
        $grand_total_selesai        = 0;
        $grand_total_stl            = 0;
        $grand_total_btl            = 0;
        $grand_total_tptd           = 0;

        $dataEntry          = $this->m_dashboard->getEntryDashboard($year, $divisi);
        $report             = array();
        $i                  = 0;
        $total_temuan       = 0;
        $total_rekomendasi  = 0;
        $total_selesai      = 0;
        $total_stl          = 0;
        $total_btl          = 0;
        $total_tptd         = 0;
        foreach ($dataEntry as $itemEntry) {
            $report['DIVISI']       = $itemEntry['NAMA_DIVISI'];
            $temuan = $this->m_rekap->getTemuan($itemEntry['ID_TL']);
            $report['TEMUAN']       = count($temuan);
            $report['REKOMENDASI']  = 0;
            $report['SELESAI']      = 0;
            $report['STL']          = 0;
            $report['BTL']          = 0;
            $report['TPTD']         = 0;

            $total_rekom    = 0;
            $selesai        = 0;
            $stl            = 0;
            $btl            = 0;
            $tptd           = 0;
            foreach ($temuan as $itemTemuan) {
                $rekomendasi = $this->m_rekap->getRekom($itemTemuan['ID']);
                $total_rekom = $total_rekom + count($rekomendasi);

                foreach ($rekomendasi as $itemRekom) {
                    if ($itemRekom['TK_PENYELESAIAN'] == 'Selesai') $selesai++;
                    if ($itemRekom['TK_PENYELESAIAN'] == 'STL') $stl++;
                    if ($itemRekom['TK_PENYELESAIAN'] == 'BTL') $btl++;
                    if ($itemRekom['TK_PENYELESAIAN'] == 'TPTD') $tptd++;
                }

                $report['REKOMENDASI']  = $total_rekom;
                $report['SELESAI']      = $selesai;
                $report['STL']          = $stl;
                $report['BTL']          = $btl;
                $report['TPTD']         = $tptd;
            }

            $total_temuan       = $total_temuan + count($temuan);
            $total_rekomendasi  = $total_rekomendasi + $total_rekom;
            $total_selesai      = $total_selesai + $selesai;
            $total_stl          = $total_stl + $stl;
            $total_btl          = $total_btl + $btl;
            $total_tptd         = $total_tptd + $tptd;

            array_push($rekap, $report);

            $i++;
        }

        $grand_total = array('TEMUAN' => $total_temuan, 'REKOMENDASI' => $total_rekomendasi, 'SELESAI' => $total_selesai, 'STL' => $total_stl, 'BTL' => $total_btl, 'TPTD' => $total_tptd);

        $temuan         = "";
        $rekomendasi    =  "";
        foreach ($rekap as $item) {
            $temuan .= "['" . $item['DIVISI'] . "', " . $item['TEMUAN'] . "],";
            $rekomendasi .= "['" . $item['DIVISI'] . "', " . $item['REKOMENDASI'] . "],";
        }

        $charts         = array('TEMUAN' => $temuan, 'REKOMENDASI' => $rekomendasi);
        
        // var_dump($rekap,$grand_total,$charts);die;
        return array('REKAP' => $rekap, 'TOTAL' => $grand_total, 'CHARTS' => $charts);
    }
    

}

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
        $data['datatable']      = $this->getTemuanDatatable();
        $data['datatablecabang']      = $this->getTemuanDataTableCabang();
        $data['datadivisi']     = $this->all_divisi();
        $data['datacabang']     = $this->all_cabang();
        $data['temuan_1']       = $this->total_temuan_9001();
        $data['temuan_2']       = $this->total_temuan_14001();
        $data['temuan_3']       = $this->total_temuan_37001();
        $data['temuan_4']       = $this->total_temuan_45001();
        $data['iso']            = $iso;
        $data['years']          = $years;
        $data['year_filter']    = $year;
        $data['auditee']        = $divisi;
        $data['data_table']     = $this->m_status_tl->temuanDashboard($year, $divisi);
        // var_dump($eldata);die;
        $this->load->view('/content/aia/v_dashboard', $data);
    }
    public function all_divisi()
    {
        $this->db->select('KODE');
        $this->db->from('TM_DIVISI');
        $this->db->where('IS_CABANG','N');
        $this->db->where('IS_DIVISI', 'Y');
        $this->db->order_by('COUNT','ASC');
        $query=$this->db->get();
        return $query->result_array();
    }
    public function all_cabang()
    {
        $this->db->select('KODE');
        $this->db->from('TM_DIVISI');
        $this->db->where('IS_CABANG','Y');
        $this->db->where('IS_DIVISI', 'Y');
        $this->db->order_by('NAMA_DIVISI','ASC');
        $query=$this->db->get();
        return $query->result_array();
    }

    public function total_temuan_9001(){
        $this->db->select('SUM(counts.count_temuans) AS "TOTALALL"')
                ->from('(SELECT COUNT(t."ID_TEMUAN") AS count_temuans 
                        FROM "TEMUAN_DETAIL" t 
                        LEFT JOIN "RESPONSE_AUDITEE_H" h ON t."ID_RESPONSE" = h."ID_HEADER" 
                        JOIN "TM_DIVISI" d ON d."KODE" = t."SUB_DIVISI" 
                        JOIN "TM_ISO" i ON i."ID_ISO" = h."ID_ISO" 
                        WHERE d."IS_CABANG" = \'N\' AND i."ID_ISO" = 1 
                        GROUP BY d."COUNT", t."SUB_DIVISI", d."NAMA_DIVISI", d."KODE_PARENT", i."NOMOR_ISO", t."ID_RESPONSE" 
                        HAVING t."SUB_DIVISI" IS NOT NULL) AS counts', false);

        $query = $this->db->get();
        $result = $query->result_array();
        // var_dump($result['0']['TOTALALL']);die;
        return $result;
    }
    public function total_temuan_14001(){
        $this->db->select('SUM(counts.count_temuans) AS "TOTALALL"')
                ->from('(SELECT COUNT(t."ID_TEMUAN") AS count_temuans 
                        FROM "TEMUAN_DETAIL" t 
                        LEFT JOIN "RESPONSE_AUDITEE_H" h ON t."ID_RESPONSE" = h."ID_HEADER" 
                        JOIN "TM_DIVISI" d ON d."KODE" = t."SUB_DIVISI" 
                        JOIN "TM_ISO" i ON i."ID_ISO" = h."ID_ISO" 
                        WHERE d."IS_CABANG" = \'N\' AND i."ID_ISO" = 2 
                        GROUP BY d."COUNT", t."SUB_DIVISI", d."NAMA_DIVISI", d."KODE_PARENT", i."NOMOR_ISO", t."ID_RESPONSE" 
                        HAVING t."SUB_DIVISI" IS NOT NULL) AS counts', false);

        $query = $this->db->get();
        $result = $query->result_array();
        // var_dump($result['0']['TOTALALL']);die;
        return $result;
    }
    public function total_temuan_37001(){
        $this->db->select('SUM(counts.count_temuans) AS "TOTALALL"')
                ->from('(SELECT COUNT(t."ID_TEMUAN") AS count_temuans 
                        FROM "TEMUAN_DETAIL" t 
                        LEFT JOIN "RESPONSE_AUDITEE_H" h ON t."ID_RESPONSE" = h."ID_HEADER" 
                        JOIN "TM_DIVISI" d ON d."KODE" = t."SUB_DIVISI" 
                        JOIN "TM_ISO" i ON i."ID_ISO" = h."ID_ISO" 
                        WHERE d."IS_CABANG" = \'N\' AND i."ID_ISO" = 3 
                        GROUP BY d."COUNT", t."SUB_DIVISI", d."NAMA_DIVISI", d."KODE_PARENT", i."NOMOR_ISO", t."ID_RESPONSE" 
                        HAVING t."SUB_DIVISI" IS NOT NULL) AS counts', false);

        $query = $this->db->get();
        $result = $query->result_array();
        return $result;
    }
    public function total_temuan_45001(){
        $this->db->select('SUM(counts.count_temuans) AS "TOTALALL"')
                ->from('(SELECT COUNT(t."ID_TEMUAN") AS count_temuans 
                        FROM "TEMUAN_DETAIL" t 
                        LEFT JOIN "RESPONSE_AUDITEE_H" h ON t."ID_RESPONSE" = h."ID_HEADER" 
                        JOIN "TM_DIVISI" d ON d."KODE" = t."SUB_DIVISI" 
                        JOIN "TM_ISO" i ON i."ID_ISO" = h."ID_ISO" 
                        WHERE d."IS_CABANG" = \'N\' AND i."ID_ISO" = 4 
                        GROUP BY d."COUNT", t."SUB_DIVISI", d."NAMA_DIVISI", d."KODE_PARENT", i."NOMOR_ISO", t."ID_RESPONSE" 
                        HAVING t."SUB_DIVISI" IS NOT NULL) AS counts', false);

        $query = $this->db->get();
        $result = $query->result_array();
        return $result;
    }

    public function getTemuanDataIso() {
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

    public function getTemuanDataTable()
    {
        // header('Content-type: application/json');
        // Ambil data dari model
        $data_temuan = $this->m_dashboard->getTemuanByDivisi();
        // $data_sub = $this->m_dashboard->getSubDivisi();
        // var_dump($data_temuan);die;
        // Kirim data dalam format JSON
        return($data_temuan);
    }


    public function getTemuanDataTableCabang()
    {
        // header('Content-type: application/json');
        // Ambil data dari model
        $data_temuan = $this->m_dashboard->getTemuanbyCabang();
        // $data_sub = $this->m_dashboard->getSubDivisi();
        // var_dump($data_temuan);die;
        // Kirim data dalam format JSON
        return($data_temuan);
    }

    public function getTemuanDataDivisi() {
        // Query untuk mendapatkan data kasus dari provinsi di Jawa
        $iso = $this->input->get('iso');
        // var_dump($iso);die;
        $query = $this->db->query('
            SELECT 
                d."KODE",
                SUM(CASE WHEN t."STATUS" = \'CLOSE\' THEN 1 ELSE 0 END) AS "SUDAH_CLOSED",
                SUM(CASE WHEN t."STATUS" != \'CLOSE\' THEN 1 ELSE 0 END) AS "BELUM_CLOSED"
            FROM 
                "TEMUAN_DETAIL" t
            right JOIN 
                "RESPONSE_AUDITEE_H" h ON t."ID_RESPONSE" = h."ID_HEADER"
            left JOIN
                "TM_DIVISI" d on h."DIVISI" = d."KODE" 
            where d."IS_CABANG" = \'N\' and d."IS_DIVISI" = \'Y\' and h."ID_ISO" =1
            GROUP BY 
                d."COUNT",d."KODE"
        ');
        // Mengubah hasil query menjadi array
        $data = $query->result_array();
        // var_dump($data);die;

        // Mengirim data dalam format JSON untuk digunakan di chart
        echo json_encode($data);
    }
    public function getTemuanDataDivisi1() {
        // Query untuk mendapatkan data kasus dari provinsi di Jawa
        $iso = $this->input->get('iso');
        // var_dump($iso);die;
        $query = $this->db->query('
            SELECT 
                d."KODE",
                SUM(CASE WHEN t."STATUS" = \'CLOSE\' THEN 1 ELSE 0 END) AS "SUDAH_CLOSED",
                SUM(CASE WHEN t."STATUS" != \'CLOSE\' THEN 1 ELSE 0 END) AS "BELUM_CLOSED"
            FROM 
                "TEMUAN_DETAIL" t
            right JOIN 
                "RESPONSE_AUDITEE_H" h ON t."ID_RESPONSE" = h."ID_HEADER"
            left JOIN
                "TM_DIVISI" d on h."DIVISI" = d."KODE" 
            where d."IS_CABANG" = \'N\' and d."IS_DIVISI" = \'Y\' and h."ID_ISO" =2
            GROUP BY 
               d."COUNT", d."KODE"
        ');
        // Mengubah hasil query menjadi array
        $data = $query->result_array();
        // var_dump($data);die;

        // Mengirim data dalam format JSON untuk digunakan di chart
        echo json_encode($data);
    }
    public function getTemuanDataDivisi2() {
        // Query untuk mendapatkan data kasus dari provinsi di Jawa
        $iso = $this->input->get('iso');
        // var_dump($iso);die;
        $query = $this->db->query('
            SELECT 
                d."KODE",
                SUM(CASE WHEN t."STATUS" = \'CLOSE\' THEN 1 ELSE 0 END) AS "SUDAH_CLOSED",
                SUM(CASE WHEN t."STATUS" != \'CLOSE\' THEN 1 ELSE 0 END) AS "BELUM_CLOSED"
            FROM 
                "TEMUAN_DETAIL" t
            right JOIN 
                "RESPONSE_AUDITEE_H" h ON t."ID_RESPONSE" = h."ID_HEADER"
            left JOIN
                "TM_DIVISI" d on h."DIVISI" = d."KODE" 
            where d."IS_CABANG" = \'N\' and d."IS_DIVISI" = \'Y\' and h."ID_ISO" =3
            GROUP BY 
               d."COUNT", d."KODE"
        ');
        // Mengubah hasil query menjadi array
        $data = $query->result_array();
        // var_dump($data);die;

        // Mengirim data dalam format JSON untuk digunakan di chart
        echo json_encode($data);
    }
    public function getTemuanDataDivisi3() {
        // Query untuk mendapatkan data kasus dari provinsi di Jawa
        $iso = $this->input->get('iso');
        // var_dump($iso);die;
        $query = $this->db->query('
            SELECT 
                d."KODE",
                SUM(CASE WHEN t."STATUS" = \'CLOSE\' THEN 1 ELSE 0 END) AS "SUDAH_CLOSED",
                SUM(CASE WHEN t."STATUS" != \'CLOSE\' THEN 1 ELSE 0 END) AS "BELUM_CLOSED"
            FROM 
                "TEMUAN_DETAIL" t
            right JOIN 
                "RESPONSE_AUDITEE_H" h ON t."ID_RESPONSE" = h."ID_HEADER"
            left JOIN
                "TM_DIVISI" d on h."DIVISI" = d."KODE" 
            where d."IS_CABANG" = \'N\' and d."IS_DIVISI" = \'Y\' and h."ID_ISO" =4
            GROUP BY 
               d."COUNT", d."KODE"
        ');
        // Mengubah hasil query menjadi array
        $data = $query->result_array();
        // var_dump($data);die;

        // Mengirim data dalam format JSON untuk digunakan di chart
        echo json_encode($data);
    }


    public function getTemuanDataCabang() {
        // Query untuk mendapatkan data kasus dari provinsi di Jawa
        $iso = $this->input->get('iso');
        // var_dump($iso);die;
        $query = $this->db->query('
            SELECT 
                d."KODE",
                SUM(CASE WHEN t."STATUS" = \'CLOSE\' THEN 1 ELSE 0 END) AS "SUDAH_CLOSED",
                SUM(CASE WHEN t."STATUS" != \'CLOSE\' THEN 1 ELSE 0 END) AS "BELUM_CLOSED"
            FROM 
                "TEMUAN_DETAIL" t
            right JOIN 
                "RESPONSE_AUDITEE_H" h ON t."ID_RESPONSE" = h."ID_HEADER"
            left JOIN
                "TM_DIVISI" d on h."DIVISI" = d."KODE" 
            where d."IS_CABANG" = \'Y\' and d."IS_DIVISI" = \'Y\' and h."ID_ISO" =1
            GROUP BY 
                d."KODE"
        ');

        
        

        // Mengubah hasil query menjadi array
        $data = $query->result_array();
        // var_dump($data);die;

        // Mengirim data dalam format JSON untuk digunakan di chart
        echo json_encode($data);
    }
    public function getTemuanDataCabang1() {
        // Query untuk mendapatkan data kasus dari provinsi di Jawa
        $iso = $this->input->get('iso');
        // var_dump($iso);die;
        $query = $this->db->query('
            SELECT 
                d."KODE",
                SUM(CASE WHEN t."STATUS" = \'CLOSE\' THEN 1 ELSE 0 END) AS "SUDAH_CLOSED",
                SUM(CASE WHEN t."STATUS" != \'CLOSE\' THEN 1 ELSE 0 END) AS "BELUM_CLOSED"
            FROM 
                "TEMUAN_DETAIL" t
            right JOIN 
                "RESPONSE_AUDITEE_H" h ON t."ID_RESPONSE" = h."ID_HEADER"
            left JOIN
                "TM_DIVISI" d on h."DIVISI" = d."KODE" 
            where d."IS_CABANG" = \'Y\' and d."IS_DIVISI" = \'Y\' and h."ID_ISO" =2
            GROUP BY 
                d."KODE"
        ');

        
        

        // Mengubah hasil query menjadi array
        $data = $query->result_array();
        // var_dump($data);die;

        // Mengirim data dalam format JSON untuk digunakan di chart
        echo json_encode($data);
    }
    public function getTemuanDataCabang2() {
        // Query untuk mendapatkan data kasus dari provinsi di Jawa
        $iso = $this->input->get('iso');
        // var_dump($iso);die;
        $query = $this->db->query('
            SELECT 
                d."KODE",
                SUM(CASE WHEN t."STATUS" = \'CLOSE\' THEN 1 ELSE 0 END) AS "SUDAH_CLOSED",
                SUM(CASE WHEN t."STATUS" != \'CLOSE\' THEN 1 ELSE 0 END) AS "BELUM_CLOSED"
            FROM 
                "TEMUAN_DETAIL" t
            right JOIN 
                "RESPONSE_AUDITEE_H" h ON t."ID_RESPONSE" = h."ID_HEADER"
            left JOIN
                "TM_DIVISI" d on h."DIVISI" = d."KODE" 
            where d."IS_CABANG" = \'Y\' and d."IS_DIVISI" = \'Y\' and h."ID_ISO" =3
            GROUP BY 
                d."KODE"
        ');

        
        

        // Mengubah hasil query menjadi array
        $data = $query->result_array();
        // var_dump($data);die;

        // Mengirim data dalam format JSON untuk digunakan di chart
        echo json_encode($data);
    }
    public function getTemuanDataCabang3() {
        // Query untuk mendapatkan data kasus dari provinsi di Jawa
        $iso = $this->input->get('iso');
        // var_dump($iso);die;
        $query = $this->db->query('
            SELECT 
                d."KODE",
                SUM(CASE WHEN t."STATUS" = \'CLOSE\' THEN 1 ELSE 0 END) AS "SUDAH_CLOSED",
                SUM(CASE WHEN t."STATUS" != \'CLOSE\' THEN 1 ELSE 0 END) AS "BELUM_CLOSED"
            FROM 
                "TEMUAN_DETAIL" t
            right JOIN 
                "RESPONSE_AUDITEE_H" h ON t."ID_RESPONSE" = h."ID_HEADER"
            left JOIN
                "TM_DIVISI" d on h."DIVISI" = d."KODE" 
            where d."IS_CABANG" = \'Y\' and d."IS_DIVISI" = \'Y\' and h."ID_ISO" =4
            GROUP BY 
                d."KODE"
        ');

        
        

        // Mengubah hasil query menjadi array
        $data = $query->result_array();
        // var_dump($data);die;

        // Mengirim data dalam format JSON untuk digunakan di chart
        echo json_encode($data);
    }

    public function getReportData() {
        // Query untuk mendapatkan data
        $query = $this->db->query('
            SELECT 
                COUNT("ID_TEMUAN") AS total_semua,
                (SELECT COUNT("ID_TEMUAN") FROM "TEMUAN_DETAIL" td 
                    LEFT JOIN "RESPONSE_AUDITEE_H" rah ON rah."ID_HEADER" = td."ID_RESPONSE" 
                    LEFT JOIN "TM_DIVISI" td2 ON td2."KODE" = rah."DIVISI"
                    WHERE td2."IS_CABANG" = \'Y\') AS total_cabang,
                (SELECT COUNT("ID_TEMUAN") FROM "TEMUAN_DETAIL" td 
                    LEFT JOIN "RESPONSE_AUDITEE_H" rah ON rah."ID_HEADER" = td."ID_RESPONSE" 
                    LEFT JOIN "TM_DIVISI" td2 ON td2."KODE" = rah."DIVISI"
                    WHERE td2."IS_CABANG" = \'N\') AS total_pusat,
                (SELECT COUNT("ID_TEMUAN") FROM "TEMUAN_DETAIL" td 
                    LEFT JOIN "RESPONSE_AUDITEE_H" rah ON rah."ID_HEADER" = td."ID_RESPONSE" 
                    LEFT JOIN "TM_DIVISI" td2 ON td2."KODE" = rah."DIVISI"
                    WHERE rah."ID_ISO" = 1 AND td2."IS_CABANG" = \'N\') AS total_divisi_iso1,
                (SELECT COUNT("ID_TEMUAN") FROM "TEMUAN_DETAIL" td 
                    LEFT JOIN "RESPONSE_AUDITEE_H" rah ON rah."ID_HEADER" = td."ID_RESPONSE" 
                    LEFT JOIN "TM_DIVISI" td2 ON td2."KODE" = rah."DIVISI"
                    WHERE rah."ID_ISO" = 2 AND td2."IS_CABANG" = \'N\') AS total_divisi_iso2,
                (SELECT COUNT("ID_TEMUAN") FROM "TEMUAN_DETAIL" td 
                    LEFT JOIN "RESPONSE_AUDITEE_H" rah ON rah."ID_HEADER" = td."ID_RESPONSE" 
                    LEFT JOIN "TM_DIVISI" td2 ON td2."KODE" = rah."DIVISI"
                    WHERE rah."ID_ISO" = 3 AND td2."IS_CABANG" = \'N\') AS total_divisi_iso3,
                (SELECT COUNT("ID_TEMUAN") FROM "TEMUAN_DETAIL" td 
                    LEFT JOIN "RESPONSE_AUDITEE_H" rah ON rah."ID_HEADER" = td."ID_RESPONSE" 
                    LEFT JOIN "TM_DIVISI" td2 ON td2."KODE" = rah."DIVISI"
                    WHERE rah."ID_ISO" = 4 AND td2."IS_CABANG" = \'N\') AS total_divisi_iso4,
                (SELECT COUNT("ID_TEMUAN") FROM "TEMUAN_DETAIL" td 
                    LEFT JOIN "RESPONSE_AUDITEE_H" rah ON rah."ID_HEADER" = td."ID_RESPONSE" 
                    LEFT JOIN "TM_DIVISI" td2 ON td2."KODE" = rah."DIVISI"
                    WHERE rah."ID_ISO" = 1 AND td2."IS_CABANG" = \'Y\') AS total_cabang_iso1,
                (SELECT COUNT("ID_TEMUAN") FROM "TEMUAN_DETAIL" td 
                    LEFT JOIN "RESPONSE_AUDITEE_H" rah ON rah."ID_HEADER" = td."ID_RESPONSE" 
                    LEFT JOIN "TM_DIVISI" td2 ON td2."KODE" = rah."DIVISI"
                    WHERE rah."ID_ISO" = 2 AND td2."IS_CABANG" = \'Y\') AS total_cabang_iso2,
                (SELECT COUNT("ID_TEMUAN") FROM "TEMUAN_DETAIL" td 
                    LEFT JOIN "RESPONSE_AUDITEE_H" rah ON rah."ID_HEADER" = td."ID_RESPONSE" 
                    LEFT JOIN "TM_DIVISI" td2 ON td2."KODE" = rah."DIVISI"
                    WHERE rah."ID_ISO" = 3 AND td2."IS_CABANG" = \'Y\') AS total_cabang_iso3,
                (SELECT COUNT("ID_TEMUAN") FROM "TEMUAN_DETAIL" td 
                    LEFT JOIN "RESPONSE_AUDITEE_H" rah ON rah."ID_HEADER" = td."ID_RESPONSE" 
                    LEFT JOIN "TM_DIVISI" td2 ON td2."KODE" = rah."DIVISI"
                    WHERE rah."ID_ISO" = 4 AND td2."IS_CABANG" = \'Y\') AS total_cabang_iso4
            FROM "TEMUAN_DETAIL" td
        ');

        // Mengambil hasil query
        $result = $query->row_array();

        // Mengatur header untuk JSON
        $this->output
            ->set_content_type('application/json')
            ->set_output(json_encode($result));
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

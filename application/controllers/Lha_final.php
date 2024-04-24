<?php
defined('BASEPATH') OR exit('No direct script access allowed');
require_once FCPATH.'vendor/autoload.php';
use PhpOffice\PhpWord\PhpWord;
class Lha_final extends MY_Controller {
    public function __construct(){
        parent::__construct();
        $this->load->model('monitoring/m_status_tl', 'm_status_tl');
        if(!$this->is_auditor()) $this->load->view('/errors/html/err_401');
    }

    private function getJudul($judul)
    {
        if($judul==1)
            return '';
        elseif($judul==2)
            return 'Jakarta, ';
        elseif($judul==3)
            return 'Daftar Isi';
        elseif($judul==4)
            return 'Ringkasan Eksekutif';
        elseif($judul==5)
            return 'Ringkasan Temuan dan Rekomendasi Audit';
        elseif($judul==6)
            return 'Ringkasan Hal-hal yang Perlu Diperhatikan';
        elseif($judul==7)
            return 'Lampiran 1: Rincian Temuan dan Rekomendasi Audit';
        elseif($judul==8)
            return 'Lampiran 2: Rincian Hal-hal yang Perlu Diperhatikan';
        elseif($judul==9)
            return 'Lampiran 3: Definisi Istilah';
        elseif($judul==10)
            return 'Lampiran 3: Surat Perintah Audit (Copy)';
    }

    public function print(){
        $id_tl          = $this->input->get('id');
        $id_tl          = base64_decode($id_tl);

        $header         = $this->db->select('te.TAHUN, te.AUDITEE, div.NAMA_DIVISI, te.TGL_PERIODE_MULAI, te.TGL_PERIODE_SELESAI, te.TANGGAL_LHA, te.NOMOR_LHA')
                            ->from('TL_ENTRY te')
                            ->join('TM_DIVISI div', 'te.AUDITEE = div.ID_DIVISI', 'LEFT')
                            ->where('te.ID_TL', $id_tl)
                            ->get()->row();
        $tahun          = $header->TAHUN;
        $id_divisi      = $header->AUDITEE;
        $id_jenis_audit = $header->ID_JENIS_AUDIT;
        $status                 = base64_decode($this->input->get('s'));
        $div_pic                = base64_decode($this->input->get('p'));

        $rekomendasi            = $this->m_status_tl->temuan_data($tahun, $id_divisi, $id_jenis_audit, $status, $div_pic);
        // $perhatian              = $this->db->order_by('NO_URUT', 'ASC')->get_where('TL_PERHATIAN', ['ID_TL' => $id_tl, 'STATUS' => 1])->result_array();
        $perhatian              = $this->db->select('P.*, J.NAMA_JABATAN')
                                    ->from('TL_PERHATIAN P')
                                    ->join('TM_JABATAN J', 'J.ID_JABATAN = P.PIC')
                                    ->where('P.STATUS', 1)
                                    ->where('P.ID_TL', $id_tl)
                                    ->order_by('NO_URUT', 'ASC')
                                    ->get()->result_array();

        $jenis_audit = $this->master_act->jenis_audit($id_jenis_audit);
        $jenis_audit = strpos(strtoupper($jenis_audit[0]['JENIS_AUDIT']), 'INTERNAL') !== false ? 'INTERNAL' : 'EXTERNAL';

        $phpWord        = new \PhpOffice\PhpWord\PhpWord();
        $phpWord->setDefaultFontName('Gotham-Book');
        $section_cover  = $phpWord->addSection(array('orientation' => 'landscape'));
        // $section_1      = $phpWord->addSection(array('orientation' => 'landscape'));
        $section_2      = $phpWord->addSection(array('orientation' => 'landscape'));
        $section_3      = $phpWord->addSection(array('orientation' => 'landscape'));
        $section_4      = $phpWord->addSection(array('orientation' => 'landscape'));
        $section_5      = $phpWord->addSection(array('orientation' => 'landscape'));
        $section_6      = $phpWord->addSection(array('orientation' => 'landscape'));
        $section_7      = $phpWord->addSection(array('orientation' => 'landscape'));
        $section_8      = $phpWord->addSection(array('orientation' => 'landscape'));
        $section_9      = $phpWord->addSection(array('orientation' => 'landscape'));
        $section_10     = $phpWord->addSection(array('orientation' => 'landscape'));

        // start cover
        $header_cover   = $section_cover->createHeader();

        $section_cover->addImage(FCPATH.'assets/img/logos/ptp.png',
                             array(
                                'height' => 50,
                                'positioning' => \PhpOffice\PhpWord\Style\Image::POSITION_ABSOLUTE,
                                'posHorizontal' => \PhpOffice\PhpWord\Style\Image::POSITION_ABSOLUTE,
                                'posVertical' => \PhpOffice\PhpWord\Style\Image::POSITION_ABSOLUTE,
                                'marginLeft' => -25,
                                'marginTop' => -40
                            ));

        $section_cover->addImage(FCPATH.'assets/img/bg/header-removebg-preview.png',
                             array(
                                'width' => 700,
                                'align' => 'center',
                                'positioning' => \PhpOffice\PhpWord\Style\Image::POSITION_ABSOLUTE,
                                'posHorizontal' => \PhpOffice\PhpWord\Style\Image::POSITION_ABSOLUTE,
                                'posVertical' => \PhpOffice\PhpWord\Style\Image::POSITION_ABSOLUTE,
                                'marginLeft' => -350,
                            ));
        $cover      = '<div style="text-align: center;"><b style="font-size: 35px;">Laporan Hasil Audit Rutin</b>';
        $cover      .= '<b style="font-size: 25px;">PT PELABUHAN TANJUNG PRIOK</b>';
        $cover      .= '<b style="font-size: 25px;">'.$header->NAMA_DIVISI.'</b>';
        $cover      .= '<b style="font-size: 25px;">Tahun '.$header->TAHUN.'</b><p></p><p></p><p></p></div>';

        $cover_dis  = '<p></p><p></p><table width="100%">
                        <tr>
                            <td colspan="2" style="font-size: 16px; font-weight: bold;">Distribusi Laporan Hasil Audit:</td>
                        </tr>
                        <tr>
                            <td width="2%">☐</td>
                            <td width="95%">Direktur Utama PT Pelabuhan Tanjung Priok</td>
                        </tr>
                        <tr>
                            <td width="2%">☐</td>
                            <td width="95%">Dewan Komisaris PT Pelabuhan Tanjung Priok c.q Komite Audit</td>
                        </tr>
                        <tr>
                            <td width="2%">☐</td>
                            <td width="95%"><i>Branch Manager</i> PT Pelabuhan Tanjung Priok '.$header->NAMA_DIVISI.'</td>
                        </tr>
                        <tr>
                            <td width="2%">☐</td>
                            <td width="95%">Arsip</td>
                        </tr>
                        </table>';

        \PhpOffice\PhpWord\Settings::setOutputEscapingEnabled(true);
        \PhpOffice\PhpWord\Shared\Html::addHtml($section_cover, $cover);
        $section_cover->addImage(FCPATH.'assets/img/bg/border-removebg-preview.png',
                             array(
                                'width' => 600,
                                'align' => 'center',
                                'positioning' => \PhpOffice\PhpWord\Style\Image::POSITION_ABSOLUTE,
                                'posHorizontal' => \PhpOffice\PhpWord\Style\Image::POSITION_ABSOLUTE,
                                'posVertical' => \PhpOffice\PhpWord\Style\Image::POSITION_ABSOLUTE,
                                'marginLeft' => -250,
                            ));
        \PhpOffice\PhpWord\Shared\Html::addHtml($section_cover, $cover_dis);

        $section_cover->addPageBreak();
        // end cover


        // start pengantar
        $header_2   = $section_2->createHeader();

        $header_2->addText($this->getJudul(2).tgl_indo($header->TANGGAL_LHA));
        $header_2->addPreserveText('Halaman {PAGE} dari {NUMPAGES}.', array("size" => 10, "name" => 'Arial'), array('align'  => 'right'));
        $header_2->addImage(FCPATH.'assets/img/bg/border-header.png',
                             array(
                                'width' => 740,
                                'align' => 'center',
                                'positioning' => \PhpOffice\PhpWord\Style\Image::POSITION_ABSOLUTE,
                                'posHorizontal' => \PhpOffice\PhpWord\Style\Image::POSITION_ABSOLUTE,
                                'posVertical' => \PhpOffice\PhpWord\Style\Image::POSITION_ABSOLUTE,
                                'marginLeft' => -370,
                                'marginTop' => -60
                            ));
        $pengantar  = '<div style="font-size: 16px; text-align: justify;"><article>Kepada Yth.</article>';
        $pengantar  .= '<b style="font-size: 18px;">Direktur Utama PT Pelabuhan Tanjung Priok</b><p></p>';
        $pengantar  .= '<u><b>Perihal : Laporan Hasil Audit Rutin PT Pelabuhan Tanjung Priok (PTP) '.$header->NAMA_DIVISI.'</b></u>';
        $pengantar  .= '<p></p>';
        $pengantar  .= '<p>Kami telah melakukan audit rutin pada '.$header->NAMA_DIVISI.' untuk periode audit '.tgl_indo($header->TGL_PERIODE_MULAI).' sampai dengan tanggal '.tgl_indo($header->TGL_PERIODE_SELESAI).'. Proses audit tersebut dilaksanakan dari tanggal 2 Februari sampai dengan tanggal 2 Maret 2022, dengan hasil audit sebagaimana kami sajikan pada laporan ini.</p>';
        $pengantar  .= '<p>Tujuan audit, ruang lingkup audit dan prosedur audit yang telah dilakukan kami rangkum dalam Ringkasan Eksekutif dari laporan ini.</p>';
        $pengantar  .= '<p>Seluruh hasil audit dan rekomendasi telah kami bahas dan disepakati oleh auditi dan Person In Charge (PIC) terkait.</p>';
        $pengantar  .= '<p>Kami mengucapkan terima kasih kepada Branch Manager '.$header->NAMA_DIVISI.' beserta staf atas kerja samanya selama pelaksanaan audit.</p>';
        $pengantar  .= '<p>Demikian kami sampaikan atas perhatiannya kami ucapkan terima kasih</p>';
        $pengantar  .= '<p></p>';
        $pengantar  .= '<p>Hormat kami,</p>';
        $pengantar  .= '<p></p>';
        $pengantar  .= '<u><b>Edy Setyo Rahardjo</b></u>';
        $pengantar  .= '<p>SM Pengawasan Internal & Hukum</p></div>';
        \PhpOffice\PhpWord\Shared\Html::addHtml($section_2, $pengantar);

        $section_2->addPageBreak();
        // end pengantar

        // start daftar isi
        $header_3   = $section_3->createHeader();

        $header_3->addText($this->getJudul(3));
        $header_3->addPreserveText('Halaman {PAGE} dari {NUMPAGES}.', array("size" => 10, "name" => 'Arial'), array('align'  => 'right'));
        $header_3->addImage(FCPATH.'assets/img/bg/border-header.png',
                             array(
                                'width' => 740,
                                'align' => 'center',
                                'positioning' => \PhpOffice\PhpWord\Style\Image::POSITION_ABSOLUTE,
                                'posHorizontal' => \PhpOffice\PhpWord\Style\Image::POSITION_ABSOLUTE,
                                'posVertical' => \PhpOffice\PhpWord\Style\Image::POSITION_ABSOLUTE,
                                'marginLeft' => -370,
                                'marginTop' => -60
                            ));

        $daftar_isi = '<p style="color: #CC9900"><b>Daftar Isi</b></p>';
        $daftar_isi .= '<p style="color: #CC9900"><b>Ringkasan Eksekutif</b></p>';
        $daftar_isi .= '<p style="color: #CC9900"><b>Ringkasan Temuan dan Rekomendasi Audit</b></p>';
        $daftar_isi .= '<ol>';
        foreach ($rekomendasi as $key => $item) {
            $daftar_isi .= '<li>'.$item['JUDUL_TEMUAN'].'</li>';
        }
        $daftar_isi .= '</ol>';
        $daftar_isi .= '<p style="color: #CC9900"><b>Ringkasan Hal-hal yang Perlu Diperhatikan</b></p>';
        $daftar_isi .= '<ol>';
        foreach ($perhatian as $key => $item) {
            $daftar_isi .= '<li>'.$item['JUDUL_OBSERVASI'].'</li>';
        }
        $daftar_isi .= '</ol>';
        $daftar_isi .= '<p style="color: #CC9900"><b>Lampiran:</b></p>';
        $daftar_isi .= '<ol>';
        $daftar_isi .= '<li>Rincian Temuan dan Rekomendasi Audit</li>';
        $daftar_isi .= '<li>Rincian Hal-hal yang Perlu Diperhatikan</li>';
        $daftar_isi .= '<li>Definisi Istilah</li>';
        $daftar_isi .= '<li><i>Copy</i> Surat Perintah Audit</li>';
        $daftar_isi .= '</ol>';
        \PhpOffice\PhpWord\Shared\Html::addHtml($section_3, $daftar_isi);

        $section_3->addPageBreak();
        // end daftar isi

        // start ringkasan eksekutif
        $header_4   = $section_4->createHeader();

        $header_4->addText($this->getJudul(4));
        $header_4->addPreserveText('Halaman {PAGE} dari {NUMPAGES}.', array("size" => 10, "name" => 'Arial'), array('align'  => 'right'));
        $header_4->addImage(FCPATH.'assets/img/bg/border-header.png',
                             array(
                                'width' => 740,
                                'align' => 'center',
                                'positioning' => \PhpOffice\PhpWord\Style\Image::POSITION_ABSOLUTE,
                                'posHorizontal' => \PhpOffice\PhpWord\Style\Image::POSITION_ABSOLUTE,
                                'posVertical' => \PhpOffice\PhpWord\Style\Image::POSITION_ABSOLUTE,
                                'marginLeft' => -370,
                                'marginTop' => -60
                            ));

        $styleTable     = array('cellMarginRight' => 100, 'cellMarginTop' => 100, 'cellMarginLeft' => 100, 'align' => 'center');
        $titleCell      = array('valign' => 'center', 'bgColor' => 'black');
        $fontStyle      = array('bold' => true, 'valign' => 'center', 'color' => 'white');
        $phpWord->addTableStyle('tabel ringkasan eksekutif', $styleTable);
        $table = $section_4->addTable('tabel ringkasan eksekutif');
        $table->addRow(100, array('tblHeader' => true));
        $table->addCell(7000, $titleCell)->addText(('Tujuan Audit'), $fontStyle, array('align' => 'left'));
        $table->addCell(200)->addText('');
        $table->addCell(6000, $titleCell)->addText(('Ruang Lingkup Audit'), $fontStyle, array('align' => 'left'));

            $table->addRow();
            $tujuan_audit = '<table width="100%" style="font-weight: bold; font-style: italic;"> 
                                    <tr>
                                        <td width="5%">1.</td>
                                        <td width="95%" style="text-align: justify;">Memberikan penilaian atas penerapan prinsip-prinsip pokok pengendalian internal terhadap pengelolaan PT PTP '.$header->NAMA_DIVISI.' yang mencakup pengelolaan aspek-aspek finansial/komersial, operasional dan legal/ governance.</td>
                                    </tr>
                                    <tr>
                                        <td width="5%">2.</td>
                                        <td width="95%" style="text-align: justify;">Memberikan penilaian atas pelaksanaan SOP perusahaan untuk meyakinkan bahwa SOP telah menjadi acuan dalam pelaksanaan kegiatan dan SOP yang ada telah memadai.</td>
                                    </tr>
                                    <tr>
                                        <td width="5%">3.</td>
                                        <td width="95%" style="text-align: justify;">Memberikan rekomendasi perbaikan atas kebijakan pengelolaan PT PTP '.$header->NAMA_DIVISI.' yang mencakup aspek Tata kelola (Governance), Manajemen Risiko (Risk), dan Pengendalian internal (Control).</td>
                                    </tr>
                                    </table>';
            $ruang_lingkup = '<table width="100%" style="font-weight: bold; font-style: italic;"> 
                                    <tr>
                                        <td colspan="2">Ruang lingkup audit :</td>
                                    </tr>
                                    <tr>
                                        <td width="5%">•</td>
                                        <td width="95%" style="text-align: justify;">Ruang lingkup audit adalah seluruh aktivitas pengelolaan PT PTP '.$header->NAMA_DIVISI.' yang meliputi pengelolaan aspek-aspek finansial, komersial, operasional dan legal/governance</td>
                                    </tr>
                                    <tr>
                                        <td colspan="2">Periode yang diaudit :</td>
                                    </tr>
                                    <tr>
                                        <td width="5%">•</td>
                                        <td width="95%" style="text-align: justify;">Periode yang diaudit adalah tanggal '.tgl_indo($header->TGL_PERIODE_MULAI).' sampai dengan tanggal '.tgl_indo($header->TGL_PERIODE_SELESAI).'</td>
                                    </tr>
                                    </table>';
            $cell_ta      = $table->addCell(7000);
            \PhpOffice\PhpWord\Shared\Html::addHtml($cell_ta, "{$tujuan_audit}",false,false,null);
            $table->addCell(200)->addText('');
            $cell_rl      = $table->addCell(6000);
            \PhpOffice\PhpWord\Shared\Html::addHtml($cell_rl, "{$ruang_lingkup}",false,false,null);

        $table->addRow(100, array('tblHeader' => true));
        $table->addCell(7000, $titleCell)->addText(('Ringkasan Prosedur Audit yang Dilakukan'), $fontStyle, array('align' => 'left'));
        $table->addCell(200)->addText('');
        $table->addCell(6000, $titleCell)->addText(('Opini Audit'), $fontStyle, array('align' => 'left'));

            $table->addRow();
            $prosedur = '<table width="100%" style="font-weight: bold; font-style: italic;"> 
                                    <tr>
                                        <td colspan="2">Audit kami laksanakan melalui prosedur berikut:</td>
                                    </tr>
                                    <tr>
                                        <td width="5%">1.</td>
                                        <td width="95%" style="text-align: justify;">Melakukan reviu atas dokumen/administrasi perusahaan, melaksanakan observasi visual, melakukan wawancara/konfirmasi serta pemeriksaan fisik untuk menilai ketaatan terhadap peraturan perusahaan</td>
                                    </tr>
                                    <tr>
                                        <td width="5%">2.</td>
                                        <td width="95%" style="text-align: justify;">Melakukan evaluasi dan penilaian terhadap upaya yang dilakukan manajemen Cabang dalam pencapaian sasaran/target perusahaan</td>
                                    </tr>
                                    <tr>
                                        <td width="5%">3.</td>
                                        <td width="95%" style="text-align: justify;">Melakukan telaah atas aturan, pedoman dan SOP yang dijadikan acuan dalam pelaksanaan kegiatan Cabang untuk dilakukan penyempurnaan</td>
                                    </tr>
                                    </table>';
            $opini_audit = '<table width="100%" style="font-weight: bold; font-style: italic;"> 
                                    <tr>
                                        <td style="text-align: justify;"><p>Berdasarkan audit ini kami memberikan opini terhadap Pengelolaan PT PTP '.$header->NAMA_DIVISI.' adalah :</p><p style="text-align: center">2 – Some Improvement Needed 
                                        (Diperlukan beberapa perbaikan)</p><p>Terdapat beberapa kelemahan kontrol yang teridentifikasi. Namun secara umum, kontrol yang ada sudah cukup, sesuai, efektif, dan memberikan jaminan yang memadai bahwa risiko telah dikelola dan tujuan dapat tercapai.</p></td>
                                    </tr>
                                    </table>';
            $cell_rp      = $table->addCell(7000);
            \PhpOffice\PhpWord\Shared\Html::addHtml($cell_rp, "{$prosedur}",false,false,null);
            $table->addCell(200)->addText('');
            $cell_oa      = $table->addCell(6000);
            \PhpOffice\PhpWord\Shared\Html::addHtml($cell_oa, "{$opini_audit}",false,false,null);

        $section_4->addPageBreak();
        // end ringkasan ekskutif

        // start Ringkasan Temuan dan Rekomendasi Audit
        $header_5   = $section_5->createHeader();

        $header_5->addText($this->getJudul(5));
        $header_5->addPreserveText('Halaman {PAGE} dari {NUMPAGES}.', array("size" => 10, "name" => 'Arial'), array('align'  => 'right'));
        $header_5->addImage(FCPATH.'assets/img/bg/border-header.png',
                             array(
                                'width' => 740,
                                'align' => 'center',
                                'positioning' => \PhpOffice\PhpWord\Style\Image::POSITION_ABSOLUTE,
                                'posHorizontal' => \PhpOffice\PhpWord\Style\Image::POSITION_ABSOLUTE,
                                'posVertical' => \PhpOffice\PhpWord\Style\Image::POSITION_ABSOLUTE,
                                'marginLeft' => -370,
                                'marginTop' => -60
                            ));

        $styleTable     = array('cellMarginRight' => 100, 'cellMarginTop' => 100, 'cellMarginLeft' => 100, 'align' => 'center');
        $styleFirstRow  = array('borderBottomSize' => 6, 'borderBottomColor' => '000', 'bgColor' => 'cc9900', 'valign' => 'center');
        $titleCell      = array('borderSize' => 10, 'borderColor' => '000');
        $fontStyle      = array('bold' => true, 'valign' => 'center', 'color' => '000');
        $phpWord->addTableStyle('tabel observasi', $styleTable, $styleFirstRow);
        $table = $section_5->addTable('tabel observasi');
        $table->addRow(100, array('tblHeader' => true));
        $table->addCell(800, $titleCell)->addText(('No'), $fontStyle, array('align' => 'center'));
        $table->addCell(7000, $titleCell)->addText(('Kondisi'), $fontStyle, array('align' => 'center'));
        $table->addCell(5000, $titleCell)->addText(('Rekomendasi'), $fontStyle, array('align' => 'center'));
        $table->addCell(3000, $titleCell)->addText(('PIC Temuan Audit/ Batas Waktu'), $fontStyle, array('align' => 'center'));
        $table->addCell(2000, $titleCell)->addText(('Prioritas'), $fontStyle, array('align' => 'center'));

        foreach ($rekomendasi as $key => $item) {
            // print_r(array_unique(json_decode($item['pic'])));die();
            $no_urut        = $key + 1;
            $prioritas      = $item["PRIORITAS"];
            $data_temuan    = '<div style="text-align: justify;font-size: 11.0pt; font-family: \'Gotham Book\'; mso-ascii-font-family: \'Gotham Book\'; mso-fareast-font-family: +mn-ea; mso-bidi-font-family: Arial; mso-fareast-theme-font: minor-fareast; mso-bidi-theme-font: minor-bidi; color: black; mso-font-kerning: 12.0pt; language: en-ID; font-weight: normal; font-style: normal; mso-style-textfill-type: solid; mso-style-textfill-fill-color: black; mso-style-textfill-fill-alpha: 100.0%;"><p><strong>' . $item['JUDUL_TEMUAN'] . "</strong></p>" . preg_replace('%<span(.*?)>|</span>%s','',$item['TEMUAN']) . "</div>";
            $data_temuan    = str_replace("<br>", "", $data_temuan);
            $rekomen        = '';
            foreach(json_decode($item['rekomendasi']) as $rekom)
                $rekomen .= $rekom;
            $data_rekomen   = '<div style="text-align: justify;font-size: 11.0pt; font-family: \'Gotham Book\'; mso-ascii-font-family: \'Gotham Book\'; mso-fareast-font-family: +mn-ea; mso-bidi-font-family: Arial; mso-fareast-theme-font: minor-fareast; mso-bidi-theme-font: minor-bidi; color: black; mso-font-kerning: 12.0pt; language: en-ID; font-weight: normal; font-style: normal; mso-style-textfill-type: solid; mso-style-textfill-fill-color: black; mso-style-textfill-fill-alpha: 100.0%;">' . $rekomen . "</div>";
            $data_rekomen   = str_replace("<br>", "", $data_rekomen);
            $data_rekomen   = preg_replace('%<span(.*?)>|</span>%s','',$data_rekomen);
            $pic            = '';
            foreach(array_unique(json_decode($item['pic'])) as $p)
            {
                if($p != '')
                    $pic .= "<div>" . $p . "</div>";
            }
            $bw             = json_decode($item['batas_waktu'])[0];
            $data_pic_bw    = '<div style="text-align: center;font-size: 11.0pt; font-family: \'Gotham Book\'; mso-ascii-font-family: \'Gotham Book\'; mso-fareast-font-family: +mn-ea; mso-bidi-font-family: Arial; mso-fareast-theme-font: minor-fareast; mso-bidi-theme-font: minor-bidi; color: black; mso-font-kerning: 12.0pt; language: en-ID; font-weight: normal; font-style: normal; mso-style-textfill-type: solid; mso-style-textfill-fill-color: black; mso-style-textfill-fill-alpha: 100.0%;"><strong>' . $pic . "</strong>" . tgl_indo($bw) . "</div>";

                    $table->addRow();
                    $table->addCell(800, array('borderSize' => 10, 'borderColor' => '000'))->addText($no_urut);
                    $cell_temuan = $table->addCell(7000, array('borderSize' => 10, 'borderColor' => '000'));
                    \PhpOffice\PhpWord\Shared\Html::addHtml($cell_temuan, $data_temuan,false,false,null);

                    $cell_rekomen = $table->addCell(5000, $titleCell);
                    \PhpOffice\PhpWord\Shared\Html::addHtml($cell_rekomen, $data_rekomen,false,false,null);

                    $cell_pic_bw  = $table->addCell(3000, $titleCell);
                    \PhpOffice\PhpWord\Shared\Html::addHtml($cell_pic_bw, $data_pic_bw,false,false,null);

                    $data_priortias  = '<div style="text-align: center;font-size: 11.0pt; font-family: \'Gotham Book\'; mso-ascii-font-family: \'Gotham Book\'; mso-fareast-font-family: +mn-ea; mso-bidi-font-family: Arial; mso-fareast-theme-font: minor-fareast; mso-bidi-theme-font: minor-bidi; color: black; mso-font-kerning: 12.0pt; language: en-ID; font-weight: normal; font-style: normal; mso-style-textfill-type: solid; mso-style-textfill-fill-color: black; mso-style-textfill-fill-alpha: 100.0%;"><strong>' . $prioritas . "</strong></div>";
                    $cell_priortias  = $table->addCell(2000, $titleCell);
                    \PhpOffice\PhpWord\Shared\Html::addHtml($cell_priortias, $data_priortias,false,false,null);

        }

        $section_5->addPageBreak();
        // end Ringkasan Temuan dan Rekomendasi Audit

        // start Ringkasan Hal-hal yang Perlu Diperhatikan
        $header_6   = $section_6->createHeader();

        $header_6->addText($this->getJudul(6));
        $header_6->addPreserveText('Halaman {PAGE} dari {NUMPAGES}.', array("size" => 10, "name" => 'Arial'), array('align'  => 'right'));
        $header_6->addImage(FCPATH.'assets/img/bg/border-header.png',
                             array(
                                'width' => 740,
                                'align' => 'center',
                                'positioning' => \PhpOffice\PhpWord\Style\Image::POSITION_ABSOLUTE,
                                'posHorizontal' => \PhpOffice\PhpWord\Style\Image::POSITION_ABSOLUTE,
                                'posVertical' => \PhpOffice\PhpWord\Style\Image::POSITION_ABSOLUTE,
                                'marginLeft' => -370,
                                'marginTop' => -60
                            ));

        $styleTable     = array('cellMarginRight' => 100, 'cellMarginTop' => 100, 'cellMarginLeft' => 100, 'align' => 'center');
        $styleFirstRow  = array('borderBottomSize' => 6, 'borderBottomColor' => '000', 'bgColor' => 'cc9900', 'valign' => 'center');
        $titleCell      = array('borderSize' => 10, 'borderColor' => '000');
        $fontStyle      = array('bold' => true, 'valign' => 'center', 'color' => '000');
        $phpWord->addTableStyle('tabel perhatian', $styleTable, $styleFirstRow);
        $table = $section_6->addTable('tabel perhatian');
        $table->addRow(100, array('tblHeader' => true));
        $table->addCell(800, $titleCell)->addText(('No'), $fontStyle, array('align' => 'center'));
        $table->addCell(7000, $titleCell)->addText(('Kondisi'), $fontStyle, array('align' => 'center'));
        $table->addCell(5000, $titleCell)->addText(('Rekomendasi'), $fontStyle, array('align' => 'center'));
        $table->addCell(3000, $titleCell)->addText(('PIC Temuan Audit/ Batas Waktu'), $fontStyle, array('align' => 'center'));
        $table->addCell(2000, $titleCell)->addText(('Prioritas'), $fontStyle, array('align' => 'center'));
        foreach ($perhatian as $key => $item) {
            $no_urut        = $key + 1;
            $prioritas      = $item["PRIORITAS"];
            $data_observasi    = "<div style='text-align: justify;'><p><strong>" . $item['JUDUL_OBSERVASI'] . "</strong></p>" . $item['OBSERVASI'] . "</div>";
            $data_observasi    = str_replace("<br>", "", $data_observasi);
            $data_rekom    = "<div style='text-align: justify;'>" . $item['REKOMENDASI'] . "</div>";
            $data_rekom    = str_replace("<br>", "", $data_rekom);
            $data_pic_bw   = "<div style='text-align: center;'><strong>" . $item['NAMA_JABATAN'] . "</strong>" . tgl_indo($item['BATAS_WAKTU']) . "</div>";
     

                    $table->addRow();
                    $table->addCell(800, array('borderSize' => 10, 'borderColor' => '000'))->addText($no_urut);
                    $cell_observasi = $table->addCell(7000, array('borderSize' => 10, 'borderColor' => '000'));
                    \PhpOffice\PhpWord\Shared\Html::addHtml($cell_observasi, $data_observasi,false,false,null);

                    $cell_rekomen = $table->addCell(5000, $titleCell);
                    \PhpOffice\PhpWord\Shared\Html::addHtml($cell_rekomen, $data_rekom,false,false,null);

                    $cell_pic_bw  = $table->addCell(3000, $titleCell);
                    \PhpOffice\PhpWord\Shared\Html::addHtml($cell_pic_bw, $data_pic_bw,false,false,null);

                    $data_priortias  = "<div style='text-align: center;'><strong>" . $item['PRIORITAS'] . "</strong></div>";
                    $cell_priortias  = $table->addCell(2000, $titleCell);
                    \PhpOffice\PhpWord\Shared\Html::addHtml($cell_priortias, $data_priortias,false,false,null);

        }

        $section_6->addPageBreak();
        // end Ringkasan Hal-hal yang Perlu Diperhatikan

        // start Lampiran 1: Rincian Temuan dan Rekomendasi Audit
        $header_7   = $section_7->createHeader();

        $header_7->addText($this->getJudul(7));
        $header_7->addPreserveText('Halaman {PAGE} dari {NUMPAGES}.', array("size" => 10, "name" => 'Arial'), array('align'  => 'right'));
        $header_7->addImage(FCPATH.'assets/img/bg/border-header.png',
                             array(
                                'width' => 740,
                                'align' => 'center',
                                'positioning' => \PhpOffice\PhpWord\Style\Image::POSITION_ABSOLUTE,
                                'posHorizontal' => \PhpOffice\PhpWord\Style\Image::POSITION_ABSOLUTE,
                                'posVertical' => \PhpOffice\PhpWord\Style\Image::POSITION_ABSOLUTE,
                                'marginLeft' => -370,
                                'marginTop' => -60
                            ));

        $styleTable     = array('cellMarginRight' => 100, 'cellMarginTop' => 100, 'cellMarginLeft' => 100, 'align' => 'center');
        $styleFirstRow  = array('borderBottomSize' => 6, 'borderBottomColor' => '000', 'bgColor' => 'cc9900', 'valign' => 'center');
        $titleCell      = array('borderSize' => 10, 'borderColor' => '000', 'bgColor' => 'cc9900', 'tblHeader' => true, 'gridSpan' => 3);
        $fontStyle      = array('bold' => true, 'valign' => 'center', 'color' => '000');
        $phpWord->addTableStyle('tabel lampiran 1', $styleTable);
        $table      = $section_7->addTable('tabel lampiran 1');
        $no_urut    = 0;

        foreach ($rekomendasi as $key => $item) {
            $no_urut        = $key + 1;
            $table->addRow(100, array('tblHeader' => false));
            $judul_temuan   = "<i><strong>". $no_urut . ". " . $item['JUDUL_TEMUAN'] . "</strong></i>";
            $cell_judul     = $table->addCell(17800, $titleCell);
            \PhpOffice\PhpWord\Shared\Html::addHtml($cell_judul, $judul_temuan,false,false,null);
// $data_temuan    = '<div style="text-align: justify;font-size: 11.0pt; font-family: \'Gotham Book\'; mso-ascii-font-family: \'Gotham Book\'; mso-fareast-font-family: +mn-ea; mso-bidi-font-family: Arial; mso-fareast-theme-font: minor-fareast; mso-bidi-theme-font: minor-bidi; color: black; mso-font-kerning: 12.0pt; language: en-ID; font-weight: normal; font-style: normal; mso-style-textfill-type: solid; mso-style-textfill-fill-color: black; mso-style-textfill-fill-alpha: 100.0%;"><p><strong>' . $item['JUDUL_TEMUAN'] . "</strong></p>" . preg_replace('%<span(.*?)>|</span>%s','',$item['TEMUAN']) . "</div>";
            $table->addRow();
            $data_detil    = '<div style="text-align: justify;"><strong>Kondisi</strong>'.str_replace("<br>", "", preg_replace('%<span(.*?)>|</span>%s','',$item['TEMUAN']))."<strong>Kriteria</strong>".preg_replace('%<span(.*?)>|</span>%s','',$item["KRITERIA"])."<strong><i>Root Cause</i></strong>".preg_replace('%<span(.*?)>|</span>%s','',$item["ROOT_CAUSE"])."<strong>Implikasi terhadap Bisnis</strong>".preg_replace('%<span(.*?)>|</span>%s','',$item["IMPLIKASI"])."</div>";
            $data_detil    = str_replace("<br>", "", $data_detil);
            $cell_detil    = $table->addCell(17800, array('borderSize' => 10, 'borderColor' => '000', 'gridSpan' => 3));
            \PhpOffice\PhpWord\Shared\Html::addHtml($cell_detil, $data_detil,false,false,null);

            $table->addRow();
            $rkmn     = $table->addCell(12800, array('borderSize' => 10, 'borderColor' => '000', 'bgColor' => 'lightgrey'));
            \PhpOffice\PhpWord\Shared\Html::addHtml($rkmn, '<strong style="text-align: center;">Rekomendasi</strong>',false,false,null);
            $pic_tm   = $table->addCell(3000, array('borderSize' => 10, 'borderColor' => '000', 'bgColor' => 'lightgrey'));
            \PhpOffice\PhpWord\Shared\Html::addHtml($pic_tm, '<strong style="text-align: center;">PIC Temuan Audit/Batas Waktu</strong>',false,false,null);
            $prio     = $table->addCell(2000, array('borderSize' => 10, 'borderColor' => '000', 'bgColor' => 'lightgrey'));
            \PhpOffice\PhpWord\Shared\Html::addHtml($prio, '<strong style="text-align: center;">Prioritas</strong>',false,false,null);

            $rekomen        = '';
            foreach(json_decode($item['rekomendasi']) as $rekom)
                $rekomen .= $rekom;
            $data_rekomen   = '<div style="text-align: justify;font-size: 11.0pt; font-family: \'Gotham Book\'; mso-ascii-font-family: \'Gotham Book\'; mso-fareast-font-family: +mn-ea; mso-bidi-font-family: Arial; mso-fareast-theme-font: minor-fareast; mso-bidi-theme-font: minor-bidi; color: black; mso-font-kerning: 12.0pt; language: en-ID; font-weight: normal; font-style: normal; mso-style-textfill-type: solid; mso-style-textfill-fill-color: black; mso-style-textfill-fill-alpha: 100.0%;">' . $rekomen . "</div>";
            $data_rekomen   = str_replace("<br>", "", $data_rekomen);
            $data_rekomen   = preg_replace('%<span(.*?)>|</span>%s','',$data_rekomen);
            $pic            = '';
            foreach(array_unique(json_decode($item['pic'])) as $p)
            {
                if($p != '')
                    $pic .= "<div>" . $p . "</div>";
            }
            $bw             = json_decode($item['batas_waktu'])[0];
            $data_pic_bw    = "<div style='text-align: center;'><strong>" . $pic . "</strong>" . tgl_indo($bw) . "</div>";

            $table->addRow();
            $rkmn_d     = $table->addCell(12800, array('borderSize' => 10, 'borderColor' => '000'));
            \PhpOffice\PhpWord\Shared\Html::addHtml($rkmn_d, $data_rekomen,false,false,null);
            $pic_tm_d   = $table->addCell(3000, array('borderSize' => 10, 'borderColor' => '000'));
            \PhpOffice\PhpWord\Shared\Html::addHtml($pic_tm_d, $data_pic_bw,false,false,null);
            $prio_d     = $table->addCell(2000, array('borderSize' => 10, 'borderColor' => '000'));
            \PhpOffice\PhpWord\Shared\Html::addHtml($prio_d, '<strong style="text-align: center;">'.$item["PRIORITAS"].'</strong>',false,false,null);

            $table->addRow();
            $data_komen    = '<div style="text-align: justify;font-size: 11.0pt; font-family: \'Gotham Book\'; mso-ascii-font-family: \'Gotham Book\'; mso-fareast-font-family: +mn-ea; mso-bidi-font-family: Arial; mso-fareast-theme-font: minor-fareast; mso-bidi-theme-font: minor-bidi; color: black; mso-font-kerning: 12.0pt; language: en-ID; font-weight: normal; font-style: normal; mso-style-textfill-type: solid; mso-style-textfill-fill-color: black; mso-style-textfill-fill-alpha: 100.0%;"><strong>Komentar Auditi:</strong>'.preg_replace('%<span(.*?)>|</span>%s','',$item["KOMENTAR_AUDITI"])."</div>";
            $data_komen    = str_replace("<br>", "", $data_komen);
            $cell_komen    = $table->addCell(17800, array('borderSize' => 10, 'borderColor' => '000', 'gridSpan' => 3));
            \PhpOffice\PhpWord\Shared\Html::addHtml($cell_komen, $data_komen,false,false,null);

        }

        $section_7->addPageBreak();
        // end Lampiran 1: Rincian Temuan dan Rekomendasi Audit

        // start Lampiran 2: Rincian Hal-hal yang Perlu Diperhatikan
        $header_8   = $section_8->createHeader();

        $header_8->addText($this->getJudul(8));
        $header_8->addPreserveText('Halaman {PAGE} dari {NUMPAGES}.', array("size" => 10, "name" => 'Arial'), array('align'  => 'right'));
        $header_8->addImage(FCPATH.'assets/img/bg/border-header.png',
                             array(
                                'width' => 740,
                                'align' => 'center',
                                'positioning' => \PhpOffice\PhpWord\Style\Image::POSITION_ABSOLUTE,
                                'posHorizontal' => \PhpOffice\PhpWord\Style\Image::POSITION_ABSOLUTE,
                                'posVertical' => \PhpOffice\PhpWord\Style\Image::POSITION_ABSOLUTE,
                                'marginLeft' => -370,
                                'marginTop' => -60
                            ));

        $styleTable     = array('cellMarginRight' => 100, 'cellMarginTop' => 100, 'cellMarginLeft' => 100, 'align' => 'center');
        $styleFirstRow  = array('borderBottomSize' => 6, 'borderBottomColor' => '000', 'bgColor' => 'lightgrey', 'valign' => 'center');
        $titleCell      = array('borderSize' => 10, 'borderColor' => '000', 'tblHeader' => true);
        $fontStyle      = array('bold' => true, 'valign' => 'center', 'color' => '000');
        $phpWord->addTableStyle('tabel perhatian 2', $styleTable);
        $table = $section_8->addTable('tabel perhatian 2');

        $data_obs = "<div style='text-align: justify;'><strong>Kondisi</strong><p>Dari hasil audit rutin pada PT PTP Cabang ".$header->NAMA_DIVISI." Tahun ".$header->TAHUN.", kami temukan beberapa hal yang perlu diperhatikan untuk peningkatan layanan, kepuasan pelanggan dan karyawan serta peningkatan kinerja perusahaan sebagai berikut:</p>";
        foreach ($perhatian as $key => $item) {
            $data_obs .= "<strong><i>".$item["NO_URUT"].". ".$item["JUDUL_OBSERVASI"]."</i></strong>".$item["OBSERVASI"];
        }
        $data_obs .= "</div>";
        $table->addRow();
        $data_obs      = str_replace("<br>", "", $data_obs);
        $cell_detil    = $table->addCell(17800, array('borderSize' => 10, 'borderColor' => '000', 'gridSpan' => 4));
        \PhpOffice\PhpWord\Shared\Html::addHtml($cell_detil, $data_obs,false,false,null);

        $table->addRow(100, array('tblHeader' => true));
        $table->addCell(800, array('borderSize' => 10, 'borderColor' => '000', 'bgColor' => 'lightgrey'))->addText(('No'), $fontStyle, array('align' => 'center'));
        $table->addCell(12000, array('borderSize' => 10, 'borderColor' => '000', 'bgColor' => 'lightgrey'))->addText(('Rekomendasi'), $fontStyle, array('align' => 'center'));
        $table->addCell(3000, array('borderSize' => 10, 'borderColor' => '000', 'bgColor' => 'lightgrey'))->addText(('PIC Temuan Audit/ Batas Waktu'), $fontStyle, array('align' => 'center'));
        $table->addCell(2000, array('borderSize' => 10, 'borderColor' => '000', 'bgColor' => 'lightgrey'))->addText(('Prioritas'), $fontStyle, array('align' => 'center'));
        foreach ($perhatian as $key => $item) {
            $no_urut        = $key + 1;
            $prioritas      = $item["PRIORITAS"];
            $data_rekom    = "<div style='text-align: justify;'>" . $item['REKOMENDASI'] . "</div>";
            $data_rekom    = str_replace("<br>", "", $data_rekom);
            $data_pic_bw   = "<div style='text-align: center;'><strong>" . $item['NAMA_JABATAN'] . "</strong>" . tgl_indo($item['BATAS_WAKTU']) . "</div>";
     

                    $table->addRow();
                    $table->addCell(800, array('borderSize' => 10, 'borderColor' => '000'))->addText($no_urut);

                    $cell_rekomen = $table->addCell(12000, $titleCell);
                    \PhpOffice\PhpWord\Shared\Html::addHtml($cell_rekomen, $data_rekom,false,false,null);

                    $cell_pic_bw  = $table->addCell(3000, $titleCell);
                    \PhpOffice\PhpWord\Shared\Html::addHtml($cell_pic_bw, $data_pic_bw,false,false,null);

                    $data_priortias  = "<div style='text-align: center;'><strong>" . $item['PRIORITAS'] . "</strong></div>";
                    $cell_priortias  = $table->addCell(2000, $titleCell);
                    \PhpOffice\PhpWord\Shared\Html::addHtml($cell_priortias, $data_priortias,false,false,null);

        }

        $section_8->addPageBreak();
        // end Lampiran 2: Rincian Hal-hal yang Perlu Diperhatikan

        // start Lampiran 3: Definisi Istilah
        $header_9   = $section_9->createHeader();

        $header_9->addText($this->getJudul(9));
        $header_9->addPreserveText('Halaman {PAGE} dari {NUMPAGES}.', array("size" => 10, "name" => 'Arial'), array('align'  => 'right'));
        $header_9->addImage(FCPATH.'assets/img/bg/border-header.png',
                             array(
                                'width' => 740,
                                'align' => 'center',
                                'positioning' => \PhpOffice\PhpWord\Style\Image::POSITION_ABSOLUTE,
                                'posHorizontal' => \PhpOffice\PhpWord\Style\Image::POSITION_ABSOLUTE,
                                'posVertical' => \PhpOffice\PhpWord\Style\Image::POSITION_ABSOLUTE,
                                'marginLeft' => -370,
                                'marginTop' => -60
                            ));

        $styleTable     = array('cellMarginRight' => 100, 'cellMarginTop' => 100, 'cellMarginLeft' => 100, 'align' => 'center');
        $styleFirstRow  = array('borderBottomSize' => 6, 'borderBottomColor' => '000', 'bgColor' => 'lightgrey', 'valign' => 'center');
        $titleCell      = array('borderSize' => 10, 'borderColor' => '000');
        $fontStyle      = array('bold' => true, 'valign' => 'center', 'color' => '000', 'size' => 10);

        $phpWord->addTableStyle('tabel definisi opini', $styleTable, $styleFirstRow);
        $table = $section_9->addTable('tabel definisi opini');
        $table->addRow(100, array('tblHeader' => true));
        $table->addCell(4000, $titleCell)->addText(('Opini Audit'), $fontStyle, array('align' => 'center'));
        $table->addCell(10000, $titleCell)->addText(('Deskripsi'), $fontStyle, array('align' => 'center'));

        $table->addRow();
        $cell_a      = $table->addCell(4000, $titleCell);
        \PhpOffice\PhpWord\Shared\Html::addHtml($cell_a, "<b style='text-align: center;'><i>1 – Adequate</i></b>",false,false,null);
        $table->addCell(10000, $titleCell)->addText(('Kontrol yang ada sudah cukup, sesuai, efektif, dan memberikan jaminan yang memadai bahwa risiko telah dikelola dan tujuan dapat tercapai.'));

        $table->addRow();
        $cell_b      = $table->addCell(4000, $titleCell);
        \PhpOffice\PhpWord\Shared\Html::addHtml($cell_b, "<b style='text-align: center;'><i>2 – Some Improvement Needed</i></b>",false,false,null);
        $table->addCell(10000, $titleCell)->addText(('Terdapat beberapa kelemahan kontrol yang teridentifikasi. Namun secara umum, kontrol yang ada sudah cukup, sesuai, efektif, dan memberikan jaminan yang memadai bahwa risiko telah dikelola dan tujuan dapat tercapai.'));

        $table->addRow();
        $cell_c      = $table->addCell(4000, $titleCell);
        \PhpOffice\PhpWord\Shared\Html::addHtml($cell_c, "<b style='text-align: center;'><i>3 – Major Improvement Needed</i></b>",false,false,null);
        $table->addCell(10000, $titleCell)->addText(('Terdapat banyak kelemahan kontrol yang teridentifikasi. Kontrol yang ada kemungkinan tidak dapat memberikan jaminan yang memadai bahwa risiko telah dikelola dan tujuan dapat tercapai.'));

        $table->addRow();
        $cell_d      = $table->addCell(4000, $titleCell);
        \PhpOffice\PhpWord\Shared\Html::addHtml($cell_d, "<b style='text-align: center;'><i>4 – Inadequate</i></b>",false,false,null);
        $table->addCell(10000, $titleCell)->addText(('Kontrol yang ada tidak cukup, sesuai, atau efektif dan tidak memberikan jaminan yang memadai bahwa risiko telah dikelola dan tujuan dapat tercapai.'));

        $section_9->addTextBreak();

        $phpWord->addTableStyle('tabel definisi prioritas', $styleTable, $styleFirstRow);
        $table = $section_9->addTable('tabel definisi prioritas');
        $table->addRow(100, array('tblHeader' => true));
        $table->addCell(4000, $titleCell)->addText(('Prioritas'), $fontStyle, array('align' => 'center'));
        $table->addCell(10000, $titleCell)->addText(('Deskripsi'), $fontStyle, array('align' => 'center'));

        $table->addRow();
        $cell_1      = $table->addCell(4000, $titleCell);
        \PhpOffice\PhpWord\Shared\Html::addHtml($cell_1, "<b style='text-align: center;'><i>1</i></b>",false,false,null);
        $table->addCell(10000, $titleCell)->addText(('Perbaikan perlu dilakukan segera/dalam jangka waktu singkat untuk menghindari terganggunya operasi perusahaan.'));

        $table->addRow();
        $cell_2      = $table->addCell(4000, $titleCell);
        \PhpOffice\PhpWord\Shared\Html::addHtml($cell_2, "<b style='text-align: center;'><i>2</i></b>",false,false,null);
        $table->addCell(10000, $titleCell)->addText(('Perbaikan perlu dilakukan dalam tiga bulan karena berpotensi menyebabkan masalah yang serius terhadap operasi perusahaan.'));

        $table->addRow();
        $cell_3      = $table->addCell(4000, $titleCell);
        \PhpOffice\PhpWord\Shared\Html::addHtml($cell_3, "<b style='text-align: center;'><i>3</i></b>",false,false,null);
        $table->addCell(10000, $titleCell)->addText(('Perbaikan dapat dilakukan dalam enam bulan. Tidak berpotensi menyebabkan masalah yang serius terhadap operasi perusahaan.'));

        $section_9->addPageBreak();
        // end Lampiran 3: Definisi Istilah

        // start Lampiran 3: Surat Perintah Audit (Copy)
        $header_10   = $section_10->createHeader();

        $header_10->addText($this->getJudul(10));
        $header_10->addPreserveText('Halaman {PAGE} dari {NUMPAGES}.', array("size" => 10, "name" => 'Arial'), array('align'  => 'right'));
        $header_10->addImage(FCPATH.'assets/img/bg/border-header.png',
                             array(
                                'width' => 740,
                                'align' => 'center',
                                'positioning' => \PhpOffice\PhpWord\Style\Image::POSITION_ABSOLUTE,
                                'posHorizontal' => \PhpOffice\PhpWord\Style\Image::POSITION_ABSOLUTE,
                                'posVertical' => \PhpOffice\PhpWord\Style\Image::POSITION_ABSOLUTE,
                                'marginLeft' => -370,
                                'marginTop' => -60
                            ));

        // end Lampiran 3: Surat Perintah Audit (Copy)


        $objWriter = \PhpOffice\PhpWord\IOFactory::createWriter($phpWord, 'Word2007');
        header("Content-Type: application/vnd.openxmlformats-officedocument.wordprocessingml.document");
        header("Content-Disposition: attachment; filename=LHA_Final_".preg_replace('/[^A-Za-z0-9\ -]/', '', $header->NAMA_DIVISI)."_".$header->TAHUN.".docx");
        $objWriter->save('php://output');
    }

}
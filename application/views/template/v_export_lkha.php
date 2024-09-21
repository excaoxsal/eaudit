<!DOCTYPE html>
<html>
<head>
    <style>
        table {
            width: 100%;
            border-collapse: collapse;
            border: 2px solid #000;
        }
        .center {
            text-align: center;
        }
        .right {
            text-align: right;
        }
    </style>
</head>
<body>
    <table>
        <tr>
            <td colspan="20" class="right" style="height: 30px; border-top: 0.1em solid #000; border-left: 0.1em solid #000; border-right: 0.1em solid #000; border-bottom: none;"><b></b><br/><img src="<?= base_url() ?>assets/img/logos/ptp.png" width="90px" /></td>
        </tr>
        <tr>
            <td colspan="20" class="center" style="height: 30px; border-top: none; border-left: 0.1em solid #000; border-right: 0.1em solid #000; border-bottom: 0.1em solid #000;"><b>LAPORAN KETIDAK SESUAIAN HASIL AUDIT</b></td>
        </tr>
        <tr>
            <td colspan="3" style="border: 0.1em solid #000;"><b>DIVISI/CABANG </b></td>
            <td colspan="8" style="border: 0.1em solid #000;"><?=$divisi?></td>
            <td colspan="3" style="border: 0.1em solid #000;"><b>LKHA NO </b></td>
            <td colspan="6" style="border: 0.1em solid #000;"><?= ($kategori === "OBSERVASI") ? '-' : $kode_divisi . '-' . $kode_lks . $point . '-' . $tahun ?></td>
        </tr>
        <tr>
            <td colspan="3" style="border: 0.1em solid #000;"><b>UNIT KERJA </b></td>
            <td colspan="8" style="border: 0.1em solid #000;"><?=$sub_divisi?></td>
            <td colspan="3" style="border: 0.1em solid #000;"><b>LEAD AUDITOR </b></td>
            <td colspan="6" style="border: 0.1em solid #000;"><?php echo $lead_auditor; ?></td>
        </tr>
        <tr>
            <td colspan="3" style="border: 0.1em solid #000;"><b>TANGGAL </b></td>
            <td colspan="8" style="border: 0.1em solid #000;"><?php echo $tanggal; ?></td>
            <td colspan="3" style="border: 0.1em solid #000;"><b>AUDITOR </b></td>
            <td colspan="6" style="border: 0.1em solid #000;"><?php echo $auditor; ?></td>
        </tr>
        <tr>
            <td colspan="20" class="center" style="border: 0.1em solid #000;height: 15px;"><b>(DIISI OLEH AUDITOR)</b></td>
        </tr>
        <tr>
            <td colspan="11" style="border: 0.1em solid #000;"><b>KLASIFIKASI KETIDAKSESUAIAN:</b></td>
            <td colspan="9" style="border: 0.1em solid #000;"><?=$kategori?></td>
        </tr>
        <tr>
            <td colspan="20" style="border: 0.1em solid #000 ;height: auto;"><?=$nomor_iso?><br/>Klausul <?=$klausul?><br/><?=$temuan?></td>
        </tr>
        <tr>
            <td colspan="4" style="border: 0.1em solid #000; height: 20px;"><b>Tanda Tangan Lead Auditor:</b></td>
            <td colspan="4" style="border: 0.1em solid #000;" class="center">
              <img src="<?= ($kategori === "OBSERVASI") ? "NULL" : $ttd_lead_auditor; ?>" alt="Tanda Tangan Lead Auditor" style="width: 50px; height: 20px; object-fit: contain;"/>
            </td>
            <td colspan="12" style="border: 0.1em solid #000;">Nama Lead Auditor : <?php echo $lead_auditor; ?></td>
        </tr>
        <tr>
            <td colspan="4" style="border: 0.1em solid #000;height: 20px;"><b>Tanda Tangan Auditor:</b></td>
            <td colspan="4" style="border: 0.1em solid #000;" class="center">
              <img src="<?= ($kategori === "OBSERVASI") ? "NULL" : $ttd_auditor; ?>" alt="Tanda Tangan Auditor" style="width: 50px; height: 20px; object-fit: contain;"/>
            </td>
            <td colspan="12" style="border: 0.1em solid #000;">Nama Auditor : <?php echo $auditor; ?></td>
        </tr>
        <tr>
            <td colspan="4" style="border: 0.1em solid #000;height: 20px;"><b>Tanda tangan Auditee:</b></td>
            <td colspan="4" style="border: 0.1em solid #000;" class="center">
              <img src="<?php echo $ttd_auditee; ?>" alt="Tanda Tangan Auditee" style="width: 50px; height: 20px; object-fit: contain;"/>
            </td>
            <td colspan="12">Nama : <?php echo $auditee; ?></td>
        </tr>
        <tr>
            <td colspan="4" style="border: 0.1em solid #000;height: 20px;"><b>Tanda tangan Atasan Langsung Auditee:</b></td>
            <td colspan="4" style="border: 0.1em solid #000;" class="center">
              <img src="<?php echo $ttd_atasan_auditee; ?>" alt="Tanda Tangan Atasan Auditee" style="width: 50px; height: 20px; object-fit: contain;"/>
            </td>
            <td colspan="12" style="border: 0.1em solid #000;">Nama : <?php echo $atasan_auditee; ?></td>
        </tr>
        <tr>
            <td colspan="20" class="center" style="border: 0.1em solid #000;height: 15px;"><b>(DIISI OLEH AUDITEE)</b></td>
        </tr>
        <tr>
            <td colspan="4" style="border: 0.1em solid #000;"><b>TANGGAL IMPLEMENTASI :</b></td>
            <td colspan="16" style="border: 0.1em solid #000;"><?php echo $tanggal_implementasi; ?></td>
        </tr>
        <tr>
            <td colspan="4" style="border: 0.1em solid #000;height: auto;"><b>TINDAKAN INVESTIGASI:</b></td>
            <td colspan="16" style="border: 0.1em solid #000;"><?=$investigasi?></td>
        </tr>
        <tr>
            <td colspan="4" style="border: 0.1em solid #000;height: auto;"><b>TINDAKAN PERBAIKAN:</b></td>
            <td colspan="16" style="border: 0.1em solid #000;"><?=$perbaikan?></td>
        </tr>
        <tr>
            <td colspan="4" style="border: 0.1em solid #000;height: auto;"><b>TINDAKAN KOREKTIF:</b></td>
            <td colspan="16" style="border: 0.1em solid #000;"><?=$korektif?></td>
        </tr>
        <tr>
            <td colspan="4" style="border: 0.1em solid #000;height: 20px;"><b>Tanda Tangan Auditee:</b></td>
            <td colspan="4" style="border: 0.1em solid #000;" class="center">
              <img src="<?php echo ($status == "Tindak Lanjut" || $status == "CLOSE") ? $ttd_auditee : null; ?>" alt="Tanda Tangan Auditee" style="width: 50px; height: 20px; object-fit: contain;"/>
            </td>
            <td colspan="12" style="border: 0.1em solid #000;">Nama : <?php echo $auditee; ?></td>
        </tr>
        <tr>
            <td colspan="4" style="border: 0.1em solid #000;height: 20px;"><b>Tanda Tangan Atasan Langsung Auditee:</b></td>
            <td colspan="4" style="border: 0.1em solid #000;" class="center">
              <img src="<?php echo ($approval_tindaklanjut == 1 || $status == "CLOSE") ? $ttd_atasan_auditee : null; ?>" alt="Tanda Tangan Atasan Auditee" style="width: 50px; height: 20px; object-fit: contain;"/>
            </td>
            <td colspan="12" style="border: 0.1em solid #000;">Nama : <?php echo $atasan_auditee; ?></td>
        </tr>
        <tr>
            <td colspan="4" style="border: 0.1em solid #000;"><b>TANGGAL CLOSING AUDITEE :</b></td>
            <td colspan="16" style="border: 0.1em solid #000;"><?php echo $closedate;?></td>
        </tr>
        <tr>
            <td colspan="20" style="border: 0.1em solid #000;height: auto;"><b>KOMENTAR PEMERIKSAAN : </b><?=$komen_lead?></td>
        </tr>
        <tr>
            <td colspan="4" style="border: 0.1em solid #000;height: 20px;"><b>Tanda Tangan Lead Auditor:</b></td>
            <td colspan="4" style="border: 0.1em solid #000;" class="center">
              <img src="<?php echo ($approval_tindaklanjut == 3 || $status == "CLOSE") ? $ttd_lead_auditor : null; ?>" alt="Tanda Tangan Lead Auditor" style="width: 50px; height: 20px; object-fit: contain;"/>
            </td>
            <td colspan="12" style="border: 0.1em solid #000;">Nama Lead Auditor : <?php echo $lead_auditor; ?></td>
        </tr>
        <tr>
            <td colspan="4" style="border: 0.1em solid #000;height: 20px;"><b>Tanda Tangan Auditor:</b></td>
            <td colspan="4" style="border: 0.1em solid #000;" class="center">
              <img src="<?php echo ($approval_tindaklanjut == 2 || $status == "CLOSE") ? $ttd_auditor : null; ?>" alt="Tanda Tangan Auditor" style="width: 50px; height: 20px; object-fit: contain;"/>
            </td>
            <td colspan="12" style="border: 0.1em solid #000;">Nama Auditor : <?php echo $auditor; ?></td>
        </tr>
    </table>
</body>
</html>

<!DOCTYPE html>
<html>
<head>
    <style>
        table {
            width: 100%;
            border-collapse: collapse;
            border: 2px solid #000;
        }
        tr, td {
            border: 0.1em solid #000;

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
            <td colspan="20" class="right" style="height: 50px;"><b></b><br/><img src="<?= base_url() ?>assets/img/logos/ptp.png" width="90px" /></td>
        </tr>
        <tr>
            <td colspan="20" class="center" style="height: 30px;"><b>LAPORAN KETIDAK SESUAIAN HASIL AUDIT</b></td>
        </tr>
        <tr>
            <td colspan="3"><b>DIVISI/CABANG </b></td>
            <td colspan="8"><?=$divisi?></td>
            <td colspan="3"><b>LKHA NO </b></td>
            <td colspan="6"><?=$kode_divisi?>-<?=$kode_lks?><?=$point?>-<?=$tahun?></td>
        </tr>
        <tr>
            <td colspan="3"><b>UNIT KERJA </b></td>
            <td colspan="8"><?=$sub_divisi?></td>
            <td colspan="3"><b>LEAD AUDITOR </b></td>
            <td colspan="6"><?php echo $lead_auditor; ?></td>
        </tr>
        <tr>
            <td colspan="3"><b>TANGGAL </b></td>
            <td colspan="8"><?php echo $tanggal; ?></td>
            <td colspan="3"><b>AUDITOR </b></td>
            <td colspan="6"><?php echo $auditor; ?></td>
        </tr>
        <tr>
            <td colspan="20" class="center" style="height: 15px;"><b>(DIISI OLEH AUDITOR)</b></td>
        </tr>
        <tr>
            <td colspan="7"><b>KLASIFIKASI KETIDAKSESUAIAN:</b></td>
            <td colspan="13"><?=$kategori?></td>
        </tr>
        <tr>
            <td colspan="20" style="height: auto;"><?=$nomor_iso?><br/>Klausul <?=$klausul?><br/><?=$temuan?></td>
        </tr>
        <tr>
            <td colspan="4" style="height: 20px;"><b>Tanda Tangan Lead Auditor:</b></td>
            <td colspan="4" class="center">
              <img src="<?php echo $ttd_lead_auditor; ?>" alt="Tanda Tangan Lead Auditor" style="width: 50px; height: 20px; object-fit: contain;"/>
            </td>
            <td colspan="12">Nama Lead Auditor : <?php echo $lead_auditor; ?></td>
        </tr>
        <tr>
            <td colspan="4" style="height: 20px;"><b>Tanda Tangan Auditor:</b></td>
            <td colspan="4" class="center">
              <img src="<?php echo $ttd_auditor; ?>" alt="Tanda Tangan Auditor" style="width: 50px; height: 20px; object-fit: contain;"/>
            </td>
            <td colspan="12">Nama Auditor : <?php echo $auditor; ?></td>
        </tr>
        <tr>
            <td colspan="4" style="height: 20px;"><b>Tanda tangan Auditee:</b></td>
            <td colspan="4" class="center">
              <img src="<?php echo $ttd_auditee; ?>" alt="Tanda Tangan Auditee" style="width: 50px; height: 20px; object-fit: contain;"/>
            </td>
            <td colspan="12">Nama : <?php echo $auditee; ?></td>
        </tr>
        <tr>
            <td colspan="4" style="height: 20px;"><b>Tanda tangan Atasan Langsung Auditee:</b></td>
            <td colspan="4" class="center">
              <img src="<?php echo $ttd_atasan_auditee; ?>" alt="Tanda Tangan Atasan Auditee" style="width: 50px; height: 20px; object-fit: contain;"/>
            </td>
            <td colspan="12">Nama : <?php echo $atasan_auditee; ?></td>
        </tr>
        <tr>
            <td colspan="20" class="center" style="height: 15px;"><b>(DIISI OLEH AUDITEE)</b></td>
        </tr>
        <tr>
            <td colspan="4"><b>TANGGAL IMPLEMENTASI :</b></td>
            <td colspan="16"><?php echo $tanggal_implementasi; ?></td>
        </tr>
        <tr>
            <td colspan="4" style="height: auto;"><b>TINDAKAN INVESTIGASI:</b></td>
            <td colspan="16"><?=$investigasi?></td>
        </tr>
        <tr>
            <td colspan="4" style="height: auto;"><b>TINDAKAN PERBAIKAN:</b></td>
            <td colspan="16"><?=$perbaikan?></td>
        </tr>
        <tr>
            <td colspan="4" style="height: auto;"><b>TINDAKAN KOREKTIF:</b></td>
            <td colspan="16"><?=$korektif?></td>
        </tr>
        <tr>
            <td colspan="4" style="height: 20px;"><b>Tanda Tangan Auditee:</b></td>
            <td colspan="4" class="center">
              <img src="<?php echo $ttd_auditee; ?>" alt="Tanda Tangan Auditee" style="width: 50px; height: 20px; object-fit: contain;"/>
            </td>
            <td colspan="12">Nama : <?php echo $auditee; ?></td>
        </tr>
        <tr>
            <td colspan="4" style="height: 20px;"><b>Tanda Tangan Atasan Langsung Auditee:</b></td>
            <td colspan="4" class="center">
              <img src="<?php echo ($approval_tindaklanjut == 1) ? $ttd_atasan_auditee : null; ?>" alt="Tanda Tangan Atasan Auditee" style="width: 50px; height: 20px; object-fit: contain;"/>
            </td>
            <td colspan="12">Nama : <?php echo $atasan_auditee; ?></td>
        </tr>
        <tr>
            <td colspan="4"><b>TANGGAL CLOSING AUDITEE :</b></td>
            <td colspan="16"><?php echo $closedate;?></td>
        </tr>
        <tr>
            <td colspan="20" style="height: auto;"><b>KOMENTAR PEMERIKSAAN : </b><?=$komen_lead?></td>
        </tr>
        <tr>
            <td colspan="4" style="height: 20px;"><b>Tanda Tangan Lead Auditor:</b></td>
            <td colspan="4" class="center">
              <img src="<?php echo ($approval_tindaklanjut == 3) ? $ttd_lead_auditor : null; ?>" alt="Tanda Tangan Lead Auditor" style="width: 50px; height: 20px; object-fit: contain;"/>
            </td>
            <td colspan="12">Nama Lead Auditor : <?php echo $lead_auditor; ?></td>
        </tr>
        <tr>
            <td colspan="4" style="height: 20px;"><b>Tanda Tangan Auditor:</b></td>
            <td colspan="4" class="center">
              <img src="<?php echo ($approval_tindaklanjut == 2) ? $ttd_auditor : null; ?>" alt="Tanda Tangan Auditor" style="width: 50px; height: 20px; object-fit: contain;"/>
            </td>
            <td colspan="12">Nama Auditor : <?php echo $auditor; ?></td>
        </tr>
    </table>
</body>
</html>

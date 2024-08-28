<!DOCTYPE html>
<html>
<head>
    <style>
        table {
            width: 100%;
            border-collapse: collapse;
        }
        td, th {
            border: 1px solid #000;
            padding: 5px;
        }
        .center {
            text-align: center;
        }
    </style>
</head>
<body>
    <table>
        <tr>
            <td colspan="20" class="right" style="height: 40px;"><b></b><br/><img src="<?= base_url() ?>assets/img/logos/ptp.png" width="120px" /></td>
        </tr>
        <tr>
            <td colspan="20" class="center" style="height: 30px;"><b>LAPORAN KETIDAK SESUAIAN HASIL AUDIT</b></td>
        </tr>
        <tr>
            <td colspan="3"><b>ORGANISASI </b></td>
            <td colspan="8">PT. Pelabuhan Tanjung Priok</td>
            <td colspan="3"><b>LKS NO </b></td>
            <td colspan="6">LKHA-<?=$kode_divisi?>-<?=$kode_lks?><?=$point?>-<?=$tahun?></td>
        </tr>
        <tr>
            <td colspan="3"><b>LOKASI </b></td>
            <td colspan="8"><?=$divisi?></td>
            <td colspan="3"><b>AUDITOR </b></td>
            <td colspan="6"><?php echo $auditor; ?></td>
        </tr>
        <tr>
            <td colspan="3"><b>TANGGAL </b></td>
            <td colspan="8"><?php echo $tanggal; ?></td>
            <td colspan="10"></td>
        </tr>
        <tr>
            <td colspan="20" class="center" style="height: 15px;"><b>(DIISI OLEH AUDITOR)</b></td>
        </tr>
        <tr>
            <td colspan="7"><b>KLASIFIKASI KETIDAKSESUAIAN:</b></td>
            <td colspan="13"><?=$kategori?></td>
        </tr>
        <tr>
            <td colspan="20"><?=$nomor_iso?><br/>Klausul 4.3<br/>Menentukan lingkup sistem manajemen mutu<br/>Klausul 6.2.<br/>Sasaran Mutu dan Perencanaan untuk Mencapainya<br/><br/>SOP yang berlaku untuk Sub. Divisi IT Hardware terjadi tumpang tindih dengan SOP dari subdivisi lain yaitu IT Software.</td>
        </tr>
        <tr>
            <td colspan="4"><b>Tanda tangan Auditor:</b></td>
            <td colspan="4"></td>
            <td colspan="12">Nama Lead Auditor : <?php echo $lead_auditor; ?><br/>Nama Auditor : <?php echo $auditor; ?><br/>Tanggal: <br/></td>
        </tr>
        <tr>
            <td colspan="4"><b>Tanda tangan Auditee:</b></td>
            <td colspan="4"></td>
            <td colspan="12">Nama : Atiq Muzzaki, Nazar Fardian</td>
        </tr>
        <tr>
            <td colspan="4"><b>Tanda tangan Atasan Langsung Auditee:</b></td>
            <td colspan="4"></td>
            <td colspan="12">Nama : <?php echo $atasan_auditee; ?><br/>Tanggal Implementasi:</td>
        </tr>
        <tr>
            <td colspan="20" class="center" style="height: 15px;"><b>(DIISI OLEH AUDITEE)</b></td>
        </tr>
        <tr>
            <td colspan="3"><b>TINDAKAN INVESTIGASI:</b></td>
            <td colspan="17"><?=$investigasi?></td>
        </tr>
        <!-- <tr>
            <td colspan="20">Ditemukan bahwa di Sub Divisi Pemeliharaan dan Pengembangan Hardware SOP yang ada saat ini masih menyatu dalam SOP Sistem Informasi dan belum di pisahkan dengan Sub Divisi Dukungan Sistem.</td>
        </tr> -->
        <tr>
            <td colspan="3"><b>TINDAKAN PERBAIKAN:</b></td>
            <td colspan="17"><?=$perbaikan?></td>
        </tr>
        <!-- <tr>
            <td colspan="20">Tindakan perbaikan yang diambil untuk mengatasi ketidaksesuaian ini adalah memisahkan SOP Sub Divisi Pemeliharaan dan Pengembangan Hardware dari SOP Sistem Informasi.</td>
        </tr> -->
        <tr>
            <td colspan="3"><b>TINDAKAN KOREKTIF:</b></td>
            <td colspan="17"><?=$korektif?></td>
        </tr>
        <!-- <tr>
            <td colspan="20">Tindakan perbaikan yang diambil untuk mengatasi ketidaksesuaian ini adalah memisahkan SOP Sub Divisi Pemeliharaan dan Pengembangan Hardware dari SOP Sistem Informasi.</td>
        </tr> -->
        <tr>
            <td colspan="4"><b>Tanda tangan Auditee:</b></td>
            <td colspan="4"></td>
            <td colspan="12">Nama : Atiq Muzzaki, Nazar Fardian</td>
        </tr>
        <tr>
            <td colspan="4"><b>Tanda tangan Atasan Langsung Auditee:</b></td>
            <td colspan="4"></td>
            <td colspan="12">Nama : <?php echo $atasan_auditee; ?><br/>Tanggal Implementasi:</td>
        </tr>
        <tr>
            <td colspan="20" style="height: 30px;"><b>KOMENTAR PEMERIKSAAN : </b><?=$komen_lead?><br/></td>
        </tr>
        <tr>
            <td colspan="4"><b>Tanda tangan Auditor:</b></td>
            <td colspan="4"></td>
            <td colspan="12">Nama Lead Auditor : <?php echo $lead_auditor; ?><br/>Nama Auditor : <?php echo $auditor; ?><br/>Tanggal Implementasi: <?php echo $tanggal; ?><br/></td>
        </tr>
    </table>
</body>
</html>

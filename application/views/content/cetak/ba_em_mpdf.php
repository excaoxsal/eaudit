<!DOCTYPE html>
<html>
<head>
	<title><?= APK_NAME ?></title>
	<style>
	body{

	}
	.title{
		text-align: center;
		padding: 10px;
		background-color: rgb(217, 217, 217);
		color: rgb(103, 144, 194);
	}
	table{
		border-collapse: collapse;
	}
	table tr td{
		font-size: 11px;
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
	.nomor_surat{
	    text-align: center;
	}
	.img-logo{
		width: 120px;
	}
	ol.a{
		list-style-type: lower-alpha!important;
	}
</style>
</head>
<body>
<table border="1" width="100%" cellpadding="5">
	<tr>
		<td width="30%" rowspan="4">
			<center><img class="img-logo" src="<?= base_url('assets/img/logos/ptp.png') ?>"></center>
		</td>
		<td width="70%" colspan="2">
			<table border="1" cellpadding="10" width="100%"> 
				<tr>
					<td class="title">
						<p style="font-size: 17px;">NOTULEN RAPAT<br>
						Exit Meeting Audit Umum Kantor Pusat tahun 2021<br>
						PT Pelabuhan Tanjung Priok</p>
					</td>
				</tr>
			</table>
		</td>
	</tr>
	<tr>
		<td>Hari / Tanggal</td>
		<td><?= $hari ?> / <?= $tanggal ?></td>
	</tr>
	<tr>
		<td>Waktu</td>
		<td><?= $data->WAKTU ?></td>
	</tr>
	<tr>
		<td>Tempat</td>
		<td><?= $data->TEMPAT ?></td>
	</tr>
</table>
<br><br>
<table border="1" width="100%" cellpadding="5">
	<tr>
		<td>Penyelenggara Rapat</td>
		<td><?= $data->NAMA_DIVISI ?></td>
	</tr>
	<tr>
		<td>Judul Rapat</td>
		<td><?= $data->JUDUL ?></td>
	</tr>
	<tr>
		<td>Perserta Rapat</td>
		<td style="line-height: 2.0;">
			<?php foreach ($peserta as $item) { ?>
			- <?php echo $item['NAMA']."<br>"; ?>
			<?php } ?>
		</td>
	</tr>
</table>
<br><br>
<table border="1" width="100%" cellpadding="5">
	<tr>
		<td class="text-center"><h3>POKOK-POKOK BAHASAN RAPAT</h3></td>
	</tr>
	<tr nobr="false">
		<td>
			<?= $data->DETAIL_A ?>
		</td>
	</tr>
</table>
<br><br>
<table border="0" width="100%" cellpadding="5">
	<tr>
		<td colspan="6">Demikian Notulen rapat ini dibuat untuk dapat dipergunakan sebagaimana mestinya.</td>
	</tr>
	<tr nobr="true">
		<td></td>
		<td></td>
		<td></td>
		<td></td>
		<td colspan="2" class="text-center">
			NOTULIS,<br>
			<?= $ttd ?>
			<br>
			<?= $data->NAMA ?>
		</td>
	</tr>
</table>
</body>
</html>
<!--begin::Content-->
<style>
	.area {
		border: 1px solid #ebedf3;
		width: 100%;
		height: 150px;
		padding: 10px;
		border-radius: 5px;
		overflow-y: auto;
		background-color: #f3f6f9;
	}
</style>
<div class="content d-flex flex-column flex-column-fluid" id="kt_content">
	<div class="subheader py-2 py-lg-4 subheader-solid" id="kt_subheader">
		<div class="container-fluid d-flex align-items-center justify-content-between flex-wrap flex-sm-nowrap">
			<div class="d-flex align-items-center flex-wrap mr-2">
				<h5 class="text-dark font-weight-bold mt-2 mb-2 mr-5"><?= APK_NAME ?></h5>
				<div class="subheader-separator subheader-separator-ver mt-2 mb-2 mr-4 bg-gray-200"></div>
				<span class="text-muted font-weight-bold mr-4">Monitoring</span>
				<div class="subheader-separator subheader-separator-ver mt-2 mb-2 mr-4 bg-gray-200"></div>
				<span class="text-muted font-weight-bold mr-4">Update Hasil Monitoring</span>
			</div>
		</div>
	</div>
	<div class="d-flex flex-column-fluid">
		<div class="container">

			<form class="form" id="form" action="<?= base_url() ?>monitoring/update_hasil_monitoring/update_hasil_monitoring/<?= $id_tl ?>/<?= $detail_rekomendasi['ID_REKOMENDASI'] ?>" method="post" enctype="multipart/form-data">
				<div class="card card-custom">
					<div class="card-header">
						<div class="card-title">
							<h3 class="card-label"><?= $title ?></h3>
						</div>
					</div>
					<div class="card-body">
						<?php if ($this->session->flashdata('error')) { ?>
							<div class="alert alert-danger alert-dismissible text-left">
								<button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
								<h4><i class="icon fa fa-ban text-white"></i> Error!</h4>
								<?= $this->session->flashdata('error'); ?>
							</div>
						<?php } ?>
						<?php if ($this->session->flashdata('success')) { ?>
							<div class="input-group mb-3">
								<div class="alert alert-success alert-dismissible" style="width: 100%;">
									<button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
									<h6><i class="icon fa fa-check text-white"></i> Success!</h6>
									<?= $this->session->flashdata('success'); ?>
								</div>
							</div>
						<?php } ?>

						<div class="form-group row">
							<label class="col-form-label col-2 text-right">PIC</label>
							<div class="col-9">
								<?php foreach($list_pic as $p){ ?>
								<input type="" class="form-control mt-2" name="" value="<?= $p['NAMA_JABATAN'] ?>" disabled>
								<?php } ?>
							</div>
						</div>
						<div class="form-group row">
							<label class="col-form-label col-2 text-right">Terakhir Diubah Oleh</label>
							<div class="col-9">
								<input type="" class="form-control" name="" value="<?= $detail_rekomendasi['UPDATE_OLEH'] ?>" disabled>
							</div>
						</div>
						<div class="form-group row">
							<label class="col-form-label col-2 text-right">Judul Temuan</label>
							<div class="col-9">
								<div class="area" id="JUDUL_TEMUAN">
									<?= $detail_rekomendasi['JUDUL_TEMUAN'] ?>
								</div>
							</div>
						</div>
						<?php if($pic['PRIMARY'] == 'Y' || $is_auditor){ ?>
						<div class="form-group row">
							<label class="col-form-label col-2 text-right">Temuan</label>
							<div class="col-9">
								<div class="area" id="TEMUAN">
									<?= $detail_rekomendasi['TEMUAN'] ?>
								</div>
							</div>
						</div>
						<?php } ?>

						<div class="form-group row">
							<label class="col-form-label col-2 text-right">Rekomendasi</label>
							<div class="col-9">
								<div class="area" id="REKOMENDASI">
									<?= $detail_rekomendasi['REKOMENDASI'] ?>
								</div>
							</div>
						</div>
						<div class="form-group row">
							<label class="col-form-label col-2 text-right">Tindak Lanjut</label>
							<div class="col-9">
								<textarea name="HASIL_MONITORING" id="HASIL_MONITORING"></textarea>
							</div>
						</div>
						<div class="form-group row">
							<label class="col-form-label col-2 text-right">Dokumen Pendukung</label>
							<div class="col-9">
								<textarea name="DOKUMEN_PENDUKUNG" id="DOKUMEN_PENDUKUNG"></textarea>
							</div>
						</div>
						<div id="list_lampiran">
							<div class="form-group row">
								<label class="col-form-label col-2 text-right">Lampiran Dokumen Pendukung</label>
								<div class="col-9">
									<input <?= $disabled ?> type="file" class="form-control" placeholder="Lampiran" multiple="" name="lampiran[]" value="">
								</div>
								<?php if($readonly!='readonly'){ ?>
								<div class="col-1">
									<span style="cursor: pointer;" name="add_lampiran" id="add_lampiran" class="label font-weight-bold label-lg label-success label-inline mb-2 mt-2">+</span><br>
								</div>
								<?php } ?>
							</div>
						</div>
						<?php if($is_closing_audit){ ?>
						<div class="form-group row">
							<label class="col-form-label col-2 text-right">Tingkat Penyelesaian</label>
							<div class="col-9">
								<div class="radio-inline">
									<label class="radio radio-outline radio-success">
										<input type="radio" value="Selesai" name="TK_PENYELESAIAN">
										<span></span>Selesai</label>
									<label class="radio radio-outline radio-success">
										<input type="radio" value="STL" name="TK_PENYELESAIAN">
										<span></span>STL</label>
									<label class="radio radio-outline radio-success">
										<input type="radio" value="BTL" name="TK_PENYELESAIAN">
										<span></span>BTL</label>
									<label class="radio radio-outline radio-success">
										<input type="radio" value="TPTD" name="TK_PENYELESAIAN">
										<span></span>TPTD</label>
								</div>
							</div>
						</div>
						<div class="form-group row">
							<label class="col-form-label col-2 text-right">Tanggal Penyelesaian</label>
							<div class="col-9">
								<div class="form-label">
					                <div class="input-icon input-icon-right mb-2">
					                  <input <?= $disabled ?> autocomplete="off" placeholder="Tanggal Penyelesaian" type="text" value="<?= date('Y-m-d') ?>" id="TGL_PENYELESAIAN" name="TGL_PENYELESAIAN" class="form-control datepicker w-100">
					                  <span>
					                    <i class="fa fa-calendar"></i>
					                  </span>
					                </div>
					             </div>
							</div>
						</div>
						<?php } ?>
						<div id="data_lampiran" style="margin-left: 180px">
							<ol></ol>
						</div>
						

						<div class="separator separator-dashed mb-5"></div>
						<div class="form-group row">
							<label class="col-form-label col-2 text-right"></label>
							<div class="col-9">
								<?php // if($readonly!='readonly'){ ?>
								<button type="button" id="update" class="btn btn-light-primary font-weight-bold">Simpan perubahan</button>
								<?php // } ?>
								<?php if($is_closing_audit){ ?>
								<a target="_blank" href="<?= base_url('monitoring/update_hasil_monitoring/cetak/').$id_tl."/".$detail_rekomendasi['ID_REKOMENDASI'] ?>" class="btn btn-light-warning font-weight-bold">Cetak</a>
								<?php } ?>
								<a onclick="window.history.go(-1)" class="btn btn-light-danger font-weight-bold">Kembali</a>
							</div>
						</div>
					</div>
			</form>
		</div>
	</div>
</div>
</div>
<script type="text/javascript">

	function update() {
		$('#form').submit();
	}
	$(document).ready(function() {

		set_tinymce('HASIL_MONITORING', `<?= $detail_rekomendasi['HASIL_MONITORING'] ?>`, `<?= $readonly ?>`);
		set_tinymce('DOKUMEN_PENDUKUNG', `<?= $detail_rekomendasi['DOKUMEN_PENDUKUNG'] ?>`, `<?= $readonly ?>`);

		var i = 1;
		$('#add_lampiran').click(function() {
			i++;
			$('#list_lampiran').append('<div class="form-group row" id="row' + i + '"><div class="col-2"></div><div class="col-9"><input type="file" class="form-control" placeholder="Lampiran" name="lampiran[]" value=""></div><div class="col-1"><span style="cursor: pointer;" name="remove" id="' + i + '" class="btn-remove label font-weight-bold label-lg label-danger label-inline mt-2">-</span><br></div></div>');
		});
		$(document).on('click', '.btn-remove', function() {
			var button_id = $(this).attr("id");
			$("#row" + button_id + "").remove();
		});

		const tgl_selesai = '<?= $detail_rekomendasi['TGL_PENYELESAIAN'] ?>';
		if (tgl_selesai) {
			$('#TGL_PENYELESAIAN').val(tgl_selesai);
		}

		const pembuat_rekom = '<?= $detail_rekomendasi['ID_PEMBUAT_REKOM'] ?>';
		const user_login = '<?= $this->session->userdata("ID_USER") ?>';

		// if (pembuat_rekom !== user_login) {
		// 	$('#editor-a').css('background-color', '#f3f6f9');
		// 	$('input:radio[name=TK_PENYELESAIAN]').attr("disabled", true);
		// 	$('#TGL_PENYELESAIAN').attr("disabled", true);
		// 	$('input:file').attr("disabled", true);
		// 	$('#add_lampiran').css('display', 'none');
		// 	$('#update').css('display', 'none');
		// }

		$('input:radio[name=TK_PENYELESAIAN]').filter('[value="<?= $detail_rekomendasi['TK_PENYELESAIAN'] ?>"]').prop('checked', true);

		fetch(`<?= base_url() ?>/monitoring/update_hasil_monitoring/get_lampiran_hasil_monitoring_json/<?= $detail_rekomendasi['ID_REKOMENDASI'] ?>`, {method:'POST'})
			.then(response => response.json())
			.then(data => {
				const lampiran = [];
				let i = 1;
				data.map(item => {
					const file_name = item.FILE_NAME ? item.FILE_NAME : `Lampiran ${i}`;
					lampiran.push(`<li id="att-${i}"><a href="<?= base_url() ?>storage/upload/lampiran/hasil_monitoring/${item.ATTACHMENT}" target="_BLANK">${file_name}</a> | <a href="javascript:delete_att(${item.ID}, 'att-${i}')" class="text-danger">Hapus</a></li>`);
					i++;
				});
				$('#data_lampiran ol').append(lampiran.join(" "))
			})
			.catch(err => {
				alert('gagal load data, tutup dan coba lagi');
			});

		$('#update').click(() => {
			Swal.fire({
				text: 'Apakah Anda yakin mengupdate data ini ?',
				icon: 'question',
				showCancelButton: true,
				confirmButtonColor: '#3085d6',
				cancelButtonColor: '#d33',
				confirmButtonText: 'Ya',
				cancelButtonText: 'Batal'
			}).then((result) => {
				result.isConfirmed && $('#form').submit();
			})
		})
	});

	const delete_att = (key, id) => {
		Swal.fire({
			text: 'Apakah Anda yakin ?',
			icon: 'warning',
			showCancelButton: true,
			confirmButtonColor: '#3085d6',
			cancelButtonColor: '#d33',
			confirmButtonText: 'Ya',
			cancelButtonText: 'Batal'
		}).then((result) => {
			result.isConfirmed && (
				fetch(`<?= base_url() ?>monitoring/entry/delete_att_hasil_rekom/${key}`, {method:'POST'})
				.then(() => {
					$(`#${id}`).remove();
				})
				.catch(err => {
					alert('Gagal hapus data')
				})
			);
		})
	}
</script>
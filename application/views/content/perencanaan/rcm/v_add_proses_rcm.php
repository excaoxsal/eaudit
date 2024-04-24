<div class="content d-flex flex-column flex-column-fluid" id="kt_content">
	<div class="d-flex flex-column-fluid">
		<div class="container-fluid">
			<form class="form" id="form_addproses" method="post" enctype="multipart/form-data">
				<div class="form-group row">
					<label class="col-form-label col-3 text-right">Deskripsi Proses</label>
					<div class="col-9">
						<button type="button" class="btn btn-sm btn-primary mb-2 btn_modal_desc_resiko" data-toggle="modal" data-target="#modal_desc_resiko" aria-label="Close">Pilih Template</button>
						<textarea class="form-control" readonly name="DESKRIPSI_PROSES" id="DESKRIPSI_PROSES"></textarea>
					</div>
				</div>
				<div class="form-group row">
					<label class="col-form-label col-3 text-right">Deskripsi Risiko</label>
					<div class="col-9">
						<textarea class="form-control" readonly name="DESKRIPSI_RESIKO" id="DESKRIPSI_RESIKO"></textarea>
					</div>
				</div>
				<div class="form-group row">
					<label class="col-form-label col-3 text-right">Prioritas Risiko</label>
					<div class="col-9">
						<select class="form-control" id="PRIORITAS_RESIKO" name="PRIORITAS_RESIKO" readonly>
							<option value="">--Select--</option>
							<?php foreach ($list_resiko as $resiko) { ?>
								<option value="<?= $resiko['ID_RESIKO'] ?>"><?= $resiko['RESIKO'] ?></option>
							<?php } ?>
						</select>
					</div>
				</div>
				<div class="form-group row">
					<label class="col-form-label col-3 text-right">Kontrol Standar</label>
					<div class="col-9">
						<textarea name="KONTROL_STANDAR" class="form-control" readonly id="KONTROL_STANDAR"></textarea>
					</div>
				</div>
				<div class="form-group row">
					<label class="col-form-label col-3 text-right">Kontrol As - Is</label>
					<div class="col-9">
						<textarea name="KONTROL_AS_IS" class="form-control" readonly id="KONTROL_AS_IS"></textarea>
					</div>
				</div>
				<div class="form-group row">
					<label class="col-form-label col-3 text-right">Kontrol Should Be</label>
					<div class="col-9">
						<textarea name="KONTROL_SHOULD_BE" class="form-control" id="KONTROL_SHOULD_BE"></textarea>
					</div>
				</div>
				<div class="form-group row">
					<label class="col-form-label col-3 text-right">Auditee</label>
					<div class="col-9">
						<textarea name="AUDITEE" class="form-control" id="AUDITEE"></textarea>
					</div>
				</div>
				<div class="form-group row">
					<label class="col-form-label col-3 text-right">Tipe Kontrol</label>
					<div class="col-9">
						<?php $no_tk = 0;
						foreach ($list_tipe_kontrol as $tipe_kontrol) { ?>
							<!-- <div class="form-check">
								<input class="form-check-input" type="checkbox" name="TIPE_KONTROL[]" value="<?= $tipe_kontrol['TIPE_KONTROL'] ?>" id="TIPE_KONTROL<?= $no_tk ?>">
								<label class="form-check-label" for="TIPE_KONTROL<?= $no_tk ?>">
									<?= $tipe_kontrol['TIPE_KONTROL'] ?>
								</label>
							</div> -->
							<label class="checkbox checkbox-outline checkbox-outline-2x checkbox-primary mb-2">
			                    <input type="checkbox" name="TIPE_KONTROL[]" value="<?= $tipe_kontrol['TIPE_KONTROL'] ?>" id="TIPE_KONTROL<?= $no_tk ?>">
			                    <span></span>
			                    &nbsp;&nbsp;<?= $tipe_kontrol['TIPE_KONTROL'] ?>
			                </label>
						<?php $no_tk++;
						} ?>
					</div>
				</div>
				<div class="form-group row">
					<label class="col-form-label col-3 text-right">Frekuensi Kontrol</label>
					<div class="col-9">
						<?php $no_fk = 0;
						foreach ($list_frekuensi_kontrol as $frekuensi_kontrol) { ?>
							<!-- <div class="form-check">
								<input class="form-check-input" type="checkbox" name="FREKUENSI_KONTROL[]" value="<?= $frekuensi_kontrol['FREKUENSI_KONTROL'] ?>" id="FREKUENSI_KONTROL<?= $no_fk ?>">
								<label class="form-check-label" for="FREKUENSI_KONTROL<?= $no_fk ?>">
									<?= $frekuensi_kontrol['FREKUENSI_KONTROL'] ?>
								</label>
							</div> -->
							<label class="checkbox checkbox-outline checkbox-outline-2x checkbox-primary mb-2">
			                    <input type="checkbox" name="FREKUENSI_KONTROL[]" value="<?= $frekuensi_kontrol['FREKUENSI_KONTROL'] ?>" id="FREKUENSI_KONTROL<?= $no_fk ?>">
			                    <span></span>
			                    &nbsp;&nbsp;<?= $frekuensi_kontrol['FREKUENSI_KONTROL'] ?>
			                </label>
						<?php $no_fk++;
						} ?>
					</div>
				</div>
				<div class="form-group row">
					<label class="col-form-label col-3 text-right">Audit Program</label>
					<div class="col-9">
						<textarea name="AUDIT_PROGRAM" class="form-control" id="AUDIT_PROGRAM"></textarea>
					</div>
				</div>
				<div class="form-group row">
					<label class="col-form-label col-3 text-right">Ada Kelemahan</label>
					<div class="col-9">
						<select class="form-control" name="KELEMAHAN" id="KELEMAHAN">
							<option value="">--Select--</option>
							<option value="Ya">Ya</option>
							<option value="Tidak">Tidak</option>
						</select>
					</div>
				</div>
				<div class="form-group row">
					<label class="col-form-label col-3 text-right">Jumlah Sample</label>
					<div class="col-9">
						<textarea name="JML_SAMPLE" class="form-control" id="JML_SAMPLE"></textarea>
					</div>
				</div>
				<div class="form-group row">
					<label class="col-form-label col-3 text-right">Anggaran ManDays</label>
					<div class="col-9">
						<textarea name="ANGGARAN_MANDAYS" class="form-control" id="ANGGARAN_MANDAYS"></textarea>
					</div>
				</div>
				<div class="form-group row">
					<label class="col-form-label col-3 text-right">Referensi KKP</label>
					<div class="col-9">
						<textarea name="REFERENSI_KKP" class="form-control" id="REFERENSI_KKP"></textarea>
					</div>
				</div>
				<div class="separator separator-dashed mb-5"></div>
				<div class="form-group row">
					<label class="col-form-label col-3 text-right"></label>
					<div class="col-9">
						<a onclick="add_proses_save()" class="btn btn-primary font-weight-bold">Simpan</a>
						<button type="button" class="btn btn-danger" data-dismiss="modal" aria-label="Close">Close</button>
					</div>
				</div>
				<input type="hidden" name="ID_RCM_ADD_PROSES" id="ID_RCM_ADD_PROSES">
				<input type="hidden" name="ID_RCM" id="ID_RCM">
			</form>
		</div>
	</div>
</div>
<script type="text/javascript">
	$(document).ready(function() {
		// set_tinymce('DESKRIPSI_PROSES');
		// set_tinymce('DESKRIPSI_RESIKO');
		// set_tinymce('KONTROL_STANDAR');
		// set_tinymce('KONTROL_AS_IS');
		// set_tinymce('KONTROL_SHOULD_BE');
		// set_tinymce('AUDITEE');
		// set_tinymce('AUDIT_PROGRAM');
		// set_tinymce('JML_SAMPLE');
		// set_tinymce('ANGGARAN_MANDAYS');
		// set_tinymce('REFERENSI_KKP');
		// set_tinymce('KOMENTAR');
	});


	function add_proses_save() {
		Swal.fire({
			text: 'Apakah Anda yakin mengupdate data ini ?',
			icon: 'question',
			showCancelButton: true,
			confirmButtonColor: '#3085d6',
			cancelButtonColor: '#d33',
			confirmButtonText: 'Ya',
			cancelButtonText: 'Batal'
		}).then((result) => {
			if (result.value) {
				var form_data = $("#form_addproses").serialize();
				$.ajax({
					url: '<?= base_url() ?>/perencanaan/rcm/add_proses_save/',
					type: 'post',
					data: form_data,
					headers: {
						'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
					},
					success: function(data) {
						$('#modal_proses').modal('toggle');
						$("#tableProses").html(data);
						Swal.fire('Sukses!', 'Berhasil menyimpan / mengubah data!', 'success');
						// console.log(data);
						// window.location = data; 
					},
					error: function(data) {
						alert("Server Error");
					}
				});
			}
		})
	}
</script>
<div class="content d-flex flex-column flex-column-fluid" id="kt_content">
  <div class="subheader py-2 py-lg-4 subheader-solid" id="kt_subheader">
    <div class="container-fluid d-flex align-items-center justify-content-between flex-wrap flex-sm-nowrap">
      <div class="d-flex align-items-center flex-wrap mr-2">
        <h5 class="text-dark font-weight-bold mt-2 mb-2 mr-5"><?= APK_NAME ?></h5>
        <div class="subheader-separator subheader-separator-ver mt-2 mb-2 mr-4 bg-gray-200"></div>
        <span class="text-muted font-weight-bold mr-4">Perencanaan</span>
        <div class="subheader-separator subheader-separator-ver mt-2 mb-2 mr-4 bg-gray-200"></div>
        <span class="text-muted font-weight-bold mr-4">Kotak Keluar</span>
        <div class="subheader-separator subheader-separator-ver mt-2 mb-2 mr-4 bg-gray-200"></div>
        <span class="text-muted font-weight-bold mr-4">PKA</span>
        <div class="subheader-separator subheader-separator-ver mt-2 mb-2 mr-4 bg-gray-200"></div>
        <span class="text-muted font-weight-bold mr-4">Create</span>
      </div>
    </div>
  </div>
  <div class="d-flex flex-column-fluid">
    <div class="container">
		
        <form class="form" id="form_pka" method="post" enctype="multipart/form-data">  
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
						<label class="col-form-label col-3 text-right">Nomor SPA</label>
						<div class="col-9">
		                  <?php if(empty($data_pka)){ ?>
			                <select <?= $disabled ?> class="form-control" id="id_spa" name="ID_SPA">
			                  <option value="">--Pilih Nomor--</option>
			                  <?php 
			                  foreach ($nomor_spa as $nomor) { ?>
			                    <option value="<?= $nomor['ID_SPA'] ?>"><?= $nomor['NOMOR_SURAT'] ?></option>
			                  <?php } ?>
			                </select>
			                <?php }else{ ?>
			                    <input disabled type="text" value="<?= $nomor_surat ?>" class="form-control" placeholder="Nomor Surat">
			              <?php } ?>
						</div>
					</div>
					<div class="form-group row">
						<label class="col-form-label col-3 text-right">Nomor PKA</label>
						<div class="col-9">
             			 <input type="text" <?= $disabled_edit ?> value="<?= $data_pka->NOMOR_PKA ?>" class="form-control" name="NOMOR_PKA" id="NOMOR_PKA" placeholder="Nomor PKA">
						</div>
					</div>
					<div class="form-group row">
						<label class="col-form-label col-3 text-right"><b>I.</b> Pendahuluan</label>
						<div class="col-9">
							<textarea name="PENDAHULUAN" id="PENDAHULUAN"></textarea>
						</div>
					</div>
					<div class="form-group row">
						<label class="col-form-label col-3 text-right">Dilaksanakan Oleh</label>
						<div class="col-9">
              <input type="text" <?= $disabled ?> value="<?= $data_pka->PENDAHULUAN_DILAKSANAKAN ?>" class="form-control" placeholder="Dilaksanakan Oleh" name="PENDAHULUAN_DILAKSANAKAN" id="PENDAHULUAN_DILAKSANAKAN">
						</div>
					</div>
					<div class="form-group row">
						<label class="col-form-label col-3 text-right">Waktu yang Diperlukan</label>
						<div class="col-9">
             	<input type="text" <?= $disabled ?> value="<?= $data_pka->PENDAHULUAN_WAKTU ?>" class="form-control" placeholder="Waktu yang Diperlukan" name="PENDAHULUAN_WAKTU" id="PENDAHULUAN_WAKTU">
						</div>
					</div>
					<div class="separator separator-dashed mb-5"></div>
					<div class="form-group row">
						<label class="col-form-label col-3 text-right"><b>II.</b> Tujuan Audit</label>
						<div class="col-9">
							<textarea name="TUJUAN_AUDIT" id="TUJUAN_AUDIT"></textarea>
						</div>
					</div>
					<div class="form-group row">
						<label class="col-form-label col-3 text-right">Dilaksanakan Oleh</label>
						<div class="col-9">
              <input type="text" <?= $disabled ?> value="<?= $data_pka->TUJUAN_DILAKSANAKAN ?>" class="form-control" placeholder="Dilaksanakan Oleh" name="TUJUAN_DILAKSANAKAN" id="TUJUAN_DILAKSANAKAN">
						</div>
					</div>
					<div class="form-group row">
						<label class="col-form-label col-3 text-right">Waktu yang Diperlukan</label>
						<div class="col-9">
       				<input type="text" <?= $disabled ?> value="<?= $data_pka->TUJUAN_WAKTU ?>" class="form-control" placeholder="Waktu yang Diperlukan" name="TUJUAN_WAKTU" id="TUJUAN_WAKTU">
						</div>
					</div>
					<div class="separator separator-dashed mb-5"></div>
					<div class="form-group row">
						<label class="col-form-label col-3 text-right"><b>III.</b> Sasaran</label>
						<div class="col-9">
							<textarea name="SASARAN_AUDIT" id="SASARAN_AUDIT"></textarea>
						</div>
					</div>
					<div class="form-group row">
						<label class="col-form-label col-3 text-right">Dilaksanakan Oleh</label>
						<div class="col-9">
       				<input type="text" <?= $disabled ?> value="<?= $data_pka->SASARAN_DILAKSANAKAN ?>" class="form-control" placeholder="Dilaksanakan Oleh" name="SASARAN_DILAKSANAKAN" id="SASARAN_DILAKSANAKAN">
						</div>
					</div>
					<div class="form-group row">
						<label class="col-form-label col-3 text-right">Waktu yang Diperlukan</label>
						<div class="col-9">
       				<input type="text" <?= $disabled ?> value="<?= $data_pka->SASARAN_WAKTU ?>" class="form-control" placeholder="Waktu yang Diperlukan" name="SASARAN_WAKTU" id="SASARAN_WAKTU">
						</div>
					</div>
					<div class="separator separator-dashed mb-5"></div>
          <div class="form-group row">
						<label class="col-form-label col-3 text-right"><b>IV.</b> Instruksi - Instruksi</label>
						<div class="col-9">
							<textarea name="INSTRUKSI_AUDIT" id="INSTRUKSI_AUDIT"></textarea>
						</div>
					</div>
					<div class="form-group row">
						<label class="col-form-label col-3 text-right">Dilaksanakan Oleh</label>
						<div class="col-9">
       				<input type="text" <?= $disabled ?> value="<?= $data_pka->INSTRUKSI_DILAKSANAKAN ?>" class="form-control" placeholder="Dilaksanakan Oleh" name="INSTRUKSI_DILAKSANAKAN" id="INSTRUKSI_DILAKSANAKAN">
						</div>
					</div>
					<div class="form-group row">
						<label class="col-form-label col-3 text-right">Waktu yang Diperlukan</label>
						<div class="col-9">
       				<input type="text" <?= $disabled ?> value="<?= $data_pka->INSTRUKSI_WAKTU ?>" class="form-control" placeholder="Waktu yang Diperlukan" name="INSTRUKSI_WAKTU" id="INSTRUKSI_WAKTU">
						</div>
					</div>
					<div class="form-group row">
						<label class="col-form-label col-3 text-right">Tempat</label>
						<div class="col-9">
             			 <input type="text" <?= $disabled ?> value="<?= $data_pka->TEMPAT ?>" class="form-control" name="TEMPAT" id="TEMPAT" placeholder="Tempat">
						</div>
					</div>
					<div class="form-group row">
						<label class="col-form-label col-3 text-right">Tanggal PKA</label>
						<div class="col-9">
							<div class="form-label">
				                <div class="input-icon input-icon-right mb-2">
				                  <input autocomplete="off" placeholder="Tanggal PKA" type="text" value="<?= $data_pka->TANGGAL ?>" name="TANGGAL" id="TANGGAL" class="form-control datepicker w-100">
				                  <span>
				                    <i class="fa fa-calendar"></i>
				                  </span>
				                </div>
				             </div>
						</div>
					</div>
					
					<?php if(isset($_GET['review'])){ ?>
						<div class="form-group row">
							<label class="col-form-label col-3 text-right">Komentar</label>
							<div class="col-9">
								<textarea name="KOMENTAR" id="KOMENTAR"></textarea>
							</div>
						</div>
						<div class="separator separator-dashed mb-5"></div>
						<div class="form-group row">
							<div class="col-9 offset-3">
								<label class="col-form-label text-right"><h6><b>Log History</b></h6></label>
								<div class="timeline timeline-justified timeline-4 mb-5">
				                <div class="timeline-bar"></div>
				                <div class="timeline-items">
				                  <?php if(!empty($data_log)) {
				                    foreach ($data_log as $value) { ?>
				                    <div class="timeline-item">
				                        <div class="timeline-badge">
				                            <div class="bg-primary"></div>
				                        </div>

				                        <div class="timeline-label">
				                            <span class="text-primary font-weight-bold"><?= $value['TGL_LOG'] ?></span>
				                        </div>

				                        <div class="timeline-content">
				                            <?= $value['LOG'] ?>
				                        </div>
				                    </div>
				                  <?php } } ?>
				                </div>
				              </div>
							</div>
						</div>
					<?php } ?>
					<?php if ($data_pka->ID_STATUS == 4) {?>
						<div class="form-group row">
							<div class="col-9 offset-3">
								<label class="col-form-label text-right"><h6><b>Log History</b></h6></label>
								<div class="log" style="height:100px; background-color:#F3F6F9; border: 1px solid #1E1E2D; overflow-y:scroll; padding:10px">
									<?php if(!empty($data_log)) {
										foreach ($data_log as $value) {
											echo $value['TGL_LOG'].' - '.$value['LOG'] . '<br>';
										}
									} ?>
								</div>
							</div>
						</div>
					<?php } ?>
					
          <div class="form-group row">
            <label class="col-form-label col-3 text-right"></label>
            <div class="col-9">
							<?php if(isset($_GET['review'])){ ?>
								<?php if($data_pka->ID_PKA != ''){ ?>
								<a target="_blank" href="<?= base_url() ?>perencanaan/pka/cetak_preview/<?= $data_pka->ID_PKA ?>" class="btn btn-light-primary font-weight-bold">Preview</a>
							<?php } ?>
							<?php if($status_pemeriksa != '2'){ ?>
								<a onclick="submitButton(3)" class="btn btn-light-success font-weight-bold">Approve</a>
								<a onclick="submitButton(4)" class="btn btn-light-warning font-weight-bold">Reject</a>
							<?php } ?>
								<a onclick="back('<?= $data_pka->ID_PKA ?>')" class="btn btn-light-danger font-weight-bold">Kembali</a>
							<?php }else { ?>
								<?php if($data_pka->ID_PKA != ''){ ?>
								<a target="_blank" href="<?= base_url() ?>perencanaan/pka/cetak_preview/<?= $data_pka->ID_PKA ?>" class="btn btn-light-primary font-weight-bold">Preview</a>
							<?php } ?>
								<?php if ($data_pka->ID_STATUS != 2 && $data_pka->ID_STATUS != 3) {?>
									<a onclick="save('<?= $data_pka->ID_PKA ?>', 1)" class="btn btn-light-success font-weight-bold">Simpan</a>
									<a onclick="save('<?= $data_pka->ID_PKA ?>', 2)" class="btn btn-light-warning font-weight-bold">Kirim</a>
								<?php } ?>
								<a onclick="back()" class="btn btn-light-danger font-weight-bold">Kembali</a>
							<?php } ?>

            </div>
          </div>
				</div>
        </form>
      </div>
    </div>
  </div>
</div>
<script type="text/javascript">
$(document).ready(function() {
  
  set_tinymce('PENDAHULUAN', '<?= $data_pka->PENDAHULUAN ?>');
  set_tinymce('TUJUAN_AUDIT', '<?= $data_pka->TUJUAN_AUDIT ?>');
  set_tinymce('SASARAN_AUDIT', '<?= $data_pka->SASARAN_AUDIT ?>');
  set_tinymce('INSTRUKSI_AUDIT', '<?= $data_pka->INSTRUKSI_AUDIT ?>');
  set_tinymce('KOMENTAR', '');
  
  $('#id_spa').select2().on('change', function (e) {
      $(this).valid();
    });
});


function save(id, action)
{
	Swal.fire({
	text: 'Apakah Anda yakin mengupdate data ini ?',
	icon: 'warning',
	showCancelButton: true,
	confirmButtonColor: '#3085d6',
	cancelButtonColor: '#d33',
	confirmButtonText: 'Ya',
	cancelButtonText: 'Batal'
	}).then((result) => {
		if (result.value) {
			var obj = {ACTION: action};
			if (id) {
				obj.ID_PKA = id;
			}
			var form_data = $("#form_pka").serialize() + '&' + $.param(obj);
			$.ajax({
				url: '<?= base_url() ?>/perencanaan/pka/simpan/',
				type: 'post',
				data: form_data,
				headers: {
					'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
				},
				success: function(data) {
					window.location = data;	
				},
				error: function(data){
					Swal.fire("Gagal menyimpan data!", "Pastika semua kolom terisi!", "error");
				}
			});
		}
	})
}

function submitButton(action){
	Swal.fire({
	  text: 'Yakin melakukan aksi ini ?',
	  icon: 'warning',
	  showCancelButton: true,
	  confirmButtonColor: '#3085d6',
	  cancelButtonColor: '#d33',
	  confirmButtonText: 'Ya',
	  cancelButtonText: 'Batal'
	}).then((result) => {
	  if (result.value) {
				var obj = {ACTION: action};
				var form_data = $("#form_pka").serialize() + '&' + $.param(obj);
				$.ajax({
						url: '<?= base_url() ?>/perencanaan/pka/approve_reject/<?= $data_pka->ID_PKA ?>',
						type: 'post',
						data: form_data,
						headers: {
							'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
						},
						success: function(data) {
								// console.log(data);
								window.location = data;
						},
						error: function(data){
								Swal.fire("Gagal menyimpan data!", "Pastika semua kolom terisi!", "error");
						}
				});
	  }
	})
}

function back(id) { 
	if (id) {
		window.location = '<?= base_url() ?>perencanaan/pka/kotak_masuk'
	}else {
		window.location = '<?= base_url() ?>perencanaan/pka/kotak_keluar'
	}
}
</script>

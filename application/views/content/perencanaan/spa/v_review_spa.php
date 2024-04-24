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
        <span class="text-muted font-weight-bold mr-4">SPA</span>
        <div class="subheader-separator subheader-separator-ver mt-2 mb-2 mr-4 bg-gray-200"></div>
        <span class="text-muted font-weight-bold mr-4">Review</span>
      </div>
    </div>
  </div>
  <div class="d-flex flex-column-fluid">
    <div class="container">
        <form class="form" id="form_spa" method="post">  
        <div class="card card-custom">
          <div class="card-header">
            <div class="card-title">
              <h3 class="card-label"><?= $title ?></h3>
            </div>
            
          </div>
          <div class="card-body">
          <div class="form-group row">
            <label class="col-form-label col-3 text-right">Nomor Surat</label>
            <div class="col-8">
              <input type="text" class="form-control form-control-solid" disabled  name="NOMOR_SURAT" value="<?= $spa_detail->NOMOR_SURAT ?>">
            </div>
          </div>
          <div class="form-group row">
              <label class="col-form-label col-3 text-right">Auditee</label>
              <div class="col-8">
                <div class="form-label">
                  <select <?= $disabled ?> class="form-control select-dua" id="AUDITEE" name="AUDITEE" required>
                  <option value="">--Pilih--</option>
                  <?php foreach ($list_divisi as $data) { ?>
                    <option <?= $disabled ?> <?= $data['ID_DIVISI'] == $spa_detail->AUDITEE ? 'selected' : ''; ?> value="<?= $data['ID_DIVISI'] ?>"><?= $data['NAMA_DIVISI'] ?></option>
                  <?php } ?>
                </select>
                </div>
              </div>
            </div>
            <div class="form-group row">
              <label class="col-form-label col-3 text-right">Tahun Audit</label>
              <div class="col-8">
                <div class="form-label">
                  <input type="text" value="<?= $spa_detail->TAHUN_AUDIT ?>" <?= $disabled ?> class="form-control datepicker-year" name="TAHUN_AUDIT" placeholder="Tahun Audit" required>
                </div>
              </div>
            </div>
          <div id="list_auditee">
            <div class="form-group row">
              <label class="col-form-label col-3 text-right">Dasar</label>
              <div class="col-8">
                <textarea <?= $disabled ?> class="form-control" name="PESERTA[]" id="nama_auditee"><?= $peserta[0]['DASAR']  ?></textarea>
              </div>
              <div class="col-1">
                <span style="cursor: pointer;<?= ($disabled == 'disabled') ? 'display:none' : '' ?>" name="add_auditee" id="add_auditee" class="label font-weight-bold label-lg label-success label-inline mt-2">+</span><br>
              </div>
              
            </div>
          </div>
          <div id="list_tim_audit">
            <div class="form-group row">
              <label class="col-form-label col-3 text-right">Diperintahkan kepada</label>
              <div class="col-4">
                <select <?= $disabled ?> class="form-control" id="tim_audit" name="TIM_AUDIT[]">
									<option value="">--Pilih User--</option>
									<?php if(!empty($tim_audit)) { ?>
									<option selected value="<?= $tim_audit[0]['ID_USER'] ?>"><?= $tim_audit[0]['NAMA'] ?></option>
                  <?php } foreach($list_user as $user){ ?>
                  <option value="<?= $user['ID_USER'] ?>"><?= $user['NAMA'] ?></option>
                  <?php } ?>
                </select>
              </div>
              <div class="col-4">
                <select <?= $disabled ?> class="form-control" id="jabatan_tim" name="JABATAN_TIM[]">
								<option value="">--Pilih Jabatan--</option>
									<?php if(!empty($tim_audit)) { 
										$jabatan = ['Ketua Tim', 'Pengawas', 'Anggota Tim'];
										$value = $tim_audit[0]['JABATAN'];
									?>
									<option selected value="<?= $value ?>"><?= $jabatan[$value-1] ?></option>
                  <?php } ?>
                  <option value="1">Ketua Tim</option>
                  <option value="2">Pengawas</option>
                  <option value="3">Anggota Tim</option>
                </select>
              </div>
              <div style="<?= ($disabled == 'disabled') ? 'display:none' : '' ?>" class="col-1">
                <span style="cursor: pointer;" name="add_tim_audit" id="add_tim_audit" class="label font-weight-bold label-lg label-success label-inline mt-2">+</span><br>
              </div>
            </div>
          </div>
          <div class="form-group row">
              <label class="col-form-label col-3 text-right">Periode Audit</label>
              <div class="col-lg-4 col-md-11">
                <div class="form-label">
                  <div class="input-icon input-icon-right mb-2">
                    <input autocomplete="off" placeholder="Periode Awal" type="text" <?= $disabled ?> value="<?= $spa_detail->PERIODE_AUDIT_AWAL ?>"  name="PERIODE_AUDIT_AWAL" required class="form-control datepicker w-100">
                    <span>
                      <i class="fa fa-calendar"></i>
                    </span>
                  </div>
                </div>
              </div>
              <!-- <p class="my-auto">s/d</p> -->
              <div class="col-lg-4 col-md-11">
                <div class="form-label">
                  <div class="input-icon input-icon-right mb-2">
                    <input autocomplete="off" placeholder="Periode Selesai" type="text" <?= $disabled ?> type="date" value="<?= $spa_detail->PERIODE_AUDIT_AKHIR ?>" name="PERIODE_AUDIT_AKHIR" required class="form-control datepicker w-100">
                    <span>
                      <i class="fa fa-calendar"></i>
                    </span>
                  </div>
                </div>
              </div>
            </div>

            <div class="form-group row">
              <label class="col-form-label col-3 text-right">Masa Audit</label>
              <div class="col-lg-4 col-md-11">
                <div class="form-label">
                  <div class="input-icon input-icon-right mb-2">
                    <input autocomplete="off" placeholder="Tanggal Awal Masa Audit" type="text" <?= $disabled ?> value="<?= $spa_detail->MASA_AUDIT_AWAL ?>"  name="MASA_AUDIT_AWAL" required class="form-control datepicker w-100">
                    <span>
                      <i class="fa fa-calendar"></i>
                    </span>
                  </div>
                </div>
              </div>
              <!-- <p class="my-auto">s/d</p> -->
              <div class="col-lg-4 col-md-11">
                <div class="form-label">
                  <div class="input-icon input-icon-right mb-2">
                    <input autocomplete="off" placeholder="Tanggal Akhir Masa Audit" type="text" <?= $disabled ?> type="date" value="<?= $spa_detail->MASA_AUDIT_AKHIR ?>" name="MASA_AUDIT_AKHIR" required class="form-control datepicker w-100">
                    <span>
                      <i class="fa fa-calendar"></i>
                    </span>
                  </div>
                </div>
              </div>
            </div>
            <div class="form-group row">
              <label class="col-form-label col-3 text-right">Jumlah Hari Masa Audit</label>
              <div class="col-lg-4 col-md-11">
                <div class="form-label">
                  <input type="number" value="<?= $spa_detail->TOTAL_HARI_AUDIT ?>" name="TOTAL_HARI_AUDIT" class="form-control" <?= $disabled ?> required>
                </div>
              </div>
              <!-- <p class="my-auto">s/d</p> -->
              <div class="col-lg-4 col-md-11">
                <div class="form-label">
                  <select role="button" name="TOTAL_HARI_AUDIT_KET" class="form-control" <?= $disabled ?> required>
                    <option value="">--Pilih--</option>
                    <option <?= $spa_detail->TOTAL_HARI_AUDIT_KET == 'Hari Kerja' ? 'selected' : '' ; ?> value="Hari Kerja">Hari Kerja</option>
                    <option <?= $spa_detail->TOTAL_HARI_AUDIT_KET == 'Hari Kalender' ? 'selected' : '' ; ?> value="Hari Kalender">Hari Kalender</option>
                  </select>
                </div>
              </div>
            </div>
          <div id="list_perintah">
            <div class="form-group row">
              <label class="col-form-label col-3 text-right">Isi Perintah</label>
              <div class="col-8">
                <textarea <?= $disabled ?> class="form-control" name="PERINTAH[]" id="nama_perintah"><?= $perintah[0]['PERINTAH']  ?></textarea>
              </div>
              <div class="col-1">
                <span style="cursor: pointer;<?= ($disabled == 'disabled') ? 'display:none' : '' ?>" name="add_perintah" id="add_perintah" class="label font-weight-bold label-lg label-success label-inline mt-2">+</span><br>
              </div>
              
            </div>
          </div>
          <div class="form-group row">
            <label class="col-form-label col-3 text-right">Perintah Selesai.</label>
            <div class="col-8">
            </div>
          </div>
					<div class="form-group row">
            <label class="col-form-label col-3 text-right">Dikeluarkan di</label>
            <div class="col-8">
              <input type="text" <?= $disabled ?> class="form-control" id="dikeluarkan" placeholder="Ex : Jakarta" name="DIKELUARKAN" value="<?= $spa_detail->DIKELUARKAN ?>">
            </div>
          </div>
          <div id="list_tembusan">
              <div class="form-group row">
                <label class="col-form-label col-3 text-right">Tembusan</label>
                <div class="col-8">
                  <input type="text" class="form-control" <?= $disabled ?> name="TEMBUSAN[]" id="nama_tembusan" value="<?= $tembusan[0]['TEMBUSAN']  ?>">
                </div>
                <div class="col-1">
                  <?php if ($disabled != 'disabled') { ?>
                    <span style="cursor: pointer;" name="add_tembusan" id="add_tembusan" class="label font-weight-bold label-lg label-success label-inline mt-2">+</span><br>
                  <?php } ?>
                </div>

              </div>
            </div>
					<!-- <div class="form-group row">
            <label class="col-form-label col-3 text-right">Pada Tanggal</label>
            <div class="col-4">
							<input class="form-control" <?= $disabled ?> type="date" name="PADA_TANGGAL" value="<?= $spa_detail->PADA_TANGGAL ?>">
            </div>
          </div> -->
					<div class="form-group row">
						<label class="col-form-label col-3 text-right">Komentar</label>
						<div class="col-8">
              <textarea class="form-control" name="KOMENTAR" id="KOMENTAR"></textarea>
						</div>
					</div>
					<div class="separator separator-dashed mb-5"></div>
					<div class="form-group row">
						<div class="col-8 offset-3">
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

          <div class="form-group row">
            <label class="col-form-label col-3 text-right"></label>
            <div class="col-8">
              <a target="_blank" href="<?= base_url() ?>perencanaan/spa/cetak_preview?id=<?= base64_encode($spa_detail->ID_SPA) ?>" class="btn btn-light-primary font-weight-bold">Preview</a>
              <?php if($status_approver->STATUS_APPROVER == 1){ ?>
              <button onclick="submitButton(4)" type="button" class="btn btn-light-warning font-weight-bold">Reject</button>
							<a onclick="submitButton(3)" class="btn btn-light-success font-weight-bold">Approve</a>
              <?php } ?>
							<a onclick="back()" class="btn btn-light-danger font-weight-bold">Kembali</a>
            </div>
          </div>
        </div>
        </form>
      </div>
    </div>
  </div>
</div>

<script type="text/javascript">
	$(document).ready(function(){
		var i = 1;
		var tim_audit = '<?= json_encode($tim_audit) ?>';
		var disabled = '<?= $disabled ?>';
		tim_audit = JSON.parse(tim_audit);
		if (tim_audit) {
			var jabatan = ['Ketua Tim', 'Pengawas', 'Anggota Tim'];
			tim_audit.splice(0, 1);
			tim_audit.forEach(element => {
				i++
				$('#list_tim_audit').append('<div class="form-group row" id="row'+i+'"><label class="col-form-label col-3 text-right"></label><div class="col-4"><select '+disabled+' class="form-control" id="tim_audit" name="TIM_AUDIT[]"><option value="">--Pilih User--</option><option selected value="'+element.ID_USER+'">'+element.NAMA+'</option><?php foreach($list_user as $user){ ?><option value="<?= $user['ID_USER'] ?>"><?= $user['NAMA'] ?></option><?php } ?></select></div><div class="col-4"><select '+disabled+' class="form-control" id="jabatan_tim" name="JABATAN_TIM[]"><option value="">--Pilih Jabatan--</option><option selected value="'+element.JABATAN+'">'+jabatan[element.JABATAN-1]+'</option><option value="1">Ketua Tim</option><option value="2">Pengawas</option><option value="3">Anggota Tim</option></select></div><div class="col-1"><span style="cursor: pointer; <?= ($disabled == 'disabled') ? 'display:none' : '' ?>" name="remove" id="'+i+'" class="btn-remove label font-weight-bold label-lg label-danger label-inline mt-2">-</span><br></div></div>');
			});
		}
    var peserta = '<?= json_encode($peserta) ?>';
    peserta = JSON.parse(peserta);
    if (peserta) {
      peserta.splice(0, 1);
      peserta.forEach(element => {
        i++
        $('#list_auditee').append('<div class="form-group row" id="row'+i+'"><label class="col-form-label col-3 text-right"></label><div class="col-8"><textarea <?= $disabled ?> class="form-control" name="PESERTA[]" id="nama_auditee">'+element.DASAR+'</textarea></div><div class="col-1"><span style="cursor: pointer;<?= ($disabled == 'disabled') ? 'display:none' : '' ?>" name="remove" id="'+i+'" class="btn-remove label font-weight-bold label-lg label-danger label-inline mt-2">-</span><br></div></div>');
      });
    }
    var perintah = '<?= json_encode($perintah) ?>';
    perintah = JSON.parse(perintah);
    if (perintah) {
      perintah.splice(0, 1);
      perintah.forEach(element => {
        i++
        $('#list_perintah').append('<div class="form-group row" id="row'+i+'"><label class="col-form-label col-3 text-right"></label><div class="col-8"><textarea <?= $disabled ?> class="form-control" name="PERINTAH[]" id="nama_perintah">'+element.PERINTAH+'</textarea></div><div class="col-1"><span style="cursor: pointer;<?= ($disabled == 'disabled') ? 'display:none' : '' ?>" name="remove" id="'+i+'" class="btn-remove label font-weight-bold label-lg label-danger label-inline mt-2">-</span><br></div></div>');
      });
    }
    var tembusan = '<?= json_encode($tembusan) ?>';
    tembusan = JSON.parse(tembusan);
    if (tembusan) {
      tembusan.splice(0, 1);
      tembusan.forEach(element => {
        i++
        $('#list_tembusan').append('<div class="form-group row" id="row' + i + '"><label class="col-form-label col-3 text-right"></label><div class="col-8"><input type="text" <?= $disabled ?> class="form-control" name="TEMBUSAN[]" id="nama_tembusan" value="' + element.TEMBUSAN + '"></div><div class="col-1"><span style="cursor: pointer;<?= ($disabled == 'disabled') ? 'display:none' : '' ?>" name="remove" id="' + i + '" class="btn-remove label font-weight-bold label-lg label-danger label-inline mt-2">-</span><br></div></div>');
      });
    }
    $('#add_tembusan').click(function() {
      i++;
      $('#list_tembusan').append('<div class="form-group row" id="row' + i + '"><label class="col-form-label col-3 text-right"></label><div class="col-8"><input type="text" class="form-control" name="TEMBUSAN[]" id="nama_tembusan"></div><div class="col-1"><span style="cursor: pointer;" name="remove" id="' + i + '" class="btn-remove label font-weight-bold label-lg label-danger label-inline mt-2">-</span><br></div></div>');
    });
    $('#add_auditee').click(function(){
      i++;
      $('#list_auditee').append('<div class="form-group row" id="row'+i+'"><label class="col-form-label col-3 text-right"></label><div class="col-8"><textarea class="form-control" name="PESERTA[]" id="nama_auditee"></textarea></div><div class="col-1"><span style="cursor: pointer;" name="remove" id="'+i+'" class="btn-remove label font-weight-bold label-lg label-danger label-inline mt-2">-</span><br></div></div>');
    });
    $('#add_perintah').click(function(){
      i++;
      $('#list_perintah').append('<div class="form-group row" id="row'+i+'"><label class="col-form-label col-3 text-right"></label><div class="col-8"><textarea class="form-control" name="PERINTAH[]" id="nama_perintah"></textarea></div><div class="col-1"><span style="cursor: pointer;" name="remove" id="'+i+'" class="btn-remove label font-weight-bold label-lg label-danger label-inline mt-2">-</span><br></div></div>');
    });
    $('#add_tim_audit').click(function(){
      i++;
      $('#list_tim_audit').append('<div class="form-group row" id="row'+i+'"><label class="col-form-label col-3 text-right"></label><div class="col-4"><select class="form-control" id="tim_audit" name="TIM_AUDIT[]"><option value="">--Pilih User--</option><?php foreach($list_user as $user){ ?><option value="<?= $user['ID_USER'] ?>"><?= $user['NAMA'] ?></option><?php } ?></select></div><div class="col-4"><select class="form-control" id="jabatan_tim" name="JABATAN_TIM[]"><option value="">--Pilih Jabatan--</option><option value="1">Ketua Tim</option><option value="2">Pengawas</option><option value="3">Anggota Tim</option></select></div><div class="col-1"><span style="cursor: pointer;" name="remove" id="'+i+'" class="btn-remove label font-weight-bold label-lg label-danger label-inline mt-2">-</span><br></div></div>');
    });
    $(document).on('click', '.btn-remove', function(){
      var button_id   = $(this).attr("id");
      $("#row"+button_id+"").remove();
    }); 
  });

  function submitButton(status)
  {
    Swal.fire({
      text: 'Yakin melakukan aksi ini ?',
      icon: 'question',
      showCancelButton: true,
      confirmButtonColor: '#3085d6',
      cancelButtonColor: '#d33',
      confirmButtonText: 'Ya',
      cancelButtonText: 'Batal'
    }).then((result) => {
      if (result.value) {
				var obj = {
					"STATUS": status,
				};
				var form_data = $("#form_spa").serialize() + '&' + $.param(obj);
				$.ajax({
						url: '<?= base_url() ?>perencanaan/spa/kirim/<?= $spa_detail->ID_SPA ?>',
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
								Swal.fire("Server Error", '','error');
						}
				});
      }
    })
	}
	function back() { 
		window.location = '<?= base_url() ?>perencanaan/spa/kotak_masuk'
	}
</script>


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
        <span class="text-muted font-weight-bold mr-4">APM</span>
        <div class="subheader-separator subheader-separator-ver mt-2 mb-2 mr-4 bg-gray-200"></div>
        <span class="text-muted font-weight-bold mr-4">Create</span>
      </div>
    </div>
  </div>
  <div class="d-flex flex-column-fluid">
    <div class="container">

        <form class="form" id="form_apm" method="post" enctype="multipart/form-data">  
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
           <h6 class="text-left my-5 mb-10">Header</h6>
          <div class="form-group row">
            <label class="col-form-label col-3 text-left">Nomor SPA</label>
            <div class="col-8">
              <?php if(empty($data_apm)){ ?>
              <select class="form-control select-dua" id="id_spa" name="ID_SPA">
                <option value="">--Pilih Nomor--</option>
                <?php 
                foreach ($nomor_spa as $nomor) { ?>
                  <option value="<?= $nomor['ID_SPA'] ?>"><?= $nomor['NOMOR_SURAT'] ?></option>
                <?php } ?>
              </select>
              <?php }else{ ?>
                <input type="text" disabled value="<?= $nomor_surat ?>" class="form-control">
              <?php } ?>
            </div>
          </div>
          <div class="form-group row">
            <label class="col-form-label col-3 text-left">Nama Audit</label>
            <div class="col-8">
              <input type="text" <?= $disabled ?> value="<?= $data_apm->NAMA_AUDIT ?>" class="form-control" name="NAMA_AUDIT" id="NAMA_AUDIT" placeholder="Nama Audit">
            </div>
          </div>
          <div class="form-group row">
            <label class="col-form-label col-3 text-left">Tanggal</label>
            <div class="col-lg-4 col-md-11">
              <div class="form-label">
                <div class="input-icon input-icon-right mb-2">
                  <input autocomplete="off" placeholder="Periode Awal" type="text" <?= $disabled ?> value="<?= $data_apm->TGL_PERIODE_MULAI ?>"  name="TGL_PERIODE_MULAI" required class="form-control datepicker w-100">
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
                  <input autocomplete="off" placeholder="Periode Selesai" type="text" <?= $disabled ?> type="date" value="<?= $data_apm->TGL_PERIODE_SELESAI ?>" name="TGL_PERIODE_SELESAI" required class="form-control datepicker w-100">
                  <span>
                    <i class="fa fa-calendar"></i>
                  </span>
                </div>
              </div>
            </div>
          </div>

          <h6 class="text-left my-10 mt-20">Tujuan dan Ruang Lingkup Audit</h6>
          <div class="form-group row">
            <label class="col-form-label col-3 text-left">Tujuan</label>
            <div class="col-8">
              <textarea name="TUJUAN" id="TUJUAN"></textarea>
            </div>
          </div>
          <div class="form-group row">
            <label class="col-form-label col-3 text-left">Ruang Lingkup</label>
            <div class="col-8">
              <textarea name="RUANG_LINGKUP" id="RUANG_LINGKUP"></textarea>
            </div>
          </div>
          <div class="form-group row">
            <label class="col-form-label col-3 text-left">Periode yang diaudit</label>
            <div class="col-8">
              <textarea name="PERIODE_AUDIT" id="PERIODE_AUDIT"></textarea>
            </div>
          </div>
          <h6 class="text-left my-10 mt-20">Latar Belakang</h6>
          <div class="form-group row">
            <label class="col-form-label col-3 text-left">Deskripsi singkat mengenai Auditee</label>
            <div class="col-8">
              <textarea name="DESKRIPSI_TEXT" id="DESKRIPSI_TEXT"></textarea>
            </div>
          </div>
          <div class="form-group row">
            <label class="col-form-label col-3 text-left">Proses Bisnis</label>
            <div class="col-8">
              <textarea name="PROSES_BISNIS_TEXT" id="PROSES_BISNIS_TEXT"></textarea>
            </div>
          </div>
          <div class="form-group row">
            <label class="col-form-label col-3 text-left">Risiko</label>
            <div class="col-8">
              <textarea name="RESIKO" id="RESIKO"></textarea>
            </div>
          </div>
          <div class="form-group row">
            <label class="col-form-label col-3 text-left">Catatan dari audit sebelumnya</label>
            <div class="col-8">
              <textarea name="CATATAN" id="CATATAN"></textarea>
            </div>
          </div>
          <div class="form-group row">
            <label class="col-form-label col-3 text-left">Review Analitis</label>
            <div class="col-8">
              <textarea name="REVIEW_ANALISIS" id="REVIEW_ANALISIS"></textarea>
            </div>
          </div>
          <div class="form-group row">
            <label class="col-form-label col-3 text-left">Berita & Aturan</label>
            <div class="col-8">
              <textarea name="BERITA_ATURAN" id="BERITA_ATURAN"></textarea>
            </div>
          </div>
          <h6 class="text-left my-10 mt-20">Risiko Potensial</h6>
          <div class="form-group row">
            <label class="col-form-label col-3 text-left">Daftar Risiko</label>
            <div class="col-8">
              <textarea name="DAFTAR_RESIKO_POTENSIAL" id="DAFTAR_RESIKO_POTENSIAL"></textarea>
            </div>
          </div>
					<h6 class="text-left my-10 mt-20">Tim Audit</h6>
					<?php 
						$jabatan = ['','Ketua Tim', 'Pengawas', 'Anggota Tim'];
						// print_r($tim_audit);
						foreach($tim_audit as $data){ 
						?>
						<div class="form-group row">
              <label class="col-form-label col-3 text-left"><?= $jabatan[$data['JABATAN']] ?></label>
              <div class="col-8">
                <input class="form-control" disabled type="text" value="<?= $data['NAMA'] ?>">
              </div>
            </div>
						<?php } ?>
            <?php if(empty($data_apm)){ ?>
						<div id="tim_audit">
              <div class="alert alert-custom alert-light-warning fade show" role="alert">
                <div class="alert-icon"><i class="fa fa-exclamation-triangle"></i></div>
                <div class="alert-text">Tim Audit otomatis terisi berdasarkan Nomor Surat Perintah Audit dipilih.</div>
                <div class="alert-close">
                    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                        <span aria-hidden="true"><i class="ki ki-close"></i></span>
                    </button>
                </div>
              </div>      
            </div>
            <?php } ?>  
          <h6 class="text-left my-10 mt-20">Jadwal Audit</h6>
          <div class="form-group row">
            <label class="col-form-label col-3 text-left">Perencanaan Audit</label>
            <div class="col-8">
              <div class="form-label">
                <div class="input-icon input-icon-right mb-2">
                  <input autocomplete="off" placeholder="Tanggal Perencanaan Audit" type="text" <?= $disabled ?> value="<?= $data_apm->JADWAL_PERENCANAAN ?>" name="JADWAL_PERENCANAAN" id="JADWAL_PERENCANAAN" required class="form-control datepicker w-100">
                  <span>
                    <i class="fa fa-calendar"></i>
                  </span>
                </div>
              </div>
            </div>
          </div>
          <div class="form-group row">
            <label class="col-form-label col-3 text-left">Entrance Meeting</label>
            <div class="col-8">
              <div class="form-label">
                <div class="input-icon input-icon-right mb-2">
                  <input autocomplete="off" placeholder="Tanggal Entrance Meeting" type="text" <?= $disabled ?> value="<?= $data_apm->JADWAL_ENTRANCE_MEETING ?>" name="JADWAL_ENTRANCE_MEETING" id="JADWAL_ENTRANCE_MEETING" required class="form-control datepicker w-100">
                  <span>
                    <i class="fa fa-calendar"></i>
                  </span>
                </div>
              </div>
            </div>
          </div>
          <div class="form-group row">
            <label class="col-form-label col-3 text-left">Pelaksanaan Penugasan Audit</label>
            <div class="col-lg-4 col-md-11">
              <div class="form-label">
                <div class="input-icon input-icon-right mb-2">
                  <input autocomplete="off" placeholder="Periode Awal" type="text" <?= $disabled ?> value="<?= $data_apm->JADWAL_PELAKSANAAN ?>" name="JADWAL_PELAKSANAAN" id="JADWAL_PELAKSANAAN" required class="form-control datepicker w-100">
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
                  <input autocomplete="off" placeholder="Periode Selesai" type="text" <?= $disabled ?> value="<?= $data_apm->JADWAL_PELAKSANAAN_SELESAI ?>" name="JADWAL_PELAKSANAAN_SELESAI" id="JADWAL_PELAKSANAAN_SELESAI" required class="form-control datepicker w-100">
                  <span>
                    <i class="fa fa-calendar"></i>
                  </span>
                </div>
              </div>
            </div>
          </div>
          <div class="form-group row">
            <label class="col-form-label col-3 text-left">Exit Meeting</label>
            <div class="col-8">
              <div class="form-label">
                <div class="input-icon input-icon-right mb-2">
                  <input autocomplete="off" placeholder="Tanggal Exit Meeting" type="text" <?= $disabled ?> value="<?= $data_apm->JADWAL_EXIT_MEETING ?>" name="JADWAL_EXIT_MEETING" id="JADWAL_EXIT_MEETING" required class="form-control datepicker w-100">
                  <span>
                    <i class="fa fa-calendar"></i>
                  </span>
                </div>
              </div>
            </div>
          </div>
          <div class="form-group row">
            <label class="col-form-label col-3 text-left">Draf Laporan Hasil Pemeriksaan</label>
            <div class="col-8">
              <div class="form-label">
                <div class="input-icon input-icon-right mb-2">
                  <input autocomplete="off" placeholder="Tanggal Draf LHP" type="text" <?= $disabled ?> value="<?= $data_apm->JADWAL_DRAFT_LAPORAN ?>" name="JADWAL_DRAFT_LAPORAN" id="JADWAL_DRAFT_LAPORAN" required class="form-control datepicker w-100">
                  <span>
                    <i class="fa fa-calendar"></i>
                  </span>
                </div>
              </div>
            </div>
          </div>
          <div class="form-group row">
            <label class="col-form-label col-3 text-left">Laporan Hasil Pemeriksaan</label>
            <div class="col-8">
              <div class="form-label">
                <div class="input-icon input-icon-right mb-2">
                  <input autocomplete="off" placeholder="Tanggal LHP" type="text" <?= $disabled ?> value="<?= $data_apm->JADWAL_LAPORAN_HASIL ?>" name="JADWAL_LAPORAN_HASIL" id="JADWAL_LAPORAN_HASIL" required class="form-control datepicker w-100">
                  <span>
                    <i class="fa fa-calendar"></i>
                  </span>
                </div>
              </div>
            </div>
          </div>
          <div class="form-group row">
            <label class="col-form-label col-3 text-left">Dokumen yang Dibutuhkan dari Auditee</label>
            <div class="col-8">
              <textarea name="DAFTAR_DOKUMEN" id="DAFTAR_DOKUMEN"></textarea>
            </div>
          </div>
					<?php if(isset($_GET['review'])){ ?>
						<div class="form-group row">
							<label class="col-form-label col-3 text-left">Komentar</label>
							<div class="col-8">
								<textarea name="KOMENTAR" id="KOMENTAR"></textarea>
							</div>
						</div>
						<div class="form-group row">
							<label class="col-form-label col-3 text-left">Tanggal Approve</label>
							<div class="col-4">
                <div class="form-label">
                  <div class="input-icon input-icon-right mb-2">
                    <input autocomplete="off" placeholder="Tanggal Approve" type="text" <?= $disabled ?> value="<?= date('Y-m-d') ?>"  name="TANGGAL" class="form-control datepicker w-100">
                    <span>
                      <i class="fa fa-calendar"></i>
                    </span>
                  </div>
                </div>
							</div>
						</div>
            <div class="separator separator-dashed mb-5"></div>
            <?php if ($data_apm->ID_STATUS != 4) {?>
						<div class="form-group row">
							<div class="col-8 offset-3">
								<label class="col-form-label text-left"><h6><b>Log History</b></h6></label>
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
          <?php }?>
					<?php } ?>
					<?php if ($data_apm->ID_STATUS == 4) {?>
						<div class="form-group row">
							<div class="col-8 offset-3">
								<label class="col-form-label text-left"><h6><b>Log History</b></h6></label>
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
            <label class="col-form-label col-3 text-left"></label>
            <div class="col-8">
							<?php if(isset($_GET['review'])){ ?>
                <?php if($data_apm->ID_APM != ''){ ?>
								<a target="_blank" href='<?= base_url() ?>perencanaan/apm/cetak_preview/<?= $data_apm->ID_APM ?>' class="btn btn-light-primary font-weight-bold">Preview</a>
                <?php } ?>
								<?php if ($_GET['sts-approver'] == 1) {?>
									<a onclick="submitButton(3)" class="btn btn-light-success font-weight-bold">Approve</a>
									<a onclick="submitButton(4)" class="btn btn-light-warning font-weight-bold">Reject</a>
								<?php } ?>
								<a onclick="back('<?= $data_apm->ID_APM ?>')" class="btn btn-light-danger font-weight-bold">Kembali</a>
							<?php }else { ?>
                <?php if($data_apm->ID_APM != ''){ ?>
								<a target="_blank" href='<?= base_url() ?>perencanaan/apm/cetak_preview/<?= $data_apm->ID_APM ?>' class="btn btn-light-primary font-weight-bold">Preview</a>
                <?php } ?>
								<?php if ($data_apm->ID_STATUS != 2 && $data_apm->ID_STATUS != 3) {?>
									<a onclick="save('<?= $data_apm->ID_APM ?>', 1)" class="btn btn-light-success font-weight-bold">Simpan</a>
									<a onclick="save('<?= $data_apm->ID_APM ?>', 2)" class="btn btn-light-warning font-weight-bold">Kirim</a>
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


  set_tinymce('TUJUAN', '<?= trim(preg_replace('/\s\s+/', ' ',$data_apm->TUJUAN)) ?>');
  set_tinymce('RUANG_LINGKUP', '<?= trim(preg_replace('/\s\s+/', ' ',$data_apm->RUANG_LINGKUP)) ?>');
  set_tinymce('PERIODE_AUDIT', '<?= trim(preg_replace('/\s\s+/', ' ',$data_apm->PERIODE_AUDIT)) ?>');
  set_tinymce('DESKRIPSI_TEXT', '<?= trim(preg_replace('/\s\s+/', ' ',$data_apm->DESKRIPSI_TEXT)) ?>');
  set_tinymce('PROSES_BISNIS_TEXT', '<?= trim(preg_replace('/\s\s+/', ' ',$data_apm->PROSES_BISNIS_TEXT)) ?>');
  set_tinymce('RESIKO', '<?= trim(preg_replace('/\s\s+/', ' ',$data_apm->RESIKO)) ?>');
  set_tinymce('CATATAN', '<?= trim(preg_replace('/\s\s+/', ' ',$data_apm->CATATAN)) ?>');
  set_tinymce('REVIEW_ANALISIS', '<?= trim(preg_replace('/\s\s+/', ' ',$data_apm->REVIEW_ANALISIS)) ?>');
  set_tinymce('BERITA_ATURAN', '<?= trim(preg_replace('/\s\s+/', ' ',$data_apm->BERITA_ATURAN)) ?>');
  set_tinymce('DAFTAR_RESIKO_POTENSIAL', '<?= trim(preg_replace('/\s\s+/', ' ',$data_apm->DAFTAR_RESIKO_POTENSIAL)) ?>');
  set_tinymce('DAFTAR_DOKUMEN', '<?= trim(preg_replace('/\s\s+/', ' ',$data_apm->DAFTAR_DOKUMEN)) ?>');
  set_tinymce('KOMENTAR', '');

  $('#id_spa').on('change', function (e) {
      // $(this).valid();

      //get tim audit
      var id_spa = $('#id_spa').val();
      $.ajax({
       url: "<?= base_url() ?>perencanaan/spa/getTimAudit",
       data: '&id_spa='+ id_spa,
       type: 'GET',
       beforeSend: function() {
        $('#loadingDiv').css('display', 'block');
       },
       success:function(data){
          var hasil = JSON.parse(data);  
          var tim_audit = [];    
          $.each(hasil, function(key,val){    
          var tim = ['','Ketua Tim', 'Pengawas', 'Anggota Tim']; 
            tim_audit.push(`<div class="form-group row">
                              <label class="col-form-label col-3 text-left">`+tim[val.JABATAN]+`</label>
                              <div class="col-8">
                                <input class="form-control" disabled type="text" value="`+val.NAMA+`">
                              </div>
                            </div>`);
          });
          $('#tim_audit').html(tim_audit);
          $('#loadingDiv').css('display', 'none');
       }
      }); 
    });
});

  function save(id, action)
  {
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
        var obj = {ACTION: action};
        if (id) {
          obj.ID_APM = id;
        }
        var form_data = $("#form_apm").serialize() + '&' + $.param(obj);
        $.ajax({
          url: '<?= base_url() ?>/perencanaan/apm/simpan/',
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

  function submitButton(action)
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
        console.log("WOY");

        var obj = {ACTION: action};
        var form_data = $("#form_apm").serialize() + '&' + $.param(obj);
        $.ajax({
            url: '<?= base_url() ?>/perencanaan/apm/approve_reject/<?= $data_apm->ID_APM ?>',
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
			window.location = '<?= base_url() ?>perencanaan/apm/kotak_masuk'
		}else {
			window.location = '<?= base_url() ?>perencanaan/apm/kotak_keluar'
		}
	}
</script>

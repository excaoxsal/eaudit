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
          <div class="form-group row">
            <label class="col-form-label col-3 text-left">Auditor</label>
            <div class="col-8">
            
              <select class="form-control select-dua" id="id_auditor" name="ID_AUDITOR">
                <option value="<?= $data_jadwal['0']['ID_AUDITOR']?>"><?= $data_jadwal['0']['NAMA_AUDITOR']?></option>
                <option value="">--Pilih Auditor--</option>
                <?php 
                foreach ($data_auditor as $auditor) { ?>
                  <option value="<?= $auditor['ID_USER'] ?>"><?= $auditor['NAMA'] ?></option>
                <?php } ?>
              </select>
              
            </div>
          </div>
          <div class="form-group row">
            <label class="col-form-label col-3 text-left">Lead Auditor</label>
            <div class="col-8">
            
              <select class="form-control select-dua" id="id_lead_auditor" name="ID_LEAD_AUDITOR">
              <option value="<?= $data_jadwal['0']['ID_AUDITOR']?>"><?= $data_jadwal['0']['NAMA_AUDITOR']?></option>
                <option value="">--Pilih Auditor--</option>
                <?php 
                foreach ($data_auditor as $auditor) { ?>
                  <option value="<?= $auditor['ID_USER'] ?>"><?= $auditor['NAMA'] ?></option>
                <?php } ?>
              </select>
              
                
              <input type="hidden" value="<?= $data_jadwal['0']['ID_JADWAL']?>" name="ID_JADWAL"></input>
            </div>
          </div>
          
          <div class="form-group row">
            <label class="col-form-label col-3 text-left">Waktu Audit</label>
            <div class="col-lg-4 col-md-11">
              <div class="form-label">
                <div class="input-icon input-icon-right mb-2">
                  <input autocomplete="off" placeholder="Periode Awal" type="text" <?= $disabled ?> value="<?= $data_jadwal['0']['WAKTU_AUDIT_AWAL']?>" name="WAKTU_AUDIT_AWAL" id="WAKTU_AUDIT_AWAL" required class="form-control datepicker w-100">
                  <span>
                    <i class="fa fa-calendar"></i>
                  </span>
                </div>
              </div>
            </div>
            <div class="col-lg-4 col-md-11">
              <div class="form-label">
                <div class="input-icon input-icon-right mb-2">
                  <input autocomplete="off" placeholder="Periode Selesai" type="text" <?= $disabled ?> type="date" value="<?= $data_jadwal['0']['WAKTU_AUDIT_SELESAI'] ?>" name="WAKTU_AUDIT_SELESAI" required class="form-control datepicker w-100">
                  <span>
                    <i class="fa fa-calendar"></i>
                  </span>
                </div>
              </div>
            </div>
            
              <!-- <p class="my-auto">s/d</p> -->
            
          </div>
          <div class="form-group row">
            <label class="col-form-label col-3 text-left">Cabang/Divisi</label>
            <div class="col-8">
            <?php if(empty($data_apm)){ ?>
              <select class="form-control select-dua" id="id_divisi" name="ID_DIVISI">
              <option value="<?= $data_jadwal['0']['ID_DIVISI']?>"><?= $data_jadwal['0']['NAMA_DIVISI']?></option>
                <option value="">--Pilih Cabang/Divisi--</option>
                <?php 
                foreach ($list_divisi as $divisi) { ?>
                  <option value="<?= $divisi['ID_DIVISI'] ?>"><?= $divisi['NAMA_DIVISI'] ?></option>
                <?php } ?>
              </select>
              <?php }else{ ?>
                <input type="text" disabled value="<?= $list_divisi ?>" class="form-control">
              <?php } ?>
            </div>
          </div>
          
					
          
          
          
					
          
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
								<a target="_blank" href='<?= base_url() ?>perencanaan/apm/cetak_preview/<?= $data_jadwal['0']['ID_JADWAL'] ?>' class="btn btn-light-primary font-weight-bold">Preview</a>
                <?php } ?>
								<?php if ($_GET['sts-approver'] == 1) {?>
									<a onclick="submitButton(3)" class="btn btn-light-success font-weight-bold">Approve</a>
									<a onclick="submitButton(4)" class="btn btn-light-warning font-weight-bold">Reject</a>
								<?php } ?>
								<a onclick="back('<?= $data_jadwal['0']['ID_JADWAL'] ?>')" class="btn btn-light-danger font-weight-bold">Kembali</a>
							<?php }else { ?>
                <?php if($data_apm->ID_APM != ''){ ?>
								<a target="_blank" href='<?= base_url() ?>perencanaan/apm/cetak_preview/<?= $data_jadwal['0']['ID_JADWAL'] ?>' class="btn btn-light-primary font-weight-bold">Preview</a>
                <?php } ?>
								<?php if ($data_apm->ID_STATUS != 2 && $data_apm->ID_STATUS != 3) {?>
									<a onclick="save('<?= $data_jadwal['0']['ID_JADWAL']?>', 1)" class="btn btn-light-success font-weight-bold">Simpan</a>
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
    text: 'Apakah Anda yakin menyimpan data ini ?',
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
          url: '<?= base_url() ?>aia/jadwal/simpan/',
          type: 'post',
          data: form_data,
          headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
          },
          success: function(data) {
            // console.log(data);
            // alert(form_data);
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
                alert(data);
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

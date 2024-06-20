<div class="content d-flex flex-column flex-column-fluid" id="kt_content">
  <div class="subheader py-2 py-lg-4 subheader-solid" id="kt_subheader">
    <div class="container-fluid d-flex align-items-center justify-content-between flex-wrap flex-sm-nowrap">
      <div class="d-flex align-items-center flex-wrap mr-2">
        <h5 class="text-dark font-weight-bold mt-2 mb-2 mr-5"><?= APK_NAME ?></h5>
        <div class="subheader-separator subheader-separator-ver mt-2 mb-2 mr-4 bg-gray-200"></div>
        <span class="text-muted font-weight-bold mr-4">List Jadwal Audit ISO</span>
        <div class="subheader-separator subheader-separator-ver mt-2 mb-2 mr-4 bg-gray-200"></div>
        <span class="text-muted font-weight-bold mr-4"><?=$sub_menu?></span>
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
              <option value="<?= $data_jadwal['0']['ID_AUDITOR']?>"><?= $data_jadwal['0']['NAMA_LEAD_AUDITOR']?></option>
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
        </div>







					

          <div class="form-group row">
            <label class="col-form-label col-3 text-left"></label>
            <div class="col-8">
							
								
								
								<!-- <a onclick="back('<?= $data_jadwal['0']['ID_JADWAL'] ?>')" class="btn btn-light-danger font-weight-bold">Kembali</a> -->
                
								
									<a onclick="save('<?= $data_jadwal['0']['ID_JADWAL']?>', 1)" class="btn btn-light-success font-weight-bold">Simpan</a>

								
								<a onclick="back()" class="btn btn-light-danger font-weight-bold">Kembali</a>
							

            </div>
          </div>
        </form>
      </div>
    </div>
  </div>
</div>
<script type="text/javascript">


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
            // console.log(data);
            Swal.fire("Gagal menyimpan data!", "Pastika semua kolom terisi!", "error");
          }
        });
      }
    })
  }

  
	function back(id) { 
		
			window.location = '<?= base_url() ?>aia/jadwal/jadwal_audit'
		
	}
</script>

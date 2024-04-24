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
        <span class="text-muted font-weight-bold mr-4">Create</span>
      </div>
    </div>
  </div>
  <div class="d-flex flex-column-fluid">
    <div class="container">
        <form class="form" id="form_spa" method="post" enctype="multipart/form-data">  
        <div class="card card-custom">
          <div class="card-header">
            <div class="card-title">
              <h3 class="card-label">Surat Perintah Audit</h3>
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
            <label class="col-form-label col-3 text-right">Nomor Surat</label>
            <div class="col-9">
              <input type="text" <?= $disabled ?> class="form-control" id="nomor_surat" placeholder="Nomor Surat" name="NOMOR_SURAT" value="<?= $spa_detail->NOMOR_SURAT ?>">
            </div>
          </div>
					<div class="form-group row">
						<label class="col-form-label col-3 text-right">Dasar</label>
						<div class="col-9">
							<div id="editor-a" style="height: 200px;overflow: auto; <?= $enable_css ?>"></div>
              <input type="hidden"  name="DASAR_AUDIT" id="DASAR_AUDIT">
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
						<label class="col-form-label col-3 text-right">Isi Perintah</label>
						<div class="col-9">
							<div id="editor-b" style="height: 200px;overflow: auto; <?= $enable_css ?>"></div>
              <input type="hidden"  name="ISI_PERINTAH" id="ISI_PERINTAH">
						</div>
					</div>
          <div class="form-group row">
            <label class="col-form-label col-3 text-right">Perintah Selesai.</label>
            <div class="col-9">
            </div>
          </div>
					<div class="form-group row">
            <label class="col-form-label col-3 text-right">Dikeluarkan di</label>
            <div class="col-9">
              <input type="text" <?= $disabled ?> class="form-control" id="dikeluarkan" placeholder="Ex : Jakarta" name="DIKELUARKAN" value="<?= $spa_detail->DIKELUARKAN ?>">
            </div>
          </div>
					<div class="form-group row">
            <label class="col-form-label col-3 text-right">Pada Tanggal</label>
            <div class="col-4">
							<input class="form-control" <?= $disabled ?> type="date" name="PADA_TANGGAL" value="<?= $spa_detail->PADA_TANGGAL ?>">
            </div>
					</div>
          <div class="separator separator-dashed mb-5"></div>
					<?php if($spa_detail->ID_STATUS == 4) { ?>
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
              <?php if($spa_detail->ID_SPA != ''){ ?>
							<a target="_blank" href="<?= base_url() ?>perencanaan/kotak_keluar/spa/cetak_preview/<?= $spa_detail->ID_SPA ?>" class="btn btn-primary font-weight-bold">Preview</a>
              <?php } ?>
							<?php if ($spa_detail->ID_STATUS != 2 && $spa_detail->ID_STATUS != 3) {?>
								<a onclick="save(<?= $spa_detail->ID_SPA ?>)" class="btn btn-success font-weight-bold">Simpan</a>
								<a onclick="kirim(<?= $spa_detail->ID_SPA ?>)" class="btn btn-warning font-weight-bold">Kirim</a>
							<?php } ?>
							<a onclick="back()" class="btn btn-danger font-weight-bold">Back</a>
            </div>
          </div>
        </div>
        </form>
      </div>
    </div>
  </div>
</div>
<script src="https://cdn.quilljs.com/1.0.0/quill.js"></script>

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
    $('#add_tim_audit').click(function(){
      i++;
      $('#list_tim_audit').append('<div class="form-group row" id="row'+i+'"><label class="col-form-label col-3 text-right"></label><div class="col-4"><select class="form-control" id="tim_audit" name="TIM_AUDIT[]"><option value="">--Pilih User--</option><?php foreach($list_user as $user){ ?><option value="<?= $user['ID_USER'] ?>"><?= $user['NAMA'] ?></option><?php } ?></select></div><div class="col-4"><select class="form-control" id="jabatan_tim" name="JABATAN_TIM[]"><option value="">--Pilih Jabatan--</option><option value="1">Ketua Tim</option><option value="2">Pengawas</option><option value="3">Anggota Tim</option></select></div><div class="col-1"><span style="cursor: pointer;" name="remove" id="'+i+'" class="btn-remove label font-weight-bold label-lg label-danger label-inline mt-2">-</span><br></div></div>');
    });
    $(document).on('click', '.btn-remove', function(){
      var button_id   = $(this).attr("id");
      $("#row"+button_id+"").remove();
    }); 
  });
  
	function getValueQuill(id, hiddenId,currentValue,enable=true,placeholder = '') {
		var quill = new Quill(id, {
		modules: {
			toolbar: [
				['bold', 'italic', 'underline'],
				['link'],
				[{
					list: 'ordered'
				}, {
					list: 'bullet'
				}]
			]
		},
		placeholder,
		theme: 'snow'
		});
		quill.enable(enable);
		if (currentValue) {
			var myEditor = document.querySelector(id);
			var html = myEditor.children[0].innerHTML = currentValue;
		}
		quill.on('text-change', function(delta, oldDelta, source) {
			var myEditor = document.querySelector(id);
			var html = myEditor.children[0].innerHTML;
			document.getElementById(hiddenId).value = html;
		});
	}
	getValueQuill('#editor-a','DASAR_AUDIT', '<?= $spa_detail->DASAR_AUDIT ?>', '<?= $enable ?>');
	getValueQuill('#editor-b','ISI_PERINTAH', '<?= $spa_detail->ISI_PERINTAH ?>', '<?= $enable ?>');

  function kirim(id)
  {
    Swal.fire({
      text: 'Apakah Anda yakin akan mengirim surat ini ?',
      icon: 'warning',
      showCancelButton: true,
      confirmButtonColor: '#3085d6',
      cancelButtonColor: '#d33',
      confirmButtonText: 'Ya',
      cancelButtonText: 'Batal'
    }).then((result) => {
      if (result.value) {
        // $("#form_spa").submit(function(e){
				//   e.preventDefault();
				var obj = {
					"ID_SPA": id,
					"ACTION": 3,
				};
				var form_data = $("#form_spa").serialize() + '&' + $.param(obj);
				$.ajax({
						url: '<?= base_url() ?>/perencanaan/kotak_keluar/spa/simpan/',
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
								alert("Server Error");
						}
				});
        // });
      }
    })
  }
	function save(id)
  {
    Swal.fire({
      text: 'Apakah Anda yakin akan menyimpan surat ini ?',
      icon: 'warning',
      showCancelButton: true,
      confirmButtonColor: '#3085d6',
      cancelButtonColor: '#d33',
      confirmButtonText: 'Ya',
      cancelButtonText: 'Batal'
    }).then((result) => {
      if (result.value) {
				var obj = {
					"ID_SPA": id,
					"ACTION": 2,
				};
				var form_data = $("#form_spa").serialize() + '&' + $.param(obj);
          $.ajax({
              url: '<?= base_url() ?>/perencanaan/kotak_keluar/spa/simpan',
              type: 'post',
							data: form_data,
              headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
              },
              success: function(data) {
									// console.log("DATA RETURN", data);
									window.location = data;
                  // alert(data);
              },
              error: function(data){
                  alert("Server Error");
              }
          });
        // });
      }
    })
  }
  function preview()
  {
    Swal.fire({
      text: 'Data akan tersimpan sebagai draft, lanjutkan preview?',
      icon: 'warning',
      showCancelButton: true,
      confirmButtonColor: '#3085d6',
      cancelButtonColor: '#d33',
      confirmButtonText: 'Ya',
      cancelButtonText: 'Batal'
    }).then((result) => {
      if (result.value) {
        if($('#nomor_surat').val() == '')
          Swal.fire("Gagal menyimpan data!", "Nomor Surat tidak boleh kosong!", "error");
        else if($('#kepada').val() == '')
          Swal.fire("Gagal menyimpan data!", "Kepada tidak boleh kosong!", "error");
        else if($('#perihal').val() == '')
          Swal.fire("Gagal menyimpan data!", "Perihal tidak boleh kosong!", "error");
        else{
          $.ajax({
              url: '<?= base_url() ?>/perencanaan/kotak_keluar/spa/preview',
              type: 'post',
              data: $("#form_spa").serialize(),
              headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
              },
              success: function(data) {
                if(data == "error"){
                  Swal.fire("Gagal menyimpan data!", "Pastikan kebutuhan data terpenuhi!", "error");
                }else{
                  console.log(data);
                  window.open("<?php echo base_url() ?>"+'perencanaan/kotak_keluar/apm/cetak_preview', '_blank');
                  // window.location.href="<?php echo base_url() ?>"+'perencanaan/kotak_keluar/spa/';
                }
                // alert(data);
              },
              error: function(data){
                Swal.fire("Error!", "Internal Server Error", "error");
              }
          });
        }
      }
    })
	}
	function back() { 
		window.location = '<?= base_url() ?>/perencanaan/kotak_keluar/spa/'
	}
</script>


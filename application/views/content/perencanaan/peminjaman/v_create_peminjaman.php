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
        <span class="text-muted font-weight-bold mr-4">Peminjaman</span>
        <div class="subheader-separator subheader-separator-ver mt-2 mb-2 mr-4 bg-gray-200"></div>
        <span class="text-muted font-weight-bold mr-4">Create</span>
      </div>
    </div>
  </div>
  <div class="d-flex flex-column-fluid">
    <div class="container">
		
        <form class="form" id="form_cs" method="post" enctype="multipart/form-data">  
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

					<!-- <h6>Header</h6>
					<hr> -->
					<div class="form-group row">
			            <label class="col-form-label col-3 text-right">Dikeluarkan di</label>
			            <div class="col-8">
			              <input type="text" class="form-control" id="dikeluarkan" placeholder="Ex : Jakarta" name="DIKELUARKAN" value="<?= $data_peminjaman->DIKELUARKAN ?>">
			            </div>
			        </div>
					<div class="form-group row">
			            <label class="col-form-label col-3 text-right">Pada Tanggal</label>
			            <div class="col-8">
						
						<div class="form-label">
			                <div class="input-icon input-icon-right mb-2">
			                  <input autocomplete="off" placeholder="Pada Tanggal" type="text" name="TANGGAL" value="<?= $data_peminjaman->TANGGAL ?>" class="form-control datepicker w-100">
			                  <span>
			                    <i class="fa fa-calendar"></i>
			                  </span>
			                </div>
			            </div>
			            </div>
			        </div>
					<div class="form-group row">
						<label class="col-form-label col-3 text-right">Kepada</label>
						<div class="col-8">
						<select class="form-control" id="id_divisi" name="KEPADA">
							<option value="">--Pilih Divisi--</option>
							<?php foreach($list_divisi as $divisi){ 
							if ($divisi['ID_DIVISI'] == $data_peminjaman->KEPADA) {
							?>
								<option selected value="<?= $divisi['ID_DIVISI'] ?>"><?= $divisi['NAMA_DIVISI'] ?></option>
							<?php } ?>
								<option value="<?= $divisi['ID_DIVISI'] ?>"><?= $divisi['NAMA_DIVISI'] ?></option>
							<?php } ?>
						</select>
						</div>
					</div>
					<div class="form-group row">
			            <label class="col-form-label col-3 text-right">Alamat Lengkap</label>
			            <div class="col-8">
			              <textarea class="form-control w-100" placeholder="Alamat Lengkap" name="HEADER_TEXT" id="HEADER_TEXT"><?= $data_peminjaman->HEADER_TEXT ?></textarea>
			            </div>
			        </div>
					<div id="list_lampiran">
						<div class="form-group row">
							<label class="col-form-label col-3 text-right">Nama Dokumen</label>
							
								<div class="col-8">
									<input type="text" class="form-control" placeholder="Nama Dokumen" name="LAMPIRAN[]" id="LAMPIRAN" value="<?= $lampiran[0]['LAMPIRAN']  ?>">
								</div>
								<div class="col-1">
									<span style="cursor: pointer;" name="add_lampiran" id="add_lampiran" class="label font-weight-bold label-lg label-success label-inline mt-2">+</span><br>
								</div>
						</div>
					</div>

					<div class="form-group row">
						<label class="col-form-label col-3 text-right">Ketua Tim</label>
						<div class="col-8">
						<select class="form-control" id="ketua_tim" name="KETUA_TIM">
							<option value="">--Pilih Ketua Tim--</option>
							<?php foreach($list_user as $user){ 
							if ($user['ID_USER'] == $data_peminjaman->KETUA_TIM) {
							?>
								<option selected value="<?= $user['ID_USER'] ?>"><?= $user['NAMA'] ?></option>
							<?php } ?>
								<option value="<?= $user['ID_USER'] ?>"><?= $user['NAMA'] ?></option>
							<?php } ?>
						</select>
						</div>
					</div>
					<div class="separator separator-dashed mb-5"></div>
					<div class="form-group row">
						<label class="col-form-label col-3 text-right"></label>
						<div class="col-8">
						<a onclick="generate()" class="btn btn-light-primary font-weight-bold">Generate</a>
              			<a href="<?= base_url() ?>/perencanaan/peminjaman" class="btn btn-light-danger font-weight-bold">Kembali</a>
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
		 $('#id_divisi, #ketua_tim').select2().on('change', function (e) {} );
    var i = 1;
    $('#add_lampiran').click(function(){
      i++;
      $('#list_lampiran').append('<div class="form-group row" id="row'+i+'"><label class="col-form-label col-3 text-right"></label><div class="col-8"><input type="text" class="form-control" placeholder="Nama Dokumen" name="LAMPIRAN[]" multiple="multiple" value=""></div><div class="col-1"><span style="cursor: pointer;" name="remove" id="'+i+'" class="btn-remove label font-weight-bold label-lg label-danger label-inline mt-2">-</span><br></div></div>');
    });
    $(document).on('click', '.btn-remove', function(){
      var button_id   = $(this).attr("id");
      $("#row"+button_id+"").remove();
    }); 
  });
	function getValueQuill(id, hiddenId,currentValue,placeholder = '') {
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
	// getValueQuill('#editor-a','HEADER_TEXT', '<?= $data_cs->HEADER_TEXT ?>', 'Alamat lengkap...');


	function generate()
	{
		Swal.fire({
		text: 'Apakah Anda yakin generate data ini ?',
		icon: 'question',
		showCancelButton: true,
		confirmButtonColor: '#3085d6',
		cancelButtonColor: '#d33',
		confirmButtonText: 'Ya',
		cancelButtonText: 'Batal'
		}).then((result) => {
		if (result.value) {
			$.ajax({
				url: '<?= base_url() ?>/perencanaan/peminjaman/generate/<?= $data_peminjaman->ID_PEMINJAMAN ?>',
				type: 'post',
				data: $("#form_cs").serialize(),
				headers: {
					'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
				},
				success: function(data) {
					if(data == "error"){
						Swal.fire("Gagal menyimpan data!", "Pastikan kebutuhan data terpenuhi!", "error");
					}else{
						window.open("<?php echo base_url() ?>"+'perencanaan/peminjaman/cetak_preview/'+data, '_blank');
					}
				},
				error: function(data){
					Swal.fire("Gagal menyimpan data!", "Pastikan kebutuhan data terpenuhi!", "error");
				}
			});
			// });
		}
		})
	}
</script>


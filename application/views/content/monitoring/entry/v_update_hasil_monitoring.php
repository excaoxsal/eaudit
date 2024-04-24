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
		
        <form class="form" action="<?= base_url() ?>monitoring/entry/update_hasil_monitoring/<?= $detail_rekomendasi->ID ?>" method="post" enctype="multipart/form-data">  
			<div class="card card-custom">
				<div class="card-header">
					<div class="card-title">
					<h3 class="card-label">Update Hasil Monitoring</h3>
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
					<!-- <div class="form-group row">
						<label class="col-form-label col-3 text-right">Nama Audit</label>
						<div class="col-9">
							<input type="text" class="form-control" placeholder="Nama Audit" name="NAMA_AUDIT" value="<?= $data_cs->NAMA_AUDIT ?>">
						</div>
					</div> -->
					<div class="form-group row">
						<label class="col-form-label col-2 text-right">Hasil Monitoring</label>
						<div class="col-10">
						  <div id="editor-a" style="height: 200px;overflow: auto; <?= $enable_css ?>"></div>
                          <input type="hidden"  name="HASIL_MONITORING" id="HASIL_MONITORING">
						</div>
					</div>
					<div class="form-group row">
						<label class="col-form-label col-2 text-right">Tingkat Penyelesaian</label>
						<div class="col-10">
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
					<!-- <div class="form-group row">
						<label class="col-form-label col-3 text-right">Lampiran</label>
						<div class="col-9">
							<input type="file" class="form-control" name="LAMPIRAN" value="<?= $data_cs->NAMA_AUDIT ?>">
						</div>
					</div> -->
					<div id="list_lampiran">
		              <div class="form-group row">
		                <label class="col-form-label col-2 text-right">Lampiran</label>
		                <div class="col-9">
		                  <input type="file" class="form-control" placeholder="Lampiran" multiple="" name="lampiran[]" value="">
		                </div>
		                <div class="col-1">
		                  <span style="cursor: pointer;" name="add_lampiran" id="add_lampiran" class="label font-weight-bold label-lg label-success label-inline mb-2 mt-2">+</span><br>
		                </div>
		              </div>
		              </div>
					<div class="separator separator-dashed mb-5"></div>
					<div class="form-group row">
						<label class="col-form-label col-2 text-right"></label>
						<div class="col-10">
						<input type="submit" class="btn btn-success font-weight-bold" value="Update">
						<a onclick="window.history.go(-1)" class="btn btn-warning font-weight-bold">Cancel</a>
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
	getValueQuill('#editor-a','HASIL_MONITORING', '<?= $data_cs->HASIL_MONITORING ?>');
	// getValueQuill('#editor-b','PIC_DIDISTRIBUSI', '<?= $data_cs->PIC_DIDISTRIBUSI ?>');
	// getValueQuill('#editor-c','PIC_APM_DISUSUN', '<?= $data_cs->PIC_APM_DISUSUN ?>');
	// getValueQuill('#editor-d','PIC_RCM_DISUSUN', '<?= $data_cs->PIC_RCM_DISUSUN ?>');
	// getValueQuill('#editor-e','PIC_ENTRANCE_DISUSUN', '<?= $data_cs->PIC_ENTRANCE_DISUSUN ?>');


	function update()
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
			$.ajax({
				url: '<?= base_url() ?>/perencanaan/control_sheet/update/<?= $data_cs->ID_SPA ?>',
				type: 'post',
				data: $("#form_cs").serialize(),
				headers: {
					'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
				},
				success: function(data) {
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
	$(document).ready(function(){
	    var i = 1;
	    $('#add_lampiran').click(function(){
	      i++;
	      $('#list_lampiran').append('<div class="form-group row" id="row'+i+'"><div class="col-2"></div><div class="col-9"><input type="file" class="form-control" placeholder="Lampiran" name="lampiran[]" value=""></div><div class="col-1"><span style="cursor: pointer;" name="remove" id="'+i+'" class="btn-remove label font-weight-bold label-lg label-danger label-inline mt-2">-</span><br></div></div>');
	    });
	    $(document).on('click', '.btn-remove', function(){
	      var button_id   = $(this).attr("id");
	      $("#row"+button_id+"").remove();
	    }); 
	  });
</script>

